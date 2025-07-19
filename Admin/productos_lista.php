<?php
//empleados_lista.php
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
    //empleados_lista.php
    require "funciones/conecta.php";
    $con = conecta();
    $sql = "SELECT * FROM productos 
            WHERE status = 1 AND eliminado = 0";
    $res = $con->query($sql);
    $sql_productos = "SELECT * FROM productos 
                  WHERE status = 1 AND eliminado = 0";
    $res_productos = $con->query($sql_productos);
    $num_productos = $res_productos->num_rows;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de productos</title>
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
        <h1>Lista de productos (<span id="numero_productos"><?php echo $num_productos; ?></span>) </h1>
    </header>
    <?php include 'menu.php' ?>
    <a href="productos_alta.php" style="background-color: #333;">Agregar producto</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Codigo</th>
            <th>Costo</th>
            <th>Stock</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php
            while($row = $res->fetch_array()) {
                $id = $row["id"];
                $nombre = $row["nombre"];
                $codigo = $row["codigo"];
                $costo = $row["costo"];
                $stock = $row["stock"];
                echo "<tr data-id='$id'>"; // Agregar el atributo data-id con el ID del empleado
                echo "<td>$id</td>";
                echo "<td>$nombre</td>";
                echo "<td>$codigo</td>";
                echo "<td>$costo</td>";
                echo "<td>$stock</td>";
                echo "<td><button onclick=\"enviaAjax($id);\">Eliminar</button></td>";
                echo "<td><button onclick=\"verDetalle($id);\">Detalle</button></td>";
                echo "<td><button onclick=\"editar($id);\">Editar</button></td>";
                echo "</tr>";
            }

        ?>
    </table>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script>
        function enviaAjax(id) {
            var confirmacion = confirm("¿Desea eliminar el producto?");
            if(confirmacion) {
                $.ajax({
                    url: 'producto_elimina.php',
                    type: 'post',
                    data: {id: id},
                    success: function(data) {
                        if(data === "si") {
                            // Elimina la fila de la tabla
                            $('table tr[data-id="' + id + '"]').remove();
                            // Actualiza el número de empleados
                            $('#numero_productos').text(function() {
                                return parseInt($(this).text()) - 1;
                            });
                        } else {
                            alert("No se pudo eliminar el producto");
                        }
                    }
                });

            }
        }



        function verDetalle(id) {
            window.location.href = "producto_detalle.php?id=" + id;
        }

        function editar(id) {
            window.location.href = "productos_editar.php?id=" + id;
        }


    </script>
</body>
</html>