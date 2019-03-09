<?php
$bloques = $info_extra['curso']['bloques'];
$grupos = [];
foreach($info_extra['curso']['grupos'] as $row){
    $grupos[$row['id']] =  $row["name"];
}
echo form_open('reporte/index', array('id' => 'form_curso'));
?>
<div class="col-lg-12">
    <div class="col-lg-4 col-sm-4">
        <div class="panel-body input-group input-group-sm">
            <!--<span class="input-group-addon">Delegación:</span>-->
            <label for="bloque">Bloque</label>
            <?php echo $this->form_complete->create_element(array('id' => 'bloque', 'type' => 'dropdown', 'options' => $bloques, 'first' => array('' => 'Seleccione un bloque'), 'attributes' => array('name' => 'delegacion', 'class' => 'form-control', 'placeholder' => 'Bloque', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Bloque', 'onchange' => "data_ajax(site_url+'/reporte_matriz_bloques/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
        </div>
    </div>
     <div class="col-lg-4 col-sm-4">
        <div class="panel-body input-group input-group-sm">
            <!--<span class="input-group-addon">Delegación:</span>-->
            <label for="curso">Curso</label>
            <?php echo $this->form_complete->create_element(array('id' => 'grupoid', 'type' => 'dropdown', 'options' => $grupos, 'first' => array('' => 'Seleccione una opción'), 'attributes' => array('name' => 'delegacion', 'class' => 'form-control', 'placeholder' => 'Curso', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Curso', 'onchange' => "data_ajax(site_url+'/reporte_matriz_bloques/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-4 col-sm-4">
            <div class="panel-body  input-group input-group-sm">
                <label for="coordinador_curso">Coordinador de curso</label>
                <?php echo $this->form_complete->create_element(array('id' => 'ccs', 'type' => 'text', 'attributes' => array('class' => 'form-control', 'placeholder' => 'Coordinador de curso', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Coordinador de curso', 'onkeyup' =>  "data_ajax(site_url+'/reporte_matriz_bloques/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="panel-body  input-group input-group-sm">
                <label for="coordinador_tutores">Coordinador de tutores</label>
                <?php echo $this->form_complete->create_element(array('id' => 'cts', 'type' => 'text', 'attributes' => array('class' => 'form-control', 'placeholder' => 'Coordinador titular', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Coordinador titular', 'onkeyup' =>  "data_ajax(site_url+'/reporte_matriz_bloques/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="panel-body  input-group input-group-sm">
                <label for="titular">Tutor titular</label>
                <?php echo $this->form_complete->create_element(array('id' => 'tts', 'type' => 'text', 'attributes' => array('class' => 'form-control', 'placeholder' => 'Tutor titular', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Tutor titular', 'onkeyup' =>  "data_ajax(site_url+'/reporte_matriz_bloques/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
