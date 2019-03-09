<div class="panel-body  input-group input-group-sm">
    <label for="tipo_curso"><span style="color:red;">*</span> Encuestas</label>
    <?php echo $this->form_complete->create_element(array('id' => 'encuesta', 'type' => 'dropdown', 'options' =>$encuesta , 'first' => array('' => 'Seleccione la encuesta'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Encuesta', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Encuesta'))); ?>
</div>