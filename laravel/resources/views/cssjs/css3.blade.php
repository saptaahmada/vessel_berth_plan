<style>#canvas {


width: 1004px;
/* width: 503px; */

height: 3340px;
background: #95c8d8;
border: 2px solid #ca3433;
position: relative;
/* left: 100px; */
top: 20px;
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
border: 1px solid #ca3433;
position: absolute;
left: 501px;
/* background-size: 10px 20px; */
/* background-image: url("/img/curah.JPG"); */
/* box-sizing: border-box;
   position: fixed; */
/* z-index: 5; */

}


.tanggal {
margin-left: -27px;
/* top:100px; */
position: absolute;
font: 11px sans-serif;
font-weight: bold;
margin-top: -15px;
}

.waktu {
/* position :absolute; */
/* left: 87px; */
font: 11px/1 sans-serif;
height: 60px
}

.divwaktu {
margin-left: 20px;
margin-top: 30px;
}


.box {
/* display:block; */

background-color: #29e;
/* border-radius: 0.75em; */
touch-action: none;
user-select: none;
transform: translate(0px, 0px);
/* box-sizing: border-box; */
/* overflow: auto; */
position: absolute !important;
/* box-shadow: 4px 4px 5px  #313131; */
border: 0.01px solid black;
/* box-sizing: border-box; */


/* Kanan */
clip-path: polygon(100% 50%, 85% 0, 5% 0, 0 5%, 0 95%, 5% 100%, 85% 100%);
/* kiri */
/* clip-path: polygon(100% 95%, 100% 5%, 95% 0, 15% 0, 0 50%, 15% 100%, 95% 100%); */


}


.box_note {
/* display:block; */

background-color: #29e;
/* border-radius: 0.75em; */
touch-action: none;
user-select: none;
transform: translate(0px, 0px);
position: absolute !important;

}

#wrap_sw {
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

.text_judul {
color: #000;
font-size: 12px;
font-family: sans-serif;
font-weight: bold;
padding-left: 20px;
padding-top: 2px;
width: 100%;
margin-left: 10px;
/* text-shadow: 1px 1px #313131; */
z-index: -2;

}

.text_detail {
color: black;
font-size: 10px;
font-family: sans-serif;
font-weight: bold;
padding-left: 20px;
width: 100%;
/* padding-top:3px; */
z-index: -2;

}

/* #text_detail{
    padding-left:12px;
}
#text_judul{
    padding-left:10px;
} */

#img {
/* float:right; */
position: absolute;
}

.ims {
float: right;
width: 18%;
height: 18%;
padding-top: 8px;

/* position: absolute; */
}

circle span {
position: absolute;
color: #fff;
font-size: 9px;
top: 50%;
transform: translate(-50%, -50%);
width: 100%;
}

circle {
/* float:right; */
background: #000;
width: 60px;
height: 20px;
/* border-radius: 50%; */
display: inline-block;
text-align: center;
/* margin-top: 10%; */
margin-right: 5px;

position: relative;
z-index: -1;
}

circle2 span {
position: absolute;
color: #fff;
font-size: 8px;
top: 50%;
transform: translate(-50%, -50%);
width: 100%;
}

circle2 {
/* float:right; */
background: #000;
width: 20px;
height: 20px;
border-radius: 50%;
display: inline-block;
text-align: center;
/* margin-top: 10%; */
margin-right: 5px;

position: relative;
z-index: -1;
}


#results {
text-align: center;
/* position: absolute; */
}

#panjang {
text-align: center;
}

#resizable {
width: 150px;
height: 150px;
padding: 0.5em;
text-align: center;
margin: 0;
}

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
left: 10%;
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

.ruler .cm:nth-of-type(12) {
left: 110%;
}

.ruler .cm:nth-of-type(12):after {
content: "550m";
}

.ruler .cm:nth-of-type(13) {
left: 120%;
}

.ruler .cm:nth-of-type(13):after {
content: "600m";
}

.ruler .cm:nth-of-type(14) {
left: 130%;
}

.ruler .cm:nth-of-type(14):after {
content: "650m";
}

.ruler .cm:nth-of-type(15) {
left: 140%;
}

.ruler .cm:nth-of-type(15):after {
content: "700m";
}

.ruler .cm:nth-of-type(16) {
left: 150%;
}

.ruler .cm:nth-of-type(16):after {
content: "750m";
}

