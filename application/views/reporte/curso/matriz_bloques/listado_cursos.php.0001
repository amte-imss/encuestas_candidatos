<?php if (isset($grupos))
{ ?>
    <table class="table-responsive" id="table_bloques">
        <thead>
            <tr>
                <th>Bloque</th>
                <th>Coordinador de curso</th>
                <th>Coordinador de tutores</th>
                <th>Grupo</th>
                <th>Titular</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                foreach ($grupos as $key_g => $grupo)
                {
                    $idgrupo = trim($grupo['id']);
                    $ct = (isset($grupo['cts'])) ? $grupo['cts'] : '--';
                    $tt = (isset($grupo['tts'])) ? $grupo['tts'] : '--';
                    $cc = (isset($grupo['ccs'])) ? $grupo['ccs'] : '--';
                    echo '<tr>';
//                    echo '<td>' . $grupo['ct_bloque'] . '</td>';
                    echo '<td>' . (isset($b_export)?utf8_decode($grupo['bloque']): $grupo['bloque']). '</td>';
                    echo '<td>' . (isset($b_export)?utf8_decode($cc):$cc) . '</td>';
                    echo '<td>' . (isset($b_export)?utf8_decode($ct):$ct) . '</td>';
                    echo '<td>' . (isset($b_export)?utf8_decode($grupo['name']):$grupo['name']) . '</td>';
                    echo '<td>' . (isset($b_export)?utf8_decode($tt):$tt) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tr>
        </tbody>
    </table>
<?php } ?>
