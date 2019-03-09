<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_bonos_implementacion_model extends CI_Model {

    private $confFind;

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->config->load('general');
        $this->load->database();
        $this->confFind = new config_busqueda();
    }

    public function get_query_calculo($param_calculo) {
//        pr($param_calculo);
        foreach ($param_calculo['join'] as $value) {//Aplica joins
            $this->db->join($value['tabla'], $value['on'], $value['escape']);
        }

        foreach ($param_calculo['group_by'] as $value) {//Aplica group by
            $this->db->group_by($value);
        }
        if (isset($param_calculo['where']) AND ! empty($param_calculo['where'])) {
            foreach ($param_calculo['where'] as $value) {//Aplica group by
//            pr($value);
                $funcion = $value['escape'];
                $this->db->{$funcion}($value['campo'], $value['value']);
            }
        }
        $this->db->select($param_calculo['select']); //Agrega select para traer los campos 
        $ejecuta = $this->db->get($this->confFind->getFromCalculoPromedio());
        $result = $query = $ejecuta->result_array();
//        $query->free_result();
//        pr($this->db->last_query());
//        pr($result);
        $datos_result['datos'] = array();
        foreach ($result as $val) {
//            if (isset($val['mdl_groups_cve']) AND isset($val['bloque'])) {
//                $datos_result['datos'][$val['course_cve']][$val['evaluado_user_cve']][$val['tutorizado']][$val['rol_evaluado_cve'] . '-' . $val['rol_evaluador_cve']][$val['bloque']][$val['mdl_groups_cve']] = $val;
//            } else if (isset($val['bloque'])) {
//                $datos_result['datos'][$val['course_cve']][$val['evaluado_user_cve']][$val['tutorizado']][$val['rol_evaluado_cve'] . '-' . $val['rol_evaluador_cve']][$val['bloque']] = $val;
//            } else {
                $datos_result['datos'][$val['course_cve']][$val['evaluado_user_cve']][$val['rol_evaluador_cve'] . '-' . $val['rol_evaluado_cve'] . '-' . $val['tutorizado']] = $val;
//            }
        }
//        pr($datos_result);
        return $datos_result;
    }

    public function get_reporte_bonos_implementacion($parametros) {
        $array_result = $this->confFind->getArrayConfigPrincipal($parametros);
//        pr($array_result);
//        exit();
        $array_config_principal = $array_result['principal'];
//        pr($array_result);
//        exit();
        $this->db->start_cache();/**         * *************Inicio cache  *************** */
//        $this->db->from($this->confFind->getFrom());
        foreach ($array_config_principal['join'] as $value) {//Aplica joins
            $this->db->join($value['tabla'], $value['on'], $value['escape']);
        }

        foreach ($array_config_principal['group_by'] as $value) {//Aplica group by
            $this->db->group_by($value);
        }
        foreach ($array_config_principal['where'] as $value) {//Aplica group by
//            pr($value);
            $funcion = $value['escape'];
            $this->db->{$funcion}($value['campo'], $value['value']);
        }
        $this->db->stop_cache();
        $num_rows = $this->db->query($this->db->select('count(*) as total, eeec.course_cve, evaluado_user_cve')->get_compiled_select($this->confFind->getFrom()))->result();
        $this->db->reset_query(); //Reset de query 
//        pr($this->db->last_query());
        $this->db->select($array_config_principal['select']); //Agrega select para traer los campos 

        if (isset($parametros['per_page']) && isset($parametros['current_row'])) { //Establecer límite definido para paginación 
            $this->db->limit($parametros['per_page'], $parametros['current_row']);
        }

        $order_type = (isset($parametros['order_type'])) ? $parametros['order_type'] : 'asc';
        if (isset($parametros['order']) and ! empty($parametros['order'])) { //Establecer límite definido para paginación 
            $orden = $parametros['order'];
//            $this->db->order_by($orden, $order_type);
        }

        $ejecuta = $this->db->get($this->confFind->getFrom()); //Prepara la consulta ( aún no la ejecuta)
        $query = $ejecuta->result_array();

        $this->db->flush_cache(); //Limpia la cache
//        pr($this->db->last_query());
//        exit();
        //Resultados de cálculo de promedios 
        $array_config_calculo = $array_result['calculo_prom'];
//        pr($num_rows);
        $parametros['is_bloque_o_grupo'] = '';//Quitar cuando se implemente filtro por bloque y grupos
        $result['result'] = $query;
        $result['result_promedio'] = $this->get_query_calculo($array_config_calculo, $parametros['is_bloque_o_grupo']);
        $result['num_rows'] = $num_rows;
        $result['total'] = count($num_rows);
//        $query->free_result();
        return $result;
    }

}

