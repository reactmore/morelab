<?php

namespace App\Controllers;

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

        return view('admin/login', $data);
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
                    $this->response->setCookie(config('cookie')->prefix . '_remember_user_id', user()->id, time() + 86400)->setHeader('Location', '/');
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
}
