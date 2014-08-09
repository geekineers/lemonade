<?php

/* |-----------------------------------------
 * | Routes
 * |-----------------------------------------
 * | Routing using Pigeon (jamierumbelow/pigeon)
 * | This make routing resourceful
 */

Pigeon::map(function($r){
    $r->route('default_controller', 'MainController#index');

    $r->route('404_override', 'Welcome#error404');


     $r->route('create-admin-lemonade', 'AuthController#createAdmin');
     $r->get('auth', 'AuthController#index');
     $r->post('auth', 'AuthController#login');
     $r->get('auth/logout', 'AuthController#logout');

     $r->get('dashboard', 'MainController#dashboard');

     $r->get('slip','MainController#slip');

     $r->get('branches', 'BranchController#index');
     $r->get('branches/add', 'BranchController#add');
     $r->post('branches/add', 'BranchController#save');
     $r->get('branches/edit', 'BranchController#edit');
     $r->post('branches/edit', 'BranchController#update');
     $r->get('branches/delete', 'BranchController#delete');

     $r->get('payroll','PayrollController#index');
     $r->get('payroll/payslip','PayrollController#payslip');
     $r->post('payroll/payslip/generate','PayrollController#generatePayslip');
     $r->get('payroll/gov-form','PayrollController#govform');
     $r->get('payroll/bank','PayrollController#bank');


     $r->get('testpdf','PayrollController#test');

     /*Admin Settings */
     $r->get('settings/roles', 'UserRolesController#index');
     $r->get('settings/roles/add', 'UserRolesController#add');
     $r->post('settings/roles/add', 'UserRolesController#save');
     $r->get('settings/roles/edit', 'UserRolesController#edit');
     $r->post('settings/roles/edit', 'UserRolesController#update');
     $r->get('settings/roles/delete', 'UserRolesController#delete');


     $r->get('settings/job', 'jobController#index');
     $r->get('settings/job/add', 'jobController#add');
     $r->post('settings/job/add', 'jobController#save');
     $r->get('settings/job/edit', 'jobController#edit');
     $r->post('settings/job/edit', 'jobController#update');
     $r->get('settings/job/delete', 'jobControllerjob#delete');

     $r->get('settings/department', 'DepartmentController#index');
     $r->get('settings/department/add', 'DepartmentController#add');
     $r->post('settings/department/add', 'DepartmentController#save');
     $r->get('settings/department/edit', 'DepartmentController#edit');
     $r->post('settings/department/edit', 'DepartmentController#update');
     $r->get('settings/department/delete', 'DepartmentController#delete');

     $r->get('settings/payroll','payrollSettingsController#index');
     $r->get('settings/payroll-group','payrollSettingsController#payrollGroup');
     $r->post('settings/payroll-group','payrollSettingsController#postPayrollGroup');

     $r->get('employees', 'EmployeeController#index');
     $r->get('employees/add', 'EmployeeController#add');
     $r->post('employees/add', 'EmployeeController#save');
     $r->get('employees/edit', 'EmployeeController#edit');
     $r->post('employees/edit', 'EmployeeController#update');
     $r->get('employees/delete', 'EmployeeController#delete');
     $r->get('employees/(:num)/profile', 'EmployeeController#profile');
     $r->post('employees/(:num)/profile', 'EmployeeController#update');
     $r->post('employees/file/upload', 'EmployeeController#upload');


     $r->get('sss','MainController#test');

     $r->get('media', 'ImageController');


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
