<?php 

class Data_model extends CI_Model
{
    //------------------ Usuario -----------------
    public function iniciarSesion($correo, $password)
    {
        $this->load->library('encryption');
        
        $this->db->select('*');
        $this->db->from('usuario');
        $this->db->where('correo=', $correo);
        $rpta = $this->db->get();

        if($rpta->num_rows() > 0)
        {
            $row = $rpta->row();
            $pwdBD = $this->encryption->decrypt($row->password);
            //$pwdBD = $row->password;
            if($pwdBD == $password)
            {
                $token = $this->encryption->encrypt($row->id);
            
                $this->db->set('token', $token);
                $this->db->where('id', $row->id);
                $rpta = $this->db->update('usuario'); 

                $results = array(
                    "status" => "success",
                    "code" => "200",
                    "message" => "sesion iniciada",
                    "data"=>$token
                );
                return $results;
            }
            else
            {
                $results = array(
                    "status" => "error",
                    "code" => "400",
                    "message" => "contraseña incorrecta",
                    "data"=>""
                );
                return $results;

            }
        }
        else
        {
            $results = array(
				"status" => "error",
				"code" => "400",
				"message" => "correo no existe",
				"data"=>""
			);
            return $results;
        }
    }

    public function cerrarSesion($token)
    {
        $this->db->set('token', "");
        $this->db->where('token', $token);
        $rpta = $this->db->update('usuario'); 



        $results = array(
            "status" => "success",
            "code" => "200",
            "message" => "Sesión cerrada",
            "data"=>$rpta
        );
        return $results;
    }

    public function selectUsuarioToken($token)
    {
        if($token=="")
        {
            $results = array(
				"status" => "error",
				"code" => "400",
				"message" => "token vacio",
				"data"=>""
            );
            return $results;
        }

        $this->db->select('usuario.id AS idUsuario, perfiles_id, nombre, apellido, correo, movil, imagen, visible, preferencias, descripcion as perfil, token');
        $this->db->from('usuario, perfiles');
        $this->db->where('usuario.perfiles_id=perfiles.id');
        $this->db->where('token=', $token);
        $rpta = $this->db->get();

        if($rpta->num_rows() > 0)
        {
            $row = $rpta->row();
            $results = array(
				"status" => "success",
				"code" => "200",
				"message" => "usuario existente en sesion",
				"data"=>$row
            );
            return $results;
        }
        else
        {
            $results = array(
				"status" => "error",
				"code" => "400",
				"message" => "no se encontro token",
				"data"=>""
            );
            return $results;
        }
    }

    public function insertUsuario($nombre, $apellido, $correo, $password, $perfil, $token)
    {
        $this->load->library('encryption');
        $idCreador = $this->encryption->decrypt($token);

        $data['nombre'] = $nombre;
        $data['apellido'] = $apellido;
        $data['correo'] = $correo;
        $data['password'] = $this->encryption->encrypt($password);
        $data['perfiles_id'] = $perfil;
        $data['visible'] = 1;
        $data['creadopor'] = $idCreador;

        $this->db->insert('usuario', $data); 
        $idNew = $this->db->insert_id();
        return $idNew;
    }

    public function insertUsuarioInvitacion($idPerfil, $correo, $token)
    {
        $this->load->library('encryption');
        $idCreador = $this->encryption->decrypt($token);

        $data['correo'] = $correo;
        $data['password'] = $this->encryption->encrypt($correo);
        $data['perfiles_id'] = $idPerfil;
        $data['creadopor'] = $idCreador;

        $this->db->insert('usuario', $data); 
        $idNew = $this->db->insert_id();
        return $idNew;
    }

    public function insertUsuarioAdmin($nombre, $apellido, $correo, $password, $perfil)
    {
        $this->load->library('encryption');

        $data['nombre'] = $nombre;
        $data['apellido'] = $apellido;
        $data['correo'] = $correo;
        $data['password'] = $this->encryption->encrypt($password);
        $data['perfiles_id'] = $perfil;
        $data['visible'] = 1;

        $this->db->insert('usuario', $data); 
        $idNew = $this->db->insert_id();
        return $idNew;
    }

