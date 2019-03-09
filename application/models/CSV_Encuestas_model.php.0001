<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CSV_Encuestas_model extends CI_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function guarda_encuesta($csv_array = [])
    {
        $salida = array('status' => true, 'errores' => []);
        $encuesta = [];
        $this->valida_csv($csv_array, $salida);
        // pr($salida);

        if($salida['status'])
        {
            $this->db->flush_cache();
            $this->db->reset_query();
            $this->db->trans_begin();
            $data = array(
                'descripcion_encuestas' => $salida['nombre_encuesta'],
                'status' => 0, //no activa
                'cve_corta_encuesta' => $salida['clave_encuesta'],
                'eva_tipo' => $salida['eva_tipo'],
                'tipo_encuesta' => $salida['tipo_encuesta'],
                'reglas_evaluacion_cve' => $salida['regla_evaluacion_cve'],
                'fecha_creacion' => date('Y-m-d'),
                'is_bono' => $salida['is_bono']
            );
            $this->db->insert('encuestas.sse_encuestas', $data);
            $insert_id = $this->db->insert_id();
            $this->guarda_preguntas($csv_array, $insert_id, $salida);
            $this->db->flush_cache();
            $this->db->reset_query();
            if ($this->db->trans_status() === FALSE) { // condición para ver si la transaccion se efectuara correctamente
                $this->db->trans_rollback();
                $salida['status'] = false;
                $salida['errores'][] = 'Error al guardar en la base de datos';
            } else {
                // $this->db->trans_rollback(); // cambiar cuando se termine el desarrollo
                $this->db->trans_commit();
            }
            $this->db->trans_complete();
        }
        return $salida;
    }

    private function guarda_preguntas(&$csv_array = [], $instrumento_insert_id, &$status)
    {
        $this->db->reset_query();
        $status['preguntas'] = [];
        foreach ($csv_array as $row)
        {
            $tipo_pregunta = $this->catalogo->tipo_pregunta($row);
            $pre_tmp = array('pregunta' => $row['PREGUNTA'],
                '#' =>$row['NO_PREGUNTA'],
                'tipo' => $tipo_pregunta['tipo_pregunta_cve']
            );
            if(isset($tipo_pregunta['error']))
            {
                $status['status'] = false;
                $pre_tmp['error'] = $tipo_pregunta['error'];
            }
            $data = array(
                'encuesta_cve' => $instrumento_insert_id,
                'seccion_cve' => $this->get_set_seccion($row['NOMBRE_SECCION']),
                'tipo_pregunta_cve' => $tipo_pregunta['tipo_pregunta_cve'],
                'pregunta' => $row['PREGUNTA'],
                'orden' => $row['NO_PREGUNTA'],
                'is_bono' => (strtoupper($row['PREGUNTA_BONO'])=='SI')?1:0,
                'tipo_indicador_cve' => $this->get_set_indicador($row['NOMBRE_INDICADOR']),
                'valido_no_aplica' => (strtoupper($row['VALIDO_NO_APLICA'])=='SI')?1:0,
                'obligada' => (strtoupper($row['OBLIGADA'])=='SI')?1:0,
            );
            $this->db->insert('encuestas.sse_preguntas', $data);
            $pregunta_insert_id = $this->db->insert_id();
            if(isset($tipo_pregunta['reactivos']))
            {
                $pre_tmp['reactivos'] = $tipo_pregunta['reactivos'];
                foreach ($tipo_pregunta['reactivos'] as $tp)
                {
                    $data = array(
                        'preguntas_cve' => $pregunta_insert_id,
                        'encuesta_cve' => $instrumento_insert_id,
                        'ponderacion' => $tp['ponderacion'],
                        'texto' => $tp['texto']
                    );
                    $this->db->insert('encuestas.sse_respuestas', $data);
                    $this->db->reset_query();
                }
            }
            $this->db->reset_query();
            $status['preguntas'][] = $pre_tmp;
        }
        $this->db->reset_query();
    }

    private function valida_csv(&$csv_array, &$salida)
    {
        $elementos = $this->config->item('ELEMENTOS_CSV_V2');
        $array = [];
        $index = 1;
        $status_tmp = true;
        $is_bono = false;
        foreach ($csv_array as $row)
        {
            foreach ($elementos as $elem)
            {
                if(!isset($array[$elem]))
                {
                    $array[$elem] = $row[$elem];
                }
                if($row[$elem] != $array[$elem])
                {
                    $status_tmp = false;
                    $salida['errores'][] = "El archivo presenta {$elem} diferentes en la fila {$index}";
                }
            }
            if(strtoupper($row['PREGUNTA_BONO'])=='SI'){
                $is_bono = true;
            }
            $index++;
        }
        if($status_tmp)
        {
            foreach ($array as $key => $value) {
                $f = "valida_{$key}";
                if(method_exists($this, $f))
                {
                    $this->$f($value, $salida);
                    // pr($salida);
                }
            }
        }
        $salida['nombre_encuesta'] = $array['NOMBRE_INSTRUMENTO'];
        $salida['is_bono'] = $is_bono?1:0;
        if($salida['status'])
        {
            $this->valida_regla_validacion($salida);
        }
    }

    private function get_set_seccion($value)
    {
        $filtros['descripcion'] = strtoupper($value);
        $seccion = $this->catalogo->get_secciones($filtros);
        if(count($seccion)>0)
        {
            $seccion = $seccion[0];
        }else
        {
            $this->db->reset_query();
            $this->db->insert('encuestas.sse_seccion', $filtros);
            $last = $this->db->insert_id();
            $seccion = array('seccion_cve'=>$last);
            $this->db->reset_query();
        }
        return $seccion['seccion_cve'];
    }

    /*
    * SI el indicador no existe se registra 
    */
    private function get_set_indicador($value)
    {
        $filtros['descripcion'] = strtoupper($value);
        $indicador = $this->catalogo->get_indicadores($filtros);
        if(count($indicador)>0)
        {
            $indicador = $indicador[0];
        }else
        {
            $this->db->reset_query();
            $this->db->insert('encuestas.sse_indicador', $filtros);
            $last = $this->db->insert_id();
            $indicador = array('indicador_cve'=>$last);
            $this->db->reset_query();
        }
        return $indicador['indicador_cve'];
    }

    private function valida_FOLIO_INSTRUMENTO($value, &$salida)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->select('count(*) cantidad');
        $folio_tmp = strtoupper($value);
        $this->db->where('cve_corta_encuesta', $folio_tmp);
        $status_tmp = $this->db->get('encuestas.sse_encuestas')->result_array()[0]['cantidad'] == 0;
        if(!$status_tmp)
        {
            $status_tmp = false;
            $salida['errores'][] = 'El folio del instrumento ya se encuentra registrado en el sistema';
        }else
        {
            $salida['clave_encuesta'] = $folio_tmp;
        }
        $this->db->reset_query();
        $salida['status'] = $salida['status'] && $status_tmp;
    }

    private function valida_ROL_A_EVALUAR($value, &$salida)
    {
        $status_tmp = true;

        $rol_evalua = $this->config->item('ENCUESTAS_ROL_EVALUA'); // obtenemos los valores de la constante ENCUESTAS_RESPUESTA
        $rol_tmp = strtoupper($value);
        $rol_tmp = str_replace(' ', '_', $rol_tmp);
        // pr("rol a evaluar: {$value}");
        // pr($rol_evalua);
        if(!isset($rol_evalua[$rol_tmp]))
        {
            $status_tmp = false;
            $salida['errores'][] = 'No existe el rol a evaluar seleccionado';
        }else
        {
            $salida['rol_asignado_evaluar'] = $rol_evalua[$rol_tmp];  // si el campo [INSTRUMENTO_ROL_ASIGNADO] no esta vacio y si existe en uno de los
            $salida['rol_asignado_evaluar_texto'] = $rol_tmp;
        }
        $salida['status'] = $salida['status'] && $status_tmp;
    }

    private function valida_ROL_EVALUADOR($value, &$salida)
    {
        $status_tmp = true;
        $rol_evaluador = $this->config->item('ENCUESTAS_ROL_EVALUADOR'); // obtenemos los valores de la constante ENCUESTAS_RESPUESTA
        $rol_tmp = strtoupper($value);
        $rol_tmp = str_replace(' ', '_', $rol_tmp);
        // pr("rol evaluador: {$value}");
        // pr($rol_evaluador);
        if(!isset($rol_evaluador[$rol_tmp]))
        {
            $status_tmp = false;
            $salida['errores'][] = 'No existe el rol evaluador seleccionado';
        }else
        {
            $salida['rol_asignado_evaluador'] = $rol_evaluador[$rol_tmp];  // si el campo [INSTRUMENTO_ROL_ASIGNADO] no esta vacio y si existe en uno de los
            $salida['rol_asignado_evaluador_texto'] = $rol_tmp;
        }
        $salida['status'] = $salida['status'] && $status_tmp;
    }

    private function valida_TUTORIZADO($value, &$salida)
    {
        $status_tmp = true;
        $tipo_tutorizado = $this->config->item('TUTORIZADO'); // obtenemos los valores de la constante TUTORIZADO
        $tutorizado_tmp = strtoupper($value);
        if(!empty($tutorizado_tmp) && !isset($tipo_tutorizado[$tutorizado_tmp]))
        {
            $salida['errores'][] = 'No existe la opción de tutorizado seleccionada';
            $status_tmp = false;
        }else{
            $tutorizado = ((!empty($tutorizado_tmp)) ? $tutorizado_tmp : 'NO' );
            $tutorizado_int = $tipo_tutorizado[$tutorizado];
            $salida['tutorizado'] = $tutorizado_int;
            $salida['tutorizado_texto'] = $tutorizado;
        }
        $salida['status'] = $salida['status'] && $status_tmp;
    }

    private function valida_TIPO_INSTRUMENTO($value, &$salida)
    {
        $status_tmp = true;
        $tipo_instrumento = $this->config->item('TIPO_INSTRUMENTO');
        $tipo_tmp = strtoupper($value);

        if(!isset($tipo_instrumento[$tipo_tmp]))
        {
            $salida['errores'][] = 'No existe el tipo de instrumento seleccionado';
            $status_tmp = false;
        }else{
            $salida['tipo_encuesta'] = $tipo_instrumento[$tipo_tmp];
            $salida['tipo_encuesta_texto'] = $tipo_tmp;
        }

        $salida['status'] = $salida['status'] && $status_tmp;
    }

    private function valida_EVA_TIPO($value, &$salida)
    {
        $status_tmp = true;
        $eva_tipo = $this->config->item('EVA_TIPO');
        $eva_tmp = strtoupper($value);

        if(!isset($eva_tipo[$eva_tmp]))
        {
            $salida['errores'][] = 'No existe el tipo de evaluación seleccionado';
            $status_tmp = false;
        }else{
            $salida['eva_tipo'] = $eva_tipo[$eva_tmp]['valor'];
        }

        $salida['status'] = $salida['status'] && $status_tmp;
    }

    private function valida_regla_validacion(&$salida)
    {
        $status_tmp = true;
        $roles_regla = array(
            'rol_evaluador_cve' => $salida['rol_asignado_evaluador'],
            'rol_evaluado_cve' => $salida['rol_asignado_evaluar'],
            'tutorizado' => $salida['tutorizado'],
        );
        $registro_en_regla = $this->catalogo->get_reglas_evaluacion($roles_regla);
        if(count($registro_en_regla)>0)
        {
            $salida['regla_evaluacion_cve'] = $registro_en_regla[0]['reglas_evaluacion_cve'];
        }else{
            $status_tmp = false;
            $salida['errores'][] = 'No existe una regla de evaluación que aplique para la configuración solicitada';
        }
        $salida['status'] = $salida['status'] && $status_tmp;
    }
}
