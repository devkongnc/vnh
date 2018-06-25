<?php 
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTerm9ToEstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::table("estates", function (Blueprint $table) {
            $table->tinyInteger("term_9")->unsigned();
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
            $table->dropColumn("term_9");
        });
    }
}
