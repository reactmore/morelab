<?php

namespace App\Controllers\Auth;

use App\Models\EmailModel;
use App\Models\UsersModel;

class ResetPassword extends AuthController
{
    public function index()
    {
        $userModel = new UsersModel();
        if ($this->session->get('vr_sess_logged_in') == TRUE) {
            return redirect()->to(base_url('/'));
        }

        $token = clean_str($this->request->getVar('token'));
        $data['title'] = trans('reset_password');

        $data["user"] =   $userModel->get_user_by_token($token);
        $data["success"] = $this->session->get('success_form');
        if (empty($data["user"]) && empty($data["success"])) {
            return redirect()->to($this->agent->getReferrer());
        }

        return view('Auth/ResetPassword', $data);
    }

    /**
     * Forgot Password Post
     */
    public function reset_password_post()
    {
        $userModel = new UsersModel();

        $success = $this->request->getVar('success_form');
        if ($success == 1) {
            redirect(lang_base_url());
        }
        $rules = [
            'password' => [
                'label'  => trans('password'),
                'rules'  => 'required|min_length[4]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                ],
            ],
            'confirm_password' => [
                'label'  => trans('password'),
                'rules'  => 'required|min_length[4]|matches[password]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'matches' => 'Password Not Match!',

                ],
            ],


        ];

        if ($this->validate($rules)) {

            $token = clean_str($this->request->getVar('token'));
            if ($userModel->reset_password($token)) {
                $this->session->setFlashData('success_form', trans("message_change_password_success"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('errors_form', trans("message_change_password_error"));
                return redirect()->to($this->agent->getReferrer());
            }
        } else {
            $this->session->setFlashData('errors_form', $this->validator->listErrors());
            return redirect()->to($this->agent->getReferrer())->withInput()->with('error', $this->validator->getErrors());
        }
    }
}
