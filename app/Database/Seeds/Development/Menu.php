<?php

namespace App\Database\Seeds\Development;

use CodeIgniter\Database\Seeder;

class Menu extends Seeder
{
	public function run()
	{
		$data = [
			[
				'menu_category' => 1,
				'title' 		=> 'dashboard',
				'url'    		=> 'dashboard',
				'icon'    		=> 'fas fa-tachometer-alt',
				'parent'   		=> 0,
				'position_order' => 1
			],
			[
				'menu_category' => 2,
				'title' 		=> 'locations',
				'url'    		=> 'locations/country',
				'icon'    		=> 'fas fa-map-marker',
				'parent'   		=> 0,
				'position_order' => 3
			],
			[
				'menu_category' => 2,
				'title' 		=> 'language_settings',
				'url'    		=> 'language-settings',
				'icon'    		=> 'fas fa-language',
				'parent'   		=> 0,
				'position_order' => 2
			],
			[
				'menu_category' => 2,
				'title' 		=> 'general_settings',
				'url'    		=> 'settings',
				'icon'    		=> 'fas fa-cogs',
				'parent'   		=> 0,
				'position_order' => 1
			],
			[
				'menu_category'  => 3,
				'title' 		 => 'users',
				'url'    		 => 'users',
				'icon'    		 => 'fas fa-users',
				'parent'   		 => 1,
				'position_order' => 1
			],
			[
				'menu_category' => 3,
				'title' 		=> 'roles_permissions',
				'url'    		=> 'role-management',
				'icon'    		=> 'fas fa-user-shield',
				'parent'   		=> 0,
				'position_order' => 2
			],
			[
				'menu_category' => 3,
				'title' 		=> 'menu_management',
				'url'    		=> 'menu-management',
				'icon'    		=> 'fas fa-cogs',
				'parent'   		=> 0,
				'position_order' => 3
			],
		];
		$this->db->table('user_menu')->insertBatch($data);
	}
}
