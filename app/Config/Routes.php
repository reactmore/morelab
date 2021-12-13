<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

helper(['custom_helper']);

$general_settings = get_general_settings();
$custom_routes = get_routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->group("admin", ["filter" => 'auth-login'], function ($routes) {
    $routes->get('', 'Administrator::index', ["filter" => 'auth-login', 'check-permissions:admin_panel']);
    $routes->get('dashboard', 'Administrator::index', ["filter" => 'check-permissions:admin_panel']);

    $routes->get('administrators', 'Administrator::administrators', ["filter" => 'check-admin']);

    $routes->group('users', ["filter" => 'check-permissions:users'], function ($routes) {
        $routes->get('list-users', 'Administrator::users');
        $routes->get('add-user', 'Administrator::add_user', ["filter" => 'check-permissions:admin_panel']);
        $routes->get('edit-user/(:num)', 'Administrator::edit_user/$1', ["filter" => 'check-permissions:admin_panel']);
    });
});


$routes->get("/$custom_routes->admin/login", 'Common::index');
$routes->get("/$custom_routes->logout", 'Common::logout');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
