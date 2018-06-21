<?php 
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTerm13ToEstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::table("estates", function (Blueprint $table) {
            $table->string("term_13");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::table("estates", function (Blueprint $table) {
            $table->dropColumn("term_13");
        });
    }
}
