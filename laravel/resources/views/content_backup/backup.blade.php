<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<!-- start dragable n resizing -->
<script type="text/javascript"> //sripct untuk Resizing and dragable

var vessel=[];
var dermaga =[];
// var image = [];

loadAll('D');
function loadAll(ocean) {
    $("#canvas").empty();
    // var image = {{asset('/vendor/jquery/jquery.min.js')}};

    $.ajax({  
        url : "{{route('getvessel')}}",
        type : "get",
        dataType : "json",
        async : false,
        success : function(result){
            // restult.end
            // image = result.img_url;
            if (ocean == "I"){
                vessel = result.Intern;
            } else if (ocean == "D"){
                vessel = result.Domes;
            }
            for (i = 1; i < vessel.length+1; ++i) {
                $("#canvas").append('<div id="box'+i+'" class="box draggable"><img src = "{{asset('/img/')}}/'+vessel[i-1].image+'" style= "width: 100px; height: 30px; " /><div class="text_judul"> MV. '+vessel[i-1].ves_name+'</div><div class="text_detail">ETA : '+vessel[i-1].est_berth_ts+'<br>ETB : '+vessel[i-1].est_berth_ts+'<br>ETD : '+vessel[i-1].est_dep_ts+'<br>Kade Meter : '+vessel[i-1].berth_fr_metre_ori+' Until '+vessel[i-1].berth_to_metre_ori+'<br></div>  <div class="widget-inner"></div> </div>');
                // $("#canvas").append('<div id="box'+i+'" class="box draggable"><div class="text_judul"> MV. '+vessel[i-1].ves_name+'</div><div class="text_detail">ETA : '+vessel[i-1].est_berth_ts+'<br>ETB : '+vessel[i-1].est_berth_ts+'<br>ETD : '+vessel[i-1].est_dep_ts+'</div>   </div>');
                convertToDrag();
                
            }
            for (i = 1; i < vessel.length+1; ++i) {
                // var r = () => Math.random() * 256 >> 0;
                // var color = `rgb(${r()}, ${r()}, ${r()})`;

                var colors = ['#FFC312', '#006266', '#1289A7', '#EE5A24', '#B53471'];

                var rand = colors[Math.floor(Math.random() * colors.length)];

                $("#box"+i).css("left", vessel[i-1].berth_fr_metre+"px");
                $("#box"+i).css("width", vessel[i-1].width+"px");
                $("#box"+i).css("top", vessel[i-1].y_awal+"px");
                $("#box"+i).css("height", vessel[i-1].height+"px");
                $("#box"+i).css("background-color", rand);
            }
          
        }
    });

    $("#vessel2").empty();
    $.ajax({  
        url : "{{route('getdermaga')}}",
        type : "get",
        dataType : "json",
        async : false,
        success : function(result){
            // restult.end
            // console.log(result);    
            
            if (ocean == "I"){
            dermaga = result.Intern;

            } else if (ocean == "D"){
            dermaga = result.Domes;
            }
            for (i = 1; i < dermaga.length+1; ++i) {
                $("#vessel2").append('<option  name="vesnam" value="'+dermaga[i-1].ves_id+'"> '+dermaga[i-1].ves_name+' | '+dermaga[i-1].ocean_interisland+' | '+dermaga[i-1].ves_id+' </option>');  
            }
        }
    });
}
var nama =[];
var width=[];
var id_vess = [];
var ocean = [];
var vess_code=[];

var cek = [];

var cok =[];

