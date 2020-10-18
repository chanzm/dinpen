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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1', 'middleware' =>'cors'], function(){
	Route::post('/login','TestingController@login');

	// Route::post('/login','AllController@login');
	Route::get('/','AllController@welcome');
	Route::post('/transfer','AllController@transfer');
	Route::post('newtunai','AllController@newtunai');
	Route::group(['middleware'=>'jwt.auth'],function(){
		// Route::post('/sekolah','AllController@sekolah');
		Route::post('/saldo','AllController@saldo');
		Route::post('/sekolah','AllController@sekolah');
		Route::post('/bendahara','AllController@bendahara');
		Route::post('/pekerjaan_bendahara_1_transfer','AllController@pekerjaan_bendahara_1_transfer');
		Route::post('/pekerjaan_bendahara_1_tunai','AllController@pekerjaan_bendahara_1_tunai');
		Route::post('/pekerjaan_bendahara_2_transfer','AllController@pekerjaan_bendahara_2_transfer');
		Route::post('/pekerjaan_bendahara_2_tunai','AllController@pekerjaan_bendahara_2_tunai');
		Route::post('/pekerjaan_bendahara_3_transfer','AllController@pekerjaan_bendahara_3_transfer');
		Route::post('/pekerjaan_bendahara_3_tunai','AllController@pekerjaan_bendahara_3_tunai');
		Route::post('pekerjaan_detail_bendahara','AllController@pekerjaan_detail_bendahara');
		Route::post('/pekerjaan_kepala_1_transfer','AllController@pekerjaan_kepala_1_transfer');
		Route::post('/pekerjaan_kepala_1_tunai','AllController@pekerjaan_kepala_1_tunai');
		Route::post('/pekerjaan_kepala_2_transfer','AllController@pekerjaan_kepala_2_transfer');
		Route::post('/pekerjaan_kepala_2_tunai','AllController@pekerjaan_kepala_2_tunai');
		Route::post('/pekerjaan_kepala_3_transfer','AllController@pekerjaan_kepala_3_transfer');
		Route::post('/pekerjaan_kepala_3_tunai','AllController@pekerjaan_kepala_3_tunai');
		Route::post('pekerjaan_detail_kepala','AllController@pekerjaan_detail_kepala');
		Route::post('bendahara_update_barang','AllController@bendahara_update_barang');
		Route::post('pekerjaan_detail_bendahara_gaji','AllController@pekerjaan_detail_bendahara_gaji');
		Route::post('/pekerjaan_bendahara_1_transfer1','AllController@pekerjaan_bendahara_1_transfer1');
		Route::post('/pekerjaan_bendahara_1_tunai1','AllController@pekerjaan_bendahara_1_tunai1');
		Route::post('/pekerjaan_bendahara_2_transfer1','AllController@pekerjaan_bendahara_2_transfer1');
		Route::post('/pekerjaan_bendahara_2_tunai1','AllController@pekerjaan_bendahara_2_tunai1');
		Route::post('/pekerjaan_bendahara_3_transfer1','AllController@pekerjaan_bendahara_3_transfer1');
		Route::post('/pekerjaan_bendahara_3_tunai1','AllController@pekerjaan_bendahara_3_tunai1');
		Route::post('/kepala_bagian','AllController@kepala_bagian');
		Route::post('/pekerjaan_kepala_1_transfer1','AllController@pekerjaan_kepala_1_transfer1');
		Route::post('/pekerjaan_kepala_1_tunai1','AllController@pekerjaan_kepala_1_tunai1');
		Route::post('/pekerjaan_kepala_2_transfer1','AllController@pekerjaan_kepala_2_transfer1');
		Route::post('/pekerjaan_kepala_2_tunai1','AllController@pekerjaan_kepala_2_tunai1');
		Route::post('/pekerjaan_kepala_3_transfer1','AllController@pekerjaan_kepala_3_transfer1');
		Route::post('/pekerjaan_kepala_3_tunai1','AllController@pekerjaan_kepala_3_tunai1');
		Route::post('/kepala_update_barang_tunai','AllController@kepala_update_barang_tunai');
		Route::post('/kepala_update_barang_transfer','AllController@kepala_update_barang_transfer');
		Route::post('/kepala_update_gaji','AllController@kepala_update_gaji');
		Route::post('/pekerjaan_detail_kepala_gaji','AllController@pekerjaan_detail_kepala_gaji');
		Route::post('/kirimgambar','AllController@kirimgambar');
		Route::post('train','AllController@train');
		Route::post('predict','AllController@predict');
		Route::post('aturimei','AllController@aturimei');
		Route::post('kirimttd','AllController@kirimttd');
	});
});
Route::group(['prefix' => 'v2', 'middleware' =>'cors'], function(){
	Route::any('/login','v2Controller@login');
    Route::get('/','v2Controller@welcome');
    Route::group(['middleware'=>'jwt.auth'],function(){
        Route::group(['prefix' => 'kepala'], function(){
            Route::post('/sekolah','v2Controller@sekolah');
        });
    });
});
