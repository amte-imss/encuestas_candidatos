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
class Loader {

    private static $main = 'inicio/index';
    private static $libre_acceso = array(
        'denegado/index',
    );

    function load() {
        $CI = & get_instance(); //Obtiene la insatancia del super objeto en codeigniter para su uso directo
	//        $CI->load->library('SessionSIED', null, 'session');	
        $CI->load->model('Login_model', 'login_mod');
        // $this->bitacora();
        $this->datos_usuario($CI); //Genera la sesión en codeigniter
	//	pr($CI->session->userdata());
		       $this->acceso($CI);
    }

    private function acceso($CI) {
        $CI->load->helper('url');

        $controlador = $CI->uri->rsegment(1);  //Controlador actual o dirección actual
        $accion = $CI->uri->rsegment(2);  //Función que se llama en el controlador
        $CI->load->model('Modulo_model', 'modulos');
        $url = $controlador . '/' . $accion;
        //$this->simula_usuario($CI, 24529); // simular niveles de acceso en las sesiones
        if (!in_array($url, Loader::$libre_acceso)) { //cambiar para localizar modulos de libre acceso como login
//            $usuario = $CI->session->userdata('USER');
            $usuario = $CI->session->userdata()['encuestas_die'];
//            //exit();
            if (!is_null($CI->session->userdata())) {
//                redirect(site_url('denegado'));
            }
            if (isset($usuario['id']) && $usuario['id'] > 0) {
                $bonos_niveles_acceso = $CI->modulos->get_niveles_acceso(0, 'modulos_rol', $usuario['id']);
                $CI->niveles_acceso_usuario = $bonos_niveles_acceso;
                if (Loader::$main == $url) {
                    if (!$this->verifica_permiso_sied($CI, $usuario)) {
//                        redirect(site_url('denegado'));
                    }
                } else if (!$this->verifica_permiso($CI, $bonos_niveles_acceso)) {
                    //                  redirect(site_url('denegado'));
                }
            } else {
//                redirect(site_url('denegado'));
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
        $CI->load->library('LNiveles_acceso', null, 'acceso');
        return $CI->acceso->permiso_acceso_ruta($url, $modulos);
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
                        $id_user_aux = 1262;
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
                    if (!isset($datos_sesion['encuestas_die'])) {
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

}
