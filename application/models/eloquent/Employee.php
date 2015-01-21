<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Cartalyst\Sentry\Groups\Eloquent\Group;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Employee extends BaseModel
{
    use SoftDeletingTrait;
    protected $table = "employees";

    protected $datas = ['deleted_at'];

    protected $sunday = [
                    'attendance' => 0,
                    'hours' => 0
                ];

    protected $fillable = [
        'user_id',
        // Basic Info
        'first_name',
        'last_name',
        'middle_name',
        'full_address',
        'birthdate',
        'gender',
        'marital_status',
        'spouse_name',

        // Employee Details

        'employee_type',
        'payroll_period',
        'job_position',
        'department',
        'sub_department_id',
        'role_id',
        'branch_id',
        'date_hired',
        'date_ended',
        'basic_pay',
        'timeshift_start',
        'timeshift_end',

        // Government Details

        'tin_number',
        'sss_number',
        'pagibig_number',
        'philhealth_number',
        'dependents',

        // Contact info

        'contact_number',
        'profile_picture',
        'fb',
        'email',
        'full_name',
        'employee_number',
        'rest_day'

    ];

    public function department()
    {
        return $this->belongsTo('Department', 'id', 'department');
    }
    public function name()
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    
    }

    public function getEmployeeID()
    {
        return createEmployeeID($this->id);
    }

    public function getEmployeeNumber()
    {
        return $this->employee_number;
    }

    public function getGroup()
    {

    }

    public function getDateHired()
    {
        return $this->date_hired;
    }
    public function getName()
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }

    public function getProfileLink()
    {
        return "/employees/" . $this->id . "/profile";
    }

    public function getRestDay()
    {
        switch ($this->rest_day) {
            case 0:
                return 'Sunday';
                break;
            case 1:
                return 'Monday';
                break;
            case 2:
                return 'Tuesday';
                break;
            case 3:
                return 'Wednesday';
                break;
            case 4:
                return 'Thursday';
                break;
            case 5:
                return 'Friday';
                break;
            case 6:
                return 'Staturday';
                break;

            default:
                return 'None';
                break;
        }
    }

    public function getFullAddress()
    {
        return $this->full_address;
    }
    public function getBirthdate($format = false)
    {
        if ($format) {return date('d M Y', strtotime($this->birthdate));
        }

        return $this->birthdate;
    }

    public function getAge()
    {
        $birthdate = new Carbon($this->birthdate);
        return $birthdate->age . 'yrs old';
    }

    public function getGender()
    {
        return $this->gender;
    }
    public function getMaritalStatus()
    {
        return $this->marital_status;
    }
    // Employee Details
    public function getEmployeeType()
    {
        $eid =  $this->employee_type;
    
        $employee_type = EmployeeType::find($eid);
        if($employee_type){
            return $employee_type->getName();
        }
        
        return 'None';
    }
    public function getEmployeeTypeId()
    {
        $eid =  $this->employee_type;
    
        $employee_type = EmployeeType::find($eid);
        if($employee_type){
            return $employee_type->id;
        }
        
        return 'None';
    }

    public function getTaxStatus()
    {
        $status = "";
        if ($this->marital_status == 'Single') {
            $dependents = (string) $this->dependents;
            $status     = 'S' . $dependents;
        } else if ($this->marital_status == 'Married') {
            $dependents = (string) $this->dependents;
            $status     = 'ME' . $dependents;
        }
        return $status;

    }

    public function getRole()
    {
        $group = Group::where('id', '=', $this->role_id)->first();
        if ($group) {
            return $group;
        } else {

            return 'None';
        }
    }

    public function getRoleName()
    {
        return ($this->getRole() == 'None') ? 'None' : $this->getRole()->name;
    }

    public function getContactNumber()
    {
        return $this->contact_number;
    }

    public function getFacebook()
    {
        return $this->fb;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSpouseName()
    {
        return $this->spouse_name;
    }

    public function getAllRoles()
    {
        $groups = Group::where('company_id', '=', COMPANY_ID)->get();
        // dd($groups);
        if(is_null($groups)){
            // dd('here');
            return null;
        }
        return $groups;
    }

    public function getPayrollPeriod($asObject = true)
    {
        $payroll_period = PayrollGroup::where('id', '=', $this->payroll_period)->first();
        if(is_null($payroll_period)){
            return null;
        }
        if($asObject){
            return $payroll_period;

        }

        return $payroll_period->period;
    }


    public function getPayrollPeriodName()
    {
        $payroll_period = PayrollGroup::where('id', '=', $this->payroll_period)->first();
            if(is_null($payroll_period)){
            return null;
        }
        return $payroll_period->group_name;
    }

    public function getJobPosition()
    {
            $job = Job_Position::find($this->job_position);
            // dd($job);
            if ($job) {
                return $job->job_position;
            }
            return 'None'; 

    }
    public function getDepartment()
    {
        $department = Department::find($this->department);
        if ($department) {
            return $department->department_name;
        }
        return 'none';
    }

    public function getSubDepartment()
    {
        $sub_department = SubDepartment::find($this->sub_department_id);
        if($sub_department){
            return $sub_department->sub_department_name;
        }
        return 'none';
    }

    public function getDependents()
    {
        return $this->dependents;
    }

    public function getDateEnded()
    {

        return ($this->deleted_at) ? date('Y-m-d', strtotime($this->deleted_at)) : 'Currently Employed';
    }
    public function getTin()
    {
        return (is_null($this->tin_number)) ? $this->tin_number : 'none';

    }
    public function getSSS()
    {

        return $this->sss_number;
    }
    public function getSSSValue($number_format = false, $term=1)
    {
        

        if ($this->deduct_sss == 1 || $this->deduct_sss == null) {
            if(strtolower($this->getPayrollPeriod()->period) == "daily"){
                return (float) $this->fixed_sss_amount;
            }
            $pay = (float) $this->getBasicPay(false);

            $first = SSSConfigs::orderby('monthly_salary_credit','asc')->first();
            $last  = SSSConfigs::orderby('monthly_salary_credit', 'desc')->first();
            if (strtolower($this->fixed_sss_amount) != "no"){
                return (float) $this->fixed_sss_amount;
            }
            if($first != null && $last != null) {

                if ($pay < $first->to_range) {
                    $sss = $first->EE;
                } else if ($pay > $last->to_range) {
                    $sss = $last->EE;
                } else {
                    $sss_count = SSSConfigs::where('to_range', '>=', $pay)->where('from_range', '<=', $pay)->count();
                    if($sss_count){
                       $sss =  SSSConfigs::where('to_range', '>=', $pay)->where('from_range', '<=', $pay)->first()->EE;
                    }
                    else{
                        $sss = $last->EE;
                    }
                    // dd($pay);
                }

                $sss = floatval($sss);

                if (str_replace(" ", "", strtolower($this->getPayrollPeriod()->period)) == "semi-monthly") {
                    if($term > 1){
                        // dd('curent term : ' . $term);
                        if($number_format == true){
                          return number_format($sss, 2);  
                        } 
                        return $sss;
                        
                    }
                    else{
                        $sss = 0;
                        if($number_format == true){
                          return number_format($sss, 2);  
                        } 
                        return $sss;
                    }
                } else {
                  
                    if($number_format == true){
                      return number_format($sss, 2);  
                    } 
                    return $sss;
                }
            } else {
                return (float) $this->fixed_sss_amount;
            }
        }
        return (int) 0;
    }

    public function getSSSEmployerValue($number_format = false, $term=1)
    {
        if(strtolower($this->getPayrollPeriod()->period) == "daily"){
            return (float) $this->fixed_sss_amount;
        }

        if ($this->deduct_sss == 1 || $this->deduct_sss == null) {
            $pay = (float) $this->getBasicPay(false);

            $first = SSSConfigs::orderby('monthly_salary_credit','asc')->first();
            $last  = SSSConfigs::orderby('monthly_salary_credit', 'desc')->first();
            if (strtolower($this->fixed_sss_amount) != "no"){
                return (float) $this->fixed_sss_amount;
            }
            if($first != null && $last != null) {
                if ($pay < $first->to_range) {
                    $sss = $first->ER;
                } else if ($pay > $last->to_range) {
                    $sss = $last->ER;
                } else {
                    $sss_count = SSSConfigs::where('to_range', '>=', $pay)->where('from_range', '<=', $pay)->count();
                    if($sss_count){
                       $sss =  SSSConfigs::where('to_range', '>=', $pay)->where('from_range', '<=', $pay)->first()->ER;
                    }
                    else{
                        $sss = $last->ER;
                    }
                    // dd($pay);
                }

                $sss = floatval($sss);

                if (str_replace(" ", "", strtolower($this->getPayrollPeriod()->period)) == "semi-monthly") {
                   if($term != 1){
                        if($number_format == true){
                          return number_format($sss, 2);  
                        } 
                        return $sss;
                        
                    }
                    else{
                        $sss = 0;
                        if($number_format == true){
                          return number_format($sss, 2);  
                        } 
                        return $sss;
                    }
                } else {
                  
                    if($number_format == true){
                      return number_format($sss, 2);  
                    } 
                    return $sss;
                }
            } else {
                return (float) $this->fixed_sss_amount;
            }
        }
        return (int) 0;
    }

    public function getPhilhealthNumber()
    {
        return $this->philhealth_number;
    }

    public function getPhilhealthValue($term = 1)
    {
        $period =  strtolower(str_replace(" ", "",$this->getPayrollPeriod()->period));
       
        if($this->fixed_philhealth_amount != "no"){
            return (float) $this->fixed_philhealth_amount;
        }

        if ($this->deduct_philhealth == 1 || $this->deduct_philhealth == null) {
            // dd('here');
            $pay = $this->getBasicPay(false);
            // dd($pay);
            $first = PHConfigs::orderby('salary_base', 'asc')->first();
            $last  = PHConfigs::orderby('salary_base', 'desc')->first();
            // dd($last);
          
                $pay = (float) $pay;
                if ($first && $last){
                    // dd($first->to_range);
                    if ($pay < (float)$first->to_range) {
                    // dd('here');
                        $ph = $first->employee_share;
                    } else if ($pay > (float)$last->to_range) {
                        $ph = $last->employee_share;
              
                    } else {
                        // return 'here';
                        $ph = PHConfigs::where('to_range', '>=', $pay)->where('from_range', '<=', $pay)->first()->employee_share;
                    }

                    $ph = floatval($ph);
                    if ( $period == "semi-monthly") {
                
                         if($term == 1){
                      
                        return $ph;
                        
                    }
                    else{
                        $ph = 0;
                       
                        return $ph;
                    }
                    } else {
                        return floatval($ph);
                    }
                } else {
                    return (int) $this->fixed_philhealth_amount;
                }
                
            
        }
        return (int) 0;

    }

    public function getHDMFValue($term=1, $number_format = false)
    {
        $hdmf = ($this->deduct_hdmf == null || $this->deduct_hdmf == 1)? 100 : 0;
        $period = str_replace(" ", "", strtolower($this->getPayrollPeriod()->period));

        $hdmf = (strtolower($this->fixed_hdmf_amount) != "no") ? (int) $this->fixed_hdmf_amount : $hdmf;
        if ($period == "semi-monthly") {
             if($term == 1){
                        if($number_format == true){
                          return number_format($hdmf, 2);  
                        } 
                        return $hdmf;
                        
                    }
                    else{
                        $hdmf = 0;
                        if($number_format == true){
                          return number_format($hdmf, 2);  
                        } 
                        return $hdmf;
                    }
        }

        return $hdmf;

    }

    public function getPagibig()
    {
        return $this->pagibig_number;
    }

    public function getProfilePicture()
    {
        if ($this->profile_picture == null || $this->profile_picture == 'none') {
            return '/img/user.jpg';
        } else {
            return '/media?image=' . $this->profile_picture;

        }
    }

    
    public function getBranch()
    {
        $branch = Branch::find($this->branch_id);
        
        if($branch){
            return $branch->branch_name;
        }
        return 'None';
    }

    public function getDocuments()
    {
        return Document::where('employee_id', '=', $this->id)->get();
    }

    public function getContributions()
    {

    }

    public function getDeductions($from = null, $to = null)
    {

        if ($from == null or $to == null) 
        {
            return EmployeeDeduction::where('employee_id', '=', $this->id)->get();
        }

        return EmployeeDeduction::where('employee_id', '=', $this->id)
            ->where('valid_from', '<=', $to)
            ->where('valid_to', '>=', $from)
            ->get();
    }

    public function getTotalDeductions($from = null, $to = null, $number_format = true)
    {
        $deductions = $this->getDeductions($from, $to);
        $total      = 0;
        foreach ($deductions as $deduction) 
        {
            $total += $deduction->amount;
        }

        if ($number_format) 
        {
            return number_format($total, 2);
        } 

        return $total;
    }

    public function getTotalAllowances($from = null, $to = null, $number_format = true)
    {
        $allowances = $this->getAllowances($from, $to);
        $total      = 0;

        foreach ($allowances as $allowance) {
            $total += $allowance->getAmount(false, $from, $to);
        }

        if(strtolower($this->getPayrollPeriod()->period) == "daily"){
            $total += $this->getColaPay($from, $to, "normal_day");
            $total += $this->getSEAPay($from, $to);
        }

        if ($number_format) {
            return number_format($total, 2);
        }

        return $total;

    }

    public function getGross($from, $to, $format = true)
    {
        $regular_holiday    = $this->getRegularHolidayPay($from, $to);
        $special_holiday    = $this->getSpecialHolidayPay($from, $to);
        $night_differential = $this->getNightDifferentialPay($from, $to);
        $rest_day_pay       = $this->getRestDayPay($from, $to)['not_holiday']; 
        $total_Allowance = 0;
        $total           = 0;
        $payset =  strtolower(str_replace(" ", "", $this->getPayrollPeriod()->period));
        $base_salary = ($payset == "daily") ? $this->getBasicSalary() * (float)$this->getInAttendance($from, $to) : $this->getBasicSalary();

        $total = $this->getTotalAllowances($from, $to, false) + $base_salary + $this->getOvertimePay($from, $to) + (float)$this->getSundayPay($from, $to, false);

        $total = $total + $regular_holiday + $special_holiday + $night_differential + $rest_day_pay;

        if ($format) {
            return number_format($total, 2);
        } else {

            return $total;
        }

    }

    public function getAllowances($from = null, $to = null)
    {

        if ($from == null or $to == null) {return EmployeeAllowance::where('employee_id', '=', $this->id)->get();
        }

        $allowance = EmployeeAllowance::where('employee_id', '=', $this->id)
                                                                       ->where('valid_from', '<=', $to)
                                                                       ->where('valid_to', '>=', $from)
                                                                       ->get();

        return $allowance;
    }

    public function getBasicPay($format = true, $from = null, $to = null)
    {
        $pay = BasicPayAdjustment::where('employee_id', '=', $this->id);
        if (count($this->getBasicPayAdjustments()) > 0) {
            if (is_null($from) && is_null($to)) {
                $pay = $pay->where('effective_date', '<=', date('Y-m-d'));

            } else {
                $pay = $pay
                // ->whereBetween('effective_date' [$from, $to])
                    ->where('effective_date', '<=', $from);

            }

            $adjustment = $pay->orderBy('id', 'desc')->first();

            if ($adjustment) {
                if ($format) {
                    return number_format($adjustment->new_basic_pay, 2, '.', ',');
                }

                return $adjustment->new_basic_pay;
            }
        }

        if ($format) {
            return number_format($this->basic_pay, 2, '.', ',');
        }

        return $this->basic_pay;

    }

    public function getBasicSalary($number_format = false)
    {
        $basic_salary = 0;
        $payset =  strtolower(str_replace(" ", "", $this->getPayrollPeriod()->period));
        // return $payset;
        switch ($payset) {
            case 'monthly':
                $basic_salary = $this->getBasicPay(false);
                break;
            case 'semi-monthly':
                $basic_salary = $this->getBasicPay(false) / 2;
                break;
            case 'daily':
                $basic_salary = $this->getBasicPay(false);
                break;
            default:
                # code...
                break;
        }
        // return $this->getBasicPay(false);
        if ($number_format) {
            // return $basic_salary;
            return number_format($basic_salary, 2);
        }

        return $basic_salary;
    }

    public function getBasicPayAdjustments($limit = 5, $skip = 0)
    {
        return BasicPayAdjustment::where('employee_id', '=', $this->id)->orderBy('id', 'desc')->take($limit)->skip($skip)->get();
    }

    public function getEntitledNightDifferential()
    {
        if ($this->entitled_night_differential) {return 'Yes';
        }

        return 'No';
    }
    public function getEntitledOvertimePay()
    {
        if ($this->entitled_overtime_pay) {return 'Yes';
        }

        return 'No';
    }
    public function getTimesheetRequired()
    {
        if ($this->timesheet_required) {return 'Yes';
        }

        return 'No';
    }

    public function getDeductSSS($english_format = true)
    {
        if ($english_format) {
            if ($this->deduct_sss) {return 'Yes';
            }

            return 'No';
        }

        return $this->deduct_sss;

    }

    public function getFixedSssAmount()
    {
        return $this->fixed_sss_amount;
    }

    public function getDeductHDMF($english_format = true)
    {
        if ($english_format) {
            if ($this->deduct_hdmf) {return 'Yes';
            }

            return 'No';
        }

        return $this->deduct_hdmf;
    }

    public function getFixedHdmfAmount()
    {
        return $this->fixed_hdmf_amount;
    }

    public function getDeductPhilhealth($english_format = true)
    {
        if ($english_format) {
            if ($this->deduct_philhealth) {return 'Yes';
            }
            return 'No';
        }

        return $this->deduct_philhealth;

    }

    public function getFixPhilhealthAmount()
    {
        return $this->fixed_philhealth_amount;
    }

    public function getUnderTimeDeductionRate($per_unit)
    {
        return getRate($this->getBasicSalary(), $this->getPayrollPeriod()->period, $per_unit);

    }

    public function getTimeShiftStart($military_format = false)
    {
        if ($military_format) 
        {
            return $this->timeshift_start;
        }

        return date('h:i a', strtotime($this->timeshift_start));
    }

    public function getTimeShiftEnd($military_format = false)
    {
        if ($military_format) {return $this->timeshift_end;
        }

        return date('h:i a', strtotime($this->timeshift_end));
    }

    public function getUnderTime($from, $to, $unit = 'minute')
    {
        $company        = $this->getCompany();
        $days           = createDateRangeArray($from, $to);
        $timeshift_ends = $this->getTimeShiftEnd(true);
        // $timeshift_ends = date('H-1:i', strtotime("-45 minutes",$timeshift_ends));
        $date                 = new DateTime($timeshift_ends);  
        $date_interval_string = 'PT' . $company->company_lunch_break . 'M';
            $date->sub(new DateInterval($date_interval_string));
        // dd($date->format('H:i:s'));
        // dd($timeshift_ends);
        $timeshift_ends = $date->format('H:i:s');
        $totalUnderTime = 0;
        foreach ($days as $day) {
            $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $day . ' 00:00:00');
            $endDate   = DateTime::createFromFormat('Y-m-d H:i:s', $day . ' 23:59:59');
            $absolute_day = DateTime::createFromFormat('Y-m-d', $day);
            $is_undertime_approved = Form_Application::where('form_type', 'undertime')->where('effective_date', $absolute_day)->count();

            $result = Timesheet::where('employee_id', '=', $this->id)
                                                                ->whereBetween('time_out', [$startDate, $endDate])->first();
            if ($result) {
                $resultDate = DateTime::createFromFormat('Y-m-d H:i:s', $result->time_out);



                $departure_time = $resultDate->format('H:i:s');
                // if($this->getTimeShiftEnd(true) > $departure_time) dd($resultDate);
                $undertime = getInterval($departure_time, $this->getTimeShiftEnd(true), $unit);
                $undertime = ($undertime >= 480) ? 480 : $undertime;
                if(!$is_undertime_approved){
                    $totalUnderTime += $undertime;                    
                }

            }
        }
        // dd($totalUnderTime);
        return $totalUnderTime;
    }

    public function getUnderTimeDeduction($from, $to, $unit, $number_format = false)
    {
        // dd($this->getUnderTime($from, $to, $unit));
        $undetime_deduction = floatval($this->getUnderTime($from, $to, $unit) * $this->getUnderTimeDeductionRate($unit));
        // dd($undetime_deduction);
        if ($number_format) {return number_format($undetime_deduction, 2);}

        return $undetime_deduction;
    }

    /**
     * return number late of an employee in a given date range and return the specified unit
     * @param  [type] $from
     * @param  [type] $to
     * @param  string $unit (minute|hours)
     * @return [int]
     */
    public function getLateDeduction($from, $to, $unit = 'minute')
    {
        if($this->getTimesheetRequired() == 'No'){
            return 0;
        }    

        $days           = createDateRangeArray($from, $to);
        $timeShiftStart = $this->getTimeShiftStart(true);
        // dd($timeShiftStart);
        $totalLate = 0;

        foreach ($days as $day) {
            $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $day . ' 00:00:00');
            $endDate   = DateTime::createFromFormat('Y-m-d H:i:s', $day . ' 23:59:59');

            $result = Timesheet::where('employee_id', '=', $this->id)
                                                                ->whereBetween('time_in', [$startDate, $endDate])->first();
            // dd($result);
            if ($result) {
                $resultDate = DateTime::createFromFormat('Y-m-d H:i:s', $result->time_in);

                $arrival_time = $resultDate->format('H:i:s');
                $late         = getInterval($this->getTimeShiftStart(true), $arrival_time, $unit);
                if ($late > $this->getCompany()->company_late_grace_period) {
                    $totalLate += $late;
                }

            }
        }
        // dd($totalLate);

        $totalLate = $totalLate + $this->getUnderTime($from, $to, 'minute');

        if($unit == "hour"){
            // return gmdate("H:i", ($totalLate * 60));
            return $totalLate/60;
        }

        return $totalLate;
    }

    /**
     * get the late deduction of an employee from a given date range
     * @param  [string/date] $from
     * @param  [string/date] $to
     * @param  [string] $unit (minute|hours)
     * @return [float]
     */
    // public function getLateDeduction($from, $to, $unit, $number_format = false)
    // {
    //     // dd($this->getLate($from, $to, $unit));

    //     $late_deduction = floatval($this->getLate($from, $to, $unit) * $this->getUnderTimeDeductionRate($unit));
    //     if ($number_format) {return number_format($late_deduction, 2);
    //     }

    //     return $late_deduction;
    // }

    public function getUnderTimeAndLateDeduction($from, $to, $unit, $number_format = false)
    {
        $total = floatval($this->getLateDeduction($from, $to, $unit)/60);
        $total = $total*$this->getHourlyRate();
        if ($number_format) {return number_format($total, 2);
        }

        return $total;
    }
    public function getSalaryComputations($from, $to)
    {
        $salary = intval($this->getBasicSalary());

        $dependents = $this->dependents;
        $period     = $this->period;

        $sss_val = $this->fixed_sss_amount == null ? getSSS($salary)['EE'] : (int) $this->fixed_sss_amount;

        $philhealth_val = $this->fixed_philhealth_amount == null ? getPH($salary)['Employee_Share'] : (int) $this->fixed_philhealth_amount;

        $pagibig_val = $this->fixed_hdmf_amount == null ? 100 : (int) $this->fixed_hdmf_amount;

        // return $curr_salary;
        $absents = $this->getAbsentDeduction($from, $to);

        $overtime = $this->getOvertimePay($from, $to);

        $curr_salary = ($salary + $overtime)-($sss_val + $philhealth_val + $pagibig_val + $absents);

        $widthholding_tax = $this->getWTax($curr_salary, $period, $dependents);

        $deductions = ($sss_val + $philhealth_val + $pagibig_val + intval($this->getTotalDeductions()) + $absents);

        $total_deductions = $deductions + $widthholding_tax;

        $net = intval($this->getGross($from, $to, false)) - $total_deductions;

        return array(
            'gross'            => number_format($salary, 2),
            'widthholding_tax' => number_format($widthholding_tax, 2),
            'philhealth'       => number_format($philhealth_val, 2),
            'SSS'              => number_format($sss_val, 2),
            'pagibig'          => number_format($pagibig_val, 2),
            'basic'            => number_format($salary, 2),
            'taxable'          => number_format($curr_salary, 2),
            'total_deduc'      => number_format($total_deductions, 2),
            'net'              => number_format($net, 2)
        );

    }

    /**
     * return overtime pay rate
     * @return [float]
     */
    public function getOverTimePayRate($type="normal")
    {
        switch ($type) {
            case 'regular_holiday':
                $ot_pay = $this->getCompany()->company_regular_holiday_overtime_pay/100;
                $ot_pay = $ot_pay + 1;
                $regular_holiday_pay = $this->getRegularHolidayRate() + 1;
                $overtime_pay = $ot_pay * $regular_holiday_pay;
                break;
            case 'special_holiday':
                $ot_pay = $this->getCompany()->company_special_holiday_overtime_pay/100;
                $ot_pay = $ot_pay + 1;
                $regular_holiday_pay = $this->getSpecialHolidayRate() + 1;
                $overtime_pay = $ot_pay * $regular_holiday_pay;
                break;
            default:
                $overtime_pay = $this->getCompany()->company_overtime_pay/100;
                $overtime_pay = $overtime_pay + 1;
                break;
        }
        if ($this->entitled_overtime_pay) {
            if ($this->overtime_pay_rate && $this->overtime_pay_rate > 0) {
                $rate = str_replace('%', '', $this->overtime_pay_rate) / 100;
                // $nrate = 1 + $rate;
                return $rate + 1;
            } else {
                return  $overtime_pay;
            }
        }
        return 0;
    }
    /**
     * return total overtime of an employee from a given date range
     * @param  [date/string] $from
     * @param  [date/string] $to
     * @return [int]
     */
    public function getOvertime($from, $to, $type = 'all')
    {
        $holiday = new \HolidayRepository();
        $total_overtime = 0;
        $from           = date('Y-m-d H:i:s', strtotime($from));
        $to             = date('Y-m-d H:i:s', strtotime($to));


        $overtimes = Form_Application::where('employee_id', '=', $this->id)
                                      ->where('form_type', '=', 'ot')
                                      ->where('status', '=', 'approved')
                                      ->whereBetween('from', [$from, $to])
                                      ->get();

        foreach ($overtimes as $ot) {
            $date_from = date('Y-m-d', strtotime($ot->from));
  
            switch ($type) {
                case 'special_holiday':
                    if($holiday->isSpecialHoliday($date_from)):
                        $ot_to   = new Carbon($ot->to);
                        $ot_from = new Carbon($ot->from);
                        $diff    = $ot_to->diffInHours($ot_from);
                        $total_overtime += $ot->getFormData()->total_hrs;  
                    endif;                 
                    break;
                case 'regular_holiday':
                    if($holiday->isRegularHoliday($date_from)):
                        $ot_to   = new Carbon($ot->to);
                        $ot_from = new Carbon($ot->from);
                        $diff    = $ot_to->diffInHours($ot_from);
                        $total_overtime += $ot->getFormData()->total_hrs;
                    endif;
                    break;
                case 'normal':
                    if(!$holiday->isRegularHoliday($date_from) && !$holiday->isSpecialHoliday($date_from)):
                        $ot_to   = new Carbon($ot->to);
                        $ot_from = new Carbon($ot->from);
                        $diff    = $ot_to->diffInHours($ot_from);
                        $total_overtime += $ot->getFormData()->total_hrs;
                    endif;
                    break;
                default:

                        $ot_to   = new Carbon($ot->to);
                        $ot_from = new Carbon($ot->from);
                        $diff    = $ot_to->diffInHours($ot_from);
                        $total_overtime += $ot->getFormData()->total_hrs;
                    break;
            }

        }

        return $total_overtime;
    }

    /**
     * return overtime pay of an employee from a given date range
     * @return [float]
     */
    public function getOvertimePay($from, $to)
    {
        // dd($this->getOvertime($from, $to, 'regular_holiday'));
        $normal = floatval($this->getOverTimePayRate('normal') * $this->getOvertime($from, $to, 'normal') * $this->getHourlyRate());
        $regular_holiday = floatval($this->getOverTimePayRate('regular_holiday') * $this->getOvertime($from, $to, 'regular_holiday') * $this->getHourlyRate());
        $special_holiday = floatval($this->getOverTimePayRate('special_holiday') * $this->getOvertime($from, $to, 'special_holiday') * $this->getHourlyRate());
        return $normal + $regular_holiday + $special_holiday;
    
    }

    public function getHourlyRate()
    {
        $basic_pay      = $this->getBasicSalary();
        $payroll_period = $this->getPayrollPeriod()->period;
        ;

        return getRate($basic_pay, $payroll_period, 'hour');

    }
    /**
     * return Daily Rate of an employee
     * @return [int]
     */
    public function getDailyRate($number_format = true)
    {
        $basic_pay      = $this->getBasicSalary();
        $payroll_period = $this->getPayrollPeriod()->period;

        return getRate($basic_pay, $payroll_period, 'daily', $number_format);

    }
    public function getSemiMonthlyRate($number_format = false)
    {
        $basic_pay      = $this->getBasicSalary();
        $payroll_period = $this->getPayrollPeriod()->period;
        ;
        // if ($number_format) {return number_format($basic_pay, 2);
        // }

        // return $basic_pay;
        return getRate($basic_pay, $payroll_period, 'Semi-monthly', $number_format);
    }
    public function getMonthlyRate($number_format = false)
    {
        $basic_pay      = $this->getBasicSalary($number_format);
        $payroll_period = $this->getPayrollPeriod()->period;
        return getRate($basic_pay, $payroll_period, 'Monthly', $number_format);
    }

    // public function getTotalMonthlyRate($number_format = true)
    // {
    //     $totalMRs = $this->getMonthlyRate(true);
    //     return $totalMRs;
    // }
    /**
     * returns the night differential of certian employee from the given date range
     * @param  [type] $from
     * @param  [type] $to
     * @param  string $unit (minute|hours)
     * @return [int]
     */
    public function getNightly($from, $to, $unit = 'minute')
    {

        $from = DateTime::createFromFormat('Y-m-d H:i:s', $from . ' 00:00:00');
        $to   = DateTime::createFromFormat('Y-m-d H:i:s', $to . ' 23:59:59');

        $attendances = Timesheet::whereBetween('time_in', [$from, $to])
            ->where('employee_id', $this->id)
            ->get();
        // dd($attendances);
        $night_diff_start = date('H:i', strtotime('22:00:00'));
        $night_diff_end   = date('H:i', strtotime('10:00:00'));

        $total_night_difference = 0;

        foreach ($attendances as $attendance) {
            $time_in_day   = date('Y-m-d', strtotime($attendance->time_in));
            $time_out_day  = date('Y-m-d', strtotime($attendance->time_out));
            $time_in_hours = date('H:i', strtotime($attendance->time_in));
            // dd($time_out_day);
            if ($time_in_day == $time_out_day && ($time_in_hours < '22:00')) {
                $day = date('Y-m-d', strtotime($attendance->time_in));
                $date = new DateTime($day);
                $date->sub(new DateInterval('P1D'));
                $day2 = $date->format('Y-m-d');
            } else {
                $day  = date('Y-m-d', strtotime($attendance->time_in));
                $date = new DateTime($day);
                $date->add(new DateInterval('P1D'));
                $day2 = $date->format('Y-m-d');
            }

            // var_dump($day, $day2);
            $night_diff_start = date('Y-m-d H:i', strtotime($day . ' 22:00:00'));
            $night_diff_end   = date('Y-m-d H:i', strtotime($day2 . ' 06:00:00'));
            $time_in          = date('Y-m-d H:i', strtotime($attendance->time_in));
            $time_out         = date('Y-m-d H:i', strtotime($attendance->time_out));

            // var_dump($time_in, $time_out);
            // var_dump($night_diff_start, $night_diff_end);

            /*
            Night Differential 

            time_in > 10pm and timeout is less than 6am
            eg : 11pm - 4pm
             */

            if ($time_in >= $night_diff_start && $time_out < $night_diff_end) {

                $interval = getInterval($attendance->time_in, $attendance->time_out, $unit);
                $total_night_difference += $interval;

            } 
            /*
                time_in > 10pm but timeout is greater than or equal to 6am
                eg : 11pm - 7am

             */
            
            else if ($time_in >= $night_diff_start && $time_out >= $night_diff_end) {

                $interval = getInterval($attendance->time_in, '06:00', $unit);
                $total_night_difference += $interval;
            } 
            /*
                time_in < 10pm but timeout is less than 6am.

             */

            else if ($time_in < $night_diff_start &&  $time_out < $night_diff_end) {
            
                $interval         = getInterval($night_diff_start, $time_out, $unit);
                $total_night_difference += $interval;

            } else if ($time_in < $night_diff_start && $time_out >= $night_diff_end) {
                $interval = getInterval($night_diff_start, $night_diff_end, $unit);
                $total_night_difference += $interval;
            }

        }
    
        return $total_night_difference;

    }
    /**
     * Night Differential Rate of an Employee
     * @return [float]
     */
    public function getNightlyRate()
    {
        if ($this->entitled_night_differential) {
            if ($this->night_differential_rate) {
                $rate = str_replace('%', '', $this->night_differential_rate) / 100;
                // $nrate = 1 + $rate;
                return $this->getHourlyRate() * $rate;
            } else {
                return $this->getHourlyRate() * 0.1;
            }
        }

        return 0;
    }
    /**
     * Night Diffrential for the certain date range
     * @param  [string/date] $from
     * @param  [string/date] $to
     * @param  [string] $unit (minute|hours)
     * @return [int]
     */
    public function getNightDifferentialPay($from, $to, $unit = 'min')
    {
        $nightly_hours = $this->getNightly($from, $to, 'minute')/60;
        return floatval($nightly_hours * $this->getNightlyRate());
    }

    public function getNightDifferentialHours($from, $to){
       return (int) $this->getNightly($from, $to, 'minute')/60;
    }

    public function getRegularHolidayRate()
    {
        return $this->getCompany()->company_regular_holiday_pay/100;
    }



    /**
     * Regular Holiday Rate
     * @param  [date/string] $from
     * @param  [date/string] $to
     * @return [float] total regular holiday pay
     */
    public function getRegularHolidayPay($from, $to)
    {
        // return $this->getRegularHolidayRate();
        // $pay =  floatval($this->getRegularHolidayRate() * $this->getHourlyRate() * $this->getRegularHolidayAttendance($from, $to)) + floatval($this->getRestDayPay($from, $to)['regular_holiday']);
        $pay =  floatval($this->getRegularHolidayRate() * $this->getHourlyRate() * $this->getRegularHolidayAttendance($from, $to));

        if(strtolower($this->getPayrollPeriod()->period) == "daily"){
            $pay += $this->getColaPay($from, $to);
        }

        return $pay;

    }

    public function getColaPay($from, $to, $type="regular_holiday")
    {
        $holiday_rate = $this->getRegularHolidayRate();
        
        if($type == "normal_day")
        {
            return floatval($this->getColaCount($from, $to, "normal_day") * $this->getCompany()->company_cola); 
        }    

        return floatval($holiday_rate * $this->getColaCount($from, $to, "regular_holiday") * $this->getCompany()->company_cola);
    }

    public function getSEAPay($from, $to)
    {
         $val =floatval($this->getSEACount($from, $to) * $this->getCompany()->company_sea); 
        // dd($val);
        return $val;
    }

    public function getColaCount($from, $to, $type="regular_holiday")
    {
        $regular_holiday_attendance = $this->getRegularHolidayAttendance($from, $to, "not_rest_day_attendance");
        if($type == "normal_day"){
            return $this->getInAttendance($from, $to) - $regular_holiday_attendance; 
        }
        return $regular_holiday_attendance;
    }

    public function getSEACount($from, $to)
    {
        return $this->getInAttendance($from, $to);
    }


    /**
     * special holiday rate
     * @return [float]
     */
    public function getSpecialHolidayRate($number_format = true)
    {
        // $daily_rate = floatval($this->getDailyRate());
        return $this->getCompany()->company_special_holiday_pay/100;

    }
    /**
     * total regular attendance from date range given
     * @param  [date/string] $from
     * @param  [date/string] $to
     * @return [int]
     */
    public function getRegularHolidayAttendance($from, $to, $extra_feature = "all")
    {
        $holiday = new \HolidayRepository();

        $date_range = createDateRangeArray($from, $to);
        $rest_day_attendance = 0;
        $not_rest_day_attendance = 0;
        $hours_attended = 0;
        foreach ($date_range as $date) {
            $date_2 = $date;
            if(strtotime($this->timeshift_start) > strtotime($this->timeshift_end)){
                $day = new DateTime($date);
                $day->add(new DateInterval('P1D'));
                $date_2 = $day->format('Y-m-d');
            }
            $date_range_start = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->timeshift_start));
            $date_range_end   = date('Y-m-d H:i:s', strtotime($date_2 . ' ' . $this->timeshift_end));
    
            $dt = new Carbon($date);

            $current_date = date('Y-m-d', strtotime($date_range_start));
            if ($holiday->isRegularHoliday($current_date)){
                $attended = Timesheet::where('employee_id', '=', $this->id)
                                    ->whereBetween('time_in', [$date_range_start, $date_range_end])
                                    ->first();

                if($attended) 
                {
                  // dd($attended);
                  if($dt->dayOfWeek == $this->rest_day){
                    $rest_day_attendance++;
                     }
                    else{ 
                    $not_rest_day_attendance++;
                     }
                    // return $attended(;
                   // dd($attended);
                    $time_in = date('Y-m-d H:i:s', strtotime($attended->time_in));
                    // $in = $time_in->format('H:i:s');
                    $time_out = date('Y-m-d H:i:s', strtotime($attended->time_out));
                    // $out = $time_out->format('H:i:s');
                    $h = getInterval($time_in, $time_out, 'hours');
                    $hours_attended += $h;
                }
            }
        }

        if($extra_feature == "rest_day_attendance") { return $rest_day_attendance; }
        if($extra_feature == "not_rest_day_attendance") { return $not_rest_day_attendance; }
        return (int) $hours_attended;
    }



    /**
     * total special holiday attendance from date range given
     * @param  [string/date] $from
     * @param  [string/date] $to
     * @return int
     */
    public function getSpecialHolidayAttendance($from, $to)
    {
          $holiday = new \HolidayRepository();

        $date_range = createDateRangeArray($from, $to);
             // dd($date_range);
        $hours_attended = 0;
        foreach ($date_range as $date) {
            $date_2 = $date;
            if(strtotime($this->timeshift_start) > strtotime($this->timeshift_end)){
                $day = new DateTime($date);
                $day->add(new DateInterval('P1D'));
                $date_2 = $day->format('Y-m-d');
            }
            $date_range_start = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->timeshift_start));
            $date_range_end   = date('Y-m-d H:i:s', strtotime($date_2 . ' ' . $this->timeshift_end));
            // dd($date_range_start, $date_range_end);
            $dt = new Carbon($date);

            $current_date = date('Y-m-d', strtotime($date_range_start));
            if ($holiday->isSpecialHoliday($current_date)){
                $attended = Timesheet::where('employee_id', '=', $this->id)
                                    ->whereBetween('time_in', [$date_range_start, $date_range_end])
                                    ->first();

                if($attended) 
                {
                    $time_in = date('Y-m-d H:i:s', strtotime($attended->time_in));
                    // $in = $time_in->format('H:i:s');
                    $time_out = date('Y-m-d H:i:s', strtotime($attended->time_out));
                    // $out = $time_out->format('H:i:s');
                    $h = getInterval($time_in, $time_out, 'hours');
                    $hours_attended += $h;
                }
            }
        }

        return (int) $hours_attended;
    }

    /**
     *  Special Holiday Pay
     * @param (string/date) $from
     * @param (string/date) $to
     * @return (float) total pay for special holidays
     */

    public function getSpecialHolidayPay($from, $to)
    {
        return floatval($this->getSpecialHolidayRate() * $this->getHourlyRate() * $this->getSpecialHolidayAttendance($from, $to))  + floatval($this->getRestDayPay($from, $to)['special_holiday']);
    }

    public function getRestDayAttendance($from, $to, $type="all")
    {
         $holiday = new \HolidayRepository();
       $date_range = createDateRangeArray($from, $to);
       
       $in_attendance = 0;
       $special_holiday_attendance = 0;
       $regular_holiday_attendance = 0;
       $normal_day_attendance = 0;

       foreach ($date_range as $date) {
            $date_range_start = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->timeshift_start));
            $date_range_end   = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->timeshift_end));
            
            $dt = new Carbon($date);
            $current_date = date('Y-m-d', strtotime($date_range_start));

            if($dt->dayOfWeek == $this->rest_day) {
                
                $current_date = date('Y-m-d', strtotime($date_range_start));

                if($dt->dayOfWeek == $this->rest_day){
                    $attended = Timesheet::where('employee_id', '=', $this->id)
                                        ->whereBetween('time_in', [$date_range_start, $date_range_end])
                                        ->count();
                    if($attended){
                        if($holiday->isSpecialHoliday($current_date)){
                            $special_holiday_attendance++;
                        }
                        else if($holiday->isRegularHoliday($current_date)){
                            $regular_holiday_attendance++;
                        }
                        else {
                            $normal_day_attendance++;
                        }                        
                    }


                    
                }                
            }
       }


       switch ($type) {
           case 'all':
               # code...
               break;
           case 'not_holiday':
               return $normal_day_attendance;
               break;
            case 'regular_holiday':
                return $regular_holiday_attendance;
                break;
            case 'special_holiday':
                return $special_holiday_attendance;
                break;
           default:
               # code...
               break;
       }

    }

    public function getRestDayPay($from, $to)
    {
        $holiday = new \HolidayRepository();

        $date_range = createDateRangeArray($from, $to);
        
        $in_attendance = 0;
        $special_holiday_attendance = 0;
        $regular_holiday_attendance = 0;
        $not_holiday_attendance = 0;
        foreach ($date_range as $date) {
            $date_range_start = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->timeshift_start));
            $date_range_end   = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->timeshift_end));
            
            $dt = new Carbon($date);
            $current_date = date('Y-m-d', strtotime($date_range_start));

            if($dt->dayOfWeek == $this->rest_day){
                $attended = Timesheet::where('employee_id', '=', $this->id)
                                    ->whereBetween('time_in', [$date_range_start, $date_range_end])
                                    ->count();
                if($attended){
                if($holiday->isSpecialHoliday($current_date)){
                    $special_holiday_attendance++;
                }
                else if($holiday->isRegularHoliday($current_date)){
                    $regular_holiday_attendance++;
                }
                else{
                    $not_holiday_attendance++;
                }                    
                }

                
            }
            
        }

        $regular_holiday_rate = $this->getCompany()->company_regular_holiday_rest_pay/100;
        $special_holiday_rate = $this->getCompany()->company_special_holiday_rest_pay/100;
        $rest_rate            = $this->getCompany()->company_rest_pay/100;

        // Regular Holiday +60%
        $regular_holiday_pay = $regular_holiday_attendance * ($regular_holiday_rate * $this->getDailyRate(false));
        // Special Holiday Attendance = +20%
        $special_holiday_pay = $special_holiday_attendance * ($special_holiday_rate * $this->getDailyRate(false));
        $not_holiday         = $not_holiday_attendance * ($rest_rate * $this->getDailyRate(false));
        
        return array(
                'regular_holiday' => $regular_holiday_pay,
                'special_holiday' => $special_holiday_pay,
                'not_holiday'     => $not_holiday
            );
    }

    public function getSundayAttendance($from, $to)
    {

        $holiday = new \HolidayRepository();

        $date_range = createDateRangeArray($from, $to);
        
        $in_attendance = 0;
        foreach ($date_range as $date) {
            $date_range_start = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->timeshift_start));
            $date_range_end   = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->timeshift_end));
            
            $dt = new Carbon($date);

            if($dt->dayOfWeek == Carbon::SUNDAY){
                $attended = Timesheet::where('employee_id', '=', $this->id)
                                    ->whereBetween('time_in', [$date_range_start, $date_range_end])
                                    ->count();
                if($attended) 
                {
                    $in_attendance++;
                }
            }


            
        }

        return $in_attendance;
    }

    public function getSundayAttendanceHours($from, $to)
    {
        $date_range = createDateRangeArray($from, $to);
       
        $hours_attended = 0;
        foreach ($date_range as $date) {
            $date_range_start = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->timeshift_start));
            $date_range_end   = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->timeshift_end));
            
            $dt = new Carbon($date);

            if($dt->dayOfWeek == Carbon::SUNDAY){
                $attended = Timesheet::where('employee_id', '=', $this->id)
                                    ->whereBetween('time_in', [$date_range_start, $date_range_end])
                                    ->first();
                if($attended) 
                {
                    // return $attended;
                    // dd($attended);
                    $time_in = DateTime::createFromFormat('Y-m-d H:i:s', $attended->time_in);
                    $in = $time_in->format('H:i:s');
                    $time_out = DateTime::createFromFormat('Y-m-d H:i:s', $attended->time_out);
                    $out = $time_out->format('H:i:s');
                    $h = getInterval($in, $out, 'hours');
                    // dd($h);
                    $hours_attended += getInterval($in, $out, 'hours');
                }
            }


            
        }

        return $hours_attended;      
    }

    public function getSundayPayRate()
    {
        $sunday_rate = $this->getCompany()->company_sunday_rate/100;
        $sunday_rate = 1 + $sunday_rate;
        return $sunday_rate * $this->getHourlyRate();
    }

    public function getSundayPay($from, $to, $format = false)
    {
        $sp = $this->getSundayAttendanceHours($from, $to) * $this->getSundayPayRate();
        if($format){
            return number_format($sp, 2);
        }
        return $sp;
    }

    public function getInAttendance($from, $to, $weekend_include = true)
    {
       
        $holiday = new \HolidayRepository();

        $date_range = createDateRangeArray($from, $to);
        // dd($date_range);
        $in_attendance = 0;
        foreach ($date_range as $date) {
            $date_2 = $date;
            if(strtotime($this->timeshift_start) > strtotime($this->timeshift_end)){
                $day = new DateTime($date);
                $day->add(new DateInterval('P1D'));
                $date_2 = $day->format('Y-m-d');
            }
            // dd($date, $date_2);
            $date_range_start = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->timeshift_start));
            $date_range_end   = date('Y-m-d H:i:s', strtotime($date_2 . ' ' . $this->timeshift_end));
            // dd($date_range_start, $date_range_end);
            $dt = new Carbon($date);

         
                $attended = Timesheet::where('employee_id', '=', $this->id)
                                    ->whereBetween('time_in', [$date_range_start, $date_range_end])
                                    ->count();
                

                if($attended) 
                {
                    $in_attendance++;
                }

            
        }
        // dd($total_absent);
       return $in_attendance;
    }

    /**
     * total absent from range given
     * @param  [type]  $from
     * @param  [type]  $to
     * @param  boolean $weekend_include
     * @return int
     */
    public function getAbsent($from, $to, $weekend_include = false)
    {
        // dd($from, $to);
        $holiday = new \HolidayRepository();

        $total_absent = 0;
        if (!$this->timesheet_required || strtolower($this->getPayrollPeriod()->period) == "daily") {
            // dd('here');
            return 0;
        }

        $date_range = createDateRangeArray($from, $to);

        foreach ($date_range as $date) {
            $date_range_start = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->timeshift_start));
            $date_range_end   = date('Y-m-d H:i:s', strtotime($date . ' ' . $this->timeshift_end));
            // dd($date_range_start, $date_range_end);
            $dt = new Carbon($date);

            if ($dt->isWeekend() && $weekend_include) {

                $attended = Timesheet::where('employee_id', '=', $this->id)
                                                                      ->whereBetween('time_in', [$date_range_start, $date_range_end])
                                                                      ->count();

                if ($attended) {

                    $total_absent += 1;
                }
            } else if ($dt->isWeekday()) {
                $attended = Timesheet::where('employee_id', '=', $this->id)
                                                                      ->whereBetween('time_in', [$date_range_start, $date_range_end])
                                                                      ->count();
                $forms = Form_Application::where('employee_id', '=', $this->id)
                                                                          ->whereIn('form_type', ['ob', 'ot', 'leave'])
                                                                          ->whereBetween('from', [$date_range_start, $date_range_end])
                                                                          ->where('status', '=', 'approved')
                                                                          ->count();
                $current_date = date('Y-m-d', strtotime($date_range_start));
                if (!$holiday->isHoliday($current_date) && !$attended && !$forms) {
                    $total_absent += 1;
                }

            }
        }
        // dd($total_absent);
        return $total_absent;
    }
    /**
     * getAbsentDeduction - get total Absent deduction
     * @param  [type]  $from
     * @param  [type]  $to
     * @param  boolean $weekend_include
     * @return [float]
     */
    public function getAbsentDeduction($from, $to, $weekend_include = false, $number_format = false)
    {

        $total = $this->getDailyRate(false) * $this->getAbsent($from, $to, $weekend_include);
        if ($number_format) {
            return number_format($total, 2);
        }
        if($this->getTimesheetRequired() == 'No'){
            return 0;
        }
        return floatval($total);

    }

    public function getTotalMandatoryDeductions($from, $to, $term=1)
    {
        $sss              = $this->getSSSValue(false,$term);
        $ph               = $this->getPhilhealthValue($term);
        $hdmf             = $this->getHDMFValue($term);
        $absents          = $this->getAbsentDeduction($from, $to);
        $late             = $this->getLateDeduction($from, $to, 'minute');
        $undertime        = $this->getUnderTimeDeduction($from, $to, 'minute');
        $widthholding_tax = $this->getWithholdingTax($from, $to, false);

        return $sss + $ph + $hdmf + $widthholding_tax + $late + $absents + $undertime;
    }

    public function getWithholdingTaxType()
    {
        return $this->withholding_tax_type;
    }

    public function getExpandedWithholdingTax($forcomputation = false)
    {
        if ($forcomputation) {
            return $this->expanded_withholding_tax / 100;
        }

        return $this->expanded_withholding_tax;
    }

    public function getWithholdingTax($from, $to, $number_format = true)
    {
        // dd($this->withholding_tax_type);
        $absents = $this->getAbsentDeduction($from, $to);
        $late    = $this->getUnderTimeAndLateDeduction($from, $to, 'minute');

        $overtime           = $this->getOvertimePay($from, $to);
        $regular_holiday    = $this->getRegularHolidayPay($from, $to);
        $special_holiday    = $this->getSpecialHolidayPay($from, $to);
        $night_differential = $this->getNightDifferentialPay($from, $to);

        $sss_val = $this->getSSSValue();

        $philhealth_val = $this->getPhilhealthValue();
        $pagibig_val    = $this->getHDMFValue();
        $basic_pay      = $this->getBasicSalary();

        $curr_salary = ($basic_pay + $overtime + $regular_holiday + $special_holiday + $night_differential)-($sss_val + $philhealth_val + $pagibig_val + $absents + $late);
        // return $curr_salary;
        if ($this->withholding_tax_type == "Expanded") {
            $wtax = $this->getExpandedWithholdingTax(true) * $curr_salary;
        } else {
            // return 'here';
            $wtax = $this->getTax($curr_salary, $this->getPayrollPeriod()->period, $this->dependents);
        }
        return $wtax;   
        $wtax = ($wtax > 0) ? $wtax : 0;

        if ($number_format) {
            return number_format($wtax, 2);
        }
        
        return $wtax;

    }

    public function getTax($pay, $period, $dependents)
    {
        // dd($period);
        // dd($pay);
         $period =  strtolower(str_replace(" ", "", $period));
         // dd($period);
        $WTConfigs = WTConfigs::get();

        $first = WTConfigs::where('period', '=', strtolower($period))
                ->where('dependents', '=', $dependents)->orderby('from_range', 'asc')->first();
        $last  = WTConfigs::where('period', '=', strtolower($period))
                ->where('dependents', '=', $dependents)->orderby('from_range', 'desc')->first();
        $wtax  = [];
        if (count($first) > 0 && $pay < $first->to_range) {
            $wtax = $first;
        } else if (count($last) > 0 && $pay > $last->to_range) {
            $wtax = $last;
        } else {
            $wtax = WTConfigs::where('period', '=', strtolower($period))
                ->where('dependents', '=', $dependents)
                ->where('to_range', '>=', $pay)->where('from_range', '<=', $pay)->first();
                // dd($wtax);
        }

        $wt = (($pay - $wtax['to_range']) * $wtax['status']+$wtax['exemption']);
        // dd($wt);
        // 
        $wt = ($wt < 0) ? 0 : $wt;
        return $wt;
    }

    public function getAllandTotalDeduction($from, $to, $number_format = true, $term = 1)
    {

        $basic_pay = $this->getBasicPay(false);

        $total_loan_deduction = $this->getTotalDeductions($from, $to, false);

        $total_mandatory_deduction = $this->getTotalMandatoryDeductions($from, $to, $term);

        $absents = $this->getAbsentDeduction($from, $to);
        dd($total_mandatory_deduction, $total_loan_deduction);
        $mandatory_wtax = $total_mandatory_deduction + $total_loan_deduction;
     
        return $mandatory_wtax;
    }
    public function getNet($from, $to, $number_format = true)
    {

        $basic_pay = $this->getBasicPay(false);

        $total_loan_deduction = $this->getTotalDeductions($from, $to, false);

        $total_mandatory_deduction = $this->getTotalMandatoryDeductions($from, $to);

        $absents = $this->getAbsentDeduction($from, $to);

        $mandatory_wtax = $total_mandatory_deduction + $total_loan_deduction;

        $gross = $this->getGross($from, $to, false);

        $remaining_pay = $gross - $mandatory_wtax;

        $net = $remaining_pay;

        if ($number_format) {
            return number_format($net, 2);
        }
        return $net;
    }
    /**
     * Get List of Certificates
     * @return object-array
     */

    public function getCertificates()
    {
        $id           = $this->id;
        $certificates = Document::where('employee_id', '=', $id)->where('document_type', '=', 'certificate')->get();
        return $certificates;
    }

    /**
     * Get List of Trainings
     */

    public function getTrainings()
    {
        $id           = $this->id;
        $certificates = Training::where('employee_id', '=', $id)->orderBy('status', 'desc')->orderBy('from', 'desc')->get();
        return $certificates;

    }
    public function getRemainingCredits($type)
    {

        $form_count = Form_Application::where('employee_id', '=', $this->id)
                                                                       ->where('form_type', '=', $type)
                                                                       ->where('status', '=', 'approved')->count();
        $company_leave_credits = Company::where('id', '=', $this->company_id)->first()->company_leave_credits;

        $remaining_credits = intval($company_leave_credits) - intval($form_count);

        return $remaining_credits;

    }

    public function getCompany()
    {
        return Company::find($this->company_id);
    }

    public function getCompanyName()
    {
        return $this->getCompany()->company_name;
    }

    public function getGeneratedPayslips($from, $to)
    {
        // var_dump($from, $to);
        $payroll_group = PayslipsGroup::whereBetween('from', [$from, $to])->get();

        $output = [];

        // if(count($payroll_group) > 0){
        //     dd($payroll_group);
        // }

        // var_dump($payroll_group);
        foreach ($payroll_group as $group) {
            $payslip = Payslips::where('payslip_group_id', '=', $group->id)->where('employee_id', '=', $this->id)->first();
            if (is_null($payslip)) {

            } else {
                // var_dump('here');
                array_push($output, $payslip);

            }
        }

        return $output;

    }

    public function getGeneratedWtax($from, $to)
    {
        $total = 0;
        // var_dump($this->getGeneratedPayslips($from, $to));
        if (is_array($this->getGeneratedPayslips($from, $to))) {
            foreach ($this->getGeneratedPayslips($from, $to) as $payslip) {

                $total += $payslip->withholding_tax;
            }

        }

        return $total;
    }

    public function getGeneratedSSSEmployee($from, $to)
    {
        $total = 0;
        // var_dump($this->getGeneratedPayslips($from, $to));
        if (is_array($this->getGeneratedPayslips($from, $to))) {
            foreach ($this->getGeneratedPayslips($from, $to) as $payslip) {

                $total += $payslip->sss;
            }

        }

        return $total;
    }

    public function getGeneratedSSSEmployer($from, $to)
    {
        $total = 0;
        // var_dump($this->getGeneratedPayslips($from, $to));
        if (is_array($this->getGeneratedPayslips($from, $to))) {
            foreach ($this->getGeneratedPayslips($from, $to) as $payslip) {
                
                $total += $payslip->sss_employer;
            }

        }

        return $total;
    }

    public function getGeneratedSSSEC($from, $to)
    {
        $total = 0;
        if(is_array($this->getGeneratedPayslips($from, $to)))
        {
            foreach ($this->getGeneratedPayslips($from, $to) as $payslip) {
                $total += $payslip->ec;
            }
        }

        return $total;
    }

    public function getGeneratedPhilhealth($from, $to)
    {
         $total = 0;
        // var_dump($this->getGeneratedPayslips($from, $to));
        if (is_array($this->getGeneratedPayslips($from, $to))) {
            foreach ($this->getGeneratedPayslips($from, $to) as $payslip) {
                
                $total += $payslip->philhealth;
            }

        }

        return $total;
    }

    public function getGeneratedPagibig($from, $to)
    {
         $total = 0;
        // var_dump($this->getGeneratedPayslips($from, $to));
        if (is_array($this->getGeneratedPayslips($from, $to))) {
            foreach ($this->getGeneratedPayslips($from, $to) as $payslip) {
                
                $total += $payslip->pagibig;
            }

        }

        return $total;
    }

    public function getSubordinates()
    {
        $output = array();
        $departments = Department::where('department_head_id', $this->id)->lists('id');
        foreach($departments as $department){
            $employees = Employee::where('department', $department)->lists('id');
            foreach ($employees as $employee) {
                
                array_push($output, $employee);
            }
        }
        return $output;
    }

    public function getSubordinatesApplications()
    {
        return Form_Application::whereIn('employee_id', $this->getSubordinates())->get();

    }

    public function isDepartmentHead()
    {
        return (boolean) Department::where('department_head_id', $this->id)->count();
    }

    public function getRemainingLeaveCredit($leave_type_id)
    {
        return EmployeeLeaveCredit::getEmployeeRemainingCredits($this->id, $leave_type_id);
    }

}
