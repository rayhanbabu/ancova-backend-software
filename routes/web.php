<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\MaintainController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UniverController;
use App\Http\Controllers\DeptController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\WeekController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\CollorController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AlmaryController;
use App\Http\Controllers\AnimalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

    Route::get('locale/{locale}',function($locale){
         Session::put('locale',$locale);
         return redirect()->back();
    });


     //Mainatin Panel
     Route::get('/maintain/login',[MaintainController::class,'login'])->middleware('MaintainTokenExist');
     Route::post('maintain/login-insert',[MaintainController::class,'login_insert']);
     Route::post('/maintain/login-verify',[MaintainController::class,'login_verify']);
     Route::get('maintain/forget',[MaintainController::class,'forget']); 
     Route::post('maintain/forget',[MaintainController::class,'forgetemail']); 
     Route::post('maintain/forgetcode',[MaintainController::class,'forgetcode']); 
     Route::post('maintain/confirmpass',[MaintainController::class,'confirmpass']);
   
   
     Route::middleware('MaintainToken')->group(function(){
          Route::get('/maintain/dashboard',[MaintainController::class,'dashboard']);
          Route::get('/maintain/logout',[MaintainController::class,'logout']);

          Route::get('maintain/password',[MaintainController::class,'passwordview']);
          Route::post('maintain/password',[MaintainController::class,'passwordupdate']);

           //Department  create
           Route::get('/maintain/dept_view',[DeptController::class,'dept_view']);
           Route::get('/maintain/dept_fetch',[DeptController::class,'fetch']);
           Route::get('/maintain/dept/fetch_data',[DeptController::class,'fetch_data']);
           Route::post('/maintain/dept_store',[DeptController::class,'store']);
           Route::get('/maintain/dept_edit',[DeptController::class,'dept_edit']);
           Route::post('/maintain/dept_update',[DeptController::class,'dept_update']);
           Route::delete('/maintain/dept_delete',[DeptController::class,'dept_delete']);
      
          Route::middleware('SupperAdminToken')->group(function(){
     
           //maintain people add
           Route::get('maintain/maintainview',[MaintainController::class,'maintainview']);
           Route::post('/maintain/store',[MaintainController::class,'store']);
           Route::get('/maintain/fetchAll',[MaintainController::class,'fetchAll']);
           Route::get('/maintain/edit',[MaintainController::class,'edit']);
           Route::post('/maintain/update',[MaintainController::class,'update']);


          //Universty route
           Route::get('maintain/univer-view',[UniverController::class,'univer_view']);
           Route::post('/univer/store',[UniverController::class,'store']);
           Route::get('/univer/fetchAll',[UniverController::class,'fetchAll']);
           Route::get('/univer/edit',[UniverController::class,'edit']);
           Route::post('/univer/update',[UniverController::class,'update']);
           Route::delete('/univer/delete',[UniverController::class,'delete']);
           Route::post('/maintain/import',[UniverController::class,'import']);
           Route::post('/maintain/export',[UniverController::class,'export']);
           Route::post('/maintain/dompdf',[UniverController::class,'dompdf']);
           Route::post('/maintain/jsprint',[UniverController::class,'jsprint']);

           Route::post('/maintain/member_import',[MaintainController::class,'member_import']);
           Route::post('/maintain/member_export',[MaintainController::class,'member_export']);

           //Week  route
           Route::get('maintain/week-view',[WeekController::class,'week_view']);
           Route::post('/week/store',[WeekController::class,'store']);
           Route::get('/week/fetchAll/{dept_id}',[WeekController::class,'fetchAll']);
           Route::get('/week/edit',[WeekController::class,'edit']);
           Route::post('/week/update',[WeekController::class,'update']);
           Route::delete('/week/delete',[WeekController::class,'delete']);

             });

         });


       //Teacher Panel
       Route::get('/admin/login',[TeacherController::class,'login'])->middleware('TeacherTokenExist');
       Route::post('admin/login-insert',[TeacherController::class,'login_insert']);
       Route::post('/admin/login-verify',[TeacherController::class,'login_verify']);
       Route::get('admin/forget',[TeacherController::class,'forget']); 
       Route::post('admin/forget',[TeacherController::class,'forgetemail']); 
       Route::post('admin/forgetcode',[TeacherController::class,'forgetcode']); 
       Route::post('admin/confirmpass',[TeacherController::class,'confirmpass']);
 
 
      Route::middleware('TeacherToken')->group(function(){
           Route::get('/admin/dashboard',[TeacherController::class,'dashboard']);
           Route::get('/admin/logout',[TeacherController::class,'logout']);
           Route::get('admin/password',[TeacherController::class,'passwordview']);
           Route::post('admin/password',[TeacherController::class,'passwordupdate']); 
          

        Route::middleware('TeacherLoginAccess')->group(function(){
              //Teacher  create
              Route::get('/admin/teacher_view',[TeacherController::class,'teacher_view']);
              Route::get('/admin/teacher_fetch',[TeacherController::class,'fetch']);
              Route::get('/admin/teacher/fetch_data',[TeacherController::class,'fetch_data']);
              Route::post('/admin/teacher_store',[TeacherController::class,'store']);
              Route::get('/admin/teacher_edit',[TeacherController::class,'teacher_edit']);
              Route::post('/admin/teacher_update',[TeacherController::class,'teacher_update']);
              Route::delete('/admin/teacher_delete',[TeacherController::class,'teacher_delete']);
         }); 

               //collors  create
            Route::get('/admin/collor_view',[CollorController::class,'collor_view']);
            Route::get('/admin/collor_fetch',[CollorController::class,'fetch']);
            Route::get('/admin/collor/fetch_data',[CollorController::class,'fetch_data']);
            Route::post('/admin/collor_store',[CollorController::class,'store']);
            Route::get('/admin/collor_edit',[CollorController::class,'collor_edit']);
            Route::post('/admin/collor_update',[CollorController::class,'collor_update']);
            Route::delete('/admin/collor_delete',[CollorController::class,'collor_delete']);

       Route::middleware('MemberAccess')->group(function(){
            Route::get('/admin/member_view/{category}',[MemberController::class,'member_view']);
            Route::get('/admin/member_fetch/{category}',[MemberController::class,'fetch']);
            Route::get('/admin/member/fetch_data/{category}',[MemberController::class,'fetch_data']);
            Route::post('/admin/member_store',[MemberController::class,'store']);
            Route::get('/admin/member_edit',[MemberController::class,'member_edit']);
            Route::post('/admin/member_update',[MemberController::class,'member_update']);
            Route::delete('/admin/member_delete',[MemberController::class,'member_delete']);
        });      

      Route::middleware('EventAccess')->group(function(){
         // Notice  Event
        Route::get('/admin/notice/{category}',[NoticeController::class,'index']);
        Route::get('/admin/notice_fetch/{category}',[NoticeController::class,'fetch']);
        Route::get('/admin/notice/fetch_data/{category}',[NoticeController::class,'fetch_data']); 

         Route::get('/admin/notice_create/{category}',[NoticeController::class,'notice_create']);
         Route::post('/admin/notice_insert',[NoticeController::class,'store']); 
         Route::get('/admin/notice_view/{id}/{category}',[NoticeController::class,'view']);
         Route::get('/admin/notice_edit/{id}/{category}',[NoticeController::class,'edit']);
         Route::post('/admin/notice_update/{id}',[NoticeController::class,'update']);
         Route::get('/admin/notice_delete/{id}/{category}',[NoticeController::class,'destroy']);
      });

         Route::middleware('PaymentAccess')->group(function(){
            //Client  create
            Route::get('/admin/client_view',[ClientController::class,'client_view']);
            Route::get('/admin/client_fetch',[ClientController::class,'fetch']);
            Route::get('/admin/client/fetch_data',[ClientController::class,'fetch_data']);
            Route::post('/admin/client_store',[ClientController::class,'store']);
            Route::get('/admin/client_edit',[ClientController::class,'client_edit']);
            Route::post('/admin/client_update',[ClientController::class,'client_update']);
            Route::delete('/admin/client_delete',[ClientController::class,'client_delete']);

            //Payment View 
            Route::get('/admin/paymentview',[InvoiceController::class,'paymentview']);
            Route::get('/admin/payment_fetch',[InvoiceController::class,'fetch']);
            Route::get('/admin/payment/fetch_data',[InvoiceController::class,'fetch_data']);
            Route::post('/admin/payment_status',[InvoiceController::class,'payment_status']);
            Route::post('/admin/payment_delete',[InvoiceController::class,'payment_delete']);
            Route::post('/admin/admin_invoice_create',[InvoiceController::class,'admin_invoice_create']);
            Route::get('/admin/payment_refresh',[InvoiceController::class,'payment_refresh']);
   
          });


          Route::middleware('AnimalAccess')->group(function(){
                //Alamary 
               Route::get('/admin/almary_view',[AlmaryController::class,'almary_view']);
               Route::get('/admin/almary_fetch',[AlmaryController::class,'fetch']);
               Route::get('/admin/almary/fetch_data',[AlmaryController::class,'fetch_data']);
               Route::post('/admin/almary_store',[AlmaryController::class,'store']);
               Route::get('/admin/almary_edit',[AlmaryController::class,'almary_edit']);
               Route::post('/admin/almary_update',[AlmaryController::class,'almary_update']);
               Route::delete('/admin/almary_delete',[AlmaryController::class,'almary_delete']);

               //Animal 
               Route::get('/admin/animal_view',[AnimalController::class,'animal_view']);
               Route::get('/admin/animal_fetch',[AnimalController::class,'fetch']);
               Route::get('/admin/animal/fetch_data',[AnimalController::class,'fetch_data']);
               Route::post('/admin/animal_store',[AnimalController::class,'store']);
               Route::get('/admin/animal_edit',[AnimalController::class,'animal_edit']);
               Route::post('/admin/animal_update',[AnimalController::class,'animal_update']);
               Route::delete('/admin/animal_delete',[AnimalController::class,'animal_delete']);

          });

          
          // Reports pdf
          Route::get('/pdf/semester_routine', [PdfController::class,'semester_routine_pdf']);



      });

     








     Route::get('/', function (){
            return view('welcome');
      });

     Route::get('/send-mail', function () {
          $details = [
              'title' => 'Sample Title From Mail',
              'body' => 'This is sample content we have added for this test mail'
          ];
        Mail::to('rayhanbabu458@gmail.com')->send(new \App\Mail\SendMail($details));
        dd("Email is Sent, please check your inbox.");
   });
