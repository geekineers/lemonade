<?php

require_once APPPATH . '/libraries/excel.php';

use Payslips as Payslips;
use Respect\Validation\Validator as Validator;

class PayslipsRepository extends BaseRepository
{

    protected $employeeRepository, $payrollGroupRepository, $payslipsGroupRepository;
    public function __construct()
    {
        $this->class = new Payslips();

        $this->employeeRepository      = new EmployeeRepository();
        $this->payrollGroupRepository  = new PayrollGroupRepository();
        $this->payslipsGroupRepository = new PayslipsGroupRepository();
    }
    public function getTotalSSS($slips)
    {
        $total = 0;
        foreach ($slips as $slip) {
            $total = $total + intval($slip->sss);
        }
        return $total;
    }
    public function getTotalWtax()
    {

    }

    public function getSlipById($id)
    {
        return $this->where('id', '=', $id)->first();
    }

    public function getTotalCompensationPerGroup($from, $to, $id)
    {
        $slips = $this->where('id', '=', $id)
                      ->whereBetween('from', ['from', 'to'])
                      ->get();

    }

    public function getAllPayslip()
    {
        return $this->all();
    }

    public function getPayslipById($id, $from, $to)
    {

        return $this->where('payslip_group_id', '=', $id)
                    ->get();
    }

    public function getAllPayrollGroupBySlips()
    {
        $slip = $this->groupBy('from')->groupBy('payroll_group');
        return $slip->get();
    }

    public function generatePayslip($input, $prepared_by)
    {
        // get payroll group
        $validator = Validator::arr()->key('group_name', Validator::notEmpty())
                                     ->key('from', Validator::date('Y-m-d'))
                                     ->key('to', Validator::date('Y-m-d'))
                                     ->validate($input);

        if ($validator) {
            $from = date('Y-m-d', strtotime($input['from']));
            $to   = date('Y-m-d', strtotime($input['to']));

            $payslip_group_from = $this->payslipsGroupRepository->where('payroll_group', '=', $input['group_name'])->whereBetween('from', [$from, $to])->count();
            $payslip_group_to   = $this->payslipsGroupRepository->where('payroll_group', '=', $input['group_name'])->whereBetween('to', [$from, $to])->count();

            if ($payslip_group_from == 0 && $payslip_group_to == 0) {
                return $this->generate([
                    'from'          => $from,
                    'to'            => $to,
                    'payroll_group' => $input['group_name'],
                    'status'        => 'open',
                    'prepared_by'   => $prepared_by
                ]);
            } else {
                return json_encode(['status' => 'fail']);
            }
        } else {
            return json_encode(['status' => 'fail']);
        }

    }

    public function generate($input)
    {
        $from        = $input['from'];
        $to          = $input['to'];
        $prepared_by = $input['prepared_by'];

        $payrollGroup = $this->payrollGroupRepository->where('id', '=', $input['payroll_group'])->first();
        // emoloyee
        $employees = $this->employeeRepository->where('branch_id', '=', $payrollGroup['branch_id'])
                          ->where('payroll_period', '=', $payrollGroup['id'])->get();
        $payslip_group = $this->payslipsGroupRepository->create($input);

        foreach ($employees as $employee) 
        {

            $this->saveEmployeePayslip($employee, $payslip_group, $payrollGroup, $from, $to, $prepared_by);

            $this->sendEmail($employee->email, 'payroll ' . $from . '-' . $to, 'Your payslip is ready check account');

        }

        return json_encode(['status' => 'success']);
    }

