<?php
//empleados_salva.php
require "funciones/conecta.php";

$con = conecta();
$id = $_REQUEST['id'];

// Recibe variables
$nombreProducto = $_REQUEST["nombre"];
$codigo = $_REQUEST["codigo"];
$descripcion = $_REQUEST["descripcion"];
$costo = $_REQUEST["costo"];
$stock =  $_REQUEST["stock"];
$archivo_n = $_FILES['archivo']['name'];
$archivo = $_FILES['archivo']['tmp_name'];

$arreglo = explode(".", $archivo_n);
$len = count($arreglo);
$pos = $len - 1;
$ext = $arreglo[$pos];
$dir = "archivos/";
//$file_enc = md5_file($archivo);
$file_enc = !empty($archivo) ? md5_file($archivo) : '';

// Inicializa un array para almacenar los campos a actualizar
$updateData = array();

// Verifica y agrega los campos que están llenos
if (!empty($nombreProducto)) {
    $updateData[] = "nombre = '$nombreProducto'";
}
if (!empty($codigo)) {
    $updateData[] = "codigo = '$codigo'";
}
if (!empty($descripcion)) {
    $updateData[] = "descripcion = '$descripcion'";
}
if (!empty($costo)) {
    $updateData[] = "costo = '$costo'";
}
if (!empty($stock)) {
    $updateData[] = "stock = $stock";
}
//if (!empty($archivo_n)) {
  //  $fileName1 = "$file_enc.$ext";
    //copy($archivo, $dir . $fileName1);
    //$updateData[] = "archivo_n = '$archivo_n', archivo = '$file_enc.$ext'";
//}
if (!empty($archivo_n) && !empty($archivo)) {
    $fileName1 = "$file_enc.$ext";
    copy($archivo, $dir . $fileName1);
    $updateData[] = "archivo_n = '$archivo_n', archivo = '$file_enc.$ext'";
} elseif (!empty($archivo_n)) {
    $updateData[] = "archivo_n = '$archivo_n'";
}

// Construye la parte SET de la consulta solo si hay campos para actualizar
$updateSet = !empty($updateData) ? implode(", ", $updateData) : '';

// Construye la consulta final
$sql = "UPDATE productos SET $updateSet WHERE id = $id";

$res = $con->query($sql);
header("Location: productos_lista.php");
?>