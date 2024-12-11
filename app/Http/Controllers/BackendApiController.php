<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Dept;
use App\Models\Collor;
use App\Models\Pocket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Notice;
use App\Models\Member;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BackendApiController extends Controller
{

  

  public function home_view(Request $request){

      $about= Notice::leftjoin('weeks','weeks.id', '=','notices.category')
      ->where('notices.dept_id',1)->where('notices.category',5)
      ->select('weeks.week as category_name','notices.*')->orderby('serial','asc')->orderby('id','desc')->get();
   
      $title= Notice::leftjoin('weeks','weeks.id', '=','notices.category')
      ->where('notices.dept_id',1)->where('notices.category',9)
      ->select('weeks.week as category_name','notices.*')->orderby('serial','asc')->orderby('id','desc')->get();

      $service= Notice::leftjoin('weeks','weeks.id','=','notices.category')
      ->where('notices.dept_id',1)->where('notices.category',7)
      ->select('weeks.week as category_name','notices.*')->orderby('serial','asc')->orderby('id','desc')->get();

      $project= Notice::leftjoin('weeks','weeks.id','=','notices.category')
      ->where('notices.dept_id',1)->where('notices.category',1)
      ->select('weeks.week as category_name','notices.*')->orderby('serial','asc')->orderby('id','desc')->get();

      $testimonial= Notice::leftjoin('weeks','weeks.id','=','notices.category')
      ->where('notices.dept_id',1)->where('notices.category',4)
      ->select('weeks.week as category_name','notices.*')->orderby('serial','asc')->orderby('id','desc')->get();

     return view('frontend.home',['about'=>$about,'title'=>$title,'service'=>$service 
     ,'project'=>$project,'testimonial'=>$testimonial]);
  
    }

    public function about_view(Request $request){
       $about= Notice::leftjoin('weeks','weeks.id', '=','notices.category')
       ->where('notices.dept_id',1)->where('notices.category',5)
       ->select('weeks.week as category_name','notices.*')->orderby('serial','asc')->orderby('id','desc')->get();
       return view('frontend.about',['about'=>$about]);   
     }

     public function service_view(Request $request){
           $service= Notice::leftjoin('weeks','weeks.id','=','notices.category')
           ->where('notices.dept_id',1)->where('notices.category',7)
           ->select('weeks.week as category_name','notices.*')->orderby('serial','asc')->orderby('id','desc')->get();
         return view('frontend.service',['service'=>$service]);   
      }

      public function project_view(Request $request){
           $project= Notice::leftjoin('weeks','weeks.id','=','notices.category')
           ->where('notices.dept_id',1)->where('notices.category',1)
           ->select('weeks.week as category_name','notices.*')->orderby('serial','asc')->orderby('id','desc')->get();
         return view('frontend.project',['project'=>$project]);   
       }


    public function department_view(Request $request ,$dept_id){
         $data= Dept::where('id',$dept_id)->first();
         return response()->json([
              'status'=>'success',
              'data'=>$data 
          ],200);
      }

     public function collor_view(Request $request ,$dept_id){
        $data= Collor::where('dept_id',$dept_id)->get();
        return response()->json([
             'status'=>'success',
             'data'=>$data 
         ],200);
     }

     public function notice_view(Request $request ,$dept_id,$category){
        $data= Notice::leftjoin('weeks','weeks.id', '=','notices.category')
        ->where('notices.dept_id',$dept_id)->where('notices.category',$category)
        ->select('weeks.week as category_name','notices.*')->orderby('serial','asc')->orderby('id','desc')->get();
          return response()->json([
              'status'=>'success',
              'data'=>$data 
           ],200);
      }


      public function notice_details(Request $request ,$dept_id,$category,$id){
        $data= Notice::leftjoin('weeks','weeks.id', '=','notices.category')
        ->where('notices.dept_id',$dept_id)->where('notices.category',$category)->where('notices.id',$id)
        ->select('weeks.week as category_name','notices.*')->orderby('serial','asc')->orderby('id','desc')->first();
          return response()->json([
              'status'=>'success',
              'data'=>$data 
           ],200);
      }


      public function member_view(Request $request ,$dept_id,$category){
        $data= Member::leftjoin('weeks','weeks.id', '=','members.category')
        ->where('members.dept_id',$dept_id)->where('members.category',$category)
        ->select('weeks.week as category_name','members.*')->orderby('serial','asc')->orderby('id','desc')->get();
          return response()->json([
               'status'=>'success',
               'data'=>$data 
           ],200);
      }


      public function member_details(Request $request ,$dept_id,$category,$id){
         $data= Member::leftjoin('weeks','weeks.id', '=','members.category')
         ->where('members.dept_id',$dept_id)->where('members.category',$category)->where('members.id',$id)
         ->select('weeks.week as category_name','members.*')->orderby('serial','asc')->orderby('id','desc')->first();
          return response()->json([
               'status'=>'success',
               'data'=>$data 
           ],200);
      }


      public function product_details(Request $request ,$dept_id,$category,$id){
        $data= Product::leftjoin('weeks','weeks.id', '=','products.category')
        ->where('products.dept_id',$dept_id)->where('products.category',$category)->where('products.id',$id)
        ->select('weeks.week as category_name','products.*')->orderby('serial','asc')->orderby('id','desc')->first();
         return response()->json([
              'status'=>'success',
              'data'=>$data 
          ],200);
     }


  
     public function contact_form(Request $request,$dept_id){
        $validator=\Validator::make($request->all(),[    
           'collor_name'=>'required',
           'image'=>'image|mimes:jpeg,png,jpg|max:400',
         ],
         );
  
       $product_id = $request->input('product_id',''); 
       if($validator->fails()){
              return response()->json([
                'status'=>700,
                'message'=>$validator->messages(),
             ]);
       }else{
              $model= new Collor;
              $model->dept_id=$dept_id;
              $model->collor_name=$request->input('collor_name');
              $model->collor_des=$request->input('collor_des');
              $model->email=$request->input('email');
              $model->phone=$request->input('phone');
              $model->product_id=$request->input('product_id');
              $model->subject=$request->input('subject');
              if($request->hasfile('image')) {
                $imgfile = 'booking-';
                $size = $request->file('image')->getsize();
                $file = $_FILES['image']['tmp_name'];
                $hw = getimagesize($file);
                $w = $hw[0];
                $h = $hw[1];
                if ($w < 310 && $h < 310) {
                    $image = $request->file('image');
                    $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads'), $new_name);
                    $model->image = $new_name;
                  } else {
                    return response()->json([
                        'status' => 300,
                        'message' => 'Image size must be 300*300px',
                    ]);
                 }
              }
             
              $model->save();
  
              return response()->json([
                    'status'=>200,  
                    'message'=>'Data Added Successfull',
               ],200);     
          }
      }



      public function product_view(request $request ,$dept_id,$category){
    
        $query=Product::query();
        if($search=$request->search){
           $query->whereRaw("products.product_id  LIKE '%".$search."%'");
         }

         //if($sort=$request->sort){
         // $query->orderBy("member_card",$sort);}

          
        $perPage=$request->input('perPage',5);
        $page=$request->input('page',1);
       
        $query->leftjoin('weeks','weeks.id','=','products.category');

        $query->where('products.category',$category)->where('products.dept_id',$dept_id);

        $query->select('weeks.week as category_name','products.*');

          $total=$query->count();
          $query->orderBy("id", 'desc');
          $result=$query->offset(($page-1) * $perPage)->limit($perPage)->get();
        

        return response()->json([
          'message'=>"Successfully fetched",
          'data'=>$result, 
          'total'=>$total,
          'page'=>$page,
          'last_page'=>ceil($total/$perPage)
        ]);
    }


      public function geolocation_store_get(Request $request){
               
           $data=$request->all();
           $json_string = json_encode($data);

           $sensor['geolocation'] = $json_string;
           $sensor['method_type'] = "GET";
           DB::table('sensors')->insert($sensor);
           return response()->json([
               'status'=>"success",  
               'message'=>'Get Data Added Successfull',
            ],200);     
      }


      public function geolocation_store_post(Request $request){
               
        $data=$request->all();
        $json_string = json_encode($data);
        
        $sensor['geolocation'] = $json_string;
        $sensor['method_type'] = "POST";
        DB::table('sensors')->insert($sensor);
        return response()->json([
            'status'=>"success",  
            'message'=>'Post Data Added Successfull',
         ],200);     
   }

   public function geolocation_show(Request $request){
    $data=DB::table('sensors')->orderBy('id','desc')->get();
    return response()->json([
         'status'=>"success",  
         'data'=>$data,
     ],200);     
}


   public function club_product(Request $request){
      
      //try {  
          
      $dayName=$request->dayName;
       $response = Http::get('https://dhakauniversityclub.com/api/getProductByDay?dayName='.$dayName.'');
       if ($response->successful()) {
           $data = $response->json();
            return response()->json([
               'status' =>'success',
               'data' => $data,
            ],200);
          }
      //  } catch (Exception $e) {
      //      return response()->json([
      //         'status' => 501,
      //         'message' => 'Somting Error',
      //      ],501);
      // }
    


   }

     
}