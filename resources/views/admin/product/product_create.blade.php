@extends('admin.layout')
@section('page_title','Admin Panel')
@section('product_select','active')
@section('content')
<div class="row mt-4 mb-3">
               <div class="col-6"> <h4 class="mt-0"> {{$category_name->week}} Product Create  Form </h4></div>
                     <div class="col-3">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            
                         </div>
                     </div>
                     <div class="col-3">
                         <div class="d-grid gap-2 d-md-flex ">
                         <a class="btn btn-primary" href="{{url('/admin/product/'.$category)}}" role="button">Back</a>  
              </div>
        </div> 
 </div> 

 <div class="form-group  mx-2 my-2">
                           @if(Session::has('fail'))
                   <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
                                @endif
                             </div>

                             <div class="form-group  mx-2 my-2">
                           @if(Session::has('success'))
                   <div  class="alert alert-success"> {{Session::get('success')}}</div>
                                @endif
                             </div>

 @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
  @endif

 <div class="container shadow p-4">
      <form method="POST" action="{{url('admin/product_insert')}}" enctype="multipart/form-data">
        @csrf
  
      <div class="row">
          <div class="col-sm-4 my-2">
            <label for="name"> Title Name <span style="color:red;"> * </span></label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}"  required>
          </div>

          <input type="hidden" name="category" id="category"  value="{{ $category }}" >
          
          <div class="col-sm-3 my-2">
            <label for="name"> Product ID <span style="color:red;"> * </span> </label>
            <input type="text" name="product_id" id="product_id" class="form-control" value="{{ old('product_id') }}" >
          </div>

          <div class="col-sm-3 my-2">
              <label for="image">Image 1 (Max Size:600KB) <span style="color:red;"> * </span> </label>
              <input type="file" name="image"  class="form-control" required>
          </div>

          <div class="col-sm-2 my-2">
              <label for="image">Image 2 </label>
              <input type="file" name="image1"  class="form-control" >
          </div>

        </div>



    <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label"> Description 1 </label>
          <textarea name="desc1" id="summernote1" cols="30" rows="5" value="{{ old('desc1') }}"></textarea>
    </div> 

    
    <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label"> Description 2</label>
          <textarea name="desc2" id="summernote2" cols="30" rows="5" value="{{ old('desc2') }}"></textarea>
    </div> 

 <button type="submit" class="btn btn-primary">Submit</button>

</form>
</div>
    <script>

      $('#summernote1').summernote({
        placeholder: 'Description...',
        tabsize: 2,
        height: 100
      });

      $('#summernote2').summernote({
        placeholder: 'Description...',
        tabsize: 2,
        height: 100
      });

    </script>


  

 @endsection             