<!DOCTYPE html>
<html>
<head>
<style>
    
    .hari1{
    text-align:center;
    font-size: 8px;
    font-weight: bold;
    margin:auto;
    color: white !important;
    position: absolute;
    font-family: "Arial"; 
    text-transform: uppercase;
}
.tanggal1
{
    display:flex;
    justify-content:center;
    align-items:center;
    writing-mode: vertical-lr;
    transform: rotate(180deg);

    width: 28px;
    height: 124px;
    /* background: #342345;    */
    
    position: absolute;
    left: 0px;
    top: 26px;
}
.tanggal2
{
    display:flex;
    justify-content:center;
    align-items:center;
    writing-mode: vertical-lr;
    transform: rotate(180deg);
    width: 28px;
    height: 124px;
    /* background: #123422;    */
    
    position: absolute;
    left: 0px;
    top: 150.5px;
}
.tanggal3
{
    display:flex;
    justify-content:center;
    align-items:center;
    writing-mode: vertical-lr;
    transform: rotate(180deg);
    width: 28px;
    height: 124px;
    /* background: #887567;    */
    
    position: absolute;
    left: 0px;
    top: 275px;
}
.tanggal4
{
    display:flex;
    justify-content:center;
    align-items:center;
    writing-mode: vertical-lr;
    transform: rotate(180deg);
    width: 28px;
    height: 124px;
    /* background: #342356;    */
    
    position: absolute;
    left: 0px;
    top: 400px;
}
.tanggal5
{
    display:flex;
    justify-content:center;
    align-items:center;
    writing-mode: vertical-lr;
    transform: rotate(180deg);
    width: 28px;
    height: 124px;
    /* background: #435324;    */
    
    position: absolute;
    left: 0px;
    top: 524.5px;
}
.tanggal6
{
    display:flex;
    justify-content:center;
    align-items:center;
    writing-mode: vertical-lr;
    transform: rotate(180deg);
    width: 28px;
    height: 124px;
    /* background: #952;    */
    
    position: absolute;
    left: 0px;
    top: 649px;
}
.tanggal7
{
    display:flex;
    justify-content:center;
    align-items:center;
    writing-mode: vertical-lr;
    transform: rotate(180deg);
    width: 28px;
    height: 124px;
    /* background: #95c8d8;    */
    
    position: absolute;
    left: 0px;
    top: 774px;
}
#start{
    display:flex;
    justify-content:center;
    align-items:center;
    /* writing-mode: vertical-lr; */
    width: 76px;
    height: 14.5px;
    left: 1018px;
    top: 13px;
    position: absolute;
    /* background: #95c8d8;    */
}
#starttgl {
    display:flex;
    justify-content:center;
    align-items:center;
    /* writing-mode: vertical-lr; */
    width: 76px;
    height: 14.5px;
    left: 1018px;
    top: 28px;
    position: absolute;
    /* background: #95c8d8;    */

}
#end{
    display:flex;
    justify-content:center;
    align-items:center;
    /* writing-mode: vertical-lr; */
    width: 76px;
    height: 14.5px;
    left: 1109.5px;
    top: 13px;
    position: absolute;
    /* background: #95c8d8;    */
}
#endtgl {
    display:flex;
    justify-content:center;
    align-items:center;
    /* writing-mode: vertical-lr; */
    width: 76px;
    height: 14.5px;
    left: 1109.5px;
    top: 28px;
    position: absolute;
    /* background: #95c8d8;    */

}
.startend{
    text-align:center;
    font-size: 6px;
    font-weight: bold;
    margin:auto;
    color: black !important;
    position: absolute;
    font-family: "Tahoma"; 
    text-transform: uppercase;
     /* background: #ca3433;    */
}
.startendtgl{
    text-align:center;
    font-size: 6px;
    font-weight: bold;
    margin:auto;
    color: white !important;
    position: absolute;
    font-family: "Tahoma"; 
    text-transform: uppercase;
     /* background: #ca3433;    */
}

#intern{
    width: 503px;
    height: 871.5px;
    /* background: #95c8d8;    */
    /* border:1px solid #ca3433; */
    position: absolute;
    /* left: 66.5px; */
    left: 261px;
    top: 159px;
    /* filter: border:1px solid #ca3433; */ 
    /* filter: drop-shadow(3px 3px 5px black); */
}

