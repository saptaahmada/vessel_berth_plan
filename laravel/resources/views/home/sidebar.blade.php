<div id="left-menu">
    <div class="sub-left-menu scroll">
        <ul class="nav nav-list">
            <li><div class="left-bg"></div></li>
            <li class="time">
              <?php 
               $date = date('l, F jS Y');
               $time = date('H:i');
              ?>
                <h1 class="animated fadeInLeft"><?php echo $time ?></h1>
                <p class="animated fadeInRight"><?php echo $date ?></p>
            </li>
            @if (session('role') === "ADMIN")
            <li class="ripple"><a href="{{ url('Dashboard') }}"><span class="fa-home fa"></span>Dashboard</a></li>
            <li class="ripple"><a href="{{ url('VesselBerthPlan3') }}"><span class="fa fa-ship"></span>Berth Plan</a></li>
            <li class="ripple"><a href="{{ url('Monitoring') }}"><span class="fa fa-inbox"></span>Monitoring Berth Plan</a></li>
            <li class="ripple"><a class="tree-toggle nav-header"><span class="fa fa-table"></span>Data Master  <span class="fa-angle-right fa right-arrow text-right"></span> </a>
              <ul class="nav nav-list tree">
                <li><a style="margin-top:-10px;" href="{{ url('VesselBerthPlan_Logo') }}"><span></span><span></span>Customer</a></li>
                <li><a style="margin-top:-15px;" href="{{ url('Dermaga') }}"><span></span><span></span>Dermaga</a></li>
                <li><a style="margin-top:-15px;" href="{{ url('Blokirkade') }}"><span></span><span></span>Blokir Kade</a></li>
                <li><a style="margin-top:-15px;" href="{{ url('Signature') }}"><span></span><span></span>Signature</a></li>
                <li><a style="margin-top:-15px;" href="{{ url('Arus') }}"><span></span><span></span>Arus</a></li>
               
              </ul>
            </li>
            @elseif (session('role') === "VESSEL PLANNER")
            <li class="ripple"><a href="{{ url('Dashboard') }}"><span class="fa-home fa"></span>Dashboard</a></li>
            <li class="ripple"><a href="{{ url('VesselBerthPlan') }}"><span class="fa fa-ship"></span>Berth Plan</a></li>
            <li class="ripple"><a href="{{ url('Monitoring') }}"><span class="fa fa-inbox"></span>Monitoring Berth Plan</a></li>
            @else 
            <li class="ripple"><a href="{{ url('Dashboard') }}"><span class="fa-home fa"></span>Dashboard</a></li>
            <li class="ripple"><a href="{{ url('Monitoring') }}"><span class="fa fa-inbox"></span>Monitoring Berth Plan</a></li>
            @endif

           

        </ul>
        
    </div>
</div>
