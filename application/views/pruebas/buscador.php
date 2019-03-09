<!DOCTYPE html>
<script type="text/css">
/*    div
    {

        margin-top: 10px;
        border-style:dashed;
        width: 500px;
        height: 500px;
        background-color:#F0FFF0;
        text-align: left;
        color:#00008B;
        padding:10px 10px;
    }

    body{
        color:#696969;
        font-family:Arial,Helvetica,sans-serif;
    }*/

</script>
<html>

    <head><title>Buscador</title>


    </head>

    <body>

    <center> 

        <h1><b>Buscador </b></h1>

        Buscar <input type="text" id="text_buscar_instrumento" name="text_buscar_instrumento" required data-toggle="dropdown" class="dropdown-toggle"/>
        <div id="resultado"></div>
        Otro <input type="text" id="busqueda" name="otro" required "/>


    </center>

</body>



<script type="text/javascript">
    $(document).ready(function () {

        //hacemos focus al campo de búsqueda
        $("#text_buscar_instrumento").focus();
        //comprobamos si se pulsa una tecla
        $("#text_buscar_instrumento").keyup(function (e) {

            //obtenemos el texto introducido en el campo de búsqueda
            var consulta = $("#text_buscar_instrumento").val();
            //hace la búsqueda
//            data_ajax_post(site_url + 'buscar_control/buscar', null, '#resultado', consulta);
            $.ajax({
                type: "POST",
                url: site_url + "/buscar_control/buscar",
                data: "b=" + consulta,
                dataType: "html",
                beforeSend: function () {
                    //imagen de carga
                    $("#resultado").html(create_loader());
                },
                success:
                        function (data) {
                            $("#resultado").empty();
                            $("#resultado").append(data);
                        }
            });
        });
    });

</script>