<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//pr($reglas_evaluacion);
//pr($result);
//pr($result_promedio);
?>
<!--<div id="div_y" style="overflow-y: auto; height: 700px;">-->
<div id="div_y" style="width:900px; height:500px; overflow: scroll;">
<!--<div class="col-lg-12 col-md-6 col-sm-3">-->
<!--<div class="col-lg- col-md-6 col-sm-3">-->
    <!--<div id="div_tabla_reporte_general_encuestas" style="overflow-x: auto; width: 1000px;">-->
        <!--Mostrará la tabla de actividad docente --> 
        <table class="table table-hover table-bordered table-responsive" id="tabla_reporte_gral_encuestas">
            <thead>
                <tr class="bg-info">
                    <th>Clave curso</th>
                    <th>Curso</th>
                    <th>Tipo implementación</th>
                    <th>Tipo</th>
                    <th>Aplica para bono</th>
                    <!--<th>Bloque</th>-->
                    <!--<th>Grupo</th>-->
                    <th>Matricula</th>
                    <th>Nombre evaluado</th>    
                    <th>Rol evaluado</th>
                    <th>Región</th>
                    <th>Delegación</th>
                    <th>Clave de Adscripción</th>
                    <?php if (!empty($reglas_evaluacion)) { ?>
                        <?php foreach ($reglas_evaluacion as $val) {
                            ?>
                            <th><?php echo $val; ?></th>
                        <?php } ?>
                    <?php } ?>
<!--<th>Opciones</th>-->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $key => $val) { ?>

                    <?php
                    $rama = $val['rama_ads_evaluado'];
                    $text_rama_adsc[0] = ' ';
                    if(!empty($rama)){
                        $a_depto_rama_evaluador = explode(":", $rama);
//                        pr($rama);
//                        pr($a_depto_rama_evaluador);
                        $text_rama_adsc = (isset($a_depto_rama_evaluador[2])) ? explode("&", $a_depto_rama_evaluador[2]) : array('');
                    }
//                    pr($rama);
                    $grupo = isset($val['mdl_groups_cve']) ? $val['mdl_groups_cve'] : '--';
                    $bloque = isset($val['bloque']) ? $val['bloque'] : '--';
                    $bono = ($val['is_bono'] == 1) ? 'Si' : 'No';
                    echo "<tr id='id_row_" . $key . "' data-keyrow=" . $key . ">";
                    echo "<td>" . $val['clave'] . "</td>";
                    echo "<td>" . $val['namec'] . "</td>";
                    echo "<td>" . $val['tipo_curso'] . "</td>";
                    echo "<td>" . $val['tex_tutorizado'] . "</td>";
                    echo "<td>" . $bono . "</td>";
//                echo "<td>" . $bloque . "</td>";
//                echo "<td>" . $grupo . "</td>";
                    echo "<td>" . $val['username'] . "</td>";
                    echo "<td>" . $val['name_evaluado'] . "</td>";
                    echo "<td>" . $val['name_rol_evaluado'] . "</td>";
                    echo "<td>" . $val['name_region'] . "</td>";
                    echo "<td>" . $val['nom_delegacion'] . "</td>";
                    echo "<td>" . $val['cve_depto_adscripcion'] . ' ' . $text_rama_adsc[0] . "</td>";

//                pr($result_promedio);

                    if (!empty($reglas_evaluacion)) {
                        foreach ($reglas_evaluacion as $key_rol => $vp) {
//                        if (isset($val['mdl_groups_cve']) AND isset($val['bloque']) AND isset($result_promedio[$val['course_cve']][$val['evaluado_user_cve']][$val['tutorizado']][$key_rol][$val['bloque']][$val['mdl_groups_cve']])) {
//                            echo "<td>" . $result_promedio[$val['course_cve']][$val['evaluado_user_cve']][$val['tutorizado']][$key_rol][$val['bloque']][$val['mdl_groups_cve']]['promedio'] . " %</td>";
//                        } else if (isset($val['bloque']) AND isset($result_promedio[$val['course_cve']][$val['evaluado_user_cve']][$val['tutorizado']][$key_rol][$val['bloque']])) {
//                            echo "<td>" . $result_promedio[$val['course_cve']][$val['evaluado_user_cve']][$val['tutorizado']][$key_rol][$val['bloque']]['promedio'] . " %</td>";
//                        } else if (isset($result_promedio[$val['course_cve']][$val['evaluado_user_cve']][$key_rol])) {
//                            echo "<td>" . $result_promedio[$val['course_cve']][$val['evaluado_user_cve']][$key_rol]['promedio'] . " %</td>";
//                        } else {
//                            echo "<td> </td>";
//                        }
                            if (isset($result_promedio[$val['course_cve']][$val['evaluado_user_cve']][$key_rol])) {
                                echo "<td>" . $result_promedio[$val['course_cve']][$val['evaluado_user_cve']][$key_rol]['promedio'] . " %</td>";
                            } else {
                                echo "<td> </td>";
                            }
                        }
                    }
                    echo "<tr>";
                    ?>
                <?php } ?>
            </tbody>
    <!--        <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>-->
        </table>
    <!--</div>-->
</div>

