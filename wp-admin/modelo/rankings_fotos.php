<?php

require_once("modelo.php");

class rankings_fotos extends modelo{

           public  $rafo_id;
		   public  $rank_id;
		   public  $rafo_descripcion;
		   public  $rafo_foto;
		   public  $rafo_publicar;
		   
    
	 function __construct($rafo_id,$rank_id,$rafo_descripcion,$rafo_foto,$rafo_publicar){
	 
			parent::__construct();
	 
			$this->rafo_id = $rafo_id;
			$this->rank_id = $rank_id;
			$this->rafo_descripcion = $rafo_descripcion;
			$this->rafo_foto = $rafo_foto;
			$this->rafo_publicar = $rafo_publicar;
			
	 }//fin constructor
	 
	 
	 function guardar(){
				
			
			$sql = "INSERT INTO rankings_fotos (rank_id,rafo_descripcion,rafo_foto,rafo_publicar)"
				." VALUES($this->rank_id,'$this->rafo_descripcion','$this->rafo_foto','$this->rafo_publicar')";
            

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
	
	
	 
	
	function get_all_ranking_fotos($rank_id){
				
			$sql = "SELECT * FROM rankings_fotos WHERE rank_id = ".$rank_id;
                                
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
	
			$sql = "DELETE FROM  rankings_fotos WHERE rank_id = ".$rank_id;
                                
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
	
	
	function eliminar_all_ranking_fotos($rank_id){
	
			$sql = "DELETE FROM rankings_fotos WHERE rank_id = ".$rank_id;
                                
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