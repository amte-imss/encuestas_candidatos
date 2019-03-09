<?php

if (!defined('BASEPATH'))
    exit('NO DIRECT SCRIPT ACCESS ALLOWED');

class Iniciar_sesion {

    var $CI;

    function login() {
        $CI = & get_instance();
//          $CI->session->sess_destroy();
//          exit();
        $CI->load->model('Encuestas_model', 'enc_mod');
        $CI->load->model('Login_model', 'lm');
        $CI->load->helper('url');
        $CI->config->load('general');
        $this->datos_usuario($CI); //Genera la sesión en codeigniter
//        pr($CI->session->userdata());
        if (!is_null($CI->session->userdata())) {
            $CI->load->library('LNiveles_acceso', null, 'acceso');
            $datos_sesion = $CI->session->get_datos_sesion_sistema();
            $usuario_id = $datos_sesion['id'];
            $controlador = $CI->uri->segment(1);  //Controlador
            $accion = $CI->uri->segment(2);  //Accion
            $is_ajax = $CI->input->is_ajax_request();  //Accion
            $datos_['sesion_iniciada'] = 1;
            $modulos = $CI->lm->get_modulos_sesion($usuario_id); //Obtiene modulos  de la base de datos según el usuario
            $acceso = $CI->acceso->permiso_acceso_ruta($controlador, $accion, $is_ajax, $modulos);
            if (!$acceso == 1) {//Verifica que el rol del usuario permita el accesos a por lo menos un módulo
//                $CI->load->view('template/sin_acceso', $datos_);
//                exit();
                redirect("inicio");
            }
        } else {//Si el usuario no se encuentra con sesión iniciada
            $datos_['sesion_iniciada'] = 0;
            $no_logueo = $CI->config->item('menu_no_logueado');
            $concat = $controlador . '/' . $accion;
            $valida = 0;
            foreach ($no_logueo as $value) {
                if ($value == $concat) {
                    $valida = 1;
                    break;
                }
            }
            if (!$valida) {
                //echo $CI->load->view('template/sin_acceso', $datos_, true);
                //exit();
                  $url_sied = $this->config->item('url_sied');
                  redirect($url_sied);
            }
        }
    }

    private function datos_usuario($CI) {
//        pr($datos_sesion);
        $datos_sesion = $CI->session->userdata();
        switch (ENVIRONMENT) {
            case 'development':
                if (!isset($datos_sesion['encuestas_die'])) {
                    if (is_null($datos_sesion)) {
                        /*cambiar id para probar diferentes roles */
                        $id_user_aux = 1262;
//                        $id_user_aux = 27353;
                    } else {
                        $id_user_aux = $datos_sesion('USER')->id;
                    }
                    $usuario = $CI->enc_mod->usuario_existe($id_user_aux);
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

                        $id_user_aux = $datos_sesion('USER')->id;
                        $usuario = $CI->enc_mod->usuario_existe($id_user_aux);
                        if (isset($usuario)) {
                            //******Modulos de acceso *****
                            $usuario_data['encuestas_die'] = array(
                                'id' => $usuario->id,
                                'nombre' => $usuario->nombre . ' ' . $usuario->apellidos,
                                'matricula' => $usuario->username,
                            );

                            $CI->session->set_userdata($usuario_data);
                        }
                    }
                }
                break;
        }
    }

}
