<?php

namespace App\Http\Controllers;

use App\Models\Blast;
use App\Models\Contact;
use App\Models\Number;
use App\Models\Schedule;
use App\Models\Tag;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;


class BlastController extends Controller
{
    public function index(){
   
      
        return view('pages.blast',[

          
        ]);
        
    }
    public function histories(){
        $h = Blast::where('user_id',Auth::user()->id)
        ->orderBy('created_at','desc')->get();
        return view('pages.blast-histories',[
            'histories' => $h //Auth::user()->blasts()->latest()->get()
        ]);
    }

    //ajax get page 
    public function getPageBlastText(Request $request){
      
        if($request->ajax()){
            return view('ajax.blast.formBlastText',[
                'numbers' => Auth::user()->numbers()->get(),
                'contacts' => Auth::user()->contacts()->get(),
                'tags' =>  Auth::user()->tags()->get(),
            ])->render();
        }
    }
    public function getPageBlastImage(Request $request){
      
        if($request->ajax()){
            return view('ajax.blast.formBlastImage',[
                'numbers' => Auth::user()->numbers()->get(),
                'contacts' => Auth::user()->contacts()->get(),
                'tags' =>  Auth::user()->tags()->get(),
            ])->render();
        }
    }
    public function getPageBlastButton(Request $request){
      
        if($request->ajax()){
            return view('ajax.blast.formBlastButton',[
                'numbers' => Auth::user()->numbers()->get(),
                'contacts' => Auth::user()->contacts()->get(),
                'tags' =>  Auth::user()->tags()->get(),
            ])->render();
        }
    }
    public function getPageBlastTemplate(Request $request){
      
        if($request->ajax()){
            return view('ajax.blast.formBlastTemplate',[
                'numbers' => Auth::user()->numbers()->get(),
                'contacts' => Auth::user()->contacts()->get(),
                'tags' =>  Auth::user()->tags()->get(),
            ])->render();
        }
    }


