<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php echo (!is_null($title)) ? "{$title}::" : "" ?> Encuestas de satisfacción
        </title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <script type="application/x-javascript">
            addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }
        </script>

        <?php echo css("bootstrap.min.css"); ?>
        <?php echo css("jasny-bootstrap.min.css"); ?>


        <!-- Custom Theme files -->
        <?php echo css("mainBody.css"); ?>
        <?php echo css("moodle_encuestas.css"); ?>
        <!-- Custom and plugin javascript -->
        <?php echo css("selectric.css"); ?>
        <?php //echo css("bonos.css"); ?>
        <?php echo css("custom.css"); ?>
        <?php echo css("font-awesome.css"); ?>
        <?php echo css("encuestas.css"); ?>
        <?php echo js("jquery.min.js"); ?>
        <?php //echo js("jquery.selectric.js"); ?>
        <?php echo js("bootstrap.min.js"); ?>
        <?php echo js("general.js"); ?>
        <script type="text/javascript">
            var img_url_loader = "<?php echo img_url_loader(); ?>";
            var site_url = "<?php echo site_url(); ?>";
<?php echo $css_script; ?>
        </script>

        <!--[if lt IE 9]>
                <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>
    <body>
        <div id="overlay">
           <img src="<?php echo base_url('assets/img/loader.gif'); ?>" alt="Loading" /><br/>
           Cargando...
       </div>
        <!-- Modal -->
        <div class="modal fade" id="my_modal" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div id="my_modal_content">
    <?php if(isset($cuerpo_modal)){ echo $cuerpo_modal;}?>
                    </div>
                </div>
            </div>
        </div>
        <!-- termina el modal -->
        <!-- inicia el encabezado -->
        <section style="text-align:center"><?php echo img("header_v2.jpg"); ?></section>
        <?php
        $secciones_acceso = $this->acceso->get_secciones_modulos_sistema($menu);

        echo $this->load->view("template/navbar.tpl.php", ['secciones_acceso' => $secciones_acceso, 'modulos' => $menu], true);
        ?>
        <!-- inicia contenido -->
        <div class="row">
            <div class="large-12 columns">
                <fieldset>
<?php if(!is_null($main_title)){ ?>
                    <legend align=''><?php echo $main_title; ?></legend>
                    <?php } ?>

                    <div class="clearfix"></div>
<?php
if (!is_null($main_content)) {
    echo $main_content;
}
?>
                </fieldset>
            </div>
        </div>
        <!-- Se declara una ventana modal llamada modal_censo -->
        <div class="modal fade" id="modal_censo" tabindex="-1" role="dialog" aria-labelledby="modal_censo_label">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" id="modal_content">
                    <!-- Cuerpo de la ventana modal -->
<?php echo (!is_null($cuerpo_modal)) ? "{$cuerpo_modal}" : ""; ?>
                </div>
            </div>
        </div>
        <!-- Termina la ventana modal llamada modal_censo -->

        <!-- inicia pie de página -->
        <div class="clearfix"> </div>
        <footer class="zurb-footer-bottom">
            <div class="row">
                <div class="large-6 columns">
                    <p class="copyright">© IMSS-MÉXICO Derechos Reservados 2016.</p>
                </div>
                <div class="large-6 columns">
                    <p class="copyright">Este sitio se visualiza en <a href="http://windows.microsoft.com/es-mx/internet-explorer/ie-9-worldwide-languages" target="_blank">Internet Explorer 9</a><span>,  </span><a href="https://download.mozilla.org/?product=firefox-stub&amp;os=win&amp;lang=es-MX" target="_blank">Firefox 26</a><span> y  </span><a href="http://www.google.com.mx/intl/es/chrome/browser/index.html#eula" target="_blank">Chrome 32</a></p>
                </div>
            </div>
        </footer>
        <script>
//                $(function(){$('select').selectric();});
        </script>
        <!-- #####carga de archivos js -->
<?php echo js("moment.js"); ?>
<?php echo js("collapse.js"); ?>
<?php echo js("transition.js"); ?>
<?php // echo js("bootstrap.min.js"); ?>
        <?php echo js("bootstrap-datetimepicker.min.js"); ?>
        <?php echo js("datetimepicker-years.js"); ?>

    </body>
</html>
