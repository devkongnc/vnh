<?php

use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker\Factory::create();
    	for ($i = 0; $i < 10; $i++) {
    		DB::table('contacts')->insert([
				'name'    => str_random(10),
				'phone'   => $faker->phoneNumber,
				'email'   => str_random(10).'@gmail.com',
				'message' => $faker->realText(100)
	        ]);
    	}
    }
}
