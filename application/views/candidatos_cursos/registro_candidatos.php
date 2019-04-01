
<div class="row">
    <div class="col-lg-3 col-sm-3 col-md-3 text-right"></div>
    <div class="col-lg-3 col-sm-3 col-md-3 text-right"></div>
    <div class="col-lg-3 col-sm-3 col-md-3 text-right">
        <?php
        if (isset($btn_candidatos_formato)) {
            echo $btn_candidatos_formato;
        }
        ?>
    </div>
    <div class="col-lg-3 col-sm-3 col-md-3 text-left">
        <?php
        if (isset($btn_delegaciones)) {
            echo $btn_delegaciones;
        }
        ?>
    </div>
</div>
<?php echo form_open_multipart('candidatos/cargar_candidatos_csv', ['id' => 'form_csv_candidatos']); ?> 
<div class="row">
    <div class="col-lg-6 col-sm-6 col-md-6">
        <div class="panel-body input-group input-group-sm">
            <!--<span class="input-group-addon">Delegación:</span>-->
            <label for="cursos_registro">Registro de cursos</label>
            <?php
            echo $this->form_complete->create_element(array('id' => Candidatos::name_curso_registro_id,
                'type' => 'dropdown', 'options' => $cursos_registro,
                'first' => array('' => 'Seleccione curso'),
                'attributes' => array('name' => Candidatos::name_curso_registro_id,
                    'class' => 'form-control',
                    'placeholder' => 'Cursos de registro',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'title' => 'Implementación en etapa de registro',
                    'onchange' => "contol_envio_cursos(this);"
            )));
            ?>
        </div>
    </div>
    <div class="col-lg-6 col-sm-6 col-md-6">
        <div class="panel-body input-group input-group-sm">
            <!--<span class="input-group-addon">Delegación:</span>-->
            <label for="tipo_carga_sied">Tipo de carga</label>
            <?php
            echo $this->form_complete->create_element(array('id' => Candidatos::name_tipo_carga,
                'type' => 'dropdown', 'options' => $tipo_carga, "value" => Candidatos_cursos_control::TIPO_CARGA_DEFAULT,
                'attributes' => array('name' => Candidatos::name_tipo_carga,
                    'class' => 'form-control',
                    'placeholder' => 'Cursos de registro',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'title' => 'Tipo de carga candidatos',
            )));
            ?>
        </div>
    </div>
</div>
<div id="control_curso" class="row" >
</div>
<?php
echo form_close();
?>
<?php
if (isset($grid_candidatos)) {
    ?>
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 ">
            <?php echo $grid_candidatos; ?> 
        </div>
    </div>
    <?php
}
?>
<script>
    function call_grid_candidatos(idCurso) {
        console.log("invoca" + idCurso);
        grid_candidatos(idCurso, "grid_candidatos");
//       var  $(element);
    }
    
    function contol_envio_cursos(element) {
        if (element.value == '') {
            $("#control_curso").html('');
            $("#grid_candidatos").html('');
            
        } else {
            data_ajax(site_url + '/candidatos/cargar_candidatos/' + element.value, null, '#control_curso');
            call_grid_candidatos(element.value);
        }
    }
</script>