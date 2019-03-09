
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$string_value = get_elementos_lenguaje(array(En_catalogo_textos::DETALLE_CENSO, En_catalogo_textos::COMPROBANTE));
$controlador = $this->uri->rsegment(1);
//pr($formulario_campos);
?>

<?php
//echo css('template_sipimss/to-do.css');
//echo css('font-awesome/css/font-awesome.css');
?>


<div class="row">
    <div id="notificaciones_modal_id" class="alert alert-info" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="col-md-12 col-sm-12 mb">
        <div class="col-md-6 goleft">
            <p><label class="bold-label"><?php echo $string_value['estado_validacion']; ?></label>
                <?php echo $detalle_censo['nombre_validacion']; ?>
            </p>
        </div>
        <div class="col-md-6 goleft">
            <p><label class="bold-label"><?php echo $string_value['folio_censo']; ?></label>
                <?php echo $detalle_censo['folio']; ?>
            </p>
        </div>


        <?php
//        $this->load->library('Funciones_motor_formulario'); //Carga biblioteca
        $notificaciones = '';
        $i = 1;
        $row_print = array('row_end' => '', 'row_close' => '');
        foreach ($formulario_campos as $value) {
            if ($value['respuesta_valor'] != 'NULL') {
                if (!is_null($value['regla_notificacion'])) {
                    $notificacion = (array) json_decode($value['regla_notificacion']);
                    $text_notificacion = $this->funciones_motor_formulario->{$notificacion['funcion']}($value['respuesta_valor']); //
                    $br_ = '';
                    if (!is_null($text_notificacion)) {
                        $notificaciones .= $br_ . $text_notificacion;
                        $br_ = '<br>';
                    }
                }
                switch ($value['nom_tipo_campo']) {//Valida el tipo de campo
                    case 'file'://Tipo de campo file
                        ?>
                        <div class="col-md-6 goleft">
                            <p><label class="bold-label"><?php echo $value['lb_campo']; ?></label>

                                <?php
                                $file = (isset($value['respuesta_valor'])) ? encrypt_base64($value['respuesta_valor']) : '';
                                echo '<a href="' . site_url($controlador . '/ver_archivo/' . $file) . '" target="_blank"><span class="fa fa-search"></span> ' . $string_value['ver_archivo'] . '</a><br>';
                                echo '<a href="' . site_url($controlador . '/descarga_archivo/' . $file) . '" target="_blank"><span class="fa fa-download"></span> ' . $string_value['descargar_archivo'] . '</a>';
//                echo $this->form_complete->create_element(array('id' => 'idc', 'type' => 'hidden', 'value' => $file));
                                ?>
                            </p>
                        </div>
                        <?php
                        break;
                    default ://Todo lo demás diferente
                        ?>
                        <div class="col-md-6 goleft">
                            <p><label class="bold-label"><?php echo $value['lb_campo']; ?></label>
                                <?php echo $value['respuesta_valor']; ?>
                            </p>

                        </div>
                    <?php
                }
            }
        }
        ?>

        <?php
        if (isset($detalle_censo['id_censo']) || !empty($detalle_censo['id_censo'])) { //En caso de tener asociado archivo, se muestra link
            ?>
            <div class="col-md-6 goleft">
                <p><label class="bold-label"><?php echo $string_value['lbl_texto_comprobante']; ?></label>

                    <?php
                    $file = (isset($detalle_censo['id_file'])) ? encrypt_base64($detalle_censo['id_file']) : '';
                    echo $this->form_complete->create_element(array('id' => 'id_file_comprobante', 'type' => 'hidden', 'value' => $file));
                    echo '<a href="' . site_url($controlador . '/ver_archivo/' . $file) . '" target="_blank"><span class="fa fa-search"></span> ' . $string_value['ver_archivo'] . '</a><br>';
                    echo '<a href="' . site_url($controlador . '/descarga_archivo/' . $file) . '" target="_blank"><span class="fa fa-download"></span> ' . $string_value['descargar_archivo'] . '</a>';
//                echo $this->form_complete->create_element(array('id' => 'idc', 'type' => 'hidden', 'value' => $file));
                    ?>
                </p>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        //                $('[data-toggle="popover"]').popover();
//                $('.datepicker').datepicker();
<?php if (empty($notificaciones)) { ?>
            $("#notificaciones_modal_id").remove();
<?php } else { ?>
            document.getElementById("notificaciones_modal_id").innerHTML += "<?php echo $notificaciones; ?>";

<?php } ?>

    });
</script>