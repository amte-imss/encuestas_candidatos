<?php
$datos_sesion = $this->session->get_datos_sesion_sistema();
$logueado = is_null($datos_sesion) ? FALSE : TRUE;
$nombre = $datos_sesion[SessionSIED::NOMBRE];  //Tipo de usuario almacenado en sesiÃ³n
// pr($secciones_acceso);
$array_controlador = array('encuestausuario' => array('lista_encuesta_usuario', 'instrumento_asignado', 'guardar_encuesta_usuario'));
$valida_menu = 1; //Valida unicamente los acccesos de menú de reportes
foreach ($array_controlador as $controlador => $metodos) {
    if ($controlador == $this->uri->segment(1)) {
        foreach ($metodos as $value) {
            if ($value == $this->uri->segment(2)) {
                $valida_menu = 0;
            }
        }
    }
}
// pr($modulos);
if (isset($logueado) && !empty($logueado)) {
    ?>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <?php if ($valida_menu) { ?>
                <div class="navbar-header right" onclick="window.close(this);">
                    <a class="navbar-brand" href="<?php echo site_url('login/cerrar_session'); ?>" onclick="window.close(this);">Cerrar sesión
                        <span class="glyphicon glyphicon-log-out" ></span></a>
                </div>
                <ul class="nav navbar-nav">
                    <?php if (isset($secciones_acceso[En_modulos::ENCUESTAS])) { ?>
                        <li><a href="<?php echo site_url('encuestas/index'); ?>">Encuestas</a></li>
                    <?php } ?>
                    <?php if (isset($secciones_acceso[En_modulos::IMPLEMENTACIONES])) { ?>
                        <li><a href="<?php echo site_url('curso/index'); ?>" class="a_nav_sied" >Implementaciones</a></li>
                    <?php } ?>
                    <?php if (isset($secciones_acceso[En_modulos::REPORTES])) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reportes
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($modulos as $value_hijos) {
                                    if (En_modulos::REPORTES == $value_hijos['padre'] and $value_hijos['is_menu'] == 1  && $value_hijos['activo'] == 1) {
                                        ?>
                                        <li><a href="<?php echo site_url($value_hijos['url']); ?>" class="a_menu"><?php echo $value_hijos['nombre'] ?></a></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (isset($secciones_acceso[En_modulos::GESTION])) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Gestión
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($modulos as $value_hijos) {
                                    if (En_modulos::GESTION == $value_hijos['padre'] and $value_hijos['is_menu'] == 1  && $value_hijos['activo'] == 1) {
                                        ?>
                                        <li><a href="<?php echo site_url($value_hijos['url']); ?>" class="a_menu"><?php echo $value_hijos['nombre'] ?></a></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if (isset($secciones_acceso[En_modulos::CANDIDATOS])) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Candidatos nominativos
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($modulos as $value_hijos) {
                                    if (En_modulos::CANDIDATOS == $value_hijos['padre'] and $value_hijos['is_menu'] == 1  && $value_hijos['activo'] == 1) {
                                        ?>
                                        <li><a href="<?php echo site_url($value_hijos['url']); ?>" class="a_menu"><?php echo $value_hijos['nombre'] ?></a></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if (isset($secciones_acceso[En_modulos::ADMINISTRACION])) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Catálogos
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($modulos as $value_hijos) {
                                    if (En_modulos::ADMINISTRACION == $value_hijos['padre'] and $value_hijos['is_menu'] == 1 && $value_hijos['activo'] == 1) {
                                        ?>
                                        <li><a href="<?php echo site_url($value_hijos['url']); ?>" class="a_menu"><?php echo $value_hijos['nombre'] ?></a></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <li>
                        <a href="<?php echo site_url('login/regresar_sied'); ?>" class="a_nav_sied">
                            Regresar a SIED
                        </a>
                    </li>
                </ul>
            <?php } else { ?>
                <div class="navbar-header right">
                    <a class="navbar-brand" href="<?php echo site_url('login/cerrar_session/edu'); ?>">Cerrar sesión
                        <span class="glyphicon glyphicon-log-out"></span></a>
                </div>
            <?php } ?>
        </div>
    </nav>

    <?php if ($valida_menu) { ?>
        <div class="row">
            <div style="text-align:right; margin-right: 15px;"><?php echo $nombre; ?></div>
        </div>
        <div class="clearfix"></div>
    <?php } ?>
    <?php
}
