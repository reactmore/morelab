<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyGeneralSettings extends Migration
{
    public function up()
    {
        //
        $fields = [
            'update_at' => [
                'name' => 'updated_at',
                'type' => 'TIMESTAMP',
                'null' => true,
                'after' => 'copyright'
            ],
        ];
        $this->forge->modifyColumn('general_settings', $fields);
    }

    public function down()
    {
        //
    }
}
