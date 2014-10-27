<?php

require_once("modelo.php");

class modalidades extends modelo{

           public  $moda_id;
		   public  $depo_id;
		   public  $moda_nombre;
		   public  $moda_abreviatura;
		   public  $moda_sexo;
		   public  $moda_publicar;
		   public  $moda_tipo;
    
	 function __construct($id,$depo,$nombre,$abreviatura,$sexo,$publicar,$tipo){
	 
			parent::__construct();
	 
			$this->moda_id = $id;
			$this->depo_id = $depo;
			$this->moda_nombre = $nombre;
			$this->moda_abreviatura = $abreviatura;
			$this->moda_sexo = $sexo;
			$this->moda_publicar = $publicar;
			$this->moda_tipo = $tipo;


	 }//fin constructor
	 
	 
	 function guardar(){
				
			if($this->moda_id==''){
				
				$sql = "INSERT INTO modalidades (depo_id,moda_nombre,moda_abreviatura,moda_sexo,moda_publicar,moda_tipo) "
				."VALUES($this->depo_id,'$this->moda_nombre','$this->moda_abreviatura','$this->moda_sexo','$this->moda_publicar','$this->moda_tipo')";
               
			}else{
				$sql = "UPDATE modalidades "
					." SET depo_id=$this->depo_id, moda_nombre='$this->moda_nombre',moda_abreviatura='$this->moda_abreviatura',"
					." moda_sexo='$this->moda_sexo',moda_publicar='$this->moda_publicar',moda_tipo='$this->moda_tipo'"
					." WHERE moda_id = $this->moda_id";
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
		  
    }//fin guardar_data
	
	
	 
	 function get_modalidad($id){
				
			$sql = "SELECT * FROM modalidades WHERE moda_id = ".$id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
			
						$this->moda_id = $row['moda_id'];
						$this->depo_id = $row['depo_id'];
						$this->moda_nombre = $row['moda_nombre'];
						$this->moda_abreviatura = $row['moda_abreviatura'];
						$this->moda_sexo = $row['moda_sexo'];
						$this->moda_publicar = $row['moda_publicar'];
						$this->moda_tipo = $row['moda_tipo'];
					
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
	
	function get_all_modalidades($depo_id){
				
			$sql = "SELECT * FROM modalidades WHERE depo_id = ".$depo_id;
                                
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
	
	
	function get_all_modalidades_activas($depo_id){
				
			$sql = "SELECT * FROM modalidades WHERE depo_id = ".$depo_id." AND moda_publicar = 'S'";
                                
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

	
	
	function eliminar($moda_id){
	
			$sql = "DELETE FROM modalidades WHERE moda_id = ".$moda_id;
                                
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