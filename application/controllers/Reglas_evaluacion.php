<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona las reglas de evaluacion
 * @version     : 1.0.0
 * @autor       : Hilda Pilar Trejo Zea
 */
class Reglas_evaluacion extends MY_Controller {

    /**
     * * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     * * @access        : public
     * * @modified  : 
     */
    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->db->schema = 'encuestas';
        $this->load->library('form_complete'); // form complete
        $this->load->library('form_validation'); //implemantación de la libreria form validation
        $this->load->library('grocery_CRUD');
        $this->load->model('Reglas_evaluacion_model','reglas');                              
      
    }


    public function new_crud(){
        $db_driver = $this->db->platform();
        $model_name = 'Grocery_crud_model_'.$db_driver;
        $model_alias = 'm'.substr(md5(rand()), 0, rand(4,15) );
        unset($this->{$model_name});
        $this->load->library('grocery_CRUD');
        $crud = new Grocery_CRUD();
        if (file_exists(APPPATH.'/models/'.$model_name.'.php')){
            $this->load->model('Grocery_crud_model');
            $this->load->model('Grocery_crud_generic_model');
            $this->load->model($model_name,$model_alias);
            $crud->basic_model = $this->{$model_alias};
        }
        $crud->set_theme('datatables');
        $crud->unset_print();
        return $crud;
    }

    public function index() {
         
        

   
        try{
           $crud = $this->new_crud();

           $crud->set_table('sse_reglas_evaluacion')
               ->set_subject('Reglas_evaluacion')
               ->columns('reglas_evaluacion_cve','rol_evaluador_cve','rol_evaluado_cve','tutorizado','is_bono')
               ->display_as('reglas_evaluacion_cve','No. de regla')
               ->display_as('rol_evaluado_cve','Rol evaluado')
               ->display_as('rol_evaluador_cve','Rol evaluador')
               //->display_as('is_excepcion','Excepción')
               ->display_as('tutorizado','Tutorizado')
               ->display_as('is_bono','Aplica para bono');
               //->display_as('ord_prioridad','Orden de priodidad')
               //->display_as('eval_is_satisfaccion','Satisfacción');
            
           $crud->add_fields('rol_evaluador_cve','rol_evaluado_cve','tutorizado','is_bono');
           $crud->edit_fields('rol_evaluador_cve','rol_evaluado_cve','tutorizado','is_bono');
           $crud->required_fields('rol_evaluador_cve','rol_evaluado_cve','tutorizado','is_bono');
           //$crud->set_rules('descripcion','Nombre sección','required|alpha_numeric_accent_space');
           //$crud->order_by('reglas_evaluacion_cve','ASC');
           $crud->change_field_type('tutorizado','true_false',array(0=>'No',1=>'Si'));
           $crud->change_field_type('is_bono','true_false',array(0=>'No',1=>'Si'));
          

          
           $rol_evaluador = $this->reglas->user_evaluador();
           //pr($rol_evaluador);
           $rol_evaluado = $this->reglas->user_evaluado();
           //pr($rol_evaluado);
           
           $crud->field_type('rol_evaluado_cve','dropdown', $rol_evaluado);
           $crud->field_type('rol_evaluador_cve','dropdown', $rol_evaluador);
               
           $crud->unset_read();
           $crud->callback_before_insert(array($this,'verificar_existencia_callback'));
           $crud->callback_before_update(array($this,'verificar_existencia_callback'));


           $output = $crud->render();
           /*pr($output);
           exit();
           */

        //$this->load->view('reglas/reglas_evaluacion',$output);           
        $this->template->setMainContent($this->load->view('reglas/reglas_evaluacion',$output, TRUE));
        $this->template->getTemplate();

        }catch(Exception $e){
        show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
           



    }


    
    public function verificar_existencia_callback($post_array)
    {
  
         $noduplicado=$this->reglas->get_duplicado_regla($post_array['rol_evaluado_cve'],$post_array['rol_evaluador_cve'],$post_array['tutorizado'],$post_array['is_bono']);
         
         if($noduplicado == 0)
         {
          return $post_array;
         }
         else
         {

          $this->form_validation->set_message('verificar_existencia','Ya existe una regla con esas características');
          return false;
         }
    } 


}    
    

