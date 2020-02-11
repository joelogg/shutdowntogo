<?php
session_start();

$token = $_SESSION["token"];

$curl = curl_init();
$token = curl_escape($curl, $token);

curl_setopt($curl, CURLOPT_URL, $_SESSION["base_del_url_miApi"]."api/cerrarSesion");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_ENCODING, "");
curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
curl_setopt($curl, CURLOPT_TIMEOUT, 30);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_POSTFIELDS, "token=".$token);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded"
  ));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);


session_destroy();

?>