<?php echo js("curso/curso.js"); ?>
<?php
echo form_open('curso/index', array('id' => 'form_curso'));
?>

<div class="panel-heading clearfix breadcrumbs6">
    <h1 class="panel-title" style="padding-left:20px;">Listado de cursos</h1>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-4 col-sm-4">
            <div class="panel-body input-group input-group-sm">
                <!--<span class="input-group-addon">Delegación:</span>-->
                <label for="delegacionn">Año del curso</label>
                <?php echo $this->form_complete->create_element(array('id' => 'anio', 'type' => 'dropdown', 'options' => $anios, 'first' => array('' => 'Seleccione un año'), 'attributes' => array('name' => 'delegacion', 'class' => 'form-control', 'placeholder' => 'Año que impartio curso', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Año en que se impartio curso', 'onchange' => "data_ajax(site_url+'/curso/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="panel-body  input-group input-group-sm">
                <label for="categoriaa">Clave implementación</label>
                <?php echo $this->form_complete->create_element(array('id' => 'cur_clave', 'type' => 'text', 'attributes' => array('class' => 'form-control', 'placeholder' => 'Clave de implementación', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Clave de implementación', 'onkeyup' =>  "data_ajax(site_url+'/curso/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4"><!-- --></div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-4 col-sm-4">
            <div class="panel-body input-group input-group-sm">
                <!--<span class="input-group-addon">Delegación:</span>-->
                <label for="delegacionn">Tipo de curso</label>
                <?php echo $this->form_complete->create_element(array('id' => 'tutorizado', 'type' => 'dropdown', 'options' => array(0=>'No Tutorizados', 1=>'Tutorizados'), 'first' => array('' => 'Seleccione una opción'), 'attributes' => array('name' => 'delegacion', 'class' => 'form-control', 'placeholder' => 'Tipo de curso', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Tipo de curso', 'onchange' => 'display_en_bloque()'))); ?>
            </div>
        </div>
        <div id="div_en_bloques" class="col-lg-4 col-sm-4">
            <div class="panel-body  input-group input-group-sm">
                <label for="categoriaa">Bloques asignados</label>
                <?php echo $this->form_complete->create_element(array('id' => 'en_bloque', 'type' => 'dropdown', 'options' => array(1=>'Asignados', 2=>'Por Asignar'), 'first' => array('' => 'Seleccione una opción'), 'attributes' => array('name' => 'delegacion', 'class' => 'form-control', 'placeholder' => 'Bloques asignados', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Bloques asignados', 'onchange' => "data_ajax(site_url+'/curso/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4"><!-- --></div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-sm-4">
        <div class="panel-body input-group input-group-sm">
            <span class="input-group-addon">Número de registros a mostrar:</span>
            <?php echo $this->form_complete->create_element(array('id'=>'per_page', 'type'=>'dropdown', 'options'=>array(5=>5,10=>10, 20=>20, 50=>50, 100=>100), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Número de registros a mostrar', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Número de registros a mostrar', 'onchange'=>"data_ajax(site_url+'/curso/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
        </div>
    </div>
    <div class="col-lg-4 col-sm-4">
        <div class="panel-body input-group input-group-sm">
            <span class="input-group-addon">Ordenar por:</span>
            <?php echo $this->form_complete->create_element(array('id'=>'order', 'type'=>'dropdown', 'options'=>array('anio'=>'Año curso','cur_clave'=>'Clave curso', 'cur_nom_completo'=>'Nombre curso','cat_nom'=>'Categoría','horascur'=>'Horas curso', 'tutorizado'=>'Tutorizado'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Ordernar por', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ordenar por', 'onchange'=>"data_ajax(site_url+'/curso/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
        </div>
    </div>
    <div class="col-lg-4 col-sm-4">
        <div class="panel-body input-group input-group-sm">
            <span class="input-group-addon">Tipo de orden:</span>
            <?php echo $this->form_complete->create_element(array('id'=>'order_type', 'type'=>'dropdown', 'options'=>array('DESC'=>'Descendente', 'ASC'=>'Ascendente'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Ordernar por', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ordenar por', 'onchange'=>"data_ajax(site_url+'/curso/get_data_ajax', '#form_curso', '#listado_resultado')"))); ?>
        </div>
    </div>
</div>

<div id="listado_resultado"><!-- resultado --></div>

<div class="clearfix"></div>



<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        data_ajax(site_url + "/curso/get_data_ajax", "#form_curso", "#listado_resultado");
        $("#btn_submit").click(function(event) {
            data_ajax(site_url + "/curso/get_data_ajax", "#form_curso", "#listado_resultado");
            event.preventDefault();
        });
    });


</script>
