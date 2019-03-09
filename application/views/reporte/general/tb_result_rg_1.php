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
                <th>Fecha de inicio</th>
                <th>Grupo</th>
                <th>Bloque</th>
                <th>Matricula</th>
                <th>Nombre evaluado</th>    
                <th>Rol evaluado</th>
                <th>A-TT</th>
                <th>TT-CT</th>
                <th>CT-CC</th>
                <th>CT-TT</th>
                <th>CC-CT</th>
                <th></th>
                <!--<th>Opciones</th>-->
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>CES-DD-I2-15</td>
                <td>Curso</td>
                <td>Formación de Directivos en Salud</td>
                <td>2015-03-17 00:00:00-06</td>
                <td>QUINTANA ROO</td>
                <td>Bloque <?php echo rand (1, 5);?></td>
                <td>9344829</td>
                <td>Rosa María Yáñez González</td>
                <td>Tutor Titular</td>
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
                <td>2015-05-18 00:00:00-06</td>
                <td>MORELOS</td>
                <td>Bloque <?php echo rand (1, 5);?></td>
                <td>99350573</td>
                <td>Aurea Atanacia Barreto González</td>
                <td>Tutor Titular</td>
                <td>89.474%</td>
                <td>--</td>
                <td>--</td>
                <td>67.897</td>
                <td>--</td>
            </tr>
             <tr>
                <td>CES-DD-I2-15</td>
                <td>Curso</td>
                <td>Formación de Directivos en Salud</td>
                <td>2015-05-18 00:00:00-06</td>
                <td>MICHOACAN</td>
                <td>Bloque <?php echo rand (1, 5);?></td>
                <td>99324079</td>
                <td>Sergio Humberto Martínez López</td>
                <td>Tutor Titular</td>
                <td>91.071%</td>
                <td>--</td>
                <td>78.965%</td>
                <td>--</td>
                <td>87.350%</td>
            </tr>
        </tbody>
        <tfoot>
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
                <td>suma:280.545% <br> promedio:93.515%</td>
                <td>suma:98.134% <br> promedio:32.71%</td>
                <td>suma:78.965% <br> promedio:26.32%</td>
                <td>suma:154.410% <br> promedio:51.42%</td>
                <td>suma:87.350% <br> promedio:29.11%</td>
            </tr>
        </tfoot>
    </table>
</div>

