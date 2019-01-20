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

// Route::get('/', function () {
//     return view('frontend.index');
// });

Route::get('/','FrontendController@index')->name('home');
Route::get('/obiekt'.'/{id}','FrontendController@object')->name('object');
Route::post('/roomSearch','FrontendController@roomsearch')->name('roomSearch');
Route::get('/room'.'/{id}','FrontendController@room')->name('room');
Route::get('/article'.'/{id}','FrontendController@article')->name('article');
Route::get('/person'.'/{id}','FrontendController@person')->name('person');

// Route::get(trans('routes.person'),'FrontendController@person')->name('person');
Route::get('/searchCities','FrontendController@searchCities');
Route::get('/ajaxGetRoomReservations/{id}','FrontendController@ajaxGetRoomReservations');

Route::get('/like/{likeable_id}/{type}','FrontendController@like' )->name('like');
Route::get('/unlike/{likeable_id}/{type}','FrontendController@unlike' )->name('unlike');

Route::post('/addComment/{commentable_id}/{type}','FrontendController@addComment')->name('addComment');
Route::post('/makeReservation/{room_id}/{city_id}','FrontendController@makeReservation')->name('makeReservation');


Route::group(['prefix'=>'admin','middleware'=>'auth'], function(){

  // for mobile
  Route::get('/getNotifications','BackendController@getNotifications');
  Route::post('/setReadNotifications','BackendController@setReadNotifications');


  Route::get('/','BackendController@index')->name('adminHome');
  Route::get('/myObjects','BackendController@myobjects')->name('myObjects');
  Route::match(['GET','POST'],'/saveObject'.'/{id?}','BackendController@saveobject')->name('saveObject');
  Route::match(['GET','POST'],'/profile','BackendController@profile')->name('profile');
  Route::get('/deletePhoto/{id}','BackendController@deletePhoto')->name('deletePhoto');
  Route::match(['GET','POST'],'/saveRoom'.'/{id?}','BackendController@saveRoom')->name('saveRoom');
  Route::get('deleteRoom'.'/{id}','BackendController@deleteRoom')->name('deleteRoom');

  Route::get('/deleteArticle/{id}','BackendController@deleteArticle')->name('deleteArticle');
  Route::post('/saveArticle/{id?}','BackendController@saveArticle')->name('saveArticle');


  Route::get('ajaxGetReservationData','BackendController@ajaxGetReservationData');
  Route::get('/ajaxSetReadNotification','BackendController@ajaxSetReadNotification');
  Route::get('/ajaxGetNotShownNotifications','BackendController@ajaxGetNotShownNotifications');
  Route::get('/ajaxSetShownNotifications','BackendController@ajaxSetShownNotifications');



  Route::get('/confirmReservation/{id}','BackendController@confirmReservation')->name('confirmReservation');
  Route::get('/deleteReservation/{id}','BackendController@deleteReservation')->name('deleteReservation');

  Route::resource('cities','CityController');

  Route::get('/deleteObject'.'/{id}','BackendController@deleteObject')->name('deleteObject');




});

Auth::routes();
