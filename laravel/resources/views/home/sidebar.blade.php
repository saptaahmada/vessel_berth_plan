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
            <li class="ripple"><a href="{{ url('EquipmentPlan') }}"><span class="fa fa-ship"></span>Equipment Plan</a></li>
            <li class="ripple"><a href="{{ url('YardPlan') }}"><span class="fa fa-ship"></span>Yard Plan</a></li>
            <li class="ripple"><a href="{{ url('VesselSim') }}"><span class="fa-ship fa"></span>Change Ves Id</a></li>
            <li class="ripple"><a class="tree-toggle nav-header"><span class="fa fa-table"></span>Data Master  <span class="fa-angle-right fa right-arrow text-right"></span> </a>
              <ul class="nav nav-list tree">
                <li><a style="margin-top:-10px;" href="{{ url('VesselBerthPlan_Logo') }}"><span></span><span></span>Customer</a></li>
                <li><a style="margin-top:-20px;" href="{{ url('MPic') }}"><span></span><span></span>PIC</a></li>
                <li><a style="margin-top:-20px;" href="{{ url('Dermaga') }}"><span></span><span></span>Dermaga</a></li>
                <li><a style="margin-top:-20px;" href="{{ url('Blokirkade') }}"><span></span><span></span>Blokir Kade</a></li>
                <li><a style="margin-top:-20px;" href="{{ url('Signature') }}"><span></span><span></span>Signature</a></li>
                <li><a style="margin-top:-20px;" href="{{ url('Arus') }}"><span></span><span></span>Arus</a></li>
                <!-- <li><a style="margin-top:-20px;" href="{{ url('MHoliday') }}"><span></span><span></span>Libur</a></li> -->
               
              </ul>
            </li>
            <li class="ripple"><a class="tree-toggle nav-header"><span class="fa fa-table"></span>Monitoring  <span class="fa-angle-right fa right-arrow text-right"></span> </a>
              <ul class="nav nav-list tree">
                <li><a style="margin-top:-10px;" href="{{ url('MonReqPandu') }}"><span></span><span></span>PMH Pely. Kapal</a></li>
                <li><a style="margin-top:-20px;" href="{{ url('MonAssignmentPandu') }}"><span></span><span></span>Assignment Pandu</a></li>
                <li><a style="margin-top:-20px;" href="{{ url('Monitoring/0') }}"><span></span><span></span>Monitoring Berth Plan</a></li>
                <li><a style="margin-top:-20px;" href="{{ url('Monitoring/1') }}"><span></span><span></span>Monitoring Berth Act</a></li>
                <li><a style="margin-top:-20px;" href="{{ url('MonEquipmentPlan') }}"><span></span><span></span>Monitoring EQ Plan</a></li>
              </ul>
            </li>
            @elseif (session('role') === "VESSEL PLANNER")
            <li class="ripple"><a href="{{ url('Dashboard') }}"><span class="fa-home fa"></span>Dashboard</a></li>
            <li class="ripple"><a href="{{ url('VesselBerthPlan') }}"><span class="fa fa-ship"></span>Berth Plan</a></li>
            <li class="ripple"><a href="{{ url('Monitoring/0') }}"><span class="fa fa-inbox"></span>Monitoring Berth Plan</a></li>
            <li class="ripple"><a href="{{ url('Monitoring/1') }}"><span class="fa fa-inbox"></span>Monitoring Berth Act</a></li>
            @elseif (session('role') === "CUSTOMER")
            <!-- <li class="ripple"><a href="{{ url('Dashboard') }}"><span class="fa-home fa"></span>Dashboard</a></li> -->
            <li class="ripple"><a href="{{ url('ReqBerth') }}"><span class="fa-home fa"></span>Req Vessel Berth</a></li>
            @elseif (session('role') === "PIC PDS")
            <!-- <li class="ripple"><a href="{{ url('Dashboard') }}"><span class="fa-home fa"></span>Dashboard</a></li> -->
            <li class="ripple"><a href="{{ url('EquipmentPlanAsg') }}"><span class="fa-home fa"></span>Equipment</a></li>
            <li class="ripple"><a href="{{ url('EqpAsgTheme') }}"><span class="fa-home fa"></span>Master Template</a></li>
            @elseif (session('role') === "PIC BDS")
            <!-- <li class="ripple"><a href="{{ url('Dashboard') }}"><span class="fa-home fa"></span>Dashboard</a></li> -->
            <li class="ripple"><a href="{{ url('EquipmentPlanAsg') }}"><span class="fa-home fa"></span>Equipment</a></li>
            <li class="ripple"><a href="{{ url('EqpAsgTheme') }}"><span class="fa-home fa"></span>Master Template</a></li>
            @else 
            <li class="ripple"><a href="{{ url('Dashboard') }}"><span class="fa-home fa"></span>Dashboard</a></li>
            <!-- <li class="ripple"><a href="{{ url('Monitoring/0') }}"><span class="fa fa-inbox"></span>Monitoring Berth Plan</a></li> -->
            @endif

        </ul>
        
    </div>