class config_busqueda {

    function getSelectBasicos() {
        return array(
            'eeec.course_cve', 'eeec.evaluado_user_cve', 'vdc.clave', 'vdc.namec', 'vdc.tex_tutorizado', 'vdc.tutorizado',
            'vdc.tipo_curso', 'enc.is_bono', "concat(evaluado.firstname, ' ', evaluado.lastname) as name_evaluado",
            "evaluado.username", 'revaluado."name" as "name_rol_evaluado"', 'revaluado.id "id_rol_evaluado"',
            'vd.name_region', 'reg.rol_evaluador_cve', 'vd.cve_depto_adscripcion', 'vd.nom_delegacion',
            //"(select * from departments.get_rama_completa(vd.cve_depto_adscripcion, 7)) as rama_ads_evaluado"
            "(select * from departments.get_unidad(vd.cve_depto_adscripcion, 7)) as rama_ads_evaluado"
        );
    }

    function getFrom() {
        return 'encuestas.sse_result_evaluacion_encuesta_curso eeec';
    }

    private function getJoinBasicos() {
        return array(
            array('tabla' => 'encuestas.view_datos_curso vdc', 'on' => 'vdc.idc = eeec.course_cve', 'escape' => ''),
            array('tabla' => 'public.mdl_user evaluado', 'on' => 'evaluado.id = eeec.evaluado_user_cve', 'escape' => ''),
            array('tabla' => 'tutorias.mdl_userexp uexp', 'on' => 'uexp.userid = evaluado.id', 'escape' => ''),
            array('tabla' => 'departments.ssv_departamentos vd', 'on' => 'vd.cve_depto_adscripcion = evaluado.cve_departamental', 'escape' => 'left'),
            array('tabla' => 'encuestas.sse_encuestas enc', 'on' => 'enc.encuesta_cve = eeec.encuesta_cve', 'escape' => ''),
            array('tabla' => 'encuestas.sse_reglas_evaluacion reg', 'on' => 'reg.reglas_evaluacion_cve = enc.reglas_evaluacion_cve', 'escape' => ''),
            array('tabla' => 'public.mdl_role revaluado', 'on' => 'revaluado.id=reg.rol_evaluado_cve', 'escape' => 'left'),
                //array('tabla' => 'encuestas.sse_curso_bloque_grupo cbg', 'on' => 'cbg.course_cve = vdc.idc and cbg.mdl_groups_cve = eeec.group_id', 'escape' => ''),
        );
    }

    function getGroupByBasico() {
        return array(
            'eeec.course_cve', 'vdc.clave', 'vdc.namec', 'evaluado_user_cve', 'vdc.tutorizado',
            'vdc.tex_tutorizado', 'vdc.tipo_curso', 'enc.is_bono',
            'evaluado.firstname',
            'evaluado.lastname', 'evaluado.username', 'revaluado."name"', 'revaluado.id',
            'vd.name_region', 'vd.cve_depto_adscripcion', 'vd.nom_delegacion', 'reg.rol_evaluador_cve'
        );
    }

    /**  querys para grupo y bloque */
    function getSelectBloque() {
        return array('cbg.bloque');
    }

    function getGroupByBloque() {
        return array('cbg.bloque');
    }

    /**  querys para grupo y bloque */
    function getSelectGrupo() {
        return array('cbg.mdl_groups_cve');
    }

    function getGroupByGrupo() {
        return array('cbg.mdl_groups_cve');
    }

    function getWhere() {
        return array(
            'clavecurso' => array('campo' => 'vdc.clave', 'escape' => 'like', 'value' => ''),
            'nombrecurso' => array('campo' => 'vdc.namec', 'escape' => 'like', 'value' => ''),
            'namedocentedo' => array('campo' => 'concat(evaluado.lastname, evaluado.firstname)', 'escape' => 'like', 'value' => ''),
            'matriculado' => array('campo' => 'evaluado.username', 'escape' => 'like', 'value' => ''),
            'grupo' => array('campo' => 'cbg.mdl_groups_cve', 'escape' => 'where', 'value' => ''),
            'bloque' => array('campo' => 'cbg.bloque', 'escape' => 'where', 'value' => ''),
            'rol_evaluado' => array('campo' => 'revaluado.id', 'escape' => 'where', 'value' => ''),
            'region' => array('campo' => 'vd.cve_regiones', 'escape' => 'where', 'value' => ''),
            'delegacion' => array('campo' => 'vd.cve_delegacion', 'escape' => 'where', 'value' => ''),
            'umae' => array('campo' => 'evaluado.cve_departamental', 'escape' => 'where', 'value' => ''),
            'is_bono' => array('campo' => 'enc.is_bono', 'escape' => 'where', 'value' => ''),
            'tipo_implementacion' => array('campo' => 'vdc.tutorizado', 'escape' => 'where', 'value' => ''),
            'anio' => array('campo' => 'vdc.anio', 'escape' => 'where', 'value' => ''),
        );
    }