    public function insertUsuariosArray($dataUsuarios)
    {
        $this->db->insert_batch('usuario', $dataUsuarios);
        if($this->db->affected_rows() > 0)
        {
            $results = array(
                "status" => "success",
                "code" => "200",
                "message" => "se creo un total de {$this->db->affected_rows()} usuarios"
            );
            return $results;
        }
        else
        {
            $results = array(
                "status" => "error",
                "code" => "400",
                "message" => "se creo un total de {$this->db->affected_rows()} usuarios"
            );
            return $results;
        }
    }

    public function selectUsuarios()
    {
        $this->db->select('usuario.id, perfiles_id, perfiles.descripcion as descripcionPerfil, nombre, apellido, correo, imagen, visible, activo');
        $this->db->from('usuario, perfiles');
        $this->db->where('usuario.perfiles_id=perfiles.id');
        $this->db->where('usuario.visible=1');
        $this->db->order_by('nombre', 'ASC');
        $rpta = $this->db->get();
        return $rpta->result();
            
    }

    public function selectPerfiles()
    {
        $this->db->select('*');
        $this->db->from('perfiles');
        $this->db->order_by('id', 'ASC');
        $rpta = $this->db->get();
        return $rpta->result();
            
    }

    public function updateImagenUsuario($dataUsuarios)
    {
        
    }
    
//------------------ Orden Trabajo -----------------
    public function insertOrdenTrabajo($dataOT, $token)
    {
        $this->load->library('encryption');
        $idCreador = $this->encryption->decrypt($token);
        //Insert OT
        $dataOT['creadopor'] = $idCreador;
        $this->db->insert('ordenestrabajo', $dataOT); 
        $idOT = $this->db->insert_id();

        return $idOT;
    }

