<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Autoreply;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\Break_;

class AutoreplyController extends Controller
{

   
    public function index(){
        
        return view('pages.autoreply',[
            'numbers' => Auth::user()->numbers()->get(),
            'autoreplies' => Auth::user()->autoreplies()->orderBy('id','DESC')->get()
        ]);
    }

    

    public function store(Request $request){
        $type = $request->type;
        $request->validate([
            'keyword' => ['required','unique:autoreplies']
        ]);



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
                $buttons = [
                    ["buttonId" => "id1" , "buttonText" => ["displayText" => $request->button1], "type" => 1], 
                    ["buttonId" => "id2" , "buttonText" => ["displayText" => $request->button2], "type" => 1] 
                ];
                $buttonMessage = [
                    "text" => $request->message,
                    "footer" => $request->footer,
                    "buttons" => $buttons,
                    "headerType" => 1
                ];
                $reply = $buttonMessage;
                break;
            case 'template':
                if(!strpos($request->template1,'|') || !strpos($request->template2,'|')){
                    return redirect(route('autoreply'))->with('alert',[
                        'type' => 'danger',
                        'msg' => 'The Templates are not valid!'
                    ]);
                } 
               
                try {
                    $allowType = ['callButton','urlButton'];
                    $template1 = $request->template1;
                    $type1 = explode('|',$template1)[0].'Button';
                    $text1 = explode('|',$template1)[1];
                    $urlOrNumber1 = explode('|',$template1)[2];
                    $template2 = $request->template2;
                    $type2 = explode('|',$template2)[0].'Button';
                    $text2 = explode('|',$template2)[1];
                    if(!in_array($type1,$allowType) || !in_array($type2,$allowType)){
                        return redirect(route('autoreply'))->with('alert',[
                            'type' => 'danger',
                            'msg' => 'The Templates are not valid!'
                        ]);
                    }
                        $urlOrNumber2 = explode('|',$template2)[2];
                        $typePurpose1 = explode('|',$template1)[0] === 'url' ? 'url' : 'phoneNumber';
                        $typePurpose2 = explode('|',$template2)[0] === 'url' ? 'url' : 'phoneNumber';
                        $templateButtons = [
                            ["index" => 1, $type1 => ["displayText" => $text1,$typePurpose1 => $urlOrNumber1]],
                            ["index" => 2, $type2 => ["displayText" => $text2,$typePurpose2 => $urlOrNumber2]],
                        ];
                        $templateMessage = [
                            "text" => $request->message,
                            "footer" => $request->footer,
                            "templateButtons" => $templateButtons
                        ];
                        $reply = $templateMessage;
                    
                   
                } catch (\Throwable $th) {
                    echo 'There is error, Please contact 6282298859671';
                }
              
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
                    return  view('ajax.autoreply.buttonshow',[
                        'keyword'=>$dataAutoReply->keyword,
                        'message'=> json_decode($dataAutoReply->reply)->text,
                        'footer' => json_decode($dataAutoReply->reply)->footer,
                        'buttons'=> json_decode($dataAutoReply->reply)->buttons,
                        ])->render();
                    break;
                case 'template':
                  
              
                    return  view('ajax.autoreply.templateshow',[
                        'keyword'=>$dataAutoReply->keyword,
                        'message'=> json_decode($dataAutoReply->reply)->text,
                        'footer' => json_decode($dataAutoReply->reply)->footer,
                        'template1' => json_decode($dataAutoReply->reply)->templateButtons[0],
                        'template2' => json_decode($dataAutoReply->reply)->templateButtons[1]
                        
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
        Autoreply::whereUserId(Auth::user()->id)->delete();
        return redirect(route('autoreply'))->with('alert',[
            'type' => 'success',
            'msg' => 'Deleted'
        ]);
        
    }
}
