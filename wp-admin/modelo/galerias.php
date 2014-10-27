<?php

require_once("modelo.php");

class galerias extends modelo{

           public  $gale_id;
		   public  $depo_id;
		   public  $gale_nombre;
		   public  $gale_imagenpp;
		   public  $gale_fecha;
		   public  $gale_publicar;
		   
    
	 function __construct($gale_id,$depo_id,$gale_nombre,$gale_imagenpp,$gale_fecha,$gale_publicar){
	 
			parent::__construct();
			
			$this->gale_id = $gale_id;
			$this->depo_id = $depo_id;
			$this->gale_nombre = $gale_nombre;
			if(isset($gale_imagenpp)){
				$this->gale_imagenpp = "'".$gale_imagenpp."'";
			}else{
				$this->gale_imagenpp = 'NULL';
			}
			$this->gale_fecha = $gale_fecha;
			$this->gale_publicar = $gale_publicar;
			
	 }//fin constructor
	 
	 
	 function guardar(){

			if($this->gale_id==''){
				
				$sql = "INSERT INTO galerias (depo_id,gale_nombre,gale_imagenpp,gale_fecha,gale_publicar)"
					." VALUES($this->depo_id,'$this->gale_nombre',$this->gale_imagenpp,str_to_date('$this->gale_fecha','%d/%m/%Y'),'$this->gale_publicar')";
                
			}else{
			
				$sql = "UPDATE galerias "
					." SET depo_id=$this->depo_id,gale_nombre='$this->gale_nombre', gale_imagenpp=$this->gale_imagenpp, gale_fecha=str_to_date('$this->gale_fecha','%d/%m/%Y'), gale_publicar='$this->gale_publicar'"
					." WHERE gale_id = $this->gale_id";
				
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
	
	
	 
	 function get_galeria($id){
				
			$sql = "SELECT * FROM galerias WHERE gale_id = ".$id;
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){

						$this->gale_id = $row['gale_id'];
						$this->depo_id = $row['depo_id'];
						$this->gale_nombre = $row['gale_nombre'];
						$this->gale_imagenpp = $row['gale_imagenpp'];
						$this->gale_fecha = date("m/d/Y",strtotime($row['gale_fecha']));
						$this->gale_publicar = $row['gale_publicar'];
								
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
	
	function get_all_galerias($inicio,$cantidad){
			
			if($cantidad!=0)
				$sql = "SELECT * FROM galerias ORDER BY gale_fecha DESC LIMIT $inicio,$cantidad";
			else
				$sql = "SELECT * FROM galerias ORDER BY gale_fecha DESC";
				
			 //echo "<p>".$sql."</p>";
			 
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
	
	
	function get_all_galerias_publicadas(){
				
			$sql = "SELECT * FROM galerias WHERE gale_publicar = 'S'";
                                
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
	
	
	 function get_cant_galerias(){
				
			$sql = "SELECT count(gale_id) as cant FROM galerias";
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
								
						return $row['cant'];
					
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
	
	
	function eliminar($gale_id){
	
			$sql = "DELETE FROM galerias WHERE gale_id = ".$gale_id;
            
			echo $sql."<br>";
			
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