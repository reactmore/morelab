<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\EmailModel;
use App\Models\ProfileModel;

class Profile extends BaseController
{
    /**
     * Update Profile
     */
    public function index()
    {

        $data['title'] = trans("profile");
        $data["user"] = user();

        $data["active_tab"] = "details";

        return view('admin/profile/profile', $data);
    }

    public function profile_post()
    {
        $user_id = user()->id;
        $action = clean_str($this->request->getVar('submit'));

        if ($action == "resend_activation_email") {
            //send activation email
            $emailModel = new EmailModel();
            $emailModel->send_email_activation($user_id);
            $this->session->setFlashData('success', trans("msg_send_confirmation_email"));
            return redirect()->to($this->agent->getReferrer());
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

        if ($this->validate($rules)) {
            $data = array(
                'username' => $this->request->getVar('username'),
                'slug' => $this->request->getVar('slug'),
                'email' => $this->request->getVar('email')
            );

            //is email unique
            if (!$this->userModel->is_unique_username($data["email"], $user_id)) {
                $this->session->setFlashData('errors_form', trans("message_email_unique_error"));
                return redirect()->back()->withInput();
            }
            //is username unique
            if (!$this->userModel->is_unique_username($data["username"], $user_id)) {
                $this->session->setFlashData('errors_form', trans("msg_username_unique_error"));
                return redirect()->back()->withInput();
            }
            //is slug unique
            if ($this->userModel->check_is_slug_unique($data["slug"], $user_id)) {
                $this->session->setFlashData('errors_form', trans("msg_slug_used"));
                return redirect()->back()->withInput();
            }

            $profileModel = new ProfileModel();
            if ($profileModel->update_profile($user_id)) {
                $this->session->setFlashData('success', trans("msg_updated"));
                //check email changed
                if ($profileModel->check_email_updated($user_id)) {
                    $this->session->setFlashData('success', trans("msg_send_confirmation_email"));
                }
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->to($this->agent->getReferrer());
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    /**
     * Update Profile
     */
    public function change_password()
    {

        $data['title'] = trans("change_password");
        $data["user"] = user();

        $data["active_tab"] = "change_password";

        return view('admin/profile/profile', $data);
    }

    /**
     * Change Password Post
     */
    public function change_password_post()
    {

        $old_password_exists = $this->request->getVar('old_password_exists');

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'password' => [
                'label'  => trans('form_password'),
                'rules'  => 'required|min_length[4]|max_length[50]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],

            'password_confirm'    => [
                'label'  => trans('form_confirm_password'),
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),

                ],
            ]
        ];

        if ($old_password_exists) {
            $rules['old_password'] = [
                'label'  => trans('form_old_password'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ]
            ];
        }

        if ($this->validate($rules)) {
            $profileModel = new ProfileModel();
            if ($profileModel->change_password($old_password_exists)) {
                $this->session->setFlashData('success', trans("message_change_password_success"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('error', trans("message_change_password_error"));
                return redirect()->to($this->agent->getReferrer());
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Update Profile
     */
    public function delete_account()
    {

        $data['title'] = trans("delete_account");
        $data["user"] = user();

        $data["active_tab"] = "delete_account";

        return view('admin/profile/profile', $data);
    }

    /**
     * Delete Account Post
     */
    public function delete_account_post()
    {

        $user = user();
        if (!empty($user)) {
            $confirm = $this->request->getVar('confirm');
            $password = $this->request->getVar('password');
            if (empty($confirm)) {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->to($this->agent->getReferrer());
            }
            if (!$this->bcrypt->check_password($password, $user->password)) {
                $this->session->setFlashData('error', trans("msg_wrong_password"));
                return redirect()->to($this->agent->getReferrer());
            }

            //delete account
            $this->userModel->delete_user($user->id);
            $this->userModel->lgoout();
            return redirect()->to(base_url());
        }
    }
}
