<?php  defined('BASEPATH') OR exit('No direct script access allowed');

/*
## Template modal
listado de variables

- ver_titulo         => true
- ver_mensaje        => false
- ver_footer         => false

- pie_modal
- titulo_modal
- cuerpo_modal
- msg_modal


*/
?>
<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content" id="modal_content">
		<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h4 class="modal-title" id="modal_censo_label"><?php if(isset($titulo_modal) && !empty($titulo_modal)) echo $titulo_modal;//se verifica que exista la variable $titulo_modal. despues se imprime ?></h4>
		</div>

		<div class="modal-body">
		    <div id="msg_modal">
		      <?php if(isset($msg_modal) && !empty($msg_modal)) echo $msg_modal;//se verifica que exista la variable $msg_modal, que no este vacia. despues se imprime ?>
		    </div>
		    <div id="cuerpo_modal">
		      <?php if(isset($cuerpo_modal) && !empty($cuerpo_modal)) echo $cuerpo_modal;//se verifica que exista la variable $cuerpo_modal. despues se imprime ?>
		    </div>
		</div>
		<div class="modal-footer">
		  <?php if(isset($ver_pie_modal) && $ver_pie_modal) echo $pie_modal;//se verifica que exista la variable $pie_modal. despues se imprime ?>
		</div>
	</DIV>
</DIV>
