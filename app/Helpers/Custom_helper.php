<?php

use App\Models\UserModel;
use App\Models\Roles_permissionsModel;
use App\Libraries\Recaptcha;
use App\Models\CurrencyModel;
use App\Models\GeneralSettingModel;
use App\Models\Locations\CityModel;
use App\Models\Locations\CountryModel;
use App\Models\Locations\StateModel;

$CI4 = new \App\Controllers\BaseController;

if (!function_exists('register_CI4')) {
    function register_CI4(&$_ci)
    {
        global $CI4;
        $CI4 = $_ci;
    }
}

if (!function_exists('get_general_settings')) {
    function get_general_settings()
    {
        $db = \Config\Database::connect();
        return $db->table('general_settings')->get()->getRow();
    }
}

if (!function_exists('get_routes')) {
    function get_routes()
    {
        $db = \Config\Database::connect();
        return $db->table('routes')->get()->getRow();
    }
}

if (!function_exists('get_langguage')) {
    function get_langguage()
    {
        $db = \Config\Database::connect();
        return  $db->table('languages')->getWhere(['status' => 1])->getResult();
    }
}

if (!function_exists('get_langguage_default')) {
    function get_langguage_default()
    {
        $db = \Config\Database::connect();
        return  $db->table('languages')->getWhere(['id' => 1])->getRow();
    }
}

if (!function_exists('get_langguage_id')) {
    function get_langguage_id($id)
    {
        $db = \Config\Database::connect();
        return  $db->table('languages')->getWhere(['id' => $id])->getRow();
    }
}

//check auth
if (!function_exists('auth_check')) {
    function auth_check()
    {
        $user_model = new UserModel;
        return $user_model->is_logged_in();
    }
}

//clean number
if (!function_exists('clean_number')) {
    function clean_number($num)
    {
        $num = trim($num);
        $num = intval($num);
        return $num;
    }
}

//clean string
if (!function_exists('clean_str')) {
    function clean_str($str)
    {
        $str = remove_special_characters($str, false);
        return $str;
    }
}

