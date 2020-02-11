<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$email = $_GET['correo']; 
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
	    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte1/registrate.css"; ?> >

	    

	    <title><?php echo $tituloP; ?> </title>
	</head>
  	<body>
    	
    	<?php $this->load->view('mensajeNaranja.php'); ?> 

	    <div class="container-fluid h-100 mh-100">
	    	
	    	<div class="row h-100 mh-100">

	    		<!--panelIzquierdo-->
	    		<div class="col-md-6">


		    			<div class="row">
		    				<div class="col-12 col-sm-8 col-md-10 col-lg-9 col-xl-6 centrar">
			    				<p id="nombrePrincipal">Regístrate</p>
			    				<form id="formEtiqueta" class="needs-validation" novalidate  action="javascript:uneteAlEquipo();">
									<div class="form-group">
										<label class="labelForm">Nombre y Apellidos</label>
										<!--
										<table class="col-12">
											<tr>
												<td><input type="text" class="inputForm" id="inputNombres" placeholder="Nombres"></td>
												<td><input type="text" class="inputForm" id="inputApellidos" placeholder="Apellidos"></td>
											</tr>
										</table>
										-->
										<div class="row">
											<div class="col-md-12 col-lg-6 md-pr-0"><input type="text" class="form-control inputForm" id="inputNombres" placeholder="Nombres" autofocus required></div>
											<div class="col-md-12 col-lg-6 md-pr-0"><input type="text" class="form-control inputForm" id="inputApellidos" placeholder="Apellidos" required></div>
										</div>
										
								  	</div>
									<div class="form-group">
								    	<label class="labelForm">Correo</label>
										<p id=correoLeido><?php echo $email;?></p>
								  	</div>
			    					<div class="form-group">
			    						<label for="pwd" class="labelForm">Contraseña</label>
			    						<div class="input-group">
											<input id="pwd" type="password" class="inputForm form-control" placeholder="Crea una contraseña" pattern="(?=.*\d)(?=.*[a-z]).{6,}" required>
											<div class="input-group-append">
												<button id="show_password" class="btn" type="button" onclick="mostrarPassword()" style="border: 1px solid #E8ECEF;"> 
													<span class="fa fa-eye-slash icon"></span> 
												</button>
											</div>
										</div>
										<span id="txtEscribeMin">Escribe mínimo 6 carácteres (al menos un número y una letra)</span>
			    					</div>
								  	

        
        

								  	<button type="submit" id="buttonPrincipal" class="btn btn-primary btn-block">ÚNETE AL EQUIPO</button>
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
			function mostrarPassword(){
					var cambio = document.getElementById("pwd");
					if(cambio.type == "password"){
						cambio.type = "text";
						$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
					}else{
						cambio.type = "password";
						$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
					}
				} 
				
				$(document).ready(function () {
				//CheckBox mostrar contraseña
				$('#ShowPassword').click(function () {
					$('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
				});
			});
		</script>
		
	    <script type="text/javascript">
			var base_del_url = '<?php echo $_SESSION["base_del_url"] ?>'; 
			var email = '<?php echo $email; ?>';
	    </script>
	    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/parte1/registrate.js"; ?> ></script>
	    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/general.js"; ?> ></script>
  	</body>
</html>