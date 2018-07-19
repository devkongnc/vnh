<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #Run ONCE at first
        factory(\App\User::class)->create();
        Auth::login(\App\User::first());

        #Require data
        $this->call(PagesTableSeeder::class);
        $this->call(OptionsTableSeeder::class);

        #Demo data
        $this->call(ResourceSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(RealEstateSeeder::class);
    }
}
