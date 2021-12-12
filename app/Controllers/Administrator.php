<?php

namespace App\Controllers;

use App\Controllers\BaseController;

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
        check_admin();
        $data['title'] = trans("administrators");
        //paginate
        $data['paginate'] = $this->userModel->administratorsPaginate();
        $data['pager'] =  $data['paginate']['pager'];

        return view('admin/users/administrators', $data);
    }

    public function users()
    {
        check_permission('users');
        // if (!check_user_permission('users')) {
        //     return redirect()->to(admin_url());
        // }
        $data['title'] = trans("users");
        //paginate
        $data['paginate'] = $this->userModel->userPaginate();
        $data['pager'] =  $data['paginate']['pager'];


        return view('admin/users/users', $data);
    }

    public function add_user()
    {
        check_admin();
        $data['title'] = trans("add_user");
        $data['roles'] = $this->RolesPermissionsModel->get_roles_permissions();



        return view('admin/users/add_users', $data);
    }

    /**
     * Add User Post
     */
    public function add_user_post()
    {
        check_admin();
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
                $this->session->setFlashData('errors_form', trans("msg_username_unique_error"));
                return redirect()->back()->withInput();
            }
            //is email unique
            if (!$this->userModel->is_unique_email($email)) {
                $this->session->setFlashData('form_data', $this->userModel->input_values());
                $this->session->setFlashData('errors_form', trans("message_email_unique_error"));
                return redirect()->back()->withInput();
            }

            //add user
            $id =  $this->userModel->add_user();
            if ($id) {
                $this->session->setFlashData('success_form', trans("msg_user_added"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('errors_form', trans("msg_error"));
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
        check_permission('users');
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
        check_permission('users');

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
                $this->session->setFlashData('success_form', trans("msg_updated"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('errors_form', trans("msg_error"));
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
        check_permission('users');
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
}
