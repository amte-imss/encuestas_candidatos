<?php

if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

$config = array(
    'edit_pregunta' => array(
        array(
            'field' => 'seccion_cve',
            'label' => 'Sección pregunta',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'pregunta',
            'label' => 'Pregunta',
            'rules' => 'required|max_length[500]|alpha_numeric_accent_space_dot_double_quot' //se cambia de 250 a 500 caracteres

        ),
        array(
            'field' => 'is_bono',
            'label' => 'Aplica para bono',
            'rules' => 'numeric'
        ),
        array(
            'field' => 'obligada',
            'label' => 'Obligada',
            'rules' => 'numeric'
        ),
        array(
            'field' => 'no_obligatoria',
            'label' => 'Respuesta nula',
            'rules' => 'numeric'
        ),
        array(
            'field' => 'tipo_pregunta',
            'label' => 'Tipo respuesta',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'tiene_pregunta_padre',
            'label' => 'Tiene pregunta padre',
            'rules' => 'numeric'
        ),
    ),
    'pregunta_instrumento' => array(
        array(
            'field' => 'NOMBRE_INSTRUMENTO',
            'label' => 'NOMBRE_INSTRUMENTO',
            'rules' => 'required|alpha_numeric_accent_space_dot_double_quot'
        ),
        array(
            'field' => 'FOLIO_INSTRUMENTO',
            'label' => 'FOLIO_INSTRUMENTO',
            'rules' => 'required|alpha_numeric_accent_space_dot_double_quot|max_length[20]'
        ),
        array(
            'field' => 'ROL_A_EVALUAR',
            'label' => 'ROL_A_EVALUAR',
            'rules' => 'required|in_list[COORDINADOR_NORMATIVO,COORDINADOR_CURSO,COORDINADOR_TUTORES,TUTOR_TITULAR,TUTOR_ADJUNTO]'
        ),
        array(
            'field' => 'ROL_EVALUADOR',
            'label' => 'ROL_EVALUADOR',
            'rules' => 'required|in_list[COORDINADOR_CURSO,COORDINADOR_TUTORES,TUTOR_TITULAR,TUTOR_ADJUNTO,ALUMNO,COORDINADOR_NORMATIVO]'
        ),
        array(
            'field' => 'TUTORIZADO',
            'label' => 'TUTORIZADO',
            'rules' => 'in_list[SI,NO,Si,No,si,no]'
        ),
        array(
            'field' => 'NOMBRE_SECCION',
            'label' => 'NOMBRE_SECCION',
            'rules' => 'required|alpha_numeric_accent_space_dot_double_quot'
        ),

        array(
            'field' => 'NOMBRE_INDICADOR',
            'label' => 'NOMBRE_INDICADOR',
            'rules' => 'required|alpha_numeric_accent_space_dot_double_quot'
        ),
        array(
            'field' => 'NO_PREGUNTA',
            'label' => 'NO_PREGUNTA',
            'rules' => 'required|integer|greater_than[0]|is_natural'
        ),
        array(
            'field' => 'PREGUNTA_PADRE',
            'label' => 'PREGUNTA_PADRE',
            'rules' => 'integer|greater_than[0]|is_natural'
        ),
        array(
            'field' => 'RESPUESTA_ESPERADA',
            'label' => 'RESPUESTA_ESPERADA',
            'rules' => 'in_list[NO_APLICA,SI,NO,SIEMPRE,CASI_SIEMPRE,ALGUNAS_VECES,CASI_NUNCA,NUNCA,RESPUESTA_ABIERTA]'
        ),
        array(
            'field' => 'PREGUNTA_BONO',
            'label' => 'PREGUNTA_BONO',
            'rules' => 'in_list[SI,NO,Si,No,si,no]|alpha'
        ),
        array(
            'field' => 'OBLIGADA',
            'label' => 'OBLIGADA',
            'rules' => 'in_list[SI,NO,Si,No,si,no]|alpha'
        ),
        array(
            'field' => 'PREGUNTA',
            'label' => 'PREGUNTA',
            'rules' => 'required|alpha_numeric_accent_space_dot_double_quot'
        ),
        array(
            'field' => 'NO_APLICA',
            'label' => 'NO_APLICA',
            'rules' => 'in_list[SI,NO,Si,No,si,no]|alpha'
        ),
        array(
            'field' => 'VALIDO_NO_APLICA',
            'label' => 'VALIDO_NO_APLICA',
            'rules' => 'in_list[SI,NO,Si,No,si,no]|alpha'
        ),

        array(
            'field' => 'NO_ENVIO_MENSAJE',
            'label' => 'NO_ENVIO_MENSAJE',
            'rules' => 'in_list[SI,NO,Si,No,si,no]|alpha'
        ),
        array(
            'field' => 'SI',
            'label' => 'SI',
            'rules' => 'in_list[SI,NO,Si,No,si,no]|alpha'
        ),
        array(
            'field' => 'NO',
            'label' => 'NO',
            'rules' => 'in_list[SI,NO,Si,No,si,no]|alpha'
        ),
        array(
            'field' => 'SIEMPRE',
            'label' => 'SIEMPRE',
            'rules' => 'in_list[SI,NO,Si,No,si,no]|alpha'
        ),
        array(
            'field' => 'CASI_SIEMPRE',
            'label' => 'CASI_SIEMPRE',
            'rules' => 'in_list[SI,NO,Si,No,si,no]|alpha'
        ),
        array(
            'field' => 'ALGUNAS_VECES',
            'label' => 'ALGUNAS_VECES',
            'rules' => 'in_list[SI,NO,Si,No,si,no]|alpha'
        ),
        array(
            'field' => 'CASI_NUNCA',
            'label' => 'CASI_NUNCA',
            'rules' => 'in_list[SI,NO,Si,No,si,no]|alpha'
        ),
        array(
            'field' => 'NUNCA',
            'label' => 'NUNCA',
            'rules' => 'in_list[SI,NO,Si,No,si,no]|alpha'
        ),
        array(
            'field' => 'RESPUESTA_ABIERTA',
            'label' => 'RESPUESTA_ABIERTA',
            'rules' => 'in_list[SI,NO,Si,No,si,no]|alpha'
        ),
        array(
            'field' => 'TIPO_INSTRUMENTO',
            'label' => 'TIPO_INSTRUMENTO',
            'rules' => 'required|in_list[DESEMPENIO,SATISFACCION]'
        ),
        array(
            'field' => 'EVA_TIPO',
            'label' => 'EVA_TIPO',
            'rules' => 'required|in_list[POR_BLOQUE,POR_GRUPO,POR_USUARIO]'
        ),

    ),
    'edita_instrumento' => array(
        array(
            'field' => 'is_bono',
            'label' => 'Aplica para bono',
            'rules' => 'numeric|greater_than[0]|max_length[1]'
        ),
        array(
            'field' => 'status',
            'label' => 'Activo',
            'rules' => 'numeric|greater_than[0]|max_length[1]' //|callback_valid_pass
        ),
        array(
            'field' => 'descripcion_encuestas',
            'label' => 'Nombre instrumento',
            'rules' => 'required|alpha_numeric_accent_space_dot_double_quot'
        ), //cve_corta_encuesta
        array(
            'field' => 'cve_corta_encuesta',
            'label' => 'Folio instrumento',
            'rules' => 'required|alpha_numeric_accent_space_dot_double_quot|max_length[20]'
        ),
        array(
            'field' => 'regla_evaluacion_cve',
            'label' => 'Regla evaluación',
            'rules' => 'required|numeric'
        ),
    ),
    'nueva_pregunta' => array(
        array(
            'field' => 'is_bono',
            'label' => 'Aplica para bono',
            'rules' => 'numeric|greater_than[0]|max_length[1]'
        ),
        array(
            'field' => 'obligada',
            'label' => 'Activo',
            'rules' => 'numeric|greater_than[0]|max_length[1]' //|callback_valid_pass
        ),
        array(
            'field' => 'no_obligatoria',
            'label' => 'No aplica',
            'rules' => 'numeric|max_length[1]'
        ), //cve_corta_encuesta
        array(
            'field' => 'tipo_pregunta',
            'label' => 'Tipo pregunta',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'seccion_cve',
            'label' => 'Sección',
            'rules' => 'required|numeric|greater_than[0]'
        ),
        array(
            'field' => 'pregunta',
            'label' => 'Pregunta',
            'rules' => 'required|alpha_numeric_accent_space_dot_double_quot'

        ),
    ),
    'inicio_sesion' => array(
        array(
            'field' => 'matricula',
            'label' => 'Matrícula',
            'rules' => 'required|max_length[18]|alpha_dash'
        ),
        array(
            'field' => 'passwd',
            'label' => 'Contraseña',
            'rules' => 'required' //|callback_valid_pass
        ),
        array(
            'field' => 'userCaptcha',
            'label' => 'C&oacute;digo de seguridad',
            'rules' => 'required|check_captcha'
        ),
    ),

);

