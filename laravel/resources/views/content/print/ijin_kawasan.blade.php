<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.no_border  {
			 border: 0px;
		}
		td.description {
			vertical-align: top;
		}
		body {
			font-size: 13px;
			font-family: Arial, Helvetica, sans-serif;
			line-height: 20px;
		}
	</style>
</head>
<body style="padding: 20px; padding-left: 50px">
	<div class="container" style="margin-top: 20px">
		
		<img src="{{asset('img/logo_ttl.png')}}" style="width: 170px; float: right; margin-right: 20px">

		<table class="no_border" style="width: 680px; margin-top: 70px">
			<tr class="no_border">
				<td class="no_border description" width="80">Nomor</td>
				<td class="no_border description" width="10"> : </td>
				<td class="no_border description" width="200">{{$vessel[0]->no_surat}}</td>
				<td class="no_border description">Surabaya, {{$today}}</td>
			</tr> 
			<tr class="no_border">
				<td class="no_border description">Kepentingan</td>
				<td class="no_border description"> : </td>
				<td class="no_border description">Penting</td>
			</tr> 
			<tr class="no_border">
				<td class="no_border description">Lampiran</td>
				<td class="no_border description"> : </td>
				<td class="no_border description">Berkas</td>
			</tr> 
			<tr class="no_border">
				<td class="no_border description">Perihal</td>
				<td class="no_border description"> : </td>
				<td class="no_border description">Persetujuan sandar kapal di dermaga International<br>PT Terminal Teluk Lamong</td>
				<td class="no_border description">
					Yth.<br>
					<ol>
						<li>Kepala kantor Otoritas Pelabuhan Tanjung Perak</li>
						<li>{{$vessel[0]->agent_name}}</li>
					</ol>
				</td>
			</tr> 
			<tr class="no_border description">
				<td class="no_border description" colspan="4">
					<ol>
						<li>Sehubungan dengan surat permohonan agent nomor: {{$vessel[0]->no_pmh_agent}}</li>
						<li>Tersebut butir 1 (satu) diatas, dapat kami alokasikan untuk disandarkan di dermaga International dengan data kapal sbb:
							<ol type="a">
								<li>Nama Agent : {{$vessel[0]->agent_name}}</li>
								<li>Nama Kapal/ETB : {{$vessel[0]->ves_name}} / {{$berth}}</li>
								<li>
									Alasan : 
									<span>
										<ul>
											<li>container telah ter stack di Cy PT Terminal Teluk Lamong</li>
											<li>lokasi depo agent berada di dekat PT Terminal Teluk Lamong</li>
											<li>kapal tersebut adalah window di PT Terminal Teluk Lamong</li>
										</ul>
									</span>
								</li>
							</ol>
						</li>
						<li>Demikian permohonan kami, atas perhatian dan kerja samanya kami ucapkan terima kasih</li>
					</ol>
					<br>
				</td>
			</tr> 
			<tr class="no_border description">
				<td class="no_border description"></td>
				<td class="no_border description"></td>
				<td class="no_border description"></td>
				<td class="no_border description">
					Pemohon,<br>OPERATIONAL SENIOR MANAGER<br>
			        <img src="https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl={{$url}}&choe=UTF-8" style="width: 125px"><br>
					<!-- <img src="{{asset('img/ttd_sm_operation.jpg')}}" style="width: 200px"><br> -->
					KARYO RAHARJO
					<br><br>
				</td>
			</tr> 
		</table>
		<br>
		<div>
			Tembusan : <br>
			1. Kepala Kantor KPPBC Tanjung Perak
		</div>

	</div>

</body>
</html>
