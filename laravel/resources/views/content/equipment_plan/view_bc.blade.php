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

          <div class="controls">
            <button id="load" class="button button--primary button--blue">Load data</button>&nbsp;
            <button id="save" class="button button--primary button--blue">Save data</button>
          </div><br><br>

          <div id="div_legend"></div>

          <table class="table table-bordered">
            <thead>
              <th>Tanggal</th>
              <th>Vessel</th>
            </thead>
            <tbody id="table_ves_tbody">
            </tbody>
          </table>


          <h3 id="title"></h3>

          <div id="div_vessel"></div>
          <br><br>
          <div id="div_eq_group_crane"></div>
          <br>
          <div id="div_truck"></div>

        </div>
      </div>
    </div>  
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  getNodes(0, 'CRANE');
  getNodes(1, 'TRUCK');
  getVesBerth();
  getEq();
  getEqPlanHour();
  initialHot();
  getEqGroup('CRANE');

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
var m_nested_headers = [];
var m_nested_headers_hidden = [];
var m_allcell       = [];

var m_truck             = [];
var m_truck_str         = [];
var m_start_rows_truck  = 0;
var m_start_cols_truck  = 49;

var m_eq_group      = [];
var m_eq_cur        = [];

getLabelJam();


function getNodes(eq_type, key='CRANE') {
  $.ajax({
      url :  "{{url('EquipmentPlan/getNodes')}}",
      type : "post",
      dataType : "json",
      data : {
          "_token": "{{ csrf_token() }}",
          eq_type: eq_type
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
        if(result.success) {
          m_vessel = result.data;
          generateLegendColor();
        }
      }
  });
}

function getEq() {
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
          m_truck = result.data_truck;
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
          getArrayHour();
        }
      }
  });
}

function getEqGroup(key = 'CRANE') {
  $.ajax({
    url :  "{{url('EquipmentPlan/getEqGroup')}}",
    type : "post",
    dataType : "json",
    data : {
        "_token": "{{ csrf_token() }}",
        eq_type: getEqTypeByKey(key),
    },
    async : false,
    success : function(result){
      if(result.success) {
        m_eq_group[key] = result.data;
        generateEqGroup(key);
      }
    }
  });
}

function generateEqGroup(key = 'CRANE') {
  $('#div_eq_group_crane').empty();
  var html = "";
  $.each(m_eq_group[key], function (j, row) {
    row.color = getGenerateColor(row.ves_name);
    row.color_eq = getGenerateColor(row.ves_name+row.eq_id);
    html += '<div class="badge legend'+key+'" '+
          'data_ves_id="'+row.ves_id+'" '+
          'data_urutan="'+j+'" '+
          'data_color="'+row.color+'" '+
          'style="background: '+row.color+'; cursor:pointer;">'+
            row.ves_id+' <span class="badge" style="background:'+row.color_eq+'">('+row.eq_id+')</span>'+
          '</div>';
  });
  $('#div_eq_group_crane').append(html);
  initialClickCustomLegend(key);
}

function generateLegendColor() {
  var data = [];

  $('#div_legend').empty();
  $('#div_legend').append('<button class="badge legend" '+
    'data_ves_id="" '+
    'data_urutan="-1" '+
    'data_color="none" '+
    'style="background: none; cursor:pointer; color:black">Hapus</button>');

  $.each(m_tgl, function (i, val) {
    var html = "<tr>"+"<td>"+val.tgl_str+"</td><td>";
    $.each(m_vessel, function (j, row) {
      row.color = getGenerateColor(row.ves_name);
      // row.cells = [];
      // console.log(val.tgl_str, row.est_berth_str);
      if(val.tgl_str == row.est_berth_str) {
        html += '<div class="badge legend" '+
              'data_ves_id="'+row.ves_id+'" '+
              'data_urutan="'+j+'" '+
              'data_color="'+row.color+'" '+
              'style="background: '+row.color+'; cursor:pointer;">'+
                row.ves_name+' ('+row.ves_id+')'+
              '</div>';
      }
    })
    html += "</td>";
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
    m_truck_str.push(val.kode_alat);
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
  m_start_cols_truck = nested_jam_id.length;

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
      $('#title').text('Draw : '+m_ves.ves_name+" ("+m_ves.ves_id+")")
    }
    else {
      m_ves = null;
      $('#title').text('Hapus')
    }
  })
}

function initialClickCustomLegend(key) {
  $('.legend'+key).on('click', function () {
    var urutan = $(this).attr('data_urutan');
    var ves_id = $(this).attr('data_ves_id');
    console.log("urutan", urutan);
    if(parseInt(urutan)>= 0) {
      m_ves         = m_vessel[getIndexVessel(ves_id)];
      m_eq_cur[key] = m_eq_group[urutan];
      console.log("test");
      // $('#title').text('Draw : '+m_ves.ves_name+" ("+m_ves.ves_id+")")
    }
    else {
      m_ves = null;
      // $('#title').text('Hapus')
    }
  })
}

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
  var nodes = getAllCells();
  nodes.push(...getAllCells('TRUCK'));
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
        }
      }
  });
});

$('#load').on('click', function() {
  updateColor('CRANE');
});

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
        return 30;
      else 
        return 100;
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
    } else {
    }
  });

  updateColor('CRANE');
}

function initHotTruck() {
  hot_truck = new Handsontable(con_truck, {
    colHeaders: false,
    rowHeaders: m_truck_str,
    height: 'auto',
    startRows: m_start_rows_truck,
    startCols: m_start_cols_truck,
    manualColumnResize: true,
    manualRowResize: true,
    nestedHeaders: m_nested_headers,
    licenseKey: 'non-commercial-and-evaluation',
    colWidths(index) {
      if(index>0)
        return 30;
      else 
        return 100;
    },
    rowHeights(index) {
      return 20;
    },
    rowHeaderWidth:100,
  });

  hot_truck.addHook('afterOnCellMouseUp', function(e,coords){
    // console.log(coords);
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

      if(a1>=0 && a2>=0 && b1>=0 && b2>=0) {
        for (a1=a1; a1<=a2; a1++) {
          for(b1=b1; b1<=b2; b1++) {
            if(b1 != 0) {
              if (m_eq_cur['TRUCK'] != null) {
                hot_truck.setDataAtCell(a1, b1, m_eq_cur['TRUCK'].eq_id);
              }
              var cell = hot_truck.getCell(a1,b1); 
              if(m_ves != null) {
                cell.style.background = m_ves.color;
                cell.style.color_code = m_ves.color;
                cell.style.ves_id = m_ves.ves_id;
              } else {
                cell.style.background = null;
                cell.style.ves_id = null;
              }
              // cell.setText("A");
            }
          }
          b1 = (x1 < x2 ? x1 : x2);
        }
      }
    } else {

    }
  });

  updateColor('TRUCK');

}

function initialHot() {
  initHotCrane();
  initHotTruck();
}

function updateColor(key='CRANE') {
  var cur_hot = getHotByKey(key);
  $.each(m_allcell[key], function (i, val) {
    var cell = cur_hot.getCell(parseInt(val.y), parseInt(val.x));
    cell.style.background = val.color_code; 
    cell.style.color_code = val.color_code;
    cell.style.ves_id = val.ves_id;
  });

}


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



</script>
@endsection