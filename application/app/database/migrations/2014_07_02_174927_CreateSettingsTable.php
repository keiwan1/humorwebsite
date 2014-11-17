<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table){

			$table->increments('id');
			$table->string('website_name');
			$table->string('website_description');
			$table->string('logo');
			$table->string('favicon');
			$table->integer('post_title_length');
			$table->boolean('auto_approve_posts');
			$table->timestamps();
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settings');

	}

}
