<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Number;
use Illuminate\Support\Facades\Http;
class ApiController extends Controller
{
    
    

    public function messageText(Request $request){
       
       if(!isset($request->sender) || !isset($request->api_key) || !isset($request->number) || !isset($request->message)){
        return response()->json([
            'status' => false ,
            'msg' => 'Wrong parameters!',
        ],Response::HTTP_BAD_REQUEST);
       }
       
    
      
        $data = Number::whereBody($request->sender)->with('user')->first();
    if(!$data){
        return response()->json([
            'status' => false ,
            'msg' => 'Invalid data!',
        ],Response::HTTP_BAD_REQUEST);
    }
      
    if($request->api_key !== $data->user->api_key){
        return response()->json([
            'status' => false ,
            'msg' => 'Wrong API KEY',
        ],Response::HTTP_BAD_REQUEST);
    }

    if($data->status !=='Connected'){
        return response()->json([
            'status' => false ,
            'msg' => 'Your sender is not connected yet!',
        ],Response::HTTP_BAD_REQUEST);
    }

        $post = json_decode($this->postMsg([
            'type' => 'text',
            'sender' => $request->sender,
            'number' => $request->number,
            'message' => $request->message
        ],'/backend-message'));

        return response()->json([
            'status' => $post->status ,
            'msg' => $post->msg,
        ],Response::HTTP_ACCEPTED);
    
    }



    public function messageImage(Request $request){
       
        if(!isset($request->sender) || !isset($request->api_key) || !isset($request->number) || !isset($request->message) || !isset($request->url)){
         return response()->json([
             'status' => false ,
             'msg' => 'Wrong parameters!',
         ],Response::HTTP_BAD_REQUEST);
        }

        $arr = explode('.',$request->url);
        $ext = end($arr);
        $allowed = ['jpg','jpeg','png'];
        if(!in_array($ext,$allowed)){
            return response()->json([
                'status' => false ,
                'msg' => 'Image URL Not Valid',
            ],Response::HTTP_BAD_REQUEST);
        }
        

     
       
         $data = Number::whereBody($request->sender)->with('user')->first();
     if(!$data){
         return response()->json([
             'status' => false ,
             'msg' => 'Invalid data!',
         ],Response::HTTP_BAD_REQUEST);
     }
       
     if($request->api_key !== $data->user->api_key){
         return response()->json([
             'status' => false ,
             'msg' => 'Wrong API KEY',
         ],Response::HTTP_BAD_REQUEST);
     }
 
     if($data->status !=='Connected'){
         return response()->json([
             'status' => false ,
             'msg' => 'Your sender is not connected yet!',
         ],Response::HTTP_BAD_REQUEST);
     }
 
         $post = json_decode($this->postMsg([
             'type' => 'image',
             'sender' => $request->sender,
             'number' => $request->number,
             'message' => $request->message,
             'url' => $request->url
         ],'/backend-media'));
 
         return response()->json([
             'status' => $post->status ,
             'msg' => $post->msg,
         ],Response::HTTP_ACCEPTED);
     
     }
    public function messageDocument(Request $request){
       
        if(!isset($request->sender) || !isset($request->api_key) || !isset($request->number)  || !isset($request->url)){
         return response()->json([
             'status' => false ,
             'msg' => 'Wrong parameters!',
         ],Response::HTTP_BAD_REQUEST);
        }

        $arr = explode('.',$request->url);
        $ext = end($arr);
        $allowed = ['pdf','doc','docx'];
        if(!in_array($ext,$allowed)){
            return response()->json([
                'status' => false ,
                'msg' => 'File URL Not Valid,ALLOWED PDF,DOC,DOCX',
            ],Response::HTTP_BAD_REQUEST);
        }
        

     
       
         $data = Number::whereBody($request->sender)->with('user')->first();
     if(!$data){
         return response()->json([
             'status' => false ,
             'msg' => 'Invalid data!',
         ],Response::HTTP_BAD_REQUEST);
     }
       
     if($request->api_key !== $data->user->api_key){
         return response()->json([
             'status' => false ,
             'msg' => 'Wrong API KEY',
         ],Response::HTTP_BAD_REQUEST);
     }
 
     if($data->status !=='Connected'){
         return response()->json([
             'status' => false ,
             'msg' => 'Your sender is not connected yet!',
         ],Response::HTTP_BAD_REQUEST);
     }
 
         $post = json_decode($this->postMsg([
             'type' => 'document',
             'sender' => $request->sender,
             'number' => $request->number,
             'url' => $request->url
         ],'/backend-document'));
 
         return response()->json([
             'status' => $post->status ,
             'msg' => $post->msg,
         ],Response::HTTP_ACCEPTED);
     
     }


