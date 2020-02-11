<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!doctype html>
<html lang="es">
	<head>
	    <!-- Required meta tags -->
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

		<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
		
		<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500&display=swap" rel="stylesheet">
		
	    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte1/general.css"; ?> >
	    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte1/recuperarContrasena.css"; ?> >

	    

	    

	    <title><?php echo $tituloP; ?> </title>
	</head>
  	<body>
    	
    	<?php $this->load->view('mensajeNaranja.php'); ?> 

	    <div class="container-fluid h-100 mh-100">

	    	
	    	<div class="row h-100 mh-100">

	    		<!--panelIzquierdo-->
	    		<div class="col-md-6">

	    			<div class="row">
		    			<div class="col-12 col-sm-8 col-md-10 col-lg-8 col-xl-6 centrar">
			    			<p id="nombrePrincipal">Recupera tu contraseña</p>
			    			<form id="formEtiqueta" class="needs-validation" novalidate  action="javascript:accionEnviarEnlace();">
			    				<div class="form-group">
			    					<label for="email" class="labelForm">Correo</label>
			    					<input type="email" class="form-control inputForm" id="email" placeholder="Ingresa tu correo" autofocus required>
			    				</div>
								  	
							  	<button type="submit" id="buttonPrincipal" class="btn btn-primary btn-block">ENVIAR ENLACE</button>
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
	    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/parte1/recuperarContrasena.js"; ?> ></script>
	    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/general.js"; ?> ></script>
	    <script type="text/javascript">
	    	var base_del_url = '<?php echo $_SESSION["base_del_url"] ?>'; 
	    </script>

  	</body>
</html>