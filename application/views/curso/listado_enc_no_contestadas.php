<?php
$bloque = '';
if (isset($evaluaciones) && !empty($evaluaciones)) {
//echo form_open('cursoencuesta/guardar_asociacion', array('id'=>'form_asignar', 'class'=>'form-horizontal'));
//pr($empleado);
    ?>
    <div class="col-sm-12 col-md-12 col-lg-12 text-danger text-left">Las celdas marcadas con * indican que esos datos derivan de una autoevaluación.</div>
    <div id="div_y" style="width:900px; height:500px; overflow: scroll;">
        <!--<div class="table-responsive">-->
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Matr&iacute;cula del evaluador</th>
                        <th>Nombre usuario evaluador</th>
                        <th>Rol evaluador</th>
                        <th>Categor&iacute;a evaluador</th>
                        <th>Unidad evaluador</th>
                        <th>Regi&oacute;n evaluador</th>
                        <th>Delegaci&oacute;n evaluador</th>
                        <th>Matr&iacute;cula del evaluado</th>
                        <th>Nombre docente evaluado</th>
                        <th>Rol evaluado</th>
                        <th>Categor&iacute;a evaluado</th>
                        <th>Unidad evaluado</th>
                        <th>Regi&oacute;n evaluado</th>
                        <th>Delegaci&oacute;n evaluado</th>
                        <th>Fol&iacute;o de la encesta</th>
                        <th>Nombre de la encuesta</th>
                        <th>Grupo(s)</th>
                        <?php if ($tutorizado == 1) { ?>
                            <th>Bloque</th>
                        <?php } ?>


                    </tr>
                </thead>
                <tbody>
                    <?php
//                    <th>Bloque</th>
//                    <td > ' . $val['bloque'] . '</td >

                    foreach ($evaluaciones as $key => $val) {
                        $bloque = '';
                        if ($tutorizado == 1) {
                            $bloque = '<td >' . $val['bloque'] . '</td >';
                            $grupos = $val['names_grupos']; //Agrega el nombre de todos los grupos de un  bloque 
//                        if ($val['group_id'] == 0 and isset($val['name_grupos'])) {//Valida la encuesta no haya sido evaluada por bloque
//                        }
                        } else {
                            $grupos = $val['names_grupos']; //Asigna el nombre del grupo 
                        }

                        if ($val['rid_dor'] == En_roles::ALUMNO) {//Verifica si es un alumno o pertenece a la plana docente
                            $region_dor = $val['regpre_dor'];
                            $delegacion_dor = $val['delpre_dor'];
                            $categoria_dor = $val['clave_catpre_dor'] . '-' . $val['name_catpre_dor'];
                            $departamento_dor = $val['departpre_dor'];
                        } else {
                            $region_dor = $val['reg_dor'];
                            $delegacion_dor = $val['delegacion_dor'];
                            $categoria_dor = $val['clave_cattut_dor'] . '-' . $val['name_cattut_dor'];
                            $departamento_dor = $val['depart_dor'];
                        }
                        //En caso de autoevaluaciones con datos
                        $marca_autoeva = '';
                        if(isset($val['autoeva_user_cve']) && !empty($val['autoeva_user_cve'])){
                            //pr($val);
                            $val['matricula_dor'] = '<span class="text-danger">*</span> '.$val['autoeva_username'];
                            $val['nom_evaluador'] = '<span class="text-danger">*</span> '.$val['autoeva_nombre'].' '.$val['autoeva_apellido'];
                            $val['rolname_dor'] = '<span class="text-danger">*</span> '.$val['autoeva_rol_nombre'];
                            $region_dor = '<span class="text-danger">*</span> '.((!empty($val['autoeva_name_region'])) ? $val['autoeva_name_region'] : '');
                            $delegacion_dor = '<span class="text-danger">*</span> '.((!empty($val['autoeva_nom_delegacion'])) ? $val['autoeva_nom_delegacion'] : '');
                            $categoria_dor = '<span class="text-danger">*</span> '.((!empty($val['autoeva_cat_nombre'])) ? $val['autoeva_cat_nombre'] : '');
                            $departamento_dor = '<span class="text-danger">*</span> '.((!empty($val['rama_tut_autoevaluacion'])) ? $val['rama_tut_autoevaluacion'] : '');
                        } else {
                            if($val['matricula_dor'] == $val['matricula_do']){
                                $marca_autoeva = '<span class="text-danger">*</span> ';
                            }
                        }

                        echo '<tr>
                            <td >' . $marca_autoeva.$val['matricula_dor'] . '</td>
                            <td >' . $marca_autoeva.$val['nom_evaluador'] . '</td >
                            <td >' . $marca_autoeva.$val['rolname_dor'] . '</td >
                            <td >' . $marca_autoeva.$categoria_dor . '</td >
                            <td >' . $marca_autoeva.$departamento_dor . '</td >
                            <td >' . $marca_autoeva.$region_dor . '</td >
                            <td >' . $marca_autoeva.$delegacion_dor . '</td >
                            <td >' . htmlentities($val['matricula_do']) . '</td>
                            <td >' . $val['nom_evaluado'] . '</td>
                            <td >' . $val['rolname_do'] . '</td>
                            <td >' . $val['name_cattut_do'] . '</td >
                            <td >' . htmlentities($val['depart_do']) . '</td >
                            <td >' . htmlentities($val['reg_do']) . '</td >
                            <td >' . htmlentities($val['del_do']) . '</td > 
                            <td >' . htmlentities($val['cve_corta_encuesta']) . '</td > 
                            <td >' . htmlentities($val['descripcion_encuestas']) . '</td > 
                            <td >' . $grupos . '</td >' .
                        $bloque
                        ;
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>

        <!--</div>-->
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12 text-danger text-left">Las celdas marcadas con * indican que esos datos derivan de una autoevaluación.</div>
<?php } else { ?>
    <br><br>
    <div class="row">
        <div class="jumbotron"><div class="container"> <p class="text_center">No se encontraron datos registrados con esta busqueda</p> </div></div>
    </div>

<?php }
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('#btn_export').show();
    });
</script>