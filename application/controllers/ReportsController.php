<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class ReportsController extends BaseController
{
    protected $formApplicationRepository, $branchRepository, $employeeRepository, $departmentRepository, $reportRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->branchRepository     = new BranchRepository();
        $this->departmentRepository = new DepartmentRepository();
        $this->jobPositionRepository = new JobPositionRepository();
        $this->employeeRepository   = new EmployeeRepository();
        $this->formApplicationRepository   = new FormApplicationRepository();

        $this->reportRepository = new ReportRepository();

    }

    public function generate()
    {
        // $year = ($this->input->get('year') == null) ? date('Y') : $this->input->get('year');
        $data['form_types'] = [
            ['name' => 'OB Form', 'string_key' => 'ob'],
            ['name' => 'OT Form', 'string_key' => 'ot'],
            ['name' => 'Undertime Form', 'string_key' => 'undertime'],
            ['name' => 'Leave Form', 'string_key' => 'leave']

        ];
        $data['company']  = $this->company;
        $data['title']    = "Generate Report";
        $data['branches'] = $this->branchRepository->all();
        $data['user']     = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['departments'] = $this->departmentRepository->all();

        $this->render('reports/generate.twig.html', $data);

    }

    public function generateEmployeeList()
    {
        $output           = [];
        $output_column    = [];
        $index            = 0;
        $selected_columns = $this->input->post('columns');
        $columns          = array_keys($selected_columns);
        $branch_id        = $this->input->post('branch');
        $employees        = $this->employeeRepository->where('branch_id', $branch_id)->get();
        $branch           = Branch::where('id', '=', $branch_id)->first();
        $branch_name      = $branch->branch_name;    
        
        foreach ($employees as $employee) 
        {
            $output[$index]['first_name']  = $employee->first_name;
            $output[$index]['middle_name'] = $employee->middle_name;
            $output[$index]['last_name']   = $employee->last_name;
            foreach ($columns as $column) 
            {
                $method = 'get' . _snakeToCamel($column);
                $value  = call_user_func(array($employee, $method));

                $output[$index][$column] = $value;
            }

            $index++;
        }
        array_push($output_column, "First Name");
        array_push($output_column, "Middle Name");
        array_push($output_column, "Last Name");

        foreach ($columns as $column) 
        {
            array_push($output_column, _snakeToTitle($column));
        }
        $xls_file = $this->reportRepository->generateXLS($output, $output_column, 'employee', $branch_name);

        if ($xls_file) 
        {
            redirect($xls_file);
        }
    }

    public function generateIncomeTaxReport()
    {
        $output = [];
        $index  = 0;
        $year   = $this->input->post('year');
        $type   = $this->input->post('type');
        if ($type == 'quarterly') {

            $array_dates = array(
                'Q1' => array('start' => date('Y-m-d', strtotime($year . '-01-01')), 'end' => date('Y-m-d', strtotime($year . '-03-31'))),
                'Q2'                  => array('start' => date('Y-m-d', strtotime($year . '-04-01')), 'end' => date('Y-m-d', strtotime($year . '-06-30'))),
                'Q3'                                   => array('start' => date('Y-m-d', strtotime($year . '-07-01')), 'end' => date('Y-m-d', strtotime($year . '-09-30'))),
                'Q4'                                                    => array('start' => date('Y-m-d', strtotime($year . '-010-01')), 'end' => date('Y-m-d', strtotime($year . '-012-31'))),
            );
        } 
        else 
        {
            $months = getMonths($year);

            foreach ($months as $month) 
            {
                $array_dates[$month->monthName] = array('start' => date('Y-m-d', strtotime($month->startMonth)), 'end' => date('Y-m-d', strtotime($month->endMonth)));
            }

        }

        foreach ($array_dates as $key   => $value) {
            array_push($output, ['quarter' => $key]);
            $employees = $this->employeeRepository->all();
            $total = 0;
            foreach ($employees as $employee) {
                $date_hired = date('Y-m-d', strtotime($employee->getDateHired()));
                // dd($date_hired);
                // var_dump($date_hired . ' : ' . $value['start']);
                // var_dump($date_hired <= $value['start']);
                if ($date_hired <= $value['start']) {
                    $item['name'] = $employee->getName();
                    $item['tin']  = $employee->getTin();
                    $item['tax']  = $employee->getGeneratedWtax($value['start'], $value['end']);
                    $total += $item['tax'];
                    array_push($output, $item);
                }

            }
            array_push($output, ['whitespace' => '', 'total'=>'TOTAL', 'total_tax' => $total]);
            array_push($output, ['break' => '']);
        }
        // exit();
        // dd($output);
        $columns = ['Name', 'Tin Number', 'Tax Withheld'];

        $xls_file = $this->reportRepository->generateXLS($output, $columns, 'tax-report');

        if ($xls_file) {
            redirect($xls_file);
        }

    }

    public function generateSssReport()
    {
        $output = [];
        $index  = 0;
        $year   = $this->input->post('year');
        
        $type   = $this->input->post('type');
        if ($type == 'quarterly') {

            $array_dates = array(
                'Q1' => array('start' => date('Y-m-d', strtotime($year . '-01-01')), 'end' => date('Y-m-d', strtotime($year . '-03-31'))),
                'Q2'                  => array('start' => date('Y-m-d', strtotime($year . '-04-01')), 'end' => date('Y-m-d', strtotime($year . '-06-30'))),
                'Q3'                                   => array('start' => date('Y-m-d', strtotime($year . '-07-01')), 'end' => date('Y-m-d', strtotime($year . '-09-30'))),
                'Q4'                                                    => array('start' => date('Y-m-d', strtotime($year . '-010-01')), 'end' => date('Y-m-d', strtotime($year . '-012-31'))),
            );
        } else {
            $months = getMonths($year);

            foreach ($months as $month) {
                $array_dates[$month->monthName] = array('start' => date('Y-m-d', strtotime($month->startMonth)), 'end' => date('Y-m-d', strtotime($month->endMonth)));
            }

        }
        

        foreach ($array_dates as $key => $value) {
            array_push($output, ['quarter' => $key]);
            $employees = $this->employeeRepository->all();
            $total_employee = 0;
            $total_employer = 0;
            foreach ($employees as $employee) {
                $date_hired = date('Y-m-d', strtotime($employee->getDateHired()));
             
                if ($date_hired <= $value['start']) {
                    $item['name']         = $employee->getName();
                    $item['sss_number']   = $employee->getSSS();
                    $item['sss']          = $employee->getGeneratedSSSEmployee($value['start'], $value['end']);
                    $item['employer_sss'] = $employee->getGeneratedSSSEmployer($value['start'], $value['end']);
                    $total_employer += $item['employer_sss'];
                    $total_employee += $item['sss'];
                    array_push($output, $item);
                }

            }
            array_push($output, ['whitespace' => '', 'total'=>'TOTAL', 'total_employee' => $total_employee, 'total_employer' => $total_employer]);
            array_push($output, ['break' => '']);
        }

            
        $columns = ['Name', 'SSS Number', 'Employee', 'Employer'];

        $xls_file = $this->reportRepository->generateXLS($output, $columns, 'sss-report');

        if ($xls_file) {
            redirect($xls_file);
        }

    }

    public function generatePhilhealthReport()
    {
        $output = [];
        $year = $this->input->post('year');

        $type   = $this->input->post('type');
        if ($type == 'quarterly') {

            $array_dates = array(
                'Q1' => array('start' => date('Y-m-d', strtotime($year . '-01-01')), 'end' => date('Y-m-d', strtotime($year . '-03-31'))),
                'Q2'                  => array('start' => date('Y-m-d', strtotime($year . '-04-01')), 'end' => date('Y-m-d', strtotime($year . '-06-30'))),
                'Q3'                                   => array('start' => date('Y-m-d', strtotime($year . '-07-01')), 'end' => date('Y-m-d', strtotime($year . '-09-30'))),
                'Q4'                                                    => array('start' => date('Y-m-d', strtotime($year . '-010-01')), 'end' => date('Y-m-d', strtotime($year . '-012-31'))),
            );
        } else {
            $months = getMonths($year);

            foreach ($months as $month) {
                $array_dates[$month->monthName] = array('start' => date('Y-m-d', strtotime($month->startMonth)), 'end' => date('Y-m-d', strtotime($month->endMonth)));
            }

        }

        foreach ($array_dates as $key => $value) {
            array_push($output, ['quarter' => $key]);
            $employees = $this->employeeRepository->all();
            $total_philhealth = 0;
            foreach ($employees as $employee) {
                $date_hired = date('Y-m-d', strtotime($employee->getDateHired()));
             
                if ($date_hired <= $value['start']) {
                    $item['name']         = $employee->getName();
                    $item['philhealth_number']   = $employee->getPhilhealthNumber();
                    $item['philhealth']          = $employee->getGeneratedPhilhealth($value['start'], $value['end']);
                    $total_philhealth += $item['philhealth'];
                    
                    array_push($output, $item);
                }

            }
            array_push($output, ['whitespace' => '', 'total'=>'TOTAL', 'total_philhealth' => $total_philhealth]);
            array_push($output, ['break' => '']);
        }

            
        $columns = ['Name', 'Philhealth Number', 'Total'];

        $xls_file = $this->reportRepository->generateXLS($output, $columns, 'philhealth-report');

        if ($xls_file) {
            redirect($xls_file);
        }

    }
    public function generatePagibigReport()
    {
        $output = [];
        $year = $this->input->post('year');

        $type   = $this->input->post('type');
        if ($type == 'quarterly') {

            $array_dates = array(
                'Q1' => array('start' => date('Y-m-d', strtotime($year . '-01-01')), 'end' => date('Y-m-d', strtotime($year . '-03-31'))),
                'Q2'                  => array('start' => date('Y-m-d', strtotime($year . '-04-01')), 'end' => date('Y-m-d', strtotime($year . '-06-30'))),
                'Q3'                                   => array('start' => date('Y-m-d', strtotime($year . '-07-01')), 'end' => date('Y-m-d', strtotime($year . '-09-30'))),
                'Q4'                                                    => array('start' => date('Y-m-d', strtotime($year . '-010-01')), 'end' => date('Y-m-d', strtotime($year . '-012-31'))),
            );
        } else {
            $months = getMonths($year);

            foreach ($months as $month) {
                $array_dates[$month->monthName] = array('start' => date('Y-m-d', strtotime($month->startMonth)), 'end' => date('Y-m-d', strtotime($month->endMonth)));
            }

        }

        foreach ($array_dates as $key => $value) {
            array_push($output, ['quarter' => $key]);
            $employees = $this->employeeRepository->all();
            $total_pagibig = 0;
            foreach ($employees as $employee) {
                $date_hired = date('Y-m-d', strtotime($employee->getDateHired()));
             
                if ($date_hired <= $value['start']) {
                    $item['name']         = $employee->getName();
                    $item['pagibig_number']   = $employee->getPagibig();
                    $item['pagibig']          = $employee->getGeneratedPagibig($value['start'], $value['end']);
                    $total_pagibig += $item['pagibig'];
                    
                    array_push($output, $item);
                }

            }
            array_push($output, ['whitespace' => '', 'total'=>'TOTAL', 'total_pagibig' => $total_pagibig]);
            array_push($output, ['break' => '']);
        }

            
        $columns = ['Name', 'Pagibig Number', 'Total'];

        $xls_file = $this->reportRepository->generateXLS($output, $columns, 'pagibig-report');

        if ($xls_file) {
            redirect($xls_file);
        }

    }

    public function generateNumberOfEmployeeReport()
    {
        $output = array();
        $branch = $this->input->post('branch');
        $year = $this->input->post('year');

        $branch = Branch::find($branch);
        $jobs = $this->jobPositionRepository->where('branch_id', $branch->id)->get();
        $departments = $this->departmentRepository->where('branch_id', $branch->id)->get();

        foreach ($departments as $department) {
            $sub_departments = SubDepartment::where('parent_department_id', $department->id)->get();
            foreach ($sub_departments as $sub_department) {
                $row = array();
                $row[1] = $department->department_name;
                $row[2] = $sub_department->sub_department_name;
                $col = 3;
                foreach ($jobs as $job) {
                    $row[$col] = $this->employeeRepository->where('department', $department->id)
                                                             ->where('sub_department_id', $sub_department->id)
                                                             ->where('job_position', $job->id)
                                                             ->count();
                    $col++;
                }
            
            array_push($output, $row);
            }
        }
        
        // var_dump($output);
        // exit();

        $columns = ['Department', 'Sub Department'];
        $header_col = 2;
        foreach ($jobs as $job) {
            $columns[$header_col] = $job->job_position;
            $header_col++;
        }
        // dd($jobs);
        // dd($columns);
        $xls_file = $this->reportRepository->generateXLS($output, $columns, 'plantilla-' . $branch->branch_name, $branch->branch_name);

        if ($xls_file) {
            redirect($xls_file);
        }

    }

    public function generateLeaveReport()
    {
       $output = [];
       $output_column = [];
        $form_types_ref = [
            'ob' => ['name' => 'OB Form', 'string_key' => 'ob'],
            'ot' => ['name' => 'OT Form', 'string_key' => 'ot'],
            'undertime' => ['name' => 'Undertime Form', 'string_key' => 'undertime'],
            'leave' => ['name' => 'Leave Form', 'string_key' => 'leave']

        ];

       $branch_id = $this->input->post('branch');
       $from = $this->input->post('from'); 
       $to = $this->input->post('to'); 
       $form_type = $this->input->post('form_type'); 
       // dd(date('Y-m-d H:i:s', strtotime($from)),date('Y-m-d H:i:s',strtotime($to . " +1 days")));
       $employees = $this->employeeRepository->where('branch_id', $branch_id)->get();
       $branch = Branch::find($branch_id);
       
       foreach ($employees as $employee) {
            $applications = $this->formApplicationRepository->where('form_type', $form_type)
                                                ->where('employee_id', $employee->id)
                                                ->where('status', 'approved')
                                                ->where('from', '>=', date('Y-m-d H:i:s',strtotime($from))) 
                                                ->where('to', '<=', date('Y-m-d H:i:s',strtotime($to . " +1 days"))) 
                                                ->get();
            foreach ($applications as $application) {
           $form_data = json_decode($application->form_data);
           $row[0] = $employee->employee_number;
           $row[1] = $employee->last_name;
           $row[2] = $employee->first_name;
           $row[3] = $employee->middle_name;
           $row[4] = $form_data->reason;
         if($form_type != 'leave'){
            $row[5] = $form_data->total_hrs;
            }
            else{

           $row[5] = $form_data->no_of_days;
            }
                                      
           $row[6] = date('M-d-Y', strtotime($application->from)) . ' to ' . date('M-d-Y',strtotime($application->to));
                     
         array_push($output, $row);
            }

        }

        $output_column = ['Employee #', 'Surname','Firstname', 'Middlename', 'Reason', 'No. of days', 'Date'];
        if($form_type != 'leave'){
            $output_column[5] = "Total Hours";
        }
        $xls_file = $this->reportRepository->generateXLS($output, $output_column, $form_type. '-report-' . $branch->branch_name, $branch->branch_name . " " . $form_types_ref[$form_type]['name']);

        if ($xls_file) {
            redirect($xls_file);
        }

    }

    public function company()
    {
        $data['title']    = $this->company->company_name . " Report ({$year})";
        $data['branches'] = $this->branchRepository->all();
        $data['user']     = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $this->render('reports/company.twig.html', $data);
    }
    public function branch($id)
    {
        $year                   = ($this->input->get('year') == null) ? date('Y') : $this->input->get('year');
        $data['company']        = $this->company;
        $data['user']           = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $branch                 = $this->branchRepository->find($id);
        $data['departments']    = $this->departmentRepository->where('branch_id', '=', $id)->get();
        $data['title']          = $branch->branch_name . " Report ({$year})";
        $data['gross_reports']  = $branch->getGrossReport();
        $data['absent_report']  = $branch->getAbsentReport();
        $data['total_absent']   = $branch->getTotalAbsent();
        $data['total_employee'] = $branch->getTotalEmployees();
        $data['total_expenses'] = $branch->getTotalExpenses();
        $data['tardiness_rate'] = $branch->getTardinessRate();
        $data['branch_id']      = $branch->id;
        $data['branches']       = $this->branchRepository->all();
        $data['year']           = $year;

        // dd($data['gross_report']);
        $this->render('reports/branch.twig.html', $data);

    }

    public function grossReport($id)
    {
        $year = ($this->input->get('year') == null) ? null : $this->input->get('year');
        $data = [];

        $department_id = ($this->input->get('department_id') == null) ? null : $this->input->get('department_id');

        if ($department_id == null || $department_id == "NULL") {
            $branch  = $this->branchRepository->find($id);
            $reports = $branch->getGrossReport($year);

        } else {
            $department = $this->departmentRepository->find($department_id);
            // dd($department->department_name);
            $reports = $department->getGrossReport($year);

        }

        foreach ($reports as $report) {
            $item = [
                'year'    => $report->year . '-' . $report->month,
                'expense' => $report->totalgross
            ];

            array_push($data, $item);
        }
        // dd($data);

        $this->sendJSON($data);
    }

    public function companyGrossReport()
    {
        $year     = ($this->input->get('year') == null) ? null : $this->input->get('year');
        $data     = [];
        $branches = $this->branchRepository->all();
        foreach ($branches as $branch) {
            $reports = $branch->getGrossReport($year);

            foreach ($reports as $report) {
                $item = [
                    'year'                                      => $report->year . '-' . $report->month,
                    $branch          ->branch_name . '-expense' => $report->totalgross
                ];
                if (count($data) >= 12) {
                    $data[$report->month - 1][$branch->branch_name . '-expense'] = $report->totalgross;
                } else {
                    // var_dump('here');
                    array_push($data, $item);

                }
            }
        }

        $this->sendJSON($data);
    }
    public function absentReport($id)
    {
        $year          = ($this->input->get('year') == null) ? null : $this->input->get('year');
        $data          = [];
        $department_id = ($this->input->get('department_id') == null) ? null : $this->input->get('department_id');
        if ($department_id == null || $department_id == "NULL") {
            $branch  = $this->branchRepository->find($id);
            $reports = $branch->getAbsentReport($year);

        } else {
            $department = $this->departmentRepository->find($department_id);
            // dd($department->department_name);
            $reports = $department->getAbsentReport($year);

        }

        foreach ($reports as $report) {
            $item = [
                'year'   => $report->year . '-' . $report->month,
                'absent' => $report->total_absent
            ];

            array_push($data, $item);
        }
        // dd($data);

        $this->sendJSON($data);
    }

    public function lateReport($id)
    {
        $year          = ($this->input->get('year') == null) ? null : $this->input->get('year');
        $department_id = ($this->input->get('department_id') == null) ? null : $this->input->get('department_id');
        $data          = [];
        // dd($department_id);
        if ($department_id == null || $department_id == "NULL") {
            $branch  = $this->branchRepository->find($id);
            $reports = $branch->getLateReport($year);

        } else {
            $department = $this->departmentRepository->find($department_id);
            // dd($department->department_name);
            $reports = $department->getLateReport($year);

        }

        foreach ($reports as $report) {
            $item = [
                'year' => $report->year . '-' . $report->month,
                'late' => $report->total_late
            ];

            array_push($data, $item);
        }
        // dd($data);

        $this->sendJSON($data);
    }

}
