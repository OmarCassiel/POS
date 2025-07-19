<?php
session_start();
require "funciones/conecta.php";
$con = conecta();

$idcliente = $_SESSION['idCliente'];

// Obtener el pedido abierto del usuario
$sql_pedido = "SELECT id FROM pedidos WHERE id_cliente = $idcliente AND status = 0";
$res_pedido = $con->query($sql_pedido);
$row_pedido = $res_pedido->fetch_assoc();
$id_pedido = $row_pedido['id'];

// Obtener los detalles de los productos en el carrito
$sql_carrito = "SELECT pp.id_producto, pp.cantidad 
                FROM pedidos_productos pp 
                WHERE pp.id_pedido = $id_pedido";
$res_carrito = $con->query($sql_carrito);

// Restar la cantidad de productos en el carrito del stock de la tabla de productos
while ($row = $res_carrito->fetch_assoc()) {
    $id_producto = $row['id_producto'];
    $cantidad = $row['cantidad'];

    // Obtener el stock actual del producto
    $sql_stock = "SELECT stock FROM productos WHERE id = $id_producto";
    $res_stock = $con->query($sql_stock);
    $row_stock = $res_stock->fetch_assoc();
    $stock_actual = $row_stock['stock'];

    // Calcular el nuevo stock después de restar la cantidad del carrito
    $nuevo_stock = $stock_actual - $cantidad;

    // Actualizar el stock en la tabla de productos
    $sql_actualizar_stock = "UPDATE productos SET stock = $nuevo_stock WHERE id = $id_producto";
    $con->query($sql_actualizar_stock);
}

// Cambiar el estado del pedido a cerrado
$sql_update_pedido = "UPDATE pedidos SET status = 1 WHERE id = $id_pedido";
$con->query($sql_update_pedido);

// Redireccionar al listado de productos
header("Location: productos.php");
exit;
?>
