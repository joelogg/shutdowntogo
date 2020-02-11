<!-- Modal Mi Perfil -->
<div class="modal fade" id="modalMiperfil" >
    <div class="modal-dialog modal-dialog-centered modal-lg tamModal">
        <div class="modal-content" style="min-height: 681px;">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <p class="modal-title">Configura tu perfil</p>
                <button type="button" class="close" data-dismiss="modal"><i class="ion ion-ios-close-circle-outline aclarar"></i></button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                
                <div class="nav-tabs-top">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#navs-general">GENERAL</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#navs-seguridad">SEGURIDAD</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#navs-notificaciones">NOTIFICACIONES</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-general">
                            <div class="card-body">
                                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-seguridad">
                            <div class="card-body">
                                <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-notificaciones">
                            <div class="card-body">
                                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
                            </div>
                        </div>
                    </div>
                </div>


               
            
            </div>

            <div class="modal-footer footerPerfil" style="border-top: 0;">
                <button class="btnsPopUp">Actualizar</button>
                
            </div>
            
            
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
