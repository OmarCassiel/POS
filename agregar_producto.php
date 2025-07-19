<?php
session_start();
$id_usuario = $_SESSION['idCliente'];
$id_producto = $_GET['id'];
$cantidad = $_GET['cantidad'];
$precio = $_GET['precio'];

require "funciones/conecta.php";
$con = conecta();

// Verifica si hay un pedido abierto para el usuario
$sql = "SELECT id FROM pedidos WHERE id_cliente = $id_usuario AND status = 0";
$res = $con->query($sql);

if ($res->num_rows == 0) {
    // No hay pedido abierto, crear uno nuevo
    $fecha = date('Y-m-d');
    $sql_insert_pedido = "INSERT INTO pedidos (fecha, id_cliente, status) VALUES ('$fecha', $id_usuario, 0)";
    $con->query($sql_insert_pedido);
    $id_pedido = $con->insert_id;
} else {
    // Obtener el ID del pedido abierto
    $row = $res->fetch_assoc();
    $id_pedido = $row['id'];
}

// Verificar si el producto ya está en el pedido
$sql_check_producto = "SELECT id, cantidad FROM pedidos_productos WHERE id_pedido = $id_pedido AND id_producto = $id_producto";
$res_check_producto = $con->query($sql_check_producto);

if ($res_check_producto->num_rows > 0) {
    // El producto ya está en el pedido, actualizar la cantidad
    $row_producto = $res_check_producto->fetch_assoc();
    $nueva_cantidad = $row_producto['cantidad'] + $cantidad;
    $sql_update_producto = "UPDATE pedidos_productos SET cantidad = $nueva_cantidad WHERE id = {$row_producto['id']}";
    $con->query($sql_update_producto);
} else {
    // El producto no está en el pedido, insertarlo
    $sql_insert_producto = "INSERT INTO pedidos_productos (id_pedido, id_producto, cantidad, precio) VALUES ($id_pedido, $id_producto, $cantidad, $precio)";
    $con->query($sql_insert_producto);
}

header("Location: carrito1.php"); // Redirige al carrito o a la página que desees
exit();
?>

