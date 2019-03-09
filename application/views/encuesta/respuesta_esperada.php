<label for="val_ref">Respuesta esperada:</label>
<?php echo $this->form_complete->create_element(array('id' => 'val_ref', 'type' => 'dropdown', 'options' => $respuestas,'value'=>$res_val, 'first' => array('' => 'Seleccione una respuesta'), 'attributes' => array('name' => 'val_ref', 'class' => 'form-control', 'placeholder' => 'Respuesta esperada', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Respuesta esperada'))); ?>
<span class="text-danger"> <?php echo form_error('val_ref','','');?> </span>
<p class="help-block"></p>