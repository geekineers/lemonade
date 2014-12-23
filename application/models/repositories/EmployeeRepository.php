<?php

require_once APPPATH . '/libraries/excel.php';

use Employee as Employee;
use Upload\Storage\FileSystem as FileSystem;
use Respect\Validation\Validator as Validator;

class EmployeeRepository extends BaseRepository
{
    use ValidableTrait;

    protected $rules = [
        'first_name'        => 'required',
        'last_name'         => 'required',
        'dependents'        => 'numeric|required',
        'marital_status'    => 'required',
        'birthdate'         => 'date|required',
        'gender'            => 'required',
        'employee_type'     => 'numeric|required',
        'branch_id'         => 'numeric|required',
        'job_position'      => 'numeric|required',
        'department'        => 'numeric|required',
        'payroll_period'    => 'numeric|required',
        'date_hired'        => 'date|required',
        'basic_pay'         => 'required'
   ];

    protected $fileSystem;
    public function __construct()
    {
        $this->class      = new Employee();
        $path             = realpath(APPPATH . '../uploads/');
        $this->fileSystem = new FileSystem($path);
    }

    public function checkEmployeeTypeChanged($data, $input)
    {
        if($data['employee_type'] == $input['employee_type']){
            return array(
                'status' => true,
                'message' => 'Employee Type changed from ' . $data['employee_type'] . ' to ' . $input['employee_type']
            );
        }

        return array('status' => false, 'message' => null);
    }

    public function getAllEmployeesJSON()
    {

        $employees = $this->all();
        $items     = array('employees' => array());

        foreach ($employees as $employee) {
            $employee = [
                'id'              => $employee->id,
                'name'            => $employee->getName(),
                'position'        => $employee->getJobPosition(),
                'profile_picture' => $employee->getProfilePicture()
            ];
            array_push($items['employees'], $employee);
        }
        // dd($items);
        return $items;
    }

    public function getAllPermissions()
    {
        // dd(get_instance()->sentry->getUser());
        get_instance()->config->load('user_permissions');
        return get_instance()->config->item('permissions');
    }

    public function updateEmployee201($employee_id, $data, $sentry)
    {
        $id = $data['employee_type'];
        $user = EmployeeType::where('id', '=', $id)->first();
        $emptype = $user->employee_type_name;
        if(strtolower($emptype) == "inactive")
        {
            $toBeDeleted = Employee::where('id', '=', $employee_id);
            $toBeDeleted->delete();
            return redirect('employees');
        }
        
        $post = array(
            'first_name'     => toTitleCase($data['first_name']),
            'last_name'      => toTitleCase($data['last_name']),
            'middle_name'    => toTitleCase($data['middle_name']),
            'full_name'      => toTitleCase($data['first_name']) . ' ' . toTitleCase($data['middle_name']) . ' ' . toTitleCase($data['last_name']),
            'full_address'   => $data['full_address'],
            'birthdate'      => $data['birthdate'],
            'gender'         => $data['gender'],
            'marital_status' => $data['marital_status'],
            'employee_number' => createEmployeeID($employee_id),
            // 'spouse_name' => $data['spouse_name'],
            'dependents' => (int) $data['dependents'],

            // Employee Details
            'employee_type'   => $data['employee_type'],
            'payroll_period'  => $data['payroll_period'],
            'job_position'    => (int) $data['job_position'],
            'department'      => (int) $data['department'],
            'sub_department_id'      => (int) $data['sub_department'],
            'role_id'         => (int) $data['role_id'],
            'branch_id'       => (int) $data['branch_id'],
            'date_hired'      => $data['date_hired'],
            'timeshift_start' => date("H:i:s", strtotime($data['timeshift_start'])),
            'timeshift_end'   => date("H:i:s", strtotime($data['timeshift_end'])),
            // 'basic_pay' => $data['basic_pay'],

            // Government Details
            'tin_number'        => $data['tin_number'],
            'sss_number'        => $data['sss_number'],
            'pagibig_number'    => $data['pagibig_number'],
            'philhealth_number' => $data['philhealth_number'],
        );
        $employee = $this->where('id', '=', $employee_id);
        $first = $employee->first();
        foreach($post as $field => $value) {
            if ( strcmp($post[$field], $first->{$field}) == 0 || strcmp($field, 'full_name') == 0 ) 
            {
                continue;
            }

            $statement = "Updated " . $field . " from " . $first->{$field} . " to " . $post[$field];

            History::create(array(
                'action'      => $statement,
                'employee_id' => $first->id,
                'company_id'  => $first->company_id
            ));
        }
        $employee_data = $employee->first()->toArray();
        $employee_type_changed = $this->checkEmployeeTypeChanged($employee_data, $post);

        $update = $employee->update($post);
        if($update)
        {
                                
            try {
                $user = $sentry->findUserById($employee->first()->id);

                foreach ($user->getGroups() as $group) {

                    $group = $sentry->findGroupById($group['id']);
                    $user->removeGroup($group);
                }

                $group = $sentry->findGroupById($data['role_id']);
                $user->addGroup($group);
            } 
            catch(Exception $e)
            {
            
            }
        }
    }

