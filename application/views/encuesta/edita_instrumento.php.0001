  <?php echo js('tinymceen\tinymce\js\tinymce\tinymce.min.js');?>
  <script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-amarillo">
            <div class="panel-body">
                <?php
                $campos_instrumento = array(
                    'descripcion_encuestas',
                    'is_bono',
                    'rol_id',
                    'tutorizado',
                    'status'
                );
                $roles_evalua = array(32=>'Tutor Titular',33=>'Tutor Adjunto',18=>'Coordinador de Tutores',14=>'Coordinador de Curso');
                if (isset($instrumento) && !empty($instrumento)) {
                ?>
                <a href="<?php echo site_url('encuestas/edit/'.$instrumento[0]['encuesta_cve']); ?>" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-list" aria-hidden="true"> </span> Regresar a preguntas </a>
                <br><br>

                <?php
                //pr($instrumento);
                echo form_open('encuestas/edita_instrumento/'.$instrumento[0]['encuesta_cve'], array('id'=>'edita_instrumento', 'style' => 'margin-top: 20px'));
                $status_success = $this->session->flashdata('success');
                if ($status_success == TRUE)
                {
                    echo html_message($status_success, 'success'); 
                }
                ?>

                <div class="list-group">
                    
                    <div class="list-group-item">
                        <label for="descripcion_encuestas">Nombre del instrumento:</label>
                        <?php
                        echo $this->form_complete->create_element(array('id'=>'descripcion_encuestas', 'type'=>'text', 'value'=>$instrumento[0]['descripcion_encuestas'], 'attributes'=>array('row'=>2, 'class'=>'form-control', 'maxlength'=>'250', 'autocomplete'=>'off', 'placeholder'=>'Nombre instrumento', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Nombre instrumento')));
                        ?>
                        <span class="text-danger"> <?php echo form_error('descripcion_encuestas','','');?> </span>
                        <p class="help-block"></p>
                    </div>

                    <div class="list-group-item">
                        <label for="descripcion_encuestas">Folio de instrumento:</label>
                        <?php
                        echo $this->form_complete->create_element(array('id'=>'cve_corta_encuesta', 'type'=>'text', 'value'=>$instrumento[0]['cve_corta_encuesta'], 'attributes'=>array('row'=>2, 'class'=>'form-control', 'maxlength'=>'20', 'autocomplete'=>'off', 'placeholder'=>'Nombre instrumento', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Nombre instrumento')));
                        ?>
                        <span class="text-danger"> <?php echo form_error('cve_corta_encuesta','','');?> </span>
                        <p class="help-block"></p>
                    </div>

                    <div class="list-group-item">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <center>
                            <label>
                            <?php
                            $check_bono = (isset($instrumento[0]['is_bono']) && $instrumento[0]['is_bono']==1) ? 'checked': '';
                            echo $this->form_complete->create_element(array('id' => 'is_bono', 'type' => 'checkbox', 'value'=>1, 'attributes' => array('name' => 'is_bono', 'checked'=>$check_bono))); ?>
                            Aplica para bono
                            </label>
                            <span class="text-danger"><?php echo form_error('is_bono','','');?></span>
                            </center>
                        </div>
                        <?php /*
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <label>
                            <?php
                            $check_tuto = (isset($instrumento[0]['tutorizado']) && $instrumento[0]['tutorizado']==1) ? 'checked': '';
                            echo $this->form_complete->create_element(array('id' => 'tutorizado', 'type' => 'checkbox', 'value'=>1, 'attributes' => array('name' => 'tutorizado', 'checked'=>$check_tuto))); ?>
                            Curso tutorizado
                            </label>
                            <span class="text-danger"><?php echo form_error('tutorizado','','');?></span>
                        </div>
                        */?>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <center>
                            <label>
                            <?php
                            $check_status = (isset($instrumento[0]['status']) && $instrumento[0]['status']==1) ? 'checked': '';
                            echo $this->form_complete->create_element(array('id' => 'status', 'type' => 'checkbox', 'value'=>1, 'attributes' => array('name' => 'status', 'checked'=>$check_status))); ?>
                            Activar
                            </label>
                            <span class="text-danger"><?php echo form_error('status','','');?></span>
                            </center>
                        </div>
                        <br>
                        <p class="help-block"></p>
                    </div>
                    

                    <div class="list-group-item">
                        <label for="descripcion_encuestas">Tipo de instrumento:</label>
                        <?php echo $this->form_complete->create_element(array('id' => 'tipo_instrumento', 'type' => 'dropdown', 'options' => $tipo_instrumento,'value'=>$instrumento[0]['tipo_encuesta'], 'first' => array('' => 'Seleccione tipo de instrumento'), 'attributes' => array('name' => 'instrumento_tipo', 'class' => 'form-control', 'placeholder' => 'Tipo de instrumento', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Tipo de instrumento'))); ?>
                        <span class="text-danger"> <?php echo form_error('tipo_instrumento','','');?> </span>
                        <p class="help-block"></p>
                    </div>

                    <div class="list-group-item">
                        <label for="descripcion_encuestas">Tipo de evaluación:</label>
                        <?php echo $this->form_complete->create_element(array('id' => 'eva_tipo', 'type' => 'dropdown', 'options' => $eva_tipo,'value'=>$instrumento[0]['eva_tipo'], 'first' => array('' => 'Seleccione el tipo de evaluación'), 'attributes' => array('name' => 'eva_tipo', 'class' => 'form-control', 'placeholder' => 'Tipo de evaluación', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Tipo de evaluación'))); ?>
                        <span class="text-danger"> <?php echo form_error('eva_tipo','','');?> </span>
                        <p class="help-block"></p>
                    </div>

                    <div class="list-group-item">
                        <label for="rol_a_evaluar">Regla de evaluación:</label>
                        <?php echo $this->form_complete->create_element(array('id' => 'regla_evaluacion_cve', 'type' => 'dropdown', 'options' => $reglas_evaluacion,'value'=>$instrumento[0]['reglas_evaluacion_cve'], 'first' => array('' => 'Seleccione un rol'), 'attributes' => array('name' => 'rol_id', 'class' => 'form-control', 'placeholder' => 'Rol a evaluar', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Rol a evaluar'))); ?>
                        <span class="text-danger"> <?php echo form_error('regla_evaluacion_cve','','');?> </span>
                        <p class="help-block"></p>
                    </div>
                      <div class="list-group-item">
                        <label for="rol_a_evaluar">Instrucciones:</label>
                        <?php echo $this->form_complete->create_element(array('id' => 'guia_descripcion_encuesta', 'type' => 'textarea', 'value'=>$instrumento[0]['guia_descripcion_encuesta'])); ?>
                        <span class="text-danger"> <?php echo form_error('guia_descripcion_encuesta','','');?> </span>
                        <p class="help-block"></p>
                    </div>


	                <div class="list-group-item">
		                  <?php
		                      echo $this->form_complete->create_element(array('id'=>'btn_submit', 'type'=>'submit', 'value'=>'Guardar instrumento', 'attributes'=>array('class'=>'btn btn-moodle btn-block espacio')));
		                  ?>
	                </div>
                    <div class="list-group-item"></div>
                </div>

                <?php
                    echo form_close();

                } else {

                ?>
                <br><br>
                <div class="row">
                    <div class="jumbotron"><div class="container"> <p class="text_center">No se encontraron datos registrados en esta busqueda</p> </div></div>
                </div>

                <?php

                }

                ?>

            </div>
        </div>
    </div>
</div>
