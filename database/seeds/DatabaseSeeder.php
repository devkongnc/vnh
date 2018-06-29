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
        factory(\App\User::class)->create();
        Auth::login(\App\User::first());
        $this->call(ResourceSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(RealEstateSeeder::class);
        $this->call(OptionsTableSeeder::class);
    }
}
