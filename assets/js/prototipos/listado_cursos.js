$(document).ready(function () {
	grid_cursos();
});

function grid_cursos() {
	var db = {
		loadData: function (filter) {
			return $.grep(this.cursos, function (curso) {
				return (!filter.clave || curso.clave == filter.clave)
					&& (!filter.nombre || curso.nombre.indexOf(filter.nombre) > -1)
					&& (!filter.anio || curso.anio == filter.anio)
					&& (!filter.tutorizado || curso.tutorizado == filter.tutorizado);
			});
		}
	};

	window.db = db;

	db.tipo_curso = [
		{ Id: 0, Valor: "Seleccione una opción"},
		{ Id: 1, Valor: "Tutorizado"},
		{ Id: 2, Valor: "No tutorizado"}
	];

	db.anios = [
		{ Id: 0, Valor: "-"},
		{ Id: 2017, Valor: "2017"},
		{ Id: 2018, Valor: "2018"}
	];

	db.cursos = [{
		"clave" : "CES-DGDE-I4-17",
		"nombre" : "Gestión Directiva para Enfermería",
		"anio" : 2018,
		"horas" : 120,
		"tutorizado" : 2,
		"bloques" : "NA"
	}, {
		"clave" : "CES-DGDE-I3-17",
		"nombre" : "Gestión Directiva para Enfermería",
		"anio" : 2018,
		"horas" : 120,
		"tutorizado" : 1,
		"bloques" : "Sin Asignar"
	}, {
		"clave" : "CES-DAMG-I1-17",
		"nombre" : "Actualización del personal Médico de Atención Primaria",
		"anio" : 2017,
		"horas" : 150,
		"tutorizado" : 1,
		"bloques" : "Asignados"
	}, {
		"clave" : "CES-AD-I1-17",
		"nombre" : "Actualización en Dermatología",
		"anio" : 2017,
		"horas" : 150,
		"tutorizado" : 1,
		"bloques" : "Sin Asignar"
	}, {
		"clave" : "CES-AD-I4-17",
		"nombre" : "Actualización en Dermatología",
		"anio" : 2017,
		"horas" : 40,
		"tutorizado" : 2,
		"bloques" : "NA"
	}, {
		"clave" : "CES-AD-I3-17",
		"nombre" : "Actualización en Dermatología",
		"anio" : 2017,
		"horas" : 40,
		"tutorizado" : 2,
		"bloques" : "NA"
	}];

	$("#grid_cursos").jsGrid({
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
        	{name: "clave", type: "text", title: "Clave de implementación", align: "left", width: 100},
        	{name: "nombre", type: "text", title: "Nombre de curso", align: "left", width: 180},
        	{name: "anio", type: "select", title: "Año del curso", align: "right", width: 50,
        		items: db.anios, valueField: "Id", textField: "Valor"
        	},
        	{name: "horas", type: "number", title: "Duración en horas", align: "right", width: 50, filtering: false},
        	{name: "tutorizado", type: "select", title: "Tipo de curso", align: "center", width:80,
        		items: db.tipo_curso, valueField: "Id", textField: "Valor",
        		itemTemplate: function (value, item) {
        			var icon;
        			if(value == 2)
        				icon = "<h4><span class='glyphicon glyphicon-remove' aria-hidden='1' style='color:red;'></span></h4>";
        			if(value == 1)
        				icon = "<h4><span class='glyphicon glyphicon-ok' aria-hidden='1' style='color:green;'></span></h4>";
        			return icon;
        		}
        	},
        	{name: "bloques", type:"text", title: "Bloques", align: "left", width: 80, filtering: false},
        	{type: "control", width:60, align: "center",
        		itemTemplate: function (value, item) {
        			var href = "#";
        			if(item['clave'] == 'CES-DAMG-I1-17'){
        				href = site_url + '/Prototipos/info_curso/1094';
        			}
        			var btn =  "<a href='" + href + "' class='btn btn-primary'>";
        			btn += "<span class='glyphicon glyphicon-search'></span>" ;
        			btn += "</a>";
        			return btn;
        		}
        	}
        ]
	});

}