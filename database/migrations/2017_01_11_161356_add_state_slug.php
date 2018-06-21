<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStateSlug extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estates', function (Blueprint $table) {
            $table->string('slug_vi')->after('id');
            $table->string('slug_en')->after('id');
        });
        $estates = \App\Estate::all();
        foreach ($estates as $estate) {
            $estate->slug_vi = str_slug($estate->translate('title', 'vi'));
            $estate->slug_en = str_slug($estate->translate('title', 'en'));
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
        Schema::table('estates', function (Blueprint $table) {
            //
        });
    }
}
