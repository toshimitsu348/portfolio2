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

Route::get('/post/index', 'PostController@index');
Route::get('/post/index2', 'PostController@index2');
Route::get('/post/create', 'PostController@create');
                                        //  ⬆︎メソッド(createのこと)
// １行の塊を「ルーティング」と呼ぶ。→「Route::get('/post/index', 'PostController@index');」などのこと。
Route::get('/post/favorite/{post_id}', 'PostController@favorite');
                            //⬆️変数名 post_idの変数でaタグからのリクエストを受け取る。
                // ⬆️空白に全角を使うとエラーになる。
Route::get('/post/favorite/delete/{post_id}', 'FavoriteController@delete');

Route::get('/mypage/postlist/', 'PostController@postlist');
Route::get('/mypage/postedit/{post_id}', 'PostController@edit');
Route::post('/post/update/{post_id}', 'PostController@update');
Route::get('/mypage/profile/', 'FavoriteController@profile');
Route::get('/mypage/profileedit/', 'FavoriteController@edit');
Route::post('/mypage/profileupdate/', 'FavoriteController@update');
Route::get('/mypage/evaluationlist/', 'FavoriteController@evaluationlist');
Route::post('/post/store', 'PostController@store');
// getメソッドとpostメソッドの技術的な違いは、以下の通りです。
// ・get：パラメーターをURLに組み込む(付加する)
// ・post：パラメーターをリクエストボディに組み込む(付加する)

// API用
Route::post('/post/list', 'PostController@list');
Route::post('/post/favorite/create', 'FavoriteController@create');
Route::post('/post/favorite/delete', 'FavoriteController@delete');

Route::get('/sample', 'HomeController@index');

Auth::routes();

Route::get('/home', 'PostController@index')->name('home');

// React練習用
Route::get('counter/', 'PostController@counter');