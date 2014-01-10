<?php

use Illuminate\Database\Migrations\Migration;

class AddDisqusColumnsToSnippetsTable
extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table("snippets", function ($table) {
      $table->timestamp("updated_comments_at");
      $table->integer("comments");
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table("snippets", function ($table) {
      $table->dropColumn("updated_comments_at");
      $table->dropColumn("comments");
    });
  }
}
