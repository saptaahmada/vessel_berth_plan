<!DOCTYPE html>
<head>
<title>LOGIN | VIERA </title>
<link rel="shortcut icon" href="{{asset('/img/icon.png')}}">
<link rel="stylesheet" type="text/css" href="{{asset('asset/css/css/bootstrap.min.css')}}">
<link href="{{asset('asset/css/style.css')}}" rel="stylesheet">


<style>
    html { 
    /* background: url('/vesselberthplan/public/img/bgterminal.jpg') no-repeat center center fixed;  */
    background: url({{ URL::asset('public/img/bgterminal.jpg') }}) no-repeat center center fixed;

    
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    overflow: hidden;
    }

    img{
    display: block;
    margin: auto;
    margin-top:30px;
    width: 170px;
    height: auto;
    
    }

    #login-button{
    cursor: pointer;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 30px;
    margin: auto;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: #000;
    overflow: hidden;
    opacity: 0.8;
    box-shadow: 10px 10px 30px #000;}

    /* Login container */
    #container{
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    width: 300px;
    height: 580px;
    border-radius: 5px;
    background: rgba(3,3,3,.9);
    box-shadow: 1px 1px 50px #000;
    display: none;
    }

    .close-btn{
    position: absolute;
    cursor: pointer;
    font-family: 'Open Sans Condensed', sans-serif;
    line-height: 18px;
    top: 3px;
    right: 3px;
    width: 20px;
    height: 20px;
    text-align: center;
    border-radius: 10px;
    opacity: .2;
    -webkit-transition: all 2s ease-in-out;
    -moz-transition: all 2s ease-in-out;
    -o-transition: all 2s ease-in-out;
    transition: all 0.2s ease-in-out;
    }

    .close-btn:hover{
    opacity: .5;
    }

    /* Heading */
    h1{
        font-family: 'Open Sans Condensed', sans-serif;
        position: relative;
        margin-top: 38px;
        margin-bottom: -3px;
        text-align: center;
        font-size: 29px;
        font-style: italic;
        color: #ddd;
        text-shadow: 3px 3px 10px #000;
    }
    h4{
    font-family: 'Open Sans Condensed', sans-serif;
    position: relative;
    margin-top: -32px;
    text-align: center;
    font-size: 15px;
    color: #ddd;
    text-shadow: 3px 3px 10px #000;
    }

    /* Inputs */
    a,
    input, input[type='text']{
    font-family: 'Open Sans Condensed', sans-serif;
    text-decoration: none;
    position: relative;
    width: 80%;
    display: block;
    margin: 9px auto;
    font-size: 14px;
    color: #fff;
    padding: 8px;
    border-radius: 6px;
    border: none;
    background: rgba(3,3,3,.8);
    -webkit-transition: all 2s ease-in-out;
    -moz-transition: all 2s ease-in-out;
    -o-transition: all 2s ease-in-out;
    transition: all 0.2s ease-in-out;
    }
    input[type='checkbox']{
    font-family: 'Open Sans Condensed', sans-serif;
    text-decoration: none;
    position: absolute;
    width: 25%;
    display: block;
    /* margin: 9px auto; */
    font-size: 14px;
    color: #fff;
    padding: 8px;
    border-radius: 6px;
    border: none;
    background: rgba(3,3,3,.8);
    -webkit-transition: all 2s ease-in-out;
    -moz-transition: all 2s ease-in-out;
    -o-transition: all 2s ease-in-out;
    transition: all 0.2s ease-in-out;
    }
   

    input:focus{
    outline: none;
    box-shadow: 3px 3px 10px #333;
    background: rgba(3,3,3,.18);
    }

    /* Placeholders */
    ::-webkit-input-placeholder {
    color: #ddd;  }
    :-moz-placeholder { /* Firefox 18- */
    color: red;  }
    ::-moz-placeholder {  /* Firefox 19+ */
    color: red;  }
    :-ms-input-placeholder {  
    color: #333;  }

    /* Link */
    a{
    font-family: 'Open Sans Condensed', sans-serif;
    text-align: center;
    padding: 4px 8px;
    background: rgba(107,255,3,0.3);
    }

    a:hover{
    opacity: 0.7;
    }

    #remember-container{
    position: relative;
    margin: -5px 20px;
    }

    .checkbox {
    position: relative;
    cursor: pointer;
        -webkit-appearance: none;
        padding: 5px;
        border-radius: 4px;
    background: rgba(3,3,3,.2);
        display: inline-block;
    width: 16px;
    height: 15px;
    }

    .checkbox:checked:active {
        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);
    }

    .checkbox:checked {
    background: rgba(3,3,3,.4);
        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.5);
        color: #fff;
    }

    .checkbox:checked:after {
        content: '\2714';
        font-size: 10px;
        position: absolute;
        top: 0px;
        left: 4px;
        color: #fff;
    }

    #remember{
    position: absolute;
    font-size: 13px;
    font-family: 'Hind', sans-serif;
    color: rgba(255,255,255,.5);
    top: 7px;
    left: 20px;
    }

    #forgotten{
    position: absolute;
    font-size: 12px;
    font-family: 'Hind', sans-serif;
    color: rgba(255,255,255,.2);
    right: 0px;
    top: 8px;
    cursor: pointer;
    -webkit-transition: all 2s ease-in-out;
    -moz-transition: all 2s ease-in-out;
    -o-transition: all 2s ease-in-out;
    transition: all 0.2s ease-in-out;
    }

    #forgotten:hover{
    color: rgba(255,255,255,.6);
    }

    #forgotten-container{
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    width: 260px;
    height: 180px;
    border-radius: 10px;
    background: rgba(3,3,3,0.25);
    box-shadow: 1px 1px 50px #000;
    display: none;
    }

    .orange-btn{
    background: rgba(87,198,255,.5);
    }

    .button {
    font-family: 'Open Sans Condensed', sans-serif;
    text-decoration: none;
    position: relative;
    width: 80%;
    display: block;
    margin: 30px auto;
    font-size: 14px;
    color: #fff;
    padding: 8px;
    border-radius: 6px;
    border: none;
    background: rgba(107,255,3,0.3);
    -webkit-transition: all 2s ease-in-out;
    -moz-transition: all 2s ease-in-out;
    -o-transition: all 2s ease-in-out;
    transition: all 0.2s ease-in-out;
    cursor:pointer;
    }
    .button:hover{
    opacity: 0.7;
    }

    .button2 {
    font-family: 'Open Sans Condensed', sans-serif;
    text-decoration: none;
    position: relative;
    width: 80%;
    display: block;
    margin: 30px auto;
    font-size: 14px;
    color: #fff;
    padding: 8px;
    border-radius: 6px;
    border: none;
    background: blue;
    -webkit-transition: all 2s ease-in-out;
    -moz-transition: all 2s ease-in-out;
    -o-transition: all 2s ease-in-out;
    transition: all 0.2s ease-in-out;
    cursor:pointer;
    }
    .button2:hover{
    opacity: 0.7;
    }
    .pass{
        margin-left: 50px;
        color: #fff;
        font-size: 11px; 
    }
    .snap{
        margin-top:-5px;
        margin-left: 30px;
        color: #E50000;
        font-size: 14px; 
    }
    
