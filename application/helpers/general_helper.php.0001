<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// HELPER General
/**
 * Método que preformatea una cadena
 * @autor 		: Jesús Díaz P.
 * @param 		: mixed $mix Cadena, objeto, arreglo a mostrar
 * @return  	: Cadena preformateada
 */
if (!function_exists('pr')) {

    function pr($mix) {
        echo "<pre>";
        print_r($mix);
        echo "</pre>";
    }

}

/**
 * Método que valida una variable; que exista, no sea nula o vacía
 * @autor 		: Jesús Díaz P.
 * @modified 	:
 * @param 		: mixed $valor Parámetro a validar
 * @return 		: bool. TRUE en caso de que exista, no sea vacía o nula de lo contrario devolverá FALSE
 */
if (!function_exists('exist_and_not_null')) {

    function exist_and_not_null($valor) {
        return (isset($valor) && !empty($valor) && !is_null($valor)) ? TRUE : FALSE;
    }

}

/**
 * Método que valida un indice dentro de un arreglo; que exista, no sea nulo o vacío
 * @autor 		: Jesús Díaz P.
 * @modified 	:
 * @param 		: mixed $valor Parámetro a validar
 * @return 		: bool. TRUE en caso de que exista, no sea vacía o nula de lo contrario devolverá FALSE
 */
if (!function_exists('exist_and_not_null_array')) {

    function exist_and_not_null_array($arreglo, $llave) {
        return (array_key_exists($llave, $arreglo) && !empty($arreglo[$llave]) && !is_null($arreglo[$llave])) ? TRUE : FALSE;
    }

}

/**
 * Método que genera un arreglo asociativo de la forma llave => valor, derivado de un arreglo multidimensional
 * @autor 		: Jesús Díaz P.
 * @modified 	:
 * @param 		: mixed[] $array_data
 * @param 		: string $field_key
 * @param 		: string $field_value
 * @return 		: mixed[]. TRUE en caso de que exista, no sea vacía o nula de lo contrario devolverá FALSE
 * Ejemplo: $array_multi = array(
 * 		array('llave1'=>'valor1.0', 'llave2'=>'valor2.0', 'llave3'=>'valor3.0'),
 * 		array('llave1'=>'valor1.1', 'llave2'=>'valor2.1', 'llave3'=>'valor3.1'),
 * 		array('llave1'=>'valor1.2', 'llave2'=>'valor2.2', 'llave3'=>'valor3.2'),
 * )
 * dropdown_options($array_multi, 'llave2', 'llave3');
 * Resultado: array(
 * 		array('valor2.0'=>'valor3.0'),
 * 		array('valor2.1'=>'valor3.1'),
 * 		array('valor2.2'=>'valor3.2'),
 * )
 */
if (!function_exists('dropdown_options')) {

    function dropdown_options($array_data, $field_key, $field_value) {
        $options = array();
        foreach ($array_data as $key => $value) {
            $options[$value[$field_key]] = $value[$field_value];
        }
        return $options;
    }

}

/**
 * Método utilizado para mostrar un mensaje en formato predefinido
 * @autor 		: Jesús Díaz P.
 * @modified 	:
 * @param 		: string $msg Texto a mostrar
 * @return 		: string Texto con formato predefinido
 */
if (!function_exists('data_not_exist')) {

    function data_not_exist($msg = null) {
        return '<h2 align="center" style="padding-top:100px; padding-bottom:100px;">' . ((exist_and_not_null($msg)) ? $msg : 'No han sido encontrados datos con los criterios seleccionados.') . '</h2>';
    }

}

/**
 * Método que crea un elemento div
 * @autor 		: Jesús Díaz P.
 * @modified 	:
 * @param 		: string $label_text Contenido de la etiqueta div
 * @param 		: mixed[] $attributes Atributos de la etiqueta div
 * @return 		: string Elemento div
 */
