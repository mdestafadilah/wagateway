<?php

namespace App\Console\Commands;

use App\Models\Number;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScheduleCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:cron';

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
     * @return int
     */
    public function handle()
    {
        
      $numbers = Number::whereStatus('Connected')->get();
    
      $url = env('WA_URL_SERVER').'/backend-initialize';
      Log::info('Auto connect whatsapp running');
      foreach ($numbers as $n) {

       $result =  Http::withOptions(['verify' => false])->asForm()->post($url,['token' => $n->body]);
       Log::info($result);

       // delay 2 seconds
        sleep(2);
      }
    }
}
