<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker   = Faker\Factory::create();

		DB::table('categories')->delete();
		DB::statement('ALTER TABLE categories AUTO_INCREMENT = 1;');

		for ($i = 0; $i < 10; $i++) {
			$category = factory(App\Category::class)->create();

			$terms = [];
		    foreach (config('real-estate') as $key => $values) {
		        if ($key == 'area') {
		            $terms[$key] = array($faker->randomElement(array_keys($values['values'])));
		            break;
		        }
		    }
		    $category->setLocalesData([
                'en' => [
					'title'            => $faker->sentence,
					'description'      => "<p>" . $faker->realText(200) . "</p>",
					'meta_keywords'    => $faker->sentence,
					'meta_description' => $faker->sentence
                ],
                'vi' => [
					'title'            => $faker->sentence,
					'description'      => "<p>" . $faker->realText(200) . "</p>",
					'meta_keywords'    => $faker->sentence,
					'meta_description' => $faker->sentence
                ],
                'ja' => [
					'title'            => $faker->sentence,
					'description'      => "<p>" . $faker->realText(200) . "</p>",
					'meta_keywords'    => $faker->sentence,
					'meta_description' => $faker->sentence
                ]
            ]);
			$category->sql_data = $terms;
        	$category->save();
		}
    }
}
