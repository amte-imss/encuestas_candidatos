<?php
//pr($grupos_ids_text);
echo js('evaluacion/instrumento_asignado.js');
?>
<div id="area_encuesta">
<div class="list-group-item">
    <div style="text-align:justify">


        <?php
        echo "<b>Instrucciones</b> <br><br>";
        echo $instrumento[0]['guia_descripcion_encuesta'];
        ?>

    </div>

</div>

<div class="col-md-4"></div>
<div class="col-md-4">
    <table id="rayitas" class="text-center">
        <tr class="border-bottom">
            <td class="border-lr"></td>
            <td></td>
            <td class="border-lr">X</td>
        </tr>
        <tr>
            <td class="no-border">Si</td>
            <td class="no-border">No</td>
            <td class="no-border">No aplica</td>
        </tr>
    </table>
</div>
<div class="col-md-4"></div>



<div class="row">
    <div class="col-md-12 col-sm-12">
        <?php
        //pr($grupos_ids_text);
        if (isset($mensaje)) {//Valida que exista un mensaje
            echo html_message($mensaje, $tipo_msj); //Muestra mensaje
        }
        ?>
        <div class="panel panel-amarillo">
            <div class="panel-body">

                <?php
                //                pr($preguntas);

                $check_ok = '<span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"> </span>';
                $check_no = '<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"> </span>';

                if (isset($preguntas) && !empty($preguntas) && isset($instrumento) && !empty($instrumento)) {
                    //pr($instrumento);
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
                    //Tabla de información de la encuesta a contestar
                    ?>
                    <div id="detalle_instrumento">
                        <div class="table-responsive">
                            <table class="table table-bordered">


                                <tr>
                                    <td>
                                        <label>Nombre del instrumento:</label>
                                    </td>
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

                    $seccion = 0;
                    $pregunta = 0;
                    $no_pregunta = 1;

                    echo form_open('evaluacion/guardar_encuesta_usuario', array('id' => 'form_encuesta_usuario'));
                    //pr($preguntas);
                    echo '<div class="errores_generales"></div>';
                    foreach ($preguntas as $key => $val) {

                        if ($seccion !== $val['seccion_cve']) {
                            if ($val['descripcion'] != 'NA') {
                                echo "<br><h4># " . $val['descripcion'] . "</h4><br>";
                            }
                        }

                        if ($pregunta !== $val['preguntas_cve']) {//Agrega la pregunta
                            echo "<br><b><h5> " . $val['orden'] . " - " . $val['pregunta'] . "</h5></b><br>";
                            echo "<div id='error_pregunta{$val['preguntas_cve']}' class='mensaje_pregunta'></div>";
                            echo form_error_format('p_r[' . $val['preguntas_cve'] . ']');
                            if(isset($errores_preguntas_abiertas[$val['preguntas_cve']])){
                                echo html_message('Esta pregunta es requerida', $tipo_msj); //Muestra mensaje
                            }
                        }

                        $tmp_s = isset($reactivos[$val['preguntas_cve']])? $reactivos[$val['preguntas_cve']]: '';

                        if ($val['tipo_pregunta_cve'] == 5)
                        {
                            echo $this->form_complete->create_element(array('id' => 'p_r'.$val['preguntas_cve'].'_text',  'type' => 'textarea', 'value' => $tmp_s, 'attributes' => array('name' => "pregunta{$val['preguntas_cve']}", 'rows' => '4')));
                        } elseif ($val['tipo_pregunta_cve'] == 6)
                        {
                            $tmp_b = '';
                            if(isset($reactivos_abiertas_radio[$val['preguntas_cve']])){
                                $tmp_s = '';
                                $tmp_b = 'checked';
                            }
                            echo '<label><input class="only_one_answer_radio" id="p_r' . $val['preguntas_cve'] . '_radio" type="radio" name="pregunta' . $val['preguntas_cve'] . '"
                            value="' . $val['reactivos_cve'] . '"' . $tmp_b . ' >' . $val['texto'] . '</label><br>';
                            if(isset($reactivos_abiertas_radio[$val['preguntas_cve']])){
                                echo '<span id="'.'p_r'.$val['preguntas_cve'].'_link'.'"><small><a onclick="activar_campo_texto('."'p_r".$val['preguntas_cve']."_text"."'".')">Activar campo de texto</a></small></span>';
                                echo $this->form_complete->create_element(array('id' => 'p_r'.$val['preguntas_cve'].'_text', 'type' => 'textarea', 'value' => $tmp_s, 'attributes' => array('name' => 'pregunta' . $val['preguntas_cve'].'texto','class' => 'only_one_answer_text', 'rows' => '4', 'disabled'=>'true')));
                            }else{
                                echo '<span style="display:none" id="'.'p_r'.$val['preguntas_cve'].'_link'.'"><small><a onclick="activar_campo_texto('."'p_r".$val['preguntas_cve']."_text"."'".')">Activar campo de texto</a></small></span>';
                                echo $this->form_complete->create_element(array('id' => 'p_r'.$val['preguntas_cve'].'_text', 'type' => 'textarea', 'value' => $tmp_s, 'attributes' => array('name' => 'pregunta' . $val['preguntas_cve'].'texto','class' => 'only_one_answer_text', 'rows' => '4')));
                            }

                        } else
                        {
                            echo '<label><input type="radio" name="pregunta' . $val['preguntas_cve'] . '"
                            value="' . $val['reactivos_cve'] . '">' . $val['texto'] . '</label><br>';
                        }
                        /*
                        echo '<label><input type="radio" name="p_r[' . $val['preguntas_cve'] . ']"
                        value="' . $val['reactivos_cve'] . '"' . set_radio('p_r[' . $val['preguntas_cve'] . ']', '' . $val['reactivos_cve'] . '') . '; >' . $val['texto'] . '</label><br>';
                        */



                        $seccion = $val['seccion_cve'];
                        $pregunta = $val['preguntas_cve'];
                    }
                    if (isset($encuesta_cve) || isset($user_id_evaluado) || isset($user_id_evaluador) || isset($curso_cve) || isset($grupo_cve)) {
                        echo '<input type="hidden" id="idencuesta" name="idencuesta" value="' . $encuesta_cve . '">';
                        echo '<input type="hidden" id="iduevaluado" name="iduevaluado" value="' . $evaluado_user_cve . '">';
                        echo '<input type="hidden" id="iduevaluador" name="iduevaluador" value="' . $evaluador_user_cve . '">';
                        echo '<input type="hidden" id="idcurso" name="idcurso" value="' . $curso_cve . '">';
                        echo '<input type="hidden" id="is_bono" name="is_bono" value="' . $instrumento[0]['is_bono'] . '">';
                        echo '<input type="hidden" id="idgrupo" name="idgrupo" value="' . $grupo_cve . '">';
                        echo '<input type="hidden" id="des_autoevaluacion_cve" name="des_autoevaluacion_cve" value="' . $des_autoevaluacion_cve . '">';



                        if (isset($grupos_ids_text)) {
                            echo '<input type="hidden" id="grupos_ids_text" name="grupos_ids_text" value="' . $grupos_ids_text . '">';
                        }
                        if (isset($bloque)) {
                            echo '<input type="hidden" id="bloque" name="bloque" value="' . $bloque . '">';
                        }
                        echo "<br>";
                    }

                    if (isset($mensaje)) {//Valida que exista un mensaje
                        echo html_message($mensaje, $tipo_msj); //Muestra mensaje
                    }

                    if (isset($boton) && !empty($boton)) {

                        echo $this->form_complete->create_element(array('id' => 'btn_submit', 'name' => 'btn_submit',
                        'type' => 'submit', 'value' => 'Terminar encuesta'
                    ));
                }



                echo form_close();
                //                    if (isset($mensaje)) {
                //                        echo "<font color='red'>" . $mensaje . "</font>";
                //                    }
                echo '<div class="errores_generales"></div>';
            } else {
                ?>
                <br><br>
                <?php
                echo html_message("No se encontraron datos registrados en esta busqueda", 'info');
                ?>
                <?php
            }
            ?>
        </div>
    </div>
</div>
</div>
