<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<!-- start dragable n resizing -->
<script src="{{asset('asset/js/plugins/select2.full.min.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{asset('js/jquery.blockUI.js')}}"></script>
<!-- <script src="{{asset('asset/js/main.js')}}"></script> -->



<script>
    var m_crane_con = [];
    var m_crane_dry = [];
    var m_index_edit = 0;
    var m_blokirkade = <?=$blokirkade?>;
    var m_dermaga_current = 'D';

        $(document).ready(function () {

//for vessel pada modal add vessel
            $("#vessel2").empty();
            $("#vessel3").empty();
            $.ajax({  
                url : "{{route('getdermaga')}}",
                type : "get",
                dataType : "json",
                async : false,
                success : function(result){
                    for (d = 1; d < result.Con.length+1; ++d) {
                        $("#vessel2").append('<option  name="vesnam" value="'+result.Con[d-1].ves_id+'">'+result.Con[d-1].ves_code+' - '+result.Con[d-1].ves_name+' ('+result.Con[d-1].ves_type_name+')</option>');  
                    }
                    for (p = 1; p < result.Dry.length+1; ++p) {
                        $("#vessel3").append('<option  name="vesnam" value="'+result.Dry[p-1].ves_id+'">'+result.Dry[p-1].ves_code+' - '+result.Dry[p-1].ves_name+' ('+result.Dry[p-1].ves_type_name+')</option>');  
                    }
                }
            });
//end for vessel pada modal add vessel

//for port pada modal add vessel
            $("#nextPDry").empty();
            $("#nextP").empty();
            $("#deshPDry").empty();
            $("#deshP").empty();
            var getport = [];

            $.ajax({  
                url : "{{route('getport')}}",
                type : "get",
                dataType : "json",
                async : false,
                success : function(result){
                    getport=result;

                    $("#nextPDry").append('<option  name="next" value="">-- PILIH NEXT PORT --</option>');  
                    $("#nextP").append('<option  name="next" value="">-- PILIH DEST PORT --</option>');

                    $("#deshPDry").append('<option  name="next" value="">-- PILIH NEXT PORT --</option>');  
                    $("#deshP").append('<option  name="next" value="">-- PILIH DEST PORT --</option>');

                    $("#edit_nextp").append('<option  name="next" value="">-- PILIH NEXT PORT --</option>');  
                    $("#edit_deshp").append('<option  name="next" value="">-- PILIH DEST PORT --</option>');

                    for (i = 1; i < getport.length+1; ++i) {
                        $("#nextPDry").append('<option  name="next" value="'+getport[i-1].port+'">'+getport[i-1].port+' ('+getport[i-1].descr+') </option>');  
                        $("#nextP").append('<option  name="next" value="'+getport[i-1].port+'">'+getport[i-1].port+' ('+getport[i-1].descr+')</option>'); 

                        $("#deshPDry").append('<option  name="desh" value="'+getport[i-1].port+'">'+getport[i-1].port+' ('+getport[i-1].descr+') </option>');  
                        $("#deshP").append('<option  name="desh" value="'+getport[i-1].port+'">'+getport[i-1].port+' ('+getport[i-1].descr+')</option>'); 

                        $("#edit_nextp").append('<option  name="next" value="'+getport[i-1].port+'">'+getport[i-1].port+' ('+getport[i-1].descr+')</option>'); 
                        $("#edit_deshp").append('<option  name="next" value="'+getport[i-1].port+'">'+getport[i-1].port+' ('+getport[i-1].descr+')</option>');  

                    }
                
                } 
            });
//end for port pada modal add vessel


//for crane pada modal add vessel
            $("#craneCon").empty();
            $("#craneDry").empty();
            $("#edit_crane").empty();
            $("#edit_crane").empty();
            $.ajax({  
                url : "{{route('getcrane')}}",
                type : "get",
                dataType : "json",
                async : false,
                success : function(result){
                    m_crane_con = result.Con;
                    m_crane_dry = result.Dry;
                    for (s= 1; s < result.Con.length+1; ++s){
                        $("#craneCon").append('<input type="checkbox" name="crane" id="checkbox'+result.Con[s-1].che_name+'" value="'+result.Con[s-1].che_name+'" class="crane" />'+
                                                            '<label>STS '+result.Con[s-1].che_name+'</label><span> </span><span> </span>');
                        }
                    for (u = 1; u < result.Dry.length+1; ++u){
                        $("#craneDry").append('<input type="checkbox" name="craneDry" id="checkbox'+result.Dry[u-1].che_name+'" value="'+result.Dry[u-1].che_name+'" class="crane" />'+
                                                            '<label>'+result.Dry[u-1].che_name+'</label><span> </span><span> </span>');
                        }
                }       
            });

//end for crane pada modal add vessel

//for signature pada modal Print
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
//end  for signature pada modal Print



            $(".select2-A").select2({
                placeholder: "Select..",
                allowClear: false
            });

            var imgPath = "{{asset('img/ajax-loader.gif')}}";
            var img = '<img src="' + imgPath + '" style="margin-top: 5px;" />';
            loadAll('D');

            $("#cekbox1").click(function () {
  
                // Default blockUI code
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
                    loadAll('D');
                }, 1000);
                setTimeout(function () {
                    // Timer to unblock    
                    $.unblockUI();
                }, 1000);

                changeDermaga('D');
            });
            
            $("#cekbox2").click(function () {
  
                // Default blockUI code
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
                    loadAll('I');
                    }, 1000);

                    setTimeout(function () {
                        $.unblockUI();
                    }, 1000);
                changeDermaga('I');

            });

            $("#cekbox3").click(function () {
  
                // Default blockUI code
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
                    loadAll('C');
                }, 1000);
                setTimeout(function () {
                    // Timer to unblock    
                    $.unblockUI();
                }, 1000);
                changeDermaga('C');

            });
            $("#saveupdate").click(function () {
                // Default blockUI code
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

                    // Timer to unblock    
                    $.unblockUI();
                }, 3000);
            });
            
            $("#dry").click(function () {
                $("body").css("cursor", "wait");
                setTimeout(function () {
                    borang('D');
                    $("body").css("cursor", "default");
                }, 1000);
               
            });

            $("#con").click(function () {
                $("body").css("cursor", "wait");
                setTimeout(function () {
                    borang('C');
                    $("body").css("cursor", "default");
                }, 1000);
            });


            changeDermaga(m_dermaga_current);
            drawSysdate();
           
        });

    function changeDermaga(der) {

        $('.blokirkade').remove();

        for (var i = 0; i < m_blokirkade.length; i++) {
            if(m_blokirkade[i].param2 == der) {
                var width = (m_blokirkade[i].param4-m_blokirkade[i].param3)*2;
                var left = m_blokirkade[i].param3*2;
                $('#canvas').prepend(
                    "<div class='blokirkade' style='background-color:#877F7D; left: "+left+"px; width: "+width+"px; height: 100%; position: absolute;'></div>"
                );
            }
        }

        m_dermaga_current = der;

        
    }

function drawSysdate() {
    var top = getPosition(new Date());

    $("#canvas").append(
        '<div id="div_sysdate" style="width:100%; height:2px; position:absolute; top:'+top+'px; background-color:red">'+
        '</div>');
}

