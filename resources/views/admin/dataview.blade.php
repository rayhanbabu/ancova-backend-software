@extends('admin.layout')
@section('page_title','Admin Panel')
@section('dataview','active')
@section('content')

<div class="row mt-4 mb-3">
               <div class="col-3"> <h4 class="mt-0"> Event Setting </h4></div>
                    
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

             
             
 <div class="card-block table-border-style">                     
 <div class="table-responsive">
 <table class="table table-bordered" id="employee_data">
    <thead>
      <tr>
        
   
          <th width="10%" > Id </th>
          <th width="10%" > Onwer name </th>
          <th width="10%" > Registration Status </th>
          <th width="10%" > Deadline Status </th>
          <th width="10%" > Program Title  </th>
          <th width="10%" > Program Description </th>
          <th width="10%" > Program Year </th>
          <th width="10%" > Message </th>
         <th width="5%" >Edit</th>
        
      </tr>
  </thead>
  <tbody>

	@foreach($maintain as $item)
	 <tr>
           <td>{{$item->id}}</td>
           <td>{{$item->name}} </td>
           <td>{{$item->registration_status}} </td>
           <td>{{$item->deadline_status}} </td>
           <td>{{$item->program_title}} </td>
           <td>{{$item->program_desc}} </td>
           <td>{{$item->program_year}}  </td>
           <td>{{$item->message}} </td>
    

    <td>
      <button type="button" name="edit" id="{{$item->id}}" class="btn btn-success btn-sm edit" 
	

       data-program_title="{{$item->program_title}}" data-program_desc="{{$item->program_desc}}"
       data-program_year="{{$item->program_year}}" data-message="{{$item->message}}"
       data-deadline_status="{{$item->deadline_status}}" data-registration_status="{{$item->registration_status}}"  >Edit</button>
    </td>

      
	</tr>
    @endforeach	 
	</tbody>
  </table>
</div>
</div>


   <script>  
 $(document).ready(function(){  
      $('#employee_data').DataTable({
        "order": [[ 0, "desc" ]] ,
		"lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]]
      }
	  );  
 });  
 </script>  
	</div>
</div>


<script type="text/javascript">
           $(document).ready(function(){
                $(document).on('click','.edit',function(){
                   var id = $(this).attr("id");  
                 
               

                  var registration_status = $(this).data("registration_status");
                  var deadline_status = $(this).data("deadline_status");
                  var program_title = $(this).data("program_title");
                  var program_desc = $(this).data("program_desc");
                  var program_year = $(this).data("program_year");
                  var message = $(this).data("message");
                 
                   
                     $('#edit_id').val(id);
                    
                     $('#registration_status').val(registration_status);
                     $('#deadline_status').val(deadline_status);
                     $('#program_title').val(program_title);
                     $('#program_desc').val(program_desc);
                     $('#program_year').val(program_year);
                     $('#message').val(message);


                     $('#updatemodal').modal('show');
                });

           });


</script>






<!-- Modal Edit -->
<div class="modal fade" id="updatemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Data View Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      <form method="post" action="{{url('maintain/dataedit')}}"  class="myform"  enctype="multipart/form-data" >
         {!! csrf_field() !!}

         <input type="hidden" id="edit_id" name="id" class="form-control">

         <div class="row px-3">

       

          <div class="form-group col-sm-4  mb-4">
             <label class=""><b> Registation Status</b></label>
              <select class="form-select" id="registration_status"  name="registration_status" aria-label="Default select example" required>
                   <option selected>Select One</option>
                   <option value="0">No</option>
                   <option value="1">Yes</option>
              </select>
           </div>  
           
           
           <div class="form-group col-sm-4  mb-4">
             <label class=""><b> Deadline Status</b></label>
              <select class="form-select" id="deadline_status"  name="deadline_status" aria-label="Default select example" required>
                   <option selected>Select One</option>
                   <option value="0">No</option>
                   <option value="1">Yes</option>
              </select>
           </div>   

           <div class="form-group  col-sm-4  my-2">
               <label class=""><b>Program Year </b></label>
               <input type="number" id="program_year"  name="program_year" class="form-control" required>
          </div> 
         
           <div class="form-group  col-sm-12  my-2">
               <label class=""><b>Program Title </b></label>
               <input type="text" id="program_title"  name="program_title" class="form-control" required>
          </div> 

          <div class="form-group  col-sm-12  my-2">
               <label class=""><b>Program Description </b></label>
               <input type="text" id="program_desc"  name="program_desc" class="form-control" required>
          </div> 

         

          <div class="form-group  col-sm-12  my-2">
               <label class=""><b> Message </b></label>
               <input type="text" id="message"  name="message" class="form-control" required>
          </div> 

     


    </div>

     <br>
      <input type="submit"   id="insert" value="Update" class="btn btn-success" />
	  
              
   </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>





   
   
     


@endsection