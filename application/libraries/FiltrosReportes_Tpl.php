<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene métodos para la carga de la plantilla base del sistema y creación de la paginación
 * @version 	: 1.1.0
 * @author 		: Jesús Díaz P.
 * @author      : Miguel Guagnelli
 * @property    : mixed[] Data arreglo de datos de plantilla con la siguisnte estructura array("title"=>null,"nav"=>null,"main_title"=>null,"main_content"=>null);
 * */
class FiltrosReportes_Tpl extends Template {

    private $tipo_reporte;
    private $config_vistas_reportes;
    private $data_post;

    const __default = 0,
            RB_RESUMEN_PUNTOS = 1,
            RB_IMPLEMENTACION = 2,
            RB_ENCUESTAS_DETALLE = 3,
            RE_INDICADORES = 4,
            RE_CONTESTADAS_NO_CONTESTADAS_PROMEDIO = 5,
            RE_MATRIZ_BLOQUES_CURSO = 6,
            RB_GENERAL = 7,
            C_VIEW_FILTRO = 'viewFiltro',
            C_VIEW_RESULT = 'viewResult',
            C_CONTROL_FILTRO = 'controlFiltro',
            C_CONTROL_RESULT = 'array_datos',
            C_GRUPO_DATOS_ARRAY = 'array_datos',
            C_URL_CONTROL = 'url_control',
            C_TITULO = 'titulo',
            C_SUBTITULO = 'subtitulo',
            C_NAME_FORMULARIO = 'formulario',
            C_NAME_DIV_RESULTADO = 'div_resultados',
            C_LINK_EXPORTAR = 'exportar'

    ;

    public function __construct() {
        $this->CI = & get_instance();
        parent::__construct(); //Inicializa la clase padre
        //        if(func_num_args()==1){
        //            $arg = fun_get_arg(0);
        //            pr('hola 2vces ');
        //        }
        $this->inicializa(); //Inicializa variables generales
    }

