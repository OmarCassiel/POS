<?php
session_start();
$sesionIniciada = isset($_SESSION['idCliente']);
$idcliente = $sesionIniciada ? $_SESSION['idCliente'] : null;

require "funciones/conecta.php";
$con = conecta();

$productosAleatorios = []; // Variable para almacenar productos aleatorios
$promocionAleatoria = ""; // Variable para almacenar la promoción

// Consulta para obtener 6 productos al azar
$sqlAleatorios = "SELECT id, nombre, archivo, costo, stock FROM productos ORDER BY RAND() LIMIT 6";
$resAleatorios = $con->query($sqlAleatorios);

if ($resAleatorios && $resAleatorios->num_rows > 0) { // Si se encuentran productos, almacenarlos en el array
    while ($rowAleatorio = $resAleatorios->fetch_assoc()) {
        $productosAleatorios[] = $rowAleatorio;
    }
}

// Consulta para obtener 1 promoción al azar
$sqlPromocion = "SELECT archivo FROM promociones ORDER BY RAND() LIMIT 1";
$resPromocion = $con->query($sqlPromocion);

if ($resPromocion && $resPromocion->num_rows > 0) { // Si se encuentra una promoción, almacenarla
    $promocionAleatoria = $resPromocion->fetch_assoc()['archivo'];
}
?>

<html>
<head>
    <title>Inicio</title>
</head>
<script src="js/jquery-3.3.1.min.js"></script>
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
            border-radius: 5px;
            padding: 5px 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: center;
            /*border: 1px solid #ddd;*/
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

        .promocion {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .promocion img {
            width: 200px;
            height: 200px;
        }
</style>
<body>
    <header>
        <?php include 'header.php' ?>
    </header>

    <div class="promocion">
        <img src="Admin/archivos/<?php echo $promocionAleatoria;?>" alt="Promoción">
    </div>
    
    <div class="productos-aleatorios">
        <h3>Productos que te pueden interesar</h3>
        <table>
            <?php
            $contador = 0; // Inicializar contador
            foreach ($productosAleatorios as $producto): // Recorrer productos aleatorios
                if ($contador % 3 == 0): // Abrir una nueva fila cada 3 productos
                    echo '<tr>';
                endif;
            ?>
                <td class="producto">
                    <p><?php echo $producto['nombre']; ?></p>
                   
                <img src="Admin/archivos/<?php echo $producto['archivo']; ?>" alt="<?php echo $producto['nombre']; ?>" style="width:150px; height: 150px;">
                 <p><?php echo "Stock: "; echo $producto['stock']; ?></p>
                    <p><?php echo "Costo: "; echo $producto['costo']; ?></p>
                    <?php if ($sesionIniciada): ?>
                    <label for="compra">Cantidad: </label>
                    <input type="number" name="compra" value="5" min="1">
                    <button type="button" onclick="agregarAlCarrito(<?php echo $producto['id']; ?>, <?php echo $producto['costo']; ?>);">Agregar al carrito</button>
                    <br>
                    <?php endif; ?>
                    
                    <a href="productos_detalle.php?id=<?php echo $producto['id']; ?>" style="background-color: black;">Ver detalle</a>
                </td>
            <?php
                $contador++;
                if ($contador % 3 == 0): // Cerrar la fila después de 3 productos
                    echo '</tr>';
                endif;
            endforeach;

            // Cerrar la última fila si no está completa
            if ($contador % 3 != 0) {
                echo '</tr>';
            }
            ?>
        </table>
    </div>


     <script src="js/jquery-3.3.1.min.js"></script>
<script>
    function agregarAlCarrito(id, costo) {
        const cantidad = document.getElementsByName('compra')[0].value;
        window.location.href = `agregar_producto.php?id=${id}&cantidad=${cantidad}&precio=${costo}`;
    }
</script>
<div align="middle">
    <?php include 'footer.php' ?>
</div>
</body>
</html>
