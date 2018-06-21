<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use App\Estate;

class MigrateTimestamps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:timestamps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $estates = DB::connection('old_server')->select('
            SELECT cscart_products.product_code, cscart_products.timestamp
            FROM cscart_products
        ;')->get()->lists('timestamp', 'product_code')->all();
    }
}
