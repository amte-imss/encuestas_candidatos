<?php

/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of SessionSIED
 *
 * @author chrigarc
 */
class SessionSIED {

    const
            __default = '',
            ID = 'id',
            NOMBRE = 'nombre',
            MATRICULA = 'matricula'

    ;

    /** @var \stdClass $record session record */
    protected $recordid = null;

    /** @var bool $failed session read/init failed, do not write back to DB */
    protected $failed = false;

    /** @var string $lasthash hash of the session data content */
    protected $lasthash = null;

    /** @var int $acquiretimeout how long to wait for session lock */
    protected $acquiretimeout = 120;

    public function __construct() {
        $this->CI = & get_instance();
        $this->abrir_session();
        // pr('hola mundo');
    }

    private function abrir_session()
    {
        $this->CI->load->database();
        $config = $this->get_configuracion();
        $session_name = "MoodleSession{$config['sessioncookie']}";
        ini_set('session.name', $session_name); //Colocar la misma llave que utilice SIED para localizar el id de session
        //pr($config);
        if($config['dbsessions'] == 1)
        {
            $this->open_db_session();
        }else
        {
            $this->open_file_session();
        }
        session_start(); //iniciar el manejo de sesiones de PHP
        // pr(ini_get('session.name'));
        // pr(session_id());
        // pr($_SESSION);
    }

    private function open_db_session()
    {
        $result = session_set_save_handler(
            array($this, 'handler_open'),
            array($this, 'handler_close'),
            array($this, 'handler_read'),
            array($this, 'handler_write'),
            array($this, 'handler_destroy'),
            array($this, 'handler_gc')
        );
        // pr('sesiones con db');
        if (!$result)
        {
            throw new exception('dbsessionhandlerproblem', 'error');
        }
        // pr('sesiones con db abiertas');
        // $this->set_userdata('hola', 'lo que sea');
        // pr($this->userdata('hola'));
    }

    private function open_file_session()
    {
        //pr($this->CI);
        $path = $this->CI->config->item('session_moodle_path');
        ini_set("session.save_path", $path); //colocar la misma ruta donde sied almacena sesiones dataroot.'/sessions'
    }

    private function get_configuracion()
    {
        $db = $this->CI->db;
        $configuraciones = [];
        $db->flush_cache();
        $db->reset_query();
        $select = array(
            'A.name','A.value'
        );
        $db->select($select);
        $db->like('A.name', 'session');
        $query = $db->get('mdl_config A');
        $array = $query->result_array();
        foreach ($array as $row) {
            $configuraciones[$row['name']] = $row['value'];
        }
        $query->free_result();
        return $configuraciones;
    }

    public function userdata($str = null) {
        if ($str == null) {
            if (empty($_SESSION)) {
                return null;
            }
            return $_SESSION;
        } else if (isset($_SESSION[$str])) {
            return $_SESSION[$str];
        }
        return null;
    }

    public function set_userdata($key, $val)
    {
        if(is_array($key))
        {
            foreach ($key as $key_int=>$val)
            {
                $_SESSION[$key_int] = $val;
            }
        }else
        {
            $_SESSION[$key] = $val;
        }
    }

    public function sess_destroy() {
        session_destroy();
    }

    public function has_userdata($key) {
        return isset($_SESSION[$key]);
    }

    public function mark_as_flash($data) {

    }

    public function set_flashdata($var, $var1) {

        if(isset($_SESSION['flashdata']))
        {
            $_SESSION['flashdata'][$var] = $var1;
        }else{
            $_SESSION['flashdata'] =  array($var => $var1);
        }
    }

    public function flashdata($data) {
        if ($data == null && isset($_SESSION['flashdata'])) {
            $salida = $_SESSION['flashdata'];
            unset($_SESSION['flashdata']);
            return $salida;
        } else if (isset($_SESSION['flashdata']) && isset($_SESSION['flashdata'][$data])) {
            $salida = $_SESSION['flashdata'][$data].'';
            unset($_SESSION['flashdata'][$data]);
            // pr($salida);
            return $salida;
        }
        return null;
    }

    public function keep_flashdata($data) {

    }

    public function mark_as_temp($var1, $var2) {

    }

