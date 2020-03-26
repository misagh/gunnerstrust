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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::prefix('articles')->group(function ()
{
    Route::middleware('admin')->group(function ()
    {
        Route::any('/add', 'ArticleController@add')->name('articles.add');
        Route::any('/edit/{id}', 'ArticleController@edit')->name('articles.edit');
        Route::get('/delete/{id}', 'ArticleController@delete')->name('articles.delete');
    });

    Route::any('/lists', 'ArticleController@lists')->name('articles.lists');
    Route::get('{slug}', 'ArticleController@view')->name('articles.view');
});

Route::prefix('users')->group(function ()
{
    Route::middleware('auth')->group(function ()
    {
        Route::any('/profile/{username}', 'UserController@profile')->name('users.profile');
    });
});

Route::prefix('comments')->group(function ()
{
    Route::middleware('auth')->group(function ()
    {
        //Route::any('/profile/{username}', 'UserController@profile')->name('users.profile');
    });

    Route::get('fetch/{type}/{id}', 'CommentController@fetch')->name('comments.fetch');
    Route::post('add/{type}/{id}', 'CommentController@add')->name('comments.add');
    Route::post('delete/{id}', 'CommentController@delete')->name('comments.delete');
    Route::post('edit/{id}', 'CommentController@edit')->name('comments.edit');
    Route::post('reaction/{id}/{emoji}', 'CommentController@reaction')->name('comments.reaction');
});
