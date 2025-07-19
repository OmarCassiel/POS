<?php
session_start();
require "funciones/conecta.php";
$con = conecta();

$id_producto_pedido = $_POST['id'];

// Obtener la información del pedido actual
$sql_get_pedido = "SELECT id_pedido FROM pedidos_productos WHERE id = $id_producto_pedido";
$res_get_pedido = $con->query($sql_get_pedido);
$row_get_pedido = $res_get_pedido->fetch_assoc();
$id_pedido = $row_get_pedido['id_pedido'];

// Eliminar el producto del pedido
$sql_delete = "DELETE FROM pedidos_productos WHERE id = $id_producto_pedido";
$con->query($sql_delete);

// Calcular el nuevo total del pedido
$sql_get_total = "SELECT SUM(cantidad * precio) AS total FROM pedidos_productos WHERE id_pedido = $id_pedido";
$res_get_total = $con->query($sql_get_total);
$row_get_total = $res_get_total->fetch_assoc();
$total = $row_get_total['total'];

// Devolver la respuesta como texto plano
echo "success,$total";
?>
