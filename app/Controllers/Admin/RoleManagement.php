<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;

class RoleManagement extends BaseController
{
    /**
     * Roles And Permissions
     *
     * @Method 
     */
    public function index()
    {

        $data['title'] = trans("roles_permissions");

        $data['roles'] = $this->RolesPermissionsModel->get_roles_permissions();
        $data['permissions'] = get_permissions_field();

        return view('admin/roles/roles_permissions', $data);
    }

    public function add_role()
    {

        $data['title'] = trans("add_role");

        return view('admin/roles/add_role', $data);
    }

    /**
     * Add Role Post
     */
    public function add_role_post()
    {
        if (!is_admin()) {
            return redirect()->to(admin_url());
        }

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'role'      => 'required|min_length[4]|max_length[100]',
        ];

        if ($this->validate($rules)) {
            $role = strtolower($this->request->getVar('role'));


            //is username unique
            if (!$this->RolesPermissionsModel->is_unique_role($role)) {
                $this->session->setFlashData('error', trans("message_unique_error"));
                return redirect()->back()->withInput();
            }

            //add user
            $id =  $this->RolesPermissionsModel->AddRole();
            if ($id) {
                $this->session->setFlashData('success', trans("msg_suc_added"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back();
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    public function edit_role($id)
    {

        if ($id == 1) {
            return redirect()->to(admin_url() . 'roles-permissions');
        }

        $data['title'] = trans("edit_role");
        $data['role'] = $this->RolesPermissionsModel->get_role($id);

        if (empty($data['role'])) {
            return redirect()->to(admin_url() . 'roles-permissions');
        }

        return view('admin/roles/edit_role', $data);
    }

    /**
     * Edit Role Post
     */
    public function edit_role_post()
    {

        if (!is_admin()) {
            return redirect()->to(admin_url());
        }

        $id = $this->request->getVar('id');

        if ($this->RolesPermissionsModel->update_role($id)) {
            $this->session->setFlashData('success', trans("msg_updated"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }

        return redirect()->back();
    }

    public function delete_role_post()
    {
        if (!is_admin()) {
            return redirect()->to(admin_url());
        }
        $id = $this->request->getVar('id');
        $role = $this->RolesPermissionsModel->asObject()->find($id);

        if ($role->id == 1) {
            $this->session->setFlashData('error', trans("msg_error"));
            exit();
        }


        if ($this->RolesPermissionsModel->delete_role($id)) {
            $this->session->setFlashData('success',  trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }
}
