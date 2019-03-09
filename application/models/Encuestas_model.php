<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Encuestas_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->config->load('general');
        $this->load->database();
    }

    public function get_preguntas_encuesta($filtros = array()) {
        $resultado = array('result' => false, 'data' => null);
        if (isset($filtros['encuesta_cve']) && $filtros['encuesta_cve'] != '') {
            $this->db->where('A.encuesta_cve', $filtros['encuesta_cve']);
        }
        if (isset($filtros['seccion_cve']) && $filtros['seccion_cve'] != '') {
            $this->db->where('A.seccion_cve', $filtros['seccion_cve']);
        }
        $this->db->order_by('orden', 'ASC');
        $query = $this->db->get('encuestas.sse_preguntas A'); //Obtener conjunto de registros
        //pr($query);
        if ($query->num_rows() > 0) {
            $resultado['result'] = true;
            $resultado['data'] = $query->result_array();
        }
        $query->free_result();
        //pr($this->db->last_query());
        return $resultado;
    }

    public function regla_disponible($rol_evaluador = '', $rol_a_evaluar = '') {
        $resultado = array('result' => false, 'id' => null);

        $params = array(
            'rol_evaluado_cve' => $rol_a_evaluar,
            'rol_evaluador_cve' => $rol_evaluador
        );

        $id_regla_evaluacion = $this->get_id_regla($params);

        $this->db->where('reglas_evaluacion_cve', $id_regla_evaluacion['id']['reglas_evaluacion_cve']);
        $this->db->where('is_bono = 1');
        $query = $this->db->get('encuestas.sse_encuestas'); //Obtener conjunto de registros
        //pr($query);
        if ($query->num_rows() > 0) {
            $resultado['result'] = true;
            $resultado['id'] = $query->result_array()[0];
        }

        //pr($this->db->last_query());
        return $resultado;
    }

    public function guarda_edita_instrumento($encuesta_cve, $valores = array()) {
        /*
          [is_bono] => 1
          [status] => 1
          [descripcion_encuestas] => Encuesta ccttna prueba 2016
          [cve_corta_encuesta] => CCTTNA2016
          [regla_evaluacion_cve] => 1
          [btn_submit] => Guardar instrumento
         */
        $this->db->trans_begin();

        $this->db->where('sse_encuestas.encuesta_cve', $encuesta_cve);

        $datos_actualiza = array(
            'is_bono' => ((isset($valores['is_bono']) && !empty($valores['is_bono'])) ? $valores['is_bono'] : 0 ),
            'status' => ((isset($valores['status']) && !empty($valores['status'])) ? $valores['status'] : 0 ),
            'descripcion_encuestas' => $valores['descripcion_encuestas'],
            'cve_corta_encuesta' => $valores['cve_corta_encuesta'],
            'reglas_evaluacion_cve' => $valores['regla_evaluacion_cve'],
            'tipo_encuesta' => $valores['tipo_instrumento'],
            'eva_tipo' => $valores['eva_tipo'],
            'guia_descripcion_encuesta' => ((isset($valores['guia_descripcion_encuesta']) && !empty($valores['guia_descripcion_encuesta'])) ? $valores['guia_descripcion_encuesta'] : '' ),
        );

        $this->db->update('encuestas.sse_encuestas', $datos_actualiza);

        if ($this->db->trans_status() === FALSE) { // condición para ver si la transaccion se efectuara correctamente
            $this->db->trans_rollback(); // si la transacción no es correcta retornar FALSE
            $bandera = false;
        } else {
            $this->db->trans_commit(); // si la transacción es correcta retornar TRUE
            $bandera = true;
        }
        $this->db->trans_complete();
        return $bandera;
    }

    public function guarda_instrumento($instrumento = array()) {
        /* # guarda el nombre del instrumento...
          descripcion_encuesta

         * # retorna el id del instrumento y el id creado para identificar las preguntas...
          encuesta_cve
          id_instrumento_enc
         */
        //pr($instrumento);
        //exit();
        $data['descripcion_encuestas'] = $instrumento['descripcion_encuestas'];
        //$data['is_bono']=$instrumento['descripcion_encuestas'];
        //$data['rol_id']=$instrumento['rol_instrumento'];
        //$data['tutorizado']=$instrumento['instrumento_tutorizado'];
        //pr($instrumento['eva_tipo']['valor']);
        //die();
        $data['status'] = 0;
        $data['cve_corta_encuesta'] = $instrumento['cve_corta_encuesta'];
        $data['reglas_evaluacion_cve'] = $instrumento['reglas_evaluacion_cve'];
        $data['tipo_encuesta'] = $instrumento['tipo_encuesta'];
        $data['eva_tipo'] = $instrumento['eva_tipo']['valor'];



        $data['fecha_creacion'] = date('Y-m-d');

        $this->db->insert('encuestas.sse_encuestas', $data);
        $insert_id = $this->db->insert_id();

        $row = array(
            'insert_id' => $insert_id,
            'id_instrumento_enc' => $instrumento['id_instrumento_enc']
        );
        //echo" {";
        return $row;
    }

    public function instrumento_bono($id_encuesta) {

        $data = array(
            'is_bono' => 1
        );

        $this->db->where('encuesta_cve', $id_encuesta);
        $this->db->update('encuestas.sse_encuestas', $data);
    }

    public function guarda_nueva_pregunta($pregunta = array(), $instrumento_id = null, $seccion_id = null) {
        $this->db->trans_begin();

        $indicador_id = $pregunta['tipo_indicador_cve'];
        $id_pregunta = $this->guarda_pregunta($pregunta, $instrumento_id, $seccion_id, $indicador_id);

        $respuestas_nuevas = (isset($pregunta['respuestas']) && is_array($pregunta['respuestas'])) ? $pregunta['respuestas'] : '';

        if (is_array($respuestas_nuevas)) {
            foreach ($respuestas_nuevas as $respuesta) {
                $this->guarda_respuesta($respuesta, $id_pregunta, $instrumento_id);
            }
        }//else trans_complete () trans_rollback return false
        if ($this->db->trans_status() != true) {
            $this->db->trans_rollback();
            $resultado['success'] = FALSE;
        } else {
            $this->db->trans_commit();
            $resultado['success'] = TRUE;
            $resultado['id_pregunta'] = $id_pregunta;
        }
        $this->db->trans_complete();
        return $resultado;
    }

    public function guarda_pregunta($pregunta = array(), $instrumento_id = null, $seccion_id = null, $indicador_id = null) {


        $data['encuesta_cve'] = $instrumento_id;
        $data['seccion_cve'] = $seccion_id;

        $data['tipo_pregunta_cve'] = $pregunta['tipo_pregunta']['tipo_pregunta_cve'];
        $data['pregunta'] = $pregunta['pregunta'];
        $data['orden'] = isset($pregunta['orden_pregunta']) ? $pregunta['orden_pregunta'] : 0;
        $data['obligada'] = isset($pregunta['pregunta_obligada']) ? $pregunta['pregunta_obligada'] : 0;
        $data['is_bono'] = isset($pregunta['pregunta_bono']) ? $pregunta['pregunta_bono'] : 0;

        $data['tipo_indicador_cve'] = $indicador_id;
        $data['valido_no_aplica'] = isset($pregunta['valido_no_aplica']) ? $pregunta['valido_no_aplica'] : 0;


        if ($pregunta['pregunta_bono'] === 1) {
            $this->instrumento_bono($instrumento_id);
        }

        if (isset($pregunta['orden_pregunta_padre']) && isset($pregunta['respuesta_esperada']) && !empty($pregunta['orden_pregunta_padre']) && !empty($pregunta['respuesta_esperada'])) {
            $pregunta_padre = $this->get_pregunta_padre($instrumento_id, $pregunta['orden_pregunta_padre'], $seccion_id);

            //pr($pregunta_padre);

            if ($pregunta_padre != FALSE) {
                $data['pregunta_padre'] = $pregunta_padre['preguntas_cve'];
                //pr($pregunta);
                $respuesta_esperada = $this->get_reactivos_cve($pregunta_padre['preguntas_cve'], $pregunta['tipo_pregunta']['respuesta_esperada']);
                //pr($respuesta_esperada);
                //exit();

                if (!empty($respuesta_esperada)) {
                    $data['val_ref'] = $respuesta_esperada[0]['reactivos_cve'];
                }// else no existe la respeuesta esperada en la pregunta padre
            }// else la pregunta padre no existe
        }

        $this->db->insert('encuestas.sse_preguntas', $data);
        $insert_id = $this->db->insert_id();
        //echo '<br>], prg: '.$insert_id.' [';
        $this->update_bono_encuesta($instrumento_id);
        return $insert_id;
    }

    function update_pregunta($id_pregunta = null, $params = null) {


        $pregunta_anterior = isset($params['pregunta_anterior'][0]) ? $params['pregunta_anterior'][0] : ''; // obtenemos los datos anteriores de la pregunta

        $pregunta_padre = 0; // variable pregunta padre
        $val_ref = 0; // variable valor de referancia
        if (isset($params['tiene_pregunta_padre']) && $params['tiene_pregunta_padre'] == true) { // si tiene pregunta padre esta activo
            // verificar si en base de datos existen los datos val ref y pregunta_padre
            $pregunta_padre = isset($params['pregunta_padre']) ? $params['pregunta_padre'] : 0; // asignamos el valor que viene en pregunta padre
            $val_ref = isset($params['val_ref']) ? $params['val_ref'] : 0; // asignamos el valor que viene en valor de referencia
        }

        $tiene_hijas = $this->tiene_preguntas_hija($id_pregunta); // buscamos si tiene preguntas hija
        //pr($tiene_hijas);
        //exit();

        if ($pregunta_anterior['tipo_pregunta_cve'] != $params['tipo_pregunta_cve']) { // si el tipo de pregunta cambio
            if (isset($tiene_hijas['tiene_hijas']) && $tiene_hijas['tiene_hijas'] > 0) { // si
                $resultado['success'] = FALSE;
                $resultado['error'] = 'No puede modificar el tipo de respuestas ya que existen preguntas que dependen de esta pregunta.';

                return $resultado;
                //exit();
            }
        }

        $this->db->trans_begin();
        $datos = array(
            'seccion_cve' => $params['seccion_cve'],
            'tipo_pregunta_cve' => $params['tipo_pregunta_cve'],
            'pregunta' => $params['pregunta'],
            'obligada' => isset($params['obligada']) ? $params['obligada'] : 0,
            'is_bono' => isset($params['is_bono']) ? $params['is_bono'] : 0,
            'pregunta_padre' => $pregunta_padre,
            'val_ref' => $val_ref,
            'tipo_indicador_cve' => $params['tipo_indicador_cve'],
            'valido_no_aplica' => $params['valido_no_aplica']
        );
        $this->db->where('preguntas_cve', $id_pregunta);
        $this->db->update('encuestas.sse_preguntas', $datos);

        $respuestas_nuevas = (isset($params['respuestas']) && is_array($params['respuestas'])) ? $params['respuestas'] : '';
        if (!empty($respuestas_nuevas) && $pregunta_anterior['tipo_pregunta_cve'] != $params['tipo_pregunta_cve']) {
            $this->db->where('sse_respuestas.preguntas_cve', $id_pregunta);
            $this->db->delete('encuestas.sse_respuestas');

            foreach ($respuestas_nuevas as $respuesta) {
                $this->guarda_respuesta($respuesta, $id_pregunta, $pregunta_anterior['encuesta_cve']);
            }
        }

        $this->update_bono_encuesta($params['encuesta_cve']);
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            $resultado['success'] = FALSE;
        } else {
            $this->db->trans_rollback();
            $resultado['success'] = TRUE;
        }
        $this->db->trans_complete();
        return $resultado;
    }

    /**
     * update_bono_encuesta - Actualiza la bandera is_bono en tabla encuestas si presenta una pregunta para bono
     * @param type $id_instrumento - id de la encuesta a revisar
     */
    public function update_bono_encuesta($id_instrumento = 0) {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->select('is_bono');
        $this->db->where('encuesta_cve', $id_instrumento);
        $query1 = $this->db->get_compiled_select('encuestas.sse_preguntas');
        $this->db->reset_query();
        $this->db->select('(case when (1 in (' . $query1 . ')) then 1 else 0 end) valor');
        $valor = $this->db->get()->result_array()[0]['valor'];
        /*
          pr('[CH][Encuestas_model][update_bono_encuesta]$valor: ' );
          pr($valor);
         * *
         */
        $this->db->reset_query();
        $this->db->set('is_bono', $valor, FALSE);

        $this->db->where('encuesta_cve', $id_instrumento);
        $this->db->update('encuestas.sse_encuestas');
    }

    public function tiene_preguntas_hija($id_pregunta = null) {
        $this->db->select("COUNT(*) AS tiene_hijas"); //////Ejemplo de compilación de consulta
        $this->db->where('sse_preguntas.pregunta_padre', $id_pregunta);
        $query = $this->db->get('encuestas.sse_preguntas');

        $resultado = $query->result_array();

        return $resultado[0];
    }

    public function guarda_respuesta($respuesta = array(), $pregunta_id = null, $instrumento_id) {
        $data['preguntas_cve'] = $pregunta_id;
        $data['encuesta_cve'] = $instrumento_id;
        $data['ponderacion'] = $respuesta['ponderacion'];
        $data['texto'] = $respuesta['texto'];
        $this->db->insert('encuestas.sse_respuestas', $data);

        $insert_id = $this->db->insert_id();
        //echo '[res: '.$insert_id.'], ';
        return $insert_id;
    }

    public function duplica_instrumento($id_instrumento = null) {
        $resultado = array();

        $this->db->trans_begin(); // inicio de transaccion

        $primer_instrumento = $this->get_instrumento_detalle($id_instrumento);
        $preguntas = $this->preguntas_instrumento($id_instrumento);
        /*
          fecha_creacion
          reglas_evaluacion_cve
          cve_corta_encuesta
          status
          is_bono
          descripcion_encuestas
          encuesta_cve
         */
        $nuevo_folio = $primer_instrumento[0]['cve_corta_encuesta'] . '-' . rand(5, 15);
        $segundo_instrumento = array(
            'descripcion_encuestas' => $primer_instrumento[0]['descripcion_encuestas'],
            'is_bono' => $primer_instrumento[0]['is_bono'],
            //'rol_id'=>$primer_instrumento[0]['rol_id'],
            //'tutorizado'=>$primer_instrumento[0]['tutorizado'],
            'status' => 0,
            'reglas_evaluacion_cve' => $primer_instrumento[0]['reglas_evaluacion_cve'],
            'cve_corta_encuesta' => $nuevo_folio,
            'tipo_encuesta' => $primer_instrumento[0]['tipo_encuesta'],
            'eva_tipo' => $primer_instrumento[0]['eva_tipo'],
            'fecha_creacion' => date('Y-m-d')
        );

        $this->db->insert('encuestas.sse_encuestas', $segundo_instrumento);
        $segundo_instrumento_cve = $this->db->insert_id();

        $resultado['instrumento_id'] = $segundo_instrumento_cve;

        $primera_pregunta_cve = '';
        $segunda_pregunta_cve = '';
        foreach ($preguntas as $row) {
            /*
              [preguntas_cve] => 846
              [seccion_cve] => 142
              [encuesta_cve] => 65
              [tipo_pregunta_cve] => 1
              [pregunta] => Notificó al coordinador de curso la validación de las calificaciones de todos los alumnos
              [obligada] => 0
              [orden] => 1
              [is_bono] => 0
              [val_ref] =>
              [pregunta_padre] =>
              [reactivos_cve] => 2969
              [ponderacion] => 1
              [texto] => Si
             */
            if ($row['preguntas_cve'] != $primera_pregunta_cve) {
                $data_pregunta = array(
                    'seccion_cve' => $row['seccion_cve'],
                    'encuesta_cve' => $segundo_instrumento_cve,
                    'tipo_pregunta_cve' => $row['tipo_pregunta_cve'],
                    'pregunta' => $row['pregunta'],
                    'obligada' => $row['obligada'],
                    'orden' => $row['orden'],
                    'is_bono' => $row['is_bono'],
                    'tipo_indicador_cve' => $row['tipo_indicador_cve'],
                    'valido_no_aplica' => $row['valido_no_aplica']
                );

                if (isset($row['pregunta_padre']) && isset($row['val_ref']) && !empty($row['pregunta_padre']) && !empty($row['val_ref'])) {
                    $pregunta_padre = $this->get_pregunta_padre_nuevo_instrumento($segundo_instrumento_cve, $row['pregunta_padre'], $row['seccion_cve']);

                    //pr($pregunta_padre);

                    if ($pregunta_padre != FALSE) {
                        $data_pregunta['pregunta_padre'] = $pregunta_padre['preguntas_cve'];
                        //pr($pregunta);
                        $respuesta_esperada = $this->get_reactivos_cve($pregunta_padre['preguntas_cve'], $this->get_reactivo_texto($row['val_ref']));
                        //pr($respuesta_esperada);
                        //exit();

                        if (!empty($respuesta_esperada)) {
                            $data_pregunta['val_ref'] = $respuesta_esperada[0]['reactivos_cve'];
                        }// else no existe la respeuesta esperada en la pregunta padre
                    }// else la pregunta padre no existe
                }

                //pr($data_pregunta);
                $this->db->insert('encuestas.sse_preguntas', $data_pregunta);

                $primera_pregunta_cve = $row['preguntas_cve'];
                $segunda_pregunta_cve = $this->db->insert_id();

                $this->guarda_respuesta($row, $segunda_pregunta_cve, $segundo_instrumento_cve);
            } else {

                $this->guarda_respuesta($row, $segunda_pregunta_cve, $segundo_instrumento_cve);
            }
        }
        if ($this->db->trans_status() == TRUE) { // condición para ver si la transaccion se efectuara correctamente
            $this->db->trans_commit(); // si la transacción es correcta retornar TRUE
            $resultado['success'] = TRUE;
        } else {
            $this->db->trans_rollback(); // si la transacción no es correcta retornar FALSE
            $resultado['success'] = FALSE;
        }
        $this->db->trans_complete();
        return $resultado;
    }

    public function get_pregunta_padre_nuevo_instrumento($instrumento_nuevo = null, $preguntas_cve = null, $seccion_cve = null) {
        $busqueda = array('sse_preguntas.preguntas_cve');

        $this->db->select("sse_preguntas.pregunta"); //////Ejemplo de compilación de consulta
        $this->db->where('sse_preguntas.seccion_cve', $seccion_cve);
        $this->db->where('sse_preguntas.preguntas_cve', $preguntas_cve);
        //$texto_pregunta = $this->db->get_compiled_select('encuestas.sse_preguntas');
        $query1 = $this->db->get('encuestas.sse_preguntas');
        $pregunta = $query1->result_array();
        //pr($pregunta);
        $texto_pregunta = $pregunta[0];

        //pr($texto_pregunta); exit();
        //$texto_pregunta = $this->db->get_compiled_select('encuestas.sse_preguntas');

        $this->db->select("sse_preguntas.preguntas_cve");
        $this->db->where('sse_preguntas.seccion_cve', $seccion_cve);
        $this->db->where('sse_preguntas.encuesta_cve', $instrumento_nuevo);
        $this->db->where('sse_preguntas.pregunta', $texto_pregunta['pregunta']);
        $query = $this->db->get('encuestas.sse_preguntas');
        //pr($this->db->last_query());

        $resultado = $query->result_array();
        //pr($resultado); exit();
        if (isset($resultado[0]['preguntas_cve'])) {
            return $resultado[0];
        } else {
            return FALSE;
        }
    }

    public function get_reactivo_texto($reactivos_cve = null) {

        $this->db->where('sse_respuestas.reactivos_cve', $reactivos_cve);
        $this->db->select('sse_respuestas.texto');
        $query = $this->db->get('encuestas.sse_respuestas');

        $resultado = $query->result_array();

        return $resultado[0]['texto'];
    }

    public function get_preguntas_padre($instrumento_id = null, $seccion = null) {
        $busqueda = array('sse_preguntas.preguntas_cve');
        $this->db->where('sse_preguntas.seccion_cve', $seccion);
        $this->db->where('sse_preguntas.encuesta_cve', $instrumento_id);
        //$this->db->where('sse_preguntas.orden', $orden_pregunta);
        $this->db->select($busqueda);
        $query = $this->db->get('encuestas.sse_preguntas');

        $resultado = $query->result_array();

        return $resultado;
    }

    public function get_reactivos_cve($preguntas_cve = null, $texto = null) {
        //pr($preguntas_cve);
        //pr($texto);
        $busqueda = array('sse_respuestas.reactivos_cve');

        $this->db->where('sse_respuestas.preguntas_cve', $preguntas_cve);
        $this->db->where('sse_respuestas.texto', $texto);
        $this->db->select($busqueda);
        $query = $this->db->get('encuestas.sse_respuestas');

        $resultado = $query->result_array();

        return $resultado;
    }

    public function guarda_orden_preguntas($orden = null) {
        $this->db->trans_begin();

        foreach ($orden as $row) {
            $data = array('orden' => $row['orden']);
            $this->db->where('sse_preguntas.preguntas_cve', $row['preguntas_cve']);
            $this->db->update('encuestas.sse_preguntas', $data);
        }
        if ($this->db->trans_status() === FALSE) { // condición para ver si la transaccion se efectuara correctamente
            $this->db->trans_rollback(); // si la transacción no es correcta retornar FALSE
            $bandera = false;
        } else {
            $this->db->trans_commit(); // si la transacción es correcta retornar TRUE
            $bandera = true;
        }
        $this->db->trans_complete();
        return $bandera;
    }

    public function get_instrumento_detalle($id_instrumento = null) {
        /*
          SELECT * FROM encuestas.sse_encuestas en
          LEFT JOIN encuestas.sse_preguntas pre ON en.encuesta_cve=pre.encuesta_cve
          LEFT JOIN encuestas.sse_respuestas res ON res.preguntas_cve=pre.preguntas_cve
          WHERE en.encuesta_cve=11;
         */
        /*

          [encuesta_cve] => 85
          [descripcion_encuestas] => alumno - titular - tutorizado
          [is_bono] => 0
          [status] => 1
          [cve_corta_encuesta] => JHF32FGJK
          [reglas_evaluacion_cve] => 1
          [fecha_creacion] => 2016-08-11
          [rol_evaluado_cve] => 32
          [rol_evaluador_cve] => 5
          [is_excepcion] => 8
          [tutorizado] => 1
          [id] => 32
          [name] => Tutor Titular
          [shortname] => tutortitular
          [description] =>
          [sortorder] => 13
          [archetype] => teacher

         */
        $this->db->select("mdl_role.name"); //////Ejemplo de compilación de consulta
        $this->db->where('sse_reglas_evaluacion.rol_evaluador_cve=mdl_role.id');
        $rol_evaluador = $this->db->get_compiled_select('public.mdl_role');

        $select_data = array(
            'sse_encuestas.encuesta_cve',
            'sse_encuestas.descripcion_encuestas',
            'sse_encuestas.tipo_encuesta',
            'sse_encuestas.eva_tipo',
            'sse_encuestas.is_bono',
            'sse_encuestas.status',
            'sse_encuestas.cve_corta_encuesta',
            'sse_encuestas.reglas_evaluacion_cve',
            'sse_reglas_evaluacion.rol_evaluado_cve',
            'sse_reglas_evaluacion.rol_evaluador_cve',
            'sse_reglas_evaluacion.is_excepcion',
            'sse_reglas_evaluacion.tutorizado',
            'mdl_role.id',
            'mdl_role.name',
            'mdl_role.shortname',
            'mdl_role.description',
            'mdl_role.sortorder',
            'mdl_role.archetype',
            'sse_encuestas.guia_descripcion_encuesta',
            '(' . $rol_evaluador . ') AS evaluador'
        );

        $this->db->where('sse_encuestas.encuesta_cve', $id_instrumento);
        $this->db->join('encuestas.sse_reglas_evaluacion', 'sse_reglas_evaluacion.reglas_evaluacion_cve=sse_encuestas.reglas_evaluacion_cve');
        $this->db->join('public.mdl_role', 'sse_reglas_evaluacion.rol_evaluado_cve=mdl_role.id');
        $this->db->select($select_data);
        $query = $this->db->get('encuestas.sse_encuestas');
//        pr($this->db->last_query());
        $resultado = $query->result_array();

        return $resultado;
    }

    public function get_secciones() {

        $query = $this->db->get('encuestas.sse_seccion');
        $resultado = $query->result_array();

        return $resultado;
    }

    public function get_seccion($descripcion = '') {
        $this->db->select('sse_seccion.seccion_cve');
        $this->db->where('sse_seccion.descripcion', $descripcion);
        $query = $this->db->get('encuestas.sse_seccion');
        $resultado = $query->result_array();

        return $resultado;
    }

    public function get_tipo_pregunta() {

        $query = $this->db->get('encuestas.sse_tipo_pregunta');
        $resultado = $query->result_array();

        return $resultado;
    }

    public function listado_preguntas_seccion($id_encuesta = null, $id_seccion = null, $id_pregunta_hija) {
        $resultado = array();
        $this->db->where('sse_preguntas.encuesta_cve', $id_encuesta);
        $this->db->where('sse_preguntas.seccion_cve', $id_seccion);
        $this->db->where('sse_preguntas.preguntas_cve < ' . $id_pregunta_hija . '');
        $query = $this->db->get('encuestas.sse_preguntas'); //Obtener conjunto de encuestas
        $resultado = $query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function listado_respuestas_pregunta($pregunta_id = null) {
        $resultado = array();
        $this->db->where('sse_respuestas.preguntas_cve', $pregunta_id);
        $query = $this->db->get('encuestas.sse_respuestas'); //Obtener conjunto de encuestas
        $resultado = $query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function get_pregunta_detalle($id_pregunta = null, $id_instrumento = null) {
        $this->db->where('sse_preguntas.encuesta_cve', $id_instrumento);
        $this->db->where('sse_preguntas.preguntas_cve', $id_pregunta);
        $query = $this->db->get('encuestas.sse_preguntas');

        $resultado = $query->result_array();

        return $resultado;
    }

    public function preguntas_instrumento($id_instrumento = null) {
        /*
          SELECT * FROM encuestas.sse_preguntas pre
          LEFT JOIN encuestas.sse_respuestas res ON res.preguntas_cve=pre.preguntas_cve
          WHERE pre.encuesta_cve=33;
         */

        /* SELECT "sse_preguntas"."preguntas_cve", "sse_preguntas"."seccion_cve", "sse_preguntas"."encuesta_cve", "sse_preguntas"."tipo_pregunta_cve",
          "sse_preguntas"."pregunta", "sse_preguntas"."obligada", "sse_preguntas"."orden", "sse_preguntas"."is_bono", "sse_preguntas"."val_ref",
          "sse_preguntas"."pregunta_padre", "sse_respuestas"."reactivos_cve", "sse_respuestas"."ponderacion", "sse_respuestas"."texto",
          "sse_seccion"."descripcion", "sse_preguntas"."tipo_indicador_cve", "sse_preguntas"."valido_no_aplica", "sse_seccion"."descripcion","sse_indicador"."descripcion"
          FROM "encuestas"."sse_preguntas"
          JOIN "encuestas"."sse_respuestas" ON "sse_respuestas"."preguntas_cve"="sse_preguntas"."preguntas_cve"
          JOIN "encuestas"."sse_seccion" ON "sse_seccion"."seccion_cve"="sse_preguntas"."seccion_cve"
          JOIN "encuestas"."sse_indicador" ON "sse_indicador"."indicador_cve"="sse_preguntas"."tipo_indicador_cve"
          WHERE "sse_preguntas"."encuesta_cve" = '514' ORDER BY "orden" ASC */

        $busqueda = array(
            'sse_preguntas.preguntas_cve',
            'sse_preguntas.seccion_cve',
            'sse_preguntas.encuesta_cve',
            'sse_preguntas.tipo_pregunta_cve',
            'sse_preguntas.pregunta',
            'sse_preguntas.obligada',
            'sse_preguntas.orden',
            'sse_preguntas.is_bono',
            'sse_preguntas.val_ref',
            'sse_preguntas.pregunta_padre',
            'sse_respuestas.reactivos_cve',
            'sse_respuestas.ponderacion',
            'sse_respuestas.texto',
            'sse_seccion.descripcion',
            'sse_preguntas.tipo_indicador_cve',
            'sse_preguntas.valido_no_aplica',
            'sse_seccion.descripcion',
            'sse_indicador.descripcion as indicador',
        );

        $this->db->join('encuestas.sse_respuestas', 'sse_respuestas.preguntas_cve=sse_preguntas.preguntas_cve', 'left');
        $this->db->join('encuestas.sse_seccion', 'sse_seccion.seccion_cve=sse_preguntas.seccion_cve');
        $this->db->join('encuestas.sse_indicador', 'sse_indicador.indicador_cve=sse_preguntas.tipo_indicador_cve');
        $this->db->where('sse_preguntas.encuesta_cve', $id_instrumento);
        $this->db->select($busqueda);
        //$this->db->order_by('seccion_cve','ASC');
        $this->db->order_by('orden', 'ASC');
        $query = $this->db->get('encuestas.sse_preguntas');
        //pr($this->db->last_query());
        $resultado = $query->result_array();

        return $resultado;
    }

    public function listado_instrumentos($params = null) {
        $resultado = array();

        $this->db->select("COUNT(*) AS existe_evaluacion"); //////Ejemplo de compilación de consulta
        $this->db->where('sse_encuestas.encuesta_cve=sse_evaluacion.encuesta_cve');
        $evaluaciones = $this->db->get_compiled_select('encuestas.sse_evaluacion');

        $this->db->select("mdl_role.name"); //////Ejemplo de compilación de consulta
        $this->db->where('sse_reglas_evaluacion.rol_evaluado_cve=mdl_role.id');
        $rol_evaluar = $this->db->get_compiled_select('public.mdl_role');

        $this->db->select("mdl_role.name"); //////Ejemplo de compilación de consulta
        $this->db->where('sse_reglas_evaluacion.rol_evaluador_cve=mdl_role.id');
        $rol_evaluador = $this->db->get_compiled_select('public.mdl_role');

        $this->db->start_cache();
        $this->db->select('sse_encuestas.encuesta_cve');

        $busqueda = array();

        if (isset($params['descripcion_encuestas']) && !empty($params['descripcion_encuestas'])) { ////// Ejemplo - Like
            $this->db->like('sse_encuestas.descripcion_encuestas', $params['descripcion_encuestas']);
            //$guarda_busqueda = true;
        }

        /**/
        if (isset($params['rol_id']) && !empty($params['rol_id'])) {
            //$guarda_busqueda = true;
            $this->db->where('sse_reglas_evaluacion.rol_evaluado_cve', $params['rol_id']);
        }

        if (isset($params['is_bono']) && !empty($params['is_bono'])) {
            //$guarda_busqueda = true;
            $this->db->where('sse_encuestas.is_bono', $params['is_bono']);
        }

        if(isset($params['tutorizado']) && !empty($params['tutorizado']))
        {
          //$guarda_busqueda = true;
          $this->db->where('sse_reglas_evaluacion.tutorizado',$params['tutorizado']);
        }
        //reglas_evaluacion_cve
        $this->db->join('encuestas.sse_reglas_evaluacion', 'sse_reglas_evaluacion.reglas_evaluacion_cve=sse_encuestas.reglas_evaluacion_cve');
        //$this->db->join('public.mdl_role', 'mdl_role.id=sse_encuestas.rol_id');

        $this->db->stop_cache();
        /////////////////////// Fin almacenado de parámetros en cache ///////////////////////////
        ///////////////////////////// Obtener número de registros ///////////////////////////////
        $nr = $this->db->get_compiled_select('encuestas.sse_encuestas'); //Obtener el total de registros
        $num_rows = $this->db->query("SELECT count(*) AS total FROM (" . $nr . ") AS temp")->result();
        //pr($this->db1->last_query());
        /////////////////////////////// FIN número de registros /////////////////////////////////
        $busqueda = array(
            'sse_encuestas.encuesta_cve',
            'sse_encuestas.reglas_evaluacion_cve',
            'sse_encuestas.descripcion_encuestas',
            'sse_encuestas.cve_corta_encuesta',
            'sse_encuestas.is_bono',
            'sse_encuestas.status',
            'sse_reglas_evaluacion.rol_evaluador_cve',
            'sse_reglas_evaluacion.rol_evaluado_cve',
            'sse_reglas_evaluacion.tutorizado',
            //'mdl_role.name',
            '(' . $rol_evaluar . ') AS rol_evaluar',
            '(' . $rol_evaluador . ') AS rol_evaluador',
            '(' . $evaluaciones . ') AS tiene_evaluaciones'
        );

        $this->db->select($busqueda);

        if (isset($params['order']) && !empty($params['order'])) {
            $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
            $this->db->order_by($params['order'], $tipo_orden);
        }
        if (isset($params['per_page']) && isset($params['current_row'])) { //Establecer límite definido para paginación
            $this->db->limit($params['per_page'], $params['current_row']);
        }
        $query = $this->db->get('encuestas.sse_encuestas'); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $resultado['total'] = $num_rows[0]->total;
        $resultado['columns'] = $query->list_fields();
        $resultado['data'] = $query->result_array();
        //pr($resultado['data']);
        $this->db->flush_cache();
        $query->free_result(); //Libera la memoria
        /*
          if(isset($guarda_busqueda) && $guarda_busqueda == true){
          $this->guarda_busqueda($params);
          } */

        return $resultado;
    }

    public function tiene_evaluaciones($id_instrumento = null) {
        $this->db->select("COUNT(*) AS tiene_evaluacion"); //////Ejemplo de compilación de consulta
        $this->db->where('sse_evaluacion.encuesta_cve', $id_instrumento);
        $query = $this->db->get('encuestas.sse_evaluacion');

        $resultado = $query->result_array();

        return $resultado;
    }

    public function block_instrumento($id_instrumento = null) {
        $data = array(
            'status' => 0
        );
        $this->db->trans_begin(); // inicio de transaccion

        $this->db->where('encuesta_cve', $id_instrumento);
        $this->db->update('encuestas.sse_encuestas', $data);
        if ($this->db->trans_status() === FALSE) { // condición para ver si la transaccion se efectuara correctamente
            $this->db->trans_rollback(); // si la transacción no es correcta retornar FALSE
            $status = false;
        } else {
            $this->db->trans_commit(); // si la transacción es correcta retornar TRUE
            $status = true;
        }
        $this->db->trans_complete();
        return $status;
    }

    public function unlock_instrumento($id_instrumento = null) {

        $data = array(
            'status' => 1
        );
        $this->db->trans_begin(); // inicio de transaccion

        $this->db->where('encuesta_cve', $id_instrumento);
        $this->db->update('encuestas.sse_encuestas', $data);

        if ($this->db->trans_status() === FALSE) { // condición para ver si la transaccion se efectuara correctamente
            $this->db->trans_rollback(); // si la transacción no es correcta retornar FALSE
            $bandera = false;
        } else {

            $this->db->trans_commit(); // si la transacción es correcta retornar TRUE
            $bandera = true;
        }
        $this->db->trans_complete();
        return $bandera;
    }

    public function drop_instrumento($encuesta_cve = null) {

        /*
          begin;
          delete from encuestas.sse_respuestas where preguntas_cve in (select preguntas_cve from encuestas.sse_preguntas where encuesta_cve in (select encuesta_cve from encuestas.sse_encuestas WHERE encuesta_cve=11));
          delete from encuestas.sse_preguntas where encuesta_cve in (select encuesta_cve from encuestas.sse_encuestas WHERE encuesta_cve=11);
          delete from encuestas.sse_encuestas WHERE encuesta_cve=11;
          commit;
         */
        $this->db->select("encuesta_cve"); //////Ejemplo de compilación de consulta
        $this->db->where('sse_encuestas.encuesta_cve', $encuesta_cve);
        $query1 = $this->db->get('encuestas.sse_encuestas');
        $encuesta = $query1->result_array();
        $encuesta_drop = $encuesta[0];

        $this->db->select("preguntas_cve"); //////Ejemplo de compilación de consulta
        $this->db->where_in('sse_preguntas.encuesta_cve', $encuesta_drop);
        $query2 = $this->db->get('encuestas.sse_preguntas');
        $preguntas = $query2->result_array();

        $preguntas_drop = array();
        foreach ($preguntas as $key => $value) {
            $preguntas_drop[] = $value['preguntas_cve'];
        }
        //pr($preguntas_drop);

        $this->db->trans_begin(); // inicio de transaccion

        $this->db->where_in('sse_respuestas.preguntas_cve', $preguntas_drop);
        $this->db->delete('encuestas.sse_respuestas');
        $this->db->where_in('sse_preguntas.encuesta_cve', $encuesta_drop);
        $this->db->delete('encuestas.sse_preguntas');
        $this->db->where_in('sse_encuesta_curso.encuesta_cve', $encuesta_drop);
        $this->db->delete('encuestas.sse_encuesta_curso');
        $this->db->where('sse_encuestas.encuesta_cve', $encuesta_cve);
        $this->db->delete('encuestas.sse_encuestas');

        if ($this->db->trans_status() === FALSE) { // condición para ver si la transaccion se efectuara correctamente
            $this->db->trans_rollback(); // si la transacción no es correcta retornar FALSE
            $bandera = false;
        } else {
            $this->db->trans_commit(); // si la transacción es correcta retornar TRUE
            $bandera = true;
        }
        $this->db->trans_complete();
        return $bandera;
    }

    public function drop_pregunta($pregunta_cve = null) {
        $this->db->select("preguntas_cve"); //////Ejemplo de compilación de consulta
        $this->db->where('sse_preguntas.preguntas_cve', $pregunta_cve);
        $query1 = $this->db->get('encuestas.sse_preguntas');
        $preguntas_hija = $query1->result_array();

        $this->db->trans_begin(); // inicio de transaccion
        if (isset($preguntas_hija[0]) && !empty($preguntas_hija[0])) {

            //pr($preguntas_hija[0]);
            //exit();
            $this->db->where_in('sse_respuestas.preguntas_cve', $preguntas_hija[0]);
            $this->db->delete('encuestas.sse_respuestas');

            $this->db->where_in('sse_preguntas.pregunta_padre', $preguntas_hija[0]);
            $this->db->delete('encuestas.sse_preguntas');
        }

        $this->db->where('sse_respuestas.preguntas_cve', $pregunta_cve);
        $this->db->delete('encuestas.sse_respuestas');

        $this->db->where('sse_preguntas.preguntas_cve', $pregunta_cve);
        $this->db->delete('encuestas.sse_preguntas');
        if ($this->db->trans_status() === FALSE) { // condición para ver si la transaccion se efectuara correctamente
            $this->db->trans_rollback(); // si la transacción no es correcta retornar FALSE
            $bandera = false;
        } else {
            $this->db->trans_commit(); // si la transacción es correcta retornar TRUE
            $bandera = true;
        }
        $this->db->trans_complete();
        return $bandera;
    }

    public function listado_encuestas_curso($params = null) {

        /* select encuestas.sse_encuestas.encuesta_cve,encuestas.sse_encuestas.descripcion_encuestas, encuestas.sse_encuestas.is_bono, encuestas.sse_encuestas.status,encuestas.sse_reglas_evaluacion.tutorizado
          from encuestas.sse_encuesta_curso
          inner join encuestas.sse_encuestas  on encuestas.sse_encuestas.encuesta_cve=encuestas.sse_encuesta_curso.encuesta_cve
          inner join encuestas.sse_reglas_evaluacion on encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve=encuestas.sse_encuestas.reglas_evaluacion_cve
          where sse_encuesta_curso.course_cve=797 */


        /* select encuestas.sse_encuestas.encuesta_cve,encuestas.sse_encuestas.descripcion_encuestas, encuestas.sse_encuestas.is_bono, encuestas.sse_encuestas.status,encuestas.sse_reglas_evaluacion.tutorizado,
          (select encuestas.sse_encuestas.encuesta_cve in (select encuesta_cve from encuestas.sse_encuesta_curso where course_cve=797)) as asig
          from encuestas.sse_encuestas
          left join encuestas.sse_encuesta_curso on   encuestas.sse_encuesta_curso.encuesta_cve=encuestas.sse_encuestas.encuesta_cve
          left join  encuestas.sse_reglas_evaluacion on encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve=encuestas.sse_encuestas.reglas_evaluacion_cve
          where encuestas.sse_reglas_evaluacion.tutorizado=1 */


        /* select encuestas.sse_encuestas.encuesta_cve,encuestas.sse_encuestas.descripcion_encuestas, encuestas.sse_encuestas.is_bono, encuestas.sse_encuestas.status,encuestas.sse_reglas_evaluacion.tutorizado,
          (select name from public.mdl_role where id=sse_reglas_evaluacion.rol_evaluado_cve) evaluado,(select name from public.mdl_role where id=sse_reglas_evaluacion.rol_evaluador_cve) as evaluador,
          (select encuestas.sse_encuestas.encuesta_cve in (select encuesta_cve from encuestas.sse_encuesta_curso where course_cve=797)) as asig
          from encuestas.sse_encuestas
          left join encuestas.sse_encuesta_curso on   encuestas.sse_encuesta_curso.encuesta_cve=encuestas.sse_encuestas.encuesta_cve
          left join  encuestas.sse_reglas_evaluacion on encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve=encuestas.sse_encuestas.reglas_evaluacion_cve
          where encuestas.sse_reglas_evaluacion.tutorizado=1 */

        /* select encuestas.sse_encuestas.encuesta_cve,encuestas.sse_encuestas.descripcion_encuestas, encuestas.sse_encuestas.is_bono, encuestas.sse_encuestas.status,encuestas.sse_reglas_evaluacion.tutorizado,
          (select name from public.mdl_role where id=sse_reglas_evaluacion.rol_evaluado_cve) evaluado,(select name from public.mdl_role where id=sse_reglas_evaluacion.rol_evaluador_cve) as evaluador,
          (select encuestas.sse_encuestas.encuesta_cve in (select encuesta_cve from encuestas.sse_encuesta_curso where course_cve=761)) as asig
          from encuestas.sse_encuestas
          left join  encuestas.sse_reglas_evaluacion on encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve=encuestas.sse_encuestas.reglas_evaluacion_cve
          where encuestas.sse_reglas_evaluacion.tutorizado=1 */


        $resultado = array();
        ///////////////////// Iniciar almacenado de parámetros en cache /////////////////////////
        $this->db->start_cache();
        $this->db->select('encuestas.sse_encuestas.encuesta_cve');

        /* if(isset($params['curso']) && !empty($params['curso']))
          {
          //$guarda_busqueda = true;
          $this->db->where('sse_encuesta_curso.course_cve',$params['curso']);
          } */


        /* if(isset($params['tutorizado']) && $params['tutorizado'] >= 0 && !empty($params['tutorizado']) )
          { */
        //$guarda_busqueda = true;
        $this->db->where('sse_reglas_evaluacion.tutorizado', $params['tutorizado']);
        //}
        /* if(isset($params['anio']) && !empty($params['anio']))
          {
          //$guarda_busqueda = true;
          $this->db->where("TO_CHAR(TO_TIMESTAMP(mdl_course.startdate),'YYYY')='".$params['anio']."'");
          } */


        $this->db->where('sse_encuestas.status', '1');
        //$this->db->join('encuestas.sse_encuestas', 'sse_encuestas.encuesta_cve=sse_encuesta_curso.encuesta_cve');
        //$this->db->join('encuestas.sse_reglas_evaluacion','sse_reglas_evaluacion.reglas_evaluacion_cve=sse_encuestas.reglas_evaluacion_cve');
        //$this->db->join('encuestas.sse_encuesta_curso', 'sse_encuesta_curso.encuesta_cve=sse_encuestas.encuesta_cve','left');
        $this->db->join('encuestas.sse_reglas_evaluacion', 'sse_reglas_evaluacion.reglas_evaluacion_cve=sse_encuestas.reglas_evaluacion_cve', 'left');




        $this->db->stop_cache();
        /////////////////////// Fin almacenado de parámetros en cache ///////////////////////////
        ///////////////////////////// Obtener número de registros ///////////////////////////////
        $nr = $this->db->get_compiled_select('encuestas.sse_encuestas'); //Obtener el total de registros
        $num_rows = $this->db->query("SELECT count(*) AS total FROM (" . $nr . ") AS temp")->result();
        //pr($this->db1->last_query());
        /////////////////////////////// FIN número de registros /////////////////////////////////
        $busqueda = array(
            'sse_encuestas.encuesta_cve as encuesta',
            'sse_encuestas.cve_corta_encuesta as encuestaclavecorta',
            'sse_encuestas.descripcion_encuestas as descrip',
            'sse_encuestas.is_bono as bono',
            'sse_encuestas.status as estatus',
            'sse_reglas_evaluacion.tutorizado as tutorizado',
            '(select sse_encuestas.encuesta_cve in (select encuesta_cve from encuestas.sse_encuesta_curso where course_cve=' . $params['curso'] . ') :: int) as asig',
            '(select name from public.mdl_role where id=sse_reglas_evaluacion.rol_evaluado_cve) as evaluado',
            '(select name from public.mdl_role where id=sse_reglas_evaluacion.rol_evaluador_cve) as evaluador',
        );

        $this->db->select($busqueda);
        if (isset($params['order']) && !empty($params['order'])) {
            $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
            $this->db->order_by($params['order'], $tipo_orden);
        }
        if (isset($params['per_page']) && isset($params['current_row'])) { //Establecer límite definido para paginación
            $this->db->limit($params['per_page'], $params['current_row']);
        }

        $query = $this->db->get('encuestas.sse_encuestas'); //Obtener conjunto de registros
        //pr($this->db1->last_query());
        $resultado['total'] = $num_rows[0]->total;
        $resultado['columns'] = $query->list_fields();
        $resultado['data'] = $query->result_array();
        //pr($resultado['data']);
        $this->db->flush_cache();
        $query->free_result(); //Libera la memoria


        return $resultado;
    }

    /**
     * @author Christian Garcia
     * @return array con la información basica de la encuesta
     *
     * */
    public function get_encuestas($filtros = []) {
        $encuestas = [];
        $this->db->flush_cache();
        $this->db->reset_query();
        if (is_array($filtros) && !empty($filtros)) {
            foreach ($filtros as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $query = $this->db->get('encuestas.sse_encuestas A');
        $encuestas = $query->result_array();
        $query->free_result();
        $this->db->flush_cache();
        $this->db->reset_query();
        return $encuestas;
    }

    public function insertar_asoc($encuestacve = array(), $curso = null) {
        //if(isset($params['encuesta']) && !empty($params['encuesta'])){
        $salida = array('status' => true, 'msg' => '');
        $row['ingresado'] = array();
        $row['existe'] = array();

        if (isset($encuestacve) && !empty($encuestacve)) {
            //pr($encuestacve);
            foreach ($encuestacve as $value) {
                $existe = $this->get_encuestac($value, $curso);
                if (count($existe) == 0) {
                    $filtros = array('encuesta_cve' => $value);
                    $encuesta = $this->get_encuestas($filtros)[0];
                    $filtros = array('reglas_evaluacion_cve' => $encuesta['reglas_evaluacion_cve']);
                    $valido = $this->get_encuestac(null, $curso, $filtros);
                    if (count($valido) == 0) {
                        if(!$this->existen_encuestas_contestadas($curso))
                        {
                            $data = array(
                                'mdl_groups_cve' => '0',
                                'course_cve' => $curso,
                                'encuesta_cve' => $value,
                                'alcance_curso_cve' => '0'
                            );
                            $this->db->insert('encuestas.sse_encuesta_curso', $data);
                            $insert_id = $this->db->insert_id();
                            $row['ingresado'] = $insert_id;
                        }else{
                            $salida['status'] = false;
                            $salida['msg'] = $salida['msg'] . '<br>' . 'No es posible asignar la encuesta con el folio: ' . $encuesta['cve_corta_encuesta'] . ' porque ya existen encuestas contestadas para el curso seleccionado';
                        }
                    } else {
                        $salida['status'] = false;
                        $salida['msg'] = $salida['msg'] . '<br>' . 'No es posible asignar la encuesta con el folio: ' . $encuesta['cve_corta_encuesta'] . ' porque ya existe una encuesta asignada con la misma configuración';
                    }
                } else {
                    $row['existe'] = $value;
                }
            }
        } else {
            # code...
            $row['error'] = 'No hubo seleccion';
        }
        return $salida;
    }

    public function get_encuestac($encuesta = null, $curso = null, $filtros = []) {
        //$resultado = array();

        $this->db->join('encuestas.sse_encuestas B', 'A.encuesta_cve = B.encuesta_cve', 'inner');
        $this->db->where('A.course_cve', $curso);
        if ($encuesta != null) {
            $this->db->where('A.encuesta_cve', $encuesta);
        }
        if (is_array($filtros) && !empty($filtros)) {
            foreach ($filtros as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $query = $this->db->get('encuestas.sse_encuesta_curso A'); //Obtener conjunto de encuestas
        $resultado = $query->result_array();
        $query->free_result(); //Libera la memoria
        return $resultado;
    }

    public function get_datos_usuarios($params = null) {
        $resultado = array();
        $arrol = array();

        /*      SELECT c.id AS cve_curso,  u.id AS cve_usuario, u.username AS nom_nombre, u.firstname AS nom, u.lastname AS pat, ' ' AS mat, g.id AS cve_grupo, g.name AS grupo_nombre, r.id AS cve_rol, r.name AS rol_nombre, u.cve_departamental
          FROM mdl_user u
          JOIN mdl_role_assignments ra ON ra.userid = u.id
          JOIN mdl_context ct ON ct.id = ra.contextid
          JOIN mdl_course c ON c.id = ct.instanceid
          JOIN mdl_role r ON r.id = ra.roleid
          right JOIN mdl_groups g ON g.courseid = c.id
          right JOIN mdl_groups_members gm ON gm.userid = u.id AND gm.groupid = g.id
          JOIN mdl_enrol en ON en.courseid = c.id
          JOIN mdl_user_enrolments ue ON ue.enrolid = en.id AND ue.userid = u.id
          where c.id=103 and u.id=7178 */

        /* SELECT mdl_role.id FROM mdl_course

          INNER JOIN mdl_context ON mdl_context.instanceid = mdl_course.id

          INNER JOIN mdl_role_assignments ON mdl_context.id = mdl_role_assignments.contextid

          INNER JOIN mdl_role ON mdl_role.id = mdl_role_assignments.roleid

          INNER JOIN mdl_user ON mdl_user.id = mdl_role_assignments.userid

          WHERE mdl_course.id=761 and mdl_user.id=7848 */

        $sql = "SELECT mdl_role.id FROM mdl_course
    INNER JOIN mdl_context ON mdl_context.instanceid = mdl_course.id
    INNER JOIN mdl_role_assignments ON mdl_context.id = mdl_role_assignments.contextid
    INNER JOIN mdl_role ON mdl_role.id = mdl_role_assignments.roleid
    INNER JOIN mdl_user ON mdl_user.id = mdl_role_assignments.userid
    WHERE mdl_course.id=" . $params['cur_id'] . " and mdl_user.id=" . $params['user_id'];

        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {

            $usuariosrol = $result->result_array();
            $result->free_result();
            foreach ($usuariosrol as $index => $value) {

                $arrol[] = $value['id'];
            }
        }




        if (in_array(5, $arrol)) {
            //Buscar en moodle


            if (isset($params['user_id']) && !empty($params['user_id'])) {
                $this->db->where('u.id', $params['user_id']);
            }
            if (isset($params['cur_id']) && !empty($params['cur_id'])) {
                $this->db->where('c.id', $params['cur_id']);
            }

            $this->db->join('public.mdl_role_assignments ra', 'ra.userid = u.id');
            $this->db->join('public.mdl_context ct', 'ct.id = ra.contextid');
            $this->db->join('public.mdl_course c', 'c.id = ct.instanceid');
            $this->db->join('public.mdl_role r', 'r.id = ra.roleid');
            $this->db->join('public.mdl_groups g', 'g.courseid = c.id', 'right');
            $this->db->join('public.mdl_groups_members gm', 'gm.userid = u.id AND gm.groupid = g.id', 'right');
            $this->db->join('public.mdl_enrol en', 'en.courseid = c.id');
            $this->db->join('public.mdl_user_enrolments ue', 'ue.enrolid = en.id AND ue.userid = u.id');

            $busqueda = array(
                'c.id AS cve_curso',
                'u.firstname AS nombres',
                'u.lastname AS apellidos',
                'g.id AS cve_grupo',
                'g.name AS nom_grupo',
                'r.id AS cve_rol',
                'r.name AS rol_nombre');

            $this->db->select($busqueda);


            $query = $this->db->get('public.mdl_user u'); //Obtener conjunto de encuestas
//            pr($this->db->last_query());
        } else {
            //Buscar en sied
            /* select public.mdl_user.firstname,public.mdl_user.lastname,public.mdl_role.name,
              public.mdl_groups.name, public.mdl_course.id ,*
              from tutorias.mdl_userexp
              inner join public.mdl_user on public.mdl_user.id= tutorias.mdl_userexp.userid
              inner join public.mdl_role on public.mdl_role.id= tutorias.mdl_userexp.role
              inner join public.mdl_groups on public.mdl_groups.id=tutorias.mdl_userexp.grupoid
              inner join public.mdl_course on public.mdl_course.id=tutorias.mdl_userexp.cursoid
              where cursoid=761 and mdl_user.id=7848 */
            if (isset($params['rol_evaluado_cve']) && !empty($params['rol_evaluado_cve'])) {
                $this->db->where_not_in('public.mdl_role.id', $params['rol_evaluado_cve']);
            }

            if (isset($params['rol_evaluador_cve']) && !empty($params['rol_evaluador_cve'])) {
                $this->db->where('public.mdl_role.id', $params['rol_evaluador_cve']);
            }


            if (isset($params['user_id']) && !empty($params['user_id'])) {
                $this->db->where('public.mdl_user.id', $params['user_id']);
            }
            if (isset($params['cur_id']) && !empty($params['cur_id'])) {
                $this->db->where('tutorias.mdl_userexp.cursoid', $params['cur_id']);
            }

            $this->db->join('public.mdl_user', 'public.mdl_user.id= tutorias.mdl_userexp.userid');
            $this->db->join('public.mdl_role', 'public.mdl_role.id= tutorias.mdl_userexp.role');
            $this->db->join('public.mdl_groups', 'public.mdl_groups.id=tutorias.mdl_userexp.grupoid');
            $this->db->join('public.mdl_course', 'public.mdl_course.id=tutorias.mdl_userexp.cursoid');

            $busqueda = array(
                'public.mdl_course.id as cve_curso',
                'public.mdl_user.firstname as nombres',
                'public.mdl_user.lastname as apellidos',
                'public.mdl_groups.id AS cve_grupo',
                'public.mdl_groups.name as nom_grupo',
                'public.mdl_role.id AS cve_rol',
                'public.mdl_role.name AS rol_nombre');
            $this->db->select($busqueda);


            $query = $this->db->get('tutorias.mdl_userexp'); //Obtener conjunto de encuestas
            //pr($this->db->last_query());
        }
//            pr($this->db->last_query());


        $resultado = $query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function get_reglas_validas_curso($params = null) {
        // $resultado = array();
        /* select re.reglas_evaluacion_cve,re.rol_evaluado_cve,re.is_excepcion,en.encuesta_cve
          from encuestas.sse_reglas_evaluacion re
          inner join encuestas.sse_encuestas en on en.reglas_evaluacion_cve=re.reglas_evaluacion_cve
          inner join encuestas.sse_encuesta_curso enc on enc.encuesta_cve=en.encuesta_cve
          where  re.rol_evaluador_cve=14 and re.tutorizado=1 and re.rol_evaluado_cve in(18) and enc.course_cve=979 */


        if (isset($params['role_evaluador']) && !empty($params['role_evaluador'])) {
            $this->db->where('sse_reglas_evaluacion.rol_evaluador_cve', $params['role_evaluador']);
        }
        if (isset($params['tutorizado']) && !empty($params['tutorizado'])) {
            $this->db->where('sse_reglas_evaluacion.tutorizado', $params['tutorizado']);
        }
        /* if(isset($params['bono']) && !empty($params['bono']))
          {
          $this->db->where('sse_reglas_evaluacion.is_bono',$params['bono']);
          } */
        if (isset($params['cur_id']) && !empty($params['cur_id'])) {
            $this->db->where('sse_encuesta_curso.course_cve', $params['cur_id']);
        }

        //$cadena_equipo = implode(",", $params['role_evaluado']);
        //condicionantes de acuerdo a la existencia de los roles
        if (isset($params['role_evaluado']) && !empty($params['role_evaluado']) && !in_array(0, $params['role_evaluado'])) {
            /* foreach ($params['role_evaluado'] as $value) {

              $this->db->where('sse_reglas_evaluacion.rol_evaluado_cve',$value);
              # code...
              } */
//            $this->db->where('sse_reglas_evaluacion.rol_evaluado_cve',$cadena_equipo);


            $this->db->where_in('sse_reglas_evaluacion.rol_evaluado_cve', $params['role_evaluado']);
        }




        $this->db->join('encuestas.sse_encuestas', 'sse_encuestas.reglas_evaluacion_cve=sse_reglas_evaluacion.reglas_evaluacion_cve');
        $this->db->join('encuestas.sse_encuesta_curso', 'sse_encuesta_curso.encuesta_cve=sse_encuestas.encuesta_cve');

        $busqueda = array(
            'sse_reglas_evaluacion.reglas_evaluacion_cve',
            'sse_reglas_evaluacion.rol_evaluado_cve',
            'sse_reglas_evaluacion.is_excepcion',
            'sse_encuestas.encuesta_cve'
        );

        $this->db->select($busqueda);



        $query = $this->db->get('encuestas.sse_reglas_evaluacion');
        //$resultado['data']=$query->result_array();
        $resultado = $query->result_array();







        $this->db->flush_cache();
        $query->free_result(); //Libera la memoria



        return $resultado;
    }

    public function listado_eval($params = null) {
        $this->db->where('tutorias.mdl_userexp.cursoid', $params['cur_id']);
        $this->db->where('tutorias.mdl_userexp.ind_status', '1');

        $this->db->where_not_in('tutorias.mdl_userexp.userid', $params['evaluador_user_cve']);

        if (isset($params['gpo_evaluador']) && !empty($params['gpo_evaluador'])) {//El evaluador es parte de un grupo
            //$this->db->where('tutorias.mdl_userexp.cursoid', $params['cur_id']);
            //$this->db->where('tutorias.mdl_userexp.role',$params['role_evaluado']);
            $this->db->where('tutorias.mdl_userexp.grupoid', $params['gpo_evaluador']);

            $this->db->where('tutorias.mdl_userexp.role', $params['role_evaluado']);

            $this->db->select('public.mdl_user.firstname,public.mdl_user.lastname,public.mdl_role.name as role, public.mdl_role.id as rol_id, public.mdl_groups.name as ngpo, \'\' AS grupos_ids_text,
                (select public.mdl_role.name from public.mdl_role where id=' . $params['role_evaluador'] . ') as evaluador,' .
                    $params['encuesta_cve'] . ' as regla, public.mdl_groups.id as gpoid, tutorias.mdl_userexp.cursoid as cursoid, public.mdl_user.id as userid,
                (select max(evaluacion_resul_cve) from encuestas.sse_result_evaluacion_encuesta_curso
                where encuesta_cve=' . $params['encuesta_cve'] . ' and course_cve=' . $params['cur_id'] . ' and group_id=' . $params['gpo_evaluador'] . '
                    and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=' . $params['evaluador_user_cve'] . ')  as realizado');

            $this->db->join('public.mdl_user', 'public.mdl_user.id= tutorias.mdl_userexp.userid');
            $this->db->join('public.mdl_role', 'public.mdl_role.id= tutorias.mdl_userexp.role');
            $this->db->join('public.mdl_groups', 'public.mdl_groups.id=tutorias.mdl_userexp.grupoid');
        } elseif (isset($params['bloque_evaluador']) && !empty($params['bloque_evaluador'])) {//El evaluador se encuentra en varios bloques
            $this->db->where('tutorias.mdl_userexp.role', $params['role_evaluado']);
            $this->db->where('encuestas.sse_curso_bloque_grupo.bloque', $params['bloque_evaluador']);

            if (isset($params['grupos']) && !empty($params['grupos'])) {
                $grupo_condition = "(SELECT array_agg(g.name)::varchar FROM public.mdl_groups g WHERE g.id IN (" . $params['grupos'] . ")) AS ngpo, '" . $params['grupos'] . "' as grupos_ids_text";
            } else {
                $grupo_condition = "public.mdl_groups.name as ngpo, \'\' AS grupos_ids_text";
            }


            $consulta = 'public.mdl_user.firstname,public.mdl_user.lastname,public.mdl_role.name as role, public.mdl_role.id as rol_id, ' . $grupo_condition . ',
                encuestas.sse_curso_bloque_grupo.bloque,
                (select public.mdl_role.name from public.mdl_role where id=' . $params['role_evaluador'] . ') as evaluador,' .
                    $params['encuesta_cve'] . ' as regla,  tutorias.mdl_userexp.cursoid as cursoid, public.mdl_user.id as userid,
                (select max(evaluacion_resul_cve) from encuestas.sse_result_evaluacion_encuesta_curso reec
                join encuestas.sse_curso_bloque_grupo cbgp on cbgp.course_cve = reec.course_cve and cbgp.bloque = encuestas.sse_curso_bloque_grupo.bloque
                and cbgp.mdl_groups_cve IN (' . $params['grupos'] . ')
                and cbgp.mdl_groups_cve = ANY (string_to_array(reec.grupos_ids_text, \',\')::int[])
                where encuesta_cve=' . $params['encuesta_cve'] . ' and reec.course_cve=' . $params['cur_id'] . '
                    and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=' . $params['evaluador_user_cve'] . ')  as realizado';
            $this->db->distinct($consulta);
            $this->db->select($consulta);
            /* $this->db->select('public.mdl_user.firstname,public.mdl_user.lastname,public.mdl_role.name as role, public.mdl_role.id as rol_id, ' . $grupo_condition . ',
              (select public.mdl_role.name from public.mdl_role where id=' . $params['role_evaluador'] . ') as evaluador,' .
              $params['encuesta_cve'] . ' as regla, public.mdl_groups.id as gpoid, tutorias.mdl_userexp.cursoid as cursoid, public.mdl_user.id as userid,
              (select max(evaluacion_resul_cve) from encuestas.sse_result_evaluacion_encuesta_curso where encuesta_cve=' . $params['encuesta_cve'] . ' and course_cve=' . $params['cur_id'] . '
              and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=' . $params['evaluador_user_cve'] . ')  as realizado');
             */

            $this->db->join('public.mdl_user', 'public.mdl_user.id= tutorias.mdl_userexp.userid');
            $this->db->join('public.mdl_role', 'public.mdl_role.id= tutorias.mdl_userexp.role');
            $this->db->join('public.mdl_groups', 'public.mdl_groups.id=tutorias.mdl_userexp.grupoid');
            $this->db->join('encuestas.sse_curso_bloque_grupo', 'encuestas.sse_curso_bloque_grupo.mdl_groups_cve = public.mdl_groups.id');
        } else {
            $params['gpo_evaluador'] = 0;
            $consulta = 'public.mdl_user.firstname,public.mdl_user.lastname,public.mdl_role.name as role, public.mdl_role.id as rol_id, ' . $params['gpo_evaluador'] . ' as ngpo, \'\' AS grupos_ids_text,
              (select public.mdl_role.name from public.mdl_role where id=' . $params['role_evaluador'] . ') as evaluador,' .
                    $params['encuesta_cve'] . ' as regla, tutorias.mdl_userexp.cursoid as cursoid, public.mdl_user.id as userid,
                    (select max(evaluacion_resul_cve) from encuestas.sse_result_evaluacion_encuesta_curso where encuesta_cve=' . $params['encuesta_cve'] . ' and course_cve=' . $params['cur_id'] . '
                        and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=' . $params['evaluador_user_cve'] . ')  as realizado';




            $this->db->distinct($consulta);
            $this->db->select($consulta);

            $this->db->where('tutorias.mdl_userexp.role', $params['role_evaluado']);


            $this->db->join('public.mdl_user', 'public.mdl_user.id= tutorias.mdl_userexp.userid');
            $this->db->join('public.mdl_role', 'public.mdl_role.id= tutorias.mdl_userexp.role');
            if ($params['role_evaluador'] != 30) {//Valida que el usuario sea diferente de normativo, ya que el normativo no se encuentra asociado a ningun grupo
                $this->db->join('public.mdl_groups_members gm', 'gm.userid = public.mdl_user.id and gm.groupid = tutorias.mdl_userexp.grupoid');
            }
        }





        $query = $this->db->get('tutorias.mdl_userexp');

        /* if ($query->num_rows() > 0){
          //$resultado['result'] = true;
          //$resultado['data'] = $query->result_array();
          $resultado = $query->result_array();

          } */
       // pr($this->db->last_query());
        $resultado = $query->result_array();
        //$this->db->flush_cache();
        //$query->free_result(); //Libera la memoria



        return $resultado;
    }

    public function get_reglas_encuesta($encuesta_cve = NULL) {
        /* select sse_reglas_evaluacion.rol_evaluador_cve,sse_reglas_evaluacion.rol_evaluado_cve
          from encuestas.sse_encuestas
          inner join encuestas.sse_reglas_evaluacion on encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve= encuestas.sse_encuestas.reglas_evaluacion_cve
          where encuestas.sse_encuestas.encuesta_cve=74
         */
        $resultado = array();
        $this->db->select('sse_reglas_evaluacion.rol_evaluador_cve,sse_reglas_evaluacion.rol_evaluado_cve');
        $this->db->where('encuestas.sse_encuestas.encuesta_cve', $encuesta_cve);

        $this->db->join('encuestas.sse_reglas_evaluacion', 'encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve= encuestas.sse_encuestas.reglas_evaluacion_cve');
        $query = $this->db->get('encuestas.sse_encuestas'); //Obtener conjunto de encuestas
        $resultado = $query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function guarda_reactivos_evaluacion($params = null) {

//        pr($params);
//        exit();
        $preguntas_base = $params['reactivos_base'];
        $reactivos = $params['reactivos'];
        $reactivos_abiertas = $params['reactivos_abiertas'];
        $reactivos_abiertas_radio = $params['reactivos_abiertas_radio'];
        $respuestas_abiertas = $params['respuestas_abiertas'];
        $encuesta_cve = $params['encuesta_cve'];
        $course_cve = $params['curso_cve'];
        $des_autoevaluacion_cve = $params['des_autoevaluacion_cve'];
        $group_id = $params['grupo_cve'];
        $evaluado_user_cve = $params['evaluado_user_cve'];
        $evaluador_user_cve = $params['evaluador_user_cve'];
        $evaluado_rol_cve = $params['evaluado_rol_id'];
        $evaluador_rol_cve = $params['evaluador_rol_id'];
//        $is_bono = $params['is_bono'];
        $is_bono = 1;
        $data = array(
            'encuesta_cve' => $encuesta_cve,
            'course_cve' => $course_cve,
            'group_id' => $group_id,
            'evaluado_user_cve' => $evaluado_user_cve,
            'evaluado_rol_id' => $evaluado_rol_cve,
            'evaluador_user_cve' => $evaluador_user_cve,
            'evaluador_rol_id' => $evaluador_rol_cve,
        );
//        $datos_encuesta_usuario = $this->session->userdata('datos_encuesta_usuario');
//        pr($datos_encuesta_usuario);
//        if (!is_null($datos_encuesta_usuario)) { //Guardar grupos, para el caso de que el tipo sea por bloques
//            foreach ($datos_encuesta_usuario as $key_du => $value_du) {
//                foreach ($value_du as $key_gr => $value_gr) {
//
//                    if (isset($value_gr['gpoid']) && $value_gr['rol_id'] == $evaluado_rol_cve && $value_gr['cursoid'] == $course_cve && $value_gr['gpoid'] == $group_id && $value_gr['userid'] == $evaluado_user_cve) {
//                        $data['grupos_ids_text'] = $value_gr['grupos_ids_text'];
//                    }
//                }
//            }
//        }

        $grupos_text = ''; //Pone como null el valor de grupos por default
        $bloque_ = 0;
        if (isset($params['grupos_ids_text'])) {
            $data['grupos_ids_text'] = $params['grupos_ids_text'];
            $grupos_text = $params['grupos_ids_text']; //Asigna el valor de grupos
            if (isset($params['bloque'])) {
                $bloque_ = $params['bloque'];
            }
        }
//        exit();
        //pr($_SESSION);
        //pr($datos_encuesta_usuario);
        //pr($data);
        //exit();
//        pr($params);

        $this->db->trans_begin(); // inicio de transaccion
        /*
          pr('[CH][Encuestas_model][guarda_reactivos_evaluacion]$reactivos: ');
          pr($params['reactivos']);
         *
         */
        foreach ($preguntas_base as $value) {
            $pregunta = $value["preguntas_cve"];
            $respuesta = $reactivos[$pregunta];
            /*
              pr('[CH][Encuestas_model][guarda_reactivos_evaluacion]$value: ');
              pr($respuesta);
             *
             */
            $data ['preguntas_cve'] = $pregunta;
            $data ['respuesta_abierta'] = $respuesta;
            $data ['reactivos_cve'] = $respuesta;

            if ($value['tipo_pregunta_cve'] == 5) { //solo respuesta abierta, no lleva reactivo asociado
                $data ['reactivos_cve'] = null;
            } else if ($value['tipo_pregunta_cve'] == 6 && !isset($reactivos_abiertas_radio[$pregunta])) { //pregunta abierta con radio y la respuesta es escrita
                $data ['reactivos_cve'] = null;
            }
            $data ['fecha'] = $params['fecha'];
            $this->db->where('encuesta_cve', $params['encuesta_cve']);
            $this->db->where('evaluado_user_cve', $params['evaluado_user_cve']);
            $this->db->where('evaluador_user_cve', $params['evaluador_user_cve']);
            $this->db->where('ev.course_cve', $params['curso_cve']);
            $this->db->where('group_id', $params['grupo_cve']);
            $this->db->where('preguntas_cve', $pregunta);
            if ($bloque_ > 0) {
                $this->db->join('encuestas.sse_curso_bloque_grupo cbg', 'cbg.course_cve = ev.course_cve
                    and cbg.mdl_groups_cve = ANY (string_to_array(ev.grupos_ids_text, \', \')::int[])
                    and cbg.bloque=' . $params['bloque'] . ' and cbg.mdl_groups_cve IN (' . $grupos_text . ') '
                );
            }
//            pr($this->db->last_query());
            //$this->db->where('reactivos_cve', $respuesta);

            $query = $this->db->get('encuestas.sse_evaluacion ev'); //Obtener conjunto de registros
//            pr($query);
            if ($query->num_rows() == 0) {

                //$pregresp = $this->get_pregunta_respuesta($pregunta, $respuesta);
                $this->db->insert('encuestas.sse_evaluacion', $data);
            }
        }
//        pr($data);
        $validacion = $this->get_validar_encuesta_contestada($data, 'promedio', $bloque_, $grupos_text);
        if ($validacion < 1) {//Valida
            //curso_cve, grupo_cve, evaluado_user_cve, evaluado_rol_id
            $parametrosp = array(
                'curso_cve' => $course_cve,
                'grupo_cve' => $group_id,
                'evaluado_user_cve' => $evaluado_user_cve,
                'evaluado_rol_id' => $evaluado_rol_cve,
                'evaluador_rol_id' => $evaluador_rol_cve,
                'evaluador_user_cve' => $evaluador_user_cve,
                'encuesta_cve' => $encuesta_cve,
                'is_bono' => $is_bono
                    )
            ;

            $promedio_of_bono = $this->get_promedio_encuesta_encuesta($parametrosp, $bloque_, $grupos_text); //Promedio de la encuesta que aplica para bono
            $promedio_snb = $this->get_promedio_encuesta_encuesta($parametrosp, $bloque_, $grupos_text, 0); //Promedio de la encuesta que aplica para bono
//            $grupos_text = (isset($data['grupos_ids_text'])) ? $data['grupos_ids_text'] : '';
//            pr($promedio);
            if (!empty($promedio_of_bono)) {//No encontro información guardada
                //GUARDAR EN RESUL_ENCUESTA
                $datares = array(
                    'encuesta_cve' => $encuesta_cve,
                    'course_cve' => $course_cve,
                    'group_id' => $group_id,
                    'evaluado_user_cve' => $evaluado_user_cve,
                    'evaluador_user_cve' => $evaluador_user_cve,
                    'total_puntua_si' => $promedio_of_bono[0]['puntua_reg'],
                    'total_nos' => $promedio_of_bono[0]['total_no'],
                    'total_no_puntua_napv' => $promedio_of_bono[0]['total_no_aplica_no_cuenta_promedio'],
                    'total_no_puntua_apv' => $promedio_of_bono[0]['total_no_aplica_cuenta_promedio'],
                    'total_reactivos_bono' => $promedio_of_bono[0]['total'],
                    'base' => $promedio_of_bono[0]['base_reg'],
                    'calif_emitida' => $promedio_of_bono[0]['porcentaje'],
                    'grupos_ids_text' => $grupos_text,
                    //No promedio que no aplica para bono
                    'total_puntua_si_napb' => $promedio_snb[0]['puntua_reg'],
                    'total_nos_napb' => $promedio_snb[0]['total_no'],
                    'total_no_puntua_napv_napb' => $promedio_snb[0]['total_no_aplica_no_cuenta_promedio'],
                    'total_no_puntua_apv_napb' => $promedio_snb[0]['total_no_aplica_cuenta_promedio'],
                    'base_napb' => $promedio_snb[0]['base_reg'],
                    'total_reactivos_napb' => $promedio_snb[0]['total'],
                    'calif_emitida_napb' => $promedio_snb[0]['porcentaje'],
                );
            } else {
                $datares = array(
                    'encuesta_cve' => $encuesta_cve,
                    'course_cve' => $course_cve,
                    'group_id' => $group_id,
                    'evaluado_user_cve' => $evaluado_user_cve,
                    'evaluador_user_cve' => $evaluador_user_cve,
                    'total_puntua_si' => 0,
                    'total_nos' => 0,
                    'total_no_puntua_napv' => 0,
                    'total_no_puntua_apv' => 0,
                    'total_reactivos_bono' => 0,
                    'base' => 0,
                    'calif_emitida' => 0,
                    'grupos_ids_text' => $grupos_text,
                    //No promedio que no aplica para bono
                    'total_puntua_si_napb' => $promedio_snb[0]['puntua_reg'],
                    'total_nos_napb' => $promedio_snb[0]['total_no'],
                    'total_no_puntua_napv_napb' => $promedio_snb[0]['total_no_aplica_no_cuenta_promedio'],
                    'total_no_puntua_apv_napb' => $promedio_snb[0]['total_no_aplica_cuenta_promedio'],
                    'base_napb' => $promedio_snb[0]['base_reg'],
                    'total_reactivos_napb' => $promedio_snb[0]['total'],
                    'calif_emitida_napb' => $promedio_snb[0]['porcentaje'],
                );
//s                pr('No seencontro información para gardar un promedio');
            }
            $this->db->insert('encuestas.sse_result_evaluacion_encuesta_curso', $datares);
        }
        if ($this->db->trans_status() === FALSE) { // condición para ver si la transaccion se efectuara correctamente
            $this->db->trans_rollback(); // si la transacción no es correcta retornar FALSE
            $bandera = false;
        } else {

            $this->db->trans_commit(); // si la transacción es correcta retornar TRUE
            $bandera = true;
        }
        $this->db->trans_complete();
        return $bandera;
    }

    public function get_validar_encuesta_contestada($params, $tipo = 'respuestas', $bloque = 0, $grupos_text = '') {
        if ($tipo == 'respuestas') {
            $where = array(
                'encuesta_cve', 'course_cve ', 'group_id', 'evaluado_user_cve',
                'evaluador_user_cve', 'evaluado_rol_id', 'evaluador_rol_id'
            );
            $from = 'encuestas.sse_evaluacion';
        } else if ($tipo == 'promedio') {

            $where = array(
                'encuesta_cve', 'reec.course_cve', 'group_id', 'evaluado_user_cve',
                'evaluador_user_cve'
            );

            if ($params['course_cve']) {
                $valtmp = $params['course_cve'];
                $params['reec.course_cve'] = $valtmp;
            }

            $from = 'encuestas.sse_result_evaluacion_encuesta_curso reec';
            if ($bloque > 0) {
                $this->db->join('encuestas.sse_curso_bloque_grupo cbg', 'cbg.course_cve = reec.course_cve
                    and cbg.mdl_groups_cve = ANY (string_to_array(reec.grupos_ids_text, \', \')::int[])
                    and cbg.bloque=' . $bloque . ' and cbg.mdl_groups_cve IN (' . $grupos_text . ') '
                );
            }
        }
        foreach ($where as $val) {
            $this->db->where($val, $params[$val]);
        }
        $query = $this->db->get($from);
//        pr($this->db->last_query());
        return $query->num_rows();
    }

    /**
     *
     * @param type $params
     * @return type
     * @param curso_cve, grupo_cve, evaluado_user_cve, evaluado_rol_id



     */
    public function get_promedio_encuesta_encuesta($params = null, $bloque = 0, $grupos_ids_text = '', $is_bono = 1) {
        //Entidad de emp_actividad_docente
        $select_gral = 'select grupo_cve, evaluador, rol_evaluador, evaluado, rol_evaluado, sum(netos) as total, '
                . 'sum(no_puntua) as no_puntua_reg, sum(nos_) total_no, '
                . 'sum(no_aplica_promedio) as total_no_aplica_cuenta_promedio, '
                . 'sum(no_puntua) as total_no_aplica_no_cuenta_promedio, '
                . 'sum(puntua) as puntua_reg, (sum(netos) - sum(no_puntua)) as base_reg, '
                . '(round(sum(puntua)::numeric * 100/(sum(netos) - sum(no_puntua))::numeric,3)) as porcentaje '
                . ' from ( '
        ;




        $group_by_gral = ' ) as calculos_promedio '
                . ' group by grupo_cve, evaluador, rol_evaluador, evaluado, rol_evaluado ';



        $join_bloque = '';
        if ($bloque > 0) {
            $join_bloque = 'join encuestas.sse_curso_bloque_grupo cbg on
            cbg.course_cve = ev.course_cve
            and cbg.mdl_groups_cve IN (' . $grupos_ids_text . ')
            and cbg.mdl_groups_cve = ANY (string_to_array(ev.grupos_ids_text, \',\')::int[])
            and cbg.bloque = ' . $bloque . ' ';
        }

        $joins = ' from encuestas.sse_evaluacion ev '
                . ' join encuestas.sse_respuestas res on res.reactivos_cve = ev.reactivos_cve '
                . ' join encuestas.sse_preguntas pre on pre.preguntas_cve = ev.preguntas_cve '
                . ' join encuestas.sse_encuesta_curso encc on encc.encuesta_cve = res.encuesta_cve '
                . $join_bloque
        ;


        $grupo = '';
        if (!empty($params['grupo_cve']) and is_numeric($params['grupo_cve']) and intval($params['grupo_cve']) > 0) {
            $grupo = ' and ev.group_id=' . $params['grupo_cve'] . ' ';
        }
        $w_p = array(
            'curso_cve' => ' encc.course_cve=' . $params['curso_cve'] . ' ',
            'grupo_cve' => $grupo,
            'evaluado_user_cve' => ' evaluado_user_cve=' . $params['evaluado_user_cve'] . ' ',
            'evaluado_rol_id' => ' evaluado_rol_id=' . $params['evaluado_rol_id'] . ' ',
            'evaluador_user_cve' => ' evaluador_user_cve=' . $params['evaluador_user_cve'] . ' ',
            'evaluador_rol_id' => ' evaluador_rol_id=' . $params['evaluador_rol_id'] . ' ',
            'is_bono' => ' pre.is_bono=' . $params['is_bono'] . ' ',
        );

        //
        $wbono = ""; //si $is_bono = 0, el cálculo del promedio deberá ser para las encuestas que no plican para bono
        if ($is_bono) {//promedio de encuesta que apliaca para bono
            $wbono = $w_p ['is_bono'] . " and ";
        }

        $where = array(
            'total_si' => " where " . $wbono . $w_p['curso_cve'] . " and res.texto in('Si', 'Casi siempre', 'Siempre') and " . $w_p['evaluador_user_cve'] . " and " . $w_p['evaluador_rol_id'] . " and " . $w_p['evaluado_rol_id'] . " and " . $w_p['evaluado_user_cve'] . $w_p['grupo_cve'],
            'total_is_bono' => " where " . $wbono . $w_p['curso_cve'] . " and " . $w_p['evaluador_user_cve'] . " and " . $w_p['evaluador_rol_id'] . " and " . $w_p['evaluado_rol_id'] . " and " . $w_p['evaluado_user_cve'] . $w_p['grupo_cve'],
            'total_no_aplica' => " where " . $wbono . $w_p['curso_cve'] . " and pre.valido_no_aplica = 1 and res.texto in('No aplica', 'No envió mensaje') and " . $w_p['evaluador_user_cve'] . " and " . $w_p['evaluador_rol_id'] . " and " . $w_p['evaluado_rol_id'] . " and " . $w_p['evaluado_user_cve'] . $w_p['grupo_cve'],
            'total_nos' => " where " . $wbono . $w_p['curso_cve'] . " and res.texto in('No', 'Casi nunca', 'Nunca', 'Algunas veces') and " . $w_p['evaluador_user_cve'] . " and " . $w_p['evaluador_rol_id'] . " and " . $w_p['evaluado_rol_id'] . " and " . $w_p['evaluado_user_cve'] . $w_p['grupo_cve'],
            'total_no_aplica_val_prom' => " where " . $wbono . $w_p['curso_cve'] . " and pre.valido_no_aplica = 0 and res.texto in('No aplica', 'No envió mensaje') and " . $w_p['evaluador_user_cve'] . " and " . $w_p['evaluador_rol_id'] . " and " . $w_p['evaluado_rol_id'] . " and " . $w_p['evaluado_user_cve'] . $w_p['grupo_cve'],
        );
        //Select especifico y repetido
        $s_p = ' ev.evaluador_user_cve "evaluador", ev.evaluador_rol_id "rol_evaluador", ev.evaluado_user_cve "evaluado", ev.evaluado_rol_id "rol_evaluado" ';
        $select = array(
            'total_si' => ' select COUNT(res.texto) as puntua, 0 as no_puntua, 0 as netos, ev.group_id "grupo_cve", 0 as nos_, 0 as no_aplica_promedio, ' . $s_p,
            'total_is_bono' => ' select 0 as puntua, 0 as no_puntua, COUNT(res.texto) as netos, ev.group_id "grupo_cve", 0 as nos_, 0 as no_aplica_promedio, ' . $s_p,
            'total_no_aplica' => 'select 0 as puntua, COUNT(res.texto) as no_puntua, 0 as netos, ev.group_id "grupo_cve", 0 as nos_, 0 as no_aplica_promedio, ' . $s_p,
            'total_nos' => ' select 0 as puntua, 0 as no_puntua, 0 as netos, ev.group_id "grupo_cve", COUNT(res.texto) as nos_, 0 as no_aplica_promedio, ' . $s_p,
            'total_no_aplica_val_prom' => ' select 0 as puntua, 0 as no_puntua, 0 as netos, ev.group_id "grupo_cve", 0 as nos_, COUNT(res.texto) as no_aplica_promedio, ' . $s_p,
        );
        $g_by = 'group by ev.group_id, ev.evaluador_user_cve, ev.evaluador_rol_id, ev.evaluado_user_cve, ev.evaluado_rol_id';



        $string_query = $select_gral;
        $union = '';
        foreach ($select as $key => $value) {
            $string_query .= $union . $value . $joins . $where[$key] . $g_by;
            $union = ' union ';
        }
        $string_query .= $group_by_gral;
//        pr($string_query);
        $query = $this->db->query($string_query);
        $result = $query->result_array();
//        pr($this->db->last_query());
//        pr($result);
        return $result;
    }

    public function listado_evaluados($params = null) {

        /* select u.username as matricula,
          concat(u.firstname,' ',u.lastname) as nombre,
          c.shortname as clave_curso,c.fullname as desc_curso,
          re.rol_evaluado_cve as role,(select name from public.mdl_role where id=re.rol_evaluado_cve) as nrol,re.rol_evaluador_cve as idrol,count(*) as evaluaciones

          from encuestas.sse_result_evaluacion_encuesta_curso ee
          left join public.mdl_user u on u.id=ee.evaluado_user_cve
          left join public.mdl_course c on c.id=ee.course_cve
          inner join encuestas.sse_encuestas en on en.encuesta_cve=ee.encuesta_cve
          inner join encuestas.sse_reglas_evaluacion re on re.reglas_evaluacion_cve=en.reglas_evaluacion_cve


          where ee.course_cve=823
          group by u.username, u.firstname,u.lastname,c.shortname,c.fullname,re.rol_evaluado_cve,re.rol_evaluador_cve
          order by u.firstname,u.lastname,c.shortname,c.fullname,re.rol_evaluado_cve,re.rol_evaluador_cve */

        $resultado = array();
        ///////////////////// Iniciar almacenado de parámetros en cache /////////////////////////
        $this->db->start_cache();
        $this->db->select('encuestas.sse_result_evaluacion_encuesta_curso.evaluacion_resul_cve');
        $this->db->where('encuestas.sse_result_evaluacion_encuesta_curso.course_cve', $params['curso']);


        $this->db->join('public.mdl_user', 'public.mdl_user.id=encuestas.sse_result_evaluacion_encuesta_curso.evaluado_user_cve', 'left');
        $this->db->join('public.mdl_course', 'public.mdl_course.id=encuestas.sse_result_evaluacion_encuesta_curso.course_cve', 'left');
        $this->db->join('encuestas.sse_encuestas', 'encuestas.sse_encuestas.encuesta_cve=encuestas.sse_result_evaluacion_encuesta_curso.encuesta_cve');
        $this->db->join('encuestas.sse_reglas_evaluacion', 'encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve=encuestas.sse_encuestas.reglas_evaluacion_cve');
        //$this->db->join('encuestas.sse_curso_bloque_grupo cbg', 'cbg.course_cve = encuestas.sse_result_evaluacion_encuesta_curso.course_cve and cbg.mdl_groups_cve = encuestas.sse_result_evaluacion_encuesta_curso.group_id');

        $this->db->stop_cache();
        /////////////////////// Fin almacenado de parámetros en cache ///////////////////////////
        ///////////////////////////// Obtener número de registros ///////////////////////////////
        $nr = $this->db->get_compiled_select('encuestas.sse_result_evaluacion_encuesta_curso'); //Obtener el total de registros
        $num_rows = $this->db->query("SELECT count(*) AS total FROM (" . $nr . ") AS temp")->result();
        //pr($this->db1->last_query());
        /////////////////////////////// FIN número de registros /////////////////////////////////
        $busqueda = array(
            'mdl_user.username as matricula',
            'mdl_user.firstname as nombre',
            'mdl_user.lastname as apellidos',
            'mdl_course.shortname as clave_curso',
            'mdl_course.fullname as desc_curso',
            'encuestas.sse_reglas_evaluacion.rol_evaluado_cve as evaluado',
            '(select name from public.mdl_role where id=sse_reglas_evaluacion.rol_evaluado_cve) as nrolevaluado',
            'sse_reglas_evaluacion.rol_evaluador_cve as evaluador',
            '(select name from public.mdl_role where id=sse_reglas_evaluacion.rol_evaluador_cve) as nrolevaluador',
            'count(*) as evaluaciones',
            'encuestas.sse_result_evaluacion_encuesta_curso.group_id as grupo_id',
            'encuestas.sse_result_evaluacion_encuesta_curso.calif_emitida as calif_emitida',
            '(select name from public.mdl_groups where id=encuestas.sse_result_evaluacion_encuesta_curso.group_id) as ngrupo',
            '(select public.mdl_user.firstname ||  \'  \'  || public.mdl_user.lastname from public.mdl_user where id=sse_result_evaluacion_encuesta_curso.evaluador_user_cve) as nombreevaluador',
            '(select * from departments.get_rama_completa((select cve_departamental from public.mdl_user where id=evaluado_user_cve), 7)) as ramaevaluado',
            '(select * from departments.get_rama_completa((select cve_departamental from gestion.sgp_tab_preregistro_al where nom_usuario like (select username from public.mdl_user where id=evaluador_user_cve) and cve_curso=encuestas.sse_result_evaluacion_encuesta_curso.course_cve), 7)) as ramaevaluador',
            '(select username from public.mdl_user where id=evaluador_user_cve) as matricula_evaluador',
                //'cbg.bloque',
        );

        $this->db->select($busqueda);
        if (isset($params['order']) && !empty($params['order'])) {
            $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
            $this->db->order_by($params['order'], $tipo_orden);
        }
        if (isset($params['per_page']) && isset($params['current_row'])) { //Establecer límite definido para paginación
            $this->db->limit($params['per_page'], $params['current_row']);
        }

        $this->db->group_by('sse_result_evaluacion_encuesta_curso.evaluacion_resul_cve,mdl_user.username, mdl_user.firstname,mdl_user.lastname,mdl_course.shortname,mdl_course.fullname,
            sse_reglas_evaluacion.rol_evaluado_cve,sse_reglas_evaluacion.rol_evaluador_cve' //, cbg.bloque'
        );

        $query = $this->db->get('encuestas.sse_result_evaluacion_encuesta_curso'); //Obtener conjunto de registros
//        pr($this->db->last_query());
        $resultado['total'] = $num_rows[0]->total;
        $resultado['columns'] = $query->list_fields();
        $resultado['data'] = $query->result_array();
        //pr($resultado['data']);
        $this->db->flush_cache();
        $query->free_result(); //Libera la memoria


        return $resultado;
    }

    public function existe_clave($cve_corta_encuesta = null) {
        $resultado = array('result' => false, 'id' => 0);
        $this->db->where('cve_corta_encuesta', $cve_corta_encuesta);
        $query = $this->db->get('encuestas.sse_encuestas'); //Obtener conjunto de registros
        //pr($query);
        if ($query->num_rows() > 0) {
            return TRUE;
        } else
            return FALSE;
    }

    public function get_reglas_evaluacion() {
        $select_params = array(
            'reglas_evaluacion_cve',
            'CONCAT(
                    (SELECT "mdl_role"."name" FROM "public"."mdl_role" WHERE "sse_reglas_evaluacion"."rol_evaluador_cve" = "mdl_role"."id"),
                    \' - \',
                    (SELECT "mdl_role"."name" FROM "public"."mdl_role" WHERE "sse_reglas_evaluacion"."rol_evaluado_cve" = "mdl_role"."id"),
                    \' - \',
                    CASE WHEN tutorizado=1 THEN \'tutorizado\'
                        WHEN tutorizado=0 THEN \'no tutorizado\'
                        ELSE \'otro\'
                    END
                ) AS nom_regla_desc'
        );

        $this->db->select($select_params);
        $query = $this->db->get('encuestas.sse_reglas_evaluacion');

        return $query->result_array();
    }

    public function desasociar_instrumento($id_encuesta = null, $id_curso = null) {
        //Buscar si existen encuestas respondidas
        $resultado = array('result' => false, 'id' => 0);
        $this->db->where('encuesta_cve', $id_encuesta);
        $this->db->where('course_cve', $id_curso);

        $query = $this->db->get('encuestas.sse_result_evaluacion_encuesta_curso'); //Obtener conjunto de registros
        if ($query->num_rows() == 0) {
            if(!$this->existen_encuestas_contestadas($id_curso))
            {
                $this->db->delete('encuestas.sse_encuesta_curso', array('encuesta_cve' => $id_encuesta, 'course_cve' => $id_curso));
                $this->db->reset_query();
                $this->db->where("id_curso not in (select course_cve from encuestas.sse_result_evaluacion_encuesta_curso where course_cve = id_curso) and id_encuesta not in (select course_cve from encuestas.sse_result_evaluacion_encuesta_curso where encuesta_cve = id_encuesta) and id_encuesta = {$id_encuesta} and id_curso = {$id_curso}", null, false);
                $this->db->delete('encuestas.sse_contador_encuestas');
                $this->db->reset_query();
                //pr($this->db->last_query());
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * @author LEAS
     * @fechamod 07/02/2017
     * @param type $params array de parametros
     * @return ARRAY INT roles del usuario
     * @describe Si $params contiene como parametros 'cur_id', entonces, trae los roles
     * del usuario relacionados al curso, si no, trae todos los roles del usuario en todos
     * los cursos donde tenga presencia
     */
    public function get_roles_usercurso($params = null) {
        $this->db->select('mdl_role.id');
        $this->db->join('mdl_context', 'mdl_context.instanceid = mdl_course.id');
        $this->db->join('mdl_role_assignments', 'mdl_context.id = mdl_role_assignments.contextid');
        $this->db->join('mdl_role', 'mdl_role.id = mdl_role_assignments.roleid');
        $this->db->join('mdl_user', 'mdl_user.id = mdl_role_assignments.userid');
        if (isset($params['cur_id'])) {
            $this->db->where('mdl_course.id', $params['cur_id']);
        } else {//Si no existe curso, puede repetir los roles, por eso se agrupa para quitar repetidos
            $this->db->group_by('mdl_role.id');
            $this->db->order_by('mdl_role.id asc');
        }

        $this->db->where_in('mdl_role.id', [5, 14, 30, 18, 33, 32]);
        //

        if (isset($params['user_id'])) {
            $this->db->where('mdl_user.id', $params['user_id']);
        }
        $result = $this->db->get('mdl_course');


        $arrol = array();

        $usuariosrol = $result->result_array();

        if ($result->num_rows() > 0) {

            foreach ($usuariosrol as $value) {

                $arrol[] = $value['id'];
            }
        }
        $result->free_result();
//        pr($this->db->last_query());
        return $arrol;
    }

    public function get_reglas_validas_cur($params = null) {
        // $resultado = array();
        /* select re.reglas_evaluacion_cve,re.rol_evaluado_cve,re.is_excepcion,en.encuesta_cve,en.tipo_encuesta,en.eva_tipo,re.ord_prioridad
          from encuestas.sse_reglas_evaluacion re
          inner join encuestas.sse_encuestas en on en.reglas_evaluacion_cve=re.reglas_evaluacion_cve
          inner join encuestas.sse_encuesta_curso enc on enc.encuesta_cve=en.encuesta_cve
          where  re.rol_evaluador_cve=18 and re.tutorizado=1 and enc.course_cve=823
          order by ord_prioridad */
        $this->db->where('sse_encuestas.status', '1');

        if (isset($params['role_evaluador']) && !empty($params['role_evaluador'])) {
            $this->db->where('sse_reglas_evaluacion.rol_evaluador_cve', $params['role_evaluador']);
        }
        if (isset($params['tutorizado']) && !empty($params['tutorizado'])) {
            $this->db->where('sse_reglas_evaluacion.tutorizado', $params['tutorizado']);
        }

        if (isset($params['cur_id']) && !empty($params['cur_id'])) {
            $this->db->where('sse_encuesta_curso.course_cve', $params['cur_id']);
        }

        //$cadena_equipo = implode(",", $params['role_evaluado']);
        //condicionantes de acuerdo a la existencia de los roles
        if (isset($params['role_evaluado']) && !empty($params['role_evaluado']) && !in_array(0, $params['role_evaluado'])) {
            /* foreach ($params['role_evaluado'] as $value) {

              $this->db->where('sse_reglas_evaluacion.rol_evaluado_cve',$value);
              # code...
              } */
//            $this->db->where('sse_reglas_evaluacion.rol_evaluado_cve',$cadena_equipo);


            $this->db->where_in('sse_reglas_evaluacion.rol_evaluado_cve', $params['role_evaluado']);
        }


        if (isset($params['cur_id']) && !empty($params['cur_id'])) {
            $this->db->where_in('sse_reglas_evaluacion.ord_prioridad', $params['ord_prioridad']);
        }




        $this->db->join('encuestas.sse_encuestas', 'sse_encuestas.reglas_evaluacion_cve=sse_reglas_evaluacion.reglas_evaluacion_cve');
        $this->db->join('encuestas.sse_encuesta_curso', 'sse_encuesta_curso.encuesta_cve=sse_encuestas.encuesta_cve');

        $busqueda = array(
            'sse_reglas_evaluacion.reglas_evaluacion_cve',
            'sse_reglas_evaluacion.rol_evaluado_cve',
            'sse_reglas_evaluacion.is_excepcion',
            'sse_encuestas.encuesta_cve',
            'sse_encuestas.tipo_encuesta',
            'sse_encuestas.eva_tipo',
            'sse_reglas_evaluacion.ord_prioridad',
            'sse_reglas_evaluacion.is_bono',
        );

        $this->db->select($busqueda);




        $query = $this->db->get('encuestas.sse_reglas_evaluacion');
        //$resultado['data']=$query->result_array();
        $resultado = $query->result_array();
//        pr($this->db->last_query());





        $this->db->flush_cache();
        $query->free_result(); //Libera la memoria



        return $resultado;
    }

    public function listado_encuestas($is_contestadas = null) {
        $resultado = array();
        ///////////////////// Iniciar almacenado de parámetros en cache /////////////////////////
        $this->db->start_cache();
        $this->db->select('*');
        /* $this->db->where('encuestas.sse_result_evaluacion.course_cve', $params['curso']);


          $this->db->join('public.mdl_user', 'public.mdl_user.id=encuestas.sse_result_evaluacion.evaluado_user_cve','left');
          $this->db->join('public.mdl_course', 'public.mdl_course.id=encuestas.sse_result_evaluacion.course_cve','left');
          $this->db->join('encuestas.sse_encuestas', 'encuestas.sse_encuestas.encuesta_cve=encuestas.sse_result_evaluacion.encuesta_cve');
          $this->db->join('encuestas.sse_reglas_evaluacion', 'encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve=encuestas.sse_encuestas.reglas_evaluacion_cve');
         */
        $this->db->stop_cache();
        /////////////////////// Fin almacenado de parámetros en cache ///////////////////////////
        ///////////////////////////// Obtener número de registros ///////////////////////////////
        $nr = $this->db->get_compiled_select('encuestas.sse_result_evaluacion'); //Obtener el total de registros
        $num_rows = $this->db->query("SELECT count(*) AS total FROM (" . $nr . ") AS temp")->result();
        //pr($this->db1->last_query());
        /////////////////////////////// FIN número de registros /////////////////////////////////


        $this->db->select('*');


        $this->db->from('(select encuestas.sse_encuestas.encuesta_cve,descripcion_encuestas,
        (select cve_departamental from gestion.sgp_tab_preregistro_al where nom_usuario like (select username from public.mdl_user where id=evaluador_user_cve) and cve_curso=course_cve) as cvedepevaluador,
        (select * from departments.get_rama_completa((select cve_departamental from gestion.sgp_tab_preregistro_al where nom_usuario like (select username from public.mdl_user where id=evaluador_user_cve) and cve_curso=course_cve), 7)) as ramaevaluador,
        (select username from public.mdl_user where id=evaluador_user_cve) as matevaluador,
        (select firstname || \' \' || lastname from public.mdl_user where id=evaluador_user_cve) as evaluador,
        (select name from public.mdl_role where id=evaluador_rol_id) as rolevaluador,
        (select cve_departamento from tutorias.mdl_usertutor where nom_usuario like (select username from public.mdl_user where id=evaluado_user_cve) and id_curso=course_cve) as cvedepevaluado,

        (select username from public.mdl_user where id=evaluado_user_cve) as matevaluado,
        (select firstname || \' \' || lastname from public.mdl_user where id=evaluado_user_cve) as evaluado,
        (select name from public.mdl_role where id=evaluado_rol_id) as rolevaluado,

        (select pregunta from encuestas.sse_preguntas where preguntas_cve=encuestas.sse_evaluacion.preguntas_cve) as pregunta,
        (select orden from encuestas.sse_preguntas where preguntas_cve=encuestas.sse_evaluacion.preguntas_cve) as orden,
        (select texto from encuestas.sse_respuestas where reactivos_cve=encuestas.sse_evaluacion.reactivos_cve) as respuesta

        from encuestas.sse_evaluacion
        inner join encuestas.sse_encuestas  on  encuestas.sse_encuestas.encuesta_cve= encuestas.sse_evaluacion.encuesta_cve
        inner join encuestas.sse_reglas_evaluacion  on  encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve= encuestas.sse_encuestas.reglas_evaluacion_cve
        where course_cve=' . $params['curso'] . ' and evaluador_rol_id=5
        UNION all

        select encuestas.sse_encuestas.encuesta_cve,descripcion_encuestas,
        (select cve_departamento from tutorias.mdl_usertutor where nom_usuario like (select username from public.mdl_user where id=evaluador_user_cve) and id_curso=course_cve) as cvedepevaluador,
        (select * from departments.get_rama_completa((select cve_departamento from tutorias.mdl_usertutor where nom_usuario like (select username from public.mdl_user where id=evaluador_user_cve) and id_curso=course_cve), 7)) as ramaevaluado,
        (select username from public.mdl_user where id=evaluador_user_cve) as matevaluador,
        (select firstname || \' \' || lastname from public.mdl_user where id=evaluador_user_cve) as evaluador,
        (select name from public.mdl_role where id=evaluador_rol_id) as rolevaluador,
        (select cve_departamento from tutorias.mdl_usertutor where nom_usuario like (select username from public.mdl_user where id=evaluado_user_cve) and id_curso=course_cve) as cvedepevaluado,

        (select username from public.mdl_user where id=evaluado_user_cve) as matevaluado,
        (select firstname || \' \' || lastname from public.mdl_user where id=evaluado_user_cve) as evaluado,
        (select name from public.mdl_role where id=evaluado_rol_id) as rolevaluado,

        (select pregunta from encuestas.sse_preguntas where preguntas_cve=encuestas.sse_evaluacion.preguntas_cve) as pregunta,
        (select orden from encuestas.sse_preguntas where preguntas_cve=encuestas.sse_evaluacion.preguntas_cve) as orden,
        (select texto from encuestas.sse_respuestas where reactivos_cve=encuestas.sse_evaluacion.reactivos_cve) as respuesta

        from encuestas.sse_evaluacion
        inner join encuestas.sse_encuestas  on  encuestas.sse_encuestas.encuesta_cve= encuestas.sse_evaluacion.encuesta_cve
        inner join encuestas.sse_reglas_evaluacion  on  encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve= encuestas.sse_encuestas.reglas_evaluacion_cve
        where course_cve=' . $params['curso'] . ' and evaluador_rol_id <> 5) as t');


        /* if(isset($params['order']) && !empty($params['order'])){
          $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
          $this->db->order_by($params['order'], $tipo_orden);
          } */
        if (isset($params['per_page']) && isset($params['current_row'])) { //Establecer límite definido para paginación
            $this->db->limit($params['per_page'], $params['current_row']);
        }

        $this->db->group_by('t.encuesta_cve,t.descripcion_encuestas,t.pregunta,t.orden,t.cvedepevaluador,t.ramaevaluador,t.evaluador,t.rolevaluador,t.cvedepevaluado,
        t.matevaluado,t.evaluado,t.rolevaluado,t.respuesta,t.matevaluador');

        $this->db->order_by('t.encuesta_cve,t.matevaluado,t.orden');

        $query = $this->db->get(); //Obtener conjunto de registros
        //pr($this->db1->last_query());
        $resultado['total'] = $num_rows[0]->total;
        $resultado['columns'] = $query->list_fields();
        $resultado['data'] = $query->result_array();
        //pr($resultado['data']);
        $this->db->flush_cache();
        $query->free_result(); //Libera la memoria


        return $resultado;
    }

//    public function listado_evaluados_detalle($params = null) {
//
//        /*
//          SELECT * FROM
//          (select encuestas.sse_encuestas.encuesta_cve,descripcion_encuestas,
//          (select cve_departamental from gestion.sgp_tab_preregistro_al where nom_usuario like (select username from public.mdl_user where id=evaluador_user_cve) and cve_curso=course_cve) as cvedepevaluador,
//          (select * from departments.get_rama_json((select cve_departamental from gestion.sgp_tab_preregistro_al where nom_usuario like (select username from public.mdl_user where id=evaluador_user_cve) and cve_curso=course_cve), 7)) as ramaevaluador,
//          (select username from public.mdl_user where id=evaluador_user_cve) as matevaluador,
//          (select firstname || ' ' || lastname from public.mdl_user where id=evaluador_user_cve) as evaluador,
//          (select name from public.mdl_role where id=evaluador_rol_id) as rolevaluador,
//          (select cve_departamento from tutorias.mdl_usertutor where nom_usuario like (select username from public.mdl_user where id=evaluado_user_cve) and id_curso=course_cve) as cvedepevaluado,
//
//          (select username from public.mdl_user where id=evaluado_user_cve) as matevaluado,
//          (select firstname || ' ' || lastname from public.mdl_user where id=evaluado_user_cve) as evaluado,
//          (select name from public.mdl_role where id=evaluado_rol_id) as rolevaluado,
//
//          (select pregunta from encuestas.sse_preguntas where preguntas_cve=encuestas.sse_evaluacion.preguntas_cve) as pregunta,
//          (select orden from encuestas.sse_preguntas where preguntas_cve=encuestas.sse_evaluacion.preguntas_cve) as orden,
//          (select texto from encuestas.sse_respuestas where reactivos_cve=encuestas.sse_evaluacion.reactivos_cve) as respuesta
//
//          from encuestas.sse_evaluacion
//          inner join encuestas.sse_encuestas  on  encuestas.sse_encuestas.encuesta_cve= encuestas.sse_evaluacion.encuesta_cve
//          inner join encuestas.sse_reglas_evaluacion  on  encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve= encuestas.sse_encuestas.reglas_evaluacion_cve
//          where course_cve=824 and evaluador_rol_id=5
//          UNION all
//
//          select encuestas.sse_encuestas.encuesta_cve,descripcion_encuestas,
//          (select cve_departamento from tutorias.mdl_usertutor where nom_usuario like (select username from public.mdl_user where id=evaluador_user_cve) and id_curso=course_cve) as cvedepevaluador,
//          (select * from departments.get_rama_json((select cve_departamento from tutorias.mdl_usertutor where nom_usuario like (select username from public.mdl_user where id=evaluador_user_cve) and id_curso=course_cve), 7)) as ramaevaluado,
//          (select username from public.mdl_user where id=evaluador_user_cve) as matevaluador,
//          (select firstname || ' ' || lastname from public.mdl_user where id=evaluador_user_cve) as evaluador,
//          (select name from public.mdl_role where id=evaluador_rol_id) as rolevaluador,
//          (select cve_departamento from tutorias.mdl_usertutor where nom_usuario like (select username from public.mdl_user where id=evaluado_user_cve) and id_curso=course_cve) as cvedepevaluado,
//
//          (select username from public.mdl_user where id=evaluado_user_cve) as matevaluado,
//          (select firstname || ' ' || lastname from public.mdl_user where id=evaluado_user_cve) as evaluado,
//          (select name from public.mdl_role where id=evaluado_rol_id) as rolevaluado,
//
//          (select pregunta from encuestas.sse_preguntas where preguntas_cve=encuestas.sse_evaluacion.preguntas_cve) as pregunta,
//          (select orden from encuestas.sse_preguntas where preguntas_cve=encuestas.sse_evaluacion.preguntas_cve) as orden,
//          (select texto from encuestas.sse_respuestas where reactivos_cve=encuestas.sse_evaluacion.reactivos_cve) as respuesta
//
//          from encuestas.sse_evaluacion
//          inner join encuestas.sse_encuestas  on  encuestas.sse_encuestas.encuesta_cve= encuestas.sse_evaluacion.encuesta_cve
//          inner join encuestas.sse_reglas_evaluacion  on  encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve= encuestas.sse_encuestas.reglas_evaluacion_cve where course_cve=824 and evaluador_rol_id <> 5) as t
//
//
//          group by t.encuesta_cve,t.descripcion_encuestas,t.pregunta,t.orden,t.cvedepevaluador,t.ramaevaluador,t.evaluador,t.rolevaluador,t.cvedepevaluado,
//          t.matevaluado,t.evaluado,t.rolevaluado,t.respuesta,t.matevaluador
//
//          order by t.encuesta_cve,t.matevaluado,t.orden
//         */
//
//        $resultado = array();
//        ///////////////////// Iniciar almacenado de parámetros en cache /////////////////////////
//        $this->db->start_cache();
//        $this->db->select('*');
//        /* $this->db->where('encuestas.sse_result_evaluacion.course_cve', $params['curso']);
//
//
//          $this->db->join('public.mdl_user', 'public.mdl_user.id=encuestas.sse_result_evaluacion.evaluado_user_cve','left');
//          $this->db->join('public.mdl_course', 'public.mdl_course.id=encuestas.sse_result_evaluacion.course_cve','left');
//          $this->db->join('encuestas.sse_encuestas', 'encuestas.sse_encuestas.encuesta_cve=encuestas.sse_result_evaluacion.encuesta_cve');
//          $this->db->join('encuestas.sse_reglas_evaluacion', 'encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve=encuestas.sse_encuestas.reglas_evaluacion_cve');
//         */
//        $this->db->stop_cache();
//        /////////////////////// Fin almacenado de parámetros en cache ///////////////////////////
//        ///////////////////////////// Obtener número de registros ///////////////////////////////
//        $nr = $this->db->get_compiled_select('encuestas.sse_result_evaluacion'); //Obtener el total de registros
//        $num_rows = $this->db->query("SELECT count(*) AS total FROM (" . $nr . ") AS temp")->result();
//        //pr($this->db1->last_query());
//        /////////////////////////////// FIN número de registros /////////////////////////////////
//
//
//        $this->db->select('*');
//
//
//        $this->db->from('(select encuestas.sse_encuestas.encuesta_cve,descripcion_encuestas,
//        (select cve_departamental from gestion.sgp_tab_preregistro_al where nom_usuario like (select username from public.mdl_user where id=evaluador_user_cve) and cve_curso=course_cve) as cvedepevaluador,
//        (select * from departments.get_rama_completa((select cve_departamental from gestion.sgp_tab_preregistro_al where nom_usuario like (select username from public.mdl_user where id=evaluador_user_cve) and cve_curso=course_cve), 7)) as ramaevaluador,
//        (select username from public.mdl_user where id=evaluador_user_cve) as matevaluador,
//        (select firstname || \' \' || lastname from public.mdl_user where id=evaluador_user_cve) as evaluador,
//        (select name from public.mdl_role where id=evaluador_rol_id) as rolevaluador,
//        (select cve_departamento from tutorias.mdl_usertutor where nom_usuario like (select username from public.mdl_user where id=evaluado_user_cve) and id_curso=course_cve) as cvedepevaluado,
//
//        (select username from public.mdl_user where id=evaluado_user_cve) as matevaluado,
//        (select firstname || \' \' || lastname from public.mdl_user where id=evaluado_user_cve) as evaluado,
//        (select name from public.mdl_role where id=evaluado_rol_id) as rolevaluado,
//
//        (select pregunta from encuestas.sse_preguntas where preguntas_cve=encuestas.sse_evaluacion.preguntas_cve) as pregunta,
//        (select orden from encuestas.sse_preguntas where preguntas_cve=encuestas.sse_evaluacion.preguntas_cve) as orden,
//        (select texto from encuestas.sse_respuestas where reactivos_cve=encuestas.sse_evaluacion.reactivos_cve) as respuesta
//
//        from encuestas.sse_evaluacion
//        inner join encuestas.sse_encuestas  on  encuestas.sse_encuestas.encuesta_cve= encuestas.sse_evaluacion.encuesta_cve
//        inner join encuestas.sse_reglas_evaluacion  on  encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve= encuestas.sse_encuestas.reglas_evaluacion_cve
//        where course_cve=' . $params['curso'] . ' and evaluador_rol_id=5
//        UNION all
//
//        select encuestas.sse_encuestas.encuesta_cve,descripcion_encuestas,
//        (select cve_departamento from tutorias.mdl_usertutor where nom_usuario like (select username from public.mdl_user where id=evaluador_user_cve) and id_curso=course_cve) as cvedepevaluador,
//        (select * from departments.get_rama_completa((select cve_departamento from tutorias.mdl_usertutor where nom_usuario like (select username from public.mdl_user where id=evaluador_user_cve) and id_curso=course_cve), 7)) as ramaevaluado,
//        (select username from public.mdl_user where id=evaluador_user_cve) as matevaluador,
//        (select firstname || \' \' || lastname from public.mdl_user where id=evaluador_user_cve) as evaluador,
//        (select name from public.mdl_role where id=evaluador_rol_id) as rolevaluador,
//        (select cve_departamento from tutorias.mdl_usertutor where nom_usuario like (select username from public.mdl_user where id=evaluado_user_cve) and id_curso=course_cve) as cvedepevaluado,
//
//        (select username from public.mdl_user where id=evaluado_user_cve) as matevaluado,
//        (select firstname || \' \' || lastname from public.mdl_user where id=evaluado_user_cve) as evaluado,
//        (select name from public.mdl_role where id=evaluado_rol_id) as rolevaluado,
//
//        (select pregunta from encuestas.sse_preguntas where preguntas_cve=encuestas.sse_evaluacion.preguntas_cve) as pregunta,
//        (select orden from encuestas.sse_preguntas where preguntas_cve=encuestas.sse_evaluacion.preguntas_cve) as orden,
//        (select texto from encuestas.sse_respuestas where reactivos_cve=encuestas.sse_evaluacion.reactivos_cve) as respuesta
//
//        from encuestas.sse_evaluacion
//        inner join encuestas.sse_encuestas  on  encuestas.sse_encuestas.encuesta_cve= encuestas.sse_evaluacion.encuesta_cve
//        inner join encuestas.sse_reglas_evaluacion  on  encuestas.sse_reglas_evaluacion.reglas_evaluacion_cve= encuestas.sse_encuestas.reglas_evaluacion_cve
//        where course_cve=' . $params['curso'] . ' and evaluador_rol_id <> 5) as t');
//
//
//        /* if(isset($params['order']) && !empty($params['order'])){
//          $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
//          $this->db->order_by($params['order'], $tipo_orden);
//          } */
//        if (isset($params['per_page']) && isset($params['current_row'])) { //Establecer límite definido para paginación
//            $this->db->limit($params['per_page'], $params['current_row']);
//        }
//
//        $this->db->group_by('t.encuesta_cve,t.descripcion_encuestas,t.pregunta,t.orden,t.cvedepevaluador,t.ramaevaluador,t.evaluador,t.rolevaluador,t.cvedepevaluado,
//        t.matevaluado,t.evaluado,t.rolevaluado,t.respuesta,t.matevaluador');
//
//        $this->db->order_by('t.encuesta_cve,t.matevaluado,t.orden');
//
//        $query = $this->db->get(); //Obtener conjunto de registros
//        //pr($this->db1->last_query());
//        $resultado['total'] = $num_rows[0]->total;
//        $resultado['columns'] = $query->list_fields();
//        $resultado['data'] = $query->result_array();
//        //pr($resultado['data']);
//        $this->db->flush_cache();
//        $query->free_result(); //Libera la memoria
//
//
//        return $resultado;
//    }

    public function get_indicador($descripcion = '') {
        $this->db->select('sse_indicador.indicador_cve');
        $this->db->where('sse_indicador.descripcion', $descripcion);
        $query = $this->db->get('encuestas.sse_indicador');
        $resultado = $query->result_array();

        return $resultado;
    }

    public function guarda_indicador($indicador = array()) {
        /* # guarda el nombre de la sección...
          descripcion

         * # retorna el id de la sección y el id creado para identificar las preguntas...
          seccion_cve
          id_seccion_enc
         */
        $indicador_bd = $this->get_indicador($indicador['descripcion_indicador']);
        if (isset($indicador_bd[0]['indicador_cve']) && $indicador_bd[0]['indicador_cve'] > 0) {
            //$seccion = $seccion_bd[0]['seccion_cve'];
            $row = array(
                'insert_id' => $indicador_bd[0]['indicador_cve'],
                'id_indicador_enc' => $indicador['id_indicador_enc']
            );
        } else {
            $data['descripcion'] = $indicador['descripcion_indicador'];
            $this->db->insert('encuestas.sse_indicador', $data);
            $insert_id = $this->db->insert_id();

            $row = array(
                'insert_id' => $insert_id,
                'id_indicador_enc' => $indicador['id_indicador_enc']
            );
        }
        //echo '<br>], sec: '.$row['insert_id'].' [';
        return $row;
    }

    public function get_indicadores() {

        $query = $this->db->get('encuestas.sse_indicador');
        $resultado = $query->result_array();

        return $resultado;
    }

    private function getReglasRolEvaluador($parametros = null) {
        if (is_null($parametros)) {
            return array();
        }
        $select = array("reg.reglas_evaluacion_cve", "reg.rol_evaluado_cve", "reg.rol_evaluador_cve",
            "reg.is_excepcion", "reg.tutorizado", "reg.is_bono", "reg.ord_prioridad",
            "reg.eval_is_satisfaccion"
        );

        $this->db->select($select);
        $this->db->where('reg.rol_evaluador_cve', $parametros['role_evaluador']);
        $this->db->where('reg.tutorizado', $parametros['tutorizado']);
        $this->db->order_by('reg.ord_prioridad', 'asc'); //Importante obtrener el de mayor presedencia

        $query = $this->db->get('encuestas.sse_reglas_evaluacion reg');


        $resultado = $query->result_array();
        $this->db->flush_cache();
        $query->free_result(); //Libera la memoria
//        pr($this->db->last_query());
//        if (!empty($resultado)) {
//            $resultado = $resultado[0];
//        }

        return $resultado;
    }

    /**
     *
     * @param type $params
     * @return type
     */
    public function get_promedio_encuesta_indicador($params = null) {
        $this->db->select(array('indicador_cve', 'descripcion'));
        $query = $this->db->get('encuestas.sse_indicador'); //Obtener conjunto de registros
        $indicadores = $query->result_array();

        $query->free_result(); //Libera la memoria
        $select = array('BLOQUE.bloque as "BLN"', "AA.course_cve", "AA.group_id",
            "AA.evaluador_user_cve",
            "AA.evaluador_rol_id",
            "AA.evaluado_user_cve",
            "AA.evaluado_rol_id",
            "AA.grupos_ids_text",
            'concat("U1".firstname, \' \', "U1".lastname, \' (\',"U1".username, \')\') as "UN1"',
            "UR1.name URN1",
            'concat("U2".firstname, \' \', "U2".lastname, \' (\',"U1".username, \')\') as "UN2"',
            "UR2.name URN2",
            'CURSO.namec "CN"',
            'CASE WHEN "AA".grupos_ids_text <> \'\' AND "AA".grupos_ids_text IS NOT NULL THEN (SELECT array_agg(g.name)::varchar FROM public.mdl_groups g WHERE g.id=ANY(regexp_split_to_array("AA".grupos_ids_text, \',\')::bigint[])) ELSE null END AS "GN"',
            'GRUPO.name "GN1"',
            'depto_tut_evaluado.name_region "region_evaluado"',
            'depto_tut_evaluado.nom_delegacion "delegacion_evaluado"',
            //'depto_tut_evaluado.des_unidad_atencion "unidad_evaluado"',
            '(select * from departments.get_unidad(depto_tut_evaluado.cve_depto_adscripcion, 7)) as "unidad_evaluado"',
            'cat_tut_evaluado.nom_nombre "categoria_evaluado"',
            'depto_pre_evaluador.name_region "region_evaluador1"',
            'depto_pre_evaluador.nom_delegacion "delegacion_evaluador1"',
            //'depto_pre_evaluador.des_unidad_atencion "unidad_evaluador1"',
            '(select * from departments.get_unidad(depto_pre_evaluador.cve_depto_adscripcion, 7)) as "unidad_evaluador1"',
            'cat_pre_evaluador.nom_nombre "categoria_evaluador1"',
            'depto_tut_evaluador.name_region "region_evaluador2"',
            'depto_tut_evaluador.nom_delegacion "delegacion_evaluador2"',
            //'depto_tut_evaluador.des_unidad_atencion "unidad_evaluador2"',
            '(select * from departments.get_unidad(depto_tut_evaluador.cve_depto_adscripcion, 7)) as "unidad_evaluador2"',
            'cat_tut_evaluador.nom_nombre "categoria_evaluador2"',
            ////////////// Se agregan para autoevaluaciones
            "autoevaluacion.evaluador_user_cve as autoeva_user_cve", "usuario_autoevaluacion.username as autoeva_username", "usuario_autoevaluacion.firstname as autoeva_nombre", "usuario_autoevaluacion.lastname as autoeva_apellido",
            "autoevaluacion.evaluador_rol_id as autoeva_rol_id", "rol_autoevaluacion.name as autoeva_rol_nombre", "tutor_autoevaluacion.cve_departamento as autoeva_cve_departamento",
            "depto_tut_autoevaluacion.nom_depto_adscripcion as autoeva_nom_depto", "depto_tut_autoevaluacion.cve_regiones as autoeva_cve_regiones",
            "depto_tut_autoevaluacion.name_region as autoeva_name_region", "depto_tut_autoevaluacion.cve_delegacion as autoeva_cve_delegacion",
            "depto_tut_autoevaluacion.nom_delegacion as autoeva_nom_delegacion", "(select * from departments.get_unidad(tutor_autoevaluacion.cve_departamento, 7)) as rama_tut_autoevaluacion",
            "tutor_autoevaluacion.cve_categoria as autoeva_cve_categoria", "cat_tut_autoevaluacion.nom_nombre as autoeva_cat_nombre");

        $this->db->flush_cache();

        $this->db->start_cache();

        $this->db->select('case when count(*) = sum(encuestas.get_value_reactivo(3,C.valido_no_aplica, "B".texto)) then 0 else 100*(sum(encuestas.get_value_reactivo(1,"C".valido_no_aplica, "B".texto))::numeric/(count(*)::numeric - sum(encuestas.get_value_reactivo(3,"C".valido_no_aplica, "B".texto))::numeric)) end');
        $this->db->join('encuestas.sse_respuestas as "B"', 'A.encuesta_cve = "B".encuesta_cve and A.reactivos_cve = "B".reactivos_cve and A.preguntas_cve = "B".preguntas_cve', 'left');
        $this->db->join('encuestas.sse_preguntas as "C"', ' C.encuesta_cve = "B".encuesta_cve and C.preguntas_cve = "B".preguntas_cve', 'inner');
        $this->db->where('"A".course_cve = "AA".course_cve and "A".group_id = "AA".group_id AND "A".evaluador_user_cve = "AA".evaluador_user_cve and "A".evaluador_rol_id = "AA".evaluador_rol_id and "A".evaluado_user_cve = "AA".evaluado_user_cve and "A".evaluado_rol_id = "AA".evaluado_rol_id and "AA".grupos_ids_text = "A".grupos_ids_text');
        $this->db->group_by('"A".course_cve, "A".group_id, "A".evaluador_user_cve, "A".evaluador_rol_id, "A".evaluado_user_cve, "A".evaluado_rol_id, "A".grupos_ids_text');
        $this->db->order_by('"A".course_cve, "A".group_id, "A".evaluador_user_cve, "A".evaluador_rol_id, "A".evaluado_user_cve, "A".evaluado_rol_id, "A".grupos_ids_text');
        $this->db->stop_cache();

        foreach ($indicadores as $indicador) {
            $this->db->where('"C".tipo_indicador_cve', $indicador['indicador_cve']);
            $tmp_q = '(' . $this->db->get_compiled_select('encuestas.sse_evaluacion as "A"') . ') as "indP' . $indicador['indicador_cve'] . '"';
            $select[] = $tmp_q;
            $this->db->reset_query();
        }

        $this->db->flush_cache();

        $this->db->reset_query();

        $this->db->select('array_to_string(array_agg("C".tipo_indicador_cve), \',\')');
        $this->db->join('encuestas.sse_respuestas as "B"', 'A.encuesta_cve = "B".encuesta_cve and A.reactivos_cve = "B".reactivos_cve and A.preguntas_cve = "B".preguntas_cve', 'left');
        $this->db->join('encuestas.sse_preguntas as "C"', ' C.encuesta_cve = "B".encuesta_cve and C.preguntas_cve = "B".preguntas_cve', 'inner');
        $this->db->where('"A".course_cve = "AA".course_cve and "A".group_id = "AA".group_id AND "A".evaluador_user_cve = "AA".evaluador_user_cve and "A".evaluador_rol_id = "AA".evaluador_rol_id and "A".evaluado_user_cve = "AA".evaluado_user_cve and "A".evaluado_rol_id = "AA".evaluado_rol_id and "AA".grupos_ids_text = "A".grupos_ids_text');
        $this->db->group_by('"A".course_cve, "A".group_id, "A".evaluador_user_cve, "A".evaluador_rol_id, "A".evaluado_user_cve, "A".evaluado_rol_id, "A".grupos_ids_text');
        $this->db->order_by('"A".course_cve, "A".group_id, "A".evaluador_user_cve, "A".evaluador_rol_id, "A".evaluado_user_cve, "A".evaluado_rol_id, "A".grupos_ids_text');
        $tmp_q = '(' . $this->db->get_compiled_select('encuestas.sse_evaluacion as "A"') . ') as "indicadores_s"';
        $select[] = $tmp_q;

        $this->db->reset_query();

        $this->db->start_cache();
        $this->db->join("public.mdl_user U1", "AA.evaluador_user_cve = U1.id", 'inner');
        $this->db->join("public.mdl_user U2", "AA.evaluado_user_cve = U2.id", "inner");
        $this->db->join("public.mdl_role UR1", "AA.evaluador_rol_id = UR1.id", "inner");
        $this->db->join("public.mdl_role UR2", "AA.evaluado_rol_id = UR2.id", "inner");
        $this->db->join("encuestas.view_datos_curso as CURSO", "CURSO.idc = AA.course_cve", "inner");
        $this->db->join("public.mdl_groups as GRUPO", "GRUPO.id = AA.group_id and AA.group_id > 0", "left");
        $this->db->join('"tutorias"."mdl_usertutor" "tut_evaluado"', '"tut_evaluado"."nom_usuario" = "U2"."username" and "tut_evaluado"."id_curso" = "AA"."course_cve" and "AA"."evaluado_rol_id" <> 5', "left");
        $this->db->join('"nomina"."ssn_categoria" cat_tut_evaluado', '"cat_tut_evaluado"."cve_categoria" = "tut_evaluado"."cve_categoria"', "left");
        $this->db->join('"departments"."ssv_departamentos" depto_tut_evaluado', '"depto_tut_evaluado"."cve_depto_adscripcion"="tut_evaluado"."cve_departamento"', "left");
        $this->db->join('"gestion"."sgp_tab_preregistro_al" as prereg_evaluador', '"prereg_evaluador"."nom_usuario" = "U1"."username" and "prereg_evaluador"."cve_curso" = "AA"."course_cve" and "AA"."evaluador_rol_id" = 5', "left");
        $this->db->join('"tutorias"."mdl_usertutor" as tut_evaluador', '"tut_evaluador"."nom_usuario"="U1"."username" and "tut_evaluador"."id_curso" = "AA"."course_cve" and "AA"."evaluador_rol_id" <> 5', "left");
        $this->db->join('"nomina"."ssn_categoria" cat_pre_evaluador', '"cat_pre_evaluador"."cve_categoria" = "prereg_evaluador"."cve_cat"', "left");
        $this->db->join('"nomina"."ssn_categoria" cat_tut_evaluador', '"cat_tut_evaluador"."cve_categoria" = "tut_evaluador"."cve_categoria"', "left");
        $this->db->join('"departments"."ssv_departamentos" depto_pre_evaluador', '"depto_pre_evaluador"."cve_depto_adscripcion"="prereg_evaluador"."cve_departamental"', "left");
        $this->db->join('"departments"."ssv_departamentos" depto_tut_evaluador', '"depto_tut_evaluador"."cve_depto_adscripcion"="tut_evaluador"."cve_departamento"  ', "left");
        $this->db->join('"encuestas.sse_curso_bloque_grupo" "BLOQUE"', '(BLOQUE.course_cve = "AA"."course_cve" and "AA"."group_id" = "BLOQUE".mdl_groups_cve) OR (BLOQUE.course_cve = "AA"."course_cve" AND BLOQUE.mdl_groups_cve = ANY (string_to_array("AA".grupos_ids_text, \', \')::int[]))', 'inner');
        ////////////// Se agregan para autoevaluaciones
        $this->db->join('encuestas.sse_designar_autoeveluaciones autoevaluacion', 'autoevaluacion.des_autoevaluacion_cve=AA.des_autoevaluacion_cve', 'left');
        $this->db->join('public.mdl_user usuario_autoevaluacion', 'usuario_autoevaluacion.id=autoevaluacion.evaluador_user_cve', 'left');
        $this->db->join('public.mdl_role rol_autoevaluacion', 'rol_autoevaluacion.id=autoevaluacion.evaluador_rol_id', 'left');
        $this->db->join('tutorias.mdl_usertutor tutor_autoevaluacion', 'tutor_autoevaluacion.nom_usuario=usuario_autoevaluacion.username
                    and tutor_autoevaluacion.id_curso=autoevaluacion.course_cve and autoevaluacion.evaluador_rol_id <> 5', 'left');
        $this->db->join('nomina.ssn_categoria cat_tut_autoevaluacion', 'cat_tut_autoevaluacion.cve_categoria = tutor_autoevaluacion.cve_categoria', 'left');
        $this->db->join('departments.ssv_departamentos depto_tut_autoevaluacion', 'depto_tut_autoevaluacion.cve_depto_adscripcion=tutor_autoevaluacion.cve_departamento', 'left');

        //espacio para filtros
        if (isset($params['grupo']) && !empty($params['grupo'])) {
            $this->db->where('UPPER("GRUPO".name) like UPPER(\'%' . $params['grupo'] . '%\')');
        }

        if (isset($params['tipo_buscar_docente_evaluado']) && $params['tipo_buscar_docente_evaluado'] == 'matriculado' && isset($params['text_buscar_docente_evaluado']) && !empty($params['text_buscar_docente_evaluado'])) {
            $this->db->where('("U1".username=\'' . $params['text_buscar_docente_evaluado'] . '\' OR usuario_autoevaluacion.username=\'' . $params['text_buscar_docente_evaluado'] . '\')');
        } elseif (isset($params['tipo_buscar_docente_evaluado']) && $params['tipo_buscar_docente_evaluado'] == 'namedocentedo' && isset($params['text_buscar_docente_evaluado']) && !empty($params['text_buscar_docente_evaluado'])) {
            $this->db->where('(UPPER("U1".firstname) like UPPER(\'%' . $params['text_buscar_docente_evaluado'] . '%\') OR UPPER("U1".lastname) like UPPER(\'%' . $params['text_buscar_docente_evaluado'] . '%\') OR '
                    . 'UPPER(usuario_autoevaluacion.firstname) like UPPER(\'%' . $params['text_buscar_docente_evaluado'] . '%\') OR UPPER(usuario_autoevaluacion.lastname) like UPPER(\'%' . $params['text_buscar_docente_evaluado'] . '%\'))');
        }

        if (isset($params['tipo_buscar_adscripcion']) && $params['tipo_buscar_adscripcion'] == 'claveadscripcion' && isset($params['text_buscar_adscripcion']) && !empty($params['text_buscar_adscripcion'])) {
            $this->db->where('("depto_pre_evaluador".cve_departamento = \'' . $params['text_buscar_adscripcion'] . '\' OR "depto_tut_evaluador".cve_departamento = \'' . $params['text_buscar_adscripcion'] . '\')');
        }

        if (isset($params['tipo_buscar_categoria']) && $params['tipo_buscar_categoria'] == 'categoria' && isset($params['text_buscar_categoria']) && !empty($params['text_buscar_categoria'])) {
            /* $this->db->where('("cat_pre_evaluador".cve_categoria like \'%' . $params['text_buscar_categoria'] . '%\' OR "cat_tut_evaluador".cve_categoria like \'%' . $params['text_buscar_categoria'].'%\' OR '
              . '"cat_pre_evaluador".nom_nombre like \'%' . $params['text_buscar_categoria'] . '%\' OR "cat_tut_evaluador".nom_nombre like \'%' . $params['text_buscar_categoria'].'%\' OR '
              . '"tutor_autoevaluacion".cve_categoria like \'%'.$params['text_buscar_categoria'].'%\' OR "cat_tut_autoevaluacion".nom_nombre like \'%' . $params['text_buscar_categoria'] . '%\')'); */
            $this->db->where('(UPPER("cat_pre_evaluador".nom_nombre) like UPPER(\'%' . $params['text_buscar_categoria'] . '%\') OR UPPER("cat_tut_evaluador".nom_nombre) like UPPER(\'%' . $params['text_buscar_categoria'] . '%\') OR '
                    . 'UPPER("cat_tut_autoevaluacion".nom_nombre) like UPPER(\'%' . $params['text_buscar_categoria'] . '%\'))');
        }

        if (isset($params['delg_umae']) && !empty($params['delg_umae'])) {
            $this->db->where('(depto_pre_evaluador.cve_delegacion  = \'' . $params['delg_umae'] . '\' OR depto_tut_evaluador.cve_delegacion  = \'' . $params['delg_umae'] . '\')');
        }

        if (isset($params['umae']) && !empty($params['umae'])) { //UMAE, listado de adscripción
            $this->db->where('("depto_pre_evaluador".cve_departamento = \'' . $params['umae'] . '\' OR "depto_tut_evaluador".cve_departamento = \'' . $params['umae'] . '\')');
            //$this->db->where("tut_evaluado.cve_departamento='".$params['umae']."'");
        }

        if (isset($params['bloque']) && !empty($params['bloque'])) {
            $this->db->where('cast("BLOQUE".bloque as text)=\'' . $params['bloque'] . '\'');
        }

        if (isset($params['curso']) && !empty($params['curso'])) {
            $this->db->where('("CURSO".clave ilike \'%' . $params['curso'] . '%\' OR "CURSO".namec ilike \'%' . $params['curso'] . '%\')');
        }

        if (isset($params['tutorizado']) && $params['tutorizado'] != '') {
            $this->db->where('CURSO.tutorizado', $params['tutorizado']);
        }

        $this->db->stop_cache();

        $count = 10;

        $group_by = array('AA.course_cve', 'AA.group_id', 'AA.evaluador_user_cve',
            'AA.evaluador_rol_id', 'AA.evaluado_user_cve', 'AA.evaluado_rol_id',
            'AA.grupos_ids_text');
        $this->db->select($group_by);
        $this->db->group_by($group_by);
        $this->db->from('encuestas.sse_evaluacion AA');
        $count = $this->db->query("select count(*) from (" . $this->db->get_compiled_select() . ") TMP")->result_array()[0]['count'];
        $this->db->reset_query();
        $group_by = array('BLOQUE.bloque', 'AA.course_cve', 'AA.group_id', 'AA.evaluador_user_cve',
            'AA.evaluador_rol_id', 'AA.evaluado_user_cve', 'AA.evaluado_rol_id',
            'AA.grupos_ids_text', 'UN1', '"U1".username', 'URN1', 'UN2', 'URN2', 'CN', 'GN', 'GN1',
            'depto_tut_evaluado.name_region', ' depto_tut_evaluado.nom_delegacion',
            /* 'depto_tut_evaluado.des_unidad_atencion', */ 'depto_tut_evaluado.cve_depto_adscripcion', 'cat_tut_evaluado.nom_nombre',
            'depto_pre_evaluador.name_region', 'depto_pre_evaluador.nom_delegacion',
            /* 'depto_pre_evaluador.des_unidad_atencion', */ 'depto_pre_evaluador.cve_depto_adscripcion', 'cat_pre_evaluador.nom_nombre',
            'depto_tut_evaluador.name_region', 'depto_tut_evaluador.nom_delegacion',
            /* 'depto_tut_evaluador.des_unidad_atencion', */ 'depto_tut_evaluador.cve_depto_adscripcion', 'cat_tut_evaluador.nom_nombre',
            ///Se agrega autoevaluacion
            'autoevaluacion.evaluador_user_cve', 'usuario_autoevaluacion.username', 'usuario_autoevaluacion.firstname', 'usuario_autoevaluacion.lastname',
            'autoevaluacion.evaluador_rol_id', 'rol_autoevaluacion.name', 'tutor_autoevaluacion.cve_departamento', 'depto_tut_autoevaluacion.nom_depto_adscripcion',
            'depto_tut_autoevaluacion.cve_regiones', 'depto_tut_autoevaluacion.name_region', 'depto_tut_autoevaluacion.cve_delegacion',
            'depto_tut_autoevaluacion.nom_delegacion', 'tutor_autoevaluacion.cve_categoria', 'cat_tut_autoevaluacion.nom_nombre');
        $this->db->group_by($group_by);



        if (isset($params['order'])) {
            $type_order = (isset($params['order_type']) && strtolower($params['order_type']) == 'desc') ? 'DESC' : 'ASC';
            switch ($params['order']) {
                case 'emp_matricula':
                    $this->db->order_by('"U1".username', $type_order);
                    break;
                case 'emp_nombre':
                    $this->db->order_by('"UN1"', $type_order);
                    break;
                case 'cur_clave':
                    $this->db->order_by('"AA"."course_cve"', $type_order);
                    break;
                case 'cur_nom_completo':
                    $this->db->order_by('"CN"', $type_order);
                    break;
                case 'rol_nom':
                    $this->db->order_by('"URN2"', $type_order);
                    break;
                case 'rol_nom_edor':
                    $this->db->order_by('"URN1"', $type_order);
                    break;
            }
        }


        $this->db->select($select);

        if (isset($params['per_page']) && !empty($params['per_page']) && isset($params['current_row'])) {
            $this->db->limit($params['per_page'], $params['current_row']);
        }



        $query = $this->db->get_compiled_select('encuestas.sse_evaluacion AA');

        //pr($query);

        $resultado = $this->db->query($query)->result_array();
        //pr($this->db->last_query());
        $this->db->reset_query();
        $this->db->flush_cache();
        $salida['total'] = $count;
        $salida['data'] = $resultado;
        $salida['indicadores'] = $indicadores;

        $indicadores_disponibles = [];
        foreach ($resultado as $r) {
            $arreglo = explode(',', str_replace(' ', '', $r["indicadores_s"])); //lo pongo ya que por alguna extraña razon esta agregando espacios en blanco que solo estorban
            foreach ($arreglo as $val) {
                if (!isset($indicadores_disponibles['ind' . $val])) {
                    $indicadores_disponibles['ind' . $val] = true;
                }
            }
        }
        $salida['indicadores_disponibles'] = $indicadores_disponibles;
        return $salida;
    }

    public function get_indicador_curso($params = null) {
        $resultado = array();

        if (array_key_exists('fields', $params)) {
            if (is_array($params['fields'])) {
                $this->db->select($params['fields'][0], $params['fields'][1]);
            } else {
                $this->db->select($params['fields']);
            }
        }
        if (array_key_exists('conditions', $params)) {
            $this->db->where($params['conditions']);
        }
        if (array_key_exists('order', $params)) {
            $this->db->order_by($params['order']);
        }
        $this->db->join('encuestas.sse_preguntas pre', 'pre.tipo_indicador_cve=ind.indicador_cve');
        $this->db->join('encuestas.sse_evaluacion eva', 'eva.encuesta_cve=pre.encuesta_cve');

        $query = $this->db->get('encuestas.sse_indicador ind'); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $resultado = $query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    private function getReglaCursoPrioridad($parametros) {
        if (is_null($parametros)) {
            return array();
        }
        $select = array("reg.reglas_evaluacion_cve", "reg.rol_evaluado_cve", "reg.rol_evaluador_cve",
            "reg.is_excepcion", "reg.tutorizado", "enc.is_bono", "reg.ord_prioridad",
            "enc.encuesta_cve", "enc.eva_tipo", "reg.eval_is_satisfaccion", "enc.tipo_encuesta",
            '0 as "rol_evaluador_real"'
        );
        $this->db->select($select);
        $this->db->where('reg.rol_evaluador_cve', $parametros['role_evaluador']);
        $this->db->where('reg.tutorizado', $parametros['tutorizado']);
        $this->db->where('encc.course_cve', $parametros['cur_id']);
        $this->db->order_by('reg.ord_prioridad', 'asc'); //Importante obtrener el de mayor presedencia
//        $this->db->limit(1); //Importante obtrener el de mayor presedencia

        $this->db->join('encuestas.sse_encuestas enc', 'enc.reglas_evaluacion_cve=reg.reglas_evaluacion_cve');
        $this->db->join('encuestas.sse_encuesta_curso encc', 'encc.encuesta_cve=enc.encuesta_cve');
        $query = $this->db->get('encuestas.sse_reglas_evaluacion reg');


        $resultado = $query->result_array();
        $this->db->flush_cache();
        $query->free_result(); //Libera la memoria
//        pr($this->db->last_query());
//        if (!empty($resultado)) {
//            $resultado = $resultado[0];
//        }

        return $resultado;
    }

    /**
     * @Autor LEAS
     * @fecha 1/12/2016
     * @param type $parametros
     * @return type
     * $parametros = array de 'role_evaluador', int 'tutorizado', int 'cur_id'
     */
    public function getReglasEvaluacionCurso($param = null) {
        $reglas_aplica = array();
        foreach ($param['role_evaluador'] as $rol) {//Recorre roles
            $parametros = array('role_evaluador' => $rol, 'tutorizado' => $param['tutorizado'], 'cur_id' => $param['cur_id']);
//            $result_prioridad = $this->getReglasRolEvaluador($parametros); //Obtiene reglas
            $result_prioridad = $this->getReglaCursoPrioridad($parametros); //Obtiene reglas
//            pr($result_prioridad);
            if (!empty($result_prioridad)) {
//                pr($result_prioridad);
                $tmp_reg = array();
                foreach ($result_prioridad as $reglas) {
                    if ($reglas['is_excepcion'] == 0) {
                        $tmp_reg[$reglas['rol_evaluador_cve']][$reglas['encuesta_cve']][$reglas['reglas_evaluacion_cve']] = $reglas;
                    } else {
//                        pr('<>---------------<>');
//                        pr($reglas);
                        $where = " WHERE reg.reglas_evaluacion_cve = " . $reglas['reglas_evaluacion_cve'];
                        $query_recursive = "WITH RECURSIVE busca_excepcion AS (
                    SELECT reg.reglas_evaluacion_cve, reg.rol_evaluado_cve, reg.rol_evaluador_cve,
                    reg.is_excepcion, reg.tutorizado, reg.is_bono, reg.ord_prioridad, reg.eval_is_satisfaccion
                    FROM encuestas.sse_reglas_evaluacion reg "
                                . $where .
                                " UNION all
                    select bex.is_excepcion, rer.rol_evaluado_cve, rer.rol_evaluador_cve,
                    rer.is_excepcion, rer.tutorizado, rer.is_bono, rer.ord_prioridad, rer.eval_is_satisfaccion
                    from busca_excepcion bex
                    join encuestas.sse_reglas_evaluacion rer on rer.reglas_evaluacion_cve = bex.is_excepcion
                    )
                    select * FROM busca_excepcion order by ord_prioridad asc
                    "
                        ;

                        $query = $this->db->query($query_recursive);
//                        pr($this->db->last_query());
                        $result = $query->result_array();
                        foreach ($result as $val_r) {
                            if (!isset($tmp_reg[$val_r['rol_evaluador_cve']][$reglas['encuesta_cve']][$val_r['reglas_evaluacion_cve']])) {
//                                pr($val_r);
                                $aux_parm = $val_r;
                                $aux_parm['encuesta_cve'] = $reglas['encuesta_cve'];
                                $aux_parm['eva_tipo'] = $reglas['eva_tipo'];
                                $aux_parm['tipo_encuesta'] = $reglas['tipo_encuesta'];
                                $aux_parm['rol_evaluador_real'] = $reglas['rol_evaluador_cve'];
//                                $tmp_reg[$val_r['rol_evaluador_cve']][$reglas['encuesta_cve']][$val_r['reglas_evaluacion_cve']] = $aux_parm;
                                $tmp_reg[$reglas['rol_evaluador_cve']][$reglas['encuesta_cve']][$val_r['reglas_evaluacion_cve']] = $aux_parm;
                            }
                        }
//
                    }
                }
                $reglas_aplica += $tmp_reg;
            }
        }
        return $reglas_aplica;
    }

    public function get_datos_usuarios_bloque($params = null) {
        $resultado = array();
        $arrol = array();
        /* SELECT public.mdl_course.id as cve_curso, public.mdl_user.firstname as nombres, public.mdl_user.lastname as apellidos,
          cbg.bloque,
          public.mdl_role.id AS cve_rol, public.mdl_role.name AS rol_nombre
          FROM tutorias.mdl_userexp
          JOIN public.mdl_user ON public.mdl_user.id= tutorias.mdl_userexp.userid
          JOIN public.mdl_role ON public.mdl_role.id= tutorias.mdl_userexp.role
          JOIN public.mdl_groups ON public.mdl_groups.id=tutorias.mdl_userexp.grupoid
          JOIN public.mdl_course ON public.mdl_course.id=tutorias.mdl_userexp.cursoid
          JOIN encuestas.sse_curso_bloque_grupo cbg on cbg.mdl_groups_cve = public.mdl_groups.id
          WHERE
          public.mdl_role.id NOT IN(32)
          AND public.mdl_user.id = '2272'
          AND tutorias.mdl_userexp.cursoid = '838'
          group by public.mdl_course.id, cbg.bloque, public.mdl_role.id, public.mdl_role.name, public.mdl_user.firstname, public.mdl_user.lastname
          order by cbg.bloque */


        //Buscar en sied
        /* select public.mdl_user.firstname,public.mdl_user.lastname,public.mdl_role.name,
          public.mdl_groups.name, public.mdl_course.id ,*
          from tutorias.mdl_userexp
          inner join public.mdl_user on public.mdl_user.id= tutorias.mdl_userexp.userid
          inner join public.mdl_role on public.mdl_role.id= tutorias.mdl_userexp.role
          inner join public.mdl_groups on public.mdl_groups.id=tutorias.mdl_userexp.grupoid
          inner join public.mdl_course on public.mdl_course.id=tutorias.mdl_userexp.cursoid
          where cursoid=761 and mdl_user.id=7848 */
        if (isset($params['rol_evaluado_cve']) && !empty($params['rol_evaluado_cve'])) {
            $this->db->where_not_in('public.mdl_role.id', $params['rol_evaluado_cve']);
        }
        if (isset($params['rol_evaluador_cve']) && !empty($params['rol_evaluador_cve'])) {
            $this->db->where('public.mdl_role.id', $params['rol_evaluador_cve']);
        }

        if (isset($params['user_id']) && !empty($params['user_id'])) {
            $this->db->where('public.mdl_user.id', $params['user_id']);
        }
        if (isset($params['cur_id']) && !empty($params['cur_id'])) {
            $this->db->where('tutorias.mdl_userexp.cursoid', $params['cur_id']);
        }

        $this->db->join('public.mdl_user', 'public.mdl_user.id= tutorias.mdl_userexp.userid');
        $this->db->join('public.mdl_role', 'public.mdl_role.id= tutorias.mdl_userexp.role');
        $this->db->join('public.mdl_groups', 'public.mdl_groups.id=tutorias.mdl_userexp.grupoid');
        $this->db->join('public.mdl_course', 'public.mdl_course.id=tutorias.mdl_userexp.cursoid');
        $this->db->join('encuestas.sse_curso_bloque_grupo cbg', 'cbg.mdl_groups_cve = public.mdl_groups.id');

        $busqueda = array(
            'public.mdl_course.id as cve_curso',
            'public.mdl_user.firstname as nombres',
            'public.mdl_user.lastname as apellidos',
            'cbg.bloque',
            'public.mdl_groups.id AS cve_grupo',
            'public.mdl_role.id AS cve_rol',
            'public.mdl_role.name AS rol_nombre');
        $this->db->select($busqueda);

        $this->db->group_by('public.mdl_course.id, cbg.bloque, public.mdl_role.id, public.mdl_role.name, public.mdl_user.firstname, public.mdl_user.lastname,public.mdl_groups.id');
        $this->db->order_by('cbg.bloque');
        $query = $this->db->get('tutorias.mdl_userexp'); //Obtener conjunto de encuestas


        $resultado = $query->result_array();
        //pr($this->db->last_query());

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function get_datos_usuarios_gral($params = null) {
        $resultado = array();
        $arrol = array();


        if (isset($params['user_id']) && !empty($params['user_id'])) {
            $this->db->where('public.mdl_user.id', $params['user_id']);
        }


        //$this->db->join('public.mdl_user', 'public.mdl_user.id= tutorias.mdl_userexp.userid');

        $busqueda = array(
            'public.mdl_user.firstname as nombres',
            'public.mdl_user.lastname as apellidos');
        $this->db->select($busqueda);
        $query = $this->db->get('public.mdl_user'); //Obtener conjunto de encuestas


        $resultado = $query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function exportar_xls_datos($id_instrumento) {
        $resultado = array(); //role_evaluado.id \"ROL_A_EVALUAR_ID\", role_evaluador.id \"ROL_EVALUADOR_ID\", sec.seccion_cve, ind.indicador_cve, tip_pre.descripcion,
        $this->db->select("enc.descripcion_encuestas \"NOMBRE_INSTRUMENTO\", enc.cve_corta_encuesta \"FOLIO_INSTRUMENTO\", role_evaluado.\"name\" \"ROL_A_EVALUAR\",
            role_evaluador.\"name\" \"ROL_EVALUADOR\", case when reg_eva.tutorizado = 1 then 'SI' else 'NO' end as \"TUTORIZADO\",
            sec.descripcion as \"NOMBRE_SECCION\", ind.descripcion as \"NOMBRE_INDICADOR\", pre.orden as \"NO_PREGUNTA\",
            case when pre.is_bono = 1 then 'SI' else 'NO' end as \"PREGUNTA_BONO\", case when pre.obligada = 1 then 'SI' else 'NO' end as \"OBLIGADA\", pre.pregunta as \"PREGUNTA\",
            case when tip_pre.descripcion SIMILAR TO '%(NULO)%' then 'SI' else '' end as \"NO_APLICA\",
            case when pre.valido_no_aplica = 1 then 'SI' else 'NO' end as \"VALIDO_NO_APLICA\",
            case when tip_pre.descripcion SIMILAR TO '%(NOENVIOMENSAJE)%' then 'SI' else '' end as \"NO_ENVIO_MENSAJE\",
            case when tip_pre.descripcion SIMILAR TO '%(SI_NO)%' then 'SI' else '' end as \"SI\",
            case when tip_pre.descripcion SIMILAR TO '%(SI_NO)%' then 'SI' else '' end as \"NO\",
            case when tip_pre.descripcion SIMILAR TO '%(SIEMPRE_NUNCA)%' then 'SI' else '' end as \"SIEMPRE\",
            case when tip_pre.descripcion SIMILAR TO '%(SIEMPRE_NUNCA)%' then 'SI' else '' end as \"CASI_SIEMPRE\",
            case when tip_pre.descripcion SIMILAR TO '%(SIEMPRE_NUNCA)%' then 'SI' else '' end as \"ALGUNAS_VECES\",
            case when tip_pre.descripcion SIMILAR TO '%(SIEMPRE_NUNCA)%' then 'SI' else '' end as \"CASI_NUNCA\",
            case when tip_pre.descripcion SIMILAR TO '%(SIEMPRE_NUNCA)%' then 'SI' else '' end as \"NUNCA\",
            case when tip_pre.descripcion SIMILAR TO '%(RESPUESTA_ABIERTA)%' then 'SI' else '' end as \"RESPUESTA_ABIERTA\",
            case when reg_eva.eval_is_satisfaccion = 1 then 'SATISFACCION' else 'DESEMPENIO' end as \"TIPO_INSTRUMENTO\",
            case when enc.eva_tipo = 1 then 'POR_GRUPO' when enc.eva_tipo = 2 then 'POR_BLOQUE' when enc.eva_tipo = 3 then 'POR_USUARIO' end as \"EVA_TIPO\",
            enc.guia_descripcion_encuesta AS \"INSTRUCCIONES\"");

        $this->db->where("enc.encuesta_cve", $id_instrumento);

        $this->db->join('encuestas.sse_reglas_evaluacion reg_eva', 'reg_eva.reglas_evaluacion_cve=enc.reglas_evaluacion_cve');
        $this->db->join('public.mdl_role role_evaluado', 'role_evaluado.id=reg_eva.rol_evaluado_cve', 'left');
        $this->db->join('public.mdl_role role_evaluador', 'role_evaluador.id=reg_eva.rol_evaluador_cve', 'left');
        $this->db->join('encuestas.sse_preguntas pre', 'pre.encuesta_cve=enc.encuesta_cve');
        $this->db->join('encuestas.sse_seccion sec', 'sec.seccion_cve=pre.seccion_cve', 'left');
        $this->db->join('encuestas.sse_indicador ind', 'ind.indicador_cve=pre.tipo_indicador_cve', 'left');
        $this->db->join('encuestas.sse_tipo_pregunta tip_pre', 'tip_pre.tipo_pregunta_cve=pre.tipo_pregunta_cve', 'left');

        $this->db->order_by('NO_PREGUNTA', 'ASC');

        $query = $this->db->get('encuestas.sse_encuestas enc'); //Obtener conjunto de registros
        //pr($this->db->last_query());
        $this->db->flush_cache();

        $resultado['data'] = $query->result_array();
        $resultado['head'] = $query->list_fields();
        //pr($resultado); exit();
        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function listado_autoeval($params = null) {
        $resultado = array();

        $this->db->where('tutorias.mdl_userexp.cursoid', $params['cur_id']);
        $this->db->where('tutorias.mdl_userexp.ind_status', '1');


        $this->db->where_in('tutorias.mdl_userexp.userid', $params['evaluador_user_cve']);

        if (isset($params['gpo_evaluador']) && !empty($params['gpo_evaluador'])) {//El evaluador es parte de un grupo
            //$this->db->where('tutorias.mdl_userexp.cursoid', $params['cur_id']);
            //$this->db->where('tutorias.mdl_userexp.role',$params['role_evaluado']);
            $this->db->where('tutorias.mdl_userexp.grupoid', $params['gpo_evaluador']);

            $this->db->where('tutorias.mdl_userexp.role', $params['role_evaluado']);

            $condicionae = "(SELECT des_autoevaluacion_cve from encuestas.sse_designar_autoeveluaciones
                where sse_designar_autoeveluaciones.course_cve=" . $params['cur_id'] . "
                and sse_designar_autoeveluaciones.encuesta_cve=" . $params['encuesta_cve'] . "
                and sse_designar_autoeveluaciones.evaluado_user_cve=tutorias.mdl_userexp.userid
                and grupos_ids_text='" . $params['gpo_evaluador'] . "') as t";

            $this->db->select('public.mdl_user.firstname,public.mdl_user.lastname,public.mdl_role.name as role, public.mdl_role.id as rol_id, public.mdl_groups.name as ngpo, \'\' AS grupos_ids_text,
                (select public.mdl_role.name from public.mdl_role where id=' . $params['role_evaluador'] . ') as evaluador,' .
                    $params['encuesta_cve'] . ' as regla, public.mdl_groups.id as gpoid, tutorias.mdl_userexp.cursoid as cursoid, public.mdl_user.id as userid,
                (select evaluacion_resul_cve from encuestas.sse_result_evaluacion_encuesta_curso
                where encuesta_cve=' . $params['encuesta_cve'] . ' and course_cve=' . $params['cur_id'] . ' and group_id=' . $params['gpo_evaluador'] . '
                    and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=' . $params['evaluador_user_cve'] . ')  as realizado,
             (select public.mdl_user.firstname || \' \' || public.mdl_user.lastname from public.mdl_user where id=' . $params['evaluador_user_cve'] . ') as nomevaluador,' .
                    $condicionae);


            $this->db->join('public.mdl_user', 'public.mdl_user.id= tutorias.mdl_userexp.userid');
            $this->db->join('public.mdl_role', 'public.mdl_role.id= tutorias.mdl_userexp.role');
            $this->db->join('public.mdl_groups', 'public.mdl_groups.id=tutorias.mdl_userexp.grupoid');
        } elseif (isset($params['bloque_evaluador']) && !empty($params['bloque_evaluador'])) {//El evaluador se encuentra en varios bloques
            /* SELECT "public"."mdl_user"."firstname", "public"."mdl_user"."lastname", "public"."mdl_role"."name" as "role", "public"."mdl_groups"."name" as "ngpo",
              (select public.mdl_role.name from public.mdl_role where id=32) as evaluador, 535 as "regla",
              "public"."mdl_groups"."id" as "gpoid", "tutorias"."mdl_userexp"."cursoid" as "cursoid",
              "public"."mdl_user"."id" as "userid",
              (select evaluacion_resul_cve from encuestas.sse_result_evaluacion_encuesta_curso where encuesta_cve=535 and course_cve=838 and group_id=11856 and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=1738)  as realizado
              FROM "tutorias"."mdl_userexp"
              JOIN "public"."mdl_user" ON "public"."mdl_user"."id"= "tutorias"."mdl_userexp"."userid"
              JOIN "public"."mdl_role" ON "public"."mdl_role"."id"= "tutorias"."mdl_userexp"."role"
              JOIN "public"."mdl_groups" ON "public"."mdl_groups"."id"="tutorias"."mdl_userexp"."grupoid"
              JOIN encuestas.sse_curso_bloque_grupo on encuestas.sse_curso_bloque_grupo.mdl_groups_cve = public.mdl_groups.id
              WHERE "tutorias"."mdl_userexp"."cursoid" = '838'
              AND "tutorias"."mdl_userexp"."role" = 18
              and encuestas.sse_curso_bloque_grupo.bloque=2 */

            //$this->db->where('tutorias.mdl_userexp.cursoid', $params['cur_id']);


            $this->db->where('tutorias.mdl_userexp.role', $params['role_evaluado']);
            $this->db->where('encuestas.sse_curso_bloque_grupo.bloque', $params['bloque_evaluador']);

            if (isset($params['grupos']) && !empty($params['grupos'])) {
                $grupo_condition = "(SELECT array_agg(g.name)::varchar FROM public.mdl_groups g WHERE g.id IN (" . $params['grupos'] . ")) AS ngpo, '" . $params['grupos'] . "' as grupos_ids_text";
            } else {
                $grupo_condition = "public.mdl_groups.name as ngpo, \'\' AS grupos_ids_text";
            }


            $condicionae = " (SELECT des_autoevaluacion_cve from encuestas.sse_designar_autoeveluaciones
                where sse_designar_autoeveluaciones.course_cve=" . $params['cur_id'] . "
                and sse_designar_autoeveluaciones.encuesta_cve=" . $params['encuesta_cve'] . "
                and sse_designar_autoeveluaciones.evaluado_user_cve=tutorias.mdl_userexp.userid
                and grupos_ids_text='" . $params['grupos'] . "') as t";

            $consulta = 'public.mdl_user.firstname,public.mdl_user.lastname,public.mdl_role.name as role, public.mdl_role.id as rol_id, ' . $grupo_condition . ',
                encuestas.sse_curso_bloque_grupo.bloque,
                (select public.mdl_role.name from public.mdl_role where id=' . $params['role_evaluador'] . ') as evaluador,' .
                    $params['encuesta_cve'] . ' as regla,  tutorias.mdl_userexp.cursoid as cursoid, public.mdl_user.id as userid,
                (select max(evaluacion_resul_cve) from encuestas.sse_result_evaluacion_encuesta_curso reec
                join encuestas.sse_curso_bloque_grupo cbgp on cbgp.course_cve = reec.course_cve and cbgp.bloque = encuestas.sse_curso_bloque_grupo.bloque
                and cbgp.mdl_groups_cve IN (' . $params['grupos'] . ')
                and cbgp.mdl_groups_cve = ANY (string_to_array(reec.grupos_ids_text, \',\')::int[])
                where encuesta_cve=' . $params['encuesta_cve'] . ' and reec.course_cve=' . $params['cur_id'] . '
                    and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=' . $params['evaluador_user_cve'] . ')  as realizado,
                (select public.mdl_user.firstname || \' \' || public.mdl_user.lastname from public.mdl_user where id=' . $params['evaluador_user_cve'] . ') as nomevaluador, '
                    . $condicionae;

            $this->db->distinct($consulta);
            $this->db->select($consulta);
            /* $this->db->select('public.mdl_user.firstname,public.mdl_user.lastname,public.mdl_role.name as role, public.mdl_role.id as rol_id, ' . $grupo_condition . ',
              (select public.mdl_role.name from public.mdl_role where id=' . $params['role_evaluador'] . ') as evaluador,' .
              $params['encuesta_cve'] . ' as regla, public.mdl_groups.id as gpoid, tutorias.mdl_userexp.cursoid as cursoid, public.mdl_user.id as userid,
              (select evaluacion_resul_cve from encuestas.sse_result_evaluacion_encuesta_curso where encuesta_cve=' . $params['encuesta_cve'] . ' and course_cve=' . $params['cur_id'] . '
              and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=' . $params['evaluador_user_cve'] . ')  as realizado');
             */

            $this->db->join('public.mdl_user', 'public.mdl_user.id= tutorias.mdl_userexp.userid');
            $this->db->join('public.mdl_role', 'public.mdl_role.id= tutorias.mdl_userexp.role');
            $this->db->join('public.mdl_groups', 'public.mdl_groups.id=tutorias.mdl_userexp.grupoid');
            $this->db->join('encuestas.sse_curso_bloque_grupo', 'encuestas.sse_curso_bloque_grupo.mdl_groups_cve = public.mdl_groups.id');
        } else {
            $params['gpo_evaluador'] = 0;

            $condicionae = "(SELECT des_autoevaluacion_cve from encuestas.sse_designar_autoeveluaciones
                where sse_designar_autoeveluaciones.course_cve=" . $params['cur_id'] . "
                and sse_designar_autoeveluaciones.encuesta_cve=" . $params['encuesta_cve'] . "
                and sse_designar_autoeveluaciones.evaluado_user_cve=tutorias.mdl_userexp.userid
                and grupos_ids_text='" . $params['gpo_evaluador'] . "') as t";


            $consulta = 'public.mdl_user.firstname,public.mdl_user.lastname,public.mdl_role.name as role, public.mdl_role.id as rol_id, ' . $params['gpo_evaluador'] . ' as ngpo, \'\' AS grupos_ids_text,
              (select public.mdl_role.name from public.mdl_role where id=' . $params['role_evaluador'] . ') as evaluador,' .
                    $params['encuesta_cve'] . ' as regla, tutorias.mdl_userexp.cursoid as cursoid, public.mdl_user.id as userid,
                    (select evaluacion_resul_cve from encuestas.sse_result_evaluacion_encuesta_curso where encuesta_cve=' . $params['encuesta_cve'] . ' and course_cve=' . $params['cur_id'] . '
                        and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=' . $params['evaluador_user_cve'] . ')  as realizado,
(select public.mdl_user.firstname || \' \' || public.mdl_user.lastname from public.mdl_user where id=' . $params['evaluador_user_cve'] . ') as nomevaluador,
' . $condicionae;




            $this->db->distinct($consulta);
            $this->db->select($consulta);

            $this->db->where('tutorias.mdl_userexp.role', $params['role_evaluado']);


            $this->db->join('public.mdl_user', 'public.mdl_user.id= tutorias.mdl_userexp.userid');
            $this->db->join('public.mdl_role', 'public.mdl_role.id= tutorias.mdl_userexp.role');
        }



        /* $this->db->join('encuestas.sse_designar_autoeveluaciones','sse_designar_autoeveluaciones.course_cve='. $params['cur_id'].'
          and sse_designar_autoeveluaciones.encuesta_cve='.$params['encuesta_cve'].' and
          sse_designar_autoeveluaciones.evaluado_user_cve=public.mdl_user.id and
          sse_designar_autoeveluaciones.grupos_ids_text = grupos_ids_text','left'); */

        $query = $this->db->get('tutorias.mdl_userexp');

        /* if ($query->num_rows() > 0){
          //$resultado['result'] = true;
          //$resultado['data'] = $query->result_array();
          $resultado = $query->result_array();

          } */
        $resultado['datosdesig'] = 0;
        //pr($this->db->last_query());
        if (!empty($query->result_array())) {
            $res = $query->result_array();
            //pr($res[0]['t']);
            $resultado['datosdesig'] = $this->get_designa_autoeva($res[0]['t']);
        }

        //$re['id'] = $query->result_array()[0];
        //pr($res);
        //$resultado['datosdesig']=$this->get_designa_autoeva($datosres);

        $resultado['evagral'] = $this->listado_evagral(array('role_evaluado' => $params['role_evaluado'],
            'cur_id' => $params['cur_id'], 'role_evaluador' => $params['role_evaluador']));

        /* $resultado['userevaluador']=$this->user_evaluador_autoevaluacion(array('role_evaluado' => $params['role_evaluado'],
          'cur_id' => $params['cur_id'],'role_evaluador' => $params['role_evaluador'])); */
        $resultado['data'] = $query->result_array();




        //pr($resultado['data']);
        //$this->db->flush_cache();
        //$query->free_result(); //Libera la memoria



        return $resultado;
    }


    public function get_designa_autoeva($idauto = null)
    {

        $resultado = array('result' => false, 'data' => null);

        $this->db->where('des_autoevaluacion_cve',$idauto);
        $query = $this->db->get('encuestas.sse_designar_autoeveluaciones'); //Obtener conjunto de encuestas
        if ($query->num_rows() > 0) {
            $resultado['result'] = true;
            $resultado['data'] = $query->result_array();
        }

        $query->free_result(); //Libera la memoria

        return $resultado;

    }

    public function listado_evagral($params = null) {
        $resultado = array();
        /* SELECT c.id AS cve_curso,  u.id AS cve_usuario, u.username AS username, u.firstname AS nom, u.lastname AS pat,
          u.cve_departamental
          FROM mdl_user u
          JOIN mdl_role_assignments ra ON ra.userid = u.id
          JOIN mdl_context ct ON ct.id = ra.contextid
          JOIN mdl_course c ON c.id = ct.instanceid
          JOIN mdl_role r ON r.id = ra.roleid
          JOIN mdl_enrol en ON en.courseid = c.id
          JOIN mdl_user_enrolments ue ON ue.enrolid = en.id AND ue.userid = u.id
          where c.id=761 and r.id not in(11,29,19,34) */

        $this->db->where('c.id', $params['cur_id']);


        $this->db->where_not_in('r.id', 11);
        $this->db->where_not_in('r.id', 19);
        $this->db->where_not_in('r.id', 29);
        $this->db->where_not_in('r.id', 34);
        $this->db->where_not_in('r.id', 5);
        $this->db->where_not_in('r.id', 33);

        $this->db->where_not_in('r.id', $params['role_evaluado']);

        if ($params['role_evaluador'] == 32 || $params['role_evaluador'] == 33) {
            $this->db->where('r.id in(14,18,30)');
        }
        if ($params['role_evaluador'] == 18) {
            $this->db->where('r.id in(14,30)');
        }
        if ($params['role_evaluador'] == 14) {
            $this->db->where('r.id in(30)');
        }



        $this->db->join('public.mdl_role_assignments ra', 'ra.userid = u.id');
        $this->db->join('public.mdl_context ct', 'ct.id = ra.contextid');
        $this->db->join('public.mdl_course c', 'c.id = ct.instanceid');
        $this->db->join('public.mdl_role r', 'r.id = ra.roleid');
        $this->db->join('public.mdl_enrol en', 'en.courseid = c.id');
        $this->db->join('public.mdl_user_enrolments ue', 'ue.enrolid = en.id AND ue.userid = u.id');

        $busqueda = array(
            'u.id AS cve_usuario',
            'u.username AS username',
            'u.firstname AS nombres',
            'u.lastname AS apellidos',
            'ra.roleid as rol',
            'r.name as rolen');

        $this->db->select($busqueda);


        $query = $this->db->get('public.mdl_user u');
        $resultado = $query->result_array();

        $query->free_result(); //Libera la memoria

        foreach ($resultado as $index => $value) {

            $arrol[$value['cve_usuario'] . '/' . $value['rol']] = $value['nombres'] . ' ' . $value['apellidos'] . '(' . $value['rolen'] . ')';
        }
        //pr($this->db->last_query());
        return $arrol;
    }

    public function guardaract_autoevaluacion($autoevaluacion = array()) {

        $data = array();
        //$data['course_cve'] = $autoevaluacion['idcurso'];
        //$data['tutorizado'] = $autoevaluacion['tutorizado'];
        //$data['rol_evaluado_cve'] = $autoevaluacion['rolevaluado'];

        $evaluador = explode("/", $autoevaluacion['evaluador']);
        //$data['rol_evaluador_cve']=$evaluador[1];
        //si existen reglas extras-- ya no se utilizó por el análisis sugerido
        /* $regla=$this->get_regla(
          array('tutorizado' => $autoevaluacion['tutorizado'],
          'rol_evaluador_cve' => $evaluador[1],
          'rol_evaluado_cve' => $autoevaluacion['rolevaluado']));



          $data['reglas_evaluacion_cve'] = $regla['id']; */




        if (isset($autoevaluacion['grupos_ids_text'])) {
            $autoeva = $autoevaluacion['grupos_ids_text'];
        } else {
            $autoeva = $autoevaluacion['idgrupo'];
        }

        $insert_autoevaluacion = array();
        $insert_autoevaluacion['course_cve'] = $autoevaluacion['cur_id'];
        $insert_autoevaluacion['encuesta_cve'] = $autoevaluacion['idencuesta'];
        $insert_autoevaluacion['evaluado_user_cve'] = $autoevaluacion['iduevaluado'];
        $insert_autoevaluacion['evaluador_user_cve'] = $evaluador[0];
        $insert_autoevaluacion['evaluador_rol_id'] = $evaluador[1];
        $insert_autoevaluacion['grupos_ids_text'] = $autoeva;
        if (isset($autoevaluacion['idencuesta']) && ($autoevaluacion['idencuesta'] == TRUE)) {
            $existe_autoevaluacion = $this->get_autoevaluacion(
                    array('course_cve' => $autoevaluacion['cur_id'],
                        'encuesta_cve' => $autoevaluacion['idencuesta'],
                        'evaluado_user_cve' => $autoevaluacion['iduevaluado'],
                        'evaluador_user_cve' => $evaluador[0],
                        'evaluador_rol_id' => $evaluador[1],
                        'grupos_ids_text' => $autoeva));

            //pr($existe_autoevaluacion['data']);
            //pr($autoevaluacion);
            //pr($evaluador);
            if ($existe_autoevaluacion['result'] == false) {
                //inserta
                //pr($existe_autoevaluacion['id']);
                $this->db->insert('encuestas.sse_designar_autoeveluaciones', $insert_autoevaluacion);
                $insert_id = $this->db->insert_id();
            } else {
                //actualiza
                //verificar que no este evaluado por el mismo evaluador
                $autoevaluacionset = array();
                $autoevaluacionset['evaluador_user_cve'] = $evaluador[0];
                $autoevaluacionset['evaluador_rol_id'] = $evaluador[1];

                if ($existe_autoevaluacion['data']['evaluador_user_cve'] != $evaluador[0]) {
                    //pr($existe_autoevaluacion);
                    $this->db->where('des_autoevaluacion_cve', $existe_autoevaluacion['data']['des_autoevaluacion_cve']);
                    $this->db->set('evaluador_user_cve', $evaluador[0]);
                    $this->db->set('evaluador_rol_id',$evaluador[1]);
                    $this->db->update('encuestas.sse_designar_autoeveluaciones');
                    //pr($this->db->last_query());
                    $update_id = $existe_autoevaluacion['data']['des_autoevaluacion_cve'];
                    echo 'Asignado con éxito';
                }else{
                    echo 'No se realizaron cambios';
                }
            }
        } else {
            echo "No se encuetra regla de evaluación asociada a esta combinación";
        }
    }

    public function get_regla($params = array()) {
        $resultado = array('result' => false, 'id' => 0);


        $this->db->where('tutorizado', $params['tutorizado']);
        $this->db->where('rol_evaluador_cve', $params['rol_evaluador_cve']);
        $this->db->where('rol_evaluado_cve', $params['rol_evaluado_cve']);


        $query = $this->db->get('encuestas.sse_reglas_evaluacion'); //Obtener conjunto de registros
        //pr($query);
        if ($query->num_rows() > 0) {
            $resultado['result'] = true;
            $resultado['id'] = $query->result_array()[0]['reglas_evaluacion_cve'];
        }

        //pr($this->db->last_query());
        //pr($query->result_array()[0]['reglas_evaluacion_cve']);
        return $resultado;
    }

    public function get_autoevaluacion($params = array()) {
        $resultado = array('result' => false, 'id' => 0);


        $this->db->where('encuesta_cve', $params['encuesta_cve']);
        //$this->db->where('evaluador_user_cve',$params['evaluador_user_cve']);
        $this->db->where('evaluado_user_cve', $params['evaluado_user_cve']);
        $this->db->where('course_cve', $params['course_cve']);
        $this->db->where('grupos_ids_text', $params['grupos_ids_text']);


        $query = $this->db->get('encuestas.sse_designar_autoeveluaciones'); //Obtener conjunto de registros
        //pr($query);
        if ($query->num_rows() > 0) {
            $resultado['result'] = true;
            $resultado['data'] = $query->result_array()[0];
        }

        //pr($this->db->last_query());
        return $resultado;
    }

    /* public function user_evaluador_autoevaluacion($params = array()) {
      $resultado = array('result' => false, 'id' => 0);


      $this->db->where('reglas_evaluacion_cve',$params['reglas_evaluacion_cve']);
      //$this->db->where('evaluador_user_cve',$params['evaluador_user_cve']);
      $this->db->where('evaluado_user_cve',$params['evaluado_user_cve']);
      $this->db->where('course_cve',$params['cur_id']);
      $this->db->where('grupos_ids_text',$params['grupos_ids_text']);


      $query = $this->db->get('encuestas.sse_designar_autoeveluaciones'); //Obtener conjunto de registros
      //pr($query);
      if ($query->num_rows() > 0) {
      $resultado['result'] = true;
      $resultado['data'] = $query->result_array()[0];
      }

      //pr($this->db->last_query());
      return $resultado;
      } */

    public function get_usuariosasig_aevaluar($params = array()) {

        /*
          SELECT encuestas.sse_reglas_evaluacion.rol_evaluado_cve as roleevaluado,(select name from public.mdl_role where id=rol_evaluado_cve ) as roleevaluadon, grupos_ids_text,
          public.mdl_role.name as evaluadorn,sse_encuestas.encuesta_cve as regla,sse_designar_autoeveluaciones.course_cve,sse_designar_autoeveluaciones.evaluado_user_cve as user_id_evaluado,
          (select evaluacion_resul_cve from encuestas.sse_result_evaluacion_encuesta_curso where encuesta_cve=sse_encuestas.encuesta_cve and course_cve=sse_designar_autoeveluaciones.course_cve
          and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=sse_designar_autoeveluaciones.evaluador_user_cve)  as realizado,
          (select firstname || ' ' || lastname from mdl_user where id=sse_designar_autoeveluaciones.evaluado_user_cve) as nombreevaluado, sse_reglas_evaluacion.rol_evaluador_cve
          FROM "encuestas"."sse_reglas_evaluacion"
          JOIN "encuestas"."sse_encuestas" ON "sse_encuestas"."reglas_evaluacion_cve"="sse_reglas_evaluacion"."reglas_evaluacion_cve"
          JOIN "encuestas"."sse_encuesta_curso" ON "sse_encuesta_curso"."encuesta_cve"="sse_encuestas"."encuesta_cve"
          JOIN "encuestas"."sse_designar_autoeveluaciones" on sse_designar_autoeveluaciones.reglas_evaluacion_cve= sse_encuestas.reglas_evaluacion_cve
          join public.mdl_user on public.mdl_user.id=encuestas.sse_designar_autoeveluaciones.evaluador_user_cve
          join public.mdl_role on public.mdl_role.id=sse_reglas_evaluacion.rol_evaluador_cve
          WHERE "sse_encuestas"."status" = '1'
          AND "sse_reglas_evaluacion"."tutorizado" = '1'
          AND "sse_encuesta_curso"."course_cve" = '838'
          AND "sse_reglas_evaluacion"."ord_prioridad" IN('1')
          and sse_designar_autoeveluaciones.evaluador_user_cve=22111 */
        $resultado = array();

        //$regla_id=$this->get_regla(array(''));
        /* $reglas_validas = $this->enc_mod->get_reglas_validas_cur(array('tutorizado' => $params['tutorizado'],
          'cur_id' => $params['cur_id'], 'ord_prioridad' => '1')); */


        $this->db->where('sse_encuestas.status', '1');
        $this->db->where('sse_reglas_evaluacion.tutorizado', $params['tutorizado']);
        $this->db->where('sse_encuesta_curso.course_cve', $params['cur_id']);

        $this->db->where('sse_reglas_evaluacion.ord_prioridad', '1');
        $this->db->where('sse_designar_autoeveluaciones.evaluador_user_cve', $params['user_id']);


        /* if (isset($params['grupos']) && !empty($params['grupos'])) {
          $grupo_condition = "(SELECT array_agg(g.name)::varchar FROM public.mdl_groups g WHERE g.id IN (" . $params['grupos'] . ")) AS ngpo, '" . $params['grupos'] . "' as grupos_ids_text";
          } else {
          $grupo_condition = "public.mdl_groups.name as ngpo, \'\' AS grupos_ids_text";
          } */


        $consulta = 'encuestas.sse_reglas_evaluacion.rol_evaluado_cve as roleevaluado, encuestas.sse_designar_autoeveluaciones.des_autoevaluacion_cve,
        (select name from public.mdl_role where id=rol_evaluado_cve ) as roleevaluadon,

        grupos_ids_text,
        public.mdl_role.name as evaluadorn,sse_encuestas.encuesta_cve as regla,
        sse_designar_autoeveluaciones.course_cve,sse_designar_autoeveluaciones.evaluado_user_cve as user_id_evaluado,
        (select evaluacion_resul_cve from encuestas.sse_result_evaluacion_encuesta_curso where encuesta_cve=sse_encuestas.encuesta_cve and course_cve=sse_designar_autoeveluaciones.course_cve
and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=sse_designar_autoeveluaciones.evaluador_user_cve)  as realizado,
(select firstname || \' \' || lastname from mdl_user where id=sse_designar_autoeveluaciones.evaluado_user_cve) as nombreevaluado,
 sse_reglas_evaluacion.rol_evaluador_cve';





        $this->db->select($consulta);

        $this->db->join('encuestas.sse_encuestas', 'sse_encuestas.reglas_evaluacion_cve=sse_reglas_evaluacion.reglas_evaluacion_cve');
        $this->db->join('encuestas.sse_encuesta_curso', 'sse_encuesta_curso.encuesta_cve=sse_encuestas.encuesta_cve');
        $this->db->join('encuestas.sse_designar_autoeveluaciones', 'sse_designar_autoeveluaciones.encuesta_cve= sse_encuestas.encuesta_cve');
        $this->db->join('public.mdl_user', 'public.mdl_user.id=encuestas.sse_designar_autoeveluaciones.evaluador_user_cve');
        $this->db->join('public.mdl_role', 'public.mdl_role.id=sse_reglas_evaluacion.rol_evaluador_cve');

        $query = $this->db->get('encuestas.sse_reglas_evaluacion');


        $resultado = $query->result_array();


        //pr($this->db->last_query());
        return $resultado;
    }

    public function crear_contador_encuestas($userid, $cursoid, $datos_usuario_curso) {
        if (!empty($datos_usuario_curso)) {
            $total_registros = 0;
            $total_contestadas = 0;
            foreach ($datos_usuario_curso as $value_capaa) {
                foreach ($value_capaa as $value_capab) {
                    $total_registros +=1;
                    if (is_numeric($value_capab['realizado']) and intval($value_capab['realizado']) > 0) {
                        $total_contestadas +=1;
                    }
                }
            }
            $cad = $userid . ',' . $cursoid . ',' . $total_registros . ',' . $total_contestadas . ',' . 0; //Nuevo registro
            $query = $this->db->get('encuestas.update_contador_encuestas(' . $cad . ')'); //Obtener conjunto de registros
            $query->result_array();
        }
    }


    /**
    * Función para generar el registro de encuestas que debe contestar un usuario
    * @param id_usuario int identidicador del usuarios
    * @param id_curso int identificador de oci_new_cursor
    * @param datos array configuración de la encuesta
    **/
    public function upsert_contador_encuestas($id_usuario = 0, $id_curso = 0, $datos = [])
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $registros = [];
        foreach ($datos as $linea)
        {
            foreach ($linea as $row)
            {
                if(isset($registros[$row['regla']])){
                    //pr($row['realizado']);
                    $registros[$row['regla']]['total_encuestas']++;
                    if((!is_null($row['realizado']) && $row['realizado'] != ''))
                    {
                        //pr('hola');
                        $registros[$row['regla']]['contador_contestadas']++;
                    }
                }else{
                    $registros[$row['regla']] = array(
                        'id_user' => $id_usuario,
                        'id_curso' => $id_curso,
                        'id_encuesta' => $row['regla'],
                        'contador_contestadas' => (!is_null($row['realizado']) && $row['realizado'] != '')? 1:0,
                        'total_encuestas' => 1
                    );
                }
            }
        }
        foreach ($registros as $row)
        {
            // pr($row);
            $this->db->select('count(*) cantidad');
            $this->db->where('id_user', $row['id_user']);
            $this->db->where('id_curso', $row['id_curso']);
            $this->db->where('id_encuesta', $row['id_encuesta']);
            $query = $this->db->get('encuestas.sse_contador_encuestas');
            $cantidad = count($query->result_array()) > 0? $query->result_array()[0]['cantidad']:0;
            $query->free_result();
            if($cantidad == 0)
            {
                $this->db->insert('encuestas.sse_contador_encuestas', $row);
            }else{
                $this->db->set('contador_contestadas', $row['contador_contestadas'] );
                $this->db->set('total_encuestas', $row['total_encuestas']);
                $this->db->where('id_user', $row['id_user']);
                $this->db->where('id_curso', $row['id_curso']);
                $this->db->where('id_encuesta', $row['id_encuesta']);
                $this->db->update('encuestas.sse_contador_encuestas');
            }
        }
        $this->db->flush_cache();
        $this->db->reset_query();
    }

    /**
    ** Función que retorna true en caso de que existan encuestas contestadas de un curso X
    **/
    private function existen_encuestas_contestadas($curso = 0)
    {
        $salida = false;
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->select('count(*) cantidad');
        $this->db->where('course_cve', $curso);
        $query = $this->db->get('encuestas.sse_evaluacion');
        $salida = $query->result_array()[0]['cantidad'] != 0;
        // pr($this->db->last_query());
        $query->free_result();
        $this->db->reset_query();
        return $salida;
    }
}
