<fieldset class="scheduler-border well">
    <legend class="scheduler-border">Curso</legend>
    <div class="col-lg-12 col-sm-12">
        <div class="panel-body input-group input-group-sm">
            <!--<span class="input-group-addon">Delegación:</span>-->
            <label for="anio_curso"><span style="color:red;">*</span> Año de la implementación</label>
            <?php echo $this->form_complete->create_element(array('id' => 'anio', 'type' => 'dropdown', 'options' => $anios, 'first' => array('' => 'Seleccione un año'), 'attributes' => array('name' => 'anio', 'class' => 'form-control', 'placeholder' => 'Año que impartio curso', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Año en que se impartio curso'))); //, 'onchange' => "data_ajax($url_control)" ?>
        </div>
    </div>
    <?php
    if (isset($buscar_instrumento)) {
        $boton_buscar = 1;
        ?>
        <div class="col-lg-12 col-sm-12">
            <div class="panel-body input-group">
                <input type="hidden" id="cursoid_busqueda" name="cursoid_busqueda" value="">
                <input type="hidden" id="menu_instrumento" name="tipo_buscar_instrumento" value="clavecurso">
                <div class="input-group-btn">
                    <button id="btn_tipo_buscar_instrumento" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default dropdown-toggle " data-toggle="tooltip" data-original-title="Buscar por"><?php echo $buscar_instrumento['clavecurso']; ?><span class="caret"> </span></button>
                    <ul id="ul_menu_buscar_por_i" data-seleccionado='clavecurso' class="dropdown-menu borderlist">
                        <?php foreach ($buscar_instrumento as $key => $value) { ?>
                            <li class="lip" onclick="funcion_menu_tipo_busqueda('<?php echo $key; ?>')"><?php echo $value; ?></li>
                        <?php } ?>
                    </ul>

                </div>

                <?php
                echo $this->form_complete->create_element(
                        array('id' => 'text_buscar_instrumento', 'type' => 'text',
                            'value' => '',
                            'autocomplete' => 'nope',
                            'attributes' => array(
                                'placeholder' => 'Buscar',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                                'data-tipo' => 'tc',
                                'class' => 'form-control dropdown-toggle',
                                'required data-toggle' => 'dropdown',
                                'onkeypress' => 'return runScript(event);', //control key del enter para buscar
                                'title' => 'Buscar',
                            //                                        'readonly'=>'readonly',
                            )
                        )
                );
                ?>
            </div>
            <div id="resultado_bus_curso" >

            </div>
        </div>
    <?php } ?>
    <div class="col-lg-12 col-sm-12">
        <div class="panel-body  input-group input-group-sm">
            <!--<span class="input-group-addon">Sesiones:</span>-->
            <label for="tipo_curso">Tipo de implementación</label>
            <?php echo $this->form_complete->create_element(array('id' => 'tipo_implementacion', 'type' => 'dropdown', 'options' => $tipo_implementacion, 'first' => array('' => 'Seleccione tipo de implementación'), 'attributes' => array('name' => 'tipo_curso', 'class' => 'form-control', 'placeholder' => 'Curso tipo tutorizado o no-tutorizado', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Curso tipo tutorizado o no-tutorizado'))); //, 'onchange' => "data_ajax($url_control)" ?>
        </div>
    </div>
</fieldset>

<script type="text/javascript">
    $(document).ready(function () {

        //hacemos focus al campo de búsqueda
//        $("#text_buscar_instrumento").focus();
        //comprobamos si se pulsa una tecla
        $("#text_buscar_instrumento").keyup(function (e) {
//            alert(e.keyCode);
            var cachaKey = (e.keyCode > 47 && e.keyCode < 58) //Números
                    || (e.keyCode > 64 && e.keyCode < 91) //Alfabeto
                    || e.keyCode == 173 //´Guión medio
                    || e.keyCode == 13 //Enter
//                    || e.keyCode == 8 //back
                    ;
            //e.keyCode == 38 || e.keyCode == 40;
            //Si es Esc, limpia lista de busqueda

            if (cachaKey) {
                //obtenemos el texto introducido en el campo de búsqueda
                var consulta = $("#text_buscar_instrumento").val();
                //hace la búsqueda
//            data_ajax_post(site_url + 'buscar_control/buscar', null, '#resultado', consulta);
                $.ajax({
                    type: "POST",
                    url: site_url + "/reporte/buscar_curso",
                    data: {b: consulta},
//                    dataType: "html",
                    beforeSend: function (xhr) {
                        //imagen de carga
                        $("#resultado_bus_curso").html(create_loader());
                    }
                })
                        .done(function (data) {
                            try {//Cacha el error
                                var resp = $.parseJSON(data);
//                              alert(resp.curso);
                                $("#resultado_bus_curso").empty();
                                $("#resultado_bus_curso").append(resp.html);
                                if (resp.curso != 0) {//Si es mayor que cero, carga bloque
                                    funcion_cargar_bloque(resp.curso);//Carga curso
                                }
                            } catch (e) {

                            }

                        })
                        .fail(function (jqXHR, response) {

                        })
                        .always(function () {
                            remove_loader();
                        });
            } else if (e.keyCode == 27) {//Esc
                $("#resultado_bus_curso").empty();
            }
        });
    });

</script>

