<!-- Titulo  -->  
<div class="divTituloCabeceraDetalle d-flex justify-content-between">
    <!--<i class="lnr lnr-chevron-left"></i>  -->  
    <button class="btnBack" onclick="v_seleccionarUnaOT()">
        <i class="ion ion-ios-arrow-back"></i>
    </button>
    DETALLE OPERACIÓN
    <i></i>
</div>
<!-- Fin Titulo -->  

<!-- Cabecera  -->  
<div class="divCabeceraDetalle d-flex justify-content-between col-12">
    <div class="descripcionLadoIzquierdo w-100">
        <div class="divTxtInfo">
            <h4 id="nombreOperacion" class="txtItemTitulo">Nombre Operación (###)</h4>
        </div>

        <div>
            <div class="row">
                <div class="col-md">
                    <p><span class="text-muted">Fecha inicio:</span>&nbsp; <span id="fechaIniOperacion">20/02/2020</span></p>
                    <p><span class="text-muted">Fecha fin:</span>&nbsp; <span id="fechaFinOperacion"> 20/02/2020</span></p>
                </div>

                <div class="col-md">
                    <p><span class="text-muted">Trabajo:</span>&nbsp; <span id="trabajoOperacion">20</span> HH</p>
                    <p><span class="text-muted">Recursos:</span>&nbsp; <span id="trabajoRecursos">5</span> hrs</p>
                    <p><span class="text-muted">Duración:</span>&nbsp; <span id="trabajoDuracion">4</span> H</p>
                </div>
              
            </div>
        </div>

    </div>

    <div class="descripcionLadoDerecho">
        <h5><span id="EspecialdiadOperacion" class="badge badge-secondary badge-miIndicador">Especialidad</span></h5>
    </div>
</div>
<!-- Fin Cabecera  --> 

<!-- Contenido Opciones -->  
<div class="bd-example">

    <!-- Opciones (Nav) --> 
    <nav id="navOpcionesDetallesOpe" class="navbar">
        <ul class="nav nav-pills">
            <li class="nav-item flex">
                <a id="idNavOpcComentarios" class="nav-link normalNavOpciones" href="#sectionComentariosOpe" onclick="selectNavOpcCementatios()">COMENTARIOS</a>
                
	        </li>
        </ul>
    </nav>
    <!-- Fin Opciones (Nav) -->  


    <!-- Seccion de tabs -->
    
    <div id="divOpcionesDetalleOpe" class="divOpcionesDetalle" data-spy="scroll" data-target="#navOpcionesDetallesOpe" data-offset="0" class="scrollspy-example">

        <!-- Seccion General --> 
        <div id="sectionComentariosOpe" class="seccionOpcionesDetalles" style="border: 0;">

            <!--
            <div class="card car-chat">
                <div class="card-body">
                    <div class="media">
                        <img src="<?php echo $_SESSION["base_del_url"]."desarrollo/img/5.png"; ?>" alt class="d-block ui-w-40 rounded-circle">
                        <div class="media-body ml-4">
                            <a href="javascript:void(0)">Nellie Maxwell</a>
                            <div class="text-muted small">02/02/2020 &nbsp; 08:50 am</div>
                            <div class="mt-2">
                                Nulla mollis sem id tempus pharetra. Mauris finibus eros et leo ultricies volutpat. Nunc in lacus nec ex posuere gravida. Mauris metus nulla, mollis at felis vitae, congue ullamcorper velit. In vulputate dui sapien, in placerat tellus pellentesque ac. Duis pretium ex felis, sed vulputate orci efficitur id. Vivamus nec mauris ex. Nullam sed dolor id augue elementum ullamcorper. Donec sit amet consectetur erat.
                            </div>
                            <div class="mt-2">
                                <img src="<?php echo $_SESSION["base_del_url"]."desarrollo/img/5.png"; ?>" alt class="imgAdjuComentarios">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card car-chat">
                <div class="card-body">
                    <div class="media">
                        <button class="btn btnAvatarUsuario">JG</button>
                        <div class="media-body ml-4">
                            <a href="javascript:void(0)">Nellie Maxwell</a>
                            <div class="text-muted small">02/02/2020 &nbsp; 08:50 am</div>
                            <div class="mt-2">
                                Nulla mollis sem id tempus pharetra. Mauris finibus eros et leo ultricies volutpat. Nunc in lacus nec ex posuere gravida. Mauris metus nulla, mollis at felis vitae, congue ullamcorper velit. In vulputate dui sapien, in placerat tellus pellentesque ac. Duis pretium ex felis, sed vulputate orci efficitur id. Vivamus nec mauris ex. Nullam sed dolor id augue elementum ullamcorper. Donec sit amet consectetur erat.
                            </div>
                            <div class="mt-2">
                                <img src="<?php echo $_SESSION["base_del_url"]."desarrollo/img/imgAmplia.jpg"; ?>" alt class="imgAdjuComentarios">
                                <img src="<?php echo $_SESSION["base_del_url"]."desarrollo/img/5.png"; ?>" alt class="imgAdjuComentarios">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card car-chat">
                <div class="card-body">
                    <div class="media">
                        <img src="<?php echo $_SESSION["base_del_url"]."desarrollo/img/5.png"; ?>" alt class="d-block ui-w-40 rounded-circle">
                        <div class="media-body ml-4">
                            <a href="javascript:void(0)">Nellie Maxwell</a>
                            <div class="text-muted small">02/02/2020 &nbsp; 08:50 am</div>
                            <div class="mt-2">
                                Nulla mollis sem id tempus pharetra. Mauris finibus eros et leo ultricies volutpat. Nunc in lacus nec ex posuere gravida. Mauris metus nulla, mollis at felis vitae, congue ullamcorper velit. In vulputate dui sapien, in placerat tellus pellentesque ac. Duis pretium ex felis, sed vulputate orci efficitur id. Vivamus nec mauris ex. Nullam sed dolor id augue elementum ullamcorper. Donec sit amet consectetur erat.
                            </div>
                            <div class="mt-2">
                                <img src="<?php echo $_SESSION["base_del_url"]."desarrollo/img/5.png"; ?>" alt class="imgAdjuComentarios">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card car-chat">
                <div class="card-body">
                    <div class="media">
                        <button class="btn btnAvatarUsuario">JG</button>
                        <div class="media-body ml-4">
                            <a href="javascript:void(0)">Nellie Maxwell</a>
                            <div class="text-muted small">02/02/2020 &nbsp; 08:50 am</div>
                            <div class="mt-2">
                                Nulla mollis sem id tempus pharetra. Mauris finibus eros et leo ultricies volutpat. Nunc in lacus nec ex posuere gravida. Mauris metus nulla, mollis at felis vitae, congue ullamcorper velit. In vulputate dui sapien, in placerat tellus pellentesque ac. Duis pretium ex felis, sed vulputate orci efficitur id. Vivamus nec mauris ex. Nullam sed dolor id augue elementum ullamcorper. Donec sit amet consectetur erat.
                            </div>
                            <div class="mt-2">
                                <img src="<?php echo $_SESSION["base_del_url"]."desarrollo/img/imgAmplia.jpg"; ?>" alt class="imgAdjuComentarios">
                                <img src="<?php echo $_SESSION["base_del_url"]."desarrollo/img/5.png"; ?>" alt class="imgAdjuComentarios">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            -->


            
            
        </div>
        <!-- Fin Seccion General --> 
    </div>
    <!-- Fin Seccion de tabs -->


</div>
