<?php
//epedidos_lista.php
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
    $sql = "SELECT * FROM pedidos 
            WHERE status = 1";
    $res = $con->query($sql);
    $sql_empleados = "SELECT * FROM pedidos 
                  WHERE status = 1";
    $res_empleados = $con->query($sql_empleados);
    $num_empleados = $res_empleados->num_rows;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }

        header {
            padding: 0.5em;
            text-align: center;
            background-color: #333;
            color: white;
            border-radius: 5px;
        }

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
			color:white
        }

        tr:hover {
            background-color: #f5f5f5;
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



        .navbar-links a {
            margin-right: 5%; /* Ajusta el margen derecho entre los enlaces */
        }

    </style>
</head>
<body>
    <header>
        <h1>Lista de Pedidos (<span id="numero_empleados"><?php echo $num_empleados; ?></span>) </h1>
    </header>
    <?php include 'menu.php' ?>
</form>

    <table>
        <tr>
            <th>ID pedido</th>
            <th>Fecha</th>
            <th>ID cliente</th>
            <th></th>
        </tr>
        <?php
            while($row = $res->fetch_array()) {
                $id = $row["id"];
                $fecha = $row["fecha"];
                $id_cliente = $row["id_cliente"];
                echo "<tr data-id='$id'>"; // Agregar el atributo data-id con el ID del empleado
                echo "<td>$id</td>";
                echo "<td>$fecha</td>";
                echo "<td>$id_cliente</td>";
                echo "<td><button onclick=\"verDetalle($id);\">Detalle</button></td>";
                echo "</tr>";
            }

        ?>
    </table>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script>
    



        function verDetalle(id) {
            window.location.href = "pedido_detalle.php?id=" + id;
        }


    </script>
</body>
</html>
