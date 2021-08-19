<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<!-- start dragable n resizing -->

<script src="{{asset('js/jquery.blockUI.js')}}"></script>
<script src="{{asset('date-picker/dist/mc-calendar.min.js')}}"></script>




<script>
    $(document).ready(function () {
        const myDatePicker = MCDatepicker.create({ 
            el: '#example',
            dateFormat: 'DD-MMM-YYYY',
        })
    });

function kade(param) {
    $.ajax({  
        url : "{{route('getkade')}}",
        type : "get",
        dataType : "json",
        async : false,
        success : function(result){
            var kad = result.all;
            var dom =  result.dom;
            var int =  result.int;
            var cur =  result.cur;
            var kade_meter = 0;
            var can =0;

            if (param == "D"){
                $("#Rdomes").empty();
                kade_meter = dom[0].param4;
                var d = kade_meter / 50;

                can = kade_meter * 2.008;
                $("#canvas").css("width", can+"px");

                for (f=0; f<d;f++){
                    $("#Rdomes").append(
                        '<div class="cm">'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                        '</div>');
                }
                $("#Rdomes").append(
                    '<div class="cm"></div>');

            } else if (param == "I") {
                $("#Rintern").empty();
                kade_meter = int[0].param4;
                var n = kade_meter / 50;
                can = kade_meter * 2.008;
                $("#canvas").css("width", can+"px");

                for (t=0; t<n;t++){
                    $("#Rintern").append(
                        '<div class="cm">'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                        '</div>');
                }
                $("#Rintern").append(
                    '<div class="cm"></div>');
                    
            } else if (param == "C"){
                $("#Rcur").empty();
                kade_meter = cur[0].param4;
                var c = kade_meter / 50;
                can = kade_meter * 2.008;
                $("#canvas").css("width", can+"px");

                for (y=0; y<c;y++){
                    $("#Rcur").append(
                        '<div class="cm">'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                            '<div class="mm"></div>'+
                        '</div>');
                }
                $("#Rcur").append(
                    '<div class="cm"></div>');
            }
        }
    });
}
</script>






