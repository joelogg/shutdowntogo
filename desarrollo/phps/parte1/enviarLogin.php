<?php
session_start();
$email = $_REQUEST['email'];
$pwd = $_REQUEST['pwd'];

$arr = array('correo'=>$email,'password'=>$pwd);

$dataStringJson = json_encode($arr);


$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $_SESSION["base_del_url_miApi"]."api/login");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_ENCODING, "");
curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
curl_setopt($curl, CURLOPT_TIMEOUT, 30);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_POSTFIELDS, "json=".$dataStringJson);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded"
  ));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) 
{
    $array = array("status" => "error");
	$array = json_encode($array);
	echo $array;
} 
else 
{
	$dataArray = json_decode($response, true);
	$_SESSION["token"] = $dataArray["data"];
	$_SESSION["message"] = $dataArray["message"];
  	echo $response;

}

?>