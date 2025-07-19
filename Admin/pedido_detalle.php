<?php
// pedido_detalle.php
session_start();
$id = $_SESSION['idUsuario'];
$nombre = $_SESSION["nombreUsuario"];
$correo = $_SESSION["correoUsuario"];
if (!isset($_SESSION["idUsuario"]) && !isset($_SESSION["correoUsuario"])) {
    header("Location: index.php");
}
if(isset($_SESSION["idCliente"])){
    header("Location: ../productos.php");
}
require "funciones/conecta.php";
$con = conecta();

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $sql = "SELECT * FROM pedidos_productos WHERE id_pedido = $id";
    $res = $con->query($sql);

    if ($res && $res->num_rows > 0) {
        echo "<header style='background-color: #333; color: white; padding: 10px 0; text-align: center;'>
                <h1>Detalles del Pedido</h1>
              </header>";
        include 'menu.php';
       echo "<table style='width: 100%; border-collapse: collapse; margin-top: 20px;'>
                <tr>
                    <th style='background-color: gray; color: white; padding: 10px;'>ID Producto</th>
                    <th style='background-color: gray; color: white; padding: 10px;'>Cantidad</th>
                    <th style='background-color: gray; color: white; padding: 10px;'>Precio</th>
                    <th style='background-color: gray; color: white; padding: 10px;'>Subtotal</th>
                </tr>";
        $total_general = 0; // Inicializamos el total general
        while ($row = $res->fetch_assoc()) {
            $id_producto = $row["id_producto"];
            $cantidad = $row["cantidad"];
            $precio = $row["precio"];
            $subtotal = $cantidad * $precio; // Calculamos el subtotal
            $total_general += $subtotal; // Sumamos al total general
            echo "<tr>
                    <td style='padding: 10px;'>$id_producto</td>
                    <td style='padding: 10px;'>$cantidad</td>
                    <td style='padding: 10px;'>$precio</td>
                    <td style='padding: 10px;'>$subtotal</td>
                  </tr>";
        }
        echo "<tr>
                <td colspan='3' style='text-align:right; padding: 10px;'>Total:</td>
                <td style='padding: 10px;'>$total_general</td>
              </tr>";
        echo "</table>";
        echo "<a href='pedidos_lista.php' style='display: block; text-align: center; text-decoration: none; color: white; background-color: #333; border: none; padding: 10px 20px; margin-top: 10px; cursor: pointer; border-radius: 3px;'>Regresar a la lista</a>";
    } else {
        echo "Pedido no encontrado.";
    }
} else {
    echo "ID de pedido no especificado.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Pedido</title>
    <style>
        a {
            text-decoration: none;
            color: white;
            background-color: gray;
            text-align: center;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin: 20px auto;
        }

        .navbar-links a {
            margin-right: 5%; /* Ajusta el margen derecho entre los enlaces */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: gray;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f0f0f0; margin: 0; padding: 0;">
</body>
</html>
