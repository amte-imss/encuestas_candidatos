<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-amarillo">
            <div class="panel-body">
				<?php
				$this->config->load('general');
				$tipo_msg = $this->config->item('alert_msg');

				if (isset($error))
				{
					echo html_message($error, $tipo_msg['WARNING']['class']);

				}

				?>

				<div>
					<?php 	echo form_open_multipart('encuestas/cargar_instrumento');?> 
						    <input type="file" name="userfile" ><br>
						    <input type="submit" name="submit" value="Cargar instrumentos" class="btn btn-moodle">
					<?php 	echo form_close(); ?>

				</div>

			</div>
		</div>
	</div>
</div>
