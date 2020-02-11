<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$nombres = $_GET['nombres']; 
$apellidos = $_GET['apellidos']; 
$pwd = $_GET['pwd']; 
$pwd = $_GET['pwd']; 
$email = $_GET['email']; 
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


		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500&display=swap" rel="stylesheet">
		
		<link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte1/general.css"; ?> >
	    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte1/bienvenido.css"; ?> >

	    

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
								<p id="nombrePrincipal">Bienvenido</p>
								<p id="nombreContacto"><?php echo $nombres." ".$apellidos;?></p>
								<p id="txtExtra">Nuestra misión es hacerte más productivo. <br>Solo te tomará un minuto</p>
								<button type="button" id="buttonPrincipalOtro" class="btn btn-primary" onclick="hagamoslo()">HAGÁMOSLO</button>
							</div>
		    			</div>
		    		
	    		</div>

	    		<!--panelDerecho-->
	    		<?php $this->load->view('parte1/panelDerecho.php'); ?> 
	    	</div>
		</div>
		
		<script>
			var base_del_url = '<?php echo $_SESSION["base_del_url"]; ?>'; 
			var nombres = '<?php echo $nombres; ?>'; 
			var apellidos = '<?php echo $apellidos; ?>'; 
			var pwd = '<?php echo $pwd; ?>'; 
			var email = '<?php echo $email; ?>'; 
			function hagamoslo()
			{
				var dir = base_del_url+"index.php/home/datosPersonales?nombres="+nombres+"&apellidos="+apellidos+"&pwd="+pwd+"&email="+email;
        		location.replace(dir);
			}
		
		</script>

		<script>
			$(document).keypress(function(event)
			{
				var keycode = (event.keyCode ? event.keyCode : event.which);
				if(keycode == '13')
				{
					hagamoslo(); 
				}
			});
		</script>

	</body>
</html>