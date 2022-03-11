@extends('home.home')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/select2.min.css')}}"/>
<link rel="stylesheet" href="{{asset('asset/css/plugins/handsontable/handsontable.full.min.css')}}" />

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script src="{{asset('asset/js/plugins/select2.full.min.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/js/plugins/handsontable/handsontable.full.min.js')}}"></script>


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

        </div>
        <div class="panel-body">

          <div class="row">
            <div class="col-md-6 controls">
              <button type="button" class="btn ripple-infinite btn-round btn-3d btn-primary" id="save">
                <i class="fa fa-save"></i> Save data
              </button>
              <button type="button" class="btn ripple-infinite btn-round btn-3d btn-warning" id="print">
                <i class="fa fa-file"></i> Print PDF
              </button>
              <a href="{{url('EquipmentPlan/print_spk')}}" target="_blank" class="btn ripple-infinite btn-round btn-3d btn-warning" id="print_spk">
                <i class="fa fa-file-text"></i> Print SPK
              </a><br><br>
              <button type="button" class="btn ripple-infinite btn-round btn-3d btn-success" id="btn_resend_pdf">
                <i class="fa fa-send"></i> Send PDF
              </button>
              <button type="button" class="btn ripple-infinite btn-round btn-3d btn-info" id="btn_resend_spk">
                <i class="fa fa-send"></i> Send SPK
              </button>
              <button type="button" class="btn ripple-infinite btn-round btn-3d btn-default" id="load">
                <i class="fa fa-refresh"></i> Load Data
              </button>
            </div>
            <div class="col-md-6">
              Legend<br>
              <span class='badge' style='background:red'>A</span> : Alongside<br>
              <span class='badge' style='background:blue'>D</span> : Departed
            </div>
          </div>
          <br><br>

          <div id="div_legend"></div>

          <table class="table table-bordered">
            <thead>
              <th>Tanggal</th>
              <th>International</th>
              <th>Domestic</th>
              <th>Dry Bulk</th>
            </thead>
            <tbody id="table_ves_tbody">
            </tbody>
          </table>


          <h3 id="title"></h3>

          <div id="div_vessel" style="width: 2000px"></div>
          <br>
          <div class="controls">
            <button type="button" class="btn ripple-infinite btn-round btn-3d btn-primary" id="save_truck">
              <i class="fa fa-save"></i> Save Data
            </button>
            <button type="button" class="btn ripple-infinite btn-round btn-3d btn-default" id="load_truck" onclick="cellTruckRequired()">
              <i class="fa fa-refresh"></i> Cek data
            </button>
            <b><span style="margin-left: 100px;" id="truck_cell_count">SUM : 0</span></b>
          </div><br>
          <div id="div_truck" style="width: 2000px"></div>
          <!-- <div id="div_eq_group_crane"></div> -->
          <!-- <br> -->
          <!-- <div id="div_truck"></div> -->

        </div>
      </div>
    </div>  
  </div>
</div>

<div class="modal fade" id="modal_print"  role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Choose Signature</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
            <!-- <form role="form" enctype="multipart/form-data"> -->
            {{csrf_field()}}
            <div class="form-group">
                    <label class="col-form-label">Planning Manager: </label>
                    <select  id="planing_manager" class="form-control " data-live-search="true">
                            <!-- <option>-----------</option> -->
                    </select>
            </div>
            <div class="form-group">
                    <label class="col-form-label">Planner: </label>
                    <select  id="berth_planner" class="form-control " data-live-search="true">
                            <!-- <option>-----------</option> -->
                    </select>
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="print()">Print</button>
            </div>
            </form>
        </div>
        
        </div>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
  $('.opener-left-menu').trigger('click');
  getNodes(0, 'CRANE');
  getNodes(1, 'TRUCK');
  getVesBerth();
  getEq();
  getEqPlanHour();
  getEqTruckReady();
  getShiftMinMax();
  getSignature();
  initialHot();
  // getNodes(0)
});


const con_vessel    = document.querySelector('#div_vessel');
const con_truck     = document.querySelector('#div_truck');
const load          = document.querySelector('#load');
var hot             = null;
var hot_truck       = null;

var m_vessel        = [];
var m_ves           = null;
var m_label_jam     = [];
var m_start_rows    = 0;
var m_start_cols    = 49;
var m_crane         = [];
var m_crane_str     = [];
var m_hour          = [];
var m_hour_str      = [];
var m_tgl           = [];
var m_tgl_vessel    = [];
var m_nested_headers = [];
var m_nested_headers_hidden = [];
var m_allcell       = [];
var m_shift_min_max = [];

var m_truck             = [];
var m_truck_str         = [];
var m_start_rows_truck  = 7;
var m_start_cols_truck  = 50;
var m_nested_headers_truck = [];
// var m_truck  = [];

// var m_eq_group      = [];
var m_eq_ready      = [];
var m_eq_cur        = [];
var m_data_truck    = [];
var m_data_crane    = [];

getLabelJam();


function getNodes(eq_type, key='CRANE') {
  $.ajax({
      url :  "{{url('EquipmentPlan/getNodes')}}",
      type : "post",
      dataType : "json",
      data : {
          "_token": "{{ csrf_token() }}",
          eq_type: eq_type,
          eq_key: key,
      },
      async : false,
      success : function(result){
        if(result.success) {
          m_allcell[key] = result.data;
        }
      }
  });
}

function getVesBerth() {
  $.ajax({
      url :  "{{url('EquipmentPlan/getVesBerth')}}",
      type : "post",
      dataType : "json",
      data : {
          "_token": "{{ csrf_token() }}"
      },
      async : true,
      success : function(result){
        // console.log(result);
        if(result.success) {
          m_vessel = result.data;
          generateLegendColor();
        }
      }
  });
}

