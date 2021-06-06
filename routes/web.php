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

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('discussions', App\Http\Controllers\DiscussionsController::class);
Route::resource('discussions/{discussion}/replies', App\Http\Controllers\RepliesController::class);

Route::post('/discussions/{discussion}/replies/{reply}mark-as-best-reply', [App\Http\Controllers\DiscussionsController::class, 'reply'])->name('discussion.best-reply');

Route::get('/users/notifications', [App\Http\Controllers\UsersController::class, 'notifications'])->name('users.notifications');





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

- go to App/Notifications/NewReplyAdded
- set up your notification, and also specify toMail or toDb or any other: 
  .. (mail, database, broadcast (real time notification), nexmo, and slack).

- Now, after you set up that, you can trigger the notification in the
  .. controller you want using '$user->notify()'.. in my case in RepliesController: 
        $discussion->author->notify();

- If you want to save notifs to db, use: 
        php artisan notifications:table
  This table has a many to many relationship to any other table
  .. but by default it's relate to the user table, you will see that relation in 'notifiable_type' column

- Some cool fucntions with notifications: 
    $user->markAsRead(); << mark all the notifications as read >> in UsersController.php
    $user->notifications << gives you the list of notifs of this user >> in UsersController.php


*/



//--------------------------------------------------------------------------
//                          Queue Jobs
//--------------------------------------------------------------------------
/*
- the configuration of the queue exist in config/queue.php

- queue jobs mean you add a job to this queue so it will be performed in the background!

- see config/queue.php file and read more about all type of queue connections
  .. by defualt the connection type is sync, we don't want that,
  .. cuz sync means do it immediatly, we want to store in the database
  .. in then we do it in the background

- So, go to '.env' and change the 'QUEUE_CONNECTION' to 'database' instead of 'sync'

- you can implements a queue in your notification class by adding implements ShouldQueue: 
        class ReplyMarkedAsBestReply extends Notification implements ShouldQueue
  obiously this implementation is in the class ReplyMarkedAsBestReply

- now, we want to make a job table so we can store the job we want to be queued
  .. to do that, do this: 
        php artisan queue:table
  It will create a migration for the queue jobs database table

- But this jobs won't be processed until you make a work first: 
        php artisan queue:work
  It will start processing jobs on the queue as a daemon!!!
  I was really wondering how web app will process something on the bg without a client requests,
  .. today I learned something new... this magical function (queue:work) which won't work in a shared hosting i think
  .. cuz you will need a server side that are running in the background and not just recieving requests and perform it
  .. for that you need to use Laravel Forge which allow you to deploy your laravel app to a cloud platforms easly.
*/




//--------------------------------------------------------------------------
//                          Using a Soope to filter discussions by channels
//--------------------------------------------------------------------------
/*
- I made a scope in te Discussion model called scopeFilterByChannels()

- to make the scope works you must prefex the function with 'scope' 

- The benifit of scope is to use the function staticlly, which means you can use it without
  .. making an object of the model, just like that Discussion::filterByChannels()
*/


//--------------------------------------------------------------------------
//                          Email Verifcation Function
//--------------------------------------------------------------------------
/*
- It's a built-in function in laravel, to implenet it go to User model and implement: 
        class User extends Authenticatable implements MustVerifyEmail
- Then go to the routes, and pass an array in the auth routes like this: 
        Auth::routes(['verify' => true]);

- That's it!!! the verfication code will be sent to the user's email!

- You can use that in a middleware, just like the auth, we used it in the DiscussionsController's contructor: 
        public function __construct(){
            $this->middleware('auth', 'verified')->only(['create','store']);
        }
- you can use it also as middleware for the routes.. i think

*/