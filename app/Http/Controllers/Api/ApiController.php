<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Number;
use App\Models\User;
use Illuminate\Support\Facades\Http;
class ApiController extends Controller
{
    
    

    public function messageText(Request $request){
      
        $data = [
            'token' => $request->sender,
            'number' => $request->number,
            'text' => $request->message
        ];
        $number = Number::whereBody($request->sender)->first();
        if ($number->status == 'Disconnect') {
            return response()->json([
                'status' => false ,
                'msg' => 'Sender is disconnected',
            ],Response::HTTP_BAD_REQUEST);
         }

        $sendMessage = json_decode($this->postMsg($data, 'backend-send-text'));
        if (!$sendMessage->status) {
            return response()->json([
                'status' => false ,
                'msg' => $sendMessage->msg ?? $sendMessage->message,
            ],Response::HTTP_BAD_REQUEST);
         }
        $number->messages_sent += 1;
        $number->save();
        
        return response()->json([
            'status' => true ,
            'data' => $sendMessage->data,
        ],Response::HTTP_OK);
        
    
    }



    public function messageMedia(Request $request){
       
        if(!isset($request->url) || !isset($request->type)){
         return response()->json([
             'status' => false ,
             'msg' => 'Wrong parameters!',
         ],Response::HTTP_BAD_REQUEST);
        }
        if(!in_array($request->type,['image','video','audio','pdf','xls','xlsx','doc','docx','zip'])){
            return response()->json([
                'status' => false ,
                'msg' => 'Invalid type of media!',
            ],Response::HTTP_BAD_REQUEST);
        }
        $url = $request->url;
        $fileName = pathinfo($url, PATHINFO_FILENAME);
        $data = [
            'type' => $request->type,
            'token' => $request->sender,
            'url' => $request->url,
            'number' => $request->number,
            'caption' => $request->message,
            'fileName' => $fileName,
            'type' => $request->type
        ];
        $number = Number::whereBody($request->sender)->first();
        if ($number->status == 'Disconnect') {
            return response()->json(['status' => false ,'msg' => 'Sender is disconnected'],Response::HTTP_BAD_REQUEST);
        }
        $sendMessage = json_decode($this->postMsg($data, 'backend-send-media'));
        if (!$sendMessage->status) {
            return response()->json( ['status' => false, 'msg' => $sendMessage->msg ?? $sendMessage->message]);
        }
        $number->messages_sent += 1;
        $number->save();
        return response()->json(['status' => true, 'data' => $sendMessage->data]);
    
       
     
     }
  


     public function messageButton(Request $request){
       
        if(!isset($request->button1) || !isset($request->footer)){
         return response()->json([
             'status' => false ,
             'msg' => 'Wrong parameterss!',
         ],Response::HTTP_BAD_REQUEST);
        }

        $buttons = [];
        $buttons[] = ['displayText' => $request->button1];
        if(isset($request->button2)){
            $buttons[] = ['displayText' => $request->button2];
        }
        if(isset($request->button3)){
            $buttons[] = ['displayText' => $request->button3];
        }
           

        $data = [
            'token' => $request->sender,
            'number' => $request->number,
            'button' => json_encode($buttons),
            'message' => $request->message,
            'footer' => $request->footer ,
            'image' => $request->image ?? '',
        ];
        $number = Number::whereBody($request->sender)->first();
        if ($number->status == 'Disconnect') {
            return response()->json(['status' => false, 'msg' => 'Sender is disconnected'], Response::HTTP_BAD_REQUEST);
        }
        $sendMessage = json_decode($this->postMsg($data, 'backend-send-button'));
        if (!$sendMessage->status) {
            return response()->json(['status' => false, 'msg' => $sendMessage->msg ?? $sendMessage->message]);
        }
        $number->messages_sent += 1;
        $number->save();
        return response()->json(['status' => true, 'data' => $sendMessage->data]);
       
        
     }
 
     public function messageTemplate(Request $request){
       if(!$request->has('template1') || !$request->has('footer')){
           return response()->json([
               'status' => false ,
               'msg' => 'Wrong parameters!',
           ],Response::HTTP_BAD_REQUEST);
       }

        $templates = [];
        $makeTemplate1 = $this->createTemplate($request->template1,1);
        if(!$makeTemplate1['status']){
           return response()->json([
              'status' => false ,
              'msg' => $makeTemplate1['msg'],
           ],Response::HTTP_BAD_REQUEST);
        } else {
            $templates[] = $makeTemplate1['data'];
        }
        if($request->has('template2')){
            $makeTemplate2 = $this->createTemplate($request->template2,2);
            if(!$makeTemplate2['status']){
                return response()->json([
                    'status' => false ,
                    'msg' => $makeTemplate2['msg'],
                ],Response::HTTP_BAD_REQUEST);
            } else {
                $templates[] = $makeTemplate2['data'];
            }
        }
        if($request->has('template3')){
            $makeTemplate3 = $this->createTemplate($request->template3,3);
            if(!$makeTemplate3['status']){
                return response()->json([
                    'status' => false ,
                    'msg' => $makeTemplate3['msg'],
                ],Response::HTTP_BAD_REQUEST);
            } else {
                $templates[] = $makeTemplate3['data'];
            }
        }
      
      
        $data = [
            'token' => $request->sender,
            'number' => $request->number,
            'button' => json_encode($templates),
            'text' => $request->message,
            'footer' => $request->footer,
            'image' => $request->url ?? '',
        ];

        $number = Number::whereBody($request->sender)->first();
        if ($number->status == 'Disconnect') {
            return response()->json(['status' => false, 'msg' => 'Sender is disconnected'], Response::HTTP_BAD_REQUEST);
        }
        $sendMessage = json_decode($this->postMsg($data, 'backend-send-template'));
        if (!$sendMessage->status) {
            return response()->json(['status' => false, 'msg' => $sendMessage->msg ?? $sendMessage->message],Response::HTTP_BAD_REQUEST);
        }
        $number->messages_sent += 1;
        $number->save();
        return response()->json(['status' => true, 'data' => $sendMessage->data],Response::HTTP_OK);
     }

