<?php

require_once("modelo.php");

class publicidades_secciones extends modelo{

           public  $publ_id;
		   public  $puse_seccion;
    
	 function __construct($publ_id,$puse_seccion){
	 
			parent::__construct();
	 
			$this->publ_id = $publ_id;
			$this->puse_seccion = $puse_seccion;
		
	 }//fin constructor
	 
	 
	 function guardar(){

				
			$sql = "INSERT INTO publicidades_secciones (publ_id,puse_seccion)"
				." VALUES($this->publ_id,'$this->puse_seccion')";
             
			
			
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
	
	
	 /*
	 function get_galeria($id){
				
			$sql = "SELECT * FROM publicidades_secciones WHERE publ_id = ".$id;
                                
			 include('../../Connections/conexion.php');	
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){

						$this->publ_id = $row['publ_id'];
						$this->publ_nombre = $row['publ_nombre'];
						$this->publ_archivo = $row['publ_archivo'];
						$this->publ_ubicacion = $row['publ_ubicacion'];
						$this->publ_publicar = $row['publ_publicar'];
								
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
	*/
	
	function get_all_publicidades_secciones($publ_id){
				
			$sql = "SELECT * FROM publicidades_secciones WHERE publ_id = ".$publ_id;
                                
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
	
	
	function eliminar($publ_id, $puse_seccion){
	
			$sql = "DELETE FROM publicidades_secciones WHERE publ_id = ".$publ_id." AND puse_seccion = '".$puse_seccion."'";
                                
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
	
	
	function eliminar_all_publicidades_seccciones($publ_id){
	
			$sql = "DELETE FROM publicidades_secciones WHERE publ_id = ".$publ_id;
                                
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