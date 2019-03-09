<?php
echo form_open("mail_c/get_ajax_mail/" . $id_empleado, array('id' => 'form_mail'));
//echo form_open("/bonos/perfil.tpl/", array('id' => 'form_tarjeton'));
if (exist_and_not_null($mail)) {
    $correo_mail = $mail;
} else {
    $correo_mail = '';
}
?>
<div class="panel">

    <div class="breadcrumbs6 panel-heading">
        <div class="list-group-item">
            <h1 style="padding-left:15px;"><small><span class="glyphicon glyphicon-info-sign"></span></small> Solicitud de tarjet&oacute;n
                <button type="button" id='cerrar' class="close" aria-hidden="true">&times;</button>
            </h1>
        </div>
    </div>

    <div id="mensajes">
        
    </div>

    <div class="list-group">
        <div class="list-group-item">
            <label for="Registro de bono">Correo electr&oacute;nico:</label>
            <?php
            echo $this->form_complete->create_element(array('id' => 'mail_', 'value' => $correo_mail, 'type' => 'text', 'attributes' => array('class' => 'form-control', 'maxlength' => '50', 'autocomplete' => 'off', 'placeholder' => 'E-mail', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'CVE')));
            ?>
            <span class="text-danger"> <?php echo form_error('mail_', '', ''); ?> </span>
        </div>
        <div class="list-group-item">
            <?php
            echo $this->form_complete->create_element(array('id' => 'envio_mail', 'type' => 'button', 'value' => 'Enviar solicitud', 'attributes' => array('class' => 'btn btn-amarillo btn-block espacio')));
            ?>
        </div>
    </div>


</div>
<?php form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {

        $("#cerrar").click(function(event) {
//        history.go(-1);
            javascript:location.reload();
        });
        $("#envio_mail").click(function(event) {
            data_ajax(site_url + '/mail_c/get_ajax_mail/<?php echo $id_empleado ?>', '#form_mail', '#div_ver_cursos');
        });

    });

//    $("#btn_guardar_tarjeton").click(function(event) {
//        data_ajax(site_url + '/tarjeton_c/get_data_ajax_nt', '#form_empleado', '#div_ver_cursos');
//    });
</script>
