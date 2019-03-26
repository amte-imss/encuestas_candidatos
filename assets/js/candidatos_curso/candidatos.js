function cargar_candidatoscsv() {
    var formulario = "form_csv_candidatos";//Obtiene nombre del formulario
    var formData = new FormData($('#' + formulario)[0]);
//            alert(formulario);
    var div_respuesta = '#grid_candidatos';
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
                    var resp = $.parseJSON(data);
                    if (typeof resp.html !== 'undefined') {
                        if (resp.tp_msg === 'success') {
                            $(div_respuesta).html('');
                            reinicia_monitor();
                            actaliza_data_table(url_actualiza_tabla);
                        } else {
                            $(div_respuesta).html(resp.html);
                        }
                        if (typeof resp.mensaje !== 'undefined') {//Muestra mensaje al usuario si este existe
                            get_mensaje_general(resp.mensaje, resp.tp_msg, 5000);
                        }
                    }
                } catch (e) {
                    $(div_respuesta).html(data);
                }

            })
            .fail(function (jqXHR, response) {
//                        $(div_respuesta).html(response);
                get_mensaje_general('Ocurrió un error durante el proceso, inténtelo más tarde.', 'warning', 5000);
            })
            .always(function () {
                ocultar_loader();
            });
}
