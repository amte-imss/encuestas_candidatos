<?php

/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of HBitacora
 *
 * @author chrigarc
 */
class LoaderSIED {

    private static $main = 'inicio/index';
    private static $libre_acceso = array(
        'denegado/index', 'login/cerrar_session', 'modal/', 'inicio/', 'login/regresar_sied'
    );

    function load() {
        $CI = & get_instance(); //Obtiene la insatancia del super objeto en codeigniter para su uso directo
        $CI->load->library('LNiveles_acceso', null, 'acceso');
        //        $CI->load->library('SessionSIED', null, 'session');
        $CI->load->model('Login_model', 'login_mod');
        // $this->bitacora();
        $this->datos_usuario($CI); //Genera la sesión en codeigniter
//        pr($CI->session->userdata());
        $datos_session = $CI->get_datos_sesion();
        //pr($datos_session);
        if (!is_null($datos_session) and $datos_session['id'] > 0) {
            $CI->load->model('Modulo_model', 'modulos');
            $modulos = $CI->modulos->get_niveles_acceso(0, 'modulos_rol', $datos_session[SessionSIED::ID]);
			$CI->niveles_acceso_usuario = $modulos;
            $CI->acceso->set_modulos_sistema($modulos); //Asigna modulos a la clase de accesos
            $CI->template->setNav($CI->acceso->get_modulos_sistema());
            $this->acceso($CI);
        } else {
            $controlador = $CI->uri->rsegment(1);  //Controlador actual o dirección actual
            $accion = $CI->uri->rsegment(2);  //Función que se llama en el controlador
            $CI->load->model('Modulo_model', 'modulos');
            $url = $controlador . '/' . $accion;
            if ($url == 'encuestausuario/lista_encuesta_usuario' || $url == 'evaluacion/instrumento_asignado') {
                $CI->redirecciona_moodle();
            } else {//Otros
                $CI->redirecciona_sesion_sied();
            }
        }
    }

    private function acceso($CI) {
        $CI->load->helper('url');
        $controlador = $CI->uri->rsegment(1);  //Controlador actual o dirección actual
        $accion = $CI->uri->rsegment(2);  //Función que se llama en el controlador
        $url = $controlador . '/' . $accion;
        /*if ($url == 'encuestas/index') {
            redirect(site_url() . '/inicio');
        }*/
        //$this->simula_usuario($CI, 24529); // simular niveles de acceso en las sesiones
        if (!in_array($url, LoaderSIED::$libre_acceso)) { //cambiar para localizar modulos de libre acceso como login
            //            $usuario = $CI->session->userdata('USER');
            $usuario = $CI->session->userdata()['encuestas_die'];
            //            //exit();
            if (!is_null($CI->session->userdata())) {
                //                redirect(site_url('denegado'));
            }
            if (isset($usuario['id']) && $usuario['id'] > 0) {
                $modulos = $CI->niveles_acceso_usuario;
                //$CI->niveles_acceso_usuario = $modulos;
				//pr($url);
                if (LoaderSIED::$main == $url) {
				//pr($CI->niveles_acceso_usuario);
                    if (!$this->verifica_permiso_sied($CI, $usuario)) {
                        // redirect($moodle);
                    }
                } else if (!$this->verifica_permiso($CI, $modulos)) {//No cuenta con permisos de acceso
//                     pr($modulos);
                    pr('No cuenta con permisos de acceso');
//                    redirect(site_url() . '/inicio');
                    exit();
                    // redirect($moodle);
                }
            } else {
                // redirect($moodle);
            }
        }
    }

    private function verifica_permiso_sied($CI, $usuario) {
        return $CI->modulos->check_acceso_sied($usuario['id']);
    }

    private function verifica_permiso($CI, $modulos) {
        $controlador = $CI->uri->rsegment(1);  //Controlador actual o dirección actual
        $accion = (is_null($CI->uri->rsegment(2))) ? 'index' : $CI->uri->rsegment(2);  //Función que se llama en el controlador
        $url = '/' . $controlador . '/' . $accion;
        //        $modulo = $CI->modulos->check_acceso($url, $usuario['id']);
        $acceso = $CI->acceso->permiso_acceso_ruta($url, $modulos);
//        pr($acceso);
        return $acceso;
    }

    private function bitacora() {
        $CI = & get_instance(); //Obtiene la insatancia del super objeto en codeigniter para su uso directo
        $CI->load->library('Bitacora');
        $CI->bitacora->registra_actividad();
    }

    private function datos_usuario($CI) {
        switch (ENVIRONMENT) {
            case 'development':
                $datos_sesion = $CI->session->userdata();

                if (!isset($datos_sesion['encuestas_die'])) {
                    if (is_null($datos_sesion)) {
                        /* cambiar id para probar diferentes roles */
                         // $id_user_aux = 24734;
                        $id_user_aux = 1262;//Administrador
//                        $id_user_aux = 53891;//Administrador de mesa de ayuda
//                        $id_user_aux = 16182; //Agente de mesa de ayuda
//                        $id_user_aux = 34685; //Área de Tecnologías para la Gestión del Conocimiento
//                        $id_user_aux = 15900; //CN
//                        $id_user_aux = 21933; //C evaluador
//                        $id_user_aux = 1644; //CC
                        //$id_user_aux = 44737;
                    } else {
                        $id_user_aux = $datos_sesion['USER']->id;
                    }
                    $usuario = $CI->login_mod->usuario_existe($id_user_aux);
                    if (isset($usuario)) {
                        //******Modulos de acceso *****
                        $usuario_data = array(
                            'id' => $usuario->id,
                            'nombre' => $usuario->nombre . ' ' . $usuario->apellidos,
                            'matricula' => $usuario->username,
                        );
                        $CI->session->set_userdata('encuestas_die', $usuario_data);
                    }
                }
                break;

            case 'testing':
                break;
            case 'production':
                $datos_sesion = $CI->session->userdata();
                if (!is_null($datos_sesion)) {
                    if (!isset($datos_sesion['encuestas_die']) || $datos_sesion['encuestas_die']['id'] != $datos_sesion['USER']->id) {
                        $id_user_aux = $datos_sesion['USER']->id;
                        $usuario = $CI->login_mod->usuario_existe($id_user_aux);
                        if (isset($usuario)) {
                            //******Modulos de acceso *****
                            $usuario_data = array(
                                'id' => $usuario->id,
                                'nombre' => $usuario->nombre . ' ' . $usuario->apellidos,
                                'matricula' => $usuario->username,
                            );
                            $CI->session->set_userdata('encuestas_die', $usuario_data);
                        }
                    }
                }
                break;
        }
    }

//    private function redirecciona_sesion_sied() {
//        $url_sied = $this->config->item('url_sied_logout');
//        redirect($url_sied);
//    }
//
//    private function redirecciona_moodle() {
//        $url_moodle = $this->config->item('url_moodle_logout');
//        redirect($url_moodle);
//    }
}
