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
    $sql = "SELECT * FROM promociones 
            WHERE status = 1 AND eliminado = 0";
    $res = $con->query($sql);
    $sql_promociones = "SELECT * FROM promociones 
                  WHERE status = 1 AND eliminado = 0";
    $res_promociones = $con->query($sql_promociones);
    $num_promociones = $res_promociones->num_rows;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de promociones</title>
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
        <h1>Lista de promociones (<span id="numero_promociones"><?php echo $num_promociones; ?></span>) </h1>
    </header>
    <?php include 'menu.php' ?>
    <a href="promociones_alta.php" style="background-color: #333;">Agregar promocion</a>
    

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre promocion</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php
            while($row = $res->fetch_array()) {
                $id = $row["id"];
                $nombre = $row["nombre"];
                echo "<tr data-id='$id'>"; // Agregar el atributo data-id con el ID del empleado
                echo "<td>$id</td>";
                echo "<td>$nombre</td>";
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
            var confirmacion = confirm("¿Desea eliminar la promocion?");
            if(confirmacion) {
                $.ajax({
                    url: 'promocion_elimina.php',
                    type: 'post',
                    data: {id: id},
                    success: function(data) {
                        if(data === "si") {
                            // Elimina la fila de la tabla
                            $('table tr[data-id="' + id + '"]').remove();
                            // Actualiza el número de empleados
                            $('#numero_promociones').text(function() {
                                return parseInt($(this).text()) - 1;
                            });
                        } else {
                            alert("No se pudo eliminar promocion");
                        }
                    }
                });

            }
        }



        function verDetalle(id) {
            window.location.href = "promocion_detalle.php?id=" + id;
        }

        function editar(id) {
            window.location.href = "promociones_editar.php?id=" + id;
        }


    </script>
</body>
</html>
