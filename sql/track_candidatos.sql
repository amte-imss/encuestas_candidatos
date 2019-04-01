INSERT INTO encuestas.sse_modulo (descripcion_modulo, nom_controlador_funcion_mod, modulo_padre_cve, is_menu) values 
('Candidatos nominativos', '/', null, 1);

INSERT INTO encuestas.sse_modulo (descripcion_modulo, nom_controlador_funcion_mod, modulo_padre_cve, is_menu) values 
('Cargar candidatos', '/candidatos/cargar_candidatos', (SELECT modulo_cve from encuestas.sse_modulo where descripcion_modulo = 'Candidatos nominativos'), 1),
('Generar formato SIED', '/candidatos/generar_formato_sied', (SELECT modulo_cve from encuestas.sse_modulo where descripcion_modulo = 'Candidatos nominativos'), 0),
('Candidatos carga csv', '/candidatos/cargar_candidatos_csv', (SELECT modulo_cve from encuestas.sse_modulo where descripcion_modulo = 'Candidatos nominativos'), 0),
('Catalogo delegaciones', '/candidatos/get_delegaciones', (SELECT modulo_cve from encuestas.sse_modulo where descripcion_modulo = 'Candidatos nominativos'), 0),
('Formato candidatos csv', '/candidatos/get_formato_candidatos_csv', (SELECT modulo_cve from encuestas.sse_modulo where descripcion_modulo = 'Candidatos nominativos'), 0),
('Lista candidatos grid', '/candidatos/lista_candidatos', (SELECT modulo_cve from encuestas.sse_modulo where descripcion_modulo = 'Candidatos nominativos'), 0),
('Insertar', '/candidatos/insert', (SELECT modulo_cve from encuestas.sse_modulo where descripcion_modulo = 'Candidatos nominativos'), 0),
('Editar', '/candidatos/edit', (SELECT modulo_cve from encuestas.sse_modulo where descripcion_modulo = 'Candidatos nominativos'), 0),
('Eliminar', '/candidatos/delete', (SELECT modulo_cve from encuestas.sse_modulo where descripcion_modulo = 'Candidatos nominativos'), 0)
;

INSERT into encuestas.sse_modulo_rol (modulo_cve, role_id, acceso) values 
((SELECT modulo_cve from encuestas.sse_modulo where descripcion_modulo = 'Candidatos nominativos'), 1, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/cargar_candidatos'), 1, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/generar_formato_sied'), 1, 1),
((SELECT modulo_cve from encuestas.sse_modulo where descripcion_modulo = 'Candidatos nominativos'), 13, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/cargar_candidatos'), 13, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/generar_formato_sied'), 13, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/cargar_candidatos_csv'), 1, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/cargar_candidatos_csv'), 13, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/get_delegaciones'), 1, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/get_delegaciones'), 13, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/get_formato_candidatos_csv'), 1, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/get_formato_candidatos_csv'), 13, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/lista_candidatos'), 1, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/lista_candidatos'), 13, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/insert'), 1, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/insert'), 13, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/edit'), 1, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/edit'), 13, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/delete'), 1, 1),
((SELECT modulo_cve from encuestas.sse_modulo where nom_controlador_funcion_mod = '/candidatos/delete'), 13, 1)
;

/*Tabla de catalogo de tipo de carga*/
CREATE TABLE "encuestas"."ssc_tipos_carga_candidatos_curso" (
	"cve_tipo_carga_candidatos" char(2) not null,
	"descripcion" varchar(25) not null,
	"activo" bool not null default true,
 	primary key ("cve_tipo_carga_candidatos")
);

/*Catalogo de tipo de carga*/
insert into encuestas.ssc_tipos_carga_candidatos_curso (cve_tipo_carga_candidatos, descripcion) values 
	('1','Externo'),
	('2','Abierto'),
	('3','Nominativo'),
	('4','Extranjero'),
	('5','Jubilado'),
	('6','Especial'),
	('8','Sustituto'),
	('9','Inscrito nominativo')
;

alter table "encuestas"."ssc_candidatos" add column "curp" varchar(20) NULL; 
/*Tabla de información de candidatos*/
CREATE TABLE "encuestas"."ssc_candidatos" (
"id_candidato" serial8 NOT NULL,
"matricula" varchar(25) NOT NULL,
"nom" varchar(50) NOT NULL,
"ap" varchar(50) NOT NULL,
"am" varchar(50),
"curp" varchar(20) NULL,
"id_curso" int8,
"cve_curso" varchar(20) NOT NULL,
"email_principal" varchar(100) NOT NULL,
"emal_otro" varchar(100),
"cve_categoria" varchar(25),
"categoria" varchar(100),
"cve_departamental" varchar(25),
"departamental" varchar(100),
"cve_delegacion" char(2) NOT NULL,
"valido" bool NOT NULL DEFAULT true,
"id_user_registro" int8 NOT NULL,
"fecha_registro" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
"id_user_actualizacion" timestamp,
"fecha_actualizacion" timestamp,
"cve_tipo_carga_candidatos" char(2) not null,
PRIMARY KEY ("id_candidato") 

);

ALTER TABLE "encuestas"."ssc_candidatos" ADD CONSTRAINT "fk_tipo_carga_candidatos" FOREIGN KEY ("cve_tipo_carga_candidatos") REFERENCES "encuestas"."ssc_tipos_carga_candidatos_curso" ("cve_tipo_carga_candidatos");
