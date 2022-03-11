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
            <button type="button" class="btn ripple-infinite btn-round btn-3d btn-primary" id="save">
              <i class="fa fa-save"></i> Save data
            </button>

            <button type="button" class="btn ripple-infinite btn-round btn-3d btn-success" id="send_spk">
              <i class="fa fa-send"></i> Send Assignment
            </button>
            
          </div>

          <h3 id="title"></h3>

          <div id="my_theme"></div><br>

          @if(session('plan_type') == 'BDS')
          <div>
            <select id="shift_min_max">
            </select>
          </div><br>
          @endif

          <input type="radio" id="eq_ht" class="eq" name="eq" value="HT" checked=""> HT&nbsp;&nbsp;&nbsp;
          <input type="radio" id="eq_tb" class="eq" name="eq" value="TB"> TB&nbsp;&nbsp;&nbsp;
          <input type="radio" id="eq_tt" class="eq" name="eq" value="TT"> TT&nbsp;&nbsp;&nbsp;
          <input type="radio" id="eq_ctt" class="eq" name="eq" value="CTT"> CTT&nbsp;&nbsp;&nbsp;

          <table class="table table-bordered">
            <thead>
              <th>Equipment</th>
              <th>Operator</th>
            </thead>
            <tbody>
              <tr>
                <td id="td_equipment"></td>
                <td id="td_operator"></td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>  
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  getMyTheme();
  if(m_plan_type == 'BDS') {
    getShiftMinMax();
  } else {
    getData();
  }
});

var m_operators = [];
var m_equipments = [];
var m_eq_cur = "HT";
var m_themes = [];
var m_theme_name = '';
var m_plan_type = "{{session('plan_type')}}";
var m_shift_min_max = [];

var m_cur_opt_idx = null;
var m_cur_opt_nipp = "";
var m_cur_opt_nama = "";
var m_cur_opt     = null;

var m_cur_eq_idx = null;
var m_cur_eq     = null;

function getData() {
  var min_max = null;
  if(m_shift_min_max.length > 0) {
    min_max = m_shift_min_max[parseInt($('#shift_min_max').val())];
  }
  // console.log("m_theme_name", m_theme_name);
  $.ajax({
      url :  "{{url('EquipmentPlanAsg/getData')}}",
      type : "post",
      dataType : "json",
      data : {
          "_token": "{{ csrf_token() }}",
          'plan_type': m_plan_type, 
          'theme_name': m_theme_name,
          'shift_min_max' : min_max,
      },
      async : true,
      success : function(result){
        if(result.success) {
          m_operators = result.operators;
          m_equipments = result.equipments;
          loadData();
        } else {
          swal({
            title: result.success ? 'Success' : 'Failed',
            text: result.message,
            icon: result.success ? "success" : 'warning',
            button: "Oke",
          });
        }
      },
      error: function(request, textStatus, errorThrown) {
        console.log(request);
          // alert(request.responseJSON.message);
      }
  });
}

function getMyTheme() {
  $.ajax({
      url :  "{{url('EqpAsgTheme/getMyTheme')}}",
      type : "post",
      dataType : "json",
      data : {
          "_token": "{{ csrf_token() }}",
          'plan_type' : m_plan_type,
      },
      async : true,
      success : function(result){
        if(result.success) {
          m_themes = result.data;
          loadMyTheme();
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
          $('#shift_min_max').html('');
          $('#shift_min_max').append("<option> -- Pilih Shift -- </option>");
          $.each(m_shift_min_max, function (i, val) {
            $('#shift_min_max').append("<option value='"+i+"'>"+val.min_tgl+" - SHIFT "+val.shift+" ("+val.min_jam+"-"+val.max_end_jam+")</option>")
          })
        }
      }
  });
}

function loadMyTheme() {
  $('#my_theme').html("Template : ");
  $.each(m_themes, function(i, val) {
    $('#my_theme').append("<button class='btn theme' theme_name='"+val.theme_name+"' "+
      "style='background:"+getGenerateColor(val.jum_opt+val.theme_name)+"; color:white;'>"+val.theme_name+"</button> ");
  });
  $('#my_theme').append("<button class='btn btn-default theme' theme_name=''><i class='fa fa-refresh'></i> reset</button> ");
  initClickTheme();
}

