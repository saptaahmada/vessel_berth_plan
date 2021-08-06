<style>
    #canvas {
       

        width: 1004px;
        /* width: 503px; */

        height: 3340px;
        background: #95c8d8;   
        border:2px solid #ca3433;
        position: relative;
        /* left: 100px; */
        top:20px;
        /* bottom: 20px; */
        /* padding: 10px; */
        /* margin: 1em auto; */
        /* overflow: scroll; */
        background-size: 10px 20px;
        background-image:
        linear-gradient(to right, grey 1px, transparent 1px),
        linear-gradient(to bottom, grey 1px, transparent 1px);
        /* box-sizing: border-box;
        position: fixed; */
        
    }
    #curah {
       

       width: 500px;
       height: 3296px;
       border:1px solid #ca3433;
       position: absolute;
       left:501px;
       /* background-size: 10px 20px; */
       /* background-image: url("/img/curah.JPG"); */
       /* box-sizing: border-box;
       position: fixed; */
       /* z-index: 5; */
       
   }


    .tanggal{   
        margin-left: -27px;
        /* top:100px; */position :absolute;
        font: 11px sans-serif;
        font-weight: bold;
        margin-top:-15px;
    }
    .waktu{
        /* position :absolute; */
        /* left: 87px; */
        font: 11px/1 sans-serif;
        height: 60px
    }

    .divwaktu
    {
        margin-left:20px;
        margin-top:30px;
    }


    .box {
        /* display:block; */
      
        background-color:#29e;
        /* border-radius: 0.75em; */
        touch-action: none;
        user-select: none;
        transform: translate(0px, 0px);
        /* box-sizing: border-box; */
        /* overflow: auto; */
        position: absolute !important;
        /* box-shadow: 4px 4px 5px  #313131; */
        border:0.01px solid black;
        /* box-sizing: border-box; */
        

        /* Kanan */
        clip-path: polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%); 
        /* kiri */
        /* clip-path: polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%); */
        
        
    }
    #wrap_sw{
    filter: drop-shadow(4px 4px 5px #313131);
        
    }

    .widget-inner {
	position: absolute;
	top: 5px;
	right: -9px;
	bottom: 5px;
	left: -9px;
	background: transparent;

	/* background: #ffff; */

	border-radius: 2px;
    
}

    .text_judul{
        color: #000;
        font-size:14px;
        font-family:sans-serif;
        font-weight:bold;
        padding-left: 20px;
        padding-top: 2px;
        width : 100%;
        /* text-shadow: 1px 1px #313131; */
        z-index: -2;
        
    }
    .text_detail{
        color: black;
    font-size:12px;
    font-family:sans-serif;
    font-weight:bold;
    padding-left:20px;
    width : 100%;
    /* padding-top:3px; */
    z-index: -2;

    }
    /* #text_detail{
        padding-left:12px;
    }
    #text_judul{
        padding-left:10px;
    } */

    #img{
        /* float:right; */
        position: absolute;
    }   
    .ims{
    float:right;
    width: 18%;
    height: 18%;
    padding-top: 8px;

/* position: absolute; */
}
circle span {
  position: absolute;
  color:#fff;
  font-size:12px;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
}
circle {
    /* float:right; */
  background: #000;
  width: 70px;
  height: 20px;
  /* border-radius: 50%; */
  display: inline-block;
  text-align: center;
  /* margin-top: 10%; */
  margin-right: 5px;
  
  position: relative;
  z-index:-1;
}

circle2 span {
position: absolute;
  color:#fff;
  font-size:12px;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
}
circle2 {
   /* float:right; */
   background: #000;
  width: 23px;
  height: 23px;
  border-radius: 50%;
  display: inline-block;
  text-align: center;
  /* margin-top: 10%; */
  margin-right: 5px;
  
  position: relative;
  z-index:-1;
}


    #results {
        text-align: center;
        /* position: absolute; */
    }
    #panjang {
        text-align: center;
    }
    #resizable { width: 150px; height: 150px; padding: 0.5em;
                text-align: center; margin: 0; }

/*  Start Ruler CSS */
    .ruler {
    position: relative;
    width: 1002px;
    /* bottom: 20px; */
    /* left: 100px; */
    /* margin: 10px auto; */
    height: 14px;
    }
    .ruler .cm,
    .ruler .mm {
    position: absolute;
    border-left: 1px solid #555;
    height: 14px;
    width: 10%;
    }
    .ruler .cm:after {
    position: absolute;
    bottom: -15px;
    font: 11px/1 sans-serif;
    font-weight: bold;
    }
    .ruler .mm {
    height: 5px;
    }
    .ruler .mm:nth-of-type(5) {
    height: 10px;
    }
    .ruler .cm:nth-of-type(1) {
    left: 0%;
    }
    .ruler .cm:nth-of-type(1):after {
    content: "0m";
    }
    .ruler .cm:nth-of-type(2) {
    left: 100px;
    }
    .ruler .cm:nth-of-type(2):after {
    content: "50m";
    }
    .ruler .cm:nth-of-type(3) {
    left: 20%;
    }
    .ruler .cm:nth-of-type(3):after {
    content: "100m";
    }
    .ruler .cm:nth-of-type(4) {
    left: 30%;
    }
    .ruler .cm:nth-of-type(4):after {
    content: "150m";
    }
    .ruler .cm:nth-of-type(5) {
    left: 40%;
    }
    .ruler .cm:nth-of-type(5):after {
    content: "200m";
    }
    .ruler .cm:nth-of-type(6) {
    left: 50%;
    }
    .ruler .cm:nth-of-type(6):after {
    content: "250m";
    }
    .ruler .cm:nth-of-type(7) {
    left: 60%;
    }
    .ruler .cm:nth-of-type(7):after {
    content: "300m";
    }
    .ruler .cm:nth-of-type(8) {
    left: 70%;
    }
    .ruler .cm:nth-of-type(8):after {
    content: "350m";
    }
    .ruler .cm:nth-of-type(9) {
    left: 80%;
    }
    .ruler .cm:nth-of-type(9):after {
    content: "400m";
    }
    .ruler .cm:nth-of-type(10) {
    left: 90%;
    }
    .ruler .cm:nth-of-type(10):after {
    content: "450m";
    }
    .ruler .cm:nth-of-type(11) {
    left: 100%;
    }
    .ruler .cm:nth-of-type(11):after {
    content: "500m";
    }
    .ruler .mm:nth-of-type(1) {
    left: 10%;
    }
    .ruler .mm:nth-of-type(2) {
    left: 20%;
    }
    .ruler .mm:nth-of-type(3) {
    left: 30%;
    }
    .ruler .mm:nth-of-type(4) {
    left: 40%;
    }
    .ruler .mm:nth-of-type(5) {
    left: 50%;
    }
    .ruler .mm:nth-of-type(6) {
    left: 60%;
    }
    .ruler .mm:nth-of-type(7) {
    left: 70%;
    }
    .ruler .mm:nth-of-type(8) {
    left: 80%;
    }
    .ruler .mm:nth-of-type(9) {
    left: 90%;
    }
    .ruler .mm:nth-of-type(10) {
    left: 100%;
    }
/* end ruller */
    #mentionme{  
    text-align:center;
    margin-top:10%;
    }
    #scroll{
        overflow: scroll;
        left : 90px;
        
    }
 /* #bongkar,#muat{
    width: 20em;
 } */
 .col-form-label{
    font-weight: bold;
    color :black;
 }
#rul1{
    display:block;
}
#rul2{
    display:none;
}

</style>

