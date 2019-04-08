var div_mensaje;
function cargar_candidatoscsv() {
    var formulario = "form_csv_candidatos";//Obtiene nombre del formulario
    var formData = new FormData($('#' + formulario)[0]);
//            alert(formulario);
    var div_respuesta = '#text_error_file';
    var url = "/candidatos/cargar_candidatos_csv";
//            var url = $('#ruta_controller').val();
//            formData.delete('ruta_controller');//Quita el elemento, solo indica la ruta
    $.ajax({
//                url: site_url + '/actividad_docente/datos_actividad',
        url: site_url + url,
        data: formData,
        type: 'POST',
        mimeType: "multipart/form-data",
        contentType: false,
//                contentType: "charset=utf-8",
        cache: false,
        processData: false,
//                dataType: 'JSON',
        beforeSend: function (xhr) {
//            $('#tabla_actividades_docente').html(create_loader());
            mostrar_loader();
        }
    })
            .done(function (data) {
                try {//Cacha el error
                    $(div_respuesta).empty();
                    div_mensaje = 'error_file';
                    var resp = $.parseJSON(data);
//                    if (typeof resp.html !== 'undefined') {
                    ver_div_notificacion();
                    tipo_alerta_div_notificacion(resp.tp_msg);
                    text_div_notificaciones(resp.msg);
                    if (resp.tp_msg === 'success') {
                        $('#candidatosfile').val('');//Limpia archivo file
                        div_notificaciones_cerrar(6000);
//                        actaliza_data_table(url_actualiza_tabla);
                    } else {
                    }
                    if (typeof resp.mensaje !== 'undefined') {//Muestra mensaje al usuario si este existe
                    }
//                    }
                } catch (e) {
                }

            })
            .fail(function (jqXHR, response) {
//                        $(div_respuesta).html(response);
//                get_mensaje_general('Ocurrió un error durante el proceso, inténtelo más tarde.', 'warning', 5000);
            })
            .always(function () {
                ocultar_loader();
            });
}

function ocultar_div_notificacion() {
    $("#" + div_mensaje).css("display", "none");
}

function ver_div_notificacion() {
    $("#" + div_mensaje).css("display", "block");

}
function tipo_alerta_div_notificacion(alerta) {
    $("#" + div_mensaje).removeClass('alert alert-danger').removeClass('alert alert-success').addClass('alert alert-' + alerta);
}
function text_div_notificaciones(mensaje) {
    $("#text_" + div_mensaje).html(mensaje);
}

function div_notificaciones_cerrar(timeout) {
    var ind = '$("#' + div_mensaje + '").css("display", "none")';
    console.log(ind);
    setTimeout(ind, timeout);
}