<?php

namespace App\Database\Migrations\Development;

use CodeIgniter\Database\Migration;

class Languages extends Migration
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
            'name'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'       => true,
            ],
            'short_form'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'language_code'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'text_direction'       => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'text_editor_lang'       => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => true,
            ],
            'status'       => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'null'       => true,
                'default' => 1
            ],
            'language_order'  => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'null'       => true,
                'default' => 1

            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('languages');
    }

    public function down()
    {
        $this->forge->dropTable('languages');
    }
}
