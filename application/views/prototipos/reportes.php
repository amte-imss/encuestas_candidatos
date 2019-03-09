<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid-theme.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid.js'); ?>"></script>
<?php echo js("prototipos/reporte_participantes.js"); ?>
<?php echo js("prototipos/notificacion.js"); ?>

<div class="panel panel-default">

    <fieldset class="scheduler-border well">
        <legend class="scheduler-border">Reporte</legend>

        <!--<div class="panel-body input-group input-group-sm" style="padding-left: 2em;">-->
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4" style="padding-left: 2em;">
                    <div class="form-group">
                        <label for="tipo_reporte">Seleccione el tipo de reporte</label>
                        <select name="tipo_reporte">
                            <option value="1">General</option>
                            <option value="2">Encuestas contestadas</option>
                            <option value="3">Encuestas no contestadas</option>
                        </select>
                    </div>
                </div>
                <div id="btn_correo" class="col-sm-offset-4 col-sm-4" style="padding-right: 2em;">
                    <br>
                    <div class="pull-right">
                        <button onclick="enviar_notificacion()" class="btn btn-primary" data-toggle="modal" data-target="#my_modal">Enviar notificación</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="reporte_general"></div>
        
        <div id="filtros_descarga">
            <fieldset class="scheduler-border well" style="padding: 2em;">
                <legend class="scheduler-border">Descarga reporte</legend>

                <div class="panel-body" >
                    <form class="form-horizontal" id="form_filtros">
                        <div class="form-group">
                            <div class="col-sm-5 pull-left">
                                <label for="instrumento" >Tipo de instrumento*</label>
                                <select class="form-control" id="instrumento">
                                  <option value selected="selected"> Seleccione una opción</option>
                                  <option value="1">A a TA - Tutorizado</option>
                                  <option value="2">A a TT - Tutorizado</option>
                                  <option value="3">A a CC - No Tutorizado</option>
                                  <option value="4">CC a CT - Tutorizado</option>
                                  <option value="5">CC a CN - Tutorizado</option>
                                  <option value="6">CN a CC - Tutorizado</option>
                                  <option value="7">CN a CC - No tutorizado</option>
                                  <option value="8">CT a TA - Tutorizado</option>
                                  <option value="9">CT a TT - Tutorizado</option>
                                  <option value="10">CT a CC - Tutorizado</option>
                                  <option value="11">TA a CT - Tutorizado</option>
                                  <option value="12">TT a CT - Tutorizado</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <fieldset class="scheduler-border well" style="padding: 2em;">
                                    <legend class="scheduler-border">Evaluador</legend>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="matricula_evaluador" class="col-sm-2">Matrícula</label>
                                                <div class="col-sm-8 pull-right">
                                                    <input type="text" name="matricula_evaluador" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nombre_evaluador" class="col-sm-2">Nombre</label>
                                                <div class="col-sm-8 pull-right">
                                                    <input type="text" name="nombre_evaluador" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="rol_evaluador" class="col-sm-2">Rol</label>
                                                <div class="col-sm-8 pull-right">
                                                    <select name="rol_evaluador" class="form-control">
                                                        <option value="" selected="selected">Seleccione una opción</option>
                                                        <option value="5">Alumno</option>
                                                        <option value="14">Coordinador de curso</option>
                                                        <option value="18">Coordinador de tutores</option>
                                                        <option value="32">Tutor titular</option>
                                                        <option value="33">Tutor adjunto</option>
                                                        <option value="30">Coordinador normativo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="categoria_evaluador" class="col-sm-2">Categoría</label>
                                                <div class="col-sm-8 pull-right">
                                                    <input type="text" name="categoria_evaluador" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="unidad_evaluador" class="col-sm-2">Unidad/UMAE</label>
                                                <div class="col-sm-8 pull-right">
                                                    <input type="text" name="unidad_evaluador" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="region_evaluador" class="col-sm-2">Región</label>
                                                <div class="col-sm-8 pull-right">
                                                    <select name="region_evaluado" class="form-control">
                                                        <option value="" selected="selected">Seleccione una opción</option>
                                                        <option value="1">Noroccidente</option>
                                                        <option value="3">Centro</option>
                                                        <option value="2">Noreste</option>
                                                        <option value="4">Centro Sureste</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nombre_evaluador" class="col-sm-2">Delegación</label>
                                                <div class="col-sm-8 pull-right">
                                                    <select name="delegacion_evaluador" class="form-control">
                                                        <option value="">Seleccione una opción</option>
                                                        <option value="39">MANDO</option>
                                                        <option value="00">SIN DELEGACION</option>
                                                        <option value="09">OFICINAS CENTRALES</option>
                                                        <option value="02">BAJA CALIFORNIA</option>
                                                        <option value="03">BAJA CALIFORNIA SUR</option>
                                                        <option value="06">COLIMA</option>
                                                        <option value="11">GUANAJUATO</option>
                                                        <option value="14">JALISCO</option>
                                                        <option value="17">MICHOACAN</option>
                                                        <option value="19">NAYARIT</option>
                                                        <option value="26">SINALOA</option>
                                                        <option value="27">SONORA</option>
                                                        <option value="05">COAHUILA</option>
                                                        <option value="08">CHIHUAHUA</option>
                                                        <option value="10">DURANGO</option>
                                                        <option value="20">NUEVO LEON</option>
                                                        <option value="25">SAN LUIS POTOSI</option>
                                                        <option value="29">TAMAULIPAS</option>
                                                        <option value="34">ZACATECAS</option>
                                                        <option value="07">CHIAPAS</option>
                                                        <option value="12">GUERRERO</option>
                                                        <option value="18">MORELOS</option>
                                                        <option value="21">OAXACA</option>
                                                        <option value="22">PUEBLA</option>
                                                        <option value="23">QUERETARO</option>
                                                        <option value="28">TABASCO</option>
                                                        <option value="30">TLAXCALA</option>
                                                        <option value="31">VERACRUZ NORTE</option>
                                                        <option value="32">VERACRUZ SUR</option>
                                                        <option value="37">D F 3 SUR</option>
                                                        <option value="38">D F 4 SUR</option>
                                                        <option value="04">CAMPECHE</option>
                                                        <option value="13">HIDALGO</option>
                                                        <option value="15">EDO MEX OTE</option>
                                                        <option value="16">EDO MEX PTE</option>
                                                        <option value="24">QUINTANA ROO</option>
                                                        <option value="33">YUCATAN</option>
                                                        <option value="35">D F 1 NORTE</option>
                                                        <option value="36">D F 2 NORTE</option>
                                                        <option value="01">AGUASCALIENTES</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-6">
                                <fieldset class="scheduler-border well" style="padding: 2em;">
                                    <legend class="scheduler-border">Evaluado</legend>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="matricula_evaluado" class="col-sm-2">Matrícula</label>
                                                <div class="col-sm-8 pull-right">
                                                    <input type="text" name="matricula_evaluado" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nombre_evaluado" class="col-sm-2">Nombre</label>
                                                <div class="col-sm-8 pull-right">
                                                    <input type="text" name="nombre_evaluado" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="rol_evaluado" class="col-sm-2">Rol</label>
                                                <div class="col-sm-8 pull-right">
                                                    <select name="rol_evaluado" class="form-control">
                                                        <option value="" selected="selected">Seleccione una opción</option>
                                                        <option value="5">Alumno</option>
                                                        <option value="14">Coordinador de curso</option>
                                                        <option value="18">Coordinador de tutores</option>
                                                        <option value="32">Tutor titular</option>
                                                        <option value="33">Tutor adjunto</option>
                                                        <option value="30">Coordinador normativo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="categoria_evaluado" class="col-sm-2">Categoría</label>
                                                <div class="col-sm-8 pull-right">
                                                    <input type="text" name="categoria_evaluado" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="unidad_evaluado" class="col-sm-2">Unidad/UMAE</label>
                                                <div class="col-sm-8 pull-right">
                                                    <input type="text" name="unidad_evaluado" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="region_evaluado" class="col-sm-2">Región</label>
                                                <div class="col-sm-8 pull-right">
                                                    <select name="region_evaluado" class="form-control">
                                                        <option value="" selected="selected">Seleccione una opción</option>
                                                        <option value="1">Noroccidente</option>
                                                        <option value="3">Centro</option>
                                                        <option value="2">Noreste</option>
                                                        <option value="4">Centro Sureste</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nombre_evaluado" class="col-sm-2">Delegación</label>
                                                <div class="col-sm-8 pull-right">
                                                    <select name="delegacion_evaluado" class="form-control">
                                                        <option value="">Seleccione una opción</option>
                                                        <option value="39">MANDO</option>
                                                        <option value="00">SIN DELEGACION</option>
                                                        <option value="09">OFICINAS CENTRALES</option>
                                                        <option value="02">BAJA CALIFORNIA</option>
                                                        <option value="03">BAJA CALIFORNIA SUR</option>
                                                        <option value="06">COLIMA</option>
                                                        <option value="11">GUANAJUATO</option>
                                                        <option value="14">JALISCO</option>
                                                        <option value="17">MICHOACAN</option>
                                                        <option value="19">NAYARIT</option>
                                                        <option value="26">SINALOA</option>
                                                        <option value="27">SONORA</option>
                                                        <option value="05">COAHUILA</option>
                                                        <option value="08">CHIHUAHUA</option>
                                                        <option value="10">DURANGO</option>
                                                        <option value="20">NUEVO LEON</option>
                                                        <option value="25">SAN LUIS POTOSI</option>
                                                        <option value="29">TAMAULIPAS</option>
                                                        <option value="34">ZACATECAS</option>
                                                        <option value="07">CHIAPAS</option>
                                                        <option value="12">GUERRERO</option>
                                                        <option value="18">MORELOS</option>
                                                        <option value="21">OAXACA</option>
                                                        <option value="22">PUEBLA</option>
                                                        <option value="23">QUERETARO</option>
                                                        <option value="28">TABASCO</option>
                                                        <option value="30">TLAXCALA</option>
                                                        <option value="31">VERACRUZ NORTE</option>
                                                        <option value="32">VERACRUZ SUR</option>
                                                        <option value="37">D F 3 SUR</option>
                                                        <option value="38">D F 4 SUR</option>
                                                        <option value="04">CAMPECHE</option>
                                                        <option value="13">HIDALGO</option>
                                                        <option value="15">EDO MEX OTE</option>
                                                        <option value="16">EDO MEX PTE</option>
                                                        <option value="24">QUINTANA ROO</option>
                                                        <option value="33">YUCATAN</option>
                                                        <option value="35">D F 1 NORTE</option>
                                                        <option value="36">D F 2 NORTE</option>
                                                        <option value="01">AGUASCALIENTES</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </fieldset>
                            </div>
                        </div><!--row-->
                        <div class="row">
                            <div class="form-group" style="padding-left: 1em;">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="folio">Folio de la encuesta</label>
                                        <input type="text" name="folio" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nombre_encuesta">Nombre de la encuesta</label>
                                        <input type="text" name="nombre_encuesta" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-offset-6 col-sm-6">
                            <div class="pull-right">
                                <input type="button" class="btn btn-primary" onclick="limpiar_filtros()" value="Limpiar filtros">
                                <a href="#" class="btn btn-primary">Exportar datos</a>
                            </div>
                        </div>
                    </form>
                </div><!--panel body-->
            </fieldset> 
        </div>      

    </fieldset>

</div>