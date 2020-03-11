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
		
		if(!isset($_POST['token']) )
		{
			echo "<h1>Datos de exportación no ingresados</h1>";
		}
		else
		{
			$token = $_POST['token'];
			
			
			$imgKPIs = $_POST['imgKPIs'];

			
			
			$this->load->model('data_model');
			$rpta = $this->data_model->selectUsuarioToken($token);
			
			if($rpta["data"]!="")
			{
				$imgKPIs = json_decode($imgKPIs, true);
				$imgKPI1 = $imgKPIs["g1"];
				
				
				$pdf = new PDF_Diag();
				$pdf->AddPage();
				
				//-------grafico 1-------------
				$pdf->SetFont('Arial', 'BIU', 12);
				$pdf->Cell(0, 5, '% COMPLETADO', 0, 1);
				$pdf->Ln(8);
				
				$pdf->SetFont('Arial', '', 10);
				$valX = $pdf->GetX();
				$valY = $pdf->GetY();
				
				$pdf->SemiPieChart(180, 70, $imgKPI1, '%l (%p)');
				$pdf->SetXY($valX, $valY + 40);

				//---------colores para el resto de graficos--------
				$col1=array(31, 119, 180);
				$col2=array(255, 127, 14);
				$col3=array(44, 160, 44);
				$col4=array(214, 39, 40);
				$col5=array(148, 103, 189);

				//---------grafico 2-----------
				$imgKPI2 = $imgKPIs["g2"];
				$pdf->Ln(12);
				
				$pdf->SetXY(90, 10);
				$pdf->SetFont('Arial', 'BIU', 12);
				$pdf->Cell(0, 5, 'ORDENES DE TRABAJO POR ESTATUS', 0, 1);
				$pdf->Ln(8);
				
				$valX = $pdf->GetX();
				$valY = $pdf->GetY();
				$pdf->SetXY(90, $valY);
				
				$pdf->PieChart(100, 35, $imgKPI2, '%l (%p)', array($col1,$col2,$col3, $col4, $col5));
				$pdf->SetXY($valX, $valY + 40);
				
			
				//Bar diagram
				$pdf->Ln(10);
				$pdf->SetFont('Arial', 'BIU', 12);
				$pdf->Cell(0, 5, '2 - Bar diagram', 0, 1);
				$pdf->Ln(8);
				$valX = $pdf->GetX();
				$valY = $pdf->GetY();
				$pdf->BarDiagram(190, 70, $imgKPI2, '%l : %v (%p)', array(255,175,100));
				$pdf->SetXY($valX, $valY + 80);
			
				$pdf->Output();

			}
			else
			{
				echo "<h1>Autorización no válidad</h1>";
			}
		}
	}
}

class PDF_Sector extends FPDF
{
    function Sector($xc, $yc, $r, $a, $b, $style='FD', $cw=true, $o=90)
    {
        $d0 = $a - $b;
        if($cw){
            $d = $b;
            $b = $o - $a;
            $a = $o - $d;
        }else{
            $b += $o;
            $a += $o;
        }
        while($a<0)
            $a += 360;
        while($a>360)
            $a -= 360;
        while($b<0)
            $b += 360;
        while($b>360)
            $b -= 360;
        if ($a > $b)
            $b += 360;
        $b = $b/360*2*M_PI;
        $a = $a/360*2*M_PI;
        $d = $b - $a;
        if ($d == 0 && $d0 != 0)
            $d = 2*M_PI;
        $k = $this->k;
        $hp = $this->h;
        if (sin($d/2))
            $MyArc = 4/3*(1-cos($d/2))/sin($d/2)*$r;
        else
            $MyArc = 0;
        //first put the center
        $this->_out(sprintf('%.2F %.2F m',($xc)*$k,($hp-$yc)*$k));
        //put the first point
        $this->_out(sprintf('%.2F %.2F l',($xc+$r*cos($a))*$k,(($hp-($yc-$r*sin($a)))*$k)));
        //draw the arc
        if ($d < M_PI/2){
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
        }else{
            $b = $a + $d/4;
            $MyArc = 4/3*(1-cos($d/8))/sin($d/8)*$r;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
        }
        //terminate drawing
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='b';
        else
            $op='s';
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3 )
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
            $x1*$this->k,
            ($h-$y1)*$this->k,
            $x2*$this->k,
            ($h-$y2)*$this->k,
            $x3*$this->k,
            ($h-$y3)*$this->k));
    }
}

