<?php

namespace App\Controllers\Auth;

use App\Libraries\Recaptcha;
use App\Models\UsersModel;

class Register extends AuthController
{
    public function index()
    {
        $this->is_registration_active();

        if ($this->session->get('vr_sess_logged_in') == TRUE) {
            return redirect()->to(base_url('/'));
        }

        $data['title'] = trans('register');

        return view('Auth/Register', $data);
    }

    /**
     * Register Post
     */
    public function admin_register_post()
    {

        $this->reset_flash_data();
        $userModel = new UsersModel();


        $rules = [
            'fullname' => [
                'label'  => trans('fullname'),
                'rules'  => 'required|min_length[4]|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
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
            ],
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

            if (!$this->recaptcha_verify_request()) {
                $this->session->setFlashData('errors_form', trans("msg_recaptcha"));
                return redirect()->to($this->agent->getReferrer());
            }

            $email = $this->request->getVar('email');
            $username = $this->request->getVar('username');

            //is username unique
            if (!$userModel->is_unique_username($username)) {
                $this->session->setFlashData('form_data', $userModel->input_values());
                $this->session->setFlashData('errors_form', trans("msg_username_unique_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }
            //is email unique
            if (!$userModel->is_unique_email($email)) {
                $this->session->setFlashData('form_data', $userModel->input_values());
                $this->session->setFlashData('errors_form', trans("message_email_unique_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }

            //register
            $user = $userModel->register();

            if ($user) {
                if (get_general_settings()->email_verification == 1) {
                    $this->session->setFlashData('success_form', trans("msg_send_confirmation_email"));
                } else {
                    $this->session->setFlashData('success_form', trans("msg_register_success"));
                }
                if ($userModel->is_logged_in()) {
                    return redirect()->to(admin_url());
                }

                return redirect()->to($this->agent->getReferrer());
            } else {
                //error
                $this->session->setFlashData('errors_form', trans("message_register_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }
        } else {
            $this->session->setFlashData('errors_form', $this->validator->listErrors());
            return redirect()->to($this->agent->getReferrer())->withInput()->with('error', $this->validator->getErrors());
        }
    }

    public function recaptcha_verify_request()
    {
        if (!recaptcha_status()) {
            return true;
        }

        $recaptchaLib = new Recaptcha();

        $recaptcha = $this->request->getVar('g-recaptcha-response');
        if (!empty($recaptcha)) {
            $response = $recaptchaLib->verifyResponse($recaptcha);
            if (isset($response['success']) && $response['success'] === true) {
                return true;
            }
        }
        return false;
    }

    /**
     * Confirm Email
     */
    public function confirm_email()
    {
        $userModel = new UsersModel();
        $data['title'] = trans("confirm_your_email");

        $token = clean_str($this->request->getVar("token"));
        $data["user"] = $userModel->get_user_by_token($token);

        if (empty($data["user"])) {
            return redirect()->to(base_url());
        }

        if ($data["user"]->email_status == 1) {
            return redirect()->to(base_url());
        }

        if ($userModel->verify_email($data["user"])) {

            $data["success"] = trans("msg_confirmed");
        } else {
            $data["error"] = trans("msg_error");
        }


        echo view('auth/confirm_email', $data);
    }

    //check if membership system active
    private function is_registration_active()
    {
        if (get_general_settings()->registration_system != 1) {
            return redirect()->to(lang_base_url());
        }
    }

    //reset flash data
    private function reset_flash_data()
    {
        $this->session->setFlashData('errors_form', "");
        $this->session->setFlashData('errors_form', "");
        $this->session->setFlashData('success_form', "");
    }
}
