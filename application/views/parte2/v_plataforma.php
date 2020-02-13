<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es" class="default-style">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Plataforma</title>


    <!-- Icon fonts -->
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/fonts/fontawesome.css"; ?>>
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/fonts/ionicons.css"; ?>>
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/fonts/linearicons.css"; ?>>
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/fonts/open-iconic.css"; ?>>
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/fonts/pe-icon-7-stroke.css"; ?>>
    
    
    <!--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>--->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <!-- Tabla orden trabajo stylesheets -->
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/libs/datatables/datatables.css"; ?>>

    <!-- scrollbar -->
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"; ?>>

    <!-- graficos -->
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/libs/c3/c3.css"; ?>>

    <!-- chat -->
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/css/pages/chat.css"; ?>>

    <!-- demo icono de notificaciones-->
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/css/demo.css"; ?>>

    <!-- chat -->
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/css/rtl/uikit.css"; ?>>

    <!-- select -->
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/libs/select2/select2.css"; ?>>




    
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/css/rtl/bootstrap.css"; ?>>
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."assets/vendor/css/rtl/appwork.css"; ?>>

    
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte2/maquetacionGeneral.css"; ?>>
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte2/ordenTrabajo.css"; ?>>
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte2/dashBoard.css"; ?>>
    <link rel="stylesheet" href=<?php echo $_SESSION["base_del_url"]."desarrollo/css/parte2/modalPerfilAjustes.css"; ?>>
    
    
    <!-- cargaDatosPrevios -->
    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/parte2/cargaDatosPrevios.js"; ?> ></script>
    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/parte2/global.js"; ?> ></script>


</head>

<body onload="isMobile(), verificarMostrarMenuLateral()"> 










    <div id="ventana" class="h-100">
        <?php $this->load->view('mensajeNaranja.php'); ?> 
        <div id="fondoOscuro"></div>

        <!-- Panel Izquierdo -->
        <?php $this->load->view('parte2/panelIzquierdo.php'); ?> 

        <div id="contenidoVentana">
            
            <!-- Inicio menu superior -->
            <?php $this->load->view('parte2/franjaSuperior.php'); ?> 
            <!-- Din menu superior -->
            
            <!-- Inicio Contenido central -->
            <?php $this->load->view('parte2/contenidoInicio.php'); ?> 
            <!-- Fin Contenido central -->
            
            

        </div>

    </div>



    <!--panelDerecho-->
    <?php $this->load->view('parte2/popUps.php'); ?> 
    

    
    <script>
    
        

    var urlDescargarApi = '<?php echo $_SESSION["base_del_url"]."index.php/home/descargaApi"; ?>';
    var esMovil = false;
    function isMobile()
    {
        var isMobile = {
            Android: function() { return navigator.userAgent.match(/Android/i); },
            BlackBerry: function() { return navigator.userAgent.match(/BlackBerry/i); },
            iOS: function() { return navigator.userAgent.match(/iPhone|iPad|iPod/i); }, 
            Opera: function() { return navigator.userAgent.match(/Opera Mini/i); },
            Windows: function() { return navigator.userAgent.match(/IEMobile/i); }, 
            any: function() { return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows()); }
        };

        if(isMobile.any()) 
        {
            esMovil = true;
            if(isMobile.iOS()) 
            {
                //location.replace(urlDescargarApi+"?dispositivo=iOS");
            }
            else
            {
                //location.replace(urlDescargarApi+"?dispositivo=Android");
            }
            
        }
        //else
        {
            //v_seleccionarDashBoard();           
            v_seleccionarOrdenesTrabajo();
            
        }
        
        /*if(isMobile.BlackBerry()) {
          console.log('Esto es un dispositivo BlackBerry');
        }
        if(isMobile.iOS()) {
          console.log('Esto es un dispositivo iOS');
        }
        if(isMobile.Opera()) {
          console.log('Esto es un dispositivo Opera');
        }
        if(isMobile.Windows()) {
            console.log('Esto es un dispositivo Windows');
        }*/

        //$('#modalUsuarios').modal('show')
        //selectUsuarios();

    }

    </script>
 
    
    <!-- tabla Orden trabajo -->
    <script src=<?php echo $_SESSION["base_del_url"]."assets/vendor/libs/datatables/datatables.js"; ?> ></script>

    <!-- scrollbar -->
    <script src=<?php echo $_SESSION["base_del_url"]."assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"; ?> ></script>

    <!-- graficos -->
    <script src=<?php echo $_SESSION["base_del_url"]."assets/vendor/libs/d3/d3.js"; ?> ></script>
    <script src=<?php echo $_SESSION["base_del_url"]."assets/vendor/libs/c3/c3.js"; ?> ></script>

    <!-- chat -->
    <script src=<?php echo $_SESSION["base_del_url"]."assets/js/pages_chat.js"; ?> ></script>

    <!-- select -->
    <script src=<?php echo $_SESSION["base_del_url"]."assets/vendor/libs/select2/select2.js"; ?> ></script>

  



    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/verificarInputCorrecto.js"; ?> ></script>
    <!-- Optional JavaScript -->
    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/general.js"; ?> ></script>
    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/parte2/maquetacion.js"; ?> ></script>
    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/parte2/controlesVistas.js"; ?> ></script>
    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/parte2/perfilAjustesEtc.js"; ?> ></script>
    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/parte2/listaOrdenTrabajo.js"; ?> ></script>
    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/parte2/detalleOrdenTrabajo.js"; ?> ></script>
    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/parte2/detalleOperaciones.js"; ?> ></script>
    <script src=<?php echo $_SESSION["base_del_url"]."desarrollo/js/parte2/dashboard.js"; ?> ></script>
    
	<script type="text/javascript">
        var base_del_url = '<?php echo $_SESSION["base_del_url"] ?>'; 
        var base_del_url_miApi = '<?php echo $_SESSION["base_del_url_miApi"] ?>';
        var token = '<?php echo $_SESSION["token"] ?>';


        
    </script>



    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>



</body>

</html>