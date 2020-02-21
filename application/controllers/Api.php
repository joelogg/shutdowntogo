<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

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
        echo var_dump($_POST);
	}


//------------------ Usuario -----------------
	// login
	public function login()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->iniciarSesion($data["correo"], $data["password"]);
        echo json_encode($rpta); 
	}

	public function cerrarSesion()
	{
		$token = $_POST['token']; // please read the below note

		$this->load->model('data_model');
		$rpta = $this->data_model->cerrarSesion($token);
        echo json_encode($rpta); 
	}
	
	public function getUsuarioToken()
	{
		$token = $_POST['token'];

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		echo json_encode($rpta); 		
	}

	public function usuarioCrear()
	{
		$data = $_POST['json'];
		$token = $_POST['token'];
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		
		if($rpta["data"]!="")
		{
			$rpta = $this->data_model->insertUsuario($data["nombre"], $data["apellido"], $data["correo"], $data["password"], $data["rol"], $token);
			$results = array(
				"status" => "success",
				"code" => "200",
				"message" => "usuario creado",
				"data"=>$rpta
			);
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
		}
		
        echo json_encode($results); 
	}

	public function usuarioCrearAdmin()
	{
		$data = $_POST['json'];
		$data = json_decode($data, true);
		$this->load->model('data_model');
		$rpta = $this->data_model->insertUsuarioAdmin($data["nombre"], $data["apellido"], $data["correo"], $data["password"],4);

		$results = array(
			"status" => "success",
			"code" => "200",
			"message" => "usuario creado",
			"data"=>$rpta
		);
		
		echo json_encode($results);
	}

	public function subirArchivoUsuarios()
	{
		$headers = apache_request_headers();
		$token = $headers["token"];

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		
		if($rpta["data"]!="")
		{
			$idCreador = $rpta["data"]->idUsuario;
			//SI EL ARCHIVO SE ENVIÓ Y ADEMÁS SE SUBIO CORRECTAMENTE
			if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) 
			{
			
				$fp = fopen($_FILES['archivo']['tmp_name'], "r");
	
				$dataUsuarios = array();
	
				$this->load->library('encryption');
	
				$i = 0;
				while (!feof($fp))
				{
					$data  = explode(";", fgets($fp));
					if($data[0]=="")
					{
						break;
					}
	
					if($i>0)
					{
						if (filter_var($data[2], FILTER_VALIDATE_EMAIL)) 
						{
							array_push($dataUsuarios, 
								array(
									'nombre' => $data[0],
									'apellido' => $data[1],
									'correo' => $data[2],
									'perfiles_id' => (int)$data[3],
									'password' => $this->encryption->encrypt('123456a'),
									'creadopor' => $idCreador
								)
							);
						}
						else
						{
							$results = array(
								"status" => "error",
								"code" => "400",
								"message" => "Formato de correo invalido"
							);
							echo json_encode($results); 
							return;
						}
					}
					$i++;
				}
	
				$this->load->model('data_model');
				$rpta = $this->data_model->insertUsuariosArray($dataUsuarios);
				echo json_encode($rpta); 
				
			}
			else
			{
				$results = array(
					"status" => "error",
					"code" => "400",
					"message" => "No se ha leído el archivo"
				);
				   
				echo json_encode($results); 
			}


			
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
			echo json_encode($results); 
		}
		




	}
	
	public function enviarInvitacion()
	{
		$data = $_POST['json'];
		$token = $_POST['token'];
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		
		if($rpta["data"]!="")
		{
			$rpta = $this->data_model->insertUsuarioInvitacion($data["idPerfil"], $data["correo"], $token);
			$results = array(
				"status" => "success",
				"code" => "200",
				"message" => "invitacion realizada",
				"data"=>$rpta
			);
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
		}
		
        echo json_encode($results); 
	}

	public function usuariosListarTodo()
	{
		$token = $_POST["token"];

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		if($rpta["data"]!="")
		{
			$rpta = $this->data_model->selectUsuarios();
			$results = array(
				"status" => "success",
				"code" => "200",
				"message" => "listado de usuarios",
				"data"=>$rpta
			);
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
		}
		
		echo json_encode($results);
	}

	public function perfilesListarTodo()
	{
		$token = $_POST["token"];

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		if($rpta["data"]!="")
		{
			$rpta = $this->data_model->selectPerfiles();
			$results = array(
				"status" => "success",
				"code" => "200",
				"message" => "listado de perfiles",
				"data"=>$rpta
			);
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
		}
		
		echo json_encode($results);
	}
	
	public function subirImagenUsuario()
	{
		$headers = apache_request_headers();
		$token = $headers["token"];
		//$token = $_POST["token"];

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		
		if($rpta["data"]!="")
		{
			$idCreador = $rpta["data"]->idUsuario;
			//SI EL ARCHIVO SE ENVIÓ Y ADEMÁS SE SUBIO CORRECTAMENTE
			if (isset($_FILES["imagen"]) && is_uploaded_file($_FILES['imagen']['tmp_name'])) 
			{
			
				$config['upload_path'] = './desarrollo/img/usuarios/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = 2048;
				$config['overwrite'] = TRUE;
				$config['file_name'] = $idCreador;

				
				
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('imagen')) 
				{
					$error = array('error' => $this->upload->display_errors());
					echo json_encode($error);
				}
				else
				{
					$nombreImg = $_FILES['imagen']['name'];
					$extension = explode(".", $nombreImg);
					$extension = $extension[ sizeof($extension)-1];

					$nombreImg = $config['upload_path'].$idCreador.".".$extension;

					$error = array('nombre'=>$nombreImg,'size' => $_FILES['imagen']['size'], 'extension'=>$extension);
					echo json_encode($error);
				}
		
				
			}
			else
			{
				$results = array(
					"status" => "error",
					"code" => "400",
					"message" => "Imagen no cargada"
				);
				   
				echo json_encode($results); 
			}


			
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
			echo json_encode($results); 
		}
		




	}
	