    public function createEmployee($data, $sentry)
    {

        // Basic Info
        $first_name     = toTitleCase($data['first_name']);
        $last_name      = toTitleCase($data['last_name']);
        $middle_name    = toTitleCase($data['middle_name']);
        $full_name      = $first_name . ' ' . $middle_name . ' ' . $last_name;
        $full_address   = $data['full_address'];
        $birthdate      = $data['birthdate'];
        $gender         = $data['gender'];
        $marital_status = $data['marital_status'];
        $spouse_name    = $data['spouse_name'];
        $dependents     = (int) $data['dependents'];

        // Employee Details
        $employee_type   = $data['employee_type'];
        $payroll_period  = $data['payroll_period'];
        $job_position    = $data['job_position'];
        $department      = $data['department'];
        $role_id         = $data['role_id'];
        $branch_id       = $data['branch_id'];
        $date_hired      = $data['date_hire'];
        $basic_pay       = $data['basic_pay'];
        $timeshift_start = $data['timeshift_start'];
        $timeshift_end   = $data['timeshift_end'];

        // Government Details
        $tin_number        = $data['tin_number'];
        $sss_number        = $data['sss_number'];
        $pagibig_number    = $data['pagibig_number'];
        $philhealth_number = $data['philhealth_number'];

        //Contact Information

        $email_address  = $data['email_address'];
        $contact_number = $data['contact_number'];
        $fb             = $data['fb'];

        //User Accounts
        $email            = isset($data['email']) ?  $data['email'] : "" ;
        $password         = isset($data['password']) ?  $data['password'] : "";
        $confirm_password = isset($data['confirm_password']) ?  $data['confirm_password'] : "";

        // dd($email, $password, $confirm_password);

        // Creation of New Account
        
        if ($email != "" && $password !== "" && $confirm_password != "") 
        {
            if($password != $confirm_password)
            {
                // dd('shit');
                return 'confirm_password_error';
            }
            // dd('here');
            $user = $sentry->createUser(array(
                    'email'      => $email,
                    'password'   => $password,
                    'activated'  => true,
                    'company_id' => COMPANY_ID
                ));

            $group = $sentry->findGroupById($role_id);
            $user->addGroup($group);
            $user_id = $user->id;
        } 
        else 
        {
            $user_id = null;
        }

        // Upload Picture

        $filename = 'none';
            try{

             $file = new \Upload\File('display_picture', $this->fileSystem);
            

            // openssl_csr_export_to_file(csr, outfilename)ionally you can rename the file on upload
            if($file->isOK()){
           
                $new_filename = uniqid();
                $file->setName($new_filename);
                // Access data about the file that has been uploaded
                $data = array(
                    'name'       => $file->getNameWithExtension(),
                    'extension'  => $file->getExtension(),
                    'mime'       => $file->getMimetype(),
                    'size'       => $file->getSize(),
                    'md5'        => $file->getMd5(),
                    'dimensions' => $file->getDimensions()
                );

                // Try to upload file

                
            }
            try {
                // Success!
                $file->upload();

                $filename = $file->getNameWithExtension();
            
            } catch (\Exception $e) {
                // Fail!
                $errors = $file->getErrors();
            }
       
            }catch(\Exception $e){

            }
         $save_data = array(

            'user_id'         => (string) $user_id,
            'first_name'      => (string) $first_name,
            'last_name'       => (string) $last_name,
            'middle_name'     => (string) $middle_name,
            'full_address'    => (string) $full_address,
            'birthdate'       => (string) $birthdate,
            'gender'          => (string) $gender,
            'marital_status'  => (string) $marital_status,
            'spouse_name'     => (string) $spouse_name,
            'employee_type'   => (string) $employee_type,
            'payroll_period'  => (string) $payroll_period,
            'job_position'    => (string) $job_position,
            'department'      => (int) $department,
            'role_id'         => (int) $role_id,
            'branch_id'       => (int) $branch_id,
            'date_hired'      => (string) $date_hired,
            'date_ended'      => (string) "none",
            'basic_pay'       => (string) $basic_pay,
            'tin_number'      => (string) $tin_number,
            'sss_number'      => (string) $sss_number,
            'pagibig_number'  => (string) $pagibig_number,
            'dependents'      => (int) $dependents,
            'contact_number'  => (string) $contact_number,
            'profile_picture' => $filename,
            'email'           => (string) $email_address,
            'fb'              => (string) $fb,
            'full_name'       => (string) $full_name,
            'timeshift_start' => date('H:i:s', strtotime($timeshift_start)),
            'timeshift_end'   => date('H:i:s', strtotime($timeshift_end))                
        ); 

        // var_dump($save_data);
        // die();
        
        $existing = $this->where('first_name', $save_data['first_name'])
            ->where('last_name', $save_data['last_name'])
            ->where('middle_name', $save_data['middle_name'])
            ->where('birthdate', $save_data['birthdate'])
            ->get()
            ->count();

        if(!$existing){
            $save = $this->create($save_data);

            $save->employee_number = createEmployeeID($save->id);

            $save->save();

            History::create(array(
                'company_id' => COMPANY_ID,
                'employee_id' => $save->id,
                'action' => 'Hired to the company'
            ));
        }
        else {
            return 'duplicate_error';
        }

    }

