<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmailModel;
use App\Models\UploadModel;
use App\Models\UserModel;

use CodeIgniter\I18n\Time;


class Administrator extends AdminController
{
    public function index()
    {
        $data['title'] = trans('dashboard');

        return view('admin/dashboard', $data);
    }

    public function administrators()
    {
        $data['title'] = trans("administrators");
        //paginate
        $data['paginate'] = $this->userModel->administratorsPaginate();
        $data['pager'] =  $data['paginate']['pager'];

        return view('admin/users/administrators', $data);
    }

    public function users()
    {
        $data['title'] = trans("users");
        //paginate
        $data['paginate'] = $this->userModel->userPaginate();
        $data['pager'] =  $data['paginate']['pager'];


        return view('admin/users/users', $data);
    }

    public function add_user()
    {
        $data['title'] = trans("add_user");
        $data['roles'] = $this->RolesPermissionsModel->get_roles_permissions();

        return view('admin/users/add_users', $data);
    }

    /**
     * Add User Post
     */
    public function add_user_post()
    {
        if (!check_user_permission('users')) {
            exit();
        }

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'username'      => 'required|min_length[4]|max_length[100]',
            'email'         => 'required|max_length[200]|valid_email',
            'password'      => 'required|min_length[4]|max_length[50]',
        ];

