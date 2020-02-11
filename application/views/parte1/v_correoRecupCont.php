<!doctype html>
<html lang="es">
	<head>
	    <!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	    
	    <style>
	    	@import url('https://fonts.googleapis.com/css?family=Rubik:300,400,500&display=swap');

			.alinearCentro
			{
				text-align: center;
			}

			.alinearIzquierda
			{
				text-align: left;
			}

			.alinearDerecha
			{
				text-align: right;
			}


			body
			{
				top: 0px;
				left: 0px;
				height: 900px;
				background: #F8FAFB 0% 0% no-repeat padding-box;
				opacity: 1;
			}

			p
			{
				margin: 0px;
			}

			#nombrePrincipal
			{
				margin-top: 47px;
			  	font-size: 20px;
			  	font-family: 'Rubik Regular', sans-serif;
				letter-spacing: -0.1px;
				color: #1B1E24;
				opacity: 1;
			}



			#contenidoMedio
			{
				margin: 0 auto;
				margin-top: 100px;
				max-width: 680px;
				min-width: 320px;
				height: 210px;
				background: #FFFFFF 0% 0% no-repeat padding-box;
				border: 1px solid #E8ECEF;
				opacity: 1;
			}


			.url
			{
				margin-top: 39px;

				text-decoration:none;
				font-size: 14px;
				font-family: 'Rubik Medium', sans-serif;
				color: white;
				background-color:#4D7CFE;
				border-radius: .25rem;

				width: 294px;
				line-height:46px;
				display:inline-block;
				cursor: pointer;
			}

			#nombreDerechos
			{
				margin-top: 38px;
				font-size: 12px;
				font-family: 'Rubik Regular', sans-serif;

				letter-spacing: -0.01px;
				color: #98A9BC;
				opacity: 1;
			}
	    </style>

	    

	    <title>Nueva Contraseña</title>
	</head>
  	<body>

  		<div id="contenidoMedio">
			<div >
				<div class="alinearCentro">
					<p id="nombrePrincipal">¡Está bien! Esto nos pasa a los mejores</p>
				</div>
			</div>

   			<div class="alinearCentro">
   				<a href="{{ url }}" class="url" style="color:white">RESTABLECER MI CONTRASEÑA</a>
   			</div>

   		</div>

		<div class="alinearCentro">
   			<p id="nombreDerechos">&copy; 2019 Innovadis | Todos los derechos reservados </p>
		</div>

  	</body>
</html>