/*
                            ES_NULO
                            SI
                            NO
                            SIEMPRE
                            CASI_SIEMPRE
                            ALGUNAS_VECES
                            CASI_NUNCA
                            NUNCA
                            RESPUESTA_ABIERTA
                            
                            ES_NULO,SI,NO,SIEMPRE,CASI_SIEMPRE,ALGUNAS_VECES,CASI_NUNCA,NUNCA,RESPUESTA_ABIERTA

                            COORDINADOR_CURSO,COORDINADOR_TUTORES,TUTOR_TITULAR,TUTOR_ADJUNTO

*/

/*
                NOMBRE_INSTRUMENTO
                INSTRUMENTO_ROL_ASIGNADO
                INSTRUMENTO_CURSO_TUTORIZADO
                NOMBRE_SECCION
                NO_PREGUNTA
                PREGUNTA_PADRE
                RESPUESTA_ESPERADA
                PREGUNTA_BONO
                OBLIGADA
                PREGUNTA
                ES_NULO
                SI
                NO
                SIEMPRE
                CASI_SIEMPRE
                ALGUNAS_VECES
                CASI_NUNCA
                NUNCA
                RESPUESTA_ABIERTA
                */


// VALIDACIONES
/*
             * isset
             * valid_email
             * valid_url
             * min_length
             * max_length
             * exact_length
             * alpha
             * alpha_numeric
             * alpha_numeric_spaces
             * alpha_dash
             * numeric
             * is_numeric
             * integer
             * regex_match
             * matches
             * differs
             * is_unique
             * is_natural
             * is_natural_no_zero
             * decimal
             * less_than
             * less_than_equal_to
             * greater_than
             * greater_than_equal_to
             * in_list
             *
             */


//custom validation

/*

alpha_accent_space_dot_quot
 *
alpha_numeric_accent_slash
 *
alpha_numeric_accent_space_dot_parent
 *
alpha_numeric_accent_space_dot_double_quot

*/

/*
*password_strong
*
*
*
*
*/