    public function set_tempdata($var1, $var2, $var3) {

    }

    public function tempdata($var) {

    }

    public function unset_tempdata($var) {

    }

    /**
     * @author LEAS
     * @fecha 01/11/2017
     * @param type $busqueda_especifica Busca un dato especifico, si es igual a "*"
     * obtiene todos los datos del sistema encuestas
     * @return type Datos del sistema encuestas
     */
    public function get_datos_sesion_sistema($busqueda_especifica = '*') {
        $data_usuario = $this->userdata('encuestas_die');
//        $data_usuario = array(En_datos_sesion::ID_DOCENTE =>1,  En_datos_sesion::MATRICULA=>'311091488');
        if ($busqueda_especifica == '*') {
            return $data_usuario;
        } else {
            if (isset($data_usuario[$busqueda_especifica])) {
                return $data_usuario[$busqueda_especifica];
            }
        }
    }

    /**
    * Open session handler.
    *
    * {@see http://php.net/manual/en/function.session-set-save-handler.php}
    *
    * @param string $save_path
    * @param string $session_name
    * @return bool success
    */
   public function handler_open($save_path, $session_name) {
       // Note: we use the already open database.
    //    pr($save_path);
       return true;
   }

   /**
    * Close session handler.
    *
    * {@see http://php.net/manual/en/function.session-set-save-handler.php}
    *
    * @return bool success
    */
   public function handler_close() {
       if ($this->recordid) {
           try
           {
            //    $this->CI->db->release_session_lock($this->recordid);
                $this->CI->db->select("pg_advisory_unlock({$this->recordid})");
                $query = $this->CI->db->get();
                $query->free_result();
           } catch (\Exception $ex)
           {
               // Ignore any problems.
           }
       }
       $this->recordid = null;
       $this->lasthash = null;
       return true;
   }

   /**
    * Read session handler.
    *
    * {@see http://php.net/manual/en/function.session-set-save-handler.php}
    *
    * @param string $sid
    * @return string
    */
   public function handler_read($sid) {
    //    pr('handler_read');
       try {
           $this->CI->db->reset_query();
           $record = null;
           $this->CI->db->select('id');
           $this->CI->db->where('sid', $sid);
           $query = $this->CI->db->get('mdl_sessions');
           if($query->num_rows() > 0){
               $record = $query->result_array()[0];
           }
           $query->free_result();
           if (is_null($record)) {
               // Let's cheat and skip locking if this is the first access,
               // do not create the record here, let the manager do it after session init.
               $this->failed = false;
               $this->recordid = null;
               $this->lasthash = sha1('');
            //    pr('1er if');
            //    pr($sid);
               return '';
           }
           if ($this->recordid and $this->recordid != $record['id']) {
               error_log('Second session read with different record id detected, cannot read session');
               $this->failed = true;
               $this->recordid = null;
               return '';
           }
           if (!$this->recordid) {
               // Lock session if exists and not already locked.
            //    $this->CI->db->get_session_lock($record->id, $this->acquiretimeout);
               $this->get_session_lock($record['id'], $this->acquiretimeout);
               $this->recordid = $record['id'];
           }
       } catch (\dml_sessionwait_exception $ex) {
           // This is a fatal error, better inform users.
           // It should not happen very often - all pages that need long time to execute
           // should close session immediately after access control checks.
           error_log('Cannot obtain session lock for sid: '.$sid);
           $this->failed = true;
           throw $ex;

       } catch (\Exception $ex) {
           // Do not rethrow exceptions here, this should not happen.
           error_log('Unknown exception when starting database session : '.$sid.' - '.$ex->getMessage());
           $this->failed = true;
           $this->recordid = null;
           return '';
       }
    //    pr('read');
       $this->CI->db->reset_query();
       $select = array(
           'id', 'sessdata'
       );
       $this->CI->db->select($select);
       $this->CI->db->where('id', $record['id']);
       $query = $this->CI->db->get('mdl_sessions');
       if($query->num_rows() > 0)
       {
           $record = $query->result_array()[0];
       }else
       {
            $record = null;
       }
    //    pr($this->CI->db->last_query());
       $query->free_result();

       // Finally read the full session data because we know we have the lock now.
       if (is_null($record)) {
           // Ignore - something else just deleted the session record.
           $this->failed = true;
           $this->recordid = null;
           return '';
       }
       $this->failed = false;

       if (is_null($record['sessdata'])) {
           $data = '';
           $this->lasthash = sha1('');
       } else {
           $data = base64_decode($record['sessdata']);
           $this->lasthash = sha1($record['sessdata']);
       }
    //    pr($this);
        // pr($data);
        return $data;
   }

