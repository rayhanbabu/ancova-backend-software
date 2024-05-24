<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Helpers\TeacherJWTToken;
use Exception;
use App\Models\Invoice;


class ClientController extends Controller
{

    public function client_view(Request $request){
        try{ 
              return view('admin.client');
           }catch (Exception $e) { return  view('errors.error',['error'=>$e]);}
      }
 
      public function store(Request $request){

       $dept_id = $request->header('dept_id');
       $teacher_id = $request->header('id');
       $validator=\Validator::make($request->all(),[    
          'client_name'=>'required',
          'phone'=>'required|unique:clients,phone',
          'email'=>'required|unique:clients,email',
          'image'=>'image|mimes:jpeg,png,jpg|max:400',
        ]);
 
      if($validator->fails()){
             return response()->json([
               'status'=>700,
               'message'=>$validator->messages(),
            ]);
      }else{ 

        $expired_date=date("Y-m-d",strtotime($request->input('created_date').$request->input('subcribe')."month"));
             $model= new Client;
             $model->dept_id=$dept_id;
             $model->client_name=$request->input('client_name');
             $model->address=$request->input('address');
             $model->email=$request->input('email');
             $model->phone=$request->input('phone');
             $model->service_info=$request->input('service_info');
             $model->total_amount=$request->input('total_amount');
             $model->created_date=$request->input('created_date');
             $model->expired_date=$expired_date;
             $model->subcribe=$request->input('subcribe');
             $model->discount_amount=$request->input('discount_amount');
             $model->client_info=$request->input('client_info');
             $model->client_ref=$request->input('client_ref');
             $model->discount_info=$request->input('discount_info');
             $model->domain_info=$request->input('domain_info');
             $model->payment_amount=$request->input('total_amount')-$request->input('discount_amount');
             $model->created_by=$teacher_id;

             $model->domain_expired=$request->input('domain_expired');
             $model->domain_name=$request->input('domain_name');

             if($request->hasfile('image')){
               $imgfile = 'booking-';
               $size = $request->file('image')->getsize();
               $file = $_FILES['image']['tmp_name'];
               $hw = getimagesize($file);
                   //    $w = $hw[0];
                   //    $h = $hw[1];
                   //    if ($w < 310 && $h < 310) {
                   $image = $request->file('image');
                   $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                   $image->move(public_path('uploads'), $new_name);
                   $model->image = $new_name;
                   // } else {
                   //    return response()->json([
                   //        'status' => 300,
                   //        'message' => 'Image size must be 300*300px',
                   //    ]);
                   //  }
             }
             $model->save();

             $invoice_date = date('Y-m-d');
             
             $invoice = new Invoice;
             $invoice->dept_id  = $dept_id;
             $invoice->tran_id = Str::random(8);
             $invoice->client_id  = $model->id;
             $invoice->service_info = $request->input('service_info');
             $invoice->total_amount = $request->input('total_amount');
             $invoice->payment_status = 0;
             $invoice->discount_info =$request->input('discount_info');
             $invoice->total_amount = $request->input('total_amount');
             $invoice->discount_amount = $request->input('discount_amount');
             $invoice->payment_amount = $model->payment_amount;
             $invoice->invoice_date = $invoice_date;
             $invoice->save();
 
             return response()->json([
                   'status'=>200,  
                   'message'=>'Data Added Successfull',
              ]);     
         }
     }
 
