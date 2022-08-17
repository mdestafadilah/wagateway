<?php


use Illuminate\Support\Facades\Route;

Route::get('generate', function (){
return \Illuminate\Support\Facades\Artisan::call('storage:link');
  echo 'ok';
});
Route::get('schedule-run', function () {
  return Illuminate\Support\Facades\Artisan::call('schedule:run');
});
?>