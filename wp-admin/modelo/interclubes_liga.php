<?php

require_once("modelo.php");
require_once("interclubes_categorias.php");
require_once("interclubes_patrocinantes.php");
	

class interclubes_liga extends modelo{

           public  $liga_id;
		   public  $liga_nombre;
		   public  $liga_fecha;
		   public  $liga_publicar;
		   public  $liga_cerrado;
		   public  $liga_afiche;
		   public  $liga_patrocinantes;

    
	 function __construct($id,$nombre,$fecha,$publicar,$cerrado,$afiche){
	 
			parent::__construct();
	 
			$this->liga_id = $id;
			$this->liga_nombre = $nombre;
			$this->liga_fecha = $fecha;
			if(isset($afiche)){
				$this->liga_afiche = "'".$afiche."'";
			}else{
				$this->liga_afiche = 'NULL';
			}
			$this->liga_publicar = $publicar;
			$this->liga_cerrado = 'N';
			$this->liga_patrocinantes = array();

	 }//fin constructor
	 
	 
	 function guardar(){
				
			if($this->liga_id==''){
				
			$sql = "INSERT INTO interclubes_liga (liga_nombre,liga_fecha,liga_afiche,liga_publicar,liga_cerrado)"
				." VALUES('$this->liga_nombre',str_to_date('$this->liga_fecha','%d/%m/%Y'),$this->liga_afiche,'$this->liga_publicar','$this->liga_cerrado')";
                
			}else{
				$sql = "UPDATE interclubes_liga "
					." SET liga_nombre='$this->liga_nombre',liga_fecha=str_to_date('$this->liga_fecha','%d/%m/%Y'),"
					." liga_afiche=$this->liga_afiche,"
					." liga_publicar='$this->liga_publicar',liga_cerrado='$this->liga_cerrado'"
					." WHERE liga_id = $this->liga_id";
			}
			
			
			include($this->archivo_conexion);
			
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					 if($this->liga_id != ''){
						$aux = new interclubes_patrocinantes('','');
						$aux->eliminar_all_patrocinadores($this->liga_id);
					}else{
						$this->liga_id = mysql_insert_id();
					}

			   
					foreach($this->liga_patrocinantes as $key => $obj){
						$obj->liga_id = $this->liga_id;
						$obj->guardar();
					} 
			   
					mysql_close($conexion);
					echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					return true;
					
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

		  
    }//fin guardar_data
	
	
	 
	 function get_interclubes_liga($id){
			
			
			$sql = "SELECT * FROM interclubes_liga WHERE liga_id = $id";
			
			include($this->archivo_conexion);
			
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
			
						$this->liga_id = $row['liga_id'];
						$this->liga_nombre = $row['liga_nombre'];
						$this->liga_fecha = date("m/d/Y",strtotime($row['liga_fecha']));
						$this->liga_afiche = $row['liga_afiche'];
						$this->liga_publicar = $row['liga_publicar'];
						$this->liga_cerrado = $row['liga_cerrado'];
						
						

						$aux = new interclubes_patrocinantes('','');
						
						$res_patr =  $aux->get_all_liga_patrocinantes($this->liga_id);
									
						while($row_patr = mysql_fetch_assoc($res_patr)){
							$this->add_liga_patrocinante($row_patr['liga_id'],
													$row_patr['patr_id']);
						}

						mysql_close($conexion);
						return $this;
					
					}else{
					
						mysql_close($conexion);
						echo "<br>No se encontro el registro<br>";
						return false;
					
					}
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

		  
    }//fin get_interclubes_liga
	
	
	function get_all_ligas_abiertas(){
				
			$sql = "SELECT * FROM interclubes_liga WHERE liga_publicar = 'S' AND liga_cerrado = 'N'";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					mysql_close($conexion);
					return $res;	
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))
		  
    }//fin get_all_ligas_abiertas
	
	
	function get_all_interclubes_ligas(){
				
			$sql = "SELECT * FROM interclubes_liga";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					mysql_close($conexion);
					return $res;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))
		  
    }//fin get_all_interclubes_ligas

	
	function get_all_categorias_abiertas($liga_id){
				
			$sql = "SELECT * FROM interclubes_categorias WHERE liga_id = ".$liga_id
						." AND inter_publicar = 'S' AND inter_cerrado = 'N' ORDER BY inter_categoria ASC";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					mysql_close($conexion);
					return $res;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))
		  
    }//fin get_all_categorias_abiertas
	
	function get_liga_defaut(){
	
		$sql = "SELECT * FROM interclubes_liga WHERE liga_publicar = 'S' AND liga_cerrado = 'N' ORDER BY liga_fecha DESC LIMIT 1";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					mysql_close($conexion);
					return $res;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

	
	}
	
	function add_liga_patrocinante($liga_id,$patr_id){
	
		array_push($this->liga_patrocinantes, new interclubes_patrocinantes($liga_id,$patr_id));
	
	}
	

	function eliminar($liga_id){
	
			$sql = "DELETE FROM interclubes_liga WHERE liga_id = ".$liga_id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
					
					$aux = new interclubes_patrocinantes('','');
					$aux->eliminar_all_patrocinadores($even_id);
			
					mysql_close($conexion);
					echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					return true;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

	}

}//fin clase interclubes_liga
?>