<?php defined('BASEPATH') OR exit('No direct script access allowed');

$this->lang->load('interface','spanish');
$string_values = $this->lang->line('interface');

?>
<style type="text/css">.rojo {color: #a94442}.panel-body table{color: #000} .pinfo{padding:20px} </style>

<div class="row" id="contenedor_formulario">

    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="panel">
                <div class="breadcrumbs6 panel-heading" style="padding-left:20px;">
                    <h1>
                        <small>
                            <span class="glyphicon glyphicon-info-sign"></span>
                        </small>
                        <?php echo $string_values['registro']['lbl_bienvenido']; ?>
                    </h1>
                </div>
                <div class="panel-body">

                </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row" style="margin:5px;">
            <div class="panel">
                <div class="breadcrumbs6 panel-heading" style="padding-left:20px;">
                    <h1 id="titulo_registro">
                        <small>
                            <span class="glyphicon glyphicon-info-sign">
                            </span>
                        </small>
                        <?php echo $string_values['registro']['lbl_campos_obligatorios']; ?>
                    </h1>
                </div>

                <div class="panel-body">
    				<?php if(isset($error)){ ?>
    					<div class="row">
    						<div class="col-md-1 col-sm-1 col-xs-1"></div>
    							<div class="col-md-10 col-sm-10 col-xs-10 alert alert-danger">
    								<?php echo $error; ?>
    							</div>
    								<div class="col-md-1 col-sm-1 col-xs-1"></div>
    							</div>
    				<?php
    				}
    				echo form_open('', array('id'=>'form_registro', 'class'=>'form-horizontal')); ?>
                    <p class="pinfo">
                        <b class="rojo">*</b> <small><?php echo $string_values['registro']['lbl_campos_obligatorios']; ?></small>
                    </p>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            <b class="rojo">*</b>
                            <?php echo $string_values['registro']['lbl_matricula']; ?>
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-pencil"> </span>
                                </span>
                            <?php
                            echo $this->form_complete->create_element(
                                    array(
                                        'id'=>'reg_matricula',
                                        'type'=>'text',
                                        'attributes'=>array(
                                            'class'=>'form-control-personal',
                                            'placeholder'=>$string_values['registro']['plh_matricula'],
                                            'autocomplete'=>'off',
                                            'data-toggle'=>'tooltip',
                                            'data-placement'=>'bottom',
                                            'title'=>$string_values['registro']['plh_matricula'],
                                            'maxlength'=>20
                                            )
                                        )
                                    );
                            ?>
                            </div>
                            <?php   echo form_error_format('reg_matricula'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            <b class="rojo">*</b>
                            <?php echo $string_values['registro']['lbl_delegacion']; ?>
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-chevron-down"> </span>
                                </span>
                            <?php
                            echo $this->form_complete->create_element(
                                    array(
                                        'id'=>'reg_delegacion',
                                        'type'=>'dropdown',
                                        //'options'=>$delegaciones,
                                        'first'=>array(''=>'Seleccione la delegaci&oacute;n'),
                                        'attributes'=>array(
                                            'class'=>'form-control-personal',
                                            'autocomplete'=>'off',
                                            'data-toggle'=>'tooltip',
                                            'data-placement'=>'bottom',
                                            'title'=>'Delegaci&oacute;n de trabajo',
                                            )
                                        )
                                    );
                            ?>
                            </div>
                            <?php   echo form_error_format('reg_delegacion'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            <b class="rojo">*</b>
                            <?php echo $string_values['registro']['lbl_correo']; ?>
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><strong>@</strong> </span>
                                <?php
                                echo $this->form_complete->create_element(
                                    array(
                                        'id'=>'reg_correo',
                                        'type'=>'email',
                                        'attributes'=>array(
                                            'class'=>'form-control-personal form-control',
                                            'placeholder'=>$string_values['registro']['plh_correo'],
                                            'autocomplete'=>'off',
                                            'data-toggle'=>'tooltip',
                                            'data-placement'=>'bottom',
                                            'title'=>$string_values['registro']['plh_correo'],
                                            'maxlength'=>80
                                            )
                                        )
                                    );
                                ?>
                            </div>
                             <?php echo form_error_format('reg_email'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            <b class="rojo">*</b>
                            <?php echo $string_values['registro']['lbl_contrasenia']; ?>
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                                <?php
                                echo $this->form_complete->create_element(
                                    array(
                                        'id'=>'reg_contrasenia',
                                        'type'=>'password',
                                        'attributes'=>array(
                                            'class'=>'form-control-personal form-control',
                                            'placeholder'=>$string_values['registro']['plh_contrasenia'],
                                            'autocomplete'=>'off',
                                            'data-toggle'=>'tooltip',
                                            'data-placement'=>'bottom',
                                            'title'=>$string_values['registro']['plh_contrasenia'],
                                            'maxlength'=>32
                                            )
                                        )
                                    );
                                ?>
                            </div>
                             <?php echo form_error_format('reg_contrasenia'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            <b class="rojo">*</b>
                            <?php echo $string_values['registro']['lbl_confirma_contrasenia']; ?>
                         </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"> <span class="glyphicon glyphicon-asterisk"></span> </span>
                                <?php
                                echo $this->form_complete->create_element(
                                    array(
                                        'id'=>'reg_confirma_contrasenia',
                                        'type'=>'password',
                                        'attributes'=>array(
                                            'class'=>'form-control-personal form-control',
                                            'placeholder'=>$string_values['registro']['plh_confirma_contrasenia'],
                                            'autocomplete'=>'off',
                                            'data-toggle'=>'tooltip',
                                            'data-placement'=>'bottom',
                                            'title'=>$string_values['registro']['plh_confirma_contrasenia'],
                                            'maxlength'=>32
                                            )
                                        )
                                    );
                                ?>
                            </div>
                             <?php echo form_error_format('reg_confirma_contrasenia'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            <b class="rojo">*</b>
                            <?php echo $string_values['registro']['lbl_captcha']; ?>
                         </label>
                        <div class="col-sm-8">
                            <div id="captcha_first"><!-- aqui va a ir la imagen captcha y el reload --></div>

                            <script type="text/javascript">
                                // inicia codigo javascript necesario para un captcha
                                $( document ).ready(function() {
                                  data_ajax(site_url+"/captcha/get_new_captcha_ajax", "#null", "#captcha_first"); // cargamos por primera vez el captcha
                                });
                                // termina codigo javascript necesario para un captcha
                            </script>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-lock"> </span>
                                </span>
                            <?php
                            echo $this->form_complete->create_element(
    							array(
    								'id'=>'reg_captcha',
    								'type'=>'text',
    								'attributes'=>array(
    									'class'=>'form-control-personal ',
    									'placeholder'=>$string_values['registro']['plh_captcha'],
                                        'autocomplete'=>'off',
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'bottom',
    									'title'=>$string_values['registro']['plh_captcha'],
    									'maxlength'=>6
    									)
    								)
    							);
                            ?>

                            </div>
                            <?php echo form_error_format('reg_captcha'); ?>
                        </div>
                    </div>
                    <div class="form-group text-center">
                            <?php
                            echo $this->form_complete->create_element(array(
                                'id' => 'btn_submit',
                                'type' => 'submit',
                                'value' => $string_values['registro']['plh_btn_guardar'],
                                'attributes' => array(
                                    'class' => 'btn btn-primary'
                                    )
                                ));

                            echo form_close();
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
