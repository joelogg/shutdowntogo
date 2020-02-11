<?php
session_start();

$ApiAuthorization =  "APIAuthorization: ".$_SESSION["token"];



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $_SESSION["base_del_url_ser"]."empresa/listarempresa",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
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
        
    if ( $status === "succes" ) 
    {
        $data = $dataArray["data"];
        $misDatos = array();
        foreach($data as $empresa)
        {
            $idE = $empresa["id"];
            $nomE = $empresa["nombre"];
            $imagenE = $empresa["imagen"];
            $unaEpresa = array('id'=>$idE,'nombre'=>$nomE,'imagen'=>$imagenE);
            array_push($misDatos, $unaEpresa);
            
            
            

        }
        $dataStringJson = json_encode($misDatos);
        echo $dataStringJson;
    }

    else
    {
      echo "error";
    }
}
?>