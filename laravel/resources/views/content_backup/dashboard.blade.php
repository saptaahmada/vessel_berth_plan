@extends('home.home')

@section('content')

<div id="content">
    <div class="panel box-shadow-none content-header">
        <div class="panel-body">
            <div class="col-md-12">
                <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>Dashboard</b></h3>
                <p class="animated fadeInDown">
                   Selamat Datang di Dashboad 
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-12 top-20 padding-0">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                @if (session('data'))
                    <h3>Welcome <span style="text-transform: uppercase;"> {{session('data')}}</span></h3>
                @endif 
                </div>
                <div class="panel-body">
                   <div> Role  : {{session('role')}}</div>
                   <div> Email : {{session('email')}}</div>
                   <div> No.Hp : {{session('hp')}}</div>

                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
