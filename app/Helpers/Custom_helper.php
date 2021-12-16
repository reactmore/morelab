<?php

use App\Models\UserModel;
use App\Models\Roles_permissionsModel;

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
            exit();
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
            $permisions = $section[0];

            if (!empty($role_permission) && $role_permission->$permisions == 1) {
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
        global $CI4;
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
        set_cookie([
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
