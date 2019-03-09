$(function () {
        $('#date-one').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#date-two').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: false //Important! See issue #1075            
        });
        $("#date-one").on("dp.change", function (e) {
            $('#date-two').data("DateTimePicker").minDate(e.date);
        });
        $("#date-two").on("dp.change", function (e) {
            $('#date-one').data("DateTimePicker").maxDate(e.date);
        });



        $('#date-three').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#date-four').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: false //Important! See issue #1075            
        });
        $("#date-three").on("dp.change", function (e) {
            $('#date-four').data("DateTimePicker").minDate(e.date);
        });
        $("#date-four").on("dp.change", function (e) {
            $('#date-three').data("DateTimePicker").maxDate(e.date);
        });



        $('#date-five').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#date-six').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: false //Important! See issue #1075            
        });
        $("#date-five").on("dp.change", function (e) {
            $('#date-six').data("DateTimePicker").minDate(e.date);
        });
        $("#date-six").on("dp.change", function (e) {
            $('#date-five').data("DateTimePicker").maxDate(e.date);
        });



        $('#date-seven').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#date-eight').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: false //Important! See issue #1075            
        });
        $("#date-seven").on("dp.change", function (e) {
            $('#date-eight').data("DateTimePicker").minDate(e.date);
        });
        $("#date-eight").on("dp.change", function (e) {
            $('#date-seven').data("DateTimePicker").maxDate(e.date);
        });
    });