<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GeneralSettingsTable extends Seeder
{
    public function run()
    {

        $data = [
            'site_lang' => '1',



        ];

        $this->db->table('general_settings')->insert($data);
    }
}
