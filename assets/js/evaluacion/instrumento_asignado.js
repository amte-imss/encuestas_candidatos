$(document).ready(function ()
{
    $('.only_one_answer_text').click(function(){
       console.log('click');
       var tmp_id = this.id.replace("_text", "") + "_radio";
       console.log(tmp_id);
       document.getElementById(tmp_id).checked = false;
    });
    $('.only_one_answer_radio').click(function(){
       console.log('click');
       var tmp_id = this.id.replace("_radio", "") + "_text";
       console.log(tmp_id);
       document.getElementById(tmp_id).disabled = true;
       $('#'+tmp_id.replace("_text", "_link")).css('display', 'block');
    });

    $('#form_encuesta_usuario').submit(function(event) {
        event.preventDefault();
        var destino = site_url + '/evaluacion/guardar_encuesta_usuario';
        var datos_form =  $(this).serializeArray();
        console.log(datos_form);
        mostrar_loader();
        $('.mensaje_pregunta').html('');
        data_ajax(destino, datos_form, null, callback_encuestas);
    });
});

function activar_campo_texto(campo){
    document.getElementById(campo).disabled = false;
    var tmp_id = campo.replace("_text", "") + "_radio";
    console.log(tmp_id);
    document.getElementById(tmp_id).checked = false;
    $('#'+tmp_id.replace("_radio", "_link")).css('display', 'none');
}

function callback_encuestas(response){
    ocultar_loader();
    response = JSON.parse(response);
    if(response.salida.status){
        console.log('OK');
        console.log(response.html);
        $('#area_encuesta').html(response.html);
    }else{
        response = response.salida;
        var errores = [];
        for(i=0;i<response.errores.length;i++){
            errores.push(response.errores[i].orden.toString().replace('pregunta', ''));
            $('#error_' + response.errores[i].id).html(response.errores[i].texto);
        }
        errores = errores.join(', ');
        $('.errores_generales').html('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Es necesario responder las preguntas: '+errores+'</div>');
    }
}
