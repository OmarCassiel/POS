<?php
//validUsuario.php
//inicia una sesion
session_start();
require "conecta.php";
$con = conecta();



$correo = $_REQUEST['correo'];
$pass = $_REQUEST['pass'];
$pass = md5($pass);

$sql = "SELECT * FROM empleados WHERE status = 1 AND eliminado = 0 AND correo = '$correo' AND pass = '$pass'";

$res = $con->query($sql);
$num = $res->num_rows;
if($num ==1){
	$row = $res->fetch_array();
	$id = $row["id"];
	$nombre = $row["nombre"]. ' '.$row["apellidos"];
	$correo = $row["correo"];

	$_SESSION["idUsuario"] = $id;
	$_SESSION["nombreUsuario"] = $nombre;
	$_SESSION["correoUsuario"] = $correo;
}
echo $num;

$_SESSION["correo"] = $correo;


?>