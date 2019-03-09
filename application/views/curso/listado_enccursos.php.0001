<?php
if (isset($empleados) && !empty($empleados)) {
    if (exist_and_not_null($error)) {
        echo '<div class="row">
                        <div class="col-md-10 col-sm-10 col-xs-10 alert alert-danger">
                        ' . $error . '
                        </div>
                    </div>';
    }

    $this->config->load('general');
    $tipo_msg = $this->config->item('alert_msg');

    if (($status_accion = $this->session->flashdata('success')) != null) {
        echo '<br><br><br>' . html_message($status_accion, $tipo_msg['SUCCESS']['class']);
    }
    if (($status_accion = $this->session->flashdata('danger')) != null) {
        echo '<br><br><br>' . html_message($status_accion, $tipo_msg['DANGER']['class']);
    }

//echo form_open('cursoencuesta/guardar_asociacion', array('id'=>'form_asignar', 'class'=>'form-horizontal'));

    $check_ok = '<span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"> </span>';
    $check_no = '<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"> </span>';

    $eliminar_instrumento = $id_accion = $this->acceso->get_permiso_accion(En_modulos::DES_ASOCIAR_ENCUESTA_CURSO);
    $asociar_instrumento = $id_accion = $this->acceso->get_permiso_accion(En_modulos::ASOCIAR_ENCUESTA_SELECCIONADAS_CURSO);
    ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <?php
                    if ($asociar_instrumento) {
                        echo '<th></th>';
                    }
                    ?>
                    <th>Folio instrumento</th>
                    <th>Nombre instrumento</th>
                    <th>Rol evaluador</th>
                    <th>Rol evaluado</th>
                    <th>Tutorizado</th>
                    <th>Bono</th>
                    <th>Asignado</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($empleados as $key => $val) {
                    $desactivar = $pinta_check = '';
                    if ($eliminar_instrumento > -1) {
                        $desactivar = '<a onclick="desasociar_encuesta(' . $val['encuesta_cve'] . ');" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Desasociar instrumento">
                                        <span class="glyphicon glyphicon-off"></span>
                                    </a>';
                    }
                    if ($asociar_instrumento > -1) {
                        $pinta_check = '<td > <input type = "checkbox" name = "encuestacve[]" id = "encuestacve[]" value = "' . $val['encuesta'] . '"></td>';
                    }
                    echo '<tr>' .
                    $pinta_check .
                    '<td >' . $val['encuestaclavecorta'] . '</td>
                    <td >' . $val['descrip'] . '</td >
                    <td > ' . $val['evaluador'] . '</td >
                    <td >' . $val['evaluado'] . '</td>
                    <td ><h4>' . (($val['tutorizado'] == 1 ) ? $check_ok : $check_no) . '</td >
                    <td> <h4>' . (($val['bono'] == 1) ? $check_ok : $check_no) . '</h4> </td >
                    <td> <h4>' . (($val['asig'] == 1) ? $check_ok : $check_no) . '</h4> </td >
                    <td > <h4>' . (($val['estatus'] == 1 ) ? $check_ok : $check_no) . '</td >
                    <td><a data-toggle="modal" data-target="#modal_censo" onclick="data_ajax(\'' . site_url('modal/mod_encuestas/' . $val['encuesta']) . '\', \'null\', \'#modal_censo\');" class="btn btn-info btn-block">  <span class="glyphicon glyphicon-search"></span></a>
                    ' . ((isset($val['asig']) && $val['asig'] == 1) ? $desactivar : '') . '
                    </td>
                    ';



                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <input type="hidden" id="curso" name="curso" value="<?php echo $curso ?>">

        <div class="form-group text-center">
            <?php
            /* echo $this->form_complete->create_element(array(
              'id' => 'btn_submit',
              'type' => 'button',
              'value' => 'Asociar',
              'attributes' => array(
              'class' => 'btn btn-primary'
              ),
              'onclick'=>"data_ajax(site_url+'/cursoencuesta/get_data_ajax/'+".$curso.", '#form_asignar', '#listado_resultado')"
              )); */

            /* echo $this->form_complete->create_element(array('id'=>'btn_submit',
              'type'=>'button',  'value' => 'Asociar'

              )); */


            /* echo $this->form_complete->create_element(array(
              'id' => 'btn_submit',
              'type' => 'button',
              'value' => 'Asociar',
              'attributes' => array(
              'class' => 'btn btn-primary',
              'onclick'=>"data_ajax(site_url+'/cursoencuesta/get_data_ajax/'+".$curso.", '#form_asignar', '#listado_resultado')"
              ),

              )); */

            //echo form_close();
            ?>
        </div>



    </div>
<?php } else { ?>
    <br><br>
    <div class="row">
        <div class="jumbotron"><div class="container"> <p class="text_center">No se encontraron datos registrados con esta busqueda</p> </div></div>
    </div>

<?php }
?>
<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

</script>
