<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tools\Helper;

class FreshTablesMonthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintain:freshTablesMonthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'drop tables, build tables and seed';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        
        $runFreshTablesMonthlyBool = env( 'runFreshTablesMonthlyBool', false );
        
        if( $runFreshTablesMonthlyBool == false ){
            Helper::echoIt( __METHOD__, __LINE__, [ 'env.runFreshTablesMonthlyBool == false' ] );
            return false;
        }
        
        
        Helper::echoIt( __METHOD__, __LINE__, [ 'runFreshTablesMonthlyBool start:' ] );
        
        \Artisan::call('migrate:fresh');
        
        Helper::echoIt( __METHOD__, __LINE__, [ 'runFreshTablesMonthlyBool migrate:fresh done' ] );
        
        \Artisan::call('db:seed');
        
        Helper::echoIt( __METHOD__, __LINE__, [ 'runFreshTablesMonthlyBool db:seed done' ] );
        
        Helper::echoIt( __METHOD__, __LINE__, [ 'runFreshTablesMonthlyBool done' ] );
        
    }
    
    
    
    
    
}
