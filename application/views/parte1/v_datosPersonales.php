<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$nombres = $_GET['nombres']; 
$apellidos = $_GET['apellidos']; 
$pwd = $_GET['pwd']; 
$email = $_GET['email']; 

$inicialesNom = $nombres[0].$apellidos[0];
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


		<!-- Icon fonts -->
		<link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/fonts/fontawesome.css"; ?>>
		<link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/fonts/ionicons.css"; ?>>
		<link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/fonts/linearicons.css"; ?>>
		<link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/fonts/open-iconic.css"; ?>>
		<link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/fonts/pe-icon-7-stroke.css"; ?>>

		<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500&display=swap" rel="stylesheet">
		
		<link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte1/general.css"; ?> >
	    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte1/datosPersonales.css"; ?> >

	    

	    <title><?php echo $tituloP; ?> </title>
	</head>
  	<body onload="cargarEmpresas()">
    	
    	<?php $this->load->view('mensajeNaranja.php'); ?> 

	    <div class="container-fluid h-100 mh-100">

	    	
	    	<div class="row h-100 mh-100">
				<!--
					.col-    (screen width less than 576px)
					.col-sm- (screen width equal to or greater than 576px)
					.col-md- (screen width equal to or greater than 768px)
					.col-lg- (screen width equal to or greater than 992px)
					.col-xl- (screen width equal to or greater than 1200px)
				-->
	    		<!--panelIzquierdo -->
	    		<div class="col-12 col-sm-10 col-lg-9 d-flex justify-content-center">

	    			
					<div class="centrar pl-3">
						
						<p id="nombrePrincipal" class="nombres">Elige tu avatar</p>
						
						<div class="row">
								
							<div class="col-12 col-md-12 my-auto" style="">
								<table id="divAvatars" class="table text-center">
									<tr>
										<td>

											<button id="btnAvatarImg" class="rounded-circle">Sube tu foto</button>
											<input id="file" type="file" name="file" accept="image/*" onchange="myFunction(this)" hidden>

											
										</td>
										<td>o</td>
										<td><button id="btnAvatarColor" class="rounded-circle"> <?php echo $inicialesNom; ?> </button></td>
									</tr>
								</table>
							</div>
								
						</div>	
						
						<form class="needs-validation" novalidate  action="javascript:hagamoslo();">
							<p class="nombres">Perteneces al equipo de</p>
							<div class="row">
								<div class="col-12 mb-5 d-flex justify-content-start">
									<img id="imgEmpresa" class="rounded-circle" src="">
									<select id="idEmpresa" class="inputForm form-control" style="max-width: 359px;" onchange="cambiarLogo()" required autofocus>
									</select>
								</div>
							</div>

							<p class="nombres">Compártenos tu numero móvil</p>
							<div class="row">
								<div class="col-12 mb-5 d-flex justify-content-start">
									<img id="imgCel" src=<?php echo  $_SESSION["base_del_url"]."desarrollo/img/cel.svg"; ?> >	
									<input type="number" class="inputForm form-control" id="inputCelular" placeholder="+56" pattern="(?=.*\d).{6,}" required>									
								</div>
							</div>

							<div class="row">
								<div class="col-12">
									<button type="submit" id="buttonPrincipalOtro" class="btn btn-primary">LISTO</button>
								</div>
							</div>
						</form>
		    			
	    			</div>
	    			
				</div>

				<!--panelDerecho-->
				<div id="panelDerecho" class="col-12 col-sm-2 col-lg-3 h-100">
				</div> 
	    		
	    	</div>

		</div>

		<script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/verificarInputCorrecto.js"; ?> ></script>
	    <!-- Optional JavaScript -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


		<script>
			var base_del_url = '<?php echo $_SESSION["base_del_url"]; ?>'; 
			var base_del_url_ser = '<?php echo $_SESSION["base_del_url_ser"] ?>'; 
			var nombres = '<?php echo $nombres; ?>'; 
			var apellidos = '<?php echo $apellidos; ?>'; 
			var pwd = '<?php echo $pwd; ?>'; 
			var email = '<?php echo $email; ?>'; 
			var token = '<?php echo $_SESSION["token"]; ?>'; 
		</script>
	    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/parte1/datosPersonales.js"; ?> ></script>
	    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/general.js"; ?> ></script>
  	</body>
</html>