    public function updateProfilePicture($data, $id)
    {
        $profile_picture = $this->find($id)->profile_picture;
        $file = new \Upload\File('display_picture', $this->fileSystem);
        
        if($profile_picture != 'none'){
        
            $path = realpath(APPPATH . '../uploads/');
            unlink($path . '/' . $profile_picture);
            $profile_picture = explode('.', $profile_picture);        
              $file->setName($profile_picture[0]);
             $file->setExtension($profile_picture[1]);
        }

        else {
            $new_filename = uniqid();
            $file->setName($new_filename);
            // Access data about the file that has been uploaded
            $data = array(
                'name'       => $file->getNameWithExtension(),
                'extension'  => $file->getExtension(),
                'mime'       => $file->getMimetype(),
                'size'       => $file->getSize(),
                'md5'        => $file->getMd5(),
                'dimensions' => $file->getDimensions()
            );

            // Try to upload file

            $profile_picture = $file->getNameWithExtension();

            $this->find($id)->update(['profile_picture' => $profile_picture]);
        }
     
           try {
                // Success!
                $file->upload();
                return true;
            } catch (\Exception $e) {
                // Fail!
                $errors = $file->getErrors();
            }
    }

    public function getLoginUser($sentry = null)
    {

        $sentry = get_instance()->sentry->getUser();
        $employee = Employee::where('user_id', '=', $sentry->id)->first();
        // dd($employee);
        if ($employee) {
            $group                     = $sentry->getGroups()[0];
            // dd($sentry->getGroups());
            $employee->permissions     = $group->getPermissions();
            $employee->all_permissions = $this->getAllPermissions();
            return $employee;
        }
        return $this->getAdminAccount();
    }

