<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_model extends CI_Model {

    const
            GF_EVALUADO = 'evaluado',
            GF_EVALUADO_DETALLE = 'evaluado_detalle',
            GF_EVALUADO_P = 'evaluado_p',
            GF_EVALUADO_IMP = 'evaluado_implementacion',
            GF_ENCUESTA_IMP = 'encuesta_implementacion',
            GF_EVALUADOR = 'evaluador',
            GF_EVALUADOR_DETALLE = 'evaluador_detalle',
            GF_ENCUESTA = 'encuesta',
            GF_ENCUESTA_DETALLE = 'encuesta_detalle',
            GF_CURSO = 'curso',
            GF_CURSO_DETALLE = 'curso_detalle',
            GF_GENERAL = 'general',
            GF_GENERAL_CNCE = 'general_enc_connoc',
            GF_BLOQUES_CURSO = 'filter_matriz_bloques',
            GF_ENCUESTA_CONTESTADAS = 'encuestas_filtro_contestadas',
            GF_EVALUADOR_CONTESTADAS = 'evaluador_contestadas',
            GF_REPORTE_GENERAL = 'reporte_general'

    ;

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->config->load('general');
        $this->load->database();
    }

    /**
     * @access   public
     * @param    array[optional] (params=>)
     * @return   array (total=>total de registros, columns=>nombres de los campos, data=>campos)
     *
     */
    public function usuarios_curso_grupo($id_curso, $id_grupo) {
        $resultado = array();

        $guarda_busqueda = false;

        //pr($id_grupo);exit();

        $cols_reporte = array(
            'mdl_user.id AS userid',
            'mdl_user.username',
            'mdl_user.nom',
            'mdl_user.pat',
            'mdl_user.mat',
            'mdl_role.id AS roleid',
            'mdl_role.name as role',
            'mdl_course_config.tutorizado',
            //'mdl_course_config.curso_alcance',
            'mdl_course.fullname',
            'mdl_course.shortname as clave_curso',
            'mdl_course.tipocur',
            'to_timestamp(mdl_course.startdate) as fecha_inicio',
            'mdl_course.horascur',
            'mdl_groups.name',
            'mdl_groups.id'
        );
        $this->db->where(array('mdl_course.id' => $id_curso, 'mdl_groups_members.groupid' => $id_grupo));
        $this->db->where_in('mdl_role.id', array(14, 18, 32, 33));
        $this->db->join('public.mdl_context', 'mdl_context.instanceid = mdl_course.id');
        $this->db->join('public.mdl_role_assignments', 'mdl_context.id = mdl_role_assignments.contextid');
        $this->db->join('public.mdl_role', 'mdl_role.id = mdl_role_assignments.roleid');
        $this->db->join('public.mdl_user', 'mdl_user.id = mdl_role_assignments.userid');
        $this->db->join('public.mdl_course_config', 'mdl_course_config.course = mdl_course.id');
        $this->db->join('public.mdl_groups_members', 'mdl_groups_members.userid=mdl_user.id', 'left');
        $this->db->join('public.mdl_groups', 'mdl_groups_members.groupid=mdl_groups.id', 'left');
        $this->db->order_by('roleid', 'ASC');
        $this->db->select($cols_reporte);
        $query = $this->db->get('public.mdl_course');
        //$resultado['total']=$num_rows[0]->total;
        //pr($this->db->last_query());
        $resultado['columns'] = $query->list_fields();
        $resultado['data'] = $query->result_array();

        return $resultado;

        /*
          SELECT
          us.id AS userid,
          us.username,
          us.nom,
          us.pat,
          us.mat,
          ro.id AS roleid,
          ro.name as role,
          curcnf.tutorizado,
          curcnf.curso_alcance,
          cur.fullname,
          cur.shortname as clave_curso,
          cur.tipocur,
          to_timestamp(cur.startdate) as fecha_inicio,
          cur.horascur
          FROM mdl_course cur
          INNER JOIN mdl_context ctx ON ctx.instanceid = cur.id
          INNER JOIN mdl_role_assignments ra ON ctx.id = ra.contextid
          INNER JOIN mdl_role ro ON ro.id = ra.roleid
          INNER JOIN mdl_user us ON us.id = ra.userid
          INNER JOIN mdl_course_config curcnf ON curcnf.course = cur.id
          LEFT JOIN public.mdl_groups_members gpmb ON gpmb.userid=us.id
          WHERE  cur.id=823 AND ro.id IN (14,18,32,33) AND gpmb.groupid=12367 --
          ORDER BY roleid ASC;
         */
    }

    public function reporte_usuarios($params = null) {
        $resultado = array();

        ///////////////////// Iniciar almacenado de parámetros en cache /////////////////////////
        $this->db->start_cache();
        $this->db->select('mdl_user.id');

        if (isset($params['text_buscar_docente_evaluado']) && !empty($params['text_buscar_docente_evaluado'])) {
            if (isset($params['tipo_buscar_docente_evaluado']) && $params['tipo_buscar_docente_evaluado'] == 'matriculado') {
                $this->db->where("mdl_user.username like '%" . $params['text_buscar_docente_evaluado'] . "%'");
            } else {
                $this->db->where("lower(mdl_user.nom) like lower('%" . $params['text_buscar_docente_evaluado'] . "%') OR lower(mdl_user.pat) like lower('%" . $params['text_buscar_docente_evaluado'] . "%') OR lower(mdl_user.mat) like lower('%" . $params['text_buscar_docente_evaluado'] . "%')");
            }
        }
        if (isset($params['rol_evaluado']) && !empty($params['rol_evaluado'])) {
            //$guarda_busqueda = true;
            $this->db->where('mdl_role.id', $params['rol_evaluado']);
        }
        if (isset($params['anio']) && !empty($params['anio'])) {
            //$guarda_busqueda = true;
            $this->db->where("TO_CHAR(TO_TIMESTAMP(mdl_course.startdate),'YYYY')='" . $params['anio'] . "'");
        }/**/

        //pr($params);
        $this->db->join('public.mdl_role_assignments', 'mdl_role_assignments.userid=mdl_user.id');
        $this->db->join('public.mdl_role', 'mdl_role.id=mdl_role_assignments.roleid AND mdl_role.id IN (14,18,32,33,30)');
        $this->db->join('public.mdl_context', 'mdl_context.id=mdl_role_assignments.contextid');
        $this->db->join('public.mdl_course', 'mdl_context.instanceid=mdl_course.id');
        $this->db->join('public.mdl_course_config', 'mdl_course_config.course=mdl_course.id');
        //$this->db->group_by("mdl_user.id");

        $this->db->stop_cache();
        /////////////////////// Fin almacenado de parámetros en cache ///////////////////////////
        ///////////////////////////// Obtener número de registros ///////////////////////////////
        $nr = $this->db->get_compiled_select('mdl_user'); //Obtener el total de registros
        $num_rows = $this->db->query("SELECT count(*) AS total FROM (" . $nr . ") AS temp")->result();
        //pr($this->db1->last_query());
        /////////////////////////////// FIN número de registros /////////////////////////////////
        $busqueda = array(
            "mdl_user.id",
            "mdl_user.username AS emp_matricula",
            "mdl_course.id AS cur_id",
            "mdl_user.nom AS emp_nombre",
            "mdl_user.pat AS emp_paterno",
            "mdl_user.mat AS emp_materno",
            "mdl_user.curp AS emp_curp",
            "mdl_course.shortname AS cur_clave",
            "mdl_course.fullname AS cur_nom_completo",
            "TO_CHAR(TO_TIMESTAMP(mdl_course.startdate),'YYYY-mm-dd') AS fecha_inicio",
//            "TO_TIMESTAMP(mdl_course.startdate) AS fecha_inicio",
            "mdl_course_config.horascur",
            "mdl_course_config.lastdate AS fecha_fin",
            "mdl_role.id AS rol_id",
            "mdl_course_config.tutorizado",
            //"mdl_course_config.curso_alcance", 
            "mdl_role.name AS rol_nom",
            'CASE mdl_course_config.tipocur 
                            WHEN 0 THEN 
                                CASE SUBSTRING(mdl_course.shortname from \'%#\"GPC#\"%\' FOR \'#\')  
                                    WHEN \'GPC\' THEN \'CURSO BASADO EN GPC\' 
                                    ELSE \'CURSO\' 
                                END
                            WHEN 1 THEN \'DIPLOMADO\' 
                            ELSE \'ERROR\'  
                        END tipo_curso',
            "mdl_course_config.tipocur"
        );


        $this->db->select($busqueda);
        if (isset($params['order']) && !empty($params['order'])) {
            $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
            $this->db->order_by($params['order'], $tipo_orden);
        }
        if (isset($params['per_page']) && isset($params['current_row'])) { //Establecer límite definido para paginación 
            $this->db->limit($params['per_page'], $params['current_row']);
        }
        $query = $this->db->get('mdl_user'); //Obtener conjunto de registros
//        pr($this->db->last_query());
        $resultado['total'] = $num_rows[0]->total;
        $resultado['columns'] = $query->list_fields();
        $resultado['data'] = $query->result_array();
        //pr($resultado['data']);
        $this->db->flush_cache();
        $query->free_result(); //Libera la memoria         

        return $resultado;
    }

    public function reporte_usuarios_vista_cursos($params = null) {
        $resultado = array();
        $where_array = array(
            'matriculado' => 'upper(muser.username)',
            'namedocentedo' => "upper(concat(muser.nom, ' ', muser.pat, ' ', muser.mat))",
            'rol_evaluado' => 'mr.id',
            'anio' => 'vdc.anio',
//            $this->db->like('upper(shortname)', strtoupper($text));
        );

//        pr($params);
//        exit();
        ///////////////////// Iniciar almacenado de parámetros en cache /////////////////////////
        $this->db->start_cache();

        if (isset($params['rol_evaluado']) && !empty(trim($params['rol_evaluado']))) {
            //$guarda_busqueda = true;
            $this->db->where($where_array['rol_evaluado'], $params['rol_evaluado']);
        }
        if (isset($params['text_buscar_docente_evaluado']) && !empty(trim($params['text_buscar_docente_evaluado']))) {
            //$guarda_busqueda = true;
            $this->db->like($where_array[$params['tipo_buscar_docente_evaluado']], strtoupper($params['text_buscar_docente_evaluado']));
        }

        if (isset($params['anio']) && !empty($params['anio'])) {
            //$guarda_busqueda = true;
            $this->db->where($where_array['anio'], $params['anio']);
        }/**/

        //pr($params);
        $this->db->join('public.mdl_role_assignments mras', 'mras.userid=muser.id');
        $this->db->join('public.mdl_role mr', 'mr.id=mras.roleid AND mr.id IN (14,18,32,33,30)');
        $this->db->join('public.mdl_context mct', 'mct.id=mras.contextid');
        $this->db->join('encuestas.view_datos_curso vdc', 'vdc.idc = mct.instanceid');
        //$this->db->group_by("mdl_user.id");

        $this->db->stop_cache();
        /////////////////////// Fin almacenado de parámetros en cache ///////////////////////////
        ///////////////////////////// Obtener número de registros ///////////////////////////////
        $nr = $this->db->get_compiled_select('public.mdl_user muser'); //Obtener el total de registros
        $num_rows = $this->db->query("SELECT count(*) AS total FROM (" . $nr . ") AS temp")->result();
        //pr($this->db1->last_query());
        /////////////////////////////// FIN número de registros /////////////////////////////////
        $busqueda = array(
            'muser.id', 'muser.username AS emp_matricula',
            'vdc.idc AS cur_id',
            "concat(muser.nom, ' ', muser.pat, ' ', muser.mat) AS emp_nombre",
            'muser.curp AS emp_curp',
            'vdc.clave AS cur_clave',
            'vdc.namec AS cur_nom_completo',
            'vdc.fecha_inicio',
            'vdc.horascur',
            'vdc.anio',
            'vdc.fecha_fin AS fecha_fin',
            'mr.id AS rol_id',
            'mr."name" AS rol_nom',
            'vdc.tutorizado',
            'vdc.tex_tutorizado',
            'vdc.tipo_curso_id',
            'vdc.tipo_curso',
            'vdc.alcance_curso',
            'vdc.puntaje_duracion',
            'vdc.horascur'
        );


        $this->db->select($busqueda);
        if (isset($params['order']) && !empty($params['order'])) {
            $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
            $this->db->order_by($params['order'], $tipo_orden);
        }
        if (isset($params['per_page']) && isset($params['current_row'])) { //Establecer límite definido para paginación 
            $this->db->limit($params['per_page'], $params['current_row']);
        }
        $query = $this->db->get('public.mdl_user muser'); //Obtener conjunto de registros
//        pr($this->db->last_query());
        $resultado['total'] = $num_rows[0]->total;
        $resultado['columns'] = $query->list_fields();
        $resultado['data'] = $query->result_array();
        //pr($resultado['data']);
        $this->db->flush_cache();
        $query->free_result(); //Libera la memoria         

        return $resultado;
    }

    public function listado_usuariosenc($params = null) {
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

        $this->db->where('c.id', $params['curso_id']);
        $this->db->where_not_in('r.id', 11);
        $this->db->where_not_in('r.id', 19);
        $this->db->where_not_in('r.id', 29);
        $this->db->where_not_in('r.id', 34);

        if (isset($params['role_id']) and $params['role_id'] == 5) {
            $this->db->where_not_in('r.id', $params['role_id']);
        }

        $this->db->join('public.mdl_role_assignments ra', 'ra.userid = u.id');
        $this->db->join('public.mdl_context ct', 'ct.id = ra.contextid');
        $this->db->join('public.mdl_course c', 'c.id = ct.instanceid');
        $this->db->join('public.mdl_role r', 'r.id = ra.roleid');
        $this->db->join('public.mdl_enrol en', 'en.courseid = c.id');
        $this->db->join('public.mdl_user_enrolments ue', 'ue.enrolid = en.id AND ue.userid = u.id');

        $busqueda = array(
            'c.id AS cve_curso',
            'u.id AS cve_usuario',
            'u.username AS username',
            'u.firstname AS nombres',
            'u.lastname AS apellidos',
            'u.cve_departamental AS cve_ads',
            'ra.roleid as rol');

        $this->db->select($busqueda);


        $query = $this->db->get('public.mdl_user u');
        $resultado = $query->result_array();

        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function listado_eval_reporte($params = null) {
        $this->db->where('tutorias.mdl_userexp.cursoid', $params['cur_id']);


        if (isset($params['gpo_evaluador']) && !empty($params['gpo_evaluador'])) {


            $this->db->where('tutorias.mdl_userexp.cursoid', $params['cur_id']);
            //$this->db->where('tutorias.mdl_userexp.role',$params['role_evaluado']);
            $this->db->where('tutorias.mdl_userexp.grupoid', $params['gpo_evaluador']);

            $this->db->where('tutorias.mdl_userexp.role', $params['role_evaluado']);

            $this->db->select('public.mdl_user.firstname,public.mdl_user.lastname,public.mdl_role.name as role, public.mdl_groups.name as ngpo, 
                (select public.mdl_role.name from public.mdl_role where id=' . $params['role_evaluador'] . ') as evaluador,' .
                    $params['encuesta_cve'] . ' as regla, public.mdl_groups.id as gpoid, tutorias.mdl_userexp.cursoid as cursoid, public.mdl_user.id as userid,
                (select evaluacion_resul_cve from encuestas.sse_result_evaluacion where encuesta_cve=' . $params['encuesta_cve'] . ' and course_cve=' . $params['cur_id'] . ' and group_id=' . $params['gpo_evaluador'] . ' 
                    and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=' . $params['evaluador_user_cve'] . ')  as realizado');

            $this->db->join('public.mdl_user', 'public.mdl_user.id= tutorias.mdl_userexp.userid');
            $this->db->join('public.mdl_role', 'public.mdl_role.id= tutorias.mdl_userexp.role');
            $this->db->join('public.mdl_groups', 'public.mdl_groups.id=tutorias.mdl_userexp.grupoid');
        } else {


            $params['gpo_evaluador'] = 0;
            $consulta = 'public.mdl_user.firstname,public.mdl_user.lastname,public.mdl_role.name as role,' . $params['gpo_evaluador'] . ' as ngpo,
              (select public.mdl_role.name from public.mdl_role where id=' . $params['role_evaluador'] . ') as evaluador,' .
                    $params['encuesta_cve'] . ' as regla, tutorias.mdl_userexp.cursoid as cursoid, public.mdl_user.id as userid,
                    (select evaluacion_resul_cve from encuestas.sse_result_evaluacion where encuesta_cve=' . $params['encuesta_cve'] . ' and course_cve=' . $params['cur_id'] . ' 
                        and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=' . $params['evaluador_user_cve'] . ')  as realizado';




            $this->db->distinct($consulta);
            $this->db->select($consulta);

            $this->db->where('tutorias.mdl_userexp.role', $params['role_evaluado']);


            $this->db->join('public.mdl_user', 'public.mdl_user.id= tutorias.mdl_userexp.userid');
            $this->db->join('public.mdl_role', 'public.mdl_role.id= tutorias.mdl_userexp.role');
        }

        $query = $this->db->get('tutorias.mdl_userexp');

        $resultado = $query->result_array();
        return $resultado;
    }

    public function listado_evaluados($params = null) {

        $resultado = array();
        $this->db->where('tutorias.mdl_userexp.cursoid', $params['cur_id']);


        if (isset($params['gpo_evaluador']) && !empty($params['gpo_evaluador'])) {


            $this->db->where('tutorias.mdl_userexp.cursoid', $params['cur_id']);
            //$this->db->where('tutorias.mdl_userexp.role',$params['role_evaluado']);
            $this->db->where('tutorias.mdl_userexp.grupoid', $params['gpo_evaluador']);

            $this->db->where('tutorias.mdl_userexp.role', $params['role_evaluado']);

            $this->db->select('public.mdl_user.firstname,public.mdl_user.lastname,public.mdl_role.name as role, public.mdl_groups.name as ngpo, 
                (select public.mdl_role.name from public.mdl_role where id=' . $params['role_evaluador'] . ') as evaluador,' .
                    $params['encuesta_cve'] . ' as regla, public.mdl_groups.id as gpoid, tutorias.mdl_userexp.cursoid as cursoid, public.mdl_user.id as userid,
                (select evaluacion_resul_cve from encuestas.sse_result_evaluacion where encuesta_cve=' . $params['encuesta_cve'] . ' and course_cve=' . $params['cur_id'] . ' and group_id=' . $params['gpo_evaluador'] . ' 
                    and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=' . $params['evaluador_user_cve'] . ')  as realizado');

            $this->db->join('public.mdl_user', 'public.mdl_user.id= tutorias.mdl_userexp.userid');
            $this->db->join('public.mdl_role', 'public.mdl_role.id= tutorias.mdl_userexp.role');
            $this->db->join('public.mdl_groups', 'public.mdl_groups.id=tutorias.mdl_userexp.grupoid');
        } else {


            $params['gpo_evaluador'] = 0;
            $consulta = 'public.mdl_user.firstname,public.mdl_user.lastname,public.mdl_role.name as role,' . $params['gpo_evaluador'] . ' as ngpo,
              (select public.mdl_role.name from public.mdl_role where id=' . $params['role_evaluador'] . ') as evaluador,' .
                    $params['encuesta_cve'] . ' as regla, tutorias.mdl_userexp.cursoid as cursoid, public.mdl_user.id as userid,
                    (select evaluacion_resul_cve from encuestas.sse_result_evaluacion where encuesta_cve=' . $params['encuesta_cve'] . ' and course_cve=' . $params['cur_id'] . ' 
                        and evaluado_user_cve=public.mdl_user.id and evaluador_user_cve=' . $params['evaluador_user_cve'] . ')  as realizado';




            $this->db->distinct($consulta);
            $this->db->select($consulta);

            $this->db->where('tutorias.mdl_userexp.role', $params['role_evaluado']);


            $this->db->join('public.mdl_user', 'public.mdl_user.id= tutorias.mdl_userexp.userid');
            $this->db->join('public.mdl_role', 'public.mdl_role.id= tutorias.mdl_userexp.role');
        }




        //$this->db->select($busqueda);
        if (isset($params['filtros']['order']) && !empty($params['filtros']['order'])) {
            $tipo_orden = (isset($params['filtros']['order_type']) && !empty($params['filtros']['order_type'])) ? $params['filtros']['order_type'] : "ASC";
            $this->db->order_by($params['filtros']['order'], $tipo_orden);
        }

//        pr($params['filtros']);
        if (isset($params['filtros']['per_page']) && isset($params['filtros']['current_row'])) { //Establecer límite definido para paginación 
            $this->db->limit($params['filtros']['per_page'], $params['filtros']['current_row']);
        }

        $query = $this->db->get('tutorias.mdl_userexp');

        //$resultado['total']=$query->num_rows();
        //$resultado['columns']=$query->list_fields();


        $resultado = $query->result_array();
        return $resultado;
    }

    public function get_anios() {
        $this->db->select('distinct(fecha)');

        $this->db->order_by('fecha', 'desc');

        $query = $this->db->get('encuestas.sse_evaluacion');

        //pr($this->db->last_query());
        return $query->result_array();
    }

    public function get_filtros_generales_reportes() {
        $rol = $this->config->item('rol_docente');
        $tipo_course = $this->config->item('tipo_curso_DCG');
        $temp_grupo = array('GUANAJUATO', 'AGUASCALIENTES', 'MICHOACAN', 'MORELOS', 'NUEVO LEON 1', 'NUEVO LEON 2', 'PUEBLA');
        $del_umae = $this->get_general_catalogos(array('from' => 'departments.ssd_cat_delegacion', 'select' => array('nom_delegacion', 'cve_delegacion')));
        $result = array(
            'tipo_encuesta' => array(1 => 'Satisfacción', 0 => 'Desempeño'),
            'anios' => $this->get_listado_anios(2009),
            'rol' => dropdown_options($rol, 'rol_id', 'rol_nom'),
            'rol_evaluado' => dropdown_options($rol, 'rol_id', 'rol_nom'),
            'rol_evaluador' => dropdown_options($rol, 'rol_id', 'rol_nom'),
            'ordenar_por' => array(
                'emp_matricula' => 'Matrícula', 'emp_nombre' => 'Nombre del evaluado',
                'cur_clave' => 'Clave curso', 'cur_nom_completo' => 'Nombre curso',
                'fecha_inicio' => 'Fecha inicio', 'rol_nom' => 'Rol evaluado', 'rol_nom' => 'Rol evaluado',
                'rol_nom_edor' => 'Rol evaluador'),
            'order_by' => array('ASC' => 'Ascendente', 'DESC' => 'Descendente'),
            'order_columns' => array('emp_matricula' => 'Matrícula', 'cve_depto_adscripcion' => 'Adscripción', 'cat_nombre' => 'Categoría', 'grup_nom' => 'BD'),
            'delg_umae' => dropdown_options($del_umae, 'cve_delegacion', 'nom_delegacion'),
            'umae' => dropdown_options($this->get_lista_umae(), 'cve_depto_adscripcion', 'nom_dependencia'),
            'instrumento' => $this->get_lista_roles_regla_evaluacion(),
            'buscar_por' => array('clavecurso' => 'Clave instrumento', 'nombrecurso' => 'Nombre instrumento'),
            'buscar_categoria' => array('categoria' => 'Categoría'),
            'buscar_adscripcion' => array('claveadscripcion' => 'Clave departamental'/* , 'nameadscripcion' => 'Nombre departamento' */),
            'buscar_instrumento' => array('clavecurso' => 'Clave instrumento', 'nombrecurso' => 'Nombre instrumento'),
            'buscar_docente_evaluado' => array('matriculado' => 'Matricula', 'namedocentedo' => 'Nombre docente'),
            'grupos_p' => $temp_grupo,
            'bloques_p' => array(1 => 'Bloque 1', 2 => 'Bloque 2', 3 => 'Bloque 3', 4 => 'Bloque 4', 5 => 'Bloque 5'),
            'is_bono_p' => array(1 => 'Para bono', 0 => 'No es para bono'),
            'tipo_implementacion' => array(1 => 'Tutorizado', 0 => 'No tutorizado'),
            'tipo_course' => $tipo_course,
//            'region' => array(1 => 'Noroccidente', 2 => 'Noreste', 3 => 'Centro', 4 => 'Centro sureste'),
        );
        return $result;
    }

    public function get_filtros_grupo($array_grupos, $condiciones = null) {
//        pr($condiciones);
        $grupos_info = $this->getDatosPorGrupo();
        $key_datos = array();
        foreach ($array_grupos as $value) {
            $key_datos = array_merge($key_datos, $grupos_info[$value]); //Junta array
        }
        $key_datos = array_unique($key_datos); //Quita valores duplicados
        $result = array();
//        if (!is_null($condiciones)) {
        foreach ($key_datos as $value) {
            $result[$value] = $this->getCatalogoInfoReportes($value, $condiciones); //Obtiene el valor de los datos
        }
//        }
//        pr($result);
        return $result;
    }

    private function getCatalogoInfoReportes($key_dato, $condiciones) {
        switch ($key_dato) {
            case'tipo_encuesta':return array(1 => 'Desempeño', 0 => 'Satisfacción');
            case 'anios': return $this->get_listado_anios(2009);
            case 'rol':
                $rol = $this->config->item('rol_docente');
                return dropdown_options($rol, 'rol_id', 'rol_nom');
            case 'rol_evaluado':
                $rol = $this->config->item('rol_docente');
                return dropdown_options($rol, 'rol_id', 'rol_nom');
            case 'rol_evaluador':
                //$rol = $this->config->item('rol_docente');
                $rol = array_merge($this->config->item('rol_alumno'), $this->config->item('rol_docente'));
                return dropdown_options($rol, 'rol_id', 'rol_nom');
            case 'region':
                $region = $this->get_general_catalogos(array('from' => 'departments.ssd_regiones', 'select' => array('name_region', 'cve_regiones')));
                return dropdown_options($region, 'cve_regiones', 'name_region');
            case 'umae':
                return dropdown_options($this->get_lista_umae(), 'cve_depto_adscripcion', 'nom_dependencia');
            case 'ordenar_por': return array(
                    'nombre' => 'Nombre',
                    'nrolevaluador' => 'Rol evaluador',
                    'nrolevaluado' => 'Rol evaluado',
                    'ngrupo' => 'Grupo');
            case 'ordenar_por_puntos': return array(
                    'muser.username' => 'Matrícula', 'muser.nom' => 'Nombre del evaluado',
                    'vdc.clave' => 'Clave curso', 'vdc.namec' => 'Nombre curso',
                    'vdc.fecha_inicio' => 'Año', 'mr.id' => 'Rol evaluado',
                );
            case 'ordenar_detalle_por': return array(
                    'descripcion_encuestas' => 'Encuesta',
                    'nrolevaluador' => 'Rol evaluador',
                    'nrolevaluado' => 'Rol evaluado',
                    'ngrupo' => 'Grupo');
            case 'ordenar_general': return array(
                    'namec' => 'Nombre de implementación',
                    'clave' => 'Clave de implementación',
                    'tutorizado' => 'Tipo de implementación',
                    'is_bono' => 'Aplica para bono');
            case 'order_by': return array('ASC' => 'Ascendente', 'DESC' => 'Descendente');
            case 'order_columns': return array('emp_matricula' => 'Matrícula',
                    'cve_depto_adscripcion' => 'Adscripción',
                    'cat_nombre' => 'Categoría', 'grup_nom' => 'BD');
            case 'delg_umae':
                $del_umae = $this->get_general_catalogos(array('from' => 'departments.ssd_cat_delegacion', 'select' => array('nom_delegacion', 'cve_delegacion')));
                return dropdown_options($del_umae, 'cve_delegacion', 'nom_delegacion');
            case 'delegacion':
                $delegacion = $this->get_general_catalogos(array('from' => 'departments.ssd_cat_delegacion', 'select' => array('nom_delegacion', 'cve_delegacion')));
                return dropdown_options($delegacion, 'cve_delegacion', 'nom_delegacion');
            case 'umae':
                $umae = $this->get_general_catalogos(array('from' => 'departments.ssd_cat_dependencia', 'select' => array('cve_depto_adscripcion', 'nom_dependencia'), 'where' => array("is_umae = '1'")));
                return dropdown_options($umae, 'cve_depto_adscripcion', 'nom_dependencia');
            case 'instrumento':
                if (isset($condiciones[$key_dato])) {
                    return $this->get_lista_roles_regla_evaluacion('normal', $condiciones[$key_dato]);
                }
                return $this->get_lista_roles_regla_evaluacion();
            case 'buscar_por': return array('clavecurso' => 'Clave instrumento', 'nombrecurso' => 'Nombre instrumento');
            case 'buscar_categoria': return array('categoria' => 'Categoría');
            case 'buscar_adscripcion': return array('claveadscripcion' => 'Clave departamental'/* , 'nameadscripcion' => 'Nombre departamento' */);
            case 'buscar_instrumento': return array('clavecurso' => 'Clave instrumento', 'nombrecurso' => 'Nombre instrumento');
            case 'buscar_docente_evaluado': return array('matriculado' => 'Matricula', 'namedocentedo' => 'Nombre docente');
            case 'grupos_p':
                $temp_grupo = array('GUANAJUATO', 'AGUASCALIENTES', 'MICHOACAN', 'MORELOS', 'NUEVO LEON 1', 'NUEVO LEON 2', 'PUEBLA');
                return $temp_grupo;
            case 'bloques_p': return array(1 => 'Bloque 1', 2 => 'Bloque 2', 3 => 'Bloque 3', 4 => 'Bloque 4', 5 => 'Bloque 5');
            case 'is_bono_p': return array(1 => 'Si', 0 => 'No');
            case 'is_bloque_o_grupo': return array('' => 'Seleccione agrupamiento', 'bloque' => 'Por bloque', 'grupo' => 'Por grupo');
            case 'tipo_implementacion': return array(1 => 'Tutorizado', 0 => 'No tutorizado');
            case 'tipo_course':
                $tipo_course = $this->config->item('tipo_curso_DCG');
                return $tipo_course;
//            case 'region':
//                return array(1 => 'Noroccidente', 2 => 'Noreste', 3 => 'Centro', 4 => 'Centro sureste');
            case 'enc_con_ncon':
                return array('e_c' => 'Reporte de encuestas contestadas', 'e_nc' => 'Reporte de encuestas no contestadas');
            case 'ordenar_por_con_no_con': return array(
                    'uedo.firstname,uedo.lastname' => 'Nombre del evaluado',
                    'uedor.firstname,uedor.lastname' => 'Nombre del evaluador',
                    'uedo.username' => 'Matrícula del evaluado',
                    'uedor.username' => 'Matrícula del evaluador',
                    'mrdor.id' => 'Rol evaluador',
                    'mrdo.id' => 'Rol evaluado',
                );
            default:
                return array();
        }
    }

    private function getDatosPorGrupo() {
        $array = array(
            Reporte_model::GF_EVALUADO => array('buscar_docente_evaluado', 'rol_evaluado', 'ordenar_por', 'order_by'),
            Reporte_model::GF_EVALUADO_DETALLE => array('buscar_docente_evaluado', 'buscar_categoria', 'rol_evaluado', 'region', 'delg_umae', 'umae', 'buscar_adscripcion', 'order_by'),
            Reporte_model::GF_EVALUADO_P => array('buscar_docente_evaluado', 'rol_evaluado', 'ordenar_por_puntos', 'anios', 'order_by'),
            Reporte_model::GF_EVALUADO_IMP => array('buscar_docente_evaluado', 'rol_evaluado', 'ordenar_por', 'anios', 'order_by', 'region', 'umae', 'delegacion'),
            Reporte_model::GF_ENCUESTA_IMP => array('is_bloque_o_grupo'),
            Reporte_model::GF_EVALUADOR => array('buscar_docente_evaluado', 'rol_evaluador', 'buscar_adscripcion', 'ordenar_por', 'order_by'),
            Reporte_model::GF_EVALUADOR_DETALLE => array('buscar_docente_evaluado', 'buscar_categoria', 'rol_evaluador', 'region', 'delg_umae', 'umae', 'buscar_adscripcion', 'order_by'),
            Reporte_model::GF_ENCUESTA => array('tipo_encuesta', 'instrumento', 'grupos_p', 'bloques_p', 'ordenar_por', 'order_by'),
            Reporte_model::GF_ENCUESTA_DETALLE => array('tipo_encuesta', 'instrumento', 'grupos_p', 'is_bono_p', 'bloques_p', 'order_by'),
            Reporte_model::GF_CURSO => array('buscar_instrumento', 'anios', 'tipo_implementacion', 'is_bono_p', 'ordenar_por', 'order_by'),
            Reporte_model::GF_CURSO_DETALLE => array('buscar_instrumento', 'anios', 'tipo_implementacion', 'order_by'),
            Reporte_model::GF_GENERAL => array('ordenar_detalle_por'),
            Reporte_model::GF_REPORTE_GENERAL => array('ordenar_general'),
            Reporte_model::GF_GENERAL_CNCE => array('order_by', /* 'is_bloque_o_grupo' */),
            Reporte_model::GF_BLOQUES_CURSO => array('order_by'),
            Reporte_model::GF_ENCUESTA_CONTESTADAS => array('enc_con_ncon', /*'instrumento'*/),
            Reporte_model::GF_EVALUADOR_CONTESTADAS => array('buscar_docente_evaluado', 'buscar_categoria', 'rol_evaluador', 'region', 'delg_umae', 'umae', 'order_by'),
        );
        return $array;
    }

    /**
     * 
     * @return string Listado de reglas de evaluación por roles
     * 
     */
    public function get_lista_roles_regla_evaluacion($tipo = 'normal', $all = '*') {

        $roles_prop = $this->config->item('prop_roles');
//        pr($roles_prop);
        $reglas_db = $this->get_regla_evaluacion_nombre($all);
        $result = array();
        switch ($tipo) {
            case 'normal':
                foreach ($reglas_db as $value) {
                    //pr($value);
                    if (isset($roles_prop[$value['rol_evaluado_cve']])) {
                        $rol_evaluado = $roles_prop[$value['rol_evaluado_cve']]['ab'];
                        $rol_evaluador = $roles_prop[$value['rol_evaluador_cve']]['ab'];
                        $result[$value['reglas_evaluacion_cve']] = $rol_evaluador . ' a ' . $rol_evaluado . ' -' . $value['text_tutorizado'];
                    }
                }
                break;
            case 'roles':
                foreach ($reglas_db as $value) {
                    $rol_evaluado = $roles_prop[$value['rol_evaluado_cve']]['ab'];
                    $rol_evaluador = $roles_prop[$value['rol_evaluador_cve']]['ab'];
                    $result[$value['rol_evaluador_cve'] . '-' . $value['rol_evaluado_cve'] . '-' . $value['tutorizado']] = $rol_evaluador . ' a ' . $rol_evaluado . ' -' . $value['text_tutorizado'];
                }
                break;
        }
        return $result;
    }

    /**
     * 
     * @return string Listado de reglas de evaluación por roles
     * 
     */
    public function get_lista_umae() {
        $this->db->select("cve_depto_adscripcion, nom_dependencia||'('||cve_depto_adscripcion||')' as nom_dependencia");
        $this->db->where("ind_umae=1 and is_umae='1'");
        $this->db->order_by('nom_dependencia', 'asc');
        $query = $this->db->get('departments.ssd_cat_dependencia');

        return $query->result_array();
    }

    /**
     * @return type
     * Obtiene las reglas de evaliación, nombres e identificadores BD
     */
    public function get_regla_evaluacion_nombre($all = '*') {
        $select = array('reg.reglas_evaluacion_cve', 'mrlo."name"', 'reg.rol_evaluado_cve', 'mrlr."name"',
            'reg.rol_evaluador_cve', 'reg.tutorizado',
            "case reg.tutorizado when 1 then 'Tutorizado' when 0 then 'No tutorizado' end as text_tutorizado"
        );
        $this->db->select($select);
        $this->db->join('public.mdl_role mrlo', 'mrlo.id = reg.rol_evaluado_cve');
        $this->db->join('public.mdl_role mrlr', 'mrlr.id = reg.rol_evaluador_cve');
        $this->db->order_by('reg.tutorizado', 'desc');
        $this->db->order_by('reg.rol_evaluador_cve', 'asc');
        //if($all == 'excepcion'){
        if (is_array($all) and ! empty($all)) {//Aplica condición
            foreach ($all as $key_where => $value_where) {
                $this->db->where($key_where, $value_where);
            }
        }
        //}
        $query = $this->db->get('encuestas.sse_reglas_evaluacion reg');
//        pr($all);
//        pr($this->db->last_query());
//        exit();

        return $query->result_array();
    }

    public function get_general_catalogos($parametros) {
        if (isset($parametros['select'])) {
            $this->db->select($parametros['select']);
        }
        if (isset($parametros['where'])) {
            $this->db->where($parametros['where']);
        }
        $query = $this->db->get($parametros['from']);
        return $query->result_array();
    }

    /**
     * 
     * @param type $anio_inicio Año de inicio
     * @param type $anio_fin 'now' indica el año acual 
     * @param type $ascendente 1= asendente, desde "anio_inial" to "anio_final"
     * @return array con anios desde principio a fin y "ascendente" o "descendente"
     */
    public function get_listado_anios($anio_inicio, $anio_fin = 'now', $ascendente = 0) {
        $anios = array();
        if ($anio_fin == 'now') {//Anio actual 
            $anio_fin = intval(date("Y"));
        }
        if ($ascendente == 1) {
            $anios[$anio_inicio] = $anio_inicio;
            while ($anio_inicio != $anio_fin) {
                $anio_inicio ++;
                $anios[$anio_inicio] = $anio_inicio;
            }
        } else {
            $anios[$anio_fin] = $anio_fin;
            while ($anio_inicio != $anio_fin) {
                $anio_fin --;
                $anios[$anio_fin] = $anio_fin;
            }
        }
//        pr($anios);
        return $anios;
    }

    public function get_busca_cursos_nombre($text = '') {
        $select = array('shortname as "curso"', 'id as "idcurso"');
        $this->db->select($select);
        $this->db->like('upper(shortname)', strtoupper($text));
//        $this->db->where('lower(shortname) ~* to_ascii(' . $text . ')');
        $this->db->order_by('shortname', 'asc');
        $this->db->limit(20);
//
        $query = $this->db->get('mdl_course');
        $result = $query->result_array();
        $query->free_result();
//
//        pr($this->db->last_query());
        return $result;
    }

    public function get_busca_bloques_grupos($cursoid = null, $bloqueid = null) {
        if ($bloqueid == null) {
            $this->db->select('bloque');
            $this->db->where('course_cve', $cursoid);
            $this->db->group_by('bloque');
//            $this->db->order_by('bloque', 'asc');
        } else {
            $this->db->select('mdl_groups_cve');
            $this->db->where('course_cve', $cursoid);
            $this->db->where('bloque', $bloqueid);
            $this->db->group_by('mdl_groups_cve');
            $this->db->order_by('mdl_groups_cve', 'asc');
        }
        $query = $this->db->get('encuestas.sse_curso_bloque_grupo');
        $result = $query->result_array();
        $query->free_result();
//        pr($this->db->last_query());
//        pr($result);

        return $result;
    }

}
