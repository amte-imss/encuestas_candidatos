<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<table>
    <thead>
        <tr>
            <?php
            foreach ($head as $encabezado) {
                if($encabezado!="INSTRUCCIONES")
                {
                    echo '<th>'.$encabezado.'</th>';
                }
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if(!empty($data)){
            foreach ($data as $datos) {
                echo '<tr>';
                foreach ($head as $encabezado) {
                    if($encabezado!="INSTRUCCIONES")
                    {
                        $cadena = $datos[$encabezado];
                        switch ($encabezado) {
                            case 'ROL_A_EVALUAR':
                            case 'ROL_EVALUADOR':
                            case 'FOLIO_INSTRUMENTO':
                            case 'NOMBRE_SECCION':
                                $cadena = strtoupper($cadena);
                                $cadena = str_replace(' ', '_', $cadena);
                                break;
                            default:
                                break;
                        }
                        $pos = strpos($this->input->server('HTTP_USER_AGENT'), 'Linux');
                        if($pos !== false)
                        {
                            echo '<td>'.utf8_decode($cadena).'</td>';
                        }else{
                            echo '<td>'.($cadena).'</td>';
                        }

                    }
                }
                echo '</tr>';
            }
        } else {
            echo '<tr><td>No existen registros relacionados con esos parámetros de búsqueda.</td></tr>';
        } ?>
    </tbody>
</table>
