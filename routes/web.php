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
// Koristim ga za tacnp preusmjeravanje kroz stranice i kroz druge fajlove i 
// Vraca sadrzaj drugih fajloova sto znaci da moze da bude i json

// Route::get('/hello', function () {
//     return "hello World";
// });
// Primjer kako se prenose paratmetri u zahtjevima 
//  Tj rute rade preusmjeravanje na neke stranice prenoseci
// Odredjene podatke ukoliko je potrebano

// Route::get('/users/{id}/{name}',function($id,$name){
//     return 'This is user '.$name .'with the id of '.$id;
// });
Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');