function getEq(key = "ALL") {
  $.ajax({
      url :  "{{url('EquipmentPlan/getEq')}}",
      type : "post",
      dataType : "json",
      data : {
          "_token": "{{ csrf_token() }}"
      },
      async : false,
      success : function(result){
        if(result.success) {
          m_crane = result.data_crane;
          m_truck = result.row_header_truck;
          m_allcell['TRUCK_DEF'] = result.data_truck;
          getArrayEq();
        }
      }
  });
}

function getEqPlanHour() {
  $.ajax({
      url :  "{{url('EquipmentPlan/getEqPlanHour')}}",
      type : "post",
      dataType : "json",
      data : {
          "_token": "{{ csrf_token() }}"
      },
      async : false,
      success : function(result){
        if(result.success) {
          m_hour = result.data;
          m_tgl = result.data_tgl;
          m_tgl_vessel = result.data_tgl_vessel;
          getArrayHour();
        }
      }
  });
}

function getEqTruckReady() {
  $.ajax({
      url :  "{{url('EquipmentPlan/getEqTruckReady')}}",
      type : "post",
      dataType : "json",
      data : {
          "_token": "{{ csrf_token() }}"
      },
      async : false,
      success : function(result){
        if(result.success) {
          m_eq_ready = result.data;
        }
      }
  });
}

function getShiftMinMax() {
  $.ajax({
      url :  "{{url('EquipmentPlan/getShiftMinMax')}}",
      type : "post",
      dataType : "json",
      data : {
          "_token": "{{ csrf_token() }}"
      },
      async : true,
      success : function(result){
        if(result.success) {
          m_shift_min_max = result.data;
        }
      }
  });
}

function getSignature() {
  $("#planing_manager").empty();
  $("#berth_planner").empty();
  $.ajax({  
      url : "{{route('getsignature')}}",
      type : "get",
      dataType : "json",
      async : true,
      success : function(result){
          var manager=result.man;
          var planner=result.plan;
          for (s = 1; s < manager.length+1; ++s) {
              $("#planing_manager").append('<option value="'+manager[s-1].nama+'">'+manager[s-1].nama+'</option>');  
          }
          for (x = 1; x < planner.length+1; ++x) {
              $("#berth_planner").append('<option value="'+planner[x-1].nama+'">'+planner[x-1].nama+'</option>');  
          } 
      } ,
      error: function(request, textStatus, errorThrown) {
          alert(request.responseJSON.message);
      }
  });
}

function generateLegendColor() {
  var data = [];

  $('#div_legend').empty();
  $('#div_legend').append('<button class="badge legend" '+
    'data_ves_id="" '+
    'data_urutan="-1" '+
    'data_color="none" '+
    'style="background: none; cursor:pointer; color:black">Hapus</button>');

  $.each(m_tgl_vessel, function (i, val) {
    html_inter = "";
    html_domes = "";
    html_cuker = "";
    $.each(m_vessel, function (j, row) {
      row.color = getGenerateColor(row.ves_name);
      var ebt = row.est_berth_ts_str;
      var arr_ebt = ebt.split(" ");

      if(row.act_berth_ts != null && row.act_dep_ts_str == null) {
        alongside = "<span class='badge' style='background:red'>A</span>";
      } else if(row.act_dep_ts_str != null) {
        alongside = "<span class='badge' style='background:blue'>D</span>";
      } else {
        alongside = "";
      }

      if(val.tgl_str == arr_ebt[0]) {
        if(row.ocean_interisland_fake == "I" && row.ves_type == 'CT') {
          html_inter += '<div class="badge legend" '+
              'data_ves_id="'+row.ves_id+'" '+
              'data_urutan="'+j+'" '+
              'data_color="'+row.color+'" '+
              'style="background: '+row.color+'; cursor:pointer;"> '+
                row.ves_name+' ('+row.ves_id+') <span class="badge" style="background:white; color:black">'+row.gen_no+"</span> "+
                alongside+
              '</div>';
        } else if(row.ocean_interisland_fake == "D" && row.ves_type == 'CT') {
          html_domes += '<div class="badge legend" '+
              'data_ves_id="'+row.ves_id+'" '+
              'data_urutan="'+j+'" '+
              'data_color="'+row.color+'" '+
              'style="background: '+row.color+'; cursor:pointer;">'+
                row.ves_name+' ('+row.ves_id+') <span class="badge" style="background:white; color:black">'+row.gen_no+"</span>"+
                alongside+
              '</div>';
        } else if(row.ves_type == 'GC') {
          html_cuker += '<div class="badge legend" '+
              'data_ves_id="'+row.ves_id+'" '+
              'data_urutan="'+j+'" '+
              'data_color="'+row.color+'" '+
              'style="background: '+row.color+'; cursor:pointer;">'+
                row.ves_name+' ('+row.ves_id+') <span class="badge" style="background:white; color:black">'+row.gen_no+"</span>"+
                alongside+
              '</div>';
        }
      }
    })
    var html = "<tr>"+"<td>"+val.tgl_str+"</td><td>"+html_inter+"</td><td>"+html_domes+"</td><td>"+html_cuker+"</td>";
    $('#table_ves_tbody').append(html);
  })

  initialClick();
}

function getArrayEq() {
  m_crane_str = [];
  $.each(m_crane, function (i, val) {
    m_crane_str.push(val.kode_alat);
  });
  m_start_rows = m_crane.length;


  m_truck_str = [];
  $.each(m_truck, function (i, val) {
    m_truck_str.push(val.eq_type);
  });
  m_start_rows_truck = m_truck.length;

}

