<?php

use Illuminate\Database\Seeder;

class RealEstateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('estates')->delete();

        $address_arr = ['Le Thanh Ton', 'Dinh Tien Hoang', 'Tran Quan Khai', 'Hai Ba Trung', 'Le Duan', 'Nguyen Cong Tru'];

        for ($i = 0; $i < 30; $i++) {

            $estate = factory(\App\Estate::class)->create();

            $estate->update([
                'title' => [
                    'en' => $faker->sentence,
                    'vi' => $faker->sentence,
                    'ja' => $faker->sentence
                ],
                'description' => [
                    'en' => "<p>" . $faker->realText(500) . "</p>",
                    'vi' => "<p>" . $faker->realText(500) . "</p>",
                    'ja' => "<p>" . $faker->realText(500) . "</p>"
                ],
                'price' => $faker->numberBetween(50,20000),
                'size'  => $faker->numberBetween(50,5000),
                'lat'   => $faker->numberBetween(9.17682,22.82333),
                'lng'   => $faker->numberBetween(103.02301,109.32094),
                'address' => $address_arr[array_rand($address_arr)],
                'contract_limit'   => "1 year",
                'floor'   => $faker->numberBetween(1,25),
                'conditioning_system'   => "Central management system",
                'anniversary'   => date("Y-m-d", mt_rand(strtotime('2005-01-01'), strtotime('2017-12-30')))
            ]);


            $resources = \App\Resource::orderByRaw('RAND()')->take(5)->get();
            $estate->resources()->saveMany($resources);

            $estate->save();

        }
    }
}
