<?php

require_once("modelo.php");

class rating_jugadores_hist extends modelo{

           public  $juga_id;
		   public  $raju_fecha_corte;
		   public  $raju_puntos;
		   public  $raconf_id;

		   
	 function __construct($juga_id,$raju_fecha_corte,$raju_puntos,$raconf_id){
	 
			parent::__construct();
	 
			$this->juga_id = $juga_id;
			$this->raju_fecha_corte = $raju_fecha_corte;
			$this->raju_puntos = $raju_puntos;
			$this->raconf_id = $raconf_id;
			
	 }//fin constructor
	 
	 
	 function guardar(){
	
			// if($this->juga_id==''){
				
			$sql = "INSERT INTO rating_jugadores_hist (juga_id,raju_fecha_corte,raju_puntos,raconf_id)"
				." VALUES($this->juga_id,'$this->raju_fecha_corte',$this->raju_puntos,$this->raconf_id)";
                
			// }else{
				// $sql = "UPDATE rating_jugadores_hist "
					// ." SET juga_id=$this->juga_id,raju_fecha_corte='$this->raju_fecha_corte', raju_puntos=$this->raju_puntos, raconf_id=$this->raconf_id"
					// ." WHERE juga_id = $this->juga_id AND raju_fecha_corte = '$this->raju_fecha_corte'";
			// }
			
			//echo $sql."<br>";
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			   
				   //echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				   return true;
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
				   die();
			
				   return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin guardar
	
	
	 
	 function get_rating_jugadores_hist($juga_id, $raju_fecha_corte){
				
			$sql = "SELECT * FROM rating_jugadores_hist WHERE juga_id = ".$juga_id." AND raju_fecha_corte='".$raju_fecha_corte."'";
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){

						$this->juga_id = $row['juga_id'];
						$this->raju_fecha_corte = $row['raju_fecha_corte'];
						$this->raju_puntos = $row['raju_puntos'];
						$this->raconf_id = $row['raconf_id'];
								
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
		  
    }//fin get_patrocinante
	
	function get_all_rating_jugadores_hist($raconf_id, $raju_fecha_corte){
				
			$sql = "SELECT rjh.*, j.juga_nombre, j.juga_apellido, rcc.raconf_categoria
					FROM rating_jugadores_hist rjh
					 JOIN jugadores j ON j.juga_id = rjh.juga_id
					 JOIN rating_categoria_config rcc ON rcc.raconf_id = rjh.raconf_id
					  AND rcc.raconf_puntos_min <= rjh.raju_puntos
					  AND rcc.raconf_puntos_max >= rjh.raju_puntos
					WHERE rjh.raconf_id = $raconf_id";
			
			if($raju_fecha_corte != ''){
			
				$sql = $sql." AND rjh.raju_fecha_corte = '$raju_fecha_corte'";
			
			}else{
			
				$sql = $sql." AND rjh.raju_fecha_corte = (SELECT max(raju_fecha_corte) FROM rating_jugadores_hist WHERE raconf_id = $raconf_id)";
			
			}
			
			$sql = $sql." ORDER BY raju_puntos DESC";

			
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_all_miscelaneos
	
	function eliminar($juga_id, $raju_fecha_corte){
	
			$sql = "DELETE FROM rating_jugadores_hist WHERE juga_id = ".$juga_id." AND raju_fecha_corte='".$raju_fecha_corte."'";
                                
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
	
	function eliminar_all_rating_jugadores_hist($raconf_id, $raju_fecha_corte){
	
			$sql = "DELETE FROM rating_jugadores_hist WHERE raconf_id = $raconf_id AND raju_fecha_corte > '".$raju_fecha_corte."'";
                        
			//echo $sql.'<br>';
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					//echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					return true;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					die();
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
	}

}//fin clase eventos
?>