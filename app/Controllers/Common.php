<?php

namespace App\Controllers;

use App\Models\UserModel;

class Common extends BaseController
{

    /**
     * --------------------------------------------------------------------------
     * Login Page Admin Controller
     * --------------------------------------------------------------------------
     */

    public function index()
    {
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
                return redirect()->to('/');
            } else {
                return redirect()->back()->withInput()->with('error', $validation->getErrors());
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }
}