.arsirintern{
    width: 65px;
    height: 871.5px;
    position: absolute;
    left: 261px;
    top: 159px;
    background: #877F7D;   
    opacity: 0.5;
    z-index:0;
}

#domes{
    width: 503px;
    height: 871.5px;
    /* background: #95c8d8;    */
    /* background: #877F7D;    */
    /* opacity: 0.2; */
    /* border:0.1px solid #ca3433; */
    position: absolute;
    /* left: 66.5px; */
    left: 880.5px;
    top: 159px;

}
.arsirdomes{
    width: 97.5px;
    height: 871.5px;
    background: #877F7D;   
    opacity: 0.5;
    /* border:0.1px solid #ca3433; */
    position: absolute;
    /* left: 66.5px; */
    left: 910.9px;
    top: 159px;
    z-index:0;

}

#curah{
    width: 190px;
    height: 871.5px;
    /* background: #95c8d8;    */
    /* border:0.1px solid #ca3433; */
    position: absolute;
    /* left: 66.5px; */
    left: 70px;
    top: 159px;
}
.arsircurah{
    width: 65px;
    height: 871.5px;
    background: #877F7D;
    /* background: #ca3433; */
    opacity: 0.5; 
    /* border:0.1px solid #ca3433; */
    position: absolute;
    /* left: 157.5px; */
    left: 70px;
    /* right: 100px; */
    /* right: 0px; */
    top: 159px;
    z-index:0;
}
.box{
    background-color:#29e;
        /* border-radius: 0.75em; */

    touch-action: none;
    user-select: none;
    transform: translate(0px, 0px);

    /* box-sizing: border-box; */
    /* overflow: auto; */
    position: absolute !important;
    /* box-shadow: 4px 4px 5px  #313131; */
    /* border-radius: 5%; */
    width : 65px;
    height :27px;

    /* height :66.5px; */

    left :0px; /*6.5*/
    top: 4.5px;
}
.text_judul{
        color: #000;
        font-size:5px;
        font-family:sans-serif;
        font-weight:bold;
        padding-left: 20px;
        padding-top: 2px;
        width : 100%;
        /* text-shadow: 1px 1px #313131; */
        z-index: -2;
        
    }
.text_detail{
    color: black;
    font-size:3.5px;
    font-family:sans-serif;
    font-weight:bold;
    padding-left:20px;
    width : 100%;
    /* padding-top:3px; */
    z-index: -2;

    
}

/* #text_detail{
        padding-left:20px;
    }
#text_judul{
        padding-left:20px;
} */
#img{
       
    /* text-align:left; */
    /* padding-left: 20px; */
    /* padding-top: 5px; */
   
    position: absolute;
    }
.ims{
    float:right;
    width: 18%;
    height: 18%;
    padding-top: 8px;

/* position: absolute; */
}
#tanggal{
    width: 672px;
    height: 747px;
    /* background: #95c8d8;    */
    /* border:1px solid #ca3433; */
    position: absolute;
    /* left: 66.5px; */
    left: 9px;
    top: 133px;
}
.zone {
  /* padding: 90px 0; */
  margin: 0 auto;
  text-align: left;
  /* background-blend-mode: darken; */
  transition: 0.5s;
  position:absolute;
  z-index:0;
 width:90px;   /* ini iya */
  height:60px;  /* ini juga*/
  top : 20px;  /* ini iya */
  left :0px; /* ini juga ternyata */
  /* box-shadow: 10px 10px 5px grey; */
} 
.dom {
  /* padding: 90px 0; */
  margin: 0 auto;
  text-align: left;
  /* background-blend-mode: darken; */
  transition: 0.5s;
  position:absolute;
  z-index:0;
 width:90px;   /* ini iya */
  height:60px;  /* ini juga*/
  top : 20px;  /* ini iya */
  left :0px; /* ini juga ternyata */
} 

