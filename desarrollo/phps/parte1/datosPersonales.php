<?php
session_start();
$email = $_REQUEST['email'];
$pwd = $_REQUEST['pwd'];
$nombres = $_REQUEST['nombres'];
$apellidos = $_REQUEST['apellidos'];
$celular = $_REQUEST['celular'];
$idEmpresa = $_REQUEST['idEmpresa'];

$arr = array('nombre'=>$nombres,'apellido'=>$apellidos,'correo'=>$email, 'password'=>$pwd,'movil'=>$celular,'idempresa'=>$idEmpresa);
$dataStringJson = json_encode($arr);

$ApiAuthorization =  "APIAuthorization: ".$_SESSION["token"];

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
        echo $_SESSION["base_del_url"]."index.php/home/plataforma";
            
    }
    else
    {
        echo $dataArray["status"];
    }
}

?>