class PDF_Diag extends PDF_Sector {
	var $legends;
	var $legendsVal;
    var $wLegend;
    var $sum;
    var $NbVal;

	function SemiPieChart($w, $h, $data, $format)
    {
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data,$format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $hLegend = 3;
        $radius = min($w - $margin * 4 - $hLegend - $this->wLegend, $h - $margin * 2);
        $radius = floor($radius / 2);
        $XDiag = $XPage + $margin + $radius;
        $YDiag = $YPage + $margin + $radius;
		

        //Sectors
        $angleStart = 0;
        $angleEnd = 0;
		
		$this->SetDrawColor(255, 255, 255);
		$this->SetLineWidth(0);

		//Dibujando el porcentaje completado
		$angle = ($data["numFinalziados"] * 180) / $data["total"];
		if ($angle != 0) 
		{
			$angleEnd = $angleStart + $angle;
			$this->SetFillColor(31, 119, 180);
			$this->Sector($XDiag, $YDiag, $radius, $angleStart, $angleEnd, 'FD', true, 180);
			$angleStart += $angle;
		}
		
		//Dibujando el porcentaje total o el plomo
		$this->SetFillColor(220, 220, 220);
		$this->Sector($XDiag, $YDiag, $radius, $angleStart, 180, 'FD', true, 180);
		
		//Dibujando un circulo blanco en el medio
		$this->SetFillColor(255, 255, 255);
		$this->Sector($XDiag, $YDiag, 20, 0, 180, 'FD', true, 180);

        
        $this->SetFont('Courier', '', 10);
        $x1 = $XPage + 4 * $margin;
        $x2 = $x1 + $hLegend + $margin;
        $y1 = $YDiag - $radius + (2 * $radius - $this->NbVal*($hLegend + $margin)) / 2 + $radius/2 - 3;
		
		//Legends
		$this->SetFillColor(31, 119, 180);
        $this->Rect($x1, $y1, $hLegend, $hLegend, 'DF');
		$this->SetXY($x2,$y1);
		$this->Cell(0,$hLegend, "Finalizados/Total(".$data["numFinalziados"]."/".$data["total"].")");

		//Colocando el numero cero
		$this->SetXY($x2-6,$y1-5);
		$this->Cell(0,$hLegend, "0");

		//Colocando el numero cien
		$this->SetXY($x2+$radius+10,$y1-5);
		$this->Cell(0,$hLegend, "100");

		//Colocando el porcentaje completado
		$this->SetFont('Courier', '', 20);
		$this->SetXY($x2+12,$y1-10);
        $this->Cell(0,$hLegend, $data["porcentaje"]."%");
	}
	
