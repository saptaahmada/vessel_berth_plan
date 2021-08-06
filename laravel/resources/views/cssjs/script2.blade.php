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
</script>






