<?php
$url_control = "site_url+'/reporte_detallado/get_buscar_cursos_encuestas', '#form_reporte_detallado_implementacion', '#listado_resultado_empleado'";
echo js("busquedas/busqueda.js");
echo form_open('reporte_detallado/index', array('id' => 'form_reporte_detallado_implementacion'));
?>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-amarillo">
            <!-- <div class="panel-heading clearfix breadcrumbs6">
                <h1 class="panel-title" style="padding-left:20px;">Listado de cursos-encuestas detallados</h1>
            </div> -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <fieldset class="scheduler-border well">
                            <legend class="scheduler-border">Curso</legend>
                            <div class="col-lg-12 col-sm-12">
                                <div class="panel-body input-group input-group-sm">
                                    <!--<span class="input-group-addon">Delegación:</span>-->
                                    <label for="anio_curso"><span style="color:red;">*</span> Año de la implementación</label>
                                    <?php echo $this->form_complete->create_element(array('id' => 'anio', 'type' => 'dropdown', 'options' => $anios, 'first' => array('' => 'Seleccione un año'), 'attributes' => array('name' => 'anio', 'class' => 'form-control', 'placeholder' => 'Año que impartio curso', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Año en que se impartio curso', 'onchange' => ""))); ?>
                                </div>
                            </div>
                            <?php
                            if (isset($buscar_instrumento)) {
                                $boton_buscar = 1;
                                ?>
                                <div class="col-lg-12 col-sm-12">
                                    <div class="panel-body input-group">
                                        <input type="hidden" id="menu_instrumento" name="tipo_buscar_instrumento" value="clavecurso">
                                        <div class="input-group-btn">
                                            <button id="btn_tipo_buscar_instrumento" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default dropdown-toggle " data-toggle="tooltip" data-original-title="Buscar por"><?php echo $buscar_instrumento['clavecurso']; ?><span class="caret"> </span></button>
                                            <ul id="ul_menu_buscar_por_i" data-seleccionado='clavecurso' class="dropdown-menu borderlist">
                                                <?php foreach ($buscar_instrumento as $key => $value) { ?>
                                                    <li class="lip" onclick="funcion_menu_tipo_busqueda('<?php echo $key; ?>')"><?php echo $value; ?></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php
                                        echo $this->form_complete->create_element(
                                                array('id' => 'text_buscar_instrumento', 'type' => 'text',
                                                    'value' => '',
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
                                    </div>
                                </div>
                            <?php } ?>                            
                            <div class="col-lg-12 col-sm-12">
                                <div class="panel-body  input-group input-group-sm">
                                    <!--<span class="input-group-addon">Sesiones:</span>-->
                                    <label for="tipo_curso">Tipo de implementación</label>
                                    <?php echo $this->form_complete->create_element(array('id' => 'tipo_implementacion', 'type' => 'dropdown', 'options' => $tipo_implementacion, 'first' => array('' => 'Seleccione tipo de implementación'), 'attributes' => array('name' => 'tipo_curso', 'class' => 'form-control', 'placeholder' => 'Curso tipo tutorizado o no-tutorizado', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Curso tipo tutorizado o no-tutorizado', 'onchange' => ""))); ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <fieldset class="scheduler-border well">
                            <legend class="scheduler-border">Encuesta</legend>
                            <?php if (isset($instrumento)) { ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="panel-body  input-group input-group-sm">
                                        <!--<span class="input-group-addon">Sesiones:</span>-->
                                        <label for="evaluado"><span style="color:red;">*</span> Instrumento</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'instrumento_regla', 'type' => 'dropdown', 'options' => $instrumento, 'first' => array('' => 'Seleccione un instrumento'), 'attributes' => array('name' => 'instrumento', 'class' => 'form-control', 'placeholder' => 'Instrumento', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Instrumento', 'onchange' => ""))); ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-lg-6 col-sm-6">
                                <div class="panel-body  input-group input-group-sm">
                                    <!--<span class="input-group-addon">Sesiones:</span>-->
                                    <label for="tipo_curso"><span style="color:red;">*</span> Aplica para bono</label>
                                    <?php echo $this->form_complete->create_element(array('id' => 'is_bono', 'type' => 'dropdown', 'options' => array('1'=>'Si', '0'=>'No'), 'first' => array('' => 'Seleccione si aplica para bono'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Aplica para bono', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Aplica para bono', 'onchange' => ""))); ?>
                                </div>
                            </div>
                            <div id="div_encuestas" style="display:none;">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="panel-body  input-group input-group-sm">
                                        <!--<span class="input-group-addon">Sesiones:</span>-->
                                        <label for="tipo_curso"><span style="color:red;">*</span> Encuestas</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'tipo_encuesta', 'type' => 'dropdown', 'options' => array('Evaluación del desempeño del tutor', 'Evaluación del desempeño del tutor 2'), 'first' => array('' => 'Seleccione tipo de curso'), 'attributes' => array('name' => 'tipo_curso', 'class' => 'form-control', 'placeholder' => 'Encuesta de satisfacción o desempeño', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Encuesta de satisfacción o desempeño', 'onchange' => ""))); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="panel-body  input-group input-group-sm">
                                    <!--<span class="input-group-addon">Sesiones:</span>-->
                                    <label for="tipo_curso">Tipo de encuesta</label>
                                    <?php echo $this->form_complete->create_element(array('id' => 'tipo_encuesta', 'type' => 'dropdown', 'options' => $tipo_encuesta, 'first' => array('' => 'Seleccione tipo de curso'), 'attributes' => array('name' => 'tipo_curso', 'class' => 'form-control', 'placeholder' => 'Encuesta de satisfacción o desempeño', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Encuesta de satisfacción o desempeño', 'onchange' => ""))); ?>
                                </div>
                            </div>                            
                            <?php if (isset($grupos_p)) { ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="panel-body input-group input-group-sm">
                                        <!--<span class="input-group-addon">Delegación:</span>-->
                                        <label for="grupo">Grupos</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'grupo', 'type' => 'dropdown', 'options' => $grupos_p, 'first' => array('' => 'Seleccione'), 'attributes' => array('name' => 'grupo', 'class' => 'form-control', 'placeholder' => 'Grupo', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Grupos', 'onchange' => ""))); ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (isset($bloques_p)) { ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="panel-body input-group input-group-sm">
                                        <!--<span class="input-group-addon">Delegación:</span>-->
                                        <label for="grupo">Bloques</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'bloque', 'type' => 'dropdown', 'options' => $bloques_p, 'first' => array('' => 'Seleccione'), 'attributes' => array('name' => 'bloque', 'class' => 'form-control', 'placeholder' => 'Bloque', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Bloques', 'onchange' => ""))); ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <fieldset class="scheduler-border well">
                            <legend class="scheduler-border">Evaluado</legend>
                            <?php
                            if (isset($buscar_docente_evaluado)) {//Buscar por instrumento 
                                $boton_buscar = 1;
                                ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="panel-body input-group">
                                        <input type="hidden" id="menu_evaluado" name="tipo_buscar_docente_evaluado" value="matriculado">
                                        <div class="input-group-btn">
                                            <button id="btn_buscar_docente_evaluado" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default dropdown-toggle " data-toggle="tooltip" data-original-title="Buscar por"><?php echo $buscar_docente_evaluado['matriculado']; ?><span class="caret"> </span></button>
                                            <ul id="ul_menu_buscar_por_d" data-seleccionado='matriculado' class="dropdown-menu borderlist">
                                                <?php foreach ($buscar_docente_evaluado as $key => $value) { ?>
                                                    <li class="lip" onclick="funcion_menu_tipo_busqueda('<?php echo $key; ?>')"><?php echo $value; ?></li>
                                                <?php } ?>
                                            </ul>

                                        </div>

                                        <?php
                                        echo $this->form_complete->create_element(
                                                array('id' => 'text_buscar_docente_evaluado', 'type' => 'text',
                                                    'value' => '',
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
                                    </div>
                                </div>
                            <?php } ?>
                            <?php
                            if (isset($buscar_categoria)) {//Buscar por instrumento   
                                $boton_buscar = 1;
                                ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="panel-body input-group">
                                        <input type="hidden" id="menu_categoria" name="tipo_buscar_categoria" value="categoria">
                                        <div class="input-group-btn">
                                            <button id="btn_buscar_categoria" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default dropdown-toggle " data-toggle="tooltip" data-original-title="Buscar por"><?php echo $buscar_categoria['categoria']; ?><span class="caret"> </span></button>
                                            <ul id="ul_menu_buscar_por_c" data-seleccionado='categoria' class="dropdown-menu borderlist">
                                                <?php foreach ($buscar_categoria as $key => $value) { ?>
                                                    <li class="lip" onclick="funcion_menu_tipo_busqueda('<?php echo $key; ?>')"><?php echo $value; ?></li>
                                                <?php } ?>
                                            </ul>

                                        </div>

                                        <?php
                                        echo $this->form_complete->create_element(
                                                array('id' => 'text_buscar_categoria', 'type' => 'text',
                                                    'value' => '',
                                                    'attributes' => array(
                                                        'placeholder' => 'Buscar en evaluado',
                                                        'data-toggle' => 'tooltip',
                                                        'data-placement' => 'bottom',
                                                        'class' => 'form-control',
                                                        'onkeypress' => 'return runScript(event);', //control key del enter para buscar
                                                        'title' => 'Buscar en evaluado',
        //                                        'readonly'=>'readonly',
                                                    )
                                                )
                                        );
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php /*if (isset($rol_evaluado)) { ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="panel-body  input-group input-group-sm">
                                        <!--<span class="input-group-addon">Sesiones:</span>-->
                                        <label for="evaluado">Región</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'rol_evaluado', 'type' => 'dropdown', 'options' => $rol_evaluado, 'first' => array('' => 'Seleccione un rol'), 'attributes' => array('name' => 'rol_evaluado', 'class' => 'form-control', 'placeholder' => 'Rol evaluado', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Rol que desempeño como docente', 'onchange' => ""))); ?>
                                    </div>
                                </div>
                            <?php }*/ ?>
                            <?php if (isset($rol_evaluado)) { ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="panel-body  input-group input-group-sm">
                                        <!--<span class="input-group-addon">Sesiones:</span>-->
                                        <label for="evaluado">Rol del evaluado</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'rol_evaluado', 'type' => 'dropdown', 'options' => $rol_evaluado, 'first' => array('' => 'Seleccione un rol'), 'attributes' => array('name' => 'rol_evaluado', 'class' => 'form-control', 'placeholder' => 'Rol evaluado', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Rol que desempeño como docente', 'onchange' => ""))); ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (isset($delg_umae)) { ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="panel-body  input-group input-group-sm">
                                        <!--<span class="input-group-addon">Sesiones:</span>-->
                                        <label for="evaluado">Delegación - UMAE evaluado</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'delg_umae', 'type' => 'dropdown', 'options' => $delg_umae, 'first' => array('' => 'Seleccione delegación o UMAE'), 'attributes' => array('name' => 'categoria', 'class' => 'form-control', 'placeholder' => 'Delegación o UMAE', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delegación o UMAE', 'onchange' => ""))); ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php
                            if (isset($buscar_adscripcion)) {//Buscar por instrumento    
                                $boton_buscar = 1;
                                ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="panel-body input-group">
                                        <input type="hidden" id="menu_adscripcion" name="tipo_buscar_adscripcion" value="claveadscripcion">
                                        <div class="input-group-btn">
                                            <button id="btn_buscar_adscripcion" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default dropdown-toggle " data-toggle="tooltip" data-original-title="Buscar por"><?php echo $buscar_adscripcion['claveadscripcion']; ?><span class="caret"> </span></button>
                                            <ul id="ul_menu_buscar_por_ad" data-seleccionado='claveadscripcion' class="dropdown-menu borderlist">
                                                <?php foreach ($buscar_adscripcion as $key => $value) { ?>
                                                    <li class="lip" onclick="funcion_menu_tipo_busqueda('<?php echo $key; ?>')"><?php echo $value; ?></li>
                                                <?php } ?>
                                            </ul>

                                        </div>

                                        <?php
                                        echo $this->form_complete->create_element(
                                                array('id' => 'text_buscar_adscripcion', 'type' => 'text',
                                                    'value' => '',
                                                    'attributes' => array(
                                                        'placeholder' => 'Buscar en evaluado',
                                                        'data-toggle' => 'tooltip',
                                                        'data-placement' => 'bottom',
                                                        'class' => 'form-control',
                                                        'onkeypress' => 'return runScript(event);', //control key del enter para buscar
                                                        'title' => 'Buscar en evaluado',
        //                                        'readonly'=>'readonly',
                                                    )
                                                )
                                        );
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php /*if (isset($rol_evaluador)) { ?>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="panel-body  input-group input-group-sm">
                                        <!--<span class="input-group-addon">Sesiones:</span>-->
                                        <label for="evaluado">Rol del evaluador</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'rol_evaluador', 'type' => 'dropdown', 'options' => $rol_evaluador, 'first' => array('' => 'Seleccione un rol'), 'attributes' => array('name' => 'rol_evaluado', 'class' => 'form-control', 'placeholder' => 'Rol evaluado', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Rol del evaluador', 'onchange' => "data_ajax($url_control)"))); ?>
                                    </div>
                                </div>
                            <?php }*/ ?>
                        </fieldset>
                    </div>
                </div>
                <?php if (isset($boton_buscar)) {
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 text-right">
                            <div class="input-group-btn" >
                                <button type="button" id="btn_buscar_b" aria-expanded="false" class="btn btn-primary browse" title="Buscar" data-toggle="tooltip" onclick="data_ajax(<?php echo $url_control;?>)" >
                                    Buscar <span aria-hidden="true" class="glyphicon glyphicon-search"></span>
                                </button>
                                <button type="button" id="btn_buscar_b" aria-expanded="false" class="btn btn-primary browse" title="Exportar" data-toggle="tooltip" onclick="data_ajax(<?php echo $url_control;?>)" style="margin-left:10px;">
                                    Exportar <span aria-hidden="true" class="glyphicon glyphicon-export"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <!-- <div class="col-lg-12 col-sm-12">
                        <fieldset class="scheduler-border well"> -->
                            <div class="col-lg-4 col-sm-4">
                                <div class="panel-body input-group input-group-sm">
                                    <span class="input-group-addon">Número de registros a mostrar:</span>
                                    <?php // echo $this->form_complete->create_element(array('id'=>'per_page', 'type'=>'dropdown', 'options'=>array(2=>2,3=>3,4=>4,10=>10, 20=>20, 50=>50, 100=>100), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Número de registros a mostrar', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Número de registros a mostrar', 'onchange'=>"data_ajax(site_url+'/bonos_titular/get_buscar_cursos_encuestas', '#form_buscador', '#listado_resultado_empleado')")));     ?>
                                    <?php echo $this->form_complete->create_element(array('id' => 'per_page', 'type' => 'dropdown', 'options' => array(10 => 10, 20 => 20, 50 => 50, 100 => 100), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Número de registros a mostrar', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Número de registros a mostrar', 'onchange' => ""))); ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4">
                                <div class="panel-body input-group input-group-sm">
                                    <span class="input-group-addon">Ordenar por:</span>
                                    <?php echo $this->form_complete->create_element(array('id' => 'order', 'type' => 'dropdown', 'options' => $ordenar_por, 'attributes' => array('class' => 'form-control', 'placeholder' => 'Ordernar por', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ordenar por', 'onchange' => ""))); ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4">
                                <div class="panel-body input-group input-group-sm">
                                    <span class="input-group-addon">Tipo de orden:</span>
                                    <?php echo $this->form_complete->create_element(array('id' => 'order_type', 'type' => 'dropdown', 'options' => $order_by, 'attributes' => array('class' => 'form-control', 'placeholder' => 'Tipo de orden', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Tipo de orden', 'onchange' => ""))); ?>
                                </div>
                            </div>
                        <!-- </fieldset>
                    </div> -->
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
$(document).ready(function () {
    //data_ajax(site_url + "/reporte_detallado/get_buscar_cursos_encuestas", "#form_reporte_detallado_implementacion", "#listado_resultado_empleado");
//    $("#btn_submit").click(function (event) {
//        data_ajax(site_url + "/reporte_bonos/get_buscar_cursos_encuestas", "#form_reporte_bonos_implementacion", "#listado_resultado_empleado");
//        event.preventDefault();
//    });
    $('#is_bono').change(function(){
        if($(this).val()=="0"){
            $("#div_encuestas").show();
        } else {
            $("#div_encuestas").hide();
        }
    });
    
});
</script>