if (!function_exists('html_div')) {

    function html_div($label_text = '', $attributes = array()) {
        $label = '<div';
        if (is_array($attributes) && count($attributes) > 0) {
            foreach ($attributes as $key => $val) {
                $label .= ' ' . $key . '="' . $val . '"';
            }
        }
        return $label . '>' . $label_text . '</div>';
    }

}

/**
 * Método que crea un elemento span
 * @autor 		: Jesús Díaz P.
 * @modified 	:
 * @param 		: string $label_text Contenido de la etiqueta span
 * @param 		: mixed[] $attributes Atributos de la etiqueta span
 * @return 		: string Elemento span
 */
if (!function_exists('html_span')) {

    function html_span($label_text = '', $attributes = array()) {
        $label = '<span';
        if (is_array($attributes) && count($attributes) > 0) {
            foreach ($attributes as $key => $val) {
                $label .= ' ' . $key . '="' . $val . '"';
            }
        }
        return $label . '>' . $label_text . '</span>';
    }

}

/**
 * Método que crea un elemento p
 * @autor 		: Jesús Díaz P.
 * @modified 	:
 * @param 		: string $label_text Contenido de la etiqueta p
 * @param 		: mixed[] $attributes Atributos de la etiqueta p
 * @return 		: string Elemento p
 */
if (!function_exists('html_p')) {

    function html_p($label_text = '', $attributes = array()) {
        $label = '<p';
        if (is_array($attributes) && count($attributes) > 0) {
            foreach ($attributes as $key => $val) {
                $label .= ' ' . $key . '="' . $val . '"';
            }
        }
        return $label . '>' . $label_text . '</p>';
    }

}

/**
 * Método que crea un elemento number
 * @autor 		: Jesús Díaz P.
 * @modified 	:
 * @param 		: string $label_text Contenido de la etiqueta number
 * @param 		: mixed[] $attributes Atributos de la etiqueta number
 * @return 		: string Elemento p
 */
if (!function_exists('form_number')) {

    function form_number($data = '', $value = '', $extra = '') {
        $defaults = array(
            'type' => 'number',
            'name' => is_array($data) ? '' : $data,
            'value' => $value
        );

        return '<input ' . _parse_form_attributes($data, $defaults) . $extra . " />\n";
    }

}


/**
 * Método que encripta una cadena con el algoritmo sha512
 * @autor 		: Jesús Díaz P.
 * @modified 	:
 * @param 		: string $matricula Cadena a codificar
 * @param 		: string $contrasenia Cadena a codificar
 * @return 		: string Cadena codificada
 */
if (!function_exists('contrasenia_formato')) {

    function contrasenia_formato($matricula, $contrasenia) {
        return hash('sha512', $contrasenia . $matricula);
    }

}

/**
 * Método que define una plantilla para los mensajes que mostrará un formulario
 * @autor 		: Jesús Díaz P.
 * @modified 	:
 * @param 		: string $elemento Nombre del elemento form
 * @param 		: string $tipo Posibles valores('success','info','warning','danger')
 * @return 		: string Mensaje con formato predefinido
 */