    /**
     * Asigna las vistas por default de reportes
     */
    function inicializa() {
        $this->CI->load->model('Reporte_model', 'rep_mod'); // modelo de reporte
        $this->tipo_reporte = FiltrosReportes_Tpl::__default;
        $this->data_post = NULL;
        $this->config_vistas_reportes = array(//Inicializa los valores de vistas pata reportes, vistas de filtros y resultaados
            FiltrosReportes_Tpl::RB_RESUMEN_PUNTOS => array(
                FiltrosReportes_Tpl::C_VIEW_FILTRO => 'reporte/resumen_bonos/docentes',
                FiltrosReportes_Tpl::C_VIEW_RESULT => 'reporte/',
                FiltrosReportes_Tpl::C_CONTROL_FILTRO => 'reporte/index',
                FiltrosReportes_Tpl::C_CONTROL_RESULT => 'reporte/get_data_ajax2',
                FiltrosReportes_Tpl::C_GRUPO_DATOS_ARRAY => array(Reporte_model::GF_EVALUADO_P),
                FiltrosReportes_Tpl::C_TITULO => 'Resumen de bonos',
                FiltrosReportes_Tpl::C_SUBTITULO => '', //'Listado de encuestas',
                FiltrosReportes_Tpl::C_URL_CONTROL => "site_url+'/reporte/get_data_ajax2', '#form_curso', '#listado_resultado_empleado'",
                FiltrosReportes_Tpl::C_NAME_FORMULARIO => "#form_curso",
                FiltrosReportes_Tpl::C_NAME_DIV_RESULTADO => "#listado_resultado_empleado",
                FiltrosReportes_Tpl::C_LINK_EXPORTAR => "reporte/exportar_datos",
            ),
            FiltrosReportes_Tpl::RB_IMPLEMENTACION => array(
                FiltrosReportes_Tpl::C_VIEW_FILTRO => 'reporte/bonos/bonos',
                FiltrosReportes_Tpl::C_VIEW_RESULT => 'reporte/bonos/tb_result_bnos',
                FiltrosReportes_Tpl::C_CONTROL_FILTRO => 'reporte_bonos/index',
                FiltrosReportes_Tpl::C_CONTROL_RESULT => '',
//                FiltrosReportes_Tpl::C_GRUPO_DATOS_ARRAY => array(Reporte_model::GF_CURSO, Reporte_model::GF_ENCUESTA_IMP, Reporte_model::GF_EVALUADO_IMP, Reporte_model::GF_GENERAL),
                FiltrosReportes_Tpl::C_GRUPO_DATOS_ARRAY => array(Reporte_model::GF_CURSO, Reporte_model::GF_EVALUADO_IMP, Reporte_model::GF_GENERAL),
                FiltrosReportes_Tpl::C_TITULO => 'Reporte de implementación',
                FiltrosReportes_Tpl::C_SUBTITULO => '', //'Listado de cursos-encuestas',
                FiltrosReportes_Tpl::C_URL_CONTROL => "site_url+'/reporte_bonos/get_buscar_cursos_encuestas', '#form_curso', '#listado_resultado_empleado'",
                FiltrosReportes_Tpl::C_NAME_FORMULARIO => "#form_curso",
                FiltrosReportes_Tpl::C_NAME_DIV_RESULTADO => "#listado_resultado_empleado",
                FiltrosReportes_Tpl::C_LINK_EXPORTAR => "reporte_bonos/exportar_implementacion",
            ),
            FiltrosReportes_Tpl::RE_CONTESTADAS_NO_CONTESTADAS_PROMEDIO => array(
                FiltrosReportes_Tpl::C_VIEW_FILTRO => 'curso/cur_enc_resultado',
                FiltrosReportes_Tpl::C_VIEW_RESULT => 'reporte/',
                FiltrosReportes_Tpl::C_CONTROL_FILTRO => 'resultadocursoencuesta/curso_encuesta_resultado/',
                FiltrosReportes_Tpl::C_CONTROL_RESULT => '',
                FiltrosReportes_Tpl::C_GRUPO_DATOS_ARRAY => array(Reporte_model::GF_ENCUESTA_CONTESTADAS),
//                FiltrosReportes_Tpl::C_GRUPO_DATOS_ARRAY => array(Reporte_model::GF_ENCUESTA_CONTESTADAS, Reporte_model::GF_EVALUADO_IMP, Reporte_model::GF_EVALUADOR_CONTESTADAS),
//                FiltrosReportes_Tpl::C_GRUPO_DATOS_ARRAY => array(),
                FiltrosReportes_Tpl::C_TITULO => 'Encuestas contestadas',
                FiltrosReportes_Tpl::C_SUBTITULO => 'Listado de encuestas realizadas por curso',
                FiltrosReportes_Tpl::C_URL_CONTROL => "site_url+'/resultadocursoencuesta/get_data_ajax', '#form_curso', '#listado_resultado'",
                FiltrosReportes_Tpl::C_NAME_FORMULARIO => "#form_curso",
                FiltrosReportes_Tpl::C_NAME_DIV_RESULTADO => "#listado_resultado",
                FiltrosReportes_Tpl::C_LINK_EXPORTAR => "resultadocursoencuesta/exportar_enc_contestadas/",
            ),
            FiltrosReportes_Tpl::RE_MATRIZ_BLOQUES_CURSO => array(
                FiltrosReportes_Tpl::C_TITULO => 'Reporte de bloques',
                FiltrosReportes_Tpl::C_VIEW_RESULT => 'reporte/',
                FiltrosReportes_Tpl::C_SUBTITULO => '',
                FiltrosReportes_Tpl::C_URL_CONTROL => "'reporte_matriz_bloques/get_data_ajax', '#form_curso', '#listado_resultado'",
                FiltrosReportes_Tpl::C_NAME_FORMULARIO => "#form_curso",
                FiltrosReportes_Tpl::C_NAME_DIV_RESULTADO => "#listado_resultado",
                FiltrosReportes_Tpl::C_VIEW_FILTRO => 'curso/filter_matriz_bloques',
                FiltrosReportes_Tpl::C_CONTROL_FILTRO => 'reporte_matriz_bloques/get_data_ajax',
                FiltrosReportes_Tpl::C_CONTROL_RESULT => '',
                FiltrosReportes_Tpl::C_GRUPO_DATOS_ARRAY => array(Reporte_model::GF_BLOQUES_CURSO),
                FiltrosReportes_Tpl::C_LINK_EXPORTAR => "reporte_matriz_bloques/export_by_curso/",
            ),
            FiltrosReportes_Tpl::RB_ENCUESTAS_DETALLE => array(
                FiltrosReportes_Tpl::C_VIEW_FILTRO => 'reporte/detalle/detalle',
                FiltrosReportes_Tpl::C_VIEW_RESULT => 'reporte/detalle/tb_result_detalle',
                FiltrosReportes_Tpl::C_CONTROL_FILTRO => 'reporte_detallado/index',
                FiltrosReportes_Tpl::C_CONTROL_RESULT => '',
                FiltrosReportes_Tpl::C_GRUPO_DATOS_ARRAY => array(Reporte_model::GF_CURSO_DETALLE, Reporte_model::GF_ENCUESTA_DETALLE, Reporte_model::GF_EVALUADO_DETALLE, Reporte_model::GF_EVALUADOR_DETALLE, Reporte_model::GF_GENERAL),
                FiltrosReportes_Tpl::C_TITULO => 'Reporte detallado',
                FiltrosReportes_Tpl::C_SUBTITULO => '',
                FiltrosReportes_Tpl::C_URL_CONTROL => "site_url+'/reporte_detallado/get_buscar_cursos_encuestas', '#form_curso', '#listado_resultado_empleado'",
                FiltrosReportes_Tpl::C_NAME_FORMULARIO => "",
                FiltrosReportes_Tpl::C_NAME_DIV_RESULTADO => "",
                FiltrosReportes_Tpl::C_LINK_EXPORTAR => "reporte_detalle/",
            ),
            FiltrosReportes_Tpl::RE_INDICADORES => array(
                FiltrosReportes_Tpl::C_VIEW_FILTRO => 'reporte/',
                FiltrosReportes_Tpl::C_VIEW_RESULT => 'reporte/',
                FiltrosReportes_Tpl::C_CONTROL_FILTRO => '',
                FiltrosReportes_Tpl::C_CONTROL_RESULT => '',
                FiltrosReportes_Tpl::C_GRUPO_DATOS_ARRAY => array(),
                FiltrosReportes_Tpl::C_TITULO => 'Reporte de indicadores',
                FiltrosReportes_Tpl::C_SUBTITULO => '',
                FiltrosReportes_Tpl::C_NAME_FORMULARIO => "",
                FiltrosReportes_Tpl::C_NAME_DIV_RESULTADO => "",
                FiltrosReportes_Tpl::C_LINK_EXPORTAR => "",
            ),
            FiltrosReportes_Tpl::RB_GENERAL => array(
                FiltrosReportes_Tpl::C_VIEW_FILTRO => '', //reporte/general/index
                FiltrosReportes_Tpl::C_VIEW_RESULT => '', //reporte/general/index_1
                FiltrosReportes_Tpl::C_CONTROL_FILTRO => '', //reporte_general/index
                FiltrosReportes_Tpl::C_CONTROL_RESULT => '',
                FiltrosReportes_Tpl::C_GRUPO_DATOS_ARRAY => array(Reporte_model::GF_CURSO, Reporte_model::GF_REPORTE_GENERAL),
                FiltrosReportes_Tpl::C_TITULO => 'Reporte general',
                FiltrosReportes_Tpl::C_SUBTITULO => '',
                FiltrosReportes_Tpl::C_URL_CONTROL => "site_url+'/reporte_general/get_reporte_general_datos', '#form_curso', '#listado_resultado'",
                FiltrosReportes_Tpl::C_NAME_FORMULARIO => "#form_curso",
                FiltrosReportes_Tpl::C_NAME_DIV_RESULTADO => "#listado_resultado",
                FiltrosReportes_Tpl::C_LINK_EXPORTAR => "reporte_general/exportar_reporte_general",
            ),
        );
    }

