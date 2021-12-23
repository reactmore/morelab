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

$routes->resource('api/rest');

$routes->get('connect-with-facebook', 'Common::connect_with_facebook');
$routes->get('facebook-callback', 'Common::facebook_callback');
$routes->get('connect-with-google', 'Common::connect_with_google');

$route['connect-with-facebook'] = 'auth_controller/connect_with_facebook';
$route['facebook-callback'] = 'auth_controller/facebook_callback';
$route['connect-with-google'] = 'auth_controller/connect_with_google';

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->group("$custom_routes->admin", ["filter" => 'auth-login'], function ($routes) {
    $routes->get('', 'Admin/Dashboard::index', ["filter" => 'auth-login', 'check-permissions:admin_panel']);
    $routes->get('dashboard', 'Admin/Dashboard::index', ["filter" => 'check-permissions:admin_panel']);

    $routes->get('administrators', 'Admin/UserManagement::administrators', ["filter" => 'check-admin']);

    $routes->group('users', ["filter" => 'check-permissions:users'], function ($routes) {
        $routes->get('list-users', 'Admin/UserManagement::users');
        $routes->get('add-user', 'Admin/UserManagement::add_user', ["filter" => 'check-permissions:admin_panel']);
        $routes->get('edit-user/(:num)', 'Admin\UserManagement::edit_user/$1', ["filter" => 'check-permissions:admin_panel']);
    });

    $routes->group('roles-permissions', ["filter" => 'check-admin'], function ($routes) {
        $routes->get('', 'Admin/RoleManagement::index');
        $routes->get('add-role', 'Admin/RoleManagement::add_role', ["filter" => 'check-admin']);
        $routes->get('edit-role/(:num)', 'Admin\RoleManagement::edit_role/$1', ["filter" => 'check-admin']);
    });

    $routes->group('settings', ["filter" => 'check-permissions:settings'], function ($routes) {
        $routes->get('', 'Admin/GeneralSettings::index');
        $routes->get('general', 'Admin/GeneralSettings::index');
        $routes->get('email', 'Admin/GeneralSettings::email_settings', ["filter" => 'check-admin']);
        $routes->get('social', 'Admin/GeneralSettings::social_settings', ["filter" => 'check-admin']);
        $routes->get('visual', 'Admin/GeneralSettings::visual_settings', ["filter" => 'check-admin']);
    });

    $routes->group('profile', function ($routes) {
        $routes->get('', 'Admin/Profile::index');
        $routes->get('change-password', 'Admin/Profile::change_password');
        $routes->get('delete-account', 'Admin/Profile::delete_account');
    });

    $routes->group('language-settings', ["filter" => 'check-admin'], function ($routes) {
        $routes->get('', 'Admin/Languages::index');
        $routes->get('edit-language/(:num)', 'Admin\Languages::edit_language/$1');
        $routes->get('translations/(:num)', 'Admin\Languages::translations/$1');
        $routes->get('search-phrases/(:num)', 'Admin\Languages::search_phrases1');
    });
});




$routes->get("/$custom_routes->admin/register", 'Common::register');
$routes->get("/$custom_routes->admin/login", 'Common::index');
$routes->get("/$custom_routes->admin/forgot-password", 'Common::forgot_password');
$routes->get("/$custom_routes->admin/reset-password", 'Common::reset_password');

$routes->get("/confirm", 'Common::confirm_email');

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