//------------------ Orden Trabajo -----------------
	public function ordenTrabajoCrear()
	{
		$data = $_POST['json'];
		$token = $_POST['token'];
		$data = json_decode($data, true);

		if( !isset($data['estadoOT_id']) )
		{
			$data['estadoOT_id'] = 2;//En la BD abierta
		}

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		
		if($rpta["data"]!="")
		{
			$rpta = $this->data_model->insertOrdenTrabajo($data, $token);
			$results = array(
				"status" => "success",
				"code" => "200",
				"message" => "OT creada",
				"data"=>$rpta
			);
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
		}
		
        echo json_encode($results);
	}

	public function ordenTrabajoListarTodo()
	{
		$token = $_POST["token"];

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		if($rpta["data"]!="")
		{
			$rpta = $this->data_model->selectOrdenesTrabajo($rpta["data"], "web", -1);
			//$rpta = $this->data_model->selectOrdenesTrabajo(1);
			$usuarios = $this->data_model->selectUsuarios();


			foreach ($rpta as $unaOT) 
			{
				$idsUsu = explode(",", $unaOT->responsable);
				$nombres = [];
				foreach ($idsUsu as $idUsu) 
				{
					foreach ($usuarios as $usuario) 
					{
						if($usuario->id == $idUsu)
						{
							array_push($nombres, array("id"=>$usuario->id, "nombre"=>$usuario->nombre, "apellido"=>$usuario->apellido, "imagen"=>$usuario->imagen));
							break;
						}
					}
				}
				$unaOT->responsable = $nombres;
			}

			$results = array(
				"status" => "success",
				"code" => "200",
				"message" => "listado de OTs",
				"data"=>$rpta
			);
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
		}
		
		echo json_encode($results);
	}

	public function ordenTrabajoListarTodoMovil()
	{
		$token = $_POST["token"];

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		if($rpta["data"]!="")
		{
			$rpta = $this->data_model->selectOrdenesTrabajo($rpta["data"], "movil", -1);
			$usuarios = $this->data_model->selectUsuarios();


			foreach ($rpta as $unaOT) 
			{
				$idsUsu = explode(",", $unaOT->responsable);
				$nombres = [];
				foreach ($idsUsu as $idUsu) 
				{
					foreach ($usuarios as $usuario) 
					{
						if($usuario->id == $idUsu)
						{
							array_push($nombres, array("id"=>$usuario->id, "nombre"=>$usuario->nombre, "apellido"=>$usuario->apellido, "imagen"=>$usuario->imagen));
							break;
						}
					}
				}
				$unaOT->responsable = $nombres;
			}

			$results = array(
				"status" => "success",
				"code" => "200",
				"message" => "listado de OTs Movil",
				"data"=>$rpta
			);
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
		}
		
		echo json_encode($results);
	}


	public function ordenTrabajoEditar()
	{
		$data = $_POST['json'];
		$token = $_POST['token'];
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		
		if($rpta["data"]!="")
		{
			$rpta = $this->data_model->updateOrdenTrabajo($data, $token);
			$results = array(
				"status" => "success",
				"code" => "200",
				"message" => "OT modificada",
				"data"=>$rpta
			);
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
		}
		
        echo json_encode($results); 
	}

	public function ordeTrabajoCambiarEstado()
	{
		$data = $_POST['json'];
		$token = $_POST['token'];
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		
		if($rpta["data"]!="")
		{
			$rpta = $this->data_model->updateEstadoOTsiguiente($data, $token);
			if($rpta)
			{
				$results = array(
					"status" => "success",
					"code" => "200",
					"message" => "Estado cambaido",
					"data"=>$rpta
				);
			}
			else
			{
				$results = array(
					"status" => "error",
					"code" => "400",
					"message" => "No ha cambiado",
					"data"=>$rpta
				);
			}
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
		}
		
        echo json_encode($results); 
	}


	public function subirOTsExcel()
	{
		$data = $_POST['datos'];
		$token = $_POST['token'];
		
		$data = json_decode($data, true);
		
		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		
		if($rpta["data"]!="")
		{
			$idProy = $this->data_model->insertProyecto($data["revision"], $data["fechaInicio"], $data["fechaFin"]);
			//$idProy = 1;
			if($idProy >0)
			{
				$data = $data["dataOTs"];

				$rpta = "";
				//Insertando fila
				$cantDatosInsertados = 0;
				foreach($data as $fila)
				{
					$area = $fila["Area"];
					$codEquipo = $fila["Codigo equipo"];
					$descEquipo = $fila["Descripcion Equipo"];
					$prioridad = $fila["Prioridad OT"];
					$tipoOT = $fila["Tipo OT"];

					$especialidad = $fila["Especialidad"];

					$numOT = $fila["Orden de trabajo"];
					$desOT = $fila["Descripcion OT"];

					$numOpe = $fila["Operacion numero"];
					$desOpe = $fila["Descripcion Operacion"];
					$fechaIniOpe = $fila["Fecha inicio"];
					$fechaFinOpe = $fila["Fecha fin"];
					$duracion = $fila["Duracion"];
					$resources = $fila["Resources"];
					$work = $fila["Work"];

										
					$idArea = $this->data_model->insertArea($area);
					$idEquipo = $this->data_model->insertEquipo($codEquipo, $descEquipo, $idArea);
					$idPrioridad = $this->data_model->selectPrioridad($prioridad);
					$idTipoOT = $this->data_model->insertTipoOT($tipoOT);
					$idEspecialidad = $this->data_model->insertEspecialidad($especialidad);

					$dataOT['ordentrabajo'] = $numOT;
					$dataOT['descripcion'] = $desOT;
					$dataOT['prioridad_id'] = $idPrioridad;
					$dataOT['equipo_id'] = $idEquipo;
					$dataOT['proyecto_id'] = $idProy;
					$dataOT['tipo_id'] = $idTipoOT;
					$idOT = $this->data_model->insertTipoOTExcel($dataOT, $token);
					
					$dataOP['ordenestrabajo_id'] = $idOT;
					$dataOP['especialidad_id'] = $idEspecialidad;
					$dataOP['numerooperacion'] = $numOpe;
					$dataOP['descripcion'] = $desOpe;
					$dataOP['fechainicio'] = $fechaIniOpe;
					$dataOP['fechafin'] = $fechaFinOpe;
					$dataOP['work'] = $work;
					$dataOP['resources'] = $resources;
					$dataOP['duracion'] = $duracion;
					$idOp = $this->data_model->insertOperacion($dataOP, $token);

					$cantDatosInsertados++;
					
				}
			
				$results = array(
					"status" => "success",
					"code" => "200",
					"message" => "OT creada",
					"data"=>"Datos insertados: ".$cantDatosInsertados
				);
				echo json_encode($results);
			}
			else
			{
				$results = array(
					"status" => "error",
					"code" => "400",
					"message" => "Error al crear semana",
					"data"=>[]
				);
				echo json_encode($results);
			}

		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
			echo json_encode($results);
		}
		
		//echo $data;
	}

