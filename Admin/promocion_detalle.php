<?php
// empleado_detalle.php
session_start();
$id = $_SESSION['idUsuario'];
$nombre = $_SESSION["nombreUsuario"];
$correo = $_SESSION["correoUsuario"];
if(!isset($_SESSION["idUsuario"]) && !isset($_SESSION["correoUsuario"])){
    header("Location: index.php");
}
if(isset($_SESSION["idCliente"])){
    header("Location: ../productos.php");
}
require "funciones/conecta.php";
$con = conecta();

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $sql = "SELECT * FROM promociones WHERE id = $id";
    $res = $con->query($sql);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $nombrePromocion = $row["nombre"];
        $archivo = $row["archivo"]; 
        $status = $row["status"] == '1' ? 'Activo' : 'Inactivo';

        // Mostrar los detalles del empleado
        echo "<header style='background-color: #333; color: white; padding: 10px 0; text-align: center;'>
                <h1>Detalles de la promocion</h1>
              </header>";
        include 'menu.php'; 
        echo "<form style='background-color: white; width: 300px; margin: 20px auto; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);'>";
        echo "<table id='listaPromocioneDetalle' border='1'>";
        echo "<tr>";
        echo "<td style='background-color: #333; color: white; padding: 10px;'>Nombre promocion</td>";
        echo "<td style='padding: 10px;'>$nombrePromocion</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td style='background-color: #333; color: white; padding: 10px;'>Status</td>";
        echo "<td style='padding: 10px;'>$status</td>";
        echo "</tr>";
        echo "</table>";
        echo "<img src='archivos/$archivo' style='display: block; margin: 20px auto;' width='200' height='200'>";
        echo "<a href='promociones_lista.php' style='display: block; text-align: center; text-decoration: none; color: white; background-color: #333; border: none; padding: 10px 20px; margin-top: 10px; cursor: pointer; border-radius: 3px;'>Regresar a la lista</a>";
        echo "</form>";
    } else {
        echo "Promocion no encontrada.";
    }
} else {
    echo "ID de promocion no especificada.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle promocion</title>
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
    </style>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f0f0f0; margin: 0; padding: 0;">

</body>
</html>
