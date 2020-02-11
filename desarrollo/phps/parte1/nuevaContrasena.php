<?php
session_start();
$pwd = $_REQUEST['pwd'];
$cod = $_REQUEST['cod'];

$arr = array('cod'=>$cod,'password'=>(string)$pwd);

$dataStringJson = json_encode($arr);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $_SESSION["base_del_url_ser"]."recrearpassword",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "PUT",
  CURLOPT_POSTFIELDS => "json=".$dataStringJson,
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
	
  	//echo "\n".$response."\n";

  	$dataArray = json_decode($response, true);


  	$_SESSION["status"] = $dataArray["status"];
  	$_SESSION["code"] = $dataArray["code"];
  	$_SESSION["message"] = $dataArray["message"];

  	
  	if ( $_SESSION["status"] === "success" ) 
  	{
  		echo $_SESSION["base_del_url"]."index.php/home/contrasenaCambiada";
  	}
  	else
  	{
  		echo "error";
  	}
}

?>