var grid;
var data_grid;
$(document).ready(function () {
//    $('#exportar_datos').on('click', function () {
//        document.location.href = site_url + '/directorio/exportar_datos/';
//    });
//    grid_reporte_encuestas($('#curso').val());
    if (document.getElementById("cantidad_registros")) {
        $('#cantidad_registros').on('change', function () {
            console.log(this.value);
            var page = parseInt(this.value, 10);
            $("#jsReporteEncuestas").jsGrid("pageSize", page);
        });
    }
    $('#divReporteEncuestas').hide();
    $('#divReporteHechos').hide();
    if ($('#tipo_reporte').length > 0) { //En caso de existir elemento
        $('#tipo_reporte').on('change', function () {
            //console.log(this.value);
            if (this.value == 1) {
                $('#divReporteHechos').fadeIn();
                $('#divReporteEncuestas').hide();
                grid_reporte_hechos($('#curso').val());
            } else if (this.value == 2) {
                $('#divReporteHechos').hide();
                $('#divReporteEncuestas').fadeIn();
                grid_reporte_encuestas($('#curso').val())
            } else {
                $('#divReporteEncuestas').hide();
                $('#divReporteHechos').hide();
            }
        });
    }
});

function formato_fecha(fecha) {
    var fechaTmp = new Date(fecha);
//    var options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: "numeric", minute: "numeric"};
    var options = {day: 'numeric', month: 'numeric', year: 'numeric', hour: "numeric", minute: "numeric"};
//    return  fechaTmp.toLocaleDateString("es-ES", options);
    return  fechaTmp.toLocaleTimeString("es-ES", options);
}