    function PieChart($w, $h, $data, $format, $colors=null)
    {
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data,$format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $hLegend = 5;
        $radius = min($w - $margin * 4 - $hLegend - $this->wLegend, $h - $margin * 2)+5;
        $radius = floor($radius / 2);
        $XDiag = $XPage + $margin + $radius;
        $YDiag = $YPage + $margin + $radius;
		if($colors == null) 
		{
			for($i = 0; $i < $this->NbVal; $i++) 
			{
                $gray = $i * intval(255 / $this->NbVal);
                $colors[$i] = array($gray,$gray,$gray);
            }
        }

        //Sectors
        $this->SetLineWidth(0.2);
        $angleStart = 0;
        $angleEnd = 0;
        $i = 0;
		foreach($data as $val) 
		{
            $angle = ($val * 360) / doubleval($this->sum);
			if ($angle != 0) 
			{
                $angleEnd = $angleStart + $angle;
                $this->SetFillColor($colors[$i][0],$colors[$i][1],$colors[$i][2]);
                $this->Sector($XDiag, $YDiag, $radius, $angleStart, $angleEnd, 'FD', true, 180);
                $angleStart += $angle;
            }
            $i++;
		}

        //Legends
        $this->SetFont('Courier', '', 10);
        $x1 = $XPage + 2 * $radius + 4 * $margin;
        $x2 = $x1 + $hLegend + $margin;
        $y1 = $YDiag - $radius + (2 * $radius - $this->NbVal*($hLegend + $margin)) / 2;
		for($i=0; $i<$this->NbVal; $i++) 
		{
            $this->SetFillColor($colors[$i][0],$colors[$i][1],$colors[$i][2]);
            $this->Rect($x1, $y1, $hLegend, $hLegend, 'DF');
            $this->SetXY($x2,$y1);
            $this->Cell(0,$hLegend,$this->legends[$i]." (".$this->legendsVal[$i]."/".$this->sum.")");
            $y1+=$hLegend + $margin;
        }
    }

    function BarDiagram($w, $h, $data, $format, $color=null, $maxVal=0, $nbDiv=4)
    {
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data,$format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $YDiag = $YPage + $margin;
        $hDiag = floor($h - $margin * 2);
        $XDiag = $XPage + $margin * 2 + $this->wLegend;
        $lDiag = floor($w - $margin * 3 - $this->wLegend);
        if($color == null)
            $color=array(155,155,155);
        if ($maxVal == 0) {
            $maxVal = max($data);
        }
        $valIndRepere = ceil($maxVal / $nbDiv);
        $maxVal = $valIndRepere * $nbDiv;
        $lRepere = floor($lDiag / $nbDiv);
        $lDiag = $lRepere * $nbDiv;
        $unit = $lDiag / $maxVal;
        $hBar = floor($hDiag / ($this->NbVal + 1));
        $hDiag = $hBar * ($this->NbVal + 1);
        $eBaton = floor($hBar * 80 / 100);

        $this->SetLineWidth(0.2);
        $this->Rect($XDiag, $YDiag, $lDiag, $hDiag);

        $this->SetFont('Courier', '', 10);
        $this->SetFillColor($color[0],$color[1],$color[2]);
        $i=0;
        foreach($data as $val) {
            //Bar
            $xval = $XDiag;
            $lval = (int)($val * $unit);
            $yval = $YDiag + ($i + 1) * $hBar - $eBaton / 2;
            $hval = $eBaton;
            $this->Rect($xval, $yval, $lval, $hval, 'DF');
            //Legend
            $this->SetXY(0, $yval);
            $this->Cell($xval - $margin, $hval, $this->legends[$i],0,0,'R');
            $i++;
        }

        //Scales
        for ($i = 0; $i <= $nbDiv; $i++) {
            $xpos = $XDiag + $lRepere * $i;
            $this->Line($xpos, $YDiag, $xpos, $YDiag + $hDiag);
            $val = $i * $valIndRepere;
            $xpos = $XDiag + $lRepere * $i - $this->GetStringWidth($val) / 2;
            $ypos = $YDiag + $hDiag - $margin;
            $this->Text($xpos, $ypos, $val);
        }
    }

    function SetLegends($data, $format)
    {
		$this->legends=array();
		$this->legendsVal=array();
        $this->wLegend=0;
        $this->sum=array_sum($data);
        $this->NbVal=count($data);
        foreach($data as $l=>$val)
        {
            $p=sprintf('%.2f',$val/$this->sum*100).'%';
            $legend=str_replace(array('%l','%v','%p'),array($l,$val,$p),$format);
			$this->legends[]=$legend;
			$this->legendsVal[]=$val;
            $this->wLegend=max($this->GetStringWidth($legend),$this->wLegend);
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
