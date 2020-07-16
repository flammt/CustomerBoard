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

use Illuminate\Support\Facades\Route;

Route::get('login/', function () {
    return view('login');
})->name('login');

Route::get('/', 'FrontDoorController@index')->middleware('auth');

Route::post('login', 'LoginController@authenticate');
Route::get('logout', 'LoginController@logout');

Route::put('json/user/chpwd', 'UserController@chpwd')->middleware('auth');

Route::get('json/user/search/{searchText}', 'UserController@search')->middleware('auth');
Route::get('json/user/searchName/{name}', 'UserController@searchName')->middleware('auth');
Route::get('json/user', 'UserController@index')->middleware('auth');
Route::get('json/user/auth', 'UserController@getAuthUser')->middleware('auth');
Route::get('json/user/{id}', 'UserController@show')->middleware('auth');
Route::post('json/user', 'UserController@store')->middleware('auth');
Route::put('json/user/{id}', 'UserController@update')->middleware('auth');

Route::get('json/account/search/{searchText}', 'AccountController@search')->middleware('auth');
Route::get('json/account/searchName/{name}', 'AccountController@searchName')->middleware('auth');
Route::get('json/account', 'AccountController@index')->middleware('auth');
Route::get('json/account/levels', 'AccountController@levels')->middleware('auth');
Route::get('json/account/sectors', 'AccountController@sectors')->middleware('auth');
Route::get('json/account/{id}', 'AccountController@show')->middleware('auth');
Route::post('json/account', 'AccountController@store')->middleware('auth');
Route::put('json/account/{id}', 'AccountController@update')->middleware('auth');
Route::get('json/account/nextContacts/{date}/{openContacts}/{id?}', 'AccountController@byNextContactDateAndUser')->middleware('auth');

Route::post('json/communication', 'CommunicationController@store')->middleware('auth');
Route::put('json/communication', 'CommunicationController@update')->middleware('auth');
Route::get('json/communication/types', 'CommunicationController@types')->middleware('auth');

Route::post('json/address', 'AddressController@store')->middleware('auth');
Route::put('json/address', 'AddressController@update')->middleware('auth');
Route::get('json/address/types', 'AddressController@types')->middleware('auth');
Route::get('json/address/typeAdd/{name}', 'AddressController@typeAdd')->middleware('auth');
Route::get('json/address/typeRemove/{id}', 'AddressController@typeRemove')->middleware('auth');

Route::get('json/aux', 'AuxiliaryController@list')->middleware('auth');//not used atm

Route::get('json/aux/addressTypes', 'AuxiliaryController@addressTypes')->middleware('auth');
Route::get('json/aux/addressType/{id}', 'AuxiliaryController@addressType')->middleware('auth');
Route::post('json/aux/addressType', 'AuxiliaryController@newAddressType')->middleware('auth');
Route::put('json/aux/addressType', 'AuxiliaryController@updateAddressType')->middleware('auth');
//Route::get('json/aux/addressType/delete/{id}', 'AuxiliaryController@deleteAddressType')->middleware('auth');

Route::get('json/aux/communicationTypes', 'AuxiliaryController@communicationTypes')->middleware('auth');
Route::get('json/aux/communicationType/{id}', 'AuxiliaryController@communicationType')->middleware('auth');
Route::post('json/aux/communicationType', 'AuxiliaryController@newCommunicationType')->middleware('auth');
Route::put('json/aux/communicationType', 'AuxiliaryController@updateCommunicationType')->middleware('auth');
//Route::get('json/aux/communicationType/delete/{id}', 'AuxiliaryController@deleteCommunicationType')->middleware('auth');

Route::get('json/aux/sectors', 'AuxiliaryController@sectors')->middleware('auth');
Route::get('json/aux/sector/{id}', 'AuxiliaryController@sector')->middleware('auth');
Route::post('json/aux/sector', 'AuxiliaryController@newSector')->middleware('auth');
Route::put('json/aux/sector', 'AuxiliaryController@updateSector')->middleware('auth');

Route::get('json/aux/connectionTypes', 'AuxiliaryController@connectionTypes')->middleware('auth');
Route::get('json/aux/connectionType/{id}', 'AuxiliaryController@connectionType')->middleware('auth');
Route::post('json/aux/connectionType', 'AuxiliaryController@newConnectionType')->middleware('auth');
Route::put('json/aux/connectionType', 'AuxiliaryController@updateConnectionType')->middleware('auth');

Route::get('json/aux/remarkTypes', 'AuxiliaryController@remarkTypes')->middleware('auth');
Route::get('json/aux/remarkType/{id}', 'AuxiliaryController@remarkType')->middleware('auth');
Route::post('json/aux/remarkType', 'AuxiliaryController@newRemarkType')->middleware('auth');
Route::put('json/aux/remarkType', 'AuxiliaryController@updateRemarkType')->middleware('auth');

Route::get('json/contact/allInAccount/{accountId}', 'ContactController@allInAccount')->middleware('auth');
Route::get('json/contact/searchInAccount/{accountId}/{name?}', 'ContactController@searchInAccount')->middleware('auth');
Route::get('json/contact/searchInAccountWithout/{accountId}/{name?}', 'ContactController@searchInAccountWithoutAdhoc')->middleware('auth');
Route::get('json/contact/searchAll/{name?}', 'ContactController@searchAll')->middleware('auth');
Route::get('json/contact/delete/{id}', 'ContactController@delete')->middleware('auth');
Route::post('json/contact/store', 'ContactController@store')->middleware('auth');

Route::post('json/connection/toContact', 'ConnectionController@storeToContact')->middleware('auth');
Route::post('json/connection/toAddress', 'ConnectionController@storeToAddress')->middleware('auth');
Route::put('json/connection', 'ConnectionController@update')->middleware('auth');
Route::get('json/connection/delete/{id}', 'ConnectionController@delete')->middleware('auth');
Route::get('json/connection/types', 'ConnectionController@types')->middleware('auth');

Route::post('json/remark/toContact', 'RemarkController@storeToContact')->middleware('auth');
Route::post('json/remark/toAddress', 'RemarkController@storeToAddress')->middleware('auth');
Route::put('json/remark', 'RemarkController@update')->middleware('auth');
Route::get('json/remark/delete/{id}', 'RemarkController@delete')->middleware('auth');
Route::get('json/remark/types', 'RemarkController@types')->middleware('auth');
