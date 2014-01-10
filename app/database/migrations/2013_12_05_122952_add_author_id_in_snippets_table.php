<?php

use Illuminate\Database\Migrations\Migration;

class AddAuthorIdInSnippetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('snippets', function ($table) {
            $table->unsignedInteger('author_id');
            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('snippets', function ($table) {
            $table->dropForeign('snippets_author_id_foreign');
            $table->dropColumn('author_id');
        });
    }

}
