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
            <div class="form-horizontal">
              <div class="form-group">
                  <label class="control-label col-md-2">Nama Template</label>
                  <div class="col-md-9">
                    <input type="input" id="theme_name" class="form-control" value="{{$theme_name}}" readonly="">
                  </div>
              </div>
              <div class="form-group">
                  <label class="control-label col-md-2"></label>
                  <div class="col-md-9">
                    <button id="save" class="btn btn-success">Save data</button>
                    <a href="{{url('EqpAsgTheme')}}" class="btn btn-danger">Back</a>
                  </div>
              </div>
            </div>
          </div>

          <h3 id="title"></h3>

          <input type="radio" id="eq_ctt" class="eq" name="eq" value="CTT" checked=""> CTT&nbsp;&nbsp;&nbsp;
          <input type="radio" id="eq_tt" class="eq" name="eq" value="TT"> TT&nbsp;&nbsp;&nbsp;
          <input type="radio" id="eq_tb" class="eq" name="eq" value="TB"> TB&nbsp;&nbsp;&nbsp;
          <input type="radio" id="eq_ht" class="eq" name="eq" value="HT"> HT

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
  getDataUpdate();
});

var m_operators = [];
var m_equipments = [];
var m_eq_cur = "CTT";
var m_plan_type = "{{session('plan_type')}}";

var m_cur_opt_idx = null;
var m_cur_opt_nipp = "";
var m_cur_opt_nama = "";
var m_cur_opt     = null;

var m_cur_eq_idx = null;
var m_cur_eq     = null;

function getDataUpdate() {
  $.ajax({
      url :  "{{url('EqpAsgTheme/getDataUpdate')}}",
      type : "post",
      dataType : "json",
      data : {
          "_token": "{{ csrf_token() }}",
          'plan_type': m_plan_type, 
          'theme_name': '{{$theme_name}}'
      },
      async : true,
      success : function(result){
        if(result.success) {
          m_operators = result.operators;
          m_equipments = result.equipments;
          loadData();
        }
      }
  });
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
      $('#td_equipment').append("<span class='span_"+val.jenis+"' id='equipment_span_"+i+"'><span class='badge equipment' id='equipment_"+i+"' "+
        "data_urutan='"+i+"' "+
        "style='background:"+getGenerateColor(val.nama+val.kode_alat+"1")+"; cursor:pointer;'>"+kode_alat+"</span><br><span>");
    if(val.jenis != m_eq_cur) {
      $('#equipment_span_'+i).hide();
    }

    if(val.opt != null) {
      var opt_html = "<span class='badge' "+
      "style='background:"+getGenerateColor(val.opt.nama+val.opt.nipp)+"; cursor:pointer;'>"+val.opt.nama+"</span>";
      $('#equipment_'+i).html(val.kode_alat+" "+opt_html);
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
        var opt_html = "<span class='badge' "+
        "style='background:"+getGenerateColor(m_cur_opt.nama+m_cur_opt.nipp)+"; cursor:pointer;'>"+m_cur_opt.nama+"</span>";
        $('#operator_span_'+m_cur_opt_idx).hide();
        $('#equipment_'+m_cur_eq_idx).html(m_equipments[m_cur_eq_idx].kode_alat+" "+opt_html);
        eq.opt = m_cur_opt;
        eq.opt_idx = m_cur_opt_idx;
      } else {
        alert("Truck sudah dipilih");
      }
    } else {
      if(eq.opt != null) {
        $('#operator_span_'+eq.opt_idx).show();
        $('#equipment_'+m_cur_eq_idx).html(m_equipments[m_cur_eq_idx].kode_alat);
        eq.opt = null;
        eq.opt_idx = null;
      }
    }
    m_cur_opt = null;
  })
}

$('#save').on('click', function () {
  if($('#theme_name').val() != '') {
    $.ajax({
        url :  "{{url('EqpAsgTheme/updateProcess')}}",
        type : "post",
        dataType : "json",
        data : {
            "_token": "{{ csrf_token() }}",
            equipments : m_equipments,
            plan_type : m_plan_type,
            theme_name : $('#theme_name').val(),
            theme_name_old : '{{$theme_name}}',
        },
        async : true,
        success : function(result){
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
      title: 'Failed',
      text: "Lengkapi Form!!!",
      icon: 'warning',
      button: "Oke",
    });
  }
})

</script>
@endsection