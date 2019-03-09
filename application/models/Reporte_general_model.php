<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que obtiene información (porcentaje general y datos de las implementaciones) almacenadas en la base de datos para el reporte general por regla de evaluación.
 * @version 	: 1.0.0
 * @autor 	: JZDP
 */
class Reporte_general_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->config->load('general');
        // $this->load->database();
    }

    /**
     * Método que extrae información de las implementaciones requeridas, de acuerdo a filtros seleccionados. Información puede ser limitada(limit) para uso en paginación o puede extraerse por completo, utilizada durante la exportación.
     * @param array $param Parámetros (filtros) recibidos del formulario mostrado al usuario. Se incluyen además variables:
     *      string anio                     Año de la implementación
     *      string tipo_buscar_instrumento  Identifica el tipo de búsqueda, por clave o nombre de la implementación
     *      string text_buscar_instrumento  Valor que será buscado de acuerdo al tipo (tipo_buscar_instrumento)
     *      string tipo_implementacion      Identifica si la implementación es tutorizada o no.
     *      string is_bono                  Identifica si la implementación aplica para bono o no.
     *      string order, order_type        El tipo y el ordenamiento que tendrán los datos.
     *      string per_page                 Número de registros a mostrarse, debe estar activada la paginación.
     *      string current_row              Número de registro donde iniciará la paginación, debe estar activada la paginación.
     *      string export                   Identifica si los resultados serán limitados (limit) o serán mostrados en su totalidad.
     * @return array Información de implementaciones
     */
    public function get_reporte_general_datos($params = null) {
        $resultado = array();
        ///////////////////// Iniciar almacenado de parámetros en cache /////////////////////////
        $this->db->start_cache();
        $this->db->select('eeec.course_cve, vdc.clave'); //, eva.evaluado_rol_id, eva.evaluador_rol_id

        if (isset($params['anio']) && !empty($params['anio'])) { //Año
            $this->db->where("vdc.anio='" . $params['anio'] . "'");
        }
        if (isset($params['text_buscar_instrumento']) && !empty($params['text_buscar_instrumento'])) { //Clave o nombre de instrumento
            if ($params['tipo_buscar_instrumento'] === "clavecurso") {
                $this->db->where("lower(vdc.clave) like lower('%" . $params['text_buscar_instrumento'] . "%')");
            } else {
                $this->db->where("lower(vdc.namec) like lower('%" . $params['text_buscar_instrumento'] . "%')");
            }
        }
        if (isset($params['tipo_implementacion']) && $params['tipo_implementacion'] != "") { //Tipo de implementación
            $this->db->where("vdc.tutorizado=" . $params['tipo_implementacion']);
        }
        if (isset($params['is_bono']) and $params['is_bono'] != "") { //Aplica para bono
            $this->db->where("enc.is_bono =" . $params['is_bono']);
        }

        $this->db->join('encuestas.view_datos_curso vdc', 'vdc.idc=eeec.course_cve');
        $this->db->join('encuestas.sse_encuestas enc', 'enc.encuesta_cve=eeec.encuesta_cve');

        $this->db->group_by("eeec.course_cve, vdc.clave, vdc.namec, vdc.tutorizado, vdc.tex_tutorizado, vdc.tipo_curso, enc.is_bono");

        $this->db->stop_cache();
        /////////////////////// Fin almacenado de parámetros en cache ///////////////////////////
        ///////////////////////////// Obtener número de registros ///////////////////////////////
        $nr = $this->db->get_compiled_select('encuestas.sse_result_evaluacion_encuesta_curso eeec'); //Obtener el total de registros
        $num_rows = $this->db->query("SELECT count(*) AS total FROM (" . $nr . ") AS temp")->result(); ///*, array_agg(DISTINCT(encuesta_cve)) as encuestas, array_agg(DISTINCT(encuesta_cve, course_cve)) as enc_cur_eva_evar*/
        //pr($this->db->last_query());
        /////////////////////////////// FIN número de registros /////////////////////////////////
        $busqueda = array("eeec.course_cve", "vdc.clave", "vdc.namec", "vdc.tex_tutorizado", "vdc.tutorizado", "vdc.tipo_curso", "enc.is_bono");

        $this->db->select($busqueda);
        if (isset($params['order']) && !empty($params['order'])) {
            $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
            $this->db->order_by($params['order'], $tipo_orden);
        }
        if (!isset($params['export']) || (isset($params['export']) && $params['export'] == false)) {
            if (isset($params['per_page']) && isset($params['current_row'])) { //Establecer límite definido para paginación 
                $this->db->limit($params['per_page'], $params['current_row']);
            }
        }
        $query = $this->db->get('encuestas.sse_result_evaluacion_encuesta_curso eeec'); //Obtener conjunto de registros        
        //pr($this->db->last_query());
        $this->db->flush_cache();

        $resultado['total'] = $num_rows[0]->total;
        $resultado['data'] = $query->result_array();
        $resultado['promedio'] = $this->get_reporte_general_promedio($params);

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function get_reporte_general_promedio($params) {
        $resultado = array();
        $this->db->select(array("eeec.course_cve", "reg.tutorizado", "enc.is_bono", "reg.rol_evaluado_cve", "reg.rol_evaluador_cve",
            //"case sum(base) when 0 then 0 else round(sum(total_puntua_si)::numeric * 100/sum(base)::numeric,3) end as promedio",
            "case sum(base_napb) when 0 then 0 else round(sum(total_puntua_si_napb)::numeric * 100/sum(base_napb)::numeric,3) end as promedio"));

        if (isset($params['anio']) && !empty($params['anio'])) { //Año
            $this->db->where("vdc.anio='" . $params['anio'] . "'");
        }
        if (isset($params['text_buscar_instrumento']) && !empty($params['text_buscar_instrumento'])) { //Clave o nombre de instrumento
            if ($params['tipo_buscar_instrumento'] === "clavecurso") {
                $this->db->where("lower(vdc.clave) like lower('%" . $params['text_buscar_instrumento'] . "%')");
            } else {
                $this->db->where("lower(vdc.namec) like lower('%" . $params['text_buscar_instrumento'] . "%')");
            }
        }
        if (isset($params['tipo_implementacion']) && $params['tipo_implementacion'] != "") { //Tipo de implementación
            $this->db->where("vdc.tutorizado=" . $params['tipo_implementacion']);
        }
        if (isset($params['is_bono']) and $params['is_bono'] != "") { //Aplica para bono
            $this->db->where("enc.is_bono =" . $params['is_bono']);
        }

        $this->db->join('encuestas.sse_encuesta_curso encc', 'encc.course_cve = eeec.course_cve and encc.encuesta_cve = eeec.encuesta_cve');
        $this->db->join('encuestas.view_datos_curso vdc', 'vdc.idc=eeec.course_cve', 'left');
        $this->db->join('encuestas.sse_encuestas enc', 'enc.encuesta_cve=eeec.encuesta_cve');
        $this->db->join('encuestas.sse_reglas_evaluacion reg', 'reg.reglas_evaluacion_cve = enc.reglas_evaluacion_cve');

        $this->db->group_by("eeec.course_cve, reg.tutorizado, enc.is_bono, reg.rol_evaluado_cve, rol_evaluador_cve");

        $query = $this->db->get('encuestas.sse_result_evaluacion_encuesta_curso eeec'); //Obtener conjunto de registros        
        //pr($this->db->last_query());

        $result = $query->result_array(); //Los resultados son extraídos en formato arreglo
        $query->free_result(); //Libera la memoria

        $resultado['promedio'] = array();
        foreach ($result as $val) { //Se genera arreglo con promedios
            $resultado['promedio'][$val['course_cve']][$val['rol_evaluador_cve'] . '-' . $val['rol_evaluado_cve'] . '-' . $val['tutorizado']] = $val;
        }

        return $resultado;
    }

    public function get_reporte_gral_datos($parametros) {
        $result_reporte = array();
        $parametros;
        if ($parametros['tipo_curso'] == 1) {//Is tutorizado
            $result_reporte = array(
                array(
                )
            );
        } else {//No tutorizado
            $result_reporte = array(
            );
        }

        return $result_reporte;
    }

}
