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

Auth::routes();


Route::middleware(['auth'])->group(function () {
    // module user
    Route::prefix('users')->group(function () {
        //list user
//        Route::get('/', 'UserController@index')->name('user.index');
        Route::get('/',[
            'as' => 'user.index',
            'uses' => 'UserController@index',
            'middleware' => 'checkacl:user-list',
        ]);


        //create user
        //Route::get('/create', 'UserController@create')->name('user.add');
        Route::get('/create',[
            'as' => 'user.add',
            'uses' => 'UserController@create',
            'middleware' => 'checkacl:user-add',
        ]);

        //Route::post('/create', 'UserController@store')->name('user.store');
        Route::post('/create',[
            'as' => 'user.store',
            'uses' => 'UserController@store',
            'middleware' => 'checkacl:user-add',
        ]);

        //Edit user
        //Route::get('/edit/{id}', 'UserController@edit')->name('user.edit');
        Route::get('/edit/{id}',[
            'as' => 'user.edit',
            'uses' => 'UserController@edit',
            'middleware' => 'checkacl:user-edit',
        ]);
        Route::post('/edit/{id}', 'UserController@update')->name('user.update');

        //Delete user
        //Route::get('/delete/{id}', 'UserController@delete')->name('user.delete');
        Route::get('/delete/{id}',[
            'as' => 'user.delete',
            'uses' => 'UserController@delete',
            'middleware' => 'checkacl:user-delete',
        ]);
    });

    // module role
    Route::prefix('roles')->group(function () {
        //list user
        Route::get('/', 'RoleController@index')->name('role.index');
        //create user
        Route::get('/create', 'RoleController@create')->name('role.add')->middleware('checkacl');
        Route::post('/create', 'RoleController@store')->name('role.store');

        //Edit user
        Route::get('/edit/{id}', 'RoleController@edit')->name('role.edit');
        Route::post('/edit/{id}', 'RoleController@update')->name('role.update');

        //Delete user
        Route::get('/delete/{id}', 'RoleController@delete')->name('role.delete');
    });
});


//Route::get('/home', 'HomeController@index')->name('home');
