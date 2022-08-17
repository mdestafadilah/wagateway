<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use mysqli;

class SettingController extends Controller
{
    
    public function index(){
        return view('pages.settings');
    }

    public function test_database_connection(Request $request)
{

  $error_message = null;

  $k = json_encode($request->database);
  $data = json_decode($k);
  
    try {
       
       $db = mysqli_connect($data->host,$data->username,$data->password,$data->database);
        if($db->connect_errno){
            $error_message = 'Connection Failed .'. $db->connect_error;
            
        }
    } catch (\Throwable $th) {
        $error_message = 'Connection failed';
    }
  


  return response()->json(['status' => $error_message ?? 'Success']);
}


    public function setServer(Request $request){
        if($request->typeServer === 'other'){
            $request->validate([
                'portnode' => ['required'],
                'urlnode' => ['required','url']
            ]);
            $urlnode = $request->urlnode .':'. $request->portnode;
        } else if($request->typeServer === 'hosting') {
            $urlnode = url('/');
        } else if($request->typeServer === 'localhost'){
            $urlnode = 'http://localhost:'.$request->portnode ;
        }
$this->setEnv('TYPE_SERVER',$request->typeServer);
$this->setEnv('PORT_NODE',$request->portnode);
$this->setEnv('WA_URL_SERVER',$urlnode);

return back()->with('alert',[
    'type' => 'success',
    'msg' => 'Success Update configuration!'
]);




    }


    public function activate_license(Request $request){
    
        try {
           $push = Http::withOptions(['verify' => false])->asForm()->post('https://license-management.m-pedia.my.id/api/license/activate',[
               'email' => $request->email,
               'host' => $_SERVER['HTTP_HOST'],
               'licensekey' => $request->license
           ]);
           $res = json_decode($push);
return $res;
   
        } catch (\Throwable $th) {
           return 'false';
        }
    }



    public function generateNewApiKey(Request $request){
        $newApiKey = Str::random(30);
      $user = Auth::user();
      $user->api_key =  $newApiKey;
      $user->update();
      return back()->with('alert',[
          'type' => 'success',
          'msg' => 'Success set new Api Key'
      ]);
    }
    public function changeChunk(Request $request){
        $chunk = $request->chunk;
      $user = Auth::user();
      $user->chunk_blast =  $chunk;
      $user->update();
      return back()->with('alert',[
          'type' => 'success',
          'msg' => 'Success change chunk'
      ]);
    }

    public function setEnv(string $key,string $value){
        
        $env =  array_reduce(file(base_path('.env'), FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES), 
        function($carry, $item)
        {
          list($key, $val) = explode('=', $item, 2);

          $carry[$key] = $val;

          return $carry;
        }, []);
     $env[$key] = $value;
      foreach($env as $k => &$v)
       $v = "{$k}={$v}";


file_put_contents(base_path('.env'),implode("\r\n",$env));
    }



    public function changePassword(ChangePasswordRequest $request){
            $new = bcrypt($request->new);
          Auth::user()->update([
              'password' => $new
          ]);
          return back()->with('alert',[
            'type' => 'success',
            'msg' => 'Password Changed'
        ]);
    }


