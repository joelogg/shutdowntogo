<div id="contVentanaCentral" class="">

    <div id="divDashBoard">
        <!--
        <div id="divMenuOT">
            <div class="btn-group pt-1">
                <button type="button" class="btn btnMenuDashBoard">RESUMEN</button>
            </div>
        </div>
        -->
        <div id="divMenuOT" class="col-12">
            <div class="row pt-1">
                <div class="col-12 col-lg-8 col-xl-9 input-group d-flex justify-content-between">

                    <button type="button" class="btn btnMenuDashBoard">RESUMEN</button>

                    <div class="btn-group pr-2 pt-2">
                        <select id="selectFechaGrafios" class="form-control mr-1" style="min-width: 150px">
                            <option value="0">Fecha</option>
                        </select>

                        <select id="selectSemanaGrafios" class="form-control mr-1" style="min-width: 150px">
                            <option value="0">Semana</option>
                        </select>

                        <div class="input-group-append">
                            <button class="form-control btnsPopUp" style="height: auto; width: 100px" onclick="filtrarDatosGrafico()">Filtrar</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div id="divGraficosDashBoard" class="col-12">        
            <?php $this->load->view('parte2/dashBoard.php'); ?>
        </div>
    </div>

    <div id="divOrdenesTrabajo" >
    
        <!-- Lista de OTs -->
        <div id="divListaOT">
            <?php $this->load->view('parte2/listaOT.php'); ?>
        </div>
        <!-- Fin Lista de OTss -->

        <!-- Detalle OT -->
        <div id="divDetalleOT">
            <?php $this->load->view('parte2/detalleOT.php'); ?>
        </div>
        <!-- Fin Detalle OT -->

        <!-- Detalle Operaciones -->
        <div id="divDetalleOperaciones">
            <?php $this->load->view('parte2/detalleOperacion.php'); ?>
        </div>
        <!-- Fin Detalle Operaciones -->



        

</div>



           
