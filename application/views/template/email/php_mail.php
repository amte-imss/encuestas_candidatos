<?php

require("class.phpmailer.php");
$mail = new PHPMailer();

//Luego tenemos que iniciar la validación por SMTP:
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = ""; // SMTP a utilizar. Por ej. smtp.elserver.com
$mail->Username = ""; // Correo completo a utilizar
$mail->Password = ""; // Contraseña
$mail->Port = 25; // Puerto a utilizar
//Con estas pocas líneas iniciamos una conexión con el SMTP. Lo que ahora deberíamos hacer, es configurar el mensaje a enviar, el //From, etc.
$mail->From = "info@elserver.com"; // Desde donde enviamos (Para mostrar)
$mail->FromName = "Nombre";

//Estas dos líneas, cumplirían la función de encabezado (En mail() usado de esta forma: “From: Nombre <correo@dominio.com>”) de //correo.
$mail->AddAddress("correo"); // Esta es la dirección a donde enviamos
$mail->IsHTML(true); // El correo se envía como HTML
$mail->Subject = 'Titulo'; // Este es el titulo del email.
$body = "Hola mundo. Esta es la primer línea<br />";
$body .= "Acá continuo el <strong>mensaje</strong>";
$mail->Body = $body; // Mensaje a enviar
$exito = $mail->Send(); // Envía el correo.
////Aguegar imagen adjunta, primer parametro es ruta de la imagen, segundo parametro es el nombre vinculado a la referencia del archivo
//$mail->AddAttachment("imagenes/imagenadjunta.jpg", "nombre_a_mostrar.jpg");
////Cuentas en copia oculta
////$mail->AddCC("cuenta@dominio.com");
//$mail->AddBCC("cuenta@dominio.com");

//También podríamos agregar simples verificaciones para saber si se envió:
if ($exito) {
    echo 'El correo fue enviado correctamente.';
} else {
    echo 'Hubo un inconveniente. Contacta a un administrador.';
}