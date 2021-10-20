@extends('home.home')

@section('content')
<style>
    #canvas_ship_to_ship {
        width:200px; height:160px;
        display: inline-block;
        margin: 1em;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="{{asset('asset/js/plugins/raphael.min.js')}}"></script>
<script src="{{asset('asset/js/plugins/justgate/justgate.js')}}"></script>

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
                    <div id="canvas_ship_to_ship"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $(function(){
        var g1 = new JustGage({
          id: "canvas_ship_to_ship",
          value: 10,
          min: 0,
          max: 50,
          title: "Testing",
          label: "m/s"
        });
    });
</script>

@endsection
