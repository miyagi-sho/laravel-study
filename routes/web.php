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
Route::group(['middleware' => 'auth'], function(){
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');
    Route::post('/folders/create', 'FolderController@create');

    Route::get('/users/{user}', 'UserController@index')->name('users.index');

    Route::get('/users/{user}/edit', 'UserController@showEditForm')->name('users.edit');
    Route::post('/users/{user}/edit', 'UserController@edit');

    Route::get('/tasks/search', 'TaskController@search')->name('tasks.search');

        Route::group(['middleware' => 'can:view,folder'], function(){
            Route::get('/folders/{folder}/tasks', 'TaskController@index')->name('tasks.index');

            Route::get('/folders/{folder}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
            Route::post('/folders/{folder}/tasks/create', 'TaskController@create');

            Route::get('/folders/{folder}/tasks/{task}', 'TaskController@showDetail')->name('tasks.detail');

            Route::get('/folders/{folder}/tasks/{task}/edit', 'TaskController@showEditForm')->name('tasks.edit');
            Route::post('/folders/{folder}/tasks/{task}/edit', 'TaskController@edit');

            Route::post('/folders/{folder}/tasks/{task}/share', 'TaskController@share')->name('tasks.share');
        });
});

Route::get('/folders/{folder}/tasks/{task}/share/{share}', 'TaskController@publicTask')->name('tasks.public');

Auth::routes();
