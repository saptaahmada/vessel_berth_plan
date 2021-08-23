@extends('home.home')

@section('content')



    <div id="content">
            <div class="panel box-shadow-none content-header">
                <div class="panel-body">
                    <div class="col-md-12">
                    <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>Arus</b></h3>
                    <p class="animated fadeInDown">
                     Data Master <span class="fa-angle-right fa"></span> Data Arus
                    </p>
                    </div>
                </div>
            </div>
              <div class="col-md-12 top-20 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <h3>Data Arus <button class="btn ripple-btn-round btn-3d btn-success right" id="btn_add"  data-toggle="modal" data-target="#modal_add" >
                        <i class='fa fa-plus '></i> Tambah
                      </button></h3>

                    </div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <table id="table" class="table table-striped table-bordered" width="100%" cellspacing="0">
                            
                                <thead>
                                  <th>Start Date</th>
                                  <th>End Date</th>
                                  <th>Edit</th>
                                </thead>
                                
                        </table>
                      </div>
                  </div>
                </div>
              </div>  
              </div>
    </div>

<!-- Modal Edit Customer -->

<div class="modal fade" id="modal_add"  role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Arus</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <form role="form" action="{{ route('addvessel') }}" method="POST"> -->
        <!-- <form role="form" enctype="multipart/form-data"> -->
        <!-- {{csrf_field()}} -->
          <div class="form-group">
            <label class="col-form-label">Start Date </label>
            <input type="datetime-local" class="form-control" id="param4" name="param4">
          </div>
          <div class="form-group">
            <label class="col-form-label">End Date </label>
            <input type="datetime-local" class="form-control" id="param5" name="param5">
          </div>
    
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" id="submit_add" class="btn btn-primary" >Save</button>
          </div>
        <!-- </form> -->
      </div>
     
    </div>
  </div>
</div>

<!-- Modal Edit Customer End-->

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>

<!-- <script type="text/javascript">
  $(document).ready(function(){
    refreshTable();
  });

  function refreshTable() {
    $('#table').DataTable({
        "filter": true,
        "destroy": true,
        "ordering": true,
        "processing": true, 
        "serverSide": true, 
        "searching": true, 
        "responsive":false,
        "orderCellsTop": true,
        "fixedHeader": true,
        ajax: "{{url('Arus/json')}}",
        columns: [
            { data: 'arus_id', name: 'param2' },
            {   data: 'tanggal',
                "render": function (data) {
                    var date = new Date(data);
                    var month = date.getMonth() + 1;
                    return date.getDate() + " - " + (month.toString().length > 1 ? month : "0" + month) + " - " + date.getFullYear();
                }, 
                name: 'tanggal' },
            { data: 'start_time', name: 'start_time' },
            { data: 'end_time', name: 'end_time' },
            { 

              // btn ripple- btn-round btn-3d btn-success
                "data": "arus_id",
                "render": function ( data, type, row ) {
                    return "<button class='btn ripple-btn-round btn-3d btn-danger' onclick=\"remove('"+data+"')\">"+
                              "<i class='fa fa-trash'></i>"+
                            "</button>"+
                            " <button class='btn ripple-btn-round btn-3d btn-warning' onclick=\"prepareUpdate(true, '"+data+"', '"+row.tanggal+"', '"+row.start_time+"', '"+row.end_time+"')\" data-toggle='modal' data-target='#modal_add' >"+
                              "<i class='fa fa-pencil'></i>"+
                            "</button>";
                            (state, param2, tanggal, start_time, end_time)
                }
            }
        ]
    });
  }

  mIsUpdate = false;
  mCurParam2 = '';

  $('#btn_add').on('click', function() {
      mIsUpdate = false;
      $('#param2').val('');
      $('#param3').val('');
      $('#param4').val('');
      $('#param5').val('');
  })
  
  var list_arus = [];

  $('#submit_plus').on('click', function() {
    // list_arus.push({
    //   ksortks
    // })
  })
  
  $('#submit_add').on('click', function() {
    $.ajax({  
      url : (!mIsUpdate?"{{ url('Arus/add') }}":"{{ url('Arus/update') }}"),
      data: {
        "_token": "{{ csrf_token() }}",
        curParam2:mCurParam2,
        param2:$('#param2').val(),
        param3:$('#param3').val(),
        param4:$('#param4').val(),
        param5:$('#param5').val(),
      },
      type : "post",
      dataType : "json",
      async : false,
      success : function(result) {
        if(result.success) {
          refreshTable();
          $('#modal_add').modal('hide');
        }
        mIsUpdate = false;
        alert(result.message);
      }
    });
  })

  function remove(param2) {
    if(confirm('apakah anda yakin ingin menghapus data ini?')) {
      $.ajax({  
        url : "{{ url('Arus/remove') }}",
        data: {
          "_token": "{{ csrf_token() }}",
          param2:param2,
        },
        type : "post",
        dataType : "json",
        async : false,
        success : function(result) {
          if(result.success) {
            refreshTable();
          }
          alert(result.message);
        }
      });
    }
  }

  function prepareUpdate(state, param2, tanggal, start_time, end_time) {
    mIsUpdate = state;
    mCurParam2 = param2;

    var now = new Date(tanggal);
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

    // console.log(today);

    $('#param2').val(param2);
    $('#param3').val(today);
    $('#param4').val(start_time);
    $('#param5').val(end_time);
  }

</script> -->
@endsection