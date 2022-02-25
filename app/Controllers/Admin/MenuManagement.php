<?php

namespace App\Controllers\Admin;

use App\Models\MenuManagementModel;
use App\Models\RolesPermissionsModel;

class MenuManagement extends AdminController
{

    public function __construct()
    {
        $this->MenuManagementModel = new MenuManagementModel();
        $this->RolesPermissionsModel = new RolesPermissionsModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title' => trans('menu_management'),
            'MenuCategories'    => $this->MenuManagementModel->getMenuCategory(),
            'Menus'                => $this->MenuManagementModel->getMenu(),
            'Submenus'            => $this->MenuManagementModel->getSubmenu(),

        ]);



        return view('admin/menu/menu_management', $data);
    }

    public function add_menu_category_post()
    {

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'menu_category' => [
                'label'  => trans('menu_category'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'menu_category_order' => [
                'label'  => trans('menu_order'),
                'rules'  => 'numeric',
            ],
        ];

        if ($this->validate($rules)) {
            $menu_category = $this->request->getVar('menu_category');

            //is username unique
            if (!$this->MenuManagementModel->is_unique_input(1, 'menu_category', $menu_category)) {
                $this->session->setFlashData('error', trans("message_unique_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }


            if ($this->MenuManagementModel->addMenuCategory()) {
                $this->session->setFlashData('success', trans("msg_suc_added"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }
        } else {
            $this->session->setFlashData("mes_add_category", 1);
            $this->session->setFlashData('error_array', $validation->getErrors());
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }
    }

    public function edit_menu_category_post()
    {

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [

            'id' => [
                'label'  => trans('id'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'menu_category' => [
                'label'  => trans('menu_category'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'menu_category_order' => [
                'label'  => trans('menu_order'),
                'rules'  => 'numeric',
            ],

        ];

        if ($this->validate($rules)) {
            $id = clean_number($this->request->getVar('id'));
            $menu_category = $this->request->getVar('menu_category');

            //is username unique
            if (!$this->MenuManagementModel->is_unique_input(1, 'menu_category', $menu_category,  $id)) {
                $this->session->setFlashData('error', trans("message_unique_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }


            if ($this->MenuManagementModel->editMenuCategory($id)) {
                $this->session->setFlashData('success', trans("msg_suc_updated"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }
        } else {
            $this->session->setFlashData("mes_add_category", 1);
            $this->session->setFlashData('error_array', $validation->getErrors());
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }
    }

    public function delete_menu_category_post()
    {
        $id = $this->request->getVar('id', FILTER_SANITIZE_STRING);

        $userAccess = $this->RolesPermissionsModel->checkUserAccess($id, 2);

        if ($this->MenuManagementModel->delete_menu_category($id)) {
            if ($userAccess > 0) {
                $this->RolesPermissionsModel->deleteUserPermission($id, 'menu_category_id');
            }
            $this->session->setFlashData('success', trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    public function add_menu_post()
    {

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'menu_category' => [
                'label'  => trans('menu_category'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'menu_title' => [
                'label'  => trans('menu_title'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'menu_url' => [
                'label'  => trans('menu_url'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'menu_icon' => [
                'label'  => trans('menu_icon'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'menu_order' => [
                'label'  => trans('menu_order'),
                'rules'  => 'numeric',
            ],

        ];

        if ($this->validate($rules)) {
            $menu_title = $this->request->getVar('menu_title');

            //is username unique
            if (!$this->MenuManagementModel->is_unique_input(2, 'title', $menu_title)) {
                $this->session->setFlashData('error', trans("message_unique_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }


            if ($this->MenuManagementModel->addMenu()) {
                $this->session->setFlashData('success', trans("msg_suc_added"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }
        } else {
            $this->session->setFlashData("mes_add_menu", 1);
            $this->session->setFlashData('error_array', $validation->getErrors());
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }
    }

    public function edit_menu_post()
    {

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'id' => [
                'label'  => trans('id'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'menu_category' => [
                'label'  => trans('menu_category'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'menu_title' => [
                'label'  => trans('menu_title'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'menu_url' => [
                'label'  => trans('menu_url'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'menu_icon' => [
                'label'  => trans('menu_icon'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'menu_order' => [
                'label'  => trans('menu_order'),
                'rules'  => 'numeric',
            ],
        ];

        if ($this->validate($rules)) {
            $id = clean_number($this->request->getVar('id'));
            $menu_title = $this->request->getVar('menu_title');

            //is username unique
            if (!$this->MenuManagementModel->is_unique_input(2, 'title', $menu_title,  $id)) {
                $this->session->setFlashData('error', trans("message_unique_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }


            if ($this->MenuManagementModel->editMenu($id)) {
                $this->session->setFlashData('success', trans("msg_suc_updated"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }
        } else {
            $this->session->setFlashData("mes_add_category", 1);
            $this->session->setFlashData('error_array', $validation->getErrors());
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }
    }

    public function delete_menu_post()
    {
        $id = $this->request->getVar('id', FILTER_SANITIZE_STRING);

        $userAccess = $this->RolesPermissionsModel->checkUserAccess($id, 3);

        if ($this->MenuManagementModel->delete_menu($id)) {
            if ($userAccess > 0) {
                $this->RolesPermissionsModel->deleteUserPermission($id, 'menu_id');
            }
            $this->session->setFlashData('success', trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    public function add_submenu_post()
    {

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'menu_parent' => [
                'label'  => trans('menu_parent'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'submenu_title' => [
                'label'  => trans('submenu_title'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'submenu_url' => [
                'label'  => trans('submenu_url'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'submenu_order' => [
                'label'  => trans('menu_order'),
                'rules'  => 'numeric',
            ],
        ];

        if ($this->validate($rules)) {
            $submenu_title = $this->request->getVar('submenu_title');

            //is username unique
            if (!$this->MenuManagementModel->is_unique_input(3, 'title', $submenu_title)) {
                $this->session->setFlashData('error', trans("message_unique_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }


            if ($this->MenuManagementModel->addSubMenu()) {
                $this->session->setFlashData('success', trans("msg_suc_added"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }
        } else {
            $this->session->setFlashData("mes_add_submenu", 1);
            $this->session->setFlashData('error_array', $validation->getErrors());
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }
    }

    public function edit_submenu_post()
    {

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'id' => [
                'label'  => trans('id'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'menu_parent' => [
                'label'  => trans('menu_parent'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'submenu_title' => [
                'label'  => trans('submenu_title'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'submenu_url' => [
                'label'  => trans('submenu_url'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'submenu_order' => [
                'label'  => trans('menu_order'),
                'rules'  => 'numeric',
            ],

        ];

        if ($this->validate($rules)) {
            $id = clean_number($this->request->getVar('id'));
            $submenu_title = $this->request->getVar('submenu_title');

            //is username unique
            if (!$this->MenuManagementModel->is_unique_input(3, 'title', $submenu_title,  $id)) {
                $this->session->setFlashData('error', trans("message_unique_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }


            if ($this->MenuManagementModel->editSubMenu($id)) {
                $this->session->setFlashData('success', trans("msg_suc_updated"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->to($this->agent->getReferrer())->withInput();
            }
        } else {
            $this->session->setFlashData("mes_add_submenu", 1);
            $this->session->setFlashData('error_array', $validation->getErrors());
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }
    }

    public function delete_submenu_post()
    {
        $id = $this->request->getVar('id', FILTER_SANITIZE_STRING);

        $userAccess = $this->RolesPermissionsModel->checkUserAccess($id, 4);

        if ($this->MenuManagementModel->delete_submenu($id)) {
            if ($userAccess > 0) {
                $this->RolesPermissionsModel->deleteUserPermission($id, 'submenu_id');
            }
            $this->session->setFlashData('success', trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }
}
