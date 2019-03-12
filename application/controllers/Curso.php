<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version     : 1.0.0
 * @autor       : Pablo José
 */
class Curso extends MY_Controller {

    /**
     * * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     * * @access        : public
     * * @modified  : 
     */
    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('form_complete'); // form complete
        $this->load->library('form_validation'); //implemantación de la libreria form validation
//        $this->config->load('general'); 
//        $this->config->load('form_validation'); // abrir el archivo general de validaciones
        //$this->load->model('Reporte_model', 'rep_mod'); // modelo de reporte
        $this->load->model('Curso_model', 'cur_mod'); // modelo de cursos
        $this->load->model('Encuestas_model', 'enc_mod');
        $this->load->model('Reporte_model', 'rep_mod'); // modelo de reporte
    }

    public function index() {


        $anios = $this->lista_anios(2009, date('Y'), FALSE);
        $rol = $this->config->item('rol_docente');
        //$data['categoria']=dropdown_options($categoria, 'cve_categoria','nom_nombre');
        //$data['adscripcion']=dropdown_options($adscripcion, '','');
        $data['anios'] = dropdown_options($anios, 'anio_id', 'anio_desc');
        //$data['rol']=dropdown_options($rol, 'rol_id','rol_nom');
        $datos['order_columns'] = array('emp_matricula' => 'Matrícula', 'cve_depto_adscripcion' => 'Adscripción', 'cat_nombre' => 'Categoría', 'grup_nom' => 'BD');

        /*
          #
          [2] => emp_matricula
          [3] => emp_nombre
          [11] => cat_nombre
          [15] => fch_pre_registro
          [17] => cur_clave
          [18] => cur_nom_completo
          [19] => fecha_inicio
          [20] => horascur
          [21] => fecha_fin
          [24] => grup_nom
          [25] => tutorizado
          [26] => curso_alcance
          [27] => rol_nom
          [28] => tipocur


         */

        /*
          $data['profesores'] = $this->rep_mod->reporte_usuarios(array('per_page'=>10, 'current_row'=>1));
          pr($data['profesores']);

         */
        $main_contet = $this->load->view('curso/cursos', $data, true);
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

    public function curso_bloque_grupos($curso = null) {
//        $data['datos_curso'] = $this->cur_mod->listado_cursos(array('cur_id'=>$curso));
//        $data['grupos'] = $this->cur_mod->listar_grupos_curso(array('cur_id'=>$curso));
        $data['curso'] = $curso;
        if (is_null($curso) || !is_numeric($curso)) {
            $data['mensaje'] = 'No se encontró información del curso o los parámetros son incorrectos.<br>Por Favor repita el proceso';
            $data['tipo_alert'] = En_general::WARNING;
        } else {

            $data['datos_curso'] = $this->cur_mod->detalle_curso(array('vdc.idc ' => $curso));
            $result = $this->cur_mod->getGruposBloques(array('vdc.idc' => $curso));
//            pr($result);
            $data_tabla = $result;
            $num_max = ($result['max_boque'] > 0) ? $result['max_boque'] : 5;
            for ($i = 1; $i <= $num_max; $i++) {
                $bloques[$i] = 'Bloque ' . $i;
            }
            $data_tabla['max_boque'] = $num_max;
            $data_tabla['bloques'] = $bloques;
            $data_tabla['modulos_acceso'] = $this->get_modulos_habilitados();
//            pr($data_tabla);
//        pr($result);total_grupos, max_boque
//           [idc] => 838
//                    [clave] => CES-DD-I2-15
//                    [namec] => Formación de Directivos en Salud
//                    [tex_tutorizado] => Tutorizado
//                    [tipo_curso] => Diplomado
//                    [bloque] => 
//                    [id] => 11858
//                    [name] => ZACATECAS
//                )
            //pr($data_tabla);
            $data['vista'] = $this->load->view('curso/tabla_bloque_grupo', $data_tabla, true);
        }
        $main_contet = $this->load->view('curso/curso_bloque_grupos', $data, true);
        $this->template->setMainTitle('Gestión de bloques por curso');
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

    public function guardar_curso_bloque_grupos() {
        if ($this->input->post()) {
            $data_post = $this->input->post(NULL, TRUE);
//            pr($data_post);
//            exit();
            $validation = array();
            foreach ($data_post as $key => $value) {//Genera validaciones
                $explode = explode("_", $key);
                if ($explode[0] == 'b') {//Si es numeric, esta validando los grupos
                    $validation[] = array('field' => $key, 'label' => 'bloque', 'rules' => 'trim|required');
                }
            }
            $this->form_validation->set_rules($validation); //Carga validaciones

            if ($this->form_validation->run()) {//Ejecuta las validaciones
                //Guardar los bloques
                $result = $this->cur_mod->insertUpdate_CursoBloqueGrupo($data_post);
                if ($result === 1) {//Se guardo exitosamente la relacion curso-grupo-bloque
                    $html['mensaje'] = 'Los datos se almacenaron correctamente';
                    $html['tipo_alert'] = En_general::SUCCESS;
                } else {
                    $html['mensaje'] = 'Ocurrio un error, por favor intentelo más tarde';
                    $html['tipo_alert'] = En_general::DANGER;
                }
            }

            $result = $this->cur_mod->getGruposBloques(array('vdc.idc' => $data_post['curso']));
            $data_tabla = $result;
            $num_max = ($result['max_boque'] > $data_post['max_bloques']) ? $result['max_boque'] : $data_post['max_bloques'];
            for ($i = 1; $i <= $num_max; $i++) {
                $bloques[$i] = 'Bloque ' . $i;
            }
            $data_tabla['max_boque'] = $num_max;
            $data_tabla['bloques'] = $bloques;
            $data_tabla['modulos_acceso'] = $this->session->userdata("modulos_acceso");
            $html['html'] = $this->load->view('curso/tabla_bloque_grupo', $data_tabla, true);
            echo json_encode($html);
        }
    }

    public function get_data_ajax($current_row = null) {
        if ($this->input->is_ajax_request()) { //Sólo se accede al método a través de una petición ajax
            if (!is_null($this->input->post())) { //Se verifica que se haya recibido información por método post
                //aqui va la nueva conexion a la base de datos del buscador
                //Se guarda lo que se busco asi como la matricula de quien realizo la busqueda
                $filtros = $this->input->post();
                $filtros['current_row'] = (isset($current_row) && !empty($current_row)) ? $current_row : 0;

                //pr($filtros);
                $resultado = $this->cur_mod->listado_cursos($filtros); //Datos del formulario se envían para generar la consulta segun los filtros
                $data = $filtros;
                $data['total_empleados'] = $resultado['total'];
                $data['empleados'] = $resultado['data'];
                $data['current_row'] = $filtros['current_row'];
                $data['per_page'] = $this->input->post('per_page');
                //pr($data);
                $this->listado_resultado($data, array('form_recurso' => '#form_curso', 'elemento_resultado' => '#listado_resultado')); //Generar listado en caso de obtener datos
            }
        } else {
            redirect(site_url()); //Redirigir al inicio del sistema si se desea acceder al método mediante una petición normal, no ajax
        }
    }

    private function listado_resultado($data, $form) {
        $pagination = $this->template->pagination_data_curso($data); //Crear mensaje y links de paginación
        $links = "<div class='col-sm-5 dataTables_info' style='line-height: 50px;'>" . $pagination['total'] . "</div>
                <div class='col-sm-7 text-right'>" . $pagination['links'] . "</div>";
        echo $links . $this->load->view('curso/listado_cursos', $data, TRUE) . $links . '
            <script>
            $("ul.pagination li a").click(function(event){
                data_ajax(this, "' . $form['form_recurso'] . '", "' . $form['elemento_resultado'] . '");
                event.preventDefault();
            });
            </script>';
    }

    public function lista_anios($anio_inicio, $anio_fin, $asc = true) {
        $anios = array();
        if ($asc) {
            for ($anio = $anio_inicio; $anio <= $anio_fin; $anio++) {
                $anios[] = array('anio_id' => $anio, 'anio_desc' => $anio);
            }
        }else{
            for ($anio = $anio_fin; $anio >= $anio_inicio; $anio--) {
                $anios[] = array('anio_id' => $anio, 'anio_desc' => $anio);
            }
        }
        //pr($anios);
        return $anios;
    }

    public function info_curso($curso = null) {
        $data['curso'] = $this->cur_mod->listado_cursos(array('cur_id' => $curso));
        $data['iduser'] = $this->get_datos_sesion(SessionSIED::ID);
        $data['roles'] = $this->cur_mod->listar_roles_curso(array('cur_id' => $curso));
//        $data['grupos'] = $this->cur_mod->listar_grupos_curso(array('cur_id' => $curso));
        $data += $this->cur_mod->getGruposBloques(array('vdc.idc' => $curso));
//        $data['modulos'] = $this->get_modulos_habilitados();
//        pr($data); exit();

        $main_contet = $this->load->view('curso/info_curso', $data, true);
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

//Listado de usuarios autoevaluados
    public function lista_encuesta_usuario_autoevaluados($idcurso = null, $idusuario = null) {
        $datos = array();

        $datos_curso = $this->cur_mod->listado_cursos(array('cur_id' => $idcurso));
//                pr($datos_curso);
        $tutorizado = null;
        if (!empty($datos_curso['data'])) {
            $tutorizado = $datos_curso['data'][0]['tutorizado'];
        }
        //pr($datos_curso);
        //var_dump($datos_curso['data'][0]['tutorizado']);
        //$datos_roles_curso=$this->cur_mod->listar_roles_curso(array('cur_id'=>$idcurso));
        //pr($datos_roles_curso['data']);
        //pr(array_values($datos_roles_curso['data
        //roles por curso por usuario
        $usuarioscurso = $this->rep_mod->listado_usuariosenc(array('curso_id' => $idcurso, 'role_id' => '5'));
        //pr($usuarioscurso);

        foreach ($usuarioscurso as $keyuc => $valueuc) {
            //checar reglas validas con encuestas asignadas al curso
            //   pr($valueuc);

            /* if($valueuc['cve_usuario'] ==  10549)
              { */
            //echo $valueuc['cve_usuario'];
            //echo '<br>'; 
            $reglas_validas = $this->enc_mod->get_reglas_validas_cur(array('role_evaluador' => $valueuc['rol'],
                'tutorizado' => $datos_curso['data'][0]['tutorizado'], 'cur_id' => $idcurso, 'ord_prioridad' => '1'));

            //pr($reglas_validas);
            foreach ($reglas_validas as $keyr => $valuer) {

                $reglasgral[] = array('reglas_evaluacion_cve' => $valuer['reglas_evaluacion_cve'],
                    'rol_evaluado_cve' => $valuer['rol_evaluado_cve'],
                    'encuesta_cve' => $valuer['encuesta_cve'],
                    'eva_tipo' => $valuer['eva_tipo'],
                    'is_bono' => $valuer['is_bono'],
                    'rol_evaluador_cve' => $valueuc['rol'],
                    'evaluador_user_cve' => $valueuc['cve_usuario'],
                );
            }
            //pr($reglasgral);
            //}  
            //}
        }

        //pr($reglasgral);
        if (isset($reglasgral)) {
            //unset($datos_user_aeva);
            foreach ($reglasgral as $keyrg => $valuerg) {

                // pr($valuerg);
                //echo $valuer['encuesta_cve'];


                if ($valuerg['eva_tipo'] == 1) {//Por grupo
                    //echo "entra";
                    //por grupo
                    $datos_usuario = $this->enc_mod->get_datos_usuarios(array('user_id' => $valuerg['evaluador_user_cve'],
                        'cur_id' => $idcurso, 'rol_evaluado_cve' => $valuerg['rol_evaluado_cve'], 'rol_evaluador_cve' => $valuerg['rol_evaluador_cve']));

                    //pr($datos_usuario);
                    if (isset($datos_usuario) || isset($datos_curso) || !empty($datos_usuario) || !empty($datos_curso)) {
                        //pr($datos_usuario);
                        foreach ($datos_usuario as $key => $value1) {

                            //role evaluador
                            $role_evaluador = $value1['cve_rol'];
                            //pr($role_evaluador);
                            //grupo del evaluador
                            $gpo_evaluador = $value1['cve_grupo']; # code...
                            //pr($gpo_evaluador);




                            $datos_user_aeva[] = $this->enc_mod->listado_autoeval(array('gpo_evaluador' => $gpo_evaluador, 'role_evaluado' => $valuerg['rol_evaluado_cve'],
                                'cur_id' => $idcurso, 'encuesta_cve' => $valuerg['encuesta_cve'],
                                'evaluador_user_cve' => $valuerg['evaluador_user_cve'],
                                'role_evaluador' => $role_evaluador, 'eva_tipo' => $valuer['eva_tipo'])
                            );
                        }
                    }
                } elseif ($valuerg['eva_tipo'] == 2) {//Por bloque
                    //echo "entra2";//por bloque   # code...
                    $datos_usuario_bloque = $this->enc_mod->get_datos_usuarios_bloque(array('user_id' => $valuerg['evaluador_user_cve'],
                        'cur_id' => $idcurso,
                        'rol_evaluado_cve' => $valuerg['rol_evaluado_cve'],
                        'rol_evaluador_cve' => $valuerg['rol_evaluador_cve'],
                    ));
                    // pr('-----------------*****************------------------------');
                    //pr($datos_usuario_bloque);

                    if (isset($datos_usuario_bloque) || isset($datos_curso) || !empty($datos_usuario_bloque) || !empty($datos_curso)) {
                        foreach ($datos_usuario_bloque as $key_ub => $usu_blo) {//genera index por rol y bloque de los usuarios que pertenecen a los bloques
                            $dato_ub[$usu_blo['cve_rol']][$usu_blo['bloque']][] = $usu_blo;
                        }
                        //echo "este es el valor";
                        //pr($dato_ub);
                        foreach ($dato_ub as $keyb_r => $valueb_r) {//Recorre roles 
                            foreach ($valueb_r as $keyb_b => $valueb_b) {//Recorre bloques
                                //pr($valueb_b);
//                                        pr($dato_ub);
                                //echo "fadsf";
                                $role_evaluador = $keyb_r;
                                $bloque_evaluador = $keyb_b; # code...


                                $grupos_ids = NULL;
                                foreach ($valueb_b as $key_data => $value_data) {//Genera cadenas de grupos que pertenecen a un grupo
                                    $grupos_ids .= $value_data['cve_grupo'] . ',';
                                }


                                $datos_user_aeva[] = $this->enc_mod->listado_autoeval(array('bloque_evaluador' => $bloque_evaluador,
                                    'role_evaluado' => $valuerg['rol_evaluado_cve'],
                                    'cur_id' => $idcurso, 'encuesta_cve' => $valuerg['encuesta_cve'],
                                    'evaluador_user_cve' => $valuerg['evaluador_user_cve'],
                                    'role_evaluador' => $role_evaluador, 'eva_tipo' => $valuer['eva_tipo'],
                                    'grupos' => trim($grupos_ids, ','))
                                );


                                //pr($datos_user_aeva);
                                /* if(!is_null($grupos_ids)){
                                  $this->enc_mod->listado_eval_update_grupo(array('conditions'=>'encuesta_cve='.$valuer['encuesta_cve'].' AND
                                  course_cve='.$idcurso.' AND evaluador_rol_id='.$value.' AND evaluado_rol_id='.$role_evaluador,
                                  'fields'=>array('grupos_ids_text'=>trim($grupos_ids, ',')))); //Actualizar grupos
                                  } */
                            }
                        }
//                        pr($this->get_datos_sesion());
                        $this->session->set_userdata('datos_encuesta_usuario', $datos_user_aeva);
//                        $this->session->set_userdata(array('datos_encuesta_usuario' => $datos_user_aeva));
                        //pr($this->session->userdata());
                        /* foreach ($datos_usuario_bloque as $keyb => $valueb) {


                          $role_evaluador = $valueb['cve_rol'];
                          $bloque_evaluador = $valueb['bloque']; # code...


                          $datos_user_aeva[] = $this->enc_mod->listado_eval(array('bloque_evaluador' => $bloque_evaluador,
                          'role_evaluado' => $valuerg['rol_evaluado_cve'],
                          'cur_id' => $idcurso, 'encuesta_cve' => $valuer['encuesta_cve'],
                          'evaluador_user_cve' => $idusuario,
                          'role_evaluador' => $role_evaluador,'eva_tipo' => $valuer['eva_tipo'])
                          );

                          } */
                    }
                } else {//Por usuario
                    //echo "entra3";      
                    //echo $valuer['encuesta_cve'];   //por usuario
                    //echo $value;
                    $datos_user_aeva[] = $this->enc_mod->listado_autoeval(array('role_evaluado' => $valuerg['rol_evaluado_cve'],
                        'cur_id' => $idcurso, 'encuesta_cve' => $valuerg['encuesta_cve'],
                        'evaluador_user_cve' => $valuerg['evaluador_user_cve'], 'role_evaluador' => $valuerg['rol_evaluador_cve'])
                    );
                }


                # code...
                //$listado_evaluadorgral=$this->enc_mod->listado_evagral(array('role_evaluado' => $valuerg['rol_evaluado_cve'],
                // 'cur_id' => $idcurso));
                //pr($listado_evaluadorgral);
                //array_push($datos_user_aeva,array($listado_evaluadorgral));
                //pr($datos_user_aeva);
                //pr($datos_user_aeva['listado_evaluadorgral']);
                /* if (isset($datos_user_aeva)) {
                  echo "tiene".$keyrg;
                  var_dump($datos_user_aeva);
                  } */
            }

            //array_push($datos_user_aeva,array($listado_evaluadorgral));

            if (isset($datos_user_aeva)) {
                //echo "tiene";
                $datos['datos_user_aeva'] = $datos_user_aeva;
            }
        }

        //}
        //pr($datos_user_aeva);
        # code...
        //}
        //pr('--------------------------------------------------------------------');
        //pr($datos_user_aeva);
        //pr($datos['datos_user_aeva']);
        $datos['datos_curso'] = $datos_curso;
        //$datos['datos_usuario']=$datos_usuario;
        //$datos['datos_user_aeva'];
        //pr( $datos);
        $datos['iduevaluador'] = $idusuario;


        $datos_usuario_evaluador = $this->enc_mod->get_datos_usuarios_gral(array('user_id' => $idusuario));

        $nombreevaluador = $datos_usuario_evaluador[0]['nombres'] . ' ' . $datos_usuario_evaluador[0]['apellidos'];
        $datos['nombreevaluador'] = $nombreevaluador;

        $main_contet = $this->load->view('encuesta/lista_usuarios_autoevaluados', $datos, true);
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

//}
    //}

    /**
     * @author HPTZ
     * @param 
     */
    public function guardar_autoevaluacion() {
        if ($this->input->is_ajax_request()) {//Si es un ajax
            $datos_post = $this->input->post(null, true);
            if ($datos_post) {
                //pr($datos_post['evaluador']);
                $result_guardar_autoevaluacion = $this->enc_mod->guardaract_autoevaluacion($datos_post);


                //echo $this->load->view($configuracion_formularios_actividad_docente['vista'], $data_actividad_doc, TRUE); //Carga la vista correspondiente al index
            }
        }
    }

}
