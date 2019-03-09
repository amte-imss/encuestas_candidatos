/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var menu_busqueda_filtros = new Object();
menu_busqueda_filtros["clavecurso"] = {text: 'Clave instrumento', btn: 'btn_tipo_buscar_instrumento', hidd: 'menu_instrumento'};
menu_busqueda_filtros["nombrecurso"] = {text: 'Nombre instrumento', btn: 'btn_tipo_buscar_instrumento', hidd: 'menu_instrumento'};
menu_busqueda_filtros["matriculado"] = {text: 'Matricula', btn: 'btn_buscar_docente_evaluado', hidd: 'menu_evaluado'};
menu_busqueda_filtros["namedocentedo"] = {text: 'Nombre docente', btn: 'btn_buscar_docente_evaluado', hidd: 'menu_evaluado'};
menu_busqueda_filtros["matriculador"] = {text: 'Matricula', btn: 'btn_buscar_docente_evaluador', hidd: 'menu_evaluador'};
menu_busqueda_filtros["namedocentedor"] = {text: 'Nombre docente', btn: 'btn_buscar_docente_evaluador', hidd: 'menu_evaluador'};
menu_busqueda_filtros["categoria"] = {text: 'Categoría', btn: 'btn_buscar_categoria', hidd: 'menu_categoria'};
menu_busqueda_filtros["claveadscripcion"] = {text: 'Clave departamental', btn: 'btn_buscar_adscripcion', hidd: 'menu_adscripcion'};
menu_busqueda_filtros["nameadscripcion"] = {text: 'Nombre departamento', btn: 'btn_buscar_adscripcion', hidd: 'menu_adscripcion'};
menu_busqueda_filtros["categoriar"] = {text: 'Categoría', btn: 'btn_buscar_categoriar', hidd: 'menu_categoriar'};


/**
 * 
 * @param {type} name Menu de opciónes de filtro
 * @returns {undefined}
 */
function funcion_menu_tipo_busqueda(name) {
    var objett = menu_busqueda_filtros[name];//Busca en el hashmap el nombre indicado
//    alert(objett.btn);
    $("#" + objett.hidd.toString()).val(name);//Modifica el valor del menu
    $("#" + objett.btn.toString()).text(objett.text);//Cambia el texto del botón
    $("#" + objett.btn.toString()).append('<span class="caret"> </span>');//Agregar span al botón para mostrar icono flechita
//    $("#buscador_docente").attr('data-original-title', 'Buscar por ' + objett.btn);//Cambia el texto del la caja de texto 
    $("#" + objett.btn.toString()).attr('data-original-title', 'Buscar por ' + objett.text);//Cambia el texto del botón
}

function funcion_cargar_bloque(curso) {
    if ($("#div_bloques")) {//Verifica si existe el componente de bloque
//    alert(curso);
        if (curso == 0) {
            $("#div_prima_bloques").empty();
            $("#div_prima_grupos").empty();//Limpia div de grupos 
        } else {
//        alert(curso);
            $.ajax({
                type: "POST",
                url: site_url + "/reporte/buscar_bloques_grupos",
                data: {curso: curso, tipo: 'c'},
//                    dataType: "html",
                beforeSend: function (xhr) {
                    //imagen de carga
                    $("#div_prima_bloques").html(create_loader());
                }
            })
                    .done(function (data) {
                        try {//Cacha el error
                            var resp = $.parseJSON(data);
                            $("#div_prima_bloques").empty();//Limpia div de bloques
                            $("#div_prima_grupos").empty();//Limpia div de grupos 
                            if (resp.empty == 1) {
                                $("#div_prima_bloques").append(resp.html);
                            }
                        } catch (e) {

                        }

                    })
                    .fail(function (jqXHR, response) {

                    })
                    .always(function () {
                        remove_loader();
                    });
        }
    }
}

function funcion_cargar_grupo(element) {
    if ($("#div_grupos")) {//Verifica si existe el componente de bloque
        var data = $(element);
        var curso = data.data('cursoid');//identificador del curso
        var bloque = $('#bloque').val();//Obtiene valor del bloque
        if (bloque === '*') {
            var sel = document.getElementById("bloque");
            var allbloques = new Object();
            for (var i = 0; i < sel.length; i++) {
                //  Aca haces referencia al "option" actual
                var opt = sel[i];
//                alert(parseInt(opt.value));
                if (opt.value.length > 0 && !isNaN(opt.value)) {
                    allbloques[i] = opt.value;
                }
//                alert(opt.value);
            }
            $.ajax({
                type: "POST",
                url: site_url + "/reporte/buscar_bloques_grupos",
                data: {curso: curso, bloque: allbloques, tipo: '*'},
//                    dataType: "html",
                beforeSend: function (xhr) {
                    //imagen de carga
                    $("#div_prima_grupos").html(create_loader());
                }
            })
                    .done(function (data) {
                        try {//Cacha el error
                            var resp = $.parseJSON(data);
                            $("#div_prima_grupos").empty();
                            if (resp.empty == 1) {
                                $("#div_prima_grupos").append(resp.html);
                            }
                        } catch (e) {

                        }

                    })
                    .fail(function (jqXHR, response) {

                    })
                    .always(function () {
                        remove_loader();
                    });


        } else if (bloque.length > 0) {
            $.ajax({
                type: "POST",
                url: site_url + "/reporte/buscar_bloques_grupos",
                data: {curso: curso, bloque: bloque, tipo: 'b'},
//                    dataType: "html",
                beforeSend: function (xhr) {
                    //imagen de carga
                    $("#div_prima_grupos").html(create_loader());
                }
            })
                    .done(function (data) {
                        try {//Cacha el error
                            var resp = $.parseJSON(data);
                            $("#div_prima_grupos").empty();
                            if (resp.empty == 1) {
                                $("#div_prima_grupos").append(resp.html);
                            }
                        } catch (e) {

                        }

                    })
                    .fail(function (jqXHR, response) {

                    })
                    .always(function () {
                        remove_loader();
                    });

        } else {
            $("#div_prima_grupos").empty();

        }
    }
}
