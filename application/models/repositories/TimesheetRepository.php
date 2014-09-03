<?php
use Timesheet as Timesheet;

class TimesheetRepository extends BaseRepository
{
    protected $employeeRepository;

    public function __construct()
    {
        $this->class              = new Timesheet();
        $this->employeeRepository = new EmployeeRepository();
    }

    public function timeIn($sentry_user, $employee_id = null)
    {

        $cookie      = $_COOKIE['cartalyst_sentry'];
        $employee_id = ($employee_id == null) ? $this->employeeRepository->getLoginUser($sentry_user)->id : $employee_id;
        $user        = $sentry_user;
        $current     = date('Y-m-d H:i:s');

        $data = [
            'employee_id'     => $employee_id,
            'source'          => 'Payroll Login',
            'time_in'         => $current,
            'cookie_registry' => $cookie

        ];

        $this->create($data);

        return true;

    }

    public function timeOut()
    {
        $cookie  = $_COOKIE['cartalyst_sentry'];
        $current = date('Y-m-d H:i:s');
        $this->where('cookie_registry', '=', $cookie)->update(['time_out' => $current]);
        return true;
    }

    public function getLoginTime()
    {

    }

    public function saveTime($employee_id, $timestart, $timeend, $from, $to)
    {

        $cookie   = $_COOKIE['cartalyst_sentry'];
        $time_in  = date('Y-m-d H:i:s', strtotime($from . ' ' . $timestart));
        $time_out = date('Y-m-d H:i:s', strtotime($to . ' ' . $timeend));
        $source   = "Manual Input";
        $data     = [
            'employee_id'     => $employee_id,
            'source'          => $source,
            'time_in'         => $time_in,
            'time_out'        => $time_out,
            'cookie_registry' => $cookie
        ];

        $this->create($data);
        return true;
    }
    public function updateTime($timesheet_id, $employee_id, $timestart, $timeend, $from, $to)
    {

        $cookie   = $_COOKIE['cartalyst_sentry'];
        $time_in  = date('Y-m-d H:i:s', strtotime($from . ' ' . $timestart));
        $time_out = date('Y-m-d H:i:s', strtotime($to . ' ' . $timeend));
        $source   = "Manual Input";
        $data     = [
            'employee_id'     => $employee_id,
            'source'          => $source,
            'time_in'         => $time_in,
            'time_out'        => $time_out,
            'cookie_registry' => $cookie
        ];

        $this->update($data, $timesheet_id);
        return true;
    }
/**
 * Get All Timesheet in a given Date Range
 * @param  [date] $from        [description]
 * @param  [date] $to          [description]
 * @param  [int] $employee_id [description]
 * @return [object array]              [description]
 */
    public function getByRange($from, $to, $employee_id = null)
    {
        $from = date('Y-m-d', strtotime($from));
        $to   = date('Y-m-d', strtotime($to));

        if ($employee_id == null) {
            return $this->whereBetween('time_in', [$from, $to])->get();
        }

        return $this->whereBetween('time_in', [$from, $to])
                    ->where('employee_id', '=', $employee_id)
                    ->get();
    }

}
