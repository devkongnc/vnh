<?php

use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
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
        $fakerEn = Faker\Factory::create();

        DB::table('apartments')->delete();
        DB::statement('ALTER TABLE apartments AUTO_INCREMENT = 1;');

        for ($i = 0; $i < 10; $i++) {

            $apartment = factory(\App\Apartment::class)->create();

            $apartment->update([
                'title' => [
                    'en' => $fakerEn->sentence,
                    'vi' => $fakerVi->sentence,
                    'ja' => $fakerJa->realText(25)
                ],
                'description' => [
                    'en' => "<p>" . implode("<p></p>", $fakerEn->paragraphs(20)) . "</p>",
                    'vi' => "<p>" . implode("<p></p>", $fakerVi->paragraphs(20)) . "</p>",
                    'ja' => "<p>" . $fakerJa->realText . "</p>"
                ],
            ]);

            $resources = \App\Resource::orderByRaw('RAND()')->take(10)->get();
            $apartment->resources()->saveMany($resources);

            $apartment->save();

        }
    }
}
