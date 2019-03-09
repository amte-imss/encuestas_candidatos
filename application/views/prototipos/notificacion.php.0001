<form>
	<div class="form-group row">
		<label class="col-sm-4" for="plantilla">Selecciona la plantilla de correo a enviar</label>
		<div class="col-sm-3">
			<select name="plantilla">
				<option value="1">Recordatorio</option>
				<option value="2">Recordatorio 1</option>
				<option value="3">Recordatorio 2</option>
				<option value="4">Recordatorio 3</option>
			</select>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-offset-1 col-sm-10">
			<div class="panel panel-default" style="padding: 2%">
				<div class="panel-body" style="max-height: 10;overflow-y: scroll; max-height: 180px;">
					<center>
						<img src="<?php echo base_url('/assets/img/plecas/recordatorio.png');?>" id="pleca" style="height: 50px; width:200%;">
					</center>
					<br>
					<p>XXXXXXXXXXXX</p>
					<br>
					<p>
					Con la finalidad de que reciba la constancia y a fin de contar con su valioso punto de vista sobre aspectos relevantes del curso: [curso], le solicitamos atentamente que responda la encuesta de satisfacción que se encuentra en la plataforma educativa colocada al final de dicho curso en la sección Evaluación final y Encuesta de satisfacción.
					</p>
					<p>
					El acceso estará disponible del [fecha_inicio] al [fecha_fin], y podrá ingresar con la última clave utilizada. Solicitamos su colaboración para responder la encuesta dentro del periodo establecido, ya que por normativa y posterior a éste el acceso cerrará en definitivo. Si tiene dudas sobre este procedimiento, contacte al personal de Mesa de ayuda de esta Coordinación:
					</p>
					<br>
					<p>
					Teléfono:    01(55) 5627-6900 Ext: 21146, 2147 y 21148
					<br>
					Horario:    08:00 a 17:00 horas
					<br>
					Correo electrónico:    soporte.innovaedu@imss.gob.mx
					</p>
				</div>
			</div>
		</div>
	</div>
  	<div class="form-group row">
    	<label class="col-sm-2 control-label" for="fecha_inicio" style="padding-right:0;">Fecha de inicio</label>
  		<div class="col-sm-3" style="padding-left:0;">
    		<input type="date" class="form-control" name="fecha_inicio">
    	</div>
    	<div class="col-sm-1"></div>
    	<label class="col-sm-2 control-label" for="fecha_fin" style="padding-right:0;">Fecha de fin</label>
    	<div class="col-sm-3" style="padding-left:0;">
    		<input type="date" class="form-control" name="fecha_fin">
    	</div>
  	</div>
  	<br>
  	<div class="row">
  		<div class="pull-right" style="padding-right: 2%;">
  			<button type="submit" class="btn btn-default">Enviar</button>
  		</div>
  	</div>
</form>

<script type="text/javascript">
var url = "<?php echo base_url(); ?>";	
$(document).ready(function () {
	var opciones = $('select[name="plantilla"]');
	opciones.on('change',function(){
		var value = opciones.val();
		var src = url;
		switch(value){
			case '1':
				src += 'assets/img/plecas/recordatorio.png';
			break;

			case '2':
				src +='assets/img/plecas/encuesta1.png';
			break;

			case '3':
				src +='assets/img/plecas/encuesta2.png';
			break;

			case '4':
				src +='assets/img/plecas/encuesta3.png';
			break;
		}
		$('#pleca').attr('src',src);
	});
});
</script>