function getPosition(date_now) {
    var date_first = new Date();
        date_first.setHours(00);
        date_first.setMinutes(00);
        date_first.setSeconds(00);

    const format9 = "YYYY-MM-DD HH:mm:ss";
    date_first = moment(date_first).format(format9);

    var tglPertama = Date.parse(date_now);
    var tglKedua = Date.parse(date_first);
    var miliday = 60 * 1000;
    var second =(tglPertama-tglKedua)/miliday;
    var pos = (second/30)*10;
    return pos;
}

var vessel=[];
var dermaga =[];
// var image = [];
var thisocean = "D";
var kd_end_glb = "";
var vesselCurrent= ["0"];
var m_note_index = 1;

borang('C');

function borang(param) {
    if (param == "C"){
        $("#formCon").show();
        $("#formDry").hide();
                                            
    } else if (param == "D"){
        $("#formDry").show();
        $("#formCon").hide();
    }
}


function getRandomColor() {
    var colors = ['#FFC312','#ffe699','#9dc3e6','#a9d18e'];
    var rand = colors[Math.floor(Math.random() * colors.length)];
    return rand;
}

$('#vessel2').on('change', function() {
    getVessel();
})
$('#vessel3').on('change', function() {
    getVessel();
})
$('#btn_add_note').on('click', function() {
    $("#wrap_sw").append(
        '<div id="box_note_'+m_note_index+'" urutan="'+m_note_index+'" class="box_note draggable">'+
            '<div class="widget-inner">'+
                '<div class="text_detail">'+
                    $('#note').val()+
                '</div>'+
            '</div>'+
        '</div>');

    $("#box_note_"+m_note_index).css("left", "100px");
    $("#box_note_"+m_note_index).css("width", "100px");
    $("#box_note_"+m_note_index).css("top", "100px");
    $("#box_note_"+m_note_index).css("height", "50px");
    $("#box_note_"+m_note_index).css("background-color", "#fff");

    convertToDragNote(m_note_index);

    m_note_index++;
})

function autofillCon() {
    var etB="";
    var bongkar="";
    var muat="";
    var bsh="";
    var kde_start="";
    var estimasimenit="";
    if($("#con").is(':checked')){
         etB = document.getElementById("etB").value; 
         bongkar = document.getElementById("bongkar").value;
         muat = document.getElementById('muat').value;
         bsh = document.getElementById('bsh').value;
         kde_start = document.getElementById('start').value;
         estimasimenit= ((parseInt(bongkar)+parseInt(muat))/parseInt(bsh))*60;

    } else {
         etB = document.getElementById("etBDry").value; 
         bongkar = document.getElementById("bongkarDry").value;
         muat = "0";
         bsh = document.getElementById('tghDry').value;
         kde_start = document.getElementById('startDry').value;
         estimasimenit= parseInt(bongkar)/parseInt(bsh)*60;

    }
    // console.log("bongkar", bongkar)
    // console.log("tgh", bsh)
    // console.log(estimasimenit)

   var vess_len = vesselCurrent.ves_len;
   var kde_end =parseInt(kde_start) + parseInt(vess_len);


   var newdate =new Date(etB);
       newdate.setMinutes(newdate.getMinutes() + estimasimenit);

   const format90 = "YYYY-MM-DD HH:mm:ss"
       var etBout= moment(etB).format(format90);
       var newdateoutCon = moment(newdate).format(format90);

    
    
   
   if (!isNaN(estimasimenit)) {
    if($("#con").is(':checked'))
        document.getElementById('etD').value = newdateoutCon;
    else
        document.getElementById('etDDry').value = newdateoutCon;

   } else{
       document.getElementById('etD').value = "";
   }

   if (!isNaN(kde_end)) {
        if($("#con").is(':checked'))
            document.getElementById('end').value = kde_end;
        else
            document.getElementById('endDry').value = kde_end;


   } else{
       document.getElementById('end').value = "0";
   }
}

function getVessel() {
    var vessid = "";
    if($("#con").is(':checked'))
        vessid = document.getElementById("vessel2").value;
    else
        vessid = document.getElementById("vessel3").value;

   $.ajax({  
        url : "{{ url('VesselBerthPlan/addvessel') }}",
        type : "post",
        data: {
            "_token": "{{ csrf_token() }}",
            param_data:vessid
            },
        dataType : "json",
        async : false,
        success : function(result){
            vesselCurrent = result[0];
            // console.log(vesselCurrent);
            
        }
    });
} 


function reloadAll() {
    $("#wrap_sw").empty();
    
    for (i = 1; i < vessel.length+1; ++i) {
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
            '<div class="widget-inner">'+
                '<div id="img'+i+'">'+
                     '<img id="ims'+i+'" class="ims" src = "{{asset('/img/')}}/'+vessel[i-1].image+'" style= "width: 20%; height: 20%; "/>'+
                '</div>'+
                '<div id="text_judul'+i+'" class="text_judul">'+
                    'MV. '+vessel[i-1].ves_name+''+
                '</div>'+
                '<div id="text_detail'+i+'" class="text_detail">'+
                    '<button onclick="toEdit('+(i-1)+')" class="btn_edit" id="btn_edit_'+i+'"><i class="fa fa-pencil"></i></button>'+
                    '<div style="margin:1px; color:red;">ETA :'+vessel[i-1].est_berth_ts+'</div>'+
                    '<div class="ETB_'+i+'" style="margin:1px;">ETB :'+vessel[i-1].est_berth_ts+'</div>'+
                    '<div class="ETD_'+i+'" style="margin:1px;">ETD : '+vessel[i-1].est_dep_ts+'</div>'+
                    '<div style="margin:1px; margin-left:2px; color:red; font-style: italic;">MOVES EST:'+vessel[i-1].est_load+'/'+vessel[i-1].est_discharge+' BOX</div>'+
                    '<div style="margin:1px;">LOA : '+vessel[i-1].width_ori+' M</div>'+
                    '<div style="margin:1px;">POD : '+vessel[i-1].dest_port+'</div>'+
                    ' <circle><span class="kade_box_'+i+'">'+vessel[i-1].berth_fr_metre_ori+' On '+vessel[i-1].berth_to_metre_ori+'</span></circle>'+
                    craneloopload+
                '</div>'+
            '</div>'+
        '</div>');
        $("#wrap_sw").append("<div id='shadow_"+i+"'>cinta</div>");
        // $("#canvas").append('<div id="box'+i+'" class="box draggable"><div class="text_judul"> MV. '+vessel[i-1].ves_name+'</div><div class="text_detail">ETA : '+vessel[i-1].est_berth_ts+'<br>ETB : '+vessel[i-1].est_berth_ts+'<br>ETD : '+vessel[i-1].est_dep_ts+'</div>   </div>');
        convertToDrag();
        
    }

    for (i = 1; i < vessel.length+1; ++i) {
        // var r = () => Math.random() * 256 >> 0;
        // var color = `rgb(${r()}, ${r()}, ${r()})`;

        var colors = ['#FFC312','#ffe699','#9dc3e6','#a9d18e'];

        var rand = colors[Math.floor(Math.random() * colors.length)];
        var btoa = vessel[i-1].btoa_side;

        
            
            if(btoa == "P"){ //kiri star
                $("#box"+i).css("left", vessel[i-1].berth_fr_metre+"px");
                $("#box"+i).css("width", vessel[i-1].width+"px");
                $("#box"+i).css("top", vessel[i-1].y_awal+"px");
                $("#box"+i).css("height", vessel[i-1].height+"px");
                $("#box"+i).css("background-color", rand);
                $("#text_judul"+i).css("padding-left", "24%");
                $("#text_detail"+i).css("padding-left", "25%");
               
                $("#box"+i).css("clip-path", "polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%)");

            
            }else if (btoa == "S") { //kanan port
                $("#box"+i).css("left", vessel[i-1].berth_fr_metre+"px");
                $("#box"+i).css("width", vessel[i-1].width+"px");
                $("#box"+i).css("top", vessel[i-1].y_awal+"px");
                $("#box"+i).css("height", vessel[i-1].height+"px");
                $("#box"+i).css("background-color", rand);
                $("#text_judul"+i).css("padding-left", "12px");
                $("#text_detail"+i).css("padding-left", "12px");
                // $("#img"+i).css("text-align", "left");
                // $("#img"+i).css("padding-left", "20px");
                // $("#img"+i).css("padding-top", "5px");
                $("#box"+i).css("clip-path", "polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%)");

            }

            $("#shadow_"+i).css("left", vessel[i-1].berth_fr_metre+"px");
            $("#shadow_"+i).css("width", vessel[i-1].width+"px");
            $("#shadow_"+i).css("top", (vessel[i-1].y_awal+vessel[i-1].height)+"px");
            $("#shadow_"+i).css("height", "10px");
            $("#shadow_"+i).css("background-color", "#000");
    
    }
    drawSysdate();
}

