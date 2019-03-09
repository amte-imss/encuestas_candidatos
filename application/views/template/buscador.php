<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <?php
    echo meta('X-UA-Compatible', 'IE=edge', 'equiv');
	echo meta('viewport', 'width=device-width, initial-scale=1');
	echo meta('description', 'Sitio Conricyt :: Recursos de información :: Buscador');
	?>
	<title>Convenio IMSS-CONACYT :: Recursos de información</title>
	<?php
	echo css('bootstrap.css'); //<!-- Bootstrap Core CSS -->
	echo css('buscador/conricyt.css');
	//<!-- Custom Fonts -->
	echo css('font-awesome-4.1.0/css/font-awesome.min.css');
	echo css('buscador/flexslider.css');
	//echo css('buscador/bxslider/jquery.bxslider.css');
	echo css('buscador/animate.css');
	echo "<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>";
	echo css('buscador/component.css');
	echo css('buscador/style.css');
	echo css('buscador/style-responsive.css');
	echo css('buscador/owlcarousel/owl.carousel.css');
	echo css('buscador/owlcarousel/owl.theme.css');
	//echo css('buscador/parallax-slider/parallax-slider.css');
	echo $css_files;
	//echo js("buscador/parallax-slider/modernizr.custom.28468.js");
	?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    	<?php echo js("html5shiv.js");
    	echo js("respond.min.js"); ?>
    <![endif]-->	
	<!-- jQuery Version 1.11.0 -->
	<?php 
	echo js("jquery-1.11.0.js");
	echo js("bootstrap.min.js"); //<!-- Bootstrap Core JavaScript -->
	echo js("buscador/hover-dropdown.js");
	echo js("buscador/jquery.flexslider.js");
	echo js("buscador/wow.min.js");
	echo js("buscador/owlcarousel/owl.carousel.js");
	echo js("buscador/jquery.easing.min.js");
	echo js("buscador/link-hover.js");
	echo js("buscador/superfish.js");
	echo js("buscador/common-scripts.js");
	/* echo js("tooltip.js");
	echo js("popover.js");
	echo js("jquery-ui.js");
	echo js("dataTables.js");
	echo js("dataTables-bootstrap.js");	*/
	?>
	<script type="text/javascript">
		var img_url_loader = "<?php echo img_url_loader(); ?>";
		var site_url = "<?php echo site_url(); ?>";
		$('a.info').tooltip();
		$(window).load(function() {
			$('.flexslider').flexslider({
				animation: "slide",
				start: function(slider) {
					$('body').removeClass('loading');
				}
			});
		});
		jQuery(document).ready(function(){
			$("#owl-demo").owlCarousel({
	        	items : 4
	        });
			jQuery('ul.superfish').superfish();
		});
		new WOW().init();
		<?php echo $css_script; ?>
	</script>
	<?php 
	echo js("general.js");
	echo $js_files;
	?>
