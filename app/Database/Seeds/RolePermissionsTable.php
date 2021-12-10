<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use \CodeIgniter\I18n\Time;

class RolePermissionsTable extends Seeder
{
    public function run()
    {

        $data = [
            [
                'role'        => 'admin',
                'role_name'     => 'Admin',
                'admin_panel'     => 1,
                'users'     => 1,
                'settings'     => 1,
                'deleted'     => 0,
                'created_at'  =>  date("Y-m-d H:i:s")
            ],
            [
                'role'        => 'user',
                'role_name'     => 'User',
                'admin_panel'     => 0,
                'users'     => 0,
                'settings'     => 0,
                'deleted'     => 0,
                'created_at'  =>  date("Y-m-d H:i:s")
            ]

        ];

        $this->db->table('roles_permissions')->insert($data);
    }
}
