<?php

namespace App\Database\Migrations\Development;

use CodeIgniter\Database\Migration;

class Images extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'image_big'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'       => true
            ],
            'image_default'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'       => true
            ],
            'image_slider'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'       => true
            ],
            'image_mid'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'       => true
            ],
            'image_small'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'       => true
            ],
            'image_mime'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'       => true,
                'default'       => 'jpg'
            ],
            'file_name'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'       => true
            ],
            'captions'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'       => true
            ],
            'captions'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'       => true
            ],
            'descriptions'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '999',
                'null'       => true
            ],
            'alt'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'       => true
            ],
            'storage'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'       => true,
                'default' => 'local'
            ],
            'user_id'      => [
                'type'           => 'INT',
                'constraint'     => '11',
                'null'       => true
            ],


        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('images');
    }

    public function down()
    {
        $this->forge->dropTable('images');
    }
}
