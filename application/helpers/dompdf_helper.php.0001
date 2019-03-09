 <?php if (!defined('BASEPATH')) exit('No direct script access allowed');

      function generarPdf($html, $filename, $stream=TRUE) {

        require_once("dompdf".DIRECTORY_SEPARATOR."dompdf_config.inc.php");
        if ( isset($html) ) {

	        $html = stripslashes($html);

	        $dompdf = new DOMPDF();

	        $dompdf->load_html(utf8_decode($html));
			    $dompdf->set_paper("a4", "landscape");
	        $dompdf->render();

	       $dompdf->stream($filename . ".pdf");


	 	   }
	  }

	function guardarPdf($html, $filename, $ruta = ".\\assets\\") {
		require_once("dompdf".DIRECTORY_SEPARATOR."dompdf_config.inc.php");
		if ( isset($html) ) {
			$html = stripslashes($html);
			$dompdf = new DOMPDF();
			$dompdf->load_html($html);
			$dompdf->render();
			$pdfoutput = $dompdf->output();
			$fp = fopen($ruta.$filename.".pdf", "a");
			fwrite($fp, $pdfoutput);
			fclose($fp);
	   }
	}
