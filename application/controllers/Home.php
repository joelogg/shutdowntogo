<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
	
}
