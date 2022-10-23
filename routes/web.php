<?php
use App\Http\Controllers\FirebaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

//enable cors
Route::middleware(['cors'])->group(function () {

//post methods
Route::post('/signin', array('uses'=>'FirebaseController@signIn'));
Route::post('/signup', array('uses'=>'FirebaseController@signUp'));
Route::post('/editUsername', array('uses'=>'FirebaseController@updateUsername'));
Route::post('/edit_email', array('uses'=>'FirebaseController@updateEmail'));
Route::post('/editPassword', array('uses'=>'FirebaseController@updatePassword'));
Route::post('/passSignIn', array('uses'=>'FirebaseController@signInWithPassword'));
Route::post('/reset', array('uses'=>'FirebaseController@resetPassword'));
Route::post('/editCover', array('uses'=>'FirebaseController@editCover'));
Route::post('/disableAccount', array('uses'=>'FirebaseController@disableAccount'));
Route::post('/enableAccount', array('uses'=>'FirebaseController@enableAccount'));
Route::post('/editPhoto', array('uses'=>'FirebaseController@updatePhoto'));

//get methods
Route::get('/signout', array('uses'=>'FirebaseController@signOut'));
Route::get('/table', array('uses'=>'FirebaseController@table'));
Route::get('/table_disabled', array('uses'=>'FirebaseController@table_disabled'));
Route::get('/delete', array('uses'=>'FirebaseController@DeleteUser'));
Route::get('/initialize', array('uses'=>'FirebaseController@initializeSession'));
Route::get('/recover', array('uses'=>'FirebaseController@recover'));
Route::get('/test', array('uses'=>'FirebaseController@test'));
Route::get('/downloadPhoto', array('uses'=>'FirebaseController@downloadPhoto'));

//for views
Route::get('/', function () {
    return view('index');
})->name('home');
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/edit', function () {
    return view('editProfile');
});
Route::get('/leaderboard', function () {
    return view('leaderboard');
});
Route::get('/about', function () {
    return view('aboutcontent');
});
Route::get('/admin', function () {
    return view('admin');
});
Route::get('/disableAccountView', function () {
    return view('disableUser');
});
Route::get('/enableAccountView', function () {
    return view('enableUser');
});
Route::get('/game', function () {
    return view('game');
});
});
 