function getArrayHour() {

  var nested_tgl = [];
  var nested_jam_id = [''];
  var nested_jam_str = [''];
  var nested_tgl_2 = [''];

  nested_tgl.push('Owner');

  $.each(m_tgl, function(i, val) {
    nested_tgl.push({label:val.tgl_str, colspan:parseInt(val.jum)});
  });

  $.each(m_hour, function(i, val) {
    nested_jam_id.push(val.jam_id);
    nested_jam_str.push(val.jam_str);
    nested_tgl_2.push(val.tgl_str);
  });

  m_nested_headers.push(nested_tgl);
  m_nested_headers.push(nested_jam_id);

  m_nested_headers_hidden.push(nested_tgl);
  m_nested_headers_hidden.push(nested_jam_str);
  m_nested_headers_hidden.push(nested_tgl_2);

  m_start_cols = nested_jam_id.length;
  m_start_cols_truck = nested_jam_id.length+2;

  m_nested_headers_truck = JSON.parse(JSON.stringify(m_nested_headers));

  // m_nested_headers_truck[0][0] = "Armada";
  m_nested_headers_truck[0].splice(0,1);
  m_nested_headers_truck[1].splice(0,1);
  m_nested_headers_truck[0].splice(0, 0, "Jumlah");
  m_nested_headers_truck[1].splice(0, 0, "");
  m_nested_headers_truck[0].splice(1, 0, "Kesiapan");
  m_nested_headers_truck[1].splice(1, 0, "");

}

function getGenerateColor(str) {
  var hash = 0;
  for (var i = 0; i < str.length; i++) {
    hash = str.charCodeAt(i) + ((hash << 5) - hash);
  }
  var colour = '#';
  for (var i = 0; i < 3; i++) {
    var value = (hash >> (i * 8)) & 0xFF;
    colour += ('00' + value.toString(16)).substr(-2);
  }
  return colour;
}

function getLabelJam() {
  m_label_jam = [''];
  for (var i = 0; i < 24; i++) {
    m_label_jam.push((i<10 ? '0'+i : ''+i));
  }
  for (var i = 0; i < 24; i++) {
    m_label_jam.push((i<10 ? '0'+i : ''+i));
  }
}

function initialClick() {
  $('.legend').on('click', function () {
    var urutan = $(this).attr('data_urutan');
    if(parseInt(urutan)>= 0) {
      m_ves = m_vessel[urutan];
      $('#title').text('Draw : '+m_ves.ves_name+" ("+m_ves.ves_id+") - Remain B/M : "+m_ves.disc_remain+"/"+m_ves.load_remain);
    }
    else {
      m_ves = null;
      $('#title').text('Hapus')
    }
  })
}

// function initialClickCustomLegend(key) {
//   $('.legend'+key).on('click', function () {
//     var urutan = $(this).attr('data_urutan');
//     var ves_id = $(this).attr('data_ves_id');
//     console.log("urutan", urutan);
//     if(parseInt(urutan)>= 0) {
//       m_ves         = m_vessel[getIndexVessel(ves_id)];
//       m_eq_cur[key] = m_eq_group[urutan];
//       console.log("test");
//       // $('#title').text('Draw : '+m_ves.ves_name+" ("+m_ves.ves_id+")")
//     }
//     else {
//       m_ves = null;
//       // $('#title').text('Hapus')
//     }
//   })
// }

function getIndexVessel(ves_id) {
  var index = 0;
  $.each(m_vessel, function(i, val) {
    if(val.ves_id == ves_id) {
      index = i;
      return;
    }
  });
  return index;
}

function getAllCells(key = 'CRANE') {
  var allcell = [];
  var cur_hot = getHotByKey(key);
  var eq_type = getEqTypeByKey(key);
  var count_row = getCountRowByKey(key);
  var count_col = getCountColByKey(key);
  for(var row=0; row<count_row; row++) {
    for(var col=0; col<count_col; col++) {
      var cell = cur_hot.getCell(row, col);
      if(cell != null) {
        if(cell.style.ves_id != null) {
          var plan_date = getDateByCol(col);
          var plan_time = getTimeByCol(col);
          var eq_id = getEqByRow(row, key);
          allcell.push({
            y: row, 
            x: col, 
            ves_id: cell.style.ves_id,
            eq_id: eq_id,
            eq_type: eq_type,
            plan_date: plan_date,
            plan_date_str: plan_date,
            plan_time: plan_time,
            color_code: cell.style.color_code,
          });
        }
      }
    }
  }
  m_allcell[key] = allcell;
  return allcell;
}

function getEqByRow(row, key = 'CRANE') {
  var value = '';
  var eq_str = getEqStrByKey(key);
  $.each(eq_str, function (i, val) {
    if(row == i) {
      value = val;
      return;
    }
  })
  return value;
}

function getTimeByCol(col) {
  var value = '';
  $.each(m_nested_headers_hidden[1], function (i, val) {
    if(col == i) {
      value = val;
      return false;
    }
  })
  return value;
}

function getDateByCol(col) {
  var arr_tgl = m_nested_headers_hidden[2];
  return arr_tgl[col];
}

