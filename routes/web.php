<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api', 'ApiController@index')->name('api');
Route::match(array('GET','POST'),'/about', 'AboutController@index')->name('about');
Route::get('/contact', 'ContactController@index')->name('contact');
Route::get('/message', 'MissionController@index')->name('message');
Route::get('/vision', 'VisionController@index')->name('vision');
Route::get('/about/deletesocial/{id}','AboutController@deleteSocial')->name('aboutdeletesocial'); 
Route::get('/about/editsocial/{id}','AboutController@editSocial')->name('abouteditsocial'); 

Route::get('storage/{filename}', function ($filename)
{
    $path = storage_path('public/images' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});