     public function messageList(Request $request){
        if(!$request->has('list1') || !$request->has('footer') || !$request->has('title') || !$request->has('name')){
            return response()->json([
                'status' => false ,
                'msg' => 'Wrong parameters!',
            ],Response::HTTP_BAD_REQUEST);
        }

        $section['title'] = $request->title;

        $i = 0;
        $section['rows'][] = [
            'title' => $request->list1,
            'rowId' => 'id1',
            'description' => '' 
        ];
        if($request->has('list2')){
            $i++;
            $section['rows'][] = [
                'title' => $request->list2,
                'rowId' => 'id2',
                'description' => '' 
            ];
        }
        if($request->has('list3')){
            $i++;
            $section['rows'][] = [
                'title' => $request->list3,
                'rowId' => 'id3',
                'description' => '' 
            ];
        }
        if($request->has('list4')){
            $i++;
            $section['rows'][] = [
                'title' => $request->list4,
                'rowId' => 'id4',
                'description' => '' 
            ];
        }
        if($request->has('list5')){
            $i++;
            $section['rows'][] = [
                'title' => $request->list5,
                'rowId' => 'id5',
                'description' => '' 
            ];
        }
       

        $data = [
            'token' => $request->sender,
            'number' => $request->number,
            'list' => json_encode($section),
            'text' => $request->message,
            'footer' => $request->footer,
            'title' => $request->title,
            'buttonText' => $request->name,
        ];
       
        $number = Number::whereBody($request->sender)->first();
        if ($number->status == 'Disconnect') {
            return response()->json(['status' => false, 'msg' => 'Sender is disconnected'], Response::HTTP_BAD_REQUEST);
        }
        $sendMessage = json_decode($this->postMsg($data, 'backend-send-list'));
        if (!$sendMessage->status) {
            return response()->json(['status' => false, 'msg' => $sendMessage->msg ?? $sendMessage->message],Response::HTTP_BAD_REQUEST);
        }
        $number->messages_sent += 1;
        $number->save();
        return response()->json(['status' => true, 'data' => $sendMessage->data],Response::HTTP_OK);

     
       
     }


    public function createTemplate($template,$no){
        try {
            //code...
            $allowType = ['callButton', 'urlButton', 'idButton'];
            $type = explode('|', $template)[0] . 'Button';
            $text = explode('|', $template)[1];
            $urlOrNumber = explode('|', $template)[2];
    
            if (!in_array($type, $allowType)) {
                return ['status' => false, 'msg' => "Wrong template $no type!"];
            }
    
            $ty = explode('|', $template)[0];
            $type = $ty ==  'id' ? 'quickReplyButton' : $type;
            if ($ty == 'url') {
                $typePurpose = 'url';
            } else if ($ty == 'call') {
                $typePurpose = 'phoneNumber';
            } else {
                $typePurpose = 'id';
            }

             

            $data = ["index" => $no, $type => ["displayText" => $text, $typePurpose => $urlOrNumber]];
            return ['status' => true, 'data' => $data];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'msg' => "The template $no is not valid",
            ];
        }
        
    }


    public function postMsg($data, $url)
    {
        try {

            $post = Http::withOptions(['verify' => false])->asForm()->post(env('WA_URL_SERVER') . '/' . $url, $data);
            return $post->body();
            if (json_decode($post)->status === true) {
                $c = Number::whereBody($data['sender'])->first();
                $c->messages_sent += 1;
                $c->save();
            }
            return $post;
        } catch (\Throwable $th) {
            return json_encode(['status' => false, 'msg' => 'Make sure your server Node already running!']);
        }
    }



    public function generateQr(Request $request){
        if(!$request->has('number') || !$request->has('api_key')){
            return response()->json([
                'status' => false ,
                'msg' => 'Wrong parameters!',
            ],Response::HTTP_BAD_REQUEST);
        }
       // check user by api key
        $user = User::whereApiKey($request->api_key)->first();
        if($user->is_expired_subscription){
            return response()->json([
                'status' => false ,
                'msg' => 'Your subscription has expired!',
            ],Response::HTTP_BAD_REQUEST);
        }
        if(!$user){
            return response()->json(['status' => false, 'msg' => 'Wrong api key!'],Response::HTTP_BAD_REQUEST);
        }
        $number = Number::whereBody($request->number)->first();
        $allnumber = Number::whereUserId($user->id)->get();
        if(!$number){
            if($user->limit_device <= count($allnumber) ){
                return response()->json(['status' => false, 'msg' => 'You have reached your limit of devices!'],Response::HTTP_BAD_REQUEST);
            }
            $number = new Number();
            $number->body = $request->number;
            $number->user_id = $user->id;
            $number->status = 'Disconnect';
            $number->save();
        }
        try {
            //code...
            $post = Http::withOptions(['verify' => false])->asForm()->post(env('WA_URL_SERVER') . '/backend-generate-qr', [
                'token' => $request->number,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Make sure your server Node already running!'],Response::HTTP_BAD_REQUEST);
        }
     // send respon json from post
     return response()->json(json_decode($post->body()),Response::HTTP_OK);
        
       
    }
}
