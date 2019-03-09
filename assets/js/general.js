$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip(); //Llamada a tooltip
});

/**
 *	Método que muestra una imagen (gif animado) que indica que algo esta cargando
 *	@return	string	Contenedor e imagen del cargador.
*/
function create_loader(){
	return '<div id="ajax_loader" align="center" style="padding-top:200px; padding-bottom:200px;"><img src="'+img_url_loader+'" alt="Cargando..." title="Cargando..." /></div>';
}

/**
 *	Método que remueve el contenedor e imagen de cargando
*/
function remove_loader(){
	$("#ajax_loader").remove();
}

function mostrar_loader() {
    $('#overlay').fadeIn('slow', function() {

    });
}

function ocultar_loader() {
    $('#overlay').fadeOut('slow', function() {

    });
}

/**	Método que muestra un mensaje con formato de alertas de boostrap
 * @param	string	message 	Mensaje que será mostrado
 * @param 	string 	tipo 		Posibles valores('success','info','warning','danger')
*/
function html_message(message, tipo){
	tipo = (typeof(tipo) === "undefined") ? 'danger' : tipo;
	return "<div class='alert alert-"+tipo+"' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+message+"</div>";
}


/*
 * @author  ???
 * @modified_by DPérez
 * @param url para conexión ajax
 * @param id html del formulario donde se obtienen los datos a enviar en ajax u objeto a mandar directo.
 * @param id html del elemento que contendrá los datos del resultado
 * @param función que se ejecutará cuando el ajax es correcto y se tienen datos
 * @returns none
 */
function data_ajax(path, recurso, elemento_resultado, callback) {
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
            $(elemento_resultado).html(response).promise().done(callback(response));
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

}
/*
 *       Función que inicializa dataTables después de una petición ajax
 * Se mandan a la función data_ajax en 4° parametro para ejecutar la función de inicio de dataTables.
 *
 * @param   id html de la tabla que aplicará DataTables
 * @returns function callback
 */
function callbackIniDataTables(idTabla, configTable){
    if(typeof configTable === 'undefined'){
        configTable = {
                "info": false
                , "searching": false
                , "lengthChange": false
                , "scrollX": true
                , "language": {
                    "lengthMenu": "Número de registros a mostrar _MENU_ ",
                    "zeroRecords": "No se encontraron registros..",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ ",
                    "infoEmpty": "No se encontraron registros",
                    "loadingRecords": "Cargando...",
                    "processing":     "Procesando datos...",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Último",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    }
                }
            }
    }
    return function(){
        configTable.language = {
            "lengthMenu": "Número de registros a mostrar _MENU_ ",
            "zeroRecords": "No se encontraron registros..",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ ",
            "infoEmpty": "No se encontraron registros",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando datos...",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            }
        }
        configTable.dom = "<lip<t>ip>";
        $(idTabla).DataTable( configTable );
    }

}

/**
 *	Método que válida con javascript la extensión del archivo que se desea subir
 *	@param 	string	fileName 	Nombre del archivo
 *	@param	array	extension 	Arreglo de extensiones permitidas
 *	@return	boolean				true en caso de que la extensión del archivo se encuentre dentro de las permitidas
*/
function validate_extension(fileName, extension){
    var file_extension = fileName.split('.').pop(); // split function will split the filename by dot(.), and pop function will pop the last element from the array which will give you the extension as well. If there will be no extension then it will return the filename.

    for(var i = 0; i <= extension.length; i++) {
        if(extension[i]==file_extension) {
            return true; // valid file extension
        }
    }

    return false;
}

/**
 *	Método que crea un modal que muestra un mensaje
 *	@attribute 	title 			Título que se le colocará al modal
 *	@attribute 	mensaje			Mensaje que mostrará
 *	@return	false
*/
function mensaje_modal(mensaje, title){
	if($('#dataMessageModal').length>0) {
		$('#dataMessageModal').remove();
	}
	var html = "<div class='modal fade' id='dataMessageModal' role='dialog' aria-labelledby='dataConfirmLabel'>"+
			"<div class='modal-dialog'>"+
				"<div class='modal-content'>"+
					"<div class='modal-header'>"+
						"<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>"+
						"<h4 class='modal-title'>"+title+"</h4>"+
					"</div>"+
					"<div class='modal-body'>"+
						"<p>"+mensaje+"</p>"+
					"</div>"+
					"<div class='modal-footer'>"+
						"<button type='button' class='btn btn-default' aria-hidden='true' data-dismiss='modal'>Aceptar</button>"+
					"</div>"+
				"</div>"+
			"</div>"+
		"</div>";
	$('body').append(html);
	$('#dataMessageModal').modal({show:true});

	return false;
}

function dropdown(id,tag,act){
	var val = $(id).val();
	// alert(val);
	$.ajax({
		url: site_url+act,
		data: {'campo':val},
		method: 'POST',
		dataType: 'JSON',
		beforeSend: function( xhr ) {
			$(tag).html(create_loader());
		}

	})
	.done(function(response) {
		// alert(response.resultado);
		if(response.resultado==true){
			$(tag).html(response.data);
			$('[data-toggle="tooltip"]').tooltip();
		} else {
			$(tag).html(html_message(response.error, 'danger'));
		}
	})
	.fail(function( jqXHR, textStatus ) {
		// alert(textStatus)
		$(tag).html(html_message("Ocurri&oacute; un error durante el proceso, inténtelo m&aacute;s tarde.", 'danger'));//+textStatus
	})
	.always(function() {
		remove_loader();
	});
}

/**
 *
 * @param {type} path
 * @param {type} form_recurso - Formulario que se va a enviar
 * @param {type} elemento_resultado Div o elemento donde se mostrará el resultado
 * param {type objete} Despúes del elemento resuiltado, se enviarán todos los elementos
 * por post simple que se requieran enviar ejem. {key : value, key_2 : value_2,...,key_n : value_n}
 *
 * @returns {JSON} Si el return del response del servidor es un, regresa JSON, si no, regresa vacio
 */
function data_ajax_post(path, form_recurso, elemento_resultado) {
//    var result = 0;
    var formData = '';
    if (form_recurso !== null) {//Prepara los datos del formulario
        formData = $(form_recurso).serialize();
    }
    if (arguments.length === 4) {//Prepara los datos extra que se enviarán por post
        var obj_data_extra = arguments[3];
        for (var key_extras in arguments[3]) {
            formData += '&' + key_extras + '=' + obj_data_extra[key_extras];
        }
    }

    $.ajax({
        url: path,
        data: formData,
        method: 'POST',
        beforeSend: function (xhr) {
            $(elemento_resultado).html(create_loader());
        }
    })
            .done(function (response) {
//                     result = 1;
                try {
                    var json = $.parseJSON(response);
                } catch (e) {
                    $(elemento_resultado).html(response);
                }
            })
            .fail(function (jqXHR, textStatus) {
                $(elemento_resultado).html("Ocurrió un error durante el proceso, inténtelo más tarde.");
            })
            .always(function () {
                remove_loader();
            });
}
