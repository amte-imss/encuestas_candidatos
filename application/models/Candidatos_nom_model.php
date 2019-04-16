<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Candidatos_nom_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    function get_cursos_preregistro($id_curso = null, $select = array('e.id course_id', 'concat(\'(\', shortname, \') \', fullname) nombre_curso')) {

        $this->db->select($select);
        $this->db->join('mdl_course_categories ccat', 'ccat.id = e.category');
        if (!is_null($id_curso)) {
            $this->db->where('e.id', $id_curso);
            $this->db->join('mdl_course_config ccg', 'ccg.course = e.id');
        }
        $this->db->order_by('e.lastdatepre');
        $this->db->order_by('e.shortname');

        $query = $this->db->get('gestion.v_cursos_preregistro e')->result_array();

        return $query;
    }

    function get_candidatos_regstro_implementacion($id_implementacion = null) {
        $select = array(
            "id_candidato", "matricula", "nom", "ap", "am", "id_curso", "cve_curso",
            "email_principal", "cve_categoria", "cve_departamental", "sc.cve_delegacion", "sc.cve_departamental",
            "dep.nom_dependencia", "scd.nom_delegacion", "valido",
        );
        $this->db->where('sc.id_curso', $id_implementacion);
        $this->db->select($select);
        $this->db->join('departments.ssd_cat_delegacion scd', 'scd.cve_delegacion = sc.cve_delegacion', 'inner');
        $this->db->join('departments.ssv_departamentos dep', 'dep.cve_depto_adscripcion = sc.cve_departamental', 'left');
        $query = $this->db->get('encuestas.ssc_candidatos sc')->result_array();
        return $query;
    }

    /**
     * 
     * @param type $clave_implementacion
     * @param type $fecha_inicio
     * @param type $fecha_fin
     */
    function get_candidatos_registro_curso($id_curso, $matriculas = null, $fecha_inicio = null, $fecha_fin = null) {
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        if(is_null($id_curso)){
            return null;
        }
        if (is_null($fecha_inicio) || is_null($fecha_fin)) {
            $select = array('mc.shortname', 'mcg.startdatepre', 'mcg.lastdatepre',
                "to_char(to_timestamp(mc.startdate::double precision), 'YYYY-MM-DD'::text) AS startdate",
                'mcg.lastdate'
            );
            $where = array('mc' => $id_curso);
            $join = array('mdl_course_config mcg' => array('typejoin'=>'inner', 'condicion'=>'mcg.course = mc.id'));
            $result = $this->getConsutasGenerales('mdl_course mc', $select, $where, $join);
            if(empty($result)){
                return null;
            }
            $fecha_inicio = $result[0]['startdatepre'];
            $fecha_fin = $result[0]['lastdate'];
        }
        $select = array('mc.shortname', 'mcg.startdatepre', 'mcg.lastdatepre',
                "to_char(to_timestamp(mc.startdate::double precision), 'YYYY-MM-DD'::text) AS startdate",
                'mcg.lastdate'
            );
    }

    public function get_usuarios_sied($matriculas = null) {
        if (is_null($matriculas) || empty($matriculas)) {
            return [];
        }
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query

        $select = ['tp.cve_curso', 'tp.nom_usuario', 'tu.nom_nombre', 'tu.nom_paterno', 'tu.nom_materno',
            'tp.des_email_pers', 'tp.nom_pwd', 'tu.nom_curp'
        ];
        if (is_array($matriculas)) {//Obtiene informacion de todas las coincidencias
            $separador = '';
            $matriculas_tmp = '';
//            $matriculas = implode($separador, $matriculas);
            foreach ($matriculas as $value) {
                $matriculas_tmp .= $separador . "'" . $value . "'";
                $separador = ',';
            }
            $matriculas = $matriculas_tmp;
        } else {
            $matriculas = "'" . $matriculas . "'";
        }
        $where_no_repetidos = "tp.cve_preregistro in (
                                select max(ptp.cve_preregistro) cve_preregistro_p 
                                from gestion.sgp_tab_preregistro_al ptp 
                                where ptp.nom_usuario in({$matriculas}) 
                                group by ptp.nom_usuario
	)";
        $this->db->select($select);
        $this->db->where($where_no_repetidos);
        $this->db->join("gestion.sgp_tab_usuario tu", "tu.nom_usuario = tp.nom_usuario", "left");
        $query = $this->db->get('gestion.sgp_tab_preregistro_al tp')->result_array();
//        pr($this->db->last_query());
        return $query;
    }

    public function get_usuarios_sied_por_nombre($nombres = null) {
        if (is_null($nombres) || empty($nombres)) {
            return [];
        }
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query

        $select = ['tp.cve_curso', 'tp.nom_usuario', 'tu.nom_nombre', 'tu.nom_paterno', 'tu.nom_materno',
            'tp.des_email_pers', 'tp.nom_pwd', 'tu.nom_curp'
        ];
        if (is_array($nombres)) {//Obtiene informacion de todas las coincidencias
            $separador = '';
            $matriculas_tmp = '';
//            $matriculas = implode($separador, $matriculas);
            foreach ($nombres as $value) {
                $matriculas_tmp .= $separador . "'" . $value . "'";
                $separador = ',';
            }
            $nombres = $matriculas_tmp;
        } else {
            $nombres = "'" . $nombres . "'";
        }
        $where_no_repetidos = "tp.cve_preregistro in (
                                select max(ptp.cve_preregistro) cve_preregistro_p 
                                from gestion.sgp_tab_preregistro_al ptp 
                                where ptp.nom_usuario in({$nombres}) 
                                group by ptp.nom_usuario
	)";
        $this->db->select($select);
        $this->db->where($where_no_repetidos);
        $this->db->join("gestion.sgp_tab_usuario tu", "tu.nom_usuario = tp.nom_usuario", "left");
        $query = $this->db->get('gestion.sgp_tab_preregistro_al tp')->result_array();
