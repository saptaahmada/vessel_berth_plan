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

          <div class="badge" style="background: green" id="btn_tanos">Tanoss Jos</div>
          <div class="badge" style="background: red" id="btn_ultraman">Ultraman</div>

          <div id="example1"></div>

          <div class="controls">
            <button id="load" class="button button--primary button--blue">Load data</button>&nbsp;
            <button id="save" class="button button--primary button--blue">Save data</button>
            <label>
              <input type="checkbox" name="autosave" id="autosave"/>
              Autosave
            </label>
          </div>

          <pre id="example1console" class="console">Click "Load" to load data from server</pre>

        </div>
      </div>
    </div>  
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
  });

const container = document.querySelector('#example1');
const exampleConsole = document.querySelector('#example1console');
const autosave = document.querySelector('#autosave');
const load = document.querySelector('#load');
const save = document.querySelector('#save');

var m_vessel = [
  {
    name : 'Tanoss Jos',
    color : 'green',
    cells : [],
  },
  {
    name : 'Ultraman',
    color : 'red',
    cells : [],
  },
];

var m_ves = null;

let autosaveNotification;

var wokee = [];
var m_label_jam = [];
getLabelJam();

function getLabelJam() {
  m_label_jam = [''];
  for (var i = 0; i < 24; i++) {
    m_label_jam.push((i<10 ? '0'+i : ''+i));
  }
  for (var i = 0; i < 24; i++) {
    m_label_jam.push((i<10 ? '0'+i : ''+i));
  }
}

$('#btn_ultraman').on('click', function () {
  m_ves = m_vessel[1];
})

$('#btn_tanos').on('click', function () {
  m_ves = m_vessel[0];
})

var hot = new Handsontable(container, {
  colHeaders: false,
  rowHeaders: ['1I', '2I', '3I', '4I', '5I', '1D', '2D', '3D', '4D', '5D'],
  height: 'auto',
  startRows: 10,
  startCols: 50,
  manualColumnResize: true,
  manualRowResize: true,
  nestedHeaders: [
    [
      'Owner', 
      { label: '25/10/2021', colspan: 24 }, 
      { label: '26/10/2021', colspan: 24 }
    ], m_label_jam,
  ],
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
});

hot.addHook('afterOnCellMouseUp', function(row,column){
  data = hot.getSelected()[0];

  var y1 = data[0];
  var x1 = data[1];
  var y2 = data[2];
  var x2 = data[3];

  var a1 = (y1 < y2 ? y1 : y2);
  var b1 = (x1 < x2 ? x1 : x2);
  var a2 = (y1 > y2 ? y1 : y2);
  var b2 = (x1 > x2 ? x1 : x2);
    console.log("a1", a1);
    console.log("b1", b1);
    console.log("a2", a2);
    console.log("b2", b2);




  for (a1=a1; a1<=a2; a1++) {
    // console.log(a1);
    for(b1=b1; b1<=b2; b1++) {
      console.log("a1:"+a1+" a2"+a2+" b1"+b1+" b2"+b2);
      var cell = hot.getCell(a1,b1); 
      cell.style.backgroundColor = m_ves.color;
    }
    b1 = (x1 < x2 ? x1 : x2);
  }


    // console.log("y1", y1);
    // console.log("x1", x1);
    // console.log("y2", y2);
    // console.log("x2", x2);

    // console.log("a1", a1);
    // console.log("b1", b1);
    // console.log("a2", a2);
    // console.log("b2", b2);

   //  hot.updateSettings({
   //     cells: function (row, col, prop) {
   //      // if(row == y1 && col == x1) {
   //      //   console.log("row ",row);
   //      //   console.log("y1 ",y1);
   //      //   console.log("col ",col);
   //      //   console.log("x1 ",x1);
   //      // }
   //        if(row == y1 && col == x1) {
   //          console.log("masukk")
   //          var cell = hot.getCell(row,col); 
   //          cell.style.backgroundColor = m_ves.color;
   //        }
   //     }
   // });
});

// hooks.forEach(function(hook) {
//   console.log(hook);

//   hot[hook] = function() {
//     log_events(hook, arguments);
//   }
// });

// function log_events(event, data) {
//   console.log("cook1");
//   if (event == 'afterSelection') {
//   console.log("cook2");
//     var y1 = data[0];
//     var x1 = data[1];
//     var y2 = data[2];
//     var x2 = data[3];

//     console.log("y1", y1);
//     console.log("x1", x1);
//     console.log("y2", y2);
//     console.log("x2", x2);
//   }
// }


</script>
@endsection