function loadAll(ocean) {
  
//    console.log(ocean);
    vessel =[];
    thisocean = ocean;
    $("#wrap_sw").empty();
    $.ajax({  
        url : "{{route('getvessel')}}",
        type : "get",
        dataType : "json",
        async : false,
        success : function(result){
            if (ocean == "I"){
                vessel = result.Intern;
                $("#canvas").css("width", "1004px");
                $("#rul1").css("display","block");
                $("#rul2").css("display","none"); 

            } else if (ocean == "D"){
                vessel = result.Domes;
                $("#canvas").css("width", "1004px");
                $("#rul1").css("display","block");
                $("#rul2").css("display","none");


            } else if (ocean == "C"){
                vessel = result.Curah;
                $("#canvas").css("width", "503px");
                $("#rul2").css("display","block");
                $("#rul1").css("display","none");
            }
            
            
            for (i = 1; i < vessel.length+1; ++i) {
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
                    '<div class="widget-inner">'+
                        '<div id="img'+i+'">'+
                             '<img id="ims'+i+'" class="ims" src = "{{asset('/img/')}}/'+vessel[i-1].image+'" style= "width: 20%; height: 20%; "/>'+
                        '</div>'+
                        '<div id="text_judul'+i+'" class="text_judul">'+
                            'MV. '+vessel[i-1].ves_name+''+
                        '</div>'+
                        '<div id="text_detail'+i+'" class="text_detail">'+
                            '<button onclick="toEdit('+(i-1)+')" class="btn_edit" id="btn_edit_'+i+'"><i class="fa fa-pencil"></i></button>'+
                            '<div style="margin:1px; color:red;">ETA :'+vessel[i-1].est_berth_ts+'</div>'+
                            '<div class="ETB_'+i+'" style="margin:1px;">ETB :'+vessel[i-1].est_berth_ts+'</div>'+
                            '<div class="ETD_'+i+'" style="margin:1px;">ETD : '+vessel[i-1].est_dep_ts+'</div>'+
                            '<div style="margin:1px; margin-left:2px; color:red; font-style: italic;">MOVES EST:'+vessel[i-1].est_load+'/'+vessel[i-1].est_discharge+' BOX</div>'+
                            '<div style="margin:1px;">LOA : '+vessel[i-1].width_ori+' M</div>'+
                            '<div style="margin:1px;">POD : '+vessel[i-1].dest_port+'</div>'+
                            ' <circle><span class="kade_box_'+i+'">'+vessel[i-1].berth_fr_metre_ori+' On '+vessel[i-1].berth_to_metre_ori+'</span></circle>'+
                            craneloopload+
                        '</div>'+
                    '</div>'+
                '</div>');
                // $("#canvas").append('<div id="box'+i+'" class="box draggable"><div class="text_judul"> MV. '+vessel[i-1].ves_name+'</div><div class="text_detail">ETA : '+vessel[i-1].est_berth_ts+'<br>ETB : '+vessel[i-1].est_berth_ts+'<br>ETD : '+vessel[i-1].est_dep_ts+'</div>   </div>');
                convertToDrag();
                
            }
            for (i = 1; i < vessel.length+1; ++i) {
                // var r = () => Math.random() * 256 >> 0;
                // var color = `rgb(${r()}, ${r()}, ${r()})`;

                var colors = ['#FFC312','#ffe699','#9dc3e6','#a9d18e'];

                var rand = colors[Math.floor(Math.random() * colors.length)];
                var btoa = vessel[i-1].btoa_side;

                
                    
                    if(btoa == "P"){ //kiri star
                        $("#box"+i).css("left", vessel[i-1].berth_fr_metre+"px");
                        $("#box"+i).css("width", vessel[i-1].width+"px");
                        $("#box"+i).css("top", vessel[i-1].y_awal+"px");
                        $("#box"+i).css("height", vessel[i-1].height+"px");
                        $("#box"+i).css("background-color", rand);
                        $("#text_judul"+i).css("padding-left", "24%");
                        $("#text_detail"+i).css("padding-left", "25%");
                       
                        $("#box"+i).css("clip-path", "polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%)");

                    
                    }else if (btoa == "S") { //kanan port
                        $("#box"+i).css("left", vessel[i-1].berth_fr_metre+"px");
                        $("#box"+i).css("width", vessel[i-1].width+"px");
                        $("#box"+i).css("top", vessel[i-1].y_awal+"px");
                        $("#box"+i).css("height", vessel[i-1].height+"px");
                        $("#box"+i).css("background-color", rand);
                        $("#text_judul"+i).css("padding-left", "12px");
                        $("#text_detail"+i).css("padding-left", "12px");
                        // $("#img"+i).css("text-align", "left");
                        // $("#img"+i).css("padding-left", "20px");
                        // $("#img"+i).css("padding-top", "5px");
                        $("#box"+i).css("clip-path", "polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%)");

                    }
            
            }

          
        }
    });

    
}
var nama =[];
var width=[];
var id_vess = [];
var ocean_ori = [];
var vess_code=[];
var cek = [];
var cok =[];
crane = [];
var crane_select=[];
// console.log(crane);

$('#edit_start').on('change', function(){
    var vees = vessel[m_index_edit];
    $('#edit_end').val(parseInt($(this).val())+parseInt(vees.width_ori));
});

