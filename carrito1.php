<?php
session_start();
require "funciones/conecta.php";
$con = conecta();
$sesionIniciada = isset($_SESSION['idCliente']);

if (!$sesionIniciada) {
    // Redirigir al usuario a la página de inicio de sesión o mostrar un mensaje de error
    echo "Debe iniciar sesión para ver su carrito.";
    exit();
}

$idcliente = $_SESSION['idCliente'];

// Obtener el pedido abierto del usuario
$sql_pedido = "SELECT id FROM pedidos WHERE id_cliente = $idcliente AND status = 0";
$res_pedido = $con->query($sql_pedido);
$row_pedido = $res_pedido->fetch_assoc();

if (!$row_pedido) {
    // No hay pedido abierto
    $id_pedido = null;
} else {
    $id_pedido = $row_pedido['id'];
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        form {
            background-color: white;
            width: 400px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
        img {
            display: block;
            margin: 20px auto;
        }
        a {
            text-decoration: none;
            color: white;
            background-color: #333;
            text-align: center;
            padding: 10px 20px;
            border-radius: 3px;
            display: block;
            margin-top: 10px;
        }
        button {
            background-color: #333;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <br>
    <br>
    <h2>Pedido 1/2</h2>
    <?php if ($id_pedido): ?>
        <?php
        $sql_carrito = "SELECT pp.id, p.nombre, pp.cantidad, pp.precio 
                        FROM pedidos_productos pp 
                        JOIN productos p ON pp.id_producto = p.id 
                        WHERE pp.id_pedido = $id_pedido";
        $res_carrito = $con->query($sql_carrito);
        ?>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="carrito">
                <?php while($row = $res_carrito->fetch_assoc()): 
                    $subtotal = $row['cantidad'] * $row['precio'];
                    $total += $subtotal;
                ?>
                <tr data-id="<?php echo $row['id']; ?>">
                    <td><?php echo $row['nombre']; ?></td>
                    <td>
                        <input type="number" value="<?php echo $row['cantidad']; ?>" onchange="actualizarCantidad(<?php echo $row['id']; ?>, this.value)">
                    </td>
                    <td><?php echo $row['precio']; ?></td>
                    <td class="subtotal"><?php echo $subtotal; ?></td>
                    <td>
                        <button onclick="eliminarProducto(<?php echo $row['id']; ?>)">Eliminar</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <h2>Total: <span id="total"><?php echo $total; ?></span></h2>
        <a href="carrito2.php">Continuar</a>
    <?php else: ?>
        <p>No tiene productos en su carrito.</p>
    <?php endif; ?>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script>
        function actualizarCantidad(id, cantidad) {
            $.ajax({
                url: 'actualizar_producto.php',
                type: 'post',
                data: {id: id, cantidad: cantidad},
                success: function(response) {
                    let data = response.split(',');
                    if (data[0] === 'success') {
                        let subtotal = data[1];
                        let total = data[2];
                        let row = $('tr[data-id="' + id + '"]');
                        row.find('.subtotal').text(subtotal);
                        $('#total').text(total);
                    } else {
                        alert('Error al actualizar la cantidad');
                    }
                },
                error: function() {
                    alert('Error al actualizar la cantidad');
                }
            });
        }

        function eliminarProducto(id) {
            $.ajax({
                url: 'eliminar_producto.php',
                type: 'post',
                data: {id: id},
                success: function(response) {
                    let data = response.split(',');
                    if (data[0] === 'success') {
                        let total = data[1];
                        $('tr[data-id="' + id + '"]').remove();
                        $('#total').text(total);
                    } else {
                        alert('Error al eliminar el producto');
                    }
                },
                error: function() {
                    alert('Error al eliminar el producto');
                }
            });
        }
    </script>
    <div align="middle">
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
