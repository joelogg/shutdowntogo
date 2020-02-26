<!-- Modal Mi Perfil -->
<div class="modal fade" id="modalMiperfil" >
    <div class="modal-dialog modal-dialog-centered modal-lg tamModal">
        <div class="modal-content" style="min-height: 681px;">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <div>
                    <div class="pb-2 btn-group">
                        <?php
                            if($usuarioActual->imagen==null || $usuarioActual->imagen=="")
                            {
                                if($usuarioActual->nombre==null || $usuarioActual->nombre=="" || $usuarioActual->apellido==null || $usuarioActual->apellido=="")
                                {
                                    echo '<div class="modal-title txtFotoPerfilPopUp">'.substr($usuarioActual->correo, 0, 2).'</div>';
                                }
                                else
                                {
                                    echo '<div class="modal-title txtFotoPerfilPopUp">'.substr($usuarioActual->nombre, 0, 1).substr($usuarioActual->apellido, 0, 1).'</div>';
                                }
                            }
                            else
                            {
                                echo '<img class="txtFotoPerfilPopUp" src="'.$_SESSION["base_del_url"].$usuarioActual->imagen.'" alt="">';

                            }
                        ?>
                        <span class="ml-3 modal-title pt-4"><?php echo $usuarioActual->nombre." ".$usuarioActual->apellido; ?></span>
                    </div>
                    <div> <?php echo $usuarioActual->perfil; ?> </div>
                    
                    <button type="button" class="close" data-dismiss="modal" style="top:20%;"><i class="ion ion-ios-close-circle-outline aclarar"></i></button>
                </div>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                
                <div class="nav-tabs-top">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#navs-general">GENERAL</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-general">
                            <div class="card-body">
                                <div>
                                <div class="row">
                                    <div class="col-md">
                                        <p><b>Correos:</b></p>
                                        <p>
                                            <span class="text-muted">Actual:</span><br>
                                            <?php echo $usuarioActual->correo; ?>
                                        </p>
                                    </div>

                                    <div class="col-md">
                                        <p><b>Número Telefónico</b></p>
                                        <p>
                                            <span class="text-muted">Móvil:</span><br>
                                            <?php echo $usuarioActual->movil; ?>
                                        </p>
                                    </div>
                                
                                </div>
                            </div>
                                
                            </div>
                        </div>
                    </div>
                </div>


               
            
            </div>
            <!--
            <div class="modal-footer footerPerfil" style="border-top: 0;">
                <button class="btnsPopUp">Actualizar</button>
                
            </div>
            -->
            
        </div>
    </div>
</div>