function toEdit(index) {
    m_index_edit = index;
    var vees = vessel[index];
    console.log(vees);
    $('#editVessel').modal('show');
    $('#edit_vessel').val(vees.ves_id);
    $('#edit_vessel_name').val(vees.ves_name);
    $('#edit_eta').val(vees.est_berth_ts.substring(0,16).replace(" ", "T"));
    $('#edit_rbt').val(vees.est_berth_ts.substring(0,16).replace(" ", "T"));
    $('#edit_etb').val(vees.est_berth_ts.substring(0,16).replace(" ", "T"));
    $('#edit_etd').val(vees.est_dep_ts.substring(0,16));
    $('#edit_bsh').val(vees.bsh);
    $('#edit_nextp').val(vees.next_port);
    $('#edit_deshp').val(vees.dest_port);
    $('#edit_bongkar').val(vees.est_discharge);
    $('#edit_muat').val(vees.est_load);
    $('#edit_start').val(vees.berth_fr_metre_ori);
    $('#edit_end').val(vees.berth_to_metre_ori);
    // $('.edit_side').val(vees.btoa_side);
    if(vees.btoa_side == 'S')
        $("#edit_side_s").attr('checked', 'checked');
    if(vees.btoa_side == 'P')
        $("#edit_side_p").attr('checked', 'checked');

    $('#edit_info').val(vees.info);

    var arr_crane = vees.crane.split(",");

    $("#edit_crane").empty();

    for (s= 1; s < m_crane_con.length+1; ++s){
        var checked = false;
        for(a=0; a<arr_crane.length; a++) {
            if(m_crane_con[s-1].che_name==arr_crane[a]) {
                checked = true;
                break;
            }
        }
        $("#edit_crane").append('<input type="checkbox" name="crane" id="checkbox'+m_crane_con[s-1].che_name+'" value="'+m_crane_con[s-1].che_name+'" class="crane" '+(checked?"checked":"")+' />'+
                                        '<label>STS '+m_crane_con[s-1].che_name+'</label><span> </span><span> </span>');
    }
}

    function CheckStack(area, rectangle)
    {

        console.log(area);
        console.log(rectangle);

        var a1 = rectangle.X;
        var a2 = rectangle.X + rectangle.Width;
        var b1 = rectangle.Y;
        var b2 = rectangle.Y + rectangle.Height;



        //if the node is inside click field
        if (area.X1 <= a1 && area.X2 >= a2 && area.Y1 <= b1 && area.Y2 >= b2)
            return true;
        //if mouseDownClick is inside the node or mouseUpClick is inside the node
        if ((area.X1 >= a1 && area.X1 <= a2 && area.Y1 >= b1 && area.Y1 <= b2) || (area.X2 >= a1 && area.X2 <= a2 && area.Y2 >= b1 && area.Y2 <= b2))
            return true;
        //if the corner node is inside click field
        if ((a1 >= area.X1 && a1 <= area.X2 && b1 >= area.Y1 && b1 <= area.Y2) ||
            (a2 >= area.X1 && a2 <= area.X2 && b2 >= area.Y1 && b2 <= area.Y2) ||
            (a2 >= area.X1 && a2 <= area.X2 && b1 >= area.Y1 && b1 <= area.Y2) ||
            (a1 >= area.X1 && a1 <= area.X2 && b2 >= area.Y1 && b2 <= area.Y2))
            return true;
        //if click field and the node intersect at vertical line node
        if (area.Y1 >= b1 && area.Y1 <= b2 && a1 >= area.X1 && a1 <= area.X2)
            return true;
        //if click field and the node intersect at horizontal line node
        if (b1 >= area.Y1 && b1 <= area.Y2 && area.X1 >= a1 && area.X1 <= a2)
            return true;

        return false;
    }

    function isVesselStack(area) {
        var isStack = false;
        for (i = 0; i < vessel.length; i++) {
            var rectangle = {
                X:parseInt(vessel[i].berth_fr_metre), 
                Y:parseInt(vessel[i].y_awal),
                Width:parseInt(vessel[i].width),
                Height:parseInt(vessel[i].height)
            }

            isStack = CheckStack(area, rectangle);
            if(isStack)
                break;
        }
        return isStack;
    }

