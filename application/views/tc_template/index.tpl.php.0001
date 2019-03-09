<?php
/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
?>

<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8" />        
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>
            <?php echo (!is_null($title)) ? "{$title}&nbsp;|" : "" ?>
            <?php echo (!is_null($main_title)) ? $main_title : "Bonos" ?>
        </title>

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />

        <!-- Bootstrap core CSS     -->
        <link href="<?php echo base_url(); ?>assets/bonos_tpl/css/bootstrap.min.css" rel="stylesheet" />
        <!-- Custom Theme files -->
        <?php echo css("mainBody.css"); ?>
        <?php echo css("moodle_encuestas.css"); ?>
        <!-- Custom and plugin javascript -->
        <?php echo css("selectric.css"); ?>		
        <?php echo css("custom.css"); ?>
        <?php echo css("font-awesome.css"); ?>
        <?php echo css("encuestas.css"); ?>

        <script type="text/javascript">
            var url = "<?php echo base_url(); ?>";
            var site_url = "<?php echo site_url(); ?>";
            var img_url_loader = "<?php echo base_url('assets/img/loader.gif'); ?>";
        </script>

        <link href="<?php echo base_url(); ?>assets/jsgrid/css/jsgrid.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/jsgrid/css/jsgrid-theme.min.css" rel="stylesheet" />

        <!--   Core JS Files   -->
        <script src="<?php echo base_url(); ?>assets/bonos_tpl/js/jquery-3.2.1.min.js" type="text/javascript"></script>
        <!--<script src="<?php echo base_url(); ?>assets/bonos_tpl/js/jquery-1.10.2.js" type="text/javascript"></script>-->
        <script src="<?php echo base_url(); ?>assets/bonos_tpl/js/bootstrap.min.js" type="text/javascript"></script>

        <!-- Date -->
        <link href="<?php echo base_url(); ?>assets/bonos_tpl/css/jquery-ui.min.css" rel="stylesheet" />
        <script src="<?php echo base_url(); ?>assets/bonos_tpl/js/jquery-ui.js" type="text/javascript"></script>

        <!-- Grid plugin -->
        <script src="<?php echo base_url(); ?>assets/jsgrid/js/jsgrid.min.js"></script>

        <?php
        if (isset($css_files) && !empty(($css_files)))
        {
            foreach ($css_files as $key => $css)
            {
                echo css($css);
            }
        }
        if (isset($js_files) && !empty(($js_files)))
        {
            foreach ($js_files as $key => $js)
            {
                echo js($js);
            }
        }
        ?>
    </head>

    <style>
        .datepicker{z-index:1151 !important;}
    </style>

    <body>
        <!-- inicia el encabezado -->
        <section style="text-align:center"><?php echo img("header_v2.jpg"); ?></section>
        <?php
        echo $this->load->view("tc_template/menu.tpl.php", array(), true);
        ?>
        <!-- inicia contenido -->
        <div class="col-md-offset-1 col-md-10">
            <!--<div class="large-12 columns">-->
            <div>
                <?php
                if (!is_null($main_title))
                {
                    ?>
                    <legend align=''><?php echo $main_title; ?></legend>
                <?php } ?>

                <div ></div>
                <?php
                if (!is_null($main_content))
                {
                    echo $main_content;
                }
                ?>
            </div>
            <!--</div>-->
        </div>

        <!-- Modal -->
        <div class="modal fade" id="my_modal" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div id="my_modal_content">
                        <?php
                        if (isset($cuerpo_modal))
                        {
                            echo $cuerpo_modal;
                        }
                        ?>
                    </div>                    
                </div>
            </div>
        </div>
        <!-- termina el modal -->


        <!-- inicia pie de página -->
        <footer class="zurb-footer-bottom">
            <div class="col-md-12">
                <div class="large-6 columns">
                    <p class="copyright">© IMSS-MÉXICO Derechos Reservados <script>document.write(new Date().getFullYear())</script>.</p>
                </div>
                <div class="large-6 columns">
                    <p class="copyright pull-right">
                        <a style="text-decoration: underline;" href="http://educacionensalud.imss.gob.mx" target="_blank">Coordinación de Educación en Salud</a>
                    </p>
                </div>
            </div>
        </footer>

    </body>

    <!--  Notifications Plugin    -->
    <script src="<?php echo base_url(); ?>assets/bonos_tpl/js/bootstrap-notify.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/general.js"></script>       
</html>