<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index(){
        return view('auth.register');
    }

    public function store(Request $request){
       
        $request->validate([
            'username' => 'unique:users|min:4|required',
            'email' => 'unique:users|email|required',
            'password'  => 'required|min:5'
        ]);

    
        User::create(
            [
                'username' =>$request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'api_key' => '',
                'chunk_blast' => 0

            ]
        );

        return redirect(route('login'))->with('alert',[
            'type' => 'success',
            'msg' => 'Registrasi success,please sign in'
        ]);
    }
}
