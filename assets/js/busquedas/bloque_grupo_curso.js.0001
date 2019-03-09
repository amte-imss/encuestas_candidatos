/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function funcion_onload_numeric() {
    var numeric = $('#max_bloques').val();
    var patron = /^\d*$/; //Patrón para expresion regular para enteros
    if (numeric.length > 0 && patron.test(numeric)) {//Valida que el texto no sea vacio y que sea numerico
        modifica_ides_tablas('.ddp', numeric, 'Bloque ', 'Seleccione bloque');
    }
}

function guardar_curso_bloque_grupo(element) {
    var formData = $('#form_curso_bloque').serialize();
    //listado_resultado_bloque 
    $.ajax({
        type: "POST",
        url: site_url + "/curso/guardar_curso_bloque_grupos",
        data: formData,
//        method: 'POST',
        beforeSend: function (xhr) {
            //imagen de carga
            $("#listado_resultado_bloque ").html(create_loader());
        }
    })
            .done(function (data) {
                try {//Cacha el error
                    $("#listado_resultado_bloque").empty();
                    var resp = $.parseJSON(data);
                    if (typeof resp.html !== 'undefined') {
                        $("#listado_resultado_bloque").append(resp.html);
                        if (typeof resp.mensaje !== 'undefined') {
                            $('#div_mensaje_texto').removeClass('alert-danger').removeClass('alert-warning').removeClass('alert-info').removeClass('alert-success').addClass('alert-' + resp.tipo_alert);
                            $('#div_mensaje_texto').append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + "<br><span>" + resp.mensaje + "</span>");
                            $('#div_mensaje_visible').show();
                            setTimeout("$('#div_mensaje_visible').hide()", 6000);
                            setTimeout("$('#div_mensaje_texto').html('')", 6000);
                        }
                    }
                } catch (e) {
                    $("#listado_resultado_bloque ").html(data);
                }

            })
            .fail(function (jqXHR, response) {

            })
            .always(function () {
                remove_loader();
            });


}

/**
 * @author LEAS
 * @fecha 10/09/2016
 *  * @param {type} tabla
 * @param {type} check_box_control
 * @returns {undefined}
 */
function modifica_ides_tablas(clase, numeric_max, texto, texto_default) {
    $(clase).each(function (indice, element) {
        var componente = $(element);
        var value = componente.val();
//        alert(value);
        componente.html('');
        for (var x = 0; x <= numeric_max; x++) {
            componente.append($('<option>', {
                value: (x === 0) ? '' : x,
                text: (x === 0) ? texto_default : texto + (x),
//                selected: (x === value) ? 'selected' : 'selected'
            }));
        }
        componente.val(value);//Selecciona la opción seleccionada

    });
}
