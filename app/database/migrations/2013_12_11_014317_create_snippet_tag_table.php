<?php

use Illuminate\Database\Migrations\Migration;

class CreateSnippetTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snippet_tag', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('snippet_id');
            $table->unsignedInteger('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('snippet_tag');
    }

}
