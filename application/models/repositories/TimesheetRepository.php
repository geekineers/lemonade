<?php
use Timesheet as Timesheet;
use Upload\Storage\FileSystem as FileSystem;

class TimesheetRepository extends BaseRepository
{
    protected $employeeRepository;

    public function __construct()
    {
        $this->class              = new Timesheet();
        $this->employeeRepository = new EmployeeRepository();
        $path                     = realpath(APPPATH . '../uploads/');
        $this->fileSystem         = new FileSystem($path);
    }

    public function record($data)
    {
     $time_in = DateTime::createFromFormat('Y-m-d H:i:s', $data['time_in']);

     $arrival_time = $time_in->format('H:i:s');
     $employee = $this->employeeRepository->find($data['employee_id']);
     $late         = getInterval($employee->getTimeShiftStart(true), $arrival_time, 'minute');
     $is_late = ($late > $employee->getCompany()->company_late_grace_period)  ? true :false;

      $time_out = DateTime::createFromFormat('Y-m-d H:i:s', $data['time_out']);

      $departure_time = $time_out->format('H:i:s');
        // if($this->getTimeShiftEnd(true) > $departure_time) dd($resultDate);
      var_dump("Departure Time  : " .  $departure_time);
      var_dump("Timeshift End Time  : " .  $employee->getTimeShiftEnd(true));
      $undertime = getInterval($departure_time, $employee->getTimeShiftEnd(true), 'minute');
      // dd($undertime);
      // dd($undertime);
      $undertime = ($undertime >= 480) ? 480 : $undertime;
      $is_undertime = ($undertime > 0) ? true : false;


      $data['status'] = (isset($data['status'])) ? $data['status'] : 'good';
      
      if($is_late){
        $data['status'] = 'late';
      }
      else if($is_undertime)
      {
        $data['status'] = 'undertime';
      }

      if(!isset($data['time_out'])){
        $data['status'] = 'current';
      }


      $existing = $this->where('employee_id', $data['employee_id'])
                        ->where(function($query) use($time_in, $time_out){
                                 $query->where(function($query) use($time_in, $time_out){
                                   $query->where('time_in', '<=', $time_in )
                                         ->where('time_in', '>=', $time_in);

                                })
                                 ->orWhere(function($query) use($time_in, $time_out){

                                   $query->where('time_out', '<=', $time_out )
                                         ->where('time_out', '>=', $time_out);
                              });
                        })->first();
                  
      if($existing){
            // $existing->get();
            $existing->fill($data);
            $existing->save();
            return true; 
      }
      else{
           $this->create($data);
           return true;
        
      }

    }

    public function timeIn($sentry_user, $employee_id = null)
    {

        $cookie      = $_COOKIE['cartalyst_sentry'];
        $employee_id = ($employee_id == null) ? $this->employeeRepository->getLoginUser($sentry_user)->id : $employee_id;
        $user        = $sentry_user;
        $current     = date('Y-m-d H:i:s');

        $this->employeeRepository->find($employee_id);

        $data = [
            'employee_id'     => $employee_id,
            'source'          => 'Payroll Login',
            'time_in'         => $current,
            'cookie_registry' => $cookie

        ];

        $time_in = $this->record($data);

        // dd($time_in->id);

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


        // dd($data);
        $this->record($data);
        return true;
    }
    public function updateTime($timesheet_id, $employee_id, $timestart, $timeend, $from, $to)
    {

        $cookie    = $_COOKIE['cartalyst_sentry'];
        $timestart = date('H:i:s', strtotime($timestart));
        $timeend   = date('H:i:s', strtotime($timeend));

        $time_in = date('Y-m-d H:i:s', strtotime($from . ' ' . $timestart));

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

    public function search($query = null, $from = null, $to = null)
    {
        $employees = ($query == null) ? null : $this->employeeRepository->searchGetId($query);
        // dd($employees);
        return $this->getByRange($from, $to, $employees);
    }

/**
 * Get All Timesheet in a given Date Range
 * @param  [date] $from        [description]
 * @param  [date] $to          [description]
 * @param  [int|array] $employee_id [description]
 * @return [object array]              [description]
 */
    public function getByRange($from = null, $to = null, $employee_id = null)
    {
        // dd($from, $to);
        $from   = (is_null($from) || $from == "") ? date('Y-m-d', strtotime('2000-01-01')) : date('Y-m-d', strtotime($from));
        $to     = (is_null($to) || $to == "") ? date('Y-m-d') : date('Y-m-d', strtotime($to));
        $search = $this;
        // dd($employee_id);
        if ($employee_id != null || $employee_id != "NULL") {
            if (is_array($employee_id)) {

                $search = $search->whereIn('employee_id', $employee_id);
            } else if (!is_array($employee_id) && $employee_id != null) {
                $search = $search->where('employee_id', '=', $employee_id);
            }

        }

        return $search->whereBetween('time_in', [$from, $to])
                      ->orderBy('time_in', 'desc')
                      ->get();
        // dd($s);
    }

    public function uploadByBatch($data)
    {
        get_instance()->load->library('excel');

        $file = new \Upload\File('excel_file', $this->fileSystem);
        // $filename = 'none';
        $path = realpath(APPPATH . '../uploads/');
        // if ($file->isOk()) {
        $filename = $path . '/add_timesheet.xlsx';
        if (file_exists($filename)) {
            unlink($filename);

        }

        $file->setName('add_timesheet');
        $file->upload();
        // }
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(false);

        $objPHPExcel = $objReader->load($filename);

        $objWorksheet = $objPHPExcel->getActiveSheet(0);

        $highestRow    = $objWorksheet->getHighestRow();// e.g. 10
        $highestColumn = $objWorksheet->getHighestColumn();// e.g 'F'

        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);// e.g. 5

        $timesheet_infos = [];

        for ($index = 0, $row = 2; $row <= $highestRow; ++$row) {
            // var_dump(''$index);
            for ($col = 0; $col <= $highestColumnIndex; ++$col) {
              
                    $timesheet_infos[$index][$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
              
            }
            $index++;
        }

        // dd($timesheet_infos);
        foreach ($timesheet_infos as $timesheet_info) {
            $employee = $this->employeeRepository->where('employee_number', '=', $timesheet_info[0])                        
                                                 ->first();

            if ($employee == null) {
                continue;
            } else {

                $time_in = date('H:i:s', strtotime($timesheet_info[2]));
                $date_in = date('Y-m-d', strtotime($timesheet_info[1]));

                $time_out = date('H:i:s', strtotime($timesheet_info[4]));
                $date_out = date('Y-m-d', strtotime($timesheet_info[3]));


                $employee_id = $employee->id;
                $timestart   = $time_in;
                $timeend     = $time_out;
                $from        = $date_in;
                $to          = $date_out;
                
                $this->saveTime($employee_id, $timestart, $timeend, $from, $to);

            }
        }
    }

}
