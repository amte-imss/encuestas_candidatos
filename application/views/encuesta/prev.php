<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel moodle-panel">
            <div class="panel-body">
                <a href="<?php echo site_url('encuestas'); ?>" class="btn pull-right btn-primary" style="margin-bottom: 20px;"> Ver listado de instrumentos </a>

                <?php
//pr($preguntas);

                $check_ok = '<span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"> </span>';
                $check_no = '<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"> </span>';

                if (isset($preguntas) && !empty($preguntas) && isset($instrumento) && !empty($instrumento))
                {

                    /*
                      preguntas_cve,
                      seccion_cve,
                      encuesta_cve,
                      tipo_pregunta_cve,
                      pregunta,
                      -- pregunta_abierta_cerrada,
                      obligada,
                      orden,
                      is_bono,
                      -- has_children,
                      -- obligatoria,
                      val_ref,
                      pregunta_padre,
                      -- encuesta_padre,
                      reactivos_cve,
                      -- preguntas_cve,
                      -- ponderacion,
                      texto,
                      -- orden,
                      encuesta_cve
                     */
                    ?>
                    <div id="detalle_instrumento">                
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td>
                                        <label>Nombre del instrumento:</label>
                                    </td>
                                    <!--<td colspan="5">
                                        <h3><?php //echo $instrumento[0]['descripcion_encuestas'];  ?></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Rol a evaluar:</label>
                                    </td>
                                    <td>
                                        <h4><?php //echo $instrumento[0]['name'];  ?></h4>
                                    </td>
                                    <td>
                                        <label>Aplica para bonos:</label>
                                    </td>
                                    <td>
                                        <h4><a><?php //echo ($instrumento[0]['is_bono'] != 0) ? $check_ok : $check_no;   ?></a></h4>
                                    </td>
                                    <td>
                                        <label>Curso tutorizado:</label>
                                    </td>
                                    <td>
                                        <h4><a><?php //echo ($instrumento[0]['tutorizado'] != 0) ? $check_ok : $check_no;  ?></a></h4>
                                    </td>
                                </tr>-->
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
                                    <td><h4><a><?php echo ($instrumento[0]['is_bono'] != 0) ? $check_ok : $check_no; ?></a></h4></td>
                                    <td><h4><a><?php echo ($instrumento[0]['tutorizado'] != 0) ? $check_ok : $check_no; ?></a></h4></td>
                                    <td><h4><a><?php echo ($instrumento[0]['status'] != 0) ? $check_ok : $check_no; ?></a></h4></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php
                    //echo "<h2>Instrumento: ".$instrumento[0]['descripcion_encuestas']."</h2><br>";
                    //echo "<h3>Rol a evaluar: ".$instrumento[0]['name']."</h3><br><br>";
                    /*
                      pr('[CH][prev]preguntas:');
                      pr($preguntas);
                     * 
                     */
                    $seccion = 0;
                    $pregunta = 0;
                    $no_preg = 1;
                    foreach ($preguntas as $key => $val)
                    {

                        if ($seccion !== $val['seccion_cve'])
                        {
                            if ($val['descripcion'] != 'NA')
                            {

                                echo "<br><h4># " . $val['descripcion'] . "</h4><br>";
                            }
                        }



                        if ($pregunta !== $val['preguntas_cve'])
                        {
                            echo "<hr>";
                            echo "<br><b><h5> " . $no_preg . " - " . $val['pregunta'] . "</h5></b><br>";

                            if (isset($val['indicador']))
                            {
                                //if($val['descripcion'] != 'NA'){

                                echo "Indicador: " . $val['indicador'] . "<br><br>";
                            }
                            $no_preg++;
                        }

                        if ($val['tipo_pregunta_cve'] == 5)
                        {
                            echo $this->form_complete->create_element(array('id' => $val['preguntas_cve'], 'type' => 'textarea', 'value' => ''));
                        } elseif ($val['tipo_pregunta_cve'] == 6)
                        {
                            echo $this->form_complete->create_element(array('id' => $val['preguntas_cve'], 'type' => 'textarea', 'value' => ''));
                            echo '<label><input type="radio" name="' . $val['preguntas_cve'] . '"> ' . $val['texto'] . "</label><br>";
                        } else
                        {
                            echo '<label><input type="radio" name="' . $val['preguntas_cve'] . '"> ' . $val['texto'] . "</label><br>";
                        }
                        $seccion = $val['seccion_cve'];
                        $pregunta = $val['preguntas_cve'];
                    }
                } else
                {
                    ?>
                    <br><br>
                    <div class="row">
                        <div class="jumbotron"><div class="container"> <p class="text_center">No se encontraron datos registrados en esta busqueda</p> </div></div>
                    </div>

                    <?php
                }
                echo "<hr>";
                ?>
            </div>
        </div>
    </div>
</div>