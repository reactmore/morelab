<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OauthGithub extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'github_id' => [
                'type' => 'VARCHAR',
                'constraint' => '999',
                'null' => true,
                'after' => 'google_id',
            ]
        ]);

        $this->forge->addColumn('general_settings', [
            'github_client_id' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
                'after' => 'google_client_secret',
            ]
        ]);

        $this->forge->addColumn('general_settings', [
            'github_client_secret' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
                'after' => 'github_client_id',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'github_id');
        $this->forge->dropColumn('general_settings', 'github_client_id');
        $this->forge->dropColumn('general_settings', 'github_client_secret');
    }
}