<!-- Modal Usuarios -->
<div class="modal fade" id="modalUsuarios" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg tamModal">
        <div class="modal-content" style="min-height: 681px;">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <p class="modal-title">Usuarios</p>
                <button type="button" class="close" data-dismiss="modal"><i class="ion ion-ios-close-circle-outline aclarar"></i></button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                
                <div class="nav-tabs-top">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#navs-usuarios">USUARIOS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#navs-importar">IMPORTAR</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#navs-exportar">EXPORTAR</a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        <!-- Tab Usuarios -->
                        <div class="tab-pane fade show active" id="navs-usuarios">
                            <div id="divTablaListusuarios" class="card-body text-center table-responsive-lg">

                                <table id="tablaListusuarios" class="table table-hover">
                                    <!--
                                    <tbody>
                                        <tr>
                                            <td><img src="<?php echo $_SESSION["base_del_url"]."desarrollo/img/5.png"; ?>" height="40" width="40" class="ui-w-40 rounded-circle" alt=""></td>
                                            <td>Joel Gallegos</td>
                                            <td>joel.o.gallegos.@gmail.com</td>
                                            <td>perfil</td>
                                        </tr>

                                        
                                    </tbody>
                                    -->
                                </table>

                            </div>

                            <div class="modal-footer-personalizado">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="titFooterModal">Invitar más usuarios</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="email" class="labelAjustes">Correo:</label>
                                            </div>
                                            <div class="col-6 col-lg-3">
                                                <label for="email" class="labelAjustes">Rol:</label>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                            </div>

                                            <div class="col-6 mb-2">
                                                <input type="email" class="form-control inputAjustes" id="inputEmail" placeholder="Ingrese correo o lista de correos">
                                            </div>
                                            <div class="col-6 col-lg-3">
                                            <select id="selectPerfilesUsuarios" class="form-control inputAjustes">
                                                <option value="">SELECCIONAR</option>
                                            </select>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <button class="btnsPopUp" onclick="inviatarUsuario()">Añadir</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                        <!-- Fin Tab Usuarios -->

                        <!-- Tab Importar -->
                        <div class="tab-pane fade" id="navs-importar">
                            <div class="card-body">
                                
                                <button id="btnImportarUsuariosPre" class="btnImportarExportar" onclick="clickSubirArchivoUsuarios()">
                                    <img src=<?php echo $_SESSION["base_del_url"]."desarrollo/img/csv.svg"; ?>>
                                    <p class="txtImportarExportar pt-3">Seleccione un archivo CSV para subir usuarios</p>
                                </button>
                                <p id="idTxtVistaPrevia" class="txtVistaPrevia"></p>
                                <form action="javascript:subirArchivoUsuarios()">
                                    <!--<input type="file" id="fileCsvUsuarios" multiple accept=".csv" style="display:none" onchange="handleFiles(this.files)">-->
                                    <input type="file" id="fileCsvUsuarios" accept=".csv" style="display:none" onchange="handleFilesCsvUsuarios(this.files)">
                                    <table id="listUsuariosPre" class="table table-hover"></table>
                                </form>

                            </div>
                            <div class="modal-footer-personalizado">
                                <button class="btnsPopUp" onclick="subirArchivoUsuarios()">Importar</button>
                            </div>
                        </div>
                        <!-- Fin Tab Importar -->

                        <!-- Tab Exportar -->
                        <div class="tab-pane fade" id="navs-exportar">
                            <div class="card-body">
                                
                            </div>
                        </div>
                        <!-- Tab Exportar -->
                    </div>
                </div>


            </div>

            <!--
            <div class="modal-footer footerPerfil" style="border-top: 0;">
                <button class="btnsPopUp">Actualizar</button>
            </div>
            -->
            
        </div>
    </div>
</div>

<!--confirmacion de eliminar usuario -->
<div class="modal fade" id="modalConfirmaEliminarUsu" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">¿Desea eliminar?</h4>
            </div>
            <div class="modal-body">
                <p id="nomAEliminar"></p>
                <input type="text" id="idU" hidden>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="eliminarusuario()">Eliminar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>




<!-- Modal Nuevo Proyecto-->
<div class="modal fade" id="modalNuevoProyecto" >
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <p class="modal-title" id="tituloAnadirUsuario">Nuevo Proyecto</p>
                <button type="button" class="close" data-dismiss="modal"><i class="ion ion-ios-close-circle-outline aclarar"></i></button>
            </div>
            
            
            <!-- Modal body -->
            
            <div class="modal-body">
                <div id="contenidoModal">
                    
                        <div class="row pl-2 pr-2">

                            
                            
                            <div class="form-group col-12">
                                <label class="labelFormNuevoProyecto">Nombre del proyecto</label>
                                <input type="text" class="form-control inputFormNuevoProyecto" id="nomProyecto" placeholder="Escribe el nombre del nuevo proyecto">
                            </div>
                            <div class="form-group col-12">
                                <label class="labelFormNuevoProyecto">Descripción</label>
                                <textarea class="form-control areaFormNuevoProyecto" rows="5" id="descripcionProyecto" placeholder="Descripción corta del proyecto" style="resize: none;"></textarea>
                            </div>
                            <div class="d-flex justify-content-between pl-3 pr-3">
                                <div id="divFechaIniNP" class="pr-3">
                                    <form action="#" autocomplete="off">
                                        <label class="labelFormNuevoProyecto">Fecha de inicio planificada</label>
                                        <input id="fechaInicio" class="inputFormNuevoProyecto form-control" type="text"  value="" placeholder="Selecciona la fecha">
                                    </form>
                                </div>
                                <div id="divFechaFinNP" class="pr-3">
                                    <form action="#" autocomplete="off">
                                        <label class="labelFormNuevoProyecto">Fecha de fin planificada</label>
                                        <input id="fechaFin" class="inputFormNuevoProyecto form-control" type="text"  value="" onclick="abrirCalendarioNuevoProyecto()" placeholder="Selecciona la fecha">                               
                                    </form>
                                </div>                        
                                <div id="divIconoNP" class="mt-5">
                                        <i class="lnr lnr-calendar-full" onclick="abrirCalendarioNuevoProyecto()"></i>
                                </div>
                            </div>

                            <div class="form-group col-6">
                                <label class="labelFormNuevoProyecto">Duración planificada</label>
                                <input type="number" class="form-control inputFormNuevoProyecto" rows="5" id="duracionProyecto" onChange="calcularFecha()" placeholder="nº de días">
                            </div>

                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-primary btnNuevoProyecto" onclick=nuevoProyecto()>AÑADIR</button>
                            </div>
                            
                        </div>
                    
                </div>          
            </div>
        </div>
    </div>
