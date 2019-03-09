
<?php
if (isset($encuestas) && !empty($encuestas)) {
    $this->config->load('general');
    $tipo_msg = $this->config->item('alert_msg');

    $status_success = $this->session->flashdata('success');
    $status_warning = $this->session->flashdata('warning');

    if ($status_success == TRUE) {
        echo "<br><br><br><div class='clearfix'>" . html_message($status_success, $tipo_msg['SUCCESS']['class']) . "</div>";
    }
    if ($status_warning == TRUE) {
        echo "<br><br><br><div class='clearfix'>" . html_message($status_warning, $tipo_msg['WARNING']['class']) . "</div>";
    }
    ?>


    <div class="table-responsive">
        <table class="table table-hover table-bordered table-moodle">
            <thead>
                <tr>
                    <th>Folio instrumento</th>
                    <th>Nombre instrumento</th>
                    <!--<th>Curso tutorizados</th>   -->
                    <th>Rol a evaluar</th>
                    <th>Rol evaluador</th>
                    <th>Aplica para bono</th>
                    <th>Curso tutorizado</th>
                    <th>Tiene evaluaciones</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $check_ok = '<span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"> </span>';
                $check_no = '<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"> </span>';
                //echo $check_ok;
                //pr($encuestas);
                foreach ($encuestas as $key => $val) {
                    $editar = $duplicar = $eliminar = $activar = $desactivar = $ver_encuesta = $descargar_cvs = $descargar_pdf = '';
                    $id_accion = $this->acceso->get_permiso_accion(En_modulos::EDITAR_INSTRUMENTO);
                    if ($id_accion > -1) {
                        $editar = '<a href="' . site_url($secciones_acceso[$id_accion]['url'] . '/' . $val['encuesta_cve']) . '" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="' . $secciones_acceso[$id_accion]['nombre'] . '">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>';
                    }
                    $id_accion = $this->acceso->get_permiso_accion(En_modulos::DUPLICAR_INSTRUMENTO);
                    if ($id_accion > -1) {
                        $duplicar = '<a onclick="dup_encuesta(' . $val['encuesta_cve'] . ');" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="' . $secciones_acceso[$id_accion]['nombre'] . '">
                                        <span class="glyphicon glyphicon-duplicate"></span>
                                    </a>';
                    }
                    $id_accion = $this->acceso->get_permiso_accion(En_modulos::ELIMINAR_INSTRUMENTO);
                    if ($id_accion > -1) {
                        $eliminar = '<a onclick="drop_encuesta(' . $val['encuesta_cve'] . ');" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="' . $secciones_acceso[$id_accion]['nombre'] . '">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>';
                    }

                    $id_accion = $this->acceso->get_permiso_accion(En_modulos::ACTIVAR_INSTRUMENTO);
                    if ($id_accion > -1) {
                        $activar = '<a onclick="unlock_encuesta(' . $val['encuesta_cve'] . ');" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="' . $secciones_acceso[$id_accion]['nombre'] . '">
                                        <span class="glyphicon glyphicon-off"></span>
                                    </a>';
                    }
                    $id_accion = $this->acceso->get_permiso_accion(En_modulos::DESACTIVAR_INSTRUMENTO);
                    if ($id_accion > -1) {
                        $desactivar = '<a onclick="block_encuesta(' . $val['encuesta_cve'] . ');" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="' . $secciones_acceso[$id_accion]['nombre'] . '">
                                        <span class="glyphicon glyphicon-off"></span>
                                    </a>';
                    }
                    $lock_unlock = (($val['status'] == TRUE) ? $desactivar : $activar );
                    $id_accion = $this->acceso->get_permiso_accion(En_modulos::VER_INSTRUMENTO);
                    if ($id_accion > -1) {
                        $ver_encuesta = '<a href="' . site_url($secciones_acceso[$id_accion]['url'] . '/' . $val['encuesta_cve']) . '" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="' . $secciones_acceso[$id_accion]['nombre'] . '">
                            <span class="glyphicon glyphicon-search"></span>
                        </a>';
                    }

                    $id_accion = $this->acceso->get_permiso_accion(En_modulos::EXPORTA_INSTRUMENTO_CSV);
                    if ($id_accion > -1) {
                        $descargar_cvs = '<a href="' . site_url($secciones_acceso[$id_accion]['url'] . '/' . $val['encuesta_cve']) . '" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="' . $secciones_acceso[$id_accion]['nombre'] . '">
                            <span class="glyphicon glyphicon-export"></span>
                        </a>';
                    }
                    $id_accion = $this->acceso->get_permiso_accion(En_modulos::EXPORTA_INSTRUMENTO_PDF);
                    if ($id_accion > -1) {
                        $descargar_pdf = '<a href="' . site_url($secciones_acceso[$id_accion]['url'] . '/' . $val['encuesta_cve']) . '" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="' . $secciones_acceso[$id_accion]['nombre'] . '">
                            <span class="glyphicon glyphicon-open"></span>
                        </a>';
                    }


                    //$duplicar = '';
                    //$desactivar = '';
                    // '.site_url('encuestas/block/
                    // '.site_url('encuestas/copy/
                    //
                    //$info_curso = json_encode($val);
                    $evaluaciones = (isset($val['tiene_evaluaciones']) && $val['tiene_evaluaciones'] == 0) ? 'bg-success' : 'bg-warning';
                    $row_color = (isset($val['status']) && $val['status'] == 1 ) ? $evaluaciones : 'bg-warning';


                    echo '<tr class="' . $row_color . '">
                    <td >' . $val['cve_corta_encuesta'] . '</td>
                    <td >' . $val['descripcion_encuestas'] . '</td>

                    <td >' . $val['rol_evaluar'] . '</td >
                    <td >' . $val['rol_evaluador'] . '</td >
                    <td ><h4><a>' . (($val['is_bono'] == TRUE) ? $check_ok : $check_no) . '</a></h4></td >
                    <td ><h4><a>' . (($val['tutorizado'] == TRUE) ? $check_ok : $check_no) . '</a></h4></td >
                    <td ><h4><a>' . (($val['tiene_evaluaciones'] > 0) ? $check_ok : $check_no) . '</a></h4></td >
                    <td ><h4><a>' . (($val['status'] == TRUE) ? $check_ok : $check_no) . '</a></h4></td >
                    <td class="bg-primary tabla-acciones"> ' .
                    $ver_encuesta
                    . $descargar_cvs
                    . $descargar_pdf
                    . ((isset($val['tiene_evaluaciones']) && $val['tiene_evaluaciones'] == 0) ? $editar . ' ' . $eliminar : $duplicar . ' ' . $lock_unlock ) . '

                    </td>
                    ';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

    </div>
<?php } else { ?>
    <br><br>
    <div class="row">
        <div class="jumbotron"><div class="container"> <p class="text_center">No se encontraron datos registrados con esta busqueda</p> </div></div>
    </div>

<?php } ?>

<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

</script>
