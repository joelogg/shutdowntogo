
<!-- Titulo -->
<div class="divTituloCabeceraDetalle pt-2">
    Ordenes de trabajo (S1)
</div>
<!-- Fin Titulo -->

<!-- Filtros -->
<div class="divCabeceraDetalle col-12 pt-3">
    
    <div class="input-group pb-3 d-flex justify-content-center" style="text-align: center">
        
        <div>
            <label class="mr-1 text-left" style="width: 150px;">Responsables:</label>
            <select class="form-control mr-1" style="max-width: 150px;">
                <option value="0">SELECCIONAR</option>
            </select>
        </div>

        <div>
            <label class="mr-1 text-left" style="width: 150px;">Prioridad:</label>
            <select class="form-control mr-1" style="max-width: 150px;">
                <option value="0">SELECCIONAR</option>
            </select>
        </div>

        <div>
            <label class="mr-1 text-left" style="width: 150px;">Estatus:</label>
            <select class="form-control mr-1" style="max-width: 150px;">
                <option value="0">SELECCIONAR</option>
            </select>
        </div>

        <div>
            <label class="mr-1 text-left" style="width: 150px;">Área:</label>
            <select class="form-control mr-1" style="max-width: 150px;">
                <option value="0">SELECCIONAR</option>
            </select>
        </div>

        <div>
            <label class="mr-1 text-left" style="width: 150px;">Fecha:</label>
            <select class="form-control mr-1" style="max-width: 150px;">
                <option value="0">SELECCIONAR</option>
            </select>
        </div>

        <div class="">
            <label class="mr-1 text-left" style="min-height: 17px;"></label>
            <button class="form-control btnsPopUp" style="height: auto; width: 100px">Filtrar</button>
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