function grid_reporte_encuestas(curso) {
    var name_fields = obtener_cabeceras_encuestas();
    grid = $('#jsReporteEncuestas').jsGrid({
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
        onItemEditing: function (args) {
        },
        cancelEdit: function () {
        },
        controller: {
            loadData: function (filter) {
                //console.log(filter);
                var d = $.Deferred();
                //var result = null;

                $.ajax({
                    type: "GET",
                    url: site_url + "/resultadocursoencuesta/get_registros_encuestas_curso/" + curso,
                    data: filter,
                    dataType: "json"
                })
                        .done(function (result) {

                            var res = $.grep(result.data, function (registro) {
                                console.log(registro.calificacion);
                                if (registro.contestada == 2 && (registro.calificacion != null && registro.calificacion.toString().length > 0)) {
                                    var evtmp = registro.calificacion.split(",", 3);
                                    if (evtmp.length > 2) {//Es un array con la informacion de calificacion para bono 
                                        registro.calificacion_bono = evtmp[1];
                                        registro.fecha_evaluacion = formato_fecha(evtmp[2]);
                                        registro.calificacion = evtmp[0];
                                    }
//                                    console.log(evtmp);
//                                console.log(registro.calificacion.toString().length);
                                    registro.contestada = 1;
                                } else if (registro.contestada == 1 && (registro.calificacion != null && registro.calificacion.toString().length > 0)) {
                                    registro.fecha_evaluacion = formato_fecha(registro.fecha_evaluacion);
                                } else if (registro.contestada == 2) {
                                    registro.calificacion = null;
                                }
//                                    console.log(registro.rol_evaluador_id);
                                if (registro.rol_evaluador_id == '5') {//Asigna los datos imss de alumno a tutores
                                    registro.clave_categoria_evaluador_tutor = registro.clave_categoria_evaluador_preg;
                                    registro.nombre_categoria_evaluado_tutor = registro.nombre_categoria_evaluado_preg;
                                    registro.clave_adscripcion_tutor_evaluador = registro.clave_adscripcion_preg_evaluador;
                                    registro.nombre_adscripcion_tutor_evaluador = registro.nombre_adscripcion_preg_evaluador;
                                    registro.delegacion_tutor_evaluador = registro.delegacion_preg_evaluador;
                                    registro.region_tutor_evaluador_dor = registro.region_preg_evaluador;
                                }
//                                if(registro.matricula_evaluador === "10004696"){
//                                    console.log(registro);
//                                }

                                return (!filter.contestada || (registro.contestada != null && (registro.contestada == filter.contestada)))
                                        && (!filter.encuesta_valida || (registro.encuesta_valida != null && (registro.encuesta_valida == filter.encuesta_valida)))    
                                        && (!filter.descripcion_encuestas || (registro.descripcion_encuestas !== null && registro.descripcion_encuestas.toLowerCase().indexOf(filter.descripcion_encuestas.toString().toLowerCase()) > -1))
                                        && (!filter.rol_evaluador || (registro.rol_evaluador !== null && registro.rol_evaluador.toLowerCase().indexOf(filter.rol_evaluador.toString().toLowerCase()) > -1))
                                        && (!filter.matricula_evaluador || (registro.matricula_evaluador !== null && registro.matricula_evaluador.toLowerCase().indexOf(filter.matricula_evaluador.toString().toLowerCase()) > -1))
                                        && (!filter.nombre_evaluador || (registro.nombre_evaluador !== null && registro.nombre_evaluador.toLowerCase().indexOf(filter.nombre_evaluador.toString().toLowerCase()) > -1))
                                        //evaluado imss
                                        && (!filter.clave_categoria_evaluado || (registro.clave_categoria_evaluado !== null && registro.clave_categoria_evaluado.toLowerCase().indexOf(filter.clave_categoria_evaluado.toString().toLowerCase()) > -1))
                                        && (!filter.nombre_categoria_evaluado || (registro.nombre_categoria_evaluado !== null && registro.nombre_categoria_evaluado.toLowerCase().indexOf(filter.nombre_categoria_evaluado.toString().toLowerCase()) > -1))
                                        && (!filter.clave_adscripcion_evaluado || (registro.clave_adscripcion_evaluado !== null && registro.clave_adscripcion_evaluado.toLowerCase().indexOf(filter.clave_adscripcion_evaluado.toString().toLowerCase()) > -1))
                                        && (!filter.nombre_adscripcion_evaluado || (registro.nombre_adscripcion_evaluado !== null && registro.nombre_adscripcion_evaluado.toLowerCase().indexOf(filter.nombre_adscripcion_evaluado.toString().toLowerCase()) > -1))
                                        && (!filter.delegacion_evaluado || (registro.delegacion_evaluado !== null && registro.delegacion_evaluado.toLowerCase().indexOf(filter.delegacion_evaluado.toString().toLowerCase()) > -1))
                                        && (!filter.region_evaluado || (registro.region_evaluado !== null && registro.region_evaluado.toLowerCase().indexOf(filter.region_evaluado.toString().toLowerCase()) > -1))
                                        //evaluador imss
                                        && (!filter.clave_categoria_evaluador_tutor || (registro.clave_categoria_evaluador_tutor !== null && registro.clave_categoria_evaluador_tutor.toLowerCase().indexOf(filter.clave_categoria_evaluador_tutor.toString().toLowerCase()) > -1))
                                        && (!filter.nombre_categoria_evaluado_tutor || (registro.nombre_categoria_evaluado_tutor !== null && registro.nombre_categoria_evaluado_tutor.toLowerCase().indexOf(filter.nombre_categoria_evaluado_tutor.toString().toLowerCase()) > -1))
                                        && (!filter.clave_adscripcion_tutor_evaluador || (registro.clave_adscripcion_tutor_evaluador !== null && registro.clave_adscripcion_tutor_evaluador.toLowerCase().indexOf(filter.clave_adscripcion_tutor_evaluador.toString().toLowerCase()) > -1))
                                        && (!filter.nombre_adscripcion_tutor_evaluador || (registro.nombre_adscripcion_tutor_evaluador !== null && registro.nombre_adscripcion_tutor_evaluador.toLowerCase().indexOf(filter.nombre_adscripcion_tutor_evaluador.toString().toLowerCase()) > -1))
                                        && (!filter.delegacion_tutor_evaluador || (registro.delegacion_tutor_evaluador !== null && registro.delegacion_tutor_evaluador.toLowerCase().indexOf(filter.delegacion_tutor_evaluador.toString().toLowerCase()) > -1))
                                        && (!filter.region_tutor_evaluador_dor || (registro.region_tutor_evaluador_dor !== null && registro.region_tutor_evaluador_dor.toLowerCase().indexOf(filter.region_tutor_evaluador_dor.toString().toLowerCase()) > -1))
                                        && (!filter.rol_evaluando || (registro.rol_evaluando !== null && registro.rol_evaluando.toLowerCase().indexOf(filter.rol_evaluando.toString().toLowerCase()) > -1))
                                        && (!filter.matricula_evaluado || (registro.matricula_evaluado !== null && registro.matricula_evaluado.toLowerCase().indexOf(filter.matricula_evaluado.toString().toLowerCase()) > -1))
                                        && (!filter.nombre_evaluado || (registro.nombre_evaluado !== null && registro.nombre_evaluado.toLowerCase().indexOf(filter.nombre_evaluado.toString().toLowerCase()) > -1))
                                        && (!filter.calif_emitida_napb || (registro.calif_emitida_napb !== null && registro.calif_emitida_napb.indexOf(filter.nombre_evaluado.toString()) > -1))
                                        && (!filter.calif_emitida || (registro.calif_emitida !== null && registro.calif_emitida.indexOf(filter.calif_emitida.toString()) > -1))
                                        && (!filter.fecha_evaluacion || (registro.fecha_evaluacion !== null && registro.fecha_evaluacion.indexOf(filter.fecha_evaluacion.toString()) > -1))
                                        ;
                            });
//                            d.resolve(result['data']);
                            d.resolve(res);
                            calcula_ancho_grid('jsReporteEncuestas', 'jsgrid-header-cell');
                        });

                return d.promise();
            },
            updateItem: function (item) {
            }
        },
        fields: [
            {name: "contestada", title: name_fields.contestada, type: "select", items: {0: 'Seleccionar', 2: "No contestada", 1: "Contestada"}, inserting: false, editing: false},
            {name: "encuesta_valida", title: name_fields.encuesta_valida, type: "select", items: {1: "Valida", 2: "No valida", 3: 'Todas'}, inserting: false, editing: false},
            {name: "descripcion_encuestas", title: name_fields.descripcion_encuestas, type: "text", inserting: false, editing: false},
            {name: "names_grupos", title: name_fields.names_grupos, type: "text", inserting: false, editing: false},
            {name: "bloque", title: name_fields.bloque, type: "text", inserting: false, editing: false},
            {name: "rol_evaluador", title: name_fields.rol_evaluador, type: "text", inserting: false, editing: false},
            {name: "matricula_evaluador", title: name_fields.matricula_evaluador, type: "text", inserting: false, editing: false},
            {name: "nombre_evaluador", title: name_fields.nombre_evaluador, type: "text", inserting: false, editing: false},
            {name: "clave_categoria_evaluador_tutor", title: name_fields.clave_categoria_evaluador_tutor, type: "text", inserting: false, editing: false},
            {name: "nombre_categoria_evaluado_tutor", title: name_fields.nombre_categoria_evaluado_tutor, type: "text", inserting: false, editing: false},
            {name: "clave_adscripcion_tutor_evaluador", title: name_fields.clave_adscripcion_tutor_evaluador, type: "text", inserting: false, editing: false},
            {name: "nombre_adscripcion_tutor_evaluador", title: name_fields.nombre_adscripcion_tutor_evaluador, type: "text", inserting: false, editing: false},
            {name: "delegacion_tutor_evaluador", title: name_fields.delegacion_tutor_evaluador, type: "text", inserting: false, editing: false},
            {name: "region_tutor_evaluador_dor", title: name_fields.region_tutor_evaluador_dor, type: "text", inserting: false, editing: false},
            {name: "rol_evaluando", title: name_fields.rol_evaluando, type: "text", inserting: false, editing: false},
            {name: "matricula_evaluado", title: name_fields.matricula_evaluado, type: "text", inserting: false, editing: false},
            {name: "nombre_evaluado", title: name_fields.nombre_evaluado, type: "text", inserting: false, editing: false},
            {name: "clave_categoria_evaluado", title: name_fields.clave_categoria_evaluado, type: "text", inserting: false, editing: false},
            {name: "nombre_categoria_evaluado", title: name_fields.nombre_categoria_evaluado, type: "text", inserting: false, editing: false},
            {name: "clave_adscripcion_evaluado", title: name_fields.clave_adscripcion_evaluado, type: "text", inserting: false, editing: false},
            {name: "nombre_adscripcion_evaluado", title: name_fields.nombre_adscripcion_evaluado, type: "text", inserting: false, editing: false},
            {name: "delegacion_evaluado", title: name_fields.delegacion_evaluado, type: "text", inserting: false, editing: false},
            {name: "region_evaluado", title: name_fields.region_evaluado, type: "text", inserting: false, editing: false},
            {name: "calificacion", title: name_fields.calificacion, type: "text", inserting: false, editing: false},
            {name: "calificacion_bono", title: name_fields.calificacion_bono, type: "text", inserting: false, editing: false},
            {name: "fecha_evaluacion", title: name_fields.fecha_evaluacion, type: "text", inserting: false, editing: false},
            {type: "control", editButton: false, deleteButton: false,
                searchModeButtonTooltip: "Cambiar a modo búsqueda", // tooltip of switching filtering/inserting button in inserting mode
                editButtonTooltip: "Editar", // tooltip of edit item button
                searchButtonTooltip: "Buscar", // tooltip of search button
                clearFilterButtonTooltip: "Limpiar filtros de búsqueda", // tooltip of clear filter button
                updateButtonTooltip: "Actualizar", // tooltip of update item button
                cancelEditButtonTooltip: "Cancelar", // tooltip of cancel editing button
            }
        ]
    });
//    $("#jsReporteEncuestas").jsGrid("option", "filtering", false);
}

