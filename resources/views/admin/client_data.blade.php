<?php 
$currentDate = new DateTime();

?>

@foreach($data as $row)
 
<?php $interval= $currentDate->diff(new DateTime($row->domain_expired));  
                    
                
                  if($interval->format('%m')<=0){
                     $over = 'style="background:#fccccc"';
                  }else{ $over = ''; } ?>
           <tr <?php echo  $over; ?> >
                   <td> <img src="{{ asset('/uploads/'.$row->image) }}" width="100" class="img-thumbnail" alt="Image"></td>
                  <td>  {{ $row->client_name}}</td>
                  <td>  {{ $row->phone}}</td>
                  <td>  {{ $row->email}}</td>
                  <td>  {{ $row->address}}</td>
                  <td>  {{ $row->payment_amount}}</td>
                  <td>
                 @if($row->client_status == 1)
                   <a href="#" class="btn btn-success btn-sm">Active<a>
                 @else
                    <a href="#"  class="btn btn-danger btn-sm"> Inactive<a>
                 @endif
               </td>
                <td> <button type="button" value="{{ $row->id}}" class="btn btn-primary btn-sm editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal">Edit</button>  </td>
                <td> <button type="button" value="{{ $row->id}}" class="btn btn-danger btn-sm deleteIcon" >Delete</button>  </td>
                  <td>  {{ $row->created_date}}</td>
                  <td>  {{ $row->expired_date}}</td>
                  <td>  {{ $row->subcribe}}</td>
                  <td>  {{ $row->service_info}}</td>
                  <td>  {{ $row->domain_name}}</td>
                  <td>  {{ $row->domain_expired}}</td>
                  <td> <?php  echo $interval->format('%y-%m-%d day'); ?> </td>
                  <td>  {{ $row->domain_info}}</td>
                  <td>  {{ $row->total_amount}}</td>
                  <td>  {{ $row->discount_info}}</td>
                  <td>  {{ $row->discount_amount}}</td>
                  <td>  {{ $row->client_info}}</td>
                  <td>  {{ $row->client_ref}}</td>
                  <td>  {{ $row->created_at}}</td>
             
            </tr>            
@endforeach
  <tr class="pagin_link">
        <td colspan="4" align="center">
           {!! $data->links() !!}
        </td>
   </tr>  