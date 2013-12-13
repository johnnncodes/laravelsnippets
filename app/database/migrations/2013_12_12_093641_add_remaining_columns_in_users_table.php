<?php

use Illuminate\Database\Migrations\Migration;

class AddRemainingColumnsInUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('users', function($table)
        {
            $table->string('twitter_url');
            $table->string('facebook_url');
            $table->string('github_url');
            $table->string('website_url');
            $table->string('photo_url');
            $table->text('about_me');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('users', function($table)
        {
            $table->dropColumn('twitter_url');
            $table->dropColumn('facebook_url');
            $table->dropColumn('github_url');
            $table->dropColumn('website_url');
            $table->dropColumn('photo_url');
            $table->dropColumn('about_me');
        });
	}

}