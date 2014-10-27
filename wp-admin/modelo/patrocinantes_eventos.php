<?php

require_once("modelo.php");


class patrocinantes_eventos extends modelo{

           public  $prev_id;
		   public  $even_id;
		   public  $patr_id;
		   public  $prev_orden;
		   
    
	 function __construct($id,$even_id,$patr_id,$prev_orden){
	 
			parent::__construct();
	 
			$this->prev_id = $id;
			$this->even_id = $even_id;
			$this->patr_id = $patr_id;
			$this->prev_orden = $prev_orden;
			
	 }//fin constructor
	 
	 
	 function guardar(){
				
			
			$sql = "INSERT INTO patrocinantes_eventos (even_id,patr_id,prev_orden)"
				." VALUES($this->even_id,$this->patr_id,$this->prev_orden)";
            

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
	
	
	 
	
	function get_all_even_patrocinantes($even_id){
				
			$sql = "SELECT * FROM patrocinantes_eventos WHERE even_id = ".$even_id;
                                
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
	
	
	function eliminar($prev_id){
	
			$sql = "DELETE FROM patrocinantes_eventos WHERE prev_id = ".$prev_id;
                                
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
	
	
	function eliminar_all_patrocinadores($even_id){
	
			$sql = "DELETE FROM patrocinantes_eventos WHERE even_id = ".$even_id;
                                
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