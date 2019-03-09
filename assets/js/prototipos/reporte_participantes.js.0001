$(document).ready(function () {
	$("#filtros_descarga").hide();
	reporte_general();

	var select_tr = $('select[name="tipo_reporte"]');
	
	select_tr.on('change',function(){
		var tipo = select_tr.val();
		dibuja_componentes(tipo);
	});
});

function limpiar_filtros(){
	document.getElementById("form_filtros").reset();
}

function reporte_general(){
	var texto = '<hr/> <div class="row" style="padding: 0.5em;">' +
	'<center>' +
	'<div class="col-sm-4">' +
	'<strong>Número de encuestas contestadas</strong>' +
	'<br>' +
	'13' +
	'</div>' +
	'<div class="col-sm-4">' +
	'<strong>Número de encuestas contestadas</strong>' +
	'<br>' +
	'8' +
	'</div>' +
	'<div class="col-sm-4">' +
	'<strong>Número de encuestas contestadas</strong>' +
	'<br>' +
	'5' +
	'</div>' +
	'</center>            ' +
	'</div>' +
	'<hr/>' +
	'<br>' +
	'<div class="row" style="padding: 1em;">' +
	'<div id="grid_participantes"></div>' +
	'</div> <hr/>';
	$('#reporte_general').html(texto);
	grid_participantes();
}

function dibuja_componentes(tipo){
	switch(tipo){
		case "1":
			$("#filtros_descarga").hide();
			$("#btn_correo").show();
			reporte_general();
		break;
		default:
			$("#btn_correo").hide();
			$("#reporte_general").empty();
			$("#filtros_descarga").show();
		break;
	}
}

function grid_participantes() {
	var db = {
		loadData: function (filter) {
			return $.grep(this.participantes, function (participante) {
				return (!filter.Matricula || participante.Matricula == filter.Matricula)
						&& (!filter.Nombre || participante.Nombre.indexOf(filter.Nombre)>-1)
						&& (!filter.Estado || participante.Estado === filter.Estado);
			});
		}
	};

	window.db = db;

	db.estados = [
		{Name: "", Id: 0},
		{Name: "Concluido", Id: 1},
		{Name: "No concluido", Id: 2}
	];

	db.participantes = [
		{
			"Matricula":  99061709,
			"Nombre": "Liliana Yaneth García Pantoja",
			"No_contestadas" : 1,
			"Asignadas": 2,
			"Recordatorios_enviados": 1,
			"Estado": 2 
		}, {
			"Matricula":  99062477,
			"Nombre": "Nereida Gutiérrez Heredia",
			"No_contestadas" : 3,
			"Asignadas": 5,
			"Recordatorios_enviados": 1,
			"Estado": 2 
		}, {
			"Matricula": 98205153,
			"Nombre" : "Martha Isabel Tamayo Narváez",
			"No_contestadas": 0,
			"Asignadas": 1,
			"Recordatorios_enviados": 1,
			"Estado": 1
		}, {
			"Matricula":  99360988,
			"Nombre": "Miguel Ángel Becerril Pérez",
			"No_contestadas" : 2,
			"Asignadas": 3,
			"Recordatorios_enviados": 1,
			"Estado": 2 
		}, {
			"Matricula": 99277409,
			"Nombre": "Juan Gabriel Salazar Ornelas",
			"No_contestadas": 0,
			"Asignadas": 2,
			"Recordatorios_enviados": 2,
			"Estado": 1
		}
	];

	$("#grid_participantes").jsGrid({
        height: 400,
        width: "100%",
 
        filtering: true,
		inserting: false,
        editing: false,
        sorting: true,
        selecting: false,
        paging: true,
        autoload: true,

        pageSize: 4,
        pageButtonCount: 3,
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
 
        controller: db,
    
        fields: [
        	{ title: "Seleccionar", width: 80, align: "center",
        		filterTemplate: function () {
        			return $("<input>").attr("type","checkbox")
        				.on("change",function () {
        					$("input:checkbox").prop('checked', $(this).prop("checked"));
        				});
        		},
        		itemTemplate: function (_, item) {
        			if(item['Estado'] == 2){
        				return $("<input>").attr("type", "checkbox")
                    	.prop("checked", $.inArray(item, selectedItems) > -1)
                    	.on("change", function () {
                        	$(this).is(":checked") ? selectItem(item) : unselectItem(item);
                    	});
                    }else{
                    	return "";
                    }
        		}
        	},
        	{ name: "Matricula", title: "Matrícula del evaluador", type: "textarea", width: 100, align: "left" },
        	{ name: "Nombre", title: "Nombre del evaluador", type: "textarea", width: 180, align: "left" },
        	{ name: "No_contestadas", title: "Número de encuestas no contestadas", type: "number", width: 100, align: "center", filtering: false },
        	{ name: "Asignadas", title: "Número de encuestas asignadas", type: "number", width: 100, align: "center", filtering: false },
        	{ name: "Recordatorios_enviados", title: "Número de recordatorios enviados", type: "number", width: 100, align: "center", filtering: false },
            { name: "Estado", title: "Estado", type: "select", items: db.estados, valueField: "Id", textField: "Name" , width: 100, align: "left" },
            { type: "control", width: 60, 
            	itemTemplate: function (value, item) {
        			var href = "#";
        			if(item['Matricula'] == 99061709){
        				href = site_url + '/Prototipos/detalle_participante';
        			}
        			var btn =  "<a href='" + href + "' class='btn btn-primary'>";
        			btn += "<span class='glyphicon glyphicon-search'></span>" ;
        			btn += "</a>";
        			return btn;
        		} 
        	}
        ]
    });

    var selectedItems = [];
 
    var selectItem = function(item) {
        selectedItems.push(item);
    };
 
    var unselectItem = function(item) {
        selectedItems = $.grep(selectedItems, function(i) {
            return i !== item;
        });
    };
 
}