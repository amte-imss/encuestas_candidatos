<?php if (isset($evaluaciones) && !empty($evaluaciones)) { 
//echo form_open('cursoencuesta/guardar_asociacion', array('id'=>'form_asignar', 'class'=>'form-horizontal'));
//pr($empleado);

  ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>Nombre usuario evaluador</th>
                    <th>Rol evaluador</th>
                    <th>Nombre docente evaluado</th>
                    <th>Rol evaluado</th>
                    <th>Grupo</th>
                    <th>Calificaci&oacute;n de encuesta</th>
                                    

                </tr>
            </thead>
            <tbody>
                <?php
//                    <th>Bloque</th>
//                    <td > ' . $val['bloque'] . '</td >
                
                foreach ($evaluaciones as $key => $val) {
                    echo '<tr>
                    <td >' .htmlentities($val['nombreevaluador']) . '</td>
                    <td >' . $val['nrolevaluador'].'</td >
                    <td >' .htmlentities($val['nombre']) . ' '. htmlentities($val['apellidos']). '</td>
                    <td > ' . $val['nrolevaluado'] . '</td >
                    <td > ' . $val['ngrupo'] . '</td >
                    <td > ' . $val['calif_emitida'] . '</td >'; 
                    

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

<?php } 

 
?>

<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('#btn_export').show();
});
</script>