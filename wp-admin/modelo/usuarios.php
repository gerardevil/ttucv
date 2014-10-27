<?php

require_once("modelo.php");

class usuarios extends modelo{

           public  $usua_id;
		   public  $usua_nombre;
		   public  $usua_email;
		   public  $usua_telefono;
		   public  $usua_clave;
		   public  $usua_tipo;
		   
    
	 function __construct($id,$nombre,$email,$telefono,$clave,$tipo){
	 
			parent::__construct();
	 
			$this->usua_id = $id;
			$this->usua_nombre = $nombre;
			$this->usua_email = $email;
			$this->usua_telefono = $telefono;
			$this->usua_clave = $clave;
			$this->usua_tipo = $tipo;


	 }//fin constructor
	 
	 
	 function guardar(){
				
			if($this->usua_id==''){
				
				$sql = "INSERT INTO usuarios (usua_nombre,usua_email,usua_telefono,usua_clave,usua_tipo) "
				."VALUES('$this->usua_nombre','$this->usua_email','$this->usua_telefono','$this->usua_clave','$this->usua_tipo')";
               
			}else{
				$sql = "UPDATE usuarios "
					." SET usua_nombre='$this->usua_nombre', usua_email='$this->usua_email',usua_telefono='$this->usua_telefono',"
					." usua_clave='$this->usua_clave',usua_tipo='$this->usua_tipo'"
					." WHERE usua_id = $this->usua_id";
			}                    
			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
					
					mysql_close($conexion);
					
				   //echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				   return true;
			   }else{
			   
				   die("<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br><br>".mysql_error().
						".<br><br>Intentalo m&aacute;s tarde o comunicate con el sopote de la web en la secci&oacute;n CONTACTO");
				   
				   mysql_close($conexion);
				   return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   
		  
    }//fin guardar_data
	
	
	 
	 function get_usuario($id){
				
			$sql = "SELECT * FROM usuarios WHERE usua_id = ".$id;
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){

						$this->usua_id = $row['usua_id'];
						$this->usua_nombre = $row['usua_nombre'];
						$this->usua_email = $row['usua_email'];
						$this->usua_telefono = $row['usua_telefono'];
						$this->usua_clave = $row['usua_clave'];
						$this->usua_tipo = $row['usua_tipo'];
					
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
		  
    }//fin get_evento
	
	function get_usuario_by_email($email){
				
			$sql = "SELECT * FROM usuarios WHERE usua_email = '".$email."'";

								
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){

						$this->usua_id = $row['usua_id'];
						$this->usua_nombre = $row['usua_nombre'];
						$this->usua_email = $row['usua_email'];
						$this->usua_telefono = $row['usua_telefono'];
						$this->usua_clave = $row['usua_clave'];
						$this->usua_tipo = $row['usua_tipo'];
					
						return $this;
					
					}else{
					
						//echo "<br>No se encontro el registro<br>";
						return false;
					
					}

			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento

	
	function existe_usuario($email){
			
			$exite = false;
			$sql = "SELECT * FROM usuarios WHERE usua_email = '".$email."'";
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
						$exite = true;
					}else{				
						$exite = false;
					}

			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
				   $exite = false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
				return $exite;
		  
    }//fin get_evento
	
	
	
	function get_all_usuarios(){
				
			$sql = "SELECT * FROM usuarios";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento
	
	
	
	function eliminar($id){
	
			$sql = "DELETE FROM usuarios WHERE usua_id = ".$id;
                                
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

	
	
	function guardar_code($code){
				
			$sql = "INSERT INTO activacion (act_code,usua_id) "
				."VALUES('$code',$this->usua_id)";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
					
					mysql_close($conexion);
					
				   //echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				   return true;
			   }else{
			   
				   die("<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br><br>".mysql_error().
						".<br><br>Intentalo m&aacute;s tarde o comunicate con el sopote de la web en la secci&oacute;n CONTACTO");
				   
				   mysql_close($conexion);
				   return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   
		  
    }//fin guardar_data
	
	function get_usuario_by_code($code){
				
			$sql = "SELECT u.* 
					FROM activacion a 
					 JOIN usuarios u ON u.usua_id = a.usua_id 
					WHERE a.act_code = '".$code."'";

								
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){

						$this->usua_id = $row['usua_id'];
						$this->usua_nombre = $row['usua_nombre'];
						$this->usua_email = $row['usua_email'];
						$this->usua_telefono = $row['usua_telefono'];
						$this->usua_clave = $row['usua_clave'];
						$this->usua_tipo = $row['usua_tipo'];
					
						return $this;
					
					}else{
					
						//echo "<br>No se encontro el registro<br>";
						return false;
					
					}

			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento
	
}//fin clase eventos
?>