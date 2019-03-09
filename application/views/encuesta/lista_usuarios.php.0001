<?php
if (isset($datos_user_aeva) && !empty($datos_user_aeva)) {
  //pr($listado_autoeval);
    ?>
    <div class="list-group-item">
        <div style="text-align:right"><?php echo $nombreevaluador ?>
        </div>
        <?php
        if (isset($error) AND ! is_null($error) AND ! empty($error)) {
            echo '<div class="row">
                                <div class="col-md-1 col-sm-1 col-xs-1"></div>
                                <div class="col-md-10 col-sm-10 col-xs-10 alert alert-danger">
                                    ' . $error . '
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-1"></div>
                            </div>';
        }
        ?>

    </div>




    <div class="panel-heading">

        <table>
            <tr>
                <th>
                    NOMBRE DE IMPLEMENTACIÓN:
                </th>
            </tr>
            <tr>
                <td>
                    <h3> <?php echo $datos_curso[0]['nombre_curso']; ?>
                        (<?php echo $datos_curso[0]['clave_curso']; ?>)</h3> 
                </td>
            </tr>
        </table>
    </div>
    </div>



    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>Regla</th>
                    <th>Rol evaluador</th>

                    <th>Rol a evaluar</th>
                    <th>Nombre docente a evaluar</th>
                    <th>Grupo</th>
                   <!--<th>Encuesta</th>-->
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
//                pr($datos_user_aeva);
                
                foreach ($datos_user_aeva as $val) {
                    //pr($val);
                    foreach ($val as $keyl => $valuel) {

//                        pr($valuel);# code...
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
                        <td >' . $valuel['regla'] . '</td >
                        <td >' . $valuel['evaluador'] . '</td >
                        <td >' . $valuel['role'] . '</td >
                         <td >' . $valuel['firstname'] . ' ' . $valuel['lastname'] . '</td>
                        <td > ' . $grupo . '</td >';
                            //<td >' . $val[0]['regla'] . '</td>

                            echo '<td>';
                            echo form_open('evaluacion/instrumento_asignado', array('id' => 'form_curso'));
                            ?>
                        <input type="hidden" id="idencuesta" name="idencuesta" value="<?php echo $valuel['regla'] ?>">
                        <?php if ($is_bloques_grupos) { ?>
                            <input type = "hidden" id = "grupos_ids_text" name = "grupos_ids_text" value = "<?php echo $valuel['grupos_ids_text'] ?>">
                        <?php } ?>
                        <?php if (isset($valuel['bloque'])) { ?>
                            <input type = "hidden" id = "bloque" name = "bloque" value = "<?php echo $valuel['bloque'] ?>">
                        <?php } ?>

                        <input type="hidden" id="iduevaluado" name="iduevaluado" value="<?php echo $valuel['userid'] ?>">
                        <input type="hidden" id="idcurso" name="idcurso" value="<?php echo $valuel['cursoid'] ?>">
                        <input type="hidden" id="idgrupo" name="idgrupo" value="<?php
                        if (isset($valuel['gpoid']) && $valuel['gpoid'] > 0) {
                            echo $valuel['gpoid'];
                        } else {
                            echo '0';
                        }
                        ?>">
                        <input type="hidden" id="iduevaluador" name="iduevaluador" value="<?php echo $iduevaluador ?>">


                        <?php
                        if (isset($valuel['realizado']) || !empty($valuel['realizado'])) {
                            echo "Realizada";
                        } else {
                            ?>
                            <input type="submit"  class="btn btn-info btn-block" value="Evaluar usuario">
                            <?php
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

            if (isset($listado_autoeval) && !empty($listado_autoeval)) {
              //pr($listado_autoeval);
                foreach ($listado_autoeval as $valaev) {
                    //pr($valaev);



                 echo '<tr>
                        <td >' . $valaev['regla'] . '</td >
                        <td >' . $valaev['evaluadorn'] . '</td >
                        <td >' . $valaev['roleevaluadon'] . '</td >
                         <td >' . $valaev['nombreevaluado'] . '</td>
                        <td > ';


                        if(isset($valaev['grupos_ids_text']) && ($valaev['grupos_ids_text']=='0'))
                        {
                            echo '--';
                        }
                        else
                        {

                          echo $valaev['grupos_ids_text'];
                        }

                        echo '</td >';


                            echo '<td>';
                            echo form_open('encuestausuario/instrumento_asignado', array('id' => 'form_curso'));
                            ?>
                        <input type="hidden" id="idencuesta" name="idencuesta" value="<?php echo $valuel['regla'] ?>">
                        <?php if ($is_bloques_grupos) { ?>
                            <input type = "hidden" id = "grupos_ids_text" name = "grupos_ids_text" value = "<?php echo $valuel['grupos_ids_text'] ?>">
                        <?php } ?>
                        <?php if (isset($valuel['bloque'])) { ?>
                            <input type = "hidden" id = "bloque" name = "bloque" value = "<?php echo $valuel['bloque'] ?>">
                        <?php } ?>

                        <input type="hidden" id="iduevaluado" name="iduevaluado" value="<?php echo $valuel['userid'] ?>">
                        <input type="hidden" id="idcurso" name="idcurso" value="<?php echo $valuel['cursoid'] ?>">
                        <input type="hidden" id="idgrupo" name="idgrupo" value="<?php
                        if (isset($valuel['gpoid']) && $valuel['gpoid'] > 0) {
                            echo $valuel['gpoid'];
                        } else {
                            echo '0';
                        }
                        ?>">
                        <input type="hidden" id="iduevaluador" name="iduevaluador" value="<?php echo $iduevaluador ?>">
                        <input type="hidden" id="des_autoevaluacion_cve" name="des_autoevaluacion_cve" value="<?php echo $valaev['des_autoevaluacion_cve'] ?>">



                        <?php
                        if (isset($valuelaev['realizado']) || !empty($valuelaev['realizado'])) {
                            echo "Realizada";
                        } else {
                            ?>
                            <input type="submit"  class="btn btn-info btn-block" value="Evaluar usuario">
                            <?php
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

                    //}
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