function grid_reporte_hechos(curso) {
    var name_fields = obtener_cabeceras_encuestas_hechos();
    grid = $('#jsReporteHechos').jsGrid({
        height: "600px",
        width: "100%",
//        deleteConfirm: "¿Deseas eliminar este registro?",
        filtering: true,
        inserting: false,
        editing: false,
        sorting: false,
        selecting: false,
        paging: true,
        autoload: true,
        pageSize: 4,
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
                //console.log(filter);
                var d = $.Deferred();
                //var result = null;

                $.ajax({
                    type: "GET",
                    url: site_url + "/resultadocursoencuesta/get_registros_encuestas_curso/" + curso,
                    data: filter,
                    dataType: "json"
                })
                        .done(function (result) {
//                            console.log(result);
                            var depuracion = get_depurar_totales(result.data);
                            update_reporte_indicador(depuracion);
//                            console.log(depuracion);
//                            console.log(result.data);
                            var res = $.grep(depuracion.data, function (registro) {
                                return (
                                        !filter.contestada || (registro.contestada !== null && (registro.contestada === filter.contestada)))
                                        && (!filter.encuesta_faltantes || (registro.encuesta_faltantes !== null && registro.encuesta_faltantes.toLowerCase().indexOf(filter.encuesta_faltantes.toString().toLowerCase()) > -1))
                                        && (!filter.matricula_evaluador || (registro.matricula_evaluador !== null && registro.matricula_evaluador.toLowerCase().indexOf(filter.matricula_evaluador.toString().toLowerCase()) > -1))
                                        && (!filter.nombre_evaluador || (registro.nombre_evaluador !== null && registro.nombre_evaluador.toLowerCase().indexOf(filter.nombre_evaluador.toString().toLowerCase()) > -1))
                                        && (!filter.total_encuestas || (registro.total_encuestas !== null && registro.total_encuestas.toString().indexOf(filter.total_encuestas.toString()) > -1))
                                        && (!filter.encuestas_contestadas || (registro.encuestas_contestadas !== null && registro.encuestas_contestadas.toString().indexOf(filter.encuestas_contestadas.toString()) > -1))
                                        && (!filter.encuestas_faltantes || (registro.encuestas_faltantes !== null && registro.encuestas_faltantes.toLowerCase().indexOf(filter.encuestas_faltantes.toString().toLowerCase()) > -1))
                                        //evaluador imss
//                                        && (!filter.clave_categoria_evaluador_tutor || (registro.clave_categoria_evaluador_tutor !== null && registro.clave_categoria_evaluador_tutor.toLowerCase().indexOf(filter.clave_categoria_evaluador_tutor.toString().toLowerCase()) > -1))
//                                        && (!filter.nombre_categoria_evaluado_tutor || (registro.nombre_categoria_evaluado_tutor !== null && registro.nombre_categoria_evaluado_tutor.toLowerCase().indexOf(filter.nombre_categoria_evaluado_tutor.toString().toLowerCase()) > -1))
//                                        && (!filter.clave_adscripcion_tutor_evaluador || (registro.clave_adscripcion_tutor_evaluador !== null && registro.clave_adscripcion_tutor_evaluador.toLowerCase().indexOf(filter.clave_adscripcion_tutor_evaluador.toString().toLowerCase()) > -1))
//                                        && (!filter.nombre_adscripcion_tutor_evaluador || (registro.nombre_adscripcion_tutor_evaluador !== null && registro.nombre_adscripcion_tutor_evaluador.toLowerCase().indexOf(filter.nombre_adscripcion_tutor_evaluador.toString().toLowerCase()) > -1))
//                                        && (!filter.delegacion_tutor_evaluador || (registro.delegacion_tutor_evaluador !== null && registro.delegacion_tutor_evaluador.toLowerCase().indexOf(filter.delegacion_tutor_evaluador.toString().toLowerCase()) > -1))
//                                        && (!filter.region_tutor_evaluador_dor || (registro.region_tutor_evaluador_dor !== null && registro.region_tutor_evaluador_dor.toLowerCase().indexOf(filter.region_tutor_evaluador_dor.toString().toLowerCase()) > -1))
                                        ;
                            });
//                            d.resolve(result['data']);
                            d.resolve(res);
                            calcula_ancho_grid('jsReporteHechos', 'jsgrid-header-cell');
                        });

                return d.promise();
            },
            updateItem: function (item) {
            }
        },
        fields: [
            {name: "contestada", title: name_fields.contestada, type: "select", items: {0: 'Seleccionar', 1: "Completa", 2: "Incompleta"}, inserting: false, editing: false},
            {name: "matricula_evaluador", title: name_fields.matricula_evaluador, type: "text", items: {0: 'Seleccionar', 2: "No contestada", 1: "Contestada"}, inserting: false, editing: false},
            {name: "nombre_evaluador", title: name_fields.nombre_evaluador, type: "text", inserting: false, editing: false},
            {name: "total_encuestas", title: name_fields.total_encuestas, type: "text", inserting: false, editing: false},
            {name: "encuestas_contestadas", title: name_fields.encuestas_contestadas, type: "text", inserting: false, editing: false},
//            {name: "clave_categoria_evaluador_tutor", title: name_fields.clave_categoria_evaluador_tutor, type: "text", inserting: false, editing: false},
//            {name: "nombre_categoria_evaluado_tutor", title: name_fields.nombre_categoria_evaluado_tutor, type: "text", inserting: false, editing: false},
//            {name: "clave_adscripcion_tutor_evaluador", title: name_fields.clave_adscripcion_tutor_evaluador, type: "text", inserting: false, editing: false},
//            {name: "nombre_adscripcion_tutor_evaluador", title: name_fields.nombre_adscripcion_tutor_evaluador, type: "text", inserting: false, editing: false},
//            {name: "delegacion_tutor_evaluador", title: name_fields.delegacion_tutor_evaluador, type: "text", inserting: false, editing: false},
//            {name: "region_tutor_evaluador_dor", title: name_fields.region_tutor_evaluador_dor, type: "text", inserting: false, editing: false},
            {name: "encuesta_faltantes", title: name_fields.encuesta_faltantes, type: "text", inserting: false, editing: false},
//            {name: "email_tutor_evaluador", title: name_fields.email_tutor_evaluador, type: "text", inserting: false, editing: false},
            {type: "control", editButton: false, deleteButton: false,
                searchModeButtonTooltip: "Cambiar a modo búsqueda", // tooltip of switching filtering/inserting button in inserting mode
                editButtonTooltip: "Editar", // tooltip of edit item button
                searchButtonTooltip: "Buscar", // tooltip of search button
                clearFilterButtonTooltip: "Limpiar filtros de búsqueda", // tooltip of clear filter button
                updateButtonTooltip: "Actualizar", // tooltip of update item button
                cancelEditButtonTooltip: "Cancelar", // tooltip of cancel editing button
            }
        ]
    });
}

