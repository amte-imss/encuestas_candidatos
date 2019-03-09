<div style="color:#333;">
	<p>Estimado(a) <?php echo $usuario->usr_nombre.' '.$usuario->usr_paterno.' '.$usuario->usr_materno; ?>,</p>
	<p>Le agradecemos por participar en los Talleres de actualizaci&oacute;n para el uso de los recursos de informaci&oacute;n en salud. Su registro al taller "<?php echo $agenda[0]['a_nombre']; ?>" fue realizado exitosamente, a continuaci&oacute;n, le mostramos el detalle de su inscripci&oacute;n:</p>
	<p>Nombre: <b><?php echo $usuario->usr_nombre.' '.$usuario->usr_paterno.' '.$usuario->usr_materno; ?></b></p>
	<p>Matricula: <b><?php echo $usuario->usr_matricula; ?></b></p>
	<p>Folio de registro: <b><?php echo $taller->t_folio; ?></b></p>
	<p>Taller: <b><?php echo $agenda[0]['a_nombre']; ?></b></p>
	<p>Horario: <b>De 8:00 a 14:00 hrs.</b></p>
	<p>Fecha: <b><?php echo date("d-m-Y", strtotime($agenda[0]['a_inicio'])).' y '.date("d-m-Y", strtotime($agenda[0]['a_fin'])); ?></b></p>
	<p>Si desea cancelar o cambiar el taller en el cu&aacute;l se registr&oacute;, s&oacute;lo debe copiar y pegar en su navegador la siguiente liga <b><?php echo site_url("registro/cancelacion"); ?></b>, proporcionar los datos que se le solicitan y registrarse en una nueva fecha para cursar el taller.</p>
	<p>Por &uacute;ltimo, le compartimos el calendario de impartici&oacute;n de talleres de &eacute;ste a&ntilde;o, para que pueda consultarlo e inscribirse al que m&aacute;s le agrade.</p>
	<table class="table table-striped" style="background-color: #AAA">
		<tr>
			<td>
				<table class="table" style="background-color: #AAA">
				    <thead>
				        <tr class="success">
				            <th>Recursos</th>
				        </tr>
				    </thead>
				    <tbody>
				        <tr><td>Conricyt</td></tr>
				        <tr><td>Summon</td></tr>
				        <tr><td>Scopus</td></tr>
				        <tr><td>Web of Science</td></tr>
				        <tr><td>Clinical Key</td></tr>
				        <tr><td>Up to date</td></tr>
				        <tr><td>Access Medicine</td></tr>
				        <tr><td>EBSCO</td></tr>
				        <tr><td>Ovid</td></tr>
				    </tbody>
				</table>
			</td>
			<td>
				<table class="table table-striped" style="background-color: #AAA">
				    <thead>
                        <tr class="success">
                            <th>Sesiones programadas</th>
                            <th>Fechas</th>
                        </tr>
                    </thead>
				    <tbody>
				        <?php
				        foreach ($agendas as $key_sp => $sesion) {
				            echo '<tr><td>'.$sesion['a_nombre'].'</td><td>'.date("d-m-Y", strtotime($sesion['a_inicio'])).' y '.date("d-m-Y", strtotime($sesion['a_fin'])).'</td></tr>';
				        }
				        ?>
				    </tbody>
				</table>
			</td>
		</tr>
	</table>
	<br>
	<p>*Restricciones:</p>
	<p><b>a) S&oacute;lo puede estar inscrito en un taller por a&ntilde;o</b></p>
	<p><b>b) S&oacute;lo es posible cancelar y reprogramar en 1 ocasi&oacute;n la fecha de su preferencia</b></p>
	<br>
	<p>*Notas:</p>
	<p><b>- Indispensable contar con equipo de cómputo personal.</b></p>
	<p><b>- Es necesaria la puntualidad, las 2 asistencias y la evaluaci&oacute;n para recibir constancia.</b></p>
	<br>
	<p>Para cualquier duda o comentario no dude en comunicarse con nosotros.</p>
	<b>Contacto:</b> Dra Sonia Aurora Gallardo Candelas <br>
	<b>Correo electr&oacute;nico:</b> <a href="mailto:sonia.gallardo@imss.gob.mx">sonia.gallardo@imss.gob.mx</a><br>
	<b>Teléfono:</b> 5627 6900 ext. 21250<bR>
	<a href="http://innovacioneducativa.imss.gob.mx/imss_conricyt/">Sitio Web del convenio IMSS CONRICYT</a>
	<br>
	<p>ATTE: Divisi&oacute;n de Innovaci&oacute;n Educativa, IMSS</p>
	<br><br>
	<h3><b>* Esta misma información le será enviada por correo electrónico, en caso de no recibirla en su bandeja de entrada principal recuerde revisar su bandeja de spam (correo no deseado).</b></h3>
</div>
