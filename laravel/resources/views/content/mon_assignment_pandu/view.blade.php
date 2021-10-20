@extends('home.home')

@section('content')

<div id="content">
  <div class="panel box-shadow-none content-header">
    <div class="panel-body">
        <div class="col-md-12">
          <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>Monitoring Assignment Pandu</b></h3>
          <p class="animated fadeInDown">
           Data Tables <span class="fa-angle-right fa"></span> Monitoring Assignment Pandu
          </p>
        </div>
    </div>
  </div>
  <div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading">
          <h3>Monitoring Assignment Pandu</h3>
        </div>
        <div class="panel-body">
          <div class="responsive-table">
            <table id="table" class="table table-striped table-bordered" width="100%" cellspacing="0">
              <thead>
                <th>No PKK</th>
                <th>No PPK 1</th>
                <th>No PPK Jasa</th>
                <th>KD Kapal</th>
                <th>Nama Kapal</th>
                <th>Callsign Kapal</th>
                <th>Tanggal</th>
                <th>Callsign Pandu</th>
                <th>Nama Pandu</th>
                <th>HP Pandu</th>
                <th>Draft</th>
                <th>Keterangan</th>
                <th>Created date</th>
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
    refreshTable();
  });

  function refreshTable() {
    $('#table').DataTable({
        "filter": true,
        "destroy": true,
        "ordering": false,
        "processing": true, 
        "serverSide": true, 
        "searching": true, 
        "responsive":false,
        "orderCellsTop": true,
        "fixedHeader": true,
        ajax: "{{url('MonAssignmentPandu/json')}}",
        columns: [
          { data: 'no_pkk', name: 'no_pkk' },
          { data: 'no_ppk1', name: 'no_ppk1' },
          { data: 'no_ppk_jasa', name: 'no_ppk_jasa' },
          { data: 'kd_kapal', name: 'kd_kapal' },
          { data: 'nama_kapal', name: 'nama_kapal' },
          { data: 'callsign_vessel', name: 'callsign_vessel' },
          { data: 'tanggal', name: 'tanggal' },
          { data: 'callsign_pandu', name: 'callsign_pandu' },
          { data: 'nama_pandu', name: 'nama_pandu' },
          { data: 'hp_pandu', name: 'hp_pandu' },
          { data: 'draft_kapal', name: 'draft_kapal' },
          { data: 'keterangan', name: 'keterangan' },
          { data: 'created_date', name: 'created_date' },
        ]
    });
  }

</script>
@endsection