<?php
//empleados_salva.php
require "funciones/conecta.php";

$con = conecta();
$id = $_REQUEST['id'];

// Recibe variables
$nombre = $_REQUEST['nombre'];
$archivo_n = $_FILES['archivo']['name'];
$archivo = $_FILES['archivo']['tmp_name'];

$arreglo = explode(".", $archivo_n);
$len = count($arreglo);
$pos = $len - 1;
$ext = $arreglo[$pos];
$dir = "archivos/";
$file_enc = !empty($archivo) ? md5_file($archivo) : '';

// Inicializa un array para almacenar los campos a actualizar
$updateData = array();

// Verifica y agrega los campos que están llenos
if (!empty($nombre)) {
    $updateData[] = "nombre = '$nombre'";
}
if (!empty($archivo_n) && !empty($archivo)) {
    $fileName1 = "$file_enc.$ext";
    copy($archivo, $dir . $fileName1);
    $updateData[] = "archivo = '$file_enc.$ext'";
}

// Construye la parte SET de la consulta solo si hay campos para actualizar
$updateSet = !empty($updateData) ? implode(", ", $updateData) : '';

// Construye la consulta final
$sql = "UPDATE promociones SET $updateSet WHERE id = $id";

$res = $con->query($sql);
header("Location: promociones_lista.php");
?>
