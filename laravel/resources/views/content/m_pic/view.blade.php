@extends('home.home')

@section('content')

<!-- <link rel="stylesheet" type="text/css" href="{{asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" /> -->
<link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/select2.min.css')}}"/>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script src="{{asset('asset/js/plugins/select2.full.min.js')}}"></script>

<!-- <script type="text/javascript" src="{{asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script> -->


<div id="content">
  <div class="panel box-shadow-none content-header">
    <div class="panel-body">
        <div class="col-md-12">
          <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>PIC</b></h3>
          <p class="animated fadeInDown">
           Data Tables <span class="fa-angle-right fa"></span> Data PIC
          </p>
        </div>
    </div>
  </div>
  <div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading">
          <h3>Data PIC <button class="btn ripple-btn-round btn-3d btn-success right" id="btn_add"  data-toggle="modal" data-target="#modal_add" >
            <i class='fa fa-plus '></i> Tambah
          </button></h3>

        </div>
        <div class="panel-body">
          <div class="responsive-table">
            <table id="table" class="table table-striped table-bordered" width="100%" cellspacing="0">
              <thead>
                <th>Tipe</th>
                <th>Agent</th>
                <th>Nama PIC</th>
                <th>HP</th>
                <th>Email</th>
                <th>Action</th>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>

<div class="modal fade" id="modal_add"  role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add PIC</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label class="col-form-label">Tipe </label>
            <select class="form-control" name="tipe" id="tipe">
              <option value="">-- Pilih Tipe --</option>
              <option value="0">PIC Vessel</option>
              <option value="1">Dinas Luar</option>
              <option value="2">Pandu</option>
            </select>
            <!-- <input type="text" class="form-control" id="tipe" name="tipe"> -->
          </div>
          <div id="div_agent">
            <div class="form-group">
              <label class="col-form-label">Agent </label>
              <select id="agent" name="agent" class="form-control" style="width:100%;">
              </select>
              <input type="hidden" class="form-control" id="agent_name" name="agent_name">
            </div>
          </div>
          <div id="div_pandu">
            <div class="form-group">
              <label class="col-form-label">Call Sign Pandu </label>
              <input type="text" class="form-control" id="callsign_pandu" name="callsign_pandu">
            </div>
          </div>
          <div class="form-group">
            <label class="col-form-label">Nama </label>
            <input type="text" class="form-control" id="nama" name="nama">
          </div>
          <div class="form-group">
            <label class="col-form-label">HP </label>
            <input type="number" class="form-control" id="hp" name="hp">
          </div>
          <div class="form-group">
            <label class="col-form-label">Email </label>
            <input type="text" class="form-control" id="email" name="email">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" id="submit_add" class="btn btn-primary" >Save</button>
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
    $('#div_pandu').hide();
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
        ajax: "{{url('MPic/json')}}",
        columns: [
          { data: 'tipe_name', name: 'tipe_name' },
          { data: 'agent_name', name: 'agent_name' },
          { data: 'nama', name: 'nama' },
          { data: 'hp', name: 'hp' },
          { data: 'email', name: 'email' },
          { 
            "data": "id",
            "render": function ( data, type, row ) {
                return "<button class='btn ripple-btn-round btn-3d btn-danger' onclick=\"remove('"+data+"')\">"+
                          "<i class='fa fa-trash'></i>"+
                        "</button>"+
                        " <button class='btn ripple-btn-round btn-3d btn-warning' onclick=\"prepareUpdate(true, '"+data+"', '"+row.tipe+"', '"+row.agent+"', '"+row.agent_name+"', '"+row.hp+"', '"+row.email+"', '"+row.nama+"')\" data-toggle='modal' data-target='#modal_add' >"+
                          "<i class='fa fa-pencil'></i>"+
                        "</button>";
                // return "";
            }
          }
        ]
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
        url : (!mIsUpdate?"{{ url('MPic/add') }}":"{{ url('MPic/update') }}"),
        data: {
          "_token": "{{ csrf_token() }}",
          id : mCurId,
          tipe : $('#tipe').val(),
          nama : $('#nama').val(),
          agent : $('#tipe').val() != 2 ? $('#agent').val() : $('#callsign_pandu').val(),
          agent_name : $('#tipe').val() != 2 ? $('#agent_name').val() : $('#nama').val(),
          hp : $('#hp').val(),
          email : $('#email').val(),
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

  function validateForm() {
    if($('#tipe').val() != 2) {
      if($('#agent').val() != '' &&
        $('#hp').val() != '' &&
        $('#nama').val() != '' &&
        $('#tipe').val() != '') {
        return true;
      }
    } else {
      if($('#hp').val() != '' &&
        $('#nama').val() != '' &&
        $('#tipe').val() != '') {
        return true;
      }
    }
    return false;
  }

  function clearForm() {
    $('#agent').val('');
    $('#agent_name').val('');
    $('#nama').val('');
    $('#callsign_pandu').val('');
    $('#nama').val('');
    $('#hp').val('');
    $('#email').val('');
    $('#tipe').val('');
    $('#agent').val('').trigger('change');
  }

  function remove(id) {
    if(confirm('apakah anda yakin ingin menghapus data ini?')) {
      $.ajax({  
        url : "{{ url('MPic/remove') }}",
        data: {
          "_token": "{{ csrf_token() }}",
          id:id,
        },
        type : "post",
        dataType : "json",
        async : false,
        success : function(result) {
          if(result.success) {
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
    }
  }

  function prepareUpdate(state, id, tipe, agent, agent_name, hp, email, nama) {
    mIsUpdate = state;
    mCurId = id;
    changeDiv(tipe);
    $('#tipe').val(tipe);
    if(tipe == 2) {
      $('#callsign_pandu').val(agent);
      $('#nama').val(agent_name);
    } else {
      $('#agent').val(agent);
      $('#agent_name').val(agent_name);
      $('#agent').append('<option value="'+agent+'">'+agent_name+'</option>');
      $('#agent').val(agent).trigger('change');
      $('#nama').val(nama);
    }
    $('#hp').val(hp);
    $('#email').val(email);
  }

  $("#agent").select2({
    ajax: {
      url: "{{ url('Customer/get_agent_json') }}",
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

  $('#agent').on('change', function () {
    $('#agent_name').val($("#agent option:selected").text());
  })

  $('#tipe').on('change', function() {
    changeDiv($(this).val());
  });

  function changeDiv(tipe) {
    if(tipe == 2) {
      $('#div_agent').hide();
      $('#div_pandu').show();
    } else {
      $('#div_agent').show();
      $('#div_pandu').hide();
    }
  }

</script>
@endsection