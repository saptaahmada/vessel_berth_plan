<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script src="{{asset('asset/js/plugins/select2.full.min.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{asset('js/jquery.blockUI.js')}}"></script>


<script>
    var m_crane_con = [];
    var m_crane_dry = [];
    var m_index_edit = 0;
    var m_note_index = 0;
    var m_blokirkade = <?=$blokirkade?>;
    var m_note = [];
    var m_dermaga_current = 'D';
    var m_dermaga_last = null;
    var m_allowed_collision = false;
    var m_show_distance_vessel = false;
    var m_vessel_removed = [];

    var vessel=[];
    var dermaga =[];
    var thisocean = "D";
    var kd_end_glb = "";
    var vesselCurrent= ["0"];
    var m_vessel_unreg = [];
    var m_vessel_all;
    var m_kade_all;

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
                    // $("#vessel2").append('<option  name="next" value="">-- PILIH VESSEL --</option>');  
                    // $("#vessel3").append('<option  name="next" value="">-- PILIH VESSEL --</option>');

                    for (d = 1; d < result.Con.length+1; ++d) {
                        $("#vessel2").append('<option  value="'+result.Con[d-1].ves_id+'">'+result.Con[d-1].ves_code+' - '+result.Con[d-1].ves_name+' ('+result.Con[d-1].ves_type_name+')</option>');  
                    }
                    for (p = 1; p < result.Dry.length+1; ++p) {
                        $("#vessel3").append('<option  value="'+result.Dry[p-1].ves_id+'">'+result.Dry[p-1].ves_code+' - '+result.Dry[p-1].ves_name+' ('+result.Dry[p-1].ves_type_name+')</option>');  
                    }

                    // m_note = result.note;
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

                    for (i = 1; i < getport.length+1; ++i) {
                        $("#nextPDry").append('<option  name="next" value="'+getport[i-1].port+'">'+getport[i-1].port+' ('+getport[i-1].descr+') </option>');  
                        $("#nextP").append('<option  name="next" value="'+getport[i-1].port+'">'+getport[i-1].port+' ('+getport[i-1].descr+')</option>'); 

                        $("#deshPDry").append('<option  name="desh" value="'+getport[i-1].port+'">'+getport[i-1].port+' ('+getport[i-1].descr+') </option>');  
                        $("#deshP").append('<option  name="desh" value="'+getport[i-1].port+'">'+getport[i-1].port+' ('+getport[i-1].descr+')</option>'); 

                        $("#edit_nextp").append('<option  name="next" value="'+getport[i-1].port+'">'+getport[i-1].port+' ('+getport[i-1].descr+')</option>'); 
                        $("#edit_deshp").append('<option  name="next" value="'+getport[i-1].port+'">'+getport[i-1].port+' ('+getport[i-1].descr+')</option>');  

                        $("#unreg_nextp").append('<option  name="next" value="'+getport[i-1].port+'">'+getport[i-1].port+' ('+getport[i-1].descr+')</option>'); 
                        $("#unreg_deshp").append('<option  name="next" value="'+getport[i-1].port+'">'+getport[i-1].port+' ('+getport[i-1].descr+')</option>');  

                    }
                
                } 
            });


            $("#craneCon").empty();
            $("#craneDry").empty();
            $("#edit_crane").empty();
            $("#unreg_crane").empty();
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

                        $("#unreg_crane").append('<input type="checkbox" name="crane" id="unreg_checkbox'+result.Con[s-1].che_name+'" value="'+result.Con[s-1].che_name+'" class="unreg_crane" />'+
                                                            '<label>STS '+result.Con[s-1].che_name+'</label><span> </span><span> </span>');

                    }
                    for (u = 1; u < result.Dry.length+1; ++u){
                        $("#craneDry").append('<input type="checkbox" name="craneDry" id="checkbox'+result.Dry[u-1].che_name+'" value="'+result.Dry[u-1].che_name+'" class="crane" />'+
                                                            '<label>'+result.Dry[u-1].che_name+'</label><span> </span><span> </span>');
                        }
                }       
            });

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


            $(".select2-A").select2({
                placeholder: "Select..",
                allowClear: true
            });

            var imgPath = "{{asset('img/ajax-loader.gif')}}";
            var img = '<img src="' + imgPath + '" style="margin-top: 5px;" />';
            getVesselAll();
            getKadeAll();
            loadAll('D');
            kade('D');
            

            $("#cekbox1").click(function () {
  
                m_dermaga_last = m_dermaga_current;
                changeDermaga('D');
                loadAll('D');
                kade('D');
            });
            
            $("#cekbox2").click(function () {
                m_dermaga_last = m_dermaga_current;
                changeDermaga('I');
                loadAll('I');
                kade('I');
            });

            $("#cekbox3").click(function () {
                m_dermaga_last = m_dermaga_current;
                changeDermaga('C');
                loadAll('C');
                kade('C');

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

    function getVesselAll() {
        $.ajax({  
            url : "{{route('getvessel')}}",
            type : "post",
            data : {
                "_token": "{{ csrf_token() }}"
            },
            dataType : "json",
            async : false,
            success : function(result){
                m_vessel_all = result;
            }
        });
    }

    function getKadeAll() {
        
        $.ajax({  
            url : "{{route('getkade')}}",
            type : "get",
            dataType : "json",
            async : false,
            success : function(result){
                m_kade_all = result;
            }
        });

    }

    function changeDermaga(der) {

        $('.blokirkade').remove();

        for (var i = 0; i < m_blokirkade.length; i++) {
            if(m_blokirkade[i].param2 == der) {
                var width = (m_blokirkade[i].param4-m_blokirkade[i].param3)*2;
                var left = m_blokirkade[i].param3*2;
                $('#canvas').prepend(
                    "<div class='blokirkade' style='background-color: #b8b8b8; left: "+left+"px; width: "+width+"px; height: 100%; position: absolute;'></div>"
                );
            }
        }

        m_dermaga_current = der;
        // m_vessel_removed = [];

        
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

function getColor(param) {
    var green = '#a9d18e';
    var blue = '#9dc3e6';
    var yellow = '#ffe699';

    if(param == 0)
        return green;
    else if(param == 1)
        return blue;
    else if(param == 2)
        return yellow;
}

$('#vessel2').on('change', function() {
    getVessel();
})
$('#vessel3').on('change', function() {
    getVessel();
})
$('#btn_add_note').on('click', function() {

    var time = new Date().getTime();
    addBoxNote(m_note_index, time, $('#note').val(), 100, 100, 100, 80, true);
    m_note_index++;

});

function addBoxNote(index, time, text, left, top, width, height, isToAdd=false) {
    $("#wrap_sw").append(
        '<div id="box_note_'+index+'" code="'+time+'" urutan="'+index+'" class="box_note draggable">'+
            '<div class="widget-inner">'+
                '<div id="text_note_'+index+'" class="text_detail">'+
                    text+
                    '<br><button onclick="toDeleteNote('+index+')" class="btn_delete_note" id="btn_delete_note_'+index+'"><i class="fa fa-trash"></i></button>'+
                '</div>'+
            '</div>'+
        '</div>');

    convertToDragNote(index);

    $("#box_note_"+index).css("left", left+"px");
    $("#box_note_"+index).css("top", top+"px");
    $("#box_note_"+index).css("width", width+"px");
    $("#box_note_"+index).css("height", height+"px");
    $("#box_note_"+index).css("background-color", "#ff968f");

    if(isToAdd) {

        var newdate = new Date();
        const format90 = "YYYY-MM-DD HH:mm:ss"
        var start_date = moment(newdate).format(format90);

        m_note.push({
            code : time,
            height : height,
            ocean_interisland : m_dermaga_current,
            start_date : start_date,
            text : text,
            width : width,
            x : left,
            y : top,
        });
    }
}

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
  

    var vess_len = vesselCurrent.ves_len;
    var kde_end =parseInt(kde_start) + parseInt(vess_len);
    var newdate =new Date(etB);
        newdate.setMinutes(newdate.getMinutes() + estimasimenit);
    const format90 = "YYYY-MM-DD HH:mm:ss"
    var etBout= moment(etB).format(format90);
    var newdateoutCon = moment(newdate).format(format90);

   
    if (!isNaN(estimasimenit)) {
        if($("#con").is(':checked'))
            document.getElementById('etD').value = newdateoutCon.replace(" ", "T");
        else
            document.getElementById('etDDry').value = newdateoutCon.replace(" ", "T");
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

$('#unreg_start').on('change', function () {
    var end = parseInt($('#unreg_loa').val())+parseInt($(this).val());
    $('#unreg_end').val(end);
})
$('#unreg_etb').on('change', function () {
    changeUnregETD();
})
$('#unreg_bsh').on('change', function () {
    changeUnregETD();
})
$('#unreg_disc').on('change', function () {
    changeUnregETD();
})
$('#unreg_load').on('change', function () {
    changeUnregETD();
})
$('#unreg_start').on('change', function () {
    var end = parseInt($('#unreg_loa').val())+parseInt($(this).val());
    $('#unreg_end').val(end);
})
$('#edit_etb').on('change', function () {
    changeEditETD();
    // console.log("masuk etb");
})
$('#edit_bsh').on('change', function () {
    changeEditETD();
    // console.log("masuk etb");
})
$('#edit_disc').on('change', function () {
    changeEditETD();
})
$('#edit_load').on('change', function () {
    changeEditETD();
})
$('#cb_collision').on('change', function() {
    m_allowed_collision = $(this).is(":checked");
})
$('#cb_distance_vessel').on('change', function() {
    m_show_distance_vessel = $(this).is(":checked");
})

$('#edit_start').on('change', function () {
    var vees = vessel[m_index_edit];
    var end = parseInt(vees.width_ori)+parseInt($(this).val());
    $('#unreg_end').val(end);
})

function changeUnregETD() {
    var etB     = $('#unreg_etb').val();
    var disc    = $('#unreg_disc').val();
    var load    = $('#unreg_load').val();
    var bsh     = $('#unreg_bsh').val();
    var est_time= ((parseInt(disc)+parseInt(load))/parseInt(bsh))*60;

    var newdate =new Date(etB);
    newdate.setMinutes(newdate.getMinutes() + est_time);
    const format90 = "YYYY-MM-DD HH:mm"
    var etBout= moment(etB).format(format90);
    var newdateoutCon = moment(newdate).format(format90);
    $('#unreg_etd').val(newdateoutCon.replace(" ", "T"));
}

function changeEditETD() {
    var etB     = $('#edit_etb').val();
    var disc    = $('#edit_disc').val();
    var load    = $('#edit_load').val();
    var bsh     = $('#edit_bsh').val();
    var est_time= ((parseInt(disc)+parseInt(load))/parseInt(bsh))*60;

    var newdate = new Date(etB);
    newdate.setMinutes(newdate.getMinutes() + est_time);
    const format90 = "YYYY-MM-DD HH:mm"
    var etBout= moment(etB).format(format90);
    var newdateoutCon = moment(newdate).format(format90);

    $('#edit_etd').val(newdateoutCon.replace(" ", "T"));
}

function getVessel() {
    var vessid = "";
    if($("#con").is(':checked'))
        vessid = document.getElementById("vessel2").value;
    else
        vessid = document.getElementById("vessel3").value;

    console.log(vessid);

   $.ajax({  
        url : "{{ url('VesselBerthPlan3/addvessel') }}",
        type : "post",
        data: {
            "_token": "{{ csrf_token() }}",
            param_data:vessid
            },
        dataType : "json",
        async : false,
        success : function(result){
            vesselCurrent = result[0];
        }
    });
} 

function reloadShadow() {
    $(".shadow").remove();
    
    for (i = 1; i < vessel.length+1; ++i) {

        if(vessel[i-1].time_remain != null) {
            if(parseInt(vessel[i-1].time_remain)>0) {
                $("#wrap_sw").prepend("<div id='shadow_"+i+"' class='shadow' urutan="+i+"></div>");

                $("#shadow_"+i).css("left", vessel[i-1].berth_fr_metre+"px");
                $("#shadow_"+i).css("width", vessel[i-1].width+"px");
                $("#shadow_"+i).css("top", vessel[i-1].y_awal+"px");
                $("#shadow_"+i).css("position", "absolute");
                $("#shadow_"+i).css("height", vessel[i-1].height_est+"px");
                $("#shadow_"+i).css("background-color", "#969696");
                // $("#shadow_"+i).css("clip-path", "polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%)");
            }
        }
        
    }
}


function reloadNote() {
    $(".box_note").remove();

    for (i = 0; i < m_note.length; i++) {
        
        var note = m_note[i];

        if(m_dermaga_current == note.ocean_interisland) {
            console.log(note);
            addBoxNote(i, note.time, note.text, note.x, note.y, note.width, note.height);
            m_note_index=i;
        }


    }

    if(m_note.length>0)
        m_note_index++;
}

function reloadAll() {
    $("#wrap_sw").empty();
    
    for (i = 1; i < vessel.length+1; ++i) {
        $("#wrap_sw").append(getVesselContent(vessel[i-1], i));

        convertToDrag();
        
    }

    for (i = 1; i < vessel.length+1; ++i) {

        var btoa = vessel[i-1].btoa_side;

        if(vessel[i-1].act_berth_ts != null) {
            rand = getColor(0);
        } else if(vessel[i-1].tentatif == "1") {
            rand = getColor(2);
        } else if(vessel[i-1].tentatif == "0") {
            rand = getColor(1);
        }
            
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
    reloadShadow();
    reloadNote();
}

function getVesselContent(vees, i, craneloopload=null) {

    if(craneloopload == null) {
        craneloopload = "";

        if(vees.crane != null) {
            for (var x = 0; x < vees.crane.length; x++) { //Move the for loop from here
                craneloopload += '<circle2><span>'+vees.crane[x]+'</span></circle2>';
            };
        }
    }

    var font_size = "10px";

    if(parseInt(vees.height) > 250) {
        font_size = "12px";
    }

    var margin_top_crane = parseInt(vees.height)/3;

    var content = '<div id="box'+i+'" urutan="'+i+'" class="box draggable">'+
            '<div class="widget-inner">'+
                '<div id="img'+i+'">'+
                    (vees.is_unreg == 0 ? 
                     '<img id="ims'+i+'" class="ims" src = "{{asset('/img/')}}/'+vees.image+'" style= "width: 20%; height: 20%; "/>':'')+
                '</div>'+
                '<div id="text_judul'+i+'" class="text_judul">'+
                    'MV. '+vees.ves_name+' ('+ vees.ves_id + ')'+
                '</div>'+
                '<div id="text_detail'+i+'" class="text_detail" style="font-size:'+font_size+'">'+
                    '<div class="row">'+
                    '<div class="col-sm-7">'+
                        '<button onclick="toEdit('+(i-1)+')" class="btn_edit" id="btn_edit_'+i+'"><i class="fa fa-pencil"></i></button>'+
                        '<button onclick="toDelete('+(i-1)+')" class="btn_delete badge badge-danger" id="btn_delete_'+i+'"><i class="fa fa-trash"></i></button><br>'+
                        (vees.req_berth_ts!=null?'RBT :'+moment(vees.req_berth_ts).format('DD-MM-YY HH:mm')+'<br>':'')+
                        (vees.act_berth_ts!=null ? 
                            'ATB : '+moment(vees.act_berth_ts).format('DD-MM-YY HH:mm') + '<br>' : 
                            (vees.est_pilot_ts!=null?'ETA : '+moment(vees.est_pilot_ts).format('DD-MM-YY HH:mm')+'<br>':'')
                        )+
                        'ETB : '+moment(vees.est_berth_ts).format('DD-MM-YY HH:mm')+'<br>'+
                        'ETD : '+moment(vees.est_dep_ts).format('DD-MM-YY HH:mm')+'<br>'+
                        'LOA : '+vees.width_ori+' M<br>'+
                        'Moves est: '+vees.est_load+'/'+vees.est_discharge+' '+(vees.ocean_interisland_fake=='C'?'MT':'box')+'<br>'+
                        'POD : '+vees.dest_port+'<br>'+
                        (vees.ocean_interisland_fake != 'C' ? 
                            (vees.load_act != null ? 'LOAD BOX : '+vees.load_act+'/'+vees.load_plan+' => '+vees.load_remain + '<br>': '')+
                            (vees.disc_act != null ? 'DISC BOX : '+vees.disc_act+'/'+vees.disc_plan+' => '+vees.disc_remain + '<br>': '')+
                            (vees.time_remain != null ? (parseInt(vees.time_remain)>0? 'Est End Work : '+vees.est_end_date + '<br>':'') : '')+
                            (vees.time_remain != null ? (parseInt(vees.time_remain)>0? 'Est Done : '+vees.time_remain_label+' left' + '<br>':'') : '')
                        : '')+
                        'WINDOW : '+(vees.windows==1?'ON_WINDOW':'OFF_WINDOW')+'<br>'+
                    '</div>'+
                    '<div class="col-sm-4" style="margin-top:'+margin_top_crane+'px">'+
                        (vees.info!=null?'INFO :'+vees.info+'<br>':'')+
                    '</div>'+
                    ' <circle><span class="kade_box_'+i+'">'+vees.berth_fr_metre_ori+' On '+vees.berth_to_metre_ori+'</span></circle><br>'+
                    craneloopload+
                '</div>'+
            '</div>'+
        '</div>';

    // var content = '<div id="box'+i+'" urutan="'+i+'" class="box draggable">'+
    //         '<div class="widget-inner">'+
    //             '<div id="img'+i+'">'+
    //                 (vees.is_unreg == 0 ? 
    //                  '<img id="ims'+i+'" class="ims" src = "{{asset('/img/')}}/'+vees.image+'" style= "width: 20%; height: 20%; "/>':'')+
    //             '</div>'+
    //             '<div id="text_judul'+i+'" class="text_judul">'+
    //                 'MV. '+vees.ves_name+' ('+ vees.ves_id + ')'+
    //             '</div>'+
    //             '<div id="text_detail'+i+'" class="text_detail">'+
    //                 '<button onclick="toEdit('+(i-1)+')" class="btn_edit" id="btn_edit_'+i+'"><i class="fa fa-pencil"></i></button>'+
    //                 '<button onclick="toDelete('+(i-1)+')" class="btn_delete badge badge-danger" id="btn_delete_'+i+'"><i class="fa fa-trash"></i></button>'+
    //                 '<div class="ETA_'+i+'" style="margin:1px;">ETA :'+(vees.est_pilot_ts!=null?vees.est_pilot_ts.substring(0,16):'')+'</div>'+
    //                 (vees.req_berth_ts!=null?'<div class="RBT_'+i+'" style="margin:1px;">RBT :'+vees.req_berth_ts.substring(0,16)+'</div>':'')+
    //                 '<div class="ETB_'+i+'" style="margin:1px;">ETB :'+vees.est_berth_ts.substring(0,16)+'</div>'+
    //                 '<div class="ETD_'+i+'" style="margin:1px;">ETD : '+vees.est_dep_ts.substring(0,16)+'</div>'+
    //                 '<div style="margin:1px; margin-left:2px; color:red; font-style: italic;">MOVES EST:'+vees.est_load+'/'+vees.est_discharge+' '+(vees.ocean_interisland_fake=='C'?'MT':'BOX')+'</div>'+
    //                 '<div style="margin:1px;">LOA : '+vees.width_ori+' M</div>'+
    //                 '<div style="margin:1px;">POD : '+vees.dest_port+'</div>'+
    //                 (vees.ocean_interisland_fake != 'C' ? 
    //                     (vees.load_act != null ? '<div style="margin:1px;">LOAD BOX : '+vees.load_act+'/'+vees.load_plan+' => '+vees.load_remain+'</div>' : '')+
    //                     (vees.disc_act != null ? '<div style="margin:1px;">DISC BOX : '+vees.disc_act+'/'+vees.disc_plan+' => '+vees.disc_remain+'</div>' : '')+
    //                     (vees.time_remain != null ? (parseInt(vees.time_remain)>0? '<div style="margin:1px;">Est End Work : '+vees.est_end_date+'</div>':'') : '')+
    //                     (vees.time_remain != null ? (parseInt(vees.time_remain)>0? '<div style="margin:1px;">Est Done : '+vees.time_remain_label+' left</div>':'') : '')
    //                 : '')+
    //                 '<div style="margin:1px;">WINDOW : '+(vees.windows==1?'ON_WINDOW':'OFF_WINDOW')+'</div>'+
    //                 (vees.info!=null?'<div class="INFO_'+(i-1)+'">INFO :'+vees.info+'</div>':'')+
    //                 ' <circle><span class="kade_box_'+i+'">'+vees.berth_fr_metre_ori+' On '+vees.berth_to_metre_ori+'</span></circle>'+
    //                 craneloopload+
    //             '</div>'+
    //         '</div>'+
    //     '</div>';
    return content;
}

function switchDermaga() {
    if (m_dermaga_last == "I")
        m_vessel_all.Intern = vessel;
    else if (m_dermaga_last == "D")
        m_vessel_all.Domes = vessel;
    else if (m_dermaga_last == "C")
        m_vessel_all.Curah = vessel;
}

function loadAll(ocean) {

    $("#wrap_sw").empty();

    // switchDermaga();

    if (ocean == "I"){
        vessel = m_vessel_all.Intern;
        m_note = m_vessel_all.note_i;
        $("#Rintern").css("display","block");
        $("#Rdomes").css("display","none");
        $("#Rcur").css("display","none");
    } else if (ocean == "D"){
        vessel = m_vessel_all.Domes;
        m_note = m_vessel_all.note_d;
        $("#Rdomes").css("display","block");
        $("#Rintern").css("display","none");
        $("#Rcur").css("display","none");
    } else if (ocean == "C"){
        vessel = m_vessel_all.Curah;
        m_note = m_vessel_all.note_c;
        $("#Rcur").css("display","block");
        $("#Rdomes").css("display","none");
        $("#Rintern").css("display","none");
    }
    
    for (i = 1; i < vessel.length+1; ++i) {
        var windo = "";
        
        if (vessel[i-1].window == null)
        windo = "-";
        else 
        windo = vessel[i-1].window;

        var crane_vess =  vessel[i-1].crane;
        var uncrane=[];

        if (crane_vess==null)
            uncrane=[];
        else {
            if(Array.isArray(crane_vess))
                uncrane = crane_vess;
            else
                uncrane = crane_vess.split(',');
        }

        var craneloopload = "";
        for (var x = 0; x < uncrane.length; x++) { //Move the for loop from here
            craneloopload += '<circle2><span>'+uncrane[x]+'</span></circle2>';
        };

        $("#wrap_sw").append(getVesselContent(vessel[i-1], i, craneloopload));

        vessel[i-1].crane = uncrane;

        convertToDrag();
        
    }
    for (i = 1; i < vessel.length+1; ++i) {

        var btoa = vessel[i-1].btoa_side;

        if(vessel[i-1].act_berth_ts != null) {
            rand = getColor(0);
        } else if(vessel[i-1].tentatif == "1") {
            rand = getColor(2);
        } else if(vessel[i-1].tentatif == "0") {
            rand = getColor(1);
        }

        
            
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


    reloadShadow();
    reloadNote();

    
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
    $('#edit_eta').val((vees.est_pilot_ts != null ? vees.est_pilot_ts.substring(0,16).replace(" ", "T") : ''));
    $('#edit_rbt').val((vees.req_berth_ts != null ? vees.req_berth_ts.substring(0,16).replace(" ", "T") : ''));
    $('#edit_etb').val((vees.est_berth_ts != null ? vees.est_berth_ts.substring(0,16).replace(" ", "T") : ''));
    $('#edit_etd').val((vees.est_dep_ts != null ? vees.est_dep_ts.substring(0,16).replace(" ", "T") : ''));
    $('#edit_bsh').val(vees.bsh);
    $('#edit_nextp').val(vees.next_port);
    $('#edit_deshp').val(vees.dest_port);
    $('#edit_disc').val(vees.est_discharge);
    $('#edit_load').val(vees.est_load);
    $('#edit_start').val(vees.berth_fr_metre_ori);
    $('#edit_end').val(vees.berth_to_metre_ori);
    $('.edit_window').val(vees.windows);

    if(vees.ocean_interisland_fake == 'C')
        $('#edit_tipe_dermaga_c').prop("checked", true);
    else if(vees.ocean_interisland_fake == 'D')
        $('#edit_tipe_dermaga_d').prop("checked", true);
    else if(vees.ocean_interisland_fake == 'I')
        $('#edit_tipe_dermaga_i').prop("checked", true);

    if(vees.windows == "1")
        $('#edit_window_on').prop("checked", true);
    if(vees.windows == "0")
        $('#edit_window_off').prop("checked", true);

    console.log("tentatif", vees.tentatif);

    if(vees.tentatif == "1")
        $('#edit_tentatif_yes').prop("checked", true);
    if(vees.tentatif == "0")
        $('#edit_tentatif_no').prop("checked", true);
    
    if(vees.btoa_side == 'S')
        $("#edit_side_s").prop("checked", true);
    if(vees.btoa_side == 'P')
        $("#edit_side_p").prop("checked", true);

    $('#edit_info').val(vees.info);

    var arr_crane = (vees.crane != null ? vees.crane : []);

    $("#edit_crane").empty();

    for (s= 1; s < m_crane_con.length+1; ++s){
        var checked = false;
        for(a=0; a<arr_crane.length; a++) {
            if(m_crane_con[s-1].che_name==arr_crane[a]) {
                checked = true;
                break;
            }
        }
        $("#edit_crane").append('<input type="checkbox" name="edit_crane" id="checkbox'+m_crane_con[s-1].che_name+'" value="'+m_crane_con[s-1].che_name+'" class="edit_crane" '+(checked?"checked":"")+' />'+
                                        '<label>STS '+m_crane_con[s-1].che_name+'</label><span> </span><span> </span>');
    }
}

function toDeleteNote(index) {
    if(confirm("apakah anda yakin ingin menghapus data ini?")) {
        // $('#box_note_'+index).remove();
        m_note.splice(index, 1);
        reloadNote();
    }

}

function toDelete(index) {
    if(confirm("apakah anda yakin ingin menghapus data ini?")) {
        // $('#box'+(index+1)).remove();
        m_vessel_removed.push(vessel[index]);
        vessel.splice(index, 1);
        reloadAll();
    }

}

    function CheckStack(area, rectangle)
    {

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

function checkField() {
    if(m_dermaga_current == 'I' || m_dermaga_current == 'D') {
        if($('#vessel2').val() != '' && 
            $('#etB').val() != '' && 
            $('#etD').val() != '' && 
            $('#bsh').val() != '' && 
            $('#muat').val() != '' && 
            $('#bongkar').val() != '' && 
            $('#start').val() != '' && 
            $('#end').val() != '') {
            return true
        }
    } else if (m_dermaga_current == 'C') {
    console.log("masukk4");
        if($('#vessel3').val() != '' && 
            $('#etBDry').val() != '' && 
            $('#etDDry').val() != '' && 
            $('#tghDry').val() != '' && 
            $('#bongkarDry').val() != '' && 
            $('#startDry').val() != '' && 
            $('#endDry').val() != '') {
            return true
        }
    }
    console.log("masukk6");
    return false;
}

function addvessel(){

    if(checkField()) {

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
        var windows="";
        var type_moves = "";
        crane_select = [];

        var today1 = new Date();
        // var vessdumm = Math.floor((Math.random() * 9999998) + 1);
        const format00 = "YYYYMMDDHHmmss";
        var vessdumm= moment(today1).format(format00);

        
        if($("#con").is(':checked')){
        
            vessid = document.getElementById("vessel2").value;
            est_pilot_ts = document.getElementById("etA").value; 
            req_berth_ts = document.getElementById("rbT").value;
            etB = document.getElementById("etB").value; 
            etD = document.getElementById("etD").value; 
            bsh = document.getElementById("bsh").value; 
            next_port = document.getElementById("nextP").value; 
            dest_port = document.getElementById("deshP").value; 
            jum_bongkar = document.getElementById("bongkar").value;
            jum_muat= document.getElementById("muat").value;
            along_side=  $('input[name=option]:checked').val();
            windows=  $('input[name=window]:checked').val();
            kade_start = document.getElementById("start").value;
            kade_to= document.getElementById("end").value;
            info= document.getElementById("info").value;
            tentatif= $('input[name=tentatif]:checked').val();
            $('.crane:checked').each(function(){
                crane_select.push($(this).val());
            });

        } else if($("#dry").is(':checked')){
           
            vessid = document.getElementById("vessel3").value;
            est_pilot_ts = document.getElementById("etADry").value;
            req_berth_ts = document.getElementById("rbTDry").value;
            etB = document.getElementById("etBDry").value; 
            etD = document.getElementById("etDDry").value; 
            bsh = document.getElementById("tghDry").value; 
            next_port = document.getElementById("nextPDry").value; 
            dest_port = document.getElementById("deshPDry").value; 
            jum_bongkar = document.getElementById("bongkarDry").value;
            jum_muat= "0";
            info= document.getElementById("infoDry").value;
            along_side=  $('input[name=optionDry]:checked').val();
            windows=  $('input[name=windowDry]:checked').val();
            kade_start = document.getElementById("startDry").value;
            kade_to= document.getElementById("endDry").value;
            tentatif= $('input[name=tentatifDry]:checked').val();
            $('.crane:checked').each(function(){
                crane_select.push($(this).val());
            });
     
        }

            var date_now = new Date();
                date_now.setHours(00);
                date_now.setMinutes(00);
                date_now.setSeconds(00);

            const format9 = "YYYY-MM-DD HH:mm"
                var etAout= est_pilot_ts!=null && est_pilot_ts!=''?moment(est_pilot_ts).format(format9):null;
                var rbTout= req_berth_ts!=null && req_berth_ts!=''?moment(req_berth_ts).format(format9):null;
                var etBout= moment(etB).format(format9);
                var etDout= moment(etD).format(format9);
                date_now = moment(date_now).format(format9);

            var tglPertama = Date.parse(etBout);
            var tglKedua = Date.parse(date_now);
            var miliday = 60 * 1000;

            var second =(tglPertama-tglKedua)/miliday;
            var y_awal_etb = (second/30)*10;

            var tglPertamaEtd = Date.parse(etDout);
            var tglKeduaEtd = Date.parse(etBout);
            var secondEtd =(tglPertamaEtd-tglKeduaEtd)/miliday;
            var y_akhir_etd = (secondEtd/30)*10;

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

                    var isStack = false;

                    if(!m_allowed_collision) {
                        var area = {
                            X1:parseInt(kd_start),
                            X2:parseInt(kd_start)+parseInt(width),
                            Y1:parseInt(y_awal_etb),
                            Y2:parseInt(y_awal_etb)+parseInt(y_akhir_etd)
                        }

                        var isStack = isVesselStack(area);
                    }

                    
                    if(!isStack) {

                        if(tentatif == "1")
                            rand = getColor(2);
                        else if(tentatif == "0")
                            rand = getColor(1); 
                       
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

                            var vees = {
                                is_unreg : 0,
                                image : '',
                                ves_name : nama,
                                ves_id: vessid,
                                est_pilot_ts: etAout,
                                req_berth_ts: rbTout,
                                est_berth_ts: etBout,
                                est_dep_ts: etDout,
                                est_load: jum_muat,
                                est_disch: jum_bongkar,
                                est_discharge: jum_bongkar,
                                load_act: null,
                                load_plan: null,
                                load_remain: null,
                                disc_act: null,
                                disc_plan: null,
                                disc_remain: null,
                                time_remain: null,
                                windows: windows,
                                width_ori: width_ves,
                                dest_port: dest_port,
                                info: info,
                                berth_fr_metre_ori: kade_start,
                                berth_to_metre_ori: kd_end
                            };

                            $("#wrap_sw").append(getVesselContent(vees, vessel.length+1, craneloop2));

                            convertToDrag();

                            etAout = etAout!=null && etAout!=''?etAout+":00":null;
                            rbTout = rbTout!=null && rbTout!=''?rbTout+":00":null;
                            etBout = etBout!=null && etBout!=''?etBout+":00":null;
                            etDout = etDout!=null && etDout!=''?etDout+":00":null;

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
                                vessel.push({
                                    ves_type:ves_type,
                                    info:info,
                                    bsh:bsh,
                                    next_port:next_port,
                                    dest_port:dest_port,
                                    est_discharge:jum_bongkar,
                                    est_load:jum_muat,
                                    btoa_side:along_side,
                                    crane:crane2,
                                    agent:agent,
                                    agent_name:agent_name,
                                    image:img,
                                    ves_id: vessdumm,
                                    ves_id_old: '',
                                    ves_name:nama,
                                    ocean_interisland:ocean_ori,
                                    ocean_interisland_fake:m_dermaga_current,
                                    ves_code:vess_code,
                                    is_simulation:"1",
                                    is_unreg:"0",
                                    is_inserted: 0,
                                    windows:windows,
                                    tentatif:tentatif,
                                    load_act:null,
                                    load_plan:null,
                                    load_remain:null,
                                    disc_act:null,
                                    disc_plan:null,
                                    disc_remain:null,
                                    time_remain:null,
                                    time_remain_label:null,
                                    est_end_date:null,
                                    berth_fr_metre:kade_start*2,
                                    berth_to_metre:kade_to*2,
                                    berth_fr_metre_ori:kade_start,
                                    berth_to_metre_ori:kade_to,
                                    width:width,
                                    width_ori:width_ves,
                                    y_awal:y_awal_etb,
                                    y_akhir:y_awal_etb+y_akhir_etd,
                                    height:y_akhir_etd,
                                    est_berth_ts:etBout,
                                    est_dep_ts:etDout,
                                    req_berth_ts:rbTout,
                                    est_pilot_ts:etAout 
                                });
                                cok.push(id_vess);
                                crane = [];

                                   
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

                                vessel.push({
                                    ves_type:ves_type,
                                    info:info,
                                    bsh:bsh,
                                    next_port:next_port,
                                    dest_port:dest_port,
                                    est_discharge:jum_bongkar,
                                    est_load:jum_muat,
                                    btoa_side:along_side,
                                    crane:crane2,
                                    agent:agent,
                                    agent_name:agent_name,
                                    image:img,
                                    ves_id: vessdumm,
                                    ves_id_old: '',
                                    ves_name:nama,
                                    ocean_interisland:ocean_ori,
                                    ocean_interisland_fake:m_dermaga_current,
                                    ves_code:vess_code,
                                    is_simulation:"1",
                                    is_unreg:"0",
                                    is_inserted: 0,
                                    windows:windows,
                                    tentatif:tentatif,
                                    load_act:null,
                                    load_plan:null,
                                    load_remain:null,
                                    disc_act:null,
                                    disc_plan:null,
                                    disc_remain:null,
                                    time_remain:null,
                                    time_remain_label:null,
                                    est_end_date:null,
                                    berth_fr_metre:kade_start*2,
                                    berth_to_metre:kade_to*2,
                                    berth_fr_metre_ori:kade_start,
                                    berth_to_metre_ori:kade_to,
                                    width:width,
                                    width_ori:width_ves,
                                    y_awal:y_awal_etb,
                                    y_akhir:y_awal_etb+y_akhir_etd,
                                    height:y_akhir_etd,
                                    est_berth_ts:etBout,
                                    est_dep_ts:etDout,
                                    req_berth_ts:rbTout,
                                    est_pilot_ts:etAout
                                });
                                cok.push(id_vess);
                                crane = [];

                            }
                        }

                        eraseTextModalContainer();

                        reloadShadow();

                        
                    } else {
                        swal({
                            title: "Vessel",
                            text: "Kapal Tumpuk",
                            icon: "warning",
                        });
                    }
                    
                }
            });
        
    } else {
        swal({
            title: "Message",
            text: "Lengkapi Form",
            icon: "warning",
        });
    }
}

function editvessel() {

    var vees = vessel[m_index_edit];
    var vees_tmp = JSON.parse(JSON.stringify(vessel[m_index_edit]));

    var arr_crane = [];

    $('.edit_crane:checked').each(function(){
        arr_crane.push($(this).val());
    });

    var ocean_interisland_fake = $('input[class=edit_tipe_dermaga]:checked').val();

    vees.crane          = arr_crane;
    vees.ocean_interisland_fake = ocean_interisland_fake;
    vees.est_pilot_ts   = $('#edit_eta').val() != null && $('#edit_eta').val() != '' ? 
                            $('#edit_eta').val().replace('T', ' ')+":00" : '';
    vees.req_berth_ts   = $('#edit_rbt').val() != null && $('#edit_rbt').val() != '' ? 
                            $('#edit_rbt').val().replace('T', ' ')+":00" : '';
    vees.est_berth_ts   = $('#edit_etb').val().replace('T', ' ')+":00";
    vees.est_dep_ts     = $('#edit_etd').val().replace('T', ' ')+":00";
    vees.ves_id         = $('#edit_vessel').val();
    vees.btoa_side      = $('input[class=edit_side]:checked').val();
    vees.bsh            = $('#edit_bsh').val();
    vees.next_port      = $('#edit_nextp').val();
    vees.dest_port      = $('#edit_deshp').val();
    vees.est_disch      = $('#edit_disc').val();
    vees.est_discharge  = $('#edit_disc').val();
    vees.est_load       = $('#edit_load').val();
    vees.berth_fr_metre = (parseInt($('#edit_start').val())*2).toString();
    vees.berth_to_metre = (parseInt($('#edit_end').val())*2).toString();
    vees.berth_fr_metre_ori = (parseInt($('#edit_start').val())).toString();
    vees.berth_to_metre_ori = (parseInt($('#edit_end').val())).toString();
    vees.windows        = $('input[class=edit_window]:checked').val();
    vees.tentatif       = $('input[class=edit_tentatif]:checked').val();
    vees.info           = $('#edit_info').val();

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
    var crane_string="";
    
    vessid = document.getElementById("edit_vessel").value;
    etA = document.getElementById("edit_eta").value; 
    rbT = document.getElementById("edit_rbt").value;
    etB = document.getElementById("edit_etb").value; 
    etD = document.getElementById("edit_etd").value;

    bsh = document.getElementById("edit_bsh").value; 
    next_port = document.getElementById("edit_nextp").value; 
    dest_port = document.getElementById("edit_deshp").value; 
    jum_bongkar = document.getElementById("edit_disc").value;
    jum_muat= document.getElementById("edit_load").value;

    kade_start = document.getElementById("edit_start").value;
    kade_to= document.getElementById("edit_end").value;
 
    var date_now = new Date();
    date_now.setHours(00);
    date_now.setMinutes(00);
    date_now.setSeconds(00);

    const format9 = "YYYY-MM-DD HH:mm"
    var etAout= moment(etA).format(format9);
    var rbTout= moment(rbT).format(format9);
    var etBout= moment(etB).format(format9);
    var etDout= moment(etD).format(format9);
    date_now = moment(date_now).format(format9);

    var tglPertama = Date.parse(etBout);
    var tglKedua = Date.parse(date_now);
    var miliday = 60 * 1000;

    var second =(tglPertama-tglKedua)/miliday;
    var y_awal_etb = (second/30)*10;

    var tglPertamaEtd = Date.parse(etDout);
    var tglKeduaEtd = Date.parse(etBout);
    var secondEtd =(tglPertamaEtd-tglKeduaEtd)/miliday;
    var height = (secondEtd/30)*10;

    vees.y_awal     = y_awal_etb.toString();
    vees.y_akhir    = height.toString();
    vees.height     = height.toString();

    vessel.splice(m_index_edit, 1);

    var isStack = false;

    if(!m_allowed_collision) {
        var area = {
            X1:parseInt(vees.berth_fr_metre),
            X2:parseInt(vees.berth_fr_metre)+parseInt(vees.width),
            Y1:parseInt(y_awal_etb),
            Y2:parseInt(y_awal_etb)+parseInt(height)
        }

        isStack = isVesselStack(area);
    }


    if(!isStack) {
        console.log("masuk1");
        if(ocean_interisland_fake == m_dermaga_current) {
        console.log("masuk2");

            vessel.splice(m_index_edit, 0, vees);
        }
        else {
        console.log("masuk3", ocean_interisland_fake);

            if (ocean_interisland_fake == "I")
                m_vessel_all.Intern.push(vees);
            else if (ocean_interisland_fake == "D")
                m_vessel_all.Domes.push(vees);
            else if (ocean_interisland_fake == "C")
                m_vessel_all.Curah.push(vees);
        }
    } else {
        console.log("masuk4");
        swal({
            title: "Vessel",
            text: "Kapal Tumpuk",
            icon: "warning",
        });
        vessel.splice(m_index_edit, 0, vees_tmp);
    }

    reloadAll();

}

function unregvessel() {
    var arr_crane = [];

    $('.unreg_crane:checked').each(function(){
        arr_crane.push($(this).val());
    });

    etA = document.getElementById("unreg_eta").value; 
    rbT = document.getElementById("unreg_rbt").value;
    etB = document.getElementById("unreg_etb").value; 
    etD = document.getElementById("unreg_etd").value;


    bsh = document.getElementById("unreg_bsh").value; 
    next_port = document.getElementById("unreg_nextp").value; 
    dest_port = document.getElementById("unreg_deshp").value; 
    jum_bongkar = document.getElementById("unreg_disc").value;
    jum_muat= document.getElementById("unreg_load").value;

    kade_start = document.getElementById("unreg_start").value;
    kade_to= document.getElementById("unreg_end").value;
    info= document.getElementById("unreg_info").value;

    var date_now = new Date();
        date_now.setHours(00);
        date_now.setMinutes(00);
        date_now.setSeconds(00);

    const format9   = "YYYY-MM-DD HH:mm"
    var etBout      = moment(etB).format(format9);
    var etDout      = moment(etD).format(format9);
    date_now        = moment(date_now).format(format9);

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

    var vees = {
        ves_id         : moment(new Date()).format("YYYYMMDDHHmmss"),
        ves_id_old     : '',
        ves_name       : $('#unreg_vessel_name').val(),
        ves_type       : m_dermaga_current == 'C' ? 'GC' : 'CT',
        ves_code       : $('#unreg_vessel_name').val().substring(0,3),
        ocean_interisland : m_dermaga_current,
        ocean_interisland_fake : m_dermaga_current,
        agent          : '',
        is_simulation  : 1,
        is_inserted    : 0,
        info           : $('#unreg_info').val(),
        ves_len        : parseInt($('#unreg_loa').val()),
        crane          : arr_crane,
        est_pilot_ts   : $('#unreg_eta').val() != null && $('#unreg_eta').val() != '' ? 
                                $('#unreg_eta').val().replace('T', ' ')+":00" : null,
        req_berth_ts   : $('#unreg_rbt').val() != null && $('#unreg_rbt').val() != '' ? 
                                $('#unreg_rbt').val().replace('T', ' ')+":00" : null,
        est_berth_ts   : $('#unreg_etb').val().replace('T', ' ')+":00",
        est_dep_ts     : $('#unreg_etd').val().replace('T', ' ')+":00",
        btoa_side      :  $('input[class=unreg_side]:checked').val(),
        bsh            : $('#unreg_bsh').val(),
        next_port      : $('#unreg_nextp').val(),
        dest_port      : $('#unreg_deshp').val(),
        est_disch      : $('#unreg_disc').val(),
        est_discharge  : $('#unreg_disc').val(),
        est_load       : $('#unreg_load').val(),
        berth_fr_metre : (parseInt($('#unreg_start').val())*2).toString(),
        berth_to_metre : (parseInt($('#unreg_end').val())*2).toString(),
        berth_fr_metre_ori : (parseInt($('#unreg_start').val())).toString(),
        berth_to_metre_ori : (parseInt($('#unreg_end').val())).toString(),
        windows         : $('input[class=unreg_window]:checked').val().toString(),
        tentatif        : $('input[class=unreg_tentatif]:checked').val(),
        y_awal          : y_awal_etb.toString(),
        y_akhir         : (y_awal_etb+height).toString(),
        height          : height.toString(),
        width           : parseInt($('#unreg_loa').val())*2,
        width_ori       : parseInt($('#unreg_loa').val()),
        is_unreg        : 1
    }

    vessel.push(vees);

    reloadAll();
}

function getDateByPosition(topp) {
    var date = new Date();
    date.setHours(00);
    date.setMinutes(00);
    date.setSeconds(00);

    var jum         = (topp/10)*30;
    var tanggaletb  =  date.setMinutes(date.getMinutes() + jum);
    
    const format    = "YYYY-MM-DD HH:mm:ss"
    var date        = moment(tanggaletb).format(format);

    return date;
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

            if(m_show_distance_vessel) {

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

            if(!m_allowed_collision) {
                var $el = $(this);
                var $elSibs = $(this).siblings('.box');
                // DETECT COLLISION
                $elSibs.each(function() {
                    var self = this;
                    var $sib = $(self);
                    collision($sib, $el);
                });

                var urutan = $(this).attr('urutan');

                $('#shadow_'+urutan).remove();
            }

        },
      
        stop: function (event,ui) {
            // console.log("stop");
            $( "#selisihKanan" ).remove();
            $( "#selisihKiri" ).remove();

            topp = $(this).position().top;
            startW = $(this).outerWidth()/2;
            kiri =  $(this).position().left/2;
            bto = kiri+startW;
            
            var etb= getDateByPosition(topp);
            var etd= getDateByPosition($(this).outerHeight()+topp);

            var urutan = $(this).attr('urutan');
            var math_kiri = Math.round(kiri);
            var math_bto = Math.round(bto);
            $('.kade_box_'+urutan).text(math_kiri+' On '+ math_bto);
            $('.ETB_'+urutan).text('ETB :'+etb);
            $('.ETD_'+urutan).text('ETD :'+etd);


            var isCollision = false;

            if(!m_allowed_collision) {            
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

                        isCollision = true;
                    }
                });

                var left = $(this).position().left;

                var x1 = left;
                var x2 = left + $(this).width(); 

                console.log()

                for (var i = 0; i < m_blokirkade.length; i++) {

                    if(m_blokirkade[i].param2 == m_dermaga_current) {
                        var a1 = m_blokirkade[i].param3*2;
                        var a2 = m_blokirkade[i].param4*2;

                        if((x1 < a1 && x2 > a1) || 
                            (x1 < a2 && x2 > a2) || 
                            (x1 < a1 && x2 > a2) || 
                            (x1 > a1 && x2 < a2)) {

                            $el.css({'top':ySave, 'left':xSave});
                            isCollision = true;

                            break;
                        }
                    }

                }
            }

            urutan = urutan-1;

            if(!isCollision)
                vessel[urutan].y_awal = parseInt(topp).toString();
            else
                vessel[urutan].y_awal = ySave;

            vessel[urutan].height               =  parseInt($(this).height()).toString();
            vessel[urutan].berth_fr_metre       =  parseInt($(this).position().left).toString();
            vessel[urutan].berth_to_metre       =  parseInt(($(this).position().left+$(this).width())).toString();
            vessel[urutan].berth_fr_metre_ori   =  vessel[urutan].berth_fr_metre/2;
            vessel[urutan].berth_to_metre_ori   =  vessel[urutan].berth_to_metre/2;
            vessel[urutan].est_berth_ts         =  etb;
            vessel[urutan].est_dep_ts           =  etd;
            reloadShadow();

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

            var urutan = $(this).attr('urutan');
            var etd= getDateByPosition($(this).outerHeight()+topp);

            $('.ETD_'+urutan).text('ETD :'+etd);

            var isCollision = false;

            if(!m_allowed_collision) {
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

                        isCollision = true;
                    }
                });
            }

            urutan = urutan-1;

            if(!isCollision)
                vessel[urutan].y_awal = parseInt(topp).toString();
            else
                vessel[urutan].y_awal = ySave;

            vessel[urutan].height       =  parseInt($(this).height()).toString();
            vessel[urutan].est_dep_ts   =  etd;
    
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

