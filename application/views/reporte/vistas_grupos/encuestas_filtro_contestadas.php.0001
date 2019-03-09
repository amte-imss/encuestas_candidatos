<fieldset class="scheduler-border well">
    <legend class="scheduler-border">Encuesta</legend>
    <?php if (isset($tipo_encuesta)) { ?>
        <div class="col-lg-12 col-sm-12">
            <div class="panel-body  input-group input-group-sm">
                <!--<span class="input-group-addon">Sesiones:</span>-->
                <label for="tipo_curso">Tipo de encuesta</label>
                <?php echo $this->form_complete->create_element(array('id' => 'tipo_encuesta', 'type' => 'dropdown', 'options' => $tipo_encuesta, 'first' => array('' => 'Seleccione tipo de curso'), 'attributes' => array('name' => 'tipo_curso', 'class' => 'form-control', 'placeholder' => 'Encuesta de satisfacción o desempeño', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Encuesta de satisfacción o desempeño', 'onchange' => "data_ajax($url_control)"))); ?>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($instrumento)) { ?>
        <div class="col-lg-12 col-sm-12">
            <div class="panel-body  input-group input-group-sm">
                <!--<span class="input-group-addon">Sesiones:</span>-->
                <label for="evaluado">Instrumento</label>
                <?php echo $this->form_complete->create_element(array('id' => 'instrumento_regla', 'type' => 'dropdown', 'options' => $instrumento, 'first' => array('' => 'Seleccione un instrumento'), 'attributes' => array('name' => 'instrumento', 'class' => 'form-control', 'placeholder' => 'Instrumento', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Instrumento', 'onchange' => "data_ajax($url_control)"))); ?>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($enc_con_ncon)) { ?>
        <div class="col-lg-12 col-sm-12">
            <div class="panel-body  input-group input-group-sm">
                <!--<span class="input-group-addon">Sesiones:</span>-->
                <label for="evaluado">Tipo reporte</label>
                <?php echo $this->form_complete->create_element(array('id' => 'enc_con_ncon', 'type' => 'dropdown', 'options' => $enc_con_ncon, 'attributes' => array('name' => 'enc_con_ncon', 'class' => 'form-control', 'placeholder' => 'Seleccione tipo reporte', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Tipo de reporte de encuestas', 'onchange' => "data_ajax($url_control)"))); ?>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($is_bloque_o_grupo)) { ?>
        <div class="col-lg-12 col-sm-12">
            <div class="panel-body  input-group input-group-sm">
                <!--<span class="input-group-addon">Sesiones:</span>-->
                <label for="evaluado">Agrupar</label>
                <?php echo $this->form_complete->create_element(array('id' => 'is_bloque_o_grupo', 'type' => 'dropdown', 'options' => $is_bloque_o_grupo, 'attributes' => array('name' => 'enc_con_ncon', 'class' => 'form-control', 'placeholder' => 'Agrupar por bloque o grupo de la implementación', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Agrupar por bloque o grupo de la implementación', 'onchange' => "data_ajax($url_control)"))); ?>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($bloques_p)) { ?>
        <div id="div_bloques" class="col-lg-12 col-sm-12">
            <div id="div_prima_bloques" class="panel-body input-group input-group-sm" >
            </div>
        </div>
    <?php } ?>
    <?php if (isset($grupos_p)) { ?>
        <div id="div_grupos" class="col-lg-12 col-sm-12">
            <div id="div_prima_grupos" class="panel-body input-group input-group-sm">
            </div>
        </div>
    <?php } ?>
</fieldset>