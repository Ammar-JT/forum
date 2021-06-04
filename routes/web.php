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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//------------------------------------------------------
//                  Remove Mass Assignment (model's fillable)
//------------------------------------------------------
/*
- To remove mass assignment you must override the Model class, and it's very simple to do that


*/

//------------------------------------------------------
//                  Changing Name Space (not available in laravel 8!!!)
//------------------------------------------------------
/*
-unfortunatally it's not available in laravel 8!!
- just do the following line:
        php artisan app:name Forum
- yup, now it's Forum

*/