$(document).ready(function(){
	//$('[data-toggle="tooltip"]').tooltip(); //Llamada a tooltip
    //$('#btn_buscar_b').unbind("click");
    var evento_buscar = $('#btn_buscar_b').attr("onclick"); //Obtener funcionamiento
    $('#btn_buscar_b').attr("onclick", ""); //Remover evento asignado
    $('#btn_buscar_b').click(function(event) {
        event.preventDefault(); //Prevenir evento por default
        var anio = $('#anio').val(); //Obtener valores obligatorios
        var instrumento_regla = $('#instrumento_regla').val();
        var is_bono = $('#is_bono').val();
        if(anio==="" || instrumento_regla==="" || is_bono==="" || ($('#encuesta').length>0 && $('#encuesta').val()==="")){
            alert('No ha seleccionado todos los campos obligatorios');
        } else {
            jQuery.globalEval(evento_buscar);
        }
    });

    var evento = $('#btn_export').attr("onclick"); //Obtener funcionamiento
    $('#btn_export').attr("onclick", ""); //Remover evento asignado
    $('#btn_export').click(function(event) {
        event.preventDefault(); //Prevenir evento por default
        var anio = $('#anio').val(); //Obtener valores obligatorios
        var instrumento_regla = $('#instrumento_regla').val();
        var is_bono = $('#is_bono').val();
        if(anio==="" || instrumento_regla==="" || is_bono==="" || ($('#encuesta').length>0 && $('#encuesta').val()==="")){
            alert('No ha seleccionado todos los campos obligatorios');
        } else {
            //jQuery.globalEval(evento);
            $("#form_curso").attr('action', site_url+'/reporte_detallado/reporte_detallado_export');
            $("#form_curso").submit();
        }
    });
});

/*
 * @author  ???
 * @modified_by DPérez
 * @param url para conexión ajax
 * @param id html del formulario donde se obtienen los datos a enviar en ajax u objeto a mandar directo.
 * @param id html del elemento que contendrá los datos del resultado
 * @param función que se ejecutará cuando el ajax es correcto y se tienen datos
 * @returns none
 */
/*function data_ajax(path, recurso, elemento_resultado, callback) {
    var dataSend;
    if(typeof recurso === "object"){
        dataSend = recurso;
    }else if(typeof recurso === "string" && recurso.charAt(0) === "#"){
        dataSend = $(recurso).serialize();
    }
    $.ajax({
        url: path,
        data: dataSend,
        method: 'POST',
        beforeSend: function (xhr) {
            $(elemento_resultado).html(create_loader());
        }
    })
    .done(function (response) {
        if( typeof callback !== 'undefined' && typeof callback === 'function' ){
            $(elemento_resultado).html(response).promise().done(callback());
        }else{
            $(elemento_resultado).html(response);
        }
    })
    .fail(function (jqXHR, textStatus) {
        $(elemento_resultado).html("Ocurrió un error durante el proceso, inténtelo más tarde.");
    })
    .always(function () {
        remove_loader();
    });

}*/
