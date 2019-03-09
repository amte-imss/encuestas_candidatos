<label for="grupo">Bloques</label>
<?php
echo $this->form_complete->create_element(array('id' => 'bloque', 'type' => 'dropdown',
    'options' => $bloques_p, 'first' => array('' => 'Seleccione bloque', '*' => 'Cargar todos los grupos'),
    'attributes' => array(
        'name' => 'bloque',
        'class' => 'form-control',
        'placeholder' => 'Bloque',
        'data-toggle' => 'tooltip',
        'data-cursoid' => (isset($cursoid)) ? $cursoid : 0,
        'data-placement' => 'top',
        'title' => 'Bloques',
        'onchange' => "funcion_cargar_grupo(this)"
)));
?>