<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid-theme.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid.js');?>"></script>
<?php echo js("prototipos/listado_cursos.js"); ?>

<div class="panel panel-default">
	<div class="panel-heading">
	    <h3>Listado de cursos</h3>
	</div>

	<div class="panel-body">
		<div class="row">
			<div id="grid_cursos"></div>
		</div>
	</div>
</div>

