var grid;
//var nameGrid;
var grid;
var data_grid;
$(document).ready(function () {
//    $('#exportar_datos').on('click', function () {
//        document.location.href = site_url + '/directorio/exportar_datos/';
//    });
//    grid_reporte_encuestas($('#curso').val());
//    if (document.getElementById("cursos_registro")) {
//        var idCurso = document.getElementById("cursos_registro").value;
//        if (document.getElementById("cursos_registro").value.length > 1) {
//            grid_candidatos(idCurso, 'grid_candidatos');
//        } else {
//            $('#grid_candidatos').html("");
//        }
//    }
});
function grid_candidatos_(curso_id, nameGrid) {
    var name_fields = get_header_candidatos();
    grid = $('#' + nameGrid).jsGrid({
        height: "500px",
        width: "100%",
//        deleteConfirm: "¿Deseas eliminar este registro?",
        filtering: true,
        inserting: false,
        editing: false,
        sorting: false,
        selecting: false,
        paging: true,
        autoload: true,
        pageSize: 10,
        rowClick: function (args) {
            //console.log(args);
        },
        pageButtonCount: 5,
        pagerFormat: "Páginas: {pageIndex} de {pageCount}    {first} {prev} {pages} {next} {last}   Total: {itemCount}",
        pagePrevText: "Anterior",
        pageNextText: "Siguiente",
        pageFirstText: "Primero",
        pageLastText: "Último",
        pageNavigatorNextText: "...",
        pageNavigatorPrevText: "...",
        noDataContent: "No se encontraron datos",
        invalidMessage: "",
        loadMessage: "Por favor espere",
        onItemUpdating: function (args) {
        },
        onItemEditing: function (args) {
        },
        cancelEdit: function () {
        },
        controller: {
            loadData: function (filter) {
                console.log('filter ^^^^^^^^^^^^^^');
                console.log(filter);
                var d = $.Deferred();
                //var result = null;

                $.ajax({
                    type: "GET",
                    url: site_url + "/candidatos/lista_candidatos/" + curso_id,
                    data: filter,
                    dataType: "json"
                })
                        .done(function (result) {
                            console.log('------------------- Result -----------------');
                            console.log(result);
                            var res = $.grep(result.data, function (registro) {
                                return (!filter.matricula || (registro.matricula !== null && registro.matricula.toLowerCase().indexOf(filter.matricula.toString().toLowerCase()) > -1))
                                        && (!filter.nom || (registro.nom !== null && registro.nom.toLowerCase().indexOf(filter.nom.toString().toLowerCase()) > -1))
                                        && (!filter.ap || (registro.ap !== null && registro.ap.toLowerCase().indexOf(filter.ap.toString().toLowerCase()) > -1))
                                        && (!filter.am || (registro.am !== null && registro.am.toLowerCase().indexOf(filter.am.toString().toLowerCase()) > -1))
                                        && (!filter.curp || (registro.curp !== null && registro.curp.toLowerCase().indexOf(filter.curp.toString().toLowerCase()) > -1))
                                        && (!filter.email_principal || (registro.email_principal !== null && registro.email_principal.toLowerCase().indexOf(filter.email_principal.toString().toLowerCase()) > -1))
                                        && (!filter.emal_otro || (registro.emal_otro !== null && registro.emal_otro.toLowerCase().indexOf(filter.emal_otro.toString().toLowerCase()) > -1))
                                        && (!filter.cve_categoria || (registro.cve_categoria !== null && registro.cve_categoria.toLowerCase().indexOf(filter.cve_categoria.toString().toLowerCase()) > -1))
                                        && (!filter.categoria || (registro.categoria !== null && registro.categoria.toLowerCase().indexOf(filter.categoria.toString().toLowerCase()) > -1))
                                        && (!filter.cve_departamental || (registro.cve_departamental !== null && registro.cve_departamental.toLowerCase().indexOf(filter.cve_departamental.toString().toLowerCase()) > -1))
                                        && (!filter.departamental || (registro.departamental !== null && registro.departamental.toLowerCase().indexOf(filter.departamental.toString().toLowerCase()) > -1))
//                                        && (!filter.cve_delegacion || (registro.cve_delegacion != null && registro.cve_delegacion == filter.cve_delegacion))
                                        ;
                            });
//                            d.resolve(result['data']);
                            d.resolve(res);
//                            calcula_ancho_grid('jsReporteEncuestas', 'jsgrid-header-cell');
//                            console.log('------------------- Result -----------------');
                        }).fail(function (){
                            console.log('FaaaaaaaaaaaaalllllllllllllllllaaaaaaaaaaaaaaaLEAS');
                        });
                return d.promise();
            },
            updateItem: function (item) {
            }
        },
        fields: [
            {type: "control", editButton: false, deleteButton: false,
                searchModeButtonTooltip: "Cambiar a modo búsqueda", // tooltip of switching filtering/inserting button in inserting mode
                editButtonTooltip: "Editar", // tooltip of edit item button
                searchButtonTooltip: "Buscar", // tooltip of search button
                clearFilterButtonTooltip: "Limpiar filtros de búsqueda", // tooltip of clear filter button
                updateButtonTooltip: "Actualizar", // tooltip of update item button
                cancelEditButtonTooltip: "Cancelar", // tooltip of cancel editing button
            },
            {name: "valido", title: name_fields.valido, type: "checkbox", inserting: true, editing: true},
            {name: "cve_tipo_carga_candidatos", title: name_fields.cve_tipo_carga_candidatos, type: "select", items: cat_tipo_cargas, valueField: "cve_tipo_carga_candidatos", textField: "descripcion", inserting: true, editing: true},
            {name: "cve_delegacion", title: name_fields.cve_delegacion, type: "select", items: cat_delegacioes, valueField: "cve_delegacion", textField: "nom_delegacion", inserting: true, editing: true},
            {name: "matricula", title: name_fields.matricula, type: "text", inserting: true, editing: true},
            {name: "nom", title: name_fields.nom, type: "text", inserting: true, editing: true},
            {name: "ap", title: name_fields.ap, type: "text", inserting: true, editing: true},
            {name: "am", title: name_fields.am, type: "text", inserting: true, editing: true},
            {name: "curp", title: name_fields.curp, type: "text", inserting: true, editing: true, width: 180},
            {name: "email_principal", title: name_fields.email_principal, type: "text", inserting: true, editing: true, width: 250},
            {name: "emal_otro", title: name_fields.emal_otro, type: "text", inserting: false, editing: false, width: 250},
            {name: "cve_categoria", title: name_fields.cve_categoria, type: "text", inserting: true, editing: true},
            {name: "categoria", title: name_fields.categoria, type: "text", inserting: true, editing: true, width: 200},
            {name: "cve_departamental", title: name_fields.cve_departamental, type: "text", inserting: true, editing: true},
            {name: "departamental", title: name_fields.departamental, type: "text", inserting: true, editing: true, width: 200},
        ]
    });
}
function grid_candidatos(curso_id, nameGrid) {

    var name_fields = get_header_candidatos();
    console.log(name_fields);
    console.log(nameGrid);
//    console.log(cat_delegacioes);
//    console.log(cat_tipo_cargas);
//    grid = $('#' + nameGrid).html("SAludossssssssssssssssssssssssssssssss");
    grid = $('#' + nameGrid).jsGrid({
        height: "500px",
        width: "100%",
//        deleteConfirm: "¿Deseas eliminar este registro?",
        filtering: true,
        inserting: true,
        editing: true,
        sorting: true,
        selecting: true,
        paging: true,
        autoload: true,
        pageSize: 5,
        rowClick: function (args) {
            //console.log(args);
        },
        pageButtonCount: 5,
        pagerFormat: "Páginas: {pageIndex} de {pageCount}    {first} {prev} {pages} {next} {last}   Total: {itemCount}",
        pagePrevText: "Anterior",
        pageNextText: "Siguiente",
        pageFirstText: "Primero",
        pageLastText: "Último",
        pageNavigatorNextText: "...",
        pageNavigatorPrevText: "...",
        noDataContent: "No se encontraron datos",
        invalidMessage: "",
        loadMessage: "Por favor espere",
        onItemUpdating: function (args) {
        },
        insertItem: function (item) {
            var deferred = $.Deferred();
            var result = $.ajax({
                type: "POST",
                url: site_url + "/candidatos/insertar/",
                data: item
            }).done(function (resp) {
                console.log(resp);
                deferred.resolve(resp.data)
            });
            return deferred.promise();
        },
        onItemEditing: function (args) {
        },
        onItemDeleted: function (arg) {//Antes de la ejecucion
            console.log("onItemDeleted");
            console.log(arg);
            arg.cancel = true;
        },
        cancelEdit: function () {
        },
        controller: {
            loadData: function (filter) {
                console.log('filter ^^^^^^^^^^^^^^');
                console.log(filter);
                var d = $.Deferred();
                //var result = null;

                $.ajax({
                    type: "GET",
                    url: site_url + "/candidatos/lista_candidatos/" + curso_id,
                    data: filter,
                    dataType: "json"
                })
                        .done(function (result) {
                            console.log('------------------- Result -----------------');
                            console.log(result);
                            var res = $.grep(result.data, function (registro) {
//                                return true;
                                return (!filter.matricula || (registro.matricula !== null && registro.matricula.toLowerCase().indexOf(filter.matricula.toString().toLowerCase()) > -1))
                                        && (!filter.nom || (registro.nom !== null && registro.nom.toLowerCase().indexOf(filter.nom.toString().toLowerCase()) > -1))
                                        && (!filter.ap || (registro.ap !== null && registro.ap.toLowerCase().indexOf(filter.ap.toString().toLowerCase()) > -1))
                                        && (!filter.am || (registro.am !== null && registro.am.toLowerCase().indexOf(filter.am.toString().toLowerCase()) > -1))
                                        && (!filter.curp || (registro.curp !== null && registro.curp.toLowerCase().indexOf(filter.curp.toString().toLowerCase()) > -1))
                                        && (!filter.email_principal || (registro.email_principal !== null && registro.email_principal.toLowerCase().indexOf(filter.email_principal.toString().toLowerCase()) > -1))
                                        && (!filter.emal_otro || (registro.emal_otro !== null && registro.emal_otro.toLowerCase().indexOf(filter.emal_otro.toString().toLowerCase()) > -1))
                                        && (!filter.cve_categoria || (registro.cve_categoria !== null && registro.cve_categoria.toLowerCase().indexOf(filter.cve_categoria.toString().toLowerCase()) > -1))
                                        && (!filter.categoria || (registro.categoria !== null && registro.categoria.toLowerCase().indexOf(filter.categoria.toString().toLowerCase()) > -1))
                                        && (!filter.cve_departamental || (registro.cve_departamental !== null && registro.cve_departamental.toLowerCase().indexOf(filter.cve_departamental.toString().toLowerCase()) > -1))
                                        && (!filter.departamental || (registro.departamental !== null && registro.departamental.toLowerCase().indexOf(filter.departamental.toString().toLowerCase()) > -1))
//                                        && (!filter.cve_delegacion || (registro.cve_delegacion != null && registro.cve_delegacion == filter.cve_delegacion))
                                        ;
                            });
//                            d.resolve(result['data']);
                            d.resolve(res);
//                            calcula_ancho_grid('jsReporteEncuestas', 'jsgrid-header-cell');
                        });
                return d.promise();
            },
            updateItem: function (item) {
            }
        },
        fields: [
            {type: "control", editButton: true, deleteButton: true,
                searchModeButtonTooltip: "Cambiar a modo búsqueda", // tooltip of switching filtering/inserting button in inserting mode
                editButtonTooltip: "Editar", // tooltip of edit item button
                searchButtonTooltip: "Buscar", // tooltip of search button
                clearFilterButtonTooltip: "Limpiar filtros de búsqueda", // tooltip of clear filter button
                updateButtonTooltip: "Actualizar", // tooltip of update item button
                cancelEditButtonTooltip: "Cancelar", // tooltip of cancel editing button
            },
            {name: "valido", title: name_fields.valido, type: "checkbox", inserting: true, editing: true},
            {name: "cve_tipo_carga_candidatos", title: name_fields.cve_tipo_carga_candidatos, type: "select", items: cat_tipo_cargas, valueField: "cve_tipo_carga_candidatos", textField: "descripcion", inserting: true, editing: true},
            {name: "cve_delegacion", title: name_fields.cve_delegacion, type: "select", items: cat_delegacioes, valueField: "cve_delegacion", textField: "nom_delegacion", inserting: true, editing: true},
            {name: "matricula", title: name_fields.matricula, type: "text", inserting: true, editing: true},
            {name: "nom", title: name_fields.nom, type: "text", inserting: true, editing: true},
            {name: "ap", title: name_fields.ap, type: "text", inserting: true, editing: true},
            {name: "am", title: name_fields.am, type: "text", inserting: true, editing: true},
            {name: "curp", title: name_fields.curp, type: "text", inserting: true, editing: true, width: 180},
            {name: "email_principal", title: name_fields.email_principal, type: "text", inserting: true, editing: true, width: 200},
            {name: "emal_otro", title: name_fields.emal_otro, type: "text", inserting: false, editing: false, width: 200},
            {name: "cve_categoria", title: name_fields.cve_categoria, type: "text", inserting: true, editing: true},
            {name: "categoria", title: name_fields.categoria, type: "text", inserting: true, editing: true, width: 200},
            {name: "cve_departamental", title: name_fields.cve_departamental, type: "text", inserting: true, editing: true},
            {name: "departamental", title: name_fields.departamental, type: "text", inserting: true, editing: true, width: 200},
            {name: "valido", title: name_fields.valido, type: "checkbox", inserting: true, editing: true},
            {name: "cve_tipo_carga_candidatos", title: name_fields.cve_tipo_carga_candidatos, type: "select", items: cat_tipo_cargas, valueField: "cve_tipo_carga_candidatos", textField: "descripcion", inserting: true, editing: true},
            {name: "cve_delegacion", title: name_fields.cve_delegacion, type: "select", items: cat_delegacioes, valueField: "cve_delegacion", textField: "nom_delegacion", inserting: true, editing: true},
            {name: "matricula", title: name_fields.matricula, type: "text", inserting: true, editing: true},
            {name: "nom", title: name_fields.nom, type: "text", inserting: true, editing: true},
            {name: "ap", title: name_fields.ap, type: "text", inserting: true, editing: true},
            {name: "am", title: name_fields.am, type: "text", inserting: true, editing: true},
            {name: "curp", title: name_fields.curp, type: "text", inserting: true, editing: true, width: 180},
            {name: "email_principal", title: name_fields.email_principal, type: "text", inserting: true, editing: true, width: 200},
            {name: "emal_otro", title: name_fields.emal_otro, type: "text", inserting: false, editing: false, width: 200},
            {name: "cve_categoria", title: name_fields.cve_categoria, type: "text", inserting: true, editing: true},
            {name: "categoria", title: name_fields.categoria, type: "text", inserting: true, editing: true, width: 200},
            {name: "cve_departamental", title: name_fields.cve_departamental, type: "text", inserting: true, editing: true},
            {name: "departamental", title: name_fields.departamental, type: "text", inserting: true, editing: true, width: 200},
        ]
    });
    $("#" + nameGrid).jsGrid("option", "filtering", false);
}

