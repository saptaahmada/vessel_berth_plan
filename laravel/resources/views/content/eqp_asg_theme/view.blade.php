@extends('home.home')

@section('content')



<div id="content">
  <div class="panel box-shadow-none content-header">
      <div class="panel-body">
          <div class="col-md-12">
          <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>Master Template</b></h3>
          <p class="animated fadeInDown">
           Data Tables <span class="fa-angle-right fa"></span> Data Template
          </p>
          </div>
      </div>
  </div>
    <div class="col-md-12 top-20 padding-0">
      <div class="col-md-12">
        <div class="panel">
          <div class="panel-heading">
            <h3>Data Template 
              <a href="{{url('EqpAsgTheme/add')}}" class="btn ripple-btn-round btn-3d btn-success right">
                <i class='fa fa-plus '></i> Tambah
              </a>
            </h3>

          </div>
          <div class="panel-body">
            <div class="responsive-table">
            <table id="table" class="table table-striped table-bordered" width="100%" cellspacing="0">
            
                <thead>
                  <th>Nama Template</th>
                  <th>Jum OPT</th>
                  <th>Edit</th>
                </thead>
                      
              </table>
            </div>
        </div>
      </div>
    </div>  
  </div>
</div>

<!-- Modal Edit Customer End-->

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>

<script type="text/javascript">
  var m_plan_type = "{{session('plan_type')}}";

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
        ajax: "{{url('EqpAsgTheme/json')}}",
        columns: [
            { data: 'theme_name', name: 'theme_name' },
            { data: 'jum_opt', name: 'jum_opt' },
            { 
                "data": "param2",
                "render": function ( data, type, row ) {
                    return "<button class='btn ripple-btn-round btn-3d btn-danger' onclick=\"remove('"+row.theme_name+"')\">"+
                              "<i class='fa fa-trash'></i>"+
                            "</button> "+
                            "<a href=\"{{url('EqpAsgTheme/update')}}/"+row.theme_name+"\" class='btn ripple-btn-round btn-3d btn-warning'>"+
                              "<i class='fa fa-pencil'></i>"+
                            "</a>";
                }
            }
        ]
    });
  }

  function remove(theme_name) {
    if(confirm("apakah anda yakin ingin menghapus data ini?")) {
      $.ajax({
          url :  "{{url('EqpAsgTheme/remove')}}",
          type : "post",
          dataType : "json",
          data : {
              "_token": "{{ csrf_token() }}",
              plan_type : m_plan_type,
              theme_name : theme_name,
          },
          async : true,
          success : function(result){
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

</script>
@endsection