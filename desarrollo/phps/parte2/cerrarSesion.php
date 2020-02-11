<?php
session_start();


$ApiAuthorization =  "APIAuthorization: ".$_SESSION["token"];

$curl = curl_init();


curl_setopt_array($curl, array(
	CURLOPT_URL => $_SESSION["base_del_url_ser"]."logoutusuario",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_HTTPHEADER => array($ApiAuthorization)
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
    session_destroy();
    echo $_SESSION["base_del_url"];

/*
  	if ( $dataArray["status"] === "success" ) 
  	{
		  
      session_destroy();
      echo $_SESSION["base_del_url"];		  
  	}
  	else
  	{
  		if ($dataArray["message"]==="token inválido")
        {
            session_destroy();
        }
        echo $dataArray["status"];
	   }
     */
}
