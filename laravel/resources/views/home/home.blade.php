<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<meta name="description" content="Miminium Admin Template v.1">
	<meta name="author" content="Isna Nur Azis">
	<meta name="keyword" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VIERA | VESSEL INFORMATION BERTHING PLAN</title>
 
    <!-- start: Css -->
    <!-- <link rel="stylesheet" type="text/css" href="{{asset('asset/css/bootstrap.min.css')}}"> -->
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/css/bootstrap.min.css')}}">

      <!-- plugins -->
      <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/font-awesome.min.css')}}"/>
      <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/datatables.bootstrap.min.css')}}"/>
      <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/simple-line-icons.css')}}"/>
      <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/animate.min.css')}}"/>
      <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/fullcalendar.min.css')}}"/>
      <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/ionrangeslider/ion.rangeSlider.css')}}"/>
      <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/ionrangeslider/ion.rangeSlider.skinFlat.css')}}"/>
    	<link href="{{asset('asset/css/style.css')}}" rel="stylesheet">
	<!-- end: Css -->

	<link rel="shortcut icon" href="{{asset('/img/icon.png')}}">


  <link href="{{asset('asset/css/resizing.css')}}" rel="stylesheet">
  <!-- <script src="{{asset('asset/js/jquery/jquery.min.js')}}"></script> -->
  <script src="{{asset('asset/js/jquery.min.js')}}"></script>
  <script src="{{asset('asset/js/jquery.ui.min.js')}}"></script>

  <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>


    <!-- start: Javascript -->
    
    <script src="{{asset('asset/js/bootstrap.min.js')}}"></script>
   
    
    <!-- plugins -->
    <script src="{{asset('asset/js/plugins/moment.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/jquery.datatables.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/datatables.bootstrap.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/fullcalendar.min.js')}}"></script>
    <script src="{{asset('asset/js/plugins/jquery.nicescroll.js')}}"></script>

  

    <!-- custom -->
     <script src="{{asset('asset/js/main.js')}}"></script>

  <style type="text/css">
  .preloader {
    position: fixed;
    cursor: wait;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background-color: #fff;
    filter: alpha(opacity=60);
    opacity: 0.6;
  }
  .preloader .loading {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
    font: 14px arial;
  }
  .preloader .loading .p{
    text-align :center;
  }
  .preloader .loading .img{
    text-align :center;
  }
  </style>
 
  </head>

 <body id="mimin" class="dashboard">

    <div class="preloader">
      <div class="loading">
        <img src="{{asset('img/ajax-loader.gif')}}">
      </div>
    </div>

      <!-- start: Header -->
      @include('home.topbar')
      <!-- end: Header -->

      <div class="container-fluid mimin-wrapper">
  
          <!-- start:Left Menu -->
          @include('home.sidebar')
          <!-- end: Left Menu -->

  		
          <!-- start: content -->
            @yield('content')
          <!-- end: content -->

    
         
          
      </div>

      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
                <ul class="nav nav-list">
                    
                    <li class="ripple">
                      <a href="calendar.html">
                         <span class="fa fa-calendar-o"></span>Calendar
                      </a>
                    </li>
                    <li class="ripple">
                      <a class="tree-toggle nav-header">
                        <span class="fa fa-envelope-o"></span>Mail
                        <span class="fa-angle-right fa right-arrow text-right"></span>
                      </a>
                      <ul class="nav nav-list tree">
                        <li><a href="mail-box.html">Inbox</a></li>
                        <li><a href="compose-mail.html">Compose Mail</a></li>
                        <li><a href="view-mail.html">View Mail</a></li>
                      </ul>
                    </li>
                    <li class="ripple">
                      <a class="tree-toggle nav-header">
                        <span class="fa fa-file-code-o"></span>Pages
                        <span class="fa-angle-right fa right-arrow text-right"></span>
                      </a>
                      <ul class="nav nav-list tree">
                        <li><a href="forgotpass.html">Forgot Password</a></li>
                        <li><a href="login.html">SignIn</a></li>
                        <li><a href="reg.html">SignUp</a></li>
                        <li><a href="article-v1.html">Article v1</a></li>
                        <li><a href="search-v1.html">Search Result v1</a></li>
                        <li><a href="productgrid.html">Product Grid</a></li>
                        <li><a href="profile-v1.html">Profile v1</a></li>
                        <li><a href="invoice-v1.html">Invoice v1</a></li>
                      </ul>
                    </li>
                     <li class="ripple"><a class="tree-toggle nav-header"><span class="fa "></span> MultiLevel  <span class="fa-angle-right fa right-arrow text-right"></span> </a>
                      <ul class="nav nav-list tree">
                        <li><a href="view-mail.html">Level 1</a></li>
                        <li><a href="view-mail.html">Level 1</a></li>
                        <li class="ripple">
                          <a class="sub-tree-toggle nav-header">
                            <span class="fa fa-envelope-o"></span> Level 1
                            <span class="fa-angle-right fa right-arrow text-right"></span>
                          </a>
                          <ul class="nav nav-list sub-tree">
                            <li><a href="mail-box.html">Level 2</a></li>
                            <li><a href="compose-mail.html">Level 2</a></li>
                            <li><a href="view-mail.html">Level 2</a></li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                    <li><a href="credits.html">Credits</a></li>
                  </ul>
            </div>
        </div>       
      </div>
      <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle btn-danger">
        <span class="fa fa-bars"></span>
      </button>
       <!-- end: Mobile -->


     <script>
    $(document).ready(function(){
    $(".preloader").fadeOut();
    });
    </script>
     
  <!-- end: Javascript -->
  </body>
</html>