if (!function_exists('form_error_format')) {

    function form_error_format($elemento, $tipo = null) {
        if (is_null($tipo)) {
            $tipo = 'danger';
        }
        return form_error($elemento, '<div class="alert alert-' . $tipo . '" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    }

}

/**
 * Método que define una plantilla para los mensajes que se mostrarán con bootstrap
 * @autor 		: Jesús Díaz P.
 * @modified 	:
 * @param 		: string $message Texto a mostrar
 * @param 		: string $tipo Posibles valores('success','info','warning','danger')
 * @return 		: string Mensaje de alerta con formato predefinido
 */
if (!function_exists('html_message')) {

    function html_message($message, $tipo = null) {
        if (is_null($tipo)) {
            $tipo = 'danger';
        }
        return '<div class="alert alert-' . $tipo . '" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message . '</div>';
    }

}

/**
 * Método que obtiene un listado de archivos de la ruta otorgada
 * @autor 		: Jesús Díaz P.
 * @modified 	:
 * @param 		: string $path Ruta de donde se obtendrá el listado de archivos
 * @return 		: mixed[] $result Listado de archivos
 */
if (!function_exists('get_files')) {

    function get_files($path) {
        return scandir($path);
    }

}

// ------------------------------------------------------------------------
if (!function_exists('merge_arrays')) {

    function merge_arrays($key, $value) {
        return $key . '="' . $value . '" ';
    }

}

/**
 * Método que hace una intersección entre dos array
 * @autor 		: Luis E. A.S.
 * @modified            :
 * @param 		: array $array_1 a comparar con $array_2
 * @return 		: $array_result  de intersección entré dor arrays
 */
if (!function_exists('filtra_array_por_key')) {

    function filtra_array_por_key($array_bidimencional, $array_unidimencional) {
        $is_array = exist_and_not_null($array_bidimencional);
        $is_array = $is_array && exist_and_not_null($array_unidimencional);
        $is_array = $is_array && is_array($array_bidimencional);
        $is_array = $is_array && is_array($array_unidimencional);
        $array_result = array();
        if ($is_array) {
            foreach ($array_unidimencional as $value) {
                foreach ($array_bidimencional as $key => $value_2) {
                    if ($value == $key) {
                        $array_result[$key] = $value_2;
                    }
                }
            }
            return $array_result;
        } else {
            return null;
        }
    }

}

if (!function_exists('get_propiedades_boton')) {

    function get_propiedades_boton($array_opciones_privilegios = null, $index = -1) {
        //id,value,tipe
        if (exist_and_not_null($array_opciones_privilegios)) {
            $existe_indice = array_key_exists($index, $array_opciones_privilegios);
            if (array_key_exists($index, $array_opciones_privilegios)) {
                $propiedades = $array_opciones_privilegios[$index];
                if (exist_and_not_null($propiedades)) {
//                    return array('id' => $propiedades['id'], 'type' => $propiedades['value'], 'value' => $propiedades['value'], 'attributes' => $propiedades['attributes']);
                    return $propiedades;
                }
            }
        }
        return null;
//        $array_listado = $this->config->item('listado_tareas');
//        pr($array_listado[$index]);
//        $is_array = exist_and_not_null($array_opciones_privilegios);
//        $array_result = array();
//        if ($is_array) {
//            $i = 0;
//            foreach ($array_opciones_privilegios as $key => $value) {
//                foreach ($value as $k => $v) {
//                    $bono = $this->config->item($key);
//                    $array_config = $bono[$k][$v]; //Estados
//                    $array_result[$key] = $array_config;
//                }
//            }
//            return $array_result;
//        } else {
//            return null;
//        }
    }

}

if (!function_exists('get_array_valor')) {

    function get_array_valor($array_busqueda, $key) {
        if (array_key_exists($key, $array_busqueda)) {
            $array_result = $array_busqueda[$key];
            return $array_result;
        }
        return array();
    }

}

if (!function_exists('crear_formato_array')) {

    /**
     * @author : LEAS <cenitluis.pumas@gmail.com>
     * @Fecha creación : 25-05-2016
     * @Fecha modificación :
     * @param type $array_value : Array ha analizar
     * @param type $key_ref : Llave de referencia del arreglo que será el index
     * del arreglo formateado
     * @param type $not_index_auto_incrementables : En false le agregará
     * un index autoincrementable, y en true se lo quita y sólo le agrega el $keyref
     * @return array[]
     * <p>
     * Array
      (
      [3] => Array
      (
      [0] => Array
      (
      [nombre_rol] => Ayudante
      [cve_modulo] => 3
      [nombre_modulo] => Comisiones académicas
      )

      )

      [4] => Array
      (
      [0] => Array
      (
      [nombre_rol] => Instructor de prácti
      [cve_modulo] => 2
      [nombre_modulo] => Formación del docente
      )

      [1] => Array
      (
      [nombre_rol] => Instructor de prácti
      [cve_modulo] => 3
      [nombre_modulo] => Comisiones académicas
      )

      )
      )

     * </p>
     */
    function crear_formato_array($array_value, $key_ref, $not_index_auto_incrementables) {
        $array_modulo = array();
        $index = -1;
        if ($not_index_auto_incrementables) {
            /* Le asigna la llave de referencia $key_ref al formato y no le agrega
             * index autoincrementables
             */
            for ($i = 0; $i < count($array_value); $i++) {
                $index = $array_value[$i][$key_ref];
                if (array_key_exists($index, $array_modulo)) {
                    $index_num_siguiente = count($array_modulo[$index]);
                    $array_modulo[$index] = array();
                } else {
                    $array_modulo[$index] = array();
                }
                foreach ($array_value[$i] as $key => $value) {
                    if ($key != $key_ref) {
                        $array_modulo[$index][$key] = $value;
                    }
                }
            }
        } else {
            /* Le  asigna un index auto incrementable que va desde "0" ,...., "n"
              al formato del array */
            for ($i = 0; $i < count($array_value); $i++) {
                $index = $array_value[$i][$key_ref];
                if (array_key_exists($index, $array_modulo)) {
                    $index_num_siguiente = count($array_modulo[$index]);
                    $array_modulo[$index][$index_num_siguiente] = array();
                } else {
                    $index_num_siguiente = 0;
                    $array_modulo[$index][$index_num_siguiente] = array();
                }
                foreach ($array_value[$i] as $key => $value) {
                    if ($key != $key_ref) {
                        $array_modulo[$index][$index_num_siguiente][$key] = $value;
                    }
                }
            }
        }
        return $array_modulo;
    }

}

if (!function_exists('crear_lista_asociativa_valores')) {

    /**
     *
     * @param type : $array_value array de busqueda
     * @param type : $key_ref llave busqueda
     * @param type : $val_ref valor asociación
     * @return type : array
     */
    function crear_lista_asociativa_valores($array_value, $key_ref, $val_ref) {
        $array_lista_roles = array();
        $key = -1;
        $value = '';
        for ($i = 0; $i < count($array_value); $i++) {
            $key = $array_value[$i][$key_ref];
            $value = $array_value[$i][$val_ref];
            $array_lista_roles[$key] = $value;
        }

        return $array_lista_roles;
    }

}
if (!function_exists('valida_sesion_activa')) {


    /**
     *
     * @author LEAS
     * @fecha 18112016
     * @param type $user_id
     * @return type
     */
    function valida_sesion_activa($user_id = null) {
        $CI = & get_instance();
        $valida_session = 0;
        $id_user_actual = $CI->session->userdata('id');
        $is_logeado = $CI->session->userdata('logueado');
//            pr($this->session->userdata);
        if (is_null($user_id)) {
            return 0;
        }
        $user_valido = (intval($user_id) == intval($id_user_actual)) ? 1 : 0;
        $valida_session = ($is_logeado == 1 and $user_valido); //Valida que el id del usuario que se logueo, sea igual al que desea consultar las encuestas
//        pr($valida_session);
        return $valida_session;
    }

}

if (!function_exists('sesion_iniciada')) {

    /**
     *
     * @author LEAS
     * @fecha 18112016
     * @param type $user_id
     * @return type
     */
    function sesion_iniciada() {
        $CI = & get_instance();
//        $control_encuestas = $CI->session->userdata('encuestas_die');
        $control_encuestas = $CI->session->userdata();
        pr('ssss');
        pr($control_encuestas);
        if (!is_null($CI->session->userdata('encuestas_die'))
                AND $CI->session->userdata('encuestas_die')['logueado']) {
            return 1;
        }
        return 0;
    }

}
if (!function_exists('transformar_modulos')) {

    /**
     *
     * @param type array $modulos_rol Moódulos de acceso segun el rol o roles del usuario
     * @return array con todos los módulos de acceso con llave index del módulo
     */
    function transformar_modulos($modulos_rol) {
        if (!is_array($modulos_rol)) {//Si no es un array, retorna null
            return null; //
        }
        $array_result = array();
        if (isset($modulos_rol['modulos'])) {

            foreach ($modulos_rol['modulos'] as $valores) {
                $array_result['modulos'][$valores['modulo_cve']] = $valores;
            }
            foreach ($modulos_rol['secciones'] as $valores) {
                $array_result['secciones'][$valores['modulo_cve']] = $valores;
            }
        }
        return $array_result;
    }

}

if (!function_exists('permiso_acceso_modulo')) {

    /**
     *
     * @param type int $modulos_id identificador del módulo que se validará su acceso
     * @return type integer si el modulo tiene acceso, retorna 1, si no, 0
     */
    function permiso_acceso_modulo($modulos_id) {
        $CI = & get_instance();
        $modulos_acceso = $CI->session->userdata('modulos_acceso');

        return (isset($modulos_acceso[$modulos_id])) ? 1 : 0; //Si se encuentra el modulo
    }

}

if (!function_exists('permiso_acceso_ruta')) {

    /**
     *
     * @param type $controlador
     * @param type $accion
     * @return type
     */
    function permiso_acceso_ruta($controlador, $accion, $is_ajax) {
        $CI = & get_instance();
        //Valida accesos generales con sesión iniciada
        $menu_logueado_general = $CI->config->item('menu_logueado_general');
        foreach ($menu_logueado_general as $value) {
            $conactena = $controlador . '/' . $accion;
            if ($conactena == $value) {
                return 1;
            }

            $exp_mgn = explode('/', $value); //descomposicion de la ruta
            if (isset($exp_mgn[1]) and $controlador == $exp_mgn[0] and $exp_mgn[1] == '*') {//Valida que la cadena de control contenga una ruta, indica que no es un controlador como tal, y que no venga vacia
                return 1;
            }
        }
        $modulos_acceso = $CI->session->get_datos_sesion_sistema('modulos_acceso');
        if (!is_null($modulos_acceso)) {
//		pr($modulos_acceso);
            $tmp_array_implicados = array();
            foreach ($modulos_acceso as $value) {
//                pr($value);
                $cadURL_control = $value['nom_controlador_funcion_mod'];
                if (strlen($cadURL_control) > 0 and $cadURL_control != '*') {//Valida que la cadena de control contenga una ruta, indica que no es un controlador como tal, y que no venga vacia
                    $explode = explode('/', $cadURL_control); //descomposicion de la ruta
                    $ctrl_mod = $explode[0];
                    $acc_mod = $explode[1];
                    if ($ctrl_mod == $controlador) {//Separa los controladores implicados
                        $tmp_array_implicados[$value['nom_controlador_funcion_mod']] = $value;
                    }
                }
            }

            if (!empty($tmp_array_implicados)) {//Verifica la eistencia de reglas de seguridad para el controlador actual
//                if ($is_ajax) {//Valida si es ajax
//                    if ($controlador == $ctrl_mod and $accion == $acc_mod) {//Si existe la condición, el controlador pasa
//                        return 1;
//                    }
//                } else {
                $concat = $controlador . '/' . $accion;
                if (isset($tmp_array_implicados[$concat])) {//Checa si existe el la acción y el controlador
                    return $tmp_array_implicados[$concat]['acceso'];
                }

                $concat = $controlador . '/*';
                if (isset($tmp_array_implicados[$concat])) {//Checa si existe el la acción y el controlador
//                    pr($tmp_array_implicados[$concat]['acceso']);
                    return $tmp_array_implicados[$concat]['acceso'];
                }
            } else {//Si no encuentra controlador, no permite acceso y retorna 0
                return 0;
            }
        } else {
            return 0;
        }
    }

}



    /* End of file general_helper.php */
