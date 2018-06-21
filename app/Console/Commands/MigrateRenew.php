<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Estate;
use App\Apartment;
use App\Term;

class MigrateRenew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:renew';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change estate data to new website version';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::unprepared('
            UPDATE `estates` SET `area` = 1 WHERE `area` IN (648,759,784,799,803,804,837);
            /*UPDATE `estates` SET `beds` = 70 WHERE `beds` IN (71,132,204,205,206,207,208,209,210,211,239,240,241,242,243,244,245,246,247,800,835,841);
            UPDATE `estates` SET `beds` = 258 WHERE `beds` = 339;
            UPDATE `estates` SET `baths` = 113 WHERE `baths` IN (134,144,145,147,229,230,231,232,233,234,235,236,237,238,801,810,817,836);
            UPDATE `estates` SET `baths` = 7 WHERE `baths` = 344;*/
            UPDATE `estates` SET `facilities` = REPLACE(`facilities`, \'"]\', \'","1"]\') WHERE MATCH(`facilities`) AGAINST(\'212 213\' IN BOOLEAN MODE);
            UPDATE `estates` SET `surroundings` = REPLACE(`surroundings`, \'"]\', \'","269"]\') WHERE `surroundings` <> \'[]\' AND `facilities` LIKE \'%269%\';
            UPDATE `estates` SET `surroundings` = \'["269"]\' WHERE `surroundings` = \'[]\' AND `facilities` LIKE \'%269%\';
            UPDATE `estates` SET `surroundings` = REPLACE(`surroundings`, \'"]\', \'","254"]\') WHERE `surroundings` <> \'[]\' AND `facilities` LIKE \'%254%\';
            UPDATE `estates` SET `surroundings` = \'["254"]\' WHERE `surroundings` = \'[]\' AND `facilities` LIKE \'%254%\';
        ');

        DB::table('apartments')->delete();
        DB::statement('ALTER TABLE apartments AUTO_INCREMENT = 1;');
        $apartments = config('real-estate.building_name.values');
        foreach ($apartments as $index => $apartment_data) {
            $title = Term::getLocaleStringAsArray($apartment_data);
            $apartment = Apartment::create([
                'title'      => Term::getLocaleStringAsArray($apartment_data),
                'product_id' => $index,
                'permalink'  => str_slug($title['en'])
            ]);
        }
        $apartments = Apartment::get()->lists('id', 'product_id')->all();
        $estates = Estate::all();
        $bar = $this->output->createProgressBar(count($estates));
        foreach ($estates as $key => $estate) {
            $estate->size = preg_replace('/\D/', '', $estate->size);
            if (!empty($estate->building_name_raw)) $estate->apartment_id = $apartments[(int) $estate->building_name_raw];
            $estate->save(['timestamps' => false]);
            $bar->advance();
        }
        $bar->finish();
    }
}
