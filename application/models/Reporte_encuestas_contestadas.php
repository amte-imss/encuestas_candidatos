<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_encuestas_contestadas extends CI_Model {

    private $filtrar_encuestas_validas = false;
    private $obtener_encuestas_validas = true;

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->config->load('general');
        $this->load->database();
    }

    /**
     * 
     * @param type $filtrar_encuestas_validas
     * En true aplica el filtro de encuestas validas, ya que algunas no aplicasn 
     */
    function setFiltrar_encuestas_validas($filtrar_encuestas_validas) {
        $this->filtrar_encuestas_validas = $filtrar_encuestas_validas;
    }

    function setObtener_encuestas_validas($obtener_encuestas_validas) {
        $this->obtener_encuestas_validas = $obtener_encuestas_validas;
    }

    /**
     * @descripcion Obtiene el reporte de encuetas contestadas 
     * y no contestadas de cursos tutorizados
     * @author LEAS 29/11/2017
     * @param type $curso_id
     * @param type $tipo_reporte
     * @return type
     */
    private function get_reporte_tutorizados($curso_id) {
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        $result_nc_sn = $this->get_reporte_NC_SN_T($curso_id);
//        pr($this->db->last_query());
        $result_nc_n = $this->get_reporte_NC_N_T($curso_id);
//        pr($this->db->last_query());
        $result_ct = $this->get_reporte_C_T($curso_id);
//        pr($this->db->last_query());
        $result = array_merge($result_ct, $result_nc_sn, $result_nc_n);
        return $result;
    }

    /**
     * Contestadas tutorizados 
     * @author LEAS
     * @fecha 29/11/2017
     * @param type $curso_id identificador del curso en Moodle
     * @return type
     */
    private function get_reporte_C_T($curso_id) {
        $this->get_select_C_T();
        $this->db->select($this->get_select_C_T(), FALSE); //Reset result query
        $this->db->distinct(); //Aplica distinct
        $this->get_where_C_T($curso_id);
        $this->get_join_C_T();
        $this->get_groupby_C_T();
        $query = $this->db->get($this->get_from_C_T()); //Reset result query
        $result = $query->result_array();
        return $result;
    }

    /**
     * Reporte de encuestas no contestadas para cursos tutorizados sin rol normativo
     * @author LEAS
     * @fecha 29/11/2017
     * @param type $curso_id
     * @return type
     */
    private function get_reporte_NC_SN_T($curso_id) {

        $this->db->select($this->get_select_NC_SN_T()); //Reset result query
        $this->db->distinct(); //Aplica distinct
        $this->get_where_NC_SN_T($curso_id);
        $this->get_join_NC_SN_T();
        $this->get_groupby_NC_SN_T();
        $query = $this->db->get($this->get_from_NC_SN_T()); //Reset result query
        $result = $query->result_array();
        return $result;
    }

    /**
     * Reporte de encuestas no contestadas para cursos tutorizados y únicamente rol normativo
     * @author LEAS
     * @fecha 29/11/2017
     * @param type $curso_id
     * @return type
     */
    private function get_reporte_NC_N_T($curso_id) {

        $this->db->select($this->get_select_NC_N_T()); //Reset result query
        $this->db->distinct(); //Aplica distinct
        $this->get_where_NC_N_T($curso_id);
        $this->get_join_NC_N_T();
        $this->get_groupby_NC_N_T();
        $query = $this->db->get($this->get_from_NC_N_T()); //Reset result query
        $result = $query->result_array();
//        pr($this->db->last_query());
        return $result;
    }

    /**
     * @descripcion Obtiene el reporte de encuetas contestadas 
     * y no contestadas de cursos no tutorizados
     * @author LEAS 29/11/2017
     * @param type $curso_id
     * @param type $tipo_reporte
     * @return type
     */
    private function get_reporte_no_tutorizados($curso_id) {
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        $result_cnc_sn = $this->get_reporte_CNC_SN_NT($curso_id);
//        pr($this->db->last_query());
        $result_cnc_n = $this->get_reporte_CNC_N_NT($curso_id);
//        pr($this->db->last_query());
        $result = array_merge($result_cnc_sn, $result_cnc_n);
        return $result;
//        return [];
    }

    /**
     * Reporte de encuestas contestadas y no contestadas para cursos no tutorizados 
     * sin rol normativo
     * @author LEAS
     * @fecha 29/11/2017
     * @param type $curso_id
     * @return type
     */
    private function get_reporte_CNC_SN_NT($curso_id) {
        $this->db->select($this->get_select_CNC_SN_NT()); //Reset result query
        $this->db->distinct(); //Aplica distinct
        $this->get_where_CNC_SN_NT($curso_id);
        $this->get_join_CNC_SN_NT();
        $this->get_groupby_CNC_SN_NT();
        $query = $this->db->get($this->get_from_CNC_SN_NT()); //Reset result query
        $result = $query->result_array();
//        pr($this->db->last_query());
        return $result;
    }

    /**
     * Reporte de encuestas contestadas y no contestadas para cursos no tutorizados 
     * únicamente rol normativo
     * @author LEAS
     * @fecha 29/11/2017
     * @param type $curso_id
     * @return type
     */
    private function get_reporte_CNC_N_NT($curso_id) {
        $this->db->select($this->get_select_CNC_N_NT()); //Reset result query
        $this->db->distinct(); //Aplica distinct
        $this->get_where_CNC_N_NT($curso_id);
        $this->get_join_CNC_N_NT();
        $this->get_groupby_CNC_N_NT();
        $query = $this->db->get($this->get_from_CNC_N_NT()); //Reset result query
        $result = $query->result_array();
        return $result;
    }

    public function getBusquedaEncContNoCont($params = null) {

        if ($params['tutorizado'] == 1) {//Ejecuta función de tutorizado
            $result = $this->get_reporte_tutorizados($params['curso']);
        } else {//Ejecuta función de no tutorizado
            $result = $this->get_reporte_no_tutorizados($params['curso']);
        }

        return $result;
    }

    /*     * ***** Reporte de encuestas para cursos tutorizados y encuestas no contestadas con normativo ********* */

    /**
     * 
     * @return type
     */
    private function get_select_NC_N_T() {//Select basico tutorizado no contestadas con normativo
        $array = [
            //tutorizado
            'mdl_course_config"."tutorizado',
//curso
            'mdl_course"."id" AS "cur_id', 'mdl_course"."shortname" AS "curso_clave', 'mdl_course"."fullname" AS "curso_nombre',
            '"public"."mdl_groups"."id" as ids_grupos', '"public"."mdl_groups"."name" as names_grupos', '"cbg".bloque',
//Encuesta
            'encuestas"."sse_encuestas"."encuesta_cve', 'encuestas"."sse_encuestas"."cve_corta_encuesta', 'encuestas"."sse_encuestas"."descripcion_encuestas'
//evaluado
            , '"mdl_user_evaluado"."username" as matricula_evaluado', '"mdl_rol_evaluado"."id" as rol_evaluado_id', '"mdl_rol_evaluado"."name" as rol_evaluando'
            , 'concat("mdl_user_evaluado".firstname, \' \', "mdl_user_evaluado"."lastname") as nombre_evaluado'
            , '"cattutdo".des_clave clave_categoria_evaluado', '"cattutdo".nom_nombre nombre_categoria_evaluado',
            'depdo.cve_depto_adscripcion clave_adscripcion_evaluado', '"depdo".des_unidad_atencion nombre_adscripcion_evaluado',
            'depdo"."nom_delegacion" "delegacion_evaluado', 'depdo"."name_region" "region_evaluado'
//evaluador 
            , '"mdl_user"."id" id_user_evaluador', '"mdl_user"."username" matricula_evaluador', '"mdl_role"."id" rol_evaluador_id', '"mdl_role"."name" as rol_evaluador',
            'concat("mdl_user"."firstname", \' \', "mdl_user"."lastname") as nombre_evaluador'
            , '\'\' clave_categoria_evaluador_preg', '\'\' nombre_categoria_evaluado_preg',
            '\'\' clave_adscripcion_preg_evaluador', '\'\' nombre_adscripcion_preg_evaluador'
            , '\'\' delegacion_preg_evaluador', '\'\' region_preg_evaluador', "'' email_preg_evaluador",
            '"cattutdor".des_clave clave_categoria_evaluador_tutor', '"cattutdor".nom_nombre nombre_categoria_evaluado_tutor',
            'depdor.cve_depto_adscripcion clave_adscripcion_tutor_evaluador', 'depdor.des_unidad_atencion nombre_adscripcion_tutor_evaluador',
            'depdor"."nom_delegacion" "delegacion_tutor_evaluador', 'depdor"."name_region" "region_tutor_evaluador_dor',
            '"mdl_user"."email" email_tutor_evaluador'
//contestadas
            , "2 contestada"
            , "'' calificacion"
            , "'' calificacion_bono"
            , "'' fecha_evaluacion"
        ];
        if ($this->obtener_encuestas_validas) {
            $array[] = $this->get_select_encuesta_valida();
        }
        return $array;
    }

    private function get_from_NC_N_T() {//Select basico tutorizado no contestadas con normativo
        return '"mdl_course"';
    }

    function get_where_NC_N_T($curso_id = null) {//Select basico tutorizado no contestadas con normativo
        if (!is_null($curso_id)) {
            $this->db->where('"mdl_course"."id"', $curso_id);
        }
        $this->db->where('"mdl_course_config".tutorizado', 1);
        $this->db->where_in('"encuestas"."sse_reglas_evaluacion"."reglas_evaluacion_cve"', 7);
        $this->db->where('(select count(*)
                from encuestas.sse_encuestas encp
                join encuestas.sse_reglas_evaluacion regep on  regep.reglas_evaluacion_cve = encp.reglas_evaluacion_cve and regep.rol_evaluado_cve = "mdl_rol_evaluado"."id"  and regep.rol_evaluador_cve = "mdl_role"."id"
                join encuestas.sse_result_evaluacion_encuesta_curso reecp on reecp.encuesta_cve = encp.encuesta_cve and reecp.course_cve = "mdl_course".id 
                join encuestas.sse_curso_bloque_grupo cbgp on cbgp.course_cve = reecp.course_cve and cbgp.bloque = "cbg".bloque  
                where reecp.evaluado_user_cve = "tutorias"."mdl_userexp"."userid" and reecp.evaluador_user_cve = "mdl_user"."id"
                ) = 0', null);
        if ($this->filtrar_encuestas_validas) {//Aplica filtro para descartar las encuestas que no son validas
            $this->db->where($this->get_where_encuesta_valida());
        }
    }

    private function get_join_NC_N_T() {//Select basico tutorizado no contestadas con normativo
        $this->db->join('"public"."mdl_course_config"', '"mdl_course_config"."course"="mdl_course"."id"', 'inner');
        $this->db->join('"public"."mdl_course_categories"', '"mdl_course_categories"."id"="mdl_course"."category"', 'inner');
        $this->db->join('"mdl_context"', '"mdl_context"."instanceid" = "mdl_course"."id"', 'inner');
        $this->db->join('"mdl_role_assignments"', '"mdl_context"."id" = "mdl_role_assignments"."contextid"', 'inner');
        $this->db->join('"mdl_role"', '"mdl_role"."id" = "mdl_role_assignments"."roleid"', 'inner');
        $this->db->join('"mdl_user"', '"mdl_user"."id" = "mdl_role_assignments"."userid"', 'inner');
        $this->db->join('"encuestas"."sse_encuesta_curso"', '"encuestas"."sse_encuesta_curso"."course_cve" = "public"."mdl_course"."id"', 'inner');
        $this->db->join('"encuestas"."sse_encuestas"', '"encuestas"."sse_encuestas"."encuesta_cve"="encuestas"."sse_encuesta_curso"."encuesta_cve"', 'inner');
        $this->db->join('"encuestas"."sse_reglas_evaluacion"', '"encuestas"."sse_reglas_evaluacion"."reglas_evaluacion_cve" = "encuestas"."sse_encuestas"."reglas_evaluacion_cve" and "mdl_role"."id" = "encuestas"."sse_reglas_evaluacion"."rol_evaluador_cve"', 'inner');
        $this->db->join('"public"."mdl_role" as "mdl_rol_evaluado"', '"mdl_rol_evaluado"."id"= "encuestas"."sse_reglas_evaluacion"."rol_evaluado_cve"', 'inner');
        $this->db->join('"tutorias"."mdl_userexp"', '"tutorias"."mdl_userexp"."role" = "mdl_rol_evaluado"."id" and "tutorias"."mdl_userexp"."ind_status" = 1 and "tutorias"."mdl_userexp"."cursoid" = "mdl_course"."id" and  "tutorias"."mdl_userexp"."role" not in(5) AND "mdl_userexp"."userid" != "mdl_user"."id"', 'inner');
        $this->db->join('"public"."mdl_user" as "mdl_user_evaluado"', '"mdl_user_evaluado"."id"= "tutorias"."mdl_userexp"."userid"', 'inner');
        $this->db->join('"public"."mdl_groups_members" "gm"', '"gm"."userid" = "mdl_user"."id" AND "gm"."groupid" = "tutorias"."mdl_userexp"."grupoid"', 'left');
        $this->db->join('"public"."mdl_groups"', '"public"."mdl_groups"."courseid" = "mdl_course"."id" and "public"."mdl_groups"."id" = "gm"."groupid"', 'left');
        $this->db->join('encuestas.sse_curso_bloque_grupo "cbg"', 'cbg.mdl_groups_cve = "gm"."groupid"', 'left');
//info Evaluador
        $this->db->join('"nomina"."ssn_categoria" "cattutdor"', '"cattutdor"."cve_categoria" = "mdl_user"."cat"', 'left');
        $this->db->join('"departments"."ssv_departamentos" "depdor"', '"depdor"."cve_depto_adscripcion" = "mdl_user"."cve_departamental"', 'left');
//info evaluado
        $this->db->join('"tutorias"."mdl_usertutor" "tutdo"', '"tutdo"."nom_usuario"="mdl_user_evaluado"."username" and "tutdo"."id_curso"="mdl_course"."id"', 'left');
        $this->db->join('"nomina"."ssn_categoria" "cattutdo"', '"cattutdo"."cve_categoria" = "tutdo"."cve_categoria"', 'left');
        $this->db->join('"departments"."ssv_departamentos" "depdo"', '"depdo"."cve_depto_adscripcion" = "tutdo"."cve_departamento"', 'left');
    }

    private function get_groupby_NC_N_T() {//Select basico tutorizado no contestadas con normativo
        return null;
    }

    /*     * ***** Reporte de encuestas para cursos tutorizados y encuestas no contestadas sin  normativo ********* */

    private function get_select_NC_SN_T() {//Select basico tutorizado no contestadas sin normativo
        $array = [
            //tutorizado
            'mdl_course_config"."tutorizado',
//curso
            'mdl_course"."id" AS "cur_id', 'mdl_course"."shortname" AS "curso_clave', 'mdl_course"."fullname" AS "curso_nombre',
            'string_agg(DISTINCT "public"."mdl_groups"."id"::text,\',\') as ids_grupos', 'string_agg(DISTINCT "public"."mdl_groups"."name", \',\') as names_grupos', '"cbg".bloque',
//Encuesta
            'encuestas"."sse_encuestas"."encuesta_cve', ' "encuestas"."sse_encuestas"."cve_corta_encuesta"', 'encuestas"."sse_encuestas"."descripcion_encuestas'
//evaluado
            , '"mdl_user_evaluado"."username" as matricula_evaluado', '"mdl_rol_evaluado"."id" as rol_evaluado_id', '"mdl_rol_evaluado"."name" as rol_evaluando'
            , 'concat("mdl_user_evaluado".firstname, \' \', "mdl_user_evaluado"."lastname") as nombre_evaluado'
            , '"cattutdo".des_clave clave_categoria_evaluado', '"cattutdo".nom_nombre nombre_categoria_evaluado',
            'depdo.cve_depto_adscripcion clave_adscripcion_evaluado', '"depdo".des_unidad_atencion nombre_adscripcion_evaluado',
            'depdo"."nom_delegacion" "delegacion_evaluado', 'depdo"."name_region" "region_evaluado'
//evaluador 
            , '"mdl_user"."id" id_user_evaluador', '"mdl_user"."username" matricula_evaluador', '"mdl_role"."id" rol_evaluador_id', '"mdl_role"."name" as rol_evaluador',
            'concat("mdl_user"."firstname", \' \', "mdl_user"."lastname") as nombre_evaluador'
            , '"catdor".des_clave clave_categoria_evaluador_preg', '"catdor".nom_nombre nombre_categoria_evaluado_preg',
            'deppredor.cve_depto_adscripcion clave_adscripcion_preg_evaluador', 'deppredor.des_unidad_atencion nombre_adscripcion_preg_evaluador'
            , 'deppredor"."nom_delegacion" "delegacion_preg_evaluador', 'deppredor"."name_region" "region_preg_evaluador',
            'string_agg(DISTINCT "gpregdor".des_email_pers, \', \') "email_preg_evaluador"',
            '"cattutdor".des_clave clave_categoria_evaluador_tutor', '"cattutdor".nom_nombre nombre_categoria_evaluado_tutor',
            'depdor.cve_depto_adscripcion clave_adscripcion_tutor_evaluador', 'depdor.des_unidad_atencion nombre_adscripcion_tutor_evaluador',
            'depdor"."nom_delegacion" "delegacion_tutor_evaluador', 'depdor"."name_region" "region_tutor_evaluador_dor',
            'string_agg(DISTINCT (case "tutdor".emailpart when \'\' then "tutdor".emaillab else "tutdor".emailpart end), \', \') as "email_tutor_evaluador"'
//contestadas
            , "2 contestada"
            , "'' calificacion"
            , "'' calificacion_bono"
            , "'' fecha_evaluacion"
        ];
        if ($this->obtener_encuestas_validas) {
            $array[] = $this->get_select_encuesta_valida();
        }
        return $array;
    }

    private function get_from_NC_SN_T() {//Select basico tutorizado no contestadas sin normativo
        return '"mdl_course"';
    }

    private function get_where_NC_SN_T($curso_id = null) {//Select basico tutorizado no contestadas con normativo
        if (!is_null($curso_id)) {
            $this->db->where('"mdl_course"."id"', $curso_id);
        }
        $this->db->where_not_in('"encuestas"."sse_reglas_evaluacion"."reglas_evaluacion_cve"', 7);
        $this->db->where('"mdl_course_config".tutorizado', 1);
        $this->db->where('(select count(*)
                from encuestas.sse_encuestas encp
                join encuestas.sse_reglas_evaluacion regep on  regep.reglas_evaluacion_cve = encp.reglas_evaluacion_cve and regep.rol_evaluado_cve = "mdl_rol_evaluado"."id"  and regep.rol_evaluador_cve = "mdl_role"."id"
                join encuestas.sse_result_evaluacion_encuesta_curso reecp on reecp.encuesta_cve = encp.encuesta_cve and reecp.course_cve = "mdl_course".id 
                join encuestas.sse_curso_bloque_grupo cbgp on cbgp.course_cve = reecp.course_cve and cbgp.bloque = "cbg".bloque  
                where reecp.evaluado_user_cve = "tutorias"."mdl_userexp"."userid" and reecp.evaluador_user_cve = "mdl_user"."id"
                )=0', null);
        if ($this->filtrar_encuestas_validas) {//Aplica filtro para descartar las encuestas que no son validas
            $this->db->where($this->get_where_encuesta_valida());
        }
    }

    private function get_join_NC_SN_T() {//Select basico tutorizado no contestadas con normativo
        $this->db->join('"public"."mdl_course_config"', '"mdl_course_config"."course"="mdl_course"."id"', 'inner');
        $this->db->join('"public"."mdl_course_categories"', '"mdl_course_categories"."id"="mdl_course"."category"', 'inner');
        $this->db->join('"mdl_context"', '"mdl_context"."instanceid" = "mdl_course"."id"', 'inner');
        $this->db->join('"mdl_role_assignments"', '"mdl_context"."id" = "mdl_role_assignments"."contextid"', 'inner');
        $this->db->join('"mdl_role"', '"mdl_role"."id" = "mdl_role_assignments"."roleid"', 'inner');
        $this->db->join('"mdl_user"', '"mdl_user"."id" = "mdl_role_assignments"."userid"', 'inner');
        $this->db->join('"encuestas"."sse_encuesta_curso"', '"encuestas"."sse_encuesta_curso"."course_cve" = "public"."mdl_course"."id"', 'inner');
        $this->db->join('"encuestas"."sse_encuestas"', '"encuestas"."sse_encuestas"."encuesta_cve"="encuestas"."sse_encuesta_curso"."encuesta_cve"', 'inner');
        $this->db->join('"encuestas"."sse_reglas_evaluacion"', '"encuestas"."sse_reglas_evaluacion"."reglas_evaluacion_cve" = "encuestas"."sse_encuestas"."reglas_evaluacion_cve" and "mdl_role"."id" = "encuestas"."sse_reglas_evaluacion"."rol_evaluador_cve"', 'inner');
        $this->db->join('"public"."mdl_role" as "mdl_rol_evaluado"', '"mdl_rol_evaluado"."id"= "encuestas"."sse_reglas_evaluacion"."rol_evaluado_cve"', 'inner');
        $this->db->join('"tutorias"."mdl_userexp"', '"tutorias"."mdl_userexp"."role" = "mdl_rol_evaluado"."id" and "tutorias"."mdl_userexp"."ind_status" = 1 and "tutorias"."mdl_userexp"."cursoid" = "mdl_course"."id" and  "tutorias"."mdl_userexp"."role" not in(5) AND "mdl_userexp"."userid" != "mdl_user"."id"', 'inner');
        $this->db->join('"public"."mdl_user" as "mdl_user_evaluado"', '"mdl_user_evaluado"."id"= "tutorias"."mdl_userexp"."userid"', 'inner');
        $this->db->join('"public"."mdl_groups_members" "gm"', '"gm"."userid" = "mdl_user"."id" AND "gm"."groupid" = "tutorias"."mdl_userexp"."grupoid" ', 'left');
        $this->db->join('"public"."mdl_groups"', '"public"."mdl_groups"."courseid" = "mdl_course"."id" and "public"."mdl_groups"."id" = "gm"."groupid" ', 'left');
        $this->db->join('encuestas.sse_curso_bloque_grupo cbg', 'cbg.mdl_groups_cve = "gm"."groupid"', 'inner');
//info Evaluado
        $this->db->join('"gestion"."sgp_tab_preregistro_al" "gpregdor"', '"gpregdor"."nom_usuario" = "mdl_user"."username" and "gpregdor"."cve_curso" = "mdl_course"."id" ', 'left');
        $this->db->join('"nomina"."ssn_categoria" "catdor"', '"catdor"."cve_categoria" = "gpregdor".cve_cat', 'left');
        $this->db->join('"departments"."ssv_departamentos" "deppredor"', '"deppredor"."cve_depto_adscripcion" = "gpregdor"."cve_departamental"', 'left');
        $this->db->join('"tutorias"."mdl_usertutor" "tutdor"', '"tutdor"."nom_usuario"="mdl_user"."username" and "tutdor"."id_curso"="mdl_course"."id"', 'left');
        $this->db->join('"nomina"."ssn_categoria" "cattutdor"', '"cattutdor"."cve_categoria" = "tutdor"."cve_categoria"', 'left');
        $this->db->join('"departments"."ssv_departamentos" "depdor"', '"depdor"."cve_depto_adscripcion" = "tutdor"."cve_departamento"', 'left');
//info evaluado
        $this->db->join('"tutorias"."mdl_usertutor" "tutdo"', '"tutdo"."nom_usuario"="mdl_user_evaluado"."username" and "tutdo"."id_curso"="mdl_course"."id"', 'left');
        $this->db->join('"nomina"."ssn_categoria" "cattutdo"', '"cattutdo"."cve_categoria" = "tutdo"."cve_categoria"', 'left');
        $this->db->join('"departments"."ssv_departamentos" "depdo"', '"depdo"."cve_depto_adscripcion" = "tutdo"."cve_departamento"', 'left');
    }

    private function get_groupby_NC_SN_T() {//Select basico tutorizado no contestadas con normativo
        $group = [
            'mdl_course_config"."tutorizado',
//curso
            'mdl_course"."id', 'mdl_course"."shortname', 'mdl_course"."fullname',
            '"cbg".bloque',
//Encuesta
            'encuestas"."sse_encuestas"."encuesta_cve', 'encuestas"."sse_encuestas"."cve_corta_encuesta', 'encuestas"."sse_encuestas"."descripcion_encuestas'
//evaluado
            , 'mdl_user_evaluado"."username', 'mdl_rol_evaluado"."id', 'mdl_rol_evaluado"."name'
            , '"mdl_user_evaluado".firstname', 'mdl_user_evaluado"."lastname', '"mdl_user_evaluado"."id"'
            , '"cattutdo".des_clave', '"cattutdo".nom_nombre',
            'depdo.cve_depto_adscripcion', '"depdo".des_unidad_atencion',
            'depdo"."nom_delegacion', 'depdo"."name_region'
//evaluador 
            , '"mdl_user"."id"', 'mdl_user"."username', 'mdl_role"."id', 'mdl_role"."name',
            'mdl_user"."firstname', 'mdl_user"."lastname'
            , '"catdor".des_clave', '"catdor".nom_nombre',
            'deppredor.cve_depto_adscripcion', 'deppredor.des_unidad_atencion'
            , 'deppredor"."nom_delegacion', 'deppredor"."name_region',
            '"cattutdor".des_clave', '"cattutdor".nom_nombre',
            'depdor.cve_depto_adscripcion', 'depdor.des_unidad_atencion',
            'depdor"."nom_delegacion', '"depdor"."name_region" '
        ];
        foreach ($group as $value) {
            $this->db->group_by($value);
        }
    }

    /*     * ********************** Reporte cursos tutorizados C (Contestadas) *********** */

    private function get_select_C_T() {//Select basico tutorizado
        $array = array(
            //TUTORIZADO
            "ccfg.tutorizado",
            //CURSO
            "ec.course_cve cur_id", "mcs.shortname curso_clave", "mcs.fullname as curso_nombre",
            "array_agg(distinct mg.id) as ids_grupos, string_agg(distinct mg.name, ', ') as names_grupos,cbg.bloque",
            //ENCUESTA
            "reec.encuesta_cve", "enc.cve_corta_encuesta", "enc.descripcion_encuestas",
            //EVALUADO
            "uedo.username as matricula_evaluado", "mrdo.id rol_evaluado_id", "mrdo.name rol_evaluando",
            "concat(uedo.firstname, ' ', uedo.lastname) nombre_evaluado",
            "cattutdo.des_clave clave_categoria_evaluado", "cattutdo.nom_nombre nombre_categoria_evaluado",
            "depdo.cve_depto_adscripcion clave_adscripcion_evaluado", "depdo.des_unidad_atencion nombre_adscripcion_evaluado",
            "depdo.nom_delegacion delegacion_evaluado",
            "depdo.name_region region_evaluado",
            //EVALUADOR
            'uedor.id id_user_evaluador', "uedor.username as matricula_evaluador", "mrdor.id rol_evaluador_id", "mrdor.name rol_evaluador",
            "concat(uedor.firstname, ' ', uedor.lastname) nombre_evaluador",
            "catpredor.des_clave clave_categoria_evaluador_preg", "catpredor.nom_nombre nombre_categoria_evaluado_preg",
            "deppredor.cve_depto_adscripcion clave_adscripcion_preg_evaluador", "deppredor.des_unidad_atencion nombre_adscripcion_preg_evaluador",
            "deppredor.nom_delegacion delegacion_preg_evaluador", "deppredor.name_region region_preg_evaluador",
            'string_agg(DISTINCT ("gpregdor"."des_email_pers"), \', \') email_preg_evaluador',
            "cattutdor.des_clave clave_categoria_evaluador_tutor", "cattutdor.nom_nombre nombre_categoria_evaluado_tutor",
            "depdor.cve_depto_adscripcion clave_adscripcion_tutor_evaluador", "depdor.des_unidad_atencion nombre_adscripcion_tutor_evaluador"
            , "depdor.nom_delegacion delegacion_tutor_evaluador", 'depdor.name_region region_tutor_evaluador_dor',
            'string_agg(DISTINCT (case "tutdor"."emailpart" when \'\' then "tutdor".emaillab else "tutdor".emailpart end), \', \') email_tutor_evaluador',
            //CALIFICACION
            "1 contestada",
            "reec.calif_emitida_napb calificacion",
            "reec.calif_emitida calificacion_bono",
            "reec.fecha_add fecha_evaluacion"
        );
        if ($this->obtener_encuestas_validas) {
            $array[] = $this->get_select_encuesta_valida(true);
        }
        return $array;
    }

    private function get_from_C_T() {//Select basico tutorizado
        return 'encuestas.sse_result_evaluacion_encuesta_curso reec';
    }

    private function get_where_C_T($curso_id = null) {//Select basico tutorizado
        $this->db->where('ccfg.tutorizado', 1);
        if (!is_null($curso_id)) {
            $this->db->where('ec.course_cve', $curso_id);
        }
        if ($this->filtrar_encuestas_validas) {//Aplica filtro para descartar las encuestas que no son validas
            $this->db->where($this->get_where_encuesta_valida(true));
        }
    }

    private function get_join_C_T() {//Select basico tutorizado
        $this->db->join('encuestas.sse_encuesta_curso ec', 'reec.encuesta_cve = ec.encuesta_cve and reec.course_cve = ec.course_cve', 'inner');
        $this->db->join('public.mdl_groups mg', "mg.id = reec.group_id or mg.id = ANY (string_to_array(reec.grupos_ids_text, ',')::int[])", 'left');
        $this->db->join('public.mdl_course mcs', 'mcs.id = ec.course_cve', 'inner');
        $this->db->join('public.mdl_course_config ccfg', 'ccfg.course = ec.course_cve', 'inner');
        $this->db->join('encuestas.sse_encuestas enc', 'enc.encuesta_cve = reec.encuesta_cve', 'inner');
        $this->db->join('encuestas.sse_reglas_evaluacion rege', 'rege.reglas_evaluacion_cve = enc.reglas_evaluacion_cve', 'inner');
        $this->db->join('public.mdl_user uedor', 'uedor.id = reec.evaluador_user_cve', 'inner');
        $this->db->join('public.mdl_role mrdor', 'mrdor.id = rege.rol_evaluador_cve', 'inner');
        $this->db->join('gestion.sgp_tab_preregistro_al gpregdor', 'gpregdor.nom_usuario = uedor.username and gpregdor.cve_curso = ec.course_cve and rege.rol_evaluador_cve = 5', 'left');
        $this->db->join('nomina.ssn_categoria catpredor', 'catpredor.cve_categoria = gpregdor.cve_cat', 'left');
        $this->db->join('departments.ssv_departamentos deppredor', 'deppredor.cve_depto_adscripcion = gpregdor.cve_departamental', 'left');
        $this->db->join('tutorias.mdl_usertutor tutdor', 'tutdor.nom_usuario = uedor.username and tutdor.id_curso = ec.course_cve', 'left');
        $this->db->join('nomina.ssn_categoria cattutdor', 'cattutdor.cve_categoria = tutdor.cve_categoria', 'left');
        $this->db->join('departments.ssv_departamentos depdor', 'depdor.cve_depto_adscripcion = tutdor.cve_departamento', 'left');
        $this->db->join('public.mdl_user uedo', 'uedo.id = reec.evaluado_user_cve', 'inner');
        $this->db->join('public.mdl_role mrdo', 'mrdo.id = rege.rol_evaluado_cve', 'inner');
        $this->db->join('tutorias.mdl_usertutor tutdo', 'tutdo.nom_usuario = uedo.username and tutdo.id_curso = ec.course_cve', 'left');
        $this->db->join('nomina.ssn_categoria cattutdo', 'cattutdo.cve_categoria = tutdo.cve_categoria', 'left');
        $this->db->join('departments.ssv_departamentos depdo', 'depdo.cve_depto_adscripcion = tutdo.cve_departamento', 'left');
        $this->db->join('"encuestas"."sse_curso_bloque_grupo" "cbg"', '"cbg"."course_cve" = "reec"."course_cve" and ("cbg"."mdl_groups_cve" = "reec"."group_id" or "cbg"."mdl_groups_cve" = ANY (string_to_array("reec"."grupos_ids_text", \',\')::int[]))', 'left', FALSE);
    }

    private function get_groupby_C_T() {//Select basico tutorizado
        $group = [
            "ec.course_cve", "mcs.shortname", "mcs.fullname", "ccfg.tutorizado", "reec.encuesta_cve", "reec.evaluador_user_cve",
            "reec.evaluado_user_cve", "enc.cve_corta_encuesta", "enc.descripcion_encuestas", "mrdo.id, mrdo.name",
            "uedor.id", 
            "uedo.id","uedo.username", "uedo.firstname", "uedo.lastname", "depdo.cve_depto_adscripcion", 
            "depdo.des_unidad_atencion", "depdo.nom_delegacion",
            "depdo.name_region", "cattutdor.des_clave", "cattutdor.nom_nombre", "mrdor.id, mrdor.name", "uedor.username", "uedor.firstname",
            "uedor.lastname", "cattutdor.des_clave", "cattutdor.nom_nombre", "catpredor.des_clave", "catpredor.nom_nombre", "depdor.cve_depto_adscripcion",
            "depdor.des_unidad_atencion", "depdor.nom_delegacion", "depdor.name_region", "deppredor.cve_depto_adscripcion",
            "deppredor.des_unidad_atencion", "deppredor.nom_delegacion", "deppredor.name_region", "reec.calif_emitida", "reec.calif_emitida_napb", "reec.fecha_add",
            "cattutdo.des_clave",
            "cattutdo.nom_nombre",
            "cbg.bloque"
        ];
        foreach ($group as $value) {
            $this->db->group_by($value);
        }
    }

    /**
     * Selecet Reporte cursos no tutorizados CyNC (contestadas y no contestadas)  sin normativo (SN-Normativo) 
     */
    private function get_select_CNC_SN_NT() {//Select basico no tutorizado sin normativo
        $array =  array(
            //tutorizado
            'mdl_course_config"."tutorizado',
            //curso
            'mdl_course"."id" AS "cur_id', 'mdl_course"."shortname" AS "curso_clave', 'mdl_course"."fullname" AS "curso_nombre', '"public"."mdl_course_config".horascur',
            '"public"."mdl_groups"."id" as ids_grupos', '"public"."mdl_groups"."name" as names_grupos',
            //Encuesta
            'encuestas"."sse_encuestas"."encuesta_cve', 'encuestas"."sse_encuestas"."cve_corta_encuesta', 'encuestas"."sse_encuestas"."descripcion_encuestas'
            //evaluado
            , '"mdl_user_evaluado"."username" as matricula_evaluado', '"mdl_rol_evaluado"."id" as rol_evaluado_id', '"mdl_rol_evaluado"."name" as rol_evaluando'
            , 'concat("mdl_user_evaluado".firstname, \' \', "mdl_user_evaluado"."lastname") as nombre_evaluado'
            , '"cattutdo".des_clave clave_categoria_evaluado', '"cattutdo".nom_nombre nombre_categoria_evaluado',
            'depdo.cve_depto_adscripcion clave_adscripcion_evaluado', '"depdo".des_unidad_atencion nombre_adscripcion_evaluado',
            'depdo"."nom_delegacion" "delegacion_evaluado', 'depdo"."name_region" "region_evaluado'
            //evaluador 
            , '"mdl_user"."id" id_user_evaluador', '"mdl_user"."username" matricula_evaluador', '"mdl_role"."id" rol_evaluador_id', '"mdl_role"."name" as rol_evaluador',
            'concat("mdl_user"."firstname", \' \', "mdl_user"."lastname") as nombre_evaluador'
            , '"catdor".des_clave clave_categoria_evaluador_preg', '"catdor".nom_nombre nombre_categoria_evaluado_preg',
            'deppredor.cve_depto_adscripcion clave_adscripcion_preg_evaluador', 'deppredor.des_unidad_atencion nombre_adscripcion_preg_evaluador'
            , 'deppredor"."nom_delegacion" "delegacion_preg_evaluador', 'deppredor"."name_region" "region_preg_evaluador', '"gpregdor".des_email_pers "email_preg_evaluador"'
            , '"cattutdor".des_clave clave_categoria_evaluador_tutor', '"cattutdor".nom_nombre nombre_categoria_evaluado_tutor'
            , 'depdor.cve_depto_adscripcion clave_adscripcion_tutor_evaluador', 'depdor.des_unidad_atencion nombre_adscripcion_tutor_evaluador'
            , 'depdor"."nom_delegacion" "delegacion_tutor_evaluador', 'depdor"."name_region" "region_tutor_evaluador_dor',
            'case "tutdor".emailpart when \'\' then "tutdor".emaillab else "tutdor".emailpart end "email_tutor_evaluador"'
            //contestadas
            , '2 contestada'
            , '(select concat(reecp.calif_emitida_napb::text,\',\',reecp.calif_emitida::text, \',\',reecp.fecha_add::text) calif
                from encuestas.sse_encuestas encp
                join encuestas.sse_reglas_evaluacion regep on  regep.reglas_evaluacion_cve = encp.reglas_evaluacion_cve and regep.rol_evaluador_cve = "mdl_role"."id" and regep.rol_evaluado_cve = "mdl_rol_evaluado"."id"
                join encuestas.sse_result_evaluacion_encuesta_curso reecp on reecp.encuesta_cve = encp.encuesta_cve and (reecp.group_id = "gm"."groupid" ) AND encp.encuesta_cve = "sse_encuesta_curso"."encuesta_cve" AND reecp.course_cve ="encuestas"."sse_encuesta_curso"."course_cve" 
                where reecp.evaluado_user_cve = "tutorias"."mdl_userexp"."userid" and reecp.evaluador_user_cve = "mdl_user"."id" 
                ) as calificacion'
            /* , '(select reecp.calif_emitida
              from encuestas.sse_encuestas encp
              join encuestas.sse_reglas_evaluacion regep on  regep.reglas_evaluacion_cve = encp.reglas_evaluacion_cve and regep.rol_evaluador_cve = "mdl_role"."id" and regep.rol_evaluado_cve = "mdl_rol_evaluado"."id"
              join encuestas.sse_result_evaluacion_encuesta_curso reecp on reecp.encuesta_cve = encp.encuesta_cve and (reecp.group_id = "gm"."groupid" ) AND encp.encuesta_cve = "sse_encuesta_curso"."encuesta_cve" AND reecp.course_cve ="encuestas"."sse_encuesta_curso"."course_cve"
              where reecp.evaluado_user_cve = "tutorias"."mdl_userexp"."userid" and reecp.evaluador_user_cve = "mdl_user"."id"
              ) as calificacion_bono' */
            , "'' calificacion_bono"
            , "'No aplica' as bloque"
            , "'' fecha_evaluacion"
        );
        if ($this->obtener_encuestas_validas) {
            $array[] = $this->get_select_encuesta_valida();
        }
        return $array;
    }

    private function get_from_CNC_SN_NT() {//Select basico no tutorizado sin normativo
        return'"mdl_course"';
    }

    private function get_where_CNC_SN_NT($curso_id = null) {//Select basico tutorizado
        if (!is_null($curso_id)) {
            $this->db->where('"mdl_course"."id"', $curso_id);
        }
        $this->db->where('"mdl_course_config".tutorizado', '0');
        $this->db->where_not_in('"encuestas"."sse_reglas_evaluacion"."reglas_evaluacion_cve"', 14);
        if ($this->filtrar_encuestas_validas) {//Aplica filtro para descartar las encuestas que no son validas
            $this->db->where($this->get_where_encuesta_valida());
        }
    }

    private function get_join_CNC_SN_NT() {//Select basico tutorizado
        $this->db->join('"public"."mdl_course_config"', '"mdl_course_config"."course"="mdl_course"."id"', 'inner');
        $this->db->join('"public"."mdl_course_categories"', '"mdl_course_categories"."id"="mdl_course"."category"', 'inner');
        $this->db->join('"mdl_context"', '"mdl_context"."instanceid" = "mdl_course"."id"', 'inner');
        $this->db->join('"mdl_role_assignments"', '"mdl_context"."id" = "mdl_role_assignments"."contextid"', 'inner');
        $this->db->join('"mdl_role"', '"mdl_role"."id" = "mdl_role_assignments"."roleid"', 'inner');
        $this->db->join('"mdl_user"', '"mdl_user"."id" = "mdl_role_assignments"."userid"', 'inner');
        $this->db->join('"encuestas"."sse_encuesta_curso"', '"encuestas"."sse_encuesta_curso"."course_cve" = "public"."mdl_course"."id"', 'inner');
        $this->db->join('"encuestas"."sse_encuestas"', '"encuestas"."sse_encuestas"."encuesta_cve"="encuestas"."sse_encuesta_curso"."encuesta_cve"', 'inner');
        $this->db->join('"encuestas"."sse_reglas_evaluacion"', '"encuestas"."sse_reglas_evaluacion"."reglas_evaluacion_cve" = "encuestas"."sse_encuestas"."reglas_evaluacion_cve" and "mdl_role"."id" = "encuestas"."sse_reglas_evaluacion"."rol_evaluador_cve"', 'inner');
        $this->db->join('"public"."mdl_role" as "mdl_rol_evaluado"', '"mdl_rol_evaluado"."id"= "encuestas"."sse_reglas_evaluacion"."rol_evaluado_cve"', 'inner');
        //última condicion quita autoevaluación
        $this->db->join('"tutorias"."mdl_userexp"', '"tutorias"."mdl_userexp"."role" = "mdl_rol_evaluado"."id" and "tutorias"."mdl_userexp"."ind_status" = 1 and "tutorias"."mdl_userexp"."cursoid" = "mdl_course"."id" and  "tutorias"."mdl_userexp"."role" not in(5) AND "mdl_userexp"."userid" != "mdl_user"."id"', 'inner');
        $this->db->join('"public"."mdl_user" as "mdl_user_evaluado"', '"mdl_user_evaluado"."id"= "tutorias"."mdl_userexp"."userid"', 'inner');
        $this->db->join('"public"."mdl_groups_members" "gm"', '"gm"."userid" = "mdl_user"."id" AND "gm"."groupid" = "tutorias"."mdl_userexp"."grupoid"', 'inner');
        $this->db->join('"public"."mdl_groups"', '"public"."mdl_groups"."courseid" = "mdl_course"."id" and "public"."mdl_groups"."id" = "gm"."groupid"', 'inner');
//info Evaluador
        $this->db->join('"gestion"."sgp_tab_preregistro_al" "gpregdor"', '"gpregdor"."nom_usuario" = "mdl_user"."username" and "gpregdor"."cve_curso" = "mdl_course"."id" --and "rege"."rol_evaluador_cve" = 5', 'left');
        $this->db->join('"nomina"."ssn_categoria" "catdor"', '"catdor"."cve_categoria" = "gpregdor".cve_cat', 'left');
        $this->db->join('"departments"."ssv_departamentos" "deppredor"', '"deppredor"."cve_depto_adscripcion" = "gpregdor"."cve_departamental"', 'left');
        $this->db->join('"tutorias"."mdl_usertutor" "tutdor"', '"tutdor"."nom_usuario"="mdl_user"."username" and "tutdor"."id_curso"="mdl_course"."id"', 'left');
        $this->db->join('"nomina"."ssn_categoria" "cattutdor"', '"cattutdor"."cve_categoria" = "tutdor"."cve_categoria"', 'left');
        $this->db->join('"departments"."ssv_departamentos" "depdor"', '"depdor"."cve_depto_adscripcion" = "tutdor"."cve_departamento"', 'left');
//info evaluado
        $this->db->join('"tutorias"."mdl_usertutor" "tutdo"', '"tutdo"."nom_usuario"="mdl_user_evaluado"."username" and "tutdo"."id_curso"="mdl_course"."id"', 'left');
        $this->db->join('"nomina"."ssn_categoria" "cattutdo"', '"cattutdo"."cve_categoria" = "tutdo"."cve_categoria"', 'left');
        $this->db->join('"departments"."ssv_departamentos" "depdo"', '"depdo"."cve_depto_adscripcion" = "tutdo"."cve_departamento"', 'left');
    }

    private function get_groupby_CNC_SN_NT() {//Select basico tutorizado
        return null;
    }

    /*     * * Reporte cursos no tutorizados CyNC (contestadas y no contetadas) - para Normativo .sql **** *********** */

    private function get_select_CNC_N_NT() {//Select basico no tutorizado con normativo
        $array = array(
            //tutorizado
            'mdl_course_config"."tutorizado',
            //curso
            'mdl_course"."id" AS "cur_id', 'mdl_course"."shortname" AS "curso_clave', 'mdl_course"."fullname" AS curso_nombre', '"public"."mdl_course_config".horascur',
            '"public"."mdl_groups"."id" as ids_grupos', '"public"."mdl_groups"."name" as names_grupos',
            //Encuesta
            'encuestas"."sse_encuestas"."encuesta_cve', 'encuestas"."sse_encuestas"."cve_corta_encuesta', 'encuestas"."sse_encuestas"."descripcion_encuestas'
            //evaluado
            , '"mdl_user_evaluado"."username" as matricula_evaluado', '"mdl_rol_evaluado"."id" as rol_evaluado_id', '"mdl_rol_evaluado"."name" as rol_evaluando'
            , 'concat("mdl_user_evaluado".firstname, \' \', "mdl_user_evaluado"."lastname") as nombre_evaluado'
            , '"cattutdo".des_clave clave_categoria_evaluado', '"cattutdo".nom_nombre nombre_categoria_evaluado',
            'depdo.cve_depto_adscripcion clave_adscripcion_evaluado', '"depdo".des_unidad_atencion nombre_adscripcion_evaluado',
            'depdo"."nom_delegacion" "delegacion_evaluado', 'depdo"."name_region" "region_evaluado'
            //evaluador 
            , '"mdl_user"."id" id_user_evaluador', '"mdl_user"."username" matricula_evaluador', '"mdl_role"."id" rol_evaluador_id', '"mdl_role"."name" as rol_evaluador',
            'concat("mdl_user"."firstname", \' \', "mdl_user"."lastname") as nombre_evaluador'
            , '\'\' clave_categoria_evaluador_preg', '\'\' nombre_categoria_evaluado_preg',
            '\'\' clave_adscripcion_preg_evaluador', '\'\' nombre_adscripcion_preg_evaluador'
            , '\'\' delegacion_preg_evaluador', '\'\' region_preg_evaluador', "'' email_preg_evaluador"
            , '"cattutdor".des_clave clave_categoria_evaluador_tutor', '"cattutdor".nom_nombre nombre_categoria_evaluado_tutor'
            , 'depdor.cve_depto_adscripcion clave_adscripcion_tutor_evaluador', 'depdor.des_unidad_atencion nombre_adscripcion_tutor_evaluador'
            , 'depdor"."nom_delegacion" "delegacion_tutor_evaluador', 'depdor"."name_region" "region_tutor_evaluador_dor'
            , '"mdl_user"."email" email_tutor_evaluador'
            //contestadas
            , "2 contestada"
            , '(select concat(reecp.calif_emitida_napb::text,\',\',reecp.calif_emitida::text, \',\',reecp.fecha_add::text)
                from encuestas.sse_encuestas encp
                join encuestas.sse_reglas_evaluacion regep on  regep.reglas_evaluacion_cve = encp.reglas_evaluacion_cve and regep.rol_evaluador_cve = "mdl_role"."id" and regep.rol_evaluado_cve = "mdl_rol_evaluado"."id"
                join encuestas.sse_result_evaluacion_encuesta_curso reecp on reecp.encuesta_cve = encp.encuesta_cve and (reecp.group_id =0) AND encp.encuesta_cve = "sse_encuesta_curso"."encuesta_cve" AND reecp.course_cve ="encuestas"."sse_encuesta_curso"."course_cve" 
                where reecp.evaluado_user_cve = "tutorias"."mdl_userexp"."userid" and reecp.evaluador_user_cve = "mdl_user"."id" 
                ) as calificacion'
            /* , '(select reecp.calif_emitida
              from encuestas.sse_encuestas encp
              join encuestas.sse_reglas_evaluacion regep on  regep.reglas_evaluacion_cve = encp.reglas_evaluacion_cve and regep.rol_evaluador_cve = "mdl_role"."id" and regep.rol_evaluado_cve = "mdl_rol_evaluado"."id"
              join encuestas.sse_result_evaluacion_encuesta_curso reecp on reecp.encuesta_cve = encp.encuesta_cve and (reecp.group_id = 0 ) AND encp.encuesta_cve = "sse_encuesta_curso"."encuesta_cve" AND reecp.course_cve ="encuestas"."sse_encuesta_curso"."course_cve"
              where reecp.evaluado_user_cve = "tutorias"."mdl_userexp"."userid" and reecp.evaluador_user_cve = "mdl_user"."id"
              ) as calificacion_bono' */
            , "'' calificacion_bono"
            , "'No aplica' as bloque"
            , "'' fecha_evaluacion"
        );
        if ($this->obtener_encuestas_validas) {
            $array[] = $this->get_select_encuesta_valida();
        }
        return $array;
    }

    private function get_from_CNC_N_NT() {//Select basico no tutorizado con normativo
        return '"mdl_course"';
    }

    private function get_where_CNC_N_NT($curso_id = null) {//Select basico tutorizado
        if (!is_null($curso_id)) {
            $this->db->where('"mdl_course"."id"', $curso_id);
        }
        $this->db->where_in('"encuestas"."sse_reglas_evaluacion"."reglas_evaluacion_cve"', 14);
        $this->db->where('"mdl_course_config".tutorizado', 0);
        if ($this->filtrar_encuestas_validas) {//Aplica filtro para descartar las encuestas que no son validas
            $this->db->where($this->get_where_encuesta_valida()); //Para descartar las encuestas que no son validas
        }
    }

    private function get_join_CNC_N_NT() {//Select basico tutorizado
        $this->db->join('"public"."mdl_course_config"', '"mdl_course_config"."course"="mdl_course"."id"', 'inner');
        $this->db->join('"public"."mdl_course_categories"', '"mdl_course_categories"."id"="mdl_course"."category"', 'inner');
        $this->db->join('"mdl_context"', '"mdl_context"."instanceid" = "mdl_course"."id"', 'inner');
        $this->db->join('"mdl_role_assignments"', '"mdl_context"."id" = "mdl_role_assignments"."contextid"', 'inner');
        $this->db->join('"mdl_role"', '"mdl_role"."id" = "mdl_role_assignments"."roleid"', 'inner');
        $this->db->join('"mdl_user"', '"mdl_user"."id" = "mdl_role_assignments"."userid"', 'inner');
        $this->db->join('"encuestas"."sse_encuesta_curso"', '"encuestas"."sse_encuesta_curso"."course_cve" = "public"."mdl_course"."id"', 'inner');
        $this->db->join('"encuestas"."sse_encuestas"', '"encuestas"."sse_encuestas"."encuesta_cve"="encuestas"."sse_encuesta_curso"."encuesta_cve"', 'inner');
        $this->db->join('"encuestas"."sse_reglas_evaluacion"', '"encuestas"."sse_reglas_evaluacion"."reglas_evaluacion_cve" = "encuestas"."sse_encuestas"."reglas_evaluacion_cve" and "mdl_role"."id" = "encuestas"."sse_reglas_evaluacion"."rol_evaluador_cve"', 'inner');
        $this->db->join('"public"."mdl_role" as "mdl_rol_evaluado"', '"mdl_rol_evaluado"."id"= "encuestas"."sse_reglas_evaluacion"."rol_evaluado_cve"', 'inner');
        //última condicion quita autoevaluación
        $this->db->join('"tutorias"."mdl_userexp"', '"tutorias"."mdl_userexp"."role" = "mdl_rol_evaluado"."id" and "tutorias"."mdl_userexp"."ind_status" = 1 and "tutorias"."mdl_userexp"."cursoid" = "mdl_course"."id" and  "tutorias"."mdl_userexp"."role" not in(5) AND "mdl_userexp"."userid" != "mdl_user"."id"', 'inner');
        $this->db->join('"public"."mdl_user" as "mdl_user_evaluado"', '"mdl_user_evaluado"."id"= "tutorias"."mdl_userexp"."userid"', 'inner');
        $this->db->join('"public"."mdl_groups_members" "gm"', '"gm"."userid" = "mdl_user"."id" AND "gm"."groupid" = "tutorias"."mdl_userexp"."grupoid"', 'left');
        $this->db->join('"public"."mdl_groups"', '"public"."mdl_groups"."courseid" = "mdl_course"."id" and "public"."mdl_groups"."id" = "gm"."groupid"', 'left');
//info Evaluador
        $this->db->join('"nomina"."ssn_categoria" "cattutdor"', '"cattutdor"."cve_categoria" = "mdl_user"."cat"', 'left');
        $this->db->join('"departments"."ssv_departamentos" "depdor"', '"depdor"."cve_depto_adscripcion" = "mdl_user"."cve_departamental"', 'left');
//info evaluado
        $this->db->join('"tutorias"."mdl_usertutor" "tutdo"', '"tutdo"."nom_usuario"="mdl_user_evaluado"."username" and "tutdo"."id_curso"="mdl_course"."id"', 'left');
        $this->db->join('"nomina"."ssn_categoria" "cattutdo"', '"cattutdo"."cve_categoria" = "tutdo"."cve_categoria"', 'left');
        $this->db->join('"departments"."ssv_departamentos" "depdo"', '"depdo"."cve_depto_adscripcion" = "tutdo"."cve_departamento"', 'left');
    }

    private function get_groupby_CNC_N_NT() {//Select basico tutorizado
        return null;
    }

    /**
     * @author LEAS
     * @date 12/03/2019
     * @param type $is_tutorizados_contestadas, es la condición que aplica para 
     * descartar encuestas que no son validas
     * @return string con la condición que valida si la encuesta debe o no ser tomada encuenta
     */
    private function get_where_encuesta_valida($is_tutorizados_contestadas = FALSE) {
        if ($is_tutorizados_contestadas) {
            $condicion = '(select case when count(*) > 0 then 1 else 0 end
                        FROM mdl_course a
                        JOIN public.mdl_course_config b ON b.course=a.id 
                        JOIN public.mdl_course_categories c ON c.id = a.category
                        JOIN mdl_context d ON d.instanceid = a.id
                        JOIN mdl_role_assignments e ON e.contextid = d.id 
                        JOIN mdl_user f ON f.id = e.userid
                        where a.id = ec.course_cve 
                                and  f.id = uedo.id 
                                and e.roleid = mrdo.id
                        )= 1';
        } else {
            $condicion = '(select case when count(*) > 0 then 1 else 0 end
                    FROM mdl_course a
                    JOIN public.mdl_course_config b ON b.course=a.id 
                    JOIN public.mdl_course_categories c ON c.id = a.category
                    JOIN mdl_context d ON d.instanceid = a.id
                    JOIN mdl_role_assignments e ON e.contextid = d.id 
                    JOIN mdl_user f ON f.id = e.userid
                    where a.id = "mdl_course"."id" 
                            and  f.id = "mdl_user_evaluado"."id" 
                            and e.roleid = "mdl_rol_evaluado"."id"
                    ) = 1';
        }
        return $condicion;
    }

    /**
     * @author LEAS
     * @date 12/03/2019
     * @param type $is_tutorizados_contestadas, es la condición que aplica para 
     * descartar encuestas que no son validas
     * @return string con la condición que valida si la encuesta debe o no ser tomada encuenta
     */
    private function get_select_encuesta_valida($is_tutorizados_contestadas = FALSE) {
        if ($is_tutorizados_contestadas) {
            $condicion = '(select case when count(*) > 0 then 1 else 2 end
                        FROM mdl_course a
                        JOIN public.mdl_course_config b ON b.course=a.id 
                        JOIN public.mdl_course_categories c ON c.id = a.category
                        JOIN mdl_context d ON d.instanceid = a.id
                        JOIN mdl_role_assignments e ON e.contextid = d.id 
                        JOIN mdl_user f ON f.id = e.userid
                        where a.id = ec.course_cve 
                                and  f.id = uedo.id 
                                and e.roleid = mrdo.id
                        ) encuesta_valida';
        } else {
            $condicion = '(select case when count(*) > 0 then 1 else 2 end
                    FROM mdl_course a
                    JOIN public.mdl_course_config b ON b.course=a.id 
                    JOIN public.mdl_course_categories c ON c.id = a.category
                    JOIN mdl_context d ON d.instanceid = a.id
                    JOIN mdl_role_assignments e ON e.contextid = d.id 
                    JOIN mdl_user f ON f.id = e.userid
                    where a.id = "mdl_course"."id" 
                            and  f.id = "mdl_user_evaluado"."id" 
                            and e.roleid = "mdl_rol_evaluado"."id"
                    ) encuesta_valida';
        }
        return $condicion;
    }

}
