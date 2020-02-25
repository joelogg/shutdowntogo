<!-- Filtros Graficos -->
<div id="divMenuOT" class="col-12">
    <div class="row pt-1">
        <div class="col-12 col-lg-8 col-xl-9 input-group d-flex justify-content-between">
            
            <button type="button" class="btn btnMenuDashBoard">RESUMEN</button>
            
            <div class="btn-group pr-2 pt-2">
                
                
                
                <input type="text" id="calendarioFiltroGraficas" value="" class="form-control" style="width: 200px">


                <select id="selectSemanaGrafios" class="form-control mr-1" style="min-width: 150px" onchange="cambiarSemanaGrafico()">
                    <option value="0"></option>    
                    <option value="1">Hoy</option>
                    <option value="2" selected>Semana actual</option>
                </select>

                <div class="input-group-append">
                    <button class="form-control btnsPopUp" style="height: auto; width: 100px" onclick="filtrarDatosGrafico()">Filtrar</button>
                </div>
            </div>

        </div>
    </div>
</div>


<div id="divGraficosDashBoard" class="col-12">  

    
    <div class="row px-2 pt-2">

        <!-- div Graficos -->
        <div class="col-12 col-lg-8 col-xl-9">
            
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12 col-xl-6 divGrafDashBoard">
                    <span class="titGraficasDashBoard">% COMPLETADO</span>
                    <div class="divUnGrafDashBoard">

                        <div id="gauge_g1" style="height: 250px;"></div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-12 col-xl-6 divGrafDashBoard">
                    <span class="titGraficasDashBoard">ESTATUS</span>
                    <div class="divUnGrafDashBoard">
                        
                        <div id="donut_g2" style="height: 250px;"></div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-12 col-xl-6 divGrafDashBoard">
                    <span class="titGraficasDashBoard">PRIORIDAD</span>
                    <div class="divUnGrafDashBoard">

                        <div id="bar_g3" style="height: 250px;"></div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-12 col-xl-6 divGrafDashBoard">
                    <span class="titGraficasDashBoard">ÁREAS</span>
                    <div class="divUnGrafDashBoard">

                        <div id="bar_g4" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- div OT derecha -->
        <div class="col-12 col-lg-4 col-xl-3">
            <span id="titOTsGraficasDashBoard" class="titGraficasDashBoard">
                ORDENES DE TRABAJO
            </span>
            <div id="divOTsDashboard">
                <!--
                <div class="divOTCritica" >
                    <div class="titTareaCriticaDashboard" title="[LUB] LUBRICACIÓN CHANCADOR PRIMARIO" onclick="verTareaCritica(12)">[100659560] 1W Insp Apron Feeder</div>
                    <div></div>
                </div>
                -->
            </div>
        </div>

    </div>


</div>       
        
        