        if ($this->validate($rules)) {
            $email = $this->request->getVar('email');
            $username = $this->request->getVar('username');

            //is username unique
            if (!$this->userModel->is_unique_username($username)) {
                $this->session->setFlashData('form_data', $this->userModel->input_values());
                $this->session->setFlashData('error', trans("msg_username_unique_error"));
                return redirect()->back()->withInput();
            }
            //is email unique
            if (!$this->userModel->is_unique_email($email)) {
                $this->session->setFlashData('form_data', $this->userModel->input_values());
                $this->session->setFlashData('error', trans("message_email_unique_error"));
                return redirect()->back()->withInput();
            }

            //add user
            $id =  $this->userModel->add_user();
            if ($id) {
                $this->session->setFlashData('success', trans("msg_user_added"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back();
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    /**
     * Edit User
     */
    public function edit_user($id)
    {

        $data['title'] = trans("update_profile");
        $data['user'] = $this->userModel->get_user($id);
        $data['roles'] = $this->RolesPermissionsModel->get_roles_permissions();

        if (empty($data['user']->id)) {
            return redirect()->back();
        }



        // $data['user_option'] = $this->auth_model->get_user_options($data['user']->id);
        // $data["states"] = array();
        // $data["cities"] = array();
        // if (!empty($data['user']->country_id)) {
        //     $data["states"] = $this->location_model->get_states_by_country($data['user']->country_id);
        // }
        // if (!empty($data['user']->state_id)) {
        //     $data["cities"] = $this->location_model->get_cities_by_state($data['user']->state_id);
        // }
        // $data['dept_list'] = $this->get_departments();
        // $data['post_list'] = $this->get_positions($data['user']->department_id);


        return view('admin/users/edit_user', $data);
    }

    /**
     * Edit User Post
     */
    public function edit_user_post()
    {
        if (!check_user_permission('users')) {
            exit();
        }

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'username' => [
                'label'  => trans('username'),
                'rules'  => 'required|min_length[4]|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],

            'email'    => [
                'label'  => trans('email'),
                'rules'  => 'required|max_length[200]|valid_email',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                ],
            ]
        ];

        if (!empty($this->request->getVar('password'))) {
            $rules['password'] = [
                'label'  => trans('password'),
                'rules'  => 'required|min_length[4]|max_length[50]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ]
            ];
        }

        if ($this->validate($rules)) {
            $data = array(
                'id' => $this->request->getVar('id'),
                'username' => $this->request->getVar('username'),
                'slug' => $this->request->getVar('slug'),
                'email' => $this->request->getVar('email')
            );

            //is email unique
            if (!$this->userModel->is_unique_username($data["email"], $data["id"])) {
                $this->session->setFlashData('errors_form', trans("message_email_unique_error"));
                return redirect()->back()->withInput();
            }
            //is username unique
            if (!$this->userModel->is_unique_username($data["username"], $data["id"])) {
                $this->session->setFlashData('errors_form', trans("msg_username_unique_error"));
                return redirect()->back()->withInput();
            }
            //is slug unique
            if ($this->userModel->check_is_slug_unique($data["slug"], $data["id"])) {
                $this->session->setFlashData('errors_form', trans("msg_slug_used"));
                return redirect()->back()->withInput();
            }

            if ($this->userModel->edit_user($data["id"])) {
                $this->session->setFlashData('success', trans("msg_updated"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('errors', trans("msg_error"));
                return redirect()->back();
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    /**
     * Delete User Post
     */
    public function delete_user_post()
    {
        if (!check_user_permission('users')) {
            exit();
        }
        $id = $this->request->getVar('id');
        $user = $this->userModel->asObject()->find($id);



        if ($user->id == 1 || $user->id == user()->id) {
            $this->session->setFlashData('error', trans("msg_error"));
            exit();
        }


        if ($this->userModel->delete_user($id)) {
            $this->session->setFlashData('success', trans("user") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    /**
     * Ban User Post
     */
    public function ban_user_post()
    {
        if (!check_user_permission('users')) {
            exit();
        }
        $option = $this->request->getVar('option');
        $id = $this->request->getVar('id');

        $user = $this->userModel->asObject()->find($id);
        if ($user->id == 1 || $user->id == user()->id) {
            $this->session->setFlashData('error', trans("msg_error"));
            exit();
        }

        //if option ban
        if ($option == 'ban') {
            if ($this->userModel->ban_user($id)) {
                $this->session->setFlashData('success', trans("msg_user_banned"));
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
            }
        }

        //if option remove ban
        if ($option == 'remove_ban') {
            if ($this->userModel->remove_user_ban($id)) {
                $this->session->setFlashData('success', trans("msg_ban_removed"));
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
            }
        }
    }

    /**
     * Confirm User Email
     */
    public function confirm_user_email()
    {
        $id = $this->request->getVar('id');
        $user = $this->userModel->asObject()->find($id);
        if ($this->userModel->verify_email($user)) {
            $this->session->setFlashData('success', trans("msg_updated"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    /** 
     * Change User Role
     */
    public function change_user_role_post()
    {
        if (!is_admin()) {
            return redirect()->to(admin_url());
        }
        $id = $this->request->getVar('user_id');
        $role = $this->request->getVar('role');
        $user = $this->userModel->asObject()->find($id);

        //check if exists
        if (empty($user)) {
            return redirect()->back();
        } else {
            if ($user->id == 1 || $user->id == user()->id) {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back();
                exit();
            }



            if ($this->userModel->change_user_role($id, $role)) {
                $this->session->setFlashData('success', trans("msg_role_changed"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back();
            }
        }
    }

    /**
     * Roles And Permissions
     *
     * @Method 
     */
    public function roles_permissions()
    {

        $data['title'] = trans("roles_permissions");

        $data['roles'] = $this->RolesPermissionsModel->get_roles_permissions();
        $data['permissions'] = get_permissions_field();

        return view('admin/roles/roles_permissions', $data);
    }

    public function add_role()
    {

        $data['title'] = trans("add_role");

        return view('admin/roles/add_role', $data);
    }

    /**
     * Add Role Post
     */
    public function add_role_post()
    {
        if (!is_admin()) {
            return redirect()->to(admin_url());
        }

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'role'      => 'required|min_length[4]|max_length[100]',
        ];

        if ($this->validate($rules)) {
            $role = strtolower($this->request->getVar('role'));


            //is username unique
            if (!$this->RolesPermissionsModel->is_unique_role($role)) {
                $this->session->setFlashData('error', trans("message_unique_error"));
                return redirect()->back()->withInput();
            }

            //add user
            $id =  $this->RolesPermissionsModel->AddRole();
            if ($id) {
                $this->session->setFlashData('success', trans("msg_suc_added"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back();
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    public function edit_role($id)
    {

        if ($id == 1) {
            return redirect()->to(admin_url() . 'roles-permissions');
        }

        $data['title'] = trans("edit_role");
        $data['role'] = $this->RolesPermissionsModel->get_role($id);

        if (empty($data['role'])) {
            return redirect()->to(admin_url() . 'roles-permissions');
        }

        return view('admin/roles/edit_role', $data);
    }

    /**
     * Edit Role Post
     */
    public function edit_role_post()
    {

        if (!is_admin()) {
            return redirect()->to(admin_url());
        }

        $id = $this->request->getVar('id');

        if ($this->RolesPermissionsModel->update_role($id)) {
            $this->session->setFlashData('success', trans("msg_updated"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }

        return redirect()->back();
    }

    public function delete_role_post()
    {
        if (!is_admin()) {
            return redirect()->to(admin_url());
        }
        $id = $this->request->getVar('id');
        $role = $this->RolesPermissionsModel->asObject()->find($id);

        if ($role->id == 1) {
            $this->session->setFlashData('error', trans("msg_error"));
            exit();
        }


        if ($this->RolesPermissionsModel->delete_role($id)) {
            $this->session->setFlashData('success',  trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    public function general_settings()
    {

        $data['title'] = trans("general_settings");
        $data['active_tab'] = 'general_settings';

        $data["selected_lang"] = $this->request->getVar('lang');

        if (empty($data["selected_lang"])) {
            $data["selected_lang"] = get_general_settings()->site_lang;
            return redirect()->to(admin_url() . "settings/general?lang=" . $data["selected_lang"]);
        }


        $data['settings'] = get_general_settings();


        return view('admin/settings/general_settings', $data);
    }

    public function settings_post()
    {

        if ($this->GeneralSettingModel->update_settings()) {
            $this->session->setFlashData('success', trans("settings") . " " . trans("msg_suc_updated"));
            $this->session->setFlashData("mes_settings", 1);
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            $this->session->setFlashData("mes_settings", 1);
            return redirect()->to($this->agent->getReferrer());
        }
    }

    public function email_settings()
    {

        $data['title'] = trans("email_settings");
        $data['active_tab'] = 'email_settings';
        $data['settings'] = get_general_settings();
        $data["protocol"] = $this->request->getVar('protocol');
        if (empty($data["protocol"])) {
            $data['protocol'] = $this->general_settings->mail_protocol;
            return redirect()->to(admin_url() . "settings/email?protocol=" . $data["protocol"]);
        }
        if ($data["protocol"] != "smtp" && $data["protocol"] != "mail") {
            $data['protocol'] = "smtp";
            return redirect()->to(admin_url() . "settings/email?protocol=smtp");
        }


        return view('admin/settings/email_settings', $data);
    }

    /**
     * Update Email Settings Post
     */
    public function email_settings_post()
    {

        if ($this->GeneralSettingModel->update_email_settings()) {
            $this->session->setFlashData('success', trans("msg_updated"));
            $this->session->setFlashData('message_type', "email");
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            $this->session->setFlashData('message_type', "email");
            return redirect()->to($this->agent->getReferrer());
        }
    }

    /**
     * Update Email Verification Settings Post
     */
    public function email_verification_settings_post()
    {

        if ($this->GeneralSettingModel->email_verification_settings()) {
            $this->session->setFlashData('success', trans("msg_updated"));
            $this->session->setFlashData('message_type', "verification");
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            $this->session->setFlashData('message_type', "verification");
            return redirect()->to($this->agent->getReferrer());
        }
    }

    /**
     * Send Test Email Post
     */
    public function send_test_email_post()
    {

        $email = $this->request->getVar('email');
        $subject = get_general_settings()->application_name . " Test Email";
        $message = "<p>This is a test email.</p>";
        $emailModel = new EmailModel();
        $this->session->setFlashData('message_type', "send_email");
        if (!empty($email)) {
            if (!$emailModel->send_test_email($email, $subject, $message)) {
                return redirect()->to($this->agent->getReferrer());
            }
            $this->session->setFlashData('success', trans("msg_email_sent"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
        return redirect()->to($this->agent->getReferrer());
    }

    public function social_settings()
    {

        $data['title'] = trans("social_login_configuration");
        $data['active_tab'] = 'social_settings';

        $data['settings'] = get_general_settings();


        return view('admin/settings/social_settings', $data);
    }

    /**
     * Social Login Facebook Post
     */
    public function social_login_facebook_post()
    {
        check_admin();
        if ($this->GeneralSettingModel->update_social_facebook_settings()) {
            $this->session->setFlashData('msg_social_facebook', '1');
            $this->session->setFlashData('success', trans("configurations") . " " . trans("msg_suc_updated"));
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            return redirect()->to($this->agent->getReferrer());
        }
    }

    /**
     * Social Login Google Post
     */
    public function social_login_google_post()
    {
        check_admin();
        if ($this->GeneralSettingModel->update_social_google_settings()) {
            $this->session->setFlashData('msg_social_google', '1');
            $this->session->setFlashData('success', trans("configurations") . " " . trans("msg_suc_updated"));
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            return redirect()->to($this->agent->getReferrer());
        }
    }

    /**
     * Visual Settings
     */
    public function visual_settings()
    {

        $data['active_tab'] = 'visual_settings';
        $data['title'] = trans("visual_settings");
        $data['visual_settings'] = get_general_settings();

        return view('admin/settings/visual_settings', $data);
    }

    /**
     * Update Settings Post
     */
    public function visual_settings_post()
    {

        $uploadModel = new UploadModel();
        if ($this->GeneralSettingModel->update_visual_settings()) {
            $this->session->setFlashData('success', trans("visual_settings") . " " . trans("msg_suc_updated"));
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            return redirect()->to($this->agent->getReferrer());
        }
    }
}
