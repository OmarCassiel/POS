<?php
session_start();
require "funciones/conecta.php";
$con = conecta();

$id_producto_pedido = $_POST['id'];
$cantidad = $_POST['cantidad'];

// Obtener la información actual del producto en el pedido
$sql_get_pedido_producto = "SELECT * FROM pedidos_productos WHERE id = $id_producto_pedido";
$res_get_pedido_producto = $con->query($sql_get_pedido_producto);
$row_get_pedido_producto = $res_get_pedido_producto->fetch_assoc();

$id_pedido = $row_get_pedido_producto['id_pedido'];
$precio = $row_get_pedido_producto['precio'];

// Actualizar la cantidad del producto en el pedido
$sql_update = "UPDATE pedidos_productos SET cantidad = $cantidad WHERE id = $id_producto_pedido";
$con->query($sql_update);

// Calcular el nuevo subtotal para el producto
$subtotal = $cantidad * $precio;

// Calcular el nuevo total del pedido
$sql_get_total = "SELECT SUM(cantidad * precio) AS total FROM pedidos_productos WHERE id_pedido = $id_pedido";
$res_get_total = $con->query($sql_get_total);
$row_get_total = $res_get_total->fetch_assoc();
$total = $row_get_total['total'];

// Devolver la respuesta como texto plano
echo "success,$subtotal,$total";
?>