//remove special characters
if (!function_exists('remove_special_characters')) {
    function remove_special_characters($str, $is_slug = false)
    {
        $str = trim($str);
        $str = str_replace('#', '', $str);
        $str = str_replace(';', '', $str);
        $str = str_replace('!', '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('$', '', $str);
        $str = str_replace('%', '', $str);
        $str = str_replace('(', '', $str);
        $str = str_replace(')', '', $str);
        $str = str_replace('*', '', $str);
        $str = str_replace('+', '', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace('\'', '', $str);
        $str = str_replace('<', '', $str);
        $str = str_replace('>', '', $str);
        $str = str_replace('=', '', $str);
        $str = str_replace('?', '', $str);
        $str = str_replace('[', '', $str);
        $str = str_replace(']', '', $str);
        $str = str_replace('\\', '', $str);
        $str = str_replace('^', '', $str);
        $str = str_replace('`', '', $str);
        $str = str_replace('{', '', $str);
        $str = str_replace('}', '', $str);
        $str = str_replace('|', '', $str);
        $str = str_replace('~', '', $str);
        if ($is_slug == true) {
            $str = str_replace(" ", '-', $str);
            $str = str_replace("'", '', $str);
        }
        return $str;
    }
}


//remove forbidden characters
if (!function_exists('remove_forbidden_characters')) {
    function remove_forbidden_characters($str)
    {
        $str = str_replace(';', '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('$', '', $str);
        $str = str_replace('%', '', $str);
        $str = str_replace('*', '', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace('\'', '', $str);
        $str = str_replace('<', '', $str);
        $str = str_replace('>', '', $str);
        $str = str_replace('=', '', $str);
        $str = str_replace('?', '', $str);
        $str = str_replace('[', '', $str);
        $str = str_replace(']', '', $str);
        $str = str_replace('\\', '', $str);
        $str = str_replace('^', '', $str);
        $str = str_replace('`', '', $str);
        $str = str_replace('{', '', $str);
        $str = str_replace('}', '', $str);
        $str = str_replace('|', '', $str);
        $str = str_replace('~', '', $str);
        return $str;
    }
}

//convert xml characters
if (!function_exists('convert_to_xml_character')) {
    function convert_to_xml_character($string)
    {
        $str = str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
        $str = str_replace('#45;', '', $str);
        return $str;
    }
}



//get translated message
if (!function_exists('trans')) {
    function trans($string)
    {
        global $CI4;

        if (!empty($CI4->language_translations[$string])) {
            return $CI4->language_translations[$string];
        }
        return "";
    }
}

//lang base url
if (!function_exists('lang_base_url')) {
    function lang_base_url()
    {
        global $CI4;
        return $CI4->lang_base_url;
    }
}


//current full url
if (!function_exists('current_full_url')) {
    function current_full_url()
    {
        $current_url = current_url();
        if (!empty($_SERVER['QUERY_STRING'])) {
            $current_url = $current_url . "?" . $_SERVER['QUERY_STRING'];
        }
        return $current_url;
    }
}



//get logged user
if (!function_exists('user')) {
    function user()
    {
        $user_model = new UserModel;
        $user = $user_model->get_logged_user();
        if (empty($user)) {
            $user_model->logout();
            return redirect()->back();
        } else {
            return $user;
        }
    }
}

//check admin
if (!function_exists('is_admin')) {
    function is_admin()
    {
        $user_model = new UserModel;
        return $user_model->is_admin();
    }
}

//check user permission
if (!function_exists('check_user_permission')) {
    function check_user_permission($section)
    {

        if (auth_check()) {
            $user_role = user()->role;

            if ($user_role == 'admin') {
                return true;
            }


            $RolesPermissionsModel = new Roles_permissionsModel();

            $role_permission = array_filter($RolesPermissionsModel->get_roles_permissions(), function ($item) use ($user_role) {
                return $item->role == $user_role;
            });

            foreach ($role_permission as $key => $value) {
                $role_permission = $value;
                break;
            }

            $sections = $section[0];

            if (!empty($role_permission) && $role_permission->$sections == 1) {
                return true;
            }
        }
        return false;
    }
}

//check permission
if (!function_exists('check_permission')) {
    function check_permission($section)
    {
        if (!check_user_permission($section)) {
            redirect()->to(admin_url());
        }
    }
}

//check permission
if (!function_exists('check_admin')) {
    function check_admin()
    {
        if (!is_admin()) {
            return redirect()->to(admin_url());
        }
    }
}


//admin url
if (!function_exists('admin_url')) {
    function admin_url()
    {

        return base_url() . '/' . get_routes()->admin . '/';
    }
}

//generate base url
if (!function_exists('generate_base_url')) {
    function generate_base_url($lang)
    {
        global $CI4;
        if (!empty($lang)) {
            if ($CI4->selected_lang->id == $lang->id) {
                return base_url();
            }
            return base_url() . '/' . $lang->short_form . "/";
        }
        return lang_base_url();
    }
}


//get route
if (!function_exists('get_route')) {
    function get_route($key, $slash = false)
    {
        global $CI4;
        $route = $key;
        if (!empty($CI4->routes->$key)) {
            $route = $CI4->routes->$key;
            if ($slash == true) {
                $route .= '/';
            }
        }
        return $route;
    }
}

//generate static url
if (!function_exists('generate_url')) {
    function generate_url($route_1, $route_2 = null)
    {
        if (!empty($route_2)) {
            return lang_base_url() . '/' . get_route($route_1, true) . get_route($route_2);
        } else {
            return lang_base_url() . '/' . get_route($route_1);
        }
    }
}


//set cookie
if (!function_exists('helper_setcookie')) {
    function helper_setcookie($name, $value)
    {
        return set_cookie([
            'name' => config('cookie')->prefix . '_' . $name,
            'value' => $value,
            'expire' => time() + (86400 * 30),
            'domain' => base_url(),
            'path' => '/'

        ]);
    }
}

//get cookie
if (!function_exists('helper_getcookie')) {
    function helper_getcookie($name, $data_type = 'string')
    {
        if (get_cookie(config('cookie')->prefix . '_' . $name)) {
            return get_cookie(config('cookie')->prefix . '_' . $name);
        }
        if ($data_type == 'int') {
            return 0;
        }
        return "";
    }
}

//delete cookie
if (!function_exists('helper_deletecookie')) {
    function helper_deletecookie($name)
    {
        if (!empty(helper_getcookie($name))) {
            set_cookie([
                'name' => config('cookie')->prefix . '_' . $name,
                'value' => "",
                'expire' => time() - 3600,
                'domain' => base_url(),
                'path' => '/'

            ]);
        }
    }
}

//set session
if (!function_exists('helper_setsession')) {
    function helper_setsession($name, $value)
    {
        global $CI4;
        $CI4->session->set($name, $value);
    }
}

//get session
if (!function_exists('helper_getsession')) {
    function helper_getsession($name, $data_type = 'string')
    {
        global $CI4;
        if (!empty($CI4->session->get($name))) {
            return $CI4->session->get($name);
        }
        if ($data_type == 'int') {
            return 0;
        }
        return "";
    }
}



//check admin nav
if (!function_exists('is_admin_nav_active')) {
    function is_admin_nav_active(array $array_nav_items,  int $getSegment = 1, string $class = 'active')
    {

        $uri = service('uri');
        $segment = $uri->getSegment($getSegment);

        if (!empty($segment) && !empty($array_nav_items)) {
            if (in_array($segment, $array_nav_items)) {
                echo ' ' . $class;
            }
        } else {
            echo '';
        }
    }
}


//check admin nav
if (!function_exists('is_auth_nav_active')) {
    function is_auth_nav_active()
    {
        global $CI4;
        $uri = service('uri');
        $segment1 = @$CI4->uri->segment(1);

        if (in_array($segment1, [$CI4->routes->admin, $CI4->routes->register, $CI4->routes->login, $CI4->routes->change_password, $CI4->routes->forgot_password, $CI4->routes->reset_password, 'unsubscribe', 'confirm'])) {
            return false;
        }

        return true;
    }
}

//get user avatar
if (!function_exists('get_user_avatar')) {
    function get_user_avatar($avatar_path)
    {
        if (!empty($avatar_path)) {
            if (file_exists(FCPATH . $avatar_path)) {
                return base_url() . $avatar_path;
            } else {
                return $avatar_path;
            }
        } else {
            return base_url() . "/public/assets/admin/img/user.png";
        }
    }
}

//date format
if (!function_exists('replace_month_name')) {
    function replace_month_name($str)
    {
        $str = trim($str);
        $str = str_replace("Jan", trans("January"), $str);
        $str = str_replace("Feb", trans("February"), $str);
        $str = str_replace("Mar", trans("March"), $str);
        $str = str_replace("Apr", trans("April"), $str);
        $str = str_replace("May", trans("May"), $str);
        $str = str_replace("Jun", trans("June"), $str);
        $str = str_replace("Jul", trans("July"), $str);
        $str = str_replace("Aug", trans("August"), $str);
        $str = str_replace("Sep", trans("September"), $str);
        $str = str_replace("Oct", trans("October"), $str);
        $str = str_replace("Nov", trans("November"), $str);
        $str = str_replace("Dec", trans("December"), $str);
        return $str;
    }
}

//date format
if (!function_exists('helper_date_format')) {
    function helper_date_format($datetime)
    {
        $date = date("M j, Y", strtotime($datetime));
        $date = replace_month_name($date);
        return $date;
    }
}

//date format
if (!function_exists('custom_date_format')) {
    function custom_date_format($format, $datetime)
    {
        $date = date($format, strtotime($datetime));
        $date = replace_month_name($date);
        return $date;
    }
}

//print date
if (!function_exists('formatted_date')) {
    function formatted_date($timestamp)
    {
        return date("Y-m-d / H:i", strtotime($timestamp));
    }
}

//generate unique id
if (!function_exists('generate_unique_id')) {
    function generate_unique_id()
    {
        $id = uniqid("", TRUE);
        $id = str_replace(".", "-", $id);
        return $id . "-" . rand(10000000, 99999999);
    }
}

//generate slug
if (!function_exists('str_slug')) {
    function str_slug($str)
    {
        $str = trim($str);
        return url_title(convert_accented_characters($str), "-", true);
    }
}

if (!function_exists('html_escape')) {
    /**
     * Returns HTML escaped variable.
     *
     * @param	mixed	$var		The input string or array of strings to be escaped.
     * @param	bool	$double_encode	$double_encode set to FALSE prevents escaping twice.
     * @return	mixed			The escaped string or array of strings as a result.
     */
    function html_escape($var, $double_encode = TRUE)
    {
        if (empty($var)) {
            return $var;
        }

        if (is_array($var)) {
            foreach (array_keys($var) as $key) {
                $var[$key] = html_escape($var[$key], $double_encode);
            }

            return $var;
        }

        return htmlspecialchars($var, ENT_QUOTES, 'UTF-8', $double_encode);
    }
}

if (!function_exists('get_permissions_field')) {

    function get_permissions_field()
    {
        $db = \Config\Database::connect();

        $fields = $db->getFieldNames('roles_permissions');

        $data = array();
        foreach ($fields as $index => $field) {
            if ($index == 0 || $index == 1 || $index == 2) {
                continue;
            }

            $data[$index] = $field;
        }



        return $data;
    }
}


//get logo
if (!function_exists('get_logo')) {
    function get_logo($visual_settings)
    {
        if (!empty($visual_settings)) {
            if (!empty($visual_settings->logo_light) && file_exists(FCPATH . "/public/" . $visual_settings->logo_light)) {
                return base_url() . '/public/' . $visual_settings->logo_light;
            } else {
                return base_url() . "/public/assets/admin/img/logo.png";
            }
        } else {
            return base_url() . "/public/assets/admin/img/logo.png";
        }
    }
}

//get favicon
if (!function_exists('get_logo_sm')) {
    function get_logo_sm($visual_settings)
    {
        if (!empty($visual_settings)) {
            if (!empty($visual_settings->favicon) && file_exists(FCPATH . $visual_settings->favicon)) {
                return base_url() . $visual_settings->favicon;
            } else {
                return base_url() . "/public/assets/admin/img/logo_sm.png";
            }
        } else {
            return base_url() . "/public/assets/admin/img/logo_sm.png";
        }
    }
}

//get logo footer
if (!function_exists('get_logo_dark')) {
    function get_logo_dark($visual_settings)
    {
        if (!empty($visual_settings)) {
            if (!empty($visual_settings->logo_dark) && file_exists(FCPATH . "/public/" . $visual_settings->logo_dark)) {
                return base_url() . '/public/' . $visual_settings->logo_dark;
            } else {
                return base_url() . "/public/assets/admin/img/logo-dark.png";
            }
        } else {
            return base_url() . "/public/assets/admin/img/logo-dark.png";
        }
    }
}

//get favicon
if (!function_exists('get_logo_sm_dark')) {
    function get_logo_sm_dark($visual_settings)
    {
        if (!empty($visual_settings)) {
            if (!empty($visual_settings->favicon) && file_exists(FCPATH . $visual_settings->favicon)) {
                return base_url() . $visual_settings->favicon;
            } else {
                return base_url() . "/public/assets/admin/img/logo_sm_dark.png";
            }
        } else {
            return base_url() . "/public/assets/admin/img/logo_sm_dark.png";
        }
    }
}

//get logo email
if (!function_exists('get_logo_email')) {
    function get_logo_email($visual_settings)
    {
        if (!empty($visual_settings)) {
            if (!empty($visual_settings->logo_email) && file_exists(FCPATH . "/public/" . $visual_settings->logo_email)) {
                return base_url() . '/public/' . $visual_settings->logo_email;
            } else {
                return base_url() . "/public/assets/admin/img/logo.png";
            }
        } else {
            return base_url() . "/public/assets/admin/img/logo.png";
        }
    }
}

//get favicon
if (!function_exists('get_favicon')) {
    function get_favicon($visual_settings)
    {
        if (!empty($visual_settings)) {
            if (!empty($visual_settings->favicon) && file_exists(FCPATH . $visual_settings->favicon)) {
                return base_url() . $visual_settings->favicon;
            } else {
                return base_url() . "/public/assets/admin/img/favicon.png";
            }
        } else {
            return base_url() . "/public/assets/admin/img/favicon.png";
        }
    }
}

//delete image from server
if (!function_exists('delete_image_from_server')) {
    function delete_image_from_server($path)
    {
        $full_path = FCPATH . $path;
        if (strlen($path) > 15 && file_exists($full_path)) {
            unlink($full_path);
        }
    }
}

//delete file from server
if (!function_exists('delete_file_from_server')) {
    function delete_file_from_server($path)
    {
        $full_path = FCPATH . $path;
        if (strlen($path) > 15 && file_exists($full_path)) {
            unlink($full_path);
        }
    }
}


//delete file from server
if (!function_exists('site_lang')) {
    function site_lang()
    {
        return get_langguage_id(get_general_settings()->site_lang);
    }
}

if (!function_exists('selected_lang')) {
    function selected_lang()
    {
        $site_lang = site_lang();

        if (empty($site_lang)) {
            return get_langguage_default();
        }

        return $site_lang;
    }
}

//get recaptcha
if (!function_exists('recaptcha_status')) {
    function recaptcha_status()
    {

        if (empty(get_general_settings()->recaptcha_site_key) || empty(get_general_settings()->recaptcha_secret_key)) {
            return false;
        }

        return true;
    }
}

//get recaptcha
if (!function_exists('generate_recaptcha')) {
    function generate_recaptcha()
    {
        $recaptchaLib = new Recaptcha();

        if (recaptcha_status()) {
            echo '<div class="form-group">';
            echo $recaptchaLib->getWidget();
            echo $recaptchaLib->getScriptTag();
            echo ' </div>';
        }
    }
}

//date diff
if (!function_exists('date_difference')) {
    function date_difference($date1, $date2, $format = '%a')
    {
        $datetime_1 = date_create($date1);
        $datetime_2 = date_create($date2);
        $diff = date_diff($datetime_1, $datetime_2);
        return $diff->format($format);
    }
}

//date difference in hours
if (!function_exists('date_difference_in_hours')) {
    function date_difference_in_hours($date1, $date2)
    {
        $datetime_1 = date_create($date1);
        $datetime_2 = date_create($date2);
        $diff = date_diff($datetime_1, $datetime_2);
        $days = $diff->format('%a');
        $hours = $diff->format('%h');
        return $hours + ($days * 24);
    }
}

//date difference in hours
if (!function_exists('date_difference_in_minutes')) {
    function date_difference_in_minutes($date1, $date2)
    {
        $datetime_1 = new DateTime($date1);
        $datetime_2 = new DateTime($date2);
        $diff =  ($datetime_1->getTimestamp() - $datetime_2->getTimestamp()) / 60;

        return $diff;
    }
}
//check cron time
if (!function_exists('check_cron_time')) {
    function check_cron_time($hour)
    {

        if (empty(get_general_settings()->last_cron_update) || date_difference_in_hours(date('Y-m-d H:i:s'), get_general_settings()->last_cron_update) >= $hour) {
            return true;
        }
        return false;
    }
}

//check cron time
if (!function_exists('check_cron_time_minutes')) {
    function check_cron_time_minutes($minutes)
    {

        if (empty(get_general_settings()->last_cron_update) || date_difference_in_minutes(date('Y-m-d H:i:s'), get_general_settings()->last_cron_update) >= $minutes) {
            return true;
        }
        return false;
    }
}

//check if dark mode enabled
if (!function_exists('check_dark_mode_enabled')) {
    function check_dark_mode_enabled()
    {

        $dark_mode = get_general_settings()->dark_mode;
        $ck_name = config('cookie')->prefix . '_vr_dark_mode';
        if (isset($_COOKIE[$ck_name])) {
            if ($_COOKIE[$ck_name] == 1 || $_COOKIE[$ck_name] == 0) {
                $dark_mode = $_COOKIE[$ck_name];
            }
        }
        return $dark_mode;
    }
}


//set cached data
if (!function_exists('set_cache_data')) {
    function set_cache_data($key, $data)
    {

        $key = $key . "_lang" . selected_lang()->id;
        if (get_general_settings()->cache_system == 1) {
            $cache = \Config\Services::cache();

            $cache->save($key, $data, get_general_settings()->cache_refresh_time);
        }
    }
}

//set cached data by lang
if (!function_exists('set_cache_data_by_lang')) {
    function set_cache_data_by_lang($key, $data, $lang_id)
    {

        $key = $key . "_lang" . $lang_id;
        if (get_general_settings()->cache_system == 1) {
            $cache = \Config\Services::cache();
            $cache->save($key, $data, get_general_settings()->cache_refresh_time);
        }
    }
}


//get cached data
if (!function_exists('get_cached_data')) {
    function get_cached_data($key)
    {

        $key = $key . "_lang" . selected_lang()->id;
        if (get_general_settings()->cache_system == 1) {
            $cache = \Config\Services::cache();
            if ($data = $cache->get($key)) {
                return $data;
            }
        }
        return false;
    }
}

//get cached data by lang
if (!function_exists('get_cached_data_by_lang')) {
    function get_cached_data_by_lang($key, $lang_id)
    {

        $key = $key . "_lang" . $lang_id;
        if (get_general_settings()->cache_system == 1) {
            $cache = \Config\Services::cache();
            if ($data = $cache->get($key)) {
                return $data;
            }
        }
        return false;
    }
}

//reset cache data
if (!function_exists('reset_cache_data')) {
    function reset_cache_data()
    {
        $cache = \Config\Services::cache();
        return $cache->clean();
    }
}

//reset cache data on change
if (!function_exists('reset_cache_data_on_change')) {
    function reset_cache_data_on_change()
    {
        if (get_general_settings()->refresh_cache_database_changes == 1) {
            return reset_cache_data();
        }
    }
}

//get location
if (!function_exists('get_location')) {
    function get_location($object)
    {
        $cityModel = new CityModel();
        $stateModel = new StateModel();
        $countryModel = new CountryModel();

        $location = "";
        if (!empty($object)) {
            if (!empty($object->address)) {
                $location = $object->address;
            }
            if (!empty($object->zip_code)) {
                $location .= " " . $object->zip_code;
            }
            if (!empty($object->city_id)) {
                $city = $cityModel->asObject()->find($object->city_id);

                if (!empty($city)) {
                    if (!empty($object->address) || !empty($object->zip_code)) {
                        $location .= " ";
                    }
                    $location .= $city->name;
                }
            }
            if (!empty($object->state_id)) {
                $state = $stateModel->asObject()->find($object->state_id);

                if (!empty($state)) {
                    if (!empty($object->address) || !empty($object->zip_code) || !empty($object->city_id)) {
                        $location .= ", ";
                    }
                    $location .= $state->name;
                }
            }
            if (!empty($object->country_id)) {
                $country = $countryModel->asObject()->find($object->country_id);
                if (!empty($country)) {
                    if (!empty($object->state_id) || $object->city_id || !empty($object->address) || !empty($object->zip_code)) {
                        $location .= ", ";
                    }
                    $location .= $country->name;
                }
            }
        }
        return $location;
    }
}

if (!function_exists('auto_uniq_number_database')) {
    function auto_uniq_number_database($database, $column, $prefix)
    {
        $db = \Config\Database::connect();
        $sql = "SELECT COUNT($database.$column) AS count FROM $database";

        $query = $db->query($sql)->getRow()->count + 1;

        return  $prefix . '-' . date('Ym') . str_pad($query, 3, '0', STR_PAD_LEFT);
    }
}


if (!function_exists('generate_uuid')) {

    function generate_uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}

//price formatted
if (!function_exists('price_formatted')) {
    function price_formatted($price, $currency_code, $convert_currency = false)
    {

        $price = $price / 100;
        //convert currency
        if (get_general_settings()->currency_converter == 1 && $convert_currency == true) {
            $rate = 1;
            if (selected_currency() != null && isset(selected_currency()->exchange_rate)) {
                $rate = selected_currency()->exchange_rate;
                $price = $price * $rate;
                $currency_code = selected_currency()->code;
            }
        }

        $dec_point = '.';
        $thousands_sep = ',';
        if (isset(currencies()[$currency_code]) && currencies()[$currency_code]->currency_format != 'us') {
            $dec_point = ',';
            $thousands_sep = '.';
        }

        if (filter_var($price, FILTER_VALIDATE_INT) !== false) {
            $price = number_format($price, 0, $dec_point, $thousands_sep);
        } else {
            $price = number_format($price, 2, $dec_point, $thousands_sep);
        }
        $price = price_currency_format($price, $currency_code);
        return $price;
    }
}

//price currency format
if (!function_exists('price_currency_format')) {
    function price_currency_format($price, $currency_code)
    {

        if (isset(currencies()[$currency_code])) {
            $currency = currencies()[$currency_code];
            $space = "";
            if ($currency->space_money_symbol == 1) {
                $space = " ";
            }
            if ($currency->symbol_direction == "left") {
                $price = "<span>" . $currency->symbol . "</span>" . $space . $price;
            } else {
                $price = $price . $space . "<span>" . $currency->symbol . "</span>";
            }
        }
        return $price;
    }
}



//convert currency for payments in the cart
if (!function_exists('convert_currency_by_exchange_rate')) {
    function convert_currency_by_exchange_rate($amount, $exchange_rate)
    {

        if ($amount <= 0) {
            return 0;
        }
        if (empty($exchange_rate)) {
            $exchange_rate = 1;
        }
        if (get_general_settings()->currency_converter == 1) {
            $amount = $amount * $exchange_rate;
            if (filter_var($amount, FILTER_VALIDATE_INT) !== false) {
                $amount = number_format($amount, 0, ".", "");
            } else {
                $amount = number_format($amount, 2, ".", "");
            }
        }
        return $amount;
    }
}



// Helper Currency 
if (!function_exists('currencies')) {
    function currencies()
    {
        $currency_model = new CurrencyModel();
        //currencies
        return $currency_model->get_currencies_array();
    }
}

if (!function_exists('default_currency')) {
    function default_currency()
    {
        $currency_model = new CurrencyModel();
        //currencies
        return $currency_model->get_default_currency(currencies(), get_general_settings());
    }
}
if (!function_exists('selected_currency')) {
    function selected_currency()
    {
        $currency_model = new CurrencyModel();
        //currencies
        return $currency_model->get_selected_currency(default_currency());
    }
}
