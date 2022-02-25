<?php

namespace App\Database\Seeds\Development;

use CodeIgniter\Database\Seeder;

class Submenu extends Seeder
{
	public function run()
	{
		$data = [
			[
				'menu' => 5,
				'title' 		=> 'add_user',
				'url'    		=> 'add-user',
				'position_order' => 1
			],
			[
				'menu' => 5,
				'title' 		=> 'administrators',
				'url'    		=> 'administrators',
				'position_order' => 2
			],
			[
				'menu' => 5,
				'title' 		=> 'users',
				'url'    		=> 'list-users',
				'position_order' => 3
			],

		];
		$this->db->table('user_submenu')->insertBatch($data);
	}
}
