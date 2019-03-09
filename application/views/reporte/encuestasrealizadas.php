<?php
//pr($data);
echo form_open('cursoencuesta/curso_encuesta/' . $curso, array('id' => 'form_curso'));
?>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-amarillo">
            <div class="panel-heading clearfix breadcrumbs6">
                <h1><?php echo $datos_curso['data'][0]['cur_clave'] . '-' . $datos_curso['data'][0]['cur_nom_completo']; ?></h1><br>
                <h2 class="panel-title" style="padding-left:20px;">Listado de encuestas realizadas por curso</h2>
                <a href="<?php echo site_url('curso/info_curso/' . $curso); ?>" class="btn btn-info pull-right"> <span class="glyphicon glyphicon-level-up"></span> Regresar a detalle curso</a>
            </div>

            <div class="panel-body">
                <div class="row" >
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Número de registros a mostrar:</span>
                            <?php
                            // echo $this->form_complete->create_element(array('id'=>'per_page', 'type'=>'dropdown', 'options'=>array(2=>2,3=>3,4=>4,10=>10, 20=>20, 50=>50, 100=>100), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Número de registros a mostrar', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Número de registros a mostrar', 'onchange'=>"data_ajax(site_url+'/bonos_titular/get_data_ajax', '#form_buscador', '#listado_resultado_empleado')")));
                            echo $this->form_complete->create_element(array('id' => 'per_page', 'type' => 'dropdown', 'options' => array(5 => 5, 10 => 10, 20 => 20, 50 => 50, 100 => 100), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Número de registros a mostrar', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Número de registros a mostrar', 'onchange' => "data_ajax(site_url+'/resultadocurenrealizada/get_data_ajax/'+" . $curso . ", '#form_curso', '#listado_resultado')")));
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Ordenar por:</span>
                            <?php echo $this->form_complete->create_element(array('id' => 'order', 'type' => 'dropdown', 'options' => array('firstname' => 'Nombre docente', 'evaluador' => 'Rol evaluador', 'role' => 'Rol a evaluar', 'ngrupo' => 'Grupo'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Ordernar por', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ordenar por', 'onchange' => "data_ajax(site_url+'/resultadocurenrealizada/get_data_ajax/'+" . $curso . ", '#form_curso', '#listado_resultado')"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Tipo de orden:</span>
                            <?php echo $this->form_complete->create_element(array('id' => 'order_type', 'type' => 'dropdown', 'options' => array('DESC' => 'Descendente', 'ASC' => 'Ascendente'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Ordernar por', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ordenar por', 'onchange' => "data_ajax(site_url+'/resultadocurenrealizada/get_data_ajax/'+" . $curso . ", '#form_curso', '#listado_resultado')"))); ?>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="curso" name="curso" value="<?php echo $curso ?>">
                <input type="hidden" id="bactiva" name="bactiva" value="0">
                <?php
                echo $this->form_complete->create_element(array('id' => 'btn_export', 'type' => 'submit', 'value' => 'Exportar', 'attributes' => array('class' => 'btn btn-info btn-sm espacio', 'style' => 'display:yes;')));
                ?>

                <div class="form-group text-center">
                    <?php
                    /* echo $this->form_complete->create_element(array('id' => 'btn_submit',
                      'type' => 'button',
                      'value' => 'Asociar',
                      'attributes' => array(
                      'class' => 'btn btn-primary'
                      )
                      )); */

                    //echo $this->form_complete->create_element(array('id'=>'btn_submit', 'type'=>'botton', 'options'=>array('DESC'=>'Descendente', 'ASC'=>'Ascendente'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Ordernar por', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ordenar por', 'onchange'=>"data_ajax(site_url+'/cursoencuesta/get_data_ajax/'+".$curso.", '#form_curso', '#listado_resultado')"))); 
                    ?>                  

                </div>



                <div id="listado_resultado">

                </div>
            </div>  <!-- /panel-body-->
        </div> <!-- /panel panel-amarillo-->
    </div> <!-- /col 12-->
</div>
<div class="row"></div>    

<script type="text/javascript">
    $(window).load(function () {
        var curso = $("#curso").val();
        data_ajax(site_url + "/resultadocurenrealizada/get_data_ajax/" + curso, "#form_curso", "#listado_resultado");
        
//        $("#btn_submit").click(function (event) {
//
//            data_ajax(site_url + "/resultadocurenrealizada/get_data_ajax/" + curso, "#form_curso", "#listado_resultado");
//            event.preventDefault();
//        });

        $("#btn_export").click(function (event) {
            event.preventDefault();
            //alert('fasdfasd');
            $("#form_curso").attr("action", site_url + "/resultadocurenrealizada/export_data/" + curso);
            $("#form_curso").submit();
            //data_ajax(site_url+"/buscador/export_data", "#form_buscador", "#listado_resultado");        
        });




    });


</script>
