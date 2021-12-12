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
}