    public function client_edit(Request $request) {
      $id = $request->id;
      $data = Client::find($id);
      return response()->json([
          'status'=>200,  
          'data'=>$data,
       ]);
    }
 
 
    public function client_update(Request $request ){

      $dept_id = $request->header('dept_id');
      $teacher_id = $request->header('id');

     $validator=\Validator::make($request->all(),[    
        'client_name'=>'required',
        'image'=>'image|mimes:jpeg,png,jpg|max:400',
        'phone'=>'required|unique:teachers,phone,'.$request->input('edit_id'),
        'email'=>'required|unique:teachers,email,'.$request->input('edit_id'),
     ]);
 
     $teacher_id = $request->header('id');
   if($validator->fails()){
          return response()->json([
            'status'=>700,
            'message'=>$validator->messages(),
         ]);
   }else{
          $model=Client::find($request->input('edit_id'));
          $expired_date=date("Y-m-d",strtotime($request->input('created_date').$request->input('subcribe')."month"));
     if($model){
      $model->dept_id=$dept_id;
      $model->client_name=$request->input('client_name');
      $model->address=$request->input('address');
      $model->email=$request->input('email');
      $model->phone=$request->input('phone');
      $model->service_info=$request->input('service_info');
      $model->total_amount=$request->input('total_amount');
      $model->created_date=$request->input('created_date');
      $model->expired_date=$expired_date;
      $model->subcribe=$request->input('subcribe');
      $model->discount_amount=$request->input('discount_amount');
      $model->discount_info=$request->input('discount_info');
      $model->client_info=$request->input('client_info');
      $model->client_ref=$request->input('client_ref');
      $model->domain_info=$request->input('domain_info');
      $model->payment_amount=$request->input('total_amount')-$request->input('discount_amount');
      $model->client_status=$request->input('client_status');
      $model->updated_by=$teacher_id;

      $model->domain_expired=$request->input('domain_expired');
      $model->domain_name=$request->input('domain_name');

         if ($request->hasfile('image')) {
            $imgfile = 'booking-';
            $size = $request->file('image')->getsize();
            $file = $_FILES['image']['tmp_name'];
            $hw = getimagesize($file);
            $w = $hw[0];
            $h = $hw[1];
            if ($w < 310 && $h < 310) {
              $path = public_path('uploads') . '/' . $model->image;
               if(File::exists($path)){
                   File::delete($path);
                 }
                $image = $request->file('image');
                $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $new_name);
                $model->image = $new_name;
            } else {
               return response()->json([
                   'status' =>300,
                   'message' =>'Image size must be 300*300px',
               ]);
             }
         }
        
          $model->update();   
           return response()->json([ 
              'status'=>200,
              'message'=>'Data Updated Successfull'
           ]);
       }else{
         return response()->json([
             'status'=>404,  
             'message'=>'Student not found',
           ]);
     }
 
     }
   }
 
 
   public function client_delete(Request $request) { 
 
       // $hallinfo=Building::where('id',$request->input('id'))->count('id');
       //  if($hallinfo>0){
       //     return response()->json([
       //       'status'=>200,  
       //       'message'=>'Can not delete this record. This hall is used in hall info table.',
       //      ]);
       //   }else{
           $model=Client::find($request->input('id'));
           $filePath = public_path('uploads') . '/' . $model->image;
           if(File::exists($filePath)){
                 File::delete($filePath);
            }
           $model->delete();
           return response()->json([
              'status'=>300,  
              'message'=>'Data Deleted Successfully',
         ]);
     // }
    } 
   
 
 
   public function fetch(Request $request){
       $dept_id = $request->header('dept_id');
       $data=Client::where('dept_id',$dept_id)->orderBy('id','desc')->paginate(10);
       return view('admin.client_data',compact('data'));
    }
 
 
 
   function fetch_data(Request $request)
   {
    if($request->ajax())
      {
          $dept_id = $request->header('dept_id');
          $sort_by = $request->get('sortby');
          $sort_type = $request->get('sorttype'); 
          $range = $request->get('range'); 
             $search = $request->get('search');
             $search = str_replace("","%", $search);
             $data = Client::where('dept_id',$dept_id)
               ->where(function($query) use ($search) {
                  $query->where('client_name', 'like', '%'.$search.'%')
                     ->orWhere('expired_date', 'like', '%'.$search.'%')
                     ->orWhere('phone', 'like', '%'.$search.'%')
                     ->orWhere('address', 'like', '%'.$search.'%')
                     ->orWhere('created_date', 'like', '%'.$search.'%')
                     ->orWhere('email', 'like', '%'.$search.'%');
               })->orderBy($sort_by, $sort_type)->paginate($range);
             return view('admin.client_data', compact('data'))->render();    
         }
       }

   }

