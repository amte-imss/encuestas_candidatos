<?php   defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogos_model extends CI_Model {
    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->config->load('general');
        $this->load->database();
    }

    public function actualizar_modulo_rol($datos){
        //pr($datos);
        foreach ($datos['roles'] as $value) {
            $this->db->update('encuestas.sse_modulo_rol', array('acceso'=>1), 'modulo_cve='.$datos['modulo_cve'].' and role_id='.$value);
            //pr($this->db->last_query());
        }
    }

    public function get_secciones($filtros = [])
    {
        $secciones = [];
        $this->db->flush_cache();
        $this->db->reset_query();
        if(isset($filtros['descripcion']) && $filtros['descripcion'] != '')
        {
            $this->db->where('descripcion', $filtros['descripcion']);
        }
        $secciones = $this->db->get('encuestas.sse_seccion')->result_array();
        $this->db->flush_cache();
        $this->db->reset_query();
        return $secciones;
    }

    public function get_indicadores($filtros = [])
    {
        $indicadores = [];
        $this->db->flush_cache();
        $this->db->reset_query();
        if(isset($filtros['descripcion']) && $filtros['descripcion'] != '')
        {
            $this->db->where('descripcion', $filtros['descripcion']);
        }
        $indicadores = $this->db->get('encuestas.sse_indicador')->result_array();
        $this->db->flush_cache();
        $this->db->reset_query();
        return $indicadores;
    }

    public function get_reglas_evaluacion($filtros = array()) {
        $resultado = [];
        $this->db->where($filtros);
        $query = $this->db->get('encuestas.sse_reglas_evaluacion'); //Obtener conjunto de registros
        if ($query->num_rows() > 0) {
            $resultado = $query->result_array();
        }
        //pr($this->db->last_query());
        return $resultado;
    }

    public function tipo_pregunta($row = array())
    {
        $respuesta = $this->config->item('ENCUESTAS_RESPUESTA'); // obtenemos los valores de la constante ENCUESTAS_RESPUESTA
        $tipo_pregunta = $this->config->item('ENCUESTAS_TIPO_PREGUNTA'); // obtenemos los valores de la constante ENCUESTAS_TIPO_PREGUNTA
        $respuesta_esperada = $this->config->item('ENCUESTAS_RESPUESTA_ESPERADA'); //obtenemos los valores de la constante ENCUESTAS_RESPUESTA_ESPERADA

        $es_nulo = ((!empty($row['NO_APLICA'])) ? strtoupper($row['NO_APLICA']) : 'NO' ); //convertimos el valor en UPPER si viene vacio lo definimos como valor NO
        $si = ((!empty($row['SI'])) ? strtoupper($row['SI']) : 'NO' ); //convertimos el valor en UPPER si viene vacio lo definimos como valor NO
        $no = ((!empty($row['NO'])) ? strtoupper($row['NO']) : 'NO' ); //convertimos el valor en UPPER si viene vacio lo definimos como valor NO
        $siempre = ((!empty($row['SIEMPRE'])) ? strtoupper($row['SIEMPRE']) : 'NO' ); //convertimos el valor en UPPER si viene vacio lo definimos como valor NO
        $casi_siempre = ((!empty($row['CASI_SIEMPRE'])) ? strtoupper($row['CASI_SIEMPRE']) : 'NO' ); //convertimos el valor en UPPER si viene vacio lo definimos como valor NO
        $algunas_veces = ((!empty($row['ALGUNAS_VECES'])) ? strtoupper($row['ALGUNAS_VECES']) : 'NO' ); //convertimos el valor en UPPER si viene vacio lo definimos como valor NO
        $casi_nunca = ((!empty($row['CASI_NUNCA'])) ? strtoupper($row['CASI_NUNCA']) : 'NO' ); //convertimos el valor en UPPER si viene vacio lo definimos como valor NO
        $nunca = ((!empty($row['NUNCA'])) ? strtoupper($row['NUNCA']) : 'NO' ); //convertimos el valor en UPPER si viene vacio lo definimos como valor NO
        $respuesta_abierta = ((!empty($row['RESPUESTA_ABIERTA'])) ? strtoupper($row['RESPUESTA_ABIERTA']) : 'NO' ); //convertimos el valor en UPPER si viene vacio lo definimos como valor NO
        //$valido_no_aplica = ((!empty($row['VALIDO_NO_APLICA'])) ? strtoupper($row['VALIDO_NO_APLICA']) : 'NO' ); //convertimos el valor en UPPER si viene vacio lo definimos como valor NO
        $no_envio_mensaje = ((!empty($row['NO_ENVIO_MENSAJE'])) ? strtoupper($row['NO_ENVIO_MENSAJE']) : 'NO' ); //convertimos el valor en UPPER si viene vacio lo definimos como valor NO


        $reactivos = ( // GENERAMOS UNA SUMA DE REACTIVOS PARA TRANSFORMARLO EN TIPO DE PREGUNTA
                $respuesta['CERRADA'][$es_nulo] +
                $respuesta['CERRADA'][$si] +
                $respuesta['CERRADA'][$no] +
                $respuesta['CERRADA'][$siempre] +
                $respuesta['CERRADA'][$casi_siempre] +
                $respuesta['CERRADA'][$algunas_veces] +
                $respuesta['CERRADA'][$nunca] +
                $respuesta['CERRADA'][$casi_nunca] +
                $respuesta['NO_ENVIO_MENSAJE'][$no_envio_mensaje] +
                $respuesta['ABIERTA'][$respuesta_abierta]

                );
        //pr('[CH][Encuestas][tipo_pregunta]reactivos: '.$reactivos);

        $error_tipo_pregunta;
        if ($reactivos <= 9 && !in_array($reactivos, array(2, 3, 5, 6, 7, 8, 9))) { // SI EL VALOR DEL REACTIVO NO SE ENCUENTRA EN EL ARREGLO Y ES MENOR A 8
            $reactivos = 1; // ERROR EN EL LLENADO DE LAS RESPUESTAS // FALTAN RESPUESTAS
            $error_tipo_pregunta = "El grupo de opciones de respuestas seleccionado no es correcto"; // ASIGNAMOS EL ERROR
        } elseif ($reactivos > 9) { // SI EL VALOR DE LOS REACTIVOS SON MAYORES A 8
            $reactivos = 1; //DEFINIMOS COMO RESPUESTA INDEFINIDA
            // no puede seleccionar todas las opciones respuestas
            $error_tipo_pregunta = "No puede seleccionar todas las opciones respuestas"; // ASIGNAMOS EL ERROR
        } elseif (in_array($reactivos, array(7, 8)) && $respuesta_abierta !== 'SI') { // Si el valor de los reactivos se encuentra en el arreglo pero la respuesta_abierta no esta activa
            $reactivos = 1; // ERROR EN EL LLENADO DE LAS RESPUESTAS // A SELECCIONADO MAS DE LAS RESPUESTAS VALIDAS

            $error_tipo_pregunta = "El grupo de opciones de respuesta seleccionado no esta clasificado"; // asignamos el error
        } elseif (in_array($reactivos, array(5, 6)) && ($si === 'SI' OR $no === 'SI')) { // Si el valor de los reactivos se encuentran en el arrreglo pero las respuestas 'SI' Y 'NO' no estan vacias
            $reactivos = 1; // su seleccion de respuestas no es valida defina si es el grupo de respuestas, se esperaban respuestas diferentes de SI o NO

            $error_tipo_pregunta = "La seleccion de opciones de respuestas no es valida, se esperaban respuestas diferentes de SI o NO"; // asignamos el error
        } elseif (in_array($reactivos, array(2, 3, 8)) && ($si !== 'SI' OR $no !== 'SI')) { // Si el valor de los reactivos se encuentran en el arreglo pero las respuestas SI y NO no estan activadas
            $reactivos = 1; // su seleccion de respuestas no es valida, se esperan respuestas SI, NO, NULO

            $error_tipo_pregunta = "La seleccion de opciones de respuestas no es valida, se esperaban las opciones de respuesta: SI, NO, NULO";
        } elseif (in_array($reactivos, array(2, 3, 9)) && ($si !== 'SI' OR $no !== 'SI')) { // Si el valor de los reactivos se encuentran en el arreglo pero las respuestas SI y NO no estan activadas
            $reactivos = 1; // su seleccion de respuestas no es valida, se esperan respuestas SI, NO, NULO

            $error_tipo_pregunta = "La seleccion de opciones de respuestas no es valida, se esperaban las opciones de respuesta: SI, NO, NO ENVIO MENSAJE";
        } elseif ($reactivos == 9 && ($si !== 'SI' OR $no !== 'SI')) { // Si el valor de los reactivos se encuentran en el arreglo pero las respuestas SI y NO no estan activadas
            $reactivos = 1; // su seleccion de respuestas no es valida, se esperan respuestas SI, NO, NULO

            $error_tipo_pregunta = "La seleccion de opciones de respuestas no es valida, se esperaban las opciones de respuesta: SI, NO, NO ENVIO MENSAJE";
        }
        // FALTA DEFINIR SI LA PREGUNTA PADRE ES MENOR EN EL ORDEN DE LA PREGUNTA HIJA
        // BUSCAR EN EL ARREGLO SI LA POSICION DE LA PREGUNTA PADRE EXISTE LA RESPUESTA ESPERADA

        $pregunta_completa = $tipo_pregunta[$reactivos]; // se asigna el contador que define el tipo de pregunta
        if (isset($row['PREGUNTA_PADRE']) && !empty($row['PREGUNTA_PADRE']) && isset($row['RESPUESTA_ESPERADA']) && !empty($row['RESPUESTA_ESPERADA'])) {
            $pregunta_completa['respuesta_esperada'] = $respuesta_esperada[$row['RESPUESTA_ESPERADA']];
        }
        if ($reactivos === 1) {
            $pregunta_completa['is_error'] = TRUE;
            $pregunta_completa['error'] = $error_tipo_pregunta;
        }

        return $pregunta_completa;
    }
}
