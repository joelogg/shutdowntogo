<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'fpdf/fpdf.php';
require_once 'dompdf/autoload.inc.php'; 
use Dompdf\Dompdf; 



class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
//Vistas
	public function index()
	{	
		/*
		if (!isset($_SESSION["message_code"]) )
		{*/
			$data['tituloP'] = 'Login';
			$this->load->view('parte1/v_login', $data);
		/*}
		else
		{
			if( $_SESSION["message_code"] == "login.success")
			{
				$data['tituloP'] = 'Plataforma';
				$this->load->view('parte2/v_plataforma', $data);
			}
			else
			{
				$data['tituloP'] = 'Login';
				$this->load->view('parte1/v_login', $data);
			}
		}
		*/
	}

	public function recuperarContrasena()
	{
		$data['tituloP'] = 'Recuperar contraseña';
        $this->load->view('parte1/v_recuperarContrasena', $data);		
	}

	public function envioDeCorreo()
	{
		$data['tituloP'] = 'Envio de correo';
        $this->load->view('parte1/v_envioCorreo', $data);	
	}

	public function correoRecuperacion()
	{
		$data['tituloP'] = 'Correo de recuperación';
        $this->load->view('parte1/v_correoRecupCont', $data);	
	}

	public function nuevaContrasena()
	{
		$data['tituloP'] = 'Nueva contraseña';
        $this->load->view('parte1/v_nuevaContrasena', $data);	
	}

	public function contrasenaCambiada()
	{
		$data['tituloP'] = 'Contraseña Cambiada';
        $this->load->view('parte1/v_contrasenaCambiada', $data);	
	}

	public function correoUnirGrupo()
	{
		$data['tituloP'] = 'Unirte al Grupo';
		$this->load->view('parte1/v_correoUnirteGrupo', $data);	
	}

	public function registrate()
	{
		$data['tituloP'] = 'Registrate';
		$this->load->view('parte1/v_registrate', $data);	
	}

	public function bienvenido()
	{
		$data['tituloP'] = 'Bienvenido';
		$this->load->view('parte1/v_bienvenido', $data);	
	}

	public function datosPersonales()
	{
		$data['tituloP'] = 'Datos Personales';
		$this->load->view('parte1/v_datosPersonales', $data);	
	}
	
	public function plataforma()
	{
		
		if (!isset($_SESSION["message"]) )
		{
			$data['tituloP'] = 'Login';
			$this->load->view('parte1/v_login', $data);
		}
		else
		{
			$this->load->model('data_model');
			$responsablesLista = $this->data_model->selectUsuarios();
			$prioridadLista = $this->data_model->selectPrioridades();
			$estatusLista = $this->data_model->selectEstadosOT();
			$areaLista = $this->data_model->selectAreas();
			$proyectosLista = $this->data_model->selectProyectos();
			$usuarioActual = $this->data_model->selectUsuarioToken($_SESSION["token"])["data"];

			if( $_SESSION["message"] == "sesion iniciada")
			{				
				$data['tituloP'] = 'Plataforma';
				$data['responsablesLista'] = $responsablesLista;
				$data['prioridadLista'] = $prioridadLista;
				$data['estatusLista'] = $estatusLista;
				$data['areaLista'] = $areaLista;
				$data['proyectosLista'] = $proyectosLista;
				$data['usuarioActual'] = $usuarioActual;
				$this->load->view('parte2/v_plataforma', $data);
			}
			else
			{
				$data['tituloP'] = 'Login';
				$this->load->view('parte1/v_login', $data);
			}
		}
		
	}

	public function descargaApi()
	{
		
		$data['tituloP'] = 'Datos Personales';
		$this->load->view('parte2/v_descargarAplicacion', $data);	
		
	}
	
	



