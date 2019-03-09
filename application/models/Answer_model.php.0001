<?php   defined('BASEPATH') OR exit('No direct script access allowed');

class Answer_model extends CI_Model {
  	public function __construct() {
          // Call the CI_Model constructor
          parent::__construct();
          $this->config->load('general');
          //$this->load->database();
    }
    
    public function getQuestionnaire(){
        $this->load->database();
        $query = $this->db->get('encuestas.sse_encuesta_curso'); //Obtener conjunto de encuestas
        $resultado = $query->result_array();
        
        $query->free_result(); //Libera la memoria

        return $resultado;
    }
}