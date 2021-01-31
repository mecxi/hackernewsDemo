<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/', function(){
//   $retries = array(null, 'id'=>'1231');
//    echo count($retries).'<pre>'. print_r($retries, true).'</pre>';
//    if (!empty($retries)){
//        echo 'hello world';
//    }
//});
Route::group([
    'namespace' => 'App\Http\Controllers',
], function($router){
    Route::get('/', 'HomeController@index');
    Route::get('/{type}', 'HomeController@index');
    Route::get('/comments/{story_id}', 'HomeController@viewComments');
});
