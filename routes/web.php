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


Route::get('/admin-login', function () {

        return view('admin.login');
    
})->name('login');

Route::post('/admin/authentication', 'Admin\LoginController@loginAction')->name('admin.authentication');

Route::group(['middleware' => ['admin']], function() {
    
    Route::as('admin.')->prefix('admin')->group( function() {
        Route::get('dashboard','Admin\DashboardController@index')->name('dashboard');

        Route::get('admin/edit/profile', function() {
            $user = Auth::guard('admin')->user();
            return view('admin.editProfile',['user' => $user]);
        })->name('edit.profile');

        Route::get('employees', 'Admin\DashboardController@employeeList')->name('employees');
        Route::get('visitors','Admin\DashboardController@vistorList')->name('visitors');
        Route::get('feedback','Admin\DashboardController@feedbackList')->name('feedback');   

        Route::post('update/profile','Admin\DashboardController@updateProfile')->name('updateProfile');
        Route::get('change/password','Admin\DashboardController@changePassword')->name('change.password');
        Route::post('update/password','Admin\DashboardController@updateProfilePassword')->name('update.password');
        Route::get('logout','Auth\LoginController@logout')->name('logout');

        Route::as('timewall.')->prefix('timewall')->group(function() {

            Route::get('list','Admin\TimeWallController@list')->name('list');
            Route::get('create','Admin\TimeWallController@create')->name('create');
            Route::post('store','Admin\TimeWallController@store')->name('storeTimeWall');
            Route::get('edit/{id}','Admin\TimeWallController@edit')->name('edit');
            Route::put('update/{id}','Admin\TimeWallController@update')->name('updateTimeWall');
            Route::delete('delete/{id}','Admin\TimeWallController@destroy')->name('delete');
        });

        Route::as('largevideowall.')->prefix('largevideowall')->group(function() {

            Route::get('list','Admin\LargeVideoWallController@list')->name('list');
            Route::get('create','Admin\LargeVideoWallController@create')->name('create');
            Route::post('store','Admin\LargeVideoWallController@store')->name('storeLargeVideoWall');
            Route::get('edit/{id}','Admin\LargeVideoWallController@edit')->name('edit');
            Route::put('update/{id}','Admin\LargeVideoWallController@update')->name('updateLargeVideoWall');
            Route::delete('delete/{id}','Admin\LargeVideoWallController@destroy')->name('delete');
        });

    });
});