/* .zone::before {
  content:"";
  position:absolute;
  
  clip-path: border-box;
  top:0;
  left:0px;
  right:0;
  bottom:0;
  z-index:-1;
  background: #ffe699 ;
  clip-path: polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%);
  -webkit-clip-path: polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%);
} */
.zone::before {
  content:"";
  position:absolute;
  
  clip-path: border-box;
  top:0;
  left:0px;
  right:0;
  bottom:0;
  z-index:-1;
  background: #ffe699 ;
  clip-path: polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%);
  -webkit-clip-path: polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%);
}
.dom::before {
  content:"";
  position:absolute;
  
  clip-path: border-box;
  top:0;
  left:0px;
  right:0;
  bottom:0;
  z-index:-1;
  background: #ffe699 ;
  clip-path: polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%);
  -webkit-clip-path: polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%);
}
circle span {
  position: absolute;
  color:#fff;
  font-size:4px;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
}
circle {
    /* float:right; */
  background: #000;
  width: 25px;
  height: 9px;
  /* border-radius: 50%; */
  display: inline-block;
  text-align: center;
  /* margin-top: 10%; */
  margin-right: 5px;
  
  position: relative;
  z-index:-1;
}

circle2 span {
    position: absolute;
  color:#fff;
  font-size:4px;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
}
circle2 {
   /* float:right; */
   background: #000;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  display: inline-block;
  text-align: center;
  /* margin-top: 10%; */
  margin-right: 5px;
  
  position: relative;
  z-index:-1;
}
#ttd1 {
    width: 46px;
    height: 70px;
    /* background: #95c8d8;    */
    /* border:0.1px solid #ca3433; */
    position: absolute;
    /* left: 66.5px; */
    left: 950px;
    top: 1134px;
}

#ttd2 {
    width: 100px;
    height: 60px;
    /* background: #95c8d8;    */
    /* border:0.1px solid #ca3433; */
    position: absolute;
    /* left: 66.5px; */
    left: 1110px;
    top: 1134px;
}





/* #img{
    left: 0px;
    top: 150px;
} */

@media print {
    .box {
        background-color: #FFC312, #006266, #1289A7, #EE5A24, #B53471 !important;
        box-shadow: 4px 4px 5px  #313131;
        -webkit-print-color-adjust: exact; 
    }
    .zone {
        background-color: #FFC312,#ffe699,#9dc3e6,#a9d18e !important;
        /* box-shadow: 4px 4px 5px  #313131; */
        -webkit-print-color-adjust: exact; 
    }
    .dom {
        background-color: #FFC312,#ffe699,#9dc3e6,#a9d18e  !important;
        /* box-shadow: 4px 4px 5px  #313131; */
        -webkit-print-color-adjust: exact; 
    }

    .hari1{
        color: white !important;
        -webkit-print-color-adjust: exact; 
    }
    .text_judul{
        color: #ffff !important;
        text-shadow: 1px 1px #313131;
        -webkit-print-color-adjust: exact; 
    }
    .arsirdomes{
        color: #877F7D !important;
        -webkit-print-color-adjust: exact; 
    }
    .arsirintern{
        color: #877F7D !important;
        -webkit-print-color-adjust: exact; 
    }
    .arsircurah{
        color: #877F7D !important;
        -webkit-print-color-adjust: exact; 
    }
}




</style>
<link rel="shortcut icon" href="{{asset('/img/icon.png')}}">
<script src="{{asset('asset/js/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js" type="text/javascript"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<!-- <script src="{{asset('asset/js/jquery.ui.min.js')}}"></script> -->

<title>PRINT MONITORING | VESSEL INFORMATION BERTHING PLAN</title>

