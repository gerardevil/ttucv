<?php

require_once("modelo.php");

class rondas extends modelo{

           public  $ronda_id;
		   public  $ronda_nombre;
		   public  $ronda_draws;

		   
    
	 function __construct($id,$ronda_nombre,$ronda_draws){
	 
			parent::__construct();
	 
			$this->ronda_id = $id;
			$this->ronda_nombre = $ronda_nombre;
			$this->ronda_draws = $ronda_draws;
			
			
	 }//fin constructor
	 
	 
	 function guardar(){
				
				
				
			if($this->ronda_id==''){
				
			$sql = "INSERT INTO rondas (ronda_nombre,ronda_draws)"
				." VALUES('$this->ronda_nombre',$this->ronda_draws)";
                
			}else{
				$sql = "UPDATE rondas "
					." SET ronda_nombre='$this->ronda_nombre', ronda_draws=$this->ronda_draws"
					." WHERE ronda_id = $this->ronda_id";
			}
			
			
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
		  
    }//fin guardar
	
	
	 
	 function get_ronda($id){
				
			$sql = "SELECT * FROM rondas WHERE ronda_id = ".$id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
			
						$this->ronda_id = $row['ronda_id'];
						$this->ronda_nombre = $row['ronda_nombre'];
						$this->ronda_draws = $row['ronda_draws'];
								
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
	
	function get_all_rondas(){
				
			$sql = "SELECT * FROM rondas ORDER BY ronda_id";
                                
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
	
	function get_next_rondas($ronda_draws){
				
			$sql = "SELECT * FROM rondas WHERE ronda_draws < $ronda_draws ORDER BY ronda_draws DESC";
                                
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
	
	
	
	function get_next_ronda($ronda_draws){
				
			$sql = "SELECT * FROM rondas WHERE ronda_draws < ".$ronda_draws." ORDER BY ronda_draws DESC LIMIT 1";

				 
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
			
						$this->ronda_id = $row['ronda_id'];
						$this->ronda_nombre = $row['ronda_nombre'];
						$this->ronda_draws = $row['ronda_draws'];
								
						return $this;
					
					}else{
					
						//echo "<br>No se encontro el registro<br>";
						return false;
					
					}
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_patrocinante
	
	function get_cant_rondas(){
				
			$sql = "SELECT count(ronda_id) as ronda_cant FROM rondas";

				 
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
								
						return $row['ronda_cant'];
					
					}else{
					
						//echo "<br>No se encontro el registro<br>";
						return false;
					
					}
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_patrocinante
	
	
	function eliminar($ronda_id){
	
			$sql = "DELETE FROM rondas WHERE ronda_id = ".$ronda_id;
                                
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

}//fin clase eventos
?>