.ruler .cm:nth-of-type(17) {
left: 160%;
}

.ruler .cm:nth-of-type(17):after {
content: "800m";
}

.ruler .cm:nth-of-type(18) {
left: 170%;
}

.ruler .cm:nth-of-type(18):after {
content: "850m";
}

.ruler .cm:nth-of-type(19) {
left: 180%;
}

.ruler .cm:nth-of-type(19):after {
content: "900m";
}

.ruler .cm:nth-of-type(20) {
left: 190%;
}

.ruler .cm:nth-of-type(20):after {
content: "950m";
}

.ruler .cm:nth-of-type(21) {
left: 200%;
}

.ruler .cm:nth-of-type(21):after {
content: "1000m";
}

.ruler .cm:nth-of-type(22) {
left: 210%;
}

.ruler .cm:nth-of-type(22):after {
content: "1050m";
}

.ruler .cm:nth-of-type(23) {
left: 220%;
}

.ruler .cm:nth-of-type(23):after {
content: "1100m";
}

.ruler .cm:nth-of-type(24) {
left: 230%;
}

.ruler .cm:nth-of-type(24):after {
content: "1150m";
}

.ruler .cm:nth-of-type(25) {
left: 240%;
}

.ruler .cm:nth-of-type(25):after {
content: "1200m";
}

.ruler .cm:nth-of-type(26) {
left: 250%;
}

.ruler .cm:nth-of-type(26):after {
content: "1250m";
}

.ruler .cm:nth-of-type(27) {
left: 260%;
}

.ruler .cm:nth-of-type(27):after {
content: "1300m";
}

.ruler .cm:nth-of-type(28) {
left: 270%;
}

.ruler .cm:nth-of-type(28):after {
content: "1350m";
}

.ruler .cm:nth-of-type(29) {
left: 280%;
}

.ruler .cm:nth-of-type(29):after {
content: "1400m";
}

.ruler .cm:nth-of-type(30) {
left: 290%;
}

.ruler .cm:nth-of-type(30):after {
content: "1450m";
}

.ruler .cm:nth-of-type(31) {
left: 300%;
}

.ruler .cm:nth-of-type(31):after {
content: "1500m";
}

.ruler .cm:nth-of-type(32) {
left: 310%;
}

.ruler .cm:nth-of-type(32):after {
content: "1550m";
}

.ruler .cm:nth-of-type(33) {
left: 320%;
}

.ruler .cm:nth-of-type(33):after {
content: "1600m";
}

.ruler .cm:nth-of-type(34) {
left: 330%;
}

.ruler .cm:nth-of-type(34):after {
content: "1650m";
}

.ruler .cm:nth-of-type(35) {
left: 340%;
}

.ruler .cm:nth-of-type(35):after {
content: "1700m";
}

.ruler .cm:nth-of-type(36) {
left: 350%;
}

.ruler .cm:nth-of-type(36):after {
content: "1750m";
}

.ruler .cm:nth-of-type(37) {
left: 360%;
}

.ruler .cm:nth-of-type(37):after {
content: "1800m";
}

.ruler .cm:nth-of-type(38) {
left: 370%;
}

.ruler .cm:nth-of-type(38):after {
content: "1850m";
}

.ruler .cm:nth-of-type(39) {
left: 380%;
}

.ruler .cm:nth-of-type(39):after {
content: "1900m";
}

.ruler .cm:nth-of-type(40) {
left: 390%;
}

.ruler .cm:nth-of-type(40):after {
content: "1950m";
}

.ruler .cm:nth-of-type(41) {
left: 400%;
}

.ruler .cm:nth-of-type(41):after {
content: "2000m";
}

.ruler .cm:nth-of-type(42) {
left: 410%;
}

.ruler .cm:nth-of-type(42):after {
content: "2050m";
}

.ruler .cm:nth-of-type(43) {
left: 420%;
}

.ruler .cm:nth-of-type(43):after {
content: "2100m";
}

.ruler .cm:nth-of-type(44) {
left: 430%;
}

.ruler .cm:nth-of-type(44):after {
content: "2150m";
}

.ruler .cm:nth-of-type(45) {
left: 440%;
}

.ruler .cm:nth-of-type(45):after {
content: "2200m";
}

.ruler .cm:nth-of-type(46) {
left: 450%;
}

.ruler .cm:nth-of-type(46):after {
content: "2250m";
}