//---------------------- Base de datos --------------------------

    public function getTabla1()
    {
        session_start();
		/*if (!isset($_SESSION["idusuario"]))
		{
			redirect(base_url());
		}
		else
		{*/
            $this->load->model('Data_model');
            $rspta=$this->Data_model->selectTable();
            $data= Array();
			
            foreach ($rspta as $reg)
            {
                $data[]=array(
                    "0"=>$reg->nombre
                    );
            }
            $results = array(
                "sEcho"=>1, //Información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
        //}
	}
	




//-------------------PDF---------------

	



	public function descargarOT_PDF()
	{
		if(!isset($_POST['idOT']) || !isset($_POST['token']) )
		{
			echo "<h1>Datos de exportación no ingresados</h1>";
		}
		else
		{
			$idOT = $_POST['idOT'];
			$token = $_POST['token'];

			$this->load->model('data_model');
			$rpta = $this->data_model->selectUsuarioToken($token);
			
			if($rpta["data"]!="")
			{
				$usuarioAux = array("perfil"=>"Propietario");
				$usuarioAux = json_encode($usuarioAux);
				$usuarioAux = json_decode($usuarioAux,0);

				$this->load->model('data_model');

				$title = 'Detalle orden de trabajo';
				$pdf = new PDFdetalleOT('P','mm','A4');
				$pdf->SetTitle($title);
				$pdf->AliasNbPages();
				

			//---- Detalles de la OT---
				$data = $this->data_model->selectOrdenesTrabajo($usuarioAux, "web", $idOT);
				$usuarios = $this->data_model->selectUsuarios();
				$pdf->ChapterCabeceraOT($data, $usuarios);
			//---- Fin Detalles de la OT---
				

			//---- Lista de Operaciones---
				$operacionesList = $this->data_model->selectOperaciones($usuarioAux, $idOT);
				
				$pdf->SetFont('Arial','',10);
				//Table with 20 rows and 4 columns
				$pdf->SetWidths(array(100,30,20,40));
				
				$pdf->RowListOpe(array('Operaciones', 'Especialidad', 'Trabajo', 'Fecha Vencimiento'), true, "FD", 8);
				foreach ($operacionesList as $operacion)
				{ 
					$pdf->RowListOpe(array($operacion->descripcion." (".$operacion->numerooperacion.")", $operacion->descripcionEspecialidad, $operacion->work, $operacion->fechafin), false, "D", 6);
				}
				$pdf->Ln(10);
				
			//---- Fin Lista de Operaciones---	
			
				foreach ($operacionesList as $operacion)
				{
					$comentarios = $this->data_model->selectComentarios($operacion->id);
					$pdf->ChapterOperaciones($operacion, $comentarios, $usuarios);
				}
				$pdf->Output();
				

		

			}
			else
			{
				echo "<h1>Autorización no válidad</h1>";
			}
		}
	}


		
	public function descargarKPIs_PDF()
	{
		if(/*!isset($_POST['idOT']) ||*/ !isset($_POST['token']) )
		{
			echo "<h1>Datos de exportación no ingresados</h1>";
		}
		else
		{
			$token = $_POST['token'];
			$imgKPI0 = $_POST['imgKPI0'];
			$imgKPI01 = $_POST['imgKPI01'];
			$imgKPI1 = $_POST['imgKPI1'];
			$imgKPI2 = $_POST['imgKPI2'];
			$imgKPI3 = $_POST['imgKPI3'];
			$imgKPI4 = $_POST['imgKPI4'];


			$this->load->model('data_model');
			$rpta = $this->data_model->selectUsuarioToken($token);
			
			if($rpta["data"]!="")
			{
				//$dompdf = new Dompdf();
				$dompdf = new Dompdf(array('enable_remote' => true));

				$html = "
				<!DOCTYPE html>
				<html>
				<head>
					<meta charset='utf-8'>
				</head>

				<body> 
					<h1>KPIs</h1>
					<div><img src='$imgKPI0' alt='image' ></div>
					<div style='background-color: orange'><img src='$imgKPI01' alt='image' ></div>
					<div><img src='$imgKPI1' alt='image' ></div>
					<div><img src='$imgKPI2' alt='image' ></div>
					<div><img src='$imgKPI3' alt='image' ></div>
					<div><img src='$imgKPI4' alt='image' ></div>
				</body>
				</html>";
				
				//echo $html;
				
				$dompdf->loadHtml($html); 
				
				//$dompdf->setPaper('A4', 'landscape'); 
				$dompdf->setPaper('A4', 'portrait'); 
				$dompdf->render(); 
				//$dompdf->stream("codexworld", array("Attachment" => 0)); //(1 = download and 0 = preview) 
				$dompdf->stream('document.pdf', array("Attachment" => 0));
				
				
				

		

			}
			else
			{
				echo "<h1>Autorización no válidad</h1>";
			}
		}
	}
}


