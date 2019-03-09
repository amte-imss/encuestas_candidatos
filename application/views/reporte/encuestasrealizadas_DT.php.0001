<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-amarillo">
            <div class="panel-heading clearfix breadcrumbs6">
                <h1><?php echo $datos_curso['data'][0]['cur_clave'].'-'.$datos_curso['data'][0]['cur_nom_completo'];?></h1><br>
                <h2 class="panel-title" style="padding-left:20px;">Listado de encuestas realizadas por curso</h2>
                <a href="<?php echo site_url('curso/info_curso/'.$curso); ?>" class="btn btn-info pull-right"> <span class="glyphicon glyphicon-level-up"></span> Regresar a detalle curso</a>
            </div>
           
            <div class="panel-body">
                <div class="row" >
                    <form method="post" action="<?= base_url(); ?>index.php/resultadocurenrealizada/export_data/">
                        <input type="submit" value="Exportar" class="btn btn-info btn-sm espacio" >
                        <input type="hidden" value="824" name="curso">
                    </form>
                </div>
                <input type="hidden" id="curso" name="curso" value="<?php echo $curso ?>">
                <input type="hidden" id="bactiva" name="bactiva" value="0">

                <div id="listado_resultado">

                </div>
             </div>  <!-- /panel-body-->
        </div> <!-- /panel panel-amarillo-->
    </div> <!-- /col 12-->
</div>
<div class="row"></div>
<script type="text/javascript">
//    $(document).ready(function() {
    $(window).load(function() {
        var curso=$("#curso").val();
        var recurso = {
            per_page:5
            , order: "firstname"
            , order_type: "DESC"
            , curso: curso
            , bactiva: 0
        }
        var configTable = {
            "info": true
            , "searching": false
            , "lengthChange": true
            , "scrollX": true
        }
        data_ajax(site_url + "/resultadocurenrealizada/get_data_ajax/"+curso, recurso, "#listado_resultado", callbackIniDataTables("#tblResultadoRealizada", configTable) );
        
//        $("#btn_export").click(function(){
//            var url = site_url + "/resultadocurenrealizada/export_data/";
//            $.ajax({
//                url: url
//                , method: "POST"
//                , data: {
//                    curso: curso
//                }
//                , succes: function(){
//                    console.log("exito");
//                }
//                , error: function(){
//                    console.warn("no se ha relizado la conexión ajax");
//                }
//            });
//        });
        
    });
</script>
<link href="../../../assets/third-party/dataTables/v1/datatables.css" rel="stylesheet" type="text/css"/>
<link href="../../../assets/third-party/dataTables/v1/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
<script src="../../../assets/third-party/dataTables/v1/datatables.js" type="text/javascript"></script>
