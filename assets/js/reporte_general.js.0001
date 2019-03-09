$(document).ready(function(){
	//$('[data-toggle="tooltip"]').tooltip(); //Llamada a tooltip
    //$('#btn_buscar_b').unbind("click");
    var evento_buscar = $('#btn_buscar_b').attr("onclick"); //Obtener funcionamiento
    $('#btn_buscar_b').attr("onclick", ""); //Remover evento asignado
    $('#btn_buscar_b').click(function(event) {
        event.preventDefault(); //Prevenir evento por default
        jQuery.globalEval(evento_buscar);
    });
    
    var evento = $('#btn_export').attr("onclick"); //Obtener funcionamiento
    $('#btn_export').attr("onclick", ""); //Remover evento asignado
    $('#btn_export').click(function(event) { //Asignar nuevo evento
        event.preventDefault(); //Prevenir evento por default
        //jQuery.globalEval(evento);
        $("#form_curso").attr('action', site_url+'/reporte_general/reporte_detallado_export');
        $("#form_curso").submit();
    });
});