    public function saveEmployeePayslip(Employee $employee, $payslip_group, $payrollGroup, $from, $to, $prepared_by)
    {
        $from = date('Y-m-d', strtotime($from));
        $to   = date('Y-m-d', strtotime($to));

        $from_month = date('Y-m', strtotime($from));
        $from_start_month = date('Y-m-d', strtotime($from_month));
        $from_end_month = date('Y-m-d', strtotime($from_month . "+ 30 days"));
        $term = PayslipsGroup::whereBetween('from', [$from_start_month, $from_end_month])->where('payroll_group', $payrollGroup->id)->count();
        // dd($term);
        $employee_slip['payslip_group_id'] = $payslip_group->id;
        $employee_slip['employee_id']      = $employee->id;
        $employee_slip['payroll_group']    = $payrollGroup->id;
        $employee_slip['branch_id']        = $payrollGroup->branch_id;
        $employee_slip['sss']              = $employee->getSSSValue(false, $term);
        $employee_slip['sss_employer']     = $employee->getSSSEmployerValue(false, $term);
        $employee_slip['philhealth']       = $employee->getPhilhealthValue($term);
        $employee_slip['pagibig']          = $employee->getHDMFValue($term);
        $employee_slip['other_deductions'] = $employee->getTotalDeductions($from, $to, false);
        $employee_slip['gross']            = $employee->getGross($from, $to, false);
        $employee_slip['withholding_tax']  = $employee->getWithholdingTax($from, $to, false);
        $employee_slip['prepared_by']      = $prepared_by;
        $employee_slip['department_id']    = $employee->department;
        $employee_slip['basic_pay']    = (strtolower($employee->getPayrollPeriod(false)) != "daily") ? $employee->getBasicSalary(false) : $employee->getBasicSalary(false) * $employee->getInAttendance($from, $to);
        $employee_slip['in_attendance']    = $employee->getInAttendance($from, $to);
        $employee_slip['sunday_pay']    = ($employee->getSundayAttendance($from, $to)) ? $employee->getSundayPay($from, $to, true) : 0;
        $employee_slip['sunday_attended_hours']    = ($employee->getSundayAttendance($from, $to)) ? $employee->getSundayAttendanceHours($from, $to) : 0;
        $employee_slip['overtime_pay'] = ($employee->getOvertime($from, $to)) ? $employee->getOverTimePay($from, $to) : 0;
        $employee_slip['overtime_hours'] =  $employee->getOvertime($from, $to); 
        $employee_slip['night_differential_pay'] = $employee->getNightDifferentialPay($from, $to);
        $employee_slip['night_differential_hours'] =  $employee->getNightDifferentialHours($from, $to); 
        $employee_slip['regular_holiday_pay'] = $employee->getRegularHolidayPay($from, $to);
        $employee_slip['regular_holiday_count'] = $employee->getRegularHolidayAttendance($from, $to);
        $employee_slip['special_holiday_pay'] = $employee->getSpecialHolidayPay($from, $to);
        $employee_slip['special_holiday_count'] = $employee->getSpecialHolidayAttendance($from, $to);
        $employee_slip['total_allowance_pay'] = $employee->getTotalAllowances($from, $to, false);
        $employee_slip['total_deduction_pay'] = $employee->getAllandTotalDeduction($from, $to, false, $term);
        $employee_slip['allowances'] = json_encode($employee->getAllowances($from, $to));
        $employee_slip['deductions'] = json_encode($employee->getDeductions($from, $to));
        $employee_slip['base_pay'] = $employee->getBasicSalary(false);
        $employee_slip['net']              = (($employee_slip['gross'] - $employee_slip['total_deduction_pay']) > 0 ) ? $employee_slip['gross'] - $employee_slip['total_deduction_pay'] : 0;
        // var_dump($employee->getName());
        // var_dump($employee_slip);
        $this->create($employee_slip);
        return true;
    }

    public function sendEmail($email = null, $subject = null, $message = null)
    {
        $instance = get_instance();
        $config   = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.sendgrid.net',
            'smtp_port' => 465,
            'smtp_user' => 'naroejesus',
            'smtp_pass' => 'oxygen05',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1',
        );
        $instance->load->library('email', $config);
        $instance->email->set_newline("\r\n");
        $instance->email->from('admin@lemon.com');// change it to yours
        $instance->email->to($email);// change it to yours
        $instance->email->subject($subject);
        $instance->email->message($message);

