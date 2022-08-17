<?php

namespace App\Http\Middleware;

use App\Models\Number;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        if(!isset($request->sender) || !isset($request->api_key) || !isset($request->number) || !isset($request->message)){
            return response()->json([
                'status' => false ,
                'msg' => 'Wrong parameters!',
            ],Response::HTTP_BAD_REQUEST);
        }
        // check user by sender then check api key
        $data = Number::whereBody($request->sender)->with('user')->first();
        if(!$data){
            return response()->json([
                'status' => false ,
                'msg' => 'Invalid data!',
            ],Response::HTTP_BAD_REQUEST);
        }
        if($data->user->is_expired_subscription){
            return response()->json([
                'status' => false ,
                'msg' => 'Your subscription has expired!, contanct admin to renew your subscription',
            ],Response::HTTP_BAD_REQUEST);
        }
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
        return $next($request);
    }
}
