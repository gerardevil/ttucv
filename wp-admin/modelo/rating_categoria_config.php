<?php

require_once("modelo.php");

class rating_categoria_config extends modelo{

		   public  $racat_id;
           public  $raconf_id;
		   public  $raconf_puntos_min;
		   public  $raconf_puntos_max;
		   public  $raconf_categoria;
		   
    
	 function __construct($racat_id,$raconf_id,$raconf_puntos_min,$raconf_puntos_max,$raconf_categoria){
	 
			parent::__construct();
	 
			$this->racat_id = $racat_id;
			$this->raconf_id = $raconf_id;
			$this->raconf_puntos_min = $raconf_puntos_min;
			$this->raconf_puntos_max = $raconf_puntos_max;
			$this->raconf_categoria = $raconf_categoria;
			
	 }//fin constructor
	 
	 
	 function guardar(){

			if($this->racat_id==''){
			
				$sql = "INSERT INTO rating_categoria_config (raconf_id,raconf_puntos_min,raconf_puntos_max,raconf_categoria)"
					." VALUES($this->raconf_id,$this->raconf_puntos_min,$this->raconf_puntos_max,'$this->raconf_categoria')";
                
			}else{
				$sql = "UPDATE rating_categoria_config "
					." SET raconf_id=$this->raconf_id,raconf_puntos_min=$this->raconf_puntos_min, raconf_puntos_max=$this->raconf_puntos_max, raconf_categoria='$this->raconf_categoria'"
					." WHERE racat_id = $this->racat_id";
			}
			
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
	
	
	 
	 function get_rating_categoria_config($id){
				
			$sql = "SELECT * FROM rating_categoria_config WHERE racat_id = ".$id;
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
						
						$this->racat_id = $row['racat_id'];
						$this->raconf_id = $row['raconf_id'];
						$this->raconf_puntos_min = $row['raconf_puntos_min'];
						$this->raconf_puntos_max = $row['raconf_puntos_max'];
						$this->raconf_categoria = $row['raconf_categoria'];
								
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
	
	
	
	function get_all_rating_categoria_configs($raconf_id){
				
			$sql = "SELECT * FROM rating_categoria_config WHERE raconf_id = ".$raconf_id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_all_rating_categoria_configs
	
	
	
	function eliminar($id){
	
			$sql = "DELETE FROM rating_categoria_config WHERE racat_id = ".$id;
                                
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
	
	function eliminar_all_rating_categoria_configs($id){
	
			$sql = "DELETE FROM rating_categoria_config WHERE raconf_id = ".$id;
                                
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
	}

}//fin clase eventos
?>