$('#save').on('click', function() {
  if(confirm('Apakah anda yakin ingin menyimpan data ini?')) {
    var nodes = getAllCells();
    // nodes.push(...getAllCells('TRUCK'));
    // console.log(nodes);
    $.ajax({
        url :  "{{url('EquipmentPlan/save')}}",
        type : "post",
        dataType : "json",
        data : {
            "_token": "{{ csrf_token() }}",
            nodes : nodes,
        },
        async : true,
        success : function(result){
          if(result.success) {
            swal({
              title: result.success ? 'Success' : 'Failed',
              text: result.message,
              icon: result.success ? "success" : 'warning',
              button: "Oke",
            });

            // getNodes(1, 'TRUCK');
            getEq();
            // initHotTruck();
            updateDataTruck();
          }
        }
    });
  }
});

$('#load').on('click', function() {
  getAllCells();
  updateColor('CRANE');
});

$('#print').on('click', function () {
  $('#modal_print').modal('show');
})

function print() {
  var planing_manager = $('#planing_manager').val();
  var berth_planner = $('#berth_planner').val();
  window.open("{{url('EquipmentPlan/print')}}/"+moment(new Date()).format('DD-MM-YYYY')+'/'+planing_manager+'/'+berth_planner, '_blank');
}

$('#save_truck').on('click', function () {
  if(confirm('Apakah anda yakin ingin menyimpan data ini?')) {
    var data = hot_truck.getData();

    if(validateSaveTruck(data)) {
      var nest = m_nested_headers_truck[0];
      var nested_date = [];
      nested_date.push(nest[2]);
      nested_date.push(nest[3]);

      var nested_time = m_nested_headers_truck[1];

      $.ajax({
        url :  "{{url('EquipmentPlan/saveTruck')}}",
        type : "post",
        dataType : "json",
        data : {
            "_token": "{{ csrf_token() }}",
            nodes : data,
            nested_date : nested_date,
            nested_time : nested_time,
            nested_row : m_truck_str,
        },
        async : true,
        success : function(result){
          if(result.success) {
            swal({
              title: result.success ? 'Success' : 'Failed',
              text: result.message,
              icon: result.success ? "success" : 'warning',
              button: "Oke",
            });
          }
        }
      });
    } else {
      swal({
        title: "Failed",
        text: "Cek lagi plan anda, data tidak boleh minus",
        icon: "warning",
        button: "Oke",
      });
    }
  }

})

function initHotCrane() {
  hot = new Handsontable(con_vessel, {
    colHeaders: false,
    rowHeaders: m_crane_str,
    height: 'auto',
    startRows: m_start_rows,
    startCols: m_start_cols,
    manualColumnResize: true,
    manualRowResize: true,
    nestedHeaders: m_nested_headers,
    licenseKey: 'non-commercial-and-evaluation',
    colWidths(index) {
      if(index>0)
        return 40;
      else 
        return 160;
    },
    rowHeights(index) {
      return 20;
    },
    rowHeaderWidth:100,
  });

  hot.addHook('afterOnCellMouseUp', function(e,coords){
    // console.log(coords);
    if(coords.row >= 0 && coords.col >= 0) {
      data = hot.getSelected()[0];

      var y1 = data[0];
      var x1 = data[1];
      var y2 = data[2];
      var x2 = data[3];

      var a1 = (y1 < y2 ? y1 : y2);
      var b1 = (x1 < x2 ? x1 : x2);
      var a2 = (y1 > y2 ? y1 : y2);
      var b2 = (x1 > x2 ? x1 : x2);

      if(a1>=0 && a2>=0 && b1>=0 && b2>=0) {
        for (a1=a1; a1<=a2; a1++) {
          for(b1=b1; b1<=b2; b1++) {
            if(b1 != 0) {
              var cell = hot.getCell(a1,b1); 
              if(m_ves != null) {
                cell.style.background = m_ves.color;
                cell.style.color_code = m_ves.color;
                cell.style.ves_id = m_ves.ves_id;
              } else {
                cell.style.background = null;
                cell.style.ves_id = null;
              }
            }
          }
          b1 = (x1 < x2 ? x1 : x2);
        }
      }

      getAllCells();
      updateColor();
    }
  });

  setTimeout(function () {
    updateColor('CRANE');
  }, 200)

}

