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
          <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>Yard Plan</b></h3>
          <p class="animated fadeInDown">
           Data Tables <span class="fa-angle-right fa"></span> Yard Plan
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
          <div class="form-horizontal">
            <div class="form-group">
                <label class="col-form-label col-md-2">Block </label>
                <div class="col-md-3">
                  <select class="form-control" id="block">
                  </select>
                </div>
                <div class="col-md-5" id="block_detail"></div>
            </div>
          </div>

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

          <div id="destination"></div>
          
          <h3 id="title"></h3>
          
          <div id="div_block" style="width: 2000px"></div>
          
        </div>
      </div>
    </div>  
  </div>
</div>

<script type="text/javascript">
var m_blocks = [];
var m_vessel = [];
var m_tgl_vessel = [];
var m_destinations = [];
var m_allcell = [];
var m_port = null;
var m_block = null;
var m_color = '';
var hot = null;

$(document).ready(function(){
  getEqPlanHour();
  getBlock();
  getVesBerth();
});

const con_block    = document.querySelector('#div_block');

function getBlock() {
  $.ajax({
      url :  "{{url('YardPlan/getBlock')}}",
      type : "post",
      dataType : "json",
      data : {
          "_token": "{{ csrf_token() }}"
      },
      async : true,
      success : function(result){
        if(result.success) {
          m_blocks = result.data;
          loadBlock();
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
          m_tgl_vessel = result.data_tgl_vessel;
        }
      }
  });
}

function getDestination() {
  $.ajax({
      url :  "{{url('YardPlan/getDestination')}}",
      type : "post",
      dataType : "json",
      data : {
          "_token": "{{ csrf_token() }}",
          ves_service : m_ves.ves_service
      },
      async : false,
      success : function(result){
        if(result.success) {
          m_destinations = result.data;
          loadDestination();
        }
      }
  });
}

function loadBlock() {
  $('#block').empty();
  $('#block').append("<option value=''>-- CHOOSE BLOCK --</option>")
  $.each(m_blocks, function (i, val) {
    $('#block').append("<option value='"+val.block_name+"'>"+val.block_name+"</option>")
  });
}

function loadDestination() {
  $('#destination').empty();
  $.each(m_destinations, function (i, val) {
    $('#destination').append("&nbsp;&nbsp;&nbsp;<input type='radio' class='legend_port' name='port' data_urutan='"+i+"'/> "+val.disch_port+" ");
    // color = getGenerateColor(val.disch_port);
    // console.log(color);
    // $('#destination').append("<div class='badge legend_port' "+
    //   'data_port="'+val.disch_port+'" '+
    //   'data_urutan="'+i+'" '+
    //   'data_color="'+color+'" '+
    //   "style='background:"+color+"; cursor:pointer;'>"+val.disch_port+"</div> ");
  })

  initialClickPort();
}

$('#block').on('change', function () {
  index = $("#block").prop('selectedIndex') - 1;
  m_block = m_blocks[index];
  $('#block_detail').empty();
  if(index >= 0) {
    $('#block_detail').append("<div class='badge badge-primary'>"+m_block.oi_name+"</div> ");
    $('#block_detail').append("<div class='badge badge-info'>ROW count : "+m_block.row_count+"</div> ");
    $('#block_detail').append("<div class='badge badge-warning'>SLOT count : "+m_block.slot_count+"</div> ");
  }

  initHot();
})


function initHot() {
  if(hot != null)
    hot.destroy();

  slots = [];
  rows = [];

  for(var i=0; i<m_block.slot_count; i++) {
    num = (i+1)*2-1;
    if(num < 10)
      num = '00'+num;
    else if(num < 100)
      num = '0'+num;
    else
      num = ''+num;

    slots.push(num);
  }
  for(var i=0; i<m_block.row_count; i++) {
    num = i+1;
    if(num < 10)
      num = '00'+num;
    else if(num < 100)
      num = '0'+num;
    else
      num = ''+num;

    rows.push(num);
  }

  hot = new Handsontable(con_block, {
    colHeaders: slots,
    rowHeaders: rows,
    height: 'auto',
    startRows: m_block.row_count,
    startCols: m_block.slot_count,
    manualColumnResize: true,
    manualRowResize: true,
    // nestedHeaders: m_nested_headers,
    licenseKey: 'non-commercial-and-evaluation',
    colWidths(index) {
      // if(index>0)
        return 100;
      // else 
      //   return 160;
    },
    rowHeights(index) {
      return 20;
    },
    rowHeaderWidth:100,
  });


  hot.addHook('afterOnCellMouseUp', function(e,coords){
    // console.log(coords);
    if(m_port != null && m_ves != null) {
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
            // if(b1 != 0) {
              var cell = hot.getCell(a1,b1); 
              if(m_ves != null) {
                cell.style.background = m_ves.color;
                cell.style.color_code = m_ves.color;
                cell.style.ves_id = m_ves.ves_id;
              } else {
                cell.style.background = null;
                cell.style.ves_id = null;
              }
            // }
          }
          b1 = (x1 < x2 ? x1 : x2);
        }
      }

      getAllCells();
      // updateColor();
    }
  });

}

function getAllCells(key = 'BLOCK') {
  var allcell = [];
  var cur_hot = hot;
  var count_row = m_block.row_count;
  var count_col = m_block.slot_count;
  for(var row=0; row<count_row; row++) {
    for(var col=0; col<count_col; col++) {
      var cell = cur_hot.getCell(row, col);
      if(cell != null) {
        if(cell.style.ves_id != null) {
          allcell.push({
            y: row, 
            x: col, 
            ves_id: cell.style.ves_id,
            color_code: cell.style.color_code,
          });
        }
      }
    }
  }
  m_allcell[key] = allcell;
  return allcell;
}

function groupCell(key = 'BLOCK') {
  is_first = true;
  $.each(m_allcell[key], function(i, val) {
    
  })
}

// function checkArea(cell, area) {
//   $.each(m_allcell[key], function(i, val) {
//     if(cell. val.)
//   });
// }


function updateColor() {
  
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

function initialClick() {
  m_port = null;
  $('.legend').on('click', function () {
    var urutan = $(this).attr('data_urutan');
    if(parseInt(urutan)>= 0) {
      m_ves = m_vessel[urutan];
      $('#title').text('Draw : '+m_ves.ves_name+" ("+m_ves.ves_id+") - Remain B/M : "+m_ves.disc_remain+"/"+m_ves.load_remain);
      getDestination();
    }
    else {
      m_ves = null;
      $('#title').text('Hapus')
    }
  })
}

function initialClickPort() {
  console.log("masuk");
  $('.legend_port').on('click', function () {
    var urutan = $(this).attr('data_urutan');
    if(parseInt(urutan)>= 0) {
      m_port = m_destinations[urutan];
      m_color = getGenerateColor(m_ves.ves_name + m_port.disch_port +  m_port.update_time);
    }
  })
}

</script>
@endsection