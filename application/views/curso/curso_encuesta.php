<?php
echo form_open('cursoencuesta/curso_encuesta/' . $curso, array('id' => 'form_curso'));
//pr($modulos_acceso);
?>

<div class="panel-heading clearfix breadcrumbs6">
    <h1><?php echo $datos_curso['data'][0]['cur_clave'] . '-' . $datos_curso['data'][0]['cur_nom_completo']; ?></h1><br>
    <h2 class="panel-title" style="padding-left:20px;">Listado de encuestas por curso</h2>
    <a href="<?php echo site_url('curso/info_curso/' . $curso); ?>" class="btn btn-info pull-right"> <span class="glyphicon glyphicon-level-up"></span> Regresar a detalle curso</a>
</div>

<!--<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-4 col-sm-4">
            <div class="panel-body input-group input-group-sm">
                <label for="delegacionn">Nombre de encuesta</label>
<?php //echo $this->form_complete->create_element(array('id' => 'anio', 'type' => 'dropdown', 'options' => $anios, 'first' => array('' => 'Seleccione un año'), 'attributes' => array('name' => 'delegacion', 'class' => 'form-control', 'placeholder' => 'Año que impartio curso', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Año en que se impartio curso', 'onchange' => "data_ajax(site_url+'/curso/get_data_ajax/'+".$curso.", '#form_curso', '#listado_resultado')"))); ?>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4"></div>
    </div>
</div>-->
<div class="row">
    <div class="col-lg-4 col-sm-4">
        <div class="panel-body input-group input-group-sm">
            <span class="input-group-addon">Número de registros a mostrar:</span>
            <?php // echo $this->form_complete->create_element(array('id'=>'per_page', 'type'=>'dropdown', 'options'=>array(2=>2,3=>3,4=>4,10=>10, 20=>20, 50=>50, 100=>100), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Número de registros a mostrar', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Número de registros a mostrar', 'onchange'=>"data_ajax(site_url+'/bonos_titular/get_data_ajax', '#form_buscador', '#listado_resultado_empleado')"))); ?>
            <?php echo $this->form_complete->create_element(array('id' => 'per_page', 'type' => 'dropdown', 'options' => array(5 => 5, 10 => 10, 20 => 20, 50 => 50, 100 => 100), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Número de registros a mostrar', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Número de registros a mostrar', 'onchange' => "data_ajax(site_url+'/cursoencuesta/get_data_ajax/'+" . $curso . ", '#form_curso', '#listado_resultado')"))); ?>
        </div>
    </div>
    <div class="col-lg-4 col-sm-4">
        <div class="panel-body input-group input-group-sm">
            <span class="input-group-addon">Ordenar por:</span>
            <?php echo $this->form_complete->create_element(array('id' => 'order', 'type' => 'dropdown', 'options' => array('encuestaclavecorta' => 'Clave de encuesta', 'descrip' => 'Nombre de encuesta', 'evaluado' => 'Rol evaluado', 'evaluador' => 'Rol evaluador'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Ordernar por', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ordenar por', 'onchange' => "data_ajax(site_url+'/cursoencuesta/get_data_ajax/'+" . $curso . ", '#form_curso', '#listado_resultado')"))); ?>
        </div>
    </div>
    <div class="col-lg-4 col-sm-4">
        <div class="panel-body input-group input-group-sm">
            <span class="input-group-addon">Tipo de orden:</span>
            <?php echo $this->form_complete->create_element(array('id' => 'order_type', 'type' => 'dropdown', 'options' => array('DESC' => 'Descendente', 'ASC' => 'Ascendente'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Ordernar por', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ordenar por', 'onchange' => "data_ajax(site_url+'/cursoencuesta/get_data_ajax/'+" . $curso . ", '#form_curso', '#listado_resultado')"))); ?>
        </div>
    </div>
</div>
<input type="hidden" id="curso" name="curso" value="<?php echo $curso ?>">
<input type="hidden" id="bactiva" name="bactiva" value="0">

<div id="listado_resultado"><!-- resultado --></div>
<?php
foreach ($modulos_acceso as $value_hijos) {
    if ($value_hijos['url'] == En_modulos::ASOCIAR_ENCUESTA_SELECCIONADAS_CURSO and $value_hijos['activo'] == 1) {
        echo $this->form_complete->create_element(array('id' => 'btn_submit', 'name' => 'btn_submit',
            'type' => 'submit', 'value' => $value_hijos['nombre']
        ));
        break;
    }
}
?>

<div class="clearfix"></div>    



<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        var curso = $("#curso").val();
        //var bact= $("#bactiva").val(0);
        data_ajax(site_url + "/cursoencuesta/get_data_ajax/" + curso, "#form_curso", "#listado_resultado");
        $("#btn_submit").click(function (event) {
            //    var bact= $("#bactiva").val(1);
            //     alert(bact);
            var nombres = [];
            $("input[type=checkbox]:checked").each(function () {
                /* $("#encuestacve[] input[type=checkbox]:checked").each(
                 function ()
                 {*/
                nombres.push(1);
            });
            //alert(nombres);
            if ((nombres.length) == 0)
            {
                alert("Debe seleccionar al menos un elemento");
            }
            data_ajax(site_url + "/cursoencuesta/get_data_ajax/" + curso, "#form_curso", "#listado_resultado");
            event.preventDefault();
        });


    });

    function desasociar_encuesta(encuesta_cve = null)
    {
        var curso = $("#curso").val();
        //alert(encuesta_cve);
        //alert(curso);  
        if (confirm('Esta a punto de desasociar ésta encuesta, ¿Desea continuar?'))
        {
            data_ajax(site_url + "/cursoencuesta/desasociar_instrumento/" + encuesta_cve + "/" + curso, '#form_curso', "#listado_resultado");
        }

    }


</script>
