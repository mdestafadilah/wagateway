<?php

namespace App\Console\Commands;

use App\Http\Controllers\BlastController;
use App\Models\Blast as ModelsBlast;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Number;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class blast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:blast';

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
        try {
           
           
            $data = Campaign::where('schedule' ,'<=',date('Y-m-d H:i:s'))->whereStatus('waiting')->with('blasts')->get();
         Log:info($data);
      
            foreach($data as $d){
              
                $blasts = $d->blasts;
                $check = Number::whereBody($d->sender)->first();
                if($check->status != 'Connected'){
                    $d->status = 'failed';
                    $d->save();
                }
                $data = [];
                // foreach destination and push to data
                foreach ($d->blasts as $blast) {
                   // if there is {name} in message, replace it with contact name
                   $contact = Contact::whereNumber($blast->receiver)->first();
                    // replace {name} to name contact if there is name
                    if($contact){
                        $message = str_replace('{name}', $contact->name, $d->message);
                    }
                    $data[] = [
                            'sender' => $blast->sender,
                
                            'campaign_id' => $d->id,
                            'receiver' => $blast->receiver,
                            'message' => $message,
                            'type' => $d->type,
                            'status' => 'pending',
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                }

                $k = new BlastController();
               
                try {
                    $result = $k->sendBlast($data, 2,$d);
                    Log::info(json_decode($result)->status);
                   
                    if (json_decode($result)->status) {
                        $d->status = 'executed';
                        $d->save();
                    } else {
                        $d->status = 'failed';
                        $d->save();
                        // set error all blast with this campaign
                        $blastss = ModelsBlast::where('campaign_id', $d->id)->update(['status' => 'failed']);
                    }
        
                } catch (\Throwable $th) {
                    $d->status = 'failed';
                    $d->save();
                    // set error all blast with this campaign
                    $blastss = ModelsBlast::where('campaign_id', $d->id)->update(['status' => 'failed']);
                 
                }
             
              


         }
         
     
     
         
          return 1;
        } catch (\Throwable $th) {
           Log::info($th);
        }
      




       
       
    }
}
