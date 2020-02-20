<!-- Titulo  -->  
<div class="divTituloCabeceraDetalle d-flex justify-content-between">
    <!--<i class="lnr lnr-chevron-left"></i>  -->  
    <button class="btnBack" onclick="v_seleccionarListaOT()">
        <i class="ion ion-ios-arrow-back"></i>
    </button>
    DETALLE ORDEN DE TRABAJO
    <i></i>
</div>
<!-- Fin Titulo -->  

<!-- Cabecera  -->  
<div class="divCabeceraDetalle d-flex justify-content-between col-12">
    <div class="descripcionLadoIzquierdo">
        <div class="divTxtInfo">
            <h4 id="descripcionOT" class="txtItemTitulo">Nombre OT (#)</h4>
        </div>
        <div class="divTxtInfo">
            <button  id="tipoOT" class="btn" style="background: #fff; color: #4E5155; border:0; text-transform: uppercase;
                padding: .25rem .6875rem; font-size: .7575rem; line-height: 1.55; border-radius: .125rem;
                box-shadow: 0px 2px 4px -1px rgba(0,0,0,0.07), 0px 4px 5px 0px rgba(0,0,0,0.05), 0px 1px 10px 0px rgba(0,0,0,0.03);">
                Tipo 1</button>
        </div>
    </div>

    <div class="descripcionLadoDerecho">
        <h5 id="estadoOT"><span class="badge badge-secondary badge-miIndicador">Estado</span></h5>
        <h5 id="prioridadOT"><span class="badge badge-success badge-miIndicador">Prioridad</span></h5>
    </div>
</div>
<!-- Fin Cabecera  --> 

<!-- Contenido Opciones -->  
<div class="bd-example">

    <!-- Opciones (Nav) --> 
    <nav id="navOpcionesDetallesOT" class="navbar">
        <ul class="nav nav-pills">
            <li class="nav-item">
	            <a id="idNavOpcGeneral" class="nav-link normalNavOpciones" href="#sectionGeneralOT" onclick="selectNavOpcGeneral()">GENERAL</a>
	        </li>
	        <li class="nav-item">
	            <a id="idNavOpcOperaciones" class="nav-link normalNavOpciones" href="#sectionOperaciones" onclick="selectNavOpcOperaciones()">OPERACIONES</a>
	        </li>
        </ul>
    </nav>
    <!-- Fin Opciones (Nav) -->  


    <!-- Seccion de tabs -->
    <div id="divOpcionesDetalleOT" class="divOpcionesDetalle" data-spy="scroll" data-target="#navOpcionesDetallesOT" data-offset="0" class="scrollspy-example">

        <!-- Seccion General --> 
        <div id="sectionGeneralOT" class="seccionOpcionesDetalles">

            <div class="card-body">
                <h6 class="font-weight-semibold mb-4">General</h6>
                <table class="table product-item-table">
                <tbody>
                    <tr>
                        <td>Responsable:</td>
                        <td>
                            <div id="txtResponsableOT">
                                
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Fecha Inicio:</td>
                        <td><span id="txtFechaInicioOT"></span></td>
                    </tr>
                    <tr>
                        <td>Fecha Vencimiento:</td>
                        <td><span id="txtFechaVencimientoOT"></span></td>
                    </tr>
                </tbody>
                </table>
            </div>
    
        </div>
        <!-- Fin Seccion General --> 

        <hr class="m-0">
        <!-- Seccion Lista Operaciones --> 
        <div id="sectionOperaciones" class="seccionOpcionesDetalles">
            <div class="card-body">

                <h6 class="font-weight-semibold mb-4">Operaciones</h6>
                <table id="tablaOperaciones" class="table">
                    <tbody>
                        <tr>
                            <td onclick="v_seleccionarUnOperacion(1)"><a href="#">(#OP) Descripción</a></td>
                            <td>Especialidad</td>
                            <td>2HH</td>
                            <td>18/01/2020 20:00:00</td>
                            <td class="text-right"><button class="btn" onclick="v_seleccionarUnOperacion(1)"><i class="ion ion-ios-arrow-forward" ></i></button></td>
                        </tr>
                        <tr>
                            <td onclick="v_seleccionarUnOperacion(1)"><a href="#">(#OP) Descripción</a></td>
                            <td>Especialidad</td>
                            <td>2HH</td>
                            <td>18/01/2020 20:00:00</td>
                            <td class="text-right"><button class="btn " onclick="v_seleccionarUnOperacion(1)"><i class="ion ion-ios-arrow-forward" ></i></button></td>
                        </tr>


                    </tbody>
                </table>
        
                




            </div>
        </div>
        <!-- Fin Seccion Lista Operaciones --> 
    </div>
    <!-- Fin Seccion de tabs -->


</div>