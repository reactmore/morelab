<?php

use App\Models\UserModel;

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

//check auth
if (!function_exists('auth_check')) {
    function auth_check()
    {
        global $CI4;
        return $CI4->auth_model->is_logged_in();
    }
}

//check admin
if (!function_exists('is_admin')) {
    function is_admin()
    {
        global $CI4;
        return $CI4->auth_model->is_admin();
    }
}

//check user permission
if (!function_exists('check_user_permission')) {
    function check_user_permission($section)
    {
        global $CI4;
        if ($CI4->auth_check) {
            $user_role = $CI4->auth_user->role;
            if ($user_role == 'admin') {
                return true;
            }
            $role_permission = array_filter($CI4->roles_permissions, function ($item) use ($user_role) {
                return $item->role == $user_role;
            });
            foreach ($role_permission as $key => $value) {
                $role_permission = $value;
                break;
            }
            if (!empty($role_permission) && $role_permission->$section == 1) {
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
            redirect(lang_base_url());
        }
    }
}

//check permission
if (!function_exists('check_admin')) {
    function check_admin()
    {
        if (!is_admin()) {
            redirect(lang_base_url());
        }
    }
}


//admin url
if (!function_exists('admin_url')) {
    function admin_url()
    {
        global $CI4;
        return base_url() . $CI4->routes->admin . '/';
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
            return base_url() . $lang->short_form . "/";
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
            return lang_base_url() . get_route($route_1, true) . get_route($route_2);
        } else {
            return lang_base_url() . get_route($route_1);
        }
    }
}