function initHotTruck() {

  hot_truck = new Handsontable(con_truck, {
    // data:m_data_truck,
    colHeaders: false,
    rowHeaders: m_truck_str,
    height: 'auto',
    startRows: m_start_rows_truck,
    startCols: m_start_cols_truck,
    manualColumnResize: true,
    manualRowResize: true,
    nestedHeaders: m_nested_headers_truck,
    licenseKey: 'non-commercial-and-evaluation',
    colWidths(index) {
      if(index>1)
        return 40;
      else 
        return 80;
    },
    rowHeights(index) {
      return 20;
    },
    rowHeaderWidth:100,
  });

  updateDataTruck();

  hot_truck.addHook('afterChange', function(e,coords){

    if(coords == 'edit' || coords == 'Autofill.fill') {

        var arr_req = m_data_truck[m_idx_req];

        if(arr_req.length <= 1) {
          for (i = 0; i < m_hour.length; i++) {
            arr_req.push(0);
          }
        }

        if(e[0][1] == 1 && e[0][0] >=2 && e[0][0] <=5) {
          var arr = m_data_truck[e[0][0]];
          val = hot_truck.getDataAtCell(e[0][0], e[0][1]);
          for(var i=0; i<m_hour.length; i++) {
            arr[i+2] = val;
          }
          m_data_truck.splice(e[0][0], 1, arr);
        }

        $.each(e, function (i, val) {
          ctt = m_data_truck[m_idx_ctt][val[1]];
          ht = m_data_truck[m_idx_ht][val[1]];
          tb = m_data_truck[m_idx_tb][val[1]];
          tt = m_data_truck[m_idx_tt][val[1]];
          tt_bds = hot_truck.getDataAtCell(m_idx_tt_bds, 1);
          ht_bds = hot_truck.getDataAtCell(m_idx_ht_bds, 1);
          req = hot_truck.getDataAtCell(m_idx_req, val[1]);
          truck = hot_truck.getDataAtCell(1, val[1]);
          bmc_ht = hot_truck.getDataAtCell(m_idx_tt_bds, val[1]);
          h_bmc_ht = hot_truck.getDataAtCell(m_idx_bmc_ht, 1);
          h_bst_ht = hot_truck.getDataAtCell(m_idx_bst_ht, 1);
          h_bst_lowbed = hot_truck.getDataAtCell(m_idx_bst_lowbed, 1);

          if(val[1] > 1 && val[0] >= 2 && val[0]<=5) {

            ctt = parseInt(ctt ? ctt : 0);
            ht = parseInt(ht ? ht : 0);
            tb = parseInt(tb ? tb : 0);
            tt = parseInt(tt ? tt : 0);
            tt_bds = parseInt(tt_bds ? tt_bds : 0);
            ht_bds = parseInt(ht_bds ? ht_bds : 0);
            truck = parseInt(truck ? truck : 0);

            jum = ctt+ht+tb+tt;
            bds_tt = (truck-jum) <= tt_bds ? ((truck-jum) >= 0 ? (truck-jum) : 0) : tt_bds;
            bds_ht = (truck-jum-bds_tt) <= ht_bds ? ((truck-jum-bds_tt) >= 0 ? (truck-jum-bds_tt) : 0) : ht_bds;
            bds_req = (truck-jum-bds_tt-bds_ht) <= bds_tt+bds_ht ? ((truck-jum-bds_tt-bds_ht) >= 0 ? (truck-jum-bds_tt-bds_ht) : 0) : bds_tt+bds_ht;

            // hot_truck.setDataAtCell(m_idx_req, val[1], req);

            var arr = m_data_truck[m_idx_tt_bds];
            arr.splice(val[1], 1, bds_tt);
            m_data_truck.splice(m_idx_tt_bds, 1, arr);

            var arr = m_data_truck[m_idx_ht_bds];
            arr.splice(val[1], 1, bds_ht);
            m_data_truck.splice(m_idx_ht_bds, 1, arr);

            var arr = m_data_truck[m_idx_req];
            arr.splice(val[1], 1, bds_req);
            m_data_truck.splice(m_idx_req, 1, arr);

            sisa_bds = truck-jum-tt_bds-ht_bds;
            bmc_ht          = sisa_bds >= h_bmc_ht ? h_bmc_ht : sisa_bds;
            sisa_bmc_ht     = sisa_bds - bmc_ht;
            bst_ht          = sisa_bmc_ht >= h_bst_ht ? h_bst_ht : sisa_bmc_ht;
            sisa_bst_ht     = sisa_bmc_ht - bst_ht;
            bst_lowbed      = sisa_bst_ht >= h_bst_lowbed ? h_bst_lowbed : sisa_bst_ht;

            bmc_ht          = bmc_ht>0 ? bmc_ht : 0;
            bst_ht          = bst_ht>0 ? bst_ht : 0;
            bst_lowbed      = bst_lowbed>0 ? bst_lowbed : 0;

            var arr1 = m_data_truck[m_idx_bmc_ht];
            arr1.splice(val[1], 1, bmc_ht);
            m_data_truck.splice(m_idx_bmc_ht, 1, arr1);

            var arr2 = m_data_truck[m_idx_bst_ht];
            arr2.splice(val[1], 1, bst_ht);
            m_data_truck.splice(m_idx_bst_ht, 1, arr2);

            var arr3 = m_data_truck[m_idx_bst_lowbed];
            arr3.splice(val[1], 1, bst_lowbed);
            m_data_truck.splice(m_idx_bst_lowbed, 1, arr3);


            var tot = parseInt(ctt) + 
                      parseInt(ht) + 
                      parseInt(tb) + 
                      parseInt(tt) + 
                      parseInt(req) + 
                      parseInt(bmc_ht) + 
                      parseInt(bst_ht) + 
                      parseInt(bst_lowbed);

            var arr4 = m_data_truck[m_idx_kekurangan];
            arr4.splice(val[1], 1, (parseInt(truck)-tot)>=0 ? (parseInt(truck)-tot) : 0);
            m_data_truck.splice(m_idx_kekurangan, 1, arr4);

            var arr5 = m_data_truck[m_idx_total];
            arr5.splice(val[1], 1, tot);
            m_data_truck.splice(m_idx_total, 1, arr5);

          } else if(val[1] > 1) {

            bmc_ht = hot_truck.getDataAtCell(m_idx_bmc_ht, val[1]);
            bst_ht = hot_truck.getDataAtCell(m_idx_bst_ht, val[1]);
            bst_lowbed = hot_truck.getDataAtCell(m_idx_bst_lowbed, val[1]);

            var tot = parseInt(ctt) + 
                      parseInt(ht) + 
                      parseInt(tb) + 
                      parseInt(tt) + 
                      parseInt(req) + 
                      parseInt(bmc_ht) + 
                      parseInt(bst_ht) + 
                      parseInt(bst_lowbed);

            var arr4 = m_data_truck[m_idx_kekurangan];
            arr4.splice(val[1], 1, (parseInt(truck)-tot)>=0 ? (parseInt(truck)-tot) : 0);
            m_data_truck.splice(m_idx_kekurangan, 1, arr4);
            
            var arr5 = m_data_truck[m_idx_total];
            arr5.splice(val[1], 1, tot);
            m_data_truck.splice(m_idx_total, 1, arr5);

          }
        })

        if(e[0][0] != m_idx_req && e[0][1] > 1) {
          var arr_tt_bds = m_data_truck[m_idx_tt_bds];
          var arr_ht_bds = m_data_truck[m_idx_ht_bds];
          var arr_req = m_data_truck[m_idx_req];

          $.each(m_shift_min_max, function (i, val) {
            var max = 0;
            $.each(arr_tt_bds, function (j, row) {
              if(j>1) {
                if(parseInt(val.max_x)+1 >= j && j >= parseInt(val.min_x)+1) {
                  if(parseInt(row) > parseInt(max)) {
                    max = parseInt(row) + parseInt(arr_ht_bds[j]);
                  }
                }
              }
            })

            $.each(arr_req, function (j, row) {
              if(parseInt(val.max_x)+1 >= j && j >= parseInt(val.min_x)+1) {
                arr_req.splice(parseInt(j), 1, max);
              }
            })
          });

          m_data_truck.splice(m_idx_req, 1, arr_req);

        }

        hot_truck.loadData(m_data_truck);

        setTimeout(function () {
          // console.log("testinggg");
          cellTruckRequired();
        }, 100);
      // } else {
      // }
      // } else if(is_run == 0) {
      //   console.log('gagal');
      // }
      // console.log("testing");
    }
    // console.log('row', coords.row);
    // console.log('col', coords.col);
  });


  hot_truck.addHook('afterOnCellMouseUp', function(e,coords){
    if(coords.row >= 0 && coords.col >= 0) {
      data = hot_truck.getSelected()[0];

      var y1 = data[0];
      var x1 = data[1];
      var y2 = data[2];
      var x2 = data[3];

      var a1 = (y1 < y2 ? y1 : y2);
      var b1 = (x1 < x2 ? x1 : x2);
      var a2 = (y1 > y2 ? y1 : y2);
      var b2 = (x1 > x2 ? x1 : x2);

      var jum = 0;

      if(a1>=0 && a2>=0 && b1>=0 && b2>=0) {
        for (a1=a1; a1<=a2; a1++) {
          for(b1=b1; b1<=b2; b1++) {
            // if(b1 != 0) {
              var cell = hot_truck.getDataAtCell(a1,b1); 
              jum += parseInt(cell);
            // }
          }
          b1 = (x1 < x2 ? x1 : x2);
        }
      }

      // console.log(jum);
      $("#truck_cell_count").text("Sum : "+jum);
    }
  });

}

