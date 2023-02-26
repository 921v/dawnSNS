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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();
Route::get('/login', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//ログアウト中のページ
Route::get('/login', 'Auth\LoginController@login')->name('auth.login');
Route::post('/login', 'Auth\LoginController@login')->name('auth.login');

Route::get('/register', 'Auth\RegisterController@register')->name('auth.register');
Route::post('/register', 'Auth\RegisterController@register')->name('auth.register');

Route::get('/added', 'Auth\RegisterController@added')->name('auth.added');

Route::get('/',function(){
  return redirect('login');})->name('login');


//ログイン中のページ
Route::get('/top','PostsController@index')->name('top');
Route::post('/top','PostsController@index')->name('top');

Route::post('/top/update','PostsController@update');

  //ログインユーザー以外のページ
Route::get('/profile/{id}','UsersController@userProfile')->name('users.userProfile');

  //ログインユーザーページ
Route::get('/profile' , 'PostsController@profile');
Route::post('/profileEdit' , 'PostsController@profileEdit');

Route::get('/search','UsersController@search')->name('users.search');
Route::post('/search','UsersController@search')->name('users.search');

Route::get('/follow-list','FollowsController@followList');
Route::get('/follower-list','FollowsController@followerList');

Route::post('/follow','FollowsController@follow');
Route::post('/unfollow','FollowsController@unfollow');

Route::get('/logout','Auth\LoginController@logout');
