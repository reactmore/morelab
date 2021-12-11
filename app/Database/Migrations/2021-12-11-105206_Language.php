<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Language extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'short_form' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'language_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'text_direction' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null' => false
            ],
            'text_editor_lang' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null' => true
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => false,
                'default' => '1'
            ],
            'language_order' => [
                'type' => 'SMALLINT',
                'constraint' => '6',
                'null' => false,
                'default' => '1'
            ],
            'deleted' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => false,
                'default' => '0'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('languages');
    }

    public function down()
    {
        //
        $this->forge->dropTable('languages');
    }
}
