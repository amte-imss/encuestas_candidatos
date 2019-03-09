<?php
echo form_open('cursoencuesta/curso_encuesta/'.$curso, array('id' => 'form_curso'));
?>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-amarillo">


            <div class="panel-heading clearfix breadcrumbs6">
                <h1><?php echo $datos_curso['data'][0]['cur_clave'].'-'.$datos_curso['data'][0]['cur_nom_completo'];?></h1><br>
                <h2 class="panel-title" style="padding-left:20px;">Listado de encuestas realizadas por curso</h2>
                <a href="<?php echo site_url('curso/info_curso/'.$curso); ?>" class="btn btn-info pull-right"> <span class="glyphicon glyphicon-level-up"></span> Regresar a detalle curso</a>
            </div>

            <div class="panel-body">
                <!-- <div class="row">
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Número de registros a mostrar:</span>
                            <?php // echo $this->form_complete->create_element(array('id'=>'per_page', 'type'=>'dropdown', 'options'=>array(2=>2,3=>3,4=>4,10=>10, 20=>20, 50=>50, 100=>100), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Número de registros a mostrar', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Número de registros a mostrar', 'onchange'=>"data_ajax(site_url+'/bonos_titular/get_data_ajax', '#form_buscador', '#listado_resultado_empleado')"))); ?>
                            <?php echo $this->form_complete->create_element(array('id'=>'per_page', 'type'=>'dropdown', 'options'=>array(5=>5,10=>10, 20=>20, 50=>50, 100=>100), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Número de registros a mostrar', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Número de registros a mostrar', 'onchange'=> "data_ajax(site_url+'/resultadocursoencuesta/get_datos/'+".$curso.", '#form_curso', '#listado_resultado')"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Ordenar por:</span>
                            <?php echo $this->form_complete->create_element(array('id'=>'order', 'type'=>'dropdown', 'options'=>array('nombre'=>'Nombre','nrolevaluador'=>'Rol evaluador','nrolevaluado' => 'Rol evaluado', 'ngrupo' => 'Grupo'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Ordernar por', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ordenar por', 'onchange'=>"data_ajax(site_url+'/resultadocursoencuesta/get_datos/'+".$curso.", '#form_curso', '#listado_resultado')"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Tipo de orden:</span>
                            <?php echo $this->form_complete->create_element(array('id'=>'order_type', 'type'=>'dropdown', 'options'=>array('DESC'=>'Descendente', 'ASC'=>'Ascendente'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Ordernar por', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ordenar por', 'onchange'=>"data_ajax(site_url+'/resultadocursoencuesta/get_datos/'+".$curso.", '#form_curso', '#listado_resultado')"))); ?>
                        </div>
                    </div>
                </div> -->
                <input type="hidden" id="curso" name="curso" value="<?php echo $curso ?>">
                <input type="hidden" id="bactiva" name="bactiva" value="0">

                <?php 
                echo $this->form_complete->create_element(array('id'=>'btn_export', 'type'=>'submit', 'value'=>'Exportar', 'attributes'=>array('class'=>'btn btn-info btn-sm espacio', 'style'=>'display:yes;')));
                ?>
                
                <div class="form-group text-center"></div>
                <div id="listado_resultado">

                    <!-- INICIO DUMMY -->
                    <div class="row container">
                        <div class="col-lg-12 col-md-12" style="width:900px;">
                            <div class="table-responsive" style="overflow-x: scroll;">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Matrícula evaluado</th>
                                            <th>Evaluado</th>
                                            <th>Rol evaluado</th>
                                            <th>Delegación / UMAE</th>
                                            <th>Adscripción</th>
                                            <th>Categoría</th>

                                            <th>Matrícula evaluador</th>
                                            <th>Evaluador</th>
                                            <th>Rol evaluador</th>
                                            <th>Delegación / UMAE</th>
                                            <th>Adscripción</th>
                                            <th>Categoría</th>

                                            <th>Encuesta</th>
                                            <th>1-Participó voluntariamente en el curso</th>
                                            <th>2-El tutor colocó un mensaje de bienvenida en el Foro de novedades y anuncios al inicio del curso.</th>
                                            <th>3-Resultó motivador para iniciar las actividades del curso.</th>
                                            <th>4-Señaló la utilidad que tendría el curso para usted.</th>
                                            <th>5-Le proporcionó los elementos para comunicarse a mesa de ayuda en caso necesario.</th>
                                            <th>6-Le proporcionó los elementos para comunicarse con el tutor en caso de alguna duda.</th>
                                            <th>7-Le informó sobre la existencia del Foro social y el objetivo del mismo.</th>
                                            <th>8-Le informó la existencia del Foro de dudas y el objetivo del mismo.</th>
                                            <th>9-Colocó un mensaje inicial en el Foro de dudas motivando su uso.</th>
                                            <th>10-Le Informó sobre la existencia del Foro de novedades y anuncios, así como el objetivo del mismo.</th>
                                            <th>11-Le orientó sobre las causas e implicaciones de la falta de registro de lectura de los contenidos en plataforma.</th>
                                            <th>12-Siempre respondió las dudas que planteó en el Foro de dudas.</th>
                                            <th>13-Respondió con un tiempo menor de 24 horas las dudas que presentó en el foro correspondiente.</th>
                                            <th>14-Respondió adecuadamente a sus dudas para visualizar los empaquetados.</th>
                                            <th>15-Cuando planteó alguna duda sobre el contenido le respondió pertinentemente de acuerdo a lo revisado en el curso.</th>
                                            <th>16-Le retroinformó con base en los contenidos del curso cuando expresó alguna duda sobre una evaluación.</th>
                                            <th>17-Le dio una respuesta pertinente en el caso de que usted le planteara una inconformidad sobre el reactivo de una evaluación.</th>
                                            <th>18-Le dio un trato respetuoso durante el curso.</th>
                                            <th>19-Mostró un adecuado conocimiento sobre el manejo de las herramientas de la plataforma educativa.</th>
                                            <th>Totales por evaluador</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $del = array('AGUASCALIENTES', 'NUEVO LEON', 'GUANAJUATO', 'BAJA CALIFORNIA', 'SONORA');
                                        $sum = 0;
                                        $si_no = array('Si', 'No');
                                        foreach ($listado_evaluados['data'] as $key_e => $registro) {
                                            $ramaevaluado = explode('&', $registro['ramaevaluado']);
                                            
                                            if(isset($ramaevaluado[1]) && explode(':', $ramaevaluado[1])[0] != ""){
                                                $ramaevaluado_ad = explode(':', $registro['ramaevaluado'])[2];
                                                $ramaevaluado_cat = explode(':', $registro['ramaevaluado'])[1];
                                                $dele = explode(':', $ramaevaluado[1])[0];
                                                $ads = explode('&', $ramaevaluado_ad)[0];
                                                $cat = explode('|', $ramaevaluado_cat)[0];
                                            } else {
                                                $random = rand(1, 10);
                                                $dele = $del[rand(0, count($del)-1)];
                                                $ads = 'HOSP GRAL ZONA C/MF '.$random;
                                                $cat = 'COORDINACION CLINICA DE MEDICINA HGZ '.$random;
                                            }
                                            $t= rand(80,95);                                            
                                            $sum += $t;
                                            echo '<tr>
                                                    <td>'.$registro['matricula'].'</td>
                                                    <td>'.$registro['nombre'].' '.$registro['apellidos'].'</td>
                                                    <td>'.$registro['nrolevaluado'].'</td>
                                                    <td>'.$dele.'</td>
                                                    <td>'.$ads.'</td>
                                                    <td>'.$cat.'</td>
                                                    <td>'.$registro['matricula_evaluador'].'</td>
                                                    <td>'.$registro['nombreevaluador'].'</td>
                                                    <td>'.$registro['nrolevaluador'].'</td>
                                                    <td>'.$dele.'</td>
                                                    <td>'.$ads.'</td>
                                                    <td>'.$cat.'</td>
                                                    <td>Encuesta de satisfacción para Alumnos</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <td>'.$si_no[rand(0,1)].'</td>
                                                    <th>'.number_format($t,3).'%</th>
                                                </tr>';
                                        } ?>
                                        <tr>
                                            <th colspan="13" style="text-align:right">Totales por pregunta</th>
                                            <?php echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>';
                                            echo '<th>'.number_format(rand(80,95),3).'%</th>'; ?>
                                        </tr>
                                    </tbody>
                                </table>                            
                            </div>
                        </div>
                    </div>
                    <!-- FIN DUMMY -->

                </div>
             </div>  <!-- /panel-body-->
        </div> <!-- /panel panel-amarillo-->
    </div> <!-- /col 12-->
</div>
<div class="row"></div>    
    
 

<?php echo form_close(); ?>

<script type="text/javascript">
$(document).ready(function() {
    var curso=$("#curso").val();
    
    /*data_ajax(site_url + "/resultadocursoencuesta/get_datos/"+curso, "#form_curso", "#listado_resultado");
    $("#btn_submit").click(function(event) {
    
        data_ajax(site_url + "/resultadocursoencuesta/get_datos/"+curso, "#form_curso", "#listado_resultado");
        event.preventDefault();
    });*/

    $("#btn_export").click(function(event){
        event.preventDefault();
        /*$("#form_curso").attr("action", site_url+"/resultadocursoencuesta/export_data_detalle/"+curso);
        $("#form_curso").submit();*/
        alert("Esto es un texto de prueba");
    });
});
</script>