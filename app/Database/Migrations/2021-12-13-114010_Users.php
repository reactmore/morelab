<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'first_name'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'default' => 'email@domain.com'
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'mobile_no' => [
                'type' => 'BIGINT',
                'constraint' => '19',
                'null' => true,
            ],
            'email_status' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true,
                'default' => '0'
            ],
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'default' => 'user'
            ],
            'user_type' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'google_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'facebook_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],

            'avatar' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true,
            ],
            'about_me' => [
                'type' => 'VARCHAR',
                'constraint' => '5000',
                'null' => true,
            ],
            'last_seen' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
