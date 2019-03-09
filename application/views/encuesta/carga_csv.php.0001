<a href="<?php echo site_url('encuestas/cargar_instrumento'); ?>" class="btn btn-primary pull-right"> Cargar instrumento por CSV </a>

<div class="clearfix"></div>

<?php
$this->config->load('general');
$tipo_msg = $this->config->item('alert_msg');


$status_carga = $this->session->flashdata('success');
if ($status_carga == TRUE)
{
    echo html_message($status_carga, $tipo_msg['SUCCESS']['class']);


}else{
if (isset($error))
{

	if (isset($error['carga_csv']) && !empty($error['carga_csv']))
	{
		echo html_message($error['carga_csv'], $tipo_msg['DANGER']['class']);

	}else{
		if (is_array($error))
		{
			foreach ($error as $tipo_error)
			{

				if (isset($tipo_error['tipo_pregunta']))
				{

					foreach($tipo_error['tipo_pregunta'] as $preg_inst)
					{
							//pr($preg_inst);
							$muestra_error = isset($preg_inst['tipo_pregunta']) ? $preg_inst['tipo_pregunta']['error'] : '';
							$display_error = '<div class="panel panel-warning">
								<!-- Default panel contents -->
								<div class="panel-heading"><h4>Resumen de la pregunta</h4></div>
									<div class="table-responsive">
								  		<table class="table table-bordered">
											<tr>
												<th>NO_PREGUNTA</th>
												<th>PREGUNTA</th>
												<th>NOMBRE_SECCION</th>
												<th>NOMBRE_INSTRUMENTO</th>
											</tr><tr>
												<td>'.$preg_inst['orden_pregunta'].'</td>
												<td>'.$preg_inst['pregunta'].'</td>
												<td>'.$preg_inst['descripcion'].'</td>
												<td>'.$preg_inst['descripcion_encuestas'].'</td>
											</tr>
										</table>
									</div>
								</div>';

							$display_error.=$muestra_error;

							echo html_message($display_error, $tipo_msg['DANGER']['class']);
						}

				}else{

					foreach($tipo_error as $preg_inst)
					{

						if (isset($preg_inst['error']) && is_array($preg_inst['error']))
						{
							$muestra_error ="";
								if (isset($preg_inst['error']['NOMBRE_INSTRUMENTO']) && !empty($preg_inst['error']['NOMBRE_INSTRUMENTO'])) $muestra_error .= $preg_inst['error']['NOMBRE_INSTRUMENTO'].'<br>';
								if (isset($preg_inst['error']['FOLIO_INSTRUMENTO']) && !empty($preg_inst['error']['FOLIO_INSTRUMENTO'])) $muestra_error .= $preg_inst['error']['FOLIO_INSTRUMENTO'].'<br>';

								if (isset($preg_inst['error']['ROL_A_EVALUAR']) && !empty($preg_inst['error']['ROL_A_EVALUAR'])) $muestra_error .= $preg_inst['error']['ROL_A_EVALUAR'].'<br>';
								if (isset($preg_inst['error']['ROL_EVALUADOR']) && !empty($preg_inst['error']['ROL_EVALUADOR'])) $muestra_error .= $preg_inst['error']['ROL_EVALUADOR'].'<br>';
								if (isset($preg_inst['error']['TUTORIZADO']) && !empty($preg_inst['error']['TUTORIZADO'])) $muestra_error .= $preg_inst['error']['TUTORIZADO'].'<br>';
								if (isset($preg_inst['error']['NOMBRE_SECCION']) && !empty($preg_inst['error']['NOMBRE_SECCION'])) $muestra_error .= $preg_inst['error']['NOMBRE_SECCION'].'<br>';
								if (isset($preg_inst['error']['NO_PREGUNTA']) && !empty($preg_inst['error']['NO_PREGUNTA'])) $muestra_error .= $preg_inst['error']['NO_PREGUNTA'].'<br>';
								if (isset($preg_inst['error']['PREGUNTA_PADRE']) && !empty($preg_inst['error']['PREGUNTA_PADRE'])) $muestra_error .= $preg_inst['error']['PREGUNTA_PADRE'].'<br>';
								if (isset($preg_inst['error']['RESPUESTA_ESPERADA']) && !empty($preg_inst['error']['RESPUESTA_ESPERADA'])) $muestra_error .= $preg_inst['error']['RESPUESTA_ESPERADA'].'<br>';
								if (isset($preg_inst['error']['PREGUNTA_BONO']) && !empty($preg_inst['error']['PREGUNTA_BONO'])) $muestra_error .= $preg_inst['error']['PREGUNTA_BONO'].'<br>';
								if (isset($preg_inst['error']['OBLIGADA']) && !empty($preg_inst['error']['OBLIGADA'])) $muestra_error .= $preg_inst['error']['OBLIGADA'].'<br>';
								if (isset($preg_inst['error']['PREGUNTA']) && !empty($preg_inst['error']['PREGUNTA'])) $muestra_error .= $preg_inst['error']['PREGUNTA'].'<br>';
								if (isset($preg_inst['error']['NO_APLICA']) && !empty($preg_inst['error']['NO_APLICA'])) $muestra_error .= $preg_inst['error']['NO_APLICA'].'<br>';
								if (isset($preg_inst['error']['SI']) && !empty($preg_inst['error']['SI'])) $muestra_error .= $preg_inst['error']['SI'].'<br>';
								if (isset($preg_inst['error']['NO']) && !empty($preg_inst['error']['NO'])) $muestra_error .= $preg_inst['error']['NO'].'<br>';
								if (isset($preg_inst['error']['SIEMPRE']) && !empty($preg_inst['error']['SIEMPRE'])) $muestra_error .= $preg_inst['error']['SIEMPRE'].'<br>';
								if (isset($preg_inst['error']['CASI_SIEMPRE']) && !empty($preg_inst['error']['CASI_SIEMPRE'])) $muestra_error .= $preg_inst['error']['CASI_SIEMPRE'].'<br>';
								if (isset($preg_inst['error']['ALGUNAS_VECES']) && !empty($preg_inst['error']['ALGUNAS_VECES'])) $muestra_error .= $preg_inst['error']['ALGUNAS_VECES'].'<br>';
								if (isset($preg_inst['error']['CASI_NUNCA']) && !empty($preg_inst['error']['CASI_NUNCA'])) $muestra_error .= $preg_inst['error']['CASI_NUNCA'].'<br>';
								if (isset($preg_inst['error']['NUNCA']) && !empty($preg_inst['error']['NUNCA'])) $muestra_error .= $preg_inst['error']['NUNCA'].'<br>';
								if (isset($preg_inst['error']['RESPUESTA_ABIERTA']) && !empty($preg_inst['error']['RESPUESTA_ABIERTA'])) $muestra_error .= $preg_inst['error']['RESPUESTA_ABIERTA'].'<br>';
								if (isset($preg_inst['error']['TIPO_INSTRUMENTO']) && !empty($preg_inst['error']['TIPO_INSTRUMENTO'])) $muestra_error .= $preg_inst['error']['TIPO_INSTRUMENTO'].'<br>';
								if (isset($preg_inst['error']['EVA_TIPO']) && !empty($preg_inst['error']['EVA_TIPO'])) $muestra_error .= $preg_inst['error']['EVA_TIPO'].'<br>';
								if (isset($preg_inst['error']['NO_ENVIO_MENSAJE']) && !empty($preg_inst['error']['NO_ENVIO_MENSAJE'])) $muestra_error .= $preg_inst['error']['NO_ENVIO_MENSAJE'].'<br>';
								if (isset($preg_inst['error']['VALIDO_NO APLICA']) && !empty($preg_inst['error']['VALIDO_NO APLICA'])) $muestra_error .= $preg_inst['error']['VALIDO_NO APLICA'].'<br>';
								if (isset($preg_inst['error']['NOMBRE_INDICADOR']) && !empty($preg_inst['error']['NOMBRE_INDICADOR'])) $muestra_error .= $preg_inst['error']['NOMBRE_INDICADOR'].'<br>';

								$display_error = $muestra_error;
								$display_error = '<div class="panel panel-warning">
									<!-- Default panel contents -->
									<div class="panel-heading"><h4>Resumen de la pregunta</h4></div>
									<div class="table-responsive">
								  		<table class="table table-bordered">
												<tr>
													<th>NO_PREGUNTA</th>
													<th>PREGUNTA</th>
													<th>NOMBRE_SECCION</th>
													<th>NOMBRE_INSTRUMENTO</th>
												</tr><tr>
													<td>'.$preg_inst['NO_PREGUNTA'].'</td>
													<td>'.$preg_inst['PREGUNTA'].'</td>
													<td>'.$preg_inst['NOMBRE_SECCION'].'</td>
													<td>'.$preg_inst['NOMBRE_INSTRUMENTO'].'</td>
												</tr>
											</table>
										</div>
									</div>';

								$display_error.=$muestra_error;

								echo html_message($display_error, $tipo_msg['DANGER']['class']);

						}else{
							$muestra_error = isset($preg_inst['error']) ? $preg_inst['error'] : '';
							$display_error = '<div class="panel panel-warning">
									<!-- Default panel contents -->
									<div class="panel-heading"><h4>Resumen de la pregunta</h4></div>
									<div class="table-responsive">
								  		<table class="table table-bordered">
												<tr>
													<th>NO_PREGUNTA</th>
													<th>PREGUNTA</th>
													<th>NOMBRE_SECCION</th>
													<th>NOMBRE_INSTRUMENTO</th>
												</tr>
												<tr>
													<td>'.$preg_inst['NO_PREGUNTA'].'</td>
													<td>'.$preg_inst['PREGUNTA'].'</td>
													<td>'.$preg_inst['NOMBRE_SECCION'].'</td>
													<td>'.$preg_inst['NOMBRE_INSTRUMENTO'].'</td>
												</tr>
											</table>
										</div>
									</div>';

								$display_error.=$muestra_error;

								echo html_message($display_error, $tipo_msg['DANGER']['class']);
							}
						}
				 	}
				}
		}/*else{

			if (!empty($error)) {
					echo html_message($error, $tipo_msg['DANGER']['class']);
			}
		}*/

	}

}


}

?>
