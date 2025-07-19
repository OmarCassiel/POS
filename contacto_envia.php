<?php
$fp = fsockopen('smtp.gmail.com', 587, $errno, $errstr, 10);
if (!$fp) {
    echo "Error: $errno - $errstr";
} else {
    echo "Conexión exitosa";
    fclose($fp);
}

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo_usuario = $_POST['correo'];
$comentario = $_POST['comentario'];

$to = 'omar.chavez0929@alumnos.udg.mx';
$subject = 'Contacto';

$message = "Nombre: $nombre\nApellidos: $apellido\nCorreo: $correo_usuario\nComentario: $comentario";

$headers = "From: $correo_usuario"; 
$headers .= '\r\nReply-To: $correo_usuario';

if (mail($to, $subject, $message, $headers)) {
    echo 'Correo enviado correctamente';
} else {
    echo 'Error al enviar el correo';
}
?>
