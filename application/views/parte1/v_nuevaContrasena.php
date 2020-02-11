<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$cod = $_GET['cod']; 
?>

<!doctype html>
<html lang="es">
	<head>
	    <!-- Required meta tags -->
	    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

		<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
		
		<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500&display=swap" rel="stylesheet">
		
		<link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte1/general.css"; ?> >
	    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte1/nuevaContrasena.css"; ?> >

	    

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
			    				<p id="nombrePrincipal">Crea tu nueva contraseña</p>
			    				<form id="formEtiqueta" class="needs-validation" novalidate  action="javascript:crearContrasena();">
			    					<div class="form-group">
			    						<label for="pwd" class="labelForm">Escribe tu nueva contraseña</label>
			    						<input type="password" class="form-control inputForm" id="pwd" placeholder="Ingresa contraseña" pattern="(?=.*\d)(?=.*[a-z]).{6,}" autofocus required>
			    						<span id="txtEscribeMin">Escribe mínimo 6 carácteres (al menos un número y una letra)</span>
			    					</div>
								  	<div class="form-group">
								    	<label for="pwdConfirma" class="labelForm">Confirma</label>
								    	<input type="password" class="form-control inputForm" id="pwdConfirma" placeholder="Confirma contraseña" pattern="(?=.*\d)(?=.*[a-z]).{6,}" required>
								  	</div>
								  	<button type="submit" id="buttonPrincipal" class="btn btn-primary btn-block">CREAR MI CONTRASEÑA</button>
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
	    <script type="text/javascript">
	    	var base_del_url = '<?php echo $_SESSION["base_del_url"] ?>'; 
	    	var cod = '<?php echo $cod; ?>';
	    </script>
	    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/parte1/nuevaContrasena.js"; ?> ></script>
	    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/general.js"; ?> ></script>
  	</body>
</html>