var XLSX;
function export_xlsx_grid(elemento) {
//    var data = $('#jsReporteEncuestas').data('JSGrid').data;
    var namegrid = $(elemento).data('namegrid');
//    console.log(namegrid);
    var data = $('#' + namegrid).data('JSGrid').data;
    var clavecurso = $(elemento).data('clavecurso');
    var cabeceras = '';
    if (namegrid == "jsReporteEncuestas") {
        cabeceras = get_header_candidatos();
    } else {
        cabeceras = obtener_cabeceras_encuestas_hechos();
    }
//    console.log(cabeceras);
//    var expresion = /(\w+)\-(\w+)/;
//    var nuevaCadena = cadena.replace(expresion, "$1_$2_");
    var nuevaCadena = clavecurso.toString().replace(/-/g, "_");
    var nombre_file = 'reporte_encuestas_' + nuevaCadena + '.xlsx';
//     var nombre_file = 'hola';
//    console.log(nombre_file);
    export_xlsx(data, cabeceras, nombre_file, 'Reporte');
}

function export_xlsx(data, cabeceras, nombre_file, nombre_libro_excel) {
    var auxdata = prep_objetc(data, cabeceras);
//    console.log(auxdata);
    var new_ws = XLSX.utils.aoa_to_sheet(auxdata);
    /* build workbook */
    var new_wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(new_wb, new_ws, nombre_libro_excel);
    /* write file and trigger a download */
    var wbout = XLSX.write(new_wb, {bookType: 'xlsx', bookSST: true, type: 'binary'});
    var fname = nombre_file;
    try {
        saveAs(new Blob([s2ab(wbout)], {type: "application/octet-stream"}), fname);
    } catch (e) {
        if (typeof console != 'undefined')
            console.log(e, wbout);
    }
}