function loadData() {
  $('#td_operator').empty();
  $('#td_equipment').empty();
  $.each(m_operators, function (i, val) {
    var nama = val.nama;
    var nipp = val.nipp;
    $('#td_operator').append("<span id='operator_span_"+i+"'><span class='badge operator' id='operator_"+i+"' "+
      "data_nipp='"+nipp+"' "+
      "data_nama='"+nama+"' "+
      "data_urutan='"+i+"' "+
      "style='background:"+getGenerateColor(nama+nipp)+"; cursor:pointer;'>"+nama+"</span><br></span>");
    if(val.hide == 1) {
      $('#operator_span_'+i).hide();
    }
  })
  $.each(m_equipments, function (i, val) {
      var kode_alat = val.kode_alat;
      var opt_html = "";
      var error = (val.kondisi != 'R' ? ' <span class="badge" style="background:red; color:white">'+val.kondisi+'</span> ':'');
      $('#td_equipment').append("<span class='span_"+val.jenis+"' id='equipment_span_"+i+"'><span class='badge equipment' id='equipment_"+i+"' "+
        "data_urutan='"+i+"' "+
        "style='background:"+getGenerateColor(val.nama+val.kode_alat+"1")+"; cursor:pointer;'>"+kode_alat+error+"</span><br><span>");
    if(val.jenis != m_eq_cur) {
      $('#equipment_span_'+i).hide();
    }

    if(val.opt != null) {
      var opt_html = "<span class='badge' "+
      "style='background:"+getGenerateColor(val.opt.nama+val.opt.nipp)+"; cursor:pointer;'>"+val.opt.nama+"</span>";
      $('#equipment_'+i).html(val.kode_alat+" "+opt_html+error);
    }
  })
  initClick();
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

$('.eq').on('change', function () {
  m_eq_cur = $(this).val();
  if(m_eq_cur == "CTT") {
    $('.span_CTT').show();
    $('.span_TT').hide();
    $('.span_TB').hide();
    $('.span_HT').hide();
  } else if(m_eq_cur == "TT") {
    $('.span_CTT').hide();
    $('.span_TT').show();
    $('.span_TB').hide();
    $('.span_HT').hide();
  } else if(m_eq_cur == "TB") {
    $('.span_CTT').hide();
    $('.span_TT').hide();
    $('.span_TB').show();
    $('.span_HT').hide();
  } else if(m_eq_cur == "HT") {
    $('.span_CTT').hide();
    $('.span_TT').hide();
    $('.span_TB').hide();
    $('.span_HT').show();
  }
})

function initClick() {

  $('.operator').on('click', function () {
    // console.log("cook");
    m_cur_opt_idx = $(this).attr('data_urutan');
    m_cur_opt_nipp = m_operators[m_cur_opt_idx].nipp;
    m_cur_opt_nama = m_operators[m_cur_opt_idx].nama;
    m_cur_opt = m_operators[m_cur_opt_idx];
    // console.log(m_cur_opt);
  })

  $('.equipment').on('click', function () {
    m_cur_eq_idx = $(this).attr('data_urutan');
    var eq = m_equipments[m_cur_eq_idx];
    if(m_cur_opt != null) {
      if(eq.opt == null){
        var error = (eq.kondisi != 'R' ? ' <span class="badge" style="background:red; color:white">'+eq.kondisi+'</span> ':'');
        var opt_html = "<span class='badge' "+
        "style='background:"+getGenerateColor(m_cur_opt.nama+m_cur_opt.nipp)+"; cursor:pointer;'>"+m_cur_opt.nama+"</span>";
        $('#operator_span_'+m_cur_opt_idx).hide();
        $('#equipment_'+m_cur_eq_idx).html(m_equipments[m_cur_eq_idx].kode_alat+" "+opt_html+error);
        eq.opt = m_cur_opt;
        eq.opt_idx = m_cur_opt_idx;
      } else {
        alert("Truck sudah dipilih");
      }
    } else {
      if(eq.opt != null) {
        var error = (eq.kondisi != 'R' ? ' <span class="badge" style="background:red; color:white">'+eq.kondisi+'</span> ':'');
        $('#operator_span_'+eq.opt_idx).show();
        $('#equipment_'+m_cur_eq_idx).html(m_equipments[m_cur_eq_idx].kode_alat+error);
        eq.opt = null;
        eq.opt_idx = null;
      }
    }
    m_cur_opt = null;
  })
}

function initClickTheme() {
  $('.theme').on('click', function () {
    m_theme_name = $(this).attr('theme_name');
    getData();
  })
}

$('#save').on('click', function () {
  if(confirm("Apakah anda yakin ingin menyimpan data ini?")) {
    var min_max = null;
    if(m_shift_min_max.length > 0) {
      min_max = m_shift_min_max[parseInt($('#shift_min_max').val())];
    }
    console.log("min_max", min_max);
    $.ajax({
        url :  "{{url('EquipmentPlanAsg/save')}}",
        type : "post",
        dataType : "json",
        data : {
            "_token": "{{ csrf_token() }}",
            equipments : m_equipments,
            plan_type : m_plan_type,
            shift_min_max : min_max,
            is_default : $('#default').is(":checked"),
        },
        async : true,
        success : function(result){
          // if(result.success) {
            swal({
              title: result.success ? 'Success' : 'Failed',
              text: result.message,
              icon: result.success ? "success" : 'warning',
              button: "Oke",
            });
          // }
        }
    });
  }
})

$('#send_spk').on('click', function () {
  var shift = "";
  if(m_plan_type == 'BDS') {
    if($('#shift_min_max').val() == '0' || $('#shift_min_max').val() == '1') {
      shift = '/3-4';
    } else if($('#shift_min_max').val() == '3' || $('#shift_min_max').val() == '4') {
      shift = '/1-2';
    } else if($('#shift_min_max').val() == '5' || $('#shift_min_max').val() == '6') {
      shift = '/3-4';
    }
  }
  if(confirm('Apakah anda yakin ingin mengirim SPK Sekarang?')) {
    $.ajax({  
        url : "https://tower.teluklamong.co.id/index.php/service/vier_eqp_asg_send_spk/{{session('nipp')}}/"+m_plan_type+shift,
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

$('#shift_min_max').on('change', function () {
  getData();
})

</script>
@endsection