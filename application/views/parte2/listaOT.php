
<!-- Titulo -->
<div class="divTituloCabeceraDetalle pt-2">
    Ordenes de trabajo (S1)
</div>
<!-- Fin Titulo -->

<!-- Filtros -->
<div class="divCabeceraDetalle col-12 pt-3">
    
    <div class="input-group pb-3 d-flex justify-content-center" style="text-align: center">
        
    <div class="mr-1">
            <label class="text-left" style="width: 150px;">Responsables:</label>
            <select id="selectFiltroResponsables" class="form-control" onchange="onchangeResponsablesFiltro()" style="max-width: 150px;">
                <option value="-1">SELECCIONAR</option>    
                <?php 
                    foreach ($responsablesLista as $item):
                        echo '<option value="'.$item->id.'">'.$item->nombre.' '.$item->apellido.'</option>';
                    endforeach;
                ?>
            </select>
        </div>

        <div class="mr-1">
            <label class="text-left" style="width: 150px;">Prioridad:</label>
            <select id="selectFiltroPrioridad" class="form-control" onchange="onchangePrioridadFiltro()" style="max-width: 150px;">
                <option value="-1">SELECCIONAR</option>    
                <?php 
                    foreach ($prioridadLista as $item):
                        echo '<option value="'.$item->id.'">'.$item->descripcion.'</option>';
                    endforeach;
                ?>
            </select>
        </div>

        <div class="mr-1">
            <label class="text-left" style="width: 150px;">Estatus:</label>
            <select id="selectFiltroEstado" class="form-control" onchange="onchangeEstadoFiltro()" style="max-width: 150px;">
                <option value="-1">SELECCIONAR</option> 
                <option value="-2">Atrasada</option>
                <?php 
                    foreach ($estatusLista as $item):
                        echo '<option value="'.$item->id.'">'.$item->descripcion.'</option>';
                    endforeach;
                ?>
            </select>
        </div>

        <div class="mr-1">
            <label class="text-left" style="width: 150px;">Área:</label>
            <select id="selectFiltroArea" class="form-control" onchange="onchangeAreaFiltro()" style="max-width: 150px;">
                <option value="-1">SELECCIONAR</option>    
                <?php 
                    foreach ($areaLista as $item):
                        echo '<option value="'.$item->id.'">'.$item->codigo.'</option>';
                    endforeach;
                ?>
            </select>
        </div>

        <div class="mr-1">
            <label class="text-left" style="width: 150px;">Fecha:</label>
            <select id="selectFiltroFecha" class="form-control" onchange="onchangeFechaFiltro()" style="min-width: 150px"">
                <option value="-1">SELECCIONAR</option>    
                <option value="-2">Hoy</option>
                <option value="-3">Mañana</option>
                <?php 
                    $i=0;
                    foreach ($proyectosLista as $item):
                        //if($i==0)
                        {
                            //echo '<option value="'.$item->revision.'" selected>'.$item->revision.'</option>';
                        }
                        //else
                        {
                            echo '<option value="'.$item->revision.'">'.$item->revision.'</option>';
                        }
                        $i++;
                    endforeach;
                ?>
            </select>
        </div>
        
        <!--
        <div class="mr-1">
            <label class="mr-1 text-left" style="min-height: 17px;"></label>
            <button class="form-control btnsPopUp" style="height: auto; width: 100px" onclick="cargarListaOrdenTrabajo()">Filtrar</button>
        </div>
        -->

        <div class="">
            <label class="mr-1 text-left" style="min-height: 17px;"></label>
            <button class="form-control btnsPopUp" style="height: auto; width: 100px" onclick="reinicarFiltros()">Restablecer</button>
        </div>
    </div>

    
</div>
<!-- Fin Filtros -->

<!-- Tabla de OTs -->
<div  class="table-responsive p-3 pb-0 bg-white" >
    <table id="tablaOT" class="datatables-demo table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nº OT</th>
                <th>Descripción</th>
                <th>F. Inicio </th>
                <th>F. Vencimiento </th>
                <th>Estado</th>
                <th>Prioridad</th>
                <th>Responsables</th>
            </tr>
        </thead>
        <!--
        <tbody>
            <tr>
                <td><a href="">asss</a></td>
                <td>77</td>
                <td>Cerradp</td>
                <td>Normal</td>
                <td>2020-01-16 14:00:00</td>
            </tr>
            <tr>
                <td><a href="">asss</a></td>
                <td>877</td>
                <td>Cesrradp</td>
                <td>Nosrmal</td>
                <td>2020-01-16 14:00:00</td>
            </tr>
        </tbody>
        -->
    </table>
</div>
<!-- Fin Tabla de OTs -->
