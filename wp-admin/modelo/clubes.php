<?php

require_once("modelo.php");

class clubes extends modelo{

           public  $club_id;
		   public  $club_nombre;
		   public  $club_abreviatura;
		   
    
	 function __construct($id,$club_nombre){
	 
			parent::__construct();
	 
			$this->club_id = $id;
			$this->club_nombre = $club_nombre;
			$this->club_abreviatura = '';
			
			
	 }//fin constructor
	 
	 
	 function guardar(){
				
				
				
			if($this->club_id==''){
				
			$sql = "INSERT INTO clubes (club_nombre,club_abreviatura)"
				." VALUES('$this->club_nombre','$this->club_abreviatura')";
                
			}else{
				$sql = "UPDATE clubes "
					." SET club_nombre='$this->club_nombre',club_abreviatura='$this->club_abreviatura'"
					." WHERE club_id = $this->club_id";
			}
			
			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
				   mysql_close($conexion);
				   echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				   return true;
			   }else{
				  
   				   mysql_close($conexion);
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

    }//fin guardar
	
	
	 
	 function get_club($id){
				
			$sql = "SELECT * FROM clubes WHERE club_id = ".$id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
			
						$this->club_id = $row['club_id'];
						$this->club_nombre = $row['club_nombre'];
						$this->club_abreviatura = $row['club_abreviatura'];
						
						mysql_close($conexion);
						return $this;
					
					}else{
					
						mysql_close($conexion);
						echo "<br>No se encontro el registro<br>";
						return false;
					
					}
			   
			   }else{
				    
					mysql_close($conexion);
				    echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				    echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))
		  
    }//fin get_patrocinante
	
	function get_all_clubes(){
				
			$sql = "(SELECT * FROM clubes WHERE club_id <> 0 ORDER BY club_nombre) UNION (SELECT * FROM clubes WHERE club_id = 0)";
			//Esta consulta es así solo para traer el club con id 0 como de último
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
					
					mysql_close($conexion);
					return $res;
			   
			   }else{
			   
				    mysql_close($conexion);
				    echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				    echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))
		  
    }//fin get_all_patrocinantes
	
	
	
	
	function eliminar($club_id){
	
			$sql = "DELETE FROM clubes WHERE club_id = ".$club_id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					mysql_close($conexion);
					echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					return true;
			   
			   }else{
			   
					mysql_close($conexion);
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

	}

}//fin clase eventos
?>