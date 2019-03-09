<a href="<?php echo site_url('encuestas/cargar_instrumento'); ?>" class="btn btn-primary pull-right"> Cargar instrumento por CSV </a>

<div class="clearfix"></div>
<?php
// pr($status);
if($status['status'])
{
    echo html_message('El archivo se guardo correctamente', $mensajes['SUCCESS']['class']);
}else{
    if(isset($status['errores']))
    {
        $lista_errores = implode($status['errores'], '<br>');
        echo html_message($lista_errores, $mensajes['DANGER']['class']);
    }else if(isset($error_upload))
    {
        echo html_message($status['msg'], $mensajes['DANGER']['class']);
        echo html_message($error_upload['carga_csv'], $mensajes['DANGER']['class']);
    }

}
?>
<div class="">
    <?php if(isset($status['clave_encuesta']))
    {
        ?>
        <p><strong>Folio</strong> <?php echo $status['clave_encuesta'];?></p>
        <p><strong>Instrumento</strong> <?php echo $status['nombre_encuesta'];?></p>
        <p><strong>Rol a evaluar</strong> <?php echo $status['rol_asignado_evaluar_texto'];?></p>
        <p><strong>Rol evaluador</strong> <?php echo $status['rol_asignado_evaluador_texto'];?></p>
        <p><strong>tutorizado</strong> <?php echo $status['tutorizado_texto'];?></p>
        <?php
    }
    ?>

    <br>
    <?php
    if(isset($status['preguntas']))
    {
        foreach ($status['preguntas'] as $row)
        {
            if(isset($row['error']))
            {
                echo html_message($row['error'], $mensajes['DANGER']['class']);
            }
            echo "<p>{$row['#']}. {$row['pregunta']}</p>";
        }
    }
    ?>
    <br>
</div>
<br>
<div class="clearfix"></div>
