<?php if (isset($datos_user_aeva) && !empty($datos_user_aeva)) { ?>
                <div class="list-group-item">

                    </div>
    <div class="table-responsive">
        <table id="tblResultadoRealizada" class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>Rol evaluador</th>
                    <th>Nombre Evaluador</th>
                    <th>Rol a evaluar</th>
                    <th>Nombre docente a evaluar</th>
                    <th>Grupo</th>
                   <!--<th>Encuesta</th>-->
                    <th>Encuestado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                foreach ($datos_user_aeva as $val) {
                    //pr($val);
                    if (isset($val[0])) {
                         if(isset($val[0]['ngpo'] ) && $val[0]['ngpo'] != '0')
                         {
                            $grupo=$val[0]['ngpo'];
                         }
                         else
                         {
                            $grupo='--';
                         }   
                        
                        echo '<tr>
                       
                        <td >' . $val[0]['evaluador'].'</td >
                        <td >' . $val[0]['evaludador_nombre'].'</td >
                        <td >' . $val[0]['role'].'</td > 
                         <td >' . $val[0]['firstname'] . ' '. $val[0]['lastname']. '</td>
                        <td > ' . $grupo. '</td >'; 
                        //<td >' . $val[0]['regla'] . '</td>
                        
                        echo '<td align="center">';
          
                        if(isset($val[0]['realizado']) || !empty($val[0]['realizado']))
                        {
                           echo "Si";
                        }
                        else
                        {
                           echo "No";
                         }
                        
                        echo '</td>
                        ';
                        
                        echo '</tr>';
                    }
                }
                
                ?>
            </tbody>
        </table>
        
    </div>
<?php } else { ?>
    <br><br>
    <div class="row">
        <div class="jumbotron"><div class="container"> <p class="text_center">No se encontraron datos registrados con esta busqueda</p> </div></div>
    </div>

<?php } ?>
