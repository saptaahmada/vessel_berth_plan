@extends('home.home')

@section('content')



    <div id="content">
            <div class="panel box-shadow-none content-header">
                <div class="panel-body">
                    <div class="col-md-12">
                    <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>Dermaga</b></h3>
                    <p class="animated fadeInDown">
                     Data Tables <span class="fa-angle-right fa"></span> Data Dermaga
                    </p>
                    </div>
                </div>
            </div>
              <div class="col-md-12 top-20 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <h3>Data Dermaga <button class="btn ripple-btn-round btn-3d btn-success right" id="btn_add"  data-toggle="modal" data-target="#modal_add" >
                        <i class='fa fa-plus '></i> Tambah
                      </button></h3>

                    </div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <table id="table" class="table table-striped table-bordered" width="100%" cellspacing="0">
                            
                                <thead>
                                  <th>Kode</th>
                                  <th>Name</th>
                                  <th>Length</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Dermaga</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <form role="form" action="{{ route('addvessel') }}" method="POST"> -->
        <!-- <form role="form" enctype="multipart/form-data"> -->
        <!-- {{csrf_field()}} -->
         <div class="form-group">
            <label class="col-form-label">Kode </label>
            <input type="text" class="form-control" id="param2" name="param2">
          </div>
          <div class="form-group">
            <label class="col-form-label">Nama </label>
            <input type="text" class="form-control" id="param3" name="param3">
          </div>
          <div class="form-group">
            <label class="col-form-label">Panjang </label>
            <input type="number" class="form-control" id="param4" name="param4">
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

<script type="text/javascript">
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
        ajax: "{{url('Dermaga/json')}}",
        columns: [
            { data: 'param2', name: 'param2' },
            { data: 'param3', name: 'param3' },
            { data: 'param4', name: 'param4' },
            { 

              // btn ripple- btn-round btn-3d btn-success
                "data": "param2",
                "render": function ( data, type, row ) {
                    return "<button class='btn ripple-btn-round btn-3d btn-danger' onclick=\"remove('"+data+"')\">"+
                              "<i class='fa fa-trash'></i>"+
                            "</button>"+
                            " <button class='btn ripple-btn-round btn-3d btn-warning' onclick=\"prepareUpdate(true, '"+data+"', '"+row.param3+"', '"+row.param4+"')\" data-toggle='modal' data-target='#modal_add' >"+
                              "<i class='fa fa-pencil'></i>"+
                            "</button>";
                            (state, param2, param3, param4)
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
  })

  $('#submit_add').on('click', function() {
    $.ajax({  
      url : (!mIsUpdate?"{{ url('Dermaga/add') }}":"{{ url('Dermaga/update') }}"),
      data: {
        "_token": "{{ csrf_token() }}",
        curParam2:mCurParam2,
        param2:$('#param2').val(),
        param3:$('#param3').val(),
        param4:$('#param4').val(),
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
        url : "{{ url('Dermaga/remove') }}",
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

  function prepareUpdate(state, param2, param3, param4) {
    mIsUpdate = state;
    mCurParam2 = param2;
    $('#param2').val(param2);
    $('#param3').val(param3);
    $('#param4').val(param4);
  }

</script>
@endsection