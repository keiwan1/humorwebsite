<?php

class UsertableSeeder extends Seeder {

	//fills the user table
	public function run(){
		DB::table('users')->insert(array (
			0 => array (

						'id' => 1,
						'username' => 'admin',
						'admin' => 1,
						'active' => 1,
						'email' => 'admin@admin.com',
						'password' => Hash::make('admin'),
					),
			1 => array (
						'id' => '',
						'username' => 'sal',
						'admin' => '',
						'active' => 1,
						'email' => 'sal@email.com',
						'password' => Hash::make('password1'),
					),
			));
	}
}