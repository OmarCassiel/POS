<?php
//contacto.php
session_start();
$sesionIniciada = isset($_SESSION['idCliente']);
$idcliente = $sesionIniciada ? $_SESSION['idCliente'] : null;
?>

<html>
	<head>
		<title>Contacto</title>
		<script src="js/jquery-3.3.1.min.js"></script>
		<style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }

        form {
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            width: 50%;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        input[type=text], input[type=password] {
            width: 50%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        input[type=submit] {
            background-color: 333;
            border: none;
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            margin: 4px 2px;
            cursor: pointer;
            display: inline-block;
            border-radius: 5px;
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
    <script >
    	function validar (){
            
            
            var nombre = $("#nombre").val();
            var apellido = $("#apellido").val();
            var correo = $("#correo").val();
            var comentario = $("#comentario").val();

           
            var formData = {
                nombre: nombre,
                apellido: apellido,
                correo: correo,
                comentario: comentario
            };

   
            $.ajax({
                type: "POST",
                url: "contacto_envia.php",
                data: formData,
                success: function (response) {
                	alert('Formulario enviado correctamente');
                    window.location = `index.php`;
                },
                error: function (error) {
                    
                    console.error(error);
                }
            });
        }
    </script>
	</head>
	
	<body>
		<header>
       		 <?php include 'header.php' ?>
   		</header>
          <form name="form01" id="form01" method="post" action="contacto_envia.php" enctype="multipart/form-data">
                <p><div class="palabra">Formulario de contacto:</div></p>
				<p><div class="palabra">Nombre:</div>  <input type="text" name="nombre" id="nombre" placeholder="Nombre aqui"/></p>
				<p><div class="palabra">Apellidos:</div>  <input type="text" name="apellido" id="apellido" placeholder="Apellidos aqui"/></p><!--Usuario-->
				<p><div class="palabra">Correo:</div>  <input type="text" name="correo" id="correo" placeholder="Correo aqui"/></p>
                <p><div class="palabra">Comentario:</div>  <input type="text" name="comentario" id="comentario"/></p><!--pass-->
                
				<input type="submit" onclick="validar(); return false;" value="Enviar" class="boton"/>
				
				
			</form> 
        <div align="middle">
            <?php include 'footer.php' ?>
        </div> 
	</body>
</html>