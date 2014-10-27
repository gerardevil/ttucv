<?php

require_once("modelo.php");

class patrocinantes extends modelo{

           public  $patr_id;
		   public  $patr_nombre;
		   public  $patr_logo;
		   public  $patr_activo;
		   
    
	 function __construct($id,$patr_nombre,$patr_logo,$patr_activo){
	 
			parent::__construct();
	 
			$this->patr_id = $id;
			$this->patr_nombre = $patr_nombre;
			if(isset($patr_logo)){
				$this->patr_logo = "'".$patr_logo."'";
			}else{
				$this->patr_logo = 'NULL';
			}
			$this->patr_activo = $patr_activo;
			
	 }//fin constructor
	 
	 
	 function guardar(){
				
				
				
			if($this->patr_id==''){
				
			$sql = "INSERT INTO patrocinantes (patr_nombre,patr_logo,patr_activo)"
				." VALUES('$this->patr_nombre',$this->patr_logo,'$this->patr_activo')";
                
			}else{
				$sql = "UPDATE patrocinantes "
					." SET patr_nombre='$this->patr_nombre',patr_logo=$this->patr_logo, patr_activo='$this->patr_activo'"
					." WHERE patr_id = $this->patr_id";
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
	
	
	 
	 function get_patrocinante($id){
				
			$sql = "SELECT * FROM patrocinantes WHERE patr_id = ".$id;
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
			
						$this->patr_id = $row['patr_id'];
						$this->patr_nombre = $row['patr_nombre'];
						$this->patr_logo = $row['patr_logo'];
						$this->patr_activo = $row['patr_activo'];
								
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
	
	function get_all_patrocinantes(){
				
			$sql = "SELECT * FROM patrocinantes";
                                
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
	
	
	function get_all_patrocinantes_activos(){
				
			$sql = "SELECT * FROM patrocinantes WHERE patr_activo = 'S'";
                                
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
	
	
	function eliminar($patr_id){
	
			$sql = "DELETE FROM patrocinantes WHERE patr_id = ".$patr_id;
                                
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