    /* -----------Cálculo Promedió  ------------------------------- */

    function getSelectBasicoCalculoPromedio() {
        return array(
            'eeec.course_cve', 'reg.tutorizado',
            'eeec.evaluado_user_cve', 'enc.is_bono',
            'reg.rol_evaluado_cve', 'reg.rol_evaluador_cve',
            //'round(sum(total_puntua_si)::numeric * 100/sum(base)::numeric,3) as promedio',
            'case sum(base) when 0 then 
                0
            else 
                round(sum(total_puntua_si)::numeric * 100/sum(base)::numeric,3)
            end as promedio'
        );
    }

    private function getJoinBasicosCalculoPromedio() {
        return array(
            array('tabla' => 'encuestas.sse_encuesta_curso encc', 'on' => 'encc.course_cve = eeec.course_cve and encc.encuesta_cve = eeec.encuesta_cve', 'escape' => ''),
            array('tabla' => 'encuestas.sse_encuestas enc', 'on' => 'enc.encuesta_cve = eeec.encuesta_cve', 'escape' => ''),
            array('tabla' => 'encuestas.sse_reglas_evaluacion reg', 'on' => 'reg.reglas_evaluacion_cve = enc.reglas_evaluacion_cve', 'escape' => ''),
            array('tabla' => 'public.mdl_user evaluador', 'on' => 'evaluador.id = eeec.evaluado_user_cve', 'escape' => ''),
            array('tabla' => 'tutorias.mdl_userexp uexp', 'on' => 'uexp.userid = evaluador.id', 'escape' => ''),
            //array('tabla' => 'encuestas.sse_curso_bloque_grupo cbg', 'on' => 'cbg.course_cve = eeec.course_cve and cbg.mdl_groups_cve = eeec.group_id', 'escape' => ''),
        );
    }

    function getGroupByBasicoCalculoPromedio() {
        return array(
            'eeec.course_cve', 'reg.tutorizado', 'enc.is_bono', 'eeec.evaluado_user_cve', 'reg.rol_evaluado_cve', 'rol_evaluador_cve'
        );
    }

    function getWhereCalculoPromedio() {
        return array(
            'course_cve' => array('campo' => 'eeec.course_cve', 'escape' => 'where', 'value' => ''),
            'evaluado_user_cve' => array('campo' => 'evaluado_user_cve', 'escape' => 'where', 'value' => ''),
            'rol_evaluado' => array('campo' => 'reg.rol_evaluado_cve', 'escape' => 'where', 'value' => ''),
        );
    }

    function getFromCalculoPromedio() {
        return 'encuestas.sse_result_evaluacion_encuesta_curso eeec';
    }

    function getArrayConfigSecundario($paramPost) {
        if($paramPost['tutorizado'] == 1){//Cursos tutorizados
            
        }else{//Cursos no tutorizados
            
        }
    }
    
