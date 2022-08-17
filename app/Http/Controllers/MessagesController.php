<?php

namespace App\Http\Controllers;

use App\Models\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
class MessagesController extends Controller
{
    
    public function index(){
        return view('pages.messagetest',[
            'numbers' => Auth::user()->numbers()->get()
        ]);
       
    }


    public function textMessageTest(Request $request){
        $data = [
             'type' => 'text',
            'sender' => $request->sender,
            'number' => $request->number,
            'message' => $request->message
        ];

       $da = Number::whereBody($request->sender)->first();
        if($da->status !== 'Connected'){
            return back()->with('alert',[
                'type' => 'danger',
                'msg' => 'Your sender is not connected!'
            ]);
        }
        try {
            $response = $this->postMsg($data,'backend-message');
        $res = json_decode($response);
        
        $alert = $res->status ? 'success' : 'danger';
       $msg = $res->msg;
        } catch (\Throwable $th) {
            $alert = 'danger';
            $msg = 'There is trouble in your node server';
        }
       
       return back()->with('alert',[
           'type' => $alert,
           'msg' => $msg
       ]);
    }
    public function imageMessageTest(Request $request){
        $data = [
            'type' => 'image',
            'sender' => $request->sender,
            'url' => $request->image,
            'number' => $request->number,
            'message' => $request->message
        ];
        $da = Number::whereBody($request->sender)->first();
        if($da->status !== 'Connected'){
            return back()->with('alert',[
                'type' => 'danger',
                'msg' => 'Your sender is not connected!'
            ]);
        }
        $arr = explode('.',$request->image);
        $ext = end($arr);
        $allowed = ['jpg','jpeg','png'];
       
        if(!in_array($ext,$allowed)){
            return back()->with('alert',[
                'type' => 'danger',
                'msg' => 'Invalid Url, allowerd JPG,PNG,JPEG'
            ]);
        }
try {
    $response = $this->postMsg($data,'backend-media');
    $res = json_decode($response);
   $alert = $res->status ? 'success' : 'danger';
   $msg = $res->msg;
} catch (\Throwable $th) {
   $alert = 'danger';
   $msg = 'There is error in your node server!';
}
        $response = $this->postMsg($data,'backend-media');
        $res = json_decode($response);
       $alert = $res->status ? 'success' : 'danger';
       return back()->with('alert',[
           'type' => $alert,
           'msg' => $msg
       ]);
    }
    public function buttonMessageTest(Request $request){
        $data = [
            'type' => 'button',
            'sender' => $request->sender,
            'number' => $request->number,
            'message' => $request->message,
            'footer' => $request->footer,
            'button1' => $request->button1,
            'button2' => $request->button2
        ];
        $da = Number::whereBody($request->sender)->first();
        if($da->status !== 'Connected'){
            return back()->with('alert',[
                'type' => 'danger',
                'msg' => 'Your sender is not connected!'
            ]);
        }
        try {
            $response = $this->postMsg($data,'backend-button');
        $res = json_decode($response);
       $alert = $res->status ? 'success' : 'danger';
       $msg = $res->msg;
        } catch (\Throwable $th) {
            $alert = 'danger';
            $msg = 'There is error in your node server!';
        }
       
       return back()->with('alert',[
           'type' => $alert,
           'msg' => $msg
       ]);
    }
    public function templateMessageTest(Request $request){
        $data = [
            'type' => 'template',
            'sender' => $request->sender,
            'number' => $request->number,
            'message' => $request->message,
            'footer' => $request->footer,
            'template1' => $request->template1,
            'template2' => $request->template2
        ];

        $da = Number::whereBody($request->sender)->first();
        if($da->status !== 'Connected'){
            return back()->with('alert',[
                'type' => 'danger',
                'msg' => 'Your sender is not connected!'
            ]);
        }
        try {
            //code...
            $response = $this->postMsg($data,'backend-template');
            $res = json_decode($response);
           $alert = $res->status ? 'success' : 'danger';
           $msg = $res->msg;
        } catch (\Throwable $th) {
            $alert = 'danger';
            $msg = 'There is trouble in your node server!';
        }
       return back()->with('alert',[
           'type' => $alert,
           'msg' => $msg
       ]);
    }




    public function postMsg($data,$url){
        try {
           
           $post = Http::withOptions(['verify' => false])->asForm()->post(env('WA_URL_SERVER').'/'.$url,$data);
           if(json_decode($post)->status === true){
              $c = Number::whereBody($data['sender'])->first();
              $c->messages_sent += 1;
              $c->save();
           }
           return $post;
        } catch (\Throwable $th) {
            var_dump($th);
            die;
           return json_encode(['status' => false,'msg' => 'Make sure your server Node already running!']);
        }
    }
}
