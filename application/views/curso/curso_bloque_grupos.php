<?php
//$curso = $datos_curso['data'][0]['cur_id'];
echo form_open('curso/curso_bloque_grupos/' . $curso, array('id' => 'form_curso_bloque'));
$visible_msj = (isset($mensaje)) ? 'hidden' : 'none';
$tipo_alert = (isset($tipo_alert)) ? 'alert alert-' . $tipo_alert : '';
?>
<div class="row">
    <div class="col-md-1 col-sm-1 col-xs-1" id="div_mensaje_visible" style='display:<?php echo $visible_msj; ?>'></div>
    <div id="div_mensaje_texto" class="col-md-10 col-sm-10 col-xs-10 <?php echo $tipo_alert; ?>">
        <?php if (isset($mensaje)) { ?>
            <?php echo $mensaje; ?>
        <?php } ?>
    </div>
    <div class="col-md-1 col-sm-1 col-xs-1"></div>
</div>

<?php if (isset($datos_curso)) { ?>
    <div class="panel-heading clearfix breadcrumbs6">
        <h2><?php echo $datos_curso[0]['name_curso']; ?></h2><br>
        <h2 class="panel-title" style="padding-left:30px;"><?php echo $datos_curso[0]['tipo_curso'] . ' - ' . $datos_curso[0]['tex_tutorizado']; ?></h2>
        <a href="<?php echo site_url('curso/info_curso/' . $curso); ?>" class="btn btn-info pull-right"> <span class="glyphicon glyphicon-level-up"></span> Regresar a detalle curso</a>
    </div>
    <input type="hidden" id="curso" name="curso" value="<?php echo $curso ?>">
<?php } ?>

<div id="listado_resultado_bloque">
    <?php
    if (isset($vista)) {
        echo $vista;
    }
    ?>
</div>

<div class="clearfix"></div>    

<?php echo form_close(); ?>