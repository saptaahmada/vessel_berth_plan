@extends('home.home')

@section('content')
@include('cssjs.css3')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/select2.min.css')}}"/>
<link rel="stylesheet" href="{{asset('date-picker/dist/mc-calendar.min.css')}}" />

<div id="content">
    <div class="panel">
        <div class="panel-body" >
            <div class="col-md-6 col-sm-12">
            <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>Monitoring Vessel Berthing Plan</b></h3>
            <p class="animated fadeInDown"><span class="fa  fa-map-marker"></span> Surabaya,Indonesia</p>            
            </div>
        </div>                    
    </div>

    <div class="col-md-12 top-20 padding-0">
        <div class="col-md-12">
            <div class="col-md-12 padding-0">
                <div class="panel">
                    <div class="panel-heading">
    <!-- 
                        <h4 style="margin-top:20px;" >Pilih Tanggal :  </h4>
                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-6" style="height:45px;">
                                    <input style="width:50%;" id="example" type="date" class="form-control"/>
                                </div>
                                <div class="col-md-6" style="height:45px;">
                                <input style="width:50%;" id="example" type="date" class="form-control"/>
                                </div>
                            </div> -->
                            <!-- <div class="row">
                                <div class="col-md-3 input-group">
                                    <span class="input-group-addon" id="basic-addon1">@</span>
                                    <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
                                </div>
                                <div class="col-md-3 ">
                                    <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
                                </div>
                            </div> -->
                            

                        <h4 style="margin-top:20px;" >Pilih Tanggal :  </h4>
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-3" style="height:45px;">
                                <input id="start" type="date" onchange="end_date()" class="form-control" placeholder="Start Date"/>
                            </div>
                            <div class="col-md-3" style="height:45px;">
                                <input  id="end" type="text" class="form-control" placeholder="End Date" disabled/>
                            </div>
                                <button type="button" id="go" class="btn ripple-infinite btn-round btn-3d btn-warning" data-toggle="#" data-target="#" style="margin-top:-2px; margin-left:10px; margin-right:10px;">
                                    Go
                                </button>
                      
                                <button type="button"  class="btn ripple-infinite btn-round btn-3d btn-success" data-toggle="modal" data-target="#modal_print" style="margin-top:-2px;">
                                    Print Monitoring
                                </button>
                     
                        </div>

                        <!--  ---------------  -->
                       


                        <h4>Pilih Dermaga :  </h4>
                            <input type="radio" id="cekbox1" class="dermaga" name="dermaga" value="D" checked  > Domestic</input> 
                            <input type="radio"  id="cekbox2" class="dermaga" name="dermaga" value="I"  > International</input>
                            <input type="radio"  id="cekbox3" class="dermaga" name="dermaga" value="C" > Curah Kering</input>
                    </div>
                    <div class="panel-body2">
                        <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-1 divwaktu">
                                        
                                        <?php for($i=0; $i<7; $i++) { ?>
                                        <div>
                                            <?php 
                                                $dateawal = date('d-m-Y');
                                                $hoursnow = date('H');
                                                $dateloop = date('d-m-Y', strtotime("+$i day", strtotime($dateawal))); 
                                            ?>
                                            <div>
                                                <div id="tgl{{$i}}" class = "tanggal">{{$dateloop}}</div>
                                            </div>
                                            <div >
                                                <div>
                                                    <div class="waktu">00.00</div>
                                                </div>
                                                <div >
                                                    <div class="waktu">03.00</div>
                                                </div>
                                                <div>
                                                    <div class="waktu">06.00</div>
                                                </div>
                                                <div>
                                                    <div class="waktu">09.00</div>
                                                </div>
                                                <div>
                                                    <div class="waktu">12.00</div>
                                                </div>
                                                <div >
                                                    <div class="waktu">15.00</div>
                                                </div>
                                                <div>
                                                    <div class="waktu">18.00</div>
                                                </div>
                                                <div>
                                                    <div class="waktu">21.00</div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?> 
                                    </div>
                                    <!-- <div id="results"></div> -->
                                    <!-- <div id="panjang"></div> -->
                                    <div style="position:absolute; left:80px;" id="div_coba">
                                        @include('content.isi.ruler')
                                        
                                        <div id='canvas'>
                                            <div id='wrap_sw'>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>

                                </div>
                        </div>
                    
                                <div class="modal fade" id="modal_print"  role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Choose Signature</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                    <label class="col-form-label">Planning Manager: </label>
                                                    <select  id="planing_manager" class="form-control " data-live-search="true">
                                                            <!-- <option>-----------</option> -->
                                                    </select>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-form-label">Berth Planner: </label>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function () { 
        var imgPath = "{{asset('img/ajax-loader.gif')}}";
        var img = '<img src="' + imgPath + '" style="margin-top: 5px;" />';
        $("#go").click(function () {
            var star3= document.getElementById("start").value;
                
            if (star3 == "") {
            // alert("Pilih Tanggal Terlebih Dahulu!!!");
                swal({
                    title: "Pilih Tanggal Terlebih Dahulu!",
                    text: "You clicked the button!",
                    icon: "warning",
                    button: "Oke",
                }); 
            } else {
                $.blockUI({ 
                    message: img,
                    css: {
                    padding:    0,
                    margin:     0,
                    width:      '30%',
                    top:        '40%',
                    left:       '35%',
                    textAlign:  'center',
                    border:     '3px transparent #aaa',
                    backgroundColor:'transparent',
                    cursor:     'wait'
                        }
                    });
                setTimeout(function () {
                    kade('D');
                    go();
                    $.unblockUI();
                }, 1000);
            }
        });

        $("#cekbox1").click(function () {
            var star4= document.getElementById("start").value;

            if (star4 == "") {
            // alert("Pilih Tanggal Terlebih Dahulu!!!");
                swal({
                    title: "Pilih Tanggal Terlebih Dahulu!",
                    text: "You clicked the button!",
                    icon: "warning",
                    button: "Oke",
                }); 
            } else {
                
                $.blockUI({ 
                    message: img,
                    css: {
                    padding:    0,
                    margin:     0,
                    width:      '30%',
                    top:        '40%',
                    left:       '35%',
                    textAlign:  'center',
                    border:     '3px transparent #aaa',
                    backgroundColor:'transparent',
                    cursor:     'wait'
                        }
                    });
                setTimeout(function () {
                    kade('D');
                    go();
                    $.unblockUI();
                    }, 1000);
            }
        });
        $("#cekbox2").click(function () {
            var star5= document.getElementById("start").value;

            if (star5 == "") {
            // alert("Pilih Tanggal Terlebih Dahulu!!!");
                swal({
                    title: "Pilih Tanggal Terlebih Dahulu!",
                    text: "You clicked the button!",
                    icon: "warning",
                    button: "Oke",
                }); 
            } else {
                
                $.blockUI({ 
                    message: img,
                    css: {
                    padding:    0,
                    margin:     0,
                    width:      '30%',
                    top:        '40%',
                    left:       '35%',
                    textAlign:  'center',
                    border:     '3px transparent #aaa',
                    backgroundColor:'transparent',
                    cursor:     'wait'
                        }
                    });
                setTimeout(function () {
                    kade('I');
                    go();
                    $.unblockUI();
                    }, 1000);
            }
        });
        $("#cekbox3").click(function () {
            var star6= document.getElementById("start").value;

            if (star6 == "") {
            // alert("Pilih Tanggal Terlebih Dahulu!!!");
                swal({
                    title: "Pilih Tanggal Terlebih Dahulu!",
                    text: "You clicked the button!",
                    icon: "warning",
                    button: "Oke",
                }); 
            } else {
                
                $.blockUI({ 
                    message: img,
                    css: {
                    padding:    0,
                    margin:     0,
                    width:      '30%',
                    top:        '40%',
                    left:       '35%',
                    textAlign:  'center',
                    border:     '3px transparent #aaa',
                    backgroundColor:'transparent',
                    cursor:     'wait'
                        }
                    });
                setTimeout(function () {
                    kade('C');
                    go();
                    $.unblockUI();
                    }, 1000);
            }
        });

    });



    function end_date() {
        var startA= document.getElementById("start").value;
        var dateendA = moment(startA).add(6,'d').format('MM/DD/YYYY');
        
        if (!isNaN(startA)) {
            document.getElementById('end').value = "" ;
        } else{
            document.getElementById('end').value = dateendA;
        }

        
    }
    
    function go() {
       
        // console.log("button",button);

        var start= document.getElementById("start").value;

        
    
        var datestart = moment(start).format('YYYY/MM/DD');
        var dateend = moment(start).add(6,'d').format('YYYY/MM/DD');
        var y_awalp = moment(start).set({h: 00, m: 00}).format('YYYY-MM-DD HH:mm:ss');
        var y_awal = moment(start).set({h: 00, m: 00});
        var tgl = moment(start).format('DD-MM-YYYY');
        for(s=0; s<7; s++){
            var tglloop = moment(start).add(s,'d').format('DD-MM-YYYY');
            $('#tgl'+s).text(tglloop);
        }
         
        var vessel=[];
        $("#wrap_sw").empty();
        $.ajax({  
            url : "{{ route('monitoringproses') }}",
            type : "post",
            data: {
                "_token": "{{ csrf_token() }}",
                date_start:datestart,
                date_end:dateend
                },
            dataType : "json",
            async : false,
            success : function(result){
                if($('#cekbox1').is(':checked')) {
                    vessel = result.Domes;
                    $("#Rdomes").css("display","block");
                    $("#Rintern").css("display","none");
                    $("#Rcur").css("display","none");

                } else if ($('#cekbox2').is(':checked')) {
                    vessel = result.Intern;
                    $("#Rintern").css("display","block");
                    $("#Rdomes").css("display","none");
                    $("#Rcur").css("display","none");

                } else if ($('#cekbox3').is(':checked')) {
                    vessel = result.Curah;
                    $("#Rcur").css("display","block");
                    $("#Rdomes").css("display","none");
                    $("#Rintern").css("display","none");
                }

                for(i=1;i < vessel.length+1; i++){

                    var crane_vess =  vessel[i-1].crane;
                    var uncrane=[];
                    if (crane_vess==null)
                    uncrane=[];
                    else
                    uncrane = crane_vess.split(',');

                    var craneloopload = "";
                    for (var x = 0; x < uncrane.length; x++) { //Move the for loop from here
                        craneloopload += '<circle2><span>'+uncrane[x]+'</span></circle2>';
                    };

                    $("#wrap_sw").append(
                    '<div id="box'+i+'" urutan="'+i+'" class="box draggable">'+
                        '<div id="img'+i+'">'+
                            '<img id="ims'+i+'" class="ims" src = "{{asset('/img/')}}/'+vessel[i-1].image+'" style= "width: 20%; height: 20%; "/>'+
                        '</div>'+
                        '<div id="text_judul'+i+'" class="text_judul">'+
                            'MV. '+vessel[i-1].ves_name+''+
                        '</div>'+
                        '<div id="text_detail'+i+'" class="text_detail">'+
                            '<div style="margin:1px; color:red;">ETA :'+vessel[i-1].est_berth_ts+'</div>'+
                            '<div class="ETB_'+i+'" style="margin:1px;">ETB :'+vessel[i-1].est_berth_ts+'</div>'+
                            '<div class="ETD_'+i+'" style="margin:1px;">ETD : '+vessel[i-1].est_dep_ts+'</div>'+
                            '<div style="margin:1px; margin-left:2px; color:red; font-style: italic;">MOVES EST:'+vessel[i-1].est_load+'/'+vessel[i-1].est_discharge+' BOX</div>'+
                            '<div style="margin:1px;">LOA : '+vessel[i-1].width_ori+' M</div>'+
                            '<div style="margin:1px;">POD : '+vessel[i-1].dest_port+'</div>'+
                            ' <circle><span class="kade_box_'+i+'">'+vessel[i-1].berth_fr_metre_ori+' On '+vessel[i-1].berth_to_metre_ori+'</span></circle>'+
                            craneloopload+
                        '</div>'+
                        '<div class="widget-inner"></div>'+
                    '</div>');
                }

                for (v = 1; v < vessel.length+1; ++v) {
                    var est_berth = vessel[v-1].est_berth_ts;
                    var end= moment(est_berth);
                    var duration = moment.duration(end.diff(y_awal));
                    var hours = duration.asHours();
                    var startdate = ((hours*60)/30)*10;

                    var colors = ['#FFC312','#ffe699','#9dc3e6','#a9d18e'];

                    var rand = colors[Math.floor(Math.random() * colors.length)];
                    var btoa = vessel[v-1].btoa_side;

                    
                        
                        if(btoa == "P"){ //kiri star
                            $("#box"+v).css("left", vessel[v-1].berth_fr_metre+"px");
                            $("#box"+v).css("width", vessel[v-1].width+"px");
                            $("#box"+v).css("top", startdate+"px");
                            $("#box"+v).css("height", vessel[v-1].height+"px");
                            $("#box"+v).css("background-color", rand);
                            $("#text_judul"+v).css("padding-left", "24%");
                            $("#text_detail"+v).css("padding-left", "25%");
                        
                            $("#box"+v).css("clip-path", "polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%)");

                        
                        }else if (btoa == "S") { //kanan port
                            $("#box"+v).css("left", vessel[v-1].berth_fr_metre+"px");
                            $("#box"+v).css("width", vessel[v-1].width+"px");
                            $("#box"+v).css("top", startdate+"px");
                            $("#box"+v).css("height", vessel[v-1].height+"px");
                            $("#box"+v).css("background-color", rand);
                            $("#text_judul"+v).css("padding-left", "12px");
                            $("#text_detail"+v).css("padding-left", "12px");
                            // $("#img"+i).css("text-align", "left");
                            // $("#img"+i).css("padding-left", "20px");
                            // $("#img"+i).css("padding-top", "5px");
                            $("#box"+v).css("clip-path", "polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%)");

                        }
                }
            }
        });    
    }
</script>

<script>
    $("#planing_manager").empty();
    $("#berth_planner").empty();
    $.ajax({  
        url : "{{route('getsignature')}}",
        type : "get",
        dataType : "json",
        async : false,
        success : function(result){
            var manager=result.man;
            var planner=result.plan;
            // console.log(manager);

            for (s = 1; s < manager.length+1; ++s) {
                $("#planing_manager").append('<option value="'+manager[s-1].nama+'">'+manager[s-1].nama+'</option>');  
            }
            for (x = 1; x < planner.length+1; ++x) {
                $("#berth_planner").append('<option value="'+planner[x-1].nama+'">'+planner[x-1].nama+'</option>');  
            } 
        } 
    });
</script>

@include('cssjs.scriptmonitoring')
@endsection