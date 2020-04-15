<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Petugas@register');
Route::post('login', 'Petugas@login');

Route::get("/","Petugas@tampil")->middleware('jwt.verify');

Route::get('user', 'Petugas@getAuthenticatedUser')->middleware('jwt.verify');

Route::post('/simpan_penyewa', 'Penyewa@store')->middleware('jwt.verify');
Route::put('/ubah_penyewa/{id}', 'Penyewa@update')->middleware('jwt.verify');
Route::get('/tampil_penyewa', 'Penyewa@tampil')->middleware('jwt.verify');
Route::get('/index_penyewa/{id}', 'Penyewa@index')->middleware('jwt.verify');
Route::delete('/hapus_penyewa/{id}', 'Penyewa@destroy')->middleware('jwt.verify');

Route::post('/simpan_jenismobil', 'Jenismobil@store')->middleware('jwt.verify');
Route::put('/ubah_jenismobil/{id}', 'Jenismobil@update')->middleware('jwt.verify');
Route::get('/tampil_jenismobil', 'Jenismobil@tampil')->middleware('jwt.verify');
Route::get('/index_jenismobil/{id}', 'Jenismobil@index')->middleware('jwt.verify');
Route::delete('/hapus_jenismobil/{id}', 'Jenismobil@destroy')->middleware('jwt.verify');

Route::post('/simpan_mobil', 'Mobil@store')->middleware('jwt.verify');
Route::put('/ubah_mobil/{id}', 'Mobil@update')->middleware('jwt.verify');
Route::get('/tampil_mobil', 'Mobil@tampil')->middleware('jwt.verify');
Route::get('/index_mobil/{id}', 'Mobil@index')->middleware('jwt.verify');
Route::delete('/hapus_mobil/{id}', 'Mobil@destroy')->middleware('jwt.verify');

Route::post('/simpan_transaksi', 'Transaksi@store')->middleware('jwt.verify');
Route::put('/ubah_transaksi/{id}', 'Transaksi@update')->middleware('jwt.verify');
Route::post('/tampil_transaksi', 'Transaksi@show')->middleware('jwt.verify');
Route::get('/index_transaksi/{id}', 'Transaksi@index')->middleware('jwt.verify');
Route::delete('/hapus_transaksi/{id}', 'Transaksi@destroy')->middleware('jwt.verify');

Route::post('/simpan_detail', 'detailtrans@store')->middleware('jwt.verify');
Route::delete('/hapus_detail/{id}', 'detailtrans@destroy')->middleware('jwt.verify');
Route::get('/tampil_detail', 'detailtrans@tampil')->middleware('jwt.verify');
Route::put('/ubah_detail/{id}', 'detailtrans@update')->middleware('jwt.verify');