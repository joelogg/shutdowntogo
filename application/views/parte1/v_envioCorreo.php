<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
		
		<link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte1/general.css"; ?> >
	    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte1/envioCorreo.css"; ?> >
	    

	    
	    

	    

	    <title><?php echo $tituloP; ?> </title>
	</head>
  	<body>
    
	    <div class="container-fluid h-100 mh-100">
	    	<div class="row h-100 mh-100">

	    		<!--panelIzquierdo-->
	    		<div class="col-md-6">

	    			<div class="col-12 col-sm-8 col-md-10 col-lg-8 col-xl-6 centrar">
		    			<div class="row">
		    				<div class="centrar">
		    					<img id="imagen" src=<?php echo $_SESSION["base_del_url"]."desarrollo/img/imgEnvioCorreo.svg";?>>	
		    				</div>
		    			</div>
		    			
		    			<div class="row">
		    				<div class="centrar">
		    					<p id="nombrePrincipal">Te enviamos un enlace de recuperación</p>
		    				</div>
		    			</div>

		    			<div class="row">
		    				<div class="centrar">
			    				<p id="nombreRevisa">revisa tu bandeja de entrada</p>
							</div>
		    			</div>
		    		</div>
	    		</div>

	    		<!--panelDerecho-->
	    		<?php $this->load->view('parte1/panelDerecho.php'); ?> 
	    	</div>
	    </div>



	    <!-- Optional JavaScript -->
	    

	    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
	    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  	</body>
</html>