<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Autoreply;
use App\Models\Number;
use Illuminate\Validation\ValidationException;

class AutoreplyController extends Controller
{

   
    public function index(Request $request){
       
        return view('pages.autoreply',[
            'autoreplies' => Autoreply::where('user_id',Auth::id())->whereDevice(session()->get('selectedDevice'))->latest()->paginate(15),
            'numbers' => $request->user()->numbers()->get(),  
        ]);
    }


    

    public function store(Request $request){
        $type = $request->type;
      
       $cek = Autoreply::whereDevice($request->device)->whereKeyword($request->keyword)->first();
       if($cek){
     
        throw ValidationException::withMessages([
            'keyword' => ['Keyword already exists in same number'],
        ]);
       }




        switch ($type) {
            case 'text':
                $reply = ["text" => $request->message];
                break;
            case 'image';
                $request->validate([
                    'image' => ['required'],
                    'caption' => 'required',
                ]);
                $arr = explode('.',$request->image);
                $ext = end($arr);
                $allowext = ['jpg','png','jpeg'];
                if(!in_array($ext,$allowext)){
                    return redirect(route('autoreply'))->with('alert',[
                        'type' => 'danger',
                        'msg' => 'Only extension jpg,png and jpeg allowed!'
                    ]);
                }
                $reply = [
                   "image" => ["url" => $request->image],
                   "caption" => $request->caption
                ];
                break;
            case 'button':
                $request->validate([
                  
                    'button1' => 'required',
                ]);
                if($request->image){
                    $arr = explode('.',$request->image);
                    $ext = end($arr);
                    $allowext = ['jpg','png','jpeg'];
                    if(!in_array($ext,$allowext)){
                        return redirect(route('autoreply'))->with('alert',[
                            'type' => 'danger',
                            'msg' => 'Only extension jpg,png and jpeg allowed!'
                        ]);
                    }
                }
                $buttons = [
                    ["buttonId" => "id1" , "buttonText" => ["displayText" => $request->button1], "type" => 1], 
                ];
                 // add if exist button2
                if($request->button2){
                    $buttons[] = ["buttonId" => "id2" , "buttonText" => ["displayText" => $request->button2], "type" => 1];
                }
                // add if exist button3
                if($request->button3){
                    $buttons[] = ["buttonId" => "id3" , "buttonText" => ["displayText" => $request->button3], "type" => 1];
                }
                $buttonMessage = [
                    "text" => $request->message,
                    "footer" => $request->footer ?? '',
                    "buttons" => $buttons,
                    "headerType" => 1
                ];
                //add image to buttonMessage if exists
                if($request->image){
                    unset($buttonMessage['text']);
                    $buttonMessage['caption'] = $request->message;
                    $buttonMessage['image'] = ["url" => $request->image];
                    $buttonMessage['headerType'] = 4;
                   
                }
                $reply = $buttonMessage;
                break;
            case 'template':
                // if(!strpos($request->template1,'|') || !strpos($request->template2,'|')){
                //     return redirect(route('autoreply'))->with('alert',[
                //         'type' => 'danger',
                //         'msg' => 'The Templates are not valid!'
                //     ]);
                // } 
                $request->validate([
                    'template1' => 'required',
                   
                ]);
               
                try {
                   
                    $templateButtons = [];
                       $template1 = $this->makeTemplateButton($request->template1,1);
                          $templateButtons[] = $template1;
                       // if exist template2
                          if($request->template2){
                            $template2 = $this->makeTemplateButton($request->template2,2);
                            $templateButtons[] = $template2;
                            }
                          // if exist template3
                            if($request->template3){
                                $template3 = $this->makeTemplateButton($request->template3,3);
                                $templateButtons[] = $template3;
                                }


                        $templateMessage = [
                            "text" => $request->message,
                            "footer" => $request->footer ?? '',
                            "templateButtons" => $templateButtons
                        ];
                        //add image to templateMessage if exists
                        if($request->image){
                            unset($templateMessage['text']);
                            $templateMessage['caption'] = $request->message;
                            $templateMessage['image'] = ["url" => $request->image];
                          
                           
                        }
                        $reply = $templateMessage;
                    
                   
                } catch (\Throwable $th) {
                    echo 'There is error, Please contact 6282298859671';
                }
              
                break;
                case 'list':
                  $request->validate([
                    'list' => 'required'
                ]);
                $section  = [
                    "title" => $request->title,
                ];
                $i = 1;
                foreach($request->list as $menu ){
                   $i++;
                   $section['rows'][] = [
                    'title' => $menu,
                    'rowId' => 'id'.$i,
                    'description' => '',
                   ];
                }

                $listMessage = [
                    "text" => $request->message,
                    "footer" => $request->footer ?? '',
                    'title' => $request->name,
                    'buttonText' => $request->button,
                    "sections" => [$section]
                ];

                $reply = $listMessage;
                

                break;
            default:
                # code...
                break;
        }



       $jsonReply = json_encode($reply);
     Autoreply::create([
         'user_id' => Auth::id(),
         'device' => $request->device,
         'keyword' => $request->keyword,
         'type' => $request->type,
         'reply' => $jsonReply
     ]);

    return redirect(route('autoreply'))->with('alert',[
         'type' => 'success',
         'msg' => 'Your auto reply was added!'
     ]);

    }

