<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author: LI. Miguel Guagnelli
 * @version: 1.0
 * @desc: Clase padre de los controladores del sistema
 * */
class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        //definir un estandar para los archivos de lenguaje
        //$string_values = $this->lang->line('interface');
    }

    protected function get_modulos_habilitados() {
        return $this->acceso->get_modulos_sistema();
    }

    /*
      Explicación $\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$
      $ = Inicio de cadena
      \S* = Cualquier set de caracteres
      (?=\S{8,}) = longitud de al menos 8 caracteres
      (?=\S*[a-z]) = asegurar que al menos existe una letra minúscula
      (?=\S*[A-Z]) = asegurar que al menos existe una letra mayúscula
      (?=\S*[\d]) = asegurar que al menos exista un número
      (?=\S*[\W]) = y asegurar que al menos tenga un caracter especial (+%#.,);
      $ = fin de la cadena */

    function valid_pass($candidate) {
        if (!preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[-+%#.,;:\d])\S*$', $candidate, $condiciones)) {
            return FALSE;
        }
        return TRUE;
    }

    /** Explicación
     * ^                               - A partir de la linea/cadena
      (?=.{8})                       - busqueda incremental para asegurar que se tienen 8 caracteres
      (?=.*[A-Z])                    - ...para asegurar que tenemos al menos un caracter en mayuscula
      (?=.*[a-z])                    - ...para asegurar que tenemos al menos un caracter en minuscula
      (?=.*\d.*\d.*\d                - ...para asegurar que tenemos al menos tres digitos
      (?=.*[^a-zA-Z\d].*[^a-zA-Z\d].*[^a-zA-Z\d])
      - ...para asegurar que tiene al menos 3 caracteres especiales (caracteres diferentes a letras y numeros)
      [-+%#a-zA-Z\d]+                - combinacion de caracteres permitidos
      $                              - fin de la linea/cadena
     */
    public function password_strong($str) {
//$exp = '/^(?=.{8})(?=.*[A-Z])(?=.*[a-z])(?=.*\d.*\d.*\d)(?=.*[^a-zA-Z\d].*[^a-zA-Z\d].*[^a-zA-Z\d])[-+%#a-zA-Z\d]+$/u';
        $exp = '/^(?=.{8})(?=.*[A-Z])(?=.*[a-z])(?=.*\d.*\d.*\d)(?=.*[^a-zA-Z\d].*[^a-zA-Z\d].*[^a-zA-Z\d])[-+%#a-zA-Z.,;:\d]+$/u';
        return (!preg_match($exp, $str)) ? FALSE : TRUE;
    }

    /**
     * @author LEAS
     * @fecha 01/11/2017
     * @param type $busqueda_especifica
     * @return int
     * @obtiene el array de los datos de session
     */
    public function get_datos_sesion($busqueda_especifica = '*') {
        $data_usuario = $this->session->get_datos_sesion_sistema();
//        $data_usuario = array(En_datos_sesion::ID_DOCENTE =>1,  En_datos_sesion::MATRICULA=>'311091488');
        if ($busqueda_especifica == '*') {
            return $data_usuario;
        } else {
            if (isset($data_usuario[$busqueda_especifica])) {
                return $data_usuario[$busqueda_especifica];
            }
        }
        return NULL; //No se encontro  una llave especifica o la session caduco
    }

    public function redirecciona_sied() {
        $url_sied = $this->config->item('url_sied');
        redirect($url_sied);
    }

    public function redirecciona_sesion_sied() {
        $url_sied = $this->config->item('url_sied_logout');
        redirect($url_sied);
    }

    public function redirecciona_moodle() {
        $url_moodle = $this->config->item('url_moodle_logout');
        redirect($url_moodle);
    }

    /**
     *
     * @param array $columnas Nombre de las columnas en el archivo
     * @param type $informacion Array con Datos de la exportación
     * @param type $column_unset
     * @param type $orden_columna Orden de las columnas
     * @param type $file_name Nombre del archivo exportado
     * @param type $delimiter delimitador del csv, por default será ","
     * @return type Descriptión documento a exportado ceon extención csv
     */
    protected function exportar_csv($columnas = null, $informacion = null, $column_unset = null, $orden_columna = null, $file_name = 'tmp_file_export_data', $delimiter = ',') {//$id_ciclo_evaluacion,$status,$filename
        header("Content-Encoding: UTF-8");
        header("Content-type: application/csv;charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '.csv";');

        $f = fopen('php://output', 'w');

        fputs($f, $bom = ( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        fputcsv($f, $columnas, $delimiter);

        //pr($info);
        if (!is_null($informacion)) {
            if (!is_null($orden_columna)) {
                foreach ($informacion as $line) {

                    $column = [];
                    foreach ($orden_columna as $genera) {//Recorre las columnas extra que no se imprimen
                        if (isset($line[$genera])) {
                            $column[] = $line[$genera]; //Elimina colunas extra
                        } else {
                            $column[] = ' '; //Elimina colunas extra
                        }
                    }
                    fputcsv($f, $column, $delimiter);
                }
            } else {
                foreach ($informacion as $line) {
                    if (!is_null($column_unset)) {

                        foreach ($column_unset as $val_unset) {//Recorre las columnas extra que no se imprimen
                            unset($line[$val_unset]);
                        }
                    }
                    fputcsv($f, $line, $delimiter);
                }
            }
        }
        fclose($f);
    }
    
    

}
