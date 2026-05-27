<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/profile', 'Dashboard::profile');
    $routes->post('/profile', 'Dashboard::updateProfile');

    // Assets — all roles VIEW, manager+ manage
    $routes->get('assets', 'Assets::index');
    $routes->get('assets/(:num)', 'Assets::show/$1');

    $routes->group('assets', ['filter' => 'auth:superadmin,manager'], function ($routes) {
        $routes->get('new', 'Assets::new');
        $routes->post('/', 'Assets::create');
        $routes->get('(:num)/edit', 'Assets::edit/$1');
        $routes->post('(:num)', 'Assets::update/$1');
        $routes->post('(:num)/delete', 'Assets::delete/$1');
    });

    // Categories — all VIEW, manager+ manage
    $routes->get('categories', 'Categories::index');

    $routes->group('categories', ['filter' => 'auth:superadmin,manager'], function ($routes) {
        $routes->get('new', 'Categories::new');
        $routes->post('/', 'Categories::create');
        $routes->get('(:num)/edit', 'Categories::edit/$1');
        $routes->post('(:num)', 'Categories::update/$1');
        $routes->post('(:num)/delete', 'Categories::delete/$1');
    });

    // Maintenance — all VIEW, manager+ manage
    $routes->get('maintenance', 'Maintenance::index');
    $routes->get('maintenance/(:num)', 'Maintenance::show/$1');

    $routes->group('maintenance', ['filter' => 'auth:superadmin,manager'], function ($routes) {
        $routes->get('new', 'Maintenance::new');
        $routes->post('/', 'Maintenance::create');
        $routes->get('(:num)/edit', 'Maintenance::edit/$1');
        $routes->post('(:num)', 'Maintenance::update/$1');
        $routes->post('(:num)/delete', 'Maintenance::delete/$1');
    });

    // Transactions — manager+ only
    $routes->group('transactions', ['filter' => 'auth:superadmin,manager'], function ($routes) {
        $routes->get('/', 'Transactions::index');
        $routes->get('new', 'Transactions::new');
        $routes->post('/', 'Transactions::create');
        $routes->get('(:num)', 'Transactions::show/$1');
    });

    // Users — superadmin only
    $routes->group('users', ['filter' => 'auth:superadmin'], function ($routes) {
        $routes->get('/', 'Users::index');
        $routes->get('new', 'Users::new');
        $routes->post('/', 'Users::create');
        $routes->get('(:num)/edit', 'Users::edit/$1');
        $routes->post('(:num)', 'Users::update/$1');
        $routes->post('(:num)/delete', 'Users::delete/$1');
    });
});

// RESTful API — Bearer token protected
$routes->group('api/v1', ['filter' => 'apiauth', 'namespace' => 'App\Controllers\Api'], function ($routes) {
    $routes->get('assets', 'AssetsApi::index');
    $routes->get('assets/(:num)', 'AssetsApi::show/$1');
    $routes->get('assets/(:num)/availability', 'AssetsApi::availability/$1');
    $routes->get('categories', 'AssetsApi::categories');
});
