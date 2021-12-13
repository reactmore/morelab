<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Routes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'admin'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'admin'
            ],
            'profile' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'profile'
            ],
            'change_password' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'change-password'
            ],
            'forgot_password' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'forgot-password'

            ],
            'reset_password' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'reset-password'
            ],
            'delete_account' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'delete-account'
            ],
            'register' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'register'
            ],
            'login' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'login'
            ],
            'logout' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'logout'
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('routes');
    }

    public function down()
    {
        $this->forge->dropTable('routes');
    }
}
