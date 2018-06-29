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
        $fakerJa = Faker\Factory::create('ja_JP');
        $fakerVi = Faker\Factory::create('vi_VN');
        $fakerEn = Faker\Factory::create();

        DB::table('estates')->delete();

        for ($i = 0; $i < 10; $i++) {

            $estate = factory(\App\Estate::class)->create();

            $estate->update([
                'title' => [
                    'en' => $fakerEn->sentence,
                    'vi' => $fakerVi->sentence,
                    'ja' => $fakerJa->realText(25)
                ],
                'description' => [
                    'en' => "<p>" . $fakerEn->realText(200) . "</p>",
                    'vi' => "<p>" . $fakerVi->realText(200) . "</p>",
                    'ja' => "<p>" . $fakerJa->realText(300) . "</p>"
                ],
            ]);


            $resources = \App\Resource::orderByRaw('RAND()')->take(10)->get();
            $estate->resources()->saveMany($resources);

            $estate->save();

        }
    }
}
