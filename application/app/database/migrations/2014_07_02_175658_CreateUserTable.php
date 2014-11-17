<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table){
			$table->increments('id');
			$table->string('username', 16);
			$table->integer('admin')->default(0);
			$table->integer('active')->default(1);
			$table->string('email');
			$table->string('password', 64);
			$table->string('avatar');
			$table->string('comavatar');
			$table->text('remember_token')->nullable();
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
		Schema::drop('users');
	}

}
