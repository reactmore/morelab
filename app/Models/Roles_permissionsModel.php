<?php

namespace App\Models;

use CodeIgniter\Model;

class Roles_permissionsModel extends Model
{
    protected $table            = 'roles_permissions';
    protected $primaryKey       = 'id';

    //get roles and permissions
    public function get_roles_permissions()
    {
        $sql = "SELECT * FROM $this->table";
        $query = $this->db->query($sql);
        return $query->getResultArray();
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

    //get role by key
    public function get_role_by_key($key)
    {
        $sql = "SELECT * FROM $this->table WHERE role = ?";
        $query = $this->db->query($sql, array(clean_str($key)));
        return $query->getRow();
    }

    // //update role
    // public function update_role($id)
    // {
    //     $data = array(
    //         'admin_panel' => $this->input->post('admin_panel', true) == 1 ? 1 : 0,
    //         'users' => $this->input->post('users', true) == 1 ? 1 : 0,
    //         'settings' => $this->input->post('settings', true) == 1 ? 1 : 0,
    //     );

    //     $this->db->where('id', $id);
    //     return $this->db->update('roles_permissions', $data);
    // }
}