     public function messageButton(Request $request){
       
        if(!isset($request->sender) || !isset($request->api_key) || !isset($request->number) || !isset($request->message)   || !isset($request->footer) || !isset($request->button1) || !isset($request->button2)){
         return response()->json([
             'status' => false ,
             'msg' => 'Wrong parameters!',
         ],Response::HTTP_BAD_REQUEST);
        }
       
         $data = Number::whereBody($request->sender)->with('user')->first();
     if(!$data){
         return response()->json([
             'status' => false ,
             'msg' => 'Invalid data!',
         ],Response::HTTP_BAD_REQUEST);
     }
       
     if($request->api_key !== $data->user->api_key){
         return response()->json([
             'status' => false ,
             'msg' => 'Wrong API KEY',
         ],Response::HTTP_BAD_REQUEST);
     }
 
     if($data->status !=='Connected'){
         return response()->json([
             'status' => false ,
             'msg' => 'Your sender is not connected yet!',
         ],Response::HTTP_BAD_REQUEST);
     }
 
         $post = json_decode($this->postMsg([
             'type' => 'button',
             'sender' => $request->sender,
             'number' => $request->number,
             'message' => $request->message,
             'footer' => $request->footer,
             'button1' => $request->button1,
             'button2' => $request->button2,
         ],'/backend-button'));
 
         return response()->json([
             'status' => $post->status ,
             'msg' => $post->msg,
         ],Response::HTTP_ACCEPTED);
     
     }
 
     public function messageTemplate(Request $request){
       
        if(!isset($request->sender) || !isset($request->api_key) || !isset($request->number) || !isset($request->message)   || !isset($request->footer) || !isset($request->template1) || !isset($request->template2)){
         return response()->json([
             'status' => false ,
             'msg' => 'Wrong parameters!',
         ],Response::HTTP_BAD_REQUEST);
        }
       
         $data = Number::whereBody($request->sender)->with('user')->first();
     if(!$data){
         return response()->json([
             'status' => false ,
             'msg' => 'Invalid data!',
         ],Response::HTTP_BAD_REQUEST);
     }
       
     if($request->api_key !== $data->user->api_key){
         return response()->json([
             'status' => false ,
             'msg' => 'Wrong API KEY',
         ],Response::HTTP_BAD_REQUEST);
     }
 
     if($data->status !=='Connected'){
         return response()->json([
             'status' => false ,
             'msg' => 'Your sender is not connected yet!',
         ],Response::HTTP_BAD_REQUEST);
     }
 
         $post = json_decode($this->postMsg([
             'type' => 'template',
             'sender' => $request->sender,
             'number' => $request->number,
             'message' => $request->message,
             'footer' => $request->footer,
             'template1' => $request->template1,
             'template2' => $request->template2,
         ],'/backend-template'));
 
         return response()->json([
             'status' => $post->status ,
             'msg' => $post->msg,
         ],Response::HTTP_ACCEPTED);
     
     }
 

    public function postMsg($data,$url){
        try {
           
           $post =  Http::withOptions(['verify' => false])->asForm()->post(env('WA_URL_SERVER').$url,$data);
           if(json_decode($post)->status === true){
            $c = Number::whereBody($data['sender'])->first();
            $c->messages_sent += 1;
            $c->save();
         }
         return $post;
        } catch (\Throwable $th) {
        
           return json_encode(['status' => false,'msg' => 'Make sure your server Node already running!']);
        }
    }
}
