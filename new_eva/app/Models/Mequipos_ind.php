<?php 


class Mequipos_ind extends CI_Model

{

	public function getMequipo(){


          return  $this->db->query("SELECT id_equipos rownum,imagen,nombre,marca,serial,equipos_industriales.servicio_id,equipos_industriales.periodicidad_id,servicios_industriales.name,frecuenciam.name FROM ((equipos_industriales INNER JOIN servicios_industriales on equipos_industriales.servicio_id=servicios_industriales.id)INNER JOIN frecuenciam on equipos_industriales.periodicidad_id=frecuenciam.id)")->result();      
	}

   	public function getEquipo($start,$length,$search){//server side processing
     //echo "start Mlogin:".$start;
		$srch = "";
		if ($search) {
			$srch = " WHERE  equipos_industriales.nombre         LIKE '%"  .$search."%' OR 
							 equipos_industriales.marca          LIKE '%"  .$search."%' OR
							 equipos_industriales.serial         LIKE '%"  .$search."%' OR
							 servicios_industriales.name         LIKE '%"  .$search."%' OR
							 equipos_industriales.codigo_inventario         LIKE '%"  .$search."%' OR
							 frecuenciam.name                    LIKE '%"  .$search."%' ";
		}

		$qnr = "SELECT count(1) cant FROM (equipos_industriales INNER JOIN servicios_industriales on equipos_industriales.servicio_id=servicios_industriales.id)INNER JOIN frecuenciam on equipos_industriales.periodicidad_id=frecuenciam.id ".$srch;

		$qnr = $this->db->query($qnr);
		$qnr = $qnr->row();
		$qnr = $qnr->cant;


		$q = "SELECT id_equipos rownum,imagen,nombre,marca,serial,modelo,codigo_inventario,equipos_industriales.servicio_id,equipos_industriales.periodicidad_id,equipos_industriales.piso_id,servicios_industriales.name,frecuenciam.name as namem,pisos.name as piso,archivo,tension,corriente,potencia,temperatura,estado,fecha_mantenimiento FROM (((equipos_industriales INNER JOIN servicios_industriales on equipos_industriales.servicio_id=servicios_industriales.id)INNER JOIN frecuenciam on equipos_industriales.periodicidad_id=frecuenciam.id)INNER JOIN pisos on equipos_industriales.piso_id=pisos.id)".$srch."LIMIT ".$start.",".$length."";

		$r = $this->db->query($q);

		$retornar = array(
			'numDataTotal' => $qnr,
			'datos' => $r
			);

		return $retornar;
	}



