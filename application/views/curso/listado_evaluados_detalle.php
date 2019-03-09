<?php if (isset($empleados) && !empty($empleados)) { 
//echo form_open('cursoencuesta/guardar_asociacion', array('id'=>'form_asignar', 'class'=>'form-horizontal'));
//pr($empleado);

  ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                   
                    <th>Nombre usuario evaluador</th>
                    <th>Rol evaluador</th>
                    <th>Clave departamental</th>
                    <th>Delegación</th>
                    <th>Nivel de atención</th>
                    <th>Adscripción</th>

                    <th>Nombre docente evaluado</th>
                    <th>Rol evaluado</th>
                    <th>Clave departamental</th>
                    <th>Delegación</th>
                    <th>Nivel de atención</th>
                    <th>Adscripción</th>

                    <th>Encuesta</th>
                    <th>Pregunta</th>
                    <th>Respuesta</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                foreach ($empleados as $key => $val) {

                    $ramaop=explode("&",$val['ramaevaluador']);
                    pr($ramaop);
                    foreach ($ramaop as $key => $value) {
                        echo $value;
                       
                        # code...
                    }

                    echo '<tr>
                    <td >' .htmlentities($val['evaluador']) . '</td>
                    <td >' .htmlentities($val['rolevaluador']).'</td >
                    <td >' .$val['cvedepevaluador'] .'</td>
                    <td > ' . htmlentities($val['rolevaluador']) . '</td >
                    <td > ' . htmlentities($val['rolevaluador']) . '</td >
                    <td > ' . htmlentities($val['rolevaluador']) . '</td >
                    

                    <td >' .htmlentities($val['evaluador']) . '</td>
                    <td >' .htmlentities($val['rolevaluador']).'</td >
                    <td >' .$val['cvedepevaluador'] .'</td>
                    <td > ' . htmlentities($val['rolevaluador']) . '</td >
                    <td > ' . htmlentities($val['rolevaluador']) . '</td >
                    <td > ' . htmlentities($val['rolevaluador']) . '</td >

                    <td >' .htmlentities($val['descripcion_encuestas']) . '</td>
                    <td >' . $val['orden'].'-'.htmlentities($val['pregunta']).'</td >
                    <td >' .htmlentities($val['respuesta']) . '</td>' ;

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