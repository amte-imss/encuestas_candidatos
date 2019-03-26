<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Candidatos_nom_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    function get_cursos_preregistro($id_curso = null, $select = array('e.id course_id', 'concat(\'(\', shortname, \') \', fullname) nombre_curso')) {

        $this->db->select($select);
        if (!is_null($id_curso)) {
            $this->db->where('e.id', $id_curso);
        }
        $this->db->join('mdl_course_categories ccat', 'ccat.id = e.category');
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

    function get_candidatos_regstro_curso($clave_curso = null) {
        
    }

    public function get_usuarios_sied($matriculas = null) {
        if (is_null($matriculas) and ! empty($matriculas)) {
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
      , array con la siguiente estructura: nameColumn => [typeJoin , condicionesJoin].
     * Si el join es noramal (typo "inner"), entonces, "nameColumn" contentra la condici{on de join     
     * Posible type de join "right and left"
     * @param type $order_by orden[]
     * @param type $group_by agrupamiento[]
     * @param type $distinct bool, true para que muetre un distinct
     * @return type
     */
    public function getConsutasGenerales($entidad, $select = '*', $array_where = null, $join = null, $order_by = null, $group_by = null, $distinct = false) {
//        pr($entidad . ' => ' . $type_where);
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

}
