<?php

require_once("modelo.php");


class interclubes_patrocinantes extends modelo{

		   public  $liga_id;
		   public  $patr_id;

	 function __construct($liga_id,$patr_id){
	 
			parent::__construct();
	 
			$this->liga_id = $liga_id;
			$this->patr_id = $patr_id;

			
	 }//fin constructor
	 
	 
	 function guardar(){
				
			
			$sql = "INSERT INTO interclubes_patrocinantes (liga_id,patr_id)"
				." VALUES($this->liga_id,$this->patr_id)";
            

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
	
	
	 
	
	function get_all_liga_patrocinantes($liga_id){
				
			$sql = "SELECT * FROM interclubes_patrocinantes WHERE liga_id = ".$liga_id;
                                
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
	
	
	function eliminar($liga_id, $patr_id){
	
			$sql = "DELETE FROM interclubes_patrocinantes WHERE liga_id = ".$liga_id." AND patr_id = ".$patr_id;
                                
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
	
	
	function eliminar_all_patrocinadores($liga_id){
	
			$sql = "DELETE FROM interclubes_patrocinantes WHERE liga_id = ".$liga_id;
                                
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

}//fin clase interclubes_patrocinantes
?>