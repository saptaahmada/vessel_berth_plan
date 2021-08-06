@extends('home.home')

@section('content')
@include('cssjs.css3')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/select2.min.css')}}"/>

<!-- <link rel="stylesheet" type="text/css" href="{{asset('asset/css/bootstrap.min.css')}}"> -->
<!-- <link rel="stylesheet" type="text/css" href="{{asset('asset/css/bootstrap.min.css')}}"> -->



<div id="content">
    <div class="panel">
        <div class="panel-body" >
            <div class="col-md-6 col-sm-12">
            <h3 class="animated fadeInLeft" style="color:#2e80ce;"><b>Vessel Berthing Plan</b></h3>
            <p class="animated fadeInDown"><span class="fa  fa-map-marker"></span> Surabaya,Indonesia</p>

            

            <!-- <ul class="nav navbar-nav">
                <li><a href="" >Impedit</a></li>
                <li><a href="" class="active">Virtute</a></li>
                <li><a href="">Euismod</a></li>
                <li><a href="">Explicar</a></li>
                <li><a href="">Rebum</a></li>
            </ul> -->
            </div>
        </div>                    
    </div>

    <div class="col-md-12 top-20 padding-0">
        <div class="col-md-12">
            <div class="col-md-12 padding-0">
                <div class="panel">
                    <div class="panel-heading">
                        <h5>
                            <!-- Handsontable is an Excel-like data grid / spreadsheet for HTML & JavaScript -->
                        </h5>

                        <button type="button" class="btn ripple-infinite btn-round btn-3d btn-primary"  data-toggle="modal" data-target="#addVessel" style='margin:10px;'>
                        Add Vessel
                        </button>
                        <button type="button" class="btn ripple-infinite btn-round btn-3d btn-info"  data-toggle="modal" data-target="#modal_note" style='margin:10px;'>
                        Add Note
                        </button>
                        <button type="button"  id="saveupdate" class="btn ripple-infinite btn-round btn-3d btn-success" onclick="setTimeout('updatebox()', 1000)" data-toggle="modal" data-target="#" style='margin:10px;'>
                        Save Berthing Plan
                        </button>
                        <button type="button" class="btn ripple-infinite btn-round btn-3d btn-warning"  data-toggle="modal" data-target="#modal_print" style='margin:10px;'>
                        Print Berthing Plan
                        </button>
                        <br>
                        <br>

                        <label for="ocean_interisland">Pilih Dermaga :  </label>
                            <input type="radio" id="cekbox1" class="dermaga" name="dermaga" value="D" checked  > Domestic</input> 
                            <input type="radio"  id="cekbox2" class="dermaga" name="dermaga" value="I"  > International</input>
                            <input type="radio"  id="cekbox3" class="dermaga" name="dermaga" value="C" > Curah Kering</input>
                    </div>
                    <div class="panel-body2">
                        <div class="panel-body">
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
                                        <!-- <div id="results"></div> -->
                                        <!-- <div id="panjang"></div> -->
                                        <div style="position:absolute; left:80px;" id="div_coba">
                                        <!-- <img src = "{{asset('/img/vessel.png')}}" /> -->
                                            @include('content.isi.ruler')
                                         
                                            <div id='canvas'>
                                            <!-- <div id="curah"> <img src="{{asset('/img/cur.png')}}" style="width: 500px; height: 3296px; position:absolute;" > </div> -->
                                                <div id='wrap_sw'>
                                                    <!-- <div id="box" class="box">
                                                        <div id="img">
                                                            <img id="ims" class="ims" src = "{{asset('/img/logo.png')}}"/>
                                                        </div>
                                                        <div id="text_judul" class="text_judul">
                                                            MV. MENTARI PRAKARSA
                                                        </div>
                                                        <div id="text_detail" class="text_detail">
                                                            <div style="margin:1px; color:red;">ETA :24/05/2021 12:00</div>
                                                            <div style="margin:1px;">ETB :24/05/2021 14:00</div>
                                                            <div style="margin:1px;">ETD :25/05/2021 07:00</div>
                                                            <div style="margin:1px; margin-left:2px; color:red; font-style: italic;">MOVES EST:0/273 BOX</div>
                                                            <div style="margin:1px;">LOA : 108 M</div>
                                                            <div style="margin:1px;">POD : TOBELO</div>
                                                        </div>
                                                    </div> -->
                                                </div>
                                                
                                            </div>
                                         
                                        </div>

                                    </div>
                                <!-- end -->
                                <!-- Modal Add Vessel -->
                                <div class="modal fade" id="addVessel" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
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
                                                
                                                <div class="form-group">
                                                    <label class="col-form-label">Vessel Name Vessel 3: </label>
                                                    <select  id="vessel3"  class="select2-A" style="width:100%;"  data-live-search="true">
                                                            <!-- <option>-----------</option> -->
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">ETA : </label>
                                                    <input id="etADry" type="datetime-local" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">RBT </label>
                                                    <input id="rbTDry" type="datetime-local" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">ETB :</label>
                                                    <input id="etBDry" type="datetime-local"  onchange="autofillCon()" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">ETD :</label>
                                                    <input id="etDDry" type="text" class="form-control" disabled>
                                                </div>
                                                

                                                <div class="form-group" >
                                                    <label class="col-form-label text-right">CRANE :</label><br>
                                                    <div id="craneDry">

                                                    </div>
                                                </div>



                                                <div class="form-group">
                                                    <label class="col-form-label">TGH :</label>
                                                    <input id="tghDry" type="text" class="form-control" onkeyup="autofillCon()">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-form-label">NEXT PORT :</label>
                                                    <select  id="nextPDry" class="select2-A" style="width:100%;"  data-live-search="true">
                                                            <!-- <option>-----------</option> -->
                                                    </select>
                                                    
                                                    <!-- <input id="nextPDry" type="text" class="form-control"> -->
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">DEST PORT : </label>
                                                    <select  id="deshPDry" class="select2-A" style="width:100%;"  data-live-search="true">
                                                            <!-- <option>-----------</option> -->
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Jumlah Bongkar : </label>
                                                    <input id="bongkarDry" type="number" class="form-control" onkeyup="autofillCon()">
                                                </div>
                                                <!-- <div class="form-group">
                                                    <label class="col-form-label">Jumlah Muat : </label>
                                                    <input id="muatDry" type="number" class="form-control" onkeyup="autofillCon()">
                                                </div> -->
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

                                                <div class="form-group">
                                                    <label class="col-form-label">Along Side : </label>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <input type="radio" class ="sideDry" name="optionDry" value="S"> Star Board
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="radio" class ="sideDry" name="optionDry" value="P"> Port Side
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Info : </label>
                                                    <textarea style="resize: none;" rows="5" class="form-control" id="infoDry"></textarea>
                                                </div>
                                            </div>

                                            <div id="formCon" >
                                                
                                                <div class="form-group">
                                                    <label class="col-form-label">Vessel Name Vessel 2 : </label>
                                                    <select  id="vessel2" class="select2-A" style="width:100%;">
                                                            <!-- <option>-----------</option> -->
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">ETA : </label>
                                                    <input id="etA" type="datetime-local" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">RBT </label>
                                                    <input id="rbT" type="datetime-local" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">ETB :</label>
                                                    <input id="etB" type="datetime-local"  onchange="autofillCon()" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">ETD :</label>
                                                    <input id="etD" type="text" class="form-control" disabled>
                                                </div>
                                                

                                                <div class="form-group" >
                                                    <label class="col-form-label text-right">CRANE :</label><br>
                                                    <div id="craneCon">

                                                    </div>
                                                </div>



                                                <div class="form-group">
                                                    <label class="col-form-label">BSH :</label>
                                                    <input id="bsh" type="text" class="form-control" onkeyup="autofillCon()">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">NEXT PORT :</label>
                                                    <select  id="nextP"  class="select2-A" style="width:100%;"  data-live-search="true">
                                                            <!-- <option>-----------</option> -->
                                                    </select>
                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">DEST PORT : </label>
                                                    <select  id="deshP"  class="select2-A" style="width:100%;"  data-live-search="true">
                                                            <!-- <option>-----------</option> -->
                                                    </select>
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

                                                <div class="form-group">
                                                    <label class="col-form-label">Along Side : </label>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <input type="radio" class ="side" name="option" value="S"> Star Board
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="radio" class ="side" name="option" value="P"> Port Side
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Info : </label>
                                                    <textarea style="resize: none;" rows="5" class="form-control" id="info"></textarea>
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

                                <!-- Modal Add Vessel -->
                                <div class="modal fade" id="editVessel" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Edit Vessel</h4>
                                      </div>
                                      <div class="modal-body">
                                        <label for="ocean_interisland">Pilih Tipe Kapal :  </label>
                                          <input type="radio" id="con" class="kapal" name="kapal" value="C" checked > Container</input> 
                                          <input type="radio" id="dry" class="kapal" name="kapal" value="D"  > Dry Bulk</input> 
                                        <br>        
                                        <form>
                                            {{csrf_field()}}

                                            <div id="formCon" >
                                                <div class="form-group">
                                                    <label class="col-form-label">Vessel ID: </label>
                                                    <input id="edit_vessel" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Vessel Name: </label>
                                                    <input id="edit_vessel_name" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">ETA : </label>
                                                    <input id="edit_eta" type="datetime-local" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">RBT </label>
                                                    <input id="edit_rbt" type="datetime-local" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">ETB :</label>
                                                    <input id="edit_etb" type="datetime-local"  onchange="autofillCon()" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">ETD :</label>
                                                    <input id="edit_etd" type="text" class="form-control" disabled>
                                                </div>
                                                

                                                <div class="form-group" >
                                                    <label class="col-form-label text-right">CRANE :</label><br>
                                                    <div id="edit_crane">

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label">BSH :</label>
                                                    <input id="edit_bsh" type="text" class="form-control" onkeyup="autofillCon()">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">NEXT PORT :</label>
                                                    <select  id="edit_nextp" class="form-control">
                                                            <!-- <option>-----------</option> -->
                                                    </select>
                                                    
                                                    <!-- <input id="nextPDry" type="text" class="form-control"> -->
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">DEST PORT : </label>
                                                    <select  id="edit_deshp" class="form-control">
                                                            <!-- <option>-----------</option> -->
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Jumlah Bongkar : </label>
                                                    <input id="edit_bongkar" type="number" class="form-control" onkeyup="autofillCon()">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Jumlah Muat : </label>
                                                    <input id="edit_muat" type="number" class="form-control" onkeyup="autofillCon()">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Kade Meter : </label>
                                                    <div class="row">
                                                        <div class= "col-sm-5">
                                                            <input id="edit_start" placeholder="Start" type="number" class="form-control" onkeyup="autofillCon();" required>  
                                                        </div>
                                                        <div class= "col-sm-2" style = "margin-left: auto; margin-right: auto;" >
                                                            TO
                                                        </div>
                                                        <div class= "col-sm-5">
                                                            <input id="edit_end" placeholder="End" type="text" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label">Along Side : </label>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <input type="radio" id="edit_side_s" class ="edit_side" name="edit_option" value="S"> Star Board
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="radio" id="edit_side_p" class ="edit_side" name="edit_option" value="P"> Port Side
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Info : </label>
                                                    <textarea style="resize: none;" rows="5" class="form-control" id="edit_info"></textarea>
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
                                <!-- Modal end Add Vessel -->


                                <!-- Modal Edit Customer -->

                                <div class="modal fade" id="modal_print"  role="dialog">
                                    <div class="modal-dialog" role="document">
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
                                    <div class="modal-dialog" role="document">
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