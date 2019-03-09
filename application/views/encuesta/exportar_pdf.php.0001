<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($head) and isset($data) and !empty($data))
{
    ?>
    <table width="100%">
        <tr>
            <td colspan="2" align="center"><h1><?php echo (isset($data[0]['NOMBRE_INSTRUMENTO'])) ? $data[0]['NOMBRE_INSTRUMENTO'].' ('.$data[0]['FOLIO_INSTRUMENTO'].')' : ''; ?></h1></td>
        </tr>
        <tr>
            <td align="right">Rol a evaluar:</td><td><b><?php echo (isset($data[0]['ROL_A_EVALUAR'])) ? mb_strtoupper($data[0]['ROL_A_EVALUAR'], 'UTF-8') : ''; ?></b></td>
        </tr>
        <tr>
            <td align="right">Rol evaluador:</td><td><b><?php echo (isset($data[0]['ROL_EVALUADOR'])) ? mb_strtoupper($data[0]['ROL_EVALUADOR'], 'UTF-8') : ''; ?></b></td>
        </tr>
        <tr>
            <td align="right">Tutorizado:</td><td><b><?php echo (isset($data[0]['TUTORIZADO'])) ? $data[0]['TUTORIZADO'] : ''; ?></b></td>
        </tr>
        <tr>
            <td align="right">Tipo de instrumento:</td><td><b><?php echo (isset($data[0]['TIPO_INSTRUMENTO']) and $data[0]['TIPO_INSTRUMENTO']=='DESEMPENIO') ? 'DESEMPEÑO' : 'SATISFACCIÓN'; ?></b></td>
        </tr>
        <tr>
            <td align="right">Tipo de evaluación:</td><td><b><?php echo (isset($data[0]['EVA_TIPO'])) ? str_replace('_',' ',$data[0]['EVA_TIPO']) : ''; ?></b></td>
        </tr>
        <tr>
            <td align="right">Instrucciones:</td><td><b><?php echo (isset($data[0]['INSTRUCCIONES'])) ? str_replace('_',' ',$data[0]['INSTRUCCIONES']) : ''; ?></b></td>
        </tr>
    </table>
    <table width="100%" style="border: 1px solid gray;">
        <thead>
            <tr style="background-color: green; color: white;">
                <th>Sección</th>
                <th>Indicador</th>
                <th>Numeración</th>
                <th>Pregunta</th>
                <th>Aplica para bono</th>
                <th>No aplica / No envío de mensaje</th>
                <th>Válido no aplica</th>
                <th>Opciones de respuesta</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(!empty($data)){
                $i=0;
                foreach ($data as $datos) {
                    $row = (($i%2)==0) ? 'style="background-color:#dff0d8"' : '';
                    echo '<tr>'
                            . '<td '.$row.'>'.$datos['NOMBRE_SECCION'].'</td>'
                            . '<td '.$row.'>'.$datos['NOMBRE_INDICADOR'].'</td>'
                            . '<td '.$row.'>'.$datos['NO_PREGUNTA'].'</td>'
                            . '<td '.$row.'>'.$datos['PREGUNTA'].'</td>'
                            . '<td '.$row.'>'.$datos['PREGUNTA_BONO'].'</td>'
                            . '<td '.$row.'>'.(($datos['NO_APLICA']=='SI')?'NO APLICA':(($datos['NO_ENVIO_MENSAJE']=='SI')?'NO ENVÍO DE MENSAJE':'')).'</td>'
                            . '<td '.$row.'>'.$datos['VALIDO_NO_APLICA'].'</td>'
                            . '<td '.$row.'>'.(($datos['SI']=='SI')?'SI, NO':(($datos['SIEMPRE']=='SI')?'SIEMPRE, CASI SIEMPRE, ALGUNAS VECES, CASI NUNCA, NUNCA': (($datos['RESPUESTA_ABIERTA']=='SI')?'RESPUESTA ABIERTA':'' ) ) ).'</td>'
                        . '</tr>';
                    $i++;
                }
            } else {
                echo '<tr><td>No existen registros relacionados con esos parámetros de búsqueda.</td></tr>';
            } ?>
        </tbody>
    </table>
    <?php
} else {
    echo 'No existen datos disponibles para el instrumento solicitado';
}
?>