function addvessel(){

    var vessid ="";
    var etA ="";
    var rbT="";
    var etB="";
    var etD="";
    var sts="";
    var kade_start ="";
    var kade_to="";

    var bsh="";
    var next_port="";
    var dest_port="";
    var jum_bongkar="";
    var jum_muat="";
    var along_side= "";
    var info ="";
    var crane_string="";

    var type_moves = "";

    crane_select = [];
    
    if($("#con").is(':checked')){
    
        vessid = document.getElementById("vessel2").value;
        etA = document.getElementById("etA").value; 
        rbT = document.getElementById("rbT").value;
        etB = document.getElementById("etB").value; 
        etD = document.getElementById("etD").value; 
        // sts = $("input:checkbox[name=crane]:checked").each(function(){
        //           crane.push($(this).val());
        //             });

        $('.crane:checked').each(function(){
            crane_select.push($(this).val());
            });
        
        // crane_string =crane_select.toString()


        bsh = document.getElementById("bsh").value; 
        next_port = document.getElementById("nextP").value; 
        dest_port = document.getElementById("deshP").value; 
        jum_bongkar = document.getElementById("bongkar").value;
        jum_muat= document.getElementById("muat").value;

        along_side=  $('input[name=option]:checked').val();

        kade_start = document.getElementById("start").value;
        kade_to= document.getElementById("end").value;
        info= document.getElementById("info").value;
        
        type_moves = "BOX";

    } else if($("#dry").is(':checked')){
       
        vessid = document.getElementById("vessel3").value;
        etA = document.getElementById("etADry").value; 
        rbT = document.getElementById("rbTDry").value;
        etB = document.getElementById("etBDry").value; 
        etD = document.getElementById("etDDry").value; 

        $('.crane:checked').each(function(){
        crane_select.push($(this).val());
        });

        // crane_string =crane_select.toString()
        

        bsh = document.getElementById("tghDry").value; 
        next_port = document.getElementById("nextPDry").value; 
        dest_port = document.getElementById("deshPDry").value; 
        jum_bongkar = document.getElementById("bongkarDry").value;
        jum_muat= "0";
        info= document.getElementById("infoDry").value;


        along_side=  $('input[name=optionDry]:checked').val();

        kade_start = document.getElementById("startDry").value;
        kade_to= document.getElementById("endDry").value;

        type_moves = "MT";
 
    }
    
        var date_now = new Date();
            date_now.setHours(00);
            date_now.setMinutes(00);
            date_now.setSeconds(00);

        const format9 = "YYYY-MM-DD HH:mm:ss"
            var etAout= moment(etA).format(format9);
            var rbTout= moment(rbT).format(format9);
            var etBout= moment(etB).format(format9);
            var etDout= moment(etD).format(format9);
            date_now = moment(date_now).format(format9);

        // start ETB
        var tglPertama = Date.parse(etBout);
        var tglKedua = Date.parse(date_now);
        var miliday = 60 * 1000;
        // var top1 = etBout-date_now;
        var second =(tglPertama-tglKedua)/miliday;
        var y_awal_etb = (second/30)*10;    
        // console.log("y awal etb",y_awal_etb);    
        // end ETB

        // start ETD
        var tglPertamaEtd = Date.parse(etDout);
        var tglKeduaEtd = Date.parse(etBout);
        var secondEtd =(tglPertamaEtd-tglKeduaEtd)/miliday;
        var y_akhir_etd = (secondEtd/30)*10;

        //  console.log("y akhir etd",y_akhir_etd);
        // end ETD

  
    
        $.ajax({  
            url : "{{ url('VesselBerthPlan3/addvessel') }}",
            data: {
            "_token": "{{ csrf_token() }}",
            param_data:vessid
            },
            type : "post",
            dataType : "json",
            async : false,
            success : function(result){
                console.log(result);
                nama = result[0].ves_name;
                width = result[0].width;
                height = result[0].height;
                id_vess = result[0].ves_id;
                
                ocean_ori = result[0].ocean_interisland;
                var ves_type = result[0].ves_type;


                vess_code = result[0].ves_code;
                agent = result[0].agent;
                agent_name = result[0].agent_name;
                img = result[0].image;
                var width_ves = result[0].ves_len;
                var crane2=crane_select;
                var kd_start = kade_start*2;
                var kd_end = parseInt(kade_start)+parseInt(width_ves);


                var area = {
                    X1:parseInt(kd_start),
                    X2:parseInt(kd_start)+parseInt(width),
                    Y1:parseInt(y_awal_etb),
                    Y2:parseInt(y_awal_etb)+parseInt(y_akhir_etd)
                }

                var isStack = isVesselStack(area);

                
                if(!isStack) {
                    // var kade_end= kade_start+width;
                   
                    // var countol = result.length;
                    // var count = $('.box').length;
                   
                    for (i = 1; i < vessel.length+1; ++i) {
                    // var r = () => Math.random() * 256 >> 0;
                    // var color = `rgb(${r()}, ${r()}, ${r()})`;

                    var colors = ['#FFC312', '#006266', '#1289A7', '#EE5A24', '#B53471'];

                    var rand = colors[Math.floor(Math.random() * colors.length)];
                    }
                   

                    if (cok.includes(id_vess)){
                        crane = [];
                        swal({
                            title: "Kapal Sudah Ditambahkan !! Simpan Terlebih Dahulu !!",
                            text: "You clicked the button!",
                            icon: "warning",
                            });                   
                    } else {
                      
                        var craneloop2 = "";
                            for (var x = 0; x < crane_select.length; x++) { //Move the for loop from here
                                craneloop2 += '<circle2><span>'+crane_select[x]+'</span></circle2>';
                            };
                        $("#wrap_sw").append(
                            '<div id="box'+(vessel.length+1)+'" urutan="'+(vessel.length+1)+'" class="box draggable">'+
                                '<div class="widget-inner">'+
                                    '<div id="img'+(vessel.length+1)+'">'+
                                        '<img id="ims'+(vessel.length+1)+'" class="ims" src = "{{asset('/img/')}}/'+img+'" style= "width: 20%; height: 20%; "/>'+
                                    '</div>'+
                                    '<div id="text_judul'+(vessel.length+1)+'" class="text_judul">'+
                                        'MV. '+nama+''+
                                    '</div>'+
                                    '<div id="text_detail'+(vessel.length+1)+'" class="text_detail">'+
                                        '<button onclick="toEdit('+(i-1)+')" class="btn_edit" id="btn_edit_'+i+'"><i class="fa fa-pencil"></i></button>'+
                                        '<div style="margin:1px; color:red;">ETA :'+etBout+'</div>'+
                                        '<div class="ETB_'+(vessel.length+1)+'" style="margin:1px;">ETB :'+etBout+'</div>'+
                                        '<div class="ETD_'+(vessel.length+1)+'" style="margin:1px;">ETD : '+etDout+'</div>'+
                                        '<div style="margin:1px; margin-left:2px; color:red; font-style: italic;">MOVES EST:'+jum_bongkar+'/'+jum_muat+' '+type_moves+'</div>'+
                                        '<div style="margin:1px;">LOA : '+width_ves+' M</div>'+
                                        '<div style="margin:1px;">POD : '+dest_port+'</div>'+
                                        ' <circle><span class="kade_box_'+(vessel.length+1)+'">'+kade_start+' On '+kd_end+'</span></circle>'+
                                        craneloop2+
                                    '</div>'+
                                '</div>'+
                            '</div>');

                            convertToDrag();
                            
                            

                        // $("#canvas").append('<div id="box'+(vessel.length+1)+'" class="box draggable"><div class="text_judul"> MV. '+nama+'</div></div>');
                        if (along_side == "P") { //kiri
                                $("#box"+(vessel.length+1)).css("width",width+"px");
                                $("#box"+(vessel.length+1)).css("left",kd_start+"px");
                                $("#box"+(vessel.length+1)).css("height",y_akhir_etd+"px");
                                $("#box"+(vessel.length+1)).css("top",y_awal_etb+"px");
                                $("#box"+(vessel.length+1)).css("background-color", rand);

                                $("#text_judul"+(vessel.length+1)).css("padding-left", "24%");
                                $("#text_detail"+(vessel.length+1)).css("padding-left", "25%");
                                $("#img"+(vessel.length+1)).css("text-align", "right");
                                $("#img"+(vessel.length+1)).css("padding-right", "20px");
                                $("#img"+(vessel.length+1)).css("padding-top", "5px");
                                $("#box"+(vessel.length+1)).css("clip-path", "polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%)");
                                vessel.push({ves_type:ves_type,info:info,bsh:bsh,next_port:next_port,dest_port:dest_port,est_discharge:jum_bongkar,est_load:jum_muat,btoa_side:along_side ,crane:crane2, agent:agent, agent_name:agent_name,image:img,ves_id: id_vess, ves_name:nama, ocean_interisland:ocean_ori,ves_code:vess_code, est_berth_ts:null, is_simulation:"1" });
                                cok.push(id_vess);
                                crane = [];
                                 console.log("Add vess P",vessel);

                               
                        } else if (along_side == "S") { //kanan
                                $("#box"+(vessel.length+1)).css("width",width+"px");
                                $("#box"+(vessel.length+1)).css("left",kd_start+"px");
                                $("#box"+(vessel.length+1)).css("height",y_akhir_etd+"px");
                                $("#box"+(vessel.length+1)).css("top",y_awal_etb+"px");
                                $("#box"+(vessel.length+1)).css("background-color", rand);

                                $("#text_judul"+(vessel.length+1)).css("padding-left", "12px");
                                $("#text_detail"+(vessel.length+1)).css("padding-left", "12px");
                                $("#img"+(vessel.length+1)).css("text-align", "left");
                                $("#img"+(vessel.length+1)).css("padding-left", "20px");
                                $("#img"+(vessel.length+1)).css("padding-top", "5px");

                                $("#box"+(vessel.length+1)).css("clip-path", "polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%)");
                                vessel.push({ves_type:ves_type,info:info,bsh:bsh,next_port:next_port,dest_port:dest_port,est_discharge:jum_bongkar,est_load:jum_muat,btoa_side:along_side ,crane:crane2, agent:agent, agent_name:agent_name,image:img,ves_id: id_vess, ves_name:nama, ocean_interisland:ocean_ori,ves_code:vess_code, est_berth_ts:null, is_simulation:"1" });
                                cok.push(id_vess);
                                crane = [];
                                console.log("Add vess S",vessel);

                        }
                      
                        
                    }

                    eraseTextModalContainer();
                    
                } else {
                    swal({
                        title: "Vessel",
                        text: "Kapal Tumpuk",
                        icon: "warning",
                    });
                }
                
            }
        });
    
}

