  <?php
        $this->config->load('general');
        $tipo_msg = $this->config->item('alert_msg');
        $status_preguntas = $this->session->flashdata('success');
        if ($status_preguntas == TRUE)
        {
            echo html_message($status_preguntas, $tipo_msg['SUCCESS']['class']);
        }

        $pencil='<span class="glyphicon glyphicon-pencil" aria-hidden="true"> </span>';
        $remove='<span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>';
        $check_ok = '<span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"> </span>';
        $check_no = '<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"> </span>';

        $seccion=0;
        $pregunta=0;
        $no_pregunta=1;

        foreach ($preguntas as $key => $val) {

            if ($seccion!==$val['seccion_cve']) {
                echo '<br><h4># '.$val['descripcion'].'
                </h4><a href="'.site_url('encuestas/ordenar_preguntas/'.$instrumento[0]['encuesta_cve']).'/'.$val['seccion_cve'].'" class="btn btn-link"><span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"> </span> Modificar orden preguntas</a><br>';
            }

            if ($pregunta !== $val['preguntas_cve']) {

                echo '<br><b>
                <h5>'.$no_pregunta.' - '.$val['pregunta'].'</h5>
                </b>
                <a href="'.site_url('encuestas/edita_pregunta/'.$val['preguntas_cve'].'/'.$val['encuesta_cve']).'" class="text-warning">'.$pencil.' Editar</a>
                |<a class="text-danger" onclick="elimina_pregunta('.$val['preguntas_cve'].','.$val['encuesta_cve'].');">'.$remove.' Eliminar</a>
                <br>';

                $no_pregunta++;
            }
            $seccion=$val['seccion_cve'];
            $pregunta=$val['preguntas_cve'];
        }

?>
