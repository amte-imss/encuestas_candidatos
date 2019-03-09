<?php
echo form_open('encuestas/index', array('id' => 'form_listado_encuestas'));

$roles_evalua = array(32 => 'Tutor Titular', 33 => 'Tutor Adjunto', 18 => 'Coordinador de Tutores', 14 => 'Coordinador de Curso');
?>
<?php $id_carga_instrumento = $this->acceso->get_permiso_accion(En_modulos::CARGAR_INSTRUMENTO);
if ($id_carga_instrumento > -1) {
    ?>
    <div class="row"> 
        <a href="<?php echo site_url($secciones_acceso[$id_carga_instrumento]['url']); ?>" class="btn pull-right btn-moodle"> <?php echo $secciones_acceso[$id_carga_instrumento]['nombre']; ?> </a>
    </div>
<?php } ?>
<br>
<div class="clearfix"></div>
<div class="row">
    <!--<div class="col-lg-12">-->
        <div class="col-lg-4 col-md-4">
            <div class="input-group input-group-sm">
                <label for="descripcion_encuestas">Nombre instrumento:</label>
                <?php echo $this->form_complete->create_element(array('id' => 'descripcion_encuestas', 'type' => 'text', 'attributes' => array('name' => 'descripcion_encuestas', 'class' => 'form-control', 'placeholder' => 'Nombre instrumento', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Nombre encuesta (instrumento)', 'onkeyup' => "data_ajax(site_url+'/encuestas/get_encuestas_ajax', '#form_listado_encuestas', '#listado_resultado')"))); ?>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="input-group input-group-sm">
                <label for="rol_id">Rol a evaluar:</label>
                <?php echo $this->form_complete->create_element(array('id' => 'rol_id', 'type' => 'dropdown', 'options' => $roles_evalua, 'first' => array('' => 'Seleccione un rol'), 'attributes' => array('name' => 'rol_id', 'class' => 'form-control', 'placeholder' => 'Rol que evalúa instrumento', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Rol que evalúa instrumento', 'onchange' => "data_ajax(site_url+'/encuestas/get_encuestas_ajax', '#form_listado_encuestas', '#listado_resultado')"))); ?>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">            
            <label>
                <?php echo $this->form_complete->create_element(array('id' => 'tutorizado', 'type' => 'checkbox', 'value' => 1, 'attributes' => array('name' => 'tutorizado', 'onClick' => "data_ajax(site_url+'/encuestas/get_encuestas_ajax', '#form_listado_encuestas', '#listado_resultado')"))); ?>
                Tutorizado
            </label><br>
            <label>
                <?php echo $this->form_complete->create_element(array('id' => 'is_bono', 'type' => 'checkbox', 'value' => 1, 'attributes' => array('name' => 'is_bono', 'onClick' => "data_ajax(site_url+'/encuestas/get_encuestas_ajax', '#form_listado_encuestas', '#listado_resultado')"))); ?>
                Instrumento bono


            </label>
        </div>
    <!--</div>-->
</div>
<!--</div>-->
<br>
<br>
<div class="row">
    <div class="col-lg-4 col-sm-4">
        <div class="input-group input-group-sm">
            <span class="input-group-addon">Número de registros a mostrar:</span>
            <?php echo $this->form_complete->create_element(array('id' => 'per_page', 'type' => 'dropdown', 'options' => array(5 => 5, 10 => 10, 20 => 20, 50 => 50, 100 => 100), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Número de registros a mostrar', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Número de registros a mostrar', 'onchange' => "data_ajax(site_url+'/encuestas/get_encuestas_ajax', '#form_listado_encuestas', '#listado_resultado')"))); ?>
        </div>
    </div>
    <div class="col-lg-4 col-sm-4">
        <div class="input-group input-group-sm">
            <span class="input-group-addon">Ordenar por:</span>
            <?php echo $this->form_complete->create_element(array('id' => 'order', 'type' => 'dropdown', 'options' => array('descripcion_encuestas' => 'Nombre instrumento', 'is_bono' => 'Aplica para bonos', 'tutorizado' => 'Curso tutorizado', 'rol_evaluar' => 'Rol a evaluar'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Ordernar por', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ordenar por', 'onchange' => "data_ajax(site_url+'/encuestas/get_encuestas_ajax', '#form_listado_encuestas', '#listado_resultado')"))); ?>
        </div>
    </div>
    <div class="col-lg-4 col-sm-4">
        <div class="input-group input-group-sm">
            <span class="input-group-addon">Tipo de orden:</span>
            <?php echo $this->form_complete->create_element(array('id' => 'order_type', 'type' => 'dropdown', 'options' => array('DESC' => 'Descendente', 'ASC' => 'Ascendente'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Ordernar por', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ordenar por', 'onchange' => "data_ajax(site_url+'/encuestas/get_encuestas_ajax', '#form_listado_encuestas', '#listado_resultado')"))); ?>
        </div>
    </div>
</div>
<br>
<br>
<div id="listado_resultado"><!-- listado encuestas --></div>
<div class="clearfix" style="margin-bottom: 45px;"></div>

<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        data_ajax(site_url + "/encuestas/get_encuestas_ajax", "#form_listado_encuestas", "#listado_resultado");
        $("#btn_submit").click(function (event) {
            data_ajax(site_url + "/encuestas/get_encuestas_ajax", "#form_listado_encuestas", "#listado_resultado");
            event.preventDefault();
        });
    });
            function drop_encuesta(encuesta_cve = null)
            {
            if (confirm('Esta a punto de eliminar este instrumento, ¿Desea continuar?'))
            {
            data_ajax(site_url + "/encuestas/drop_instrumento/" + encuesta_cve, 'null', "#listado_resultado");
            }

            }
    function block_encuesta(encuesta_cve = null)
    {
    if (confirm('Esta a punto de desactivar este instrumento, ¿Desea continuar?'))
    {
    data_ajax(site_url + "/encuestas/block_instrumento/" + encuesta_cve, 'null', "#listado_resultado");
    }

    }
    function unlock_encuesta(encuesta_cve = null)
    {
    if (confirm('Esta a punto de activar este instrumento, ¿Desea continuar?'))
    {
    data_ajax(site_url + "/encuestas/unlock_instrumento/" + encuesta_cve, 'null', "#listado_resultado");
    }

    }
    function dup_encuesta(encuesta_cve = null)
    {
        if (confirm('Esta a punto de duplicar este instrumento, ¿Desea continuar?'))
        {
            data_ajax(site_url + "/encuestas/copy/" + encuesta_cve, 'null', "#listado_resultado");
        }

    }

</script>