function addvessel(){
    var vessid = document.getElementById("vessel2").value;
        // var vesstext = $('select[name=selector] option').filter(':selected').text();
        // var vesstext = $("#vessel").find('option:selected').attr("name");
        $.ajax({  
            url : "{{ url('VesselBerthPlan/addvessel') }}",
            data: {
            "_token": "{{ csrf_token() }}",
            param_data:vessid,
            },
            type : "post",
            dataType : "json",
            async : false,
            success : function(result){
                nama = result[0].ves_name;
                width = result[0].width;
                id_vess = result[0].ves_id;
                ocean = result[0].ocean_interisland;
                vess_code = result[0].ves_code;
                agent = result[0].agent;
                agent_name = result[0].agent_name;
                img = result[0].image;
                // var countol = result.length;
                // var count = $('.box').length;
               
                for (i = 1; i < vessel.length+1; ++i) {
                // var r = () => Math.random() * 256 >> 0;
                // var color = `rgb(${r()}, ${r()}, ${r()})`;

                var colors = ['#FFC312', '#006266', '#1289A7', '#EE5A24', '#B53471'];

                var rand = colors[Math.floor(Math.random() * colors.length)];
            }
               

                if (cok.includes(id_vess)){
                    alert ("Kapal Sudah Ditambahkan !! Simpan Terlebih Dahulu !!");
                } else {
                  
                    $("#canvas").append('<div id="box'+(vessel.length+1)+'" class="box draggable"><img src = "{{asset('/img/')}}/'+img+'" style= "width: 100px; height: 30px; " /><div class="text_judul"> MV. '+nama+'</div> <div class="widget-inner"></div> </div>');
                    // $("#canvas").append('<div id="box'+(vessel.length+1)+'" class="box draggable"><div class="text_judul"> MV. '+nama+'</div></div>');
                    convertToDrag();
                    $("#box"+(vessel.length+1)).css("width",width+"px");
                    $("#box"+(vessel.length+1)).css("height","100px");
                    $("#box"+(vessel.length+1)).css("background-color", rand);
                    vessel.push({agent:agent, agent_name:agent_name,image:img,ves_id:id_vess, ves_name:nama, ocean_interisland:ocean,ves_code:vess_code, est_berth_ts:null});
                    console.log(vessel);
                    cok.push(id_vess);

                }
                
            }
        });
}

function convertToDrag() {   
    var xSave;
	var ySave;
    $('.box')
    .draggable({
        containment: "#canvas",
        // obstacle:".butNotHere",
        // preventCollision: true,
        grid: [ 2, 10 ],
        scroll: false,
        stack: '.box',
        start: function (event,ui) {
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
            topp = $(this).position().top;
            startW = $(this).outerWidth()/2;
            kiri =  $(this).position().left/2;
            bto = kiri+startW;
            $('#results').text('BFR: '+ kiri +' '+' BTO: ' + bto);
            
            var $el = $(this);
			var $elSibs = $(this).siblings('.box');
			$el.removeClass('dragging');
			$elSibs.addClass('not-dragging');
			// DETECT COLLISION
			$elSibs.each(function() {
				var self = this;
				var $sib = $(self);
				collision($sib, $el);
				var result = collision($sib, $el);
				// if there is collision, we send back to start position.
				if(result == true) {

                    // alert("dilarang tabrak");
					$el.css({'top':ySave, 'left':xSave});
					$sib.find('.widget-inner').removeClass('collision');
				}
			});
        }
    })

    

    .resizable({
  
        //Other options
        grid: 10,
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
            // $( '#box1' ).height(120)
            // alert(endW)
            $('#panjang').text('Width: ' + (endW) + ' ' + 'Height: ' + (endH));
            // alert("width changed: "+ (endW-startW) + " And Height changed: " + (endH-endW));
            var $el = $(this);
			var $elSibs = $(this).siblings('.box');
			$el.removeClass('dragging');
			$elSibs.addClass('not-dragging');
			// DETECT COLLISION
			$elSibs.each(function() {
				var self = this;
				var $sib = $(self);
				collision($sib, $el);
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
	function collision($sib, $el) {
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
		if (	 (r1 >= x2 && b1 >= y2 && y1 < y2 && x1 < r2)
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
        top_arr.push({agent:agent,height:height,y_awal:y_awal,y_akhir:y_akhir, top:top, width:width, left:left, ves_id:ves_id,berth_to_ori:berth_to_ori, berth_fr_ori:berth_fr_ori, est_berth_ts: est_berth_ts, occ:occ, name:name, code:code});
    }
    // console.log(top_arr);
    $.ajax({  
            url : "{{ url('VesselBerthPlan/updatevessel') }}",
            data: {
            "_token": "{{ csrf_token() }}",
            // param_id:ves_id,
            param_vess:top_arr,
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
                    alert ("Data Berhasil Diubah!!");
                    
                } else {
                    alert ("Data Gagal Diubah !!");
                }

            } 
        });
}

function print() {
  //window.open(pathString, target);
  window.open("{{ URL::to('/print') }}", "_blank");
}
</script>