//------------------ Operaciones -----------------
	public function operacionCrear()
    {
        $data = $_POST['json'];
        $token = $_POST['token'];
        $data = json_decode($data, true);

        $this->load->model('data_model');
        $rpta = $this->data_model->selectUsuarioToken($token);
        
        if($rpta["data"]!="")
        {
            $rpta = $this->data_model->insertOperacion($data, $token);
            $results = array(
                "status" => "success",
                "code" => "200",
                "message" => "operacion creada",
                "data"=>$rpta
            );
        }
        else
        {
            $results = array(
                "status" => "error",
                "code" => "400",
                "message" => "token inválido",
                "data"=>[]
            );
        }
        
        echo json_encode($results);
	}

	public function operacionesListarTodo()
	{
		$token = $_POST["token"];

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		if($rpta["data"]!="")
		{
			$rpta = $this->data_model->selectOperaciones($rpta["data"], -1);

			$usuarios = $this->data_model->selectUsuarios();


			foreach ($rpta as $unaOp) 
			{
				$idsUsu = explode(",", $unaOp->participantes);
				$nombres = [];
				foreach ($idsUsu as $idUsu) 
				{
					foreach ($usuarios as $usuario) 
					{
						if($usuario->id == $idUsu)
						{
							array_push($nombres, array("id"=>$usuario->id, "nombre"=>$usuario->nombre, "apellido"=>$usuario->apellido, "imagen"=>$usuario->imagen));
							break;
						}
					}
				}
				$unaOp->participantes = $nombres;
			}


			$results = array(
				"status" => "success",
				"code" => "200",
				"message" => "listado de operaciones",
				"data"=>$rpta
			);
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
		}
		
		echo json_encode($results);
	}

	public function operacionesCambiarEstado()
	{
		$data = $_POST['json'];
        $token = $_POST['token'];
        $data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		
		if($rpta["data"]!="")
		{
			$rpta = $this->data_model->updateEstadoOperacion($data["idOp"], $data["estado"], $token);
			if($rpta)
			{
				$results = array(
					"status" => "success",
					"code" => "200",
					"message" => "Estado cambaido",
					"data"=>$rpta
				);
			}
			else
			{
				$results = array(
					"status" => "error",
					"code" => "400",
					"message" => "No ha cambiado",
					"data"=>$rpta
				);
			}
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
		}
		
        echo json_encode($results); 
	}


