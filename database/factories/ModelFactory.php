<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'     => 'admin',
        'email'    => 'test@gmail.com',
        'level'    => 2,
        'password' => bcrypt('mangohcm123')
    ];
});

$factory->define(App\Estate::class, function (Faker\Generator $faker) {

    $arr = [];
    foreach (Config::get('real-estate') as $key => $values) {
        if ($values['type'] == 'single') {
            $arr[$key] = $faker->randomElement(array_keys($values['values']));
        } else if ($values['type'] == 'multiple') {
            $arr[$key] = $faker->randomElements(array_keys($values['values']));
        }/* else {
            if ($key == 'price') {
                $arr['price'] = $faker->randomNumber(6);
            } else
                $arr[$key] = $faker->sentence;
        }*/
    }
    $general = [
        'product_id'  => $faker->unique()->numerify("#####"),
        'status'      => 0,
        'price'       => $faker->numberBetween(500, 9999),
        'lat'         => '10.7883447',
        'lng'         => '106.6955799',
        'resource_id' => \App\Resource::orderByRaw('RAND()')->first()->id
    ];

    return array_merge($general, $arr);
});

$factory->define(App\EstateTranslate::class, function(Faker\Generator $faker){
    return [
        'title'       => $faker->sentence,
        'description' => $faker->paragraph
    ];
});

$factory->define(App\Apartment::class, function (Faker\Generator $faker) {
    return [
        'product_id'  => $faker->unique()->numberBetween(1, 99),
        'permalink'   => \Illuminate\Support\Str::slug($faker->sentence),
        'status'      => 0,
        'recommend'   => $faker->numberBetween(1, 99),
        'lat'         => '10.7883447',
        'lng'         => '106.6955799',
        'resource_id' => \App\Resource::orderByRaw('RAND()')->first()->id,
        'area'        => $faker->randomElement(array_keys(config('real-estate.area.values')))
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'permalink'   => \Illuminate\Support\Str::slug($faker->sentence),
        'status'      => 0,
        'sticky'      => true,
        'sql_data'    => [],
        'resource_id' => \App\Resource::orderByRaw('RAND()')->first()->id,
    ];
});
