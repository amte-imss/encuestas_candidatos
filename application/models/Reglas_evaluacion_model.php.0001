<?php   defined('BASEPATH') OR exit('No direct script access allowed');

class Reglas_evaluacion_model extends CI_Model {
  	public function __construct() {
          // Call the CI_Model constructor
          parent::__construct();
          $this->config->load('general');
          $this->load->database();
         
    }
    
    public function user_evaluador(){
        
        $rol_evaluador = $this->config->item('ENCUESTAS_ROL_EVALUADOR');
        $resultado = array();
        
        $this->db->order_by('name');
        
        $query = $this->db->get('public.mdl_role'); //Obtener total de encuestas
        //pr($query);
        //$resultado = $query->result_array();

         if ($query->num_rows() > 0)
        {
            //$data_person = array();
            foreach ($query->result_array() as $row)
            {
                
                if(in_array($row['id'],array_values($rol_evaluador)))
                {
                 $resultado[$row['id']] = $row['name'];
                }
            }
        }
               
        $query->free_result(); //Libera la memoria
        
        //pr($this->db->last_query());
        return $resultado;
    }

    public function user_evaluado(){
        $rol_evalua = $this->config->item('ENCUESTAS_ROL_EVALUA');
        $resultado = array();
        
        $this->db->order_by('name');
        $query = $this->db->get('public.mdl_role'); //Obtener conjunto de encuestas

        //$resultado = $query->result_array();

         if ($query->num_rows() > 0)
        {
            //$data_person = array();
            foreach ($query->result_array() as $row)
            {
                
                if(in_array($row['id'],array_values($rol_evalua)))
                {
                 $resultado[$row['id']] = $row['name'];
                }
            }
        }
               
        $query->free_result(); //Libera la memoria
        
        //pr($this->db->last_query());

        return $resultado;
    }


    public function get_duplicado_regla($rol_evaluado_cve=null,$rol_evaluador_cve=null,$tutorizado=null,$is_bono=null){

        $this->db->from('encuestas.sse_reglas_evaluacion');
        $this->db->where('rol_evaluado_cve', $rol_evaluado_cve);
        $this->db->where('rol_evaluador_cve', $rol_evaluador_cve);
        $this->db->where('tutorizado', $tutorizado);
        $this->db->where('is_bono', $is_bono);
        $consulta = $this->db->get();

        $resultado = $consulta->num_rows();
        if($resultado >= 1)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }    
    
}
