<style>
    .header{
        style="border: none;"
    }

    .tdHeader{
        style="border: none;"
    }

    .trHeader{
        style="border: none;"
    }
</style>
<table name="header" >
            <tr name="trHeader">
                <td name="tdHeader">
                    <img src="./Admin/imagenes/logo.png" width="50px" height="50px">
                </td>
                <td name="tdHeader">
                </td>
                <td name="tdHeader">
                    <a href="index.php">Inicio</a>
                </td>
                <td name="tdHeader">
                    <a href="productos.php">Productos</a>
                </td>
                 <td name="tdHeader">
                    <a href="contacto.php">Contacto</a>
                </td>
                 <td name="tdHeader">
                    <?php if ($sesionIniciada): ?>
                    <a href="funciones/cerrarSesion.php">Cerrar sesion</a>
                    <?php endif; ?>
                    <?php if (!$sesionIniciada): ?>
                    <a href="login.php">Iniciar sesion</a>
                    <?php endif; ?>
                </td>
                 <td name="tdHeader">
                    <?php if ($sesionIniciada): ?>
                    <a href="carrito1.php">Carrito</a>
                    <?php endif; ?>
                </td>
            </tr>
        </table>