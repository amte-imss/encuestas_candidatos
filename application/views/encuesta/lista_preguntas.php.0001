<?php 
echo js("jquery-ui-1.12.0.custom.js"); ?>
<style type="text/css">
    /*.content_orden{
        padding-top: 20px;
        /*width: 480px;
        margin: 0 auto;
    }*/
    ul#preguntas{
        list-style: none;;
        /*margin: 0;
        padding: 0;*/
    }
    /*
    ul#preguntas li{
        display: block;
        /*background: #f6f6f6;*/
        /*border: 1px solid #ccc;*/
        /*color: #3594c4;
        margin-top: 3px;
        /*height: 50px;
        padding: 3px;
    }*/
    .ui-state-highlight{
        background: #fff0a5;
        border: 1px solid #fed22f;
    }
    /*
    .msg_orden{
        color: #0c0;
        font: normal 11px Tahoma;
    }*/
</style>

<script type="text/javascript">
$(document).ready(function() {
    $("ul#preguntas").sortable({ placeholder: "ui-state-highlight",opacity:0.6, cursor:'move', update:function(){
            var order = $(this).sortable("serialize");
            $.post("<?php echo site_url('encuestas/ajax_orden'); ?>",order, function(respuesta){
                $(".msg_orden").html(respuesta).fadeIn("fast").fadeOut(2500);
            });
        } 
    });
});
</script>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-amarillo">
            <div class="panel-body">
                <a href="<?php echo site_url('encuestas/edit/'.$instrumento); ?>" class="btn pull-right"><span class="glyphicon glyphicon-list" aria-hidden="true"> </span> Regresar a preguntas </a>
                <br>
                <br>
                
                <div class="content_orden">
                    <h3>Ordenar preguntas</h3><br>

                    <div class="msg_orden"></div>
            
                    <?php 
                    if (isset($preguntas['data']) && !empty($preguntas['data']) && isset($instrumento) && !empty($instrumento)){

                    ?>
                    <ul id="preguntas" class="list-group">
    
                        <?php   
                        foreach ($preguntas['data'] as $key => $val) {
                            $color_li = ($val['orden'] == 0 ) ? 'active' : '';
                        ?>
                        <li id="pregunta-<?php echo $val['preguntas_cve']; ?>" class="list-group-item <?php echo $color_li;?>">                            
                            <p class="list-group-item-text"><span class="badge"><?php echo $val['orden']; ?></span><?php echo "". $val['pregunta'].""; ?></p>
                        </li>                    

                        <?php

                        }

                        ?>
                    </ul>

                    <?php   

                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>