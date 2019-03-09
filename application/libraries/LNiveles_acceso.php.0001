<?php

/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */

/**
 * Description of LNiveles_acceso
 *
 * @author chrigarc
 */
class LNiveles_acceso {

    private $modulos_sistema;

    //put your code here
    public function __construct() {

    }

    public function nivel_acceso_valido($modulos_acceso) {
        $status = false;
        foreach ($niveles_disponibles as $nivel) {
            if (is_array($nivel) && isset($nivel['id_rol'])) {
                $nivel = $nivel['id_rol'];
            }
            if (in_array($nivel, $niveles_requeridos)) {
                $status = true;
            }
        }
        return $status;
    }

    /**
     *
     * @param type array $modulos_rol Moódulos de acceso segun el rol o roles del usuario
     * @return array con todos los módulos de acceso con llave index del módulo
     * @
     */
    private function transformar_modulos($modulos_rol) {
        if (!is_array($modulos_rol)) {//Si no es un array, retorna null
            return []; //
        }
        $array_result = array();
        foreach ($modulos_rol as $valores) {
            // pr($valores);
            if(isset($array_result[$valores['modulo_cve']]))
            {
                if($valores['activo'] == 1)
                {
                    $array_result[$valores['modulo_cve']] = $valores;
                }
            }else{
                $array_result[$valores['modulo_cve']] = $valores;
            }
        }
        // pr($array_result);
        return $array_result;
    }

    /**
     * @author LEAS
     * @fecha 22/11/2017
     * @dexcripcion Asigna modulos del seistema
     */
    public function set_modulos_sistema($modulos = null) {
        $this->modulos_sistema = $this->transformar_modulos($modulos);
    }

    /**
     * @author LEAS
     * @fecha 22/11/2017
     * @param type $modulos
     * @return type Obtiene las secciones o menus del sistema
     * @deprecated since version number 0.0
     */
    public function get_modulos_sistema() {
        return $this->modulos_sistema;
    }

    /**
     *
     * @author LEAS
     * @fecha 07/11/2017
     * @param type $modulos
     * @return type Obtiene las secciones o menus del sistema y las rutas de acceso
     */
    public function get_secciones_modulos_sistema($modulos = null) {
        if (is_null($modulos)) {
            return null;
        }
//        $menus_modulos = $this->transformar_modulos($modulos);
//        if (empty($menus_modulos)) {
//            return null;
//        }
//        return ['secciones_acceso' => $menus_modulos['secciones'], 'modulos_acceso' => $menus_modulos['modulos']];
        $secciones = [];
        foreach ($modulos as $row) {
            if ($row['is_menu'] == 1 && $row['activo'] == 1) {
                $secciones[$row['modulo_cve']] = true;
            }
        }
        // pr($secciones);
        return $secciones;
    }

    /**
     *
     * @param type $controlador Ruta principal del controlador
     * @param type $accion index o cualquiere otro método al mismo nivel
     * @param type $is_ajax indica si el llamado es de ajax
     * @param type $modulos_acceso
     * @return int "1" si el usuario tiene permiso de acceso, si no, retorna "0"
     */
    public function permiso_acceso_ruta($url, $modulos_acceso = null) {
        $CI = & get_instance();
//         pr($url);
        //  pr($modulos_acceso);
        $valor = 0;
        foreach ($modulos_acceso as $value) {
            if ($url == $value['url'] || $url == $value['url'] . 'index') {
//                pr('$url ' . $url . ' -> ' .  $value['url']);
                if($value['activo'] == 1){
                    $valor = $value['activo'];
                }
            }
        }
        return $valor;
    }

    function get_valida_sesion_activa($datos_sesion, $user_id) {
        if (is_null($datos_sesion)) {
            return 0;
        }
        $user_valido = (intval($user_id) == intval($datos_sesion[SessionSIED::ID])) ? 1 : 0;
        return $user_valido;
    }

    public function get_permiso_accion($accion) {
        // pr($this->modulos_sistema);
        foreach ($this->modulos_sistema as $value) {
            if (strpos($value['url'], $accion) > -1 and $value['activo'] == 1) {
                return intval($value['modulo_cve']);
            }
        }
        return -1;
    }

}
