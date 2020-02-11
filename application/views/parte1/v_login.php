<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo "string";
?>

<!doctype html>
<html lang="es">
	<head>
	    <!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

		<!--
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
-->
		<script src="https://code.jquery.com/jquery-3.2.1.js"></script>

		<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500&display=swap" rel="stylesheet">
		
		<link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte1/general.css"; ?> >
	    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte1/login.css"; ?> >

	    
	    
	    
	    
	    

	    <title><?php echo $tituloP; ?> </title>
	</head>
  	<body>
    	
  		<?php $this->load->view('mensajeNaranja.php'); ?> 
	    <div class="container-fluid h-100 mh-100">
	    	
	    	<div class="row h-100 mh-100">

	    		<!--panelIzquierdo-->
	    		<div class="col-md-6" >

	    			<div class="row">
		    			<div class="col-12 alinearTCentro">
		    				<img id="logo" src=<?php echo $_SESSION["base_del_url"]."desarrollo/img/Logo_Centinela.png";?> >	
		    			</div>
		    		</div>
		    			
		    		<div class="row">
		    			<div class="col-12 alinearTCentro">
		    				<p id="nombreGerencia">GERENCIA MANTENIMIENTO <br> CONCENTRADORA</p>
		    			</div>
		    		</div>
						
					<div class="row">
		    			<div class="col-12 col-sm-8 col-md-10 col-lg-8 col-xl-6 centrar">
			    			<p id="nombrePrincipal">Inicia sesión</p>
			    			<form id="formEtiqueta" class="needs-validation" novalidate  action="javascript:accionLogin();">
			    				<div class="form-group">
			    					<label for="email" class="labelForm">Correo</label>
			    					<input type="email" class="form-control inputForm" id="email" placeholder="Ingresa su correo" autofocus required>									
			    				</div>
							  	<div class="form-group">
							    	<label for="pwd" class="labelForm">Contraseña</label>
							    	<input type="password" class="form-control inputForm" id="pwd" placeholder="Escribe tu contraseña" pattern="(?=.*\d)(?=.*[a-z]).{6,}" required>
							  	</div>
							  	<div class="form-group form-check">
							    	<p id="nombreRecuperarContrasena" class="alinearTDerecha" onclick="recuperarContrasena()">Recuperar mi contraseña</p>
							  	</div>
							  	<button type="submit" id="buttonPrincipal" class="btn btn-primary btn-block">CONTINUAR</button>
							</form>
						</div>
					</div>
		    		
	    		</div>
	    	

	    		<!--panelDerecho-->
	    		<?php $this->load->view('parte1/panelDerecho.php'); ?> 

	    	</div>
	    </div>
		
		
		<script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/verificarInputCorrecto.js"; ?> ></script>
	    <!-- Optional JavaScript -->
	    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/parte1/login.js"; ?> ></script>
	    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/general.js"; ?> ></script>
	    <script type="text/javascript">
			var base_del_url = '<?php echo $_SESSION["base_del_url"] ?>'; 
			var base_del_url_miApi = '<?php echo $_SESSION["base_del_url_miApi"] ?>';
	    	//console.log(base_del_url);
	    </script>

	    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
	    
  	</body>
</html>