    public function selectOrdenesTrabajo($usuario, $webMovil)
    {
        $rpta = [];

        //$perfil = $usuario->perfil;
        
        //if($perfil=="Propietario")
        {
            $this->db->select('ordenestrabajo.id as id, ordentrabajo, ordenestrabajo.descripcion, 
                            ordenestrabajo.visible AS visible, responsable, ordenestrabajo.fechainicio, ordenestrabajo.fechafin,
                            estadoOT_id, estadoot.descripcion as estado, estadoot.color as estadoOT_color,
                            prioridad.id as prioridad_id, prioridad.descripcion as descripcionPrioridad, prioridad.color as colorPrioridad,
                            equipo.id as equipo_id, equipo.descripcion as descripcionEquipo, equipo.codigo as codigoEquipo, 
                            area.id as area_id, area.descripcion as descripcionArea,
                            proyecto.id as proyecto_id, proyecto.revision as revisionProyecto,
                            tipo.id as tipo_id, tipo.descripcion as descripcionTipo, tipo.tag as tagTipo');
            $this->db->from('ordenestrabajo, estadoot');

            $this->db->where('ordenestrabajo.visible=1');
            $this->db->where('ordenestrabajo.estadoOT_id=estadoot.id');
            if($webMovil=="movil")
            {   
                $where = "estadoot.descripcion!='Finalizada' AND 
                estadoot.descripcion!='Reprogramada' AND
                ( estadoot.descripcion='Atrazada' OR ordenestrabajo.fechafin<=CURDATE() )";
                
            }
            $this->db->where($where);

            $this->db->join('prioridad', 'ordenestrabajo.prioridad_id=prioridad.id', 'left');
            $this->db->join('equipo', 'ordenestrabajo.equipo_id=equipo.id', 'left');
            $this->db->join('proyecto', 'ordenestrabajo.proyecto_id=proyecto.id', 'left');
            $this->db->join('tipo', 'ordenestrabajo.tipo_id=tipo.id', 'left');
            $this->db->join('area', 'equipo.area_id=area.id', 'left');


            $this->db->order_by('estadoot.id', 'ASC');
            $this->db->order_by('ordenestrabajo.fechafin', 'ASC');
            $this->db->order_by('ordenestrabajo.id', 'ASC');
        }
        /*else
        {
            $this->db->select('ordenestrabajo.id as id, ordentrabajo, ordenestrabajo.descripcion, 
                            ordenestrabajo.visible AS visible, responsable, ordenestrabajo.fechainicio, ordenestrabajo.fechafin,
                            estadoOT_id, estadoot.descripcion as estado, 
                            prioridad.id as prioridad_id, prioridad.descripcion as descripcionPrioridad, prioridad.color as colorPrioridad,
                            equipo.id as equipo_id, equipo.descripcion as descripcionEquipo,
                            area.id as area_id, area.descripcion as descripcionArea,
                            proyecto.id as proyecto_id, proyecto.revision as revisionProyecto,
                            tipo.id as tipo_id, tipo.descripcion as descripcionTipo, tipo.tag as tagTipo');
            $this->db->from('ordenestrabajo, responsables, usuario, estadoot');
            $this->db->where('ordenestrabajo.visible=1');
            $this->db->where('ordenestrabajo.id=responsables.ordenestrabajo_id');
            $this->db->where('responsables.usuario_id=usuario.id');
            $this->db->where('ordenestrabajo.estadoOT_id=estadoot.id');
            $this->db->where('usuario.id', $usuario->idUsuario);

            $this->db->join('prioridad', 'ordenestrabajo.prioridad_id=prioridad.id', 'left');
            $this->db->join('equipo', 'ordenestrabajo.equipo_id=equipo.id', 'left');
            $this->db->join('proyecto', 'ordenestrabajo.proyecto_id=proyecto.id', 'left');
            $this->db->join('tipo', 'ordenestrabajo.tipo_id=tipo.id', 'left');
            $this->db->join('area', 'equipo.area_id=area.id', 'left');

            if($estado == "")
            {
            }
            elseif($estado == "Finalizado")
            {
                $this->db->where('estadoot.descripcion="Finalizado"');
            }
            else
            {
                $this->db->where('estadoot.descripcion!="Finalizado"');
            }

            $this->db->order_by('fechafin', 'ASC');
            $this->db->order_by('ordenestrabajo.id', 'ASC');
        }*/

        $rpta = $this->db->get();
        return $rpta->result();
    }


    public function updateOrdenTrabajo($dataOT, $token)
    {
        $this->load->library('encryption');
        $idCreador = $this->encryption->decrypt($token);
        $dataOT['modificadopor'] = $idCreador;

        $this->db->where('id', $dataOT["id"]);
        $rpta = $this->db->update('ordenestrabajo', $dataOT); 

        return $rpta;
    }

    //------------------ Operaciones -----------------
    public function insertOperacion($dataOp, $token)
    {//ordenestrabajo_id, numerooperacion, descripcion) 
        $this->load->library('encryption');
        $idCreador = $this->encryption->decrypt($token);
        //Insert operacion
        $dataOp['creadopor'] = $idCreador;
        $dataOp['modificadopor'] = $idCreador;
        $this->db->insert('operaciones', $dataOp); 
        $idOp = $this->db->insert_id();

        return $idOp;
    }

    public function selectOperaciones($usuario)
    {
        
        $rpta = [];

        $perfil = $usuario->perfil;
        
        if($perfil=="Propietario")
        {
            $this->db->select('operaciones.id, ordenestrabajo_id, numerooperacion, operaciones.descripcion AS descripcion, 
                            operaciones.fechainicio, operaciones.fechafin, work, resources, duracion, participantes, 
                            especialidad_id, especialidad.descripcion AS descripcionEspecialidad');
            $this->db->from('operaciones, ordenestrabajo');
            $this->db->where('operaciones.visible=1');
            $this->db->where('ordenestrabajo.visible=1');
            $this->db->where('operaciones.ordenestrabajo_id=ordenestrabajo.id');
            $this->db->join('especialidad', 'operaciones.especialidad_id=especialidad.id', 'left');

            $this->db->order_by('ordenestrabajo_id', 'ASC');
        }
        else
        {
            /*$this->db->select('operaciones.id, ordenestrabajo_id, numerooperacion, operaciones.descripcion AS descripcion, 
                            operaciones.fechainicio, operaciones.fechafin, work, resources, duracion, participantes
                            especialidad_id, especialidad.descripcion AS descripcionEspecialidad');
            $this->db->from('operaciones, ordenestrabajo, usuario_operaciones, usuario');
            $this->db->where('operaciones.visible=1');
            $this->db->where('ordenestrabajo.visible=1');
            $this->db->where('usuario_operaciones.operaciones_id=operaciones.id');
            $this->db->where('usuario_operaciones.usuario_id=usuario.id');
            $this->db->where('operaciones.ordenestrabajo_id=ordenestrabajo.id');
            $this->db->where('usuario.id', $usuario->idUsuario);
            $this->db->join('especialidad', 'operaciones.especialidad_id=especialidad.id', 'left');

            $this->db->order_by('ordenestrabajo_id', 'ASC');*/

            
            
        }

        $rpta = $this->db->get();
        return $rpta->result();
           
    }

    //------------------ Comentarios -----------------
    public function insertComentario($dataComentario, $token)
    {
        $this->load->library('encryption');
        $idCreador = $this->encryption->decrypt($token);
        //Insert comentario
        $dataComentario['creadopor'] = $idCreador;
        $dataComentario['chat'] = 1;
        $this->db->insert('comentarios', $dataComentario); 
        $idComentario = $this->db->insert_id();

        return $idComentario;
    }
    
    public function selectComentarios($idOp)
    {
        $this->db->select('comentarios.id as idComentario, creadopor, fechacreacion, mensaje, chat,
                        nombre as adjuntoNombre, extension as adjuntoExtension');
        $this->db->from('comentarios');
        $this->db->where('chat=1');
        $this->db->where('operaciones_id=', $idOp);
        $this->db->join('adjunto', 'adjunto.comentarios_id=comentarios.id', 'left');
        $this->db->order_by('fechacreacion', 'ASC');

        $rpta = $this->db->get();
        return $rpta->result();
           
    }

    /*
    $valE = $this->encryption->decrypt($valE);
    if(sizeof( $rpta->result() )>=1)
        {
            foreach ($rpta->result() as $row)
            {
                $this->db->set('token', $row->id);
                $this->db->where('id', $row->id);
                $rpta = $this->db->update('usuario'); 

                return $row->id;
            }

        }
    */

    /*
    // Funcion de inicio de sesion
	public function inicio($user,$pass){
		$this->db->where('email',$user);
        $this->db->where('clave',$pass);
        $this->db->select('id, nombres, apellidos, imagen, email');
        $rpta = $this->db->get('tbUsuario');
        return $rpta->row();
    }
    

    // select tabla de tarea
    public function selectTareaIdP($idP)
    {
        $this->db->select('*');
        $this->db->from('tarea');
        $this->db->where('tarea.proyecto_id =', $idP);
        $rpta = $this->db->get();
        return $rpta->result();
    }

    // select tabla de actividad
    public function selectActividadesIdP($idP)
    {
        //$this->db->select('actividad.*,
        //actividad.id AS porcentaje, actividad.id AS alertas, actividad.id AS mensajes');
        $this->db->select('actividad.id, actividad.tarea_id, actividad.modificadopor, actividad.descripcion, 
            actividad.ordentrabajo, actividad.responsables, actividad.seguidores, actividad.especialidad_id, actividad.requerimiento_id, actividad.grupo,
            actividad.fechainicioplanificada, actividad.fechafinplanificada, actividad.fechainicioreal, actividad.fechafinreal, actividad.status,
            actividad.avance, disciplina, actividad.id AS alertas, actividad.id AS mensajes');
        //$this->db->select('actividad.id, actividad.tarea_id, actividad.modificadopor, actividad.descripcion, 
        //    actividad.ordentrabajo, actividad.responsables, actividad.seguidores, actividad.especialidad_id, actividad.requerimiento_id, actividad.grupo,
        //    actividad.fechainicioplanificada, actividad.fechafinplanificada, actividad.fechainicioreal, actividad.fechafinreal, actividad.status');
        $this->db->from('actividad, tarea');
        $this->db->where('tarea.proyecto_id =', $idP);
        $this->db->where('actividad.tarea_id=tarea.id');
        $this->db->order_by('actividad.tarea_id', 'ASC');
        $rpta = $this->db->get();
        
        return $rpta->result();
    }

    // select contador de alertas pendientes
    public function selectAlertasPendientesIdP($idP)
    {
        date_default_timezone_set('America/Santiago');
        $fechaActual = date("Y-m-d H:i:s");

        $consulta = 'SELECT alerta.actividad_id, COUNT(*) AS sinAtender FROM alerta, actividad, tarea 
            WHERE alerta.actividad_id=actividad.id AND actividad.tarea_id=tarea.id AND tarea.proyecto_id='.$idP.' AND 
            alerta.fechadeinicio<="'.$fechaActual.'" AND 
            alerta.fechafin is null GROUP BY alerta.actividad_id ORDER BY alerta.actividad_id ASC';
        $rpta = $this->db->query($consulta);
        //$rpta = $this->db->get();
        
        return $rpta->result();
    }

    public function selectEquiposIdArea($idA)
    {
        
        $this->db->select('equipo.id, equipo.area_id, equipo.codigo, equipo.descripcion');
        $this->db->from('equipo, area');
        $this->db->where('area.id=', $idA);
        $this->db->where('equipo.area_id=area.id');
        $rpta = $this->db->get();
        
        return $rpta->result();
    }

    

    public function registrarMensajeChat($mensaje, $mencion, $actividad, $creadopor)
    {
        date_default_timezone_set('America/Santiago');
        $fechaActual = date("Y-m-d H:i:s");
        $data['mensaje'] = $mensaje;
        $data['mencion'] = $mencion;
        $data['actividad_id'] = $actividad;
        $data['creadopor'] = $creadopor;
        $data['modificadopor'] = $creadopor;
        $data['fechacreacion'] = $fechaActual;
        $data['fechamodificacion'] = $fechaActual;
        $this->db->insert('chat', $data); 
        $idChat = $this->db->insert_id();
        return $idChat;
    }


    public function registrarAcances($id_actividad, $modificadopor, $avance)
    {
        date_default_timezone_set('America/Santiago');
        $fechaActual = date("Y-m-d H:i:s");
        
        //creacion de un avance
        $data['actividad_id'] = $id_actividad;
        $data['creadopor'] = $modificadopor;
        $data['modificadopor'] = $modificadopor;
        $data['fechacreacion'] = $fechaActual;
        $data['fechamodificacion'] = $fechaActual;
        $data['porcentajeavance'] = $avance;
        $rpta = $this->db->insert('avances', $data); 

        //modificacion en actividad
        if($rpta=="1")
        {
            $this->db->set('modificadopor', $modificadopor);
            $this->db->set('avance', $avance);
            $this->db->set('fechamodificacion', $fechaActual);
            $this->db->where('id', $id_actividad);
            $rpta = $this->db->update('actividad'); 
        }
        
        return $rpta;

    }

    public function registrarAcancesManual($id_actividad, $modificadopor, $avance, $fecha)
    {
        date_default_timezone_set('America/Santiago');
        $fechaActual = $fecha;
        
        //creacion de un avance
        $data['actividad_id'] = $id_actividad;
        $data['creadopor'] = $modificadopor;
        $data['modificadopor'] = $modificadopor;
        $data['fechacreacion'] = $fechaActual;
        $data['fechamodificacion'] = $fechaActual;
        $data['porcentajeavance'] = $avance;
        $rpta = $this->db->insert('avances', $data); 

        //modificacion en actividad
        if($rpta=="1")
        {
            $this->db->set('modificadopor', $modificadopor);
            $this->db->set('avance', $avance);
            $this->db->set('fechamodificacion', $fechaActual);
            $this->db->where('id', $id_actividad);
            $rpta = $this->db->update('actividad'); 
        }
        
        return $rpta;

    }

    //Seleccionar datos para los graficos de todo un proyecto sin tabla de cada avance
    public function selectActividadesGraficaIdP($idP)
    {
        $this->db->select('actividad.tarea_id, 
        DATE_FORMAT(actividad.fechainicioplanificada, "%m/%d/%Y %H:%i:%s") AS fechainicioplanificada, 
        DATE_FORMAT(actividad.fechafinplanificada, "%m/%d/%Y %H:%i:%s") AS fechafinplanificada, 
        DATE_FORMAT(actividad.fechainicioreal, "%m/%d/%Y %H:%i:%s") AS fechainicioreal, 
        avance, tarea.descripcion as nomTarea');
        $this->db->from('actividad, tarea');
        $this->db->where('tarea.proyecto_id =', $idP);
        $this->db->where('actividad.tarea_id=tarea.id');
        $this->db->order_by('actividad.tarea_id', 'ASC');
        $this->db->order_by('actividad.id', 'ASC');
        $rpta = $this->db->get();
        
        return $rpta->result();
    }

    public function selectAvancesIdP($idP)
    {
        $this->db->select('actividad.id as idActividad, porcentajeavance, avances.fechacreacion, TIMESTAMPDIFF(SECOND, fechainicioplanificada, fechafinplanificada) as duracionActividad');
        $this->db->from('avances, actividad, tarea');
        $this->db->where('tarea.proyecto_id =', $idP);
        $this->db->where('actividad.tarea_id=tarea.id');
        $this->db->where('avances.actividad_id=actividad.id');
        $this->db->order_by('avances.actividad_id', 'ASC');
        $this->db->order_by('avances.id', 'ASC');
        $rpta = $this->db->get();
        
        return $rpta->result();
    }



    public function updateInicioRealActividad($id_actividad)
    {
        date_default_timezone_set('America/Santiago');
        $fechaActual = date("Y-m-d H:i:s");
        $this->db->set('fechainicioreal', $fechaActual);
        $this->db->set('status', 'Progreso');
        $this->db->where('id', $id_actividad);
        $rpta = $this->db->update('actividad'); 
        return $rpta;
    }

    public function updateFinRealActividad($id_actividad)
    {
        date_default_timezone_set('America/Santiago');
        $fechaActual = date("Y-m-d H:i:s");
        $this->db->set('fechafinreal', $fechaActual);
        $this->db->set('status', 'Finalizado');
        $this->db->where('id', $id_actividad);
        $rpta = $this->db->update('actividad'); 
        return $rpta;
    }

    
    public function selectAvanceIdActividad($idA)
    {
        
        $this->db->select('avance');
        $this->db->from('actividad');
        $this->db->where('actividad.id=', $idA);
        $rpta = $this->db->get();
        
        return $rpta->result();
    }

    

    public function selectUsuarios()
    {
        
        $this->db->select('usuario.id, usuario.nombre, apellido, usuario.imagen, empresa_id, empresa.nombre AS nomEmpresa');
        $this->db->from('usuario, empresa');
        $this->db->where('usuario.empresa_id=empresa.id');
        $rpta = $this->db->get();
        
        return $rpta->result();
    }




    public function selectIdAreaConIdEquipo($idEquipo)
    {
        
        $this->db->select('area_id');
        $this->db->from('equipo');
        $this->db->where('id=', $idEquipo);
        $rpta = $this->db->get();
        
        return $rpta->result();
    }


    


    public function insertAlerta($id_actividad, $descripcion, $creadopor, $categoria)
    {
        date_default_timezone_set('America/Santiago');
        $fechainicio = date("Y-m-d H:i:s");
        
        $data['actividad_id'] = $id_actividad;
        $data['descripcion'] = $descripcion;
        $data['creadopor'] = $creadopor;
        $data['categoria'] = $categoria;
        $data['fechacreacion'] = $fechainicio;
        $data['fechadeinicio'] = $fechainicio;
        $this->db->insert('alerta', $data); 
        $idAlerta = $this->db->insert_id();
        
        return $idAlerta;

    }
    


    // select tabla de alerta
    public function selectAlerta($idA)
    {
        $this->db->select('descripcion, categoria, alertacerradapor, leido');
        $this->db->from('alerta');
        $this->db->where('id=', $idA);
        $rpta = $this->db->get();
        return $rpta->result();
    }

    public function selectAdjuntoAlerta($idA)
    {
        $this->db->select('nombre, tamano, extension');
        $this->db->from('adjuntoalerta');
        $this->db->where('alerta_id=', $idA);
        $rpta = $this->db->get();
        return $rpta->result();
    }


    public function selectAlertaGrafica($idP)
    {
        $this->db->select('categoria, COUNT(*) AS cantidad');
        $this->db->from('alerta, actividad, tarea');
        $this->db->where('alerta.actividad_id=actividad.id');
        $this->db->where('actividad.tarea_id=tarea.id');
        $this->db->where('tarea.proyecto_id=', $idP);
        $this->db->group_by("categoria");
        $this->db->order_by('categoria', 'ASC');
        $rpta = $this->db->get();
        return $rpta->result();
    }

    //------------------------------- creando los enpoints pasados -----------------------
    
    
    public function selectUsuario($correo)
    {
        $this->db->select('*');
        $this->db->from('usuario');
        $this->db->where('correo=', $correo);
        $rpta = $this->db->get();
        return $rpta->result();
    }

    public function selectProyecto($idP)
    {
        $this->db->select('*');
        $this->db->from('proyecto');
        $this->db->where('id=', $idP);
        $rpta = $this->db->get();
        return $rpta->result();
    }   
    
    public function selectAreas()
    {
        $this->db->select('*');
        $this->db->from('area');
        $rpta = $this->db->get();
        return $rpta->result();
    } 

    public function selectEquipos()
    {
        $this->db->select('*');
        $this->db->from('equipo');
        $rpta = $this->db->get();
        return $rpta->result();
    } 
    
    public function selectPrioridades()
    {
        $this->db->select('*');
        $this->db->from('prioridad');
        $rpta = $this->db->get();
        return $rpta->result();
    } 
    
    public function selectEspecialidades()
    {
        $this->db->select('*');
        $this->db->from('especialidad');
        $rpta = $this->db->get();
        return $rpta->result();
    } 
    
    public function selectRequerimientos()
    {
        $this->db->select('*');
        $this->db->from('requerimiento');
        $rpta = $this->db->get();
        return $rpta->result();
    }
    
    public function selectGruposTrabajo()
    {
        $this->db->select('*');
        $this->db->from('grupo_trabajo');
        $rpta = $this->db->get();
        return $rpta->result();
    }

    public function updateTarea($tareaId, $modificadopor, $proyecto_id, $descripcion, 
                                $equipo_id, $prioridad_id, $tipotarea, $disciplina)
    {
        $this->db->set('proyecto_id', $proyecto_id);
        $this->db->set('equipo_id', $equipo_id);
        $this->db->set('prioridad_id', $prioridad_id);
        $this->db->set('modificadopor', $modificadopor);
        $this->db->set('descripcion', $descripcion);
        $this->db->set('tipotarea', $tipotarea);
        $this->db->set('disciplina', $disciplina);
        $this->db->where('id', $tareaId);
        $rpta = $this->db->update('tarea'); 
        return $rpta;
    }
    
    public function updateActividad($id_actividad, $id_tarea, $mofificadopor, $especialidad_id,
                                    $requerimiento_id, $descripcion, $ordentrabajo, $fechainicioplanificada, 
                                    $fechafinplanificada, $fechainicioreal, $fechafinreal, $estado, 
                                    $responsables, $seguidores, $grupo)
    {
        $this->db->set('tarea_id', $id_tarea);
        $this->db->set('modificadopor', $mofificadopor);
        $this->db->set('especialidad_id', $especialidad_id);
        $this->db->set('requerimiento_id', $requerimiento_id);
        $this->db->set('descripcion', $descripcion);
        $this->db->set('ordentrabajo', $ordentrabajo);
        $this->db->set('fechainicioplanificada', $fechainicioplanificada);
        $this->db->set('fechafinplanificada', $fechafinplanificada);
        $this->db->set('fechainicioreal', $fechainicioreal);
        $this->db->set('fechafinreal', $fechafinreal);
        $this->db->set('status', $estado);
        $this->db->set('responsables', $responsables);
        $this->db->set('seguidores', $seguidores);
        $this->db->set('grupo', $grupo);
        $this->db->where('id', $id_actividad);
        $rpta = $this->db->update('actividad'); 
        return $rpta;
    }

    public function insertTarea($creadopor, $proyecto_id, $descripcion, $equipo_id, 
                                $prioridad_id, $tipotarea, $disciplina)
    {        
        $data['creadopor'] = $creadopor;
        $data['proyecto_id'] = $proyecto_id;
        $data['descripcion'] = $descripcion;
        $data['equipo_id'] = $equipo_id;
        $data['prioridad_id'] = $prioridad_id;
        $data['tipotarea'] = $tipotarea;
        $data['disciplina'] = $disciplina;
        $this->db->insert('tarea', $data); 
        $idTarea = $this->db->insert_id();
        
        return $idTarea;
    }

    public function deleteTarea($id_tarea)
    {
        $this->db->where('id', $id_tarea);
        $rpta = $this->db->delete('tarea');
        
        return $rpta;
    }
    */
    

}