</div>
<div id="menu_mobile">
    <div class="panel box-shadow-none content-header">
        <div class="panel-body">
            <ul class="nav nav-list">
                <li style="margin-top: 50px"><div class="left-bg"></div></li>
                @if (session('role') === "ADMIN")
                <li style="font-size: 20px"><a href="{{ url('Dashboard') }}"><span class="fa-home fa"></span>Dashboard</a></li>
                <li style="font-size: 20px"><a href="{{ url('VesselBerthPlan3') }}"><span class="fa fa-ship"></span>Berth Plan</a></li>
                <li style="font-size: 20px"><a href="{{ url('EquipmentPlan') }}"><span class="fa fa-ship"></span>Equipment Plan</a></li>
                <li style="font-size: 20px"><a class="tree-toggle nav-header"><span class="fa fa-table"></span>Data Master  <span class="fa-angle-right fa right-arrow text-right"></span> </a>
                  <ul class="nav nav-list tree">
                    <li><a style="margin-top:-10px;" href="{{ url('VesselBerthPlan_Logo') }}"><span></span><span></span>Customer</a></li>
                    <li><a style="margin-top:-20px;" href="{{ url('MPic') }}"><span></span><span></span>PIC</a></li>
                    <li><a style="margin-top:-20px;" href="{{ url('Dermaga') }}"><span></span><span></span>Dermaga</a></li>
                    <li><a style="margin-top:-20px;" href="{{ url('Blokirkade') }}"><span></span><span></span>Blokir Kade</a></li>
                    <li><a style="margin-top:-20px;" href="{{ url('Signature') }}"><span></span><span></span>Signature</a></li>
                    <li><a style="margin-top:-20px;" href="{{ url('Arus') }}"><span></span><span></span>Arus</a></li>
                    <!-- <li><a style="margin-top:-20px;" href="{{ url('MHoliday') }}"><span></span><span></span>Libur</a></li> -->
                   
                  </ul>
                </li>
                <li style="font-size: 20px"><a class="tree-toggle nav-header"><span class="fa fa-table"></span>Monitoring  <span class="fa-angle-right fa right-arrow text-right"></span> </a>
                  <ul class="nav nav-list tree">
                    <li><a style="margin-top:-10px;" href="{{ url('MonReqPandu') }}"><span></span><span></span>PMH Pely. Kapal</a></li>
                    <li><a style="margin-top:-20px;" href="{{ url('MonAssignmentPandu') }}"><span></span><span></span>Assignment Pandu</a></li>
                    <li><a style="margin-top:-20px;" href="{{ url('Monitoring/0') }}"><span></span><span></span>Monitoring Berth Plan</a></li>
                    <li><a style="margin-top:-20px;" href="{{ url('Monitoring/1') }}"><span></span><span></span>Monitoring Berth Act</a></li>
                  </ul>
                </li>
                @elseif (session('role') === "VESSEL PLANNER")
                <li style="font-size: 20px"><a href="{{ url('Dashboard') }}"><span class="fa-home fa"></span>Dashboard</a></li>
                <li style="font-size: 20px"><a href="{{ url('VesselBerthPlan') }}"><span class="fa fa-ship"></span>Berth Plan</a></li>
                <li style="font-size: 20px"><a href="{{ url('Monitoring/0') }}"><span class="fa fa-inbox"></span>Monitoring Berth Plan</a></li>
                <li style="font-size: 20px"><a href="{{ url('Monitoring/1') }}"><span class="fa fa-inbox"></span>Monitoring Berth Act</a></li>
                @elseif (session('role') === "CUSTOMER")
                <!-- <li style="font-size: 20px"><a href="{{ url('Dashboard') }}"><span class="fa-home fa"></span>Dashboard</a></li> -->
                <li style="font-size: 20px"><a href="{{ url('ReqBerth') }}"><span class="fa-home fa"></span>Req Vessel Berth</a></li>
                @elseif (session('role') === "PIC PDS")
                <!-- <li style="font-size: 20px"><a href="{{ url('Dashboard') }}"><span class="fa-home fa"></span>Dashboard</a></li> -->
                <li style="font-size: 20px"><a href="{{ url('EquipmentPlanAsg') }}"><span class="fa-truck fa"></span> Ploting Truck</a></li>
                <li style="font-size: 20px"><a href="{{ url('EqpAsgTheme') }}"><span class="fa-tag fa"></span> Master Template</a></li>
                @elseif (session('role') === "PIC BDS")
                <!-- <li style="font-size: 20px"><a href="{{ url('Dashboard') }}"><span class="fa-home fa"></span>Dashboard</a></li> -->
                <li style="font-size: 20px"><a href="{{ url('EquipmentPlanAsg') }}"><span class="fa-truck fa"></span> Ploting Truck</a></li>
                <li style="font-size: 20px"><a href="{{ url('EqpAsgTheme') }}"><span class="fa-tag fa"></span> Master Template</a></li>
                @else 
                <li style="font-size: 20px"><a href="{{ url('Dashboard') }}"><span class="fa-home fa"></span>Dashboard</a></li>
                <!-- <li class="ripple"><a href="{{ url('Monitoring/0') }}"><span class="fa fa-inbox"></span>Monitoring Berth Plan</a></li> -->
                @endif

            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        if ($(window).width() < 700){
            // alert("mobile");
            $('#menu_mobile').show();
        }
        else {
            // alert("not mobile");
            $('#menu_mobile').hide();
        }
    });
</script>