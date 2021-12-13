<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LanguageTable extends Seeder
{
    public function run()
    {

        $data = [
            'name' => 'English',
            'short_form' => 'en',
            'language_code' => 'en-US',
            'text_direction' => 'ltr',
            'text_editor_lang' => 'id',
            'status' => '1',
            'language_order' => '1',
            'deleted' => '0',


        ];

        $this->db->table('languages')->insert($data);
    }
}
