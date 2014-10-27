<?php

require_once("modelo.php");


class draws extends modelo{

           public  $draw_id;
		   public  $evmo_id;
		   public  $ronda_id;
		   public  $juga_id1;
		   public  $juga_id2;
		   public  $juga_id3;
		   public  $juga_id4;
		   public  $draw_ganador;
		   public  $draw_score;
		   public  $draw_fecha;
		   
    
	 function __construct($id,$evmo_id,$ronda_id,$juga_id1,$juga_id2,$juga_id3,$juga_id4
						,$draw_ganador,$draw_score,$draw_fecha){
	 
			parent::__construct();
	 
			$this->draw_id = $id;
			$this->evmo_id = $evmo_id;
			$this->ronda_id = $ronda_id;
			if($juga_id1 != null){
				$this->juga_id1 = $juga_id1;
			}else{
				$this->juga_id1 = "null";
			}
			if($juga_id2 != null){
				$this->juga_id2 = $juga_id2;
			}else{
				$this->juga_id2 = "null";
			}
			if($juga_id3 != null){
				$this->juga_id3 = $juga_id3;
			}else{
				$this->juga_id3 = "null";
			}
			if($juga_id4 != null){
				$this->juga_id4 = $juga_id4;
			}else{
				$this->juga_id4 = "null";
			}
			
			if($draw_ganador != null){
				$this->draw_ganador = $draw_ganador;
			}else{
				$this->draw_ganador = "null";
			}
			if($draw_score != null){
				$this->draw_score = "'".$draw_score."'";
			}else{
				$this->draw_score = "null";
			}
			if($draw_fecha != null){
				$this->draw_fecha = "'".$draw_fecha."'";
			}else{
				$this->draw_fecha = "null";
			}

			
	 }//fin constructor
	 
	 
	 function guardar(){

			if($this->draw_id==''){
				
				$sql = "INSERT INTO draws (evmo_id,ronda_id,juga_id1,juga_id2,juga_id3,
												   juga_id4,draw_ganador,draw_score,draw_fecha)"
					." VALUES($this->evmo_id,$this->ronda_id,$this->juga_id1,$this->juga_id2,$this->juga_id3,$this->juga_id4,$this->draw_ganador,$this->draw_score,$this->draw_fecha)";
                
			}else{
			
				$sql = "UPDATE draws "
					." SET evmo_id=$this->evmo_id,ronda_id=$this->ronda_id,juga_id1=$this->juga_id1,"
						."juga_id2=$this->juga_id2,juga_id3=$this->juga_id3,juga_id4=$this->juga_id4,"
						."draw_ganador=$this->draw_ganador,draw_score='$this->draw_score',draw_fecha=str_to_date('$this->draw_fecha','%d/%m/%Y')"
					." WHERE draw_id = $this->draw_id";
					
			}
			
			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			   
				   //echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				    mysql_close($conexion);
				   return true;
			   }else{
			   
					 mysql_close($conexion);
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin guardar
	
	
	 
	 function get_draw($id){
				
			$sql = "SELECT * FROM draws WHERE draw_id = ".$id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
			
						
						$this->draw_id = $row['draw_id'];
						$this->evmo_id = $row['evmo_id'];
						$this->ronda_id = $row['ronda_id'];
						$this->juga_id1 = $row['juga_id1'];
						$this->juga_id2 = $row['juga_id2'];
						$this->juga_id3 = $row['juga_id3'];
						$this->juga_id4 = $row['juga_id4'];
						$this->draw_ganador = $row['draw_ganador'];
						$this->draw_score = $row['draw_score'];
						$this->draw_fecha = date("m/d/Y",strtotime($row['draw_fecha']));
						
								
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
		  
    }//fin get_draw
	
	
	
	function get_all_draws($evmo_id){
				
			$sql = "SELECT d.* FROM draws d JOIN rondas r ON r.ronda_id = d.ronda_id WHERE d.evmo_id = ".$evmo_id." ORDER BY r.ronda_draws DESC, d.draw_id ASC";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_all_draws
	
	
	
	
	function get_draws_ronda($evmo_id,$ronda_id){
				
			$sql = "SELECT d.*, j1.juga_nombre as juga1_nombre, j1.juga_apellido as juga1_apellido
					, j2.juga_nombre as juga2_nombre, j2.juga_apellido as juga2_apellido
					, j3.juga_nombre as juga3_nombre, j3.juga_apellido as juga3_apellido
					, j4.juga_nombre as juga4_nombre, j4.juga_apellido as juga4_apellido
					FROM draws d
					  LEFT OUTER JOIN jugadores j1 ON (j1.juga_id = d.juga_id1)
					  LEFT OUTER JOIN jugadores j2 ON (j2.juga_id = d.juga_id2)
					  LEFT OUTER JOIN jugadores j3 ON (j3.juga_id = d.juga_id3)
					  LEFT OUTER JOIN jugadores j4 ON (j4.juga_id = d.juga_id4) WHERE evmo_id = ".$evmo_id." AND ronda_id = ".$ronda_id." ORDER BY draw_id ASC";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_draws_ronda
	
	
	
	
	function get_first_ronda($evmo_id){
				
			$sql = "SELECT r.ronda_id
					FROM draws d
					  JOIN rondas r ON r.ronda_id = d.ronda_id
					WHERE d.evmo_id = $evmo_id
					ORDER BY r.ronda_draws DESC
					LIMIT 1";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){

						return $row['ronda_id'];
				   
				   }else{
						//echo "<br>No se han cargado los draw<br>";
						return false;
				   }
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_first_ronda
	
	
	function get_draws_by_fecha(){
				
			date_default_timezone_set('America/Caracas');	
				
			$sql = "SELECT d.*, j1.juga_nombre as juga1_nombre, j1.juga_apellido as juga1_apellido
					, j2.juga_nombre as juga2_nombre, j2.juga_apellido as juga2_apellido
					, j3.juga_nombre as juga3_nombre, j3.juga_apellido as juga3_apellido
					, j4.juga_nombre as juga4_nombre, j4.juga_apellido as juga4_apellido
					, m.moda_nombre
					FROM draws d
					  LEFT OUTER JOIN jugadores j1 ON (j1.juga_id = d.juga_id1)
					  LEFT OUTER JOIN jugadores j2 ON (j2.juga_id = d.juga_id2)
					  LEFT OUTER JOIN jugadores j3 ON (j3.juga_id = d.juga_id3)
					  LEFT OUTER JOIN jugadores j4 ON (j4.juga_id = d.juga_id4)
					  JOIN eventos_modalidades em ON (em.evmo_id = d.evmo_id)
					  JOIN modalidades m ON (m.moda_id = em.moda_id) 
					WHERE draw_fecha IS NOT NULL 
					  AND d.juga_id1 IS NOT NULL
					  AND d.juga_id3 IS NOT NULL
					  AND d.juga_id1 <> 111111
					  AND d.juga_id3 <> 111111
					  AND draw_fecha >= '".date("Y/m/d H:i:s")."' AND em.evmo_publicar_draw = 'S' 
					ORDER BY draw_fecha ASC";
	
							
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_draws_by_fecha
	
	
	function eliminar($draw_id){
	
			$sql = "DELETE FROM draws WHERE draw_id = ".$draw_id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					return true;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
	}
	
	
	
	function eliminar_all_draws($evmo_id){
	
			$sql = "DELETE FROM draws WHERE evmo_id = ".$evmo_id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					//echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					return true;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
	}

	
	function get_draws_puntos($evmo_id){
				
			$sql = "SELECT j.juga_id, concat(j.juga_apellido,', ',j.juga_nombre) as juga_nombre, draws_puntos
					FROM draws_puntajes d
					  JOIN jugadores j ON j.juga_id = d.juga_id
					WHERE evmo_id = $evmo_id
					ORDER BY draws_puntos DESC";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_draws_puntos
	
	
	
	function get_evento_draws($even_id){
				
			$sql = "SELECT em.evmo_id, m.moda_nombre
					FROM eventos e
					  JOIN eventos_modalidades em ON e.even_id = em.even_id
					  JOIN modalidades m ON m.moda_id = em.moda_id
					WHERE e.even_id = $even_id
					 AND em.evmo_id IN (SELECT evmo_id FROM draws)";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento_draws
	
	
	function calcular_puntos_draw($evmo_id){
	
			$sql = "call calcular_puntos_draws($evmo_id)";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					return true;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
	}
	
	
	function calcular_puntos($ano){
	
			$sql = "SELECT evmo_id
					FROM eventos e
					 JOIN eventos_modalidades em ON em.even_id = e.even_id
					WHERE e.even_id <> 13 AND year(e.even_fecha) = ".$ano;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   while($row = mysql_fetch_assoc($res)){
			
						$this->calcular_puntos_draw($row['evmo_id']);			
					
					}
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				mysql_close($conexion);
	}
	
	
	function asignar_puntos_ranking($evmo_id){
	
			$sql = "call asignar_puntos_ranking($evmo_id)";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					return true;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
	}
	
	
	
	function existe_draw($evmo_id){
		
			$sql = "SELECT count(*) as cant
					FROM draws
					WHERE evmo_id = $evmo_id";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){

						return $row['cant'] == 0 ? false : true;
				   
				   }else{
						//echo "<br>No se han cargado los draw<br>";
						return false;
				   }
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
	}
	
	
	function is_draw_publicado($evmo_id){
		
			$sql = "SELECT evmo_publicar_draw
					FROM eventos_modalidades
					WHERE evmo_id = $evmo_id";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){

						return $row['evmo_publicar_draw'] == 'N' ? false : true;
				   
				   }else{
						//echo "<br>No se han cargado los draw<br>";
						return false;
				   }
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
	}
	
	
}//fin clase draws
?>