   private function get_session_lock($rowid, $timeout)
   {
       $timeoutmilli = $timeout * 1000;
       $this->CI->db->query("SET statement_timeout TO {$timeoutmilli}");
       $this->CI->db->get("pg_advisory_lock({$rowid})");
       $this->CI->db->query("SET statement_timeout TO DEFAULT");
   }

   /**
    * Write session handler.
    *
    * {@see http://php.net/manual/en/function.session-set-save-handler.php}
    *
    * NOTE: Do not write to output or throw any exceptions!
    *       Hopefully the next page is going to display nice error or it recovers...
    *
    * @param string $sid
    * @param string $session_data
    * @return bool success
    */
   public function handler_write($sid, $session_data) {
       if ($this->failed) {
           // Do not write anything back - we failed to start the session properly.
           return false;
       }

       $sessdata = base64_encode($session_data); // There might be some binary mess :-(
       $hash = sha1($sessdata);

       if ($hash === $this->lasthash) {
           return true;
       }

       try {
           $this->CI->db->reset_query();
           if ($this->recordid) {
               $this->CI->db->update('mdl_sessions', array('sessdata' => $sessdata), array('id'=>$this->recordid));
           } else {
               // This happens in the first request when session record was just created in manager.
               $this->CI->db->update('mdl_sessions', array('sessdata'=> $sessdata), array('sid'=>$sid));
           }
       } catch (\Exception $ex) {
           // Do not rethrow exceptions here, this should not happen.
           error_log('Unknown exception when writing database session data : '.$sid.' - '.$ex->getMessage());
       }

       return true;
   }

   /**
    * Destroy session handler.
    *
    * {@see http://php.net/manual/en/function.session-set-save-handler.php}
    *
    * @param string $sid
    * @return bool success
    */
   public function handler_destroy($sid) {
       // pr('cerrando sesión');
       // pr($sid);
       $this->CI->db->reset_query();
       $session = null;
       $select = array(
           'id', 'sid'
       );
       $this->CI->db->select($select);
       $this->CI->db->where('sid', $sid);
       $query = $this->CI->db->get('mdl_sessions');
       if ($query->num_rows() > 0) {
            $session = $query->result_array()[0];
       }
       // pr($session);
       $query->free_result();

       if (is_null($session)) {
           if ($sid == session_id()) {
               $this->recordid = null;
               $this->lasthash = null;
           }
           return true;
       }

       if ($this->recordid and $session['id'] == $this->recordid) {
           try {
            //    $this->CI->db->release_session_lock($this->recordid);
                $this->CI->db->reset_query();
                $this->CI->db->select("pg_advisory_unlock({$this->recordid})");
                $query = $this->CI->db->get();
                $query->free_result();
           } catch (\Exception $ex) {
               // Ignore problems.
           }
           $this->recordid = null;
           $this->lasthash = null;
       }

       $this->CI->db->delete('mdl_sessions', array('id'=>$session['id']));

       return true;
   }

   /**
    * GC session handler.
    *
    * {@see http://php.net/manual/en/function.session-set-save-handler.php}
    *
    * @param int $ignored_maxlifetime moodle uses special timeout rules
    * @return bool success
    */
   public function handler_gc($ignored_maxlifetime) {
       // This should do something only if cron is not running properly...
       if (!$stalelifetime = ini_get('session.gc_maxlifetime')) {
           return true;
       }
       $this->CI->db->reset_query();
       $this->CI->db->where('userid',0 );
       $this->CI->db->where("timemodified < (time() - ${stalelifetime})", null, FALSE);
       $this->CI->db->delete('mdl_sessions');
       $this->CI->db->reset_query();
       return true;
   }

}
