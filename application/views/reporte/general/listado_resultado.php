<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="div_tabla_reporte_general_encuestas table-responsive" style="overflow-x: auto; width: 1200px;">
    <!--Mostrará la tabla de actividad docente --> 
    <table class="table table-striped table-hover table-bordered " id="tabla_reporte_gral_encuestas">
        <thead>
            <tr class="bg-info">
                <th>Clave de implementación</th>
                <th>Nombre de implementación</th>
                <th>Tipo</th>
                <th>Tipo de implementación</th>
                <th>Aplica para bono</th>
                <?php //pr($preguntas);
                if(!empty($reglas_evaluacion))
                {
                    foreach ($reglas_evaluacion as $val) 
                    {
                        echo '<th>'.$val.'</th>';
                    }
                } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if(!empty($datos)){
                foreach ($datos as $key_d => $dato) {
                    $bono = ($dato['is_bono'] == 1) ? 'Si' : 'No';
                    echo "<tr>"
                            . "<td>" . $dato['clave'] . "</td>"
                            . "<td>" . $dato['namec'] . "</td>"
                            . "<td>" . $dato['tipo_curso'] . "</td>"
                            . "<td>" . $dato['tex_tutorizado'] . "</td>"
                            . "<td>" . $bono . "</td>";
                    if (!empty($reglas_evaluacion)) {
                        foreach ($reglas_evaluacion as $key_rol => $vp) {
                            if (isset($result_promedio['promedio'][$dato['course_cve']][$key_rol])) {
                                echo "<td>" . $result_promedio['promedio'][$dato['course_cve']][$key_rol]['promedio'] . " %</td>";
                            } else {
                                echo "<td> </td>";
                            }
                        }
                    }
                    echo "<tr>";
                }
            } else {
                echo '<tr><td colspan="21">No existen registros relacionados con esos parámetros de búsqueda.</td></tr>';
            } ?>
        </tbody>
    </table>
</div>

