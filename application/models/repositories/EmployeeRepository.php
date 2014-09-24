<?php

require_once APPPATH . '/libraries/excel.php';

use Employee as Employee;
use Upload\Storage\FileSystem as FileSystem;

class EmployeeRepository extends BaseRepository
{

    protected $fileSystem;
    public function __construct()
    {
        $this->class      = new Employee();
        $path             = realpath(APPPATH . '../uploads/');
        $this->fileSystem = new FileSystem($path);
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

        $post = array(
            'first_name'     => $data['first_name'],
            'last_name'      => $data['last_name'],
            'middle_name'    => $data['middle_name'],
            'full_address'   => $data['full_address'],
            'birthdate'      => $data['birthdate'],
            'gender'         => $data['gender'],
            'marital_status' => $data['marital_status'],
            // 'spouse_name' => $data['spouse_name'],
            'dependents' => (int) $data['dependents'],

            // Employee Details
            'employee_type'   => $data['employee_type'],
            'payroll_period'  => $data['payroll_period'],
            'job_position'    => (int) $data['job_position'],
            'department'      => (int) $data['department'],
            'role_id'         => (int) $data['role_id'],
            'branch_id'       => (int) $data['branch_id'],
            'date_hired'      => $data['date_hired'],
            'timeshift_start' => date("H:i:s", strtotime($data['timeshift_start'])),
            'timeshift_end'   => date("H:i:s", strtotime($data['timeshift_end'])),
            // 'basic_pay' => $data['basic_pay'],

            // Government Details
            'tin_number'     => $data['tin_number'],
            'sss_number'     => $data['sss_number'],
            'pagibig_number' => $data['pagibig_number'],
        );
        // dd($post);

        $employee = $this->where('id', '=', $employee_id);

        $employee->update($post);
      try{
            $user     = $sentry->findUserById($employee->first()->id);

            foreach ($user->getGroups() as $group) {

                $group = $sentry->findGroupById($group['id']);
                $user->removeGroup($group);
            }

            $group = $sentry->findGroupById($data['role_id']);
            $user->addGroup($group);
      }catch(Exception $e)
      {
        
      }
    }

    public function createEmployee($data, $sentry)
    {
        // Basic Info
        $first_name     = $data['first_name'];
        $last_name      = $data['last_name'];
        $middle_name    = $data['middle_name'];
        $full_address   = $data['full_address'];
        $birthdate      = $data['birthdate'];
        $gender         = $data['gender'];
        $marital_status = $data['marital_status'];
        $spouse_name    = $data['spouse_name'];
        $dependents     = (int) $data['dependents'];

        // Employee Details
        $employee_type  = $data['employee_type'];
        $payroll_period = $data['payroll_period'];
        $job_position   = $data['job_position'];
        $department     = $data['department'];
        $role_id        = $data['role_id'];
        $branch_id      = $data['branch_id'];
        $date_hired     = $data['date_hire'];
        $basic_pay      = $data['basic_pay'];

        // Government Details
        $tin_number     = $data['tin_number'];
        $sss_number     = $data['sss_number'];
        $pagibig_number = $data['pagibig_number'];

        //Contact Information

        $email_address  = $data['email_address'];
        $contact_number = $data['contact_number'];
        $fb             = $data['fb'];

        //User Accounts
        $email           = isset($data['email']) ?  $data['email'] : "" ;
        $password        = isset($data['password']) ?  $data['password'] : "";
        $cofirm_password = isset($data['confirm_password']) ?  $data['confirm_password'] : "";

        // Creation of New Account
        if ($email != "") {

            $user = $sentry->createUser(array(
                    'email'      => $email,
                    'password'   => $password,
                    'activated'  => true,
                    'company_id' => COMPANY_ID
                ));

            $group = $sentry->findGroupById($role_id);
            $user->addGroup($group);
            $user_id = $user->id;
        } else {
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

                $filename = $file->getNameWithExtension();
                
            }
        if ($save):
            try {
                // Success!
                $file->upload();
                return true;
            } catch (\Exception $e) {
                // Fail!
                $errors = $file->getErrors();
            }

        endif;

        }catch(Exception $e)
        {

        }
       

        $save = $this->create(
            array(

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
                'profile_picture' => $filename ,
                'email'           => (string) $email_address,
                'fb'              => (string) $fb,
            )
        );


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

    public function getLoginUser($sentry)
    {

        // dd($sentry->id);
        // dd(COMPANY_ID);
        $employee = Employee::where('user_id', '=', $sentry->id)->first();
        // dd($employee);
        if ($employee) {
            $group                     = $sentry->getGroups()[0];
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
        return $query->get();
    }

    public function search($query)
    {
        return $this->where(function($q) use ($query){
                    $q->where('first_name', 'like', "%{$query}%")
                            ->orWhere('last_name', 'like', "%{$query}%")
        // ->orWhere('job_position', 'like', "%{$query}%")
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
            $data = array(
                'first_name'      => $user_info[1],
                'last_name'       => $user_info[3],
                'middle_name'     => $user_info[2],
                    'full_address'    => $user_info[4],
                    'birthdate'       => $user_info[8],
                'gender'          => $user_info[9],
                'marital_status'  => $user_info[7],
                'spouse_name'     => $user_info[5],
                'employee_type'   => $user_info[10],
                'payroll_period'  =>  PayrollGroup::where('group_name','like',"%{$user_info[14]}%")->first()->id,
                'job_position'    =>  Job_Position::where('Job_Position','like',"%{$user_info[12]}%")->first()->id,
                'department'      =>  Department::where('department_name','like',"%{$user_info[13]}%")->first()->id,
                'role_id'         => $user_info[15],
                'branch_id'       => Branch::where('department_name','like',"%{$user_info[11]}%")->first()->id,
                'date_hire'      => $user_info[16],
                'date_ended'      => $user_info[3],
                'basic_pay'       => $user_info[17],
                'tin_number'      => $user_info[18],
                'ssss_number'      => $user_info[19],
                'pagibig_number'  => $user_info[20],
                'dependents'      => $user_info[6],
                'contact_number'  => $user_info[23],
                'email_address'           =>$user_info[21],
                'fb'              => $user_info[22]
            );
            $this->createEmployee($data,"");
        }         


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