    function getArrayConfigPrincipal($paramPost) {
//        pr($paramPost);
        //***Carga arrays con datos basicos de la consulta principal
        $array_where = $this->getWhere(); //Obtiene colección de posibles where
        $array_where_calculo_promedio = $this->getWhereCalculoPromedio(); //Obtiene colección de posibles where
        $principal['join'] = $this->getJoinBasicos();
        $principal['group_by'] = $this->getGroupByBasico();
        $principal['select'] = $this->getSelectBasicos();
        $principal['where'] = array();
        //***Carga arrays con datos del cálculo del prmedio 
        $calculo_prom['join'] = $this->getJoinBasicosCalculoPromedio();
        $calculo_prom['group_by'] = $this->getGroupByBasicoCalculoPromedio();
        $calculo_prom['select'] = $this->getSelectBasicoCalculoPromedio();

        //Agregar el grupo como agrupamiento en el grup by y el select
        $paramPost['is_bloque_o_grupo'] = '';//Para evitar error, quitar después
        switch ($paramPost['is_bloque_o_grupo']) {
            case 'grupo':
                $principal['select'] = array_merge($principal['select'], $this->getSelectBloque(), $this->getSelectGrupo());
                $principal['group_by'] = array_merge($principal['group_by'], $this->getGroupByBloque(), $this->getGroupByGrupo());
                $calculo_prom['select'] = array_merge($calculo_prom['select'], $this->getSelectBloque(), $this->getSelectGrupo());
                $calculo_prom['group_by'] = array_merge($calculo_prom['group_by'], $this->getGroupByBloque(), $this->getGroupByGrupo());
                break;
            case 'bloque':
                $principal['select'] = array_merge($principal['select'], $this->getSelectBloque());
                $principal['group_by'] = array_merge($principal['group_by'], $this->getGroupByBloque());
                $calculo_prom['select'] = array_merge($calculo_prom['select'], $this->getSelectBloque());
                $calculo_prom['group_by'] = array_merge($calculo_prom['group_by'], $this->getGroupByBloque());
                break;
            default :
        }

        //Verifica primer where referente con la clave o nommbre del curso
        if (isset($paramPost['text_buscar_instrumento']) AND ! empty($paramPost['text_buscar_instrumento'])) {//Texto del curso
            $tmp_where = $array_where[$paramPost['tipo_buscar_instrumento']];
            $tmp_where['value'] = $paramPost['text_buscar_instrumento'];
            $principal['where'][] = $tmp_where; //Agrega where de curso-clave de curso
        }
//        Condición por rol del evaluado;
        if (!empty($paramPost['rol_evaluado'])) {
            //condición where para el rol evaluado
            $tmp_where = $array_where['rol_evaluado'];
            $tmp_where['value'] = $paramPost['rol_evaluado'];
            $principal['where'][] = $tmp_where;

            /* ---Agrega rol para calculo */
            //condición where para el rol evaluado cálculo promedio
            $tmp_where = $array_where_calculo_promedio['rol_evaluado'];
            $tmp_where['value'] = $paramPost['rol_evaluado'];
            $calculo_prom['where'][] = $tmp_where;
        }
        //Condición delegación del evaluado
        if (!empty($paramPost['delegacion'])) {
            $tmp_where = $array_where['delegacion'];
            $tmp_where['value'] = $paramPost['delegacion'];
            $principal['where'][] = $tmp_where; //Agrega where de curso-clave de curso
        }
        //Condición umae del evaluado
        if (!empty($paramPost['umae'])) {
            $tmp_where = $array_where['umae'];
            $tmp_where['value'] = $paramPost['umae'];
            $principal['where'][] = $tmp_where; //Agrega where de curso-clave de curso
        }
        //Condición por región
        if (!empty($paramPost['region'])) {
            $tmp_where = $array_where['region'];
            $tmp_where['value'] = $paramPost['region'];
            $principal['where'][] = $tmp_where; //Agrega where de curso-clave de curso
        }
        //Condición por región
        if (is_numeric($paramPost['is_bono'])) {
//            pr($paramPost['is_bono']);
            $tmp_where = $array_where['is_bono'];
            $tmp_where['value'] = $paramPost['is_bono'];
            $principal['where'][] = $tmp_where; //Agrega where de curso-clave de curso
        }

        //Condición por región
        if (is_numeric($paramPost['tipo_implementacion'])) {
//            pr($paramPost['tipo_implementacion']);
            $tmp_where = $array_where['tipo_implementacion'];
            $tmp_where['value'] = $paramPost['tipo_implementacion'];
            $principal['where'][] = $tmp_where; //Agrega where de curso-clave de curso
        }
        //Condición por región
        if (!empty($paramPost['anio'])) {
            $tmp_where = $array_where['anio'];
            $tmp_where['value'] = $paramPost['anio'];
            $principal['where'][] = $tmp_where; //Agrega where de curso-clave de curso
        }

        //Verifica where para busqueda del evaluado matrucula y nombre
        if (isset($paramPost['text_buscar_docente_evaluado']) AND ! empty($paramPost['text_buscar_docente_evaluado'])) {//Texto del curso
            $tmp_where = $array_where[$paramPost['tipo_buscar_docente_evaluado']];
            $tmp_where['value'] = $paramPost['text_buscar_docente_evaluado'];
            $principal['where'][] = $tmp_where; //Agrega where de curso-clave de curso
        }
        //Verifica where para busqueda del evaluado matrucula y nombre

        $result['principal'] = $principal; //Guarda datos de la consulta principal
        $result['calculo_prom'] = $calculo_prom; //Guarda datos de la consulta principal
        return $result;
    }

}
