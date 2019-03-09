<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluacion_model extends CI_Model
{
    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function guardar_respuestas(&$parametros = [], &$salida = [])
    {
        $plantilla_preguntas = $parametros['plantilla_preguntas'];
        $parametros['grupos_ids_text'] = (isset($parametros['grupos_ids_text'])?$parametros['grupos_ids_text']:'');
        $data = [];
        $fecha = date('Y-m-d: H:s');
        foreach ($plantilla_preguntas as $row)
        {
            if($this->verifica_respuesta($row, $parametros))
            {
                $reactivo = null;
                switch ($row['tipo_pregunta_cve'])
                {
                    case 5:
                        $reactivo = null;
                        break;
                    case 6:
                        if(isset($parametros['pregunta'.$row['preguntas_cve'].'texto']))
                        {
                            $reactivo = null;
                        }else
                        {
                            $reactivo = $parametros['pregunta'.$row['preguntas_cve']];
                        }
                        break;
                    default:
                        $reactivo = $parametros['pregunta'.$row['preguntas_cve']];
                        break;
                }
                $respuesta_abierta = null;
                if(isset($parametros['pregunta'.$row['preguntas_cve'].'texto']))
                {
                    $respuesta_abierta =  $parametros['pregunta'.$row['preguntas_cve'].'texto'];
                }else
                {
                    $respuesta_abierta = $parametros['pregunta'.$row['preguntas_cve']];
                }
                // $parametros['pregunta'.$row['preguntas_cve'].'texto'],
                $data[] = array(
                    'encuesta_cve' => $parametros['idencuesta'],
                    'preguntas_cve' => $row['preguntas_cve'],
                    'reactivos_cve' => $reactivo,
                    // 'reactivos_cve' => $row['tipo_pregunta_cve'] == 5 ? null: ()$parametros['pregunta'.$row['preguntas_cve']],
                    'course_cve' => $parametros['idcurso'],
                    'group_id' => $parametros['idgrupo'],
                    'evaluado_user_cve' => $parametros['iduevaluado'],
                    'evaluado_rol_id' => $parametros['regla_evaluacion']['rol_evaluado_cve'],
                    'evaluador_user_cve' => $parametros['iduevaluador'],
                    'evaluador_rol_id' => $parametros['regla_evaluacion']['rol_evaluador_cve'],
                    'respuesta_abierta' => $respuesta_abierta,
                    'fecha' => $fecha,
                    'grupos_ids_text' => $parametros['grupos_ids_text']
                 );
            }else if($row['obligada'])
            {
                $salida['status'] = false;
                $salida['errores'][] = array(
                    'id' => 'pregunta'.$row['preguntas_cve'],
                    'texto' => html_message('Esta pregunta es requerida', 'danger'),
                    'orden' => $row['orden']
                );
            }
        }
        if($salida['status']){
            $this->db->flush_cache();
            $this->db->reset_query();
            $this->db->trans_begin();
            $this->db->insert_batch('encuestas.sse_evaluacion', $data);
            $this->db->reset_query();
            $data = array(
                'encuesta_cve' => $parametros['idencuesta'],
                'course_cve' => $parametros['idcurso'],
                'group_id' => $parametros['idgrupo'],
                'evaluado_user_cve' => $parametros['iduevaluado'],
                'evaluador_user_cve' => $parametros['iduevaluador'],
                'grupos_ids_text' => $parametros['grupos_ids_text'],
                'des_autoevaluacion_cve' => ($parametros['des_autoevaluacion_cve']!='')?$parametros['des_autoevaluacion_cve']:null
            );
            $this->db->insert('encuestas.sse_result_evaluacion_encuesta_curso', $data);
            $insert_id = $this->db->insert_id();
            $this->db->reset_query();
            $this->db->select("encuestas.update_promedios_encuestas({$parametros['idencuesta']}, {$parametros['idcurso']}, {$parametros['idgrupo']}, '{$parametros['grupos_ids_text']}', {$parametros['iduevaluado']}, {$parametros['iduevaluador']}, {$parametros['regla_evaluacion']['rol_evaluado_cve']}, {$parametros['regla_evaluacion']['rol_evaluador_cve']}, {$insert_id})");
            $this->db->get();
            $this->db->reset_query();
            $this->db->select("encuestas.update_promedios_encuestas_bonos({$parametros['idencuesta']}, {$parametros['idcurso']}, {$parametros['idgrupo']}, '{$parametros['grupos_ids_text']}', {$parametros['iduevaluado']}, {$parametros['iduevaluador']}, {$parametros['regla_evaluacion']['rol_evaluado_cve']}, {$parametros['regla_evaluacion']['rol_evaluador_cve']}, {$insert_id})");
            $this->db->get();
            if ($this->db->trans_status() === FALSE) { // condición para ver si la transaccion se efectuara correctamente
                $this->db->trans_rollback();
                $salida['status'] = false;
                $salida['errores'][] = 'Error al guardar en la base de datos';
            } else {
                //$this->db->trans_rollback(); // cambiar cuando se termine el desarrollo
                $this->db->trans_commit();
            }
        }
    }

    private function verifica_respuesta(&$row, &$parametros)
    {
        $status = true;
        switch ($row['tipo_pregunta_cve'])
        {
            case 6:
                if(!isset($parametros["pregunta{$row['preguntas_cve']}"]) && !isset($parametros["pregunta{$row['preguntas_cve']}texto"]))
                {
                    $status = false;
                }else if(isset($parametros["pregunta{$row['preguntas_cve']}texto"]) && ($parametros["pregunta{$row['preguntas_cve']}texto"] == '' && $row['obligada']))
                {
                    $status = false;
                }
                break;
            case 5:
                if(!isset($parametros["pregunta{$row['preguntas_cve']}"]) || ($parametros["pregunta{$row['preguntas_cve']}"] == '' && $row['obligada'])){
                    $status = false;
                }
                break;
            default:
                if(!isset($parametros["pregunta{$row['preguntas_cve']}"]))
                {
                    $status = false;
                }
                break;
        }
        return $status;
    }

    public function get_encuestas_evaluadas($filtros = [])
    {
        $encuestas = [];
        $this->db->flush_cache();
        $this->db->reset_query();
        if(isset($filtros['encuesta_cve']) && $filtros['encuesta_cve'] != '')
        {
            $this->db->where('encuesta_cve', $filtros['encuesta_cve']);
        }
        if(isset($filtros['course_cve']) && $filtros['course_cve'] != '')
        {
            $this->db->where('course_cve', $filtros['course_cve']);
        }
        if(isset($filtros['group_id']) && $filtros['group_id'] != '')
        {
            $this->db->where('group_id', $filtros['group_id']);
        }
        if(isset($filtros['evaluador_user_cve']) && $filtros['evaluador_user_cve'] != '')
        {
            $this->db->where('evaluador_user_cve', $filtros['evaluador_user_cve']);
        }
        if(isset($filtros['evaluado_user_cve']) && $filtros['evaluado_user_cve'] != '')
        {
            $this->db->where('evaluado_user_cve', $filtros['evaluado_user_cve']);
        }
        if(isset($filtros['grupos_ids_text']) && $filtros['grupos_ids_text'] != '')
        {
            $this->db->where('grupos_ids_text', $filtros['grupos_ids_text']);
        }
        if(isset($filtros['des_autoevaluacion_cve']) && $filtros['des_autoevaluacion_cve'] != '')
        {
            $this->db->where('des_autoevaluacion_cve'. $filtros['des_autoevaluacion_cve']);
        }
        $query = $this->db->get('encuestas.sse_result_evaluacion_encuesta_curso');
        // pr($this->db->last_query());
        $encuestas = $query->result_array();
        $query->free_result(); //Libera la memoria
        $this->db->flush_cache();
        $this->db->reset_query();
        return $encuestas;
    }
}
