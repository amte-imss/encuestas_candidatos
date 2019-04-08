<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @version 	: 1.1.0
 * @author      : LEAS
 * */
class Candidatos_cursos_control {

    const EDITA_CANDIDATO = 1, AGREGAR_CANDIDATO = 2, ELIMINAR_CANDIDATO = 3, CARGAR_CSV_CANDIDATOS = 4,
            VALIDAR_CANDIDATO = 5, GENERAR_FORMATO_CSV_SIED = 6,
            ID_CURSO = 'course_id', NOMBRE_CURSO = 'nombre_curso',
            CSVRESULT_HEADER = 'headers', CSVRESULT_STATUS = 'satatus', CSVRESULT_DATA = 'data_csv'

    ;
    const TPCS_EXTERNOS = 1,
            TPCS_ABIERTO = 2,
            TPCS_NOMINATIVO = 3,
            TPCS_EXTRANJERO = 4,
            TPCS_JUBILADO = 5,
            TPCS_ESPECIAL = 6,
            TPCS_SUSTITUTO = 8,
            TPCS_INSCRITO_NOMINATIVO = 9
    ;
    const TIPO_CARGA_DEFAULT = 2;

    private static $candidatos;
    private $elements;
    private $curso_id;
    private $lista_cursos;
    private $detalle_curso;
    private $detalle_candidatos;
    private $tmp_csv;
    private $res_validacion;

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

