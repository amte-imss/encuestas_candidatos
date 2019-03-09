<div class="panel">
<strong>
Ya existe una encuesta con esta regla de evaluación, ¿Aun desea continuar con la carga del archivo CSV?
</strong><br>
<?php 

$data['var_json'] = json_encode($csv_array);


?>
<div id="resultado_json"></div>
<?php
echo form_open('encuestas/carga_matriz_form');
?>
<input type="text" name="archivo" value="<?php echo $ruta_archivo; ?>" id="archivo">
<a href="" class="btn btn-default">Cancelar</a>
<input type="submit" name="submit" value="Continuar" class="btn btn-success">



<?php echo form_close(); ?>

</div>

