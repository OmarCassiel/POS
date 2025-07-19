<?php
//validUsuario.php
//inicia una sesion
require "conecta.php";
$con = conecta();
session_start();


$correo = $_REQUEST['correo'];
$pass = $_REQUEST['pass'];


$sql = "SELECT * FROM clientes WHERE correo = '$correo' AND pass = '$pass'";

$res = $con->query($sql);
$num = $res->num_rows;
if($num ==1){
	$row = $res->fetch_array();
	$id = $row["id"];
	$correo = $row["correo"];

	$_SESSION["idCliente"] = $id;
	$_SESSION["correoUsuario"] = $correo;
}
echo $num;

$_SESSION["correo"] = $correo;


?>