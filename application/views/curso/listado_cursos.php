<?php 

if (isset($empleados) && !empty($empleados)) { 

$check_ok = '<h4><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"> </span></h4>';
$check_no = '<h4><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"> </span></h4>'; 

?>

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-moodle">
            <thead>
                <tr>
                    <th>Clave implementación</th>
                    <th>Nombre curso</th>
                    <!--<th>Categor&iacute;a</th>-->
                    <th>Año curso</th>
                    <th>Horas Curso</th>
                    <!--<th>Tipo curso</th>-->
                    <!--<th>Modalidad</th>-->
                    <th>Tutorizado</th>
                    <th>Bloques</th>
                    <th>Encuestas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                foreach ($empleados as $key => $val) {
                    
                    //$info_curso = json_encode($val);
                    /*echo '<tr>
                    <td >' . $val['cur_clave'] . '</td>
                    <td >' . $val['cur_nom_completo'].'</td > 
                    <td > ' . $val['cat_nom'] . '</td > 
                    <td >' . $val['anio'] . '</td>
                    <td >' . $val['horascur']. '</td > 
                    <td >' . $val['tutorizado']. '</td > 
                    <td>
                        <a href="'.site_url('curso/info/'.$val['cur_id']).'" class="btn btn-info btn-block">
                            <span class="glyphicon glyphicon-search"></span>
                        </a>
                    </td>
                    ';*/

//                    <td > ' . $val['cat_nom'] . '</td > 
//                    <td>'.substr(str_shuffle('-123456'), 0, 1).'</td>
                    echo '<tr>
                    <td >' . $val['cur_clave'] . '</td>
                    <td >' . $val['cur_nom_completo'].'</td > 
                    <td >' . $val['anio'] . '</td>
                    <td >' . $val['horascur']. '</td > 
                    <td >' . ((isset($val['tutorizado']) && $val['tutorizado'] == '1') ? $check_ok : $check_no) . '</td ><td>'
                            ;
                    if($val['tutorizado'] == '1' && $val['en_bloque'] == 1){
                        echo 'Asignados';
                    }else if($val['tutorizado'] == '1' && $val['en_bloque'] == 0){
                        echo 'Sin Asignar';
                    }else{
                        echo 'NA';
                    }
                    echo '<td ><p data-placement="left" data-toggle="tooltip" title   data-original-title="'.$val['encuestas_des'].'">'. $val['clave_encuestas']. '</p></td >';
//                    echo '<td ><span data-placement="left" data-toggle="popover" title  data-trigger="click hover" data-content="'.$val['encuestas_des'].'">'. $val['clave_encuestas']. '</span></td >';
                    echo '</td><td>
                        <a href="'.site_url('curso/info_curso/'.$val['cur_id']).'" class="btn btn-info btn-block">
                            <span class="glyphicon glyphicon-search"></span>
                        </a>
                    </td>
                    ';

                    echo '</tr>';
                }
                
                ?>
            </tbody >
        </table>
        
    </div>
<?php } else { ?>
    <br><br>
    <div class="row">
        <div class="jumbotron"><div class="container"> <p class="text_center">No se encontraron datos registrados con esta busqueda</p> </div></div>
    </div>

<?php } ?>
    
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip(); 
//  $('[data-toggle="popover"]').popover(); 
});
//$(document).ready(function(){
//});
</script>