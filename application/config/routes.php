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
