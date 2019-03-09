<fieldset class="scheduler-border well">
    <legend class="scheduler-border">Evaluador</legend>
    <?php
    if (isset($buscar_docente_evaluado)) {//Buscar por instrumento 
        $boton_buscar = 1;
        ?>
        <div class="col-lg-6 col-sm-6">
            <div class="panel-body input-group">
                <input type="hidden" id="menu_evaluador" name="tipo_buscar_docente_evaluador" value="matriculador">
                <div class="input-group-btn">
                    <button id="btn_buscar_docente_evaluador" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default dropdown-toggle " data-toggle="tooltip" data-original-title="Buscar por"><?php echo $buscar_docente_evaluado['matriculado']; ?><span class="caret"> </span></button>
                    <ul id="ul_menu_buscar_por_dr" data-seleccionado='matriculador' class="dropdown-menu borderlist">
                        <?php foreach ($buscar_docente_evaluado as $key => $value) { ?>

                            <li class="lip" onclick="funcion_menu_tipo_busqueda('<?php echo $key . 'r'; ?>')"><?php echo $value; ?></li>
                        <?php } ?>
                    </ul>

                </div>

                <?php
                echo $this->form_complete->create_element(
                        array('id' => 'text_buscar_docente_evaluador', 'type' => 'text',
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
    <?php if (isset($region)) { ?>
        <div class="col-lg-6 col-sm-6">
            <div class="panel-body  input-group input-group-sm">
                <!--<span class="input-group-addon">Sesiones:</span>-->
                <label for="region">Región</label>
                <?php echo $this->form_complete->create_element(array('id' => 'regionr', 'type' => 'dropdown', 'options' => $region, 'first' => array('' => 'Seleccione región'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Región', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Región'))); //, 'onchange' => "data_ajax($url_control)" ?>
            </div>
        </div>
    <?php } ?>    
    <?php if (isset($rol_evaluador)) { ?>
        <div class="col-lg-6 col-sm-6">
            <div class="panel-body  input-group input-group-sm">
                <!--<span class="input-group-addon">Sesiones:</span>-->
                <label for="evaluador">Rol</label>
                <?php echo $this->form_complete->create_element(array('id' => 'rol_evaluador', 'type' => 'dropdown', 'options' => $rol_evaluador, 'first' => array('' => 'Seleccione un rol'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Rol evaluador', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Rol evaluador'))); //, 'onchange' => "data_ajax($url_control)" ?>
            </div>
        </div>
    <?php } ?>
     <?php if (isset($delegacion)) { ?>
        <div class="col-lg-6 col-sm-6">
            <div class="panel-body  input-group input-group-sm">
                <!--<span class="input-group-addon">Sesiones:</span>-->
                <label for="evaluado">Delegación</label>
                <?php echo $this->form_complete->create_element(array('id' => 'delegacion_dor', 'type' => 'dropdown', 'options' => $delegacion, 'first' => array('' => 'Seleccione delegación'), 'attributes' => array('name' => 'delegacion_dor', 'class' => 'form-control', 'placeholder' => 'Delegación', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delegación', 'onchange' => "data_ajax($url_control)"))); ?>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($umae)) { ?>
        <div class="col-lg-6 col-sm-6">
            <div class="panel-body  input-group input-group-sm">
                <!--<span class="input-group-addon">Sesiones:</span>-->
                <label for="evaluado">UMAE</label>
                <?php echo $this->form_complete->create_element(array('id' => 'umaedor', 'type' => 'dropdown', 'options' => $umae, 'first' => array('' => 'Seleccione UMAE'), 'attributes' => array('name' => 'umaedor', 'class' => 'form-control', 'placeholder' => 'UMAE', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'UMAE', 'onchange' => "data_ajax($url_control)"))); ?>
            </div>
        </div>
    <?php } ?>
     <?php
    if (isset($buscar_adscripcion)) {//Buscar por instrumento    
        $boton_buscar = 1;
        ?>
        <div class="col-lg-6 col-sm-6">
            <div class="panel-body input-group">
                <input type="hidden" id="menu_adscripcion" name="tipo_buscar_adscripcion_dor" value="claveadscripciondor">
                <div class="input-group-btn">
                    <button id="btn_buscar_adscripciondor" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default dropdown-toggle " data-toggle="tooltip" data-original-title="Buscar por"><?php echo $buscar_adscripcion['claveadscripcion']; ?><span class="caret"> </span></button>
                    <ul id="ul_menu_buscar_por_ad" data-seleccionado='claveadscripciondor' class="dropdown-menu borderlist">
                        <?php foreach ($buscar_adscripcion as $key => $value) { ?>
                            <li class="lip" onclick="funcion_menu_tipo_busqueda('<?php echo $key.'dor'; ?>')"><?php echo $value; ?></li>
                        <?php } ?>
                    </ul>

                </div>

                <?php
                echo $this->form_complete->create_element(
                        array('id' => 'text_buscar_adscripcion_dor', 'type' => 'text',
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


    <?php
    if (isset($buscar_categoria)) {//Buscar por instrumento   
        $boton_buscar = 1;
        ?>
        <div class="col-lg-6 col-sm-6">
            <div class="panel-body input-group">
                <input type="hidden" id="menu_categoriar" name="tipo_buscar_categoriar" value="categoriar">
                <div class="input-group-btn">
                    <button id="btn_buscar_categoriar" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default dropdown-toggle " data-toggle="tooltip" data-original-title="Buscar por"><?php echo $buscar_categoria['categoria']; ?><span class="caret"> </span></button>
                    <ul id="ul_menu_buscar_por_c" data-seleccionado='categoriar' class="dropdown-menu borderlist">
                        <?php foreach ($buscar_categoria as $key => $value) { ?>
                            <li class="lip" onclick="funcion_menu_tipo_busqueda('<?php echo $key; ?>')"><?php echo $value; ?></li>
                        <?php } ?>
                    </ul>

                </div>

                <?php
                echo $this->form_complete->create_element(
                        array('id' => 'text_buscar_categoriar', 'type' => 'text',
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
</fieldset>
<script type="text/javascript">
    $(document).ready(function () {
        $('#delg_umaer').change(function () {
            if ($(this).val() == "-1") {
                $("#div_umaer").show();
            } else {
                $("#div_umaer").hide();
            }
            $('#umaer').val('');
        });
    });
</script>