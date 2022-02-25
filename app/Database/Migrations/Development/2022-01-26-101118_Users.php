<?php

namespace App\Database\Migrations\Development;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'fullname'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],

            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],

            'slug' => [
                'type'           => 'VARCHAR',
                'constraint'     => '999',
                'null' => true,
            ],

            'email' => [
                'type'           => 'VARCHAR',
                'constraint'     => '35',
                'null' => true,
            ],

            'mobile_no' => [
                'type'           => 'BIGINT',
                'constraint'     => 201,
                'null' => true,
            ],

            'email_status' => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'null' => false,
                'default' => 0

            ],

            'token' => [
                'type' => 'VARCHAR',
                'constraint' => '999',
                'null' => true,
            ],

            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],

            'role' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],

            'user_type' => [
                'type' => 'VARCHAR',
                'constraint' => '999',
                'null' => false,
                'default' => 'registered',
            ],

            'google_id' => [
                'type' => 'VARCHAR',
                'constraint' => '999',
                'null' => true,
            ],

            'status' => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'null' => false,
                'default' => 0

            ],


            'avatar' => [
                'type' => 'VARCHAR',
                'constraint' => '999',
                'null' => true,
            ],

            'about_me' => [
                'type' => 'VARCHAR',
                'constraint' => '999',
                'null' => true,
            ],

            'country_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],

            'state_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],

            'city_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],

            'address' => [
                'type' => 'text',
                'null' => true,
            ],

            'zip_code' => [
                'type' => 'VARCHAR',
                'constraint' => '90',
                'null' => true,
            ],

            'last_seen' => [
                'type'           => 'TIMESTAMP',
                'null' => true,
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type'           => 'DATETIME',
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