	public function add($data){


		$this->db->insert("equipos_industriales",$data);

		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}

	}

    public function actual($data) {
    	
         $fetched_records = $this->db->query("SELECT id_equipos,imagen,nombre,marca,serial,modelo,codigo_inventario,equipos_industriales.servicio_id,equipos_industriales.periodicidad_id,equipos_industriales.piso_id as id_piso,servicios_industriales.name,frecuenciam.name as namem,pisos.name as piso,archivo,tension,corriente,potencia,temperatura,estado,fecha_mantenimiento FROM (((equipos_industriales INNER JOIN servicios_industriales on equipos_industriales.servicio_id=servicios_industriales.id)INNER JOIN frecuenciam on equipos_industriales.periodicidad_id=frecuenciam.id)INNER JOIN pisos on equipos_industriales.piso_id=pisos.id) where id_equipos = ".$data);

		     $users = $fetched_records->result_array();

		     // Initialize Array with fetched data
		     $datos = array();
		     foreach($users as $user){
		      $datos[] = array("id_equipos"=>$user['id_equipos'],"imagen"=>$user['imagen'],"nombre"=>$user['nombre'],"marca"=>$user['marca'],"serial"=>$user['serial'],"modelo"=>$user['modelo'],"codigo_inventario"=>$user['codigo_inventario'],"servicio_id"=>$user['servicio_id'],"periodicidad_id"=>$user['periodicidad_id'],"archivo"=>$user['archivo'],"ubicacion"=>$user['name'],"mantenimiento"=>$user['namem'],"tension"=>$user['tension'],"corriente"=>$user['corriente'],"potencia"=>$user['potencia'],"piso_id"=>$user['piso'],"temperatura"=>$user['temperatura'],"fecha_mantenimiento"=>$user['fecha_mantenimiento'],"id_piso"=>$user["id_piso"]);
		     }
		     return $datos;
       
    }

    public function getOne($data) {

         $fetched_records = $this->db->query("SELECT id_equipos,imagen,nombre,marca,serial,modelo,codigo_inventario,equipos_industriales.servicio_id,equipos_industriales.periodicidad_id,equipos_industriales.piso_id,servicios_industriales.name,frecuenciam.name as namem,pisos.name as piso,archivo,tension,corriente,potencia,temperatura,estado,fecha_mantenimiento FROM (((equipos_industriales INNER JOIN servicios_industriales on equipos_industriales.servicio_id=servicios_industriales.id)INNER JOIN frecuenciam on equipos_industriales.periodicidad_id=frecuenciam.id)INNER JOIN pisos on equipos_industriales.piso_id=pisos.id) where id_equipos = ".$data["id"]);

		     return $fetched_records->row();
       
    }


    public function update($data,$valor) {
              $this->db->where('id_equipos', $valor);
		      $this->db->update('equipos_industriales',$data);
              if($this->db->affected_rows() == 0){
			       return true;
		         }else{
			       return false;
		         }
    }



    public function borrar($data){
    	
    		
		    $estado = $this->db->query("SELECT estado FROM equipos_industriales where id_equipos =".$data);
            $state = $estado->result_array();
            //print_r($state[0]['estado']);
		    if($state[0]['estado']=="1"){		    	
		      
              $this->db->query("UPDATE `equipos_industriales` SET estado ='2' WHERE id_equipos =".$data);
           
			      return true;
				
		    }else{
              
              $this->db->query("UPDATE `equipos_industriales` SET `estado`='1' WHERE id_equipos =".$data);

			return true;
	
		    }
    	
        
              

    }

    public function getLikeSerie($param){
	$this->db->where("serial like '%".$param["serial"]."%' ");
	$this->db->limit(12);
	$this->db->order_by("nombre","asc");
	return $this->db->get("equipos_industriales")->result();
    }
    public function getLikeCodigo($param){
	$this->db->where("codigo_inventario like '%".$param["code"]."%' ");
	$this->db->limit(12);
	$this->db->order_by("nombre","asc");
	return $this->db->get("equipos_industriales")->result();
    }


	public function getServicios($s){

		 	 $this->db->select('*');
		     $this->db->where("name like '%".$s."%' ");
		     // $this->db->where("id".$s );
		     $fetched_records = $this->db->get('servicios_industriales');
		     $users = $fetched_records->result_array();
		     // Initialize Array with fetched data
		     $data = array();
		     foreach($users as $user){
		        $data[] = array("id"=>$user['id'], "text"=>$user['name']);
		     }
		     return $data;



		}
	public function getMantenimiento($s){

		 	 $this->db->select('*');
		     $this->db->where("name like '%".$s."%' ");
		     $fetched_records = $this->db->get('frecuenciam');
		     $users = $fetched_records->result_array();
		     // Initialize Array with fetched data
		     $data = array();
		     foreach($users as $user){
		        $data[] = array("id"=>$user['id'], "text"=>$user['name']);
		     }
		     return $data;



		}
      
       	public function getPiso($s){

		 	 $this->db->select('*');
		     $this->db->where("name like '%".$s."%' ");
		     $fetched_records = $this->db->get('pisos');
		     $users = $fetched_records->result_array();
		     // Initialize Array with fetched data
		     $data = array();
		     foreach($users as $user){
		        $data[] = array("id"=>$user['id'], "text"=>$user['name']);
		     }
		     return $data;



		}
	
}


?>