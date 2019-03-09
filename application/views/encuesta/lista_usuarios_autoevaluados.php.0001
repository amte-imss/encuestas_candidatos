<?php

echo js('encuestas/encuestas.js');
if (isset($datos_user_aeva) && !empty($datos_user_aeva)) {
    //pr($datos_user_aeva);

    ?>




    <div class="panel-heading">

        <table>
            <tr>
                <th>
                    NOMBRE DE IMPLEMENTACIÓN:
                </th>
            </tr>
            <tr>
                <td>
                    <h3> <?php echo $datos_curso['data'][0]['cur_nom_completo']; ?>
                        (<?php echo $datos_curso['data'][0]['cur_clave']; ?>)</h3>
                </td>
            </tr>
        </table>
    </div>
    </div>



    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>

                    <th>Rol evaluador</th>
                    <th>Nombre usuario evaluador</th>
                    <th>Rol a evaluar</th>
                    <th>Nombre docente a evaluar</th>
                    <th>Grupo</th>
                   <!--<th>Encuesta</th>-->
                    <th>Asignar evaluador</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //pr($datos_user_aeva[0]['evagral']);
                $i=0;
                foreach ($datos_user_aeva as $val) {
                    $i++;
                    //pr($val['evagral']);
                    //pr($val['data']);

                    foreach ($val['data'] as $keyl => $valuel) {
                        // pr($val);
                        //pr($valuel);# code...
                        //}

                        $is_bloques_grupos = 0;
                        if (isset($valuel)) {
                            if (isset($valuel['ngpo']) && $valuel['ngpo'] != '0') {
                                //$grupo = $val[0]['ngpo'];
                                $grupo = (!empty($valuel['ngpo'])) ? implode(str_getcsv(trim($valuel['ngpo'], '{}')), ', ') : '';
                                $is_bloques_grupos = 1;
                            } else {
                                $grupo = '--';
                            }

                            echo '<tr>

                        <td >' . $valuel['evaluador'] . '</td >
                        <td >' . $valuel['nomevaluador'] . '</td >

                        <td >' . $valuel['role'] . '</td >
                         <td >' . $valuel['firstname'] . ' ' . $valuel['lastname'] . '</td>
                        <td > ' . $grupo . '</td >';
                            //<td >' . $val[0]['regla'] . '</td>

                            echo '<td>';
                            echo form_open('encuestausuario/instrumento_asignado', array('id' => 'form_curso'.$i));
                            ?>
                        <input type="hidden" id="idencuesta" name="idencuesta" value="<?php echo $valuel['regla'] ?>">
                        <?php if ($is_bloques_grupos) { ?>
                            <input type = "hidden" id = "grupos_ids_text" name = "grupos_ids_text" value = "<?php echo $valuel['grupos_ids_text'] ?>">
                        <?php } ?>
                        <?php if (isset($valuel['bloque'])) { ?>
                            <input type = "hidden" id = "bloque" name = "bloque" value = "<?php echo $valuel['bloque'] ?>">
                        <?php } ?>

                        <input type="hidden" id="iduevaluado" name="iduevaluado" value="<?php echo $valuel['userid'] ?>">
                        <input type="hidden" id="rolevaluado" name="rolevaluado" value="<?php echo $valuel['rol_id'] ?>">
                        <input type="hidden" id="cur_id" name="cur_id" value="<?php echo $valuel['cursoid'] ?>">
                        <input type="hidden" id="i" name="i" value="<?php echo $i ?>">
                        <input type="hidden" id="tutorizado" name="tutorizado" value="<?php echo $datos_curso['data'][0]['tutorizado'] ?>">




                        <input type="hidden" id="idgrupo" name="idgrupo" value="<?php
                        if (isset($valuel['gpoid']) && $valuel['gpoid'] > 0) {
                            echo $valuel['gpoid'];
                        } else {
                            echo '0';
                        }
                        ?>">
                        <!--<input type="text" id="iduevaluador" name="iduevaluador" value="<?php echo $iduevaluador ?>">-->


                        <?php
                        if (isset($valuel['realizado']) || !empty($valuel['realizado'])) {
                            echo "Realizada";
                        } else {

                        //pr($val['datosdesig']['data'][0]);
                        $valor='';
                        if($val['datosdesig']['result'] == true)
                        {
                              $valor=$val['datosdesig']['data'][0]['evaluador_user_cve'].'/'. $val['datosdesig']['data'][0]['evaluador_rol_id'];
                         }

// pr($valor);

                          echo $this->form_complete->create_element(array('id' => 'evaluador', 'name' => 'evaluador',
                            'type' => 'dropdown',
                            'options' => $val['evagral'],
                            'first' => array('' => 'Seleccione'),
                            'value' => $valor,
                            'attributes' => array('name' => 'evaluador',
                                'class' => 'form-control',
                                'placeholder' => 'Evaluador',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'title' => 'Evaluador',
                                'onchange' => "guarda_autoevaluado(i.value);")));



                        }
                        ?>

                        <!--
                          <a href="'.site_url('encuestausuario/instrumento_asignado/'.$val[0]['regla']).'" class="btn btn-info btn-block">
                              <span class="glyphicon glyphicon-search"></span>
                          </a>-->
                        <?php
                        echo form_close();

                        echo '</td>
                        ';

                        echo '</tr>';
                        # code...
                    }
                }
            }
            ?>
            </tbody>
        </table>

    </div>
<?php } else if (isset($coment_general)) { ?>
    <div class="row">
        <div class="jumbotron"><div class="container"><p class="text_center"><?php echo $coment_general; ?></p> </div></div>
    </div>
<?php } else { ?>
    <br><br>
    <div class="row">
        <div class="jumbotron"><div class="container"> <p class="text_center">No se encontraron datos registrados con esta busqueda</p> </div></div>
    </div>

<?php } ?>
