@extends('home.home')

@section('content')
@include('cssjs.css2')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/select2.min.css')}}"/>

<!-- <link rel="stylesheet" type="text/css" href="{{asset('asset/css/bootstrap.min.css')}}"> -->
<!-- <link rel="stylesheet" type="text/css" href="{{asset('asset/css/bootstrap.min.css')}}"> -->



<div id="content">
    <div class="panel">
        <div class="panel-body" >
            <div class="col-md-6 col-sm-12">
            <h3 class="animated fadeInLeft">Vessel Berthing Plan</h3>
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
                        <button type="button" class="btn ripple-infinite btn-round btn-3d btn-success" onclick="updatebox()"  data-toggle="modal" data-target="#" style='margin:10px;'>
                        Save Berthing Plan
                        </button>
                        <button type="button" class="btn ripple-infinite btn-round btn-3d btn-warning" onclick="print()" data-toggle="modal" data-target="#" style='margin:10px;'>
                        Print Berthing Plan
                        </button>
                        <br>
                        <br>

                        <label for="ocean_interisland">Pilih Dermaga :  </label>
                            <input type="radio" id="cekbox1" class="dermaga" name="dermaga" value="D" checked onchange="loadAll('D')"> Domestic</input> 
                            <input type="radio"  id="cekbox2" class="dermaga" name="dermaga" value="I"  onchange="loadAll('I')"> International</input>
                            <input type="radio"  id="cekbox2" class="dermaga" name="dermaga" value="I"  onchange="loadAll('I')"> Curah Kering</input>
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
                                            @include('content.isi.ruler2')
                                        
                                            <div id='canvas'>
                                                
                                            </div>
                                        </div>

                                    </div>
                                <!-- end -->
                                <!-- Modal Add Vessel -->
                                <div class="modal fade" id="addVessel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Add Vessel</h4>
                                      </div>
                                      <div class="modal-body">
                                        <label for="ocean_interisland">Pilih Tipe Kapal :  </label>
                                          <input type="radio" id="box" class="kapal" name="kapal" value="C" checked onchange="form('C')"> Container</input> 
                                          <input type="radio" id="box" class="kapal" name="kapal" value="D"  onchange="form('D')"> Dry Bulk</input> 
                                        <br>        
                                        <form>
                                            {{csrf_field()}}
                                            <div id="form">
                                                
                                                <div class="form-group">
                                                    <label class="col-form-label">Vessel Name : </label>
                                                    <select  id="vessel2" class="form-control "  data-live-search="true">
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
                                                    <input id="etB" type="datetime-local" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">ETD :</label>
                                                    <input id="etD" type="datetime-local" class="form-control">
                                                </div>
                                                

                                                <div class="form-group">
                                                    <label class="col-form-label text-right">CRANE :</label><br>
                                                    <input type="checkbox" name="crane" id="checkbox-1" value="STS 1D" class="crane" />
                                                    <label for="checkbox-1">STS 1D</label>
                                                    <input type="checkbox" name="crane" id="checkbox-2" value="STS 2D" class="crane" />
                                                    <label for="checkbox-2">STS 2D</label>
                                                    <input type="checkbox" name="crane" id="checkbox-3" value="STS 4D" class="crane" />
                                                    <label for="checkbox-3">STS 4D</label>
                                                    <input type="checkbox" name="crane" id="checkbox-4" value="STS 5D" class="crane" />
                                                    <label for="checkbox-4">STS 5D</label>
                                                </div>



                                                <div class="form-group">
                                                    <label class="col-form-label">BSH :</label>
                                                    <input id="bsh" type="text" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">NEXT PORT :</label>
                                                    <input id="nextP" type="text" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">DEST PORT : </label>
                                                    <input id="deshP" type="text" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Jumlah Bongkar : </label>
                                                    <input id="bongkar" type="number" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Jumlah Muat : </label>
                                                    <input id="muat" type="number" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Kade Meter : </label>
                                                    <div class="row">
                                                        <div class= "col-sm-5">
                                                            <input id="start" placeholder="Start" type="number" class="form-control">  
                                                        </div>
                                                        <div class= "col-sm-2" style = "margin-left: auto; margin-right: auto;">
                                                            TO
                                                        </div>
                                                        <div class= "col-sm-5">
                                                            <input id="end" placeholder="End" type="number" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label">Along Side : </label>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <input type="radio" name="option"> Star Board
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="radio" name="option"> Port Side
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Info : </label>
                                                    <textarea style="resize: none;" rows="5" class="form-control" name="info"></textarea>
                                                    <!-- <input type="textarea" class="form-control" name="info"> -->
                                                </div>

                                            </div>
                                        </form>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addvessel();" >Add Vessel</button>
                                      </div>
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->



                                <!-- Modal end Add Vessel -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('cssjs.script2')
@endsection