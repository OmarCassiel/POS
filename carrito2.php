<?php
session_start();
require "funciones/conecta.php";
$con = conecta();
$sesionIniciada = isset($_SESSION['idCliente']);
$idcliente = $_SESSION['idCliente'];

// Obtener el pedido abierto del usuario
$sql_pedido = "SELECT id FROM pedidos WHERE id_cliente = $idcliente AND status = 0";
$res_pedido = $con->query($sql_pedido);
$row_pedido = $res_pedido->fetch_assoc();
$id_pedido = $row_pedido['id'];

$sql_carrito = "SELECT pp.id, p.nombre, pp.cantidad, pp.precio 
                FROM pedidos_productos pp 
                JOIN productos p ON pp.id_producto = p.id 
                WHERE pp.id_pedido = $id_pedido";
$res_carrito = $con->query($sql_carrito);

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
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        /*table, th, td {
            border: 1px solid black;
        }*/
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

        input[type=submit] {
            background-color: #333;
            border: none;
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            margin: 4px 2px;
            cursor: pointer;
            display: inline-block;
            border-radius: 5px;
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
        <?php include 'header.php' ?>
    </header>
    <br>
    <br>
    <h2>Pedido 1/2</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre del Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody id="carrito">
            <?php while($row = $res_carrito->fetch_assoc()): 
                $subtotal = $row['cantidad'] * $row['precio'];
                $total += $subtotal;
            ?>
            <tr data-id="<?php echo $row['id']; ?>">
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['cantidad']; ?></td>
                <td><?php echo $row['precio']; ?></td>
                <td class="subtotal"><?php echo $subtotal; ?></td>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br>
    <h3>Total: <span id="total"><?php echo $total; ?></span></h3>
    <form action="finalizar_pedido.php" method="post">
        <input type="submit" value="Finalizar Pedido">
    </form>
    <div align="middle">
    <?php include 'footer.php' ?>
</div>
</body>
</html>