    // ajax proccess
    public function blastProccess(Request $request){
     
        if($request->ajax()){
            $destination = [];

            $dN = [  
                'sender' => $request->sender,
                'api_key' => Auth::user()->api_key,
                'delay' => $request->delay
               ];
               $destination = $this->getNumberbyTag($request->tag);
             
          if(count($destination) === 0 || count($destination) > Auth::user()->chunk_blast){
            session()->flash('alert',[
                'type' => 'danger',
                'msg' => 'the number of recipients does not match'
            ]);
            return 'false';
          }
        
                $numAndMsg = [];
             

                $cek = Number::whereBody($request->sender)->first();
                if($cek->status !== 'Connected'){
                    session()->flash('alert',[
                        'type' => 'danger',
                        'msg' => 'Your sender is not connected yet!'
                    ]);
                    return 'false';
                }
               
            if(strpos($request->message,'{name}')){
               
                    foreach ($destination as $d) {
                    // return $d;
                        $name = Contact::whereNumber($d)->first('name')->name;
                    
                       $numAndMsg[] = [
                           'number' => $d,
                           'msg' => str_replace('{name}',$name,$request->message)
                       ];
                    }
                  
            } else {
                foreach ($destination as $d) {
                   
                   $numAndMsg[] = [
                       'number' => $d,
                       'msg' => $request->message
                   ];
                }
            }
          
          // insert to database

$send = '';
            switch ($request->type) {
                case 'text':
                   $nm = [
                        'type' => 'text',
                        'data' => $numAndMsg
                   ];
                   $data = array_merge($dN,$nm);
                   if($request->tipe === 'schedule'){
                       Schedule::create([
                           'user_id' => Auth::user()->id,
                           'type' => 'text',
                           'sender' => $request->sender,
                           'numbers' => json_encode($destination),
                           'text' => $request->message,
                           'datetime' => $request->datetime
                       ]);
                   } 
               
                   break;
                case 'image' :
                    $nm = [
                        'type' => 'image',
                        'data' => $numAndMsg
                    ];
                    $nm['data'] = [
                        'image' => $request->image,
                        'data' => $numAndMsg
                     ];
                   $data = array_merge($dN,$nm);
                   if($request->tipe === 'schedule'){
                    Schedule::create([
                        'user_id' => Auth::user()->id,
                        'sender' => $request->sender,
                        'type' => 'image',
                        'numbers' => json_encode($destination),
                        'text' => $request->message,
                        'media' => $request->image,
                        'datetime' => $request->datetime
                    ]);
                } 
            
                 
            
                    break;
                case 'button' :
                    $nm = [
                        'type' => 'button',
                        'data' => $numAndMsg
                    ];
                    $nm['data'] = [
                        'footer' => $request->footer,
                        'button1' => $request->button1,
                        'button2' => $request->button2,
                        'data' => $numAndMsg
                     ];
                     $data = array_merge($dN,$nm);
                     if($request->tipe === 'schedule'){
                        Schedule::create([
                            'user_id' => Auth::user()->id,
                            'sender' => $request->sender,
                            'type' => 'button',
                            'numbers' => json_encode($destination),
                            'text' => $request->message,
                            'footer' => $request->footer,
                            'button1' => $request->button1,
                            'button2' => $request->button2,
                            'datetime' => $request->datetime
                        ]);
                    } 

                    break;
                case 'template' :

                    $nm = [
                        'type' => 'template',
                        'data' => $numAndMsg
                    ];
                    $nm['data'] = [
                        'footer' => $request->footer,
                        'template1' => $request->template1,
                        'template2' => $request->template2,
                        'data' => $numAndMsg
                     ];
                     $data = array_merge($dN,$nm);
                     if($request->tipe === 'schedule'){
                        Schedule::create([
                            'user_id' => Auth::user()->id,
                            'sender' => $request->sender,
                            'type' => 'template',
                            'numbers' => json_encode($destination),
                            'text' => $request->message,
                            'footer' => $request->footer,
                            'button1' => $request->template1,
                            'button2' => $request->template2,
                            'datetime' => $request->datetime
                        ]);
                    } 
                    
                    break;
                default:
                    # code...
                    break;
            }


            // insert to the database
           
           if($request->tipe === 'immediately'){
               $send = $this->sendBlast($data);
               $res = json_decode($send);
               session()->flash('alert',[
                   'type' => $res->status === true ? 'success' : 'danger',
                   'msg' => $res->msg
               ]);
                return $send;
           } else {
               
               session()->flash('alert',[
                'type' => 'success',
                'msg' => 'The message has scheduled.'
            ]);
             return 'true';
           }

          
        }
    }



    public function sendBlast($data){
        try {
            //code...
            return Http::asForm()->post(env('WA_URL_SERVER').'/backend-blast',$data);
                
        } catch (\Throwable $th) {
            session()->flash('alert',[
                'type' => 'danger',
                'msg' => 'There is trouble in your node server'
            ]);
            return 'false';
        }
    }
    public function getAllnumbers(){
        $contacts = Auth::user()->contacts()->get();
        $numbers = [];
        foreach ($contacts as $contact) {
            $numbers[] = $contact->number;
        }

        return $numbers;
        
    }

    public function getNumberbyTag($tag){
        $contacts = Tag::find($tag)->contacts()->get();
        $numbers = [];
        foreach ($contacts as $contact) {
            $numbers[] = $contact->number;
        }

        return $numbers;
    }


    public function destroy(Request $request){
        Auth::user()->blasts()->delete();
       return back()->with('alert',[
            'type' => 'success',
            'msg' => 'All Histories deleted'
        ]);
    }



    public function scheduled(){
        $scheduled = Schedule::whereUserId(Auth::user()->id)->latest()->get();
        return view('pages.scheduled-lists',[
            'schedule' => $scheduled
        ]);
    }
}
