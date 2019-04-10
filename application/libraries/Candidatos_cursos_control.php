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
    const MATRICULA = 'MATRICULA', NOMBRE = "NOMBRE", PATERNO = "PATERNO", MATERNO = "MATERNO",
            CURP = "CURP", CVE_CATEGORIA = "CLAVE_CATEGORIA", NOMBRE_CATEGORIA = "NOMBRE_CATEGORIA",
            CORREO_ELECTRONICO_PRINCIPAL = "CORREO_ELECTRONICO_PRINCIPAL",
            OTRO_CORREO_ELECTRONICO = "OTRO_CORREO_ELECTRONICO",
            CVE_DELEGACION = "CVE_DELEGACION", CATEGORIA = 'CATEGORIA',
            CVE_ADSCRIPCION = 'CVE_ADSCRIPCION', ADSCRIPCION = 'ADSCRIPCION', VALIDACIONES = 'VALIDACIONES'

    ;
    const TB_SIED = 'busqueda_sied', TB_SIAP = 'busqueda_siap',
            TB_V_CANDIDATOS_CURSOS_APROBADOS = 'aprobados_curso',
            TB_V_PROCESO_CANDITATOS = 'busqueda_proceso_candidatos',
            TB_V_INSCRITOS_PERIODO = 'busqueda_inscritos_periodo', TB_DATOS_CSV = 'datos_csv',
            TB_MATRICULAS = 'matriculas',
            TB_DATOS_PRE_VALIDADOS = 'datos_pre_validados',
            TB_DATOS_PRE_VALIDADOS_ERROR = 'datos_pre_validados_error'

    ;

    private static $datos_candidatos_csv;
    private $elements;
    private $curso_id;
    private $user_sesion_id;
    private $clave_curso;
    private $lista_cursos;
    private $detalle_curso;
    private $detalle_candidatos;
    private $tmp_csv;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('Candidatos_nom_model', 'cand');
        $this->curso_id = null;
        $this->detalle_curso = null;
    }

    static function getDatos_candidatos_csv() {
        return self::$datos_candidatos_csv;
    }

    static function setDatos_candidatos_csv($datos_candidatos_csv) {
        self::$datos_candidatos_csv = $datos_candidatos_csv;
    }

    function getUser_sesion_id() {
        return $this->user_sesion_id;
    }

    function setUser_sesion_id($user_sesion_id) {
        $this->user_sesion_id = $user_sesion_id;
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

    function getClave_curso() {
        if (is_null($this->clave_curso)) {
            $detalle_curso = $this->getDetalle_curso();
            if (!empty($detalle_curso)) {
                $this->clave_curso = $detalle_curso['clave_curso'];
            }
        }
        return $this->clave_curso;
    }

    function setClave_curso($clave_curso) {
        $this->clave_curso = $clave_curso;
    }

    function getDetalle_curso() {
        if (is_null($this->detalle_curso) && !is_null($this->curso_id)) {
            $select = array('e.id course_id', 'concat(\'(\', shortname, \') \', fullname) nombre_curso'
                , 'shortname clave_implementacion',
                'substring(shortname from 1 for position(substring(shortname from $$\-\w\d+\-\d+$$) in shortname)-1) clave_curso',
                'e.startdatepre inicio_preregistro', 'e.lastdatepre fin_preregistro', 'e.cuotacurso cuota',
                'e.preact', 'e.achsel', 'e.category category_id', 'e.startdate inicio_curso', 'ccat.name category',
                "case when ccg.tutorizado = 1 then 'Tutorizado' else 'No tutorizado' end tutorizado",
                "case when (e.lastdatepre >= date(now())) then 'tp' else 'ic' end estado",
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
            self::MATRICULA, self::NOMBRE, self::PATERNO, self::MATERNO,
            self::CURP, self::CVE_CATEGORIA, self::NOMBRE_CATEGORIA,
            self::CORREO_ELECTRONICO_PRINCIPAL,
            self::OTRO_CORREO_ELECTRONICO,
            self::CVE_DELEGACION,
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

//    function getListadoCandidatos($ruta = 'candidatos_cursos/') {
//        
//    }
//
//    function getRes_validacion() {
//        if (is_null($this->res_validacion)) {
//            
//        }
//        return $this->res_validacion;
//    }

    /**
     * 
     * @param type $candidatos Array de matriculas (nombre de usuario) 
     * para ver sis existen usuarios en SIED
     * @param type $is_matricula Valida si la busqueda será por matricula o por nombre
     * @return type Array con información encontrada
     */
    public function busqueda_sied($candidatos, $is_matricula = true) {
        if ($is_matricula) {
            $result_aux = $this->CI->cand->get_usuarios_sied($candidatos);
        } else {
            $result_aux = $this->CI->cand->get_usuarios_sied_por_nombre($candidatos);
        }
        $result = [];
        if (!empty($result_aux)) {//Valida que existan usuarios
            foreach ($result_aux as $value) {//Recorre el resultado para obtener las llaves (matricula name user)
                $result[$value['nom_usuario']] = $value;
            }
        }
        return $result;
    }

    public function busqueda_cursos_aprobados($matriculas, $clave_curso = null) {
        if (is_null($clave_curso)) {
            $clave_curso = $this->getClave_curso(); //Obtiene la clave del curso
        }
        $result_aux = $this->CI->cand->get_usuarios_curso_aprobado($matriculas, $clave_curso);
        $result = [];
        if (!empty($result_aux)) {//Valida que existan usuarios
            foreach ($result_aux as $value) {//Recorre el resultado para obtener las llaves (matricula name user)
                $result[$value['username']] = $value;
            }
        }
        return $result;
    }

    /**
     * 
     * @param type $array_candidatos
     * @param type $key_matricula
     * @param type $key_delegacion
     * @return type
     */
    protected function busqueda_SIAP($array_candidatos, $key_matricula = 'MATRICULA', $key_delegacion = 'CVE_DELEGACION') {
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
                $result_tmp['nombre_old'] = $result_tmp['nombre']; //Almacena el nombre de SIAP 
                $result_tmp['paterno_old'] = $result_tmp['paterno'];
                $result_tmp['materno_old'] = $result_tmp['materno'];
                $result_tmp['nombre'] = $this->replace_SIAP($result_tmp['nombre']); //Limpiar cadena y reemplazar caracter & por Ñ
                $result_tmp['paterno'] = $this->replace_SIAP($result_tmp['paterno']);
                $result_tmp['materno'] = $this->replace_SIAP($result_tmp['materno']);
                $result[$result_tmp['matricula']] = $result_tmp; //Asigna el resultado de la busqueda SIAP 
            }
        }
        return $result;
    }

    /**
     * 
     * @param type $txt Texto a analizar
     * @param type $caracter_busqueda Busqueda de caracteres o aguja
     * @param type $caracter_replace Caracter con que se reemplazara
     * @return type
     */
    public function replace_SIAP($txt, $caracter_busqueda = '&', $caracter_replace = 'ñ') {
        $resultText = ucwords(strtolower(str_replace($caracter_busqueda, $caracter_replace, $txt)));
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
     * @return type Prepara todo para la carga csv 
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
            pr($result);
            if ($result['tp_msg'] === En_general::SUCCESS) {//Guardar datos 
                $datos = self::getDatos_candidatos_csv();
                $datosValidos = $datos[self::TB_DATOS_PRE_VALIDADOS];
                $tipo_carga = (isset($post['tipo_carga_sied'])) ? $post['tipo_carga_sied']: self::TIPO_CARGA_DEFAULT; 
                $result = $this->guardar_registros_candidatos($datosValidos, $tipo_carga);
                $result[self::TB_DATOS_PRE_VALIDADOS_ERROR] = $datos[self::TB_DATOS_PRE_VALIDADOS_ERROR];
                if ($result['tp_msg'] === En_general::SUCCESS) {//Guardar datos 
                }
            }
//            $result['msg'] = 'La información se guardo exitosamente.';
        } else {
            $result['msg'] = validation_errors();
        }
        return $result;
    }

    private function guardar_registros_candidatos($datos, $tipoCarga) {
        $result = [];
        $data = [];
//        pr($datos);
        foreach ($datos as $value) {
//            if (!isset($value[self::MATRICULA])) {
//                pr($value);
//                break;
//            }
            $data['matricula'] = $value[self::MATRICULA];
            $data['nom'] = $value[self::NOMBRE];
            $data['ap'] = $value[self::PATERNO];
            $data['am'] = $value[self::MATERNO];
            $data['id_curso'] = $this->getCurso_id();
            $data['cve_curso'] = $this->getClave_curso();
            $data['curp'] = $value[self::CURP];
            $data['email_principal'] = $value[self::CORREO_ELECTRONICO_PRINCIPAL];
            $data['cve_categoria'] = $value[self::CVE_CATEGORIA];
            $data['categoria'] = $value[self::CATEGORIA];
            $data['cve_departamental'] = $value[self::CVE_ADSCRIPCION];
            $data['departamental'] = $value[self::ADSCRIPCION];
            $data['cve_delegacion'] = $value[self::CVE_DELEGACION];
            $data['id_user_registro'] = $this->getUser_sesion_id();
            $data['cve_tipo_carga_candidatos'] = $tipoCarga;
//            pr('$data');
//            pr($data);
            $result = $this->CI->cand->insert_registro_general('encuestas.ssc_candidatos', $data, [], 'id_candidato');
        }
        return $result;
    }

    /**
     * 
     * @param type $post
     * @param type $array_csv
     * @return type
     * Identifica que tipo de validación se ejecutara, si es para 
     * institucionales o externos
     */
    private function validacion_datos_csv($post, $array_csv) {
        $columns_csv = $array_csv[Candidatos_cursos_control::CSVRESULT_HEADER]; //Obtiene las cabeceras del archivo 

        switch ($post[Candidatos::name_tipo_carga]) {
            /* case Candidatos_cursos_control::TPCS_ABIERTO:
              case Candidatos_cursos_control::TPCS_ESPECIAL:
              case Candidatos_cursos_control::TPCS_NOMINATIVO:
              case Candidatos_cursos_control::TPCS_INSCRITO_NOMINATIVO:
              case Candidatos_cursos_control::TPCS_JUBILADO:
              case Candidatos_cursos_control::TPCS_SUSTITUTO:
              $result = $this->valida_columnas_csv($columns_csv); //Valida que esten todas las columnas necesarias, en el archivo, para candidatos institucionales
              if ($result['tp_msg'] === En_general::SUCCESS) {
              $r_d = $this->_genera_datos_internos_csv($array_csv[Candidatos_cursos_control::CSVRESULT_DATA]); //Valida que esten todas las columnas necesarias, en el archivo, para candidatos institucionales
              }
              break; */
            case Candidatos_cursos_control::TPCS_EXTERNOS:
            case Candidatos_cursos_control::TPCS_EXTRANJERO:
                $result = $this->valida_columnas_csv($columns_csv); //Valida que esten todas las columnas necesarias, en el archivo, para candidatos externos
                if ($result['tp_msg'] === En_general::SUCCESS) {
                    $result = $this->_genera_datos_externos_csv($array_csv[Candidatos_cursos_control::CSVRESULT_DATA]); //Valida que esten todas las columnas necesarias, en el archivo, para candidatos institucionales
                }
                break;
            default :
                $result = $this->valida_columnas_csv($columns_csv); //Valida que esten todas las columnas necesarias, en el archivo, para candidatos institucionales
                if ($result['tp_msg'] === En_general::SUCCESS) {
                    $r_d = $this->_genera_datos_internos_csv($array_csv[Candidatos_cursos_control::CSVRESULT_DATA]); //Carga los datos para validaciono
                    $array_datos = $this->depurar_datos_csv($r_d); //Limpia datos, pre validaciones y errores
                    self::setDatos_candidatos_csv(array_merge($r_d, $array_datos)); //Asigna a una variable estatica los resultadso
                }
        }
        return $result;
    }

    /**
     * Valida que existan las columnas necesarias, segun el caso, para cargar 
     * la información correctamente
     * @param type $columnas_archivo
     * @param type $name_validation
     * @return type
     */
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

    /**
     * Requiere la llave por registro [] MATRICULA y CVE_DELEGACION
     * @param type $array_datacsv_aux
     * @return type
     */
    private function _genera_datos_internos_csv($array_datacsv_aux) {
        $array_datacsv = [];
        $array_matriculas = [];
        foreach ($array_datacsv_aux as $value) {//Obtiene todas las marriculas o identificadores
            $array_datacsv[$value['MATRICULA']] = $value;
            $array_matriculas[] = $value['MATRICULA'];
        }
        $result = ['tp_msg' => En_general::SUCCESS];
//        $result['msg'] = 'Información guardada correctamente ';
        $result[self::TB_V_CANDIDATOS_CURSOS_APROBADOS] = $this->busqueda_cursos_aprobados($array_matriculas);
        $result[self::TB_MATRICULAS] = $array_matriculas; //Arreglo de matriculas o identificadores
        $result[self::TB_DATOS_CSV] = $array_datacsv;
        $result[self::TB_SIED] = $this->busqueda_sied($array_matriculas);
        $result[self::TB_SIAP] = $this->busqueda_SIAP($array_datacsv);
        self::setDatos_candidatos_csv($result); //Asigna en la variable estatica 
//        $validations = $this->CI->config->item($name_validation);
        return $result;
    }

    /**
     * Depura la información, separa los datos que cumplen de los que no cumplen
     * @param type $result_array
     */
    private function depurar_datos_csv($result_array) {
        if (!is_null($result_array) && !empty($result_array)) {
            $result [self::TB_DATOS_PRE_VALIDADOS] = [];
            $result [self::TB_DATOS_PRE_VALIDADOS_ERROR] = [];
            foreach ($result_array[self::TB_DATOS_CSV] as $value) {//Recorre el array de los datos del CSV
                $this->complementa_datos_candidatos_internos($value[self::MATRICULA], $result_array, $result['datos_pre_validados'], $result['datos_pre_validados_error']);
            }
        }
        return $result;
    }

    private function complementa_datos_candidatos_internos($key_matricula, $array_datos_candidatos, &$array_result_validos, &$array_result_error) {
        $result = [];
        $banderaAuxValidacion = TRUE;
        $text_validacion = '';
        $separacion = '';
        if (!isset($array_result_validos[$key_matricula]) && !isset($array_result_error[$key_matricula])) {//Valida que no exista ya registrado o catalogado
            if (isset($array_datos_candidatos[self::TB_SIAP][$key_matricula])) {//Valida que exista el usuario en SIAP
                if (isset($array_datos_candidatos[self::TB_V_CANDIDATOS_CURSOS_APROBADOS][$key_matricula])) {//Caso de encontrar información en sied
                    //Retorna Error de que se encuentra en curso
                    $banderaAuxValidacion = FALSE;
                    $text_validacion .= $separacion . 'El candidato aprobo el curso con clave: ' . $array_datos_candidatos[self::TB_V_CANDIDATOS_CURSOS_APROBADOS][$key_matricula]['shortname'];
                    $separacion = "\n";
                }
                //Valida que no exista ya registrado como candidato en este y los demás cursos
                if (isset($array_datos_candidatos[self::TB_V_PROCESO_CANDITATOS][$key_matricula])) {//Caso de encontrar información en sied
                    //Retorna Error de que se encuentra en curso
                    $banderaAuxValidacion = FALSE;
                    $text_validacion .= $separacion . 'El candidato se encuentra en un proceso actualmente ';
                    $separacion = "\n";
                }
                //Valida que no se encuentren en periodo de inscripcion
                if (isset($array_datos_candidatos[self::TB_V_INSCRITOS_PERIODO][$key_matricula])) {//Caso de encontrar información en sied
                    //Retorna Error de que se encuentra en curso
                    $banderaAuxValidacion = FALSE;
                    $text_validacion .= $separacion . 'El candidato se encuentra inscrito en un curso que se empalma con las fechas ';
                    $separacion = "\n";
                }
                if ($banderaAuxValidacion) {//El candidato no presenta problema alguno para inscribirse
                    $array_result_validos[$key_matricula] = [self::MATRICULA => $key_matricula];
                    if (isset($array_datos_candidatos[self::TB_SIED][$key_matricula])) {//Caso de encontrar información en sied
                        $this->recarga_datos_sied($array_result_validos[$key_matricula], $array_datos_candidatos[self::TB_SIED][$key_matricula]);
                        $this->recarga_datos_imss_siap($array_result_validos[$key_matricula], $array_datos_candidatos[self::TB_SIAP][$key_matricula]);
                    } else {
                        $this->recarga_datos_personales_siap($array_result_validos[$key_matricula], $array_datos_candidatos[self::TB_SIAP][$key_matricula]);
                        $this->recarga_datos_imss_siap($array_result_validos[$key_matricula], $array_datos_candidatos[self::TB_SIAP][$key_matricula]);
                        //Asigna el correo del archivo CSV
                        $this->recarga_correo_electronico_csv($array_result_validos[$key_matricula], $array_datos_candidatos[self::TB_DATOS_CSV][$key_matricula]);
                    }
                } else {//Agregar a arreglo de erroles
                    $array_result_error[$key_matricula] = $array_datos_candidatos[self::TB_DATOS_CSV][$key_matricula]; //Asigna los mismos valores del CSV para regresarlos
                    $array_result_error[$key_matricula][self::VALIDACIONES] = $text_validacion; //Agrga el texto de validacion
                }
            } else {//No se encontro información del candidato
                $text_validacion .= 'No se encontro información del candidato';
                $array_result_error[$key_matricula] = $array_datos_candidatos[self::TB_DATOS_CSV][$key_matricula]; //Asigna los mismos valores del CSV para regresarlos
                $array_result_error[$key_matricula][self::VALIDACIONES] = $text_validacion; //Agrga el texto de validacion
            }
        }
        return $result;
    }

    private function recarga_correo_electronico_csv(&$data, $datos_csv) {
        $data[self::CORREO_ELECTRONICO_PRINCIPAL] = $datos_csv[self::CORREO_ELECTRONICO_PRINCIPAL];
    }

    private function recarga_datos_csv(&$data, $datos_csv) {
        $data[self::NOMBRE] = $datos_csv[self::NOMBRE];
        $data[self::PATERNO] = $datos_csv[self::PATERNO];
        $data[self::MATERNO] = $datos_csv[self::MATERNO];
        $data[self::CORREO_ELECTRONICO_PRINCIPAL] = $datos_csv[self::CORREO_ELECTRONICO_PRINCIPAL];
        $data[self::CURP] = (isset($datos_csv[self::CURP])) ? $datos_csv[self::CURP] : '';
    }

    private function recarga_datos_sied(&$data, $datos_sied) {
        $data[self::NOMBRE] = $datos_sied['nom_nombre'];
        $data[self::PATERNO] = $datos_sied['nom_paterno'];
        $data[self::MATERNO] = $datos_sied['nom_materno'];
        $data[self::CORREO_ELECTRONICO_PRINCIPAL] = $datos_sied['des_email_pers'];
        $data[self::CURP] = $datos_sied['nom_curp'];
    }

    private function recarga_datos_personales_siap(&$data, $datos_siap) {
        $data[self::NOMBRE] = $datos_siap['nombre'];
        $data[self::PATERNO] = $datos_siap['paterno'];
        $data[self::MATERNO] = $datos_siap['materno'];
        $data[self::CURP] = $datos_siap['curp'];
    }

    private function recarga_datos_imss_siap(&$data, $datos_siap) {
        $data[self::CVE_CATEGORIA] = $datos_siap['emp_keypue'];
        $data[self::CATEGORIA] = $datos_siap['pue_despue'];
        $data[self::CVE_ADSCRIPCION] = $datos_siap['adscripcion'];
        $data[self::ADSCRIPCION] = $datos_siap['descripcion'];
        $data[self::CVE_DELEGACION] = $datos_siap['delegacion'];
    }

    private function _genera_datos_externos_csv($array_csv) {
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