function prep_objetc(arr) {
    var out = [];
    var init = 0;
    var valor;
    var cabeceras = null;
    if (arguments.length === 2) {//Prepara los datos extra que se enviarán por post
        cabeceras = arguments[1];
        var aux_cabeceras = [];
        Object.keys(cabeceras).forEach(function (c, index) {
            aux_cabeceras[index] = cabeceras[c];
        });
        out[init] = aux_cabeceras;
        init++;
    }
//    console.log(arr[6]);
    for (var i = 0; i < arr.length; ++i) {
        if (!arr[i])
            continue;
        valor = arr[i];
        if (typeof valor === 'object') {
            var auxarr = [];
            Object.keys(cabeceras).forEach(function (c, index) {
                auxarr[index] = valor[c];
            });
//            console.log(auxarr);
            out[(i + init)] = auxarr;
//            console.log(auxarr);
            continue;
        }
    }
//    console.log(out);
    return out;
}

function prep(arr) {
    var out = [];
    var valor;
    var cabeceras = null;
    if (arguments.length === 2) {//Prepara los datos extra que se enviarán por post
        cabeceras = arguments[1];
    }
//    console.log(arr[6]);
    for (var i = 0; i < arr.length; ++i) {
        if (!arr[i])
            continue;
//        if (Array.isArray(arr[i])) {
        valor = arr[i];
        if (Array.isArray(valor)) {
//            console.log(arr[i]);
            out[i] = valor;
            continue;
        }

        var o = new Array();
        Object.keys(arr[i]).forEach(function (k) {
            o[ +k] = arr[i][k]
        });
        out[i] = o;
    }
//    console.log(out);

    return out;
}