    public function get_candidatos_implementacion() {
        $result = [];
        if (!is_null($this->getCurso_id())) {

            $select = ["ct.id_candidato", "ct.id_curso", "ct.matricula", "ct.nom", "ct.ap", "ct.am", "curp",
                "ct.email_principal", "ct.emal_otro", "ct.cve_tipo_carga_candidatos",
                "ct.cve_delegacion", "ct.cve_categoria", "categoria", "ct.cve_departamental",
                "ct.departamental", "ct.valido", "cve_tipo_carga_candidatos"];
            $order_by = 'cve_delegacion';
            $where = ["ct.id_curso" => $this->getCurso_id()];
            $result['data'] = $this->CI->cand->getConsutasGenerales("encuestas.ssc_candidatos ct", $select, $where, null, $order_by);
            $result['header'] = $select;
        }
        return $result;
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
        if (!is_null($curso_id) && is_numeric($curso_id)) {//Valida que sea numerico
            $this->curso_id = $curso_id;
        }
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

    /**
     * 
     * @param type $candidatos Array de matriculas (nombre de usuario) 
     * para ver sis existen usuarios en SIED
     * @return type Array con información encontrada
     */
    public function busqueda_sied($candidatos) {
        $result_aux = $this->CI->cand->get_usuarios_sied($candidatos);
        $result = [];
        if (!empty($result_aux)) {//Valida que existan usuarios
            foreach ($result_aux as $value) {//Recorre el resultado para obtener las llaves (matricula name user)
                $result[$value['nom_usuario']] = $value;
            }
        }
//        pr($result);
        return $result_aux;
    }

    /**
     * 
     * @param type $array_candidatos
     * @param type $key_matricula
     * @param type $key_delegacion
     * @return type
     */
    public function busqueda_SIAP($array_candidatos, $key_matricula = 'MATRICULA', $key_delegacion = 'CVE_DELEGACION') {
        if (is_null($array_candidatos) || !is_array($array_candidatos)) {
            return null;
        }
        $this->CI->load->library("Empleados_siap", null, 'siap');
        $result = [];
        foreach ($array_candidatos as $value) {
            $data_siap['asp_matricula'] = $value[$key_matricula];
            $data_siap['reg_delegacion'] = $value[$key_delegacion];
            $data_siap['reg_cve_ctegoria'] = $value['CLAVE_CATEGORIA']; //Tmp borrar al final
            $data_siap['reg_ctegoria'] = $value['NOMBRE_CATEGORIA']; //Tmp borrar al final
            $data_siap['reg_curp'] = $value['CURP']; //Tmp borrar al final
            $data_siap['nombre'] = $value['NOMBRE']; //Tmp borrar al final
            $data_siap['ap'] = $value['PATERNO']; //Tmp borrar al final
            $data_siap['am'] = $value['MATERNO']; //Tmp borrar al final
//            $result_tmp = $this->CI->siap->buscar_usuario_siap($data_siap);//Busca en SIAP
            $result_tmp = $this->tmp_simulador_SIAP($data_siap); //Tmp, borrar simulador
            if (!empty($result_tmp)) {
                $result[$result_tmp['matricula']] = $result_tmp; //Asigna el resultado de la busqueda SIAP 
            }
        }
        return $result;
    }

    private function replace_SIAP($txt, $caracter_busqueda = '&', $caracter_replace = 'ñ') {
        $resultText = ucwords(str_replace($caracter_busqueda, $caracter_replace, $txt));
        return $resultText;
    }

    /**
     * Metodo temporal, para simular la conexión con SIAP 
     * @param type $data_siap
     * @return type
     */
    private function tmp_simulador_SIAP($data_siap) {
        $encontrar = rand(0, 1);
        $result = [];
        if ($encontrar == 1) {
            $result = [
                'matricula' => $data_siap['asp_matricula'],
                'nombre' => $data_siap['nombre'],
                'paterno' => $data_siap['ap'],
                'materno' => $data_siap['am'],
                'sexo' => null,
                'curp' => $data_siap['reg_curp'],
                'rfc' => null,
                'nacimiento' => null,
                'status' => null,
                //'delegacion' => $aspirante->DELEGACION,
                'delegacion' => $data_siap['reg_delegacion'],
                'antiguedad' => null,
                'adscripcion' => null,
                'descripcion' => null,
                'emp_regims' => null,
                'emp_keypue' => $data_siap['reg_cve_ctegoria'],
                'pue_despue' => $data_siap['reg_ctegoria'],
                'fecha_ingreso' => null
            ];
        }
        return $result;
    }

    /**
     * 
     * @param type $post id_curso
     * @param type $array_csv
     * @return type
     */
    public function validacion_csv($post, $array_csv) {
        $result = ['tp_msg' => En_general::DANGER];
        $this->CI->config->load('form_validation');
        $this->CI->load->library('form_validation');
        $validations = $this->CI->config->item('cargar_candidatos_csv'); //Valida que exista un archivo
//        pr($array_csv);
        $this->CI->form_validation->set_data($post); //Asigna el valor del data que va a validar
        $this->CI->form_validation->set_rules($validations);
        if ($this->CI->form_validation->run() == TRUE) {//Valida que exista una archivo y que exista un curso 
            $result = $this->validacion_datos_csv($post, $array_csv);
//            $result['msg'] = 'La información se guardo exitosamente.';
        } else {
            $result['msg'] = validation_errors();
        }
        return $result;
    }

    private function validacion_datos_csv($post, $array_csv) {
        $columns_csv = $array_csv[Candidatos_cursos_control::CSVRESULT_HEADER];
        switch ($post[Candidatos::name_tipo_carga]) {
            case Candidatos_cursos_control::TPCS_ABIERTO:
            case Candidatos_cursos_control::TPCS_ESPECIAL:
            case Candidatos_cursos_control::TPCS_NOMINATIVO:
            case Candidatos_cursos_control::TPCS_INSCRITO_NOMINATIVO:
            case Candidatos_cursos_control::TPCS_JUBILADO:
            case Candidatos_cursos_control::TPCS_SUSTITUTO:
                $result = $this->valida_columnas_csv($columns_csv); //Valida que esten todas las columnas necesarias, en el archivo, para candidatos institucionales
                if ($result['msg'] === En_general::SUCCESS) {
                    $result = $this->valida_datos_instituto_csv($array_csv); //Valida que esten todas las columnas necesarias, en el archivo, para candidatos institucionales
                }
                break;
            case Candidatos_cursos_control::TPCS_EXTERNOS:
            case Candidatos_cursos_control::TPCS_EXTRANJERO:
                $result = $this->valida_columnas_csv($columns_csv, 'columnas_csv_candidatos_externos'); //Valida que esten todas las columnas necesarias, en el archivo, para candidatos externos
                if ($result['msg'] === En_general::SUCCESS) {
                    $result = $this->valida_datos_externos_csv($array_csv); //Valida que esten todas las columnas necesarias, en el archivo, para candidatos institucionales
                }
                break;
            default :
                $result = $this->valida_columnas_csv($columns_csv); //Valida que esten todas las columnas necesarias, en el archivo, para candidatos institucionales
                if ($result['msg'] === En_general::SUCCESS) {
                    $result = $this->valida_datos_csv($array_csv); //Valida que esten todas las columnas necesarias, en el archivo, para candidatos institucionales
                }
        }
        return $result;
    }

    private function valida_columnas_csv($columnas_archivo, $name_validation = 'columnas_csv_candidatos_imss') {
        $validations = $this->CI->config->item($name_validation);
        $aux_val = null;
        foreach ($columnas_archivo as $col) {
            $aux_val[$col] = $col;
        }
        $this->CI->form_validation->set_data($aux_val); //Asigna el valor del data que va a validar
        $this->CI->form_validation->set_rules($validations);
        if ($this->CI->form_validation->run() == TRUE) {//Valida que exista una archivo y que exista un curso 
            $result = ['tp_msg' => En_general::SUCCESS];
            $result['msg'] = En_general::SUCCESS;
        } else {
            $result = ['tp_msg' => En_general::DANGER];
            $result['msg'] = validation_errors();
        }
        return $result;
    }

    private function _get_datos_instituto($array_csv) {
        $array_datacsv_aux = $array_csv[Candidatos_cursos_control::CSVRESULT_DATA];
        $array_datacsv = [];
        $array_matriculas = [];
        foreach ($array_datacsv_aux as $value) {//Obtiene todas las marriculas o identificadores
            $array_datacsv[$value['MATRICULA']] = $value;
            $array_matriculas[] = $value['MATRICULA'];
        }
        $result = ['tp_msg' => En_general::SUCCESS];
//        $result['msg'] = 'Información guardada correctamente ';
        $result['matriculas'] = $array_matriculas;
        $result['busqueda_sied'] = $this->busqueda_sied($array_matriculas);
        $result['busqueda_siap'] = $this->busqueda_SIAP($array_datacsv);
        pr($result);
//        $validations = $this->CI->config->item($name_validation);
        return $result;
    }
    private function _get_datos_externos($array_csv) {
        $array_datacsv_aux = $array_csv[Candidatos_cursos_control::CSVRESULT_DATA];
        $array_datacsv = [];
        $array_matriculas = [];
        foreach ($array_datacsv_aux as $value) {//Obtiene todas las marriculas o identificadores
            $array_datacsv[$value['MATRICULA']] = $value;
            $array_matriculas[] = $value['MATRICULA'];
        }
        $result['matriculas'] = $array_matriculas;
        $result['busqueda_sied'] = $this->busqueda_sied($array_matriculas);
        
    }

    private function valida_datos_externos_csv($array_csv, $name_validation = 'datos_csv_candidatos_imss') {
        
    }

    /**
     * 
     * @param type $post Datos de post, curso id, archivo id, tipo carga sied 
     * @param type $array_csv, Datos del CSV
     */
    private function validacion_carga_archivo($post, $array_csv) {
        
    }

    private function validacion_registro() {
        
    }

}
