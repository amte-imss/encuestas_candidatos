<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid-theme.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.js"></script>

<?php
$mostrar_registros = [5, 10, 15, 20, 100];
$postutorizado = strpos($datos_curso[0]['nombre_curso'], 'utorizado');
$text_tutorizado = ($datos_curso[0]['tutorizado'] == '0') ? ' - No tutorizado' : ' - Tutorizado';
$nombre_curso = (is_numeric($postutorizado)) ? $datos_curso[0]['nombre_curso'] : $datos_curso[0]['nombre_curso'] . $text_tutorizado;
echo js("js_export/canvas-datagrid.js");
echo js("js_export/Blob.js");
echo js("js_export/FileSaver.js");
echo js("js_export/xlsx.full.min.js");
echo js("curso/reporte_encuestas.js");
?>


<div class="panel-heading clearfix breadcrumbs6">
    <h3 class="text-justify"><?php echo $datos_curso[0]['clave_curso'] . '-' . $nombre_curso; ?></h3>
    <div class="col-sm-12"><?php //echo $this->form_complete->create_element(array('id' => 'tipo_reporte', 'type' => 'select', 'value' => $datos_curso[0]['cur_id'])); ?>
    	<?php echo $this->form_complete->create_element(array('id' => 'curso', 'type' => 'hidden', 'value' => $datos_curso[0]['cur_id']));; ?>
    	<label>Seleccione el tipo de reporte</label>
    	<select name="tipo_reporte" id="tipo_reporte">
    		<option value="0">Seleccione...</option>
			<option value="1">General</option>
			<option value="2">Detalle</option>
		</select>
    </div>
</div>

<div id="divReporteEncuestas">
	<div class="panel-heading clearfix breadcrumbs6">
		<div class="col-md-6"></div>
	    <div class="col-md-3 text-right"><input class="btn btn-moodle" type="submit" value="Exportar reporte" id="xport" data-namegrid="jsReporteEncuestas" data-clavecurso ="<?php echo $datos_curso[0]['clave_curso']; ?>" onclick="export_xlsx_grid(this);"></div>
	    <div class="col-md-3 text-right"><a href="<?php echo site_url('curso/info_curso/' . $datos_curso[0]['cur_id']); ?>" class="btn btn-info"> <span class="glyphicon glyphicon-level-up"></span> Regresar a detalle curso</a></div>
	</div>
	<div class="col-sm-12">
	    <div id="jsReporteEncuestas"></div>
	</div>
</div>

<div id="divReporteHechos">
	<div class="panel-heading clearfix breadcrumbs6">
		<hr><div class="row pinta_resumen" style="padding: 0.5em;">
			<center>
                            <div class="col-sm-4"><strong>Número de encuestas asignadas</strong><br><div id="div_total_encuestas"></div></div>
			<div class="col-sm-4"><strong>Número de encuestas contestadas</strong><br><div id="div_encuestas_contestadas"></div></div>
			<div class="col-sm-4"><strong>Número de encuestas no contestadas</strong><br><div id="div_encuestas_no_contestadas"></div></div>
                        </center>
		</div><hr>
		<div class="col-md-6 text-left"></div>
	    <div class="col-md-3 text-right"><input class="btn btn-moodle" type="submit" value="Exportar reporte" id="export_hecho" data-namegrid="jsReporteHechos" data-clavecurso ="<?php echo $datos_curso[0]['clave_curso']; ?>" onclick="export_xlsx_grid(this);"></div>
	    <div class="col-md-3 text-right"><a href="<?php echo site_url('curso/info_curso/' . $datos_curso[0]['cur_id']); ?>" class="btn btn-info"> <span class="glyphicon glyphicon-level-up"></span> Regresar a detalle curso</a></div>
	</div>
	<div class="col-sm-12">
	    <div id="jsReporteHechos"></div>
	</div>
</div>
