<div id="menuSuperior">
    <!-- navbar-expand-(sm, md, lg, xl ) -->
    <nav class="navbar navbar-expand-lg navbar-light">

        <!-- btn toggle menu lateral -->
        <button id="btnToggleMenuLateral" class="mr-2">
            <i class="lnr lnr-menu"></i>
        </button>
        
        <div class="dropdown">
            <button id="dropdownMenuButton" class="btnAdd btn" data-toggle="dropdown"><i class="ion ion-md-add"></i></button>
            <div class="dropdown-menu dropdown-menu-lg-left" aria-labelledby="dropdownMenuButton">
                <button class="dropdown-item" type="button" data-toggle="modal" data-target="#modalImportarOTs" 
                    onclick="limpiarVentandaSubirOTs()">Importar OTs por semana</button>
            </div>
        </div>

        <!-- btn toggle menu superior -->
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Contenido del menu -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
            <!--
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            -->
            

            <ul class="navbar-nav align-items-lg-center ml-auto">
                
                

                <li class="nav-item">

                    <div class="demo-navbar-notifications nav-item dropdown mr-lg-3">
                        <a class="nav-link dropdown-toggle hide-arrow" href="#" data-toggle="dropdown">
                            <i class="ion ion-md-notifications-outline navbar-icon align-middle"></i>
                            <span class="badge badge-primary badge-dot indicator"></span>
                            <span class="d-lg-none align-middle">&nbsp; Notifications</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="bg-primary text-center text-white font-weight-bold p-3">
                                4 Nuecas Notificaciones
                            </div>
                            <div class="list-group list-group-flush">
                                <a href="javascript:void(0)" class="list-group-item list-group-item-action media d-flex align-items-center">
                                <div class="ui-icon ui-icon-sm ion ion-md-home bg-secondary border-0 text-white">
                                </div>
                                <div class="media-body line-height-condenced ml-3">
                                    <div class="text-body">Notificacion 1 </div>
                                    <div class="text-light small mt-1">
                                        Detalle notificacion 1.
                                    </div>
                                    <div class="text-light small mt-1">12h atras</div>
                                </div>
                                </a>

                                <a href="javascript:void(0)" class="list-group-item list-group-item-action media d-flex align-items-center">
                                <div class="ui-icon ui-icon-sm ion ion-md-person-add bg-info border-0 text-white"></div>
                                <div class="media-body line-height-condenced ml-3">
                                    <div class="text-body">Notificacion <strong>2</strong></div>
                                    <div class="text-light small mt-1">
                                        Detalle notificacion 2.
                                    </div>
                                </div>
                                </a>

                                <a href="javascript:void(0)" class="list-group-item list-group-item-action media d-flex align-items-center">
                                <div class="ui-icon ui-icon-sm ion ion-md-power bg-danger border-0 text-white"></div>
                                <div class="media-body line-height-condenced ml-3">
                                    <div class="text-body">Notificacion 3</div>
                                    <div class="text-light small mt-1">
                                    Detalle notificacion 3.
                                    </div>
                                </div>
                                </a>

                                <a href="javascript:void(0)" class="list-group-item list-group-item-action media d-flex align-items-center">
                                <div class="ui-icon ui-icon-sm ion ion-md-warning bg-warning border-0 text-body"></div>
                                <div class="media-body line-height-condenced ml-3">
                                    <div class="text-body">Notificacion 4</div>
                                    <div class="text-light small mt-1">
                                    Detalle notificacion 4_1.
                                    </div>
                                    <div class="text-light small mt-1">
                                    Detalle notificacion 4_2.
                                    </div>
                                </div>
                                </a>
                            </div>

                            <!--<a href="javascript:void(0)" class="d-block text-center text-light small p-2 my-1"></a>-->
                        </div>
                    </div>
                </li>
                
                
                <li class="nav-item">
                    <div class="dropdown">
                        <?php
                            if($usuarioActual->imagen==null || $usuarioActual->imagen=="")
                            {
                                if($usuarioActual->nombre==null || $usuarioActual->nombre=="" || $usuarioActual->apellido==null || $usuarioActual->apellido=="")
                                {
                                    echo '<div class="txtFotoPerfilMenu"  data-toggle="dropdown">'.substr($usuarioActual->correo, 0, 2).'</div>';
                                }
                                else
                                {
                                    echo '<div class="txtFotoPerfilMenu"  data-toggle="dropdown">'.substr($usuarioActual->nombre, 0, 1).substr($usuarioActual->apellido, 0, 1).'</div>';
                                }
                            }
                            else
                            {
                                echo '<img class="txtFotoPerfilMenu" src="'.$_SESSION["base_del_url"].$usuarioActual->imagen.'" alt=""  data-toggle="dropdown">';

                            }
                        ?>
                        
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalMiperfil">Perfil</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalUsuarios" onclick="selectUsuarios()">Usuarios</a>
                            <a class="dropdown-item" href="#" onclick="cerrarSesion()">Cerrar sesión</a>
                        </div>
                    </div>
                </li>
                
            </ul>
            
            
        </div>
    </nav>
    
</div>
    