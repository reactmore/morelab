<?php

namespace App\Database\Seeds\Development;

use CodeIgniter\Database\Seeder;

class RolePermissions extends Seeder
{
	public function run()
	{
		$data = [
			// Common Page
			[
				'role_id'    		=>  1,
				'menu_category_id'  =>  1,
				'menu_id'    		=>  0,
				'submenu_id'		=> 	0
			],
			//dashboard
			[
				'role_id'    		=>  1,
				'menu_category_id'  =>  0,
				'menu_id'    		=>  1,
				'submenu_id'		=> 	0
			],

			// Settings Page
			[
				'role_id'    		=>  1,
				'menu_category_id'  =>  2,
				'menu_id'    		=>  0,
				'submenu_id'		=> 	0
			],

			// Locations
			[
				'role_id'    		=>  1,
				'menu_category_id'  =>  0,
				'menu_id'    		=>  2,
				'submenu_id'		=> 	0
			],
			// Language Settings
			[
				'role_id'    		=>  1,
				'menu_category_id'  =>  0,
				'menu_id'    		=>  3,
				'submenu_id'		=> 	0
			],
			// General Settings
			[
				'role_id'    		=>  1,
				'menu_category_id'  =>  0,
				'menu_id'    		=>  4,
				'submenu_id'		=> 	0
			],

			// Dev Page
			[
				'role_id'    		=>  1,
				'menu_category_id'  =>  3,
				'menu_id'    		=>  0,
				'submenu_id'		=> 	0
			],
			// Users 
			[
				'role_id'    		=>  1,
				'menu_category_id'  =>  0,
				'menu_id'    		=>  5,
				'submenu_id'		=> 	0
			],
			[
				'role_id'    		=>  1,
				'menu_category_id'  =>  0,
				'menu_id'    		=>  0,
				'submenu_id'		=> 	1
			],
			[
				'role_id'    		=>  1,
				'menu_category_id'  =>  0,
				'menu_id'    		=>  0,
				'submenu_id'		=> 	2
			],
			[
				'role_id'    		=>  1,
				'menu_category_id'  =>  0,
				'menu_id'    		=>  0,
				'submenu_id'		=> 	3
			],
			// Permissions
			[
				'role_id'    		=>  1,
				'menu_category_id'  =>  0,
				'menu_id'    		=>  6,
				'submenu_id'		=> 	0
			],
			// Menu Management
			[
				'role_id'    		=>  1,
				'menu_category_id'  =>  0,
				'menu_id'    		=>  7,
				'submenu_id'		=> 	0
			],

		];
		$this->db->table('user_access')->insertBatch($data);
	}
}
