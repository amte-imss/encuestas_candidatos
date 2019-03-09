<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Permite utilizar la función que convierte código HTML a un archivo PDF, a través de la herramienta dompdf ubicada en third_party
 */
use Dompdf\Dompdf;
class My_dompdf {
	public function __construct() {
    	$this->CI =& get_instance();
    	include APPPATH.'third_party/dompdf/autoload.inc.php';
    }

    public function convert_html_to_pdf($nombre_archivo='', $vista=''){
    	$dompdf = new Dompdf();
        
        $dompdf->set_option('defaultFont', 'Helvetica');
        $dompdf->set_option('isHtml5ParserEnabled', true);
        // instantiate and use the dompdf class
        //$dompdf = new Dompdf();
        $dompdf->loadHtml($vista);
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream($nombre_archivo);
    }
	/*
    public function phpmailerclass() {
        echo $path = APPPATH.'third_party/phpmailer/';
    	//$this->CI->load->add_package_path($path)->library('PHPMailer');
    	$this->CI->load->add_package_path($path);

    }*/
}

