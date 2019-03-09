<?php
echo js("busquedas/busqueda.js");
$url_control = "site_url+'/resultadocursoindicador/get_data_ajax', '#form_curso', '#listado_resultado'";
echo form_open('resultadocursoindicador/get_data_ajax/'.$curso, array('id' => 'form_curso'));
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-amarillo">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <fieldset class="scheduler-border well">
                            <legend class="scheduler-border">Encuesta</legend>
                            <div class="row">
                                <div class="col-lg-4 col-sm-4">
                                    <div class="panel-body input-group input-group-sm">
                                        <!--<span class="input-group-addon">Delegación:</span>-->
                                        <label for="bloque">Bloques</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'bloque', 'type' => 'text',  'attributes' => array('name' => 'bloque', 'class' => 'form-control', 'placeholder' => 'Bloque', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Bloques', 'onchange' => "data_ajax(site_url+'/resultadocursoindicador/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
                                    </div>
                                </div>
                            
                            <?php if(!isset($curso)){ ?>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="panel-body input-group input-group-sm">
                                        <!--<span class="input-group-addon">Delegación:</span>-->
                                        <label for="curso">Curso</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'curso', 'type' => 'text', 'attributes' => array( 'class' => 'form-control', 'placeholder' => 'Curso', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Cursos', 'onchange' => "data_ajax(site_url+'/resultadocursoindicador/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-4">
                                    <div class="panel-body input-group input-group-sm">
                                        <!--<span class="input-group-addon">Delegación:</span>-->
                                        <label for="grupo">Grupo</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'grupo', 'type' => 'text', 'attributes' => array('name' => 'grupo','class' => 'form-control', 'placeholder' => 'grupo', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Grupos', 'onchange' => "data_ajax(site_url+'/resultadocursoindicador/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <div class="panel-body input-group input-group-sm">
                                        <!--<span class="input-group-addon">Delegación:</span>-->
                                        <label for="tutorizado">Tutorizado</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'tutorizado', 'type' => 'dropdown', 'options' => array(0=> 'No Tutorizado', 1 => 'Tutorizado'), 'first' => array('' => 'Seleccione tipo de curso'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Grupo', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Grupos', 'onchange' => "data_ajax(site_url+'/resultadocursoindicador/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <fieldset class="scheduler-border well">
                            <legend class="scheduler-border">Evaluador</legend>
                            <?php
                            if (isset($buscar_docente_evaluado)) {//Buscar por instrumento 
                                $boton_buscar = 1;
                                ?>
                                <div class="col-lg-12 col-sm-12">
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
                            <?php /*if (isset($rol_evaluado)) { ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="panel-body  input-group input-group-sm">
                                        <!--<span class="input-group-addon">Sesiones:</span>-->
                                        <label for="evaluado">Región</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'rol_evaluado', 'type' => 'dropdown', 'options' => $rol_evaluado, 'first' => array('' => 'Seleccione un rol'), 'attributes' => array('name' => 'rol_evaluado', 'class' => 'form-control', 'placeholder' => 'Rol evaluado', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Rol que desempeño como docente', 'onchange' => ""))); ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (isset($rol_evaluado)) { ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="panel-body  input-group input-group-sm">
                                        <!--<span class="input-group-addon">Sesiones:</span>-->
                                        <label for="evaluado">Rol</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'rol_evaluado', 'type' => 'dropdown', 'options' => $rol_evaluado, 'first' => array('' => 'Seleccione un rol'), 'attributes' => array('name' => 'rol_evaluado', 'class' => 'form-control', 'placeholder' => 'Rol evaluado', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Rol que desempeño como docente', 'onchange' => ""))); ?>
                                    </div>
                                </div>
                            <?php }*/ ?>
                            <?php if (isset($delg_umae)) { ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="panel-body  input-group input-group-sm">
                                        <!--<span class="input-group-addon">Sesiones:</span>-->
                                        <label for="evaluado">Delegación</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'delg_umae', 'type' => 'dropdown', 'options' => $delg_umae, 'first' => array('' => 'Seleccione delegación'), 'attributes' => array('name' => 'categoria', 'class' => 'form-control', 'placeholder' => 'Delegación', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delegación', 'onchange' => "data_ajax(site_url+'/resultadocursoindicador/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (isset($umae)) { ?>
                                <div id="div_umae" class="col-lg-6 col-sm-6">
                                    <div class="panel-body  input-group input-group-sm">
                                        <!--<span class="input-group-addon">Sesiones:</span>-->
                                        <label for="evaluado">UMAE</label>
                                        <?php echo $this->form_complete->create_element(array('id' => 'umae', 'type' => 'dropdown', 'options' => $umae, 'first' => array('' => 'Seleccione la UMAE'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'UMAE', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'UMAE', 'onchange' => "data_ajax(site_url+'/resultadocursoindicador/get_data_ajax', '#form_curso', '#listado_resultado')"))); //, 'onchange' => "data_ajax($url_control)" ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php
                            /*if (isset($buscar_adscripcion)) {//Buscar por instrumento    
                                $boton_buscar = 1;
                                ?>
                                <!-- <div class="col-lg-6 col-sm-6">
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
                                                        'placeholder' => 'Buscar en evaluador',
                                                        'data-toggle' => 'tooltip',
                                                        'data-placement' => 'bottom',
                                                        'class' => 'form-control',
                                                        'onkeypress' => 'return runScript(event);', //control key del enter para buscar
                                                        'title' => 'Buscar en evaluador',
        //                                        'readonly'=>'readonly',
                                                    )
                                                )
                                        );
                                        ?>
                                    </div>
                                </div> -->
                            <?php }*/ ?>
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
                                                        'placeholder' => 'Buscar en evaluador',
                                                        'data-toggle' => 'tooltip',
                                                        'data-placement' => 'bottom',
                                                        'class' => 'form-control',
                                                        'onkeypress' => 'return runScript(event);', //control key del enter para buscar
                                                        'title' => 'Buscar en evaluador',
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
                                <button type="button" id="btn_buscar_b" aria-expanded="false" class="btn btn-primary browse" title="Buscar" data-toggle="tooltip" onclick="<?php echo "data_ajax(site_url+'/resultadocursoindicador/get_data_ajax', '#form_curso', '#listado_resultado')";?>" >
                                    Buscar <span aria-hidden="true" class="glyphicon glyphicon-search"></span>
                                </button>
                                <?php echo $this->form_complete->create_element(array('id'=>'btn_export', 'type'=>'submit', 'value'=>'Exportar', 'attributes'=>array('class'=>'btn btn-primary browse', 'data-toggle'=>"tooltip", 'style'=>'display:yes;margin-left:10px;'))); ?>
                                <!-- <button type="submit" id="btn_export" aria-expanded="false" class="btn btn-primary browse" title="Exportar" data-toggle="tooltip" onclick="data_ajax(<?php echo $url_control;?>)" style="margin-left:10px;">
                                    Exportar <span aria-hidden="true" class="glyphicon glyphicon-export"></span>
                                </button> -->
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <!-- <fieldset class="scheduler-border well">
                            <div class="col-lg-4 col-sm-4"> -->
                                <div class="panel-body input-group input-group-sm">
                                    <span class="input-group-addon">Número de registros a mostrar:</span>
                                    <?php // echo $this->form_complete->create_element(array('id'=>'per_page', 'type'=>'dropdown', 'options'=>array(2=>2,3=>3,4=>4,10=>10, 20=>20, 50=>50, 100=>100), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Número de registros a mostrar', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Número de registros a mostrar', 'onchange'=>"data_ajax(site_url+'/bonos_titular/get_buscar_cursos_encuestas', '#form_buscador', '#listado_resultado_empleado')")));     ?>
                                    <?php echo $this->form_complete->create_element(array('id' => 'per_page', 'type' => 'dropdown', 'options' => array(20 => 20, 50 => 50, 100 => 100), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Número de registros a mostrar', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Número de registros a mostrar', 'onchange' => "data_ajax(site_url+'/resultadocursoindicador/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4">
                                <div class="panel-body input-group input-group-sm">
                                    <span class="input-group-addon">Ordenar por:</span>
                                    <?php echo $this->form_complete->create_element(array('id' => 'order', 'type' => 'dropdown', 'options' => $ordenar_por, 'attributes' => array('class' => 'form-control', 'placeholder' => 'Ordernar por', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ordenar por', 'onchange' => "data_ajax(site_url+'/resultadocursoindicador/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4">
                                <div class="panel-body input-group input-group-sm">
                                    <span class="input-group-addon">Tipo de orden:</span>
                                    <?php echo $this->form_complete->create_element(array('id' => 'order_type', 'type' => 'dropdown', 'options' => $order_by, 'attributes' => array('class' => 'form-control', 'placeholder' => 'Tipo de orden', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Tipo de orden', 'onchange' => "data_ajax(site_url+'/resultadocursoindicador/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
                                </div>
                            </div>
                        <!-- </fieldset>
                    </div> -->
                </div>



                <?php if(isset($curso)){ ?>
                <input type="hidden" id="curso" name="curso" value="<?php echo $curso ?>">
                <?php } ?>
                <input type="hidden" id="bactiva" name="bactiva" value="0">
                
                <div class="form-group text-center">
                <?php
                /* echo $this->form_complete->create_element(array('id' => 'btn_submit',
                                        'type' => 'button',
                                        'value' => 'Asociar',
                                        'attributes' => array(
                                            'class' => 'btn btn-primary'
                                            )
                                        ));*/
                //echo $this->form_complete->create_element(array('id'=>'btn_submit', 'type'=>'botton', 'options'=>array('DESC'=>'Descendente', 'ASC'=>'Ascendente'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Ordernar por', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ordenar por', 'onchange'=>"data_ajax(site_url+'/cursoencuesta/get_data_ajax/'+".$curso.", '#form_curso', '#listado_resultado')"))); ?>
                </div>
               <!-- <div class="row"> -->
                <div id="listado_resultado"></div>
                <!--</div>-->
             </div>  <!-- /panel-body-->
        </div> <!-- /panel panel-amarillo-->
    </div> <!-- /col 12-->
</div>
<div class="row"></div>    
    
 

<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        var curso=$("#curso").val();
        
        data_ajax(site_url + "/resultadocursoindicador/get_data_ajax/"+curso, "#form_curso", "#listado_resultado");
        $("#btn_submit").click(function(event) {
        
            data_ajax(site_url + "/resultadocursoindicador/get_data_ajax/"+curso, "#form_curso", "#listado_resultado");
            event.preventDefault();
        });

        $("#btn_export").click(function(event){
        event.preventDefault();
        //alert('fasdfasd');
        $("#form_curso").attr("action", site_url+"/resultadocursoindicador/export_data/"+curso);
        $("#form_curso").submit();
        //data_ajax(site_url+"/buscador/export_data", "#form_buscador", "#listado_resultado");        
    });




    });


</script>