    function getNumEspaciosVistaGrupos($grupo_vista) {
        switch ($grupo_vista) {
            case Reporte_model::GF_EVALUADO: case Reporte_model::GF_EVALUADO_DETALLE: case Reporte_model::GF_EVALUADO_IMP:
                return 2;
            case Reporte_model::GF_EVALUADO_P: case Reporte_model::GF_EVALUADOR_CONTESTADAS:
                return 2;
            case Reporte_model::GF_BLOQUES_CURSO:
            case Reporte_model::GF_EVALUADOR: case Reporte_model::GF_EVALUADOR_DETALLE:
                return 2;
            default :
                return 1;
        }
    }

    function setArrayVistasReportes($tipo_reporte = FiltrosReportes_Tpl::__default, $array_view_filtro_resultados = array()) {
        if ($tipo_reporte == FiltrosReportes_Tpl::__default) {
            $this->config_vistas_reportes[$tipo_reporte] = $array_view_filtro_resultados;
        }
    }

    function getArrayVistasReportes($tipo_reporte = FiltrosReportes_Tpl::__default) {
        if ($tipo_reporte != FiltrosReportes_Tpl::__default and isset($this->config_vistas_reportes[$tipo_reporte])) {
            return $this->config_vistas_reportes[$tipo_reporte]; //Retorna el valor array de la vista pedido
        }
        return array();
    }

