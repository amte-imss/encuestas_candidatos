<?php echo js("candidatos_curso/candidatos.js"); ?>


<div class="col-lg-6 col-sm-6 col-md-6 custom-file control_cursos_registro">
    <?php
//    echo $this->form_complete->create_element(array('id' => 'id_c', "type" => 'hidden',
//        "value" => $datos_cursos_registro['course_id']
//    ));
    echo $this->form_complete->create_element(array('id' => 'candidatosfile',
        'type' => 'upload',
        'attributes' => array('name' => 'candidatosfile',
            'class' => 'custom-file-input',
            'accept' => '.csv',
            'size' => 1000,
    )));
    echo form_error('candidatosfile');
    ?>
    <!--<input type="file" name="candidatosfile" accept=".csv"><br>-->
    <input type="button" name="button" value="Cargar candidatos" class="btn btn-moodle" onclick="cargar_candidatoscsv();">
</div>


