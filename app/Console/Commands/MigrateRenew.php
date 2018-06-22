<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Estate;
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
            UPDATE `estates` SET `facilities` = REPLACE(`facilities`, \'"]\', \'","1"]\') WHERE MATCH(`facilities`) AGAINST(\'212 213\' IN BOOLEAN MODE);
            UPDATE `estates` SET `surroundings` = REPLACE(`surroundings`, \'"]\', \'","269"]\') WHERE `surroundings` <> \'[]\' AND `facilities` LIKE \'%269%\';
            UPDATE `estates` SET `surroundings` = \'["269"]\' WHERE `surroundings` = \'[]\' AND `facilities` LIKE \'%269%\';
            UPDATE `estates` SET `surroundings` = REPLACE(`surroundings`, \'"]\', \'","254"]\') WHERE `surroundings` <> \'[]\' AND `facilities` LIKE \'%254%\';
            UPDATE `estates` SET `surroundings` = \'["254"]\' WHERE `surroundings` = \'[]\' AND `facilities` LIKE \'%254%\';
        ');

        $estates = Estate::all();
        $bar = $this->output->createProgressBar(count($estates));
        foreach ($estates as $key => $estate) {
            $estate->size = preg_replace('/\D/', '', $estate->size);
            $estate->save(['timestamps' => false]);
            $bar->advance();
        }
        $bar->finish();
    }
}
