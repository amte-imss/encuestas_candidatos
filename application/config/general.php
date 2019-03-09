<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


$config['salt'] = "B0no5"; ///SALT

$config['roles_moodle'] = array(
    1	=> 'Administrador',
    14	=> 'Coordinador de Curso',
    11	=> 'Agente de mesa de ayuda',
    5	=> 'Alumno',
    13	=> 'Administrador de mesa de ayuda',
    34	=> 'Coordinador Evaluador',
    30	=> 'Coordinador Normativo',
    29	=> 'Área de Tecnologías para la Gestión del Conocimiento',
    33	=> 'Tutor Adjunto',
    32	=> 'Tutor Titular',
    18	=> 'Coordinador de Tutores'
);

$config['rol_alumno'] = array(
    array('rol_id' => 5, 'rol_nom' => 'Alumno'),
);

$config['rol_docente'] = array(
    array('rol_id' => 14, 'rol_nom' => 'Coordinador de curso'),
    array('rol_id' => 18, 'rol_nom' => 'Coordinador de tutores'),
    array('rol_id' => 32, 'rol_nom' => 'Tutor titular'),
    array('rol_id' => 33, 'rol_nom' => 'Tutor adjunto'),
    array('rol_id' => 30, 'rol_nom' => 'Coordinador normativo')
);

$config['menu_super_admin'] = array('resultadocursoencuesta' => array('*'), 'encuestas' => array('*'),
    'dashboard' => array('*'), 'curso' => array('*'), 'modal' => array('*'),
    'cursoencuesta' => array('*'), 'email' => array('*'), 'evaluacion' => array('*'),
    'encuestasusuario' => array('*'), 'resultadocurso' => array('*'), 'reporte' => array('*'),
    'grupo' => array('*'), 'login' => array('*'), 'seccion' => array('*'),
    'encuestausuario' => array('*'), 'resultadocurenrealizada' => array('*'),
    'pagina_no_encontrada' => array('*'), 'resultadocursoindicador' => array('*'),
    'reporte_bonos' => array('*'),
    'reporte_detallado' => array('*'),
    'reporte_general' => array('*'),
);

$config['menu_validador'] = array('login' => array('cerrar_session', 'cerrar_session_ajax'), 'dashboard' => array('*'), 'tarjeton' => array('*'), 'pagina_no_encontrada' => array('index'), 'bonos_titular' => array('*'), 'bono_perfil_empleado' => array('*'));

$config['menu_no_logueado'] = array('login/logeo', 'encuestausuario/lista_encuesta_usuario');
$config['menu_logueado_general'] = array('login/cerrar_session', 'modal/', 'inicio/');
$config['omite_menus'] = array('encuestausuario' => array('*')); //Es importante que el usuario mantenga una sesión inicida, pero no deben aparecer los menus, ejemplos: gestión, reportes implementación, instrumentos etc.
/////Ruta de solicitudes
$config['ruta_documentacion'] = $_SERVER["DOCUMENT_ROOT"] . "/sipimss_bonos/assets/files/archivos_bono/";
$config['ruta_documentacion_web'] = asset_url() . 'files/archivos_bono/'; //base_url()."assets/files/solicitudes/";

$config['tiempo_fuerza_bruta'] = 60 * 60; //3600 = 1 hora => Tiempo válido para chequeo de fuerza bruta

$config['intentos_fuerza_bruta'] = 10; ///Número de intentos válidos durante tiempo 'tiempo_fuerza_bruta'

$config['tiempo_recuperar_contrasenia'] = 60 * 60 * 24; //3600 * 24 = 86400 = 1 día => Límite de tiempo que estará activo el link

