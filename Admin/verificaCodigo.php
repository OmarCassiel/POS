<?php
require "funciones/conecta.php";
$con = conecta();

$codigo = $_POST['codigo'];

$sql = "SELECT codigo FROM productos WHERE codigo = '$codigo' AND eliminado=0";
$res = $con->query($sql);

if ($res->num_rows > 0) {
  echo 'si';
} else {
  echo 'no';
}
?>