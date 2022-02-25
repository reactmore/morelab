<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Development extends Seeder
{
	public function run()
	{
		// Data Login 

		$data = [
			'fullname' 		=> 'Reactmore',
			'username'    	=> 'reactmore',
			'slug'    		=> 'reactmore',
			'email'    		=> 'reactmorecom@gmail.com',
			'email_status'  =>  1,
			'password'    	=>  password_hash('reactmorecom321', PASSWORD_BCRYPT),
			'role'    		=>  1,
			'user_type'    	=>  'registered',
			'status'    	=>  1,
			'created_at'    =>  date('Y-m-d h:i:s')
		];

		$this->db->table('users')->insert($data);
		$this->call('App\Database\Seeds\Development\UserRole');
		$this->call('App\Database\Seeds\Development\MenuCategory');
		$this->call('App\Database\Seeds\Development\Menu');
		$this->call('App\Database\Seeds\Development\Submenu');
		$this->call('App\Database\Seeds\Development\RolePermissions');
		$this->call('App\Database\Seeds\Development\Languages');
		$this->call('App\Database\Seeds\Development\GeneralSettings');
		$this->call('App\Database\Seeds\Development\Locations');
	}
}