function convertToDragNote(index) {
    $('#box_note_'+index)
    .draggable({
        containment: "#canvas",
        grid: [ 4, 10 ],
        scroll: false,
        drag: function(event, ui) {

        },
        start: function (event,ui) {
            
        },
      
        stop: function (event,ui) {
            syncDragNote(this)
        }
    })
    .resizable({
        grid: 2,
        containment: "#canvas",
        start : function(event,ui) {
            
        },
        stop : function(event,ui) {
            syncDragNote(this);
        }
    });
}

function syncDragNote(component) {
    var urutan = $(component).attr('urutan');

    var top = $(component).position().top;
    var left =  $(component).position().left;
    var width = $(component).width();
    var height = $(component).height();

    console.log("urutan", urutan);
    console.log("top", top);
    console.log("left", left);
    console.log("width", width);
    console.log("height", height);
    
    m_note[urutan].x        =  parseInt(left);
    m_note[urutan].y        =  parseInt(top);
    m_note[urutan].width    =  parseInt(width);
    m_note[urutan].height   =  parseInt(height);
}


function kade(param) {

    var kad = m_kade_all.all;
    var dom =  m_kade_all.dom;
    var int =  m_kade_all.int;
    var cur =  m_kade_all.cur;
    var kade_meter = 0;
    var can =0;

    if (param == "D"){
        $("#Rdomes").empty();
        kade_meter = dom[0].param4;
        var d = kade_meter / 50;

        can = kade_meter * 2.008;
        $("#canvas").css("width", can+"px");

        for (f=0; f<d;f++){
            $("#Rdomes").append(
                '<div class="cm">'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                '</div>');
        }
        $("#Rdomes").append(
            '<div class="cm"></div>');

    } else if (param == "I") {
        $("#Rintern").empty();
        kade_meter = int[0].param4;
        var n = kade_meter / 50;
        can = kade_meter * 2.008;
        $("#canvas").css("width", can+"px");

        for (t=0; t<n;t++){
            $("#Rintern").append(
                '<div class="cm">'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                '</div>');
        }
        $("#Rintern").append(
            '<div class="cm"></div>');
            
    } else if (param == "C"){
        $("#Rcur").empty();
        kade_meter = cur[0].param4;
        var c = kade_meter / 50;
        can = kade_meter * 2.008;
        $("#canvas").css("width", can+"px");

        for (y=0; y<c;y++){
            $("#Rcur").append(
                '<div class="cm">'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                    '<div class="mm"></div>'+
                '</div>');
        }
        $("#Rcur").append(
            '<div class="cm"></div>');
    }
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

function saveBox() {

    console.log(m_vessel_all);

    $.ajax({  
            url : "{{ url('VesselBerthPlan3/save') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                param_vess : m_vessel_all,
                param_vess_removed : m_vessel_removed
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

                    saveDone();
                    
                } else {
                    alert ("Data Gagal Diubah !!");
                }

            } 
    });
}

