<?php

use Illuminate\Database\Migrations\Migration;

class AddApprovedInSnippetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('snippets', function ($table) {
            $table->boolean('approved')->default(0);
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
            $table->dropColumn('approved');
        });
    }

}
