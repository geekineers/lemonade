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
    $r->get('test', 'BranchController#test');
    $r->get('auth', 'AuthController#index');
    $r->post('auth', 'AuthController#login');
    $r->get('register', 'AuthController#register');
    $r->get('reset-password/(:num)/(:num)', 'AuthController#resetPassword');
    $r->post('reset-password/(:num)/(:num)', 'AuthController#postResetPassword');
    $r->get('forgot-password', 'AuthController#forgotPassword');
    $r->post('forgot-password', 'AuthController#forgot');
    $r->post('auth/changepassword', 'AuthController#changePassword');
    $r->post('register', 'AuthController#saveRegister');
    $r->get('auth/logout', 'AuthController#logout');
    $r->get('auth/time-in', 'AuthController#timeIn');
    $r->get('accounts', 'AuthController#accountSettings');

    $r->get('birthday', 'MainController#birthday');
    $r->get('announcements', 'MainController#announcements');
    $r->get('memos', 'MainController#memos');
    $r->get('events', 'MainController#events');
    $r->get('dashboard', 'MainController#dashboard');
    $r->get('dashboard/announcement-rest', 'AnnouncementController#getAnnouncement');
    $r->post('dashboard/delete-announcement', 'AnnouncementController#delete');
    $r->post('dashboard/delete-memo', 'MemoController#delete');
    $r->post('announcement', 'AnnouncementController#save');

    $r->get('public/payslip/(:num)', 'AttachedEmailController#slip');

    $r->get('slip', 'MainController#slip');

    $r->get('settings/branches', 'BranchController#index');
    $r->get('settings/branches/add', 'BranchController#add');
    $r->post('settings/branches/add', 'BranchController#save');
    $r->get('settings/branches/edit', 'BranchController#edit');
    $r->post('settings/branches/edit', 'BranchController#update');
    $r->get('settings/branches/delete', 'BranchController#delete');
    $r->get('settings/branches/trash', 'BranchController#trash');
    $r->get('settings/branches/restore/(:num)', 'BranchController#restore');

    $r->get('payroll', 'PayrollController#index');
    $r->get('payroll/payslip', 'PayrollController#payslip');

    $r->get('payroll/rest-payroll-group', 'PayrollController#restGetPayrollGroup');
    $r->post('payroll/payslip/generate', 'PayrollController#generatePayslip');
    $r->post('payroll/payslip/delete', 'PayrollController#deletePayslips');
    $r->get('payroll/gov-form/(:num)', 'PayrollController#govform');
    $r->get('payroll/bank', 'PayrollController#bank');

    $r->get('payroll/group/(:num)', 'PayrollController#groupList');
    $r->get('payroll/payslip/(:num)', 'PayrollController#slip');
    $r->get('payroll/payslip-xls/(:num)', 'PayrollController#slipXls');
    $r->get('payroll/masterlist/(:num)', 'PayrollController#masterList');
    $r->get('payroll/masterlist-xls/(:num)', 'PayrollController#masterListInXls');

    $r->get('payroll/test', 'PayrollController#test');

    $r->get('testpdf', 'PayrollController#test');

    /*Admin Settings */
    $r->get('settings/sss-config', 'SSSConfigController#index');
    $r->get('settings/sss-config/seeder', 'SSSConfigController#sssSeeder');
    $r->post('settings/sss-config', 'SSSConfigController#store');
    $r->post('settings/sss-config/update', 'SSSConfigController#update');

    $r->get('settings/philhealth-config', 'PHConfigController#index');
    $r->post('settings/philhealth-config', 'PHConfigController#store');
    $r->post('settings/philhealth-config/update', 'PHConfigController#update');

    $r->get('settings/withholding-config', 'WithholdingtaxController#index');
    $r->get('settings/withholding-config/seed', 'WithholdingtaxController#seeder');
    $r->post('settings/withholding-config', 'WithholdingtaxController#store');
    $r->post('settings/withholding-config/update', 'WithholdingtaxController#update');

    $r->get('settings/roles', 'UserRolesController#index');
    $r->get('settings/roles/add', 'UserRolesController#add');
    $r->post('settings/roles/add', 'UserRolesController#save');
    $r->get('settings/roles/edit', 'UserRolesController#edit');
    $r->post('settings/roles/edit', 'UserRolesController#update');
    $r->get('settings/roles/delete', 'UserRolesController#delete');

    $r->get('settings/job', 'JobController#index');
    $r->get('settings/job/add', 'JobController#add');
    $r->post('settings/job/add', 'JobController#save');
    $r->post('settings/job/update', 'JobController#update');
    $r->get('settings/job/edit', 'JobController#edit');
    $r->post('settings/job/edit', 'JobController#update');
    $r->get('settings/job/delete', 'JobController#delete');
    $r->get('settings/job/trash', 'JobController#trash');
    $r->get('settings/job/restore/(:num)', 'JobController#restore');

    $r->get('settings/employee-types', 'EmployeeTypeController#index');
    $r->post('settings/employee-types/save', 'EmployeeTypeController#save');
    $r->post('settings/employee-types/update', 'EmployeeTypeController#update');
    $r->get('settings/employee-types/delete', 'EmployeeTypeController#delete');
    $r->get('settings/employee-types/trash', 'EmployeeTypeController#trash');
    $r->get('settings/employee-types/restore/(:num)', 'EmployeeTypeController#restore');

    $r->get('settings/department', 'DepartmentController#index');
    $r->get('settings/department/add', 'DepartmentController#add');
    $r->post('settings/department/add', 'DepartmentController#save');
    $r->post('settings/department/update', 'DepartmentController#update');
    $r->get('settings/department/edit', 'DepartmentController#edit');
    $r->post('settings/department/edit', 'DepartmentController#update');
    $r->get('settings/department/delete', 'DepartmentController#delete');
    $r->get('settings/department/trash', 'DepartmentController#trash');
    $r->get('settings/department/restore/(:num)', 'DepartmentController#restore');

    $r->get('settings/sub-department', 'SubDepartmentController#index');
    $r->get('settings/sub-department/add', 'SubDepartmentController#add');
    $r->post('settings/sub-department/add', 'SubDepartmentController#save');
    $r->get('settings/sub-department/edit', 'SubDepartmentController#edit');
    $r->post('settings/sub-department/edit', 'SubDepartmentController#update');
    $r->get('settings/sub-department/delete', 'SubDepartmentController#delete');
    $r->get('settings/sub-department/trash', 'SubDepartmentController#trash');
    $r->get('settings/sub-department/restore/(:num)', 'DSubepartmentController#restore');    

    $r->get('settings/payroll', 'payrollSettingsController#index');
    $r->get('settings/payroll-group', 'payrollSettingsController#payrollGroup');
    $r->post('settings/payroll-group', 'payrollSettingsController#postPayrollGroup');
    $r->post('settings/payroll-group/update', 'payrollSettingsController#updatePayrollGroup');
    $r->get('settings/payroll-group/delete', 'payrollSettingsController#delete');

    $r->get('settings/forms', 'FormSettingsController#index');
    $r->get('settings/forms/new', 'FormSettingsController#create');
    $r->get('settings/forms/(:num)/edit', 'FormSettingsController#edit');
    $r->get('settings/forms/(:num)', 'FormSettingsController#show');
    $r->post('settings/forms', 'FormSettingsController#store');
    $r->put('settings/forms/(:num)', 'FormSettingsController#update');
    $r->delete('settings/forms/(:num)', 'FormSettingsController#delete');

    $r->get('settings/deductions', 'DeductionController#index');
    $r->post('settings/deductions/save', 'DeductionController#save');
    $r->post('settings/deductions/update', 'DeductionController#update');
    $r->get('settings/deductions/delete', 'DeductionController#delete');
    $r->get('settings/deductions/trash', 'DeductionController#trash');
    $r->get('settings/deductions/restore/(:num)', 'DeductionController#restore');

    $r->get('settings/allowances', 'AllowanceController#index');
    $r->get('settings/allowances/delete', 'AllowanceController#delete');
    $r->get('settings/allowances/trash', 'AllowanceController#trash');
    $r->get('settings/allowances/restore/(:num)', 'AllowanceController#restore');
    $r->post('settings/allowances/save', 'AllowanceController#save');
    $r->post('settings/allowances/update', 'AllowanceController#update');

    $r->get('settings/company', 'CompanyController#index');
    $r->post('settings/company', 'CompanyController#save');
    $r->post('settings/company/edit', 'CompanyController#update');
    $r->post('settings/company/payroll-info-edit', 'CompanyController#updatePayroll');

    $r->get('settings/holidays', 'HolidayController#index');
    $r->get('settings/holidays/delete', 'HolidayController#delete');
    $r->post('settings/holidays/generate', 'HolidayController#generateYear');
    $r->get('settings/holidays/(:num)', 'HolidayController#holidayPerYear');
    $r->post('settings/holidays/update/(:num)', 'HolidayController#update');
    $r->post('settings/holidays/save/(:num)', 'HolidayController#add');


    $r->get('settings/leave-types', 'LeaveTypeController#index');
    $r->get('settings/leave-types/add', 'LeaveTypeController#add');
    $r->get('settings/leave-types/edit', 'LeaveTypeController#edit');
    $r->post('settings/leave-types/edit', 'LeaveTypeController#update');
    $r->post('settings/leave-types/submit', 'LeaveTypeController#store');

    $r->get('settings/users', 'UserController#index');
    $r->get('settings/users/delete', 'UserController#delete');

    $r->get('notification/form-notification','LeaveNotificationController#notify');
    $r->get('notification/form-approve','LeaveNotificationController#approved');

    $r->post('employees/(:num)/update-contributions', 'EmployeeController#updateContributions');

    $r->post('evaluations/save', 'EvaluationController#store');

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
    $r->get('employees/terminated', 'EmployeeController#terminated');
    $r->get('employees/reactivate', 'EmployeeController#reactivate');
    $r->get('employees/(:num)/profile', 'EmployeeController#profile');
    $r->post('employees/(:num)/profile', 'EmployeeController#update');
    $r->post('employees/file/upload', 'EmployeeController#uploadFile');
    $r->post('employees/certificate/upload', 'EmployeeController#uploadCertificate');
    $r->get('employees/file/delete', 'EmployeeController#deleteFile');
    $r->post('employees/adjust-basic-pay', 'EmployeeController#adjustBasicPay');
    $r->post('employees/(:num)/update-salary', 'EmployeeController#updateSalary');
    $r->post('employees/(:num)/update-contacts', 'EmployeeController#updateContacts');
    $r->post('employees/(:num)/update-contributions', 'EmployeeController#updateContributions');
    $r->post('employees/(:num)/picture_upload', 'EmployeeController#updateProfilePicture');
    $r->post('employees/trainings', 'TrainingController#save');
    $r->get('employees/trainings/delete', 'TrainingController#delete');

    $r->post('employees/batch-upload', 'EmployeeController#addEmployeeByBatch');

    $r->get('hr', 'HumanResourceController#index');
    $r->get('hr/form-application', 'HumanResourceController#application');
    $r->post('hr/approved', 'HumanResourceController#approve');
    $r->post('hr/disapproved', 'HumanResourceController#disapproved');
    $r->post('hr/delete', 'HumanResourceController#delete');

    $r->get('forms', 'FormsController#index');
    $r->get('forms/apply-manual', 'FormsController#apply');
    $r->get('forms/application', 'FormsController#employeeApply');
    $r->get('forms/rest-get-user', 'FormsController#restGetUser');
    $r->get('forms/rest-form-template', 'FormsController#formTemplate');
    $r->post('forms/save-form', 'FormsController#store');
    $r->get('forms/view/(:num)', 'FormsController#viewPrint');

    $r->post('evaluations/save', 'EvaluationController#store');

    $r->get('timesheet', 'TimesheetController#index');
    $r->get('timesheet/search', 'TimesheetController#search');
    $r->get('timesheet/test', 'TimesheetController#testCase');
    $r->get('timesheet/range', 'TimesheetController#range');
    $r->post('timesheet/update', 'TimesheetController#update');
    $r->get('timesheet/delete', 'TimesheetController#delete');
    $r->get('my-timesheet', 'TimesheetController#myTimesheet');
    $r->get('timein', 'TimesheetController#timein');
    $r->get('timeout', 'TimesheetController#timeout');
    $r->post('timesheet/save', 'TimesheetController#save');
    $r->post('timesheet/upload', 'TimesheetController#batchUpload');
    $r->post('deductions/employee_add', 'DeductionController#addEmployeeDeduction');
    $r->post('allowances/employee_add', 'AllowanceController#addEmployeeAllowance');

    $r->get('reports/(:num)/branch', 'ReportsController#branch');
    $r->get('reports/(:num)/branch/gross', 'ReportsController#grossReport');
    $r->get('reports/(:num)/branch/absent', 'ReportsController#absentReport');
    $r->get('reports/(:num)/branch/late', 'ReportsController#lateReport');
    $r->get('reports/company/gross', 'ReportsController#companyGrossReport');
    $r->get('reports/company', 'ReportsController#company');
    $r->get('reports/generate', 'ReportsController#generate');
    $r->post('reports/generate-employee-list', 'ReportsController#generateEmployeeList');
    $r->post('reports/generate-income-tax-report', 'ReportsController#generateIncomeTaxReport');
    $r->post('reports/generate-sss-report', 'ReportsController#generateSssReport');
    $r->post('reports/generate-philhealth-report', 'ReportsController#generatePhilhealthReport');
    $r->post('reports/generate-pagibig-report', 'ReportsController#generatePagibigReport');


    $r->post('history/save', 'HistoryController#save');

    $r->get('sss', 'MainController#test');

    $r->get('media', 'ImageController');

    $r->post('memo/add', 'MemoController#add');

    $r->get('my-payslip', 'PayrollController#myPaySlips');

    $r->get('api/employees', 'EmployeeController#apiAll');

    $r->get('api/department', 'DepartmentController#apiAll');

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
