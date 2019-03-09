<?php   echo form_open('dashboard/index', array('id'=>'login')); ?>

<div class="row">
    <div class="container">

        <div class="col-md-4 col-sm-3 col-xs-12"></div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="panel">
                <div class="breadcrumbs6 panel-heading">
                    <h1 style="padding-left:20px;"><small><span class="glyphicon glyphicon-info-sign"></span></small> Lista de roles del usuario</h1>
                </div>

                <div class="list-group">

                    <div class="list-group-item">
                    <?php

                    if(isset($error) AND !is_null($error) AND !empty($error))
                    {
                        echo '<div class="row">
                                <div class="col-md-1 col-sm-1 col-xs-1"></div>
                                <div class="col-md-10 col-sm-10 col-xs-10 alert alert-danger">
                                    '.$error.'
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-1"></div>
                            </div>';
                    }

                    ?>
                    </div>
                    <div class="list-group-item">
                            <label for="matricula">Seleccione rol </label>
                            <?php 
                            echo $this->form_complete->create_element(array('id' => 'seleciion_role', 'type' => 'dropdown', 'options' => $lista_roles, 'first' => array('' => 'Seleccione rol'), 'attributes' => array('name' => 'categoria', 'class' => 'form-control', 'placeholder' => 'Categoría', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Categorías', 'onchange' => "data_ajax(site_url+'/listado_empleados_c/get_data_ajax', '#form_empleado', '#listado_resultado_empleado')"))); 
                            ?>
                            <span class="text-danger"> <?php echo form_error('matricula','','');?> </span>
                        </div>
                        <div class="list-group-item">
                            <?php
                                echo $this->form_complete->create_element(array('id'=>'btn_cargar_rol', 'type'=>'submit', 'value'=>'Cargar rol', 'attributes'=>array('class'=>'btn btn-amarillo btn-block espacio')));

                            ?>
                        </div>
                        <div class="list-group-item">
                        </div>

                </div>  <!-- /panel-body-->
            </div> <!-- /panel panel-amarillo-->
        </div> <!-- /col 12-->
        <div class="col-md-4 col-sm-3 col-xs-12"></div>

    </div>
</div> <!-- row 12-->
<input type="hidden" id="token" name="token" value="<?php echo (exist_and_not_null($this->session->userdata('token')) ? $this->session->userdata('token') : ''); ?>">
<?php

echo form_close(); ?>

<script type="text/javascript">
    $( "#img-captcha" ).find( "img" ).addClass( "img-rounded");
</script>
<br><br>

