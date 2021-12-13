<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RolesPermission extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'auto_increment' => true,
            ],
            'role'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'role_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'admin_panel' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => false,
            ],
            'users' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => false,

            ],
            'settings' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => false,
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('roles_permissions');
    }

    public function down()
    {
        $this->forge->dropTable('roles_permissions');
    }
}
