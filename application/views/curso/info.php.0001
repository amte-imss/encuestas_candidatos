<?php 

$this->config->load('general');
$tipo_msg = $this->config->item('alert_msg');

if(isset($curso) && !empty($curso) && $curso['total']==1 )
{
    $info_curso = $curso['data'][0];

?>

<div class="panel-heading"> <h2> <small class="badge">Curso: </small> <?php echo $info_curso['cur_nom_completo']; ?></h2> </div>

<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-9">
        <div class="col-xs-6 col-md-6">
            <label>Información del curso</label><br><br>
            Id curso: <?php echo $info_curso['cur_id']; ?><br>
            Clave curso: <?php echo $info_curso['cur_clave']; ?><br>
            Categoria: <?php echo $info_curso['cat_nom']; ?><br>
            Año: <?php echo $info_curso['anio']; ?><br>
            Fecha inicio: <?php echo $info_curso['fecha_inicio']; ?><br>
            Duración en horas: <?php echo $info_curso['horascur']; ?><br>
            Tutorizado: <?php echo $info_curso['tutorizado']; ?><br>

        </div>
        <div class="col-xs-6 col-md-6">
            <label>Roles del curso</label><br><br>
            <div class="list-group">
                <?php
                $roles_mostrar = array(5,14,18,32,33,30);

                foreach ($roles['data'] as $row) {
                    if (in_array($row['rol_id'], $roles_mostrar))
                    {

                ?>
                <a class="list-group-item" href="#">
                    <span class="badge"><?php echo $row['usuarios_por_rol']; ?></span>
                    <?php echo $row['nom_rol']; ?>
                </a>
                <?php

                    }

                }

                ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3">
        <label>Grupos del curso</label><br><br>
        <div class="list-group">
            <?php

            foreach ($grupos['data'] as $row)
            {

            ?>
                <a class="list-group-item" href="#<?php echo $row['grup_id']; ?>">
                    <?php echo $row['grup_nom']; ?>
                </a>
            <?php
            }

            ?>

        </div>

    </div>
</div>
<?php

}else{

?>

<div class="clearfix"></div>

<?php 

echo html_message('No se encontro información del curso', $tipo_msg['WARNING']['class']); 

}
