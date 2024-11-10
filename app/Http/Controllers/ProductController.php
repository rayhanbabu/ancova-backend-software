<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Week;

use Cookie;
use Session;
use DOMDocument;
use Illuminate\Support\Str;
use Spatie\Image\Image;

class ProductController extends Controller
{
     public function index($category){

        $category_name=Week::where('category_name','Product')->where('id',$category)->orderby('serial','asc')->first();
        return view('admin.product.product',['category' => $category,'category_name' => $category_name]);
   
      }

     public function fetch(Request $request ,$category){
        $dept_id = $request->header('dept_id');
        $teacher_id = $request->header('id');
        $data=DB::table('products')->where('dept_id',$dept_id)->where('category',$category)->orderBy('id','desc')->paginate(10);
        return view('admin.product.product_data',compact('data'));
     }

    function fetch_data(Request $request,$category)
    {
       $dept_id = $request->header('dept_id');
       $teacher_id = $request->header('id');

       if($request->ajax())
        {
          $sort_by = $request->get('sortby');
          $sort_type = $request->get('sorttype'); 
             $search = $request->get('search');
             $search = str_replace(" ", "%", $search);
         $data=DB::table('products')->where('dept_id',$dept_id)
                 ->where('category',$category)
           ->where(function($query) use ($search) {
              $query->orWhere('title', 'like', '%'.$search.'%');
              $query->orWhere('product_id', 'like', '%'.$search.'%');
              $query->orWhere('category', 'like', '%'.$search.'%');
           })->orderBy($sort_by, $sort_type)->paginate(10);

          return view('admin.product.product_data', compact('data'))->render();
        }
     }


    public function product_create (Request $request,$category){

        $category_name=Week::where('category_name','Product')->where('id',$category)->orderby('serial','asc')->first();
        return view('admin.product.product_create',['category'=>$category,'category_name'=>$category_name]);
      
      }


    public function store(Request $request) {

       $dept_id = $request->header('dept_id');
       $teacher_id = $request->header('id');

   
       $validated = $request->validate([
            'desc1'=>'required',
            'image' =>'required|file|mimes:jpeg,png,jpg|max:600',
            'image1' =>'file|mimes:jpeg,png,jpg|max:600',
            'title'=>'required',
            'product_id'=>'required|unique:products,product_id',
       ]);

        $model= new Product;
        $model->category=$request->input('category');
        $model->dept_id=$dept_id;
        $model->title=$request->input('title');
        $model->product_id=$request->input('product_id');
        $model->desc1=$request->input('desc1');
        $model->desc2=$request->input('desc2');
     

       
        if($request->hasfile('image')){
          $image = $request->file('image');
          $mimeType = $image->getClientMimeType();
          if ($mimeType === 'application/pdf') {
             $filename = time() . '.' . $image->getClientOriginalExtension();
             $image->move(public_path('uploads/admin'), $filename);
             $model->image=$filename;
           }elseif (in_array($mimeType, ['image/jpeg','image/jpg','image/png'])) {
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


         if($request->hasfile('image1')){
             $image1 = $request->file('image1');
                $filename1 = time() . '.' . $image1->getClientOriginalExtension();
                $filePath1 = public_path('uploads/admin/') . $filename1;
  
                $size = getimagesize($_FILES['image1']['tmp_name']);
                $resize=image_resize($size);
                $width=$resize['width'];
                $height=$resize['height'];
  
                 $image1 = Image::load($image1->getPathname())
                 ->width($width)
                 ->height($height)
                 ->save($filePath1);
                 $model->image1=$filename;
           }

        $model->save();

        return redirect('admin/product/'.$model->category)->with('success','Data Added Successfuly');
       
     }


     public function view(Request $request ,$id,$category){
         $data = Product::find($id);
         $category_name=Week::where('category_name','Product')->where('id',$category)->orderby('serial','asc')->first();
         return view('admin.product.product_view',['data'=>$data,'category'=>$category,'category_name'=>$category_name]);
      }


     public function edit(Request $request ,$id,$category){
          $data = Product::find($id);
          $category_name=Week::where('category_name','Product')->where('id',$category)->orderby('serial','asc')->first();
          return view('admin.product.product_edit',['data'=>$data,'category'=>$category,'category_name'=>$category_name]);
      }

     public function update(Request $request, $id)
     {
        $validated = $request->validate([
         'desc1'=>'required',
         'image' =>'file|mimes:jpeg,png,jpg|max:600',
         'image1' =>'file|mimes:jpeg,png,jpg|max:600',
         'title'=>'required',
         'product_id'=>'required|unique:products,product_id,'.$id,
        ]);

        $model = Product::find($id);
        $model->title=$request->input('title');
        $model->product_id=$request->input('product_id');
        $model->desc1=$request->input('desc1');
        $model->desc2=$request->input('desc2');
     

        if($request->hasfile('image')){
              $path=public_path('uploads/admin/').$model->image;
               if(File::exists($path)){
                   File::delete($path);
               }

              $image = $request->file('image');
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



         if($request->hasfile('image1')){
            $path=public_path('uploads/admin/').$model->image1;
               if(File::exists($path)){
                   File::delete($path);
                }

              $image1 = $request->file('image1');
              $filename1 = time() . '.' . $image1->getClientOriginalExtension();
              $filePath1 = public_path('uploads/admin/') . $filename1;

              $size = getimagesize($_FILES['image1']['tmp_name']);
              $resize=image_resize($size);
              $width=$resize['width'];
              $height=$resize['height'];

              $image1 = Image::load($image1->getPathname())
              ->width($width)
              ->height($height)
              ->save($filePath1);
              $model->image1=$filename1;
         }



        $model->save();

        return redirect('admin/product/'.$model->category)->with('success','Data Updated Successfuly');
   }


   public function destroy(Request $request,$id,$category)
   {
       $post = Product::find($id);  
       $path=public_path('uploads/admin/').$post->image;
        if(File::exists($path)){
          File::delete($path);
        }

        $path1=public_path('uploads/admin/').$post->image1;
        if(File::exists($path1)){
          File::delete($path1);
        }
       $post->delete();
       return back()->with('success','Data Deleted  successfully');

   }


}