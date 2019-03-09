<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//pr($lista_unidades);
?>
<div class="col-sm-12 col-md-12 col-lg-12 text-danger text-left">Las celdas marcadas con * indican que esos datos derivan de una autoevaluación.</div>
<div id="div_tabla_reporte_general_encuestas table-responsive" style="overflow-x: auto; width: 1200px;">
    <!--Mostrará la tabla de actividad docente -->
    <table class="table table-striped table-hover table-bordered " id="tabla_reporte_gral_encuestas">
        <thead>
            <tr class="bg-info">
                <th>Encuesta</th>
                <th>Tipo encuesta</th>
                <th>Aplica para bono</th>
                <th>Es tutorizado</th>
                <th>Curso</th>
                <th>Tipo de curso</th>                
                <th>Año</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
                <th>Bloque</th>
                <th>CT</th>
                <th>Regla evaluación</th>
                <th>Matrícula evaluado</th>
                <th>Nombre evaluado</th>
                <th>Rol evaluado</th>
                <th>Grupo evaluado</th>
                <th>Región evaluado</th>
                <th>Delegación evaluado</th>
                <th>Unidad evaluado</th>
                <th>Categoría evaluado</th>
                <th>Matrícula evaluador</th>
                <th>Nombre evaluador</th>
                <th>Rol evaluador</th>
                <th>Grupo evaluador</th>
                <th>Región evaluador</th>
                <th>Delegación evaluador</th>
                <th>Categoría evaluador</th>
                <!--<th>Adscripción evaluador</th>
                <th>Categoría evaluador</th> -->
                <?php //pr($preguntas); 
                if(!empty($preguntas)){
                    foreach ($preguntas as $key_p => $pregunta) {
                        $abierta = ($pregunta['is_abierta']==1) ? 'Abierta.' : '';
                        $bono = ($pregunta['is_bono']==1) ? 'Aplica para bono.' : '';
                        
                        echo '<th>'.$pregunta['orden'].') '.$pregunta['pregunta'].' <span style="color:blue; font-size:.75rem">'.$abierta.'</span> <span style="color:red; font-size:.75rem">'.$bono.'</span></th>';
                    }
                } ?>
                <th>Porcentaje de evaluador</th>
            </tr>
        </thead>
        <tbody>
            <?php //pr($datos); 
            //pr($respuestas);
            if(!empty($respuestas)){
                foreach ($datos as $key_d => $dato) {
                    //$depto_evaluado = ((!empty($dato['depto_tut_nombre'])) ? $dato['depto_tut_nombre'] : $dato['depto_user_nombre']);
                    //$depto_rama_evaluado = ((!empty($dato['rama_tut_evaluador'])) ? $dato['rama_tut_evaluador'] : $dato['rama_uder_evaluador']);
                    if(isset($dato['rama_tut_evaluado']) && !empty($dato['rama_tut_evaluado'])){
                        $rama_evaluado = explode(":", $dato['rama_tut_evaluado']);
                        $r_evaluado = $rama_evaluado[1].' ('.$rama_evaluado[0].')';
                        //pr($a_depto_rama_evaluado);
                        //$rama_evaluado = (isset($a_depto_rama_evaluado[2])) ? explode("&", $a_depto_rama_evaluado[2]) : array('');
                    } else {
                        $rama_evaluado = array('','');
                        $r_evaluado = '';
                    }
                    $rama = (isset($dato['rama_tut_evaluador']) && !empty($dato['rama_tut_evaluador'])) ? $dato['rama_tut_evaluador'] : ((isset($dato['rama_pre_evaluador']) && !empty($dato['rama_pre_evaluador'])) ? $dato['rama_pre_evaluador'] : '' );
                    if($rama != ''){
                        $a_depto_rama_evaluador = explode(":", $rama);
                        //pr($a_depto_rama_evaluado);
                        $rama_evaluador = (isset($a_depto_rama_evaluador[2])) ? explode("&", $a_depto_rama_evaluador[2]) : array('');
                    } else {
                        $rama_evaluador[0] = '';
                    }
                    //$grupo_nombre = (!empty($dato['grupo_nombre'])) ? str_replace("\",\"", ', ', trim($dato['grupo_nombre'], '{"}')) : '';
                    $grupo_nombre = (!empty($dato['grupo_nombre'])) ? implode(str_getcsv(trim($dato['grupo_nombre'], '{}')), ', ') :  ((!empty($dato['grupo_nombre1'])) ? $dato['grupo_nombre1'] : '');
                    $grupo_nombre_evaluado = (!empty($dato['grupo_evaluado'])) ? implode(str_getcsv(trim($dato['grupo_evaluado'], '{}')), ', ') : '';
                    $ct_bloque = (!empty($dato['ct_bloque'])) ? implode(str_getcsv(trim($dato['ct_bloque'], '{}')), ', ') : '';
                    //En caso de autoevaluaciones
                    if(isset($dato['autoeva_user_cve']) && !empty($dato['autoeva_user_cve'])){
                        $dato['evaluador_matricula'] = '<span class="text-danger">*</span> '.$dato['autoeva_username'];
                        $dato['evaluador_nombre'] = '<span class="text-danger">*</span> '.$dato['autoeva_nombre'];
                        $dato['evaluador_apellido'] = $dato['autoeva_apellido'];
                        $dato['evaluador_rol_nombre'] = '<span class="text-danger">*</span> '.$dato['autoeva_rol_nombre'];
                    }
                    echo '<tr>
                            <td>'.$dato['descripcion_encuestas'].'</td>
                            <td>'.($this->config->item('TIPO_INSTRUMENTOV')[$dato['tipo_encuesta']]).'</td>
                            <td>'.(($dato['is_bono']==1) ? 'Bonos' : ' - ').'</td>
                            <td>'.$dato['tex_tutorizado'].'</td>
                            <td>'.$dato['namec'].' ('.$dato['curso_clave'].')</td>
                            <td>'.$dato['tipo_curso'].'</td>
                            <td>'.$dato['anio'].'</td>
                            <td>'.$dato['fecha_inicio'].'</td>
                            <td>'.$dato['fecha_fin'].'</td>
                            <td>'.$dato['bloque'].'</td>
                            <td>'.$ct_bloque.'</td>
                            <td>'.$dato['evaluador_rol_nombre'].' a '.$dato['evaluado_rol_nombre'].' - '.$dato['tex_tutorizado'].'</td>
                            <td>'.$dato['evaluado_matricula'].'</td>
                            <td>'.$dato['evaluado_nombre'].' '.$dato['evaluado_apellido'].'</td>
                            <td>'.$dato['evaluado_rol_nombre'].'</td>
                            <td>'.$grupo_nombre_evaluado.'</td>
                            <td>'.$dato['reg_tut_nombre'].'</td>
                            <td>'.((!empty($dato['depto_tut_nom_del'])) ? $dato['depto_tut_nom_del'] : '').'</td>
                            <td>'.$r_evaluado.'</td>
                            <td>'.((!empty($dato['evaluado_cat_tut_nom'])) ? $dato['evaluado_cat_tut_nom'] : '').'</td>
                            <td>'.$dato['evaluador_matricula'].'</td>
                            <td>'.$dato['evaluador_nombre'].' '.$dato['evaluador_apellido'].'</td>
                            <td>'.$dato['evaluador_rol_nombre'].'</td>
                            <td>'.$grupo_nombre.'</td>';
                    if(isset($dato['autoeva_user_cve']) && !empty($dato['autoeva_user_cve'])){ //En caso de autoevaluación
                        echo '<td><span class="text-danger">*</span> '.((!empty($dato['autoeva_name_region'])) ? $dato['autoeva_name_region'] : '').'</td>
                            <td><span class="text-danger">*</span> '.((!empty($dato['autoeva_nom_delegacion'])) ? $dato['autoeva_nom_delegacion'] : '').'</td>
                            <td><span class="text-danger">*</span> '.((!empty($dato['autoeva_cat_nombre'])) ? $dato['autoeva_cat_nombre'] : '').'</td>';
                    } else {
                        if($dato['evaluador_rol_id']==$this->config->item('ENCUESTAS_ROL_EVALUADOR')['ALUMNO']){ //En caso de ser alumno
                            echo '<td>'.((!empty($dato['reg_pre_eva_nombre'])) ? $dato['reg_pre_eva_nombre'] : '').'</td>
                                <td>'.((!empty($dato['depto_e_pre_nom_del'])) ? $dato['depto_e_pre_nom_del'] : '').'</td>
                                <td>'.((!empty($dato['evaluador_cat_pre_nom'])) ? $dato['evaluador_cat_pre_nom'] : '').'</td>';
                            /*echo '<td>'.((!empty($dato['depto_e_pre_nombre'])) ? $dato['depto_e_pre_nombre'] : '').'</td>';*/
                        } else { //En caso de ser un tutor
                            echo '<td>'.((!empty($dato['reg_tut_eva_nombre'])) ? $dato['reg_tut_eva_nombre'] : '').'</td>
                                <td>'.((!empty($dato['depto_e_tut_nom_del'])) ? $dato['depto_e_tut_nom_del'] : '').'</td>
                                <td>'.((!empty($dato['evaluador_cat_tut_nom'])) ? $dato['evaluador_cat_tut_nom'] : '').'</td>';
                            /*echo '<td>'.((!empty($dato['depto_e_tut_nombre'])) ? $dato['depto_e_tut_nombre'] : '').'</td>';*/
                        }
                    }
                    foreach ($preguntas as $key_p => $pregunta) {
                        //echo '<td>'.$respuestas[$dato['course_cve']][$dato['group_id']][$dato['encuesta_cve']][$dato['evaluado_user_cve']][$dato['evaluador_user_cve']][$pregunta['preguntas_cve']]['texto'].'</td>';
                        //if(isset($dato['course_cve']) && isset($dato['group_id']) && isset($dato['encuesta_cve']) && isset($dato['evaluado_user_cve']) && isset($dato['evaluador_user_cve']) && isset($pregunta['preguntas_cve'])) {
                        /*if($key_p==39){
                            pr($pregunta);
                            pr($respuestas[$dato['course_cve']][$dato['grupos_ids_text']][$dato['encuesta_cve']][$dato['evaluado_user_cve']][$dato['evaluador_user_cve']]);
                        }*/
                        if(isset($respuestas[$dato['course_cve']][$dato['grupos_ids_text']][$dato['encuesta_cve']][$dato['evaluado_user_cve']][$dato['evaluador_user_cve']][$pregunta['preguntas_cve']])) {
                            if($pregunta['is_abierta']==1){
                                echo '<td>'.$respuestas[$dato['course_cve']][$dato['grupos_ids_text']][$dato['encuesta_cve']][$dato['evaluado_user_cve']][$dato['evaluador_user_cve']][$pregunta['preguntas_cve']]['respuesta_abierta'].'</td>';
                            } else {
                                echo '<td>'.$respuestas[$dato['course_cve']][$dato['grupos_ids_text']][$dato['encuesta_cve']][$dato['evaluado_user_cve']][$dato['evaluador_user_cve']][$pregunta['preguntas_cve']]['texto'].'</td>';
                            }
                        } else {
                            echo '<td></td>';
                        }
                        //':'.$dato['course_cve'].'-'.$dato['group_id'].'-'.$dato['encuesta_cve'].'-'.$dato['evaluado_user_cve'].'-'.$dato['evaluador_user_cve'].'-'.$dato['preguntas_cve'].
                    }
                    echo '<td>'.$dato['calif_emitida'].' %</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="21">No existen registros relacionados con esos parámetros de búsqueda.</td></tr>';
            } ?>
        </tbody>
    </table>
</div>
<div class="col-sm-12 col-md-12 col-lg-12 text-danger text-left">Las celdas marcadas con * indican que esos datos derivan de una autoevaluación.</div>
