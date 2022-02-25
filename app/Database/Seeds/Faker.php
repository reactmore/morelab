<?php

namespace App\Database\Seeds;

use App\Models\UsersModel;
use CodeIgniter\Database\Seeder;

class Faker extends Seeder
{
	public function run()
	{
		helper('custom');
		$faker = \Faker\Factory::create('id_ID');
		// Data Login 
		$userModel = new UsersModel();
		for ($i = 0; $i < 50; $i++) {
			$data = [
				'fullname' 		=> $faker->firstName() . ' ' . $faker->lastName(),
				'username'    	=> $faker->username(),
				'email'    		=> $faker->email(),
				'email_status'  =>  1,
				'password'    	=>  password_hash('reactmorecom321', PASSWORD_BCRYPT),
				'role'    		=>  $faker->randomElement([2, 3, 4]),
				'user_type'    	=>  $faker->randomElement(['registered', 'github', 'google']),
				'status'    	=>  1,
				'created_at'    =>  date("Y-m-d H:i:s",  $faker->dateTimeThisMonth()->getTimestamp())
			];

			$data['slug'] =  $userModel->generate_uniqe_slug($data['username']);

			print_r($data);
			$this->db->table('users')->insert($data);
		}
	}
}