class PDFdetalleOT extends FPDF
{

	
	// Page header
	function Header()
	{
		$hoy = date('F j\, Y');
		$this->SetY(2);
		$this->SetFont('Arial','B',10);
		$this->SetTextColor(128); //color texto
		// Page number
		$txt = iconv('utf-8', 'cp1252', $hoy.'       Página '.$this->PageNo().'/{nb}' );
		$this->Cell(0,10,$txt,0,0,'C');
		$this->Ln(10);
	}

	
	function ChapterCabeceraOT($data, $usuarios)
	{
		$this->AddPage();


		$this->SetTextColor(0); //color text

		//----Logo----
		$this->SetFont('Arial','B',15);
		$this->Cell(50,30,'PM DIGITAL',1, 0, 'C');
		//$this->Image('./desarrollo/img/chancadora.jpg',12,14,30,26);
		
		//----Titulo OT----
		$txt0 = iconv('utf-8', 'cp1252', 'Numero Orden de trabajo: ');
		$this->SetFont('Arial','B',14);
		$txt1 = iconv('utf-8', 'cp1252', $data[0]->descripcion );
		$txt2 = iconv('utf-8', 'cp1252', $data[0]->ordentrabajo );

		$this->Cell(140,15,$txt1,1,0,'C');
		$this->SetY(27);
		$this->SetX(60);
		$this->Cell(140,15,$txt0.$txt2,1,0,'C');

		$this->Ln(17);
		//----Mas datos OT----
		
		$nombres = [];
		foreach ($data as $unaOT) 
		{
			$idsUsu = explode(",", $unaOT->responsable);
			foreach ($idsUsu as $idUsu) 
			{
				foreach ($usuarios as $usuario) 
				{
					if($usuario->id == $idUsu)
					{
						array_push($nombres, array("nombre"=>$usuario->nombre, "apellido"=>$usuario->apellido));
						break;
					}
				}
			}
		}
	
		$this->SetFont('Arial','',10);
		$dataDetalleOt = array();
		/*$txt = iconv('utf-8', 'cp1252', 'Descripción' );
		$txt2 = iconv('utf-8', 'cp1252', ': '.$data[0]->descripcion );
		array_push ($dataDetalleOt, array($txt, $txt2) );

		$txt = iconv('utf-8', 'cp1252', 'Número orden de trabajo' );
		$txt2 = iconv('utf-8', 'cp1252', ': '.$data[0]->ordentrabajo );
		array_push ($dataDetalleOt, array($txt, $txt2) );*/

		$txt2 = iconv('utf-8', 'cp1252', $data[0]->descripcionTipo );
		array_push ($dataDetalleOt, array("Tipo", ': '.$txt2 ) );

		$txt2 = iconv('utf-8', 'cp1252', $data[0]->estado );
		array_push ($dataDetalleOt, array("Estado", ': '.$txt2) );

		$txt2 = iconv('utf-8', 'cp1252', $data[0]->descripcionPrioridad );
		array_push ($dataDetalleOt, array("Prioridad", ': '.$txt2) );

		$max = sizeof($nombres);
		for ($i=0; $i < $max; $i++) 
		{ 
			$txt = iconv('utf-8', 'cp1252', $nombres[$i]["nombre"]." ".$nombres[$i]["apellido"] );
			if($i==0)
			{
				array_push ($dataDetalleOt, array("Responsables",  ': '.$txt) );
			}
			else
			{
				array_push ($dataDetalleOt, array("", '  '.$txt ) );
			}
		}
		array_push ($dataDetalleOt, array("Fecha inicio", ': '.$data[0]->fechainicio) );
		array_push ($dataDetalleOt, array("Fecha vencimiento", ': '.$data[0]->fechafin) );
		$this->ImprovedTable($dataDetalleOt, 41, 149);
		
		$this->Ln(4);
		
	}

