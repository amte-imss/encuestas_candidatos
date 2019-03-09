<a href="<?php echo site_url('encuestas'); ?>" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-list" aria-hidden="true"> </span> Ver listado de instrumentos </a>
<br>
<div class="clearfix"></div>
<div class="panel panel-amarillo">
    <div class="panel-body">
        <?php   if (isset($preguntas) && !empty($preguntas) && isset($instrumento) && !empty($instrumento)) {

            $pencil='<span class="glyphicon glyphicon-pencil" aria-hidden="true"> </span>';
            $remove='<span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>';
            $check_ok = '<span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"> </span>';
            $check_no = '<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"> </span>';
        ?>

        <div id="detalle_instrumento">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td><label>Nombre del instrumento:</label></td>
                        <td colspan="4"><h3><?php echo $instrumento[0]['descripcion_encuestas']; ?></h3></td>
                    </tr>
                    <tr>
                        <td><label>Rol a evaluar:</label></td>
                        <td><label>Rol evaluador:</label></td>
                        <td><label>Aplica para bonos:</label></td>
                        <td><label>Curso tutorizado:</label></td>
                        <td><label>Activo:</label></td>
                    </tr>
                    <tr>
                        <td><h4><?php echo $instrumento[0]['name']; ?></h4></td>
                        <td><h4><?php echo $instrumento[0]['evaluador']; ?></h4></td>
                        <td><h4><a><?php echo ($instrumento[0]['is_bono'] != 0) ? $check_ok : $check_no;  ?></a></h4></td>
                        <td><h4><a><?php echo ($instrumento[0]['tutorizado'] != 0) ? $check_ok : $check_no; ?></a></h4></td>
                        <td><h4><a><?php echo ($instrumento[0]['status'] != 0) ? $check_ok : $check_no; ?></a></h4></td>
                    </tr>
                </table>
            </div>
            <a href="<?php echo site_url('encuestas/edita_instrumento/'.$instrumento[0]['encuesta_cve']); ?>" class="btn  btn-moodle"><span class="glyphicon glyphicon-pencil" aria-hidden="true"> </span> Modificar detalles instrumento</a>
            <!--<a href="<?php //echo site_url('seccion/secciones/'.$instrumento[0]['encuesta_cve']); ?>" class="btn btn-warning"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"> </span> Agregar sección</a>-->
            <a href="<?php echo site_url('encuestas/nueva_pregunta/'.$instrumento[0]['encuesta_cve']); ?>" class="btn  btn-moodle"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"> </span> Agregar nueva pregunta</a>
                    
            <br>
        </div>

        <div id="preguntas_instrumento">

                <?php

                $seccion=0;
                $pregunta=0;                
                $no_pregunta=1;
                foreach ($preguntas as $key => $val) {

                    if ($seccion!==$val['seccion_cve']) {
                        if($val['descripcion'] != 'NA'){
                            echo '<br><h4># '.$val['descripcion'].'</h4>';
                        }
                            echo '<a href="'.site_url('encuestas/ordenar_preguntas/'.$instrumento[0]['encuesta_cve']).'/'.$val['seccion_cve'].'" class="btn btn-link"><span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"> </span> Modificar orden preguntas</a><br>';
                    }

                    if ($pregunta !== $val['preguntas_cve']) {
                        echo '<br><b>
                            <h5>'.$no_pregunta.' - '.$val['pregunta'].'</h5>
                            </b>
                            <a href="'.site_url('encuestas/edita_pregunta/'.$val['preguntas_cve'].'/'.$val['encuesta_cve']).'" class="text-warning">'.$pencil.' Editar</a>
                            |<a class="text-danger" onclick="elimina_pregunta('.$val['preguntas_cve'].','.$val['encuesta_cve'].');">'.$remove.' Eliminar</a>
                        <br>';
                        $no_pregunta++;
                    }

                    //echo '<label><!--<input type="radio" name="'.$val['preguntas_cve'].'"> -->'.$val['texto']."</label><br>";

                    $seccion=$val['seccion_cve'];
                    $pregunta=$val['preguntas_cve'];
                    
                }
                
                ?>
                
                </div>
                <br>
                
                <?php

        } else { 

?>
            <br><br>
            <div class="row">
                <div class="jumbotron"><div class="container"> <p class="text_center">No se encontraron datos registrados en esta busqueda</p> </div></div>
            </div>

<?php 

        } 

?>
    </div>
</div>


<script type="text/javascript">
    function elimina_pregunta(pregunta=null, encuesta=null) {        
        if (confirm('Esta a punto de eliminar esta pregunta, ¿Desea continuar?')) {
                data_ajax(site_url + "/encuestas/delete_data_ajax_pregunta/" + pregunta + "/"+encuesta, 'null', "#preguntas_instrumento");
            }
    }

</script>
