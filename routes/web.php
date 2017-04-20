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
    Route::get('profile', 'ProfileController@index')->name('profile.index');
    Route::get('/apartments/create', 'ApartmentController@create')->name('apartments.create');
    Route::post('/apartments/store', 'ApartmentController@store')->name('apartments.store');
    Route::get('/apartments/{apartment}/edit', 'ApartmentController@edit')->name('apartments.edit');
    Route::post('/apartments/{apartment}', 'ApartmentController@update')->name('apartments.update');
    Route::post('/apartments/{apartment}/comment/store', 'CommentController@store')->name('comments.store');
    Route::post('/apartments/{apartment}/rate', 'RatingController@store')->name('apartments.rate');
});

Route::get('/apartments/{apartment}', 'ApartmentController@show')->name('apartments.show');

Route::get('/user/{user}/apartments/datatable/ads/{type}', 'ProfileController@showApartmentsDatatable')->name('user.apartments.datatable');

/*Admin*/
Route::get('/admin/moderator', ['as' => 'admin.moderator.index', 'uses' => 'Admin\ModeratorController@index',]);
Route::get('/admin/moderator/datatable', ['as' => 'admin.moderator.datatable', 'uses' => 'Admin\ModeratorController@showDatatables']);
Route::get('/admin/moderator/{apartment}', ['as' => 'admin.moderator.apartment', 'uses' => 'Admin\ModeratorController@show']);
Route::post('/admin/moderator/{apartment}/response', ['as' => 'admin.moderator.apartment.response', 'uses' => 'Admin\ModeratorController@update']);

Route::get('/admin/users', ['as' => 'admin.users.index', 'uses' => 'Admin\UserController@index']);
Route::get('/admin/users/datatable', ['as' => 'admin.users.datatable', 'uses' => 'Admin\UserController@showDatatables']);
Route::get('/admin/users/datatable/{user}/ads/{adType}', ['as' => 'admin.users.datatable.ads', 'uses' => 'Admin\UserController@showDatatablesApartments']);

Route::get('/admin/users/{user}', ['as' => 'admin.users.user', 'uses' => 'Admin\UserController@show']);
Route::post('/admin/users/{user}/update', ['as' => 'admin.users.user.response', 'uses' => 'Admin\UserController@update']);

Route::get('/admin/users/{user}/{apartment}/edit', ['as' => 'admin.users.user.apartment', 'uses' => 'Admin\UserController@edit']);
Route::post('/admin/users/{user}/{apartment}/update', ['as' => 'admin.users.user.apartment.response', 'uses' => 'Admin\UserController@updateApartment']);



Route::get('/admin/report', ['as' => 'admin.report.index', 'uses' => 'Admin\ReportController@index']);

Route::post('/admin/report/filter', ['as' => 'admin.report.filter', 'uses' => 'Admin\ReportController@graphFilter']);



Route::get('/analytics', ['as' => 'admin.analytics.index']);