//------------------ Comentarios -----------------
	public function comentariosCrear()
    {
        $data = $_POST['json'];
        $token = $_POST['token'];
        $data = json_decode($data, true);

        $this->load->model('data_model');
        $rpta = $this->data_model->selectUsuarioToken($token);
        
        if($rpta["data"]!="")
        {
            $rpta = $this->data_model->insertComentario($data, $token);
            $results = array(
                "status" => "success",
                "code" => "200",
                "message" => "comentario creado",
                "data"=>$rpta
            );
        }
        else
        {
            $results = array(
                "status" => "error",
                "code" => "400",
                "message" => "token inválido",
                "data"=>[]
            );
        }
        
        echo json_encode($results);
	}

	public function subirImagenComentario()
	{
		$idCom = $_POST['idCom'];
		$token = $_POST['token'];

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		
		if($rpta["data"]!="")
		{
			$this->load->model('data_model');
			$idOp = $this->data_model->selecComentario($idCom);

			$idCreador = $rpta["data"]->idUsuario;
			//SI EL ARCHIVO SE ENVIÓ Y ADEMÁS SE SUBIO CORRECTAMENTE
			if ($idOp!=0 && isset($_FILES["imagen"]) && is_uploaded_file($_FILES['imagen']['tmp_name'])) 
			{
				$carpeta = 'adjuntos/comentarios/'.$idOp.'/';
				if (!file_exists($carpeta)) {
					mkdir($carpeta, 0755, true);
				}

				
				$config['upload_path'] = $carpeta;
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['overwrite'] = TRUE;
				$config['file_name'] = $idCom;

				
				
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('imagen')) 
				{
					$error = array('error' => $this->upload->display_errors());
					echo json_encode($error);
				}
				else
				{
					$nombreImg = $_FILES['imagen']['name'];
					$extension = explode(".", $nombreImg);
					$extension = $extension[ sizeof($extension)-1];

					$nombreImg = $config['upload_path'].$idCom.".".$extension;

					$infoImg = array('comentarios_id'=>$idCom, 'nombre'=>$nombreImg,'tamano' => $_FILES['imagen']['size'], 'extension'=>$extension);

					$rpta = $this->data_model->updateImagenComentario($infoImg, $idCreador);
					$results = array(
						"status" => "success",
						"code" => "200",
						"message" => "Imagen subida",
						"data"=>$infoImg
					);
					echo json_encode($results);
				}
				
			}
			else
			{
				$results = array(
					"status" => "error",
					"code" => "400",
					"message" => "Imagen no cargada"
				);
				   
				echo json_encode($results); 
			}


			
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
			echo json_encode($results); 
		}
		




	}
	
	public function comentariosPorIdOpe()
	{
		$token = $_POST["token"];
		$idOp = $_POST["idOp"];

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		if($rpta["data"]!="")
		{
			$rpta = $this->data_model->selectComentarios($idOp);

			$usuarios = $this->data_model->selectUsuarios();


			foreach ($rpta as $unComentario) 
			{
				$idUsu =$unComentario->creadopor;
				foreach ($usuarios as $usuario) 
				{
					if($usuario->id == $idUsu)
					{
						$unComentario->nombreUsu = $usuario->nombre;
						$unComentario->apellidoUsu = $usuario->apellido;
						$unComentario->imagenUsu = $usuario->imagen;
						break;
					}
				}
				
			}


			$results = array(
				"status" => "success",
				"code" => "200",
				"message" => "listado de operaciones",
				"data"=>$rpta
			);
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
		}
		
		echo json_encode($results);
	}

	public function operacionEditar()
	{
		$data = $_POST['json'];
		$token = $_POST['token'];
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuarioToken($token);
		
		
		if($rpta["data"]!="")
		{
			$rpta = $this->data_model->updateOperacion($data, $token);
			$results = array(
				"status" => "success",
				"code" => "200",
				"message" => "Operacion modificada",
				"data"=>$rpta
			);
		}
		else
		{
			$results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token inválido",
				"data"=>[]
			);
		}
		
        echo json_encode($results); 
	}

	
	/*

	// Lee todas la tareas del proyecto, recibe como parámetro el ID del proyecto
	public function leerTareasIdP()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->selectTareaIdP($data["idP"]);
        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "todos los datos de tareas",
			"data"=>$rpta);
           
		echo json_encode($results); 
	}

	// Lee todas la actividades del proyecto, recibe como parámetro el ID del proyecto
	function leerActividadesIdT()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->selectActividadesIdP($data["idP"]);
		$rpta2 = $this->data_model->selectAlertasPendientesIdP($data["idP"]);
		        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "todos los datos de actividades",
			"data"=>$rpta,
			"alertas"=>$rpta2);
           
		echo json_encode($results); 
	}

	function leeEquiposIdArea()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
        $rpta = $this->data_model->selectEquiposIdArea($data["idArea"]);
        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "Equipos por id de area",
			"data"=>$rpta);
           
		echo json_encode($results); 
	}
	
	function enviarMensaje()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
        $rpta = $this->data_model->registrarMensajeChat($data["mensaje"], $data["mencion"], $data["actividad"], $data["creadopor"]);
        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "Mensaje creado",
			"data"=>$rpta);
           
		echo json_encode($results); 
	}

	

	function registrarAvances()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$this->data_model->registrarAcances($data['idA'], $data['modificadopor'], $data['avance']);
		
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "Avance creado");
           
		echo json_encode($results);
	}

	function registrarAcancesManual()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$this->data_model->registrarAcancesManual($data['idA'], $data['modificadopor'], $data['avance'], $data['fecha']);
		
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "Avance creado");
           
		echo json_encode($results);
	}

	function datosGraficaProyecto()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->selectActividadesGraficaIdP($data["idP"]);
		
		date_default_timezone_set('America/Santiago');
		$fechaActual = date("Y-m-d H:i:s");
		
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "todos los datos de actividades",
			"data"=>$rpta,
			"fechaActual"=>$fechaActual);
           
		echo json_encode($results); 
	}

	function datosAvancesProyecto()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->selectAvancesIdP($data["idP"]);
		        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "todos los datos de actividades",
			"data"=>$rpta);
           
		echo json_encode($results); 
	}

	function actualizarInicioRealActividad()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->updateInicioRealActividad($data["idA"]);
		        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "fecha real inicio actualizada",
			"data"=>$rpta);
           
		echo json_encode($results); 
	}

	function actualizarFinRealActividad()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->updateFinRealActividad($data["idA"]);
		        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "fecha real inicio actualizada",
			"data"=>$rpta);
           
		echo json_encode($results); 
	}


	function avanceActividad()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
        $rpta = $this->data_model->selectAvanceIdActividad($data["idActividad"]);
        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "Avance por id de activida",
			"data"=>$rpta[0]);
           
		echo json_encode($results); 
	}


	
	function getUsuarios()
	{
		$this->load->model('data_model');
        $rpta = $this->data_model->selectUsuarios();
        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "Usuarios",
			"data"=>$rpta);
           
		echo json_encode($results); 
	}


	function getIdAreaconIdEquipo()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
        $rpta = $this->data_model->selectIdAreaConIdEquipo($data["idEquipo"]);
        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "Avance por id de activida",
			"data"=>$rpta[0]);
           
		echo json_encode($results); 
	}

	

	function registrarAlerta()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
        $rpta = $this->data_model->insertAlerta($data["idA"], $data["descripcion"], $data["creadopor"], $data["categoria"]);
        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "Alerta registrada",
			"data"=>$rpta);
           
		echo json_encode($results); 
	}


	
	function getAlertaPorId()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->selectAlerta($data["idAlerta"]);
        $rpta2 = $this->data_model->selectAdjuntoAlerta($data["idAlerta"]);	
		
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "Datos Alerta",
			"alerta"=>$rpta,
			"adjuntoAlerta"=>$rpta2);
           
		echo json_encode($results); 
	}


	function getAlertaGrafica()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->selectAlertaGrafica($data["idP"]);
		
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "Datos Alerta",
			"data"=>$rpta);
           
		echo json_encode($results); 
	}


	//------------------------------- creando los enpoints pasados -----------------------
	

	public function getusuario()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->selectUsuario($data["correo"]);
		
		$results = array(
			"status" => "error",
    		"code" => "400",
    		"message" => "alert.error",
			"data"=>$rpta);

		if(sizeof($rpta)>=1)
		{
			$results = array(
				"status" => "success",
				"code" => "200",
				"message" => "alert.success",
				"data"=>$rpta);
		}
        
           
		echo json_encode($results); 
	}

	public function proyectoBuscarporId()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->selectProyecto($data["idproyecto"]);
		
		$results = array(
			"status" => "success",
			"code" => "200",
			"message" => "alert.success",
			"data"=>$rpta);
           
		echo json_encode($results); 
	}

	public function areaListarTodo()
	{
		$this->load->model('data_model');
		$rpta = $this->data_model->selectAreas();
		
		$results = array(
			"status" => "success",
			"code" => "200",
			"message" => "alert.success",
			"data"=>$rpta);
        
           
		echo json_encode($results); 
	}
	
	public function equipoListarTodo()
	{
		$this->load->model('data_model');
		$rpta = $this->data_model->selectEquipos();
		
		$results = array(
			"status" => "success",
			"code" => "200",
			"message" => "alert.success",
			"data"=>$rpta);
        
           
		echo json_encode($results); 
	}
	
	public function prioridadListarTodo()
	{
		$this->load->model('data_model');
		$rpta = $this->data_model->selectPrioridades();
		
		$results = array(
			"status" => "success",
			"code" => "200",
			"message" => "alert.success",
			"data"=>$rpta);        
           
		echo json_encode($results); 
	}
	
	
	
	public function especialidadListarTodo()
	{
		$this->load->model('data_model');
		$rpta = $this->data_model->selectEspecialidades();
		
		$results = array(
			"status" => "success",
			"code" => "200",
			"message" => "alert.success",
			"data"=>$rpta);        
           
		echo json_encode($results); 
	}
	
	public function requerimientoListarTodo()
	{
		$this->load->model('data_model');
		$rpta = $this->data_model->selectRequerimientos();
		
		$results = array(
			"status" => "success",
			"code" => "200",
			"message" => "alert.success",
			"data"=>$rpta);        
           
		echo json_encode($results); 
	}
	
	public function grupoTrabajoListarTodo()
	{
		$this->load->model('data_model');
		$rpta = $this->data_model->selectGruposTrabajo();
		
		$results = array(
			"status" => "success",
			"code" => "200",
			"message" => "alert.success",
			"data"=>$rpta);        
           
		echo json_encode($results); 
	}
	
	function tareaEditar()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->updateTarea($data["tarea"], $data["modificadopor"], $data["proyecto_id"], 
												$data["descripcion"], $data["equipo_id"], $data["prioridad_id"], 
												$data["tipotarea"], $data["disciplina"]);
		        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "fecha real inicio actualizada",
			"data"=>$rpta);
           
		echo json_encode($results);
	}
	
	function actividadActualizar()
	{
		$data = $_POST['json']; // please read the below note
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->updateActividad($data["id_actividad"], $data["id_tarea"], $data["mofificadopor"], $data["especialidad_id"], 
												$data["requerimiento_id"], $data["descripcion"], $data["ordentrabajo"], $data["fechainicioplanificada"], 
												$data["fechafinplanificada"], $data["fechainicioreal"], $data["fechafinreal"], $data["estado"], 
												$data["responsables"], $data["seguidores"], $data["grupo"]);
		        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "fecha real inicio actualizada",
			"data"=>$rpta);
           
		echo json_encode($results);
	}

	function tareaCrear()
	{
		$data = $_POST['json'];
		$data = json_decode($data, true);

		$this->load->model('data_model');
		$rpta = $this->data_model->insertTarea($data["creadopor"], $data["proyecto_id"], $data["descripcion"], $data["equipo_id"], 
												$data["prioridad_id"], $data["tipotarea"], $data["disciplina"]);
        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "Tarea registrada",
			"data"=>$rpta);
        
		
		echo json_encode($results);
	}

	function tareaEliminar()
	{
		$id_tarea = $_REQUEST['id_tarea'];

		$this->load->model('data_model');
		$rpta = $this->data_model->deleteTarea($id_tarea);
        
        $results = array(
			"status" => "success",
    		"code" => "200",
    		"message" => "Tarea eliminada",
			"data"=>$rpta);
        
		
		echo json_encode($results);
	}
	*/
	

}


