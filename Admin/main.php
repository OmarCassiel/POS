<?php
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
?>

<html>
	<head>
		<style>
			body {
				font-family: Arial, sans-serif;
				background-color: white;
				margin: 0;
				padding: 0;
			}
			*{
				margin: 0;
				padding: 0;	
			}

			header {
            text-align: center;
            background-color: #333;
            color: white;
            padding: 10px 0;
        }

		hr {
 		   	height: 1px;
 			background-color: black;
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

        .navbar-links a {
        	display: inline-block; /* Convierte los enlaces en elementos de línea */
            margin-right: 5%; /* Ajusta el margen derecho entre los enlaces */

        }
		</style>
		<script src="js/jquery-3.3.1.min.js"></script>

	</head>
	
	<body>
		<header><h1>Pagina principal</h1></header>
		<hr>
		<?php include 'menu.php' ?>
		<br>
              
	</body>
</html>