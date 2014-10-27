<?php

require_once("modelo.php");

class rankings_modalidades extends modelo{

		   public  $rank_id;
		   public  $moda_id;
		   
    
	 function __construct($rank_id,$moda_id){
	 
			parent::__construct();
	 
			$this->rank_id = $rank_id;
			$this->moda_id = $moda_id;
			
	 }//fin constructor
	 
	 
	 function guardar(){
				
			
			$sql = "INSERT INTO rankings_modalidades (rank_id,moda_id)"
				." VALUES($this->rank_id,$this->moda_id)";
            

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
	
	
	 
	
	function get_all_ranking_modalidades($rank_id){
				
			$sql = "SELECT * FROM rankings_modalidades WHERE rank_id = ".$rank_id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_all_ranking_modalidades
	
	
	function eliminar_all_ranking_modalidades($rank_id){
	
			$sql = "DELETE FROM rankings_modalidades WHERE rank_id = ".$rank_id;
                                
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

}//fin clase rankings_modalidades

?>