<?php

class SettingstableSeeder extends Seeder {

	//this fills the settings table
	public function run() {

		DB::table('settings')->delete();

		DB::table('settings')->insert(array (
				'id' => 1,
				'website_name' => 'site',
				'website_description' => 'Laugh with us',
				'logo' => 'application/assets/img/logo.png',
				'favicon' => 'application/assets/img/favicon.png',
				'post_title_length' => 15,
				'auto_approve_posts' => true,
				'updated_at' => '2014-07-02 00:08:17',
				'created_at' => '0000-00-00 00:00:00',
			));
	}
}