        return $instance->email->send();
    }

    public function generateMasterXLS($data)
    {
        $slip   = $data['payslips'];
        $from   = $data['from'];
        $to     = $data['to'];
        $period = $data['period'];
        $date   = $data['date'];

        get_instance()->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load("xls_template/masterlist.xlsx");
        $objPHPExcel->setActiveSheetIndex(0);
        $A = $objPHPExcel->getActiveSheet();
        $B = clone $A;
        $C = clone $A;
        try 
        { 
           // dd($slip); 
            foreach ($slip as $key => $payslip)
            {  
                    if($key > 0)
                    {
                        // var_dump($key); die();
                        $B = clone $C;
                        $B->setTitle($payslip['name']);
                        $sheetIndex = $key;
                        $row = 10;
                        $objPHPExcel->addSheet($B,$sheetIndex);
                        $objPHPExcel->setActiveSheetIndex($key);

                    }
                    //echo $row;

                    $totalRow = 21;

                    //
                    //
                    $total_night_diff = 0;
                    $total_cola = 0;
                    $total_sea = 0;
                    $total_rest_day = 0;
                    $total_all_deduction = 0;
                    $total_all_employee_sss = 0;
                    $total_all_employer_sss = 0;
                    $total_all_employee_pagibig = 0;
                    $total_all_employer_pagibig = 0;
                    $total_all_employee_philhealth = 0; 
                    $total_all_employer_philhealth = 0; 
                    $total_all_both_sss = 0;
                    $total_all_both_pagibig = 0;
                    $total_all_both_philhealth = 0;
                    $total_all_netpay = 0;


                    $total_all_gross = 0;
                    $total_all_overtime = 0;
                    $total_all_allowance = 0;
                    $total_all_late_deduction = 0;
                    $total_all_absent = 0;


                    $row = 10;
                    $objPHPExcel->setActiveSheetIndex($key);
                    $objPHPExcel->getActiveSheet()->SetTitle($payslip['name']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D1', $from . '-' . $to);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D2', $date);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D3', $period->getPayrollGroup()->period);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D7', $payslip['name']);
                    foreach ($payslip['items'] as $key=>$item)  
                    {
                        $total_allowance = $item->total_allowance_pay - $item->getEmployee()->getColaPay($from, $to, 'normal_day') - $item->getEmployee()->getSEAPay($from, $to);
                        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $row, $item->getEmployee()->getEmployeeID());
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $row, toTitleCase($item->getEmployee()->last_name));
                        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $row, toTitleCase($item->getEmployee()->first_name));
                        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $row, toTitleCase($item->getEmployee()->middle_name));
                        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $row, $item->getEmployee()->getJobPosition());
                        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $row, $item->getEmployee()->getTaxStatus());
                        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $row, $item->in_attendance);
                        // $objPHPExcel->getActiveSheet()->SetCellValue('J' . $row, $item->getEmployee()->get#DAYOFF());
                        $objPHPExcel->getActiveSheet()->SetCellValue('K' . $row, $item->getEmployee()->getMonthlyRate(true));
                        $objPHPExcel->getActiveSheet()->SetCellValue('L' . $row, $item->getEmployee()->getSemiMonthlyRate(true));
                        $objPHPExcel->getActiveSheet()->SetCellValue('M' . $row, $item->getEmployee()->getDailyRate());
                        $objPHPExcel->getActiveSheet()->SetCellValue('N' . $row, number_format($item->getEmployee()->getColaPay($from, $to, 'normal_day'), 2));
                        $objPHPExcel->getActiveSheet()->SetCellValue('O' . $row, number_format($item->getEmployee()->getSEAPay($from, $to), 2));
                        $objPHPExcel->getActiveSheet()->SetCellValue('P' . $row, number_format($total_allowance, 2));
                        $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $row, $item->getEmployee()->getOverTime($from, $to, 'normal'));
                        $objPHPExcel->getActiveSheet()->SetCellValue('R' . $row, $item->getEmployee()->getOverTimePay($from, $to, 'normal'));
                        $objPHPExcel->getActiveSheet()->SetCellValue('S' . $row, $item->getEmployee()->getOverTime($from, $to, 'regular_holiday'));
                        $objPHPExcel->getActiveSheet()->SetCellValue('T' . $row, $item->getEmployee()->getOverTimePay($from, $to, 'regular_holiday'));
                        $objPHPExcel->getActiveSheet()->SetCellValue('U' . $row, $item->getEmployee()->getOverTime($from, $to, 'special_holiday'));
                        $objPHPExcel->getActiveSheet()->SetCellValue('V' . $row, $item->getEmployee()->getOverTimePay($from, $to, 'special_holiday'));
                        $objPHPExcel->getActiveSheet()->SetCellValue('W' . $row, $item->getEmployee()->getOverTime($from, $to, 'rest_day'));
                        $objPHPExcel->getActiveSheet()->SetCellValue('X' . $row, $item->getEmployee()->getOverTimePay($from, $to, 'rest_day'));
                        $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $row, $item->getEmployee()->getOverTime($from, $to, 'regular_holiday_rest_day'));
                        $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $row, $item->getEmployee()->getOverTimePay($from, $to, 'regular_holiday_rest_day'));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $row, $item->getEmployee()->getOverTime($from, $to, 'special_holiday_rest_day'));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $row, $item->getEmployee()->getOverTimePay($from, $to, 'special_holiday_rest_day'));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $row, $item->getEmployee()->getRestDayAttendance($from, $to, 'all'));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $row, $item->getEmployee()->getTotalRestDayPay($from, $to));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $row, $item->getEmployee()->getNightDifferentialHours($from, $to));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $row, $item->getEmployee()->getNightDifferentialPay($from, $to));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $row, $item->getEmployee()->getRegularHolidayPay($from, $to));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $row, $item->getEmployee()->getSpecialHolidayPay($from, $to));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $row, $item->getEmployee()->getGross($from, $to));
                        // $objPHPExcel->getActiveSheet()->SetCellValue('T' . $row, $item->getEmployee()->get#CASHADVANCE;
                        $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $row, $item->getEmployee()->getAbsentDeduction($from, $to, true));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $row, $item->getEmployee()->getUnderTimeAndLateDeduction($from, $to, 'minute', true));
                        // $objPHPExcel->getActiveSheet()->SetCellValue('V' . $row, $item->getEmployee()->getUnderTimeAndLateDeduction($from, $to, 'minute', true) + $item->getEmployee()->getAbsentDeduction($from, $to, true));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $row, $item->getEmployee()->getTotalDeductions($from, $to));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AR' . $row, number_format($item->sss, 2));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AS' . $row, number_format($item->sss_employer,2));

                        $objPHPExcel->getActiveSheet()->SetCellValue('AT' . $row, $item->getEmployee()->getGeneratedSSSEC($from, $to));
                        // $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $row, $item->getEmployee()->get#EC

                        // $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $row, $item->getEmployee()->getGeneratedSSSEmployer($from, $to));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AU' . $row, ((float)$item->getEmployee()->getGeneratedSSSEmployee($from, $to) + (float)$item->getEmployee()->getGeneratedSSSEmployer($from, $to)));

                        $objPHPExcel->getActiveSheet()->SetCellValue('AV' . $row, $item->getEmployee()->getGeneratedPagibig($from, $to));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AW' . $row, $item->getEmployee()->getGeneratedPagibig($from, $to));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AX' . $row, ((float)$item->getEmployee()->getGeneratedPagibig($from, $to)) * 2);
                        $objPHPExcel->getActiveSheet()->SetCellValue('AY' . $row, $item->getEmployee()->getGeneratedPhilhealth($from, $to));
                        $objPHPExcel->getActiveSheet()->SetCellValue('AZ' . $row, $item->getEmployee()->getGeneratedPhilhealth($from, $to));
                        $objPHPExcel->getActiveSheet()->SetCellValue('BA' . $row, ((float)$item->getEmployee()->getGeneratedPhilhealth($from, $to)) * 2);
                        // $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $row, $item->getEmployee()->getGeneratedPhilhealth($from, $to));
                        $objPHPExcel->getActiveSheet()->SetCellValue('BB' . $row, $item->getEmployee()->getNet($from, $to));
                        // $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $row, $item->getEmployee()->getPayrollPeriod()->period);
                        // $objPHPExcel->getActiveSheet()->SetCellValue('AO' . $row, $item->getEmployee()->get#REMARKS
                        $total_night_diff +=   $item->getEmployee()->getNightDifferentialPay($from, $to);
                        $total_rest_day += $item->getEmployee()->getTotalRestDayPay($from, $to);
                        $total_cola += $item->getEmployee()->getColaPay($from, $to, 'normal_day');
                        $total_sea +=  $item->getEmployee()->getSEAPay($from, $to);
                        $total_all_deduction += $item->getEmployee()->getUnderTimeAndLateDeduction($from, $to, 'minute', false) + $item->getEmployee()->getAbsentDeduction($from, $to, false);
                        $total_all_both_sss += (float)$item->getEmployee()->getGeneratedSSSEmployee($from, $to) + (float)$item->getEmployee()->getGeneratedSSSEmployer($from, $to);
                        $total_all_both_pagibig += (float) $item->getEmployee()->getGeneratedPagibig($from, $to) * 2;
                        $total_all_both_philhealth += (float)$item->getEmployee()->getGeneratedPhilhealth($from, $to) * 2;
                        $total_all_netpay += (float) $item->getEmployee()->getNet($from, $to, false);
                       
                        $total_all_employee_sss += (float)$item->getEmployee()->getGeneratedSSSEmployee($from, $to);
                        $total_all_employer_sss += (float)$item->getEmployee()->getGeneratedSSSEmployer($from, $to);
                        $total_all_employee_philhealth += (float)$item->getEmployee()->getGeneratedPhilhealth($from, $to);
                        $total_all_employer_philhealth += (float)$item->getEmployee()->getGeneratedPhilhealth($from, $to);
                        $total_all_employee_pagibig += (float)$item->getEmployee()->getGeneratedPagibig($from, $to);
                        $total_all_employer_pagibig += (float)$item->getEmployee()->getGeneratedPagibig($from, $to);
                        $total_all_gross += (float)$item->getEmployee()->getGross($from, $to, false);

                        $total_all_overtime += (float) $item->getEmployee()->getOverTimePay($from, $to);
                        $total_all_allowance += (float) $total_allowance;
                        $total_all_late_deduction += (float) $item->getEmployee()->getUnderTimeAndLateDeduction($from, $to, 'minute');
                        $total_all_absent += (float) $item->getEmployee()->getAbsentDeduction($from, $to, false);
                        $row++;      
                       
                        if ($key === count($payslip['items'])-1)
                        {
                            $total_row = $row + 3;
                            
                            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $total_row, "Grand Total:");
                            $objPHPExcel->getActiveSheet()->getStyle('A' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('A' . $total_row)->getFont()->setSize(11);

                            // $objPHPExcel->getActiveSheet()->SetCellValue('C' . $row, $item->getEmployee()->getEmployeeID());
                            // $objPHPExcel->getActiveSheet()->SetCellValue('D' . $row, toTitleCase($item->getEmployee()->last_name));
                            // $objPHPExcel->getActiveSheet()->SetCellValue('E' . $row, toTitleCase($item->getEmployee()->first_name));
                            // $objPHPExcel->getActiveSheet()->SetCellValue('F' . $row, toTitleCase($item->getEmployee()->middle_name));
                            // $objPHPExcel->getActiveSheet()->SetCellValue('G' . $row, $item->getEmployee()->getJobPosition());
                            // $objPHPExcel->getActiveSheet()->SetCellValue('H' . $row, $item->getEmployee()->getMonthlyRate(true));
                            // $objPHPExcel->getActiveSheet()->SetCellValue('I' . $row, $item->getEmployee()->getSemiMonthlyRate(true));
                            // $objPHPExcel->getActiveSheet()->SetCellValue('J' . $row, $item->getEmployee()->getDailyRate());
                            // $objPHPExcel->getActiveSheet()->SetCellValue('K' . $row, $item->getEmployee()->getTaxStatus());
                            // $objPHPExcel->getActiveSheet()->SetCellValue('L' . $row, $item->getEmployee()->getInAttendance($from, $to, $weekend_include = true));
                            // $objPHPExcel->getActiveSheet()->SetCellValue('M' . $row, $item->getEmployee()->get#DAYOFF());
                            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $total_row, $total_cola);
                               $objPHPExcel->getActiveSheet()->getStyle('N' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('N' . $total_row)->getFont()->setSize(11);
                            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $total_row, $total_sea);
                               $objPHPExcel->getActiveSheet()->getStyle('O' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('O' . $total_row)->getFont()->setSize(11);
                  $objPHPExcel->getActiveSheet()->SetCellValue('P' . $total_row, $total_all_allowance);
                               $objPHPExcel->getActiveSheet()->getStyle('P' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('P' . $total_row)->getFont()->setSize(11);
                                   $objPHPExcel->getActiveSheet()->SetCellValue('R' . $total_row, $total_all_overtime);
                               $objPHPExcel->getActiveSheet()->getStyle('R' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('R' . $total_row)->getFont()->setSize(11);

                                   $objPHPExcel->getActiveSheet()->SetCellValue('T' . $total_row, $total_rest_day);
                               $objPHPExcel->getActiveSheet()->getStyle('T' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('T' . $total_row)->getFont()->setSize(11);

                                   $objPHPExcel->getActiveSheet()->SetCellValue('V' . $total_row, $total_night_diff);
                               $objPHPExcel->getActiveSheet()->getStyle('V' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('V' . $total_row)->getFont()->setSize(11);
                            // $objPHPExcel->getActiveSheet()->SetCellValue('P' . $row, $item->getEmployee()->get#SUNDAYOVERTIME;
                            // $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $row, $item->getEmployee()->getRegularHolidayPay($from, $to));
                            // $objPHPExcel->getActiveSheet()->SetCellValue('R' . $row, $item->getEmployee()->getSpecialHolidayPay($from, $to));
                            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $total_row, $total_all_gross);
                               $objPHPExcel->getActiveSheet()->getStyle('Y' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('Y' . $total_row)->getFont()->setSize(11);
                            // $objPHPExcel->getActiveSheet()->SetCellValue('T' . $row, $item->getEmployee()->get#CASHADVANCE;
                            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $total_row, $total_all_absent);
                               $objPHPExcel->getActiveSheet()->getStyle('Z' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('Z' . $total_row)->getFont()->setSize(11);
                            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $total_row, $total_all_late_deduction);
                               $objPHPExcel->getActiveSheet()->getStyle('AA' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AA' . $total_row)->getFont()->setSize(11);
                            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $total_row, $total_all_deduction);
                               $objPHPExcel->getActiveSheet()->getStyle('AB' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AB' . $total_row)->getFont()->setSize(11);
                            // $objPHPExcel->getActiveSheet()->SetCellValue('W' . $row, $item->getEmployee()->getTotalDeductions($from, $to));
                            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $total_row, $total_all_employee_sss);
                               $objPHPExcel->getActiveSheet()->getStyle('AH' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AH' . $total_row)->getFont()->setSize(11);
                            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $total_row, $total_all_employer_sss);
                               $objPHPExcel->getActiveSheet()->getStyle('AI' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AI' . $total_row)->getFont()->setSize(11);
                            // $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $row, $item->getEmployee()->getGeneratedSSSEmployer($from, $to));
                            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $total_row, $total_all_both_sss);
                               $objPHPExcel->getActiveSheet()->getStyle('AK' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AK' . $total_row)->getFont()->setSize(11);
                            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $total_row, $total_all_employee_pagibig);
                               $objPHPExcel->getActiveSheet()->getStyle('AL' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AL' . $total_row)->getFont()->setSize(11);
                            $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $total_row, $total_all_employer_pagibig);
                               $objPHPExcel->getActiveSheet()->getStyle('AM' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AM' . $total_row)->getFont()->setSize(11);
                            $objPHPExcel->getActiveSheet()->SetCellValue('AN' . $total_row, $total_all_both_pagibig);
                               $objPHPExcel->getActiveSheet()->getStyle('AN' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AN' . $total_row)->getFont()->setSize(11);
                            $objPHPExcel->getActiveSheet()->SetCellValue('AO' . $total_row, $total_all_employee_philhealth);
                               $objPHPExcel->getActiveSheet()->getStyle('AO' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AO' . $total_row)->getFont()->setSize(11);
                            $objPHPExcel->getActiveSheet()->SetCellValue('AP' . $total_row, $total_all_employer_philhealth);
                               $objPHPExcel->getActiveSheet()->getStyle('AP' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AP' . $total_row)->getFont()->setSize(11);
                            $objPHPExcel->getActiveSheet()->SetCellValue('AQ' . $total_row, $total_all_both_philhealth);
                               $objPHPExcel->getActiveSheet()->getStyle('AQ' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AQ' . $total_row)->getFont()->setSize(11);
                            // $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $row, $item->getEmployee()->getGeneratedPhilhealth($from, $to));
                            $objPHPExcel->getActiveSheet()->SetCellValue('AR' . $total_row, $total_all_netpay);
                               $objPHPExcel->getActiveSheet()->getStyle('AR' . $total_row)->getFont()->setBold(true);
                            $objPHPExcel->getActiveSheet()->getStyle('AR' . $total_row)->getFont()->setSize(11);
                            // $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $row, $item->getEmployee()->getPayrollPeriod()->period);
                            // $objPHPExcel->getActiveSheet()->SetCellValue('B' . $row+11, "PREPARED BY:");
                            // $objPHPExcel->getActiveSheet()->SetCellValue('G' . $row+11, "CHECKED BY:");
                            // $objPHPExcel->getActiveSheet()->SetCellValue('L' . $row+11, "APPROVED BY:");   
                        }
                         
                    }       

            }


            
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save('excel_files/masterlist-' . $date . '.xlsx');
            return true;
        }
        catch (Exception $e) {
            dd($e);
        }

    }

    public function generatePayslipXls($data)
    {
       
        get_instance()->load->library('excel');
        try {
            $objPHPExcel = PHPExcel_IOFactory::load("xls_template/masterlist.xlsx");
            $objPHPExcel->setActiveSheetIndex(0);
            $objWorksheet = new PHPExcel_Worksheet($objPHPExcel);
            $objPHPExcel->addSheet($objWorksheet);
            $row = $objPHPExcel->getActiveSheet()->getHighestRow() + 1;
            //echo $row;
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', $from . '-' . $to);
            $objPHPExcel->getActiveSheet()->SetCellValue('B2', $date);
            // $objPHPExcel->getActiveSheet()->SetCellValue('B3', $period->getPayrollGroup()->period);
            $row = 10;
            foreach ($slip as $key => $payslip) {

                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row, $payslip->getEmployee()->id);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $row, $payslip->getEmployee()->getName());
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $row, $payslip->getEmployee()->getJobPosition());
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $row, $payslip->getEmployee()->getMonthlyRate(true));
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $row, $payslip->getEmployee()->getSemiMonthlyRate(true));
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $row, $payslip->getEmployee()->getDailyRate());
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $row, $payslip->getEmployee()->getTaxStatus());
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $row, $payslip->getEmployee()->getTotalAllowances($from, $to));
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $row, $payslip->getEmployee()->getGross($from, $to));
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $row, $payslip->getEmployee()->getSSSValue(true));
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $row, $payslip->getEmployee()->getPhilhealthValue(true));
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $row, $payslip->getEmployee()->getHDMFValue(true));
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $row, $payslip->getEmployee()->getAbsentDeduction($from, $to));
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $row, $payslip->getEmployee()->getLateDeduction($from, $to, 'minute', true));
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $row, $payslip->getEmployee()->getUnderTimeDeduction($from, $to, 'minute', true));
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $row, $payslip->getEmployee()->getTotalDeductions($from, $to, 'minute', true));
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $row, $payslip->getEmployee()->getWithholdingTax($from, $to, true));
                $objPHPExcel->getActiveSheet()->SetCellValue('R' . $row, $payslip->getEmployee()->getNet($from, $to));

                $row++;
            }

            $objPHPExcel->getActiveSheet()
                ->getStyle( $phpExcel->getActiveSheet()->calculateWorksheetDimension() )
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save('excel_files/payslip-' . $date . '.xlsx');
            return true;
        }
         catch (Exception $e) {
            dd($e);
        }
    }

    public function generateGovermentForms($id, $type, $from, $to)
    {
        $pdf   = new FPDI();
        $slips = $this->getPayslipById($id, $from, $to);

        $group = $this->payslipsGroupRepository->where('id', '=', $id)->first();
        // set the sourcefile

        // dd($group->getPayrollGroup()->getBranch());
        // $pdf->setSourceFile($pdf_template);
        if ($type == 'mcrf') {

            $pageCount = $pdf->setSourceFile('pdf_template/FPF060.pdf');
            // iterate through all pages
            $templateArr = [];
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $pdf->importPage($pageNo);
                // get the size of the imported page
                $size          = $pdf->getTemplateSize($templateId);
                $templateArr[] = $templateId;
                // create a page (landscape or portrait depending on the imported page size)
                if ($size['w'] > $size['h']) {
                    $pdf->AddPage('L', array($size['w'], $size['h']));
                } else {
                    $pdf->AddPage('P', array($size['w'], $size['h']));
                }

                // use the imported page
                if ($templateId == 1) {
                    $pdf->useTemplate($templateId);
                    $pdf->SetFont('Helvetica');
                    $pdf->SetFontSize('8');
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetXY(7, 44);
                    $data = $group->getPayrollGroup()->getBranch();
                    $pdf->Write(0, $data);
                    foreach ($slips as $i => $slip) {

                        $tin   = $slip->getEmployee()->tin_number != null ? $slip->getEmployee()->tin_number : 'n/a     ';
                        $birth = $slip->getEmployee()->birthdate;
                        $fname = $slip->getEmployee()->first_name;
                        $mname = $slip->getEmployee()->middle_name;
                        $lname = $slip->getEmployee()->last_name;
                        $ee    = 100;
                        $er    = 200;
                        $total = $ee + $er;
                        $pdf->SetXY(7, 69+(4 * $i));
                        $data = $tin . '                           ' .
                            $birth . '                   ' .
                            $lname . '                          ' .
                            $fname . '                      ' .
                            $mname . '               ' .
                            $ee . '                       ' .
                            $er . '                        ' .
                            $total;
                        $pdf->Write(0, $data);

                    }
                } else {
                    $pdf->useTemplate($templateId);

                    $pdf->SetFont('Helvetica');
                    $pdf->SetXY(5, 5);
                    $pdf->Write(8, 'A complete document imported with FPDI');
                }
            }

            $pdf->Output();
        } else if ($type == '1601C') {
            $pageCount = $pdf->setSourceFile('pdf_template/1601C.pdf');
            // iterate through all pages
            $templateArr = [];
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $pdf->importPage($pageNo);
                // get the size of the imported page
                $size          = $pdf->getTemplateSize($templateId);
                $templateArr[] = $templateId;
                // create a page (landscape or portrait depending on the imported page size)
                if ($size['w'] > $size['h']) {
                    $pdf->AddPage('L', array($size['w'], $size['h']));
                } else {
                    $pdf->AddPage('P', array($size['w'], $size['h']));
                }

                // use the imported page
                // fill first page
                if ($templateId == 2) {

                    $pdf->useTemplate($templateId);
                    $pdf->SetFont('Helvetica');

                    $pdf->SetTextColor(0, 0, 0);

                    // month
                    $data = date("m", strtotime($slips[0]->to));
                    $pdf->SetFontSize('14');
                    $pdf->SetXY(45, 56);
                    $pdf->Write(0, $data);
                    // year
                    $data = date("Y", strtotime($slips[0]->to));
                    $pdf->SetFontSize('14');
                    $pdf->SetXY(55, 56);
                    $pdf->Write(0, $data);
                    // polt
                    $pdf->SetFontSize('14');
                    $pdf->SetXY(106, 56);
                    $pdf->Write(0, 'X');

                    // tin

                    $pdf->SetFontSize('14');
                    $tin  = Company::first()->company_tin;
                    $tin_ = substr($tin, 0, 3) . '       ' . substr($tin, 3, 3) . '       ' . substr($tin, 6, 3) . '       ' . substr($tin, 9, 3);
                    $pdf->SetXY(22, 68);
                    $pdf->Write(0, $tin_);

                    $pdf->SetFontSize('12');
                    $pdf->SetXY(20, 79);
                    $pdf->Write(0, Company::first()->company_name);
                    // group

                    // line of business

                    $pdf->SetFontSize('10');
                    $pdf->SetXY(162, 68);
                    $pdf->Write(0, Company::first()->line_of_business);
                    // group
                    $pdf->SetFontSize('12');
                    $pdf->SetXY(20, 89);
                    $pdf->Write(0, Company::first()->company_address);

                } else {
                    $pdf->useTemplate($templateId);

                    $pdf->SetFont('Helvetica');
                    $pdf->SetXY(5, 5);
                    $pdf->Write(8, 'A complete document imported with FPDI');
                }
            }

            $pdf->Output();
        } else if ($type == "sss-r3") {
            $pageCount = $pdf->setSourceFile('pdf_template/sss-r3.pdf');
            // iterate through all pages
            $templateArr = [];
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $pdf->importPage($pageNo);
                // get the size of the imported page
                $size          = $pdf->getTemplateSize($templateId);
                $templateArr[] = $templateId;
                // create a page (landscape or portrait depending on the imported page size)
                if ($size['w'] > $size['h']) {
                    $pdf->AddPage('L', array($size['w'], $size['h']));
                } else {
                    $pdf->AddPage('P', array($size['w'], $size['h']));
                }

                // use the imported page
                if ($templateId == 1) {
                    $pdf->useTemplate($templateId);
                    $pdf->SetFont('Helvetica');
                    $pdf->SetFontSize('8');

                    // sss number
                    $pdf->SetFontSize('12');
                    $pdf->SetXY(15, 34);
                    $pdf->SetFont('');
                    $pdf->CellFitSpaceForce(53, 10, Company::first()->company_sss, 2, 1, 1);
                    // address
                    $pdf->SetXY(70, 48);
                    $pdf->SetFontSize('10');
                    $data = Company::first()->company_address;
                    $pdf->Write(0, $data);

                    // tel
                    $pdf->SetXY(15, 48);
                    $pdf->SetFontSize('10');
                    $data = Company::first()->company_tel;
                    $pdf->Write(0, $data);

                    // employer name
                    $pdf->SetFontSize('10');
                    $pdf->SetXY(70, 38);
                    $pdf->Write(0, Company::first()->company_name);

                    foreach ($slips as $i => $slip) {

                        $sss   = $slip->getEmployee()->sss_number != null ? $slip->getEmployee()->sss_number : '';
                        $birth = $slip->getEmployee()->birthdate;
                        $fname = $slip->getEmployee()->first_name;
                        $mname = $slip->getEmployee()->middle_name;
                        $lname = $slip->getEmployee()->last_name;
                        $ee    = 100;
                        $er    = 200;
                        $total = $ee + $er;
                        $pdf->SetXY(15, 69+(4 * $i));
                        $data = $tin . '                           ' .
                            $birth . '                   ' .
                            $lname . '                          ' .
                            $fname . '                      ' .
                            $mname . '               ' .
                            $ee . '                       ' .
                            $er . '                        ' .
                            $total;
                        $pdf->CellFitSpaceForce(40, 0, $sss, 2, 1, 1);
                        $pdf->Write(0, $data);
                        $pdf->SetXY(133.5, 69+(4 * $i));
                        $pdf->Write(0, number_format($slip->sss, 2));
                        $pdf->Ln();

                    }

                    // total amount
                    $pdf->SetFontSize('10');
                    $pdf->SetXY(145.5, 168);
                    $pdf->Write(0, number_format($this->getTotalSSS($slips), 2));
                } else {
                    $pdf->useTemplate($templateId);

                    $pdf->SetFont('Helvetica');
                    $pdf->SetXY(5, 5);
                    $pdf->Write(8, '');
                }
            }

            $pdf->Output();
        }
    }
}
