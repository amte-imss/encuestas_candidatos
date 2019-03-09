<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_detallado_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->config->load('general');
        //$this->load->database();
    }
    
    /*
    select enc.encuesta_cve, enc.descripcion_encuestas, enc.is_bono, enc.tipo_encuesta, enc.eva_tipo, tex_tutorizado,
        eva.course_cve, curso.namec, curso.clave as curso_clave, curso.tipo_curso, curso.tipo_curso_id, curso.horascur, curso.anio, curso.fecha_inicio, curso.fecha_fin, eva.group_id, grupo.name as curso_nombre, 
        eva.evaluado_user_cve, eva.evaluado_rol_id, rol_evaluado.name as evaluado_rol_nombre, 
            tut_evaluado.cve_departamento as depto_tut_id, depto_tut_evaluado.nom_depto_adscripcion as depto_tut_nombre, depto_tut_evaluado.cve_delegacion as depto_tut_id_del, depto_tut_evaluado.nom_delegacion as depto_tut_nom_del, 
            (select * from departments.get_rama_completa(tut_evaluado.cve_departamento, 7)) as rama_tut_evaluado, 
        tut_evaluado.cve_categoria as evaluado_cat_tut_id, cat_tut_evaluado.nom_nombre as evaluado_cat_tut_nom, 
        eva.evaluador_user_cve, eva.evaluador_rol_id, rol_evaluador.name as evaluador_rol_nombre, 
            tut_evaluador.cve_departamento as depto_e_tut_id, depto_tut_evaluador.nom_depto_adscripcion as depto_e_tut_nombre, depto_tut_evaluador.cve_delegacion as depto_e_tut_id_del, depto_tut_evaluador.nom_delegacion as depto_e_tut_nom_del, 
            (select * from departments.get_rama_completa(tut_evaluador.cve_departamento, 7)) as rama_tut_evaluador,
            prereg_evaluador.cve_departamental as depto_e_pre_id, depto_pre_evaluador.nom_depto_adscripcion as depto_e_pre_nombre, depto_pre_evaluador.cve_delegacion as depto_e_pre_id_del, depto_pre_evaluador.nom_delegacion as depto_e_pre_nom_del, 
            (select * from departments.get_rama_completa(prereg_evaluador.cve_departamental, 7)) as rama_pre_evaluador,
        tut_evaluador.cve_categoria as evaluador_cat_tut_id, cat_tut_evaluador.nom_nombre as evaluador_cat_tut_nom, prereg_evaluador.cve_cat as evaluador_cat_pre_id, cat_pre_evaluador.nom_nombre as evaluador_cat_pre_nom, 
        evaluado.username as evaluado_matricula, evaluado.firstname as evaluado_nombre, evaluado.lastname as evaluado_apellido, evaluador.username as evaluador_matricula, evaluador.firstname as evaluador_nombre, evaluador.lastname as evaluador_apellido,
        enc.reglas_evaluacion_cve
    from encuestas.sse_encuestas enc
    inner join encuestas.sse_evaluacion eva on eva.encuesta_cve=enc.encuesta_cve
    inner join encuestas.view_datos_curso curso on curso.idc=eva.course_cve
    left join encuestas.sse_reglas_evaluacion eva_reg on eva_reg.reglas_evaluacion_cve=enc.reglas_evaluacion_cve
    left join public.mdl_groups grupo ON grupo.id=eva.group_id
    left join public.mdl_user evaluado on evaluado.id=eva.evaluado_user_cve
    left join public.mdl_role rol_evaluado on rol_evaluado.id=eva.evaluado_rol_id
    left join tutorias.mdl_usertutor tut_evaluado on tut_evaluado.nom_usuario=evaluado.username and tut_evaluado.id_curso=eva.course_cve 
        and eva.evaluado_rol_id <> 5
    left join nomina.ssn_categoria cat_tut_evaluado ON cat_tut_evaluado.cve_categoria = tut_evaluado.cve_categoria
    left join departments.ssv_departamentos depto_tut_evaluado ON depto_tut_evaluado.cve_depto_adscripcion=tut_evaluado.cve_departamento  
    left join public.mdl_user evaluador on evaluador.id=eva.evaluador_user_cve
    left join public.mdl_role rol_evaluador on rol_evaluador.id=eva.evaluador_rol_id
    left join gestion.sgp_tab_preregistro_al as prereg_evaluador on prereg_evaluador.nom_usuario=evaluador.username and prereg_evaluador.cve_curso=eva.course_cve 
        and eva.evaluador_rol_id = 5
    left join tutorias.mdl_usertutor as tut_evaluador on tut_evaluador.nom_usuario=evaluador.username and tut_evaluador.id_curso=eva.course_cve 
        and eva.evaluador_rol_id <> 5
    left join nomina.ssn_categoria cat_pre_evaluador ON cat_pre_evaluador.cve_categoria = prereg_evaluador.cve_cat
    left join nomina.ssn_categoria cat_tut_evaluador ON cat_tut_evaluador.cve_categoria = tut_evaluador.cve_categoria
    left join departments.ssv_departamentos depto_pre_evaluador ON depto_pre_evaluador.cve_depto_adscripcion=prereg_evaluador.cve_departamental
    left join departments.ssv_departamentos depto_tut_evaluador ON depto_tut_evaluador.cve_depto_adscripcion=tut_evaluador.cve_departamento
    where eva.course_cve=838
    group by enc.encuesta_cve, enc.descripcion_encuestas, enc.is_bono, enc.reglas_evaluacion_cve, enc.tipo_encuesta, enc.eva_tipo, tex_tutorizado,
        eva.course_cve, curso.namec, curso.clave, curso.tipo_curso, curso.tipo_curso_id, curso.horascur, curso.anio, curso.fecha_inicio, curso.fecha_fin, eva.group_id, grupo.name, 
        eva.evaluado_user_cve, eva.evaluado_rol_id, rol_evaluado.name, tut_evaluado.cve_departamento, 
        tut_evaluado.cve_categoria, cat_tut_evaluado.nom_nombre, depto_tut_evaluado.nom_depto_adscripcion, depto_tut_evaluado.cve_delegacion, depto_tut_evaluado.nom_delegacion,
        eva.evaluador_user_cve, eva.evaluador_rol_id, rol_evaluador.name, 
        tut_evaluador.cve_categoria, cat_tut_evaluador.nom_nombre, prereg_evaluador.cve_cat, cat_pre_evaluador.nom_nombre,
        evaluado.username, evaluado.firstname, evaluado.lastname, evaluador.username, evaluador.firstname, evaluador.lastname, enc.reglas_evaluacion_cve,
        prereg_evaluador.cve_departamental, tut_evaluador.cve_departamento, depto_tut_evaluador.nom_depto_adscripcion, depto_tut_evaluador.cve_delegacion, depto_tut_evaluador.nom_delegacion,
        depto_pre_evaluador.nom_depto_adscripcion, depto_pre_evaluador.cve_delegacion, depto_pre_evaluador.nom_delegacion
    */
    public function reporte_detalle_encuesta($params = null) {
        $resultado = array();

        ///////////////////// Iniciar almacenado de parámetros en cache /////////////////////////
        $this->db->start_cache();
        $this->db->select('enc.encuesta_cve, eva.course_cve, eva.evaluado_rol_id, eva.evaluador_rol_id');

        //tipo_buscar_instrumento:"clavecurso"
        //text_buscar_instrumento:"CES"
        if (isset($params['anio']) && !empty($params['anio'])) { //Año
            $this->db->where("curso.anio='".$params['anio']."'");
        }
        if (isset($params['text_buscar_instrumento']) && !empty($params['text_buscar_instrumento'])) { //Clave o nombre de instrumento
            if($params['tipo_buscar_instrumento']==="clavecurso"){
                $this->db->where("lower(curso.clave) like lower('%".$params['text_buscar_instrumento']."%')");
            } else {
                $this->db->where("lower(curso.namec) like lower('%".$params['text_buscar_instrumento']."%')");
            }
        }
        if (isset($params['tipo_implementacion']) && $params['tipo_implementacion']!="") { //Tipo de implementación
            $this->db->where("curso.tutorizado=".$params['tipo_implementacion']);
        }
        if (isset($params['instrumento_regla']) && !empty($params['instrumento_regla'])) { //Instrumento
            $this->db->where("eva_reg.reglas_evaluacion_cve=".$params['instrumento_regla']);
        }
        if (isset($params['is_bono']) && !empty($params['is_bono'])) { //Aplica para bono
            //$this->db->where("eva_reg.is_bono=".$params['is_bono']);
            $this->db->where("enc.is_bono=".$params['is_bono']);
        }
        if (isset($params['tipo_encuesta']) && !empty($params['tipo_encuesta'])) { //Aplica para bono
            $this->db->where("enc.tipo_encuesta=".$params['tipo_encuesta']);
        }
        if (isset($params['encuesta']) && !empty($params['encuesta'])) { //Encuesta
            $this->db->where("enc.encuesta_cve=".$params['encuesta']);
        }
        if (isset($params['text_buscar_docente_evaluado']) && !empty($params['text_buscar_docente_evaluado'])) { //Clave o nombre de instrumento
            if($params['tipo_buscar_docente_evaluado']==="matriculado"){
                $this->db->where("evaluado.username like '%".$params['text_buscar_docente_evaluado']."%'");
            } else {
                $this->db->where("(lower(evaluado.firstname) like lower('%".$params['text_buscar_docente_evaluado']."%') OR lower(evaluado.lastname) like lower('%".$params['text_buscar_docente_evaluado']."%'))");
            }
        }
        if (isset($params['text_buscar_categoria']) && !empty($params['text_buscar_categoria'])) { //Categoría
            if($params['tipo_buscar_categoria']==="categoria"){
                $this->db->where("(lower(cat_tut_evaluado.des_clave) like lower('%".$params['text_buscar_categoria']."%') OR lower(cat_tut_evaluado.nom_nombre) like lower('%".$params['text_buscar_categoria']."%'))");
            }
        }
        if (isset($params['rol_evaluado']) && !empty($params['rol_evaluado'])) { //Rol del evaluado
            $this->db->where("eva.evaluado_rol_id=".$params['rol_evaluado']);
        }
        if (isset($params['region']) && !empty($params['region'])) { //Región
            $this->db->where("depto_tut_evaluado.cve_regiones=".$params['region']);
        }
        if (isset($params['delg_umae']) && !empty($params['delg_umae']) && $params['delg_umae']!="-1") { //Delegación / UMAE (-1)
            $this->db->where("depto_tut_evaluado.cve_delegacion='".$params['delg_umae']."'");
        }
        if (isset($params['umae']) && !empty($params['umae'])) { //UMAE, listado de adscripción
            $this->db->where("tut_evaluado.cve_departamento='".$params['umae']."'");
        }

        if (isset($params['text_buscar_docente_evaluador']) && !empty($params['text_buscar_docente_evaluador'])) { //Clave o nombre de instrumento
            if($params['tipo_buscar_docente_evaluador']==="matriculado"){
                $this->db->where("(evaluador.username like '%".$params['text_buscar_docente_evaluador']."%' OR usuario_autoevaluacion.username like '%".$params['text_buscar_docente_evaluador']."%' )");
            } else {
                $this->db->where("((lower(evaluador.firstname) like lower('%".$params['text_buscar_docente_evaluador']."%') OR lower(evaluador.lastname) like lower('%".$params['text_buscar_docente_evaluador']."%')) OR"
                        . "(lower(usuario_autoevaluacion.firstname) like lower('%".$params['text_buscar_docente_evaluador']."%') OR lower(usuario_autoevaluacion.lastname) like lower('%".$params['text_buscar_docente_evaluador']."%')))");
            }
        }
        if (isset($params['text_buscar_categoriar']) && !empty($params['text_buscar_categoriar'])) { //Categoría
            if($params['tipo_buscar_categoriar']==="categoria"){
                $this->db->where("((lower(cat_tut_evaluador.des_clave) like lower('%".$params['text_buscar_categoriar']."%') OR lower(cat_tut_evaluador.nom_nombre) like lower('%".$params['text_buscar_categoriar']."%')
                        OR lower(cat_pre_evaluador.des_clave) like lower('%".$params['text_buscar_categoriar']."%') OR lower(cat_pre_evaluador.nom_nombre) like lower('%".$params['text_buscar_categoriar']."%')) OR"
                        . "(lower(cat_tut_autoevaluacion.des_clave) like lower('%".$params['text_buscar_categoriar']."%') OR lower(cat_tut_autoevaluacion.nom_nombre) like lower('%".$params['text_buscar_categoriar']."%')))");
            }
        }
        if (isset($params['rol_evaluador']) && !empty($params['rol_evaluador'])) { //Rol del evaluado
            $this->db->where("(eva.evaluador_rol_id=".$params['rol_evaluador']." OR autoevaluacion.evaluador_rol_id=".$params['rol_evaluador'].")");
        }
        if (isset($params['regionr']) && !empty($params['regionr'])) { //Región
            $this->db->where("(depto_tut_evaluador.cve_regiones=".$params['regionr']." OR depto_pre_evaluador.cve_regiones=".$params['regionr']
                    . " OR depto_tut_autoevaluacion.cve_regiones=".$params['regionr'].")");
        }
        if (isset($params['delg_umaer']) && !empty($params['delg_umaer']) && $params['delg_umaer']!="-1") { //Delegación / UMAE (-1)
            $this->db->where("(depto_tut_evaluador.cve_delegacion='".$params['delg_umaer']."' OR depto_pre_evaluador.cve_delegacion='".$params['delg_umaer']."'"
                    . " OR depto_tut_autoevaluacion.cve_delegacion='".$params['delg_umaer']."')");
        }
        if (isset($params['umaer']) && !empty($params['umaer'])) { //UMAE, listado de adscripción
            $this->db->where("(tut_evaluador.cve_departamento='".$params['umaer']."' OR prereg_evaluador.cve_departamental='".$params['umaer']."'"
                    . " OR tutor_autoevaluacion.cve_departamento='".$params['umaer']."')");
        }

        //pr($params);
        $this->db->join('encuestas.sse_evaluacion eva', 'eva.encuesta_cve=enc.encuesta_cve');
        $this->db->join('encuestas.view_datos_curso curso', 'curso.idc=eva.course_cve');
        $this->db->join('encuestas.sse_result_evaluacion_encuesta_curso res_eva_enc', 'res_eva_enc.encuesta_cve = eva.encuesta_cve and res_eva_enc.course_cve = eva.course_cve and res_eva_enc.evaluado_user_cve = eva.evaluado_user_cve and res_eva_enc.evaluador_user_cve = eva.evaluador_user_cve', 'left');
        $this->db->join('encuestas.sse_curso_bloque_grupo curso_bloque_grupo', 'curso_bloque_grupo.course_cve=res_eva_enc.course_cve and (curso_bloque_grupo.mdl_groups_cve=res_eva_enc.group_id  or curso_bloque_grupo.mdl_groups_cve= ANY (string_to_array(res_eva_enc.grupos_ids_text, \',\')::int[]))', 'left');
        $this->db->join('encuestas.sse_reglas_evaluacion eva_reg', 'eva_reg.reglas_evaluacion_cve=enc.reglas_evaluacion_cve', 'left');
        $this->db->join('public.mdl_groups grupo', 'grupo.id=eva.group_id', 'left');
        $this->db->join('public.mdl_user evaluado', 'evaluado.id=eva.evaluado_user_cve', 'left');
        $this->db->join('public.mdl_role rol_evaluado', 'rol_evaluado.id=eva.evaluado_rol_id', 'left');
        $this->db->join('tutorias.mdl_usertutor tut_evaluado', 'tut_evaluado.nom_usuario=evaluado.username and tut_evaluado.id_curso=eva.course_cve and eva.evaluado_rol_id <> 5', 'left');
        $this->db->join('nomina.ssn_categoria cat_tut_evaluado', 'cat_tut_evaluado.cve_categoria = tut_evaluado.cve_categoria', 'left');
        $this->db->join('departments.ssv_departamentos depto_tut_evaluado', 'depto_tut_evaluado.cve_depto_adscripcion=tut_evaluado.cve_departamento', 'left');
        $this->db->join('public.mdl_user evaluador', 'evaluador.id=eva.evaluador_user_cve', 'left');
        $this->db->join('public.mdl_role rol_evaluador', 'rol_evaluador.id=eva.evaluador_rol_id', 'left');
        $this->db->join('gestion.sgp_tab_preregistro_al as prereg_evaluador', 'prereg_evaluador.nom_usuario=evaluador.username and prereg_evaluador.cve_curso=eva.course_cve and eva.evaluador_rol_id = 5', 'left');
        $this->db->join('tutorias.mdl_usertutor as tut_evaluador', 'tut_evaluador.nom_usuario=evaluador.username and tut_evaluador.id_curso=eva.course_cve and eva.evaluador_rol_id <> 5', 'left');
        $this->db->join('nomina.ssn_categoria cat_pre_evaluador', 'cat_pre_evaluador.cve_categoria = prereg_evaluador.cve_cat', 'left');
        $this->db->join('nomina.ssn_categoria cat_tut_evaluador', 'cat_tut_evaluador.cve_categoria = tut_evaluador.cve_categoria', 'left');
        $this->db->join('departments.ssv_departamentos depto_pre_evaluador', 'depto_pre_evaluador.cve_depto_adscripcion=prereg_evaluador.cve_departamental', 'left');
        $this->db->join('departments.ssv_departamentos depto_tut_evaluador', 'depto_tut_evaluador.cve_depto_adscripcion=tut_evaluador.cve_departamento', 'left');
        ////////////// Se agregan para autoevaluaciones
        $this->db->join('encuestas.sse_designar_autoeveluaciones autoevaluacion', 'autoevaluacion.des_autoevaluacion_cve=eva.des_autoevaluacion_cve', 'left');
        $this->db->join('public.mdl_user usuario_autoevaluacion', 'usuario_autoevaluacion.id=autoevaluacion.evaluador_user_cve', 'left');
        $this->db->join('public.mdl_role rol_autoevaluacion', 'rol_autoevaluacion.id=autoevaluacion.evaluador_rol_id', 'left');
        $this->db->join('tutorias.mdl_usertutor tutor_autoevaluacion', 'tutor_autoevaluacion.nom_usuario=usuario_autoevaluacion.username
                    and tutor_autoevaluacion.id_curso=autoevaluacion.course_cve and autoevaluacion.evaluador_rol_id <> 5', 'left');
        $this->db->join('nomina.ssn_categoria cat_tut_autoevaluacion', 'cat_tut_autoevaluacion.cve_categoria = tutor_autoevaluacion.cve_categoria', 'left');
        $this->db->join('departments.ssv_departamentos depto_tut_autoevaluacion', 'depto_tut_autoevaluacion.cve_depto_adscripcion=tutor_autoevaluacion.cve_departamento', 'left');
        
        $this->db->group_by("enc.encuesta_cve, enc.descripcion_encuestas, enc.is_bono, enc.reglas_evaluacion_cve, curso_bloque_grupo.bloque, enc.tipo_encuesta, enc.eva_tipo, tex_tutorizado,
            eva.course_cve, curso.namec, curso.clave, curso.tipo_curso, curso.tipo_curso_id, curso.horascur, curso.anio, curso.fecha_inicio, curso.fecha_fin, eva.group_id, eva.grupos_ids_text, grupo.name, 
            eva.evaluado_user_cve, eva.evaluado_rol_id, rol_evaluado.name, tut_evaluado.cve_departamento, 
            tut_evaluado.cve_categoria, cat_tut_evaluado.nom_nombre, depto_tut_evaluado.nom_depto_adscripcion, depto_tut_evaluado.cve_regiones, depto_tut_evaluado.name_region, depto_tut_evaluado.cve_delegacion, depto_tut_evaluado.nom_delegacion,
            eva.evaluador_user_cve, eva.evaluador_rol_id, rol_evaluador.name, 
            tut_evaluador.cve_categoria, cat_tut_evaluador.nom_nombre, prereg_evaluador.cve_cat, cat_pre_evaluador.nom_nombre,
            evaluado.username, evaluado.firstname, evaluado.lastname, evaluador.username, evaluador.firstname, evaluador.lastname, enc.reglas_evaluacion_cve,
            prereg_evaluador.cve_departamental, tut_evaluador.cve_departamento, depto_tut_evaluador.nom_depto_adscripcion, depto_tut_evaluador.cve_regiones, depto_tut_evaluador.name_region, depto_tut_evaluador.cve_delegacion, depto_tut_evaluador.nom_delegacion,
            depto_pre_evaluador.nom_depto_adscripcion, depto_pre_evaluador.cve_regiones, depto_pre_evaluador.name_region, depto_pre_evaluador.cve_delegacion, depto_pre_evaluador.nom_delegacion, 
            autoevaluacion.evaluador_user_cve, usuario_autoevaluacion.username, usuario_autoevaluacion.firstname, usuario_autoevaluacion.lastname, autoevaluacion.evaluador_rol_id, rol_autoevaluacion.name, tutor_autoevaluacion.cve_departamento,
            depto_tut_autoevaluacion.nom_depto_adscripcion, depto_tut_autoevaluacion.cve_regiones, depto_tut_autoevaluacion.name_region, depto_tut_autoevaluacion.cve_delegacion, 
            depto_tut_autoevaluacion.nom_delegacion, tutor_autoevaluacion.cve_categoria, cat_tut_autoevaluacion.nom_nombre,
            res_eva_enc.calif_emitida");
        //eva.group_id, grupo.name
        $this->db->stop_cache();
        /////////////////////// Fin almacenado de parámetros en cache ///////////////////////////
        ///////////////////////////// Obtener número de registros ///////////////////////////////
        $nr = $this->db->get_compiled_select('encuestas.sse_encuestas enc'); //Obtener el total de registros
        $num_rows = $this->db->query("SELECT count(*) AS total, array_agg(DISTINCT(encuesta_cve)) as encuestas, array_agg(DISTINCT(encuesta_cve, course_cve, evaluado_rol_id, evaluador_rol_id)) as enc_cur_eva_evar FROM (" . $nr . ") AS temp")->result();
        //pr($this->db->last_query());
        /////////////////////////////// FIN número de registros /////////////////////////////////
        $busqueda = array(
            "enc.encuesta_cve", "enc.descripcion_encuestas", "enc.is_bono", "enc.tipo_encuesta", "enc.eva_tipo", "tex_tutorizado",
            "eva.course_cve", "curso.namec", "curso.clave as curso_clave", "curso.tipo_curso", "curso.tipo_curso_id", "curso.horascur", "curso.anio", "curso.fecha_inicio", "curso.fecha_fin", "eva.grupos_ids_text", "grupo.name as grupo_nombre1", "curso_bloque_grupo.bloque", 
            "eva.evaluado_user_cve", "eva.evaluado_rol_id", "rol_evaluado.name as evaluado_rol_nombre", 
                "tut_evaluado.cve_departamento as depto_tut_id", "depto_tut_evaluado.nom_depto_adscripcion as depto_tut_nombre", "depto_tut_evaluado.cve_regiones as reg_tut_cve", "depto_tut_evaluado.name_region as reg_tut_nombre", "depto_tut_evaluado.cve_delegacion as depto_tut_id_del", "depto_tut_evaluado.nom_delegacion as depto_tut_nom_del", 
                "(select * from departments.get_unidad(tut_evaluado.cve_departamento, 7)) as rama_tut_evaluado", 
            "tut_evaluado.cve_categoria as evaluado_cat_tut_id", "cat_tut_evaluado.nom_nombre as evaluado_cat_tut_nom", 
            "eva.evaluador_user_cve", "eva.evaluador_rol_id", "rol_evaluador.name as evaluador_rol_nombre", 
                "tut_evaluador.cve_departamento as depto_e_tut_id", "depto_tut_evaluador.nom_depto_adscripcion as depto_e_tut_nombre", "depto_tut_evaluador.cve_regiones as reg_tut_eva_cve", "depto_tut_evaluador.name_region as reg_tut_eva_nombre", "depto_tut_evaluador.cve_delegacion as depto_e_tut_id_del", "depto_tut_evaluador.nom_delegacion as depto_e_tut_nom_del", 
                "(select * from departments.get_unidad(tut_evaluador.cve_departamento, 7)) as rama_tut_evaluador",
                "prereg_evaluador.cve_departamental as depto_e_pre_id", "depto_pre_evaluador.nom_depto_adscripcion as depto_e_pre_nombre", "depto_pre_evaluador.cve_regiones as reg_pre_eva_cve", "depto_pre_evaluador.name_region as reg_pre_eva_nombre", "depto_pre_evaluador.cve_delegacion as depto_e_pre_id_del", "depto_pre_evaluador.nom_delegacion as depto_e_pre_nom_del", 
                "(select * from departments.get_unidad(prereg_evaluador.cve_departamental, 7)) as rama_pre_evaluador",
            "tut_evaluador.cve_categoria as evaluador_cat_tut_id", "cat_tut_evaluador.nom_nombre as evaluador_cat_tut_nom", "prereg_evaluador.cve_cat as evaluador_cat_pre_id", "cat_pre_evaluador.nom_nombre as evaluador_cat_pre_nom", 
            "evaluado.username as evaluado_matricula", "evaluado.firstname as evaluado_nombre", "evaluado.lastname as evaluado_apellido", "evaluador.username as evaluador_matricula", "evaluador.firstname as evaluador_nombre", "evaluador.lastname as evaluador_apellido",
            "enc.reglas_evaluacion_cve", "res_eva_enc.calif_emitida", "(select array_agg(DISTINCT(u.firstname||' '||u.lastname||' ('||u.username||')'))
                FROM tutorias.mdl_userexp ue
                JOIN public.mdl_user u ON u.id=ue.userid 
                JOIN public.mdl_role r ON r.id=ue.role 
                JOIN public.mdl_groups g ON g.id=ue.grupoid 
                JOIN public.mdl_course c ON c.id=ue.cursoid
                JOIN encuestas.sse_curso_bloque_grupo cbg ON cbg.mdl_groups_cve=g.id
                WHERE ue.role=18 
                AND (ue.grupoid=eva.group_id or ue.grupoid=ANY (string_to_array(eva.grupos_ids_text, ',')::int[]))
                AND ue.cursoid = eva.course_cve
                ) AS ct_bloque", //GROUP BY u.firstname, u.lastname, u.username
            //"(SELECT array_agg(g.name)::varchar FROM public.mdl_groups g WHERE g.id =ANY(regexp_split_to_array(eva.grupos_ids_text, ',')::bigint[])) AS grupo_nombre",
            "CASE WHEN eva.grupos_ids_text <> '' AND eva.grupos_ids_text IS NOT NULL THEN (SELECT array_agg(g.name)::varchar FROM public.mdl_groups g WHERE g.id =ANY(regexp_split_to_array(eva.grupos_ids_text, ',')::bigint[])) ELSE null END AS grupo_nombre",
            "(SELECT array_agg(g.name)::varchar
                FROM tutorias.mdl_userexp ue
                JOIN public.mdl_user u ON u.id=ue.userid 
                JOIN public.mdl_role r ON r.id=ue.role 
                JOIN public.mdl_groups g ON g.id=ue.grupoid 
                JOIN public.mdl_course c ON c.id=ue.cursoid
                JOIN encuestas.sse_curso_bloque_grupo cbg ON cbg.mdl_groups_cve=g.id
                WHERE ue.cursoid = eva.course_cve AND eva.evaluado_user_cve=ue.userid AND eva.evaluado_rol_id=ue.role
                GROUP BY eva.evaluado_user_cve=ue.userid) as grupo_evaluado",
            ////////////// Se agregan para autoevaluaciones
            "autoevaluacion.evaluador_user_cve as autoeva_user_cve", "usuario_autoevaluacion.username as autoeva_username", "usuario_autoevaluacion.firstname as autoeva_nombre", "usuario_autoevaluacion.lastname as autoeva_apellido", 
            "autoevaluacion.evaluador_rol_id as autoeva_rol_id", "rol_autoevaluacion.name as autoeva_rol_nombre", "tutor_autoevaluacion.cve_departamento as autoeva_cve_departamento",
            "depto_tut_autoevaluacion.nom_depto_adscripcion as autoeva_nom_depto", "depto_tut_autoevaluacion.cve_regiones as autoeva_cve_regiones", 
            "depto_tut_autoevaluacion.name_region as autoeva_name_region", "depto_tut_autoevaluacion.cve_delegacion as autoeva_cve_delegacion", 
            "depto_tut_autoevaluacion.nom_delegacion as autoeva_nom_delegacion", "(select * from departments.get_unidad(tutor_autoevaluacion.cve_departamento, 7)) as rama_tut_autoevaluacion",
            "tutor_autoevaluacion.cve_categoria as autoeva_cve_categoria", "cat_tut_autoevaluacion.nom_nombre as autoeva_cat_nombre"
        ); //"grupo.name as grupo_nombre"
        /* FROM public.mdl_user u
                JOIN public.mdl_role_assignments ra ON ra.userid = u.id
                JOIN public.mdl_context ct ON ct.id = ra.contextid
                JOIN public.mdl_course c ON c.id = ct.instanceid
                JOIN public.mdl_role r ON r.id = ra.roleid
                RIGHT JOIN public.mdl_groups g ON g.courseid = c.id
                RIGHT JOIN public.mdl_groups_members gm ON gm.userid = u.id AND gm.groupid = g.id
                JOIN public.mdl_enrol en ON en.courseid = c.id
                JOIN public.mdl_user_enrolments ue ON ue.enrolid = en.id AND ue.userid = u.id
                where  
                c.id = eva.course_cve and r.id=18 and g.id=eva.group_id*/
        
        $this->db->select($busqueda);
        if (isset($params['order']) && !empty($params['order'])) {
            $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
            $this->db->order_by($params['order'], $tipo_orden);
        }
        if(!isset($params['export']) || (isset($params['export']) && $params['export']==false)) {
            if (isset($params['per_page']) && isset($params['current_row'])) { //Establecer límite definido para paginación 
                $this->db->limit($params['per_page'], $params['current_row']);
            }
        }
        $query = $this->db->get('encuestas.sse_encuestas enc'); //Obtener conjunto de registros        
        
        $this->db->flush_cache();

        //pr($this->db->last_query());
        $resultado['total'] = $num_rows[0]->total;
        $encuestas = 0;
        $enc_cur_eva_evar = array();
        if($resultado['total']>0){
            $encuestas = trim($num_rows[0]->encuestas, '{}');
            $ecee = trim($num_rows[0]->enc_cur_eva_evar, '{"()"}');
            $enc_cur_eva_evar = explode(')","(', $ecee);
            //pr($encuestas);
            //pr($enc_cur_eva_evar);
        }
        //$resultado['columns'] = $query->list_fields();
        $resultado['data'] = $query->result_array();
        $resultado['preguntas'] = $this->reporte_preguntas(array('conditions'=>"encuesta_cve in (".$encuestas.")", 'order'=>'encuesta_cve, seccion_cve, orden'));
        $resultado['respuestas'] = $this->reporte_detalle_resultados($enc_cur_eva_evar);
        //pr($resultado['data']);
        //pr($resultado['respuestas']);
        $query->free_result(); //Libera la memoria

        return $resultado;
    }

    public function reporte_detalle_resultados($params = array()) {
        $resultado = array();
        //pr($params);
        foreach ($params as $key_p => $param) {
            $valor = explode(',', $param);
            
            $this->db->select('eva.*, res.reactivos_cve, res.ponderacion, res.texto, res.orden, res.texto_real');
            /*$query = $this->db->query('select * from encuestas.sse_evaluacion eva 
                inner join encuestas.sse_respuestas res on eva.reactivos_cve=res.reactivos_cve
                WHERE  eva.course_cve=838 and evaluador_rol_id=18 and evaluado_rol_id=32 AND eva.encuesta_cve=526');*/
            $this->db->where('eva.encuesta_cve='.$valor[0].' AND eva.course_cve='.$valor[1].' AND evaluado_rol_id='.$valor[2].' AND evaluador_rol_id='.$valor[3]);
            
            $this->db->join('encuestas.sse_respuestas res', 'eva.reactivos_cve=res.reactivos_cve', 'left');
            
            $query = $this->db->get('encuestas.sse_evaluacion eva');
            
            $temp = $query->result_array();
            foreach ($temp as $key_d => $dato) {
                //$resultado['data'][$dato['course_cve']][$dato['group_id']][$dato['encuesta_cve']][$dato['evaluado_user_cve']][$dato['evaluador_user_cve']][$dato['preguntas_cve']] = $dato;
                $resultado['data'][$dato['course_cve']][$dato['grupos_ids_text']][$dato['encuesta_cve']][$dato['evaluado_user_cve']][$dato['evaluador_user_cve']][$dato['preguntas_cve']] = $dato;
            }
            //pr($this->db->last_query());
            //$this->db->flush_cache();            
            $query->free_result(); //Libera la memoria         
        }
        return $resultado;
    }

    public function reporte_preguntas($params = null) {
        $resultado = array();
        $this->db->select("*, tip_pre.descripcion similar to '%RESPUESTA_ABIERTA%' as is_abierta");
        if (isset($params['conditions']) && !empty($params['conditions'])) {
            $this->db->where($params['conditions']);
        }
        if (isset($params['order']) && !empty($params['order'])) {
            $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
            $this->db->order_by($params['order'], $tipo_orden);
        }
        $this->db->join('encuestas.sse_tipo_pregunta tip_pre', 'tip_pre.tipo_pregunta_cve=preg.tipo_pregunta_cve');
        //$query = $this->db->query('select * from encuestas.sse_preguntas preg where encuesta_cve=526');
        $query_p = $this->db->get('encuestas.sse_preguntas preg');
        //pr($query_p);
        //pr($this->db->last_query());
        $resultado['data'] = $query_p->result_array();
        //pr($resultado);
        $query_p->free_result(); //Libera la memoria         
        
        return $resultado;
    }

    public function reporte_encuesta_data($params = null){
        $resultado = array();
        if (isset($params['fields']) && !empty($params['fields'])) {
            $this->db->select($params['fields']);
        }
        if (isset($params['is_bono']) && $params['is_bono']!="") {
            $this->db->where('is_bono', $params['is_bono']);
        }
        if (isset($params['instrumento_regla']) && !empty($params['instrumento_regla'])) {
            $this->db->where('reglas_evaluacion_cve', $params['instrumento_regla']);
        }
        if (isset($params['conditions']) && !empty($params['conditions'])) {
            $this->db->where($params['conditions']);
        }        
        if (isset($params['order']) && !empty($params['order'])) {
            $tipo_orden = (isset($params['order_type']) && !empty($params['order_type'])) ? $params['order_type'] : "ASC";
            $this->db->order_by($params['order'], $tipo_orden);
        }
        $query_p = $this->db->get('encuestas.sse_encuestas');
        //pr($query_p);
        //pr($this->db->last_query());
        $resultado['data'] = $query_p->result_array();
        //pr($resultado);
        $query_p->free_result(); //Libera la memoria         

        return $resultado;
    }
}
