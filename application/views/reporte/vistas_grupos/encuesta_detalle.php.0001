<fieldset class="scheduler-border well">
    <legend class="scheduler-border">Encuesta</legend>
    <?php if (isset($instrumento)) { ?>
        <div class="col-lg-6 col-sm-6">
            <div class="panel-body  input-group input-group-sm">
                <!--<span class="input-group-addon">Sesiones:</span>-->
                <label for="evaluado"><span style="color:red;">*</span> Instrumento</label>
                <?php echo $this->form_complete->create_element(array('id' => 'instrumento_regla', 'type' => 'dropdown', 'options' => $instrumento, 'first' => array('' => 'Seleccione un instrumento'), 'attributes' => array('name' => 'instrumento', 'class' => 'form-control', 'placeholder' => 'Instrumento', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Instrumento', 'onchange' => "javascript:data_ajax(site_url+'/reporte_detallado/get_view_ajax/e', '#form_curso', '#div_encuestas');"))); //, 'onchange' => "data_ajax($url_control)" ?>
            </div>
        </div>
    <?php } ?>
    <div class="col-lg-6 col-sm-6">
        <div class="panel-body  input-group input-group-sm">
            <label for="tipo_curso"><span style="color:red;">*</span> Aplica para bono</label>
            <?php echo $this->form_complete->create_element(array('id' => 'is_bono', 'type' => 'dropdown', 'options' => array('1' => 'Si', '0' => 'No'), 'first' => array('' => 'Seleccione si aplica para bono'), 'attributes' => array('name' => 'tipo_curso', 'class' => 'form-control', 'placeholder' => 'Aplica para bono', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Aplica para bono', 'onchange' => "javascript:data_ajax(site_url+'/reporte_detallado/get_view_ajax/e', '#form_curso', '#div_encuestas');"))); //, 'onchange' => "data_ajax($url_control)" ?>
        </div>
    </div>
    <div class="col-lg-6 col-sm-6">
        <div class="panel-body  input-group input-group-sm">
            <!--<span class="input-group-addon">Sesiones:</span>-->
            <label for="tipo_curso">Tipo de encuesta</label>
            <?php echo $this->form_complete->create_element(array('id' => 'tipo_encuesta', 'type' => 'dropdown', 'options' => $tipo_encuesta, 'first' => array('' => 'Seleccione tipo de curso'), 'attributes' => array('name' => 'tipo_curso', 'class' => 'form-control', 'placeholder' => 'Encuesta de satisfacción o desempeño', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Encuesta de satisfacción o desempeño'))); //, 'onchange' => "data_ajax($url_control)" ?>
        </div>
    </div>
    <div id="div_encuestas" class="col-lg-6 col-sm-6">
        <?php if(isset($encuesta)) { ?>
            <!-- <div class="panel-body  input-group input-group-sm">
                <label for="tipo_curso"><span style="color:red;">*</span> Encuestas</label>
                <?php //echo $this->form_complete->create_element(array('id' => 'encuesta', 'type' => 'dropdown', 'options' =>$encuesta , 'first' => array('' => 'Seleccione la encuesta'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Encuesta', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Encuesta'))); ?>
            </div> -->
        <?php } ?>
    </div>
    <?php if(isset($grupos_p)) { ?>
        <div id="div_grupos" class="col-lg-6 col-sm-6">
            <div id="div_prima_grupos" class="panel-body input-group input-group-sm">
                <!-- <label for="grupo">Grupos</label>
                <?php //echo $this->form_complete->create_element(array('id' => 'grupo', 'type' => 'dropdown', 'options' => $grupos_p, 'first' => array('' => 'Seleccione'), 'attributes' => array('name' => 'grupo', 'class' => 'form-control', 'placeholder' => 'Grupo', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Grupos', 'onchange' => ""))); ?> -->
            </div>
        </div>
    <?php } ?>
    <?php if (isset($bloques_p)) { ?>
        <div id="div_bloques" class="col-lg-6 col-sm-6">
            <div id="div_prima_bloques" class="panel-body input-group input-group-sm" >
                <!-- <label for="grupo">Bloques</label>
                <?php //echo $this->form_complete->create_element(array('id' => 'bloque', 'type' => 'dropdown', 'options' => $bloques_p, 'first' => array('' => 'Seleccione'), 'attributes' => array('name' => 'bloque', 'class' => 'form-control', 'placeholder' => 'Bloque', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Bloques', 'onchange' => ""))); ?> -->
            </div>
        </div>
    <?php } ?>
</fieldset>
<script type="text/javascript">
$(document).ready(function () {
    /*$('#is_bono').change(function(){
        if($(this).val()=="0"){
            $("#div_encuestas").show();
        } else {
            $("#div_encuestas").hide();
        }
    });*/
});
</script>