    public function getAdminAccount()
    {
        $employee               = new Employee();
        $employee->id           = 1;
        $employee->first_name   = 'Super Admin';
        $employee->middle_name  = 'N/A';
        $employee->last_name    = 'Administrator';
        $employee->full_address = 'N/A';
        $employee->birthdate    = date('Y-m-d');
        $employee->birthdate    = date('Y-m-d');
        $employee->branch_administrator = true;
        return $employee;
    }

    public function getUserById($id)
    {
        return Employee::where('id', '=', $id)->first();
    }

    public function getNearBirthday()
    {

        $startDate = Carbon::now();
        $endDate   = $startDate->copy()->addWeeks(3);
        $query     = $this->whereRaw("DATE_FORMAT(birthdate, '%m%d') BETWEEN " . $startDate->format('m') . $startDate->day . " AND " . $endDate->format('m') . $endDate->day, []);
        return $query->take(5)->get();
    }

    public function getBirthdays()
    {
        $bdays = [];
        // $item = [ 'name' => '', 'day' => '', 'month' => ''];
        $employees = Employee::all();

        foreach ($employees as $employee) {
            $item['name'] = $employee->getName() . "- Birthday";
            $item['day'] = date('d', strtotime($employee->getBirthdate()));
            $item['month'] = date('m', strtotime($employee->getBirthdate())) - 1;
            $item['year'] = date('Y', strtotime($employee->getBirthdate()));
            array_push($bdays, $item);
        }

        return $bdays;
    }

    public function search($query)
    {
        return $this->where(function($q) use ($query){
                    $q->where('first_name', 'like', "%{$query}%")
                            ->orWhere('last_name', 'like', "%{$query}%")
                            ->orWhere('email', 'like', "%{$query}%"); })
                    ->where('company_id', '=', COMPANY_ID)
                    ->get();

    }

    public function searchGetId($query)
    {
        $search = $this->search($query)->toArray();
        return array_column($search, 'id');
    }

    function deleteEmployee($id)
    {
        $employee = Employee::find($id);
        $employee->date_ended = date('Y-m-d');

        return $employee->delete();

    }

    function getAllExpandedBIR()
    {
        return Employee::where('withholding_tax_type', '=', 'Expanded')->get();
    }

    function getAllCompensatedBIR()
    {
        return Employee::where('withholding_tax_type', '=', 'Compensation')->get();
    }