$config['meses'] = array(1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre');

$config['rol_admin'] = array('COORDINADOR' => array('id' => 1, 'text' => 'Coordinador'), 'VALIDADOR' => array('id' => 2, 'text' => 'Validador'), 'TITULAR' => array('id' => 3, 'text' => 'Titular del programa'));

$config['bon_pro_eva_min'] = (float) 80.00;

$config['bon_sum_act_min'] = 26;

$config['categoria_participante'] = array('36112580', '35312180');
//, 'attributes' => array('class' => 'btn btn-info btn-sm espacio'
$config['listado_tareas'] = array(
    1 => array('id' => 'btn_solicitud_tarjeton', 'value' => 'Solicitar tarjetón', 'type' => 'button', 'attributes' => array('class' => 'btn btn-sm btn-success btn-block espacio')),
    2 => array('id' => 'btn_registro_tarjeton', 'value' => 'Capturar tarjetón', 'type' => 'button', 'attributes' => array('class' => 'btn btn-sm btn-info  btn-block  espacio')),
    3 => array('id' => 'btn_modificar_tarjeton', 'value' => 'Corregir tarjetón', 'type' => 'button', 'attributes' => array('class' => 'btn btn-sm btn-info  btn-block espacio')),
    4 => array('id' => 'btn_env_seleccion', 'value' => 'Validar candidato seleccionados', 'type' => 'button', 'attributes' => array('class' => 'btn btn-default btn-sm espacio pull-right')), /*   actualmente esta opcion no esta en el alcance las validaciones se tendran que hacer individuales   */
    5 => array('id' => 'btn_term_seleccion', 'value' => 'Terminar seleccion de candidatos', 'type' => 'button', 'attributes' => array('class' => 'btn btn-success btn-sm espacio pull-right', 'data-toggle' => "modal", 'data-target' => "#reporteBeneficiadosBono")),
    6 => array('id' => 'btn_export_exel', 'value' => 'Exportar a excel', 'type' => 'submit', 'attributes' => array('class' => 'btn btn-info btn-sm espacio pull-right')),
    7 => array('id' => 'btn_val_titular', 'type' => 'button', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'value' => '<i class=/"fa fa-check/"></i>', 'title' => 'Validar candidato por titular', 'class' => 'btn btn-success btn-sm pull-right'),
    8 => array('id' => 'btn_val_ja', 'value' => 'Validar candidato por jefe area', 'type' => 'button', 'attributes' => array('class' => 'btn btn-info btn-sm espacio', 'data-toggle' => 'tooltip', 'title' => 'Validar candidato por jefe area')),
    9 => array('id' => 'btn_env_correccion', 'value' => 'Enviar a corrección', 'type' => 'button', 'title' => 'Enviar a corrección', 'attributes' => array('class' => 'btn btn-info btn-sm espacio', 'data-toggle' => 'tooltip', 'onclick' => "data_ajax(site_url+\'/bonos_titular/get_data_ajax_correccion\', \'null\', \'#modal_content\')")),
    //    8 => array('id' => 'btn_val_ja', 'value' => 'Validar candidato por jefe area', 'type' => 'button', 'attributes' => array('class' => 'btn btn-info btn-sm espacio', 'data-toggle' => 'tooltip', 'title' => 'Validar candidato por jefe area')),
    //    9 => array('id' => 'btn_env_correccion', 'value' => 'Enviar a corrección', 'type' => 'button', 'title' => 'Enviar a corrección', 'attributes' => array('class' => 'btn btn-info btn-sm espacio', 'data-toggle' => 'tooltip',  'onclick' => "data_ajax(site_url+\'/bonos_titular/get_data_ajax_correccion\', \'null\', \'#modal_content\')")),
    10 => array('type' => 'button', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Enviar a revisión del validador', 'class' => 'btn btn-success btn-sm pull-right'),
    11 => array('title' => 'Agregar evaluación', 'value' => 'Agregar evaluación'),
    12 => array('title' => 'Coorregir evaluación'),
    13 => array('type' => 'label', 'value' => 'Cumplio con todos los filtros de validación', 'class' => 'btn btn-success btn-sm pull-right'),
    14 => array('value' => 'Existe(n) [field] empleado(s) validados por el jefe de área', 'cantidad' => 0),
    15 => array('value' => 'Existe(n) [field] empleado(s) validados por el titular, Puede terminar el proceso de selección de candidatos', 'cantidad' => 0)
);



$config['estados_bono'] = array(
    1 => array('value' => 'NINGUNO', 'sub_value' => 'No aprobado por Faltas', 'text' => 'No entra en categoría',
        'tareas' => array(), 'no_acceso_tipo_usuarios' => array(), 'validacion_estado_anterior' => array()),
    2 => array('value' => 'CATEGORIA', 'sub_value' => 'No aprobado por Actividad', 'text' => 'Categorías de docentes participantes',
        'tareas' => array(), 'no_acceso_tipo_usuarios' => array(), 'validacion_estado_anterior' => array()),
    3 => array('value' => 'ACTIVIDAD', 'sub_value' => 'Filtro de actuación', 'text' => 'Suma de actividad docente mayor a 25 puntos',
        'tareas' => array(11, 12), 'no_acceso_tipo_usuarios' => array(), 'validacion_estado_anterior' => array()), // botones que se activan: registro de actuacion(evaluacion), modifica actuacion(corrige), y si existe almenos una actuacion y es mayor a 80.0 activa el boton solicitud de tarjeton
    4 => array('value' => 'ACTUACION', 'sub_value' => 'Filtro de tarjetón', 'text' => 'Promedio de actuación mayor a 80.00',
        'tareas' => array(1, 2, 3, 11, 12), 'no_acceso_tipo_usuarios' => array(), 'validacion_estado_anterior' => array()), // botones si la actuacion si se cumplio... -> solicitud de tarjeton si no era la quincena correcta, registro de tarjeton, y modifica tarjeton(corrige)
    5 => array('value' => 'INCIDENCIA', 'sub_value' => 'Sin faltas/Por validar/Revisión por Coordinador', 'text' => 'Docentes que no presentaron incidencias',
        'tareas' => array(3, 10), 'no_acceso_tipo_usuarios' => array(), 'validacion_estado_anterior' => array()), // si el candidato cumplio el requisito de incidencia se activa el boton de validar por jefe de area, y el boton de enviar a correccion si es el caso
    6 => array('value' => 'VALIDADO_JA', 'sub_value' => 'Validado por Jefe de área', 'text' => 'Validación de Jefe de Area',
        'tareas' => array(7, 9), 'no_acceso_tipo_usuarios' => array('VALIDADOR'), 'validacion_estado_anterior' => array(),
        'validacion_estado_anterior' => array()),
    7 => array('value' => 'CORRECCION_TARJETON', 'sub_value' => 'Corrección de tarjetón', 'text' => 'Corrección de tarjetón',
        'tareas' => array(1, 2, 3, 10), 'no_acceso_tipo_usuarios' => array(), 'validacion_estado_anterior' => array()),
    8 => array('value' => 'CORRECCION_ENCUESTA', 'sub_value' => 'Corrección de encuesta', 'text' => 'Corrección de Actuación',
        'tareas' => array(11, 12, 10), 'no_acceso_tipo_usuarios' => array(), 'validacion_estado_anterior' => array()),
    9 => array('value' => 'VALIDADO_TITULAR', 'sub_value' => 'Validado por Titular', 'text' => 'Validación del titular',
        'tareas' => array(13), 'no_acceso_tipo_usuarios' => array(), 'validacion_estado_anterior' => array()),
    10 => array('value' => 'REVISION', 'sub_value' => 'Revisión por Jefe de área', 'text' => 'Validación del titular',
        'tareas' => array(8, 9), 'no_acceso_tipo_usuarios' => array(), 'validacion_estado_anterior' => array()),
);



$config['usuarios_bono'] = array(
    'COORDINADOR' => array('id' => 1, 'permisos' => array(6, 1, 2, 3, 11, 12, 10, 13)),
    'VALIDADOR' => array('id' => 2, 'permisos' => array(6, 8, 9, 13)),
    'TITULAR' => array('id' => 3, 'permisos' => array(6, 5, 9, 7, 4, 13, 14, 15)));

$config['buscador_listado'] = array(6, 5, 4, 14, 15);
//$config['buscador_listado'] = array(                     'vista'=>array(array('vista'=>1,10,13,14,15,16,17,18,19)));

$config['alert_msg'] = array(
    'SUCCESS' => array('id_msg' => 1, 'class' => 'success'),
    'DANGER' => array('id_msg' => 2, 'class' => 'danger'),
    'WARNING' => array('id_msg' => 3, 'class' => 'warning'),
    'INFO' => array('id_msg' => 4, 'class' => 'info')
);

$config['parametros_bitacora'] = array('USUARIO_CVE' => 'NULL', 'BIT_VALORES' => 'NULL',
    'BIT_IP' => 'NULL', 'BIT_RUTA' => 'NULL', 'MODULO_CVE' => 'NULL');
$config['parametros_log'] = array('USUARIO_CVE' => 'NULL', 'LOG_INI_SES_IP' => 'NULL',
    'INICIO_SATISFACTORIO' => 'NULL');



$config['ENCUESTAS_RESPUESTA'] = array(
    'CERRADA' => array('SI' => 1, 'NO' => 0),
    'ABIERTA' => array('SI' => 7, 'NO' => 0),
    'NO_ENVIO_MENSAJE' => array('SI' => 7, 'NO' => 0)
);

$config['ENCUESTAS_TIPO_PREGUNTA'] = array(
    1 => array(//RESPUESTA_INDEFINIDA
        'tipo_pregunta_cve' => 7
    ),
    2 => array(//SI_NO
        'tipo_pregunta_cve' => 1,
        'reactivos' => array(
            array('texto' => 'Si', 'ponderacion' => 1),
            array('texto' => 'No', 'ponderacion' => 0)
        )
    ),
    3 => array(//NULO_SI_NO
        'tipo_pregunta_cve' => 2,
        'reactivos' => array(
            array('texto' => 'No aplica', 'ponderacion' => 0),
            array('texto' => 'Si', 'ponderacion' => 1),
            array('texto' => 'No', 'ponderacion' => 0)
        )
    ),
    5 => array(//SIEMPRE_NUNCA
        'tipo_pregunta_cve' => 3,
        'reactivos' => array(
            array('texto' => 'Siempre', 'ponderacion' => 1),
            array('texto' => 'Casi siempre', 'ponderacion' => 1),
            array('texto' => 'Algunas veces', 'ponderacion' => 0),
            array('texto' => 'Casi nunca', 'ponderacion' => 0),
            array('texto' => 'Nunca', 'ponderacion' => 0)
        )
    ),
    6 => array(//NULO_SIEMPRE_NUNCA
        'tipo_pregunta_cve' => 4,
        'reactivos' => array(
            array('texto' => 'No aplica', 'ponderacion' => 0),
            array('texto' => 'Siempre', 'ponderacion' => 1),
            array('texto' => 'Casi siempre', 'ponderacion' => 1),
            array('texto' => 'Algunas veces', 'ponderacion' => 0),
            array('texto' => 'Casi nunca', 'ponderacion' => 0),
            array('texto' => 'Nunca', 'ponderacion' => 0)
        )
    ),
    7 => array(//RESPUESTA_ABIERTA
        'tipo_pregunta_cve' => 5
    ),
    8 => array(//NULO_RESPUESTA_ABIERTA
        'tipo_pregunta_cve' => 6,
        'reactivos' => array(
            array('texto' => 'No aplica', 'ponderacion' => 0))
    ),
    9 => array(//NOENVIOMENSAJE_E_SI_NO
        'tipo_pregunta_cve' => 8,
        'reactivos' => array(
            array('texto' => 'No envió mensaje', 'ponderacion' => 0),
            array('texto' => 'Si', 'ponderacion' => 1),
            array('texto' => 'No', 'ponderacion' => 0)
        )
    )
);
$config['ENCUESTAS_RESPUESTA_ESPERADA'] = array(
    'NO_APLICA' => 'No aplica',
    'SI' => 'Si',
    'NO' => 'No',
    'SIEMPRE' => 'Siempre',
    'CASI_SIEMPRE' => 'Casi siempre',
    'ALGUNAS_VECES' => 'Algunas veces',
    'CASI_NUNCA' => 'Casi nunca',
    'NUNCA' => 'Nunca',
    'RESPUESTA_ABIERTA' => 'Respuesta abierta',
    'NO_ENVIO_MENSAJE' => 'No envío mensaje'
);
$config['ENCUESTAS_ROL_EVALUA'] = array(
    'COORDINADOR_NORMATIVO' => 30,
    'COORDINADOR_CURSO' => 14,
    'COORDINADOR_DE_TUTORES' => 18,
    'COORDINADOR_TUTORES' => 18,
    'TUTOR_TITULAR' => 32,
    'TUTOR_ADJUNTO' => 33,
    'COORDINADOR_DE_CURSO' => 14
);
$config['ENCUESTAS_ROL_EVALUADOR'] = array(
    'COORDINADOR_CURSO' => 14,
    'COORDINADOR_TUTORES' => 18,
    'COORDINADOR_DE_TUTORES' => 18,
    'TUTOR_TITULAR' => 32,
    'ALUMNO' => 5,
    'COORDINADOR_NORMATIVO' => 30,
    'TUTOR_ADJUNTO' => 33,
    'COORDINADOR_DE_CURSO' => 14
);

$config['TUTORIZADO'] = array(
	'SI' => 1,
	'NO' => 0
);


$config['puntos_rol'] = array(
    '14_0' => 2, //'Coordinador de curso no tutorizado'
    '14_1' => 3, //'Coordinador de curso tutorizado'
    '18_1' => 4, //Coordinador de tutores tutorizado
    '32_1' => 6, //Tutor titular
    '33_1' => 4, //Tutor adjunto
    '30_1' => 0, // coordinador normativo
    //No pasa en el negocio, pero en programacion es importante para evitar errores
    '18_0' => 4, //Coordinador de tutores tutorizado
    '32_0' => 6, //Tutor titular
    '33_0' => 4, //Tutor adjunto
    '30_0' => 0// coordinador normativo
);

$config['tipo_curso_DCG'] = array(1 => 'Diplomado', 2 => 'Curso', 3 => 'Curso basado en GPC');
$config['puntos_tipo_curso'] = array('CURSO' => 1, 'DIPLOMADO' => 3, 'CURSO BASADO EN GPC' => 1);
$config['puntos_tipo_curso_id'] = array(2 => 1, 1 => 3, 3 => 1); //curso =2 ; diplomado=1; GPC=3;
$config['puntos_horas'] = array(
    '=0' => array('PUN' => 0, 'DESC' => 'Default'),
    '<40' => array('PUN' => 1, 'DESC' => 'Menor que 40 y mayor a 1'),
    '>40' => array('PUN' => 2, 'DESC' => 'Mayor o igual a 40 y menor a 80'),
    '>80' => array('PUN' => 3, 'DESC' => 'Mayor o igual a 80 y menor a 10'),
    '>120' => array('PUN' => 6, 'DESC' => 'Mayor o igual a 120')
);

/* ES_NULO
  SI
  NO
  SIEMPRE
  CASI_SIEMPRE
  ALGUNAS_VECES
  CASI_NUNCA
  NUNCA
  RESPUESTA_ABIERTA
  No aplica
  Si
  No
  Siempre
  Casi siempre
  Algunas veces
  Casi nunca
  Nunca
  Respuesta abierta

 *//*    # ROLES

  - COORDINADOR_CURSO
  - COORDINADOR_TUTORES
  - TUTOR_TITULAR
  - TUTOR_ADJUNTO

 */

$config['rol_orden'] = array(1 => 'A', 2 => 'TT', 3 => 'TA', 4 => 'CT', 5 => 'CC', 6 => 'CN');
$config['ENCUESTAS_RESPUESTAS_PREGUNTA'] = array(
    1 => array(//SI_NO
        array('texto' => 'Si', 'ponderacion' => 1),
        array('texto' => 'No', 'ponderacion' => 0)
    ),
    2 => array(//NULO_SI_NO
        array('texto' => 'No aplica', 'ponderacion' => 0),
        array('texto' => 'Si', 'ponderacion' => 1),
        array('texto' => 'No', 'ponderacion' => 0)
    ),
    3 => array(//SIEMPRE_NUNCA
        array('texto' => 'Siempre', 'ponderacion' => 1),
        array('texto' => 'Casi siempre', 'ponderacion' => 1),
        array('texto' => 'Algunas veces', 'ponderacion' => 1),
        array('texto' => 'Casi nunca', 'ponderacion' => 0),
        array('texto' => 'Nunca', 'ponderacion' => 0)
    ),
    4 => array(//NULO_SIEMPRE_NUNCA
        array('texto' => 'No aplica', 'ponderacion' => 0),
        array('texto' => 'Siempre', 'ponderacion' => 1),
        array('texto' => 'Casi siempre', 'ponderacion' => 1),
        array('texto' => 'Algunas veces', 'ponderacion' => 1),
        array('texto' => 'Casi nunca', 'ponderacion' => 0),
        array('texto' => 'Nunca', 'ponderacion' => 0)
    ),
    5 => array(), //RESPUESTA_ABIERTA
    6 => array(//NULO_RESPUESTA_ABIERTA
        array('texto' => 'No aplica', 'ponderacion' => 0)
    ),
    7 => array(), //RESPUESTA_INDEFINIDA
    8 => array(//NOENVIOMSG_SI_NO
        array('texto' => 'No envió mensaje', 'ponderacion' => 0),
        array('texto' => 'Si', 'ponderacion' => 1),
        array('texto' => 'No', 'ponderacion' => 0)
    ),
);

//Liga sied productivo
$config['url_sied'] = 'http://innovaedu.imss.gob.mx/sied';
$config['url_sied_logout'] = 'http://innovaedu.imss.gob.mx/sied/app/login';
$config['url_moodle_logout'] = 'http://innovaedu.imss.gob.mx/educacionadistancia/login/index.php';
/*
//$config['url_moodle'] = 'http://11.32.41.13/kio_des/educacionadistancia_kio/';
//$config['url_sied'] = 'http://11.32.41.13/kio_des/sied';
//$config['url_sied_logout'] = 'http://11.32.41.13/kio_des/sied/app/login';
//$config['url_moodle_logout'] = 'http://11.32.41.13/kio_des/educacionadistancia_kio/login/index.php';
$config['url_moodle'] = 'http://11.32.41.13/moodle_3_3_3/';
// $config['url_sied'] = 'http://11.32.41.13/kio_des/sied';
// $config['url_sied_logout'] = 'http://11.32.41.13/kio_des/sied/app/login';
$config['url_sied'] = 'http://11.32.41.13/moodle_3_3_3/login/index.php';
$config['url_sied_logout'] = 'http://11.32.41.13/moodle_3_3_3/login/index.php';
$config['url_moodle_logout'] = 'http://11.32.41.13/moodle_3_3_3/login/index.php';
*/

$config['TIPO_INSTRUMENTO'] = array(
    'DESEMPENIO' => 1,
    'SATISFACCION' => 2
);

$config['TIPO_INSTRUMENTOV'] = array(
    1 => 'Desempeño',
    2 => 'Satisfacción'
);


$config['EVA_TIPO'] = array(
    'POR_GRUPO' => array('valor' => 1, 'text' => 'Por grupo'),
    'POR_BLOQUE' => array('valor' => 2, 'text' => 'Por bloque'),
    'POR_USUARIO' => array('valor' => 3, 'text' => 'Por usuario'),
);


$config['prop_roles'] = array(
    En_roles::ALUMNO => array(//5
        'rol_nom' => 'Alumno',
        'ab' => 'A'
    ),
    En_roles::COORDINADOR_DE_CURSO => array(//14
        'rol_nom' => 'Coordinador de Curso',
        'ab' => 'CC'
    ),
    En_roles::COORDINADOR_DE_TUTORES => array(//18
        'rol_nom' => 'Coordinador de Tutores',
        'ab' => 'CT'
    ),
    En_roles::COORDINADOR_NORMATIVO => array(//30
        'rol_nom' => 'Coordinador Normativo',
        'ab' => 'CN'
    ),
    En_roles::TUTOR_TITULAR => array(//32
        'rol_nom' => 'Tutor Titular',
        'ab' => 'TT'
    ),
    En_roles::TUTOR_ADJUNTO => array(//33
        'rol_nom' => 'Tutor Adjunto',
        'ab' => 'TA'
    )
);

$config['ELEMENTOS_CSV_V2'] = array(
    'NOMBRE_INSTRUMENTO',
    'FOLIO_INSTRUMENTO',
    'ROL_A_EVALUAR',
    'ROL_EVALUADOR',
    'TUTORIZADO',
    'TIPO_INSTRUMENTO',
    'EVA_TIPO'
);
