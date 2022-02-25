<?php

namespace App\Database\Migrations\Development;

use CodeIgniter\Database\Migration;

class Locations extends Migration
{
    public function up()
    {
        // Country
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'       => true,
            ],
            'continent_code'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'status'       => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
                'default' => 1

            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('location_countries');

        //state
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'country_id'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'name'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'       => true,
            ],


        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('location_states');

        //city
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'country_id'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'state_id'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'name'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'       => true,
            ],


        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('location_cities');
    }

    public function down()
    {
        $this->forge->dropTable('location_countries');
        $this->forge->dropTable('location_states');
        $this->forge->dropTable('location_cities');
    }
}
