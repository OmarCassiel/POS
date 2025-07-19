<?php
session_start();
$sesionIniciada = isset($_SESSION['idCliente']);
$idcliente = $sesionIniciada ? $_SESSION['idCliente'] : null;

require "funciones/conecta.php";
$con = conecta();

$nombreProducto = $codigo = $descripcion = $costo = $stock = $archivo = $status = "";
$productosAleatorios = [];

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $sql = "SELECT * FROM productos WHERE id = $id";
    $res = $con->query($sql);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $nombreProducto = $row["nombre"];
        $codigo = $row["codigo"];
        $descripcion = $row["descripcion"];
        $costo = $row["costo"];
        $stock =  $row["stock"];
        $archivo = $row["archivo"]; 
        $status = $row["status"] == '1' ? 'Activo' : 'Inactivo';
    } else {
        $error = "Producto no encontrado.";
    }
} else {
    $error = "ID de producto no especificado.";
}

$sqlAleatorios = "SELECT id, nombre, archivo FROM productos ORDER BY RAND() LIMIT 3";
$resAleatorios = $con->query($sqlAleatorios);

if ($resAleatorios && $resAleatorios->num_rows > 0) {
    while ($rowAleatorio = $resAleatorios->fetch_assoc()) {
        $productosAleatorios[] = $rowAleatorio;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle producto</title>
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

        /* Estilo para la tabla de productos aleatorios */
        .productos-aleatorios {
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            width: 800px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .productos-aleatorios table {
            width: 100%;
        }
        .producto {
            text-align: center;
        }
        .producto img {
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
    <header>
        <?php include 'header.php' ?>
    </header>
    <form>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php else: ?>
            <table id="listaProductosDetalle">
                <tr>
                    <th>Nombre</th>
                    <td><?php echo $nombreProducto; ?></td>
                </tr>
                <tr>
                    <th>Codigo</th>
                    <td><?php echo $codigo; ?></td>
                </tr>
                <tr>
                    <th>Descripcion</th>
                    <td><?php echo $descripcion; ?></td>
                </tr>
                <tr>
                    <th>Costo</th>
                    <td><?php echo $costo; ?></td>
                </tr>
                <tr>
                    <th>Stock</th>
                    <td><?php echo $stock; ?></td>
                </tr>
                <tr>
                    <th>Imagen refencia</th>
                    <td><img src="Admin/archivos/<?php echo $archivo; ?>" width="200" height="200"></td>
                </tr>
            </table>
            <br>
            <?php if ($sesionIniciada): ?>
            <label for="compra">Cantidad: </label>
            <input type="number" id="compra" name="compra" value="5" min="1" max="<?php echo $stock; ?>">
            <button type="button" onclick="agregarAlCarrito(<?php echo $id; ?>, <?php echo $costo; ?>);">Agregar al carrito</button>
            <?php endif; ?>
            <a href="productos.php">Regresar a la lista</a>
        <?php endif; ?>
    </form>

    <div class="productos-aleatorios">
        <h3>Productos que te pueden interesar</h3>
        <table>
            <tr>
                <?php foreach ($productosAleatorios as $producto): ?>
                    <td class="producto">
                        <p><?php echo $producto['nombre']; ?></p>
                        <p><?php echo $producto['id']; ?></p>
                        <img src="Admin/archivos/<?php echo $producto['archivo']; ?>" alt="<?php echo $producto['nombre']; ?>">
                        <?php if ($sesionIniciada): ?>
                        <label for="compra">Cantidad: </label>
                        <input type="number" id="compra_<?php echo $producto['id']; ?>" name="compra" value="5" min="1" max="<?php echo $stock; ?>">
                        <button type="button" onclick="agregarAlCarrito(<?php echo $producto['id']; ?>, <?php echo $costo; ?>);">Agregar al carrito</button>
                        <?php endif; ?>
                        <a href="productos_detalle.php?id=<?php echo $producto['id']; ?>">Ver detalle</a>
                    </td>
                <?php endforeach; ?>
            </tr>
        </table>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script>
        function agregarAlCarrito(id, costo) {
            const cantidad = document.getElementById('compra').value;
            window.location.href = `agregar_producto.php?id=${id}&cantidad=${cantidad}&precio=${costo}`;
        }
    </script>
</body>
</html>