    function getAllArrayVistasReportes() {
        return $this->config_vistas_reportes;
    }

    function setTipoReporte($tipo_reporte) {
        $this->tipo_reporte = $tipo_reporte;
    }

    /* regresa en pantalla el contenido de la plantilla
     * @method: array getData()
     * @return: mixed[] Data arreglo de datos de plantilla con la siguisnte estructura array("title"=>null,"nav"=>null,"main_title"=>null,"main_content"=>null);
     */

    function getVista($tipo_reporte = FALSE) {
        if ($tipo_reporte != FiltrosReportes_Tpl::__default) {
            $prop = $this->getArrayVistasReportes($tipo_reporte);
            $grupos_filtro_vista = $prop[FiltrosReportes_Tpl::C_GRUPO_DATOS_ARRAY];
            //Carga datos del controlador
            $this->CI->load->model('Reporte_model', 'rep_mod'); // modelo de reporte
            //Obtiene datos de los filtros
            $data_info = $this->CI->rep_mod->get_filtros_grupo($grupos_filtro_vista); //Carga datos para ver en grupo
            $data_info['controlador'] = $prop[FiltrosReportes_Tpl::C_CONTROL_FILTRO];
            $data_info['url_control'] = $prop[FiltrosReportes_Tpl::C_URL_CONTROL];
            $data_info['subtitulo'] = $prop[FiltrosReportes_Tpl::C_SUBTITULO];
            $data['vistas'] = array(); //Carga datos para ver en grupo
//            pr($grupos_filtro_vista);
            foreach ($grupos_filtro_vista as $view) {
//                $r = $this->getNumEspaciosVistaGrupos($view);
//                pr($r);
                if ($this->getNumEspaciosVistaGrupos($view) == 2) {
                    $data['vistas_2'][] = $this->CI->load->view('reporte/vistas_grupos/' . $view, $data_info, true);
                } else {
                    $data['vistas'][] = $this->CI->load->view('reporte/vistas_grupos/' . $view, $data_info, true);
                }
            }
            $this->setTitle($prop[FiltrosReportes_Tpl::C_TITULO]);
            $main_contet = $this->CI->load->view('reporte/vistas_grupos/vista', $data, true);
            $this->setMainContent($main_contet);
        } else {
            $prop = $this->getArrayVistasReportes($this->tipo_reporte);
            $main_contet = $this->CI->load->view($prop[FiltrosReportes_Tpl::C_VIEW_FILTRO], $data, true);
            $this->setMainContent($main_contet);
        }
        $this->getTemplate();
    }

