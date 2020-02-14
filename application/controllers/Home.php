<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'fpdf/fpdf.php';



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
			if( $_SESSION["message"] == "sesion iniciada")
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
		/*$data = $_POST['json'];
        $token = $_POST['token'];
		$data = json_decode($data, true);*/
		$idOT = 2;

        $this->load->model('data_model');
        //$rpta = $this->data_model->selectUsuarioToken($token);
        
        //if($rpta["data"]!="")
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
			$pdf->ChapterTitle('General');
			$rpta = $this->data_model->selectOrdenesTrabajo($usuarioAux, "web", $idOT);
			$usuarios = $this->data_model->selectUsuarios();
			$nombres = [];
			foreach ($rpta as $unaOT) 
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

			$dataDetalleOt = array();
			$txt = iconv('utf-8', 'cp1252', 'Descripción:' );
			array_push ($dataDetalleOt, array($txt, $rpta[0]->descripcion) );
			array_push ($dataDetalleOt, array("Numero orden de trabajo:", $rpta[0]->descripcion, $rpta[0]->ordentrabajo) );
			array_push ($dataDetalleOt, array("Tipo:", $rpta[0]->descripcionTipo) );
			array_push ($dataDetalleOt, array("Estado", $rpta[0]->estado) );
			array_push ($dataDetalleOt, array("Prioridad:", $rpta[0]->descripcionPrioridad) );

			$max = sizeof($nombres);
			for ($i=0; $i < $max; $i++) 
			{ 
				if($i==0)
				{
					array_push ($dataDetalleOt, array("Responsables:", $nombres[$i]["nombre"]." ".$nombres[$i]["apellido"] ) );
				}
				else
				{
					array_push ($dataDetalleOt, array("", $nombres[$i]["nombre"]." ".$nombres[$i]["apellido"] ) );
				}
			}
			array_push ($dataDetalleOt, array("Fecha inicio:", $rpta[0]->fechainicio) );
			array_push ($dataDetalleOt, array("Fecha vencimiento:", $rpta[0]->fechafin) );
			$pdf->ImprovedTable($dataDetalleOt);
			
			$pdf->Ln(4);
			//---- Fin Detalles de la OT---
			


		//---- Lista de Operaciones---
		
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
			
		//---- Fin Lista de Operaciones---	
			
			$pdf->ChapterTitle('Detalle de Operaciones');
			
			foreach ($operacionesList as $operacion)
			{
				$dataDetalleOP = array();
				$txt = iconv('utf-8', 'cp1252', 'Descripción:' );

				array_push ($dataDetalleOP, array($txt, $operacion->descripcion) );
				//array_push ($dataDetalleOP, array($txt, $rpta[0]->descripcion) );
				array_push ($dataDetalleOP, array("Numero orden de trabajo:", $rpta[0]->descripcion, $rpta[0]->ordentrabajo) );
				array_push ($dataDetalleOP, array("Tipo:", $rpta[0]->descripcionTipo) );
				array_push ($dataDetalleOP, array("Estado", $rpta[0]->estado) );
				array_push ($dataDetalleOP, array("Prioridad:", $rpta[0]->descripcionPrioridad) );

				$max = sizeof($nombres);
				for ($i=0; $i < $max; $i++) 
				{ 
					if($i==0)
					{
						array_push ($dataDetalleOP, array("Responsables:", $nombres[$i]["nombre"]." ".$nombres[$i]["apellido"] ) );
					}
					else
					{
						array_push ($dataDetalleOP, array("", $nombres[$i]["nombre"]." ".$nombres[$i]["apellido"] ) );
					}
				}
				array_push ($dataDetalleOP, array("Fecha inicio:", $rpta[0]->fechainicio) );
				array_push ($dataDetalleOP, array("Fecha vencimiento:", $rpta[0]->fechafin) );
				$pdf->ImprovedTable($dataDetalleOP);
				$pdf->Ln(4);
				
				//$rpta = $this->data_model->selectComentarios($operacion->id);
				//break;
			}
			$pdf->Output();
			

			
			
			

        }
        /*else
        {
            $results = array(
                "status" => "error",
                "code" => "400",
                "message" => "token inválido",
                "data"=>[]
            );
			echo json_encode($results);
        }*/
        
	
/*
		
		*/
	}
	
}


class PDFdetalleOT extends FPDF
{

	
	// Page header
	function Header()
	{
		// Logo
		
		
		$title = "PM Digital";
		$this->Image('./desarrollo/img/chancadora.jpg',12,10,20);

		// Arial bold 15
		$this->SetFont('Arial','B',15);
		// Calculate width of title and position
		$w = $this->GetStringWidth($title)+6;
		$this->SetX((210-$w)/2);
		// Colors of frame, background and text
		$this->SetDrawColor(0,80,180);
		$this->SetFillColor(230,230,0);
		$this->SetTextColor(220,50,50);
		// Thickness of frame (1 mm)
		$this->SetLineWidth(0.5);
		// Title
		$this->Cell($w,9,$title,1,1,'C',true);
		// Line break
		$this->Ln(10);
	}

	// Page footer
	function Footer()
	{
		
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Text color in gray
		$this->SetTextColor(128);
		// Page number
		$txt = iconv('utf-8', 'cp1252', 'Página '.$this->PageNo().'/{nb}' );
		$this->Cell(0,10,$txt,0,0,'C');
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
	function ImprovedTable($data)
	{
		// Column widths
		$w = array(95, 95);
		
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
