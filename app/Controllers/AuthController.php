<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends BaseController
{

    public function index()
    {
        $data['title'] = 'Login';

        return view('admin/login', $data);
    }

    /**
     * Admin Login Post
     */
    public function admin_login_post()
    {

        $userModel = new User();
        $maintenance_mode_status = 1;
        $validation =  \Config\Services::validation();

        $rules = [
            'email'         => 'required|min_length[4]|max_length[100]|valid_email',
            'password'      => 'required|min_length[4]|max_length[50]',
        ];

        if ($this->validate($rules)) {
            $user = $userModel->get_user_by_email($this->request->getVar('email'));
            if (!empty($user) && $user->role != 'admin' && $maintenance_mode_status == 1) {
                $this->session->setFlashData('errors_form', "Site under construction! Please try again later.");
                return redirect()->back();
            }

            if ($userModel->login()) {
                return redirect()->to('/');
            } else {
                return redirect()->back();
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back();
        }
    }
}
