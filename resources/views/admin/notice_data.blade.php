@foreach($data as $row)
      <tr>
                  <td>{{ $row->date}}</td>
                  <td>{{ $row->title}}</td>
                  <td>{{ $row->short_desc}}</td>
                  <td><img src="{{ asset('/uploads/admin/'.$row->image) }}" width="70" class="img-thumbnail" alt="Image"></td>
                  <td><a href="/admin/notice_view/{{ $row->id }}/{{ $row->category}}" class="btn btn-success btn-sm">View Details</a> </td> 
                  <td><a href="/admin/notice_edit/{{ $row->id }}/{{ $row->category}}" class="btn btn-info btn-sm">Edit</a> </td> 
                  <td><a href="/admin/notice_delete/{{ $row->id }}/{{ $row->category}}" onclick="return confirm('Are you sure you want to dalete  this item?')"  class="btn btn-danger btn-sm">Delete</a> </td> 
              
      </tr>
      @endforeach

      <tr class="pagin_link">
       <td colspan="9" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  