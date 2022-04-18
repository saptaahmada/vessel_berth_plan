<!DOCTYPE html>
<html>
<head>
	<title>TAP</title>
	<style type="text/css">
		.vertical {
		    writing-mode: vertical-lr;
		    transform: rotate(180deg);
		}
		.jam {
			height: 50px
		}
		table, th, td {
			border: 2px solid black;
			border-collapse: collapse;
		}
		.no_border  {
			 border: 0px;
		}
		.center {
			text-align: center;
		}
		@media print {
		    .vertical{
		        /*color: white !important;*/
		        -webkit-print-color-adjust: exact; 
			    /*writing-mode: vertical-lr;*/
			    transform: rotate(270deg);

		    }
		}
		.font_standart {
			font-size: 15px;
		}
	</style>
</head>
<?php
$jum = 0;
foreach ($data['kesiapan'] as $i => $val) {
	if($i == 5 || $i == 6)
		$jum += $val->kesiapan;
}

function getAlat($kode)
{
	if($kode == 'TT_BDS')
		return 'TT';
	else if($kode == 'HT_BDS')
		return 'HT';
	else if($kode == 'BMC_HT')
		return 'HT';
	else if($kode == 'BST_LOWBED')
		return 'LOWBED';
	else if($kode == 'BST_HT')
		return 'HT';
	else if($kode == 'REQ')
		return 'ORDER';
	else
		return $kode;
}
?>
<body>
	<table class="no_border" width="100%">
		<tr class="no_border">
			<td class="no_border" width="33%">
				<img src="{{url('public/img/logo_ttl.png')}}" width="200">
			</td>
			<td class="center no_border" width="33%">
				<span style="font-size: 30px;"><b>TRUCK ALLOCATION PLAN</b></span>
			</td>
			<td class="no_border" width="33%"></td>
		</tr>
	</table>
	<span style="margin-left: 100px; ">{{$data['tgl'][0]->tgl}}</span>
	<table width=100%>
		<tbody>
			<tr>
				<td rowspan="3" class="center font_standart" style="width: 20px">KADE</td>
				<td rowspan="3" colspan="2" class="center font_standart">STS / KAPAL</td>
				<td rowspan="3" class="center font_standart">JUMLAH<br>ARMADA</td>
				<td rowspan="3" class="center font_standart">KESIAPAN<br>ARMADA</td>
				@foreach($data['tgl'] as $i => $val)
					<td colspan="{{$val->jum}}" class="center">{{$val->tgl}}</td>
				@endforeach
			</tr>
			<tr>
				@foreach($data['shift'] as $i => $val)
				<td colspan="{{$val->jum}}" class="center">SHIFT {{$val->shift}}</td>
				@endforeach
			</tr>
			<tr>
				@foreach($data['jam'] as $i => $val)
				<td class="center vertical jam" width="40">{{$val->jam_str}}</td>
				@endforeach
			</tr>
			@if(count($data['sts_i']) > 0)
			<tr>
				<td class="center vertical font_standart" rowspan="{{(count($data['sts_i'])*2)+1}}">INTER</td>
			</tr>
			@endif
			@foreach($data['sts_i'] as $i => $val)
			<tr>
				<td class="center font_standart" colspan="2" style="background: #d9ffc2">KAPAL</td>
				<td style="background: #d9ffc2; height: 30px"></td>
				<td style="background: #d9ffc2"></td>
				<?php 
				$p_jum_max = count($data['jam'])-$val['jum'];
				$p_jum = 0;
				foreach($data['jam'] as $ja => $jam) {
					if($jam->jam_str == $val['min_time'] && $jam->tgl == $val['min_date']) {
						break;
					} else { 
						$p_jum++;
						echo '<td></td>';
					} 
				}
				
				if($val['alongside'] == 2)
					$bg_vessel = '#5eebeb';
				else if($val['alongside'] == 1)
					$bg_vessel = '#F5E89A';
				else if($val['alongside'] == 0)
					$bg_vessel = '#BDE992';

				?>
				<td class="center" rowspan="2" colspan="{{$val['jum']}}" 
					style="background: {{$bg_vessel}}">
					{{"{$val['ves_name']} (B:{$val['est_disc']} / M:{$val['est_load']} BOX, STS: {$val['crane']})"}}
					<br>
					<table width=100% style="border: 0px;">
						<tr>
							@foreach($val['hours'] as $j => $row)
							<td class="center no_border">{{$row['jum']}}</td>
							@endforeach
						</tr>
					</table>
				</td>
				<?php
				for($p_jum=$p_jum; $p_jum<$p_jum_max; $p_jum++) {
					echo '<td></td>';
				}
				?>
			</tr>
			<tr>
				<td class="center font_standart" colspan="2" style="background: #d9ffc2">STS</td>
				<td style="background: #d9ffc2; height: 30px"></td>
				<td style="background: #d9ffc2"></td>
				<?php
				for($p_jum=0; $p_jum<$p_jum_max; $p_jum++) {
					echo '<td></td>';
				}
				?>
			</tr>
			@endforeach

			@if(count($data['sts_d']) > 0)
			<tr>
				<td class="center vertical font_standart" rowspan="{{(count($data['sts_d'])*2)+1}}">DOM</td>
			</tr>
			@endif

			@foreach($data['sts_d'] as $i => $val)
			<tr>
				<td class="center font_standart" colspan="2" style="background: #fff0cc">KAPAL</td>
				<td style="background: #fff0cc; height: 30px"></td>
				<td style="background: #fff0cc"></td>
				<?php 
				$p_jum_max = count($data['jam'])-$val['jum'];
				$p_jum = 0;
				foreach($data['jam'] as $ja => $jam) {
					if($jam->jam_str == $val['min_time'] && $jam->tgl == $val['min_date']) {
						break;
					} else { 
						$p_jum++;
						echo '<td></td>';
					} 
				}

				if($val['alongside'] == 2)
					$bg_vessel = '#5eebeb';
				else if($val['alongside'] == 1)
					$bg_vessel = '#F5E89A';
				else if($val['alongside'] == 0)
					$bg_vessel = '#BDE992';

				?>
				<td class="center" rowspan="2" colspan="{{$val['jum']}}" style="background: {{$bg_vessel}}">
					{{"{$val['ves_name']} (B:{$val['est_disc']} / M:{$val['est_load']} BOX, STS: {$val['crane']})"}}
					<br>
					<table width=100% style="border: 0px;">
						<tr>
							@foreach($val['hours'] as $j => $row)
							<td class="center no_border">{{$row['jum']}}</td>
							@endforeach
						</tr>
					</table>
				</td>
				<?php
				for($p_jum=$p_jum; $p_jum<$p_jum_max; $p_jum++) {
					echo '<td></td>';
				}
				?>
			</tr>
			<tr>
				<td class="center font_standart" colspan="2" style="background: #fff0cc">STS</td>
				<td style="background: #fff0cc;  height: 30px"></td>
				<td style="background: #fff0cc"></td>
				<?php
				for($p_jum=0; $p_jum<$p_jum_max; $p_jum++) {
					echo '<td></td>';
				}
				?>
			</tr>
			@endforeach
			<tr>
				<td class="center" colspan="3" rowspan="2" style="background: #cccccc">TOTAL STS<br>Kebutuhan Armada</td>
				<td rowspan="2" style="background: #cccccc"></td>
				<td rowspan="2" style="background: #cccccc"></td>
				@foreach($data['det_count'] as $i => $val)
				<td class="center" style="background: #cccccc">{{$val->jum_v}}</td>
				@endforeach
			</tr>
			<tr>
				@foreach($data['det_count'] as $i => $val)
				<td class="center" style="background: #cccccc">{{$val->jum_t}}</td>
				@endforeach
			</tr>
			<tr>
				<td class="center vertical font_standart" rowspan="{{count($data['row_truck'])+count($data['row_owner'])}}">ARMADA</td>
			</tr>
			@foreach($data['row_owner'] as $a => $owner)
				@if($owner['owner'] != 'EXTERNAL BMC')
				<tr>
					<td class="center font_standart" rowspan="{{$owner['jum']+1}}" style="background: #cccccc">{{$owner['owner']}}</td>
				</tr>
				@endif
				@foreach($owner['truck'] as $i => $val)
				<tr>
					@if($owner['owner'] == 'EXTERNAL BMC')
					<td class="center font_standart" style="background: #cccccc;" width="120">{{$owner['owner']}}</td>
					@endif

					@if($val['jenis'] != 'REQ')
					<td class="center font_standart" style="background: #cccccc" width="80">{{getAlat($val['jenis'])}}</td>
					@else
					<td class="center font_standart" colspan="3" style="background: #cccccc; color: #bf0b0b">{{getAlat($val['jenis'])}}</td>
					@endif

					@foreach($data['kesiapan'] as $kes => $siap)
						@if($siap->jenis == $val['jenis'] && $siap->jenis != 'REQ')
							<td class="center" style="background: #cccccc" width="40">{{$siap->jum}}</td>
							<td class="center" style="background: #cccccc" width="40">{{$siap->kesiapan}}</td>
						@endif
					@endforeach

					@foreach($val['item'] as $j => $row)
						@if($owner['owner'] == 'INTERNAL BDS')
							<?php 

								if($row['shift'] == 1) {
									$color = '#ffa3fd';
								} else if($row['shift'] == 2) {
									$color = '#a9fcec';
								} else if($row['shift'] == 3) {
									$color = '#9cc5ff';
								} else if($row['shift'] == 4) {
									$color = '#a8ffab';
								}
							?>
							<td class="center" style="background: {{$color}}">{{$row['plan_count']}}</td>
						@else
							<td class="center">{{$row['plan_count']}}</td>
						@endif
					@endforeach

				</tr>
				@endforeach
			@endforeach

			<tr>
				<td class="center" colspan="2" style="background: #cccccc">KETERSEDIAAN ARMADA</td>
				<td style="background: #cccccc"></td>
				<td style="background: #cccccc"></td>
				<td style="background: #cccccc"></td>
				@foreach($data['det_total'] as $i => $val)
				<td class="center" style="background: #cccccc">{{$val->plan_count}}</td>
				@endforeach
			</tr>
		</tbody>
	</table>
	<table class="no_border">
		<tr class="no_border">
			<td class="no_border">KETERANGAN</td>
			<td class="no_border">
				<ul>
					<li><b>Kesiapan armada BDS {{date('d/m/Y')}} ({{$jum}} Unit)</b></li>
					<li>Kebutuhan armada dan plot STS dapat disesuaikan di masing - masing shift dengan mempertimbangkan kelancaran kegiatan bongkar muat</li>
					<li>Armada CTT hanya digunakan untuk kegiatan bongkar muat di area WSTA dan diprioritaskan untuk kegiatan docking</li>
				</ul>
			</td>
		</tr>
	</table>

	<table class="no_border" width="100%">
		<tr class="no_border">
			<td class="no_border" width="10%">
			    <div id="ttd1">
			        <div style="position: absolute;  z-index: 5; color:black; font-size:8px; font-family:arial; font-weight:bold;"> Dibuat Oleh,</div>
			        <div  style="position: absolute; color:black; z-index: 5; font-size:8px; font-family:arial; font-weight:bold; margin-top: 8px;"> YARD PLANNER</div>
			        <img id="link1" style=" margin-top: 8px; margin-left: -10px; position:initial;  width:100px;height:100px" src="">
			        <div id="berth_planner" style="position: absolute;margin-top: -10px;color:black;text-decoration: underline; font-size:8px; font-family:arial; font-weight:bold; text-transform:uppercase;"></div>
			    </div>
				
			</td>
			<td class="no_border"  width="70%"></td>
			<td class="no_border" width="10%">
			    <div id="ttd2">
			        <div style="position: absolute;  z-index: 5;color:black; font-size:8px; font-family:arial; font-weight:bold;">Mengetahui</div>
			        <div style="position: absolute; color:black; z-index: 5; font-size:8px; font-family:arial; font-weight:bold; margin-top: 8px;"> PLANNING SUPERINTENDENT</div>
			        <img id="link2" style=" margin-top: 8px; margin-left: -10px; position:initial;  width:100px;height:100px" src="">
			        <div id="planning_manager" style="position: absolute;margin-top: -10px; color:black;text-decoration: underline; font-size:8px; font-family:arial; font-weight:bold; text-transform:uppercase;"></div>
			    </div>		
				
			</td>
			<td class="no_border" width="10%">
			    <div id="ttd2">
			        <div style="position: absolute;  z-index: 5;color:black; font-size:8px; font-family:arial; font-weight:bold;">Mengetahui</div>
			        <div style="position: absolute; color:black; z-index: 5; font-size:8px; font-family:arial; font-weight:bold; margin-top: 8px;"> PLANNING MANAGER</div>
			        <img id="link3" style=" margin-top: 8px; margin-left: -10px; position:initial;  width:100px;height:100px" src="">
			        <div id="planning_manager" style="position: absolute;margin-top: -10px; color:black;text-decoration: underline; font-size:8px; font-family:arial; font-weight:bold; text-transform:uppercase;"></div>
			    </div>				
			</td>
		</tr>
	</table>

	<script src="{{asset('asset/js/jquery.min.js')}}"></script>

	<script type="text/javascript">
        $(document).ready(function () {
        	signature();
        });

	    function signature() {
	        var data_url = <?=json_encode($data)?>;

	        var berth_planner       = data_url.param11;
	        var planning_manager    = data_url.param22;
	        var date                = data_url.date;
	        var no_doc              = data_url.no_doc;

	        var link1 ="{{ URL::to('/Signature/qr')}}?bp="+berth_planner+"&date="+date+"&no_doc="+no_doc+"";
	        var link2 ="{{ URL::to('/Signature/qr')}}?bp=NANANG HIDAYAT&date="+date+"&no_doc="+no_doc+"";
	        var link3 ="{{ URL::to('/Signature/qr')}}?bp="+planning_manager+"&date="+date+"&no_doc="+no_doc+"";
	        // console.log("link2", link2);

	        $('#berth_planner').text(berth_planner);
	        $('#planning_manager').text(planning_manager);
	        $('#link1').attr("src", "https://chart.googleapis.com/chart?chs=180x180&cht=qr&chl="+encodeURIComponent(link1)+"&choe=UTF-8");
	        $('#link2').attr("src", "https://chart.googleapis.com/chart?chs=180x180&cht=qr&chl="+encodeURIComponent(link2)+"&choe=UTF-8");
	        $('#link3').attr("src", "https://chart.googleapis.com/chart?chs=180x180&cht=qr&chl="+encodeURIComponent(link3)+"&choe=UTF-8");
	    }
	</script>
</body>
</html>