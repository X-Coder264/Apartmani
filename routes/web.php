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

Auth::routes();

Route::get('/', 'HomeController@index')->name('index');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/apartments/create', 'ApartmentController@create')->name('apartments.create');
    Route::post('/apartments/store', 'ApartmentController@store')->name('apartments.store');
    Route::post('/apartments/{apartment}/comment/store', 'CommentController@store')->name('comments.store');
});

Route::get('/apartments/{apartment}', 'ApartmentController@show')->name('apartments.show');

Route::get('/admin', ['as' => 'admin', 'uses' => 'AdminController@index',]);
Route::get('/admin/moderator', ['as' => 'admin.moderator', 'uses' => 'AdminController@getModeratorData']);
Route::get('/admin/users', ['as' => 'admin.users', 'uses' => 'AdminController@getUsers']);
Route::get('/admin/usersDatatables', ['as' => 'admin.usersDatatables', 'uses' => 'AdminController@getUsersData']);
Route::get('/admin/users/{user}', ['as' => 'admin.users.user', 'uses' => 'AdminController@showUser']);
Route::post('/admin/users/{user}/update', ['uses' => 'AdminController@updateUser']);
Route::get('/admin/users/{user}/{apartments}/edit', ['as' => 'admin.users.user.apartment.edit', 'uses' => 'AdminController@showUsersApartment']);
Route::post('/admin/users/{user}/{apartments}/edit', ['uses' => 'AdminController@editUsersApartment']);
Route::get('/admin/{apartment}', ['as' => 'admin.moderator.apartment', 'uses' => 'AdminController@showApartment']);
Route::post('/admin/{apartment}/response', 'AdminController@getApartmentResponse');
Route::get('/admin/usersDatatables/{user}/active-ads/{adType}', ['as' => 'admin.usersDatatables.activeAds', 'uses' => 'AdminController@getUsersActiveAds']);