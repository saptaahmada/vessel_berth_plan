<!DOCTYPE html>
<head>
<title>ROLE | VIERA </title>
<link rel="shortcut icon" href="{{asset('/img/icon.png')}}">
<link rel="stylesheet" type="text/css" href="{{asset('asset/css/css/bootstrap.min.css')}}">
<link href="{{asset('asset/css/style.css')}}" rel="stylesheet">


<style>
    html { 
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
    height: 550px;
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
    <h1>Select Role</h1>
    <!-- <h4>Vessel Information Berthing Plan</h4> -->
    
    <!-- <span class="close-btn">
        <img src="https://cdn4.iconfinder.com/data/icons/miu/22/circle_close_delete_-128.png"></img>
    </span> -->

    <div id="role">
       
        

       
       
        <!-- <button class="button">User</button> -->

        <!-- <div style="width:280px; margin:auto;" class="alert alert-danger alert-dismissible fade in" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
            session
        </div> -->
<!-- 
        @if (session('message'))
        <div style="width:280px; margin:auto;margin-top: -15px;" class="alert alert-danger alert-dismissible fade in" role="alert">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
            {{session('message')}}
        </div>
        @endif -->

        

    </div>

    
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

<script>
    $.ajax({  
        url : "{{route('roleproses')}}",
        type : "get",
        dataType : "json",
        async : false,
        success : function(result){
            var role =result; //berbentuk Array ["1,2"]
            var implode = role.join(" "); //merubah ke sting 1,2
            var button_role = implode.split(","); //merubah ke array lagi ["1","2"]

            // console.log(explode);



            var roleloop = "";
            for (var x = 0; x < button_role.length; x++) { //Move the for loop from here
                roleloop += '<button class="button"  value="'+button_role[x]+'" onClick="getrole(this.value)">'+button_role[x]+'</button>';
            };
            $("#role").append(
                roleloop    
            );
        } 
    });

    function getrole(aksesparam) {
        // console.log(aksesparam);
        var session =""
        if (aksesparam == "ADMIN") {
           session ="ADMIN"
            }
        else if (aksesparam == "VESSEL PLANNER") {
           session ="VESSEL PLANNER"
            }
        else {
           session =" "
            } 


    $.ajax({  
        url : "{{route('rolesession')}}",
        type : "post",
        data: {
            "_token": "{{ csrf_token() }}",
            param_role:session
            },
        dataType : "json",
        async : false,
        success : function(result){
            window.location="{{ URL::to('/Dashboard') }}"
            
        }
    });

        
    }
</script>

<!-- <script type="text/javascript">
    $(document).ready(function(){		
		$('#showpass').click(function(){
			if($(this).is(':checked')){
				$('#pass').attr('type','text');
			}else{
				$('#pass').attr('type','password');
			}
		});
	});
</script> -->