</head>
<body>
    <?php
        setlocale(LC_TIME, 'id_ID.utf8');

        $datenow = $_GET['datestart'];
        
        $hari1prin = new DateTime($datenow);
        $day1 = $hari1prin->format('l');
        $hari1= strftime('%A', $hari1prin->getTimestamp());
        $tgl1 = strftime('%d %B %Y', $hari1prin->getTimestamp());

        $hari2prin = new DateTime($datenow);
        $hari2prin->add(new DateInterval('P1D'));
        $day2 = $hari2prin->format('l');
        $hari2 =strftime('%A', $hari2prin->getTimestamp());
        $tgl2 = strftime('%d %B %Y', $hari2prin->getTimestamp());

        $hari3prin = new DateTime($datenow);
        $hari3prin->add(new DateInterval('P2D'));
        $day3 = $hari3prin->format('l');
        $hari3 =strftime('%A', $hari3prin->getTimestamp());
        $tgl3 = strftime('%d %B %Y', $hari3prin->getTimestamp());

        $hari4prin = new DateTime($datenow);
        $hari4prin->add(new DateInterval('P3D'));
        $day4 = $hari4prin->format('l');
        $hari4 =strftime('%A', $hari4prin->getTimestamp());
        $tgl4 = strftime('%d %B %Y', $hari4prin->getTimestamp());

        $hari5prin = new DateTime($datenow);
        $hari5prin->add(new DateInterval('P4D'));
        $day5 = $hari5prin->format('l');
        $hari5 =strftime('%A', $hari5prin->getTimestamp());
        $tgl5 = strftime('%d %B %Y', $hari5prin->getTimestamp());

        $hari6prin = new DateTime($datenow);
        $hari6prin->add(new DateInterval('P5D'));
        $day6 = $hari6prin->format('l');
        $hari6 =strftime('%A', $hari6prin->getTimestamp());
        $tgl6 = strftime('%d %B %Y', $hari6prin->getTimestamp());

        $hari7prin = new DateTime($datenow);
        $hari7prin->add(new DateInterval('P6D'));
        $day7 = $hari7prin->format('l');
        $tgl7 = strftime('%d %B %Y', $hari7prin->getTimestamp());
        $hari7 =strftime('%A', $hari7prin->getTimestamp());

    ?>
   
   <img src="{{asset('/img/vessel_print_650_new-new.jpg')}}" style="width:1377px; height: 1257.333333333333px; position:absolute;" >
    <!-- <img src="{{asset('/img/vessel_print2.jpg')}}" style="width:1050px; height: 1093.484262838211px; position:absolute;" > -->
    
    <div id="start">
    </div>
    <div id="starttgl">
    </div>
    <div id="endtgl">
    </div>
    <div id="end">
    </div>
   

    <div id="internarsir">
         <!-- <div class="arsirintern" id="arsirintern"></div> -->
    </div>
        <div id="intern">
            <!-- <div id="box" class="box"><img src = "{{asset('/img/logo.png')}}" style= "position:absolute; width: 10px; height: 14,38461538461538px; right:2px; top:2px;"/></div> -->
        </div>

    <div id="domesarsir">
         <!-- <div class="arsirdomes" id="arsirdomes"></div> -->
    </div>
        <div id="domes">
            <!-- <div id="box" class="box"><img src = "{{asset('/img/logo.png')}}" style= "position:absolute; width: 10px; height: 14,38461538461538px; right:2px; top:2px;"/></div> -->
        </div>

    <div id="curaharsir">
         <!-- <div class="arsircurah" id="arsircurah"></div> -->

    </div>
        <div id="curah">
            <!-- <div id="box" class="box"><img src = "{{asset('/img/logo.png')}}" style= "position:absolute; width: 10px; height: 14,38461538461538px; right:2px; top:2px;"/></div> -->
        </div>


    <div id="tanggal">
    </div>

    <div id="ttd1">
        <div style="position: absolute;  z-index: 5; color:black; font-size:4px; font-family:arial; font-weight:bold;"> Dibuat Oleh,</div>
        <div  style="position: absolute; color:black; z-index: 5; font-size:5px; font-family:arial; font-weight:bold; margin-top: 5px;"> BERTH PLANNER</div>
        <img id="link1" style=" margin-top: 2px; margin-left: -10px; position:initial;  width:65px;height:65px" src="https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl=data->link1&choe=UTF-8">
        <div id="berth_planner" style="position: absolute;margin-top: -10px;color:black;text-decoration: underline; font-size:5px; font-family:arial; font-weight:bold; text-transform:uppercase;">NANANG HIDAYAT </div>
    </div>
    <div id="ttd2">
        <div style="position: absolute;  z-index: 5;color:black; font-size:5px; font-family:arial; font-weight:bold;">Mengetahui</div>
        <div style="position: absolute; color:black; z-index: 5; font-size:5px; font-family:arial; font-weight:bold; margin-top: 5px;"> PLANNING MANAGER</div>
        <img id="link2" style=" margin-top: 2px; margin-left: -10px; position:initial;  width:65px;height:65px" src="https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl=data->link2&choe=UTF-8">
        <div id="planning_manager" style="position: absolute;margin-top: -10px; color:black;text-decoration: underline; font-size:5px; font-family:arial; font-weight:bold; text-transform:uppercase;">PIERRE ROCHEL </div>
    </div>



</body>
</html>

<script type="text/javascript">
    window.onload = function () {
    window.print();
    setTimeout(function(){window.close();}, 1);
  }
</script>