function get_depurar_totales(arr) {
    var out = {};
    var out_p = new Array();
    var result = new Object();
    var valor;
    var total_general = 0;
    var contestadas_general = 0;
//    console.log(arr);

    for (var i = 0; i < arr.length; ++i) {
        valor = arr[i];

//        console.log(valor.contestada);
        if (out[valor.matricula_evaluador]) {
            var aux = out[valor.matricula_evaluador];
            var contestada = aux.encuestas_contestadas + 1;
            var total = aux.total_encuestas + 1;
            if (valor.contestada == 2 && (valor.calificacion == null || valor.calificacion.toString().length <= 0)) {
//            if (valor.contestada != "2" ) {
                contestada -= 1;
                if (aux.encuesta_faltantes.toLowerCase().indexOf(valor.cve_corta_encuesta.toString().toLowerCase()) == -1) {//Valida que no exista la encusta
                    aux.encuesta_faltantes += ', ' + valor.descripcion_encuestas;
                }
            }
            aux.contestada = 2;
            if (contestada == total) {
                aux.contestada = 1;
            }
//            console.log(total);

            out[valor.matricula_evaluador] = {
                encuesta_faltantes: aux.encuesta_faltantes,
                clave_categoria_evaluador_tutor: aux.clave_categoria_evaluador_tutor,
                nombre_categoria_evaluado_tutor: aux.nombre_categoria_evaluado_tutor,
                clave_adscripcion_tutor_evaluador: aux.clave_adscripcion_tutor_evaluador,
                nombre_adscripcion_tutor_evaluador: aux.nombre_adscripcion_tutor_evaluador,
                delegacion_tutor_evaluador: aux.delegacion_tutor_evaluador,
                region_tutor_evaluador_dor: aux.region_tutor_evaluador_dor,
                matricula_evaluador: valor.matricula_evaluador,
                nombre_evaluador: valor.nombre_evaluador,
                total_encuestas: total,
                encuestas_contestadas: contestada,
                contestada: aux.contestada,
                email_tutor_evaluador: aux.email_preg_evaluador
            }

        } else {

            var concluidas = 2;
            if (valor.rol_evaluador_id == 5) {
                valor.clave_categoria_evaluador_tutor = valor.clave_categoria_evaluador_preg;
                valor.nombre_categoria_evaluado_tutor = valor.nombre_categoria_evaluado_preg;
                valor.clave_adscripcion_tutor_evaluador = valor.clave_adscripcion_preg_evaluador;
                valor.nombre_adscripcion_tutor_evaluador = valor.nombre_adscripcion_preg_evaluador;
                valor.delegacion_tutor_evaluador = valor.delegacion_preg_evaluador;
                valor.region_tutor_evaluador_dor = valor.region_preg_evaluador;
                valor.email_tutor_evaluador = valor.email_preg_evaluador;
            }
            if (valor.contestada == 1) {
                valor.encuestas_contestadas = 1;
                valor.descripcion_encuestas = "";
                concluidas = 1;
            } else {
                if ((valor.calificacion != null && valor.calificacion.toString().length > 0)) {
                    valor.encuestas_contestadas = 1;
                    concluidas = 1;
                } else {
                    valor.encuestas_contestadas = 0;
                }
            }
            out[valor.matricula_evaluador] = {
                encuesta_faltantes: valor.descripcion_encuestas,
                clave_categoria_evaluador_tutor: valor.clave_categoria_evaluador_tutor,
                nombre_categoria_evaluado_tutor: valor.nombre_categoria_evaluado_tutor,
                clave_adscripcion_tutor_evaluador: valor.clave_adscripcion_tutor_evaluador,
                nombre_adscripcion_tutor_evaluador: valor.nombre_adscripcion_tutor_evaluador,
                delegacion_tutor_evaluador: valor.delegacion_tutor_evaluador,
                region_tutor_evaluador_dor: valor.region_tutor_evaluador_dor,
                matricula_evaluador: valor.matricula_evaluador,
                nombre_evaluador: valor.nombre_evaluador,
                total_encuestas: 1,
                encuestas_contestadas: valor.encuestas_contestadas,
                contestada: concluidas,
                email_tutor_evaluador: valor.email_tutor_evaluador,
            }
        }
    }
    var auxtmp;
    for (var key in out) {
        auxtmp = out[key];
        out_p.push(auxtmp);
        total_general += auxtmp.total_encuestas;
        contestadas_general += auxtmp.encuestas_contestadas;
    }
    result.data = out_p;
    result.total_general = total_general;
    result.contestadas_general = contestadas_general;
    result.no_contestadas_general = total_general - contestadas_general;
    return result;
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
        cabeceras = obtener_cabeceras_encuestas();
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
            o[+k] = arr[i][k]
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
function obtener_cabeceras_encuestas() {
    var arr_header = {
        tutorizado: 'Tutoricado',
//        cur_id: '',
        curso_clave: 'Clave de curso',
        curso_nombre: 'Curso',
//        ids_grupos: '',
        names_grupos: 'Grupo(s)',
        bloque: 'Bloque',
//        encuesta_cve: '',
//        cve_corta_encuesta: '',
        descripcion_encuestas: 'Nombre de la encuesta',
        matricula_evaluado: 'Matrícula del evaluado',
//        rol_evaluado_id: '',
        rol_evaluando: 'Rol del evaluado',
        nombre_evaluado: 'Nombre del evaluado',
        clave_categoria_evaluado: 'Clave de categoría del evaluado',
        nombre_categoria_evaluado: 'Categoría del evaluado',
        clave_adscripcion_evaluado: 'Clave de adscripción del evaluado',
        nombre_adscripcion_evaluado: 'Adscripción del evaluado',
        delegacion_evaluado: 'Delegación del evaluado',
        region_evaluado: 'Región del evaluado',
        matricula_evaluador: 'Matrícula evaluador',
//        rol_evaluador_id: '',
        rol_evaluador: 'Rol del evaluador',
        nombre_evaluador: 'Nombre del evaluador',
//        clave_categoria_evaluador_preg: 'Clave de categoria evaluador alumno',
//        nombre_categoria_evaluado_preg: 'Categoría evaluador alumno',
//        clave_adscripcion_preg_evaluador: 'Clave adscripción evaluador alumno',
//        nombre_adscripcion_preg_evaluador: 'Adscripción evaluador alumno',
//        delegacion_preg_evaluador: 'Delegación evaluador alumno',
//        region_preg_evaluador: 'Región evaluador alumno',
        clave_categoria_evaluador_tutor: 'Clave de categoría del evaluador',
        nombre_categoria_evaluado_tutor: 'Categoría del evaluador',
        clave_adscripcion_tutor_evaluador: 'Clave adscripción del evaluador',
        nombre_adscripcion_tutor_evaluador: 'Adscripción del evaluador',
        delegacion_tutor_evaluador: 'Delegación del evaluador',
        region_tutor_evaluador_dor: 'Región del evaluador',
//        email_tutor_evaluador: 'Correo electrónico del evaluador'
        contestada: 'Encuesta contestada y no contestada',
        calificacion: 'Calificación',
        calificacion_bono: 'Calificación para bono',
        fecha_evaluacion: 'Fecha de evaluación',
        encuesta_valida: 'Encuesta valida'
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
    var itemsCount = d.data.length;//Obtiene el tamaño de los datos
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