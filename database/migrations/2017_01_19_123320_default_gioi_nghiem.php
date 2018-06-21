<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DefaultGioiNghiem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $estates = \App\Estate::all();
        foreach ($estates as $estate) {
            $surroundings = $estate->surroundings;
            array_push($surroundings, "2");
            $surroundings = array_unique($surroundings);
            $estate->surroundings = $surroundings;
            $estate->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