	function ChapterOperaciones($operacion, $comentarios, $usuarios)
	{
		$dataDetalleOP = array();
		$txt = iconv('utf-8', 'cp1252', $operacion->descripcion );
		$txt2 = iconv('utf-8', 'cp1252', $operacion->numerooperacion );
		$this->ChapterTitle('Detalle de Operación: '. $txt);
		
		$this->SetFont('Arial','',10);

		/*
		$txt = iconv('utf-8', 'cp1252', 'Descripción' );
		$txt2 = iconv('utf-8', 'cp1252', ': '.$operacion->descripcion );
		array_push ($dataDetalleOP, array($txt, $txt2) );*/
		$txt = iconv('utf-8', 'cp1252', 'Número de operación' );
		$txt2 = iconv('utf-8', 'cp1252', $operacion->numerooperacion );
		array_push ($dataDetalleOP, array($txt, ': '.$txt2) );
		

		array_push ($dataDetalleOP, array("Trabajo", ': '.$operacion->work) );
		array_push ($dataDetalleOP, array("Recursos", ': '.$operacion->resources) );
		$txt = iconv('utf-8', 'cp1252', 'Duración' );
		array_push ($dataDetalleOP, array($txt, ': '.$operacion->duracion) );
		
		array_push ($dataDetalleOP, array("Fecha inicio", ': '.$operacion->fechainicio) );
		array_push ($dataDetalleOP, array("Fecha vencimiento", ': '.$operacion->fechafin) );
		$this->ImprovedTable($dataDetalleOP, 35, 155);
		$this->Ln(4);
		
		$this->SetFont('Arial','B',14);
		$txt = iconv('utf-8', 'cp1252', 'a' );
		$this->Cell(190,10,"Comentarios");
		$this->Ln(10);


		$anT = 190;

		$anImg = 10;
		$padding = 2;
		$celI = $anImg + $padding*2;
		$celCabMen = $anT - $celI;

		$espacioMensajes = 10;
		
		$i=0;

		$this->SetDrawColor(130,130,130);
    	$this->SetFillColor(230,230,0);
    	
		foreach ($comentarios as $comentario) 
		{
			$usuario = $this->buscarUsuario($usuarios, $comentario->creadopor);

			$this->SetFont('Arial','',10);
			$txtNom = iconv('utf-8', 'cp1252', $usuario->nombre.' '.$usuario->apellido );
			$txtCom = iconv('utf-8', 'cp1252', $comentario->mensaje );
			$txtFecha = iconv('utf-8', 'cp1252', $comentario->fechacreacion );


			if($usuario->imagen!=null && $i%2==0)
			{
				//imagen
				$this->Image($usuario->imagen,12,null, $anImg, $anImg);
				$this->SetY($this->GetY()-$anImg-$padding);
				$this->Cell($celI, $celI,"",'LTB');

			}
			else
			{
				if($usuario->nombre==null || $usuario->nombre=="" || $usuario->apellido==null || $usuario->apellido=="")
				{
					$this->Cell($celI, $celI, substr($usuario->correo, 0, 2),'LTB', 0, 'C');
				}
				else
				{
					$this->Cell($celI, $celI, substr($usuario->nombre, 0, 1).substr($usuario->apellido, 0, 1),'LTB', 0, 'C');
				}
				
			}
			
			//Nombre
			$this->SetTextColor(0,80,180);
			$this->Cell($celCabMen,$celI/2,$txtNom,'TR');
			$this->Ln($celI/2);
			$this->SetTextColor(0, 0, 0);

			//fecha
			$this->SetTextColor(100, 100, 100);
			$this->SetX($celI+$this->GetX());
			$this->Cell($celCabMen,$celI/2,$txtFecha, 'RB');
			$this->Ln($celI/2);
			$this->SetTextColor(0, 0, 0);

			//mensaje
			if( !($txtCom=="" || $txtCom==null))
			{
				$this->MultiCell($anT,10,$txtCom, 'LR');
			}

			//adjunto imagen
			if( !($comentario->adjuntoNombre=="" || $comentario->adjuntoNombre==null))
			{
				$this->Ln(2);
				$anImgAdj = 35;
				$this->Image($comentario->adjuntoNombre,12,null, 0, $anImgAdj);
				$this->SetY($this->GetY()-$anImgAdj-2);
				$this->Cell($anT,$anImgAdj+4,"",'LRB');
				
				$this->Ln($anImgAdj+$espacioMensajes);
				
			}
			else
			{
				$this->Cell($anT,0,"",'B');
				$this->Ln($espacioMensajes);
			}
			

			$i++;
		}
		
	}

	function buscarUsuario($usuarios, $creadopor)
	{
		foreach ($usuarios as $usu) 
		{
			if($usu->id==$creadopor)
			{
				return $usu;
			}
		}
		return null;
	}

	function ChapterTitle($label)
	{
		$this->AddPage();
		// Arial 12
		$this->SetFont('Arial','',12);
		// Background color
		$this->SetFillColor(200,220,255);
		// Title
		$txt = iconv('utf-8', 'cp1252', $label);
		$this->Cell(0,6,$txt,0,1,'L',true);
		// Line break
		$this->Ln(4);
	}

	// Better table
	function ImprovedTable($data, $spacio1, $spacio2)
	{
		// Column widths
		$w = array($spacio1, $spacio2);
		
		// Data
		foreach($data as $row)
		{
			$this->Cell($w[0],8,$row[0],'');
			$this->Cell($w[1],8,$row[1],'');
			$this->Ln();
		}
		// Closing line
		$this->Cell(array_sum($w),0,'','T');
	}






	var $widths;
	var $aligns;
	
	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}
	
	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}
	
	
	function colorCabeceraTabla()
	{
		$this->SetFillColor(180,180,180);
		$this->SetTextColor(0);
		$this->SetDrawColor(128,128,128);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
	}

	function colorCuerpoTabla()
	{
		$this->SetFillColor(255);
		$this->SetTextColor(0);
		$this->SetDrawColor(128,128,128);
		$this->SetLineWidth(.3);
		$this->SetFont('');
	}

	function RowListOpe($data, $cabecera, $fillLine, $altoFila)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
		{
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		}
		$h=$altoFila*$nb;
		
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		
		
		$this->colorCuerpoTabla();
		if($cabecera)
		{
			$this->colorCabeceraTabla();
		}
		

		

		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h, $fillLine);
			//Print the text
			$this->MultiCell($w,6,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}
	
	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}
	
	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}



}
