<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackendApiController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

      Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
           return $request->user();
      });

      Route::get('{dept_id}/department_view/', [BackendApiController::class, 'department_view']);
      Route::get('{dept_id}/collor_view/', [BackendApiController::class,'collor_view']);

      Route::get('{dept_id}/notice/{category}',[BackendApiController::class,'notice_view']);
      Route::get('{dept_id}/notice_details/{category}/{id}',[BackendApiController::class,'notice_details']);
      Route::post('{dept_id}/contact_form', [BackendApiController::class,'contact_form']);
      Route::get('{dept_id}/member/{category}',[BackendApiController::class,'member_view']);
      Route::get('{dept_id}/member_details/{category}/{id}',[BackendApiController::class,'member_details']);
    
      Route::get('{dept_id}/product/{category}',[BackendApiController::class,'product_view']);
      Route::get('{dept_id}/product_details/{category}/{id}',[BackendApiController::class,'product_details']);

      Route::get('/geolocation/store',[BackendApiController::class,'geolocation_store_get']);
      Route::post('/geolocation/store',[BackendApiController::class,'geolocation_store_post']);
      Route::get('/geolocation',[BackendApiController::class,'geolocation_show']);

      
      Route::get('/club_product',[BackendApiController::class,'club_product']);



   
     



