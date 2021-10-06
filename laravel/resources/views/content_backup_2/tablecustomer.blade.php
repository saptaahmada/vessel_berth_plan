@extends('home.home')

@section('content')



    <div id="content">
            <div class="panel box-shadow-none content-header">
                <div class="panel-body">
                    <div class="col-md-12">
                    <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>Customer</b></h3>
                    <p class="animated fadeInDown">
                     Data Tables <span class="fa-angle-right fa"></span> Data Curstomer
                    </p>
                    </div>
                </div>
            </div>
              <div class="col-md-12 top-20 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Data Customer</h3></div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Logo</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Logo</th>
                                <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            @foreach($customer as $cus)
                                <tr>
                                <td>{{$cus->customer}}</td>
                                <td>{{$cus->full_name}}</td>
                                <td>{{$cus->addr1}}</td>
                                <td>{{$cus->phone}}</td>
                                <td> <img width="70px" height="50px" class="img-circle" src = "{{asset('/img/customer/'.$cus->image)}}"> </td>
                                <td> 
                                <button class="btn ripple- btn-round btn-3d btn-warning edit" data-toggle="modal" data-target="#update" data-name="{{$cus->full_name}}" data-id="{{$cus->customer}}" data-img ="{{$cus->image}}">Update</button>
                                </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                      </div>
                  </div>
                </div>
              </div>  
              </div>
    </div>

<!-- Modal Edit Customer -->

<div class="modal fade" id="update"  role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Vessel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <form role="form" action="{{ route('addvessel') }}" method="POST"> -->
        <form id="form_update"  method="POST" action="#" role="form" enctype="multipart/form-data">
        {{csrf_field()}}
         <div class="form-group">
            <label class="col-form-label">Customer ID: </label>
            <input type="text" class="form-control" id="customer_ID" name="customer_ID" disabled>
          </div>
          <div class="form-group">
            <label class="col-form-label">Customer Name: </label>
            <input type="text" class="form-control" id="customer_name" disabled>
          </div>
    
          <div class="form-group">
            <label class="col-form-label">Customer Logo: </label>
                <div>
                    <img src=""  width ="80px" id="pict">
                </div>
            <input type="file" class="form-control" id="file" name="file">
           
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" >Update Customer</button>
        </div>
        </form>
      </div>
     
    </div>
  </div>
</div>

<!-- Modal Edit Customer End-->

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
     $('.edit').click(function(){
        // console.log("{{ url('/VesselBerthPlan_Logo/updatelogo/') }}/"+$(this).data('id'))
        var id_cus = $(this).data('id');
        var name_cus = $(this).data('name');
        var img_cus = $(this).data('img');
        $(".modal-body #customer_ID").val(id_cus);
        $(".modal-body #customer_name").val(name_cus);
        $(".modal-body #pict").attr("src", "{{ URL::to('public//') }}/img/"+img_cus );
        $('#form_update').attr('action', "{{ url('/VesselBerthPlan_Logo/updatelogo/') }}/"+$(this).data('id'))
    })   
</script>


<script type="text/javascript">
  $(document).ready(function(){
    $('#datatables-example').DataTable();
  });
</script>
@endsection