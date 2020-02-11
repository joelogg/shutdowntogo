<?php
session_start();
$email = $_REQUEST['email'];





$url = $_SESSION["base_del_url_ser"]."enviaremailrecuperarpassword?correo=".$email."&url=".$_SESSION["base_del_url"]."index.php/home/nuevaContrasena";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "code: 3juhd73hu476ru4"
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
  	$dataArray = json_decode($response, true);

  	
  	if ( $dataArray["status"] === "success" ) 
  	{
      echo $_SESSION["base_del_url"]."index.php/home/envioDeCorreo";
  	}
  	else
  	{
  		echo "error";
    }
}
?>