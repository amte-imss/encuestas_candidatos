<fieldset class="scheduler-border well">
    <legend class="scheduler-border">Encuesta</legend>
    <?php if (isset($is_bloque_o_grupo)) { ?>
        <div class="col-lg-12 col-sm-12">
            <div class="panel-body  input-group input-group-sm">
                <!--<span class="input-group-addon">Sesiones:</span>-->
                <label for="evaluado">Bloque o grupo</label>
                <?php echo $this->form_complete->create_element(array('id' => 'is_bloque_o_grupo', 'type' => 'dropdown', /*'value'=>'bloque',*/ 'options' => $is_bloque_o_grupo, 'attributes' => array('name' => 'is_bloque_o_grupo', 'class' => 'form-control', 'placeholder' => 'Bloque o grupo', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Bloque o grupo', 'onchange' => "data_ajax($url_control)"))); ?>
            </div>
        </div>
    <?php } ?>
</fieldset>