//Subir imagen de usuario refistrandose

//para activar el input file
$('#btnAvatarImg').click(function(){ $('#file').trigger('click'); });

function myFunction(input) 
{
	var formData = new FormData();
	var files = $('#file')[0].files[0];
	formData.append('imagen',files);
    //console.log(files);

	$.ajax({
			async: true,
  			crossDomain: true,
            type:'POST',
            url: base_del_url_ser+"uploadimagen",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            headers: {
			    "APIAuthorization": token
			},
            success:function(data)
            {
                urlN = data.dominio_ruta_archivo;
                //console.log(data);
				document.getElementById("btnAvatarImg").innerHTML  = "";
				document.getElementById('btnAvatarImg').style.backgroundImage = "url("+urlN+")";
				document.getElementById("btnAvatarImg").style.backgroundSize  = "112px 112px";
				
            },
            error: function(data){
                console.log("error");
            }
        });

}


var imgEmpresas = []
var empresasImagenes = new Array();

function cargarEmpresas() 
{   
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            var responseJsonObj = this.responseText;
            var empresas = JSON.parse(responseJsonObj);
            //console.log(empresas);
            //console.log(empresas.length);
            var dataSelect = "";
            for (i=0; i<empresas.length; i++) 
            {
                
                empresasImagenes[empresas[i].id] = empresas[i].imagen;
                if (i==0)
                {
                    dataSelect += '<option value="">' + empresas[i].nombre + '</option>';
                    document.getElementById("imgEmpresa").src = base_del_url_ser+"images/empresa/"+empresas[i].id+"/"+empresas[i].imagen; 
                }
                else
                {
                    dataSelect += '<option value="' + empresas[i].id + '">' + empresas[i].nombre + '</option>';
                }
            }
            
            document.getElementById("idEmpresa").innerHTML = dataSelect;
            
        }
    };
        
    xmlhttp.open("GET", base_del_url+"desarrollo/phps/parte1/cargarEmpresas.php", true); 
    xmlhttp.send();    
}

function cambiarLogo() 
{
    var idE = document.getElementById("idEmpresa").value;
    idE = parseInt(idE, 10);
    var url = base_del_url_ser+"images/empresa/"+idE+"/"+empresasImagenes[idE]; 
    document.getElementById("imgEmpresa").src = url; 
    
}


function hagamoslo() 
{
    var celular = document.getElementById("inputCelular").value;
    var idEmpresa = document.getElementById("idEmpresa").value;

    if (celular=="" || idEmpresa=="" || idEmpresa=="1") 
    {
        mensajeAmarillo("Completa tus datos");
    }
    else
    {      
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
        {
            if (this.readyState == 4 && this.status == 200) 
            {
                var responseJsonObj = this.responseText;
                console.log(responseJsonObj);
                
                if (responseJsonObj=="error") 
                {
                    mensajeAmarillo("Registro no finalizado");
                }
                else
                {
                    location.replace(responseJsonObj);
                }
                
            }
        };
        
        xmlhttp.open("GET", base_del_url+"desarrollo/phps/parte1/datosPersonales.php?nombres="+nombres+"&apellidos="+apellidos+"&pwd="+pwd+"&celular="+celular+"&idEmpresa="+idEmpresa+"&email="+email, true); 
        xmlhttp.send();
    }
    
}