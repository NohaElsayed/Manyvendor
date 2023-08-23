
<script src="{{asset('backend/plugins/jquery/jquery.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-ui/jquery-ui.js')}}"></script>

<script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.js')}}"></script>
<script src="{{asset('backend/dist/js/demo.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('backend/plugins/raphael/raphael.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-mapael/jquery.mapael.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-mapael/maps/usa_states.js')}}"></script>
<script src="{{asset('backend/plugins/chart.js/Chart.js')}}"></script>
<script src="{{asset('backend/dist/js/pages/dashboard2.js')}}"></script>
<script src="{{asset('backend/plugins/sparklines/sparkline.js')}}"></script>
<script src="{{asset('backend/plugins/jqvmap/jquery.vmap.js')}}"></script>
<script src="{{asset('backend/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<script src="{{asset('backend/plugins/jquery-knob/jquery.knob.js')}}"></script>
<script src="{{asset('backend/plugins/moment/moment.js')}}"></script>
<script src="{{asset('backend/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.js')}}"></script>
<script src="{{asset('backend/plugins/ekko-lightbox/ekko-lightbox.js')}}"></script>
<script src="{{asset('backend/plugins/filterizr/jquery.filterizr.js')}}"></script>
<script src="{{asset('backend/plugins/moment/moment.js')}}"></script>
<script src="{{asset('backend/plugins/fullcalendar/main.js')}}"></script>
<script src="{{asset('backend/plugins/fullcalendar-daygrid/main.js')}}"></script>
<script src="{{asset('backend/plugins/fullcalendar-timegrid/main.js')}}"></script>
<script src="{{asset('backend/plugins/fullcalendar-interaction/main.js')}}"></script>
<script src="{{asset('backend/plugins/fullcalendar-bootstrap/main.js')}}"></script>
<script src="{{asset('backend/plugins/ion-rangeslider/js/ion.rangeSlider.js')}}"></script>
<script src="{{asset('backend/plugins/bootstrap-slider/bootstrap-slider.js')}}"></script>
<script src="{{asset('backend/plugins/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('backend/plugins/toastr/toastr.js')}}"></script>
<script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('backend/plugins/jsgrid/demos/db.js')}}"></script>
<script src="{{asset('backend/plugins/jsgrid/jsgrid.js')}}"></script>
<script src="{{asset('backend/plugins/summernote/summernote-bs4.js')}}"></script>

<script src="{{asset('backend/plugins/bs-custom-file-input/bs-custom-file-input.js')}}"></script>
<script src="{{asset('backend/plugins/select2/js/select2.full.js')}}"></script>
<script src="{{asset('backend/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.js')}}"></script>
<script src="{{asset('backend/plugins/moment/moment.js')}}"></script>
<script src="{{asset('backend/plugins/inputmask/min/jquery.inputmask.bundle.js')}}"></script>
<script src="{{asset('backend/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script src="{{asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js')}}"></script>
<script src="{{asset('backend/plugins/bootstrap-switch/js/bootstrap-switch.js')}}"></script>
<script src="{{asset('backend/plugins/dropzone/dropzone.js')}}"></script>
<script src="{{asset('backend/dist/js/bootstrap-tagsinput.js')}}"></script>
<script src="{{asset('backend/dist/js/adminlte.js')}}"></script>
<script src="{{asset('backend/dist/js/demo.js')}}"></script>
<script src="{{asset('backend/custom/js/notify.js')}}"></script>
<script src="{{asset('js/dropify.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>
<script>
    $(document).ready(function () {
        'use strict'
        //primary color
        $('.my-colorpicker2').colorpicker();

        $('.my-colorpicker2').on('colorpickerChange', function (event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        });

        //primary color
        $('.my-colorpicker3').colorpicker()

        $('.my-colorpicker3').on('colorpickerChange', function (event) {
            $('.my-colorpicker3 .fa-square').css('color', event.color.toString());
        });

        // dropify

        $('.dropify').dropify();
        
        // dropify:END

    });

    
</script>
