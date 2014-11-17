<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediatable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media', function(Blueprint $table){

			$table->increments('id');
			$table->integer('user_id');
			$table->integer('category_id');
			$table->string('title');
			$table->string('slug');
			$table->string('description', 250)->default('');
			$table->boolean('active')->default(1);
			$table->boolean('vid')->default(0);
			$table->boolean('pic')->default(0);
			$table->boolean('nukta')->default(0);
			$table->text('nukta_text')->nullable();
			$table->string('pic_url')->nullable();
			$table->text('vid_url')->nullable();
			$table->integer('views')->default(0);
			$table->text('tags')->nullable();
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
		Schema::drop('media');
	}

}
