<?php

require_once("modelo.php");
require_once("eventos_modalidades.php");
require_once("patrocinantes_eventos.php");
require_once("draws.php");
	

class eventos extends modelo{

           public  $even_id;
		   public  $depo_id;
		   public  $even_nombre;
		   public  $even_fecha;
		   public  $even_sede;
		   public  $even_ciudad;
		   public  $even_afiche;
		   public  $even_publicarhome;
		   public  $even_archivo;
		   public  $even_publicar;
		   public  $even_modalidades;
		   public  $even_patrocinantes;
		   public  $even_draws;
		   public  $even_cerrado;
    
	 function __construct($id,$depo,$nombre,$fecha,$sede,$ciudad,$afiche,$publicarhome,$archivo,$publicar){
	 
			parent::__construct();
	 
			$this->even_id = $id;
			$this->depo_id = $depo;
			$this->even_nombre = $nombre;
			$this->even_fecha = $fecha;
			$this->even_sede = $sede;
			$this->even_ciudad = $ciudad;
			if(isset($afiche)){
				$this->even_afiche = "'".$afiche."'";
			}else{
				$this->even_afiche = 'NULL';
			}
			$this->even_publicarhome = $publicarhome;
			$this->even_archivo = $archivo;
			$this->even_publicar = $publicar;
			$this->even_modalidades = array();
			$this->even_patrocinantes = array();
			$this->even_draws = array();
			$this->even_cerrado = 'N';
	 }//fin constructor
	 
	 
	 function guardar(){
				
			if($this->even_id==''){
				
				$sql = "INSERT INTO eventos (depo_id,even_nombre,even_fecha,even_sede,even_ciudad,even_afiche,even_publicarhome,even_publicar,even_cerrado)"
					." VALUES($this->depo_id,'$this->even_nombre',str_to_date('$this->even_fecha','%d/%m/%Y'),'$this->even_sede','$this->even_ciudad',$this->even_afiche,'$this->even_publicarhome','$this->even_publicar','$this->even_cerrado')";
                
			}else{
				$sql = "UPDATE eventos "
					." SET depo_id=$this->depo_id, even_nombre='$this->even_nombre',even_fecha=str_to_date('$this->even_fecha','%d/%m/%Y'),"
					." even_sede='$this->even_sede',even_ciudad='$this->even_ciudad',even_afiche=$this->even_afiche,"
					." even_publicarhome='$this->even_publicarhome',even_publicar='$this->even_publicar',even_cerrado='$this->even_cerrado'"
					." WHERE even_id = $this->even_id";
			}
			
			
			include($this->archivo_conexion);
			
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($this->even_id != ''){
						$aux = new eventos_modalidades('','','','','','');
						$aux->eliminar_all_even_modalidades($this->even_id);
						
						$aux = new patrocinantes_eventos('','','','');
						$aux->eliminar_all_patrocinadores($this->even_id);
					}else{
						$this->even_id = mysql_insert_id();
					}
			   
					
			   
					foreach($this->even_modalidades as $key => $obj){
						$obj->even_id = $this->even_id;
						$obj->guardar();
					}
					
					foreach($this->even_patrocinantes as $key => $obj){
						$obj->even_id = $this->even_id;
						$obj->guardar();
					}
			   
				   echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				   return true;
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin guardar_data
	
	
	 
	 function get_evento($id){
			
			
			$sql = "SELECT * FROM eventos WHERE even_id = $id";
			
			include($this->archivo_conexion);
			
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
			
						$this->even_id = $row['even_id'];
						$this->depo_id = $row['depo_id'];
						$this->even_nombre = $row['even_nombre'];
						$this->even_fecha = date("m/d/Y",strtotime($row['even_fecha']));
						$this->even_sede = $row['even_sede'];
						$this->even_ciudad = $row['even_ciudad'];
						$this->even_afiche = $row['even_afiche'];
						$this->even_publicarhome = $row['even_publicarhome'];
						$this->even_archivo = $row['even_archivo'];
						$this->even_publicar = $row['even_publicar'];
						$this->even_cerrado = $row['even_cerrado'];
						
						$aux = new eventos_modalidades('','','','','','');
						
						$res_moda =  $aux->get_all_even_modalidades($this->even_id);
									
						while($row_moda = mysql_fetch_assoc($res_moda)){
							$this->add_evento_modalidad($row_moda['evmo_id'],$row_moda['even_id'],
											$row_moda['moda_id'],$row_moda['evmo_premiacion'],
											$row_moda['evmo_subcampeon'],date("m/d/Y",strtotime($row_moda['evmo_fecha'])),
											$row_moda['moda_nombre'],$row_moda['moda_sexo'],$row_moda['moda_tipo'],$row_moda['evmo_cerrado'],
											$row_moda['evmo_publicar_draw'],$row_moda['evmo_costo_inscripcion']);
						}

						$aux = new patrocinantes_eventos('','','','');
						
						$res_patr =  $aux->get_all_even_patrocinantes($this->even_id);
									
						while($row_patr = mysql_fetch_assoc($res_patr)){
							$this->add_evento_patrocinante($row_patr['prev_id'],$row_patr['even_id'],
													$row_patr['patr_id'],$row_patr['prev_orden']);
						}
						
						
						$aux = new draws('','','','','','','','','','');
						
						$res_draw =  $aux->get_evento_draws($this->even_id);
									
						while($row_draw = mysql_fetch_assoc($res_draw)){
							$this->add_evento_draw($row_draw['evmo_id'],$row_draw['moda_nombre']);
						}
						
									
						return $this;
					
					}else{
					
						echo "<br>No se encontro el registro<br>";
						return false;
					
					}
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento
	
	function get_all_eventos_abiertos($depo_id){
				
			$sql = "SELECT * FROM eventos WHERE depo_id = ".$depo_id." AND even_publicar = 'S' AND even_cerrado = 'N'";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento
	
	function get_all_eventos($depo_id){
				
			$sql = "SELECT * FROM eventos WHERE depo_id = ".$depo_id." AND even_publicar = 'S'";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento



	function get_all_eventos_anual($depo_id, $año){
				
			$sql = "(SELECT e.even_id, e.even_nombre, em.evmo_id, m.moda_nombre, e.even_fecha, 'TP' as tipo_col
					FROM eventos e
					  JOIN eventos_modalidades em ON em.even_id = e.even_id
					  JOIN modalidades m ON m.moda_id = em.moda_id
					WHERE e.depo_id = $depo_id
					 AND e.even_publicar = 'S'
					 AND extract(year from e.even_fecha) = $año
					)
					UNION ALL
					(
					SELECT 1, 'RANKING PUNTOS', r.rank_id, r.rank_nombre, null, 'RP'
					FROM rankings r
					WHERE r.depo_id = $depo_id
					 AND r.rank_publicar = 'S'
					 AND r.rank_ano = $año
					)
					UNION ALL
					(
					SELECT 2, 'RANKING TORNEOS JUGADOS', r.rank_id, r.rank_nombre, null, 'RJ'
					FROM rankings r
					WHERE r.depo_id = $depo_id
					 AND r.rank_publicar = 'S'
					 AND r.rank_ano = $año
					)

					ORDER BY tipo_col DESC, even_fecha, moda_nombre";	
			
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento

	

	
	function add_evento_modalidad($evmo_id,$even_id,$moda_id,$evmo_premiacion,$evmo_subcampeon,$even_fecha,$moda_nombre,$moda_sexo,$moda_tipo,$evmo_cerrado,$evmo_publicar_draw,$evmo_costo_inscripcion){
	
		$moda = new eventos_modalidades($evmo_id,$even_id,$moda_id,$evmo_premiacion,$evmo_subcampeon,$even_fecha);
		$moda->moda_nombre = $moda_nombre;
		$moda->moda_sexo = $moda_sexo;
		$moda->moda_tipo = $moda_tipo;
		$moda->evmo_cerrado = $evmo_cerrado;
		$moda->evmo_publicar_draw = $evmo_publicar_draw;
		$moda->evmo_costo_inscripcion = $evmo_costo_inscripcion;
		array_push($this->even_modalidades, $moda);
	
	}
	
	
	function add_evento_patrocinante($prev_id,$even_id,$patr_id,$prev_orden){
	
		array_push($this->even_patrocinantes, new patrocinantes_eventos($prev_id,$even_id,$patr_id,$prev_orden));
	
	}
	
	
	function add_evento_draw($evmo_id,$moda_nombre){
	
		array_push($this->even_draws, array('evmo_id' => $evmo_id, 'moda_nombre' => $moda_nombre));
	
	}
	
	
	function eliminar($even_id){
	
			$sql = "DELETE FROM eventos WHERE even_id = ".$even_id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					$aux = new eventos_modalidades('','','','','','');
					$aux->eliminar_all_even_modalidades($even_id);
					
					$aux = new patrocinantes_eventos('','','','');
					$aux->eliminar_all_patrocinadores($even_id);
			
					echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					return true;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
	}

}//fin clase eventos
?>