<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class VisualSettings extends Migration
{
    public function up()
    {

        $this->forge->addColumn('general_settings', [
            'logo_light' => [
                'type' => 'VARCHAR',
                'constraint'     => 255,
                'null' => true,
                'after' => 'copyright'

            ],
        ]);

        $this->forge->addColumn('general_settings', [
            'logo_dark' => [
                'type' => 'VARCHAR',
                'constraint'     => 255,
                'null' => true,
                'after' => 'logo_light'
            ]
        ]);

        $this->forge->addColumn('general_settings', [
            'logo_email' => [
                'type' => 'VARCHAR',
                'constraint'     => 255,
                'null' => true,
                'after' => 'logo_dark'
            ]
        ]);

        $this->forge->addColumn('general_settings', [
            'favicon' => [
                'type' => 'VARCHAR',
                'constraint'     => 255,
                'null' => true,
                'after' => 'logo_email'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('general_settings', ['logo_light', 'logo_dark', 'logo_email', 'favicon']);
    }
}