function editvessel() {

    var vees = vessel[m_index_edit];
    var vees_tmp = JSON.parse(JSON.stringify(vessel[m_index_edit]));

    vees.act_berth_ts   = $('#edit_eta').val().replace('T', ' ')+":00";
    vees.act_dep_ts     = $('#edit_eta').val().replace('T', ' ')+":00";
    vees.est_berth_ts   = $('#edit_etb').val().replace('T', ' ')+":00";
    vees.est_dep_ts     = $('#edit_etd').val().replace('T', ' ')+":00";
    vees.ves_id         = $('#edit_vessel').val();
    vees.btoa_side      =  $('input[class=edit_side]:checked').val();
    vees.bsh            = $('#edit_bsh').val();
    vees.next_port      = $('#edit_nextp').val();
    vees.dest_port      = $('#edit_deshp').val();
    vees.est_disch      = $('#edit_bongkar').val();
    vees.est_discharge  = $('#edit_bongkar').val();
    vees.est_load       = $('#edit_muat').val();
    vees.berth_fr_metre = (parseInt($('#edit_start').val())*2).toString();
    vees.berth_to_metre = (parseInt($('#edit_end').val())*2).toString();
    vees.berth_fr_metre_ori = (parseInt($('#edit_start').val())).toString();
    vees.berth_to_metre_ori = (parseInt($('#edit_end').val())).toString();

    var vessid ="";
    var etA ="";
    var rbT="";
    var etB="";
    var etD="";
    var sts="";
    var kade_start ="";
    var kade_to="";

    var bsh="";
    var next_port="";
    var dest_port="";
    var jum_bongkar="";
    var jum_muat="";
    var along_side= "";
    var info ="";
    var crane_string="";
    
    vessid = document.getElementById("edit_vessel").value;
    etA = document.getElementById("edit_eta").value; 
    rbT = document.getElementById("edit_rbt").value;
    etB = document.getElementById("edit_etb").value; 
    etD = document.getElementById("edit_etd").value;


    bsh = document.getElementById("edit_bsh").value; 
    next_port = document.getElementById("edit_nextp").value; 
    dest_port = document.getElementById("edit_deshp").value; 
    jum_bongkar = document.getElementById("edit_bongkar").value;
    jum_muat= document.getElementById("edit_muat").value;

    kade_start = document.getElementById("edit_start").value;
    kade_to= document.getElementById("edit_end").value;
    info= document.getElementById("edit_info").value;
 

    var date_now = new Date();
        date_now.setHours(00);
        date_now.setMinutes(00);
        date_now.setSeconds(00);

    const format9 = "YYYY-MM-DD HH:mm:ss"
        var etAout= moment(etA).format(format9);
        var rbTout= moment(rbT).format(format9);
        var etBout= moment(etB).format(format9);
        var etDout= moment(etD).format(format9);
        date_now = moment(date_now).format(format9);

    // start ETB
    var tglPertama = Date.parse(etBout);
    var tglKedua = Date.parse(date_now);
    var miliday = 60 * 1000;
    // var top1 = etBout-date_now;
    var second =(tglPertama-tglKedua)/miliday;
    var y_awal_etb = (second/30)*10;    
    // console.log("y awal etb",y_awal_etb);    
    // end ETB


    var tglPertamaEtd = Date.parse(etDout);
    var tglKeduaEtd = Date.parse(etBout);
    var secondEtd =(tglPertamaEtd-tglKeduaEtd)/miliday;
    var height = (secondEtd/30)*10;


    vees.y_awal     = y_awal_etb.toString();
    vees.y_akhir    = height.toString();
    vees.height     = height.toString();


    vessel.splice(m_index_edit, 1);


    var area = {
        X1:parseInt(vees.berth_fr_metre),
        X2:parseInt(vees.berth_fr_metre)+parseInt(vees.width),
        Y1:parseInt(y_awal_etb),
        Y2:parseInt(y_awal_etb)+parseInt(height)
    }

    var isStack = isVesselStack(area);

    if(!isStack) {
        vessel.splice(m_index_edit, 0, vees);
    } else {
        swal({
            title: "Vessel",
            text: "Kapal Tumpuk",
            icon: "warning",
        });
        vessel.splice(m_index_edit, 0, vees_tmp);
    }

    reloadAll();

}

