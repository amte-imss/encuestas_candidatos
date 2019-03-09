<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogos extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        //$dbn = $this->load->database();
        $this->load->library('form_validation');
        $this->load->library('grocery_CRUD');
        $this->load->model('Catalogos_model','catalogos');
        //pr($db->schema);
        //
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
        //pr($crud);
        $crud->unset_print();
        return $crud;
    }

    public function index() {
        redirect(site_url());
    }
    /**
     * Crud para ssn_categoria
     * @author JZDP
     */
    public function categoria() {
        try{
            $this->db->schema = 'nomina';
            //pr($this->db->list_tables());
            $crud = $this->new_crud();
            //$crud = new grocery_CRUD();
            $crud->set_table('ssn_categoria')
                ->set_subject('Categoría')
                ->columns('cve_categoria','nom_nombre','cve_tipo_categoria','des_clave','num_jornada','num_class','des_tipo_nomina','ind_baja')
                ->display_as('cve_categoria','ID')
                ->display_as('des_clave','Clave')
                ->display_as('nom_nombre','Nombre de categoría')
                ->display_as('cve_tipo_categoria','Tipo')
                ->display_as('num_jornada','Jornada')
                ->display_as('num_class','Class')
                ->display_as('des_tipo_nomina','Tipo nomina');
            $crud->set_relation('cve_tipo_categoria','ssn_tipo_catgoria','nom_nombre');
            
            //$crud->fields('cve_categoria','nom_nombre','cve_tipo_categoria','des_clave','num_jornada','num_class','des_tipo_nomina','ind_baja');
            //$crud->edit_fields('nom_nombre','cve_tipo_categoria','des_clave','num_jornada','num_class','des_tipo_nomina');
            $crud->required_fields('nom_nombre','cve_tipo_categoria','des_clave','num_jornada','num_class','des_tipo_nomina','ind_baja');
            //$crud->set_rules('descripcion','Nombre sección','required|alpha_numeric_accent_space');
            $crud->order_by('nom_nombre','ASC');
            $crud->unset_add();
            $crud->unset_delete();
            //$crud->unset_read();
            
            $output = $crud->render();
            
            $this->template->setMainContent($this->load->view('gc_output',$output, TRUE));
            $this->template->getTemplate();
        } catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    /**
     * Grud para ssd_cat_depto_adscripcion
     * @author JZDP
     */
    public function departamento() {
        try{
            $this->db->schema = 'departments';
            $crud = $this->new_crud();
            $crud->set_table('ssd_cat_depto_adscripcion')
                ->set_subject('Depto. Adscripción')
                ->columns('cve_depto_adscripcion','nom_depto_adscripcion','cve_depto_adscripcion_padre','des_nombre_completo','id_tipo_adscripcion','ind_baja','ind_unidad');
            
            //$crud->set_relation('cve_depto_adscripcion_padre','ssd_cat_depto_adscripcion','nom_depto_adscripcion');
            //$crud->fields('cve_categoria','nom_nombre','cve_tipo_categoria','des_clave','num_jornada','num_class','des_tipo_nomina','ind_baja');
            //$crud->edit_fields('ind_unidad');
            $crud->required_fields('cve_depto_adscripcion_padre','nom_depto_adscripcion','cve_depto_adscripcion_padre','id_tipo_adscripcion','ind_baja','ind_unidad');
            //$crud->set_rules('descripcion','Nombre sección','required|alpha_numeric_accent_space');
            $crud->order_by('nom_depto_adscripcion','ASC');
            $crud->unset_add();
            $crud->unset_delete();
            //$crud->unset_read();
            
            $output = $crud->render();
            
            $this->template->setMainContent($this->load->view('gc_output',$output, TRUE));
            $this->template->getTemplate();
        } catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
    
    /**
     * Grud para ssd_cat_delegacion
     * @author JZDP
     */
    public function delegacion() {
        try{
            $this->db->schema = 'departments';
            //pr($this->db->list_tables());
            $crud = $this->new_crud();
            //$crud = new grocery_CRUD();
            $crud->set_table('ssd_cat_delegacion');
            
            //$crud->set_relation('cve_depto_adscripcion_padre','ssd_cat_depto_adscripcion','nom_depto_adscripcion');
            
            //$crud->fields('');
            //$crud->edit_fields('');
            //$crud->required_fields('');
            //$crud->set_rules('descripcion','Nombre sección','required|alpha_numeric_accent_space');
            $crud->order_by('nom_delegacion','ASC');
            $crud->unset_add();
            $crud->unset_delete();
            //$crud->unset_read();
            
            $output = $crud->render();
            
            $this->template->setMainContent($this->load->view('gc_output',$output, TRUE));
            $this->template->getTemplate();
        } catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
    
    public function region() {
        try{
            $this->db->schema = 'departments';
            $crud = $this->new_crud();
            $crud->set_table('ssd_regiones');
            $crud->order_by('name_region','ASC');
            $crud->unset_delete();
            
            $output = $crud->render();
            
            $this->template->setMainContent($this->load->view('gc_output',$output, TRUE));
            $this->template->getTemplate();
        } catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
    
    public function designar_autoeveluaciones() {
        try{
            $this->db->schema = 'encuestas';
            $crud = $this->new_crud();
            $crud->set_table('sse_designar_autoeveluaciones');
            $crud->order_by('course_cve','ASC');
            $crud->unset_delete();
            
            $output = $crud->render();
            
            $this->template->setMainContent($this->load->view('gc_output',$output, TRUE));
            $this->template->getTemplate();
        } catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
    
    public function indicador() {
        try{
            $this->db->schema = 'encuestas';
            $crud = $this->new_crud();
            $crud->set_table('sse_indicador');
            $crud->order_by('descripcion','ASC');
            $crud->unset_delete();
            
            $output = $crud->render();
            
            $this->template->setMainContent($this->load->view('gc_output',$output, TRUE));
            $this->template->getTemplate();
        } catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
    
    public function modulo() {
        try{
            $this->db->schema = 'encuestas';
            $crud = $this->new_crud();
            $crud->set_table('sse_modulo');
            $crud->order_by('modulo_cve','ASC');
            //$crud->unset_delete();
            
            $output = $crud->render();
            
            $this->template->setMainContent($this->load->view('gc_output',$output, TRUE));
            $this->template->getTemplate();
        } catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
    
    public function modulo_rol() {
        try{
            $this->db->schema = 'encuestas';
            $crud = $this->new_crud();
            $crud->set_table('sse_modulo');
            $crud->order_by('modulo_cve','ASC');
            $crud->set_relation_n_n('roles', 'sse_modulo_rol', 'mdl_role', 'modulo_cve', 'role_id', 'name');
            $crud->unset_delete();
            $crud->fields('modulo_cve','roles');
            $crud->edit_fields('modulo_cve','roles');
            
            $crud->callback_after_insert(array($this,'modulo_rol_acceso_callback'));
            $crud->callback_after_update(array($this,'modulo_rol_acceso_callback'));
            
            $output = $crud->render();
            //pr($this->db->last_query());
            $this->template->setMainContent($this->load->view('gc_output',$output, TRUE));
            $this->template->getTemplate();
        } catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
    
    public function modulo_rol_acceso_callback($post_array){
        if(in_array($post_array['modulo_cve'], array(En_modulos::CATALOGOS, En_modulos::CATALOGOS,
            En_modulos::GESTION, En_modulos::REPORTES, En_modulos::ENCUESTAS, 
            En_modulos::IMPLEMENTACIONES, En_modulos::EVALUACION_ENCUESTAS))){
            $this->catalogos->actualizar_modulo_rol($post_array); //Actualizar acceso
        }
        return $post_array;
    }
    
    public function pregunta() {
        try{
            $this->db->schema = 'encuestas';
            $crud = $this->new_crud();
            $crud->set_table('sse_preguntas');
            $crud->set_relation('tipo_pregunta_cve','sse_tipo_pregunta','descripcion');
            $crud->set_relation('seccion_cve','sse_seccion','descripcion');
            $crud->set_relation('tipo_indicador_cve','sse_indicador','descripcion');
            $crud->order_by('encuesta_cve','ASC');
            $crud->unset_delete();
            
            $output = $crud->render();
            
            $this->template->setMainContent($this->load->view('gc_output',$output, TRUE));
            $this->template->getTemplate();
        } catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
    
    public function reglas_evaluacion() {
        try{
            $this->db->schema = 'encuestas';
            $crud = $this->new_crud();
            $crud->set_table('sse_reglas_evaluacion');
            $crud->set_primary_key('reglas_evaluacion_cve','sse_reglas_evaluacion');
            $crud->set_relation('rol_evaluado_cve','mdl_role','name');
            $crud->set_relation('rol_evaluador_cve','mdl_role','name');
            $crud->order_by('reglas_evaluacion_cve','ASC');
            $crud->unset_delete();
            
            $output = $crud->render();
            
            $this->template->setMainContent($this->load->view('gc_output',$output, TRUE));
            $this->template->getTemplate();
        } catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
    
    /*public function respuesta() {
        try{
            $this->db->schema = 'encuestas';
            $crud = $this->new_crud();
            $crud->set_table('sse_respuestas');
            //$crud->set_primary_key('sse_encuestas','encuesta_cve');
            //$crud->set_primary_key('preguntas_cve','sse_preguntas');
            $crud->set_primary_key('sse_respuestas','reactivos_cve');
            $crud->set_relation('encuesta_cve','sse_encuestas','descripcion_encuestas');
            $crud->set_relation('preguntas_cve','sse_preguntas','pregunta');
            $crud->order_by('reactivos_cve','ASC');
            $crud->unset_delete();
            
            $output = $crud->render();
            
            $this->template->setMainContent($this->load->view('gc_output',$output, TRUE));
            $this->template->getTemplate();
        } catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }*/
    
    public function seccion() {
        try{
            $this->db->schema = 'encuestas';
            $crud = $this->new_crud();
            $crud->set_table('sse_seccion');
            $crud->order_by('descripcion','ASC');
            $crud->unset_delete();
            
            $output = $crud->render();
            
            $this->template->setMainContent($this->load->view('gc_output',$output, TRUE));
            $this->template->getTemplate();
        } catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
    
    public function tipo_pregunta() {
        try{
            $this->db->schema = 'encuestas';
            $crud = $this->new_crud();
            $crud->set_table('sse_tipo_pregunta');
            $crud->order_by('descripcion','ASC');
            $crud->unset_delete();
            
            $output = $crud->render();
            
            $this->template->setMainContent($this->load->view('gc_output',$output, TRUE));
            $this->template->getTemplate();
        } catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
}