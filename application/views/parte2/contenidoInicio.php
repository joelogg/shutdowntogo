<div id="contVentanaCentral" class="">

    <div id="divDashBoard">
        <div id="divMenuOT">
            <div class="btn-group pt-1">
                <button type="button" class="btn btnMenuDashBoard">RESUMEN</button>
            </div>
        </div>
        <div id="divGraficosDashBoard">
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



           