function s2ab(s) {
    var b = new ArrayBuffer(s.length), v = new Uint8Array(b);
    for (var i = 0; i != s.length; ++i)
        v[i] = s.charCodeAt(i) & 0xFF;
    return b;
}

function obtener_cabeceras_encuestas_hechos() {
    var arr_header = {
        matricula_evaluador: 'Matrícula',
        total_encuestas: 'Total de encuestas',
        encuestas_contestadas: 'Encuestas contestadas',
        nombre_evaluador: 'Nombre del evaluador',
        clave_categoria_evaluador_tutor: 'Clave de categoría del evaluador',
        nombre_categoria_evaluado_tutor: 'Categoría del evaluador',
        clave_adscripcion_tutor_evaluador: 'Clave adscripción del evaluador',
        nombre_adscripcion_tutor_evaluador: 'Adscripción del evaluador',
        delegacion_tutor_evaluador: 'Delegación del evaluador',
        region_tutor_evaluador_dor: 'Región del evaluador',
        contestada: 'Encuesta completas e incompletas',
        email_tutor_evaluador: 'Correo electrónico',
    }
    return arr_header;
}
function get_header_candidatos() {
    var arr_header = {
        cve_tipo_carga_candidatos: "Tipo de carga",
        cve_delegacion: "Delegación",
        matricula: "Matrícula",
        nom: "Nombre",
        ap: "Apellido paterno",
        am: "Apellido materno",
        curp: "Curp",
        email_principal: "Correo electrónico",
        emal_otro: "Correo electrónico alternativo",
        cve_categoria: "Clave categoría",
        categoria: "Categoría",
        cve_departamental: "Clave departamental",
        departamental: "Departamento",
        valido: "Valido",
    }

    return arr_header;
}