function saveDone() {
    for (var i = 0; i < m_vessel_all.Intern.length; i++) {
        m_vessel_all.Intern[i].is_inserted = 1;
        m_vessel_all.Intern[i].ves_id_old = m_vessel_all.Intern[i].ves_id;
    }
    for (var i = 0; i < m_vessel_all.Domes.length; i++) {
        m_vessel_all.Domes[i].is_inserted = 1;
        m_vessel_all.Domes[i].ves_id_old = m_vessel_all.Domes[i].ves_id;
    }
    for (var i = 0; i < m_vessel_all.Curah.length; i++) {
        m_vessel_all.Curah[i].is_inserted = 1;
        m_vessel_all.Curah[i].ves_id_old = m_vessel_all.Curah[i].ves_id;
    }

    m_vessel_removed = [];
}

function updatebox() {
   
    var count = $('.box').length;
    var top_arr = [];
    cek = [];
    cok = ["0"];

    count_note = $('.box_note').length;
    var arr_note = [];

    $('.box_note').each(function(i, obj) {

        var top = $(this).position().top;
        var left =  $(this).position().left;
        var height =  $(this).height();
        var width =  $(this).width();
        var text =  $(this).text();
        var code = $(this).attr('code');

        var date = new Date();
        date.setHours(00);
        date.setMinutes(00);
        date.setSeconds(00);

        estimasimenit = (parseInt(top)/20)*60;

        var newdate =new Date(date);
            newdate.setMinutes(newdate.getMinutes() + estimasimenit);
        const format90 = "YYYY/MM/DD HH:mm:ss"
        var newdateoutCon = moment(newdate).format(format90);

        arr_note.push({
            x:parseInt(left),
            y:parseInt(top),
            width:parseInt(width),
            height:parseInt(height),
            text:text,
            code:code,
            start_date: newdateoutCon,
            ocean_interisland: m_dermaga_current
        });
    });

    $.ajax({  
            url : "{{ url('VesselBerthPlan3/updatevessel') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                param_vess:vessel,
                param_ocean : thisocean,
                param_crane : crane,
                param_note : arr_note,
                param_vess_removed : m_vessel_removed
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


