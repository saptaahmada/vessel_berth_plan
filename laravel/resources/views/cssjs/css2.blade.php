<style>
    #canvas {
        width: 1004px;
        height: 3300px;
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

        /* Kanan */
        clip-path: polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%); 
        /* kiri */
        /* clip-path: polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%); */
        
        
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
        color: #ffff;
        font-size:14px;
        font-family:arial;
        font-weight:bold;
        padding-left:10px;
        width : 100%;
        text-shadow: 1px 1px #313131;
        z-index: -2;
        
    }
    .text_detail{
        color: black;
        font-size:12px;
        font-family:arial;
        font-weight:bold;
        padding-left:12px;
        /* padding-top:3px; */
        z-index: -2;
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
</style>

