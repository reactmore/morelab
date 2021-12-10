<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UserTable extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        for ($i = 0; $i < 100; $i++) {
            $data = [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'username' => $faker->username,
                'email' => $faker->safeEmail,
                'mobile_no' => NULL,
                'email_status' => 1,
                'token' => NULL,
                'password' => '$2a$08$sPowX6bGos9lGrtf3PDzjO2C8ClUf90RhXRbEG15e6rqrJVdA4pPC', //reactmorcom321
                'role' => 'admin',
                'user_type' => 'registered',
                'google_id' => NULL,
                'facebook_id' => NULL,
                'avatar' => NULL,
                'status' => 1,
                'about_me' => NULL,
                'last_seen' => NULL,
                'created_at' => date("Y-m-d H:i:s"),
            ];

            $data['slug'] = $data['username'];


            print_r($data);
            $this->db->table('users')->insert($data);
        }
        //
    }
}
