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
                'lng'   => $faker->numberBetween(103.02301,109.32094)
            ]);


            $resources = \App\Resource::orderByRaw('RAND()')->take(5)->get();
            $estate->resources()->saveMany($resources);

            $estate->save();

        }
    }
}
