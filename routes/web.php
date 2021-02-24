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

//Logout
Route::get('/logout', 'AuthController@logout')->name('logout');

//AUTH PAGE (NOT LOGIN REQUIRED)
Route::group(['middleware' => ['prevent_Back_Button']], function () {
    Route::group(['middleware' => ['is_Not_Login']], function () {
        //Root Link -> Linked To Login
        Route::get('/', 'AuthController@login');

        //Login
        Route::get('/login', 'AuthController@login')->name('login');
        Route::post('/login', 'AuthController@login_process')->name('login_process');

        //Forgot Password
        Route::get('/forgot', 'AuthController@forgot_password')->name('forgot_password');
        Route::post('/forgot', 'AuthController@forgot_password_process')->name('forgot_password_process');

        //Change To New Password (Forgot Password)
        Route::get('/{email}/{token}/change', 'AuthController@change_password')->name('change_password');
        Route::post('/{email}/{token}/change', 'AuthController@change_password_process')->name('change_password_process');
    });
});

//USER PAGE (LOGIN REQUIRED)
Route::group(['middleware' => ['prevent_Back_Button']], function () {
    Route::group(['middleware' => ['is_Login']], function () {
        //Home
        Route::get('/home', 'HomeController@index')->name('home');

        //403 Forbidden Page
        Route::get('/forbidden', 'ErrorController@forbidden')->name('forbidden');

        //404 Not Found Page
        Route::get('/notfound', 'ErrorController@not_found')->name('not_found');

        //Notification
        Route::get('/notification', 'NotificationController@index')->name('notification');

        //FOR ADMIN ONLY
        Route::group(['middleware' => ['is_Admin']], function () {
            //Setting
            Route::group(['prefix' => 'setting'], function () {
                Route::get('/', 'SettingController@index')->name('setting');
                Route::patch('/', 'SettingController@update')->name('setting_update');
                Route::patch('/logo', 'SettingController@logo')->name('setting_logo');
                Route::patch('/favicon', 'SettingController@favicon')->name('setting_favicon');
            });

            //Operator
            Route::group(['prefix' => 'operator'], function () {
                Route::get('/', 'OperatorController@index')->name('operator');
                Route::get('/insert', 'OperatorController@insert')->name('operator_insert');
                Route::post('/insert', 'OperatorController@store')->name('operator_store');
                Route::get('/edit/{id}', 'OperatorController@edit')->name('operator_edit');
                Route::patch('/edit/{id}', 'OperatorController@update')->name('operator_update');
                Route::delete('/destroy/{id}', 'OperatorController@destroy')->name('operator_destroy');
            });
        });


        //Profile
        Route::group(['prefix' => 'u'], function () {
            Route::get('/{id}', 'ProfileController@index')->name('profile');
            Route::get('/{id}/setting', 'ProfileController@setting')->name('profile_setting');
            Route::patch('/{id}/setting', 'ProfileController@profile_update')->name('profile_setting_update');
            Route::put('/{id}/setting', 'ProfileController@password_update')->name('profile_setting_update_password');
            Route::patch('/{id}/setting/picture', 'ProfileController@picture_update')->name('profile_setting_update_picture');
        });

        //Content
        Route::group(['prefix' => 'content'], function () {
            Route::get('/', 'ContentController@index')->name('content');
            Route::get('/insert', 'ContentController@insert')->name('content_insert');
            Route::post('/insert/file', 'ContentController@store_file')->name('content_store_file');
            Route::post('/insert/link', 'ContentController@store_link')->name('content_store_link');
            Route::get('/edit/{id}', 'ContentController@edit')->name('content_edit');
            Route::patch('/edit/{id}/file', 'ContentController@update_file')->name('content_update_file');
            Route::patch('/edit/{id}/link', 'ContentController@update_link')->name('content_update_link');
            Route::delete('/destroy/{id}', 'ContentController@destroy')->name('content_destroy');

            // Provider Detail
            Route::group(['prefix' => '{content_id}'], function () {
                Route::get('/', 'ContentController@detail')->name('content_detail');
                Route::get('/download/{content_file_name}', 'ContentController@file_download')->name('content_file_download');
                Route::get('/preview/{content_file_name}', 'ContentController@file_preview')->name('content_file_preview');
            });
        });
    });
});

// TELEGRAM WEBHOOK
Route::patch('/telegram/setwebhook', 'TelegramController@refreshWebhook')->name('telegram_setwebhook');

Route::get('/test', 'Controller@image_intervention_test');
