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

//Route::get('login/', function () {
//    return view('login');
//})->name('login');

Route::get('/', 'FrontDoorController@index');

//Route::post('login', 'LoginController@authenticate');
//Route::get('logout', 'LoginController@logout');

Route::put('json/user/chpwd', 'UserController@chpwd');

Route::get('json/user/search/{searchText}', 'UserController@search');
Route::get('json/user/searchName/{name}', 'UserController@searchName');
Route::get('json/user', 'UserController@index');
Route::get('json/user/auth', 'UserController@getAuthUser');
Route::get('json/user/{id}', 'UserController@show');
Route::post('json/user', 'UserController@store');
Route::put('json/user/{id}', 'UserController@update');

Route::get('json/account/search/{searchText}', 'AccountController@search');
Route::get('json/account/searchName/{name}', 'AccountController@searchName');
Route::get('json/account', 'AccountController@index');
Route::get('json/account/levels', 'AccountController@levels');
Route::get('json/account/sectors', 'AccountController@sectors');
Route::get('json/account/{id}', 'AccountController@show');
Route::post('json/account', 'AccountController@store');
Route::put('json/account/{id}', 'AccountController@update');
Route::get('json/account/nextContacts/{date}/{openContacts}/{id?}', 'AccountController@byNextContactDateAndUser');

Route::post('json/communication', 'CommunicationController@store');
Route::put('json/communication', 'CommunicationController@update');
Route::get('json/communication/types', 'CommunicationController@types');

Route::post('json/address', 'AddressController@store');
Route::put('json/address', 'AddressController@update');
Route::get('json/address/types', 'AddressController@types');
Route::get('json/address/typeAdd/{name}', 'AddressController@typeAdd');
Route::get('json/address/typeRemove/{id}', 'AddressController@typeRemove');

Route::get('json/aux', 'AuxiliaryController@list');//not used atm

Route::get('json/aux/addressTypes', 'AuxiliaryController@addressTypes');
Route::get('json/aux/addressType/{id}', 'AuxiliaryController@addressType');
Route::post('json/aux/addressType', 'AuxiliaryController@newAddressType');
Route::put('json/aux/addressType', 'AuxiliaryController@updateAddressType');
//Route::get('json/aux/addressType/delete/{id}', 'AuxiliaryController@deleteAddressType')->middleware('auth');

Route::get('json/aux/communicationTypes', 'AuxiliaryController@communicationTypes');
Route::get('json/aux/communicationType/{id}', 'AuxiliaryController@communicationType');
Route::post('json/aux/communicationType', 'AuxiliaryController@newCommunicationType');
Route::put('json/aux/communicationType', 'AuxiliaryController@updateCommunicationType');
//Route::get('json/aux/communicationType/delete/{id}', 'AuxiliaryController@deleteCommunicationType');

Route::get('json/aux/sectors', 'AuxiliaryController@sectors');
Route::get('json/aux/sector/{id}', 'AuxiliaryController@sector');
Route::post('json/aux/sector', 'AuxiliaryController@newSector');
Route::put('json/aux/sector', 'AuxiliaryController@updateSector');

Route::get('json/aux/connectionTypes', 'AuxiliaryController@connectionTypes');
Route::get('json/aux/connectionType/{id}', 'AuxiliaryController@connectionType');
Route::post('json/aux/connectionType', 'AuxiliaryController@newConnectionType');
Route::put('json/aux/connectionType', 'AuxiliaryController@updateConnectionType');

Route::get('json/aux/remarkTypes', 'AuxiliaryController@remarkTypes');
Route::get('json/aux/remarkType/{id}', 'AuxiliaryController@remarkType');
Route::post('json/aux/remarkType', 'AuxiliaryController@newRemarkType');
Route::put('json/aux/remarkType', 'AuxiliaryController@updateRemarkType');

Route::get('json/contact/allInAccount/{accountId}', 'ContactController@allInAccount');
Route::get('json/contact/searchInAccount/{accountId}/{name?}', 'ContactController@searchInAccount');
Route::get('json/contact/searchInAccountWithout/{accountId}/{name?}', 'ContactController@searchInAccountWithoutAdhoc');
Route::get('json/contact/searchAll/{name?}', 'ContactController@searchAll');
Route::get('json/contact/delete/{id}', 'ContactController@delete');
Route::post('json/contact/store', 'ContactController@store');

Route::post('json/connection/toContact', 'ConnectionController@storeToContact');
Route::post('json/connection/toAddress', 'ConnectionController@storeToAddress');
Route::put('json/connection', 'ConnectionController@update');
Route::get('json/connection/delete/{id}', 'ConnectionController@delete');
Route::get('json/connection/types', 'ConnectionController@types');

Route::post('json/remark/toContact', 'RemarkController@storeToContact');
Route::post('json/remark/toAddress', 'RemarkController@storeToAddress');
Route::put('json/remark', 'RemarkController@update');
Route::get('json/remark/delete/{id}', 'RemarkController@delete');
Route::get('json/remark/types', 'RemarkController@types');