<script type="text/javascript">
    for (i = 1; i < 3; ++i) {

        // console.log(i);
        $("#tanggal").append('<div class= "tanggal1 box'+i+'"><p class=hari1><?php echo $tgl1 ?><br><?php echo $hari1 ?> / <?php echo $day1 ?></p></div>');
        $("#tanggal").append('<div class= "tanggal2 box'+i+'"><p class=hari1><?php echo $tgl2 ?><br><?php echo $hari2 ?> / <?php echo $day2 ?></p></div>');
        $("#tanggal").append('<div class= "tanggal3 box'+i+'"><p class=hari1><?php echo $tgl3 ?><br><?php echo $hari3 ?> / <?php echo $day3 ?></p></div>');
        $("#tanggal").append('<div class= "tanggal4 box'+i+'"><p class=hari1><?php echo $tgl4 ?><br><?php echo $hari4 ?> / <?php echo $day4 ?></p></div>');
        $("#tanggal").append('<div class= "tanggal5 box'+i+'"><p class=hari1><?php echo $tgl5 ?><br><?php echo $hari5 ?> / <?php echo $day5 ?></p></div>');
        $("#tanggal").append('<div class= "tanggal6 box'+i+'"><p class=hari1><?php echo $tgl6 ?><br><?php echo $hari6 ?> / <?php echo $day6 ?></p></div>');
        $("#tanggal").append('<div class= "tanggal7 box'+i+'"><p class=hari1><?php echo $tgl7 ?><br><?php echo $hari7 ?> / <?php echo $day7 ?></p></div>');

    }
    $(".box1").css("left","0px");
    $(".box2").css("left", "842px");
    $("#start").append('<p class="startend"><?php echo $hari1 ?></p>');
    $("#starttgl").append('<p class="startendtgl"><?php echo $tgl1 ?></p>');
    $("#end").append('<p class="startend"><?php echo $hari7 ?></p>');
    $("#endtgl").append('<p class="startendtgl"><?php echo $tgl7 ?></p>');

</script>

