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

          <div class="controls">
            <button id="load" class="button button--primary button--blue">Load data</button>&nbsp;
            <button id="save" class="button button--primary button--blue">Save data</button>
          </div><br>

          <input type="radio" class="check_part" name="check_part" value="0" checked=""> CRANE&nbsp;&nbsp;&nbsp;
          <input type="radio" class="check_part" name="check_part" value="1"> TRUCK&nbsp;&nbsp;&nbsp;

          <div id="div_crane"></div>

        </div>
      </div>
    </div>  
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  getNodes();
  getVesBerth();
  getEqPlanHour();
  getCrane();
  initialHot();
});


const container = document.querySelector('#div_crane');
// const autosave = document.querySelector('#autosave');
const load = document.querySelector('#load');
var hot = null;
// const save = document.querySelector('#save');

var m_nodes = [];
var m_vessel = [];
var m_ves = null;
var m_label_jam = [];
var m_start_rows = 0;
var m_start_cols = 49;
var m_equipment = [];
var m_equipment_str = [];
var m_equipment_gen = [];
var m_hour = [];
var m_hour_str = [];
var m_tgl = [];
var m_nested_headers = [];
var m_nested_headers_hidden = [];
var m_allcell = [];
var m_allcell_gen = [];
// ['1I', '2I', '3I', '4I', '5I', '1D', '2D', '3D', '4D', '5D']
getLabelJam();


function getNodes() {
  $.ajax({
      url :  "{{url('EquipmentPlan/getNodes')}}",
      type : "post",
      dataType : "json",
      data : {
          "_token": "{{ csrf_token() }}"
      },
      async : false,
      success : function(result){
        if(result.success) {
          m_allcell_gen = result.data;
          m_allcell = m_allcell_gen.data_0;
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

function getCrane() {
  $.ajax({
      url :  "{{url('EquipmentPlan/getCrane')}}",
      type : "post",
      dataType : "json",
      data : {
          "_token": "{{ csrf_token() }}"
      },
      async : false,
      success : function(result){
        if(result.success) {
          m_equipment_gen = result.data;
          m_equipment = m_equipment_gen.data_0;
          getArrayCrane();
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
      row.cells = [];
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

function getArrayCrane() {
  m_equipment_str = [];
  $.each(m_equipment, function (i, val) {
    m_equipment_str.push(val.che_id);
  });
  m_start_rows = m_equipment.length;
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

function getAllCells() {
  var allcell = [];
  for(var row=0; row<m_start_rows; row++) {
    for(var col=0; col<m_start_cols; col++) {
      var cell = hot.getCell(row, col);
      if(cell != null) {
        if(cell.style.ves_id != null) {
          var plan_date = getDateByCol(col);
          var plan_time = getTimeByCol(col);
          var eq_id = getEqByRow(row);
          allcell.push({
            y: row, 
            x: col, 
            ves_id: cell.style.ves_id,
            eq_type: $('.check_part').val(),
            eq_id: eq_id,
            plan_date: plan_date,
            plan_date_str: plan_date,
            plan_time: plan_time,
            color_code: cell.style.color_code,
          });
        }
      }
    }
  }
  m_allcell = allcell;
  return allcell;
}

function getEqByRow(row) {
  var value = '';
  $.each(m_equipment_str, function (i, val) {
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
  console.log(m_allcell);
  // $.ajax({
  //     url :  "{{url('EquipmentPlan/save')}}",
  //     type : "post",
  //     dataType : "json",
  //     data : {
  //         "_token": "{{ csrf_token() }}",
  //         nodes : m_allcell,
  //     },
  //     async : true,
  //     success : function(result){
  //       if(result.success) {
  //         swal({
  //           title: result.success ? 'Success' : 'Failed',
  //           text: result.message,
  //           icon: result.success ? "success" : 'warning',
  //           button: "Oke",
  //         });
  //       }
  //     }
  // });
});

$('#load').on('click', function() {
  updateColor();
});

$('.check_part').on('change', function () {
  if($(this).val() == '0') {
    m_allcell = m_allcell_gen.data_0;
    m_equipment = m_equipment_gen.data_0;
  } else if($(this).val() == '1') {
    m_allcell = m_allcell_gen.data_1;
    m_equipment = m_equipment_gen.data_1;
  } else if($(this).val() == '2') {
    m_allcell = m_allcell_gen.data_2;
    m_equipment = m_equipment_gen.data_2;
  }
  console.log(m_allcell);
  console.log(m_equipment);
  getArrayCrane();
  initialHot();
})


function initialHot() {
  $('#div_crane').empty();
  hot = new Handsontable(container, {
    colHeaders: false,
    rowHeaders: m_equipment_str,
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
    console.log(coords);
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

      m_allcell = getAllCells();

      console.log('11');

      if($('.check_part').val() == '0') {
      console.log('22');
        m_allcell_gen.data_0 = m_allcell;
      } else if($('.check_part').val() == '1') {
      console.log('33');
        m_allcell_gen.data_1 = m_allcell;
      } else if($('.check_part').val() == '2') {
      console.log('44');
        m_allcell_gen.data_2 = m_allcell;
      }
    }
  });

  updateColor();

}

function updateColor() {
  console.log(m_allcell);
  $.each(m_allcell, function (i, val) {
    var cell = hot.getCell(parseInt(val.y), parseInt(val.x));
    cell.style.background = val.color_code; 
    cell.style.color_code = val.color_code;
    cell.style.ves_id = val.ves_id;
  });

}



</script>
@endsection