function convertToDrag() {   
    var xSave;
    var ySave;
    $('.box')
    .draggable({
        containment: "#canvas",
        // obstacle:".butNotHere",
        // preventCollision: true,
        grid: [ 4, 10 ],
        scroll: false,
        stack: '.box',
        drag: function(event, ui) {

            otop =  $(this).position().top;
            left =  $(this).position().left;
            height =  $(this).height();
            width =  $(this).width();

            var area = {
                X1:left,
                X2:left+width,
                Y1:otop,
                Y2:otop+height
            }

            var urutan = $(this).attr('urutan')-1;
            var isBreak = false;


            for (i = 0; i < vessel.length; i++) {

                if(i!=urutan) {

                    var rect = {
                        X1:$('#box'+(i+1)).position().left, 
                        Y1:$('#box'+(i+1)).position().top,
                        X2:$('#box'+(i+1)).position().left+$('#box'+(i+1)).width(),
                        Y2:$('#box'+(i+1)).position().top+$('#box'+(i+1)).height()
                    }

                    var selisihKanan = rect.X1 - area.X2;
                    var selisihKiri = area.X1 - rect.X2;

                    selisihKanan    = selisihKanan<0?0:selisihKanan;
                    selisihKiri     = selisihKiri<0?0:selisihKiri;
                    
                    if((rect.Y2 >= area.Y1 && rect.Y2<= area.Y2) || 
                        (rect.Y2 >= area.Y2 && rect.Y1<= area.Y2) || 
                        (rect.Y2 >= area.Y2 && rect.Y1<= area.Y1) || 
                        (rect.Y1 >= area.Y1 && rect.Y2<= area.Y2)) {

                        $( "#selisihKanan" ).remove();
                        $( "#selisihKiri" ).remove();

                        if(selisihKanan < 40 && selisihKanan > 0) {
                            $("#wrap_sw").append("<div id='selisihKanan' "+
                                "style='position:absolute; left:"+(area.X2+5)+"px; top:"+(area.Y1+width/2)+"px; color:#000; background-color:#fff'>"+
                                parseInt(selisihKanan/2)+"m"+
                                "</div>");
                            isBreak = true;
                        }
                        if(selisihKiri < 40 && selisihKiri > 0) {
                            $("#wrap_sw").append("<div id='selisihKiri' "+
                                "style='position:absolute; left:"+(area.X1-20)+"px; top:"+(area.Y1+width/2)+"px; color:#000; background-color:#fff'>"+
                                parseInt(selisihKiri/2)+"m"+
                                "</div>");
                            isBreak = true;
                        }
                    }
                }

                if(isBreak) 
                    break;

            }
        },
        start: function (event,ui) {
            // console.log("start");
            top = $(this).position().top;
            left =  $(this).position().left;
            // $(this).removeClass('butNotHere');

            // save coordinates for collision detection.
            xSave = $(this).position().left;
            ySave = $(this).position().top;
            var $el = $(this);
            var $elSibs = $(this).siblings('.box');
            // DETECT COLLISION
            $elSibs.each(function() {
                var self = this;
                var $sib = $(self);
                collision($sib, $el);
            });
        },
      
        stop: function (event,ui) {
            // console.log("stop");
            $( "#selisihKanan" ).remove();
            $( "#selisihKiri" ).remove();

            topp = $(this).position().top;
            startW = $(this).outerWidth()/2;
            kiri =  $(this).position().left/2;
            bto = kiri+startW;
            
            var menit = (topp/10)*30;
            var height = (($(this).outerHeight()+topp)/10)*30;
            // var height_etd = $(this).outerHeight();
            var date = new Date();
                date.setHours(00);
                date.setMinutes(00);
                date.setSeconds(00);
            var date2 = new Date();
                date2.setHours(00);
                date2.setMinutes(00);
                date2.setSeconds(00);

           
            var tanggaletb =  date.setMinutes(date.getMinutes() + menit);
            var tanggaletd = date2.setMinutes(date2.getMinutes() + height);
               

            const format = "YYYY-MM-DD HH:mm:ss"
            var etb= moment(tanggaletb).format(format);
            var etd= moment(tanggaletd).format(format);
            // console.log(etb);
            // console.log(etd);
           

            var urutan = $(this).attr('urutan');
          
            
            // $('#results').text('top: '+ menit);
            var math_kiri = Math.round(kiri);
            var math_bto = Math.round(bto);
            $('.kade_box_'+urutan).text(math_kiri+' On '+ math_bto);
            $('.ETB_'+urutan).text('ETB :'+etb);
            $('.ETD_'+urutan).text('ETD :'+etd);

            
            var $el = $(this);
            var $elSibs = $(this).siblings('.box');
            $el.removeClass('dragging');
            $elSibs.addClass('not-dragging');


            // DETECT COLLISION
            $elSibs.each(function() {
                var self = this;
                var $sib = $(self);
                // collision($sib, $el);
                var result = collision($sib, $el, true);
                // if there is collision, we send back to start position.
                if(result == true) {

                    // alert("dilarang tabrak");
                    $el.css({'top':ySave, 'left':xSave});
                    $sib.find('.widget-inner').removeClass('collision');
                }
            });

            var x1 = left;
            var x2 = left + $(this).width(); 

            for (var i = 0; i < m_blokirkade.length; i++) {

                if(m_blokirkade[i].param2 == m_dermaga_current) {
                    var a1 = m_blokirkade[i].param3*2;
                    var a2 = m_blokirkade[i].param4*2;

                    if((x1 < a1 && x2 > a1) || 
                        (x1 < a2 && x2 > a2) || 
                        (x1 < a1 && x2 > a2) || 
                        (x1 > a1 && x2 < a2)) {

                        $el.css({'top':ySave, 'left':xSave});

                        break;
                    }
                }

            }

            urutan = $(this).attr('urutan')-1;

            vessel[urutan].y_awal = parseInt(topp).toString();
            vessel[urutan].height =  parseInt($(this).height()).toString();
            vessel[urutan].berth_fr_metre =  parseInt($(this).position().left).toString();
            vessel[urutan].berth_to_metre =  parseInt(($(this).position().left+$(this).width())).toString();
            vessel[urutan].berth_fr_metre_ori =  vessel[urutan].berth_fr_metre/2;
            vessel[urutan].berth_to_metre_ori =  vessel[urutan].berth_to_metre/2;

        }
    })

    .resizable({
  
        //Other options
        grid: 2,
        handles: 's',
         containment: "#canvas",
        // maxWidth: 100, //digunkan untuk change width

        start : function(event,ui) {
            startW = $(this).outerWidth();
            startH = $(this).outerHeight();

             // save coordinates for collision detection.
            xSave = $(this).outerWidth();
            ySave = $(this).outerHeight();
            var $el = $(this);
            var $elSibs = $(this).siblings('.box');
            // DETECT COLLISION
            $elSibs.each(function() {
                var self = this;
                var $sib = $(self);
                collision($sib, $el);
            });
         

        },
        stop : function(event,ui) {
            endW = $(this).outerWidth();
            endH = $(this).outerHeight();
            topp = $(this).position().top;
            // $( '#box1' ).height(120)
            // alert(endW)
            $('#panjang').text('Width: ' + (endW) + ' ' + 'Height: ' + (endH));
            // alert("width changed: "+ (endW-startW) + " And Height changed: " + (endH-endW));

            var urutan2 = $(this).attr('urutan');
            var height = (($(this).outerHeight()+topp)/10)*30;
            var date3 = new Date();
                date3.setHours(00);
                date3.setMinutes(00);
                date3.setSeconds(00);

            var tanggaletdz = date3.setMinutes(date3.getMinutes() + height);
            const format1 = "YYYY-MM-DD HH:mm:ss"
            var etdz= moment(tanggaletdz).format(format1);
            // console.log(etdz);
            $('.ETD_'+urutan2).text('ETD :'+etdz);


            var $el = $(this);
            var $elSibs = $(this).siblings('.box');
            $el.removeClass('dragging');
            $elSibs.addClass('not-dragging');
            // DETECT COLLISION
            $elSibs.each(function() {
                var self = this;
                var $sib = $(self);
                // collision($sib, $el);
                var result = collision($sib, $el);
                // if there is collision, we send back to start position.
                if(result == true) {

                    // alert("dilarang tabrak");
                    $el.css({'height':ySave, 'width':xSave});
                    $sib.find('.widget-inner').removeClass('collision');
                }
            });
        
        }
    }); 

    // Collision detection
    function collision($sib, $el, isStop=false) {
        var sibInner = $sib.find('.widget-inner');
        var wigInner = $el.find('.widget-inner');
        var x1 = wigInner.offset().left;
        var y1 = wigInner.offset().top; 
        var h1 = wigInner.outerHeight(true); 
        var w1 = wigInner.outerWidth(true); 
        var b1 = y1 + h1; 
        var r1 = x1 + w1; 
        var x2 = sibInner.offset().left; 
        var y2 = sibInner.offset().top; 
        var h2 = sibInner.outerHeight(true); 
        var w2 = sibInner.outerWidth(true); 
        var b2 = y2 + h2; 
        var r2 = x2 + w2; 

        // CHECK FOR COLLISION
        if (     (r1 >= x2 && b1 >= y2 && y1 < y2 && x1 < r2)
                || (x1 <= r2 && b1 >= y2 && y1 < y2 && r1 > r2)
                || (r1 >= x2 && y1 <= b2 && b1 > b2 && x1 < x2)
                || (x1 <= r2 && y1 <= b2 && b1 > b2 && r1 > r2)
                || (y1 == y2 && r1 == r2 && b1 == b2 && x1 == x2)
                || (y1 >= y2 && x1 < r2 && b1 <= b2 && r1 > r2)
                || (y1 >= y2 && r1 >= x2 && b1 <= b2 && x1 < x2)
                || (x1 >= x2 && r1 <= r2 && y1 <= b2 && b1 > b2)
                || (x1 >= x2 && y1 >= y2 && b1 <= b2 && r1 <= r2)
             ) 
        {
            sibInner.addClass('collision');
            return true;
            
        } else { 
            sibInner.removeClass('collision');
        }

    }
}

