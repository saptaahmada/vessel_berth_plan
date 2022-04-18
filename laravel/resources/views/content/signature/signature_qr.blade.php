<!DOCTYPE html>
<html lang="en">

<head>


  <meta charset="utf-8">
	<meta name="description" content="Miminium Admin Template v.1">
	<meta name="author" content="Isna Nur Azis">
	<meta name="keyword" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BERITA ACARA | VESSEL INFORMATION BERTHING PLAN</title>

  

  <!-- start: Css -->
  <!-- <link rel="stylesheet" type="text/css" href="{{asset('asset/css/bootstrap.min.css')}}"> -->
  <link rel="stylesheet" type="text/css" href="{{asset('asset/css/css/bootstrap.min.css')}}">


  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/font-awesome.min.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/simple-line-icons.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/animate.min.css')}}" />
  <link href="{{asset('asset/css/style.css')}}" rel="stylesheet">
  <!-- end: Css -->
  <link rel="shortcut icon" href="{{asset('/img/icon.png')}}">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  <style>
    .border
    {
      border-collapse:collapse;
      border:none !important;
    } 
    .border td
    {
      border:none;
      outline:none;
    }
    .responsive {
  width: 100%;
  height: auto;
}
  </style>



</head>

<body id="mimin">

  <div class="container invoice invoice-v1">

    <nav class="navbar navbar-default header invoice-v1-tool container navbar-fixed-top">
      <div class="col-md-12 nav-wrapper">
        <div class="navbar-header" style="width:100%;">
          <a  >
         <img style="width:86px; height:57px; margin-top:0px; margin-right: 15px; margin-left:-5px;"  src="{{asset('/img/VIERA512.png')}}">

            <!-- <img style="width:130px; height:50px; margin-top:-14px;  margin-left:-30px;" src="{{asset('/img/pt_terminal_teluk_lamongnew.png')}}" class="invoice-logo" alt="logo mi" /> -->
            
            <img style="width:220px; height:39px; margin-left:0px; margin-top:0px;"  src="{{asset('/img/VIERAWORD.png')}}"></span>
            <!-- <b style="font-size:21px; " >BERITA ACARA</b> -->
          </a>
          

          <!-- <ul class="nav navbar-nav navbar-right user-nav">
            <li>
              <button class="btn btn-round btn-primary" style="margin-top:10px;">Print</button>
            </li>
          </ul> -->
        </div>
      </div>
    </nav>
    <!-- start: Content -->
    <div class="panel invoice-v1-content">
      <div class="panel-body">
        <div class="col-md-12 invoice-v1-header">
            <div class="col-md-12">
                <b style="font-size:18px;">DATA BERITA ACARA VALID</b>
            </div>

     
            <h4>
              <address>
              <table style="font-size:11px; margin-left:auto; margin-right: auto;">
                  <tr>
                    <td >Judul</td>
                    <td>:</td>
                    <td id="title_doc">PENGESAHAN SHIP BERTHING PLAN TERMINAL TELUK LAMONG 2021</td>
                   
                  </tr>
                  <tr>
                    <td>Nomor Surat</td>
                    <td>:</td>
                    <td id="no_doc">BA.0934/TI.02.03/PTTL-2021</td>
                 
                  </tr>
                  <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td id="nama">PIERRE ROCHEL</td>
                  </tr>
                  <tr>
                    <td>Tanggal Approval</td>
                    <td>:</td>
                    <td id="tgl">05/04/2021 16:16</td>
                  </tr>
                </table>
              </address>
            </h4>
         
        </div>
      
      
      </div>
    </div>
    
    <!-- end: content -->
  </div>

  <!-- start: Javascript -->



  <!-- plugins -->
  
</body>

</html>
<script src="{{asset('asset/js/jquery.min.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>


<script type="text/javascript"> 
    var url_string= window.location.href;
    var url = new URL(url_string);

    var title_doc = url.searchParams.get("title_doc");
    var no_doc = url.searchParams.get("no_doc");
    var nama = url.searchParams.get("bp");
    var tgl = url.searchParams.get("date");

    if(title_doc != '' && title_doc != null) {
      $('#title_doc').text(title_doc);
    }
    $('#no_doc').text(no_doc);
    $('#nama').text(nama);
    $('#tgl').text(tgl);

</script>