<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class ReportsController extends BaseController
{
    protected $branchRepository, $employeeRepository, $departmentRepository, $reportRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->branchRepository     = new BranchRepository();
        $this->departmentRepository = new DepartmentRepository();
        $this->employeeRepository   = new EmployeeRepository();

        $this->reportRepository = new ReportRepository();

    }

    public function generate()
    {
        // $year = ($this->input->get('year') == null) ? date('Y') : $this->input->get('year');
        $data['company']  = $this->company;
        $data['title']    = "Generate Report";
        $data['branches'] = $this->branchRepository->all();
        $data['user']     = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $this->render('reports/generate.twig.html', $data);

    }

    public function generateEmployeeList()
    {
        $output           = [];
        $output_column    = [];
        $index            = 0;
        $selected_columns = $this->input->post('columns');
        $columns          = array_keys($selected_columns);
        $employees        = $this->employeeRepository->all();

        foreach ($employees as $employee) {
            $output[$index]['first_name']  = $employee->first_name;
            $output[$index]['middle_name'] = $employee->middle_name;
            $output[$index]['last_name']   = $employee->last_name;

            foreach ($columns as $column) {
                $method = 'get' . _snakeToCamel($column);
                $value  = call_user_func(array($employee, $method));

                $output[$index][$column] = $value;
            }

            $index++;
        }
        array_push($output_column, "First Name");
        array_push($output_column, "Middle Name");
        array_push($output_column, "Last Name");

        foreach ($columns as $column) {
            array_push($output_column, _snakeToTitle($column));
        }

        $xls_file = $this->reportRepository->generateXLS($output, $output_column, 'employee');

        if ($xls_file) {
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
        } else {
            $months = getMonths($year);

            foreach ($months as $month) {
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
