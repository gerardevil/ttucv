<?php

require_once("modelo.php");

class estados extends modelo{

		   public  $edo_id;
           public  $edo_nombre;
    
	 function __construct($edo_id,$edo_nombre){
	 
			parent::__construct();
	 
			$this->edo_id = $edo_id;
			$this->edo_nombre = $edo_nombre;


	 }//fin constructor
	 
	 
	 
	 function guardar(){
				
			$sql = "INSERT INTO estados (edo_id,edo_nombre) "
					." VALUES($this->edo_id,$this->edo_nombre)"
					." ON DUPLICATE KEY UPDATE "
					." 			edo_id=$this->edo_id,edo_nombre='$this->edo_nombre'";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			   
				   //echo "<br>Operación realizada satisfactoriamente.<br>";
				   return true;
			   }else{
			   
				   echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin guardar_data
	
	
	 
	 function get_estado($id){
				
			$sql = "SELECT * FROM estados WHERE edo_id = ".$id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
			
						$this->edo_id = $row['edo_id'];
						$this->edo_nombre = $row['edo_nombre'];
								
						return $this;
					
					}else{
					
						echo "<br>No se encontro el registro<br>";
						return false;
					
					}
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento
	
	function get_all_estados(){
				
			$sql = "SELECT * FROM estados ORDER BY edo_nombre ASC";
                                
			include($this->archivo_conexion);	
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento
	
	
	function eliminar_estado($id){
	
			$sql = "DELETE FROM estados WHERE edo_id  = ".$id;
                                
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