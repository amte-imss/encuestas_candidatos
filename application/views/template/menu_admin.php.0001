<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Navigation -->
<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--<a class="navbar-brand" href="index.html">Inicio</a>-->
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="<?php echo base_url(); ?>index.php/dashboard/"> <span class="glyphicon glyphicon-home"></span> Inicio</a>
                </li>
                <li>
                    <a aria-expanded="false" aria-haspopup="true" role="button" href="#" data-toggle="dropdown" class="dropdown-toggle">Publicaciones<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo site_url('publicacion'); ?>">Revisar las publicaciones</a></li>
                        <li><a href="<?php echo site_url('publicacion/edicion/'.encrypt_base64($this->config->item('id_insercion'))); ?>">Agregar publicaciones</a></li>
                    </ul>
                </li>
                <!-- <li>
                    <a href="<?php echo base_url(); ?>index.php/publicacion/">Buscador de publicaciones</a>
                </li>
                <li>
                    <a href="<?php echo site_url('publicacion/edicion/MA'); ?>">Agregar publicaciones</a>
                </li> -->
                <li class="active">
                    <a href="#" target="_blank">Ir al sitio Web</a>
                </li>
                <li class="pull-right">
                    <a href="<?php echo base_url(); ?>index.php/login/cerrar_session/">Cerrar sesi&oacute;n</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>