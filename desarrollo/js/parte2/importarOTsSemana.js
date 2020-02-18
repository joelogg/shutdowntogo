//---------importar archivo de usuarios------
function clickSubirOTsSemana() 
{
    var el = document.getElementById("inputExcelOTs");
    if (el) 
    {
        el.click();
    }
}

var dataSemana = [];
$(function () 
{
    $("#inputExcelOTs").on("change", function () 
    {
        var excelFile,
            fileReader = new FileReader();

        fileReader.onload = function (e) 
        {
            var buffer = new Uint8Array(fileReader.result);
            dataSemana = [];

            $.ig.excel.Workbook.load(buffer, function (workbook) 
            {
                var row, newRow, cellValue, columnIndex, i,
                    worksheet = workbook.worksheets(0),
                    columnsNumber = 0,
                    rowsNumber = 0,
                    gridColumns = [],
                    data = [],
                    rowDataTabla = 3;

                var revision = worksheet.rows(0).getCellText(2);
                var fechaInicio = worksheet.rows(1).getCellText(2);
                var fechaFin = worksheet.rows(2).getCellText(2);

                

                //Contando las columnas que tiene la informacion principal (las operaciones) en columnas
                while (worksheet.rows(rowDataTabla).getCellValue(columnsNumber)) 
                {
                    columnsNumber++;
                }

                //Contando las columnas que tiene la informacion principal (las operaciones) en filas
                while (worksheet.rows(rowDataTabla+rowsNumber+1).getCellValue(0)) 
                {
                    rowsNumber++;
                }
                
                // Iterating through cells in first row and use the cell text as key and header text for the grid columns
                /*var rowData = new Array();
                for (columnIndex = 0; columnIndex < columnsNumber; columnIndex++) 
                {
                    cellValue = worksheet.rows(rowDataTabla).getCellText(columnIndex);
                    rowData.push(cellValue);
                }
                data.push(rowData);*/
                for (columnIndex = 0; columnIndex < columnsNumber; columnIndex++) 
                {
                    column = worksheet.rows(rowDataTabla).getCellText(columnIndex);
                    gridColumns.push({ headerText: column, key: column });
                }

                // We start iterating from 1, because we already read the first row to build the gridColumns array above
                // We use each cell value and add it to json array, which will be used as dataSource for the grid
                for (i = 0; i < rowsNumber; i++) 
                {
                    newRow = {};
                    row = worksheet.rows(rowDataTabla + i + 1);

                    for (columnIndex = 0; columnIndex < columnsNumber; columnIndex++) 
                    {
                        cellValue = row.getCellText(columnIndex);
                        newRow[gridColumns[columnIndex].key] = cellValue;
                    }
                    data.push(newRow);
                }

                
                dataSemana = {"revision":revision, "fechaInicio":fechaInicio, "fechaFin":fechaFin, "dataOTs":data};
                dataSemana = JSON.stringify(dataSemana);
                dataSemana = JSON.parse(dataSemana);
                vistaPreviaOtsExcel(dataSemana, gridColumns);                
            }, 
            function (error) 
            {
                $("#result").text("The excel file is corrupted.");
                $("#result").show(1000);
            });
        }

        if (this.files.length > 0) 
        {
            excelFile = this.files[0];
            if (excelFile.type === "application/vnd.ms-excel" || excelFile.type === "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || (excelFile.type === "" && (excelFile.name.endsWith("xls") || excelFile.name.endsWith("xlsx")))) 
            {
                fileReader.readAsArrayBuffer(excelFile);
            } else {
                $("#result").text("The format of the file you have selected is not supported. Please select a valid Excel file ('.xls, *.xlsx').");
                $("#result").show(1000);
            }
        }

    })
});


function vistaPreviaOtsExcel(dataSemana, gridColumns)
{
    document.getElementById("btnImportarOTsSemana").style.display = "none";
    document.getElementById("btnSubirExcelOts").disabled   = false;


    document.getElementById("encabezadoExcelOTs").innerHTML = '\
        <span>revision: '+dataSemana["revision"]+'</span><br>\
        <span>fechaInicio: '+dataSemana["fechaInicio"]+'</span><br>\
        <span>fechaFin: '+dataSemana["fechaFin"]+'</span>';
    
    createGrid(dataSemana["dataOTs"], gridColumns);
}

function createGrid(data, gridColumns) 
{
    if ($("#tablaExcelOTs").data("igGrid") !== undefined) 
    {
        $("#tablaExcelOTs").igGrid("destroy");
    }

    $("#tablaExcelOTs").igGrid({
        columns: gridColumns,
        autoGenerateColumns: true,
        dataSource: data,
    });
    document.getElementById("tablaExcelOTs").style.width = "auto";
}


function limpiarVentandaSubirOTs()
{
    dataSemana = [];
    document.getElementById("btnImportarOTsSemana").style.display = "block";
    document.getElementById("btnSubirExcelOts").disabled   = true;
    document.getElementById("encabezadoExcelOTs").innerHTML = "";
    document.getElementById("tablaExcelOTs").innerHTML = "";
    document.getElementById("inputExcelOTs").value = "";
}
function subirOTsSemana()
{
    console.log(dataSemana);
    var dataSemanaSubir = JSON.stringify(dataSemana);
    //dataSemanaSubir = JSON.parse(dataSemanaSubir);
    limpiarVentandaSubirOTs();
    
    
    $.ajax(
    {
        async: true,
        crossDomain: true,
        type:'POST',
        url: base_del_url_miApi+"api/subirOTsExcel",
        data: {
            "token": token,
            "json": dataSemanaSubir
          },
        success:function(rpta)
        {
            rpta = JSON.parse(rpta);
            
            if(rpta.status == "success")
            {
                console.log(rpta);
            }
            else if(rpta.status == "error")
            {
                if(rpta.message == "Autorización inválida")
                {
                    mensajeAmarillo("Su cuenta ha sido iniciada en otro dispositivo");
                    setTimeout(function() { location.replace(base_del_url); },4000);
                }
                else
                {
                    mensajeAmarillo("Error de creación de tarea");
                }
            }
        },
        error: function(rpta)
        {
            //console.log(rpta);
            mensajeAmarillo("Error, datos no validos o repetidos como la revisión");
        }
    });
}