</style>

</head>

<div id="container">
    <img src="{{asset('/img/VIERA33.png')}}"></img>
    <h1 id="m_title">LOGIN</h1>
    <!-- <h4>Vessel Information Berthing Plan</h4> -->
    
    <!-- <span class="close-btn">
        <img src="https://cdn4.iconfinder.com/data/icons/miu/22/circle_close_delete_-128.png"></img>
    </span> -->

    <form class="form-signin" method="POST" action="{{ route('loginproses') }}">
        @csrf
        <input type="text" id="username" name="username" placeholder="Username" required>
        <input type="password" id="pass" name="pass" placeholder="Password" required>

        <!-- <div class="form-group form-animate-text" style="margin-top:40px !important;">
            <input type="text" id="username" name="username" class="form-text"  style=" margin-top: -45px;" required>
            <label>Username</label>
        </div>
        <div class="form-group form-animate-text" style="margin-top:40px !important;">
            <input type="password" id="pass" name="pass" class="form-text" style=" margin-top: -25px;" required>
            <label>Password</label>
        </div> -->
       
        <input type="checkbox" id="showpass"><span class="pass"> Show Password</span>

       
        <button type="submit" class="button">Login</button>
        <span style="margin-left: 30px; color: white; cursor: pointer;" id="btn_login_customer">
            Login pengguna jasa >>
        </span>
        <!-- <div style="width:280px; margin:auto;" class="alert alert-danger alert-dismissible fade in" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
            session
        </div> -->

        @if (session('message'))
        <div style="width:280px; margin:auto;margin-top: -15px;" class="alert alert-danger alert-dismissible fade in" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
            {{session('message')}}
        </div>
        @endif

        

    </form>

    <div id="div_message" style="margin:10px"></div>

    <form class="form-customer">
        @csrf
        <div id="div_customer_1">
            <input type="text" id="hp" name="hp" placeholder="No HP">
            <div class="button" id="submit_login_customer_1">Login</div>
        </div>
        <div id="div_customer_2">
            <input type="text" id="code" name="code" placeholder="Masukkan Kode Verifikasi">
            <div class="button" id="submit_login_customer_2">Konfirm</div>
        </div>
    </form>
    

    
