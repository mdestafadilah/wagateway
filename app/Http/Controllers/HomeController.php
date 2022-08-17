<?php

namespace App\Http\Controllers;

use App\Models\Number;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    

    public function index(){
        
        $numbers = Number::whereStatus('Connected')->get();
   
        
      
        return view('home',[
            'numbers' => Auth::user()->numbers()->get()
        ]);
    }

  
    public function store(Request $request){
        $request->validate([
            'sender' => ['required','min:10','unique:numbers,body']
        ]);

        Number::create([
            'user_id' => Auth::user()->id,
            'body' => $request->sender,
            'webhook' => $request->urlwebhook,
            'status' => 'Disconnect',
            'messages_sent' => 0
        ]);

        return back()->with('alert',[
            'type' => 'success',
            'msg' => 'Devices Added!'
        ]);
    }
    public function destroy(Request $request){
        Number::find($request->deviceId)->delete();

        return back()->with('alert',[
            'type' => 'success',
            'msg' => 'Devices Deleted!'
        ]);
    }


    public function setHook(Request $request){
        $n = Number::whereBody($request->number)->first();
        $n->webhook = $request->webhook;
        $n->save();
        return true;
    }


    


    

}