    public function install(Request $request){
        if(env('APP_INSTALLED')=== true){
            return redirect('/');
        }
        if($request->method() === 'POST')
      {        
        $request->validate([
          'database.*'          => 'string|required',
         //'licensekey'           => 'required',
         //'buyeremail'           =>'required|email',
          'admin.username'      => 'required',
          'admin.email'         => 'required|email',
          'admin.password'      => 'required|max:255',
        ]);

         /** CREATE DATABASE CONNECTION STARTS **/
         $db_params = $request->input('database');
         Config::set("database.connections.mysql", array_merge(config('database.connections.mysql'), $db_params));
         try 
         {
           DB::connection()->getPdo();
         }
         catch (\Exception $e)
         {
            
           $validator = Validator::make($request->all(), [])
                        ->errors()->add('Database', $e->getMessage());

           return redirect()->back()->withErrors($validator)->withInput();
         }
       /** CREATE DATABASE CONNECTION ENDS **/


       /** CREATE DATABASE TABLES STARTS **/
         DB::transaction(function()
         {
             
           DB::unprepared(File::get(base_path('database/db_tables.sql')));
         });
       /** CREATE DATABASE TABLES ENDS **/
   /** SETTING .ENV VARS STARTS **/
   $env =  array_reduce(file(base_path('.env'), FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES), 
   function($carry, $item)
   {
     list($key, $val) = explode('=', $item, 2);

     $carry[$key] = $val;

     return $carry;
   }, []);

   if(isset($_SERVER['REQUEST_SCHEME'])){
       $urll = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}";   
   } else {
       $urll = $_SERVER['HTTP_HOST'];
   }
$env['DB_HOST']       = $db_params['host'];
$env['DB_DATABASE']   = $db_params['database'];
$env['DB_USERNAME']   = $db_params['username'];
$env['DB_PASSWORD']   = $db_params['password'];
$env['APP_URL']       = $urll;
$env['APP_INSTALLED'] = 'true';
$env['LICENSE_KEY'] = $request->input('licensekey');
$env['BUYER_EMAIL'] = $request->input('buyeremail');

foreach($env as $k => &$v)
$v = "{$k}={$v}";

file_put_contents(base_path('.env'), implode("\r\n", $env));
/** SETTING .ENV VARS ENDS **/


   /** CREATE ADMIN USER STARTS **/
   if(!$user = User::where('email', $request->input('admin.email'))->first())
   {
     $user = new User;

     $user->username = $request->input('admin.username');
     $user->email = $request->input('admin.email');
     $user->password = Hash::make($request->input('admin.password'));
     $user->email_verified_at = date('Y-m-d');
    

     $user->save();
   }
 /** CREATE ADMIN USER END **/
 Auth::loginUsingId($user->id,true);
        return redirect()->route('home');
      }
      $mysql_user_version = ['distrib' => '', 'version' => null, 'compatible' => false];

        if(function_exists('exec') || function_exists('shell_exec'))
        {
          $mysqldump_v = function_exists('exec') ? exec('mysqldump --version') : shell_exec('mysqldump --version');
  
          if($mysqld = str_extract($mysqldump_v, '/Distrib (?P<destrib>.+),/i'))
          {
            $destrib = $mysqld['destrib'] ?? null;
  
            $mysqld = explode('-', mb_strtolower($destrib), 2);
  
            $mysql_user_version['distrib'] = $mysqld[1] ?? 'mysql';
            $mysql_user_version['version'] = $mysqld[0];
  
            if($mysql_user_version['distrib'] == 'mysql' && $mysql_user_version['version'] >= 5.6)
            {
              $mysql_user_version['compatible'] = true;
            }
            elseif($mysql_user_version['distrib'] == 'mariadb' && $mysql_user_version['version'] >= 10)
            {
              $mysql_user_version['compatible'] = true;
            }
          }
        }
       
        $requirements = [
            "php" => ["version" => 7.4, "current" => phpversion()],
            "mysql" => ["version" => 5.6, "current" => $mysql_user_version],
            "php_extensions" => [
              "curl" => false,
              "fileinfo" => false,
              "intl" => false,
              "json" => false,
              "mbstring" => false,
              "openssl" => false,
              "mysqli" => false,
              "zip" => false,
              "ctype" => false,
              "dom" => false,
            ],
          ];
    
          $php_loaded_extensions = get_loaded_extensions();
        
    
          foreach($requirements['php_extensions'] as $name => &$enabled)
          {
              $enabled = in_array($name, $php_loaded_extensions);
          }
        return view('install',[
            'requirements' => $requirements
        ]);
    }

}