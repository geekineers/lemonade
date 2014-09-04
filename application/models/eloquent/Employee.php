<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

// use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Cartalyst\Sentry\Groups\Eloquent\Group;

class Employee extends BaseModel
{
    // use SoftDeletingTrait;
    protected $table = "employees";

    // protected $datas = ['deleted_at'];

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
        'role_id',
        'branch_id',
        'date_hired',
        'date_ended',
        'basic_pay',

        // Government Details

        'tin_number',
        'sss_number',
        'pagibig_number',
        'dependents',

        // Contact info

        'contact_number',
        'profile_picture',
        'fb',
        'email',

    ];

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
        return $this->employee_type;
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

    public function getAllRoles()
    {
        $groups = Group::all();
        return $groups;
    }

    public function getPayrollPeriod()
    {
        return PayrollGroup::where('id','=',$this->payroll_period)->first();
    }

    public function getJobPosition()
    {
        try {
            $job = Job_Position::find($this->job_position);
            if ($job) {
                return $job->job_position;
            }
        } catch (Exception $e) {
            return $e;
        }

    }
    public function getDepartment()
    {
        return Department::find($this->department)->department_name;
    }
    public function getDateEnded()
    {
        return $this->date_ended;
    }
    public function getTin()
    {
        return $this->tin_number;
    }
    public function getSSS()
    {

        return $this->sss_number;
    }
    public function getSSSValue()
    {
        return $this->deduct_sss == null ? getSSS($this->getBasicPay(false))['EE'] : (int) $this->fixed_sss_amount;
    }

    public function getPhilhealthValue()
    {
        return $this->deduct_philhealth == null ? getPH($this->getBasicPay(false))['Employee_Share'] : (int) $this->fixed_philhealth_amount;
    }

    public function getHDMFValue()
    {
        return $this->deduct_hdmf == null ? 100 : (int) $this->fixed_hdmf_amount;
    }

    public function getPagibig()
    {
        return $this->pagibig_number;
    }

    public function getProfilePicture()
    {
        if ($this->profile_picture == null) {
            return '/img/unknown_user.jpeg';
        } else {
            return '/media?image=' . $this->profile_picture;

        }
    }
    public function getBranch()
    {
        return Branch::find($this->branch_id)->branch_name;
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

        if ($from == null or $to == null) {return EmployeeDeduction::where('employee_id', '=', $this->id)->get();
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
        foreach ($deductions as $deduction) {
            $total += $deduction->amount;
        }

        if ($number_format) {return number_format($total, 2);
        }

        return $total;
    }

    public function getTotalAllowances($from = null, $to = null, $number_format = true)
    {
        $allowances = $this->getAllowances($from, $to);
        $total      = 0;

        foreach ($allowances as $allowance) {
            $total += $allowance->amount;
        }

        if ($number_format) {
            return number_format($total, 2);
        }

        return $total;

    }

    public function getGross($from, $to, $format = true)
    {

        $total_Allowance = 0;
        $total           = 0;

        $total = $this->getTotalAllowances($from, $to, false) + $this->getBasicPay(false) +  $this->getOvertime($from, $to) ;

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

    public function getBasicPay($format = true)
    {
        if (count($this->getBasicPayAdjustments()) > 0) {
            $adjustment = BasicPayAdjustment::where('effective_date', '<=', date('Y-m-d'))->orderBy('id', 'desc')->first();

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

    public function getDeductHDMF($english_format = true)
    {
        if ($english_format) {
            if ($this->deduct_hdmf) {return 'Yes';
            }

            return 'No';
        }

        return $this->deduct_hdmf;
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

    public function getUnderTimeDeductionRate($per_unit)
    {
        return getRate($this->basic_pay, $this->payroll_period, $per_unit);

    }

    public function getTimeShiftStart($military_format = false)
    {
        if ($military_format) {return $this->timeshift_start;
        }

        return date('h:i a', strtotime($this->timeshift_start));
    }

    public function getTimeShiftEnd($military_format = false)
    {
        if ($military_format) {return $this->timeshift_end;
        }

        return date('h:i a', strtotime($this->timeshift_end));
    }

    /**
     * return number late of an employee in a given date range and return the specified unit
     * @param  [type] $from
     * @param  [type] $to
     * @param  string $unit (minute|hours)
     * @return [int]
     */
    public function getLate($from, $to, $unit = 'minute')
    {
        $days           = createDateRangeArray($from, $to);
        $timeShiftStart = $this->getTimeShiftStart(true);
        // dd($timeShiftStart);
        $totalLate = 0;

        foreach ($days as $day) {
            $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $day . ' 00:00:00');
            $endDate   = DateTime::createFromFormat('Y-m-d H:i:s', $day . ' 23:59:59');

            $result = Timesheet::whereBetween('time_in', [$startDate, $endDate])->first();
            // dd($result);
            if ($result) {
                $resultDate = DateTime::createFromFormat('Y-m-d H:i:s', $result->time_in);

                $arrival_time = $resultDate->format('H:i:s');
                $late         = getInterval($this->getTimeShiftStart(true), $arrival_time, $unit);

                $totalLate += $late;

            }
        }
        // dd($totalLate);

        return $totalLate;
    }

    /**
     * get the late deduction of an employee from a given date range
     * @param  [string/date] $from
     * @param  [string/date] $to
     * @param  [string] $unit (minute|hours)
     * @return [float]
     */
    public function getLateDeduction($from, $to, $unit)
    {
        return floatval($this->getLate($from, $to, $unit) * $this->getUnderTimeDeductionRate($unit));
    }

    public function getSalaryComputations($from, $to)
    {
        $salary     = intval($this->getBasicPay(false));
        $dependents = $this->dependents;
        $period     = $this->period;

        $sss_val = $this->fixed_sss_amount == null ? getSSS($salary)['EE'] : (int) $this->fixed_sss_amount;

        $philhealth_val = $this->fixed_philhealth_amount == null ? getPH($salary)['Employee_Share'] : (int) $this->fixed_philhealth_amount;

        $pagibig_val = $this->fixed_hdmf_amount == null ? 100 : (int) $this->fixed_hdmf_amount;

        // return $curr_salary;
        $absents = $this->getAbsentDeduction($from, $to);

        $overtime = $this->getOvertime($from, $to);

        $curr_salary = ($salary + $overtime)-($sss_val + $philhealth_val + $pagibig_val + $absents);

        $widthholding_tax = getWTax($curr_salary, $period, $dependents);

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
    public function getOverTimePayRate()
    {
        if ($this->entitled_overtime_pay) {
            if ($this->overtime_pay_rate) {
                $rate = str_replace('%', '', $this->overtime_pay_rate) / 100;
                // $nrate = 1 + $rate;
                return $this->getHourlyRate() * $rate;
            } else {
                return $this->getHourlyRate() * 0.1;
            }
        }

    }
    /**
     * return total overtime of an employee from a given date range
     * @param  [date/string] $from
     * @param  [date/string] $to
     * @return [int]
     */
    public function getOvertime($from, $to)
    {
        $total_overtime = 0;
        $from           = date('Y-m-d H:i:s', strtotime($from));
        $to             = date('Y-m-d H:i:s', strtotime($to));

        $overtimes = Form_Application::where('employee_id', '=', $this->id)
                                                                      ->where('form_type', '=', 'ot')
                                                                      ->where('status', '=', 'approved')
                                                                      ->whereBetween('from', [$from, $to])
                                                                      ->get();

        foreach ($overtimes as $ot) {
            $ot_to   = new Carbon($ot->to);
            $ot_from = new Carbon($ot->from);
            $diff    = $ot_to->diffInHours($ot_from);
            $total_overtime += $diff;
        }

        return $total_overtime;
    }

    /**
     * return overtime pay of an employee from a given date range
     * @return [float]
     */
    public function getOvertimePay()
    {
        return floatval($this->getOverTimePayRate() * $this->getOvertime());
    }

    public function getHourlyRate()
    {
        $basic_pay      = $this->basic_pay;
        $payroll_period = $this->payroll_period;

        return getRate($basic_salary, $payroll_period, 'hour');

    }
    /**
     * return Daily Rate of an employee
     * @return [int]
     */
    public function getDailyRate($number_format = true)
    {
        $basic_pay      = $this->basic_pay;
        $payroll_period = $this->payroll_period;

        return getRate($basic_pay, $payroll_period, 'daily', $number_format);

    }
    public function getSemiMonthlyRate()
    {
        $basic_pay      = $this->basic_pay;
        $payroll_period = $this->payroll_period;

        return getRate($basic_pay, $payroll_period, 'Semi-Monthly');
    }
    public function getMonthlyRate()
    {
        $basic_pay      = $this->basic_pay;
        $payroll_period = $this->payroll_period;

        return getRate($basic_pay, $payroll_period, 'Monthly');
    }

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

        $night_diff_start = date('H:i', strtotime('22:00:00'));
        $night_diff_end   = date('H:i', strtotime('10:00:00'));

        $total_night_difference = 0;

        foreach ($attendances as $attendance) {
            $time_in_day   = date('Y-m-d', strtotime($attendance->time_in));
            $time_out_day  = date('Y-m-d', strtotime($attendance->time_out));
            $time_in_hours = date('H:i', strtotime($attendance->time_in));

            if ($time_in_day == $time_out_day && ($time_in_hours < '22:00')) {
                $day2 = date('Y-m-d', strtotime($attendance->time_in));
                $date = new DateTime($day2);
                $date->sub(new DateInterval('P1D'));
                $day = $date->format('Y-m-d');
            } else {
                $day  = date('Y-m-d', strtotime($attendance->time_in));
                $date = new DateTime($day);
                $date->add(new DateInterval('P1D'));
                $day2 = $date->format('Y-m-d');
            }

            $night_diff_start = date('Y-m-d H:i', strtotime($day . ' 22:00:00'));
            $night_diff_end   = date('Y-m-d H:i', strtotime($day2 . ' 06:00:00'));
            $time_in          = date('Y-m-d H:i', strtotime($attendance->time_in));
            $time_out         = date('Y-m-d H:i', strtotime($attendance->time_out));

            if ($time_in >= $night_diff_start || $time_in < $night_diff_end) {
                $interval = getInterval($attendance->time_in, $attendance->time_out, $unit);
                $total_night_difference += $interval;

            } else if ($time_in >= $night_diff_start || $time_in >= $night_diff_end) {
                $interval = getInterval($attendance->time_in, '06:00', $unit);
                $total_night_difference += $interval;
            } else if ($time_in < $night_diff_start && ($time_out >= $night_diff_start || $time_out <= $night_diff_end)) {
                $night_diff_start = date('Y-m-d H:i', strtotime('2014-01-01 22:00'));
                $time_out         = date('Y-m-d H:i', strtotime('2014-01-01: 22:00'));
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
    public function getNightDifferentialPay($from, $to, $unit)
    {
        return floatval($this->getNightly($from, $to, $unit) * $this->getNightlyRate());
    }

    public function getRegularHolidayRate()
    {
        return $this->getDailyRate();
    }
    /**
     * Regular Holiday Rate
     * @param  [date/string] $from
     * @param  [date/string] $to
     * @return [float] total regular holiday pay
     */
    public function getRegularHolidayPay($from, $to)
    {
        return floatval($this->getRegularHolidayRate() * $this->getRegularHolidayAttendance($from, $to));

    }
    /**
     * special holiday rate
     * @return [float]
     */
    public function getSpecialHolidayRate()
    {
        $daily_rate = floatval($this->getDailyRate());
        return $daily_rate * 0.3;
    }
    /**
     * total regular attendance from date range given
     * @param  [date/string] $from
     * @param  [date/string] $to
     * @return [int]
     */
    public function getRegularHolidayAttendance($from, $to)
    {
        $from = date('Y-m-d', strtotime($from));
        $to   = date('Y-m-d', strtotime($to));

        return Holiday::whereBetween('holiday_from', [$from, $to])
            ->where('holiday_type', 'regular')
            ->count();
    }

    /**
     * total special holiday attendance from date range given
     * @param  [string/date] $from
     * @param  [string/date] $to
     * @return int
     */
    public function getSpecialHolidayAttendance($from, $to)
    {
        $from = date('Y-m-d', strtotime($from));
        $to   = date('Y-m-d', strtotime($to));
        return Holiday::whereBetween('holiday_from', [$from, $to])
            ->where('holiday_type', 'special non-working')
            ->count();

    }

    /**
     *  Special Holiday Pay
     * @param (string/date) $from
     * @param (string/date) $to
     * @return (float) total pay for special holidays
     */

    public function getSpecialHolidayPay($from, $to)
    {
        return floatval($this->getSpecialHolidayRate() * $this->getSpecialHolidayAttendance($from, $to));
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
        $total_absent = 0;
        if (!$this->getTimesheetRequired()) {

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
            } else if($dt->isWeekday()) {
                $attended = Timesheet::where('employee_id', '=', $this->id)
                                       ->whereBetween('time_in', [$date_range_start, $date_range_end])
                                       ->count();
                $forms = Form_Application::where('employee_id', '=', $this->id)
                                         ->whereIn('form_type', ['ob', 'ot', 'leave'])
                                         ->whereBetween('from', [$date_range_start, $date_range_end])
                                         ->where('status', '=', 'approved')
                                         ->count();

                if (!$attended && !$forms) {
                    $total_absent += 1;
                }

            }
        }
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
        return floatval($total);

    }

    public function getTotalMandatoryDeductions($from, $to)
    {
        $sss              = $this->getSSSValue();
        $ph               = $this->getPhilhealthValue();
        $hdmf             = $this->getHDMFValue();
        $absents = $this->getAbsentDeduction($from,$to);
        $late    = $this->getLateDeduction($from, $to, 'minute');
        $widthholding_tax = $this->getWithholdingTax($from,$to,false);
        
        
        return $sss + $ph + $hdmf + $widthholding_tax + $late  +$absents ;
    }

    public function getWithholdingTax($from, $to, $number_format = true)
    {

        
        $absents = $this->getAbsentDeduction($from,$to);
        $late    = $this->getLateDeduction($from, $to, 'minute');
        $overtime =  $this->getOvertime($from,$to);
        $sss_val = $this->getSSSValue();

        $philhealth_val = $this->getPhilhealthValue();
        $pagibig_val    = $this->getHDMFValue();
        $basic_pay      = $this->getBasicPay(false);

        $curr_salary = ($basic_pay + $overtime) - ($sss_val + $philhealth_val + $pagibig_val + $absents +  $late);
        
        $wtax        = getWTax($curr_salary, $this->period, $this->dependents);

        if ($number_format) {
            return number_format($wtax, 2);
        }
        return $wtax;

    }

    public function getAllandTotalDeduction($from, $to, $number_format = true)
    {
        $basic_pay                 = $this->getBasicPay(false);

        $total_loan_deduction      = $this->getTotalDeductions($from, $to, false);


        $total_mandatory_deduction = $this->getTotalMandatoryDeductions($from, $to);

        $absents                   = $this->getAbsentDeduction($from,$to);

        $mandatory_wtax            =  $total_mandatory_deduction  +  $total_loan_deduction ;
         if ($number_format) {
            return number_format($mandatory_wtax, 2);
        }
        
        return $mandatory_wtax;
    }
    public function getNet($from, $to, $number_format = true)
    {

        $basic_pay                 = $this->getBasicPay(false);

        $total_loan_deduction      = $this->getTotalDeductions($from, $to, false);


        $total_mandatory_deduction = $this->getTotalMandatoryDeductions($from, $to);

        $absents                   = $this->getAbsentDeduction($from,$to);

        $mandatory_wtax            =  $total_mandatory_deduction  +  $total_loan_deduction ;
       
        $gross                     = $this->getGross($from, $to, false);

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
        
       
        $form = EmployeeCredits::where('employee_id','=',$this->id)
                                    ->where('credit_name','=',$type)
                                    ->first();
        

        if($form==null)
        {
            return 'N/A';
        }
        else
        {
            return $form->remaining_credits;
        }
    }

    public function getUnderTime()
    {

    }

}