//        pr($this->db->last_query());
        return $query;
    }

    /**
     * 
     * @param type $matriculas
     * @param type $clave_curso
     * @return type
     */
    public function get_usuarios_curso_aprobado($matriculas, $clave_curso) {

        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        $select = ['us.username', 'b.code certificados', 'shortname'];
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        $this->db->select($select); //Reset result query
        $this->db->join('public.mdl_customcert_issues b', 'b.customcertid = a.id'); //Reset result query
        $this->db->join('cert.ssc_tab_cert_issues_conf c', 'c.cert_issues_id = b.id'); //Reset result query
        $this->db->join('public.mdl_course mc', 'mc.id = a.course'); //Reset result query
        $this->db->join('public.mdl_user us', 'us.id = c.userid'); //Reset result query
        $this->db->where('substring(mc.shortname from 1 for position(substring(mc.shortname from $$\-\w\d+\-\d+$$) in mc.shortname)-1) = \'' . $clave_curso . '\'', null); //Reset result query
        $this->db->where_in('us.username', $matriculas); //Reset result query
        $reslult = $this->db->get('public.mdl_customcert a')->result_array();
        return $reslult;
    }

    /**
     * 
     * @param type $entidad Nombre de la tabla principal
     * @param type $select
      , es un array con el nombre de las columnas que mostrara la consulta
     * @param type $array_where
      , array con la siguiente estructura: nameColumn => [typeWhere, valorWhere].
     * Si el where es noramal (typo "and"), entonces, "nameColumn" contentra el valor solicitado (no array ni objeto)
     * posible valor de typeWhere: "or_where_in, where_not_in, where, 
     * @param type $join
      , array con la siguiente estructura: nametabla => [typejoin , condicion].
     * Si el join es noramal (typo "inner"), entonces, "nameColumn" contentra la condici{on de join     
     * Posible type de join "right and left"
     * @param type $order_by orden[]
     * @param type $group_by agrupamiento[]
     * @param type $distinct bool, true para que muetre un distinct
     * @return type
     */
    public function getConsutasGenerales($entidad, $select = '*', $array_where = null, $join = null, $order_by = null, $group_by = null, $distinct = false) {
//        pr($entidad . ' => ' . $type_where);
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        if (!is_null($array_where)) {
            foreach ($array_where as $key => $value) {
                if (is_array($value)) {
                    $typeWhere = $value['typeWhere'];
                    $this->db->{$typeWhere}($key, $value['valueWhere']);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }

        if ($distinct) {
            $this->db->distint();
        }

        if (!is_null($join)) {
            foreach ($join as $key_join => $value_join) {
                $this->db->join($key_join, $value_join['condicion'], $value_join['typejoin']);
            }
        }

        $this->db->select($select); //Asigna el select de la consulta 

        if (!is_null($order_by)) {
            if (is_array($order_by)) {
                foreach ($order_by as $column => $ascdesc) {
                    $this->db->order_by($column, $ascdesc);
                }
            } else {
                $this->db->order_by($order_by);
            }
        }
        if (!is_null($group_by)) {
            $this->db->group_by($group_by);
        }
        if (!is_null($order_by)) {
            if (is_array($order_by)) {
                foreach ($order_by as $column => $ascdesc) {
                    $this->db->order_by($column, $ascdesc);
                }
            } else {
                $this->db->order_by($order_by);
            }
        }
        $query = $this->db->get($entidad);
        $resultArray = $query->result_array();
        $query->free_result();
//        pr($this->db->last_query());
        return $resultArray;
    }

    public function delete_registro_general($entidad, $array_where, $texts = []) {
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        $result = ['tp_msg' => En_general::DANGER, 'msg' => ''];
        $this->db->trans_begin();
        if (!is_null($array_where)) {
            foreach ($array_where as $key => $value) {
                if (is_array($value)) {
                    $typeWhere = $value['typeWhere'];
                    $this->db->{$typeWhere}($key, $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
            $this->db->delete($entidad);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $result = ['tp_msg' => En_general::SUCCESS, 'msg' => ''];
            }
        }
        return $result;
    }

    public function insert_registro_general($entidad, $datos, $texts = [], $identificador = null) {
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        $result = ['tp_msg' => En_general::DANGER, 'msg' => ''];
        $this->db->trans_begin();
        $this->db->insert($entidad, $datos);
        if (!is_null($identificador)) {
            $datos[$identificador] = $this->db->insert_id();
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $result = ['tp_msg' => En_general::SUCCESS, 'msg' => ''];
            $result['data'] = $datos;
        }
        return $result;
    }

    public function update_registro_general($entidad, $data, $array_where, $texts = []) {
        $this->db->flush_cache(); //Limpia cache
        $this->db->reset_query(); //Reset result query
        $result = ['tp_msg' => En_general::DANGER, 'msg' => ''];
        $this->db->trans_begin();
        foreach ($array_where as $key => $value) {
            if (is_array($value)) {
                $typeWhere = $value['typeWhere'];
                $this->db->{$typeWhere}($key, $value);
            } else {
                $this->db->where($key, $value);
            }
        }
        $this->db->update($entidad, $data);
//        pr($this->db->last_query());
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $result = ['tp_msg' => En_general::SUCCESS, 'msg' => ''];
        }
        return $result;
    }

}
