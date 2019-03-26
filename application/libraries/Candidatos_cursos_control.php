<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @version 	: 1.1.0
 * @author      : LEAS
 * */
class Candidatos_cursos_control {

    const EDITA_CANDIDATO = 1, AGREGAR_CANDIDATO = 2, ELIMINAR_CANDIDATO = 3, CARGAR_CSV_CANDIDATOS = 4,
            VALIDAR_CANDIDATO = 5, GENERAR_FORMATO_CSV_SIED = 6, ID_CURSO = 'course_id', NOMBRE_CURSO = 'nombre_curso'

    ;
    const TIPO_CARGA_DEFAULT = 2;

    private $elements;
    private $curso_id;
    private $lista_cursos;
    private $detalle_curso;
    private $detalle_candidatos;
    private $tmp_csv;
    private $res_validacion;
    private $niveles_acceso;
    private $acciones_acceso;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('Candidatos_nom_model', 'cand');
        $this->curso_id = null;
        $this->detalle_curso = null;
    }

    function getCurso_id() {
        return $this->curso_id;
    }

    function getLista_cursos() {
        if (is_null($this->lista_cursos)) {
            $this->lista_cursos = $this->CI->cand->get_cursos_preregistro();
        }
        return $this->lista_cursos;
    }

    function getDetalle_curso() {
        if (is_null($this->detalle_curso) && !is_null($this->curso_id)) {
            $select = array('e.id course_id', 'concat(\'(\', shortname, \') \', fullname) nombre_curso', 'shortname clave_curso',
                'startdatepre inicio_preregistro', 'lastdatepre fin_preregistro', 'cuotacurso cuota',
                'preact', 'achsel', 'category category_id', 'startdate inicio_curso', 'ccat.name category',
                "case when (lastdatepre >= date(now())) then 'tp' else 'ic' end estado"
            );
            $this->detalle_curso = $this->CI->cand->get_cursos_preregistro($this->curso_id, $select);
            if (!empty($this->detalle_curso)) {
                $this->detalle_curso = $this->detalle_curso[0];
            } else {
                $this->detalle_curso = null;
            }
        }
        return $this->detalle_curso;
    }

    /**
     * 
     * @param type $parametros Parametros de configuración
     */
    public function get_formato_candidatos_csv($parametros = null) {
        $array_result['headers'] = array(
            'MATRICULA', "NOMBRE", "PATERNO", "MATERNO",
            "CURP", "CLAVE_CATEGORIA", "NOMBRE_CATEGORIA",
            "CORREO_ELECTRONICO_PRINCIPAL",
            "OTRO_CORREO_ELECTRONICO",
            "CVE_DELEGACION",
        );
        return $array_result;
    }

    /**
     * 
     * @param type $parametros Parametros de configuración
     */
    public function get_formato_sied_csv($parametros = null) {
        $array_result['headers'] = array(
        );
        return $array_result;
    }

    /**
     * 
     * @return type Catalogo de delegaciones
     */
    public function get_calogo_delegaciones() {
        $select = ["cve_delegacion", "nom_delegacion"];
        $order_by = 'cve_delegacion';
        $result['data'] = $this->CI->cand->getConsutasGenerales("departments.ssd_cat_delegacion", $select, null, null, $order_by);
        $result['header'] = $select;
        return $result;
    }

    /**
     * 
     * @return type Catalogo de tipo de cagas
     */
    public function get_calogo_tipo_cargas($parametros = null) {
        $select = ["cve_tipo_carga_candidatos", "descripcion"];
        $where = ["activo" => true];
        if (!is_null($parametros)) {
            if (isset($parametros['where'])) {
                $where = array_merge($where, $parametros['where']);
            }
        }
        $result['header'] = $select;
        $result['data'] = $this->CI->cand->getConsutasGenerales("encuestas.ssc_tipos_carga_candidatos_curso", $select, $where);
        return $result;
    }

    function setCurso_id($curso_id) {
        $this->curso_id = $curso_id;
    }

    function getDetalle_candidatos() {
        return $this->detalle_candidatos;
    }

    function getTmp_csv() {
        return $this->tmp_csv;
    }

    function setTmp_csv($tmp_csv) {
        $this->tmp_csv = $tmp_csv;
    }

    function getElements() {
        return $this->elements;
    }

    function setElements($elements) {
        $this->elements = $elements;
    }

    function getListadoCandidatos($ruta = 'candidatos_cursos/') {
        
    }

    function getRes_validacion() {
        if (is_null($this->res_validacion)) {
            
        }
        return $this->res_validacion;
    }
    
    

    public function busqueda_sied($array_candidatos) {
//        $this->CI->cand->get_usuarios_sied($array_matriculas);
        $result = $this->CI->cand->get_usuarios_sied('99148266');
        return $result;
    }

    private function busqueda_SIAP($array_candidatos, $key_matricula, $key_delegacion) {
        if (is_null($array_candidatos) || !is_array($array_candidatos)) {
            return null;
        }
        $this->CI->load->library("Empleados_siap", null, 'siap');
        $result = [];
        foreach ($array_candidatos as $value) {
            $data_siap['asp_matricula'] = $value[$key_matricula];
            $data_siap['reg_delegacion'] = $value[$key_delegacion];
            $result_tmp = $this->CI->siap->buscar_usuario_siap($data_siap);
            $result[$key_matricula] = $result_tmp;
        }
        return $result;
    }

}
