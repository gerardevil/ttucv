<?php

require_once("modelo.php");

class prensas extends modelo{

           public  $pren_id;
		   public  $pren_fecha;
		   public  $pren_titulo;
		   public  $pren_resumen;
		   public  $pren_texto;
		   public  $pren_imagen;
		   public  $pren_publicar;
		   
    
	 function __construct($pren_id,$pren_fecha,$pren_titulo,$pren_resumen,$pren_texto,$pren_imagen,$pren_publicar){
	 
			parent::__construct();
	 
			$this->pren_id = $pren_id;
			$this->pren_fecha = $pren_fecha;
			$this->pren_titulo = $pren_titulo;
			$this->pren_resumen = $pren_resumen;
			$this->pren_texto = $pren_texto;
			if(isset($pren_imagen)){
				$this->pren_imagen = "'".$pren_imagen."'";
			}else{
				$this->pren_imagen = 'NULL';
			}
			$this->pren_publicar = $pren_publicar;
			
	 }//fin constructor
	 
	 
	 function guardar(){
				
				
				
			if($this->pren_id==''){
				
			$sql = "INSERT INTO prensas (pren_fecha,pren_titulo,pren_resumen,pren_texto,pren_imagen,pren_publicar)"
				." VALUES(str_to_date('$this->pren_fecha','%d/%m/%Y'),'$this->pren_titulo','$this->pren_resumen','$this->pren_texto',$this->pren_imagen,'$this->pren_publicar')";
                
			}else{
				$sql = "UPDATE prensas "
					." SET pren_fecha=str_to_date('$this->pren_fecha','%d/%m/%Y'),pren_titulo='$this->pren_titulo', pren_resumen='$this->pren_resumen', pren_texto='$this->pren_texto', pren_imagen=$this->pren_imagen, pren_publicar='$this->pren_publicar'"
					." WHERE pren_id = $this->pren_id";
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
	
	
	 
	 function get_prensa($id){
				
			$sql = "SELECT * FROM prensas WHERE pren_id = ".$id;
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){

						$this->pren_id = $row['pren_id'];
						$this->pren_fecha = date("m/d/Y",strtotime($row['pren_fecha']));
						$this->pren_titulo = $row['pren_titulo'];
						$this->pren_resumen = $row['pren_resumen'];
						$this->pren_texto = $row['pren_texto'];
						$this->pren_imagen = $row['pren_imagen'];
						$this->pren_publicar = $row['pren_publicar'];
								
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
	
	function get_all_prensas(){
				
			$sql = "SELECT * FROM prensas";
                                
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
	
	
	function get_all_prensas_activos(){
				
			$sql = "SELECT * FROM prensas WHERE pren_publicar = 'S'";
                                
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
	
	
	function eliminar($pren_id){
	
			$sql = "DELETE FROM prensas WHERE pren_id = ".$pren_id;
                                
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