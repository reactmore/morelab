<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterGeneralSettings extends Migration
{
    public function up()
    {

        $fields = [
            'contact_name' => [
                'type' => 'VARCHAR',
                'constraint'     => 500,
                'null' => true,
                'after' => 'version',
            ],
            'contact_text' => [
                'type' => 'VARCHAR',
                'constraint'     => 500,
                'null' => true,
                'after' => 'contact_name',
            ],
            'contact_address' => [
                'type' => 'VARCHAR',
                'constraint'     => 500,
                'null' => true,
                'after' => 'contact_text',
            ],
            'contact_email' => [
                'type' => 'VARCHAR',
                'constraint'     => 500,
                'null' => true,
                'after' => 'contact_address',
            ],
            'contact_phone' => [
                'type' => 'VARCHAR',
                'constraint'     => 500,
                'null' => true,
                'after' => 'contact_email',
            ],
            'contact_text' => [
                'type' => 'VARCHAR',
                'constraint'     => 500,
                'null' => true,

            ],
            'copyright' => [
                'type' => 'VARCHAR',
                'constraint'     => 500,
                'null' => true,

            ]
        ];
        $this->forge->addColumn('general_settings', $fields);
    }

    public function down()
    {
        $fields = [
            'contact_name' => [
                'type' => 'VARCHAR',
                'constraint'     => 500,
                'null' => true,

            ],
            'contact_text' => [
                'type' => 'VARCHAR',
                'constraint'     => 500,
                'null' => true,
                'after' => 'contact_name',
            ],
            'contact_address' => [
                'type' => 'VARCHAR',
                'constraint'     => 500,
                'null' => true,

            ],
            'contact_email' => [
                'type' => 'VARCHAR',
                'constraint'     => 500,
                'null' => true,

            ],
            'contact_phone' => [
                'type' => 'VARCHAR',
                'constraint'     => 500,
                'null' => true,

            ],
            'contact_text' => [
                'type' => 'VARCHAR',
                'constraint'     => 500,
                'null' => true,

            ],
            'copyright' => [
                'type' => 'VARCHAR',
                'constraint'     => 500,
                'null' => true,

            ]
        ];
        $this->forge->dropColumn('general_settings',  $fields);
    }
}