</head>
<body>
	<!-- Header -->
    <div class="container top">
        
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 hidden-xs cabeza">
                 <a href="http://www.presidencia.gob.mx/" target="_blank"><?php echo img('presidencia.png', array('class'=>'img-responsive')); ?><!--<img class="img-responsive" src="img/presidencia.png">--></a>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs cabeza">
                <a href="http://www.conricyt.mx/" target="_blank"><?php echo img('conricyt.png', array('class'=>'img-responsive')); ?><!--<img'presidencia class="img-responsive" src="img/conricyt.png">--></a>
            </div>
             <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs cabeza">
                <a href="http://edumed.imss.gob.mx/2010/" target="_blank"><?php echo img('CES.png', array('class'=>'img-responsive')); ?><!--<img class="img-responsive" src="img/CES.png">--></a>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-3 hidden-xs cabeza">
                <a href="http://www.imss.gob.mx/" target="_blank"><?php echo img('imss.png', array('class'=>'img-responsive')); ?><!--<img class="img-responsive" src="img/imss.png">--></a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12 cabeza">
                <div class="pull-right">
               <a href="http://acceso.conricyt.mx/auth/registration.php?profile=new" target="_blank"><button type="button" class="btn btn-primary"> Registra tu acceso remoto</button></a>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> Contacto</button>
                </div>
            </div>
        </div>
        
    </div>
        
        
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                            <h2 class="modal-title" id="myModalLabel">Contacto</h2>
                          </div>
                          <div class="modal-body">
                              <div class="media">
                                  <div class="pull-left">
                                      <?php echo img('mesa.png', array('class'=>'img-responsive thumbnail')); ?>
                                     
                                  </div>
                                  <div class="media-body">
                                      <h3 class="media-heading">Mesa de ayuda</h3>
                                      <p>No dude en ponerse en contacto con nosotros.</p>
                                      <p><i class="fa fa-phone"></i> 
                                          <abbr title="Phone">Tel</abbr>: 56 27 69 00 <strong> Exts.</strong> 21146, 21147 y 21148 </p>
                                         <p><i class="fa fa-arrow-circle-right"></i> 
                                          <abbr title="red">Red</abbr>: 865021146, 865021147, 865021148</p>
                                      <p><i class="fa fa-envelope-o"></i> 
                                          <abbr title="Email">Email</abbr>: <a href="mailto:acceso.edumed@imss.gob.mx">acceso.edumed@imss.gob.mx</a>
                                      </p>
                                      <p><i class="fa fa-clock-o"></i> 
                                          <abbr title="Hours">Horario</abbr>: lunes - viernes: 8:00 AM a 16:00 Hrs</p>
                                  </div>
                              </div>
                          </div><!--cierra modal-body-->

                          <div class="modal-body">
                              <div class="media">
                                  <div class="pull-left">
                                      <?php echo img('disponibilidad.png', array('class'=>'img-responsive thumbnail')); ?>
                                     
                                  </div>
                                  <div class="media-body">
                                      <h3 class="media-heading">Disponibilidad de Recursos</h3>
                                      <p><strong>Lic. Verónica Sánchez Castillo </strong></p>
                                      <p>División de Innovación Educativa </p>
                                      <p><i class="fa fa-phone"></i> 
                                          <abbr title="Phone">Tel</abbr>:  (55) 5627 6900   <strong> Exts.</strong> 21250</p>
                                      <p><i class="fa fa-envelope-o"></i> 
                                          <abbr title="Email">Email</abbr>: <a href="mailto:veronica.sanchezc@imss.gob.mx">veronica.sanchezc@imss.gob.mx</a>
                                      </p>
                                      <p><i class="fa fa-clock-o"></i> 
                                          <abbr title="Hours">Horario</abbr>: lunes - viernes: 8:00 AM a 16:00 Hrs</p>
                                  </div>
                              </div>
                          </div><!--cierra modal-body-->
                          <div class="modal-body">
                              <div class="media">
                                  <div class="pull-left">
                                      <?php echo img('capa.png', array('class'=>'img-responsive thumbnail')); ?>
                                     
                                  </div>
                                  <div class="media-body">
                                      <h3 class="media-heading">Capacitación</h3>
                                      <p><strong>Dra. Sonia Aurora Gallardo Candelas</strong> </p>
                                      <p>División de Innovación Educativa </p>
                                      <p><i class="fa fa-phone"></i> 
                                          <abbr title="Phone">Tel</abbr>:  (55) 5627 6900   <strong> Exts.</strong> 21250</p>
                                      <p><i class="fa fa-envelope-o"></i> 
                                          <abbr title="Email">Email</abbr>: <a href="mailto:sonia.gallardoc@imss.gob.mx">sonia.gallardoc@imss.gob.mx</a>
                                      </p>
                                      <p><i class="fa fa-clock-o"></i> 
                                          <abbr title="Hours">Horario</abbr>: lunes - viernes: 8:00 AM a 16:00 Hrs</p>
                                  </div>
                              </div>
                          </div><!--cierra modal-body-->


                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
    <!-- Navigation start -->
    
    
<nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span>Menú</span>
                </button>
                <!--<a class="navbar-brand" href="index.html">Inicio</a>-->
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left">
                    <li class="">
                         <a href="index.html"> <span class="glyphicon glyphicon-home"></span> Inicio</a>
                    </li>
                    <li>
                        <a href="que.html">Conéctate al Conocimiento</a>
                    </li>
                    <li class="active">
                        <a href="<?php echo site_url('buscador'); ?>">Recursos de Información</a>
                    </li>
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Editoriales <span class="caret"></span> </a>
                         <ul class="dropdown-menu">
             <li><a href="jama.html">American Medical Association</a></li>
            <li><a href="ebsco.html">Ebsco México</a></li>
            <li><a href="elsevier.html">Elsevier B.V.</a></li>
            <li><a href="lippincott.html">Lippincott Williams &amp; Wilkins</a></li>
            <li><a href="nature.html">Nature America Inc.</a></li>
            <li><a href="oxford.html">Oxford University Press</a></li>
            <li><a href="springer.html">Springer Science + Business Media</a></li>
            <li><a href="decision.html">Decision Support in Medicine</a></li>
            <li><a href="thomson.html">Thomson Reuters</a></li>
            <li><a href="wiley.html">Wiley Blackwell</a></li>
            <li><a href="walters.html">Walters Kluwer Health</a></li>
          </ul>
                    </li>
                    <li>
                        <a href="requerimientos.html">Requerimientos</a>
                    </li>
                     <li class="">
                        <a href="materiales.html">Materiales de Apoyo</a>
                    </li>
                     
                   <!--<li class="">
                        <a href="http://innovacioneducativa.imss.gob.mx/reservas/Web/view-schedule.php" target="_blank">Capacitación</a>
                    </li>-->
                    <li class="">
                        <a href="faq.html">Preguntas Frecuentes</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>


    
    <!-- Navigation end -->
    <!--breadcrumbs start-->
	<div class="breadcrumbs6">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-sm-4">
					<h1>Recursos de Información</h1>
				</div>
				<div class="col-lg-8 col-sm-8">
					<ol class="breadcrumb pull-right">
						<li><a href="#">Inicio</a></li>
						<li class="active">Recursos de Información</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<!--breadcrumbs end-->
    <div style="clear:both;"></div>
    <!-- CONTENIDO PRINCIPAL -->
    <div class="property3 gray2-bg">
		<div class="container">
	        <?php echo $main_content; ?>
	        <div style="clear:both;"></div>
		</div><!-- /container -->
                <br><br>
	</div>
	<!-- Footer -->
 
        <footer class="footer-small">
        <div class="container">
            <div class="row">
                <!--<div class="col-lg-6 col-sm-6 pull-right">
                    <ul class="social-link-footer list-unstyled">
                        <li class="wow flipInX" data-wow-duration="2s" data-wow-delay=".1s"><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li class="wow flipInX" data-wow-duration="2s" data-wow-delay=".2s"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li class="wow flipInX" data-wow-duration="2s" data-wow-delay=".5s"><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li class="wow flipInX" data-wow-duration="2s" data-wow-delay=".8s"><a href="#"><i class="fa fa-youtube"></i></a></li>
                    </ul>
                </div>-->
                <div class="col-md-12">
                  <div class="copyright">
                    <p>Copyright © IMSS 2014. Este sitio se visualiza mejor a partir de resoluciones 1024 px con Explorer 11 / Firefox 33.0 / Chrome 38.0</p>
                  </div>
                </div>
            </div>
        </div>
    </footer>
	<!--<footer class="footer-small">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6 pull-right">
                    <ul class="social-link-footer list-unstyled">
                        <li class="wow flipInX" data-wow-duration="2s" data-wow-delay=".1s"><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li class="wow flipInX" data-wow-duration="2s" data-wow-delay=".2s"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li class="wow flipInX" data-wow-duration="2s" data-wow-delay=".5s"><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li class="wow flipInX" data-wow-duration="2s" data-wow-delay=".8s"><a href="#"><i class="fa fa-youtube"></i></a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                  <div class="copyright">
                    <p>Copyright © IMSS 2014. Este sitio se visualiza mejor a partir de resoluciones 1024 px con Explorer 11 / Firefox 33.0 / Chrome 38.0</p>
                  </div>
                </div>
            </div>
        </div>
    </footer>-->
</body>
</html>