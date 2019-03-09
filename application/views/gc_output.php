<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<?php 
	if (isset($encuesta_cve)) {
		
		?>
		<a href="<?php echo site_url('encuestas/edit/'.$encuesta_cve); ?>" class="btn pull-right">
            <span class="glyphicon glyphicon-list" aria-hidden="true"> </span> Regresar a preguntas 
        </a>
		<?php

	}
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="row" style="margin:5px;">
            <div class="panel">
				<?php echo $output;

					//pr($output);

				?>
    		</div>
    	</div>
    </div>
</div>
