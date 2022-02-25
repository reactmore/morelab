<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\EmailModel;
use App\Models\Locations\CityModel;
use App\Models\Locations\CountryModel;
use App\Models\Locations\StateModel;
use App\Models\ProfileModel;

class Profile extends AdminController
{
    protected $cityModel;
    protected $stateModel;
    protected $countryModel;

    public function __construct()
    {
        $this->cityModel = new CityModel();
        $this->stateModel = new StateModel();
        $this->countryModel = new CountryModel();
    }
    /**
     * Update Profile
     */
    public function index()
    {

        $data = array_merge($this->data, [
            'title'     => trans('profile'),
            'active_tab'     => 'details',
            'user'     =>  user()

        ]);


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
            'slug' => [
                'label'  => trans('slug'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

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

        $data = array_merge($this->data, [
            'title'     => trans('change_password'),
            'active_tab'     => 'change_password',
            'user'     =>  user()

        ]);

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
     * Update Profile address information
     */
    public function address_information()
    {

        $data = array_merge($this->data, [
            'title'     => trans('address_information'),
            'active_tab'     => 'address_information',
            'user'     =>  user(),
            'countries'     => $this->countryModel->asObject()->where('status', 1)->findAll(),
            'states'     => $this->stateModel->asObject()->where('country_id', user()->country_id)->findAll(),
            'cities'     =>  $this->cityModel->asObject()->where('state_id', user()->state_id)->findAll(),

        ]);

        return view('admin/profile/profile', $data);
    }

    /**
     * address information Post
     */
    public function address_information_post()
    {
        //validate inputs

        $rules = [
            'country_id' => [
                'label'  => trans('country'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'state_id' => [
                'label'  => trans('state'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'city_id' => [
                'label'  => trans('city'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'address'    => [
                'label'  => trans('address'),
                'rules'  => 'required|min_length[10]|max_length[200]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),

                ],

            ],
            'zip_code'    => [
                'label'  => trans('zip_code'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ]
            ]
        ];


        if ($this->validate($rules)) {
            $profileModel = new ProfileModel();
            if ($profileModel->update_address(user()->id)) {
                $this->session->setFlashData('success', trans("msg_updated"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }
        } else {
            $this->session->setFlashData('errors_form', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Update Profile
     */
    public function delete_account()
    {
        $data = array_merge($this->data, [
            'title'     => trans('delete_account'),
            'active_tab'     => 'delete_account',
            'user'     =>  user(),


        ]);


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

            if (!password_verify($password, $user->password)) {
                $this->session->setFlashData('error', trans("msg_wrong_password"));
                return redirect()->to($this->agent->getReferrer());
            }

            //delete account
            $this->userModel->delete_user($user->id);
            $this->userModel->logout();
            return redirect()->to(base_url());
        }
    }
}