function initialHot() {
  initHotCrane();
  initHotTruck();
}

function getGenNo(vessels, ves_id) {
  var gen_no = '';
  $.each(vessels, function (j, row) {
    if(row.ves_id == ves_id) {
      gen_no = row.gen_no;
      return;
    }
  });
  return gen_no;
}

function updateColor(key='CRANE') {
  
  var cur_hot = getHotByKey(key);

  m_data_crane = [];

  for(i=0; i<m_start_rows; i++) {
    var arr = [];
    arr.push("");
    $.each(m_hour, function(i, val) {
      arr.push("");
    });
    m_data_crane.push(arr);
  }
  $.each(m_allcell[key], function (i, val) {
    var arr = m_data_crane[parseInt(val.y)];
    arr.splice(val.x, 1, getGenNo(m_vessel, val.ves_id));
    m_data_crane[parseInt(val.y)] = arr;
  });

  cur_hot.loadData(m_data_crane);

  $.each(m_allcell[key], function (i, val) {
    var cell = cur_hot.getCell(parseInt(val.y), parseInt(val.x));
    if(cell != null) {
      cell.style.background = val.color_code; 
      cell.style.color_code = val.color_code;
      cell.style.ves_id = val.ves_id;
    }
  });
}

function updateDataTruck(key = 'TRUCK') {

  var cur_hot = getHotByKey(key);

  setKesiapan();

  var arr_sts   = ['', ''];
  var arr_truck = ['', ''];
  var arr_ctt = [m_eq_ready[m_idx_ctt-2].jum, m_eq_ready[m_idx_ctt-2].kesiapan];
  var arr_ht = [m_eq_ready[m_idx_ht-2].jum, m_eq_ready[m_idx_ht-2].kesiapan];
  var arr_tb = [m_eq_ready[m_idx_tb-2].jum, m_eq_ready[m_idx_tb-2].kesiapan];
  var arr_tt = [m_eq_ready[m_idx_tt-2].jum, m_eq_ready[m_idx_tt-2].kesiapan];
  var arr_tt_bds = [m_eq_ready[4].jum, m_eq_ready[4].kesiapan];
  var arr_ht_bds = [m_eq_ready[5].jum, m_eq_ready[5].kesiapan];
  var arr_req = [m_eq_ready[6].jum, ''];
  var arr_bmc_ht = [m_eq_ready[7].jum, m_eq_ready[7].kesiapan];
  var arr_bst_lowbed = [m_eq_ready[8].jum, m_eq_ready[8].kesiapan];
  var arr_bst_ht = [m_eq_ready[9].jum, m_eq_ready[9].kesiapan];
  var arr_kekurangan = ['', ''];
  var arr_total = ['', ''];

  $.each(m_allcell[key+'_DEF'], function (i, val) {
    $.each(m_truck_str, function (t, truck) {
      if(truck == 'STS') {
        arr_sts.push(val.jum_v);
      } else if(truck == 'TRUCK') {
        arr_truck.push(val.jum_t);
      }
    })
  });

  if(m_allcell[key].length > 0) {

    $.each(m_allcell[key], function (i, val) {
      if(val.y == m_idx_ctt) {
        arr_ctt.push(val.plan_count);
      } else if(val.y == m_idx_ht) {
        arr_ht.push(val.plan_count);
      } else if(val.y == m_idx_tb) {
        arr_tb.push(val.plan_count);
      } else if(val.y == m_idx_tt) {
        arr_tt.push(val.plan_count);
      } else if(val.y == m_idx_tt_bds) {
        arr_tt_bds.push(val.plan_count);
      } else if(val.y == m_idx_ht_bds) {
        arr_ht_bds.push(val.plan_count);
      } else if(val.y == m_idx_req) {
        arr_req.push(val.plan_count);
      } else if(val.y == m_idx_bmc_ht) {
        arr_bmc_ht.push(val.plan_count);
      } else if(val.y == m_idx_bst_lowbed) {
        arr_bst_lowbed.push(val.plan_count);
      } else if(val.y == m_idx_bst_ht) {
        arr_bst_ht.push(val.plan_count);
      }
    });

    $.each(arr_truck, function (i, val) {
      if(i>1) {
        var tot = parseInt(arr_ctt[i]) + 
                  parseInt(arr_ht[i]) + 
                  parseInt(arr_tb[i]) + 
                  parseInt(arr_tt[i]) + 
                  parseInt(arr_req[i]) + 
                  parseInt(arr_bmc_ht[i]) + 
                  parseInt(arr_bst_ht[i]) + 
                  parseInt(arr_bst_lowbed[i]);
        arr_total.push(tot);
        arr_kekurangan.push((val-tot) >= 0 ? (val-tot) : 0);
      }
    })

  } else {

  }

  m_data_truck = [arr_sts, arr_truck, arr_tt, arr_tb, arr_ht, arr_ctt, arr_tt_bds, arr_ht_bds, arr_req, arr_bmc_ht, arr_bst_lowbed, arr_bst_ht, arr_total, arr_kekurangan];
  hot_truck.loadData(m_data_truck);

  hot_truck.updateSettings({
    cells(row, col) {
      const cellProperties = {};

      if (col>1 && (row == 6 || row == 7 || row == 0 || row == 1 || row == 11 || row == 12)) {
        cellProperties.readOnly = true;
      }

      return cellProperties;
    }
  });

  cellTruckRequired();

  // var cur_hot = getHotByKey(key);
  // if(m_allcell[key].length > 0) {
  //   $.each(m_allcell[key], function (i, val) {
  //     hot_truck.setDataAtCell(parseInt(val.y), parseInt(val.x), val.plan_count);
  //   });
  //   $.each(m_eq_ready, function (i, val) {
  //     $.each(m_truck_str, function (t, truck) {
  //       if(truck == val.jenis) {
  //         hot_truck.setDataAtCell(t, 0, val.jum);
  //       }
  //       if(truck == 'BDS') {
  //         m_idx_tt_bds = t;
  //       } else if(truck == 'REQ') {
  //         m_idx_req = t;
  //       } else if(truck == 'BMC_HT') {
  //         m_idx_bmc_ht = t;
  //       } else if(truck == 'BST_HT') {
  //         m_idx_bst_ht = t;
  //       } else if(truck == 'BST_LOWBED') {
  //         m_idx_bst_lowbed = t;
  //       }
  //     })
  //   })
  // } else {
  //   $.each(m_allcell[key+'_DEF'], function (i, val) {
  //     $.each(m_truck_str, function (t, truck) {
  //       if(truck == 'STS') {
  //         hot_truck.setDataAtCell(t, i+1, val.jum_v);
  //       } else if(truck == 'TRUCK') {
  //         hot_truck.setDataAtCell(t, i+1, val.jum_t);
  //       }
  //     })
  //   });

  //   $.each(m_eq_ready, function (i, val) {
  //     $.each(m_truck_str, function (t, truck) {
  //       if(truck == val.jenis) {
  //         hot_truck.setDataAtCell(t, 0, val.jum);
  //       }
  //       if(truck == 'BDS') {
  //         m_idx_tt_bds = t;
  //       } else if(truck == 'REQ') {
  //         m_idx_req = t;
  //       } else if(truck == 'BMC_HT') {
  //         m_idx_bmc_ht = t;
  //       } else if(truck == 'BST_HT') {
  //         m_idx_bst_ht = t;
  //       } else if(truck == 'BST_LOWBED') {
  //         m_idx_bst_lowbed = t;
  //       }
  //     })
  //   })

  //   cellTruckRequired();
  // }
}

