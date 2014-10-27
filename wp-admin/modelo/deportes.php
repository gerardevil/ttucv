<?php

require_once("modelo.php");

class deportes extends modelo{

           public  $depo_id;
		   public  $depo_nombre;
		   public  $depo_publicar;

    
	 function __construct($id,$nombre,$publicar){
	 
			parent::__construct();
	 
			$this->depo_id = $id;
			$this->depo_nombre = $nombre;
			$this->depo_publicar = $publicar;


	 }//fin constructor
	 
	 
	 function guardar(){
				
			$sql = "INSERT INTO deportes VALUES($this->depo_id,'$this->depo_nombre','$this->depo_publicar')";
                                
			 include($this->archivo_conexion);
				
				
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			   
			   
				   echo "<br>Operación realizada satisfactoriamente.<br>";
				   return true;
			   
			   }else{
			   
			   
			   
				   echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin guardar_data
	
	
	 
	 function get_deporte($id){
				
			$sql = "SELECT * FROM deportes WHERE depo_id = ".$id;
                                
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
	
	function get_all_deportes(){
				
			$sql = "SELECT * FROM deportes WHERE depo_publicar = 'S'";
                                
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

}//fin clase eventos
?>