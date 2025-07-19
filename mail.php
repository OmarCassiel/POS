<?php
$to = 'omar.chavez0929@alumnos.udg.mx';
$subject = 'Hola desde xampp';
$message = 'Esto es una prueba';
$headers = 'From: omar@mail.com\r\n';
if(mail($to, $subject, $message, $headers)){
	echo "correo a sido enviado";
} else{
	echo "error";
}
?>