</div>





<!-- Modal  Crear Alerta-->
<div class="modal fade" id="modalCrearAlerta" >
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <p class="modal-title" id="tituloAnadirUsuario">Nuevo Aviso</p>
                <button type="button" class="close" data-dismiss="modal"><i class="ion ion-ios-close-circle-outline aclarar"></i></button>
            </div>
            
            
            <!-- Modal body -->
            
            <div class="modal-body">
                <div id="contenidoModal">
                    
                        <div class="row pl-2 pr-2">

                            
                            
                            <div class="form-group col-12">
                                <label class="labelFormNuevoProyecto">Descripción</label>
                                <textarea class="form-control areaFormNuevoProyecto" rows="5" id="descripcionAlerta" placeholder="Descripción del aviso" style="resize: none;"></textarea>
                            </div>
                            <div class="form-group col-12">
                                <label class="labelFormNuevoProyecto">Categoría</label>
                                <select class="form-control areaFormNuevoProyecto" id="categoriaAlerta"  tyle="resize: none;">
                                    <option value="">Seleccione</option>
                                    <option value="Seguridad">Seguridad</option>
                                    <option value="Operaciones">Operaciones</option>
                                    <option value="Materiales">Materiales</option>
                                    <option value="Equipos">Equipos</option>
                                    <option value="Interferencias">Interferencias</option>
                                </select>
                            </div>

                            <div class="form-group col-6">
                                <label for="adjuntoAlerta">Seleccione adjunto:</label>
                                <input type="file" id="adjuntoAlerta" name="adjuntoAlerta" accept="image/*">
                            </div>

                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-primary btnNuevoProyecto" onclick=nuevaAlerta()>AÑADIR</button>
                            </div>
                            
                        </div>
                    
                </div>          
            </div>
        </div>
    </div>
</div>


<!-- Modal Importar OTs semana -->
<div class="modal fade" id="modalImportarOTs" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg tamModal">
        <div class="modal-content" style="min-height: 681px;">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <p class="modal-title">Importar OTs por semana</p>
                <button type="button" class="close" data-dismiss="modal"><i class="ion ion-ios-close-circle-outline aclarar"></i></button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                
                <div class="card-body pb-0">
                    <button id="btnImportarOTsSemana" class="btnImportarExportar" onclick="clickSubirOTsSemana()">
                        <img src=<?php echo $_SESSION["base_del_url"]."desarrollo/img/csv.svg"; ?>>
                        <p class="txtImportarExportar pt-3">Seleccione un archivo XLS para subir OTs</p>
                    </button>
                    <form action="javascript:subirOTsSemana()">
                        <input type="file" id="inputExcelOTs" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" style="display:none">
                    </form>
                    <p id="nomExcelImportOTs"></p>

                </div>
                
                <div class="card-body py-0" style="margin-bottom: 94px;">
                    <div id="encabezadoExcelOTs"></div>
                    <div class="table-responsive" style="max-height: 400px">
                        <table id="tablaExcelOTs" class="table table-hover table-sm"></table>
                    </div>
                </div>




            </div>
            <div class="modal-footer-personalizado">
                <button id="btnSubirExcelOts" class="btnsPopUp" onclick="subirOTsSemana()" disabled>Importar</button>
            </div>


            
        </div>
    </div>
</div>