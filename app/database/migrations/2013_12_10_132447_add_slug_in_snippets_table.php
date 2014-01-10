<?php

use Illuminate\Database\Migrations\Migration;

class AddSlugInSnippetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('snippets', function ($table) {
            $table->string('slug')->default(0);
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
            $table->dropColumn('slug');
        });
    }

}
