<?php

namespace App\Models;

use CodeIgniter\Model;

class RolesPermissionsModel extends Model
{
    protected $table            = 'user_role';
    protected $primaryKey       = 'id';

    protected $session;

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->request = \Config\Services::request();
    }

    public function getRole($role_id = false)
    {
        if ($role_id) {
            return   $this->asObject()->find($role_id);
        }

        return $this->asObject()->findAll();
    }

    public function getRoles()
    {
        $sql = "SELECT * FROM $this->table WHERE role_name != ?";
        $query = $this->db->query($sql, array('Developer'));
        return $query->getResult();
    }

    public function get_role_by_name($role)
    {
        $sql = "SELECT * FROM $this->table WHERE role_name = ?";
        $query = $this->db->query($sql, array(clean_str($role)));
        return $query->getRow();
    }

    public function is_unique_role($role, $role_id = 0)
    {
        $role = $this->get_role_by_name($role);
        //if id doesnt exists
        if ($role_id == 0) {
            if (empty($role)) {
                return true;
            } else {
                return false;
            }
        }
        if ($role_id != 0) {
            if (!empty($role) && $role->id != $role_id) {
                return false;
            } else {
                return true;
            }
        }
    }

    // Add New Role 
    public function AddRole()
    {
        $data = array(
            'role_name' => $this->request->getVar('role_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        );

        return $this->builder()->insert($data);
    }

    //update Role
    public function UpdateRole($id)
    {
        $data = array(
            'role_name' => $this->request->getVar('role_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        );


        return $this->builder()->where('id', $id)->update($data);
    }

    //delete Role
    public function delete_role($id)
    {
        $id = clean_number($id);
        $role = $this->asObject()->find($id);
        if (!empty($role) && $role->id != 1) {
            return $this->delete($role->id);
        }
        return false;
    }

    public function checkUserAccess($id, int $options = 1)
    {
        if ($options === 1) {
            return  $this->db->table('user_access')
                ->where([
                    'role_id' => $id,
                ])
                ->countAllResults();
        }

        if ($options === 2) {
            return  $this->db->table('user_access')
                ->where([
                    'menu_category_id' => $id,
                ])
                ->countAllResults();
        }

        if ($options === 3) {
            return  $this->db->table('user_access')
                ->where([
                    'menu_id' => $id,
                ])
                ->countAllResults();
        }

        if ($options === 4) {
            return  $this->db->table('user_access')
                ->where([
                    'submenu_id' => $id,
                ])
                ->countAllResults();
        }
    }


    public function deleteUserPermission($id, $column = 'role_id')
    {
        return $this->db->table('user_access')->delete([$column => $id]);
    }



    public function getAccessMenuCategory($role)
    {
        return $this->db->table('user_menu_category')
            ->select('*,user_menu_category.id AS menuCategoryID, user_menu_category.position_order')
            ->join('user_access', 'user_menu_category.id = user_access.menu_category_id')
            ->orderBy('user_menu_category.position_order', 'ASC')
            ->where(['user_access.role_id' => $role])
            ->get()->getResultArray();
    }



    public function getAccessMenu($role)
    {
        return $this->db->table('user_menu')
            ->join('user_access', 'user_menu.id = user_access.menu_id')
            ->where(['user_access.role_id' => $role])
            ->get()->getResultArray();
    }




    // CRUD PERMISSIONS 
    public function checkUserMenuCategoryAccess($dataAccess)
    {
        return  $this->db->table('user_access')
            ->where([
                'role_id' => $dataAccess['roleID'],
                'menu_category_id' => $dataAccess['menuCategoryID']
            ])
            ->countAllResults();
    }

    public function checkUserMenuAccess($dataAccess)
    {
        return  $this->db->table('user_access')
            ->where([
                'role_id' => $dataAccess['roleID'],
                'menu_id' => $dataAccess['menuID']
            ])
            ->countAllResults();
    }

    public function checkUserSubmenuAccess($dataAccess)
    {
        return  $this->db->table('user_access')
            ->where([
                'role_id' => $dataAccess['roleID'],
                'submenu_id' => $dataAccess['submenuID']
            ])
            ->countAllResults();
    }
    public function insertMenuCategoryPermission($dataAccess)
    {
        return $this->db->table('user_access')->insert(['role_id' => $dataAccess['roleID'], 'menu_category_id' => $dataAccess['menuCategoryID']]);
    }
    public function deleteMenuCategoryPermission($dataAccess)
    {
        return $this->db->table('user_access')->delete(['role_id' => $dataAccess['roleID'], 'menu_category_id' => $dataAccess['menuCategoryID']]);
    }

    public function insertMenuPermission($dataAccess)
    {
        return $this->db->table('user_access')->insert(['role_id' => $dataAccess['roleID'], 'menu_id' => $dataAccess['menuID']]);
    }
    public function deleteMenuPermission($dataAccess)
    {
        return $this->db->table('user_access')->delete(['role_id' => $dataAccess['roleID'], 'menu_id' => $dataAccess['menuID']]);
    }

    public function insertSubmenuPermission($dataAccess)
    {
        return $this->db->table('user_access')->insert(['role_id' => $dataAccess['roleID'], 'submenu_id' => $dataAccess['submenuID']]);
    }

    public function deleteSubmenuPermission($dataAccess)
    {
        return $this->db->table('user_access')->delete(['role_id' => $dataAccess['roleID'], 'submenu_id' => $dataAccess['submenuID']]);
    }
}
