@extends('home.home')

@section('content')

<style>
hr{
  border-top: 5px solid #aa9494
}
</style>

<link rel="stylesheet" type="text/css" href="{{asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>


    <div id="content">
            <div class="panel box-shadow-none content-header">
                <div class="panel-body">
                    <div class="col-md-12">
                    <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>Master Holiday</b></h3>
                    <p class="animated fadeInDown">
                     Data Master <span class="fa-angle-right fa"></span> Master Holiday
                    </p>
                    </div>
                </div>
            </div>
              <div class="col-md-12 top-20 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <h3>Master Holiday <button class="btn ripple-btn-round btn-3d btn-success right" id="btn_add"  data-toggle="modal" data-target="#modal_add" >
                        <i class='fa fa-plus '></i> Tambah
                      </button></h3>

                    </div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <table id="table" class="table table-striped table-bordered" width="100%" cellspacing="0">
                            
                                <thead>
                                  <th>Id </th>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Master Holiday</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class ="row" id= "button_input">
            <button class="btn ripple-btn-round btn-3d btn-warning " id="input_add"  style="margin-left:30px; margin-top:10px">
                <i class='fa fa-plus'></i>
            </button>
      </div>
      <div class="modal-body" >
      <div id="form_add">
        <div class="container-fluid">
          <div class ="row">
            <div class="col-md-9">

              <div class="form-group">
                  <label class="col-form-label">Start Date : </label>
                  <div class="input-group date form_datetime bs-datetime">
                      <input type="text" id="start_date" size="16" class="form-control start">
                      <span class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                      </span>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-form-label">End Date : </label>
                  <div class="input-group date form_datetime bs-datetime">
                      <input type="text" id="end_date" size="16" class="form-control end">
                      <span class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                      </span>
                  </div>
              </div>
              
            </div>
          
          </div>
        </div> 
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
    initialDatetime();
  });

function initialDatetime() {
  $(".form_datetime").datetimepicker({
    autoclose: !0,
    isRTL: false,
    format: "dd/mm/yyyy hh:ii",
    fontAwesome: !0,
    pickerPosition: false ? "bottom-right" : "bottom-left"
  });
}

function refreshTable(){
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
      ajax: "{{url('MHoliday/json')}}",
      columns: [
        { data: 'id', name: 'id' },
        { data: 'start_date', name: 'start_date' },
        { data: 'end_date', name: 'end_date' },
        { 
          "data": "id",
          "render": function ( data, type, row ) {
              return "<button class='btn ripple-btn-round btn-3d btn-danger' onclick=\"remove('"+data+"')\">"+
                        "<i class='fa fa-trash'></i>"+
                      "</button>";
          }
        }
      ]
  });
}

var numb = 0;
$('#input_add').on('click', function() {
  var html ='<div class="kolom" id="kolom'+numb+'">'+
            '<hr>'+
              '<div class="container-fluid">'+
                '<div class ="row">'+
                  '<div class="col-md-9">'+
                    '<div class="form-group">'+
                        '<label class="col-form-label">Start Date : </label>'+
                        '<div class="input-group date form_datetime bs-datetime">'+
                            '<input type="text" id="start_date" size="16" class="form-control start">'+
                            '<span class="input-group-addon">'+
                                '<i class="fa fa-calendar"></i>'+
                            '</span>'+
                        '</div>'+
                    '</div>'+

                    '<div class="form-group">'+
                        '<label class="col-form-label">End Date : </label>'+
                        '<div class="input-group date form_datetime bs-datetime">'+
                            '<input type="text" id="end_date" size="16" class="form-control end">'+
                            '<span class="input-group-addon">'+
                                '<i class="fa fa-calendar"></i>'+
                            '</span>'+
                        '</div>'+
                    '</div>'+
                  '</div>'+
                  '<div class="col-md-3 ml-auto" >'+
                    '<div style="margin-top:70px"><a class="remove_block" onclick="removediv('+numb+')" href="#">Remove</a></div>'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>';

  $('#form_add').append(html);
  initialDatetime();
  numb++;
   
});

$('#parent').on('click', 'a.remove_block', function(events){
   $(this).parents('div').eq(1).remove();
});

function removediv(param){
  $("#kolom"+param).remove();
}

function clear() {
  $('.start').val('');
  $('.end').val('');
  $(".kolom").remove();
}

$('#submit_add').on('click', function() {
  var start= $.map($('.start'), function (el) { 
    return el.value;
  });

  var end = $.map($('.end'), function (i) { 
    return i.value; 
  });

  $.ajax({  
    url :"{{ url('MHoliday/add') }}" ,
    data: {
      "_token": "{{ csrf_token() }}",
      start_date:start,
      end_date:end,
    },
    type : "post",
    dataType : "json",
    async : false,
    success : function(result) {
      if(result.success) {
        refreshTable();
        $('#modal_add').modal('hide');
        clear();
        
      }
      mIsUpdate = false;
      alert(result.message);
    }
  });
});




function remove(id) {
    if(confirm('apakah anda yakin ingin menghapus data ini?')) {
      $.ajax({  
        url : "{{ url('MHoliday/remove') }}",
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
          alert(result.message);
        }
      });
    }
}
</script>
@endsection