<?php

namespace App\Controllers;

use App\Models\EmailModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

class Common extends BaseController
{

    /**
     * --------------------------------------------------------------------------
     * Login Page Admin Controller
     * --------------------------------------------------------------------------
     */

    public function index()
    {
        if (auth_check()) {
            return redirect()->to(admin_url());
        }

        $data['title'] = trans('login');

        return view('admin/auth/login', $data);
    }

    /**
     * --------------------------------------------------------------------------
     * Login Post Admin Controller
     * --------------------------------------------------------------------------
     */
    public function admin_login_post()
    {

        $userModel = new UserModel();
        $validation =  \Config\Services::validation();

        $rules = [
            'email'         => 'required|min_length[4]|max_length[100]|valid_email',
            'password'      => 'required|min_length[4]|max_length[50]',
        ];

        if ($this->validate($rules)) {
            $user = $userModel->get_user_by_email($this->request->getVar('email'));
            if (!empty($user) && $user->role != 'admin' && get_general_settings()->maintenance_mode_status == 1) {
                $this->session->setFlashData('errors_form', "Site under construction! Please try again later.");
                return redirect()->back();
            }

            if ($userModel->login()) {
                //remember user
                $remember_me = $this->request->getVar('remember_me');
                if ($remember_me == 1) {
                    $this->response->setCookie(config('cookie')->prefix . '_remember_user_id', user()->id, time() + 86400);
                }
                return redirect()->to(admin_url())->withCookies();
            } else {
                return redirect()->back()->withInput()->with('error', $validation->getErrors());
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    /**
     * --------------------------------------------------------------------------
     * Forgot Password Admin Controller
     * --------------------------------------------------------------------------
     */

    public function forgot_password()
    {
        if (auth_check()) {
            return redirect()->to(admin_url());
        }

        $data['title'] = trans('forgot_password');

        return view('admin/auth/forgot_password', $data);
    }

    /**
     * Forgot Password Post
     */
    public function forgot_password_post()
    {
        //check auth
        if (auth_check()) {
            return redirect()->to(admin_url());
        }

        $email = clean_str($this->request->getVar('email'));
        //get user
        $user = $this->userModel->get_user_by_email($email);
        //if user not exists
        if (empty($user)) {
            $this->session->setFlashData('error_form', html_escape(trans("reset_password_error")));
            return redirect()->back()->withInput();
        } else {
            $emailModel = new EmailModel();
            $emailModel->send_email_reset_password($user->id);
            $this->session->setFlashData('success_form', trans("reset_password_success"));
            return redirect()->to(admin_url() . 'forgot-password');
        }
    }

    /**
     * Reset Password
     */
    public function reset_password()
    {
        if (auth_check()) {
            return redirect()->to(admin_url());
        }

        $token = clean_str($this->request->getVar('token'));
        $data['title'] = trans('reset_password');

        //get user
        $data["user"] = $this->userModel->get_user_by_token($token);
        $data["success"] = $this->session->get('success_form');
        if (empty($data["user"]) && empty($data["success"])) {
            return redirect()->back();
        }

        return view('admin/auth/reset_password', $data);
    }

    /**
     * Reset Password Post
     */
    public function reset_password_post()
    {

        $success = $this->request->getVar('success_form');
        if ($success == 1) {
            redirect(lang_base_url());
        }

        $validation =  \Config\Services::validation();

        $rules = [
            'password'         => 'required|min_length[4]|max_length[200]',
            'password_confirm'      => 'required|matches[password]',
        ];

        if ($this->validate($rules)) {

            $token = clean_str($this->request->getVar('token'));
            if ($this->userModel->reset_password($token)) {
                $this->session->setFlashData('success_form', trans("message_change_password_success"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('errors_form', trans("message_change_password_error"));
                return redirect()->back();
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        //unset user data
        $this->session->remove('vr_sess_user_id');
        $this->session->remove('vr_sess_user_email');
        $this->session->remove('vr_sess_user_role');
        $this->session->remove('vr_sess_logged_in');
        $this->session->remove('vr_sess_app_key');
        $this->session->remove('vr_sess_user_ps');
        helper_deletecookie("remember_user_id");
        return redirect()->to('/');
    }

    public function run_internal_cron()
    {
        if ($this->request->isAJAX()) {
            //delete old sessions
            $this->db->query("DELETE FROM ci_sessions WHERE timestamp < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 3 DAY))");
        }
    }
}
