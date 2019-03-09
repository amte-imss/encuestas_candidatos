<?php
//pr($cts);
//pr($grupos);
?>
<?php if (isset($grupos)) { ?>
    <div class="panel-body  input-group input-group-sm">
        <label for="lab_max_bloques">Cantidad de bloques</label>
        <input type="number" id="max_bloques" name="max_bloques" min="<?php echo $max_boque; ?>" value="<?php echo $max_boque; ?>"  onchange="funcion_onload_numeric();">
    </div>
    <table class="table-responsive" id="table_bloques">
        <thead>
            <tr>
                <th>Coordinador de tutores</th>
                <th>Grupo</th>
                <th>Titular</th>
                <th>Bloque</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                foreach ($grupos as $key_g => $grupo) {
                    $idgrupo = trim($grupo['id']);
//                    $ct = (isset($cts[$idgrupo])) ? $cts[$idgrupo] : '--';
//                    $tt = (isset($tts[$idgrupo])) ? $tts[$idgrupo] : '--';
                    $ct = (isset($grupo['cts']) and ! empty($grupo['cts'])) ? $grupo['cts'] : '--';
                    $tt = (isset($grupo['tts']) and ! empty($grupo['tts'])) ? $grupo['tts'] : '--';
                    echo '<tr>';
//                    echo '<td>' . $grupo['ct_bloque'] . '</td>';
                    echo '<td>' . $ct . '</td>';
                    echo '<td>' . $grupo['name'] . '</td>';
                    echo '<td>' . $tt . '</td>';
                    echo '<td>';
                    if (isset($grupo['tts']) and ! empty($grupo['tts'])) {
                        echo $this->form_complete->create_element(array('id' => 'b_' . $grupo['id'],
                            'type' => 'dropdown', 'options' => $bloques,
                            'value' => $grupo['bloque'],
                            'first' => array('' => 'Seleccione bloque'),
                            'attributes' => array('name' => 'b_' . $grupo['id'], 'class' => 'form-control ddp',
                                'placeholder' => 'Bloque para el grupo ' . $grupo['name'],
                                'data-toggle' => 'tooltip', 'data-placement' => 'top',
                                'title' => 'Bloque para el grupo ' . $grupo['name'])));
                    }
                    echo form_error_format('b_' . $grupo['id']);
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tr>
        </tbody>
    </table>
    <?php
    $id_accion = $this->acceso->get_permiso_accion(En_modulos::DESIGNAR_BLOQUES_GUARDAR);
    if ($id_accion > -1) {
        ?>
        <div class="right"><input type="button" class="form-control btn-primary" value="Guardar bloques" onclick="guardar_curso_bloque_grupo();"/></div>
    <?php } ?>
<?php } ?>
<?php echo js("busquedas/bloque_grupo_curso.js"); ?>