<script src="{{asset('asset/js/plugins/moment.min.js')}}"></script>
<script type="text/javascript">

    var vessel=[];
    var vesseldom = [];


    Load();  
    signature();    
    function Load() {
        var vessel=[];
        var vesseldom = [];
        var vesselcur = [];

        var url_angkut      = window.location.href;
        var pacul = new URL(url_angkut);
        var datestart = pacul.searchParams.get("datestart");
        // console.log("JAncok",datestart)
        var dateend =pacul.searchParams.get('dateend');
        var y_awal = moment(datestart).set({h: 00, m: 00});
        // console.log(y_awal);


    //   console.log(datestart);


        $.ajax({  
            url : "{{ route('monitorprint') }}",
            type : "post",
            data: {
                "_token": "{{ csrf_token() }}",
                date2_start:datestart,
                date2_end:dateend
                },
            dataType : "json",
            async : false,
            success : function(result){
                vessel = result.Intern;
                vesseldom = result.Domes;
                vesselcur = result.Curah;
                // console.log(vessel);

                for (i = 1; i < vessel.length+1; ++i) {
                    var crane =  vessel[i-1].crane;
                    var uncrane=[];
                    if (crane==null)
                    uncrane=[];
                    else
                    uncrane = crane.split(',');

                    var craneloop = "";
                    for (var x = 0; x < uncrane.length; x++) { //Move the for loop from here
                        craneloop += '<circle2><span>'+uncrane[x]+'</span></circle2>';
                    };

                    $("#intern").append(
                        '<div id="zone'+i+'" class="zone">'+
                            '<div id="img'+i+'">'+
                                '<img id="ims'+i+'" class="ims" src = "{{asset('/img/customer/')}}/'+vessel[i-1].image+'"/>'+
                            '</div>'+
                            '<div id="text_judul'+i+'" class="text_judul" val="'+vessel[i-1].ves_id+'">'+
                                'MV. '+vessel[i-1].ves_name+''+
                            '</div>'+
                            '<div id="text_detail'+i+'" class="text_detail">'+
                                '<div style="margin:1px; color:red;">ETA :'+vessel[i-1].est_berth_ts+'</div>'+
                                '<div style="margin:1px;">ETB :'+vessel[i-1].est_berth_ts+'</div>'+
                                '<div style="margin:1px;">ETD : '+vessel[i-1].est_dep_ts+'</div>'+
                                '<div style="margin:1px; margin-left:2px; color:red; font-style: italic;">MOVES EST:'+vessel[i-1].real_disch+'/'+vessel[i-1].real_load+' BOX</div>'+
                                '<div style="margin:1px;">LOA : '+vessel[i-1].width_ori+' M</div>'+
                                '<div style="margin:1px;">POD : '+vessel[i-1].dest_port+'</div>'+
                                ' <circle><span>'+vessel[i-1].berth_fr_metre_ori+' On '+vessel[i-1].berth_to_metre_ori+'</span></circle>'+
                                craneloop+
                            '</div>'+
                        '</div>');
                }
                for (i = 1; i < vessel.length+1; ++i) {
                    if(vessel[i-1].act_berth_ts != null) {
                        rand = getColor(0);
                    } else if(vessel[i-1].tentatif == 1) {
                        rand = getColor(2);
                    } else if(vessel[i-1].tentatif == 0) {
                        rand = getColor(1);
                    }

                    var est_berth = vessel[i-1].est_berth_ts;
                    var end= moment(est_berth);
                    var duration = moment.duration(end.diff(y_awal));
                    var hours = duration.asHours();
                    // console.log(vessel[i-1].ves_name,hours);
                    var startdate = hours * 5.1875;
                   
                    var left = vessel[i-1].berth_fr_metre_ori/10 *7.611111111111111;
                    var top = vessel[i-1].y_awal/20 * 5.1875;
                    var width = vessel[i-1].width_ori/10 *7.611111111111111;
                    var height = vessel[i-1].height/20 * 5.1875 ;
                    var along_sidein = vessel[i-1].btoa_side;
                    var name = vessel[i-1].ves_name;
                
                    if(along_sidein == "P"){
                    $("#zone"+i).css("left", left+"px");
                    $("#zone"+i).css("width", width+"px");
                    $("#zone"+i).css("top", startdate +"px");
                    $("#zone"+i).css("height", height+"px");
                    $("#zone"+i).append('<style>#zone'+i+'::before{content:""; position:absolute;clip-path: border-box;top:0;left:0px; right:0;bottom:0; z-index:-1;background: '+rand+' ;clip-path: polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%); -webkit-clip-path: polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%);}</style>');
                    } else if (along_sidein == "S") {
                    $("#zone"+i).css("left", left+"px");
                    $("#zone"+i).css("width", width+"px");
                    $("#zone"+i).css("top", startdate +"px");
                    $("#zone"+i).css("height", height+"px");
                    $("#zone"+i).append('<style>#zone'+i+'::before{content:""; position:absolute;clip-path: border-box;top:0;left:0px; right:0;bottom:0; z-index:-1;background: '+rand+' ;clip-path: polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%); -webkit-clip-path: polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%);}</style>');
                    $("#text_judul"+i+".text_judul").css("padding-left", "5px");
                    $("#text_judul"+i+".text_judul").css("padding-top", "5px");
                    $("#text_detail"+i+".text_detail").css("padding-left", "5px");
                    }


                }

                for (i = 1; i < vesseldom.length+1; ++i) {
                    var cranedom =  vesseldom[i-1].crane;
                    var uncranedom=[];
                    if (cranedom==null)
                    uncranedom=[];
                    else
                    uncranedom = cranedom.split(',');

                    // console.log(uncrane);
                    var craneloopdom = "";
                    for (var x = 0; x < uncranedom.length; x++) { //Move the for loop from here
                        craneloopdom += '<circle2><span>'+uncranedom[x]+'</span></circle2>';
                    };

                    $("#domes").append(
                        '<div id="dom'+i+'" class="zone">'+
                            '<div id="img'+i+'">'+
                                '<img id="ims'+i+'" class="ims" src = "{{asset('/img/customer/')}}/'+vesseldom[i-1].image+'"/>'+
                            '</div>'+
                            '<div id="text_juduldom'+i+'" class="text_judul" val="'+vesseldom[i-1].ves_id+'">'+
                                'MV. '+vesseldom[i-1].ves_name+''+
                            '</div>'+
                            '<div id="text_detaildom'+i+'" class="text_detail">'+
                                '<div style="margin:1px; color:red;">ETA :'+vesseldom[i-1].est_berth_ts+'</div>'+
                                '<div style="margin:1px;">ETB :'+vesseldom[i-1].est_berth_ts+'</div>'+
                                '<div style="margin:1px;">ETD : '+vesseldom[i-1].est_dep_ts+'</div>'+
                                '<div style="margin:1px; margin-left:2px; color:red; font-style: italic;">MOVES EST:'+vesseldom[i-1].real_disch+'/'+vesseldom[i-1].real_load+' BOX</div>'+
                                '<div style="margin:1px;">LOA : '+vesseldom[i-1].width_ori+' M</div>'+
                                '<div style="margin:1px;">POD : '+vesseldom[i-1].dest_port+'</div>'+
                                ' <circle><span>'+vesseldom[i-1].berth_fr_metre_ori+' On '+vesseldom[i-1].berth_to_metre_ori+'</span></circle>'+
                                craneloopdom+
                            '</div>'+
                        '</div>');
                }
                for (i = 1; i < vesseldom.length+1; ++i) {

                    if(vesseldom[i-1].act_berth_ts != null) {
                        rand = getColor(0);
                    } else if(vesseldom[i-1].tentatif == 1) {
                        rand = getColor(1);
                    } else if(vesseldom[i-1].tentatif == 0) {
                        rand = getColor(2);
                    }
                    
                    var est_berth = vesseldom[i-1].est_berth_ts;
                    var end= moment(est_berth);
                    var duration = moment.duration(end.diff(y_awal));
                    var hours = duration.asHours();
                    // console.log(vessel[i-1].ves_name,hours);
                    var startdatedom = hours * 5.1875;

                    var leftdom = vesseldom[i-1].berth_fr_metre_ori/10 *7.611111111111111; // done
                    var topdom = vesseldom[i-1].y_awal/20 * 5.1875; // done
                    var widthdom = vesseldom[i-1].width_ori/10 *7.611111111111111;
                    var heightdom = vesseldom[i-1].height/20 * 5.1875;
                    var along_sidedom = vesseldom[i-1].btoa_side;
                    
                    // console.log(height);
                    if(along_sidedom == "P"){ //kiri star
                    $("#dom"+i).css("left", leftdom+"px");
                    $("#dom"+i).css("width", widthdom+"px");
                    $("#dom"+i).css("top", startdatedom +"px");
                    $("#dom"+i).css("height", heightdom+"px");
                    $("#dom"+i).append('<style>#dom'+i+'::before{content:""; position:absolute;clip-path: border-box;top:0;left:0px; right:0;bottom:0; z-index:-1;background: '+rand+' ;clip-path: polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%); -webkit-clip-path: polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%);}</style>');
                    }else if (along_sidedom == "S") {
                    $("#dom"+i).css("left", leftdom+"px");
                    $("#dom"+i).css("width", widthdom+"px");
                    $("#dom"+i).css("top", startdatedom +"px");
                    $("#dom"+i).css("height", heightdom+"px");
                    $("#text_juduldom"+i+".text_judul").css("padding-left", "5px");
                    $("#text_detaildom"+i+".text_detail").css("padding-left", "5px");
                    

                    $("#dom"+i).append('<style>#dom'+i+'::before{content:""; position:absolute;clip-path: border-box;top:0;left:0px; right:0;bottom:0; z-index:-1;background: '+rand+' ;clip-path: polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%); -webkit-clip-path: polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%);}</style>');
                    }
                }

                for (a = 1; a < vesselcur.length+1; ++a) {
                    var cranecur =   vesselcur[a-1].crane;
                    var uncranecur=[];
                    if (cranecur==null)
                    uncranecur=[];
                    else
                    uncranecur = cranecur.split(',');

                    // console.log(uncrane);
                    var craneloopcur = "";
                    for (var x = 0; x < uncranecur.length; x++) { //Move the for loop from here
                        craneloopcur += '<circle2><span>'+uncranecur[x]+'</span></circle2>';
                    };

                    $("#curah").append(
                        '<div id="cur'+a+'" class="zone">'+
                            '<div id="img'+a+'">'+
                                '<img id="ims'+a+'" class="ims" src = "{{asset('/img/customer/')}}/'+vesselcur[a-1].image+'"/>'+
                            '</div>'+
                            '<div id="text_judulcur'+a+'" class="text_judul" val="'+ vesselcur[a-1].ves_id+'">'+
                                'MV. '+vesselcur[a-1].ves_name+''+
                            '</div>'+
                            '<div id="text_detailcur'+a+'" class="text_detail">'+
                                '<div style="margin:1px; color:red;">ETA :'+vesselcur[a-1].est_berth_ts+'</div>'+
                                '<div style="margin:1px;">ETB :'+vesselcur[a-1].est_berth_ts+'</div>'+
                                '<div style="margin:1px;">ETD : '+vesselcur[a-1].est_dep_ts+'</div>'+
                                '<div style="margin:1px; margin-left:2px; color:red; font-style: italic;">MOVES EST:'+vesselcur[a-1].real_disch+' MT</div>'+
                                '<div style="margin:1px;">LOA : '+vesselcur[a-1].width_ori+' M</div>'+
                                '<div style="margin:1px;">POD : '+vesselcur[a-1].dest_port+'</div>'+
                                ' <circle><span>'+vesselcur[a-1].berth_fr_metre_ori+' On '+vesselcur[a-1].berth_to_metre_ori+'</span></circle>'+
                                craneloopcur+
                            '</div>'+
                        '</div>');
                }
                for (i = 1; i < vesselcur.length+1; ++i) {
                    if(vesselcur[i-1].act_berth_ts != null) {
                        rand = getColor(0);
                    } else if(vesselcur[i-1].tentatif == 1) {
                        rand = getColor(1);
                    } else if(vesselcur[i-1].tentatif == 0) {
                        rand = getColor(2);
                    }
                   
                    var est_berth = vesselcur[i-1].est_berth_ts;
                    var end= moment(est_berth);
                    var duration = moment.duration(end.diff(y_awal));
                    var hours = duration.asHours();
                    // console.log(vessel[i-1].ves_name,hours);
                    var startdatecur = hours * 5.1875;

                    var leftcur = (((250 - vesselcur[i-1].berth_to_metre_ori)/10)*7.611111111111111);
                    var widthcur = (((250 - vesselcur[i-1].berth_fr_metre_ori)/10) *7.611111111111111) - (leftcur); // done

                    // console.log("left", leftcur);

                    var topcur= vesselcur[i-1].y_awal/20 * 5.1875; // done
                    var heightcur = vesselcur[i-1].height/20 * 5.1875;
                    var along_sidecur = vesselcur[i-1].btoa_side;
                    
                    // console.log(height);
                    if(along_sidecur == "P"){ //kiri star
                    $("#cur"+i).css("left", leftcur+"px");
                    $("#cur"+i).css("width", widthcur+"px");
                    $("#cur"+i).css("top", startdatecur +"px");
                    $("#cur"+i).css("height", heightcur+"px");
                    $("#cur"+i).append('<style>#cur'+i+'::before{content:""; position:absolute;clip-path: border-box;top:0;left:0px; right:0;bottom:0; z-index:-1;background: '+rand+' ;clip-path: polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%); -webkit-clip-path: polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%);}</style>');
                    }else if (along_sidecur == "S") {
                    $("#cur"+i).css("left", leftcur+"px");
                    $("#cur"+i).css("width", widthcur+"px");
                    $("#cur"+i).css("top", startdatecur +"px");
                    $("#cur"+i).css("height", heightcur+"px");
                    $("#text_judulcur"+i+".text_judul").css("padding-left", "5px");
                    $("#text_detailcur"+i+".text_detail").css("padding-left", "5px");
                    
                    $("#cur"+i).append('<style>#cur'+i+'::before{content:""; position:absolute;clip-path: border-box;top:0;left:0px; right:0;bottom:0; z-index:-1;background: '+rand+' ;clip-path: polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%); -webkit-clip-path: polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%);}</style>');
                    }
                }

            }
        });

    }

    function signature() {
        
        var url_string      = window.location.href;
        var url = new URL(url_string);
        var berth_planner = url.searchParams.get("param11");
        var planning_manager =url.searchParams.get('param22');
        var link1 = url.searchParams.get("link1");
        var link2 = url.searchParams.get("link2");

        var link1up = encodeURIComponent(link1);
        var link2up = encodeURIComponent(link2);

        $('#berth_planner').text(berth_planner);
        $('#planning_manager').text(planning_manager);
        $('#link1').attr("src", "https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl="+link1up+"&choe=UTF-8");
        $('#link2').attr("src", "https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl="+link2up+"&choe=UTF-8");
      
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
            return yellow 
    }
    

</script>










