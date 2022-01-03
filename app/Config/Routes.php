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
$routes->group("api", ["namespace" => "App\Controllers\Api"], function ($routes) {
    $routes->group("user", function ($routes) {
        $routes->get("/", "User::index", ["filter" => 'secure-api']);
        $routes->get("(:num)", "User::show/$1", ["filter" => 'secure-api']);
        $routes->post("create", "User::create", ["filter" => 'secure-api']);
        $routes->put("update/(:num)", "User::update/$1", ["filter" => 'secure-api']);
        $routes->delete("delete/(:num)", "User::delete/$1", ["filter" => 'secure-api']);
    });
});


$routes->get('connect-with-google', 'Common::connect_with_google');

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->group("$custom_routes->admin", ["namespace" => "App\Controllers\Admin"], ["filter" => 'auth-login'], function ($routes) {

    $routes->get('', 'Dashboard::index', ["filter" => 'auth-login', 'check-permissions:admin_panel']);
    $routes->get('dashboard', 'Dashboard::index', ["filter" => 'check-permissions:admin_panel']);
    $routes->get('administrators', 'UserManagement::administrators', ["filter" => 'check-admin']);

    $routes->group('users', ["namespace" => "App\Controllers\Admin"], ["filter" => 'check-permissions:users'], function ($routes) {
        $routes->get('list-users', 'UserManagement::users');
        $routes->get('add-user', 'UserManagement::add_user', ["filter" => 'check-permissions:admin_panel']);
        $routes->get('edit-user/(:num)', 'UserManagement::edit_user/$1', ["filter" => 'check-permissions:admin_panel']);
    });

    $routes->group('roles-permissions', ["namespace" => "App\Controllers\Admin"], ["filter" => 'check-admin'], function ($routes) {
        $routes->get('', 'RoleManagement::index');
        $routes->get('add-role', 'RoleManagement::add_role', ["filter" => 'check-admin']);
        $routes->get('edit-role/(:num)', 'RoleManagement::edit_role/$1', ["filter" => 'check-admin']);
    });

    $routes->group('settings', ["namespace" => "App\Controllers\Admin"], ["filter" => 'check-permissions:settings'], function ($routes) {
        $routes->get('', 'GeneralSettings::index');
        $routes->get('general', 'GeneralSettings::index');
        $routes->get('email', 'GeneralSettings::email_settings', ["filter" => 'check-admin']);
        $routes->get('social', 'GeneralSettings::social_settings', ["filter" => 'check-admin']);
        $routes->get('visual', 'GeneralSettings::visual_settings', ["filter" => 'check-admin']);
        $routes->get('cache-system', 'GeneralSettings::cache_system_settings', ["filter" => 'check-admin']);
    });

    $routes->group('profile', ["namespace" => "App\Controllers\Admin"], function ($routes) {
        $routes->get('', 'Profile::index');
        $routes->get('address-information', 'Profile::address_information');
        $routes->get('change-password', 'Profile::change_password');
        $routes->get('delete-account', 'Profile::delete_account');
    });

    $routes->group('language-settings', ["namespace" => "App\Controllers\Admin"], ["filter" => 'check-admin'], function ($routes) {
        $routes->get('', 'Languages::index');
        $routes->get('edit-language/(:num)', 'Languages::edit_language/$1');
        $routes->get('translations/(:num)', 'Languages::translations/$1');
        $routes->get('search-phrases/(:num)', 'Languages::search_phrases1');
    });

    $routes->group('locations', ["namespace" => "App\Controllers\Admin\Locations"], ["filter" => 'check-admin'], function ($routes) {
        $routes->get('country', 'Country::index');
        $routes->get('state', 'State::index');
        $routes->get('city', 'City::index');
    });
});




$routes->get("/$custom_routes->admin/register", 'Common::register');
$routes->get("/$custom_routes->admin/login", 'Common::index');
$routes->get("/$custom_routes->admin/forgot-password", 'Common::forgot_password');
$routes->get("/$custom_routes->admin/reset-password", 'Common::reset_password');

$routes->get("/confirm", 'Common::confirm_email');

$routes->get("/$custom_routes->logout", 'Common::logout');
$routes->post("/vr-run-internal-cron", 'AjaxController::run_internal_cron');
$routes->post("/vr-switch-mode", 'AjaxController::switch_visual_mode');
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