</div>

    <!-- Forgotten Password Container -->
    <!-- <div id="forgotten-container">
        <h1>Forgotten</h1>
        <span class="close-btn">
            <img src="https://cdn4.iconfinder.com/data/icons/miu/22/circle_close_delete_-128.png"></img>
        </span>

        <form>
            <input type="email" name="email" placeholder="E-mail">
            <a href="#" class="orange-btn">Get new password</a>
        </form>
    </div> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="{{asset('asset/js/jquery.min.js')}}"></script>
<script src="{{asset('asset/js/jquery.ui.min.js')}}"></script>
<script src="{{asset('asset/js/bootstrap.min.js')}}"></script>


  <!-- plugins -->
  <script src="{{asset('asset/js/plugins/moment.min.js')}}"></script>
  <script src="{{asset('asset/js/plugins/jquery.nicescroll.js')}}"></script>


  <!-- custom -->
  <script src="{{asset('asset/js/main.js')}}"></script>

    <script>
  

    $(document).ready(function(){
        $("#container").fadeIn();
            // TweenMax.from("#container", .4, { scale: 0, ease:Sine.easeInOut});
            // TweenMax.to("#container", .4, { scale: 1, ease:Sine.easeInOut});
    });


    </script>
    <script type="text/javascript">
    $(document).ready(function(){		
		$('#showpass').click(function(){
			if($(this).is(':checked')){
				$('#pass').attr('type','text');
			}else{
				$('#pass').attr('type','password');
			}
		});
        $('.form-signin').show();
        $('.form-customer').hide();
        $('#div_customer_1').show();
        $('#div_customer_2').hide();
	});

    $('#btn_login_customer').on('click', function () {
        $('.form-signin').hide();
        $('.form-customer').show();
    })

    $('#submit_login_customer_1').on('click', function () {
        $.ajax({  
            url : "{{route('login_customer_1')}}",
            type : "post",
            data : {
                "_token": "{{ csrf_token() }}",
                'hp' : $('#hp').val()
            },
            dataType : "json",
            async : false,
            success : function(result){
                if(result.success) {
                    $('#div_customer_1').hide();
                    $('#div_customer_2').show();
                }
                $('#div_message').html(result.message);
            }
        });
    })

    $('#submit_login_customer_2').on('click', function () {
        $.ajax({  
            url : "{{route('login_customer_2')}}",
            type : "post",
            data : {
                "_token": "{{ csrf_token() }}",
                'hp' : $('#hp').val(),
                'code' : $('#code').val(),
            },
            dataType : "json",
            async : false,
            success : function(result){
                if(result.success) {
                    window.location = "{{url('ReqBerth')}}";
                }
                $('#div_message').html(result.message);
            }
        });
    })
    </script>
