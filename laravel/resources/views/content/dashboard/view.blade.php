@extends('home.home')

@section('content')
<style>
    #canvas_ship_to_ship {
        width:300px; height:300px;
        display: inline-block;
        margin: 1em;
    }
    #canvas_ship_to_ship_d, #canvas_ship_to_ship_i, #canvas_ship_to_ship_c {
        width:300px; height:300px;
        display: inline-block;
        margin: 1em;
    }
</style>

<!-- <link rel="stylesheet" type="text/css" href="{{asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" /> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="{{asset('asset/js/plugins/raphael.min.js')}}"></script>
<script src="{{asset('asset/js/plugins/justgate/justgate.js')}}"></script>

<!-- <script type="text/javascript" src="{{asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script> -->


<div id="content">
    <div class="panel box-shadow-none content-header">
        <div class="panel-body">
            <div class="col-md-12">
                <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>Dashboard</b></h3>
                <p class="animated fadeInDown">
                   Selamat Datang di Dashboad 
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-12 top-20 padding-0">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    SHIP TO SHIP
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label">Date To</label>
                                <input type="date" class="form-control" id="date_to" name="date_to">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label"></label>
                                <button class="btn btn-success" id="btn_submit" style="margin-top: 23px">
                                    <i class="fa fa-refresh"></i> Refresh
                                </button>
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3">
                            <div id="canvas_ship_to_ship"></div>
                            <button id="btn_canvas" class="btn btn-info col-md-12">show detail</button>
                        </div>
                        <div class="col-md-3">
                            <div id="canvas_ship_to_ship_d"></div>
                            <button id="btn_canvas_d" class="btn btn-success col-md-12">show detail</button>
                        </div>
                        <div class="col-md-3">
                            <div id="canvas_ship_to_ship_i"></div>
                            <button id="btn_canvas_i" class="btn btn-primary col-md-12">show detail</button>
                        </div>
                        <div class="col-md-3">
                            <div id="canvas_ship_to_ship_c"></div>
                            <button id="btn_canvas_c" class="btn btn-warning col-md-12">show detail</button>
                        </div>
                    </div><br><br>
                    <h2 id="title"></h2><br>
                    <table id="table" class="table table-striped table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <th>Ves ID</th>
                        <th>Ves Name</th>
                        <th>Ves ID Next</th>
                        <th>Ves Name Next</th>
                        <th>EST Depart VES1</th>
                        <th>EST Berth VES2</th>
                        <th>Diff EST</th>
                        <th>ACT Depart VES1</th>
                        <th>ACT Berth VES2</th>
                        <th>Diff ACT</th>
                        <th>Flag</th>
                      </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $(function(){
        runGraph('canvas_ship_to_ship', 0, 'ALL');
        runGraph('canvas_ship_to_ship_d', 0, 'DOMESTIC');
        runGraph('canvas_ship_to_ship_i', 0, 'INTERNATIONAL');
        runGraph('canvas_ship_to_ship_c', 0, 'DRY BULK');
    });

    $('#btn_submit').on('click', function () {
        get_ship_to_ship();
    })
    $('#btn_canvas').on('click', function () {
        $('#title').text("DETAIL ALL DERMAGA");
        refreshTable('A');
    })
    $('#btn_canvas_d').on('click', function () {
        $('#title').text("DETAIL DOMESTIC DERMAGA");
        get_ship_to_ship();
        refreshTable('D');
    })
    $('#btn_canvas_i').on('click', function () {
        $('#title').text("DETAIL INTERNATIONAL DERMAGA");
        get_ship_to_ship();
        refreshTable('I');
    })
    $('#btn_canvas_c').on('click', function () {
        $('#title').text("DETAIL DRY BULK DERMAGA");
        get_ship_to_ship();
        refreshTable('C');
    })

    function runGraph(canvas_ship_to_ship, value, title, color='#47c468') {
        $('#'+canvas_ship_to_ship).empty();
        // console.log(color);
        // console.log(canvas_ship_to_ship, color);
        new JustGage({
          id: canvas_ship_to_ship,
          value: value,
          min: 0,
          max: 50,
          levelColors: [color],
          title: title,
          label: "Hour"
        });
    }

  function refreshTable(ocean_interisland) {

    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();

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
        ajax: "{{url('Dashboard/json')}}/"+ocean_interisland+'/'+date_from+'/'+date_to,
        columns: [
          { data: 'ves_id', name: 'ves_id' },
          { data: 'ves_name', name: 'ves_name' },
          { data: 'ves_id_next', name: 'ves_id_next' },
          { data: 'ves_name_next', name: 'ves_name_next' },
          { data: 'ves1_est_dep_date', name: 'ves1_est_dep_date' },
          { data: 'ves2_est_berth_date', name: 'ves2_est_berth_date' },
          { data: 'diff_est', name: 'diff_est' },
          { data: 'ves1_dep_date', name: 'ves1_dep_date' },
          { data: 'ves2_berth_date', name: 'ves2_berth_date' },
          { data: 'diff', name: 'diff' },
          { 
            "data": "is_ship_to_ship",
            "render": function ( data, type, row ) {
                return row.is_ship_to_ship;
            }
          }
        ],
        "createdRow": function( row, data, dataIndex){
            if(data.is_ship_to_ship == 'Y'){
                $(row).css("background", "#7dffa4");
            } else {
                $(row).css("background", "#ffe18f");
            }
        }
    });
  }

    function get_ship_to_ship() {
        $.ajax({  
        url : "{{ url('Dashboard/get_ship_to_ship') }}",
        data: {
          "_token": "{{ csrf_token() }}",
          date_from : $('#date_from').val(),
          date_to : $('#date_to').val(),
        },
        type : "post",
        dataType : "json",
        async : false,
        success : function(result) {
            if(result.success) {
                var data = result.data;

                var color = '#47c468';
                var color_d = '#47c468';
                var color_i = '#47c468';
                var color_c = '#47c468';

                if(parseFloat(data.res)>parseFloat(data.param2))
                    color = '#f51905';
                if(parseFloat(data.res_d)>parseFloat(data.param3))
                    color_d = '#f51905';
                if(parseFloat(data.res_i)>parseFloat(data.param4))
                    color_i = '#f51905';
                if(parseFloat(data.res_c)>parseFloat(data.param5))
                    color_c = '#f51905';

                runGraph('canvas_ship_to_ship', data.res, 'ALL', color);
                runGraph('canvas_ship_to_ship_d', data.res_d, 'DOMESTIC', color_d);
                runGraph('canvas_ship_to_ship_i', data.res_i, 'INTERNATIONAL', color_i);
                runGraph('canvas_ship_to_ship_c', data.res_c, 'DRY BULK', color_c);
                // runGraph(result.data);
            }
        }
      });
    }

</script>

@endsection
