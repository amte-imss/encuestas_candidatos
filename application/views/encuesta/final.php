<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-amarillo">
            <div class="panel-body">
                <?php
                if (isset($mensaje)) {
                    echo html_message($mensaje, $tipo_msj);
                    echo form_open('encuestausuario/lista_encuesta_usuario?iduser=' . $idusuario . '&idcurso=' . $idcurso);
                    ?> 
                    <input type="submit" name="submit" value="Terminar" class="btn btn-success">
    <?php
    echo form_close();
}
?>


            </div>
        </div>
    </div>
</div>