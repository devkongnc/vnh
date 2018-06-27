<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->delete();
        DB::statement('ALTER TABLE options AUTO_INCREMENT = 1;');

        $temp_data = [
            'home_slider' => "",
            'page_menu' => "",
            'search' => '{"0":"area"}',
            'partner' => "",
            'home_video' => "",
            'home_banner' => "slider",
        ];

        foreach ($temp_data as $key => $value) {
            DB::table('options')->insert([
                'name' => $key,
                'value' => $value,
            ]);
        }
    }
}
