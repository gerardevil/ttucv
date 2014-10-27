<?php

require_once("modelo.php");

class rankings_posiciones extends modelo{

           public  $rapo_id;
		   public  $rank_id;
		   public  $rapo_jugador;
		   public  $rapo_puntos;
		   public  $rapo_tj;
		   public  $rapo_orden;
		   
    
	 function __construct($rapo_id,$rank_id,$rapo_jugador,$rapo_puntos,$rapo_tj,$rapo_orden){
	 
			parent::__construct();
	 
			$this->rapo_id = $rapo_id;
			$this->rank_id = $rank_id;
			$this->rapo_jugador = $rapo_jugador;
			$this->rapo_puntos = $rapo_puntos;
			$this->rapo_tj = $rapo_tj;
			$this->rapo_orden = $rapo_orden;
			
	 }//fin constructor
	 
	 
	 function guardar(){
				
			
			$sql = "INSERT INTO rankings_posiciones (rank_id,rapo_jugador,rapo_puntos,rapo_tj,rapo_orden)"
				." VALUES($this->rank_id,'$this->rapo_jugador',$this->rapo_puntos,'$this->rapo_tj',$this->rapo_orden)";
            
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
		  
    }//fin guardar
	
	
	 
	
	function get_all_ranking_posiciones($rank_id){
				
			$sql = "SELECT * FROM rankings_posiciones WHERE rank_id = ".$rank_id." ORDER BY rapo_puntos DESC";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_all_patrocinantes
	
	
	function eliminar($rank_id){
	
			$sql = "DELETE FROM rankings_posiciones WHERE rank_id = ".$rank_id;
                                
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
	
	
	function eliminar_all_ranking_posiciones($rank_id){
	
			$sql = "DELETE FROM rankings_posiciones WHERE rank_id = ".$rank_id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					return true;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				mysql_close($conexion);
	}

}//fin clase eventos
?>