$(function() {
    if($('#btn_eliminar_ce').length){
        $('#btn_eliminar_ce').on('click', function() {
            data_ajax(site_url+'/convocatoria_evaluacion/gestionar_convocatoria', null, '#modal_content');
        });
    }
    if($('.btn_editar_ce').length){
        $('.btn_editar_ce').on('click', function() {
            data_ajax(site_url+'/convocatoria_evaluacion/gestionar_convocatoria/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }

    if($('#btn_agregar_ce').length){
        $('#btn_agregar_ce').on('click', function() {
            data_ajax(site_url+'/convocatoria_evaluacion/gestionar_convocatoria/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }

    $('.btn_eliminar_ce').on('click', function() {
        var data_value = $(this).attr('data-value');
        apprise(confirmar_eliminacion, {verify: true}, function(btnClick) {
            if (btnClick) {
                $.ajax({
                    url: site_url + '/convocatoria_evaluacion/eliminar_convocatoria/'+data_value,
                    method: 'POST',
                    dataType: "json",
                    beforeSend: function(xhr) {
                        $('#get_data_ajax_actividad').html(create_loader());
                    }
                })
                .done(function(response) {
                    $('#mensaje').html(imprimir_resultado(response));
                    if(response.result==true){
                        $('#tr_'+data_value).slideUp( "slow", function() { //Ocultar fila del registro
                            $('#tr_'+data_value).remove(); //Eliminar fila
                        });
                    }
                })
                .fail(function(jqXHR, response) {
                    $('#mensaje').html(imprimir_resultado(response));
                })
                .always(function() {
                    remove_loader();
                });
            } else {
                return false;
            }
        });
    });



});

function guarda_autoevaluado(i)
    {
        //alert("entra");
        var i;
        var formData = $('#form_curso'+i).serialize();
        //alert(i);

         $.ajax({

            type:'POST',
            data:formData,
            url: site_url + '/curso/guardar_autoevaluacion',

            success: function(data){
                     alert(data);
              },
          });
    }
