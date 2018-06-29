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
            'page_menu' => '[{"deleted":0,"new":1,"id":1},{"deleted":0,"new":1,"id":2},{"deleted":0,"new":1,"id":3},{"deleted":0,"new":1,"id":4},{"deleted":0,"new":1,"id":5},{"deleted":0,"new":1,"id":6}]',
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
