@extends('home.home')

@section('content')
@include('cssjs.css3')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/select2.min.css')}}"/>

<!-- <link rel="stylesheet" type="text/css" href="{{asset('asset/css/bootstrap.min.css')}}"> -->
<!-- <link rel="stylesheet" type="text/css" href="{{asset('asset/css/bootstrap.min.css')}}"> -->

<link rel="stylesheet" type="text/css" href="{{asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script src="{{asset('asset/js/plugins/select2.full.min.js')}}"></script>

<script type="text/javascript" src="{{asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>

<style type="text/css">
    .legend {
        display: inline-block; 
        height: 30px; 
        width: 30px; 
    }
    .small_margin {
        padding:3px !important;
    }
</style>


<div id="content">
    <div class="panel">
        <div class="panel-body" >
            <div class="col-md-6 col-sm-12">
            <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>Vessel Berthing Plan</b></h3>
            <p class="animated fadeInDown"><span class="fa  fa-map-marker"></span> Surabaya,Indonesia</p>

            </div>
        </div>                    
    </div>

    <div class="col-md-12 top-20 padding-0">
        <div class="col-md-12">
            <div class="col-md-12 padding-0">
                <div class="panel">
                    <div class="panel-heading">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="well">
                                <button type="button" class="btn ripple-infinite btn-round btn-3d btn-primary"  data-toggle="modal" data-target="#addVessel" style='margin:10px;'>
                                Add Vessel
                                </button>
                                <button type="button" class="btn ripple-infinite btn-round btn-3d btn-info"  data-toggle="modal" data-target="#vessel_unregistered" style='margin:10px;'>
                                Add Vessel Unregistered
                                </button>
                                <button type="button" class="btn ripple-infinite btn-round btn-3d btn-danger"  data-toggle="modal" data-target="#modal_note" style='margin:10px;'>
                                Add Note
                                </button>
                                <button type="button" class="btn ripple-infinite btn-round btn-3d btn-warning"  data-toggle="modal" data-target="#modal_print" style='margin:10px;'>
                                Print Berthing Plan
                                </button>
                                <button type="button" class="btn ripple-infinite btn-round btn-3d btn-default" id="btn_sync" style='margin:10px;'>
                                Sync Now
                                </button>
                                <div>
                                    <input type="checkbox" id="cb_collision"> Vessel tumpuk diperbolehkan
                                </div>
                                <div>
                                    <input type="checkbox" id="cb_distance_vessel"> Tampilkan jarak antar kapal waktu dragging
                                </div>
                                <div>
                                    <input type="checkbox" id="cb_hari_libur"> Sembunyikan Hari Libur
                                </div>
                                <div>
                                    <input type="checkbox" id="cb_arus_minus"> Sembunyikan Arus Minus
                                </div>
                                </div>
                                <h4>Legend</h1>

                                <div class="row">
                                    <div class="col-md-3">
                                        <table>
                                            <tr>
                                                <td class="small_margin"><span class="legend" style="background-color: #a9d18e"></span></td>
                                                <td class="small_margin">Sudah Sandar</td>
                                            </tr>
                                            <tr>
                                                <td class="small_margin"><span class="legend" style="background-color: #9dc3e6"></span></td>
                                                <td class="small_margin">Plan Pasti Sandar</td>
                                            </tr>
                                            <tr>
                                                <td class="small_margin"><span class="legend" style="background-color: #ffe699"></span></td>
                                                <td class="small_margin">Plan Tentatif</td>
                                            </tr>
                                            <tr>
                                                <td class="small_margin"><span class="legend" style="background-color: #ff968f"></span></td>
                                                <td class="small_margin">Note</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-3">
                                        <table>
                                            <tr>
                                                <td class="small_margin"><span class="legend" style="background-color: #f6bfff"></span></td>
                                                <td class="small_margin">Arus Minus</td>
                                            </tr>
                                            <tr>
                                                <td class="small_margin"><span class="legend" style="background-color: #fc4949"></span></td>
                                                <td class="small_margin">Hari Libur</td>
                                            </tr>
                                            <tr>
                                                <td class="small_margin"><span class="legend" style="background-color: #b8b8b8"></span></td>
                                                <td class="small_margin">Blokir Kade</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                </div>

                                
                            </div>
                            <div class="col-sm-6">
                                
                                <div class="well">
                                    <h4>VESSEL BELUM DI INPUT</h4>
                                    <div>
                                      Legend : 
                                      <!-- <button class="badge" onclick="" style="background: #000; color: #FFF">All</button> -->
                                      <div class="badge" style="background: #7dffa4; color: #787878">Insert</div>
                                      <div class="badge" style="background: #ffccfb; color: #787878">Update</div>
                                      <div class="badge" style="background: #ffc6c2; color: #787878">Cancel</div>
                                    </div><br>
                                    <table class="table table-bordered" id="table_ves_not_input">
                                        <thead>
                                            <th>Ves ID</th>
                                            <th>Ves Name</th>
                                            <th>ETA</th>
                                            <th>ETB</th>
                                            <th>LOA</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        

                        

                        <label for="ocean_interisland">Pilih Dermaga :  </label>
                            <input type="radio" id="cekbox1" class="dermaga" name="dermaga" value="D" checked  > Domestic</input> 
                            <input type="radio"  id="cekbox2" class="dermaga" name="dermaga" value="I"  > International</input>
                            <input type="radio"  id="cekbox3" class="dermaga" name="dermaga" value="C" > Curah Kering</input>

                        
                    </div>
                    <div class="panel-body2">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <!-- start -->
                                    <div class="row">
                                        <div class="col-sm-1 divwaktu">
                                            <?php for($i=0; $i<7; $i++) { ?>
                                            <div>
                                                <?php 
                                                    $dateawal = date('d-m-Y');
                                                    $hoursnow = date('H');
                                                    $dateloop = date('d-m-Y', strtotime("+$i day", strtotime($dateawal))); 
                                                ?>
                                                <div>
                                                    <div class = "tanggal">{{$dateloop}}</div>
                                                </div>
                                                <div >
                                                    <div>
                                                        <div class="waktu">00.00</div>
                                                    </div>
                                                    <div >
                                                        <div class="waktu">03.00</div>
                                                    </div>
                                                    <div>
                                                        <div class="waktu">06.00</div>
                                                    </div>
                                                    <div>
                                                        <div class="waktu">09.00</div>
                                                    </div>
                                                    <div>
                                                        <div class="waktu">12.00</div>
                                                    </div>
                                                    <div >
                                                        <div class="waktu">15.00</div>
                                                    </div>
                                                    <div>
                                                        <div class="waktu">18.00</div>
                                                    </div>
                                                    <div>
                                                        <div class="waktu">21.00</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?> 
                                        </div>

                                        <div style="position:absolute; left:80px;" id="div_coba">

                                            @include('content.isi.ruler')

                                            <div id='canvas'>
                                                <div id='wrap_sw'>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    
                                </div>
                                <div class="col-md-2">
                                    <div id="div_request_berth">
                                        
                                    </div>
                                </div>
                            </div>
                                
                                <!-- end -->
                                <!-- Modal Add Vessel -->
                                <div class="modal fade" id="addVessel" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Add Vessel</h4>
                                      </div>
                                      <div class="modal-body">
                                        <label for="ocean_interisland">Pilih Tipe Kapal :  </label>
                                          <input type="radio" id="con" class="kapal" name="kapal" value="C" checked > Container</input> 
                                          <input type="radio" id="dry" class="kapal" name="kapal" value="D"  > Dry Bulk</input> 
                                        <br>        
                                        <form>
                                            {{csrf_field()}}
                                            
                                            <div id="formDry" >
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Vessel Name Vessel 3: </label>
                                                            <select  id="vessel3"  class="select2-A" style="width:100%;"  data-live-search="true">
                                                                    <!-- <option>-----------</option> -->
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Vessel Service :</label>
                                                            <select  id="vesServiceDry" class="form-control" style="width: 100%">
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">ETA : </label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime_2 bs-datetime">
                                                                    <input type="text" id="etADry" size="16" class="form-control">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- <input id="etADry" type="datetime-local" class="form-control"> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">RBT </label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime_2 bs-datetime">
                                                                    <input type="text" id="rbTDry" size="16" class="form-control">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- <input id="rbTDry" type="datetime-local" class="form-control"> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">ETB :</label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime bs-datetime">
                                                                    <input type="text" id="etBDry" size="16" class="form-control" onchange="autofillCon()">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">ETD :</label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime bs-datetime">
                                                                    <input type="text" id="etDDry" size="16" class="form-control">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                        
                                                        <div class="form-group">
                                                            <label class="col-form-label">NEXT PORT :</label>
                                                            <select  id="nextPDry" class="select2-A" style="width:100%;"  data-live-search="true">
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">DEST PORT : </label>
                                                            <select  id="deshPDry" class="select2-A" style="width:100%;"  data-live-search="true">
                                                                    <!-- <option>-----------</option> -->
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-form-label">Crane Density :</label>
                                                            <input id="craneDensityDry" type="text" class="form-control">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-form-label">TGH :</label>
                                                            <input id="tghDry" type="text" class="form-control" onkeyup="autofillCon()">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-form-label">Jumlah Bongkar : </label>
                                                            <input id="bongkarDry" type="number" class="form-control" onkeyup="autofillCon()">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-form-label">Kade Meter : </label>
                                                            <div class="row">
                                                                <div class= "col-sm-5">
                                                                    <input id="startDry" placeholder="Start" type="number" class="form-control" onkeyup="autofillCon();" required>  
                                                                </div>
                                                                <div class= "col-sm-2" style = "margin-left: auto; margin-right: auto;" >
                                                                    TO
                                                                </div>
                                                                <div class= "col-sm-5">
                                                                    <input id="endDry" placeholder="End" type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                        
                                                        <div class="form-group">
                                                            <label class="col-form-label">Along Side : </label>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <input type="radio" id="dry_side_s" class ="sideDry" name="optionDry" value="S" checked=""> Star Board
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="radio" id="dry_side_p" class ="sideDry" name="optionDry" value="P"> Port Side
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Window : </label>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <input type="radio" class ="sideDry" name="windowDry" value="1" checked=""> ON WINDOW
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="radio" class ="sideDry" name="windowDry" value="0"> OFF WINDOW
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Tentatif : </label>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <input type="radio" id="tentatifDry_yes" class ="tentatifDry" name="tentatifDry" value="1" checked=""> Yes
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="radio" id="tentatifDry_no" class ="tentatifDry" name="tentatifDry" value="0"> No
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group" >
                                                            <label class="col-form-label text-right">CRANE :</label><br>
                                                            <div id="craneDry">

                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Info : </label>
                                                            <textarea style="resize: none;" rows="5" class="form-control" id="infoDry"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 well" style="background: #feffb0">
                                                        <div>
                                                        <h4>Arus Minus</h4>
                                                        <table class="table table-bordered" id="dry_table_arus" style="background: white">
                                                            <thead>
                                                                <th>Start</th>
                                                                <th>End</th>
                                                            </thead>
                                                            <tbody id="dry_tbody_arus"></tbody>
                                                        </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="formCon" >
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        
                                                        <div class="form-group">
                                                            <label class="col-form-label">Vessel Name Vessel 2 : </label>
                                                            <select  id="vessel2" class="select2-A" style="width:100%;">
                                                                    <!-- <option>-----------</option> -->
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Vessel Service :</label>
                                                            <select  id="vesService" class="form-control" style="width: 100%">
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">ETA : </label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime_2 bs-datetime">
                                                                    <input type="text" id="etA" size="16" class="form-control">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- <input id="etA" type="datetime-local" class="form-control"> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">RBT </label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime_2 bs-datetime">
                                                                    <input type="text" id="rbT" size="16" class="form-control">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- <input id="rbT" type="datetime-local" class="form-control"> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">ETB :</label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime bs-datetime">
                                                                    <input type="text" id="etB" size="16" class="form-control" onchange="autofillCon()">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- <input id="etB" type="datetime-local"   class="form-control" required> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">ETD :</label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime bs-datetime">
                                                                    <input type="text" id="etD" size="16" class="form-control">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- <input id="etD" type="datetime-local" class="form-control"> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">

                                                        <div class="form-group">
                                                            <label class="col-form-label">NEXT PORT :</label>
                                                            <select  id="nextP"  class="select2-A" style="width:100%;"  data-live-search="true">
                                                            </select>
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">DEST PORT : </label>
                                                            <select  id="deshP"  class="select2-A" style="width:100%;"  data-live-search="true">
                                                                    <!-- <option>-----------</option> -->
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Crane Density :</label>
                                                            <input id="craneDensity" type="text" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">BSH :</label>
                                                            <input id="bsh" type="number" class="form-control" onkeyup="autofillCon()">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-form-label">Jumlah Bongkar : </label>
                                                            <input id="bongkar" type="number" class="form-control" onkeyup="autofillCon()">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Jumlah Muat : </label>
                                                            <input id="muat" type="number" class="form-control" onkeyup="autofillCon()">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Kade Meter : </label>
                                                            <div class="row">
                                                                <div class= "col-sm-5">
                                                                    <input id="start" placeholder="Start" type="number" class="form-control" onkeyup="autofillCon();" required>  
                                                                </div>
                                                                <div class= "col-sm-2" style = "margin-left: auto; margin-right: auto;" >
                                                                    TO
                                                                </div>
                                                                <div class= "col-sm-5">
                                                                    <input id="end" placeholder="End" type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Along Side : </label>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <input type="radio" id="side_s" class ="side" name="option" value="S" checked=""> Star Board
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="radio" id="side_p" class ="side" name="option" value="P"> Port Side
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Window : </label>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <input type="radio" class ="window" name="window" value="1" checked=""> ON WINDOW
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="radio" class ="window" name="window" value="0"> OFF WINDOW
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Tentatif : </label>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <input type="radio" id="tentatif_yes" class ="tentatif" name="tentatif" value="1" checked=""> Yes
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="radio" id="tentatif_no" class ="tentatif" name="tentatif" value="0"> No
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group" >
                                                            <label class="col-form-label text-right">CRANE :</label><br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div id="craneCon">

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div id="craneCon_2">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Info : </label>
                                                            <textarea style="resize: none;" rows="5" class="form-control" id="info"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 well">
                                                        <div>
                                                        <h4>Arus Minus</h4>
                                                        <table class="table table-bordered" id="table_arus" style="background: white">
                                                            <thead>
                                                                <th>Start</th>
                                                                <th>End</th>
                                                            </thead>
                                                            <tbody id="tbody_arus"></tbody>
                                                        </table>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </form>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="eraseTextModalContainer();">Close</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addvessel();" >Add Vessel</button>
                                      </div>
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <!-- Modal end Add Vessel -->

                                <!-- Modal Edit Vessel -->
                                <div class="modal fade" id="editVessel" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Edit Vessel</h4>
                                      </div>
                                      <div class="modal-body">
                                        <label>Tipe Dermaga : </label>
                                          <input type="radio" id="edit_tipe_dermaga_d" class="edit_tipe_dermaga" name="edit_tipe_dermaga" value="D"> Domestik</input> 
                                          <input type="radio" id="edit_tipe_dermaga_i" class="edit_tipe_dermaga" name="edit_tipe_dermaga" value="I"> Internasional</input>
                                          <input type="radio" id="edit_tipe_dermaga_c" class="edit_tipe_dermaga" name="edit_tipe_dermaga" value="C"> Dry Bulk</input>
                                        <br>        
                                        <form>
                                            {{csrf_field()}}

                                            <div id="formCon" >
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Vessel ID: </label>
                                                            <input id="edit_vessel" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Vessel Name: </label>
                                                            <input id="edit_vessel_name" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Vessel Service :</label>
                                                            <select  id="edit_ves_service" class="form-control" style="width: 100%">
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">ETA : </label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime_2 bs-datetime">
                                                                    <input type="text" id="edit_eta" size="16" class="form-control">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- <input id="edit_eta" type="datetime-local" class="form-control"> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">RBT </label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime_2 bs-datetime">
                                                                    <input type="text" id="edit_rbt" size="16" class="form-control">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- <input id="edit_rbt" type="datetime-local" class="form-control"> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">ETB :</label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime bs-datetime">
                                                                    <input type="text" id="edit_etb" size="16" class="form-control">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- <input id="edit_etb" type="datetime-local" class="form-control" required> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">ETD :</label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime bs-datetime">
                                                                    <input type="text" id="edit_etd" size="16" class="form-control">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- <input id="edit_etd" type="datetime-local" class="form-control"> -->
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-4">

                                                        <div class="form-group">
                                                            <label class="col-form-label">NEXT PORT :</label>
                                                            <select  id="edit_nextp" class="select2-A" style="width:100%;"  data-live-search="true">
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">DEST PORT : </label>
                                                            <select  id="edit_deshp" class="select2-A" style="width:100%;"  data-live-search="true">
                                                                    <!-- <option>-----------</option> -->
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Crane Density :</label>
                                                            <input id="edit_crane_density" type="text" class="form-control">
                                                        </div>
                                                        <div class="form-group" id="edit_div_tgh">
                                                            <label class="col-form-label">TGH :</label>
                                                            <input id="edit_tgh" type="number" class="form-control">
                                                        </div>
                                                        <div class="form-group" id="edit_div_bsh">
                                                            <label class="col-form-label">BSH :</label>
                                                            <input id="edit_bsh" type="number" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Jumlah Bongkar : </label>
                                                            <input id="edit_disc" type="number" class="form-control">
                                                        </div>
                                                        <div class="form-group" id="edit_div_load">
                                                            <label class="col-form-label">Jumlah Muat : </label>
                                                            <input id="edit_load" type="number" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Kade Meter : </label>
                                                            <div class="row">
                                                                <div class= "col-sm-5">
                                                                    <input id="edit_start" placeholder="Start" type="number" class="form-control" required>  
                                                                </div>
                                                                <div class= "col-sm-2" style = "margin-left: auto; margin-right: auto;" >
                                                                    TO
                                                                </div>
                                                                <div class= "col-sm-5">
                                                                    <input id="edit_end" placeholder="End" type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-4">

                                                        <div class="form-group">
                                                            <label class="col-form-label">Along Side : </label>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <input type="radio" id="edit_side_s" class ="edit_side" name="edit_option" value="S"> Star Board
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="radio" id="edit_side_p" class ="edit_side" name="edit_option" value="P"> Port Side
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Window : </label>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <input type="radio" id="edit_window_on" class ="edit_window" name="edit_window" value="1"> ON WINDOW
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="radio" id="edit_window_off" class ="edit_window" name="edit_window" value="0"> OFF WINDOW
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Tentatif : </label>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <input type="radio" id="edit_tentatif_yes" class ="edit_tentatif" name="edit_tentatif" value="1"> Yes
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input type="radio" id="edit_tentatif_no" class ="edit_tentatif" name="edit_tentatif" value="0"> No
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group" >
                                                            <label class="col-form-label text-right">CRANE :</label><br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div id="edit_crane">

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div id="edit_crane_2">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="edit_crane_dry">

                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <div class="form-group">
                                                            <label class="col-form-label">Info : </label>
                                                            <textarea style="resize: none;" rows="5" class="form-control" id="edit_info"></textarea>
                                                        </div>


                                                    </div>
                                                    <div class="col-md-6 well">

                                                        <div>
                                                        <h4>Arus Minus</h4>
                                                        <table class="table table-bordered" id="edit_table_arus" style="background: white">
                                                            <thead>
                                                                <th>Start</th>
                                                                <th>End</th>
                                                            </thead>
                                                            <tbody id="edit_tbody_arus"></tbody>
                                                        </table>
                                                        </div>

                                                    </div>
                                                </div>

                                                
                                            </div>
                                            
                                        </form>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="eraseTextModalContainer();">Close</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="editvessel();" >Edit Vessel</button>
                                      </div>
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <!-- Modal end Edit Vessel -->


                                <div class="modal fade" id="vessel_unregistered" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Add Vessel</h4>
                                      </div>
                                      <div class="modal-body">
                                        <label for="ocean_interisland">Pilih Tipe Kapal :  </label>
                                          <input type="radio" id="unreg_con" class="unreg_type" name="unreg_kapal2" value="CONTAINER" checked > Container</input> 
                                          <input type="radio" id="unreg_dry" class="unreg_type" name="unreg_kapal2" value="DRY_BULK"  > Dry Bulk</input>
                                        <br>
                                        <form>
                                            {{csrf_field()}}

                                            <div id="edit_formCon" >
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Vessel ID : </label>
                                                            <input id="unreg_vessel_id" class="form-control">
                                                            <input id="unreg_vessel_code" type="hidden">
                                                            <input id="unreg_vessel_code_mdm" type="hidden">
                                                            <input id="unreg_call_sign" type="hidden">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Vessel Name : </label>
                                                            <input id="unreg_vessel_name" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Vessel Service :</label>
                                                            <select  id="unreg_ves_service" class="form-control" style="width: 100%">
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Vessel Length : </label>
                                                            <input id="unreg_loa" type="number" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">ETA : </label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime_2 bs-datetime">
                                                                    <input type="text" id="unreg_eta" size="16" class="form-control">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- <input id="unreg_eta" type="datetime-local" class="form-control"> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">RBT </label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime_2 bs-datetime">
                                                                    <input type="text" id="unreg_rbt" size="16" class="form-control">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- <input id="unreg_rbt" type="datetime-local" class="form-control"> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">ETB :</label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime bs-datetime">
                                                                    <input type="text" id="unreg_etb" size="16" class="form-control">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- <input id="unreg_etb" type="datetime-local" class="form-control" required> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">ETD :</label>
                                                            <div class="form-group">
                                                                <div class="input-group date form_datetime bs-datetime">
                                                                    <input type="text" id="unreg_etd" size="16" class="form-control">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- <input id="unreg_etd" type="datetime-local" class="form-control"> -->
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-4">

                                                        <div class="form-group">
                                                            <label class="col-form-label">NEXT PORT :</label>
                                                            <select  id="unreg_nextp" class="select2-A" style="width:100%;"  data-live-search="true">
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">DEST PORT : </label>
                                                            <select  id="unreg_deshp" class="select2-A" style="width:100%;"  data-live-search="true">
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Crane Density :</label>
                                                            <input id="unreg_crane_density" type="text" class="form-control">
                                                        </div>
                                                        <div class="form-group" id="unreg_div_bsh">
                                                            <label class="col-form-label">BSH :</label>
                                                            <input id="unreg_bsh" type="number" class="form-control">
                                                        </div>
                                                        <div class="form-group" id="unreg_div_tgh">
                                                            <label class="col-form-label">TGH :</label>
                                                            <input id="unreg_tgh" type="number" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Jumlah Bongkar : </label>
                                                            <input id="unreg_disc" type="number" class="form-control">
                                                        </div>
                                                        <div id="unreg_div_load">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Jumlah Muat : </label>
                                                            <input id="unreg_load" type="number" class="form-control">
                                                        </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Kade Meter : </label>
                                                            <div class="row">
                                                                <div class= "col-sm-5">
                                                                    <input id="unreg_start" placeholder="Start" type="number" class="form-control" required>  
                                                                </div>
                                                                <div class= "col-sm-2" style = "margin-left: auto; margin-right: auto;" >
                                                                    TO
                                                                </div>
                                                                <div class= "col-sm-5">
                                                                    <input id="unreg_end" placeholder="End" type="text" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-4">

                                                        <div class="form-group" >
                                                            <div class="form-group">
                                                                <label class="col-form-label">Along Side : </label>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <input type="radio" id="unreg_side_s" class ="unreg_side" name="unreg_option" value="S" checked=""> Star Board
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <input type="radio" id="unreg_side_p" class ="unreg_side" name="unreg_option" value="P"> Port Side
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-form-label">Window : </label>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <input type="radio" id="unreg_window_on" class ="unreg_window" name="unreg_window" value="1" checked=""> ON WINDOW
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <input type="radio" id="unreg_window_off" class ="unreg_window" name="unreg_window" value="0"> OFF WINDOW
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-form-label">Tentatif : </label>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <input type="radio" id="unreg_tentatif_yes" class ="unreg_tentatif" name="unreg_tentatif" value="1" checked=""> Yes
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <input type="radio" id="unreg_tentatif_no" class ="unreg_tentatif" name="unreg_tentatif" value="0"> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <label class="col-form-label text-right">CRANE :</label><br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div id="unreg_crane">

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div id="unreg_crane_2">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="unreg_crane_dry">

                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <div class="form-group">
                                                            <label class="col-form-label">Info : </label>
                                                            <textarea style="resize: none;" rows="5" class="form-control" id="unreg_info"></textarea>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6 well">
                                                        <div>
                                                        <h4>Arus Minus</h4>
                                                        <table class="table table-bordered" id="unreg_table_arus" style="background: white">
                                                            <thead>
                                                                <th>Start</th>
                                                                <th>End</th>
                                                            </thead>
                                                            <tbody id="unreg_tbody_arus"></tbody>
                                                        </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            

                                            </div>
                                            
                                        </form>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="eraseTextModalContainer();">Close</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="unregvessel();" >Add Vessel</button>
                                      </div>
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <!-- Modal end Edit Vessel -->

                                <!-- Modal Edit Customer -->

                                <div class="modal fade" id="modal_print"  role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Choose Signature</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                            <!-- <form role="form" enctype="multipart/form-data"> -->
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                    <label class="col-form-label">Planning Manager: </label>
                                                    <select  id="planing_manager" class="form-control " data-live-search="true">
                                                            <!-- <option>-----------</option> -->
                                                    </select>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-form-label">Berth Planner: </label>
                                                    <select  id="berth_planner" class="form-control " data-live-search="true">
                                                            <!-- <option>-----------</option> -->
                                                    </select>
                                            </div>
                                        
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="print()">Print</button>
                                            </div>
                                            </form>
                                        </div>
                                        
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modal_note"  role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Note</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-form-label">Note: </label>
                                                <textarea class="form-control" id="note"></textarea>
                                            </div>
                                        
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="btn_add_note" >Tambah</button>
                                            </div>
                                        </div>
                                        
                                        </div>
                                    </div>
                                </div>

                                    <!-- Modal Edit Customer End-->


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('cssjs.script3')
@endsection