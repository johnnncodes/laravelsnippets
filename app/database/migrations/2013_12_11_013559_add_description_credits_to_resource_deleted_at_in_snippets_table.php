<?php

use Illuminate\Database\Migrations\Migration;

class AddDescriptionCreditsToResourceDeletedAtInSnippetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('snippets', function($table)
		{
			$table->text('description');
			$table->string('credits_to');
			$table->string('resource');
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('snippets', function($table)
		{
			$table->dropColumn('description');
			$table->dropColumn('credits_to');
			$table->dropColumn('resource');
			$table->dropColumn('deleted_at');
		});
	}

}