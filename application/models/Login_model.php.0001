<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
//         $this->load->database();
    }

    /**
     * @autor LEAS
     * Fecha creación: 03-02-2017
     * @return Accesos por rol
     */
    public function get_modulos_sesion_vx($param) {
//        pr($param);
        $string_roeles = '';
        if (isset($param['roles']) and ! empty($param['roles'])) {
            $string_roeles = 'and mrol.id in( ';
            $separador = '';
            foreach ($param['roles'] as $idrole) {
                $string_roeles .= $separador . $idrole;
                $separador = ', ';
            }
            $string_roeles .= ' )';
        } else {//Si no existen roles asociados con el usuario, envíar un array vacio
            return array();
        }

        $select = array(
            'm.modulo_cve', 'm.nom_controlador_funcion_mod', 'm.descripcion_modulo', 'm.modulo_padre_cve', 'is_seccion',
            "(select nom_controlador_funcion_mod from encuestas.sse_modulo mp where mp.modulo_cve = m.modulo_padre_cve) as modulo_padre_controlador_funcion"
        );

        $this->db->select($select);
        $this->db->join('encuestas.sse_modulo_rol mr', 'mr.modulo_cve  = m.modulo_cve');
        $this->db->join('public.mdl_role mrol', 'mrol.id = mr.role_id ' . $string_roeles);
        //Condiciones
        //Group by agrupamiento
        $this->db->group_by('m.modulo_cve');
        $this->db->group_by('m.descripcion_modulo');
        $this->db->group_by('m.modulo_padre_cve');
        //Ordenamiento
        $this->db->order_by('modulo_padre_cve', 'desc');
        $query = $this->db->get('encuestas.sse_modulo m');
        $result = $query->result_array();

//        pr($this->db->last_query());
        $query->free_result();
        return $result;
    }

    /**
     * @autor LEAS
     * Fecha creación: 03-02-2017
     * @return Accesos por rol en la tabla "public.mdl_config" , "name" = \'siteadmins\'
     * guarda los administradores de la plataforma no enrolados
     * @deprecated since version number 1.0
     */
    public function get_is_user_admin_sied($id_user) {

        $this->db->select('count(*) admin_existe');
        //Condiciones
        $this->db->where('"name" = \'siteadmins\'');
        $this->db->where($id_user . '= any (string_to_array(c."value", \',\')::int8[])');

        $query = $this->db->get('public.mdl_config c');
        $result = $query->result_array();

//        pr($this->db->last_query());
        $query->free_result();
        return $result[0]['admin_existe'];
    }

    /**
     * @autor LEAS
     * Fecha creación: 02/11/2017
     * @return Accesos por rol administrador (id con valor 1) en la tabla "public.mdl_config" , "name" = \'siteadmins\' y
     * los roles assignados en la tabla de asignación de moodle el formato de salida serán los identificadores de rol separados por comas
     *
     *
     */
    public function get_roles_sistema($id_user = null) {

        $query_cad = 'select string_agg(distinct id::text, \',\') roles from
                    ((SELECT mdl_role.id
                            FROM mdl_course
                            JOIN mdl_context ON mdl_context.instanceid = mdl_course.id
                            JOIN mdl_role_assignments ON mdl_context.id = mdl_role_assignments.contextid
                            JOIN mdl_role ON mdl_role.id = mdl_role_assignments.roleid
                            JOIN mdl_user ON mdl_user.id = mdl_role_assignments.userid
                            WHERE mdl_user.id in(' . $id_user . ')
                            GROUP BY mdl_role.id
                            ORDER BY mdl_role.id asc)
                    union
                            select 1 as id
                            from public.mdl_config c
                            where
                            "name" = \'siteadmins\'
                            and ' . $id_user . ' = any (string_to_array(c."value", \',\')::int8[])
                    ) as roles_id';
        $ejecucion = $this->db->query($query_cad)->result_array();
//        pr($this->db->last_query());
        return $ejecucion;
    }

    /**
     * @autor LEAS
     * Fecha creación: 03-02-2017
     * @return Accesos por rol
     */
    public function get_modulos_sesion($id_user) {
//        pr($param);
        $string_roeles = '';
        $roles = $this->get_roles_sistema($id_user);
        if (!empty($roles)) {
            $string_roeles = ' in( ' . $roles[0]['roles'] . ' )';
        } else {//Si no existen roles asociados con el usuario, envíar un array vacio
            return array();
        }

        $query_cad = "
            select mact.modulo_cve, mact.modulo_padre_cve, mact.descripcion_modulo,
                mact.nom_controlador_funcion_mod, 1 acceso
                from encuestas.sse_modulo mact
                left join encuestas.sse_modulo_rol mract on mract.modulo_cve = mact.modulo_cve and mract.role_id " . $string_roeles . "
                where mact.is_seccion = 0 and
                mact.modulo_padre_cve in (select mactp.modulo_cve
                from encuestas.sse_modulo mactp
                join encuestas.sse_modulo_rol mractp on mractp.modulo_cve = mactp.modulo_cve and mactp.is_seccion = 1 and mractp.role_id " . $string_roeles . "
                group by mactp.modulo_cve)
                and mract.role_id is null
                group by mact.modulo_padre_cve, mact.modulo_cve
            union
                select mact.modulo_cve, mact.modulo_padre_cve, mact.descripcion_modulo,
                mact.nom_controlador_funcion_mod,
		case when ((select count(*) cuenta
                    from encuestas.sse_modulo_rol mract
                    join encuestas.sse_modulo mact on mact.modulo_cve = mract.modulo_cve and acceso = 0 and mract.role_id " . $string_roeles . "
                    group by mact.modulo_padre_cve, mact.modulo_cve
                    having count(mact.modulo_cve) > 1) > 0) then 1
                    else 0 end
                as acceso
                from encuestas.sse_modulo_rol mract
                join encuestas.sse_modulo mact on mact.modulo_cve = mract.modulo_cve and acceso = 0 and mract.role_id " . $string_roeles . "
                group by mact.modulo_padre_cve, mact.modulo_cve
                having count(mact.modulo_cve) = 1
            union
                select mact.modulo_cve, mact.modulo_padre_cve, mact.descripcion_modulo,
                mact.nom_controlador_funcion_mod, 0 acceso
                from encuestas.sse_modulo_rol mract
                join encuestas.sse_modulo mact on mact.modulo_cve = mract.modulo_cve and acceso = 0 and mract.role_id " . $string_roeles . "
                group by mact.modulo_padre_cve, mact.modulo_cve
                having count(mact.modulo_cve) > 1";

        $ejecucion = $this->db->query($query_cad)->result_array();
//        pr($this->db->last_query());
        //Carga las secciones
        $select = array(
            'mactp.modulo_cve', 'mactp.descripcion_modulo', 'mactp.nom_controlador_funcion_mod'
        );

        $this->db->select($select);
        $this->db->join('encuestas.sse_modulo_rol mractp', 'mractp.modulo_cve = mactp.modulo_cve and mactp.is_seccion = 1 and mractp.role_id ' . $string_roeles);
        //Condiciones
        $this->db->where('mractp.acceso', '1');
        //Group by agrupamiento
        $this->db->group_by('mactp.modulo_cve');
        //Ordenamiento
        $this->db->order_by('mactp.modulo_cve');
        $query = $this->db->get('encuestas.sse_modulo mactp');
        $secciones = $query->result_array();
        $query->free_result();

        $result['modulos'] = $ejecucion;
        $result['secciones'] = $secciones;

//        pr($this->db->last_query());
        return $result;
    }

    public function usuario_existe($id = NULL) {
        /* "SELECT DISTINCT ro.id as idtipo, op.username, op.password, op.id,
          op.firstname || ' ' || op.lastname as operador, ro.name as tipousuario
          FROM public.mdl_user op
          LEFT JOIN public.mdl_role_assignments ra ON op.id = ra.userid
          LEFT JOIN public.mdl_role ro ON ro.id = ra.roleid
          WHERE op.id =".$iduser."
         */

        $resultado = array();
        $this->db->select('distinct(us.id) as idtipo, us.username, us.id, us.firstname as nombre,us.lastname as apellidos');
        $this->db->where('us.id', $id);

        $this->db->join('public.mdl_role_assignments ra', 'us.id = ra.userid', 'left');
        $this->db->join('public.mdl_role ro', 'ro.id = ra.roleid', 'left');


        $query = $this->db->get('public.mdl_user us'); //Obtener conjunto de encuestas
        $resultado = $query->result_array();
        $row = $query->row();




        if ($query->num_rows() == 0) {
            //Checar si es admin

            $this->db->where('name', 'siteadmins');
            $q = $this->db->get('public.mdl_config'); //Obtener conjunto de encuestas

            foreach ($q->result_array() as $row) {
                $admins = explode(",", $row['value']);
                if (in_array($id, $admins)) {
                    $this->db->select('us.username, us.id, us.firstname as nombre,us.lastname as apellidos');
                    $this->db->where('id', $id);
                    $qadmin = $this->db->get('public.mdl_user us');
                    $dato = $qadmin->row();
                } else {
                    $dato = FALSE;
                }
            }
        } else {
            //Usuario perfil no admin
            $dato = $query->row();
        }
//        pr($this->db->last_query());

        $query->free_result(); //Libera la memoria

        return $dato;
    }

}
