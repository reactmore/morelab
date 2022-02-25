<?php

namespace App\Database\Seeds\Development;

use CodeIgniter\Database\Seeder;

class GeneralSettings extends Seeder
{
	public function run()
	{
		$data = [
			'application_name'    		=>  'Reactmore',
			'site_lang'    		=>  1,
			'multilingual_system'    		=>  1,
			'registration_system'    		=>  1,
			'recaptcha_lang'    		=> 'en',
			'cache_system'    		=>  1,
			'email_verification'    		=>  1,
			'version'    		=>  '1.0',
			'updated_at'    		=>  date('Y-m-d h:i:s')


		];

		$this->db->table('general_settings')->insert($data);
	}
}
