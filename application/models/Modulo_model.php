<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Modulo_model
 *
 * @author chrigarc
 */
class Modulo_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->config->load('general');
        $this->load->database();
    }

    public function get_modulos($id_modulo = 0, $agrupadas = true) {
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            'A.modulo_cve id_modulo', 'A.descripcion_modulo nombre', 'A.descripcion_modulo descripcion', 'A.nom_controlador_funcion_mod url', '0 orden'
            , 'A.is_menu id_configurador', "'' configurador", 'A.modulo_padre_cve modulo_padre_id', '1 visible', "'' icon"
        );
        $this->db->select($select);
        if ($id_modulo > 0) {
            $this->db->where('A.modulo_cve', $id_modulo);
        }
        $modulos = $this->db->get('encuestas.sse_modulo A')->result_array();
        if ($id_modulo <= 0 && $agrupadas) {
            $modulos = $this->get_tree($modulos);
        }
        return $modulos;
    }

    /**
     * @update 22/11/2017 LEAS
     * @param type $id_aux
     * @param type $target
     * @param type $user
     * @return type
     */
    public function get_niveles_acceso($id_aux = 0, $target = 'modulos', $user = null) {

//        $roles_moodle = [];
        // pr($roles_moodle);
        $niveles = [];
        if ($target == 'modulos') {
            $roles = $this->config->item('roles_moodle');
            $roles_moodle = implode(array_keys($roles), ',');
            $this->db->flush_cache();
            $this->db->reset_query();
            $select = array(
                'role_id_array id_grupo', 'B.acceso activo'
            );
            $this->db->select($select);
            $this->db->from("unnest(array[{$roles_moodle}]) role_id_array");
            $this->db->join('encuestas.sse_modulo_rol B', " role_id_array = B.role_id AND B.modulo_cve = {$id_aux}", 'left');
            $niveles = $this->db->get()->result_array();
            $this->db->reset_query();
            // pr($niveles);
            foreach ($niveles as &$row) {
                foreach ($roles as $key => $value) {
                    if ($key == $row['id_grupo']) {
                        $row['nombre'] = $roles[$key];
                    }
                }
            }
        } else if ($target == 'modulos_rol') {
            $this->load->model('Login_model', 'lm');
            $roles = $this->lm->get_roles_sistema($user); //Obtiene los roles del sistema
            if (!empty($roles)) {

                $roles_moodle = $roles[0]['roles'];
//            pr($roles_moodle);
                $this->db->flush_cache();
                $this->db->reset_query();
                $select = array(
                    'role_id_array id_grupo', 'B.acceso activo', 'nom_controlador_funcion_mod url',
                    'descripcion_modulo nombre', 'modulo_padre_cve padre', 'is_menu', 'C.modulo_cve'
                );
                $this->db->select($select);
                $this->db->from("unnest(array[{$roles_moodle}]) role_id_array");
//            $this->db->join('encuestas.sse_modulo_rol B', " role_id_array = B.role_id AND B.modulo_cve = {$id_aux}", 'left');
                $this->db->join('encuestas.sse_modulo_rol B', " role_id_array = B.role_id ", 'left');
                $this->db->join('encuestas.sse_modulo C', " C.modulo_cve = B.modulo_cve ", 'left');
                $niveles = $this->db->get()->result_array();
                $this->db->reset_query();
            }
        } else if ($target == 'usuarios') {
            $this->load->model('Login_model', 'lm');
            $roles = $this->lm->get_roles_sistema($id_aux); //Obtiene los roles del sistema
            if (!empty($roles)) {
                $niveles = $this->get_niveles_acceso_usuario($roles);
            }
//            pr($niveles);
        }
//        pr($this->db->last_query());
        return $niveles;
    }

    private function get_niveles_acceso_usuario($roles) {

        $grupos = [];
        if (!empty($roles)) {
            $this->db->flush_cache();
            $this->db->reset_query();
            $this->db->select('er.role_id id');
            $this->db->where_in('er.role_id', $roles);
            $this->db->group_by('er.role_id');
            $grupos = $this->db->get('encuestas.sse_modulo_rol er')->result_array();
        }
        $this->db->flush_cache();
        $this->db->reset_query();
        return $grupos;
    }

    public function get_configuradores() {
        $configuradores = array(
            array('id_configurador' => 1, 'nombre' => 'Menú'),
            array('id_configurador' => 0, 'nombre' => 'Acción')
        );
        return $configuradores;
    }

    public function upsert_niveles_acceso($niveles_acceso = [], $params = []) {
        $salida = false;
        $this->db->trans_begin();
        $id_modulo = $params['modulo'];
        foreach ($niveles_acceso as $nivel) {
            $activo = (isset($params['activo' . $nivel['id_grupo']])) ? true : false;
            $this->upsert_modulo_grupo($nivel['id_grupo'], $id_modulo, $activo);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $salida = true;
        }
        return $salida;
    }

    private function upsert_modulo_grupo($id_grupo = 0, $id_modulo = 0, $activo = false) {
        //pr('[CH][modulo_model][upsert_modulo_grupo] id_grupo: '.$id_grupo.' id_modulo: '.$id_modulo.', conf: '.$configurador.', activo: '.($activo?'true':'false') );
        if ($id_grupo > 0 && $id_modulo > 0) {
            $activo = $activo ? 1 : 0;
            $this->db->flush_cache();
            $this->db->reset_query();
            $this->db->select('count(*) cantidad');
            $this->db->start_cache();
            $this->db->where('role_id', $id_grupo);
            $this->db->where('modulo_cve', $id_modulo);
            $this->db->stop_cache();
            $existe = $this->db->get('encuestas.sse_modulo_rol')->result_array()[0]['cantidad'] != 0;
            if ($existe) {
                $this->db->set('acceso', $activo);
                $this->db->update('encuestas.sse_modulo_rol');
            } else {
                $this->db->flush_cache();
                $insert = array(
                    'modulo_cve' => $id_modulo,
                    'role_id' => $id_grupo,
                    'acceso' => $activo
                );
                $this->db->insert('encuestas.sse_modulo_rol', $insert);
            }
            $this->db->reset_query();
//            pr($this->db->last_query());
        }
    }

    public function update($id_modulo = 0, &$datos = array()) {
        $status = false;
        if ($id_modulo > 0) {
            $this->db->flush_cache();
            $this->db->reset_query();
            $this->db->set('descripcion_modulo', $datos['nombre']);
            $this->db->set('nom_controlador_funcion_mod', $datos['url']);
            $this->db->set('modulo_padre_cve', (empty($datos['padre'])) ? null : $datos['padre']);
            $this->db->set('is_menu', $datos['tipo']);
            $this->db->where('modulo_cve', $id_modulo);
            $this->db->update('encuestas.sse_modulo');
            $status = true;
        }
        return $status;
    }

    public function insert(&$datos = array()) {
        $status = false;
        try {
            $insert = array(
                'descripcion_modulo' => $datos['nombre'],
                'nom_controlador_funcion_mod' => $datos['url'],
                'modulo_padre_cve' => $datos['padre'],
                'is_menu' => $datos['tipo'],
            );
            $this->db->insert('encuestas.sse_modulo', $insert);
            $this->db->reset_query();
            $status = true;
        } catch (Exception $e) {

        }
        return $status;
    }

    private function get_tree($modulos = array()) {
        $niveles_tree = 10;
        $pre_tree = [];
        for ($i = 0; $i < $niveles_tree + 1; $i++) {
            foreach ($modulos as $row) {
                if (!isset($pre_tree[$row['id_modulo']])) {
                    $pre_tree[$row['id_modulo']] = $row;
                }
                //pr($pre_tree[$row['id_modulo']]);
                if (isset($pre_tree[$row['modulo_padre_id']]) /* && !isset($pre_menu[$row['id_menu_padre']]['childs'][$row['id_menu']]) */) {
//                    pr($row['id_modulo']['id_modulo_padre']);
                    $pre_tree[$row['modulo_padre_id']]['childs'][$row['id_modulo']] = $pre_tree[$row['id_modulo']];
                } else {
                    //pr($row['id_modulo']['id_modulo_padre']);
                }
            }
        }
        $tree = [];
//        pr($pre_tree);

        foreach ($pre_tree as $row) {
            if (empty($row['modulo_padre_id']) && !isset($tree[$row['id_modulo']])) {
                $tree[$row['id_modulo']] = $row;
            }
        }
        //pr($tree);
        return $tree;
    }

    function check_acceso($url = null, $id_usuario = 0) {
        $salida = null;
        if ($id_usuario > 0 && $url != null && $url != "") {
            $this->db->flush_cache();
            $this->db->reset_query();
            $select = array(
                'A.id_modulo', 'A.nombre  modulo', 'A.url'
            );
            $this->db->select($select);
            $this->db->join('sistema.roles_modulos B', 'B.id_modulo = A.id_modulo', 'inner');
            $this->db->join('sistema.usuario_rol C', 'C.id_rol = B.id_rol', 'inner');
            $this->db->where('C.id_usuario', $id_usuario);
            $this->db->where('A.activo', true);
            $this->db->where('B.activo', true);
            $this->db->where('C.activo', true);
            $url_d = $url . '/';
            $this->db->where("(A.url = '{$url}' or A.url = '{$url_d}')");
            $result_set = $this->db->get('sistema.modulos A');
            if ($result_set) {
                $salida = $result_set->result_array();
            }
        }
        return $salida;
    }

    public function check_acceso_sied($id_usuario = 0) {
        $salida = null;
        if ($id_usuario > 0) {
            $this->db->flush_cache();
            $this->db->reset_query();
//            $grupos = $this->get_niveles_acceso_sied($id_usuario);
            $this->db->flush_cache();
            $this->db->reset_query();
            $select = array(
                'A.cve_menu id_modulo', 'A.des_menu nombre', 'A.ref_url url'
            );
            $this->db->select($select);
            $this->db->join('parametrizacion.ssp_cat_menu A', 'A.cve_menu = B.cve_menu and A.ind_activo = 1 and B.ind_activo = 1', 'inner');
            $this->db->where('B.cve_usuario', $id_usuario);
            $this->db->where('A.ind_activo', 1);
            $this->db->where('A.ref_url', '../encuestas');
            $result_set = $this->db->get('parametrizacion.ssp_tab_usuario_menu B');
            if ($result_set) {
                $salida = $result_set->result_array();
            }
        }
        return count($salida) == 1;
    }

}
