<?php echo js("highcharts/highcharts.js"); ?>
<?php echo js("highcharts/modules/data.js"); ?>
<?php echo js("highcharts/modules/drilldown.js"); ?>

<?php echo $msg; ?>


<?php $tipo_admin_config = $this->config->item('rol_admin'); //Identificador de administrador ?>

<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><label>Docentes registrados: </label> <?php echo $datos['total']; ?></div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"></div>
</div>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>



<script type="text/javascript">

$(function () {
    // Create the chart
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Docentes participantes en bono divididos por delegación, 2016'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total docentes'
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    //format: '{point.y:.1f}%'
                    format: '{point.y}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            //pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> del total<br/>'
        },

        series: [{
            name: 'Delegación',
            colorByPoint: true,
            data: [ <?php echo $datos['javascript']; ?> /*{
                name: 'Microsoft Internet Explorer',
                y: 56.33,
                drilldown: 'Microsoft Internet Explorer'
            },*/]
        }],
    });
});
</script>
