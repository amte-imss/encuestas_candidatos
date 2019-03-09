<?php   echo form_open('login/index', array('id'=>'login')); ?>

<div class="row">
    <div class="container">

        <div class="col-md-4 col-sm-3 col-xs-12"></div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="panel">
                <div class="breadcrumbs6 panel-heading">
                    <h1 style="padding-left:20px;"><small><span class="glyphicon glyphicon-info-sign"></span></small> Iniciar sesi&oacute;n</h1>
                </div>

                <div class="list-group">

                    <div class="list-group-item">
                    <?php

                    if(exist_and_not_null($error))
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
                            <label for="matricula">Matr&iacute;cula:</label>
                            <?php
                                echo $this->form_complete->create_element(array('id'=>'matricula', 'type'=>'text', 'attributes'=>array('class'=>'form-control', 'maxlength'=>'20', 'autocomplete'=>'off', 'placeholder'=>'Matr&iacute;cula', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Matricula')));

                            ?>
                            <span class="text-danger"> <?php echo form_error('matricula','','');?> </span>
                            <p class="help-block">Matriculas: 10004696</p>
                        </div>

                        <div class="list-group-item">
                            <label for="passwd">Contrase&ntilde;a:</label>
                            <?php
                                echo $this->form_complete->create_element(array('id'=>'passwd', 'type'=>'password', 'attributes'=>array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Contrase&ntilde;a', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Contrase&ntilde;a')));
                            ?>
                                <a href="http://www.google.com">Olvido su contraseña</a>
                            <span class="text-danger"> <?php echo form_error('passwd','','');?> </span>
                            <p class="help-block">Contraseñas: 123</p>
                        </div>
                        <div class="list-group-item">
                          <div id="captcha_first"><!-- aqui va a ir la imagen captcha y el reload --></div>

                          <script type="text/javascript">
                          // inicia codigo javascript necesario para un captcha
                          $( document ).ready(function() {
                            data_ajax(site_url+"/captcha/get_new_captcha_ajax", "#null", "#captcha_first"); // cargamos por primera vez el captcha
                          });
                          // termina codigo javascript necesario para un captcha
                          </script>

                          <input type="text" class="form-control" name="userCaptcha" id="userCaptcha" placeholder="Escribe el texto de la imágen" autocomplete="off" value="<?php if(!empty($userCaptcha))echo $userCaptcha; ?>">
                            <span class="text-danger"> <?php echo form_error('userCaptcha','','');?> </span>
                        </div>
                        <div class="list-group-item">
                            <?php
                                echo $this->form_complete->create_element(array('id'=>'btn_login', 'type'=>'submit', 'value'=>'Iniciar sesión', 'attributes'=>array('class'=>'btn btn-amarillo btn-block espacio')));
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

