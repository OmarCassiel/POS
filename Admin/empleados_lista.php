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
    $sql = "SELECT * FROM empleados 
            WHERE status = 1 AND eliminado = 0";
    $res = $con->query($sql);
    $sql_empleados = "SELECT * FROM empleados 
                  WHERE status = 1 AND eliminado = 0";
    $res_empleados = $con->query($sql_empleados);
    $num_empleados = $res_empleados->num_rows;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Empleados</title>
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
        <h1>Lista de Empleados (<span id="numero_empleados"><?php echo $num_empleados; ?></span>) </h1>
    </header>
    <?php include 'menu.php' ?>
    <a href="empleados_alta.php" style="background-color: #333;">Agregar empleado</a>
    <form id="formBusqueda" method="GET">
    <label for="idEmpleado">Buscar por ID:</label>
    <input type="text" id="idEmpleado" name="idEmpleado" placeholder="Ingrese ID">
    <button type="submit">Buscar</button>
</form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Rol</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php
            while($row = $res->fetch_array()) {
                $id = $row["id"];
                $nombre = $row["nombre"];
                $apellidos = $row["apellidos"];
                $correo = $row["correo"];
                $rol = $row["rol"] == '1' ? 'Gerente' : 'Ejecutivo';
                echo "<tr data-id='$id'>"; // Agregar el atributo data-id con el ID del empleado
                echo "<td>$id</td>";
                echo "<td>$nombre</td>";
                echo "<td>$apellidos</td>";
                echo "<td>$correo</td>";
                echo "<td>$rol</td>";
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
            var confirmacion = confirm("¿Desea eliminar empleado?");
            if(confirmacion) {
                $.ajax({
                    url: 'empleado_elimina.php',
                    type: 'post',
                    data: {id: id},
                    success: function(data) {
                        if(data === "si") {
                            // Elimina la fila de la tabla
                            $('table tr[data-id="' + id + '"]').remove();
                            // Actualiza el número de empleados
                            $('#numero_empleados').text(function() {
                                return parseInt($(this).text()) - 1;
                            });
                        } else {
                            alert("No se pudo eliminar empleado");
                        }
                    }
                });

            }
        }



        function verDetalle(id) {
            window.location.href = "empleado_detalle.php?id=" + id;
        }

        function editar(id) {
            window.location.href = "empleados_editar.php?id=" + id;
        }

        $(document).ready(function() {
    $('#formBusqueda').submit(function(e) {
        e.preventDefault();
        var idEmpleado = $('#idEmpleado').val();
        if (idEmpleado.trim() !== '') {
            $.ajax({
                url: 'buscar_empleado.php',
                type: 'GET',
                data: {id: idEmpleado},
                success: function(response) {
                    if (response != '') {
                        $('table tbody').html(response);
                    } else {
                        alert('Empleado no encontrado');
                    }
                }
            });
        } else {
            alert('Por favor, ingrese un ID válido');
        }
    });
});

    </script>
</body>
</html>
