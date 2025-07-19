<?php
//productos.php
session_start();
$sesionIniciada = isset($_SESSION['idCliente']);
$idcliente = $sesionIniciada ? $_SESSION['idCliente'] : null;


require "funciones/conecta.php";
$con = conecta();
$sql = "SELECT * FROM productos 
        WHERE status = 1 AND eliminado = 0 AND stock>1";
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
    <title>Productos</title>
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
            text-align: center;
            display: inline-block;
            padding: 10px 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: gray;
            color: white;
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

    <table>
        <?php
            $counter = 0;
            while($row = $res->fetch_array()) {
                if ($counter % 3 == 0) {
                    echo "<tr>";
                }
                $id = $row["id"];
                $nombre = $row["nombre"];
                $codigo = $row["codigo"];
                $costo = $row["costo"];
                $stock = $row["stock"];
                $archivo = $row["archivo"];
                echo "<td>";
                echo "<img src='Admin/archivos/$archivo' style='display: block; margin: 20px auto;' width='200' height='200'>";
                echo "<p>Nombre: $nombre</p>";
                echo "<p>Codigo: $codigo</p>";
                echo "<p>Costo: $costo</p>";
                echo "<p>Stock: $stock</p>";
                if($sesionIniciada){
                    echo " <label for=\"compra_$id\">Cantidad: </label>
                        <input type=\"number\" id=\"compra_$id\" name=\"compra\" value=\"5\" min=\"1\" max=\"$stock\">";
                echo "<br>";
                echo "<br>";
                echo "<button onclick=\"agregarAlCarrito($id, $costo);\">Agregar al carrito</button>";
                echo "<br>";
                echo "<br>";
                }
                
                echo "<button onclick=\"verDetalle($id);\">Detalle</button>";
                echo "</td>";
                $counter++;
                if ($counter % 3 == 0) {
                    echo "</tr>";
                }
            }
            if ($counter % 3 != 0) {
                echo "</tr>";
            }
        ?>
    </table>
    <div align="middle">
        <?php include 'footer.php' ?>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script>
        function agregarAlCarrito(id, costo) {
            const cantidad = document.getElementById('compra_' + id).value;
            window.location.href = `agregar_producto.php?id=${id}&cantidad=${cantidad}&precio=${costo}`;
        }

        function verDetalle(id) {
            window.location.href = "productos_detalle.php?id=" + id;
        }
    </script>
</body>
</html>
