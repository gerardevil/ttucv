<?php

require_once("modelo.php");

class miscelaneos extends modelo{

           public  $misc_id;
		   public  $misc_variable;
		   public  $misc_titulo;
		   public  $misc_texto;
		   public  $misc_imagen1;
		   
    
	 function __construct($misc_id,$misc_variable,$misc_titulo,$misc_texto,$misc_imagen1){
	 
			parent::__construct();
	 
			$this->misc_id = $misc_id;
			$this->misc_variable = $misc_variable;
			$this->misc_titulo = $misc_titulo;
			$this->misc_texto = $misc_texto;
			if(isset($misc_imagen1)){
				$this->misc_imagen1 = "'".$misc_imagen1."'";
			}else{
				$this->misc_imagen1 = 'NULL';
			}
			
			
	 }//fin constructor
	 
	 
	 function guardar(){
				
				
				
			if($this->misc_id==''){
				
			$sql = "INSERT INTO miscelaneos (misc_variable,misc_titulo,misc_texto,misc_imagen1)"
				." VALUES('$this->misc_variable','$this->misc_titulo','$this->misc_texto',$this->misc_imagen1)";
                
			}else{
				$sql = "UPDATE miscelaneos "
					." SET misc_variable='$this->misc_variable',misc_titulo='$this->misc_titulo', misc_texto='$this->misc_texto', misc_imagen1=$this->misc_imagen1"
					." WHERE misc_id = $this->misc_id";
			}
			
			
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			   
				   //echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				   return true;
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
				   die();
			
				   return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin guardar
	
	
	 
	 function get_miscelaneo($id){
				
			$sql = "SELECT * FROM miscelaneos WHERE misc_id = ".$id;
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){

						$this->misc_id = $row['misc_id'];
						$this->misc_variable = $row['misc_variable'];
						$this->misc_titulo = $row['misc_titulo'];
						$this->misc_texto = $row['misc_texto'];
						$this->misc_imagen1 = $row['misc_imagen1'];
								
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
	
	function get_all_miscelaneos(){
				
			$sql = "SELECT * FROM miscelaneos WHERE misc_variable NOT IN ('banner','bannerInterclubes')";
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_all_miscelaneos
	
	function get_all_banner(){
				
			$sql = "SELECT * FROM miscelaneos WHERE misc_variable = 'banner'";
                                
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
	
	
	function get_all_banner_interclubes(){
				
			$sql = "SELECT * FROM miscelaneos WHERE misc_variable = 'bannerInterclubes'";
                                
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
	
	function eliminar($misc_id){
	
			$sql = "DELETE FROM miscelaneos WHERE misc_id = ".$misc_id;
                                
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
	
	function eliminar_all_miscelaneos($variable){
	
			$sql = "DELETE FROM miscelaneos WHERE misc_variable = '".$variable."'";
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					//echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					return true;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					die();
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
	}

}//fin clase eventos
?>