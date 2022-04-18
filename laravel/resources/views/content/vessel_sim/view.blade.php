@extends('home.home')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/select2.min.css')}}"/>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script src="{{asset('asset/js/plugins/select2.full.min.js')}}"></script>

<script type="text/javascript" src="{{asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>


<div id="content">
  <div class="panel box-shadow-none content-header">
    <div class="panel-body">
        <div class="col-md-12">
          <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>Vessel</b></h3>
          <p class="animated fadeInDown">
           Data Tables <span class="fa-angle-right fa"></span> Data Vessel
          </p>
        </div>
    </div>
  </div>
  <div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading">
          <h3>Data Vessel</h3>
        </div>
        <div class="panel-body">
          <div class="responsive-table">
            <table id="table" class="table table-striped table-bordered" width="100%" cellspacing="0">
              <thead>
                <th>Ves Id</th>
                <th>Ves Code</th>
                <th>Ves Name</th>
                <th>ETB</th>
                <th>ATB</th>
                <th>ETD</th>
                <th>ATD</th>
                <th>Action</th>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>

<div class="modal fade" id="modal_edit"  role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Vessel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="col-form-label">Old Ves Id </label>
              <input type="text" class="form-control" id="ves_id" readonly="">
            </div>
            <div class="form-group">
              <label class="col-form-label">New Ves ID</label>
              <input type="text" class="form-control" id="ves_id_new">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="col-form-label">ETB</label>
              <div class="input-group date form_datetime bs-datetime">
                  <input type="text" id="etb" size="16" class="form-control">
                  <span class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                  </span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-form-label">ETD</label>
              <div class="input-group date form_datetime bs-datetime">
                  <input type="text" id="etd" size="16" class="form-control">
                  <span class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                  </span>
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="submit_edit" class="btn btn-primary" >Save</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Customer End-->

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script> -->

<script type="text/javascript">
  $(document).ready(function(){
    refreshTable();

    $(".form_datetime").datetimepicker({
      autoclose: !0,
      isRTL: false,
      format: "yyyy-mm-dd hh:ii",
      fontAwesome: !0,
      pickerPosition: false ? "bottom-right" : "bottom-left"
    });
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
        ajax: "{{url('VesselSim/json')}}",
        columns: [
          { data: 'ves_id', name: 'ves_id' },
          { data: 'ves_code', name: 'ves_code' },
          { data: 'ves_name', name: 'ves_name' },
          { data: 'est_berth_ts', name: 'est_berth_ts' },
          { data: 'act_berth_ts', name: 'act_berth_ts' },
          { data: 'est_dep_ts', name: 'est_dep_ts' },
          { data: 'act_dep_ts', name: 'act_dep_ts' },
          { 
            "data": "ves_id",
            "render": function ( data, type, row ) {
              return " <button class='btn ripple-btn-round btn-3d btn-warning' "+
              "onclick=\"prepareUpdate('"+row.ves_id+"', '"+row.est_berth_ts+"', '"+row.est_dep_ts+"')\" data-toggle='modal' data-target='#modal_edit' >"+
                        "<i class='fa fa-pencil'></i>"+
                      "</button>";
            }
          }
        ]
    });
  }

  $('#submit_edit').on('click', function() {
    if(confirm('Apakah anda yakin ingin mengubah data ini?')) {
      if(validateForm()) {
        $.ajax({  
          url : "{{ url('VesselSim/update') }}",
          data: {
            "_token": "{{ csrf_token() }}",
            ves_id : $('#ves_id').val(),
            ves_id_new : $('#ves_id_new').val(),
            etb : $('#etb').val(),
            etd : $('#etd').val(),
          },
          type : "post",
          dataType : "json",
          async : false,
          success : function(result) {
            if(result.success) {
              $('#modal_edit').modal('hide');
              refreshTable();
            }
            swal({
              title: result.success ? 'Success' : 'Failed',
              text: result.message,
              icon: result.success ? "success" : 'warning',
              button: "Oke",
            });
          }
        });
      } else {
        swal({
          title: "Warning",
          text: "Lengkapi Form..!!",
          icon: "warning",
        });
      }
    }
  })

  function validateForm() {
    if($('#ves_id').val() != 2 && $('#ves_id_new').val() != '') {
      return true;
    }
    return false;
  }

  function prepareUpdate(ves_id, est_berth_ts, est_dep_ts) {
    $('#ves_id').val(ves_id);
    $('#ves_id_new').val(ves_id);
    $('#etb').val(est_berth_ts.substring(0,16));
    $('#etd').val(est_dep_ts.substring(0,16));
  }

</script>
@endsection