.ruler .cm:nth-of-type(47) {
left: 460%;
}

.ruler .cm:nth-of-type(47):after {
content: "2300m";
}

.ruler .cm:nth-of-type(48) {
left: 470%;
}

.ruler .cm:nth-of-type(48):after {
content: "2350m";
}

.ruler .cm:nth-of-type(49) {
left: 480%;
}

.ruler .cm:nth-of-type(49):after {
content: "2400m";
}

.ruler .cm:nth-of-type(50) {
left: 490%;
}

.ruler .cm:nth-of-type(50):after {
content: "2450m";
}

.ruler .cm:nth-of-type(51) {
left: 500%;
}

.ruler .cm:nth-of-type(51):after {
content: "2500m";
}

.ruler .cm:nth-of-type(52) {
left: 510%;
}

.ruler .cm:nth-of-type(52):after {
content: "2550m";
}

.ruler .cm:nth-of-type(53) {
left: 520%;
}

.ruler .cm:nth-of-type(53):after {
content: "2600m";
}

.ruler .cm:nth-of-type(54) {
left: 530%;
}

.ruler .cm:nth-of-type(54):after {
content: "2650m";
}

.ruler .cm:nth-of-type(55) {
left: 540%;
}

.ruler .cm:nth-of-type(5):after {
content: "2700m";
}

.ruler .cm:nth-of-type(56) {
left: 550%;
}

.ruler .cm:nth-of-type(56):after {
content: "2750m";
}

.ruler .cm:nth-of-type(57) {
left: 560%;
}

.ruler .cm:nth-of-type(57):after {
content: "2800m";
}

.ruler .cm:nth-of-type(58) {
left: 570%;
}

.ruler .cm:nth-of-type(58):after {
content: "2850m";
}

.ruler .cm:nth-of-type(59) {
left: 580%;
}

.ruler .cm:nth-of-type(59):after {
content: "2900m";
}

.ruler .cm:nth-of-type(60) {
left: 590%;
}

.ruler .cm:nth-of-type(60):after {
content: "2950m";
}

.ruler .cm:nth-of-type(61) {
left: 600%;
}

.ruler .cm:nth-of-type(61):after {
content: "3000m";
}

.ruler .cm:nth-of-type(62) {
left: 610%;
}

.ruler .cm:nth-of-type(62):after {
content: "3050m";
}

.ruler .cm:nth-of-type(63) {
left: 620%;
}

.ruler .cm:nth-of-type(63):after {
content: "3150m";
}

.ruler .cm:nth-of-type(64) {
left: 630%;
}

.ruler .cm:nth-of-type(64):after {
content: "3200m";
}

.ruler .cm:nth-of-type(65) {
left: 640%;
}

.ruler .cm:nth-of-type(65):after {
content: "3250m";
}

.ruler .cm:nth-of-type(66) {
left: 650%;
}

.ruler .cm:nth-of-type(66):after {
content: "3300m";
}

.ruler .cm:nth-of-type(67) {
left: 660%;
}

.ruler .cm:nth-of-type(67):after {
content: "3350m";
}

.ruler .cm:nth-of-type(68) {
left: 670%;
}

.ruler .cm:nth-of-type(68):after {
content: "3400m";
}

.ruler .cm:nth-of-type(69) {
left: 680%;
}

.ruler .cm:nth-of-type(69):after {
content: "3450m";
}

.ruler .cm:nth-of-type(70) {
left: 690%;
}

.ruler .cm:nth-of-type(70):after {
content: "3500m";
}

.ruler .cm:nth-of-type(71) {
left: 700%;
}

.ruler .cm:nth-of-type(71):after {
content: "3550m";
}

.ruler .cm:nth-of-type(72) {
left: 710%;
}

.ruler .cm:nth-of-type(72):after {
content: "3600m";
}

.ruler .cm:nth-of-type(73) {
left: 720%;
}

.ruler .cm:nth-of-type(73):after {
content: "3650m";
}

.ruler .cm:nth-of-type(74) {
left: 730%;
}

.ruler .cm:nth-of-type(74):after {
content: "3700m";
}

.ruler .cm:nth-of-type(75) {
left: 740%;
}

.ruler .cm:nth-of-type(75):after {
content: "3750m";
}

.ruler .cm:nth-of-type(76) {
left: 750%;
}

