<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('pages')->delete();
        DB::unprepared(file_get_contents(database_path()."/seeds/static_page.sql"));
    }
}
