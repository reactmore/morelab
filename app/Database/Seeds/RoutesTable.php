<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoutesTable extends Seeder
{
    public function run()
    {

        $data = [
            'admin' => 'admin',

        ];

        $this->db->table('routes')->insert($data);
    }
}
