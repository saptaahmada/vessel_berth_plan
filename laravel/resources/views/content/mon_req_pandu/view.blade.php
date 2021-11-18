@extends('home.home')

@section('content')

<div id="content">
  <div class="panel box-shadow-none content-header">
    <div class="panel-body">
        <div class="col-md-12">
          <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>Monitoring Permohonan Pelayanan Kapal</b></h3>
          <p class="animated fadeInDown">
           Data Tables <span class="fa-angle-right fa"></span> Monitoring Permohonan Pelayanan Kapal</p>
        </div>
    </div>
  </div>
  <div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading">
          <h3>Data Monitoring Permohonan Pelayanan Kapal</h3>
        </div>
        <div class="panel-body">
          <div class="responsive-table">
            <div>
              Legend : 
              <button class="badge" onclick="refreshTable(-1)" style="background: #000; color: #FFF">All</button>
              <button class="badge" onclick="refreshTable(0)" style="background: #7dffa4; color: #787878">Labuh</button>
              <button class="badge" onclick="refreshTable(1)" style="background: #ffe18f; color: #787878">Pandu</button>
            </div><br>
            <table id="table" class="table table-striped table-bordered" width="100%" cellspacing="0">
              <thead>
                <th>No PKK</th>
                <th>No PPK 1</th>
                <th>No PPK Jasa</th>
                <th>KD Kapal</th>
                <th>Nama Kapal</th>
                <th>Callsign Kapal</th>
                <th>Permohonan Pandu</th>
                <th>Draft kapal</th>
                <th>Lokasi</th>
                <th>Tgl Masuk</th>
                <th>Tgl Keluar</th>
                <th>Keterangan</th>
                <th>Created date</th>
                <th>Tipe</th>
                <th>Tipe Pandu</th>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    refreshTable(-1);
  });

  function refreshTable(param) {
    $('#table').DataTable({
        "filter": true,
        "destroy": true,
        "ordering": true,
        "processing": true, 
        "serverSide": true, 
        "searching": true, 
        "responsive":false,
        "orderCellsTop": true,
        "fixedHeader": true,
        "order": [[ 12, "desc" ]],
        ajax: "{{url('MonReqPandu/json')}}/"+param,
        columns: [
          { data: 'no_pkk', name: 'no_pkk' },
          { data: 'no_ppk1', name: 'no_ppk1' },
          { data: 'no_ppk_jasa', name: 'no_ppk_jasa' },
          { data: 'kd_kapal', name: 'kd_kapal' },
          { data: 'nama_kapal', name: 'nama_kapal' },
          { data: 'callsign_vessel', name: 'callsign_vessel' },
          { data: 'permohonan_pandu', name: 'permohonan_pandu' },
          { data: 'draft_kapal', name: 'draft_kapal' },
          { data: 'nama_lokasi', name: 'nama_lokasi' },
          { data: 'tanggal_masuk', name: 'tanggal_masuk' },
          { data: 'tanggal_keluar', name: 'tanggal_keluar' },
          { data: 'keterangan', name: 'keterangan' },
          { data: 'created_date', name: 'created_date' },
          { data: 'tipe_name', name: 'tipe_name' },
          { 
            "data": "tipe_pandu_name",
            "render": function ( data, type, row ) {
              if(row.tipe==1 && row.tipe_pandu == 0)
                return "<div class='badge badge-primary'>"+row.tipe_pandu_name+"</div>";
              else if(row.tipe==1 && row.tipe_pandu == 1)
                return "<div class='badge badge-info'>"+row.tipe_pandu_name+"</div>";
              else if(row.tipe==1 && row.tipe_pandu == 2)
                return "<div class='badge badge-danger'>"+row.tipe_pandu_name+"</div>";
              else 
                return "<div class='badge badge-success'>LABUH</div>";
            }
          }
        ],
        "createdRow": function( row, data, dataIndex){
          console.log(data.tipe);
            if(data.tipe == '0'){
                $(row).css("background", "#7dffa4");
            } else if(data.tipe == '1') {
                $(row).css("background", "#ffe18f");
            }
        }
    });
  }

</script>
@endsection