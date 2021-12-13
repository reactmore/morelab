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
                'admin_panel'     => '1',
                'users'     => '1',
                'settings'     => '1',

            ],
            [
                'role'        => 'user',
                'role_name'     => 'User',
                'admin_panel'     => '1',
                'users'     => '1',
                'settings'     => '1',

            ]

        ];

        $this->db->table('roles_permissions')->insert($data);
    }
}