function setKesiapan() {
  $.each(m_eq_ready, function (i, val) {
    $.each(m_truck_str, function (t, truck) {
      if(truck == val.jenis) {
        hot_truck.setDataAtCell(t, 0, val.jum);
      }

      if(i == 0) {
        if(truck == 'CTT') {
          m_idx_ctt = t;
        }else if(truck == 'HT') {
          m_idx_ht = t;
        }else if(truck == 'TB') {
          m_idx_tb = t;
        }else if(truck == 'TT') {
          m_idx_tt = t;
        } else if(truck == 'TT_BDS') {
          m_idx_tt_bds = t;
        } else if(truck == 'HT_BDS') {
          m_idx_ht_bds = t;
        } else if(truck == 'REQ') {
          m_idx_req = t;
        } else if(truck == 'BMC_HT') {
          m_idx_bmc_ht = t;
        } else if(truck == 'BST_LOWBED') {
          m_idx_bst_lowbed = t;
        } else if(truck == 'BST_HT') {
          m_idx_bst_ht = t;
        } else if(truck == 'KEKURANGAN') {
          m_idx_kekurangan = t;
        } else if(truck == 'TOTAL') {
          m_idx_total = t;
        }
      }

    })
  })
}

function validateSaveTruck(data) {
  var is_valid = true;
  $.each(data, function (i, val) {
    $.each(val, function (j, row) {
      if(parseInt(row) < 0) {
        is_valid = false;
        return;
      }
    })
    if(!is_valid) {
      return;
    }
  })
  return is_valid;
}

