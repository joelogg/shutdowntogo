<?php
session_start();
$token = $_SESSION["token"];



$curl = curl_init();


$token = curl_escape($curl, $token);

curl_setopt($curl, CURLOPT_URL, $_SESSION["base_del_url_miApi"]."api/ordenTrabajoListarTodo");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_POSTFIELDS, "token=".$token);



$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) 
{
	echo '{
        "data": [ ]
    }';
} 
else 
{
    $dataArray = json_decode($response, true);
    
    $dataArray = $dataArray['data'];
    
    $dataTabla = array();
    foreach ($dataArray as $valor) 
    {
        $descripcion = $valor['descripcion'];
        $ordentrabajo = '<span class="elementoListOT" onclick="v_seleccionarUnaOT('.$valor['id'].')">'.$valor['ordentrabajo'].'</span>' ;

        $status = "";
        if($status = $valor['atrasado']==1)
        {
            $status = '<span style="color:red">Atrazada</span>';
        }
        else
        {
            $status = $valor['estado'];
        }



        $prioridadColor = $valor['colorPrioridad'];
        $prioridadDescripcion = $valor['descripcionPrioridad'];
        if($prioridadDescripcion==null || $prioridadDescripcion=="")
        {
            $prioridadDescripcion = '-';
        }
        else
        {
            $prioridadDescripcion = '<span style="color:#'.$prioridadColor.'">' .$prioridadDescripcion. '</span>';
            $prioridadDescripcion = '<span style="color:#'.$prioridadColor.'">' .$prioridadDescripcion. '</span>';
        }

        $fechainicio = $valor['fechainicio'];
        if($fechainicio==null || $fechainicio=="")
        {
            $fechainicio = "-";
        }

        $fechafin = $valor['fechafin'];
        if($fechafin==null || $fechafin=="")
        {
            $fechafin = "-";
        }

        $responsables = $valor['responsable'];

        $nomResponsables = "";
        foreach ($responsables as $responsable) 
        {
            $nombre = explode(" ", $responsable['nombre'])[0];
            $apellido = explode(" ", $responsable['apellido'])[0];
            $nomResponsables = $nomResponsables.$nombre." ".$apellido."<br>";
        }

        $arr1 = array($ordentrabajo, $descripcion, $fechainicio, $fechafin, $status, $prioridadDescripcion, $nomResponsables);
        array_push($dataTabla, $arr1);
    }



    
  
    
    $dataTabla = array('data'=>$dataTabla);
    $dataTabla = json_encode($dataTabla);
          
      
    echo $dataTabla;
}






?>