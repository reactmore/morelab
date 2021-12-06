<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

# Custom Class
use App\Libraries\Bcrypt;
use App\Models\UserModel;
use App\Models\Roles_permissionsModel;



/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['custom_helper', 'form', 'security', 'url'];

    # Create Custom variable
    protected $bcrypt;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $userModel = new UserModel();
        $RolesPermissionsModel = new Roles_permissionsModel();
        $this->general_settings = get_general_settings();
        $this->routes = get_routes();

        // Preload any models, libraries, etc, here.
        $this->bcrypt = new Bcrypt();
        $this->session = \Config\Services::session();
        $this->agent = $this->request->getUserAgent();

        register_CI4($this); // Registering controller instance for helpers;

        //lang base url
        $this->lang_base_url = base_url();
        //languages
        $this->languages = get_langguage();
        //site lang
        $this->site_lang = get_langguage_id($this->general_settings->site_lang);
        if (empty($this->site_lang)) {
            $this->site_lang = get_langguage_default();
        }
        $this->selected_lang = $this->site_lang;
        //set language
        $uri = current_url(true);
        $lang_segment = $uri->getSegment(1);
        foreach ($this->languages as $lang) {
            if ($lang_segment == $lang->short_form) {
                if ($this->general_settings->multilingual_system == 1) :
                    $this->selected_lang = $lang;
                    $this->lang_base_url = base_url() . $lang->short_form . "/";
                else :
                    return redirect(base_url());
                endif;
            }
        }
        //set lang base url
        if ($this->general_settings->site_lang == $this->selected_lang->id) {
            $this->lang_base_url = base_url();
        } else {
            $this->lang_base_url = base_url() . $this->selected_lang->short_form . "/";
        }

        //language translations
        $this->language_translations = $this->get_translation_array($this->selected_lang->id);
        $this->roles_permissions = $RolesPermissionsModel->get_roles_permissions();
    }

    public function get_translation_array($land_id)
    {
        $db = \Config\Database::connect();

        $translations = $db->table('language_translations')->getWhere(['lang_id' => $land_id])->getResult();

        $array = array();
        if (!empty($translations)) {
            foreach ($translations as $translation) {
                $array[$translation->label] = $translation->translation;
            }
        }
        $validation =  \Config\Services::validation();
        //set custom error messages
        if (isset($array["form_validation_required"])) {
            $validation->setRules(['required' => $array["form_validation_required"]]);
        }
        if (isset($array["form_validation_min_length"])) {
            $validation->setRules(['required' => $array["form_validation_min_length"]]);
        }
        if (isset($array["form_validation_max_length"])) {
            $validation->setRules(['required' => $array["form_validation_max_length"]]);
        }
        if (isset($array["form_validation_matches"])) {
            $validation->setRules(['required' => $array["form_validation_matches"]]);
        }
        if (isset($array["form_validation_is_unique"])) {
            $validation->setRules(['required' => $array["form_validation_is_unique"]]);
        }
        return $array;
    }
}
