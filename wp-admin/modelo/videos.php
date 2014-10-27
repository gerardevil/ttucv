<?php

require_once("modelo.php");

class videos extends modelo{

           public  $vide_id;
		   public  $depo_id;
		   public  $vide_nombre;
		   public  $vide_fecha;
		   public  $vide_codigo;
		   public  $vide_publicar;
		   
    
	 function __construct($vide_id,$depo_id,$vide_nombre,$vide_fecha,$vide_codigo,$vide_publicar){
	 
			parent::__construct();
	 
			$this->vide_id = $vide_id;
			$this->depo_id = $depo_id;
			$this->vide_nombre = $vide_nombre;
			$this->vide_fecha = $vide_fecha;
			$this->vide_codigo = $vide_codigo;
			$this->vide_publicar = $vide_publicar;
			
	 }//fin constructor
	 
	 
	 function guardar(){
				
				
				
			if($this->vide_id==''){
			
				$sql = "INSERT INTO videos (depo_id,vide_nombre,vide_fecha,vide_codigo,vide_publicar)"
					." VALUES($this->depo_id,'$this->vide_nombre',str_to_date('$this->vide_fecha','%d/%m/%Y'),'$this->vide_codigo','$this->vide_publicar')";
                
			}else{
				$sql = "UPDATE videos "
					." SET depo_id=$this->depo_id,vide_nombre='$this->vide_nombre', vide_fecha=str_to_date('$this->vide_fecha','%d/%m/%Y'), vide_codigo='$this->vide_codigo', vide_publicar='$this->vide_publicar'"
					." WHERE vide_id = $this->vide_id";
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
	
	
	 
	 function get_video($id){
				
			$sql = "SELECT * FROM videos WHERE vide_id = ".$id;
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
						
						$this->vide_id = $row['vide_id'];
						$this->depo_id = $row['depo_id'];
						$this->vide_nombre = $row['vide_nombre'];
						$this->vide_fecha = date("m/d/Y",strtotime($row['vide_fecha']));
						$this->vide_codigo = $row['vide_codigo'];
						$this->vide_publicar = $row['vide_publicar'];
								
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
	
	function get_all_videos(){
				
			$sql = "SELECT * FROM videos";
                                
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
	
	
	function get_all_videos_publicados(){
				
			$sql = "SELECT * FROM videos WHERE vide_publicar = 'S'";
                                
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
	
	
	function eliminar($vide_id){
	
			$sql = "DELETE FROM videos WHERE vide_id = ".$vide_id;
                                
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