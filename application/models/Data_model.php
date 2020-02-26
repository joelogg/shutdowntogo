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

    public function actualizarFechasProyecto($dataOT)
    {
        //Select proyecto
        if (isset($dataOT['proyecto_id']))
        {
            $idProy = $dataOT['proyecto_id'];

            $this->db->select('fechainicio, fechafin');
            $this->db->from('proyecto');
            $this->db->where('id=', $idProy);
            $rpta = $this->db->get();

            if($rpta->num_rows() > 0)
            {
                $row = $rpta->row();
                $fechaIniPro =  $row->fechainicio;
                $fechaFinPro =  $row->fechafin;

                $dataUpdateProyecto['fechainicio'] = $fechaIniPro;
                $dataUpdateProyecto['fechafin'] = $fechaFinPro;

                //actualizando fecha inicio
                if(isset($dataOT['fechainicio']))
                {
                    if($fechaIniPro=="" || $fechaIniPro == NULL)
                    {
                        $dataUpdateProyecto['fechainicio'] = $dataOT['fechainicio'];
                    }
                    else if($fechaIniPro>$dataOT['fechainicio'])
                    {
                        $dataUpdateProyecto['fechainicio'] = $dataOT['fechainicio'];
                    }
                }

                //actualizando fecha fin
                if(isset($dataOT['fechafin']))
                {
                    if($fechaFinPro=="" || $fechaFinPro == NULL)
                    {
                        $dataUpdateProyecto['fechafin'] = $dataOT['fechafin'];
                    }
                    else if($fechaFinPro<$dataOT['fechafin'])
                    {
                        $dataUpdateProyecto['fechafin'] = $dataOT['fechafin'];
                    }
                }

                $this->db->where('id', $idProy);
                $this->db->update('proyecto', $dataUpdateProyecto); 
            }
        }
    }

    public function insertTipoOTExcel($dataOT, $token)
    {
        $this->db->select('id');
        $this->db->from('ordenestrabajo');
        $this->db->where('ordentrabajo=', $dataOT['ordentrabajo']);
        $this->db->where('proyecto_id=', $dataOT['proyecto_id']);
        $rpta = $this->db->get();

        if($rpta->num_rows() > 0)
        {
            $row = $rpta->row();
            $id =  $row->id;
            return $id;
        }
        else
        {
            return $this->insertOrdenTrabajo($dataOT, $token);
        }
    }
    
    public function insertOrdenTrabajo($dataOT, $token)
    {
        $this->load->library('encryption');
        $idCreador = $this->encryption->decrypt($token);
        
        //Insert OT
        $dataOT['creadopor'] = $idCreador;
        $this->db->insert('ordenestrabajo', $dataOT); 
        $idOT = $this->db->insert_id();

        //-----Actualizar fechas ----
        $this->actualizarFechasProyecto($dataOT);

        //actualziar responsables
        if(isset($dataOT['responsable']) && $dataOT['responsable']!="")
        {
            $idsResponsables = explode(",", $dataOT["responsable"]);
            
            $data = array();
            foreach ($idsResponsables as $idRes) 
            {
                array_push($data, array( 'usuario_id' => $idRes, 'ordenestrabajo_id' => $idOT )  );
            }

            if( count($data)>0 )
            {
                $this->db->insert_batch('responsables', $data);
            }
        }

        
        
        
        return $idOT;
    }

    public function selectOrdenesTrabajoFiltros($usuario, $webMovil, $idOT, $filtros)
    {
        $responsablesId = -1;
        $prioridadId = -1;
        $estatusId = -1;
        $areaId = -1;
        $fechaCod = -1;

        if(isset($filtros['responsablesId']))
        {
            $responsablesId = $filtros["responsablesId"];
            $prioridadId = $filtros["prioridadId"];
            $estatusId = $filtros["estatusId"];
            $areaId = $filtros["areaId"];
            $fechaCod = $filtros["fechaCod"];
        }

        $rpta = [];

        //$perfil = $usuario->perfil;
        
        //if($perfil=="Propietario")
        {
            $this->db->select('ordenestrabajo.id as id, ordentrabajo, ordenestrabajo.descripcion, atrasado, 
                            ordenestrabajo.visible AS visible, responsable, ordenestrabajo.fechainicio, ordenestrabajo.fechafin,
                            estadoOT_id, estadoot.descripcion as estado, estadoot.color as estadoOT_color,
                            prioridad.id as prioridad_id, prioridad.descripcion as descripcionPrioridad, prioridad.color as colorPrioridad,
                            equipo.id as equipo_id, equipo.descripcion as descripcionEquipo, equipo.codigo as codigoEquipo, 
                            area.id as area_id, area.descripcion as descripcionArea, area.codigo as codigoArea,
                            proyecto.id as proyecto_id, proyecto.revision as revisionProyecto,
                            tipo.id as tipo_id, tipo.descripcion as descripcionTipo, tipo.tag as tagTipo');
            
            //filtro responsables
            if($responsablesId == -1)
            {
                $this->db->from('ordenestrabajo, estadoot');
                $this->db->where('ordenestrabajo.visible=1');
                $this->db->where('ordenestrabajo.estadoOT_id=estadoot.id');
            }
            else 
            {
                $this->db->from('ordenestrabajo, responsables, usuario, estadoot');
                $this->db->where('ordenestrabajo.visible=1');
                $this->db->where('ordenestrabajo.id=responsables.ordenestrabajo_id');
                $this->db->where('responsables.usuario_id=usuario.id');
                $this->db->where('ordenestrabajo.estadoOT_id=estadoot.id');
                $this->db->where('usuario.id', $responsablesId);
            }

            
            if($idOT != -1)
            {
                $this->db->where('ordenestrabajo.id=', $idOT);
            }

            if($webMovil=="movil")
            {   
                $where = "estadoot.descripcion!='Finalizada' AND 
                estadoot.descripcion!='Reprogramada' AND
                ( ordenestrabajo.atrasado='1' OR ordenestrabajo.fechafin<=CURDATE() )";

                $this->db->where($where);
                
            }



            //filtro prioridad
            if($prioridadId != -1)
            {
                $this->db->where('prioridad.id=', $prioridadId);
            }

            //filtro prioridad
            if($estatusId != -1)
            {
                if($estatusId > 0)
                {
                    $this->db->where('estadoot.id=', $estatusId);
                    $this->db->where('ordenestrabajo.atrasado=0');
                }
                elseif($estatusId == -2)//Atrasada
                {
                    $this->db->where('ordenestrabajo.atrasado=1');
                }
            }

            //filtro area
            if($areaId != -1)
            {
                $this->db->where('area.id=', $areaId);
            }

            //filtro fecha
            if($fechaCod != -1)
            {
                if($fechaCod == -2)//hoy
                {
                    $this->db->where('DATE_FORMAT(ordenestrabajo.fechainicio, "%Y-%m-%d")=CURDATE()');
                }
                elseif($fechaCod == -3)//mañana
                {
                    $this->db->where('DATE_FORMAT(ordenestrabajo.fechainicio, "%Y-%m-%d")=DATE_ADD(CURDATE(), INTERVAL 1 DAY)');
                }
                else//revision de proyecto
                {
                    $this->db->where('proyecto.revision=', $fechaCod);
                }
            }
            


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

    public function selectOrdenesTrabajo($usuario, $webMovil, $idOT)
    {
        $rpta = [];

        //$perfil = $usuario->perfil;
        
        //if($perfil=="Propietario")
        {
            $this->db->select('ordenestrabajo.id as id, ordentrabajo, ordenestrabajo.descripcion, atrasado, 
                            ordenestrabajo.visible AS visible, responsable, ordenestrabajo.fechainicio, ordenestrabajo.fechafin,
                            estadoOT_id, estadoot.descripcion as estado, estadoot.color as estadoOT_color,
                            prioridad.id as prioridad_id, prioridad.descripcion as descripcionPrioridad, prioridad.color as colorPrioridad,
                            equipo.id as equipo_id, equipo.descripcion as descripcionEquipo, equipo.codigo as codigoEquipo, 
                            area.id as area_id, area.descripcion as descripcionArea, area.codigo as codigoArea,
                            proyecto.id as proyecto_id, proyecto.revision as revisionProyecto,
                            tipo.id as tipo_id, tipo.descripcion as descripcionTipo, tipo.tag as tagTipo');
            $this->db->from('ordenestrabajo, estadoot');

            $this->db->where('ordenestrabajo.visible=1');
            $this->db->where('ordenestrabajo.estadoOT_id=estadoot.id');
            if($idOT != -1)
            {
                $this->db->where('ordenestrabajo.id=', $idOT);
            }

            if($webMovil=="movil")
            {   
                $where = "estadoot.descripcion!='Finalizada' AND 
                estadoot.descripcion!='Reprogramada' AND
                ( ordenestrabajo.atrasado='1' OR ordenestrabajo.fechafin<=CURDATE() )";

                $this->db->where($where);
                
            }

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
        $this->db->update('ordenestrabajo', $dataOT); 

        $rpta = false;
        if($this->db->affected_rows() > 0)
        {
            $rpta = true;
        }

        //actualziar fechas
        $this->actualizarFechasProyecto($dataOT);

        //actualziar responsables
        if(isset($dataOT['responsable']))
        {
            $this->db->delete('responsables', array('ordenestrabajo_id' => $dataOT["id"]));

            if($dataOT['responsable']!="")
            {
                $idsResponsables = explode(",", $dataOT["responsable"]);
                
                $data = array();
                foreach ($idsResponsables as $idRes) 
                {
                    array_push($data, array( 'usuario_id' => $idRes, 'ordenestrabajo_id' => $dataOT["id"] )  );
                }

                if( count($data)>0 )
                {
                    $this->db->insert_batch('responsables', $data);
                }
            }
        }

        return $rpta;
    }

    public function updateEstadoOTsiguiente($data, $token)
    {
        $this->load->library('encryption');
        $idModificador = $this->encryption->decrypt($token);

        

        $this->db->set('modificadopor', $idModificador);

        if($data["accion"]=="R")
        {
            $this->db->set('estadoOT_id', 4);
        }
        else
        {
            $this->db->select('estadoOT_id');
            $this->db->from('ordenestrabajo');
            $this->db->where('id =', $data["idOT"]);
            $rpta = $this->db->get();
            $row = $rpta->row();
            $estadoOT_id =  $row->estadoOT_id;

            if( (int)$estadoOT_id + 1 < 4)
            {
                $this->db->set('estadoOT_id', (int)$estadoOT_id + 1);
            }

        }

        $this->db->where('id', $data["idOT"]);
        $this->db->update('ordenestrabajo'); 

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

     //------------------ estatus OT -----------------
     public function selectEstadosOT()
     {
         $this->db->select('*');
         $this->db->from('estadoot');
         $rpta = $this->db->get();
 
         return $rpta->result();
     }

    //------------------ Operaciones -----------------
    public function actualizarFechasOT($dataOp)
    {
        
        //Select proyecto
        if (isset($dataOp['ordenestrabajo_id']))
        {
            $idOp = $dataOp['ordenestrabajo_id'];

            $this->db->select('proyecto_id, fechainicio, fechafin');
            $this->db->from('ordenestrabajo');
            $this->db->where('id=', $idOp);
            $rpta = $this->db->get();

            if($rpta->num_rows() > 0)
            {
                $row = $rpta->row();
                $fechaIniOT =  $row->fechainicio;
                $fechaFinOT =  $row->fechafin;

                $dataUpdateOT['fechainicio'] = $fechaIniOT;
                $dataUpdateOT['fechafin'] = $fechaFinOT;

                //actualizando fecha inicio
                if(isset($dataOp['fechainicio']))
                {
                    if($fechaIniOT=="" || $fechaIniOT == NULL)
                    {
                        $dataUpdateOT['fechainicio'] = $dataOp['fechainicio'];
                    }
                    else if($fechaIniOT>$dataOp['fechainicio'])
                    {
                        $dataUpdateOT['fechainicio'] = $dataOp['fechainicio'];
                    }
                }

                //actualizando fecha fin
                if(isset($dataOp['fechafin']))
                {
                    if($fechaFinOT=="" || $fechaFinOT == NULL)
                    {
                        $dataUpdateOT['fechafin'] = $dataOp['fechafin'];
                    }
                    else if($fechaFinOT<$dataOp['fechafin'])
                    {
                        $dataUpdateOT['fechafin'] = $dataOp['fechafin'];
                    }
                }

                $this->db->where('id', $idOp);
                $this->db->update('ordenestrabajo', $dataUpdateOT); 


                $dataUpdateOT["proyecto_id"] = $row->proyecto_id;
                $this->actualizarFechasProyecto($dataUpdateOT);
            }
        }
    }

    public function insertOperacion($dataOp, $token)
    {
        $this->load->library('encryption');
        $idCreador = $this->encryption->decrypt($token);
        //Insert operacion
        $dataOp['creadopor'] = $idCreador;
        $dataOp['modificadopor'] = $idCreador;
        $this->db->insert('operaciones', $dataOp); 
        $idOp = $this->db->insert_id();

        $this->actualizarFechasOT($dataOp);

        //actualziar participantes
        if(isset($dataOp['participantes']) && $dataOp['participantes']!="")
        {
            $idsParticipantes = explode(",", $dataOp["participantes"]);
            
            $data = array();
            foreach ($idsParticipantes as $idRes) 
            {
                array_push($data, array( 'usuario_id' => $idRes, 'operaciones_id' => $idOp )  );
            }

            if( count($data)>0 )
            {
                $this->db->insert_batch('usuario_operaciones', $data);
            }
        }

        return $idOp;
    }

    public function selectOperaciones($usuario, $idOT)
    {
        
        $rpta = [];

        $perfil = $usuario->perfil;
        
        if($perfil=="Propietario")
        {
            $this->db->select('operaciones.id, ordenestrabajo_id, numerooperacion, operaciones.descripcion AS descripcion, 
                            operaciones.fechainicio, operaciones.fechafin, work, resources, duracion, participantes, 
                            especialidad_id, especialidad.descripcion AS descripcionEspecialidad, finalizada');
            $this->db->from('operaciones, ordenestrabajo');
            if($idOT != -1)
            {
                $this->db->where('operaciones.ordenestrabajo_id=', $idOT);
            }
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

    public function updateEstadoOperacion($idOp, $estado, $token)
    {
        $this->load->library('encryption');
        $idModificador = $this->encryption->decrypt($token);

        $this->db->set('modificadopor', $idModificador);
        $this->db->set('finalizada', $estado);

        $this->db->where('id', $idOp);
        $this->db->update('operaciones'); 

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function updateOperacion($dataOp, $token)
    {
        $this->load->library('encryption');
        $idCreador = $this->encryption->decrypt($token);
        $dataOp['modificadopor'] = $idCreador;

        $this->db->where('id', $dataOp["id"]);
        $this->db->update('operaciones', $dataOp); 

        $rpta = false;
        if($this->db->affected_rows() > 0)
        {
            $rpta = true;
        }

        //actualziar fechas
        $this->actualizarFechasProyecto($dataOp);

        //actualziar participantes
        if(isset($dataOp['participantes']))
        {
            $this->db->delete('usuario_operaciones', array('operaciones_id' => $dataOp["id"]));

            if($dataOp['participantes']!="")
            {
                $idsParticipantes = explode(",", $dataOp["participantes"]);
                
                $data = array();
                foreach ($idsParticipantes as $idRes) 
                {
                    array_push($data, array( 'usuario_id' => $idRes, 'operaciones_id' => $dataOp["id"] )  );
                }

                if( count($data)>0 )
                {
                    $this->db->insert_batch('usuario_operaciones', $data);
                }
            }
        }

        return $rpta;
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
    
    public function updateImagenComentario($infoImg, $idModificador)
    {
        //Insert adjunto
        $this->db->insert('adjunto', $infoImg); 
        $idAdj = $this->db->insert_id();

        return $idAdj;
    }

    public function selecComentario($idCom)
    {
        $this->db->select('operaciones_id');
        $this->db->from('comentarios');
        $this->db->where('id=', $idCom);
        $this->db->order_by('id', 'DESC');
        $rpta = $this->db->get();
        if($rpta->num_rows() > 0)
        {
            $row = $rpta->row();
            $operaciones_id =  $row->operaciones_id;

            return $operaciones_id;
        }
        else
        {
            return 0;
        }
           
    }

    public function selectComentarios($idOp)
    {
        $this->db->select('comentarios.id as idComentario, creadopor, fechacreacion, mensaje, chat,
                        nombre as adjuntoNombre, extension as adjuntoExtension');
        $this->db->from('comentarios');
        $this->db->where('chat=1');
        $this->db->where('operaciones_id=', $idOp);
        $this->db->join('adjunto', 'adjunto.comentarios_id=comentarios.id', 'left');
        $this->db->order_by('fechacreacion', 'DESC');

        $rpta = $this->db->get();
        return $rpta->result();
           
    }

    //------------------ Proyecto -----------------
    public function insertProyecto($revision, $fechainicio, $fechaFin)
    {
        $dataComentario['revision'] = $revision;
        $dataComentario['fechainicio'] = $fechainicio;
        $dataComentario['fechaFin'] = $fechaFin;
        $this->db->insert('proyecto', $dataComentario); 
        $idProy = $this->db->insert_id();

        return $idProy;
    }

    public function selectProyectos()
    {
        $this->db->select('revision');
        $this->db->from('proyecto');
        $this->db->order_by('fechainicio', 'DESC');
        $rpta = $this->db->get();

        return $rpta->result();
    }

    //------------------ Area -----------------
    public function insertArea($area)
    {
        $this->db->select('id');
        $this->db->from('area');
        $this->db->where('codigo=', $area);
        $rpta = $this->db->get();

        if($rpta->num_rows() > 0)
        {
            $row = $rpta->row();
            $idArea =  $row->id;
            return $idArea;
        }
        else
        {
            $dataInsert['codigo'] = $area;
            $dataInsert['descripcion'] = $area;
            $this->db->insert('area', $dataInsert); 
            $id = $this->db->insert_id();
            return $id;
        }
    }

    public function selectAreas()
     {
         $this->db->select('*');
         $this->db->from('area');
         $rpta = $this->db->get();
 
         return $rpta->result();
     }

    //------------------ equipo -----------------
    public function insertEquipo($codigo, $descripcion, $idArea)
    {
        $this->db->select('id');
        $this->db->from('equipo');
        $this->db->where('codigo=', $codigo);
        $rpta = $this->db->get();

        if($rpta->num_rows() > 0)
        {
            $row = $rpta->row();
            $id =  $row->id;
            return $id;
        }
        else
        {
            $dataInsert['codigo'] = $codigo;
            $dataInsert['descripcion'] = $descripcion;
            $dataInsert['area_id'] = $idArea;
            $this->db->insert('equipo', $dataInsert); 
            $id = $this->db->insert_id();
            return $id;
        }
    }

    //------------------ prioridad -----------------
    public function selectPrioridad($idPrioridad)
    {
        $this->db->select('id');
        $this->db->from('prioridad');
        $this->db->where('id=', $idPrioridad);
        $rpta = $this->db->get();

        if($rpta->num_rows() > 0)
        {
            $row = $rpta->row();
            $id =  $row->id;
            return $id;
        }
        else
        {
            return NULL;
        }
    }

    public function selectPrioridades()
    {
        $this->db->select('*');
        $this->db->from('prioridad');
        //$this->db->order_by('fechainicio', 'DESC');
        $rpta = $this->db->get();

        return $rpta->result();
    }

    //------------------ equipo -----------------
    public function insertTipoOT($tag)
    {
        $this->db->select('id');
        $this->db->from('tipo');
        $this->db->where('tag=', $tag);
        $rpta = $this->db->get();

        if($rpta->num_rows() > 0)
        {
            $row = $rpta->row();
            $id =  $row->id;
            return $id;
        }
        else
        {
            $dataInsert['tag'] = $tag;
            $dataInsert['descripcion'] = $tag;
            $this->db->insert('tipo', $dataInsert); 
            $id = $this->db->insert_id();
            return $id;
        }
    }

    //------------------ especialidad -----------------
    public function insertEspecialidad($especialidad)
    {
        $this->db->select('id');
        $this->db->from('especialidad');
        $this->db->where('descripcion=', $especialidad);
        $rpta = $this->db->get();

        if($rpta->num_rows() > 0)
        {
            $row = $rpta->row();
            $id =  $row->id;
            return $id;
        }
        else
        {
            $dataInsert['descripcion'] = $especialidad;
            $this->db->insert('especialidad', $dataInsert); 
            $id = $this->db->insert_id();
            return $id;
        }
    }

    //------------------ Dasboard -----------------
    public function selectOrdenesTrabajoGrafica($fechaIni, $fechaFin, $selectSemana)
    {
        if($selectSemana>="2")
        {
            $this->db->select('revision');
            $this->db->from('proyecto');
            $this->db->order_by('fechainicio', 'DESC');
            $this->db->order_by('id', 'DESC');

            $rpta = $this->db->get();
            $selectSemana = $rpta->result()[$selectSemana-2]->revision;
        }



        $this->db->select('ordenestrabajo.id as idOT, ordenestrabajo.descripcion as descripcionOT, ordenestrabajo.ordentrabajo,
                            estadoOT_id, estadoot.descripcion as estado, atrasado, 
                            prioridad.id as prioridad_id, 
                            area.codigo as codigoArea');
                            
        $this->db->from('ordenestrabajo, estadoot, proyecto');
        
        $this->db->where('ordenestrabajo.visible=1');
        $this->db->where('ordenestrabajo.estadoOT_id=estadoot.id');
        $this->db->where('ordenestrabajo.proyecto_id=proyecto.id');
        
        if($fechaIni!="" && $fechaFin!="")
        {
            $this->db->where('ordenestrabajo.fechainicio>=', $fechaIni);
            $this->db->where('ordenestrabajo.fechainicio<=', $fechaFin);
        }
        else
        {
            $this->db->where('proyecto.revision=', $selectSemana);
        }

        $this->db->join('prioridad', 'ordenestrabajo.prioridad_id=prioridad.id', 'left');
        $this->db->join('equipo', 'ordenestrabajo.equipo_id=equipo.id', 'left');
        $this->db->join('area', 'equipo.area_id=area.id', 'left');



        $rpta = $this->db->get();
        return $rpta->result();
    }

    


    
    

}
