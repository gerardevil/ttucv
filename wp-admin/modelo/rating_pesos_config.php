<?php

require_once("modelo.php");

class rating_pesos_config extends modelo{

		   public  $rapes_id;
           public  $raconf_id;
		   public  $raconf_nombre;
		   public  $raconf_peso;
		   
    
	 function __construct($rapes_id,$raconf_id,$raconf_nombre,$raconf_peso){
	 
			parent::__construct();
	 
			$this->rapes_id = $rapes_id;
			$this->raconf_id = $raconf_id;
			$this->raconf_nombre = $raconf_nombre;
			$this->raconf_peso = $raconf_peso;
			
	 }//fin constructor
	 
	 
	 function guardar(){

			if($this->rapes_id==''){
			
				$sql = "INSERT INTO rating_pesos_config (raconf_id,raconf_nombre,raconf_peso)"
					." VALUES($this->raconf_id,'$this->raconf_nombre',$this->raconf_peso)";
                
			}else{
				$sql = "UPDATE rating_pesos_config "
					." SET raconf_id=$this->raconf_id,raconf_nombre='$this->raconf_nombre', raconf_peso=$this->raconf_peso"
					." WHERE rapes_id = $this->rapes_id";
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
	
	
	 
	 function get_rating_pesos_config($id){
				
			$sql = "SELECT * FROM rating_pesos_config WHERE rapes_id = ".$id;
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
						
						$this->rapes_id = $row['rapes_id'];
						$this->raconf_id = $row['raconf_id'];
						$this->raconf_nombre = $row['raconf_nombre'];
						$this->raconf_peso = $row['raconf_peso'];
								
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
	
	
	
	function get_all_rating_pesos_configs($raconf_id){
				
			$sql = "SELECT * FROM rating_pesos_config WHERE raconf_id = ".$raconf_id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_all_rating_pesos_configs
	
	
	
	function eliminar($id){
	
			$sql = "DELETE FROM rating_pesos_config WHERE rapes_id = ".$id;
                                
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
	
	function eliminar_all_rating_pesos_configs($id){
	
			$sql = "DELETE FROM rating_pesos_config WHERE raconf_id = ".$id;
                                
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