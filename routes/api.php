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


/*Route::middleware(['authjwt:api'])->group(function () {
    Route::get('/users', function (Request $request) {
	    return response()->json($request->user());
	});
});*/

Route::post('auth', 'Access@authenticate');
Route::group(array('middleware' => ['authjwt']), function ()
{
    Route::post('users',function(){
        return response()->json([ "hello", "Welcome to ExpertPHP.in"]);
    });

    Route::post('dashboard', 'Dashboard@index');
    Route::post('payment', 'Payment@index');
    Route::post('order', 'Payment@generateOrder');
});
