<nav class="navbar navbar-default header navbar-fixed-top">
    <div class="col-md-12 nav-wrapper">
        <div class="navbar-header" style="width:100%;">
            <div class="opener-left-menu is-open">
            <span class="top"></span>
            <span class="middle"></span>
            <span class="bottom"></span>
            </div>
          
            
            <!-- <span><b>VESSEL INFORMATION BERTHING PLAN </b></span> -->
            <a href="#" class="navbar-brand"> 
                 <span><img style="width:86px; height:57px; margin-top:-14px;  margin-left:-5px;"  src="{{asset('/img/VIERA512.png')}}"></span>
            </a>
            <a href="#" class="navbar-brand" > 
            <img style="width:220px; height:39px; margin-left:-34px; margin-top:-5px;"  src="{{asset('/img/VIERAWORD.png')}}"></span>
            </a>
           
            <ul class="nav navbar-nav navbar-right user-nav">
           
            <li class="user-name"><span style="text-transform: uppercase;"> {{session('data')}}</span></li>
        

                <li class="dropdown avatar-dropdown">
                <img src="{{asset('/asset/img/avatar.jpg')}}" style="margin-right:10px;" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>
                <ul class="dropdown-menu user-dropdown">
                    <!-- <li><a><span class="fa fa-user"></span> {{session('data')}}</a></li> -->
                    <!-- <li><a href="#"><span class="fa fa-envelope"></span>{{session('email')}}</a></li>
                    <li><a href="#"><span class="fa fa-phone"></span>{{session('hp')}}</a></li> -->
                    <li role="separator" class="divider"></li>
                    <li class="more">
                    <ul>
                    
                    <li><a href="{{route('logout') }}"><span class="fa fa-power-off "></span> Logout</a></li>
                    </ul>
                </li>
                </ul>
            </li>
            <!-- <li ><a href="#" class="opener-right-menu"><span class="fa fa-coffee"></span></a></li> -->
            </ul>
        </div>
    </div>
</nav>