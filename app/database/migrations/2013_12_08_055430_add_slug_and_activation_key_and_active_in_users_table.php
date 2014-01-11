<?php

use Illuminate\Database\Migrations\Migration;

class AddSlugAndActivationKeyAndActiveInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
              $table->string('slug');
              $table->string('activation_key');
              $table->string('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('slug');
            $table->dropColumn('activation_key');
            $table->dropColumn('active');
        });
    }

}