    public function uploadBybatch($data)
    {
        get_instance()->load->library('excel');


        $file = new \Upload\File('excel_file', $this->fileSystem);
        // openssl_csr_export_to_file(csr, outfilename)ionally you can rename the file on upload
        
        $filename = 'none';
        $path = realpath(APPPATH . '../uploads/');
            
        $filename = $path.'/add_employee_template.xlsx';
            // dd($filename);
        if (file_exists($filename)) {
            unlink($filename);
        }
        $file->setName('add_employee_template');
        $file->upload();

            // Try to upload file


        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $objPHPExcel = $objReader->load($filename);

        $objWorksheet = $objPHPExcel->getActiveSheet(0);

        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'

        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        $user_infos = [];
        
        for ($index = 0,$row = 2; $row <= $highestRow; ++$row) {
          for ($col = 0; $col <= $highestColumnIndex; ++$col) {
            $user_infos[$index][$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();  
          }
          $index++;
        }
        

        foreach ($user_infos as  $user_info ) {
            if($user_info[0] == "")
            {
                continue;
            }
            $required_field = [
                            'employee_type' => $user_info[9],
                            'branch' =>  $user_info[10],
                            'department' => $user_info[12],
                            'job_position' => $user_info[11],
                            'payroll_group_name' => $user_info[13],
                            'payroll_group_period' => $user_info[14],
                            ];
            // dd($required_field);
            // 
            foreach ($required_field as $key => $value) {
                if($value == "" || $value==NULL){
                    // var_dump('here');
                    // dd($key, $value);
                    return ['status' => false, 'message' => $key . ' is required'];
                }
            }

            $employee_type = EmployeeType::where('employee_type_name', '=', $user_info[9])->first();
            if($employee_type){
                $employee_type_id = $employee_type->id;
            }
            else{
                $employee_type = EmployeeType::create(['employee_type_name' => $user_info[9], 'company_id' => COMPANY_ID]);
                $employee_type_id = $employee_type->id;
            }

            $branch = Branch::where('branch_name','=', $user_info[10])->first();
            if($branch){
                $branch_id =$branch->id;
            }
            else{
                $branch= Branch::create(array('branch_name' => $user_info[10], 'branch_description' => 'null', 'branch_address' => 'null', 'branch_contact_number' => 'null', 'company_id' => COMPANY_ID));
                
                $branch_id = $branch->id;
            }
            // dd($branch_id);
            $department = Department::where('department_name', '=',  $user_info[12])->first();
            if($department){
                $department_id =$department->id;
            }
            else{
                $department = Department::create(array('department_name' => $user_info[12],'branch_id' => $branch_id, 'company_id' => COMPANY_ID, 'department_description' => 'null'));
                $department_id = $department->id;
            }

            $job_position = Job_Position::where('Job_Position','=', $user_info[11])->first();
            if($job_position)
            {
                $job_position_id = $job_position->id;
            }
            else
            {
                $job_position = Job_Position::create(array('job_position' => $user_info[11], 'company_id' => COMPANY_ID, 'job_description' => 'null'));
                   $job_position_id = $job_position->id;
            }

            $group_name = trim(ucwords(strtolower($user_info[13])));

            $payroll_period = PayrollGroup::where('group_name','=',$group_name)
                                            ->where('branch_id', '=', $branch_id) 
                                            ->first();
            if($payroll_period)
            {    
                $payroll_period_id = $payroll_period->id;
            }
            else{
     
                $period  = trim(ucwords(strtolower($user_info[14])));
                $payroll_period = PayrollGroup::create(array('group_name' => $group_name, 'period' => $period, 'branch_id' => $branch_id,'company_id' => COMPANY_ID));
                 $payroll_period_id = $payroll_period->id;
            }
            // dd(date('H:i:s', strtotime($user_info[25])));

            $data = array(
                'first_name'        => toTitleCase($user_info[0]),
                'last_name'         => toTitleCase($user_info[2]),
                'middle_name'       => toTitleCase($user_info[1]),
                'full_address'      => toTitleCase($user_info[3]),
                'birthdate'         => toTitleCase($user_info[7]),
                'gender'            => toTitleCase($user_info[8]),
                'marital_status'    => toTitleCase($user_info[6]),
                'spouse_name'       => toTitleCase($user_info[4]),
                'employee_type'     => $employee_type_id,
                'payroll_period'    =>  $payroll_period_id,
                'job_position'      =>  $job_position_id,
                'department'        =>  $department_id,
                'role_id'           => $user_info[15],
                'branch_id'         => $branch_id,
                'date_hire'         =>  $user_info[16],
                'date_ended'        => 'none',
                'basic_pay'         => $user_info[17],
                'tin_number'        => $user_info[18],
                'sss_number'        => $user_info[19],
                'pagibig_number'    => $user_info[21],
                'philhealth_number' => $user_info[20],
                'dependents'        => (int) $user_info[5],
                'contact_number'    => $user_info[24],
                'email_address'     => $user_info[22],
                'fb'                => $user_info[23],
                'display_picture'   => null,
                'timeshift_start'   => date('H:i:s', strtotime($user_info[25])),
                'timeshift_end'     => date('H:i:s', strtotime($user_info[26]))


            );
            $this->createEmployee($data,"");
        }         

        return ['status' => true, 'message' => 'Successfully Uploaded!'];
    }

    public function reactivateEmployee($id)
    {
        $employee = $this->where('id', '=', $id)
                         ->onlyTrashed()
                        ->first();


       $restore =  $employee->restore();
       return $restore;
    }


}