    function getCuerpo($tipo_reporte = FALSE, $data_extra = null, $condiciones = null) {
        if ($tipo_reporte != FiltrosReportes_Tpl::__default) {
            if (is_null($condiciones)) {
                $condiciones = array();
            }
            $prop = $this->getArrayVistasReportes($tipo_reporte);
            $grupos_filtro_vista = $prop[FiltrosReportes_Tpl::C_GRUPO_DATOS_ARRAY];
            //Carga datos del controlador
            $this->CI->load->model('Reporte_model', 'rep_mod'); // modelo de reporte
            //Obtiene datos de los filtros

            $data_info['controlador'] = $prop[FiltrosReportes_Tpl::C_CONTROL_FILTRO];
//            pr($data_info);
            $data_info['subtitulo'] = $prop[FiltrosReportes_Tpl::C_SUBTITULO];
            if (!is_null($data_extra) && (isset($data_extra['curso_url']) || isset($data_extra['texto_titulo']) || isset($data_extra['curso']))) {
                $data_info['url_control'] = $data_extra['curso_url'];
                $data_info['text_extra'] = $data_extra['texto_titulo'];
                $data_info['curso'] = $data_extra['curso'];
                if (isset($data_extra['tutorizado'])) {
                    $data_info['tutorizado'] = $data_extra['tutorizado'];
                    $condiciones['instrumento'] = array('tutorizado' => $data_extra['tutorizado']);
                }
            } else {
                $data_info['url_control'] = $prop[FiltrosReportes_Tpl::C_URL_CONTROL];
            }
            $data_info += $this->CI->rep_mod->get_filtros_grupo($grupos_filtro_vista, $condiciones); //Carga datos para ver en grupo

            $data['js'] = (isset($data_extra['js']) && !empty($data_extra['js'])) ? $data_extra['js'] : array('busquedas/busqueda.js');
//            pr($data_info);
            $data['vistas'] = array(); //Carga datos para ver en grupo
            $data['exportar'] = $prop[FiltrosReportes_Tpl::C_LINK_EXPORTAR]; //Carga datos para ver en grupo
            $data['formulario'] = $prop[FiltrosReportes_Tpl::C_NAME_FORMULARIO]; //Carga datos para ver en grupo
            if(isset($data_extra['info_extra']))
            {
                $data_info['info_extra'] = $data_extra['info_extra'];
            }
//            pr($grupos_filtro_vista);
            foreach ($grupos_filtro_vista as $view) {
//                $r = $this->getNumEspaciosVistaGrupos($view);
//                pr($r);
                if ($this->getNumEspaciosVistaGrupos($view) == 2) {//Ocuapa dos espacios o un espacio en la vista, column 12 para un espacio; column 6 para dos espacios
                    $data['vistas_2'][] = $this->CI->load->view('reporte/vistas_grupos/' . $view, $data_info, true);
                } else {
                    $data['vistas'][] = $this->CI->load->view('reporte/vistas_grupos/' . $view, $data_info, true);
                }
            }
            $this->setTitle($prop[FiltrosReportes_Tpl::C_TITULO]);
            $main_contet = $this->CI->load->view('reporte/vistas_grupos/vista', $data, true);
        } else {
            $prop = $this->getArrayVistasReportes($this->tipo_reporte);
            $main_contet = $this->CI->load->view($prop[FiltrosReportes_Tpl::C_VIEW_FILTRO], $data, true);
        }
        return $main_contet;
    }

}
