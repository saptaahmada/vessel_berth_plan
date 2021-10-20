@extends('home.home')

@section('content')

<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"> -->
<link rel="stylesheet" type="text/css" href="{{asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/select2.min.css')}}"/>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script src="{{asset('asset/js/plugins/select2.full.min.js')}}"></script>

<script type="text/javascript" src="{{asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>

<div id="content">
  <div class="panel box-shadow-none content-header">
    <div class="panel-body">
        <div class="col-md-12">
          <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>REQ BERTH</b></h3>
          <p class="animated fadeInDown">
           Data Tables <span class="fa-angle-right fa"></span> Data REQ BERTH
          </p>
        </div>
    </div>
  </div>
  <div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading">
          <h3>Data REQ BERTH <button class="btn ripple-btn-round btn-3d btn-success right" id="btn_add"  data-toggle="modal" data-target="#modal_add" >
            <i class='fa fa-plus '></i> Tambah
          </button></h3>
        </div>
        <div class="panel-body">
          <div class="responsive-table">
            <table id="table" class="table table-striped table-bordered" width="100%" cellspacing="0">
              <thead>
                <th>Ves Code</th>
                <th>Ves Name</th>
                <th>LOA</th>
                <th>Voy No</th>
                <th>RBT</th>
                <th>ETA</th>
                <th>ETB</th>
                <th>Est Load</th>
                <th>Est Disc</th>
                <th>Dest Port</th>
                <th>Draft</th>
                <th>Closing Cargo</th>
                <th>Status</th>
                <th>Remark</th>
                <th>Cancel</th>
                <!-- <th>Action</th> -->
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>

<div class="modal fade" id="modal_add"  role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add REQ BERTH</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label class="col-form-label">Ves Code</label>
            <select id="ves_code" name="ves_code" class="form-control" style="width:100%;">
            </select>
            <input type="hidden" class="form-control" id="ves_id" name="ves_id">
            <input type="hidden" class="form-control" id="ves_name" name="ves_name">
            <input type="hidden" class="form-control" id="ves_code_mdm" name="ves_code_mdm">
            <input type="hidden" class="form-control" id="call_sign" name="call_sign">
          </div>
          <div class="form-group">
            <label class="col-form-label">LOA </label>
            <input type="number" class="form-control" id="loa" name="loa">
          </div>
          <div class="form-group">
            <label class="col-form-label">Voy No </label>
            <input type="text" class="form-control" id="voy_no_cust" name="voy_no_cust">
          </div>
          <div class="form-group">
            <label class="col-form-label">Dest Port</label>
            <select id="dest_port" name="dest_port" class="form-control" style="width:100%;">
            </select>
            <input type="hidden" class="form-control" id="dest_port_name" name="dest_port_name">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <label class="col-form-label">Request Berth Time : </label>
              <div class="input-group date form_datetime bs-datetime">
                  <input type="text" id="rbt" size="16" class="form-control">
                  <span class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                  </span>
              </div>
          </div>
          <div class="form-group">
              <label class="col-form-label">ETA : </label>
              <div class="input-group date form_datetime bs-datetime">
                  <input type="text" id="eta" size="16" class="form-control">
                  <span class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                  </span>
              </div>
          </div>
          <div class="form-group">
              <label class="col-form-label">ETB : </label>
              <div class="input-group date form_datetime bs-datetime">
                  <input type="text" id="etb" size="16" class="form-control">
                  <span class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                  </span>
              </div>
          </div>
          <div class="form-group">
            <label class="col-form-label">Closing Cargo</label>
              <div class="input-group date form_datetime bs-datetime">
                  <input type="text" id="closing_cargo_date" size="16" class="form-control">
                  <span class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                  </span>
              </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label class="col-form-label">Est Load</label>
            <input type="text" class="form-control" id="est_load" name="est_load">
          </div>
          <div class="form-group">
            <label class="col-form-label">Est Disc</label>
            <input type="text" class="form-control" id="est_disc" name="est_disc">
          </div>
          <div class="form-group">
            <label class="col-form-label">Draft</label>
            <input type="text" class="form-control" id="draft" name="draft">
          </div>
          <div class="form-group">
            <label class="col-form-label">Remark</label>
            <textarea class="form-control" id="remark" name="remark"></textarea>
          </div>
          <div class="form-group">
            <label class="col-form-label">Status Request</label>
            <select class="form-control" id="status" class="status">
              <option value="">-- Pilih Status Request --</option>
              <option value="0">Request Vessel Berth</option>
              <option value="1">Update Vessel Berth</option>
            </select>
          </div>
        </div>
        </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" id="submit_add" class="btn btn-primary" >Save</button>
          </div>

      </div>
     
    </div>
  </div>
