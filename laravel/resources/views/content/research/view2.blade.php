@extends('home.home')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/select2.min.css')}}"/>
<link rel="stylesheet" href="{{asset('asset/css/plugins/handsontable/handsontable.full.min.css')}}" />

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script src="{{asset('asset/js/plugins/select2.full.min.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/js/plugins/handsontable/handsontable.full.min.js')}}"></script>

<style type="text/css">
  #example1_events {
    height: 166px;
    padding: 5px;
    margin: 10px 0;
    overflow-y: scroll;
    font-size: 11px;
    border: 1px solid #CCC;
    box-sizing: border-box;
  }
  #example1 {
    margin-top: 0;
  }
  #hooksList {
    padding: 0;
  }

  #hooksList li {
    list-style: none;
    width: 33%;
    display: inline-block;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
  }
</style>

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

          <div class="badge" style="background: green">Tanoss Jos</div>
          <div class="badge" style="background: red">Ultraman</div>

          <div id="example1" class="hot"></div>
          <div id="example1_events"></div>

          <strong> Choose events to be logged:</strong>

          <ul id="hooksList">
            <li><label><input type="checkbox" id="check_select_all">Select all</label></li>
          </ul>

        </div>
      </div>
    </div>  
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
  });

const config = {
  data: [
    ['', 'Tesla', 'Mazda', 'Mercedes', 'Mini', 'Mitsubishi'],
    ['2017', 0, 2941, 4303, 354, 5814],
    ['2018', 3, 2905, 2867, 412, 5284],
    ['2019', 4, 2517, 4822, 552, 6127],
    ['2020', 2, 2422, 5399, 776, 4151]
  ],
  minRows: 5,
  minCols: 6,
  height: 'auto',
  stretchH: 'all',
  minSpareRows: 1,
  autoWrapRow: true,
  colHeaders: true,
  contextMenu: true,
  licenseKey: 'non-commercial-and-evaluation'
};

const example1Events = document.getElementById("example1_events");
const hooksList = document.getElementById('hooksList');
const hooks = Handsontable.hooks.getRegistered();

hooks.forEach(function(hook) {
  let checked = '';

  if (
    hook === 'afterChange' || 
    hook === 'afterSelection' || 
    hook === 'afterCreateRow' || 
    hook === 'afterRemoveRow' || 
    hook === 'afterCreateCol' || 
    hook === 'afterRemoveCol'
    ) {
    checked = 'checked';
  }

  hooksList.innerHTML += '<li><label><input type="checkbox" ' + checked + ' id="check_' + hook + '"> ' + hook + '</label></li>';
  config[hook] = function() {
    log_events(hook, arguments);
  }
});

const start = (new Date()).getTime();
// let i = 0;
let timer;

function log_events(event, data) {
  if (event == 'afterSelection') {
    // console.log(data);
    // for (var i = 0; i <= 4; i++) {
    //   console.log('i', data[i]);
    // }
    var y1 = data[0];
    var x1 = data[1];
    var y2 = data[2];
    var x2 = data[3];

    console.log("y1", y1);
    console.log("x1", x1);
    console.log("y2", y2);
    console.log("x2", x2);
    // const now = (new Date()).getTime();
    // const diff = now - start;
    // let str;

    // const vals = [ i, '@' + numbro(diff / 1000).format('0.000'), '[' + event + ']'];

    // console.log(data);

    // for (let d = 0; d < data.length; d++) {
    //   // console.log(data[d]);
    //   try {
    //     str = JSON.stringify(data[d]);
    //   } catch (e) {
    //     str = data[d].toString(); // JSON.stringify breaks on circular reference to a HTML node
    //   }

    //   if (str === void 0) {
    //     console.log("testing", d);
    //     continue;
    //   }
    //     console.log("halo", d);
    //   if (str.length > 20) {
    //     str = data[d].toString();
    //   }
    //   if (d < data.length - 1) {
    //     str += ',';
    //   }

    //   vals.push(str);
    // }

    // if (window.console) {
    //   console.log(i, '@' + numbro(diff / 1000).format('0.000'), '[' + event + ']', data);
    // }

    // const div = document.createElement('div');
    // const text = document.createTextNode(vals.join(' '));
    // div.appendChild(text);
    // example1Events.appendChild(div);
    // clearTimeout(timer);
    // timer = setTimeout(function() {
    //   example1Events.scrollTop = example1Events.scrollHeight;
    //   // console.log(vals.join(' '))
    // }, 10);

    // i++;
  }
}

const example1 = document.getElementById('example1');
const hot = new Handsontable(example1, config);

document.querySelector('#check_select_all').addEventListener('click', function () {
  const state = this.checked;
  const inputs = document.querySelectorAll('#hooksList input[type=checkbox]');
  Array.prototype.forEach.call(inputs, function (input) {
    input.checked = state;
  });
});

document.querySelector('#hooksList input[type=checkbox]').addEventListener('click', function () {
  if (!this.checked) {
    document.getElementById('check_select_all').checked = false;
  }
});

</script>
@endsection