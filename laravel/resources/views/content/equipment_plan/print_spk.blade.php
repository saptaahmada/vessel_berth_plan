<!DOCTYPE html>
<html>
<head>
	<title>SPK</title>
	<style type="text/css">
		body{
			font-size: 15px
		}
		table, th, td {
			border: 2px solid black;
			border-collapse: collapse;
		}
		.height_standart {
			height: 40px
		}
		.no_border  {
			 border: 0px;
		}
		.center {
			text-align: center;
		}
	</style>
</head>
<body>
	<img src="{{url('public/img/pt_terminal_teluk_lamong.png')}}" width="300" style="display: block; margin: 0 auto;">
	<div style="text-align: center; font-size: 30px"><b><u>SURAT PERINTAH KERJA</u></b></div>
	<div style="margin-top:20px">1. Yang bertanda tangan dibawah ini :</div>
	<div style="margin-left: 20px">
		<div style="margin-left: 10px;">
			<table class="no_border">
				<tr class="no_border">
					<td class="no_border">Nama</td>
					<td class="no_border"> : </td>
					<td class="no_border">Pierre Rochel T</td>
				</tr>
				<tr class="no_border">
					<td class="no_border">Posisi / Jabatan</td>
					<td class="no_border"> : </td>
					<td class="no_border">Operation Planning Manager</td>
				</tr>
				<tr class="no_border">
					<td class="no_border">Unit Kerja</td>
					<td class="no_border"> : </td>
					<td class="no_border">Operational Sub Directorat</td>
				</tr>
			</table>
		</div>
		<div style="margin-top: 20px">Dengan berdasarkan kebutuhan armada haulage stevedoring pada Truck Alocation Plan :</div>
		<div style="margin-left: 10px; margin-top: 10px">
			Hari / Tanggal : {{$data['data'][0]->hari}}, {{$data['data'][0]->tanggal}}
		</div>
		<div style="margin-top: 20px">Memerintahkan kerja kepada tenaga perbantuan (on call) Operator Head Truck sebagai berikut:</div>
		<table width="100%">
			<tr>
				<td class="center height_standart">TANGGAL</td>
				<td class="center height_standart">SHIFT KERJA</td>
				<td class="center height_standart">JUMLAH OPERATOR</td>
				<td class="center height_standart">KETERANGAN</td>
			</tr>
			<?php foreach ($data['data'] as $i => $val): ?>
			<tr>
				<td class="center height_standart">{{$val->tanggal}}</td>
				<td class="center height_standart">{{$val->start_time.' - '.$val->end_time}}</td>
				<td class="center height_standart">{{$val->plan_count}}</td>
				<td class="center height_standart">Haulage Stevedoring</td>
			</tr>
			<?php endforeach ?>
		</table>
	</div>
	<div style="margin-top:20px">2. Demikian disampaikan atas perhatian dan kerjasamanya diucapkan terima kasih. :</div>
	<table class="no_border" width="100%" style="margin-top: 30px">
		<tr class="no_border">
			<td class="no_border center">Penerima Tugas</td>
			<td class="no_border center">Pemberi Tugas</td>
		</tr>
		<tr class="no_border">
			<td class="no_border center">PT Aperindo Prima Mandiri</td>
			<td class="no_border center">Operation Plan Manager</td>
		</tr>
		<tr class="no_border">
			<td class="no_border center" style="height: 100px"></td>
			<td class="no_border center" style="height: 100px">
				<img id="link3" style="position:initial;  width:150px;height:150px" src="">
			</td>
		</tr>
		<tr class="no_border">
			<td class="no_border center">(............................)</td>
			<td class="no_border center">( Pierre Rochel T )</td>
		</tr>
	</table>
	
	<script src="{{asset('asset/js/jquery.min.js')}}"></script>
	<script type="text/javascript">
        $(document).ready(function () {
        	signature();
        });

		setTimeout(function () {
			window.print()
		}, 2000)

	    function signature() {
	        var data_url = <?=json_encode($data)?>;

	        var berth_planner       = data_url.param11;
	        var planning_manager    = data_url.param22;
	        var date                = data_url.date;
	        var no_doc              = data_url.no_doc;

	        // var link1 ="{{ URL::to('/Signature/qr')}}?bp="+berth_planner+"&date="+date+"&no_doc="+no_doc+"";
	        // var link2 ="{{ URL::to('/Signature/qr')}}?bp=NANANG HIDAYAT&date="+date+"&no_doc="+no_doc+"";
	        var link3 ="{{ URL::to('/Signature/qr')}}?bp="+planning_manager+"&date="+date+"&no_doc="+no_doc+"";
	        // console.log("link2", link2);

	        // $('#berth_planner').text(berth_planner);
	        $('#planning_manager').text(planning_manager);
	        // $('#link1').attr("src", "https://chart.googleapis.com/chart?chs=180x180&cht=qr&chl="+encodeURIComponent(link1)+"&choe=UTF-8");
	        // $('#link2').attr("src", "https://chart.googleapis.com/chart?chs=180x180&cht=qr&chl="+encodeURIComponent(link2)+"&choe=UTF-8");
	        $('#link3').attr("src", "https://chart.googleapis.com/chart?chs=180x180&cht=qr&chl="+encodeURIComponent(link3)+"&choe=UTF-8");

	        console.log("masuk cook");
	    }
	</script>
</body>
</html>