</div>


<div class="modal fade" id="modal_cancel"  role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">CANCEL REQ BERTH</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <input type="hidden" class="form-control" id="cancel_id">
              <label class="col-form-label">Ves Code</label>
              <input type="text" class="form-control" id="cancel_ves_code_str" readonly="">
              <input type="hidden" class="form-control" id="cancel_ves_id">
              <input type="hidden" class="form-control" id="cancel_ves_code">
              <input type="hidden" class="form-control" id="cancel_ves_name">
              <input type="hidden" class="form-control" id="cancel_ves_code_mdm">
              <input type="hidden" class="form-control" id="cancel_call_sign">
            </div>
            <div class="form-group">
              <label class="col-form-label">LOA </label>
              <input type="number" class="form-control" id="cancel_loa" readonly="">
            </div>
            <div class="form-group">
              <label class="col-form-label">Voy No </label>
              <input type="text" class="form-control" id="cancel_voy_no_cust" readonly="">
            </div>
            <div class="form-group">
              <label class="col-form-label">Dest Port</label>
              <input type="text" class="form-control" id="cancel_dest_port_str" readonly="">
              <input type="hidden" id="cancel_dest_port">
              <input type="hidden" class="form-control" id="cancel_dest_port_name">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label class="col-form-label">Request Berth Time : </label>
                <input type="text" class="form-control" id="cancel_rbt" readonly="">
            </div>
            <div class="form-group">
                <label class="col-form-label">ETA : </label>
                <input type="text" class="form-control" id="cancel_eta" readonly="">
            </div>
            <div class="form-group">
                <label class="col-form-label">ETB : </label>
                <input type="text" class="form-control" id="cancel_etb" readonly="">
            </div>
            <div class="form-group">
              <label class="col-form-label">Closing Cargo</label>
              <input type="text" class="form-control" id="cancel_closing_cargo_date" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="col-form-label">Est Load</label>
              <input type="text" class="form-control" id="cancel_est_load" readonly="">
            </div>
            <div class="form-group">
              <label class="col-form-label">Est Disc</label>
              <input type="text" class="form-control" id="cancel_est_disc" readonly="">
            </div>
            <div class="form-group">
              <label class="col-form-label">Draft</label>
              <input type="text" class="form-control" id="cancel_draft" readonly="">
            </div>
            <div class="form-group">
              <label class="col-form-label">Remark</label>
              <textarea class="form-control" id="cancel_remark"></textarea>
            </div>
            <input type="hidden" id="cancel_status" value="1">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="submit_cancel" class="btn btn-primary">Cancel Request Berth</button>
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
  });

  var selectedRow = null;

  $(".form_datetime").datetimepicker({
    autoclose: !0,
    isRTL: false,
    format: "dd/mm/yyyy hh:ii",
    fontAwesome: !0,
    pickerPosition: false ? "bottom-right" : "bottom-left"
  });

  function refreshTable() {
    $('#table').DataTable({
        "filter": true,
        "destroy": true,
        "ordering": false,
        "processing": true, 
        "serverSide": true, 
        "searching": true, 
        "responsive":false,
        "orderCellsTop": true,
        "fixedHeader": true,
        ajax: "{{url('ReqBerth/json')}}",
        columns: [
          { data: 'ves_code', name: 'ves_code' },
          { data: 'ves_name', name: 'ves_name' },
          { data: 'loa', name: 'loa' },
          { data: 'voy_no_cust', name: 'voy_no_cust' },
          { data: 'rbt_str', name: 'rbt_str' },
          { data: 'eta_str', name: 'eta_str' },
          { data: 'etb_str', name: 'etb_str' },
          { data: 'est_load', name: 'est_load' },
          { data: 'est_disc', name: 'est_disc' },
          { data: 'dest_port', name: 'dest_port' },
          { data: 'draft', name: 'draft' },
          { data: 'closing_cargo_date_str', name: 'closing_cargo_date_str' },
          { data: 'status_str', name: 'status_str' },
          { data: 'remark', name: 'remark' },
          { 
            "data": "id",
            "render": function ( data, type, row ) {
              if(row.is_cancel == 0) {
                return "<button class='btn ripple-btn-round btn-3d btn-danger' onclick=\"prepareCancel('"+data+"', '"+row.ves_id+"', '"+row.ves_code+"', '"+row.ves_name+"', '"+row.ves_code_mdm+"', '"+row.call_sign+"', '"+row.loa+"', '"+row.voy_no_cust+"', '"+row.rbt_str+"', '"+row.eta_str+"', '"+row.etb_str+"', '"+row.est_load+"', '"+row.est_disc+"', '"+row.dest_port+"', '"+row.dest_port_name+"', '"+row.draft+"', '"+row.closing_cargo_date_str+"', '"+row.status+"')\">"+
                          "<i class='fa fa-times'></i> cancel"+
                        "</button>";
              } else {
                return "";
              }
            }
          }
        ],
        "createdRow": function( row, data, dataIndex){
            if(data.status == '0'){
                $(row).css("background", "#7dffa4");
            } else if(data.status == '1') {
                $(row).css("background", "#ffccfb");
            } else if(data.status == '2') {
                $(row).css("background", "#ffc6c2");
            }
        }
    });
  }

  mIsUpdate = false;
  mCurId = '';

  $('#btn_add').on('click', function() {
      mIsUpdate = false;
      clearForm();
  })

  $('#submit_add').on('click', function() {
    if(validateForm()) {
      $.ajax({  
        url : (!mIsUpdate?"{{ url('ReqBerth/add') }}":"{{ url('ReqBerth/update') }}"),
        data: {
          "_token": "{{ csrf_token() }}",
          id : mCurId,
          ves_id : $('#ves_id').val(),
          ves_code : $('#ves_code').val(),
          ves_name : $('#ves_name').val(),
          ves_code_mdm : $('#ves_code_mdm').val(),
          call_sign : $('#call_sign').val(),
          loa : $('#loa').val(),
          voy_no_cust : $('#voy_no_cust').val(),
          rbt : $('#rbt').val(),
          eta : $('#eta').val(),
          etb : $('#etb').val(),
          est_load : $('#est_load').val(),
          est_disc : $('#est_disc').val(),
          dest_port : $('#dest_port').val(),
          dest_port_name : $('#dest_port_name').val(),
          draft : $('#draft').val(),
          closing_cargo_date : $('#closing_cargo_date').val(),
          remark : $('#remark').val(),
          status : $('#status').val(),
        },
        type : "post",
        dataType : "json",
        async : false,
        success : function(result) {
          if(result.success) {
            refreshTable();
            $('#modal_add').modal('hide');
            clearForm();
          }
          mIsUpdate = false;
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
  })

  $('#submit_cancel').on('click', function() {
    if(validateFormCancel()) {
      $.ajax({  
        url : "{{ url('ReqBerth/cancel') }}",
        data: {
          "_token": "{{ csrf_token() }}",
          id : $('#cancel_id').val(),
          ves_id : $('#cancel_ves_id').val(),
          ves_code : $('#cancel_ves_code').val(),
          ves_name : $('#cancel_ves_name').val(),
          ves_code_mdm : $('#cancel_ves_code_mdm').val(),
          call_sign : $('#cancel_call_sign').val(),
          loa : $('#cancel_loa').val(),
          voy_no_cust : $('#cancel_voy_no_cust').val(),
          rbt : $('#cancel_rbt').val(),
          eta : $('#cancel_eta').val(),
          etb : $('#cancel_etb').val(),
          est_load : $('#cancel_est_load').val(),
          est_disc : $('#cancel_est_disc').val(),
          dest_port : $('#cancel_dest_port').val(),
          dest_port_name : $('#cancel_dest_port_name').val(),
          draft : $('#cancel_draft').val(),
          closing_cargo_date : $('#cancel_closing_cargo_date').val(),
          remark : $('#cancel_remark').val(),
          status : $('#cancel_status').val(),
        },
        type : "post",
        dataType : "json",
        async : false,
        success : function(result) {
          if(result.success) {
            refreshTable();
            $('#modal_cancel').modal('hide');
            clearFormCancel();
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
  })

  function validateForm() {
    if($('#ves_code').val() != '' &&
      $('#loa').val() != '' &&
      $('#voy_no_cust').val() != '' &&
      $('#dest_port').val() != '' &&
      $('#rbt').val() != '' &&
      $('#eta').val() != '' &&
      $('#etb').val() != '' &&
      $('#est_load').val() != '' &&
      $('#est_disc').val() != '' &&
      $('#draft').val() != '' &&
      $('#status').val() != '') {
      return true;
    }
    return false;
  }

  function validateFormCancel() {
    if($('#cancel_ves_code').val() != '' &&
      $('#cancel_id').val() != '' &&
      $('#cancel_loa').val() != '' &&
      $('#cancel_voy_no_cust').val() != '' &&
      $('#cancel_dest_port').val() != '' &&
      $('#cancel_rbt').val() != '' &&
      $('#cancel_eta').val() != '' &&
      $('#cancel_etb').val() != '' &&
      $('#cancel_est_load').val() != '' &&
      $('#cancel_est_disc').val() != '' &&
      $('#cancel_draft').val() != '' &&
      $('#cancel_status').val() != '') {
      return true;
    }
    return false;
  }

  function clearForm() {
    $('#ves_code').val('');
    $('#ves_code').val('').trigger('change');
    $('#ves_id').val('');
    $('#ves_name').val('');
    $('#ves_code_mdm').val('');
    $('#call_sign').val('');
    $('#loa').val('');
    $('#voy_no_cust').val('');
    $('#rbt').val('');
    $('#eta').val('');
    $('#etb').val('');
    $('#est_load').val('');
    $('#est_disc').val('');
    $('#dest_port').val('');
    $('#dest_port').val('').trigger('change');
    $('#dest_port_name').val('');
    $('#draft').val('');
    $('#closing_cargo').val('');
    $('#remark').val('');
    $('#status').val('');
  }

  function clearFormCancel() {
    $('#cancel_id').val('');
    $('#cancel_ves_code').val('');
    $('#cancel_ves_id').val('');
    $('#cancel_ves_name').val('');
    $('#cancel_ves_code_mdm').val('');
    $('#cancel_call_sign').val('');
    $('#cancel_loa').val('');
    $('#cancel_voy_no_cust').val('');
    $('#cancel_rbt').val('');
    $('#cancel_eta').val('');
    $('#cancel_etb').val('');
    $('#cancel_est_load').val('');
    $('#cancel_est_disc').val('');
    $('#cancel_dest_port').val('');
    $('#cancel_dest_port_name').val('');
    $('#cancel_draft').val('');
    $('#cancel_closing_cargo').val('');
    $('#cancel_remark').val('');
    $('#cancel_status').val('');
  }

  function cancel(id) {
    // if(confirm('apakah anda yakin ingin data ini?')) {
    //   $.ajax({  
    //     url : "{{ url('ReqBerth/remove') }}",
    //     data: {
    //       "_token": "{{ csrf_token() }}",
    //       id:id,
    //     },
    //     type : "post",
    //     dataType : "json",
    //     async : false,
    //     success : function(result) {
    //       if(result.success) {
    //         refreshTable();
    //       }
    //       swal({
    //         title: result.success ? 'Success' : 'Failed',
    //         text: result.message,
    //         icon: result.success ? "success" : 'warning',
    //         button: "Oke",
    //       });
    //     }
    //   });
    // }
  }

  function prepareCancel(id, ves_id, ves_code, ves_name, ves_code_mdm, call_sign, loa, voy_no_cust, 
    rbt_str, eta_str, etb_str, est_load, est_disc,
    dest_port, dest_port_name, draft, closing_cargo_date_str, status) {

    // if(id != null) {
      $('#modal_cancel').modal('show');
      $('#cancel_id').val(id);
      $('#cancel_ves_code_str').val(ves_name+" ("+ves_code+")");
      $('#cancel_ves_id').val(ves_id);
      $('#cancel_ves_code').val(ves_code);
      $('#cancel_ves_name').val(ves_name);
      $('#cancel_ves_code_mdm').val(ves_code_mdm);
      $('#cancel_call_sign').val(call_sign);
      $('#cancel_loa').val(loa);
      $('#cancel_voy_no_cust').val(voy_no_cust);
      $('#cancel_rbt').val(rbt_str);
      $('#cancel_eta').val(eta_str);
      $('#cancel_etb').val(etb_str);
      $('#cancel_est_load').val(est_load);
      $('#cancel_est_disc').val(est_disc);
      $('#cancel_dest_port_str').val(dest_port_name);
      $('#cancel_dest_port').val(dest_port);
      $('#cancel_dest_port_name').val(dest_port_name);
      $('#cancel_draft').val(draft);
      $('#cancel_closing_cargo_date').val(closing_cargo_date_str);
      $('#cancel_remark').val();
      $('#cancel_status').val('2');
    // }
  }

  $("#ves_code").select2({
    ajax: {
      url: "{{ url('GeneralService/get_vessel_json') }}",
      type: "post",
      dataType: 'json',
      delay: 250,
      data: function(params) {
        return {
          keyword: params.term,
          _token: "{{ csrf_token() }}"
        };
      },
      processResults: function(response) {
        return {
          results: response
        };
      },
      cache: true
    },
    placeholder: "Select..",
    allowClear: true,
    // minimumInputLength: 3
  });

  $("#dest_port").select2({
    ajax: {
      url: "{{ url('GeneralService/get_port_json') }}",
      type: "post",
      dataType: 'json',
      delay: 250,
      data: function(params) {
        return {
          keyword: params.term,
          _token: "{{ csrf_token() }}"
        };
      },
      processResults: function(response) {
        return {
          results: response
        };
      },
      cache: true
    },
    placeholder: "Select..",
    allowClear: true,
    // minimumInputLength: 3
  });

  $('#ves_code').on('change', function () {
    $.ajax({  
      url : "{{ url('GeneralService/get_vessel_det_by_ves_code') }}",
      data: {
        "_token": "{{ csrf_token() }}",
        ves_code:$('#ves_code').val(),
      },
      type : "post",
      dataType : "json",
      async : false,
      success : function(result) {
        if(result.success) {
          if(result.data != null) {
            $('#ves_id').val(result.data.ves_id);
            $('#ves_name').val(result.data.ves_name);
            $('#ves_code_mdm').val(result.data.mdm_kode_kapal);
            $('#call_sign').val(result.data.call_sign);
            $('#loa').val(result.data.ves_len);
          }
        }
      }
    });
    // $('#ves_name').val($("#ves_code option:selected").text());
  })

  $('#dest_port').on('change', function () {
    $('#dest_port_name').val($("#dest_port option:selected").text());
  })

</script>
@endsection