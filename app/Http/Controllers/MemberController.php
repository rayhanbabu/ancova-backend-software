<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Exception;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\validator;
use Spatie\Image\Image;

class MemberController extends Controller
{
    public function member_view(Request $request,$category){
        try{  
              $category_name=Week::where('category_name','Member')->where('id',$category)->orderby('serial','asc')->first();
              return view('admin.member',['category'=>$category,'category_name'=>$category_name]);
          }catch (Exception $e) { return  view('errors.error',['error'=>$e]);}
     }

     public function store(Request $request){

      $dept_id = $request->header('dept_id');
      $teacher_id = $request->header('id');
      $validator=\Validator::make($request->all(),[    
         'name'=>'required',
         'designation'=>'required',
         'image'=>'image|mimes:jpeg,png,jpg|max:10240',
       ],
       );

      if($validator->fails()){
             return response()->json([
               'status'=>700,
               'message'=>$validator->messages(),
            ]);
       }else{

            $model= new Member;
            $model->dept_id=$dept_id;
            $model->name=$request->input('name');
            $model->designation=$request->input('designation');
            $model->email=$request->input('email');
            $model->phone=$request->input('phone');
            $model->web_link=$request->input('web_link');
            $model->date1=$request->input('date1');
            $model->date2=$request->input('date2');
            $model->category=$request->input('category');
            $model->text=$request->input('text');
            $model->others=$request->input('others');
            $model->serial=$request->input('serial');

           
            if ($request->hasfile('image')) {
              $image = $request->file('image');
              $mimeType = $image->getClientMimeType();
                if (in_array($mimeType, ['image/jpeg','image/jpg','image/png'])) {
                  $filename = time() . '.' . $image->getClientOriginalExtension();
                  $filePath = public_path('uploads/admin/') . $filename;
    
                  $size = getimagesize($_FILES['image']['tmp_name']);
                  $resize=image_resize($size);
                  $width=$resize['width'];
                  $height=$resize['height'];
    
                  $image = Image::load($image->getPathname())
                  ->width($width)
                  ->height($height)
                  ->save($filePath);
                  $model->image=$filename;
                }
            }
           
            $model->save();

            return response()->json([
                  'status'=>200,  
                  'message'=>'Data Added Successfull',
             ]);     
        }
    }

   public function member_edit(Request $request) {
     $id = $request->id;
     $data = Member::find($id);
     return response()->json([
         'status'=>200,  
         'data'=>$data,
      ]);
   }


   public function member_update(Request $request ){

       $validator=\Validator::make($request->all(),[    
        'name'=>'required',
        'designation'=>'required',
         'image'=>'image|mimes:jpeg,png,jpg|max:400',
      ]);

     $teacher_id = $request->header('id');
   if($validator->fails()){
         return response()->json([
           'status'=>700,
           'message'=>$validator->messages(),
        ]);
   }else{
         $model=Member::find($request->input('edit_id'));
     if($model){
        $model->name=$request->input('name');
        $model->designation=$request->input('designation');
        $model->email=$request->input('email');
        $model->phone=$request->input('phone');
        $model->web_link=$request->input('web_link');
        $model->date1=$request->input('date1');
        $model->date2=$request->input('date2');
        $model->category=$request->input('category');
        $model->text=$request->input('text');
        $model->others=$request->input('others');
        $model->status=$request->input('status');
        $model->serial=$request->input('serial');

        if ($request->hasfile('image')) {
              $path = public_path('uploads/admin') . '/' . $model->image;
               if(File::exists($path)){
                  File::delete($path);
                }

              $image = $request->file('image');
              $mimeType = $image->getClientMimeType();
                if (in_array($mimeType, ['image/jpeg','image/jpg','image/png'])) {
                  $filename = time() . '.' . $image->getClientOriginalExtension();
                  $filePath = public_path('uploads/admin/') . $filename;
    
                  $size = getimagesize($_FILES['image']['tmp_name']);
                  $resize=image_resize($size);
                  $width=$resize['width'];
                  $height=$resize['height'];
    
                  $image = Image::load($image->getPathname())
                  ->width($width)
                  ->height($height)
                  ->save($filePath);
                  $model->image=$filename;
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


  public function member_delete(Request $request) { 

      // $hallinfo=Building::where('id',$request->input('id'))->count('id');
      //  if($hallinfo>0){
      //     return response()->json([
      //       'status'=>200,  
      //       'message'=>'Can not delete this record. This hall is used in hall info table.',
      //      ]);
      //   }else{
          $model=Member::find($request->input('id'));
          $filePath = public_path('uploads/admin') . '/' . $model->image;
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
  


  public function fetch(Request $request,$category){
      $dept_id = $request->header('dept_id');
      $data=Member::where('dept_id',$dept_id)->where('category',$category)->orderBy('id','desc')->paginate(10);
      return view('admin.member_data',compact('data'));
   }

   

  function fetch_data(Request $request,$category)
  {
   if($request->ajax())
   {
         $dept_id = $request->header('dept_id');
         $sort_by = $request->get('sortby');
         $sort_type = $request->get('sorttype'); 
            $search = $request->get('search');
            $search = str_replace("","%", $search);
         $data = Member::where('dept_id',$dept_id)->where('category',$category)
             ->where(function($query) use ($search) {
                 $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('designation', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%')
                    ->orWhere('web_link', 'like', '%'.$search.'%')
                    ->orWhere('others', 'like', '%'.$search.'%');
              })->orderBy($sort_by, $sort_type)->paginate(10);
                  return view('admin.member_data', compact('data'))->render();
                 
      }
  }



}