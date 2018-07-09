<?php

use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$faker = Faker\Factory::create();
        DB::table('resources')->delete();
        DB::statement('ALTER TABLE resources AUTO_INCREMENT = 1;');
        File::deleteDirectory(public_path('upload'));
        File::makeDirectory(public_path('upload' ));
        File::makeDirectory(public_path('upload' . DIRECTORY_SEPARATOR . 'images'));

//        for ($i = 0; $i < (env('APP_ENV') == 'local' ? 10 : 100); $i++) {

        for ($i = 0; $i < 5; $i++) {
            $fileName = "image-" . $i . ".png";

            $image = file_get_contents("http://unsplash.it/768/520?random");
            file_put_contents(public_path("upload" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR) . $fileName, $image);

            \App\Resource::create([
                'folder'   => 'images/',
                'filename' => $fileName,
            ]);
        }
    }
}
