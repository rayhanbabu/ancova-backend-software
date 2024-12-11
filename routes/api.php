<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackendApiController;
use App\Http\Controllers\DuclubController;


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

      
         //Du Club routes
         Route::get('/duclub/api/homepage', [TestimonialController::class,'apidu_homepage']);
         Route::get('/duclub/api/product_view', [DuclubController::class,'product_view']);
         Route::get('/duclub/api/login/{phone}', [DuclubController::class,'duclub_login']);
         Route::get('/duclub/api/VerifyLogin/{phone}/{otp}',[DuclubController::class, 'duclub_VerifyLogin']);
         Route::get('/duclub/api/product_view1', [DuclubController::class,'product_view1']);
  
  
         Route::get('/dumess/api/term', [HomepageController::class,'du_term']);
         Route::get('/dumess/api/privacy', [HomepageController::class,'du_privacy']);
         Route::get('/maintain/HomePage/{category}', [HomepageController::class,'maintain_homepage']);
  
    Route::middleware('DuClubToken')->group(function(){ 
         Route::get('/duclub/api/member_ledger', [DuclubController::class,'member_ledger']);
         Route::post('/duclub/api/product_add', [DuclubController::class,'product_add']);
         Route::get('/duclub/api/pending_product_view', [DuclubController::class,'pending_product_view']);
         Route::get('/duclub/api/product_delete/{saleID}', [DuclubController::class,'product_delete']);
         Route::get('/duclub/api/duclub_info', [DuclubController::class,'duclub_info']);
         Route::post('/duclub/api/event_registation', [DuclubController::class,'event_registation']);
         Route::get('/duclub/api/event_registation_show/{year}', [DuclubController::class,'event_registation_show']);
    }); 
          
        
  



   
     



