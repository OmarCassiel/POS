<?php
require "funciones/conecta.php";
$con = conecta();

$codigo = $_POST['codigo'];
$id_producto = $_POST['id_producto '];

$sql = "SELECT codigo FROM productos  WHERE codigo = '$codigo' AND id != $id_producto AND eliminado = 0";
$res = $con->query($sql);

if ($res->num_rows > 0) {
  echo 'si';
} else {
  echo 'no';
}
?>
