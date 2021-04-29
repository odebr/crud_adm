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

Route::redirect('/', '/payments');

// Authentication
Route::get('login', 'Auth\LoginController@login')->name('login');
Route::post('login', 'Auth\LoginController@authenticate');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@register')->name('register');
Route::post('register', 'Auth\RegisterController@store');

// Users
Route::prefix('users')->group(function() {
    Route::get('', 'UsersController@index')->name('users');
    Route::post('get_user_list', 'UsersController@getUserList');
    Route::post('save_user', 'UsersController@saveUser');
    Route::post('delete_user', 'UsersController@deleteUser');
});

// Imovel
Route::prefix('imovel')->group(function() {
    Route::get('', 'ImovelController@index');
    Route::post('get_imovel_list', 'ImovelController@getImovelList');
    Route::post('edit_imovel', 'ImovelController@editImovel');
    Route::post('delete_imovel', 'ImovelController@deleteImovel');
});

// Uploads
Route::prefix('upload')->group(function() {
    Route::get('', 'UploadController@index')->name('upload');
    Route::get('upload_files/{id}', 'UploadController@showUploadFiles');
    Route::post('upload_contrato', 'UploadController@uploadContrato');
    Route::post('upload_laudo', 'UploadController@uploadLaudo');
});

// Payments
Route::prefix('payments')->group(function() {
    Route::get('', 'PaymentController@index')->name('payments');
    Route::post('get_payments_list', 'PaymentController@getPaymentsList');
    Route::get('create_payment', 'PaymentController@createPayment');
    Route::post('save_payment', 'PaymentController@savePayment');
    Route::post('delete_payment', 'PaymentController@deletePayment');
    Route::post('upload_file', 'PaymentController@uploadFile');
    Route::post('edit_payment', 'PaymentController@editPayment');
});
