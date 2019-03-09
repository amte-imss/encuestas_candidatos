    <div class="table-responsive">
        <table id="tblResultadoRealizada" class="table table-striped table-hover table-bordered">
            <thead>
                <tr bgcolor="#212121" style="height:50px">
                    <th colspan="2">
                        <header role="banner">
                            <div id="cd-logo">
                                <img src="<?= base_url(); ?>/assets/img/imss.png" />
                            </div>
                        </header>
                    </th>
                    <th colspan="2">
                        <header role="banner">
                            <div id="cd-logo">
                                <img src="<?= base_url(); ?>assets/img/ces.png" />
                            </div>
                        </header>
                    </th>
                    <th colspan="2">
                        <header role="banner">
                            <div id="cd-logo">
                                <img src="<?= base_url(); ?>assets/img/arrobas.png" />
                            </div>
                        </header>
                    </th>
                </tr>
                <tr>
                    <th colspan="6">
                        <h1> Encuestas de satisfacci&oacute;n docente </h1>
                    </th>                
                </tr>
                <tr>
                    <th>Rol evaluador</th>
                    <th>Nombre Evaluador</th>
                    <th>Rol a evaluar</th>
                    <th>Nombre docente a evaluar</th>
                    <th>Grupo</th>
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
                            htmlentities($grupo=$val[0]['ngpo']);
                         }
                         else
                         {
                            $grupo='--';
                         }   
                        
                        echo '<tr>
                       
                        <td >' . htmlentities( $val[0]['evaluador'] ).'</td >
                        <td >' . htmlentities( $val[0]['evaludador_nombre'] ).'</td >
                        <td >' . htmlentities( $val[0]['role'] ).'</td > 
                         <td >' .htmlentities( $val[0]['firstname'] ). ' '. htmlentities( $val[0]['lastname'] ). '</td>
                        <td > ' . htmlentities( $grupo ). '</td >'; 
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

