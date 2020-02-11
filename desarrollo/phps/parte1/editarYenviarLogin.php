<?php
//Primero se inicia sesion y luego recien se edita valores
session_start();
$email = $_REQUEST['email'];
$pwd = $_REQUEST['pwd'];
$nombres = $_REQUEST['nombres'];
$apellidos = $_REQUEST['apellidos'];

$arr = array('correo'=>$email,'password'=>$email,'gettoken'=>'true');

$dataStringJson = json_encode($arr);

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => $_SESSION["base_del_url_ser"]."login",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "json=".$dataStringJson,
	CURLOPT_HTTPHEADER => array(
	  "Content-Type: application/x-www-form-urlencoded",
	  "cache-control: no-cache"
	),
  ));




$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) 
{
  echo "error";
} 
else 
{
	
  	//echo $response;

  	$dataArray = json_decode($response, true);

	  
	$_SESSION["token"] = $dataArray["token"];
	$_SESSION["message_code"] = $dataArray["message"];
    
    $ApiAuthorization =  "APIAuthorization: ".$dataArray["token"];
  	
  	if ( $dataArray["status"] === "success" ) 
  	{	
		
        //--------------------- Inicio Editar Datos --------------------
        $arr = array("nombre"=>$nombres,"apellido"=>$apellidos,"correo"=>$email, "password"=>$email,"movil"=>"1","idempresa"=>"1");
		$dataStringJson = json_encode($arr);
		
        $curl = curl_init();

        curl_setopt_array($curl, array(
			CURLOPT_URL => $_SESSION["base_del_url_ser"]."editarusuario",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "PUT",
			CURLOPT_POSTFIELDS => "json=".$dataStringJson,
			CURLOPT_HTTPHEADER => array(
				$ApiAuthorization
			),
        ));




        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) 
        {
        echo "error";
        } 
        else 
        {
          
			//echo $response;
			
			$dataArray = json_decode($response, true);

			
			$status = $dataArray["status"];
			
			if ( $status === "success" ) 
			{
				echo $status;
				
			}
			else
			{
				echo "error";
			}
        }
        //--------------------- Fin Editar Datos -----------------------  
  	}
  	else
  	{
  		echo "error";
	}
	  
}
?>