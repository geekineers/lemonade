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

     $r->get('branches', 'BranchController#index');
     $r->get('branches/add', 'BranchController#add');
     $r->post('branches/add', 'BranchController#save');
     $r->get('branches/edit', 'BranchController#edit');
     $r->post('branches/edit', 'BranchController#update');
     $r->get('branches/delete', 'BranchController#delete');


     $r->get('roles', 'UserRolesController#index');
     $r->get('roles/add', 'UserRolesController#add');
     $r->post('roles/add', 'UserRolesController#save');
     $r->get('roles/edit', 'UserRolesController#edit');
     $r->post('roles/edit', 'UserRolesController#update');
     $r->get('roles/delete', 'UserRolesController#delete');

     $r->get('employees', 'EmployeeController#index');
     $r->get('employees/add', 'EmployeeController#add');
     $r->post('employees/add', 'EmployeeController#save');
     $r->get('employees/edit', 'EmployeeController#edit');
     $r->post('employees/edit', 'EmployeeController#update');
     $r->get('employees/delete', 'EmployeeController#delete');


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