    public function show($id,Request $request){
        
        if($request->ajax()){
            $dataAutoReply = Autoreply::find($id);
          
            switch ($dataAutoReply->type) {
                case 'text':
                    return view('ajax.autoreply.textshow',[
                        'keyword'=>$dataAutoReply->keyword,
                        'text'=> json_decode($dataAutoReply->reply)->text
                        ])->render();
                    break;
                case 'image':
                    return  view('ajax.autoreply.imageshow',[
                        'keyword'=>$dataAutoReply->keyword,
                        'caption'=> json_decode($dataAutoReply->reply)->caption,
                        'image'=> json_decode($dataAutoReply->reply)->image->url,
                        ])->render();
                    break;
                case 'button':
                    // if exists property image in $dataAutoreply->reply
                  
                    return  view('ajax.autoreply.buttonshow',[
                        'keyword'=>$dataAutoReply->keyword,
                        'message'=> json_decode($dataAutoReply->reply)->text ?? json_decode($dataAutoReply->reply)->caption,
                        'footer' => json_decode($dataAutoReply->reply)->footer,
                        'buttons'=> json_decode($dataAutoReply->reply)->buttons, 
                        'image'=> json_decode($dataAutoReply->reply)->image->url ?? null,
                        ])->render();
                    break;
                case 'template':
                  
              $templates = [];
              // if exists template 1

                    return  view('ajax.autoreply.templateshow',[
                        'keyword'=>$dataAutoReply->keyword,
                        'message'=> json_decode($dataAutoReply->reply)->text ?? json_decode($dataAutoReply->reply)->caption,
                        'footer' => json_decode($dataAutoReply->reply)->footer,
                        'templates' => json_decode($dataAutoReply->reply)->templateButtons,
                        'image' => json_decode($dataAutoReply->reply)->image->url ?? null,
                        ])->render();
                    break;
                default:
                    # code...
                    break;
            }
        }
    }

    public function getFormByType($type,Request $request){
        if($request->ajax()){
            switch ($type) {
                case 'text':
                   return view('ajax.autoreply.formtext')->render();
                    break;
                case 'image' :
                    return view('ajax.autoreply.formimage')->render();
                    break;
                case 'button' :
                    return view('ajax.autoreply.formbutton')->render();
                    break;
                case 'template' :
                    return view('ajax.autoreply.formtemplate')->render();
                    break;
                case 'list':
                    return view('ajax.autoreply.formlist')->render();
                    break;
                default:
                    # code...
                    break;
            }
            return;
        }
        return 'http request';
    }

    public function destroy(Request $request){
        Autoreply::whereId($request->id)->delete();
        return redirect(route('autoreply'))->with('alert',[
            'type' => 'success',
            'msg' => 'Deleted'
        ]);
        
    }
    public function destroyAll(Request $request){
        Autoreply::whereUserId(Auth::user()->id)->whereDevice(session()->get('selectedDevice'))->delete();
        return redirect(route('autoreply'))->with('alert',[
            'type' => 'success',
            'msg' => 'Deleted'
        ]);
    
    }


    public function makeTemplateButton($templateButton,$no){
        $allowType = ['callButton', 'urlButton'];
        $template = $templateButton;
        $type = explode('|', $template)[0] . 'Button';
        $text = explode('|', $template)[1];
        $urlOrNumber = explode('|', $template)[2];
      
        if (!in_array($type, $allowType)) {
            return redirect(route('autoreply'))->with('alert', [
                'type' => 'danger',
                'msg' => 'The Templates are not valid!'
            ]);
        }
      
        $typePurpose = explode('|', $template)[0] === 'url' ? 'url' : 'phoneNumber';
           return ["index" => $no, $type => ["displayText" => $text, $typePurpose => $urlOrNumber]];             
    }
}
