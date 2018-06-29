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
        $fakerJa = Faker\Factory::create('ja_JP');
        $fakerVi = Faker\Factory::create('vi_VN');
        $fakerEn = Faker\Factory::create('en');
        DB::table('reviews')->delete();
        DB::statement('ALTER TABLE reviews AUTO_INCREMENT = 1;');

        for ($i = 0; $i < 10; $i++) {

            \App\Review::create([
                 'title' => [
                     'en' => $fakerEn->sentence,
                     'vi' => $fakerVi->sentence,
                     'ja' => $fakerJa->realText(25)
                 ],
                'description' => [
                    'en' => "<p>" . $fakerEn->realText(300) . "</p>",
                    'vi' => "<p>" . $fakerVi->realText(300) . "</p>",
                    'ja' => "<p>" . $fakerJa->realText(500) . "</p>"
                ],
                'permalink' => \Illuminate\Support\Str::slug($fakerEn->sentence),
                'resource_id' => \App\Resource::orderByRaw('RAND()')->first()->id,
                'categories' => array(random_int(0, 5)),
                'locales_only' => array(random_int(0, 2))
            ]);

        }
    }
}
