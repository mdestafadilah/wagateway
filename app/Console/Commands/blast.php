<?php

namespace App\Console\Commands;

use App\Http\Controllers\BlastController;
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
           
           
            $data = Schedule::where('datetime' ,'<=',date('Y-m-d H:i:s'))->whereIsExecuted(0)->get();
      Log:info(date('Y-m-d H:i:s'));
            foreach($data as $d){
                
             $cek = Number::whereBody($d->sender)->first();
             $user = User::find($cek->user_id);
             $dN = [  
             
                 'sender' => $d->sender,
                 'api_key' => $user->api_key,
                 'delay' => 5
                ];
             if($cek->status !== 'Connected'){
                 return 0;
             }
     
     $numAndMsg = [];
             if(strpos($d->text,'{name}')){
                 foreach (json_decode($d->numbers) as $ds) {
                     
                     $name = Contact::whereNumber($ds)->first('name')->name;
                    $numAndMsg[] = [
                        'number' => $ds,
                        'msg' => str_replace('{name}',$name,$d->text)
                    ];
                 }
         } else {
             Log::info($d);
             foreach (json_decode($d->numbers) as $ds) {
                
                $numAndMsg[] = [
                    'number' => $ds,
                    'msg' => $d->text
                ];
             }
         }
     
         switch ($d->type) {
             case 'text':
                $nm = [
                     'type' => 'text',
                     'data' => $numAndMsg
                ];
                $data = array_merge($dN,$nm);
               
                break;
             case 'image' :
                 $nm = [
                     'type' => 'image',
                     'data' => $numAndMsg
                 ];
                 $nm['data'] = [
                     'image' => $d->media,
                     'data' => $numAndMsg
                  ];
                $data = array_merge($dN,$nm);
                 break;
             case 'button' :
                 $nm = [
                     'type' => 'button',
                     'data' => $numAndMsg
                 ];
                 $nm['data'] = [
                     'footer' => $d->footer,
                     'button1' => $d->button1,
                     'button2' => $d->button2,
                     'data' => $numAndMsg
                  ];
                  $data = array_merge($dN,$nm);
              
     
                 break;
             case 'template' :
     
                 $nm = [
                     'type' => 'template',
                     'data' => $numAndMsg
                 ];
                 $nm['data'] = [
                     'footer' => $d->footer,
                     'template1' => $d->button1,
                     'template2' => $d->button2,
                     'data' => $numAndMsg
                  ];
                  $data = array_merge($dN,$nm);
                 break;
             default:
                 # code...
                 break;
     
     
         }

         $k = new BlastController();
         $d->is_executed = true;
         $d->save();
         $send = $k->sendBlast($data);

         }
         
     
     
         
          return 1;
        } catch (\Throwable $th) {
           Log::info($th);
        }
      




       
       
    }
}
