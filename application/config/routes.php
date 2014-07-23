<?php

/* |-----------------------------------------
 * | Routes
 * |-----------------------------------------
 * | Routing using Pigeon (jamierumbelow/pigeon)
 * | This make routing resourceful
 */

Pigeon::map(function($r){
    $r->route('default_controller', ['Welcome', 'index']);
    $r->route('404_override', 'Welcome#error404');

    $r->get('hey', ['Welcome', 'hey']);
    $r->get('hey/(:num)', ['Welcome', 'hey']);
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
