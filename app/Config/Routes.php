<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
$routes->get('/maintenance', 'Home::maintenance');


$routes->group("api", ["namespace" => "App\Controllers\Api"], function ($routes) {
    $routes->group("user", function ($routes) {
        $routes->get("/", "User::index", ["filter" => 'secure-api']);
        $routes->get("(:num)", "User::show/$1", ["filter" => 'secure-api']);
        $routes->post("create", "User::create", ["filter" => 'secure-api']);
        $routes->put("update/(:num)", "User::update/$1", ["filter" => 'secure-api']);
        $routes->delete("delete/(:num)", "User::delete/$1", ["filter" => 'secure-api']);
    });
});

$routes->group("auth", ["namespace" => "App\Controllers\Auth"], function ($routes) {
    $routes->get('login', 'Login::index');
    $routes->post('login-post', 'Login::admin_login_post');
    $routes->get('register', 'Register::index');
    $routes->post('register-post', 'Register::admin_register_post');
    $routes->get('forgot-password', 'ForgotPassword::index');
    $routes->post('forgot-password-post', 'ForgotPassword::forgot_password_post');
    $routes->get('reset-password', 'ResetPassword::index');
    $routes->post('reset-password-post', 'ResetPassword::reset_password_post');
    $routes->get('logout', 'Login::Logout');
    $routes->get("confirm", 'Register::confirm_email');
    $routes->get("connect-with-google", 'Login::connect_with_google');
    $routes->get("connect-with-github", 'Login::connect_with_github');
});



$routes->group("admin", ["namespace" => "App\Controllers\Admin"], function ($routes) {
    $routes->get('blocked', 'Dashboard::Blocked');
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');

    $routes->group('users',  function ($routes) {
        $routes->get('administrators', 'UserManagement::administrators', ["filter" => 'check-admin']);
        $routes->get('list-users', 'UserManagement::users');
        $routes->get('add-user', 'UserManagement::add_user');
        $routes->get('edit-user/(:num)', 'UserManagement::edit_user/$1');
    });

    $routes->group("role-management", function ($routes) {
        $routes->get('', 'RoleManagement::index');
        $routes->get('permission', 'RoleManagement::Permissions');
        $routes->post('add-role-post', 'RoleManagement::add_role_post');
        $routes->post('edit-role-post', 'RoleManagement::edit_role_post');
        $routes->post('delete-role-post', 'RoleManagement::delete_role_post');
        $routes->post('change-menu-category-permission', 'RoleManagement::changeMenuCategoryPermission');
        $routes->post('change-menu-permission', 'RoleManagement::changeMenuPermission');
        $routes->post('change-submenu-permission', 'RoleManagement::changeSubMenuPermission');
    });
    $routes->group("menu-management", function ($routes) {
        $routes->get('', 'MenuManagement::index');

        $routes->post('add-menu-category-post', 'MenuManagement::add_menu_category_post');
        $routes->post('edit-menu-category-post', 'MenuManagement::edit_menu_category_post');
        $routes->post('delete-menu-category-post', 'MenuManagement::delete_menu_category_post');

        $routes->post('add-menu-post', 'MenuManagement::add_menu_post');
        $routes->post('edit-menu-post', 'MenuManagement::edit_menu_post');
        $routes->post('delete-menu-post', 'MenuManagement::delete_menu_post');

        $routes->post('add-submenu-post', 'MenuManagement::add_submenu_post');
        $routes->post('edit-submenu-post', 'MenuManagement::edit_submenu_post');
        $routes->post('delete-submenu-post', 'MenuManagement::delete_submenu_post');
    });

    $routes->group('language-settings', function ($routes) {
        $routes->get('', 'Languages::index');
        $routes->get('edit-language/(:num)', 'Languages::edit_language/$1');
        $routes->get('translations/(:num)', 'Languages::translations/$1');
        $routes->get('search-phrases/(:num)', 'Languages::search_phrases/$1');

        $routes->post('add-language-post', 'Languages::add_language_post');
        $routes->post('delete-language-post', 'Languages::delete_language_post');
        $routes->post('language-edit-post', 'Languages::language_edit_post');
        $routes->post('set-language-post', 'Languages::set_language_post');
        $routes->post('update-translation-post', 'Languages::update_translation_post');
        $routes->post('add-translation-post', 'Languages::add_translations_post');
    });

    $routes->group('settings', function ($routes) {
        $routes->get('', 'GeneralSettings::index');
        $routes->get('general', 'GeneralSettings::index');
        $routes->get('email', 'GeneralSettings::email_settings', ["filter" => 'check-admin']);
        $routes->get('social', 'GeneralSettings::social_settings', ["filter" => 'check-admin']);
        $routes->get('visual', 'GeneralSettings::visual_settings', ["filter" => 'check-admin']);
        $routes->get('cache-system', 'GeneralSettings::cache_system_settings', ["filter" => 'check-admin']);

        $routes->post('settings-post', 'GeneralSettings::settings_post');
        $routes->post('maintenance-mode-post', 'GeneralSettings::maintenance_mode_post');
        $routes->post('recaptcha-settings-post', 'GeneralSettings::recaptcha_settings_post');
    });

    $routes->group('profile', function ($routes) {
        $routes->get('', 'Profile::index');
        $routes->get('address-information', 'Profile::address_information');
        $routes->get('change-password', 'Profile::change_password');
        $routes->get('delete-account', 'Profile::delete_account');
    });

    $routes->group('locations', ["namespace" => "App\Controllers\Admin\Locations"], ["filter" => 'check-admin'], function ($routes) {
        $routes->get('country', 'Country::index');
        $routes->post('country/saved-country-post', 'Country::saved_country_post');
        $routes->post('country/delete-country-post', 'Country::delete_country_post');
        $routes->post('country/activate-inactivate-countries', 'Country::activate_inactivate_countries');
        $routes->get('state', 'State::index');
        $routes->post('state/saved-state-post', 'Country::saved_state_post');
        $routes->post('state/delete-state-post', 'Country::delete_state_post');
        $routes->get('city', 'City::index');
        $routes->post('city/saved-city-post', 'Country::saved_city_post');
        $routes->post('city/delete-city-post', 'Country::delete_city_post');
    });
});

$routes->post('vr-run-internal-cron', 'Common::run_internal_cron');
$routes->post("vr-switch-mode", 'Common::switch_visual_mode');


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