function convertToDragNote() {
    $('#box_note_'+m_note_index)
    .draggable({
        containment: "#canvas",
        grid: [ 4, 10 ],
        scroll: false,
        drag: function(event, ui) {

        },
        start: function (event,ui) {
            
        },
      
        stop: function (event,ui) {
            
        }
    })
    .resizable({
        grid: 2,
        containment: "#canvas",
        start : function(event,ui) {
            
        },
        stop : function(event,ui) {
            
        }
    });
}

function eraseTextModalContainer() {
    if($("#con").is(':checked')){
     document.getElementById("etA").value = "";
     document.getElementById("rbT").value = "";
     document.getElementById("etB").value = "";
     document.getElementById("etD").value = "";

     var checkboxes= document.getElementsByClassName("crane");
     for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
        }

     document.getElementById("nextP").value = "";
     document.getElementById("deshP").value = "";
     document.getElementById("bsh").value = "";
     document.getElementById("bongkar").value = "";
     document.getElementById("muat").value = "";
     document.getElementById("start").value = "";
     document.getElementById("end").value = "";

     var checkboxes= document.getElementsByClassName("side");
     for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
        }
    document.getElementById("info").value = "";

    } else if($("#dry").is(':checked')) {

   
     document.getElementById("etADry").value = "";
     document.getElementById("rbTDry").value = "";
     document.getElementById("etBDry").value = "";
     document.getElementById("etDDry").value = "";

     var checkboxes= document.getElementsByClassName("craneDry");
     for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
        }

     document.getElementById("nextPDry").value = "";
     document.getElementById("deshPDry").value = "";
     document.getElementById("tghDry").value = "";

     document.getElementById("bongkarDry").value = "";
   
     document.getElementById("startDry").value = "";
     document.getElementById("endDry").value = "";

     var checkboxes= document.getElementsByClassName("sideDry");
     for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
        }
    document.getElementById("infoDry").value = "";
    }

}

function updatebox() {
   
    var count = $('.box').length;
    var top_arr = [];
    cek = [];
    cok = ["0"];

    for (i = 1; i < count+1 ; ++i){
        
        var height =  parseInt($('#box'+i).css('height')) ;
        var top =  parseInt($('#box'+i).css('top')); // Y.Awal
        var width_ori =  parseInt($('#box'+i).css('width'))/2;
        var width =  parseInt($('#box'+i).css('width'));
        var left =  parseInt($('#box'+i).css('left'));
  
        var ves_id = vessel[i-1].ves_id; //ves_id yang ada di planning
        // var ves_id_master = dermaga[i-1].ves_id //ves_id yang ada di master
        var berth_to_ori = (width+left)/2;
        var berth_fr_ori = left/2;
        var y_awal = top;
        var y_akhir = top + height;
        var est_berth_ts = vessel[i-1].est_berth_ts;
        var occ = vessel[i-1].ocean_interisland;
        var name = vessel[i-1].ves_name;
        var code = vessel[i-1].ves_code;
        var img = vessel[i-1].image;
        var agent = vessel[i-1].agent;
        var is_simulation= vessel[i-1].is_simulation;
        var crane2=vessel[i-1].crane;

        var bsh = vessel[i-1].bsh;
        var next_port = vessel[i-1].next_port;
        var dest_port = vessel[i-1].dest_port;
        var jum_bongkar = vessel[i-1].est_discharge;
        var jum_muat = vessel[i-1].est_load;
        var along_side = vessel[i-1].btoa_side;
        var info = vessel[i-1].info;
        var vess_type = vessel[i-1].ves_type;

        
        
    top_arr.push({ves_type:vess_type,info:info,bsh:bsh,next_port:next_port,dest_port:dest_port,jum_bongkar:jum_bongkar,jum_muat:jum_muat,along_side:along_side,crane:crane2,is_simulation:is_simulation, agent:agent,height:height,y_awal:y_awal,y_akhir:y_akhir, top:top, width:width, left:left, ves_id:ves_id,berth_to_ori:berth_to_ori, berth_fr_ori:berth_fr_ori, est_berth_ts: est_berth_ts, occ:occ, name:name, code:code});
    }
    // console.log("top arr",top_arr);
    $.ajax({  
            url : "{{ url('VesselBerthPlan3/updatevessel') }}",
            data: {
            "_token": "{{ csrf_token() }}",
            // param_id:ves_id,
            param_vess:top_arr,
            param_ocean : thisocean,
            param_crane : crane
            // y_awal:top,
            // y_akhir:height,
            // fr_matre:left,
            // name : name,
            },
            type : "post",
            dataType : "json",
            async : false,
            success : function(result){
                if(result["sukses"] == true) {
                   
                    swal({
                        title: "Data Berhasil Diubah!",
                        text: "You clicked the button!",
                        icon: "success",
                        button: "Oke",
                        });
                    
                } else {
                    alert ("Data Gagal Diubah !!");
                }

            } 
        });
}

var printout = [];

function makeid(length) {
    var result           = '';
    var characters       = '0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * 
 charactersLength));
   }
   return result;
}

function print() {
  //window.open(pathString, target);
    
    
    var date_print = new Date();
    const format_date_print = "DD-MM-YYYY HH:mm:ss"

    var date_printout = moment(date_print).format(format_date_print);
    var param11= document.getElementById("berth_planner").value;
    var param22= document.getElementById("planing_manager").value;
    var nomor_doc=makeid(3);
    var no_doc ="BA."+nomor_doc+"/TI.02.03/PTTL-2021";

    // printout.push({date_print:date_printout,bp:param11,pm:param22})
    var link1 ="{{ URL::to('/Signature/qr')}}?bp="+param11+"&date="+date_printout+"&no_doc="+no_doc+"";
    var link2 ="{{ URL::to('/Signature/qr')}}?bp="+param22+"&date="+date_printout+"&no_doc="+no_doc+"";
    console.log("Link1", link1);


    
    
    

      window.open("{{ URL::to('/print') }}?param11="+param11+"&param22="+param22+"&link1="+encodeURIComponent(link1)+"&link2="+encodeURIComponent(link2), "_blank");
}


function wait() {
    var imgPath = "{{asset('img/ajax-loader.gif')}}";
    var img = '<img src="' + imgPath + '" style="margin-top: 5px;" />';

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
    // $.blockUI(
    //     {
    //         message: img,
    //         fadeIn: 400,
    //         fadeOut: 400,
    //         timeout: 20000,
    //         showOverlay: true,
    //         textAlign: 'center',
    //         centerY: true,
    //         centerX: true,
    //         css: {
    //             border: '',
    //             padding: '5px',
    //             backgroundColor: '#000',
    //             '-webkit-border-radius': '10px',
    //             '-moz-border-radius': '10px',
    //             'border-radius': '10px',
    //             opacity: 0.5,
    //             color: '#fff'
    //         },
    //         overlayCSS: { opacity: 0.1 }
    //     });
}

///
/// Hides the jQuery busy popup; to make this smooth on IE, give it
/// a reasonable amount of time to remain visible, in case the operation
/// was really short.
///
/// In this case, wait for 1.2 seconds before fading out the dialog
///

function normal() {
    $.unblockUI();
}
</script>
