.<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentReplyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comment_replies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('comment_id');
			$table->integer('media_id');
			$table->string('comment');
			$table->string('pic_url')->nullable();
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
		Schema::drop('comment_replies');
	}

}
