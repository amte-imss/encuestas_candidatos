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
    <?php if (isset($rol_evaluado)) { ?>
        <div class="col-lg-6 col-sm-6">
            <div class="panel-body  input-group input-group-sm">
                <!--<span class="input-group-addon">Sesiones:</span>-->
                <label for="evaluado">Rol</label>
                <?php echo $this->form_complete->create_element(array('id' => 'rol_evaluado', 'type' => 'dropdown', 'options' => $rol_evaluado, 'first' => array('' => 'Seleccione un rol'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Rol evaluado', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Rol que desempeño como docente'))); //, 'onchange' => "data_ajax($url_control)" ?>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($region)) { ?>
        <div class="col-lg-6 col-sm-6">
            <div class="panel-body  input-group input-group-sm">
                <!--<span class="input-group-addon">Sesiones:</span>-->
                <label for="region">Región</label>
                <?php echo $this->form_complete->create_element(array('id' => 'region', 'type' => 'dropdown', 'options' => $region, 'first' => array('' => 'Seleccione región'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Región', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Región'))); //, 'onchange' => "data_ajax($url_control)" ?>
            </div>
        </div>
    <?php } ?>    
    <?php if (isset($delg_umae)) { ?>
        <div class="col-lg-6 col-sm-6">
            <div class="panel-body  input-group input-group-sm">
                <!--<span class="input-group-addon">Sesiones:</span>-->
                <label for="evaluado">Delegación</label>
                <?php echo $this->form_complete->create_element(array('id' => 'delg_umae', 'type' => 'dropdown', 'options' => $delg_umae, 'first' => array('' => 'Seleccione delegación'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Delegación', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delegación'))); //, 'onchange' => "data_ajax($url_control)" ?>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($umae)) { ?>
        <div id="div_umae" class="col-lg-6 col-sm-6">
            <div class="panel-body  input-group input-group-sm">
                <!--<span class="input-group-addon">Sesiones:</span>-->
                <label for="evaluado">UMAE</label>
                <?php echo $this->form_complete->create_element(array('id' => 'umae', 'type' => 'dropdown', 'options' => $umae, 'first' => array('' => 'Seleccione la UMAE'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'UMAE', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'UMAE'))); //, 'onchange' => "data_ajax($url_control)" ?>
            </div>
        </div>
    <?php } ?>
    <?php
    /*if (isset($buscar_adscripcion)) {//Buscar por instrumento    
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
    <?php }*/ ?>    
    <?php /* if (isset($rol_evaluador)) { ?>
      <div class="col-lg-4 col-sm-4">
      <div class="panel-body  input-group input-group-sm">
      <!--<span class="input-group-addon">Sesiones:</span>-->
      <label for="evaluado"><span style="color:blue;">*</span> Rol del evaluador</label>
      <?php echo $this->form_complete->create_element(array('id' => 'rol_evaluador', 'type' => 'dropdown', 'options' => $rol_evaluador, 'first' => array('' => 'Seleccione un rol'), 'attributes' => array('name' => 'rol_evaluado', 'class' => 'form-control', 'placeholder' => 'Rol evaluado', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Rol del evaluador', 'onchange' => "data_ajax($url_control)"))); ?>
      </div>
      </div>
      <?php } */ ?>
</fieldset>
<script type="text/javascript">
$(document).ready(function () {
    /*$('#delg_umae').change(function(){
        if($(this).val()=="-1"){
            $("#div_umae").show();
        } else {
            $("#div_umae").hide();
        }
        $('#umae').val('');
    });*/
});
</script>