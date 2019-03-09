<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Administracion_model
 *
 * @author chrigarc
 */
 class Administracion_model extends CI_Model {

     public function __construct() {
         // Call the CI_Model constructor
         parent::__construct();
         $this->load->database();
     }

     public function get_niveles_acceso(){
        $roles = $this->config->item('roles_moodle');
        $roles_moodle = implode(array_keys($roles), ',');
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            'role_id_array id_grupo', 'B.name nombre', 'description descripcion'
        );
        $this->db->select($select);
        $this->db->from("unnest(array[{$roles_moodle}]) role_id_array");
        $this->db->join('public.mdl_role B', 'role_id_array = B.id', 'inner');
        $niveles = $this->db->get()->result_array();
        $this->db->reset_query();
        return $niveles;
     }
 }
