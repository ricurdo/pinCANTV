<?php

Route::get('/', 'InicioController@inicio');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('generacion', 'Pines\PinsController@view')->name('generar');
Route::post('proceso', 'Pines\PinsController@test')->name('proceso');


//-----------------------------------------------------------------------

//Ruta de carga de fichas
Route::get('fichas','Pines\FichasController@index')->name('fichas');
// Route::get('generar','CardsController@generar')->name('generar');
Route::post('fichas/carga','Pines\FichasController@store')->name('carga');

//------------------------------------------------------------------------

Route::get('fichas/chart', 'Charts\ChartsController@index_cargas')->name('chart_carga');
Route::post('allDates','Charts\ChartsController@allDates');
Route::post('dateChange','Charts\ChartsController@dateChange');


//------------------------------------------------------------------------
Route::get('generacion/chart', 'Charts\ChartsController@index_creacion')->name('chart_generacion');
Route::post('/allDatesPines','Charts\ChartsController@allDatesPines');
Route::post('/dateChangePines','Charts\ChartsController@dateChangePines');








/** $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
			Rutas de prueba
	$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
*/

Route::get('test','Pines\FichasController@test');
Route::post('prueba','Pines\FichasController@test')->name('eventos');
// Route::post('guardar', 'CardsController@guardar')->name('guardar');

Route::get('fecha', function(){

    	$mytime = Carbon\Carbon::now();
		return $mytime;
    
});


Route::get('existe','Pines\CardsController@test2');