function cellTruckRequired() {
  for(var i=0; i<m_start_rows_truck; i++) {
    // data = hot_truck.getDataAtCell(i, 0);

    $.each(m_hour, function (j, val) {
      // if(j > 0) {

        if(j <= 1) {
          if(i >=2 && i<=5) {
            cell = hot_truck.getCell(i, j);
            if(cell != null)
              cell.style.background = '#fff952';
          }
        }

        var k = j+2;
        data = hot_truck.getDataAtCell(i, k);
        data = parseInt(data ? data : 0);

        cell = hot_truck.getCell(i, k);

        if(cell != null) {
          if(i == 0 || i == 1) {
            cell.style.background = '#cccccc';
          } else if(i >=2 && i<=5) {
            // if(data >= 0) {
              cell.style.background = '#fff952';
            // } else {
            //   cell.style.background = '#ff5f3b';
            // }
          } else if(i == 6 || i == 7) {
            cell.style.background = '#cccccc';
            // cell.readOnly = true;
          } else if(i == 8) {
            var color = val.shift == 1 ? '#ffa3fd' : val.shift == 2 ? '#a9fcec' : val.shift == 3 ? '#9cc5ff' : val.shift == 4 ? '#a8ffab' : '';
            cell.style.background = color;
          } else if(i == 12) {

            data_truck = hot_truck.getDataAtCell(1, k);
            data_truck = parseInt(data_truck ? data_truck : 0);
            
            if(data >= data_truck) {
              cell.style.background = '#cccccc';
            } else {
              cell.style.background = '#ff5f3b';
            }
          } else if(i == 13) {
            if(data <= 0) {
              cell.style.background = '#cccccc';
            } else {
              cell.style.background = '#ff5f3b';
            }
          }
        }
        if(i >=2 && i<=6) {
          if(data < 0 && cell != null) {
            cell.style.background = '#ff5f3b';
          }
        }
      // }
    })
  }
}

var m_idx_ctt = 0;
var m_idx_ht = 0;
var m_idx_tb = 0;
var m_idx_tt = 0;
var m_idx_tt_bds = 0;
var m_idx_ht_bds = 0;
var m_idx_req = 0;
var m_idx_bmc_ht = 0;
var m_idx_bst_ht = 0;
var m_idx_bst_lowbed = 0;
var m_idx_kekurangan = 0;
var m_idx_total = 0;


function getHotByKey(key = 'CRANE') {
  var cur_hot = null;
  if(key == 'CRANE') {
    cur_hot = hot;
  } else if(key == 'TRUCK') {
    cur_hot = hot_truck;
  }
  return cur_hot;
}

function getEqTypeByKey(key = 'CRANE') {
  var eq_type = 0;
  if(key == 'CRANE') {
    eq_type = 0;
  } else if(key == 'TRUCK') {
    eq_type = 1;
  }
  return eq_type;
}

function getEqStrByKey(key = 'CRANE') {
  var eq_str = [];
  if(key == 'CRANE') {
    eq_str = m_crane_str;
  } else if(key == 'TRUCK') {
    eq_str = m_truck_str;
  }
  return eq_str;
}

function getCountRowByKey(key = 'CRANE') {
  var row = 0;
  if(key == 'CRANE') {
    row = m_start_rows;
  } else if(key == 'TRUCK') {
    row = m_start_rows_truck;
  }
  return row;
}

function getCountColByKey(key = 'CRANE') {
  var col = 0;
  if(key == 'CRANE') {
    col = m_start_cols;
  } else if(key == 'TRUCK') {
    col = m_start_cols_truck;
  }
  return col;
}


$('#btn_resend_pdf').on('click', function () {
    if(confirm('Are you sure to resend pdf?')) {
        $.ajax({  
            url : "https://tower.teluklamong.co.id/index.php/service/vier_eqp_send_pdf/"+"{{session('nipp')}}",
            type : "get",
            dataType : "json",
            async : true,
            success : function(result){
                swal({
                    title: result.message,
                    text: result.message,
                    icon: result.success ? "success" : "danger",
                    button: "Oke",
                });
            },
            error: function(request, textStatus, errorThrown) {
                alert(request.responseJSON.message);
            }
        });
        setTimeout(function () {
            swal({
                title: 'Sukses',
                text: 'Sukses',
                icon: "success",
                button: "Oke",
            });
        }, 2000)
    }
})


$('#btn_resend_spk').on('click', function () {
    if(confirm('Are you sure to resend pdf?')) {
        $.ajax({  
            url : "https://tower.teluklamong.co.id/index.php/service/vier_eqp_send_spk/"+"{{session('nipp')}}",
            type : "get",
            dataType : "json",
            async : true,
            success : function(result){
                swal({
                    title: result.message,
                    text: result.message,
                    icon: result.success ? "success" : "danger",
                    button: "Oke",
                });
            },
            error: function(request, textStatus, errorThrown) {
                alert(request.responseJSON.message);
            }
        });
        setTimeout(function () {
            swal({
                title: 'Sukses',
                text: 'Sukses',
                icon: "success",
                button: "Oke",
            });
        }, 2000)
    }
})


</script>
@endsection