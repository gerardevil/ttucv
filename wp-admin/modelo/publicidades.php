<?php

require_once("modelo.php");
require_once("../modelo/publicidades_secciones.php");

class publicidades extends modelo{

           public  $publ_id;
		   public  $publ_nombre;
		   public  $publ_archivo;
		   public  $publ_ubicacion;
		   public  $publ_publicar;
		   public  $publ_secciones;
		   
    
	 function __construct($publ_id,$publ_nombre,$publ_archivo,$publ_ubicacion,$publ_publicar){
	 
			parent::__construct();
	 
			$this->publ_id = $publ_id;
			$this->publ_nombre = $publ_nombre;
			if(isset($publ_archivo)){
				$this->publ_archivo = "'".$publ_archivo."'";
			}else{
				$this->publ_archivo = 'NULL';
			}
			$this->publ_ubicacion = $publ_ubicacion;
			$this->publ_publicar = $publ_publicar;
			$this->publ_secciones = array();
			
	 }//fin constructor
	 
	 
	 function guardar(){
				
				
				
			if($this->publ_id==''){
				
			$sql = "INSERT INTO publicidades (publ_nombre,publ_archivo,publ_ubicacion,publ_publicar)"
				." VALUES('$this->publ_nombre',$this->publ_archivo,'$this->publ_ubicacion','$this->publ_publicar')";
                
			}else{
				$sql = "UPDATE publicidades "
					." SET publ_nombre='$this->publ_nombre', publ_archivo=$this->publ_archivo, publ_ubicacion='$this->publ_ubicacion', publ_publicar='$this->publ_publicar'"
					." WHERE publ_id = $this->publ_id";
			}
			
			
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			   
					if($this->publ_id != ''){
						$aux = new publicidades_secciones('','');
						$aux->eliminar_all_publicidades_seccciones($this->publ_id);
						
					}else{
						$this->publ_id = mysql_insert_id();
					}

			   
					foreach($this->publ_secciones as $key => $obj){
						$obj->publ_id = $this->publ_id;
						$obj->guardar();
					}
			   
			   
				   echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				   return true;
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin guardar
	
	
	 
	 function get_publicidad($id){
				
			$sql = "SELECT * FROM publicidades WHERE publ_id = ".$id;
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){

						$this->publ_id = $row['publ_id'];
						$this->publ_nombre = $row['publ_nombre'];
						$this->publ_archivo = $row['publ_archivo'];
						$this->publ_ubicacion = $row['publ_ubicacion'];
						$this->publ_publicar = $row['publ_publicar'];
						
						
						$aux = new publicidades_secciones('','');
						
						$res_secc =  $aux->get_all_publicidades_secciones($this->publ_id);
									
						while($row_secc = mysql_fetch_assoc($res_secc)){
							$this->add_publicidad_seccion($row_secc['publ_id'],$row_secc['puse_seccion']);
						}


						
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
	
	function get_all_publicidades(){
				
			$sql = "SELECT * FROM publicidades";
                                
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
	
	
	function get_all_publicidades_publicadas(){
				
			$sql = "SELECT * FROM publicidades WHERE publ_publicar = 'S'";
                                
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
	
	
	function add_publicidad_seccion($publ_id,$puse_seccion){
	
		array_push($this->publ_secciones, new publicidades_secciones($publ_id,$puse_seccion));
	
	}
	
	
	
	function eliminar($publ_id){
	
			$sql = "DELETE FROM publicidades WHERE publ_id = ".$publ_id;
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					$sql = "DELETE FROM publicidades_secciones WHERE publ_id = ".$publ_id;
					if($res = mysql_query($sql,$conexion)){}
			
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