<?php
echo form_open('reporte/index', array('id' => 'form_empleado'));
?>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-amarillo">
            <div class="panel-heading clearfix breadcrumbs6">
                <h1 class="panel-title" style="padding-left:20px;">Listado de docentes</h1>
            </div>
            <div class="panel-body">
                <div class="row">                    

                    <div class="col-lg-12">
                        <div class="col-lg-4 col-sm-4">
                            <div class="panel-body  input-group input-group-sm">
                                <!--<span class="input-group-addon">Sesiones:</span>-->
                                <label for="categoriaa">Rol del docente</label>
                                <?php echo $this->form_complete->create_element(array('id' => 'rol', 'type' => 'dropdown', 'options' => $rol, 'first' => array('' => 'Seleccione un rol'), 'attributes' => array('name' => 'categoria', 'class' => 'form-control', 'placeholder' => 'Rol que desempeña', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Rol que desempeño como docente', 'onchange' => "data_ajax(site_url+'/reporte/get_data_ajax', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="panel-body input-group input-group-sm">
                                <!--<span class="input-group-addon">Delegación:</span>-->
                                <label for="delegacionn">Año del curso</label>
                                <?php echo $this->form_complete->create_element(array('id' => 'anio', 'type' => 'dropdown', 'options' => $anios, 'first' => array('' => 'Seleccione un año'), 'attributes' => array('name' => 'delegacion', 'class' => 'form-control', 'placeholder' => 'Año que impartio curso', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Año en que se impartio curso', 'onchange' => "data_ajax(site_url+'/reporte/get_data_ajax', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-4">
                        </div>

                    </div>
                </div>
                

                <div class="row">
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Número de registros a mostrar:</span>
                            <?php // echo $this->form_complete->create_element(array('id'=>'per_page', 'type'=>'dropdown', 'options'=>array(2=>2,3=>3,4=>4,10=>10, 20=>20, 50=>50, 100=>100), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Número de registros a mostrar', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Número de registros a mostrar', 'onchange'=>"data_ajax(site_url+'/bonos_titular/get_data_ajax', '#form_buscador', '#listado_resultado_empleado')"))); ?>
                            <?php echo $this->form_complete->create_element(array('id'=>'per_page', 'type'=>'dropdown', 'options'=>array(5=>5,10=>10, 20=>20, 50=>50, 100=>100), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Número de registros a mostrar', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Número de registros a mostrar', 'onchange'=>"data_ajax(site_url+'/reporte/get_data_ajax2', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Ordenar por:</span>
                            <?php echo $this->form_complete->create_element(array('id'=>'order', 'type'=>'dropdown', 'options'=>array('emp_matricula'=>'Matrícula', 'emp_nombre'=>'Docente nombre','cur_clave'=>'Clave curso','cur_nom_completo'=>'Nombre curso','fecha_inicio'=>'Fecha inicio', 'rol_nom'=>'Rol docente','horascur'=>'Duración horas','tipo_curso'=>'Tipo curso'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Ordernar por', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ordenar por', 'onchange'=>"data_ajax(site_url+'/reporte/get_data_ajax', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Tipo de orden:</span>
                            <?php echo $this->form_complete->create_element(array('id'=>'order_type', 'type'=>'dropdown', 'options'=>array('ASC'=>'Ascendente','DESC'=>'Descendente'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Ordernar por', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ordenar por', 'onchange'=>"data_ajax(site_url+'/reporte/get_data_ajax', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                        </div>
                    </div>
                </div>

                <div id="listado_resultado_empleado">

                </div>
                    
                

            </div>  <!-- /panel-body-->
        </div> <!-- /panel panel-amarillo-->
    </div> <!-- /col 12-->
</div>
<div class="row"></div>    
    
 

<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        data_ajax(site_url + "/reporte/get_data_ajax2", "#form_empleado", "#listado_resultado_empleado");
        $("#btn_submit").click(function(event) {
            data_ajax(site_url + "/reporte/get_data_ajax2", "#form_empleado", "#listado_resultado_empleado");
            event.preventDefault();
        });
    });


</script>