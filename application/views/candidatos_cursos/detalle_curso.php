<div class="col-lg-12 col-sm-12 col-md-12 custom-file control_cursos_registro">
    <h4 class="text-justify"><?php echo $datos_cursos_registro['nombre_curso'] . " - " . $datos_cursos_registro['tutorizado']; ?></h4>
    <span class="text-justify"><b>Clave del curso:</b> <?php echo $datos_cursos_registro['clave_curso']; ?></span>
    <span class="text-justify"><b>Identificador del curso:</b> <?php echo $datos_cursos_registro['course_id']; ?></span>
    <span class="text-justify"><b>Cuota del curso:</b> <?php echo $datos_cursos_registro['cuota']; ?></span><br>
    <?php if ($datos_cursos_registro['estado'] == 'tp') { ?>
        <u>
            <span class="text-justify"><b>Fecha inicio de preregistro:</b> <?php echo $datos_cursos_registro['inicio_preregistro']; ?></span>
            <span class="text-justify"><b>Fecha fin de preregistro:</b> <?php echo $datos_cursos_registro['fin_preregistro']; ?></span>
        </u>
        <span class="text-justify"><b>Fecha inicio de curso:</b> <?php echo $datos_cursos_registro['inicio_curso']; ?></span>
    <?php } else { ?>
        <span class="text-justify"><b>Fecha inicio de preregistro:</b> <?php echo $datos_cursos_registro['inicio_preregistro']; ?></span>
        <u>
            <span class="text-justify"><b>Fecha fin de preregistro:</b> <?php echo $datos_cursos_registro['fin_preregistro']; ?></span>
            <span class="text-justify"><b>Fecha inicio de curso:</b> <?php echo $datos_cursos_registro['inicio_curso']; ?></span>
        </u>
    <?php } ?>
</div>
<br>