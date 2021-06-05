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

Route::resource('discussions', App\Http\Controllers\DiscussionsController::class);
Route::resource('discussions/{discussion}/replies', App\Http\Controllers\RepliesController::class);

Route::post('/discussions/{discussion}/replies/{reply}mark-as-best-reply', [App\Http\Controllers\DiscussionsController::class, 'reply'])->name('discussion.best-reply');







//------------------------------------------------------
//                  Remove Mass Assignment (model's fillable)
//------------------------------------------------------
/*
- To remove mass assignment you must override the Model class, and it's very simple thing: 
    - make a model called Model manually
    - extends the original Model class (rename it to BaseModel or what ever to prevent clashes)
    - put your override in this Model class..
    - my override was 'protected $guarded = [];' to remove mass assignment
    - now.. all other models that you don't want to use mass assign with it
      .. must extends this new Model not the original model, 
      .. simply by deleting 'use ...\..\..\Model;', so it will extends
      .. the Model file in the same folder which is the overrided one (the new one)!

    - to understand go and look at the Models folder


*/

//--------------------------------------------------------------------------
//                  Changing Name Space (not available in laravel 8!!!)
//--------------------------------------------------------------------------
/*
-unfortunatally it's not available in laravel 8!!
- just do the following line:
        php artisan app:name Forum
- yup, now it's Forum

*/



//--------------------------------------------------------------------------
//                  Provider + AppServiceProvider + View::share() method
//--------------------------------------------------------------------------
/*
- Provider: If you open the config/app.php file included with Laravel, you will see a providers array.
  .. These are all of the service provider classes that will be loaded for your application.
  .. Which so Providers or Service Providers is the services that works with booting (when you start the app)

  .. By default, a set of Laravel core service providers are listed in this array (config/app.php >> providers[]). 
  .. These providers bootstrap the core Laravel components, such as the mailer, queue, cache, and others. 
  .. Many of these providers are "deferred" providers, meaning they will not be loaded on every request, 
  .. but only when the services they provide are actually needed.

- AppServiceProvider: this is just like the other service providers, but as a good practise, this is the one
  .. that you can edit and change. And that's why we're gonna use it.

- View::share(): this method will share anything you pass to the parameter to all the views, 
  .. we will use it in the AppServiceProvider so it can work when the app booted.

*/


//--------------------------------------------------------------------------
//                  Customize Models Relationship (functions name)
//--------------------------------------------------------------------------
/*
- go to Discussion Model, as you can see we changed user() to author(),
  .. but this thing will give you an error cuz laravel won't know what is
  .. the forign key for this function which must be 'user_id'!!
  .. So you have to specify that in the belongsTo(User::class, 'user_id')
  .. in the author function
- see it by yourself in the model
*/


//--------------------------------------------------------------------------
//                  OverRide Route's Model Binding (discussions/{id} to dissussions/{slug or title or..})
//--------------------------------------------------------------------------
/*
- in routing instead of 'discussion/{id}' you change it to
  .. 'discussion/{slug}' for example.

- to do that you have to use this method in the model: 
    getRouteKeyName()

- go and see the model Discussion

*/

//--------------------------------------------------------------------------
//                  Don't make Multiple layouts/app.blade.php
//--------------------------------------------------------------------------
/*
- Yeah, Don't make Multiple layouts/app.blade.php!! 
  .. instead, use all the if else methods and the laravel @auth and so on... 
- loke at the app.blade.php
- use these it's very useful for this purpose: 
        - @auth
        - @if 
        - request()->path() <<<< this gives you the current path 
        - @if(in_array($request->path()), ['put the paths you want', '','',...])


*/


//--------------------------------------------------------------------------
//                  Fun Tricks
//--------------------------------------------------------------------------
/*
1- (don't use this, use 3) To redirect the user after he login, go to: 
        ReigsterController.php
        LoginController.php
  then, change the $redirectTo to whatever you want (to '/discussions' in my case)

2- (don't use this, use 3) To redirect the authed user if he visit login or register, since he is already logged in
  .. go to 
        Middleware/RedirectIfAuthenticated.php
  then change the redirect to whatever (to '/discussions' in my case)


3- DON't use 1 and 2... in laravel 8 just go to:
        Providers/RouteServiceProvider.php
   And change HOME to whatever (to '/discussions' in my case) and that's it!!!
   .. No need to change it all one by one!!

*/


//--------------------------------------------------------------------------
//                          Notification
//--------------------------------------------------------------------------
/*
- To make a notification: 
        php artisan make:notification NewReplyAdded

- go to App/Notifications 
- set up your notification, and also specify toMail or toDb or both 

- Now, after you set up that, you can trigger the notification in the
  .. controller you want using '$user->notify()'.. in my case in RepliesController: 
        $discussion->author->notify();




*/