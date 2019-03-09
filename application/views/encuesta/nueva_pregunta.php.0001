<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-amarillo">
            <div class="panel-body">
                <a href="<?php echo site_url('encuestas/edit/' . $encuesta_cve); ?>" class="btn btn-info pull-right"><span class="glyphicon glyphicon-list" aria-hidden="true"> </span> Regresar a preguntas </a>
                <br><br>
                <?php
                $campos_pregunta = array(
                    'encuesta_cve',
                    'seccion_cve',
                    'tipo_pregunta_cve',
                    'pregunta',
                    'obligada',
                    'orden',
                    'is_bono',
                    'val_ref',
                    'pregunta_padre',
                    'reactivos_cve',
                    'texto',
                    'ponderacion'
                );

                if (isset($encuesta_cve) && !empty($encuesta_cve))
                {

                    //pr($pregunta);
                    $status_success = $this->session->flashdata('success');
                    echo form_open('encuestas/nueva_pregunta/' . $encuesta_cve, array('id' => 'nueva_pregunta'));
                    if ($status_success == TRUE)
                    {
                        echo html_message($status_success, 'success');
                    }
                    ?>

                    <div class="list-group">

                        <div class="list-group-item">
                            <h3>Agregar nueva pregunta</h3>
                        </div>

                        <div class="list-group-item">
                            <label for="seccion_cve">Nombre de sección:</label>
                            <?php echo $this->form_complete->create_element(array('id' => 'seccion_cve', 'type' => 'dropdown', 'options' => $secciones, 'value' => '', 'first' => array('' => 'Seleccione una sección'), 'attributes' => array('name' => 'seccion_cve', 'class' => 'form-control', 'placeholder' => 'Sección pregunta', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Sección pregunta'))); ?>
                            <?php echo form_error_format('seccion_cve'); ?> <!--<span class="text-danger"></span>-->
                            <p class="help-block"></p>
                        </div>

                        <div class="list-group-item">
                            <label for="seccion_cve">Nombre de indicador:</label>
                            <?php
                            echo $this->form_complete->create_element(array('id' => 'tipo_indicador_cve', 'type' => 'dropdown', 'options' => $indicadores, 'value' => '', 'first' => array('' => 'Seleccione indicador'), 'attributes' => array('name' => 'tipo_indicador_cve', 'class' => 'form-control', 'placeholder' => 'Indicador de pregunta', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Indicador de pregunta')));
                            ?>
                            <?php echo form_error_format('tipo_indicador_cve'); ?>
                            <p class="help-block"></p>
                        </div>


                        <div class="list-group-item">
                            <label for="pregunta">Pregunta:</label>
                            <?php
                            echo $this->form_complete->create_element(array('id' => 'pregunta', 'type' => 'textarea', 'value' => '', 'attributes' => array('row' => 2, 'class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'pregunta', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'pregunta')));
                            ?>
                            <?php echo form_error_format('pregunta'); ?> <!--<span class="text-danger"> </span>-->
                            <p class="help-block"></p>
                        </div>
                        <div class="list-group-item">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <label>
                                    <?php
                                    $check_bono = ""; //(isset($pregunta[0]['is_bono']) && $pregunta[0]['is_bono']==1) ? 'checked': '';
                                    echo $this->form_complete->create_element(array('id' => 'is_bono', 'type' => 'checkbox', 'value' => 1, 'attributes' => array('name' => 'is_bono', 'checked' => $check_bono)));
                                    ?>
                                    Aplica para bono
                                </label>
                                <?php echo form_error_format('is_bono'); ?>
                            </div><div class="col-lg-4 col-md-4 col-sm-4">
                                <label>
                                    <?php
                                    $check_obligada = ""; // (isset($pregunta[0]['obligada']) && $pregunta[0]['obligada']==1) ? 'checked': '';
                                    echo $this->form_complete->create_element(array('id' => 'obligada', 'type' => 'checkbox', 'value' => 1, 'attributes' => array('name' => 'obligada', 'checked' => $check_obligada)));
                                    ?>
                                    Obligada
                                </label>
                                <?php echo form_error_format('obligada', '', ''); ?>
                            </div>
                            <br>
                            <p class="help-block"></p>
                        </div>
                        <div class="list-group-item">
                            <label for="tipo_pregunta_cve">Tipo de respuesta:</label><br>
                            <br>
                            <label>
                                <?php
                                $check_null;

                                if (isset($pregunta[0]['tipo_pregunta_cve']) && ($pregunta[0]['tipo_pregunta_cve'] == 2 OR $pregunta[0]['tipo_pregunta_cve'] == 4 OR $pregunta[0]['tipo_pregunta_cve'] == 6))
                                {
                                    $check_null = 1;
                                } elseif (isset($pregunta[0]['tipo_pregunta_cve']) && $pregunta[0]['tipo_pregunta_cve'] == 8)
                                {
                                    $check_null = 7;
                                } else
                                {
                                    $check_null = 0;
                                }
                                $tiponoobligatoria = array(1 => 'No aplica', 7 => 'No envió mensaje');
                                //echo "Respuesta tipo no obligatoria";
                                echo $this->form_complete->create_element(array('id' => 'no_obligatoria', 'type' => 'dropdown', 'options' => $tiponoobligatoria, 'value' => $check_null, 'first' => array('' => 'Seleccione'), 'attributes' => array('name' => 'no_obligatoria', 'class' => 'form-control', 'placeholder' => 'Respuesta', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Respuesta')));




                                /**/
                                //$check_null = "";// (isset($pregunta[0]['tipo_pregunta_cve']) && ($pregunta[0]['tipo_pregunta_cve']==2 OR $pregunta[0]['tipo_pregunta_cve']==4 OR $pregunta[0]['tipo_pregunta_cve']==6)) ? 'checked': '';
                                //echo $this->form_complete->create_element(array('id' => 'no_obligatoria', 'type' => 'checkbox', 'value'=>1, 'attributes' => array('name' => 'no_obligatoria', 'checked'=>$check_null)));
                                ?>
                                <!--//No aplica-->
                            </label><br>


                            <!-- -->
                            <label>
                                <?php
                                $valores = array(
                                    1 => '[Si / No]', 2 => '[Siempre, Casi siempre, Algunas veces, Casi nunca, Nunca]', 3 => '[Respuesta abierta]'
                                );
                                $check_sino = (isset($pregunta[0]['tipo_pregunta_cve']) && ($pregunta[0]['tipo_pregunta_cve'] == 1 OR $pregunta[0]['tipo_pregunta_cve'] == 2));
                                $check_siemprenunca = (isset($pregunta[0]['tipo_pregunta_cve']) && ($pregunta[0]['tipo_pregunta_cve'] == 3 OR $pregunta[0]['tipo_pregunta_cve'] == 4));
                                $check_abierta = (isset($pregunta[0]['tipo_pregunta_cve']) && ($pregunta[0]['tipo_pregunta_cve'] == 5 OR $pregunta[0]['tipo_pregunta_cve'] == 6));
                                $value_tipo_respuesta = 0;
                                if ($check_sino)
                                {
                                    $value_tipo_respuesta = 1;
                                } else if ($check_siemprenunca)
                                {
                                    $value_tipo_respuesta = 2;
                                } else if ($check_abierta)
                                {
                                    $value_tipo_respuesta = 3;
                                }

                                //pr('[CH][edita_pregunta]check_abierta: '.$value_tipo_respuesta);
                                echo $this->form_complete->create_element(array('id' => 'tipo_pregunta', 'type' => 'dropdown', 'options' => $valores, 'value' => $value_tipo_respuesta, 'first' => array('' => 'Seleccione'), 'attributes' => array('name' => 'tipo_respuesta', 'class' => 'form-control', 'placeholder' => 'Respuesta', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Respuesta')));
                                ?>
                            </label><br>
                            <?php echo form_error_format('tipo_pregunta_cve'); ?>




                            <p class="help-block"></p>
                        </div>
                        <div class="list-group-item" style='display:none;' id='validonap'>
                            <label for="seccion_cve">Valido no aplica:</label><br>
                            <label>
                                <input type="radio" name="valido_no_aplica" id="valido_no_aplica" value="1" <?php
                            //echo set_value('valido_no_aplica', $pregunta[0]['valido_no_aplica']) == 1 ? "checked" : "";
                            ?> />Si

                                <input type="radio" name="valido_no_aplica" id="valido_no_aplica" value="0" <?php
                            //echo set_value('valido_no_aplica', $pregunta[0]['valido_no_aplica']) == 0 ? "checked" : "";
                            ?> />No

                            </label><br>
                            <br>
                            <p class="help-block"></p>
                        </div>


                        <div class="list-group-item">
                            <?php
                            echo $this->form_complete->create_element(array('id' => 'btn_submit', 'type' => 'submit', 'value' => 'Guardar pregunta', 'attributes' => array('class' => 'btn btn-success btn-block espacio')));
                            ?>
                        </div>
                        <div class="list-group-item">
                        </div>
                    </div>

                    <?php
                    echo form_close();
                } else
                {
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
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        var op = $("#no_obligatoria option:selected").val();
        if (op == 7)
        {
            $("input[id=tipo_pregunta_2]").attr("disabled", true);
            $("input[id=tipo_pregunta_3]").attr("disabled", true);
            $("input[id=tipo_pregunta_1]").attr("checked", true);
            $('#validonap').hide();
        } else if (op == 1)
        {
            $("input[id=tipo_pregunta_2]").attr("disabled", false);
            $("input[id=tipo_pregunta_3]").attr("disabled", false);
            $("input[id=tipo_pregunta_1]").attr("checked", true);
            $('#validonap').show();

        } else
        {
            $("input[id=tipo_pregunta_2]").attr("disabled", false);
            $("input[id=tipo_pregunta_3]").attr("disabled", false);
            $("input[id=tipo_pregunta_1]").attr("checked", true);
            $('#validonap').hide();

        }

        $("#no_obligatoria").change(function () {
            var op = $("#no_obligatoria option:selected").val();
            if (op == 7)
            {
                $("input[id=tipo_pregunta_2]").attr("disabled", true);
                $("input[id=tipo_pregunta_3]").attr("disabled", true);
                $("input[id=tipo_pregunta_1]").attr("checked", true);
                $('#validonap').hide();
            } else if (op == 1)
            {
                $("input[id=tipo_pregunta_2]").attr("disabled", false);
                $("input[id=tipo_pregunta_3]").attr("disabled", false);
                $("input[id=tipo_pregunta_1]").attr("checked", true);
                $('#validonap').show();

            } else
            {
                $("input[id=tipo_pregunta_2]").attr("disabled", false);
                $("input[id=tipo_pregunta_3]").attr("disabled", false);
                $("input[id=tipo_pregunta_1]").attr("checked", true);
                $('#validonap').hide();

            }

        });


    });
</script>
