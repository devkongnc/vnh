<?php

use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        DB::table('reviews')->delete();
        DB::statement('ALTER TABLE reviews AUTO_INCREMENT = 1;');

        for ($i = 0; $i < 10; $i++) {

            \App\Review::create([
                 'title' => [
                     'en' => $faker->sentence,
                     'vi' => $faker->sentence,
                     'ja' => $faker->realText(25)
                 ],
                'description' => [
                    'en' => "<p>" . $faker->realText(300) . "</p>",
                    'vi' => "<p>" . $faker->realText(300) . "</p>",
                    'ja' => "<p>" . $faker->realText(500) . "</p>"
                ],
                'permalink' => \Illuminate\Support\Str::slug($faker->sentence),
                'resource_id' => \App\Resource::orderByRaw('RAND()')->first()->id,
                'categories' => array(random_int(0, 5)),
                'locales_only' => array(random_int(0, 2))
            ]);

        }
    }
}