/**
 * @fecga 10/11/2017
 * @param {type} padre
 * @param {type} classe
 * @param {type} itemsCount
 * @returns cálcula y modifica tamaño de scroll no exixten registros en el jsgrid
 */
function calcula_ancho_grid(padre, classe) {

    var d = $('#' + padre).data("JSGrid");
    var itemsCount = d.data.length; //Obtiene el tamaño de los datos
//    console.log(d.height);
//    console.log(d);
//    console.log(itemsCount);
    if (itemsCount < 1) {
        var ancho = 0;
        $('#' + padre + ' .' + classe).each(function (index, value) {
            ancho += parseInt(value.style.width.split('px')[0]);
        });
        $('#' + padre + ' .jsgrid-cell').css('width', ancho);
        $('#' + padre + ' .jsgrid-grid-body').css('height', '100');
//        whidth: ancho + 'px'
    } else {//regresa a su estado por default el ancho del body
//        $('#' + padre + ' .jsgrid-grid-body').css('height', d.height.split('px')[0]);//Asigana el valor por default de las propieddes del grid indicado

    }


}

function update_reporte_indicador(data) {
    data.total_general;
    data.contestadas_general;
    data.no_contestadas_general;
    $('.pinta_resumen').html(
            "<center>" +
            '<div class="col-sm-4"><strong>Número de encuestas asignadas</strong><br><div id="div_total_encuestas">' + data.total_general + '</div></div>' +
            '<div class="col-sm-4"><strong>Número de encuestas contestadas</strong><br><div id="div_encuestas_contestadas">' + data.contestadas_general + '</div></div>' +
            '<div class="col-sm-4"><strong>Número de encuestas no contestadas</strong><br><div id="div_encuestas_no_contestadas">' + data.no_contestadas_general + '</div></div>' +
            " </center>"
            );
//    console.log(obj);
}