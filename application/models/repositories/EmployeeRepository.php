<?php



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
        $email           = $data['email'];
        $password        = $data['password'];
        $cofirm_password = $data['confirm_password'];

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

        $file = new \Upload\File('display_picture', $this->fileSystem);
        // openssl_csr_export_to_file(csr, outfilename)ionally you can rename the file on upload
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
                'profile_picture' => $filename,
                'email'           => (string) $email_address,
                'fb'              => (string) $fb,
            )
        );

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

    }

    public function updateProfilePicture($data, $id)
    {
        $profile_picture = $this->find($id)->profile_picture;
        $path = realpath(APPPATH . '../uploads/');
        unlink($path . '/' . $profile_picture);

        $profile_picture = explode('.', $profile_picture);
        $file = new \Upload\File('display_picture', $this->fileSystem);
        // openssl_csr_export_to_file(csr, outfilename)ionally you can rename the file on upload
        
        $file->setName($profile_picture[0]);
        $file->setExtension($profile_picture[1]);
        // dd($file);
        // dd($profile_picture);
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

    function deleteEmployee($id)
{
        $employee = Employee::find($id);
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

}
