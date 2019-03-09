<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//pr($lista_unidades);
?>
<div id="div_tabla_reporte_general_encuestas">
    <!--Mostrará la tabla de actividad docente --> 
    <table class="table table-striped table-hover table-bordered " id="tabla_reporte_gral_encuestas">
        <thead>
            <tr class="bg-info">
                <th>Clave curso</th>
                <th>Tipo de curso</th>
                <th>Curso</th>
                <th>Grupo</th>
                <th>Bloque</th>
                <th>A-TT</th>
                <th>TT-CT</th>
                <th>CT-CC</th>
                <th>CT-TT</th>
                <th>CC-CT</th>
                <!--<th>Opciones</th>-->
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>suma:280.545% <br> promedio:93.515%</td>
                <td>suma:98.134% <br> promedio:32.71%</td>
                <td>suma:78.965% <br> promedio:26.32%</td>
                <td>suma:154.410% <br> promedio:51.42%</td>
                <td>suma:87.350% <br> promedio:29.11%</td>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td>CES-DD-I2-15</td>
                <td>Curso</td>
                <td>Formación de Directivos en Salud</td>
                <td>QUINTANA ROO</td>
                <td>Bloque 2</td>
                <td>100%</td>
                <td>98.134</td>
                <td>--</td>
                <td>86.364%</td>
                <td>--</td>
            </tr>
            <tr>
                <td>CES-DD-I2-15</td>
                <td>Curso</td>
                <td>Formación de Directivos en Salud</td>
                <td>MICHOACAN</td>
                <td>Bloque 3</td>
                <td>91.071%</td>
                <td>--</td>
                <td>78.965%</td>
                <td>--</td>
                <td>87.350%</td>
            </tr>
            <tr>
                <td>CES-DPDESBL-I2-15</td>
                <td>Curso</td>
                <td>Profesionalización Docente para la Educación en Salud</td>
                <td>GUANAJUATO 1</td>
                <td>Bloque 4</td>
                <td>85.43%</td>
                <td>67.349%</td>
                <td>78.965%</td>
                <td>65.98%</td>
                <td>84.1%</td>
            </tr>
        </tbody>
    </table>
</div>

