<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class UserController extends Controller
{
   
    public function changePassword(){
        return view('pages.user.changepassword');
    }

    public function changePasswordPost(ChangePasswordRequest $request)
    {
        $new = bcrypt($request->new);
        Auth::user()->update([
            'password' => $new
        ]);
        return back()->with('alert', [
            'type' => 'success',
            'msg' => 'Password Changed'
        ]);
    }

    public function generateNewApiKey(Request $request)
    {
        $newApiKey = Str::random(30);
        $user = Auth::user();
        $user->api_key =  $newApiKey;
        $user->update();
        return back()->with('alert', [
            'type' => 'success',
            'msg' => 'Success set new Api Key'
        ]);
    }

    public function changeChunk(Request $request)
    {
        $chunk = $request->chunk;
        $user = Auth::user();
        $user->chunk_blast =  $chunk;
        $user->update();
        return back()->with('alert', [
            'type' => 'success',
            'msg' => 'Success change chunk'
        ]);
    }

}
