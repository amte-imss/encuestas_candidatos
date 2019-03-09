<?php
echo form_open('reporte/index', array('id' => 'form_empleado'));
?>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-amarillo">
            <div class="panel-heading clearfix breadcrumbs6">
                <h1 class="panel-title" style="padding-left:20px;">Listado de cursos-encuestas</h1>
            </div>
            <div class="panel-body">
                <div class="row">                    
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body  input-group input-group-sm">
                            <!--<span class="input-group-addon">Sesiones:</span>-->
                            <label for="tipo_curso">Tipo de implementación</label>
                            <?php echo $this->form_complete->create_element(array('id' => 'tipo_implementacion', 'type' => 'dropdown', 'options' => $tipo_implementacion, 'attributes' => array('name' => 'tipo_curso', 'class' => 'form-control', 'placeholder' => 'Curso tipo tutorizado o no-tutorizado', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Curso tipo tutorizado o no-tutorizado', 'onchange' => "data_ajax(site_url+'/reporte_general/get_buscar_cursos_encuestas', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body  input-group input-group-sm">
                            <!--<span class="input-group-addon">Sesiones:</span>-->
                            <label for="tipo_curso">Tipo de encuesta</label>
                            <?php echo $this->form_complete->create_element(array('id' => 'tipo_encuesta', 'type' => 'dropdown', 'options' => $tipo_encuesta, 'first' => array('' => 'Seleccione tipo de encuesta'), 'attributes' => array('name' => 'tipo_curso', 'class' => 'form-control', 'placeholder' => 'Encuesta de satisfacción o desempeño', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Encuesta de satisfacción o desempeño', 'onchange' => "data_ajax(site_url+'/reporte_general/get_buscar_cursos_encuestas', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <!--<span class="input-group-addon">Delegación:</span>-->
                            <label for="anio_curso">Año del curso</label>
                            <?php echo $this->form_complete->create_element(array('id' => 'anio', 'type' => 'dropdown', 'options' => $anios, 'first' => array('' => 'Seleccione un año'), 'attributes' => array('name' => 'anio', 'class' => 'form-control', 'placeholder' => 'Año que impartio curso', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Año en que se impartio curso', 'onchange' => "data_ajax(site_url+'/reporte_general/get_buscar_cursos_encuestas', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="panel-body input-group input-group-sm">
                            <!--<span class="input-group-addon">Delegación:</span>-->
                            <label for="grupo">Grupos</label>
                            <?php echo $this->form_complete->create_element(array('id' => 'grupo', 'type' => 'multiselect', 'options' => $grupos_p, 'first' => array('' => 'Seleccione'), 'attributes' => array('name' => 'grupo', 'class' => 'form-control', 'placeholder' => 'Grupo', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Grupos', 'onchange' => "data_ajax(site_url+'/reporte_general/get_buscar_cursos_encuestas', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="panel-body input-group input-group-sm">
                            <!--<span class="input-group-addon">Delegación:</span>-->
                            <label for="grupo">Bloques</label>
                            <?php echo $this->form_complete->create_element(array('id' => 'bloque', 'type' => 'multiselect', 'options' => $bloques_p, 'first' => array('' => 'Seleccione'), 'attributes' => array('name' => 'bloque', 'class' => 'form-control', 'placeholder' => 'Bloque', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Bloques', 'onchange' => "data_ajax(site_url+'/reporte_general/get_buscar_cursos_encuestas', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                        </div>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col-lg-6 col-sm-6">
                        <div class="panel-body  input-group input-group-sm">
                            <!--<span class="input-group-addon">Sesiones:</span>-->
                            <label for="evaluado">Instrumento</label>
                            <?php echo $this->form_complete->create_element(array('id' => 'instrumento', 'type' => 'dropdown', 'options' => $instrumento, 'first' => array('' => 'Seleccione un instrumento'), 'attributes' => array('name' => 'instrumento', 'class' => 'form-control', 'placeholder' => 'Instrumento', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Instrumento', 'onchange' => "data_ajax(site_url+'/reporte_general/get_buscar_cursos_encuestas', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="panel-body  input-group input-group-sm">
                            <!--<span class="input-group-addon">Sesiones:</span>-->
                            <label for="evaluado">Delegación - UMAE</label>
                            <?php echo $this->form_complete->create_element(array('id' => 'delg_umae', 'type' => 'dropdown', 'options' => $delg_umae, 'first' => array('' => 'Seleccione delegación o UMAE'), 'attributes' => array('name' => 'categoria', 'class' => 'form-control', 'placeholder' => 'Delegación o UMAE', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delegación o UMAE', 'onchange' => "data_ajax(site_url+'/reporte_general/get_buscar_cursos_encuestas', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Número de registros a mostrar:</span>
                            <?php // echo $this->form_complete->create_element(array('id'=>'per_page', 'type'=>'dropdown', 'options'=>array(2=>2,3=>3,4=>4,10=>10, 20=>20, 50=>50, 100=>100), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Número de registros a mostrar', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Número de registros a mostrar', 'onchange'=>"data_ajax(site_url+'/bonos_titular/get_buscar_cursos_encuestas', '#form_buscador', '#listado_resultado_empleado')"))); ?>
                            <?php echo $this->form_complete->create_element(array('id' => 'per_page', 'type' => 'dropdown', 'options' => array(5 => 5, 10 => 10, 20 => 20, 50 => 50, 100 => 100), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Número de registros a mostrar', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Número de registros a mostrar', 'onchange' => "data_ajax(site_url+'/reporte_general/get_buscar_cursos_encuestas', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Ordenar por:</span>
                            <?php echo $this->form_complete->create_element(array('id' => 'order', 'type' => 'dropdown', 'options' => $ordenar_por, 'attributes' => array('class' => 'form-control', 'placeholder' => 'Ordernar por', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ordenar por', 'onchange' => "data_ajax(site_url+'/reporte_general/get_buscar_cursos_encuestas', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Tipo de orden:</span>
                            <?php echo $this->form_complete->create_element(array('id' => 'order_type', 'type' => 'dropdown', 'options' => $order_by, 'attributes' => array('class' => 'form-control', 'placeholder' => 'Tipo de orden', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Tipo de orden', 'onchange' => "data_ajax(site_url+'/reporte_general/get_buscar_cursos_encuestas', '#form_empleado', '#listado_resultado_empleado')"))); ?>
                        </div>
                    </div>
                </div>
                <?php if (isset($buscar_por) and ! empty($buscar_por)) {//Buscar por ?>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="panel-body input-group">
                                <input type="hidden" id="menu_select" name="menu_busqueda" value="unidad">
                                <div class="input-group-btn">
                                    <button id="btn_buscar_por" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default dropdown-toggle " data-toggle="tooltip" data-original-title="Buscar por"><?php echo $buscar_por['clavecurso'];?><span class="caret"> </span></button>
                                    <ul id="ul_menu_buscar_por" data-seleccionado='clavecurso' class="dropdown-menu borderlist">
                                        <?php foreach ($buscar_por as $key => $value) { ?>
                                            <li class="lip" onclick="funcion_menu_tipo_busqueda('<?php echo $key; ?>')"><?php echo $value; ?></li>
                                        <?php } ?>
                                    </ul>

                                </div>

                                <?php
                                echo $this->form_complete->create_element(
                                        array('id' => 'buscar_unidad_medica', 'type' => 'text',
                                            'value' => 'CES-DD-I2-15',
                                            'attributes' => array(
                                                'placeholder' => 'Buscar',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'bottom',
                                                'class' => 'form-control',
                                                'onkeypress' => 'return runScript(event);', //control key del enter para buscar
                                                'title' => 'Buscar',
//                                        'readonly'=>'readonly',
                                            )
                                        )
                                );
                                ?>
                                <div class="input-group-btn" >
                                    <button type="button" id="btn_buscar_b" aria-expanded="false" class="btn btn-default browse" title="Buscar" data-toggle="tooltip" onclick="data_ajax(site_url + '/reporte_general/get_buscar_cursos_encuestas', '#form_empleado', '#listado_resultado_empleado')" ><span aria-hidden="true" class="glyphicon glyphicon-search"></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div id="listado_resultado_empleado">

                </div>



            </div>  <!-- /panel-body-->
        </div> <!-- /panel panel-amarillo-->
    </div> <!-- /col 12-->
</div>
<div class="row"></div>    



<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        data_ajax(site_url + "/reporte_general/get_buscar_cursos_encuestas", "#form_empleado", "#listado_resultado_empleado");
        $("#btn_submit").click(function (event) {
            data_ajax(site_url + "/reporte_general/get_buscar_cursos_encuestas", "#form_empleado", "#listado_resultado_empleado");
            event.preventDefault();
        });
    });


</script>