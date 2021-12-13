<?php

namespace App\Models;

use CodeIgniter\Model;

class Roles_permissionsModel extends Model
{
    protected $table            = 'roles_permissions';
    protected $primaryKey       = 'id';

    public function __construct()
    {
        parent::__construct();


        $this->session = session();
        $this->db = db_connect();

        $this->request = \Config\Services::request();
        // $this->builder = $this->table('mytable');
    }

    //get roles and permissions
    public function get_roles_permissions()
    {
        $sql = "SELECT * FROM $this->table";
        $query = $this->db->query($sql);
        return $query->getResult();
    }

    //get roles and permissions W/o Admin
    public function get_roles()
    {
        $sql = "SELECT * FROM $this->table WHERE role != ?";
        $query = $this->db->query($sql, array('admin'));
        return $query->getResult();
    }

    //get role
    public function get_role($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->getRow();
    }
    //get role
    public function get_role_by_role($role)
    {
        $sql = "SELECT * FROM $this->table WHERE role = ?";
        $query = $this->db->query($sql, array(clean_str($role)));
        return $query->getRow();
    }

    //get role by key
    public function get_role_by_key($key)
    {
        $sql = "SELECT * FROM $this->table WHERE role = ?";
        $query = $this->db->query($sql, array(clean_str($key)));
        return $query->getRow();
    }

    //update role
    public function update_role($id)
    {
        $data = array(
            'admin_panel' => $this->request->getVar('admin_panel') == 1 ? 1 : 0,
            'users' => $this->request->getVar('users') == 1 ? 1 : 0,
            'settings' => $this->request->getVar('settings') == 1 ? 1 : 0,
        );

        return $this->builder()->where('id', $id)->update($data);
    }


    //check if email is unique
    public function is_unique_role($role, $user_id = 0)
    {
        $role = $this->get_role_by_role($role);
        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($role)) {
                return true;
            } else {
                return false;
            }
        }
        if ($user_id != 0) {
            if (!empty($role) && $role->id != $user_id) {
                //email taken
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
            'role' => strtolower($this->request->getVar('role')),
            'role_name' => ucfirst($this->request->getVar('role')),
        );

        $fields = $this->db->getFieldNames('roles_permissions');

        foreach ($fields as $field) {
            if ($field == 'id' || $field == 'role' || $field == 'role_name') {
                continue;
            }

            $data[$field] = $this->request->getVar($field) == 1 ? 1 : 0;
        }


        return $this->builder()->insert($data);
    }

    //delete user
    public function delete_role($id)
    {
        $id = clean_number($id);
        $role = $this->get_role($id);
        if (!empty($role)) {
            return $this->builder()->where('id', $id)->delete();
        }
        return false;
    }


    // Add New Permissions 
    public function added_permissions()
    {
        $forge = \Config\Database::forge();
        //secure password
        $fields = [
            strtolower($this->request->getVar('role')) => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null' => false,

            ],
        ];


        return $forge->addColumn($this->table, $fields);
    }
}
