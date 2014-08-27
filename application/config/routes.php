<?php

/* |-----------------------------------------
 * | Routes
 * |-----------------------------------------
 * | Routing using Pigeon (jamierumbelow/pigeon)
 * | This make routing resourceful
 */

Pigeon::map(function ($r) {
	$r->route('default_controller', 'MainController#index');

	$r->route('404_override', 'Welcome#error404');

	$r->route('create-admin-lemonade', 'AuthController#createAdmin');
	$r->get('auth', 'AuthController#index');
	$r->post('auth', 'AuthController#login');
	$r->get('auth/logout', 'AuthController#logout');
	$r->get('auth/time-in', 'AuthController#timeIn');

	$r->get('dashboard', 'MainController#dashboard');

	$r->post('announcement', 'AnnouncementController#save');

	$r->get('slip', 'MainController#slip');

	$r->get('settings/branches', 'BranchController#index');
	$r->get('settings/branches/add', 'BranchController#add');
	$r->post('settings/branches/add', 'BranchController#save');
	$r->get('settings/branches/edit', 'BranchController#edit');
	$r->post('settings/branches/edit', 'BranchController#update');
	$r->get('settings/branches/delete', 'BranchController#delete');

	$r->get('payroll', 'PayrollController#index');
	$r->get('payroll/payslip', 'PayrollController#payslip');
	$r->post('payroll/payslip/generate', 'PayrollController#generatePayslip');
	$r->get('payroll/gov-form/(:num)', 'PayrollController#govform');
	$r->get('payroll/bank', 'PayrollController#bank');

	$r->get('payroll/group/(:num)', 'PayrollController#groupList');

	$r->get('payroll/payslip/(:num)', 'PayrollController#slip');

	$r->get('payroll/masterlist/(:num)', 'PayrollController#masterList');



	$r->get('testpdf', 'PayrollController#test');

	/*Admin Settings */
	$r->get('settings/roles', 'UserRolesController#index');
	$r->get('settings/roles/add', 'UserRolesController#add');
	$r->post('settings/roles/add', 'UserRolesController#save');
	$r->get('settings/roles/edit', 'UserRolesController#edit');
	$r->post('settings/roles/edit', 'UserRolesController#update');
	$r->get('settings/roles/delete', 'UserRolesController#delete');

	$r->get('settings/job', 'JobController#index');
	$r->get('settings/job/add', 'JobController#add');
	$r->post('settings/job/add', 'JobController#save');
	$r->get('settings/job/edit', 'JobController#edit');
	$r->post('settings/job/edit', 'JobController#update');
	$r->get('settings/job/delete', 'JobControllerjob#delete');

	$r->get('settings/department', 'DepartmentController#index');
	$r->get('settings/department/add', 'DepartmentController#add');
	$r->post('settings/department/add', 'DepartmentController#save');
	$r->get('settings/department/edit', 'DepartmentController#edit');
	$r->post('settings/department/edit', 'DepartmentController#update');
	$r->get('settings/department/delete', 'DepartmentController#delete');

	$r->get('settings/payroll', 'payrollSettingsController#index');
	$r->get('settings/payroll-group', 'payrollSettingsController#payrollGroup');
	$r->post('settings/payroll-group', 'payrollSettingsController#postPayrollGroup');

	$r->get('settings/forms', 'FormSettingsController#index');
	$r->get('settings/forms/new', 'FormSettingsController#create');
	$r->get('settings/forms/(:num)/edit', 'FormSettingsController#edit');
	$r->get('settings/forms/(:num)', 'FormSettingsController#show');
	$r->post('settings/forms', 'FormSettingsController#store');
	$r->put('settings/forms/(:num)', 'FormSettingsController#update');
	$r->delete('settings/forms/(:num)', 'FormSettingsController#delete');

	$r->get('settings/deductions', 'DeductionController#index');
	$r->post('settings/deductions/save', 'DeductionController#save');

	$r->get('settings/allowances', 'AllowanceController#index');
	$r->post('settings/allowances/save', 'AllowanceController#save');

	$r->get('settings/company', 'CompanyController#index');
    $r->post('settings/company', 'CompanyController#save');
	$r->post('settings/company/edit', 'CompanyController#update');

    $r->get('settings/holidays', 'HolidayController#index');
    $r->post('settings/holidays/generate', 'HolidayController#generateYear');
    $r->get('settings/holidays/(:num)', 'HolidayController#holidayPerYear');
    $r->post('settings/holidays/update/(:num)', 'HolidayController#update');
	$r->post('settings/holidays/save/(:num)', 'HolidayController#add');

	$r->get('employees', 'EmployeeController#index');
	$r->get('employees/add', 'EmployeeController#add');
	$r->get('employees/search', 'EmployeeController#search');
	$r->post('employees/add', 'EmployeeController#save');
	$r->get('employees/edit', 'EmployeeController#edit');
	$r->post('employees/edit', 'EmployeeController#update');
	$r->get('employees/delete', 'EmployeeController#delete');
	$r->get('employees/(:num)/profile', 'EmployeeController#profile');
	$r->post('employees/(:num)/profile', 'EmployeeController#update');
	$r->post('employees/file/upload', 'EmployeeController#upload');
	$r->post('employees/adjust-basic-pay', 'EmployeeController#adjustBasicPay');
	$r->post('employees/(:num)/update-salary', 'EmployeeController#updateSalary');
	$r->post('employees/(:num)/update-contributions', 'EmployeeController#updateContributions');

	$r->post('evaluations/save', 'EvaluationController#store');

	$r->get('timesheet', 'TimesheetController#index');

	$r->post('deductions/employee_add', 'DeductionController#addEmployeeDeduction');
	$r->post('allowances/employee_add', 'AllowanceController#addEmployeeAllowance');

	$r->get('sss', 'MainController#test');

	$r->get('media', 'ImageController');



     $r->get('employees', 'EmployeeController#index');
     $r->get('employees/add', 'EmployeeController#add');
     $r->get('employees/search', 'EmployeeController#search');
     $r->post('employees/add', 'EmployeeController#save');
     $r->get('employees/edit', 'EmployeeController#edit');
     $r->post('employees/edit', 'EmployeeController#update');
     $r->get('employees/delete', 'EmployeeController#delete');
     $r->get('employees/(:num)/profile', 'EmployeeController#profile');
     $r->post('employees/(:num)/profile', 'EmployeeController#update');
     $r->post('employees/file/upload', 'EmployeeController#upload');
     $r->post('employees/adjust-basic-pay', 'EmployeeController#adjustBasicPay');
     $r->post('employees/(:num)/update-salary', 'EmployeeController#updateSalary');
     $r->post('employees/(:num)/update-contributions', 'EmployeeController#updateContributions');


     $r->get('hr','HumanResourceController#index');
     $r->get('hr/form-application','HumanResourceController#application');
     $r->post('hr/approved','HumanResourceController#approve');


     $r->get('forms','FormsController#index');
     $r->get('forms/rest-get-user','FormsController#restGetUser');
     $r->get('forms/rest-form-template','FormsController#formTemplate');
     $r->post('forms/save-form','FormsController#store');

     $r->post('evaluations/save', 'EvaluationController#store');

     $r->get('timesheet', 'TimesheetController#index');
     $r->get('my-timesheet', 'TimesheetController#myTimesheet');
     $r->get('timein', 'TimesheetController#timein');
     $r->get('timeout', 'TimesheetController#timeout');
   

     $r->post('deductions/employee_add', 'DeductionController#addEmployeeDeduction');
     $r->post('allowances/employee_add', 'AllowanceController#addEmployeeAllowance');


     $r->get('sss','MainController#test');

     $r->get('media', 'ImageController');

     $r->post('memo/add', 'MemoController#add');

     $r->get('my-payslip', 'PayrollController#myPaySlips');

    // $r->post('posts', 'Posts#create' );
    // $r->put('posts/(:num)', array( 'Posts', 'update' ));
    // $r->delete('posts/(:num)', array( 'Posts', 'delete' ));

    // $r->resources('posts');

    // $r->resources('posts', function($r){
    //     $r->resources('comments');
    // });
});

$route = Pigeon::draw();

// $route['default_controller'] = 'welcome';
// $route['404_override'] = '';
// $route['translate_uri_dashes'] = FALSE;
