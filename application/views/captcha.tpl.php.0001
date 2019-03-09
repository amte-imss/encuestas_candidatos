<?php   defined('BASEPATH') OR exit('No direct script access allowed');   ?>

<div id="change_captcha">
    <div id="img-captcha"><?php echo $captcha['image']; ?>
    <a class="btn btn-lg btn-link pull-right" onclick="change_image();">
        <span class="glyphicon glyphicon-refresh"></span>
    </a>
    </div>

    <script type="text/javascript">
        function change_image() {
            data_ajax(site_url+"/captcha/get_new_captcha_ajax", "null", "#change_captcha"); // aqui va el nombre del controlador desde donde se ejecuta el captcha junto con su funcion ajax
            console.log("image captcha changed!");
            //$( "#img-captcha" ).find( "img" ).addClass( "img-rounded");
            event.preventDefault();
        }
    </script>
</div>
