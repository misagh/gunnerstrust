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
Route::get('/t/{id}', 'ArticleController@short')->name('articles.short');

Route::prefix('articles')->group(function ()
{
    Route::any('/add', 'ArticleController@add')->name('articles.add');
    Route::any('/edit/{id}', 'ArticleController@edit')->name('articles.edit');
    Route::get('/delete/{id}', 'ArticleController@delete')->name('articles.delete');
    Route::any('/lists', 'ArticleController@lists')->name('articles.lists');
    Route::post('/pin', 'ArticleController@pin')->name('articles.pin');
    Route::get('{slug}', 'ArticleController@view')->name('articles.view');
});

Route::prefix('topics')->middleware('auth')->group(function ()
{
    Route::get('{slug}', 'TopicController@view')->name('topics.view');
});

Route::prefix('admin')->middleware('admin')->group(function ()
{
    Route::get('articles/optimize', 'AdminController@articlesOptimize')->name('admin.articles.optimize');
});

Route::prefix('users')->middleware('auth')->group(function ()
{
    Route::post('/edit', 'UserController@edit')->name('users.edit');
    Route::post('/password', 'UserController@password')->name('users.password');
    Route::get('/list', 'UserController@list')->name('users.list');
    Route::get('/messages', 'UserController@messages')->name('users.messages');
    Route::get('/profile/{username}', 'UserController@profile')->name('users.profile');
});

Route::prefix('details')->middleware('auth')->group(function ()
{
    Route::post('/edit', 'DetailController@edit')->name('details.edit');
});

Route::prefix('comments')->group(function ()
{
    Route::get('list', 'CommentController@list')->name('comments.list');
    Route::get('fetch/{type}/{id}', 'CommentController@fetch')->name('comments.fetch');
    Route::post('add/{type}/{id}', 'CommentController@add')->name('comments.add');
    Route::post('delete/{id}', 'CommentController@delete')->name('comments.delete');
    Route::post('edit/{id}', 'CommentController@edit')->name('comments.edit');
    Route::post('reaction/add/{id}/{emoji}', 'CommentController@reactionAdd')->name('comments.reaction.add');
    Route::post('reaction/list/{id}', 'CommentController@reactionList')->name('comments.reaction.list');
});

Route::prefix('messages')->middleware('auth')->group(function ()
{
    Route::post('send', 'MessageController@send')->name('messages.send');
    Route::any('view/{id}', 'MessageController@view')->name('messages.view');
});

Route::prefix('avatars')->middleware('auth')->group(function ()
{
    Route::post('add', 'AvatarController@add')->name('avatars.add');
});
