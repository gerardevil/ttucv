<?php

require_once("modelo.php");
	

class interclubes_grupos extends modelo{

           public  $intergrup_id;
		   public  $intergrup_nombre;
		   public  $inter_id;
    
	 function __construct($id,$nombre,$inter_id){
	 
			parent::__construct();
	 
			$this->intergrup_id = $id;
			$this->intergrup_nombre = $nombre;
			$this->inter_id = $inter_id;

	 }//fin constructor
	 
	 
	 function guardar(){
				
			if($this->intergrup_id==''){
				
				$sql = "INSERT INTO interclubes_grupos (intergrup_nombre,inter_id)"
					." VALUES ('$this->intergrup_nombre',$this->inter_id)";
                
			}else{
				$sql = "UPDATE interclubes_grupos "
					." SET intergrup_nombre='$this->intergrup_nombre',inter_id=$this->inter_id"
					." WHERE intergrup_id = $this->intergrup_id";
			}

			//echo $sql."<br><br>";
			
			include($this->archivo_conexion);
			
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
					
					if($this->intergrup_id==''){
						$this->intergrup_id = mysql_insert_id();
					}
					
				   //echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				   return true;
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin guardar_data
	
	
	
	function asignar_grupo_equipo($equipo_id){
				
		
				$sql = "UPDATE equipos "
					." SET intergrup_id = $this->intergrup_id"
					." WHERE equipo_id = $equipo_id";
			
			//echo $sql."<br><br>";

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
		  
    }//fin guardar_data
	
	
	function asignar_cant_equipos_x_grupo($inter_id,$cant){
				
		
				$sql = "UPDATE interclubes_categorias "
					." SET inter_cant_equipos_x_grupo = $cant"
					." WHERE inter_id = $inter_id";
			
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
		  
    }//fin guardar_data
	
	 
	 function get_grupo($id){
			
			
			$sql = "SELECT * FROM interclubes_grupos WHERE intergrup_id = $id";
			
			include($this->archivo_conexion);
			
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
			
						$this->intergrup_id = $row['intergrup_id'];
						$this->intergrup_nombre = $row['intergrup_nombre'];
						$this->inter_id = $row['inter_id'];
									
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
		  
    }//fin ger_equipo
	
	
	
	
	function get_cantidad_equipos_x_grupo($inter_id){
			
			$exite = false;
			$sql = "SELECT inter_cant_equipos_x_grupo FROM interclubes_categorias WHERE inter_id = $inter_id";
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
						return $row['inter_cant_equipos_x_grupo'];
					}

			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
				return 0;
		  
    }//fin get_evento
	
	
	
	function eliminar($intergrup_id){
	
			$sql = "DELETE FROM interclubes_grupos WHERE intergrup_id = ".$intergrup_id;
                                
			//echo $sql."<br><br>";
			
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
	
	function eliminar_all_grupos($inter_id){
	
			$sql = "DELETE FROM interclubes_grupos WHERE inter_id = ".$inter_id;
                                
			//echo $sql."<br><br>";
			
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

	
	function get_all_grupos($inter_id){
				
			$sql = "SELECT *
					FROM interclubes_grupos
					WHERE inter_id = $inter_id ORDER BY intergrup_nombre ASC";
								
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_all_equipos
	
	
}//fin clase equipos
?>