.ruler .cm:nth-of-type(76):after {
content: "3800m";
}

.ruler .cm:nth-of-type(77) {
left: 760%;
}

.ruler .cm:nth-of-type(77):after {
content: "3850m";
}

.ruler .cm:nth-of-type(78) {
left: 770%;
}

.ruler .cm:nth-of-type(78):after {
content: "3900m";
}

.ruler .cm:nth-of-type(79) {
left: 780%;
}

.ruler .cm:nth-of-type(79):after {
content: "3950m";
}

.ruler .cm:nth-of-type(80) {
left: 790%;
}

.ruler .cm:nth-of-type(80):after {
content: "4000m";
}

.ruler .cm:nth-of-type(81) {
left: 800%;
}

.ruler .cm:nth-of-type(81):after {
content: "4050m";
}

.ruler .cm:nth-of-type(82) {
left: 810%;
}

.ruler .cm:nth-of-type(82):after {
content: "4100m";
}

.ruler .cm:nth-of-type(83) {
left: 820%;
}

.ruler .cm:nth-of-type(83):after {
content: "4150m";
}

.ruler .cm:nth-of-type(84) {
left: 830%;
}

.ruler .cm:nth-of-type(84):after {
content: "4200m";
}

.ruler .cm:nth-of-type(85) {
left: 840%;
}

.ruler .cm:nth-of-type(85):after {
content: "4250m";
}

.ruler .cm:nth-of-type(86) {
left: 850%;
}

.ruler .cm:nth-of-type(86):after {
content: "4300m";
}

.ruler .cm:nth-of-type(87) {
left: 860%;
}

.ruler .cm:nth-of-type(87):after {
content: "4350m";
}

.ruler .cm:nth-of-type(88) {
left: 870%;
}

.ruler .cm:nth-of-type(88):after {
content: "4400m";
}

.ruler .cm:nth-of-type(89) {
left: 880%;
}

.ruler .cm:nth-of-type(89):after {
content: "4450m";
}

.ruler .cm:nth-of-type(90) {
left: 890%;
}

.ruler .cm:nth-of-type(90):after {
content: "4500m";
}

.ruler .cm:nth-of-type(91) {
left: 900%;
}

.ruler .cm:nth-of-type(91):after {
content: "4550m";
}

.ruler .cm:nth-of-type(92) {
left: 910%;
}

.ruler .cm:nth-of-type(92):after {
content: "4600m";
}

.ruler .cm:nth-of-type(93) {
left: 920%;
}

.ruler .cm:nth-of-type(93):after {
content: "4650m";
}

.ruler .cm:nth-of-type(94) {
left: 930%;
}

.ruler .cm:nth-of-type(94):after {
content: "4700m";
}

.ruler .cm:nth-of-type(95) {
left: 940%;
}

.ruler .cm:nth-of-type(95):after {
content: "4750m";
}

.ruler .cm:nth-of-type(96) {
left: 950%;
}

.ruler .cm:nth-of-type(96):after {
content: "4800m";
}

.ruler .cm:nth-of-type(97) {
left: 960%;
}

.ruler .cm:nth-of-type(97):after {
content: "4850m";
}

.ruler .cm:nth-of-type(98) {
left: 970%;
}

.ruler .cm:nth-of-type(98):after {
content: "4900m";
}

.ruler .cm:nth-of-type(99) {
left: 980%;
}

.ruler .cm:nth-of-type(99):after {
content: "4950m";
}

.ruler .cm:nth-of-type(100) {
left: 990%;
}

.ruler .cm:nth-of-type(100):after {
content: "5000m";
}

.ruler .cm:nth-of-type(101) {
left: 1000%;
}

.ruler .cm:nth-of-type(101):after {
content: "4050m";
}

.ruler .cm:nth-of-type(102) {
left: 1010%;
}

.ruler .cm:nth-of-type(102):after {
content: "4100m";
}

.ruler .cm:nth-of-type(103) {
left: 1020%;
}

.ruler .cm:nth-of-type(103):after {
content: "4150m";
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
#mentionme {
text-align: center;
margin-top: 10%;
}

#scroll {
overflow: scroll;
left: 90px;

}

/* #bongkar,#muat{
width: 20em;
} */
.col-form-label {
font-weight: bold;
color: black;
}

#Rdomes {
display: block;
}

#Rintern {
display: none;
}

#Rcur {
display: none;
}

</style>
