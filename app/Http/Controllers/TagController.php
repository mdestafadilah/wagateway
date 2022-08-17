<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Number;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TagController extends Controller
{
    public function index(){

        return view('pages.tag',[
            'tags' => Auth::user()->tags()->get(),
            'senders' => Auth::user()->numbers()->get()
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required','min:3','unique:tags']
        ]);

        Tag::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name
        ]);

        return back()->with('alert',[
            'type' => 'success',
            'msg' => 'Success add tag!'
        ]);
    }


    public function destroy(Request $request){
        $t = Tag::with('contacts')->find($request->id);
        $t->delete();
        return back()->with('alert',[
            'type' => 'success',
            'msg' => 'Success delete tag!'
        ]);
    }

    public function fetchGroups(Request $request){
       try {
           $fetch =Http::withOptions(['verify' => false])->asForm()->post(env('WA_URL_SERVER').'/backend-getgroups',['sender' => $request->sender]);
          $respon = json_decode($fetch->body());

       if($respon->status === false){
        return back()->with('alert',[
            'type' => 'danger',
            'msg' => $respon->msg
        ]);
       }
                foreach ($respon->groups as $group) {
                    $tag = Tag::firstOrCreate(['user_id'=> Auth::user()->id,'name' => $group->subject .'( '.$group->id.' )']);
                    
                   foreach ($group->participants as $member) {
                      $number = str_replace('@s.whatsapp.net','',$member->id);
                      $cek = Number::whereId(Auth::user()->id)->whereBody($number)->count();
                     if($cek < 1){

                          $tag->contacts()->create(['user_id' => Auth::user()->id,'name' => $number,'number' => $number]);
                     }

                   }
                }
                return back()->with('alert',[
                    'type' => 'success',
                    'msg' => 'Generate success'
                ]);
         
       } catch (\Throwable $th) {
            throw $th;
       }
    }


    //  ajax
    public function view($id,Request $request){
        if($request->ajax()){
            $contacts = Tag::find($id)->contacts()->latest()->get();
            return view('ajax.tag.view',[
                'contacts' => $contacts
            ])->render();
        }
    }
}
