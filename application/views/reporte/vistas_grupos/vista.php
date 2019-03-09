<?php
//pr($vistas);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// pr($formulario);
$o = array('ordenar_general', 'ordenar_por_con_no_con',/*Nueva*/'ordenar_detalle_por', 'ordenar_por', 'order_columns', 'ordenar_por_puntos',); //Ordenmiento variantes 
$order = array();
foreach ($o as $val) {
//    pr(${$val});
    if (isset(${$val})) {
        $order = ${$val};
        break;
    }
}
?>

<?php
echo form_open($controlador, array('id' => 'form_curso'));
?>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-amarillo">
            <div class="panel-heading clearfix breadcrumbs6">
                <?php if (isset($text_extra)) { ?>
                    <h1><?php echo $text_extra ?></h1><br>
                <?php } ?>
                <h2 class="panel-title" style="padding-left:20px;"><?php echo $subtitulo; ?></h2>
                <!-- <p>Para realizar la búsqueda, los filtros mínimos seleccionables son los marcados con <span style="color:blue;">*</span> o en su defecto los que esten marcados con <span style="color:red;">*</span></p> -->
            </div>
            <div class="panel-body">

                <?php
                if (isset($curso)) {
                    ?>
                    <input type = "hidden" id = "curso" name = "curso" value = "<?php echo $curso ?>">
                    <input type="hidden" id="bactiva" name="bactiva" value="0">
                    <?php
                }
                if (isset($tutorizado)) {
                    ?>
                    <input type="hidden" id="bactiva" name="tutorizado" value="<?php echo $tutorizado ?>">

                    <?php
                }
                ?>
                <?php
                if (isset($vistas)) {
                    $count = count($vistas);
                    $i = 0;
                    while ($i < $count) {
                        ?>
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <?php
                                echo $vistas[$i];
                                ?>
                            </div>
                            <?php if (isset($vistas[$i + 1])) { ?>
                                <div class="col-lg-6 col-sm-6">
                                    <?php
                                    echo $vistas[$i + 1];
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                        <?php
                        $i+=2;
                    }
                }
                ?>
                <?php
                if (isset($vistas_2)) {
                    $count = count($vistas_2);
                    $i = 0;
                    while ($i < $count) {
                        ?>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <?php
                                echo $vistas_2[$i];
                                ?>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                }
                ?>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 text-right">
                        <div class="input-group-btn" >
                            <button type="button" id="btn_buscar_b" name="btn_buscar_b" aria-expanded="false" class="btn btn-primary browse" title="Buscar" data-toggle="tooltip" onclick="data_ajax(<?php echo $url_control; ?>)" >
                                Buscar <span aria-hidden="true" class="glyphicon glyphicon-search"></span>
                            </button>
                            <?php if (!empty($exportar)) { ?>
                                <button type="button" id="btn_export" name="btn_export" aria-expanded="false" class="btn btn-primary browse" title="Exportar" data-toggle="tooltip" style="margin-left:10px;">
                                    Exportar<span aria-hidden="true" class="glyphicon glyphicon-export"></span>
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Número de registros a mostrar:</span>
                            <?php // echo $this->form_complete->create_element(array('id'=>'per_page', 'type'=>'dropdown', 'options'=>array(2=>2,3=>3,4=>4,10=>10, 20=>20, 50=>50, 100=>100), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Número de registros a mostrar', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Número de registros a mostrar', 'onchange'=>"data_ajax(site_url+'/bonos_titular/get_buscar_cursos_encuestas', '#form_buscador', '#listado_resultado_empleado')")));      ?>
                            <?php echo $this->form_complete->create_element(array('id' => 'per_page', 'type' => 'dropdown', 'options' => array(5 => 5, 10 => 10, 20 => 20, 50 => 50, 100 => 100), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Número de registros a mostrar', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Número de registros a mostrar', 'onchange' => "data_ajax($url_control)"))); ?>
                        </div>
                    </div>
                    <?php if (!empty($order)) { ?>
                        <div class="col-lg-4 col-sm-4">
                            <div class="panel-body input-group input-group-sm">
                                <span class="input-group-addon">Ordenar por:</span>
                                <?php echo $this->form_complete->create_element(array('id' => 'order', 'type' => 'dropdown', 'options' => $order, 'attributes' => array('class' => 'form-control', 'placeholder' => 'Ordernar por', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ordenar por', 'onchange' => "data_ajax($url_control)"))); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Tipo de orden:</span>
                            <?php echo $this->form_complete->create_element(array('id' => 'order_type', 'type' => 'dropdown', 'options' => $order_by, 'attributes' => array('class' => 'form-control', 'placeholder' => 'Tipo de orden', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Tipo de orden', 'onchange' => "data_ajax($url_control)"))); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 text-left">
                    </div>
                </div>
                <div id="listado_resultado_empleado">

                </div>
                <div id="listado_resultado">

                </div>
            </div>
        </div>
    </div>
</div>

<?php
//echo js("busquedas/busqueda.js");
foreach ($js as $file_js) {
    echo js($file_js);
}
?>

<script type="text/javascript">
    $(document).ready(function () {
    });
    $(window).load(function () {
//        $( "#btn_buscar_b" ).trigger( "click" );
<?php // $extrac = (isset($curso))? $curso:''  ?>
<?php if (!empty($exportar)) { ?>
            $("#btn_export").click(function (event) {
                event.preventDefault();
                //alert('fasdfasd');
                $("<?php echo $formulario; ?>").attr("action", site_url + "/<?php echo $exportar; ?>");
                $("<?php echo $formulario; ?>").submit();
                //data_ajax(site_url+"/buscador/export_data", "#form_buscador", "#listado_resultado");        
            });
<?php } ?>
    });
</script>