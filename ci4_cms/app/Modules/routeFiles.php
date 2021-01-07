<?php 


$routes->get('/', 'Controllers\Home::index');

// $routes->get('/home', 'Modules\Home\Controllers\Home::index');


// login
$routes->group('login', function($routes)
{
    $routes->add('/', 'Modules\Login\Controllers\Login::index');
    $routes->add('action_login/', 'Modules\Login\Controllers\Login::actionLogin');
    $routes->add('logout/', 'Modules\Login\Controllers\Login::logout');
});


// dashboard
$routes->group('home', function($routes)
{
    $routes->add('/', 'Modules\Home\Controllers\Home::index');
});

// configuration
$routes->group('configuration', function($routes)
{
	// user
    $routes->add('user', 'Modules\Configuration\User\Controllers\User::index');
    $routes->add('user/add', 'Modules\Configuration\User\Controllers\User::add');
    $routes->add('user/edit/(:any)', 'Modules\Configuration\User\Controllers\User::edit/$1');
    $routes->add('user/action_add', 'Modules\Configuration\User\Controllers\User::actionAdd');
    $routes->add('user/action_edit', 'Modules\Configuration\User\Controllers\User::actionEdit');
    $routes->add('user/delete/(:any)', 'Modules\Configuration\User\Controllers\User::delete/$1');
    $routes->add('user/change_status/(:any)', 'Modules\Configuration\User\Controllers\User::changeStatus/$1');


    // action
    $routes->add('action', 'Modules\Configuration\MenuAction\Controllers\MenuAction::index');
    $routes->add('action/add', 'Modules\Configuration\MenuAction\Controllers\MenuAction::add');
    $routes->add('action/action_add', 'Modules\Configuration\MenuAction\Controllers\MenuAction::actionAdd');
    $routes->add('action/edit/(:any)', 'Modules\Configuration\MenuAction\Controllers\MenuAction::edit/$1'); 
    $routes->add('action/action_edit', 'Modules\Configuration\MenuAction\Controllers\MenuAction::actionEdit');    
    $routes->add('action/action_delete/(:any)', 'Modules\Configuration\MenuAction\Controllers\MenuAction::actionDelete/$1'); 
    $routes->add('action/action_change_status/(:any)', 'Modules\Configuration\MenuAction\Controllers\MenuAction::actionChangeStatus/$1'); 


    // privilege
    $routes->add('privilege', 'Modules\Configuration\Privilege\Controllers\Privilege::index');
    $routes->add('privilege/add', 'Modules\Configuration\Privilege\Controllers\Privilege::add');
    $routes->add('privilege/edit', 'Modules\Configuration\Privilege\Controllers\Privilege::edit');
    $routes->add('privilege/action_add', 'Modules\Configuration\Privilege\Controllers\Privilege::actionAdd');
    $routes->add('privilege/action_edit', 'Modules\Configuration\Privilege\Controllers\Privilege::actionEdit');
    $routes->add('privilege/delete/(:any)', 'Modules\Configuration\Privilege\Controllers\Privilege::delete/$1');
    $routes->add('privilege/change_status/(:any)', 'Modules\Configuration\Privilege\Controllers\Privilege::changeStatus/$1');    
});
