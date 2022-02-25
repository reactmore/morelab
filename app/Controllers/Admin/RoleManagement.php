<?php

namespace App\Controllers\Admin;

use App\Models\MenuManagementModel;
use App\Models\RolesPermissionsModel;

class RoleManagement extends AdminController
{

    public function __construct()
    {
        $this->RolesPermissionsModel = new RolesPermissionsModel();
        $this->MenuManagementModel = new MenuManagementModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title' => trans('roles_permissions'),
            'roles' => $this->RolesPermissionsModel->getRole()

        ]);

        return view('admin/role/roles_permissions', $data);
    }

    /**
     * Add Role Post
     */
    public function add_role_post()
    {

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'role_name' => [
                'label'  => trans('role_name'),
                'rules'  => 'required|min_length[4]|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],

        ];

        if ($this->validate($rules)) {
            $role = strtolower($this->request->getVar('role_name'));

            //is username unique
            if (!$this->RolesPermissionsModel->is_unique_role($role)) {
                $this->session->setFlashData('error', trans("message_unique_error"));
                return redirect()->back()->withInput();
            }

            $id =  $this->RolesPermissionsModel->AddRole();

            if ($id) {
                $this->session->setFlashData('success', trans("msg_suc_added"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back();
            }
        } else {
            $this->session->setFlashData("mes_add_role", 1);
            $this->session->setFlashData('error_array', $validation->getErrors());
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }
    }

    public function edit_role_post()
    {

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'id' => 'required',
            'id' => [
                'label'  => trans('id'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'role_name' => [
                'label'  => trans('role_name'),
                'rules'  => 'required|min_length[4]|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],

        ];

        if ($this->validate($rules)) {
            $id = clean_number($this->request->getVar('id'));
            $role = $this->request->getVar('role_name');

            //is username unique
            if (!$this->RolesPermissionsModel->is_unique_role($role, $id)) {
                $this->session->setFlashData('error', trans("message_unique_error"));
                return redirect()->back()->withInput();
            }

            if ($this->RolesPermissionsModel->UpdateRole($id)) {
                $this->session->setFlashData('success', trans("msg_suc_added"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back();
            }
        } else {
            $this->session->setFlashData("mes_add_role", 1);
            $this->session->setFlashData('error_array', $validation->getErrors());
            return redirect()->back()->withInput()->with('error_form', $validation->listErrors());
        }
    }

    public function delete_role_post()
    {
        $id = $this->request->getVar('id', FILTER_SANITIZE_STRING);
        $userAccess = $this->RolesPermissionsModel->checkUserAccess($id);

        if ($this->RolesPermissionsModel->delete_role($id)) {
            if ($userAccess > 0) {
                $this->RolesPermissionsModel->deleteUserPermission($id);
            }
            $this->session->setFlashData('success', trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    public function Permissions()
    {
        $role         = $this->request->getGet('role');
        $userRole     = $this->RolesPermissionsModel->get_role_by_name($role);

        if (!$userRole) {
            return redirect()->to(admin_url() . 'role-management');
        }

        $data = array_merge($this->data, [
            'title' => trans('permissions'),
            'role' => $userRole,
            'MenuCategories'    => $this->MenuManagementModel->getMenuCategory(),
            'Menus'                => $this->MenuManagementModel->getMenu(),
            'Submenus'            => $this->MenuManagementModel->getSubmenu(),
            'UserAccess'        => $this->RolesPermissionsModel->getAccessMenu($role),
        ]);


        return view('admin/role/permissions', $data);
    }

    public function changeMenuCategoryPermission()
    {
        $userAccess = $this->RolesPermissionsModel->checkUserMenuCategoryAccess($this->request->getPost(null, FILTER_SANITIZE_STRING));
        if ($userAccess > 0) {
            $this->RolesPermissionsModel->deleteMenuCategoryPermission($this->request->getPost(null, FILTER_SANITIZE_STRING));
        } else {
            $this->RolesPermissionsModel->insertMenuCategoryPermission($this->request->getPost(null, FILTER_SANITIZE_STRING));
        }
    }

    public function changeMenuPermission()
    {
        $userAccess = $this->RolesPermissionsModel->checkUserMenuAccess($this->request->getPost(null, FILTER_SANITIZE_STRING), 3);

        if ($userAccess > 0) {
            $this->RolesPermissionsModel->deleteMenuPermission($this->request->getPost(null, FILTER_SANITIZE_STRING));
        } else {
            $this->RolesPermissionsModel->insertMenuPermission($this->request->getPost(null, FILTER_SANITIZE_STRING));
        }
    }

    public function changeSubMenuPermission()
    {
        $userAccess = $this->RolesPermissionsModel->checkUserSubmenuAccess($this->request->getPost(null, FILTER_SANITIZE_STRING));
        if ($userAccess > 0) {
            $this->RolesPermissionsModel->deleteSubmenuPermission($this->request->getPost(null, FILTER_SANITIZE_STRING));
        } else {
            $this->RolesPermissionsModel->insertSubmenuPermission($this->request->getPost(null, FILTER_SANITIZE_STRING));
        }
    }
}
