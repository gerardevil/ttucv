<?php

require_once("modelo.php");
require_once("interclubes_juegos_config.php");

	

class interclubes_categorias extends modelo{

           public  $inter_id;
		   public  $inter_nombre;
		   public  $inter_puntaje_jornada;
		   public  $inter_publicar;
		   public  $inter_cerrado;
		   public  $inter_juegos;
		   public  $inter_fecha;
		   public  $inter_afiche;
		   public  $inter_categoria;
		   public  $inter_tipo;
		   public  $inter_cant_equipos_x_grupo;
		   public  $liga_id;
    
	 function __construct($id,$nombre,$puntaje_jornada,$publicar,$cerrado,$fecha,$afiche,$categoria,$tipo){
	 
			parent::__construct();
	 
			$this->inter_id = $id;
			$this->inter_nombre = $nombre;
			$this->inter_puntaje_jornada = $puntaje_jornada;
			
			$this->inter_publicar = $publicar;
			$this->inter_cerrado = $cerrado;
			$this->inter_fecha = $fecha;
			if($afiche == ''){
				$this->inter_afiche = 'NULL';
			}else{
				$this->inter_afiche = "'".$afiche."'";
			}
			if($categoria == ''){
				$this->inter_categoria = 'NULL';
			}else{
				$this->inter_categoria = "'".$categoria."'";
			}
			$this->inter_tipo = $tipo;
			
			$this->inter_juegos = array();

	 }//fin constructor
	 
	 
	 function guardar(){
				
			if($this->inter_id==''){
				
			$sql = "INSERT INTO interclubes_categorias (inter_nombre,inter_puntaje_jornada,inter_publicar,inter_cerrado,inter_fecha,inter_afiche,inter_categoria,inter_tipo,liga_id)"
				." VALUES ('$this->inter_nombre',$this->inter_puntaje_jornada,'$this->inter_publicar','$this->inter_cerrado',str_to_date('$this->inter_fecha','%d/%m/%Y')"
							.",$this->inter_afiche,$this->inter_categoria,'$this->inter_tipo',$this->liga_id)";
                
			}else{
				$sql = "UPDATE interclubes_categorias "
					." SET inter_nombre='$this->inter_nombre',"
					." inter_puntaje_jornada=$this->inter_puntaje_jornada,"
					." inter_publicar='$this->inter_publicar',inter_cerrado='$this->inter_cerrado',"
					." inter_fecha=str_to_date('$this->inter_fecha','%d/%m/%Y'),inter_afiche=$this->inter_afiche,"
					." inter_categoria=$this->inter_categoria,inter_tipo='$this->inter_tipo',liga_id=$this->liga_id"
					." WHERE inter_id = $this->inter_id";
			}
			
			
			include($this->archivo_conexion);
			
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($this->inter_id != ''){
						$aux = new interclubes_juegos_config('','','','','','','','');
						//$aux->eliminar_all_inter_juegos($this->inter_id);
					}else{
						$this->inter_id = mysql_insert_id();
					}
			   
					
			   
					foreach($this->inter_juegos as $key => $obj){
						$obj->inter_id = $this->inter_id;
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
	
	
	 
	 function get_interclubes($id){
			
			
			$sql = "SELECT * FROM interclubes_categorias WHERE inter_id = $id";
			
			include($this->archivo_conexion);
			
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
			
						$this->inter_id = $row['inter_id'];
						$this->inter_nombre = $row['inter_nombre'];
						$this->inter_puntaje_jornada = $row['inter_puntaje_jornada'];
						$this->moda_id = $row['moda_id'];
						$this->inter_publicar = $row['inter_publicar'];
						$this->inter_cerrado = $row['inter_cerrado'];
						$this->inter_fecha = date("m/d/Y",strtotime($row['inter_fecha']));
						$this->inter_afiche = $row['inter_afiche'];
						$this->inter_categoria = $row['inter_categoria'];
						$this->inter_tipo = $row['inter_tipo'];
						$this->inter_cant_equipos_x_grupo = $row['inter_cant_equipos_x_grupo'];
						$this->liga_id = $row['liga_id'];
						
						$aux = new interclubes_juegos_config('','','','','','','','');
						
						$res_juegos =  $aux->get_all_inter_juegos($this->inter_id);
									
						while($row_juego = mysql_fetch_assoc($res_juegos)){
							$this->add_inter_juego($row_juego['interconf_id'],$row_juego['inter_id'],
											$row_juego['interconf_sexo'],$row_juego['interconf_tipo'],
											$row_juego['interconf_puntaje_juego_ganado'],$row_juego['interconf_categoria'],
											$row_juego['interconf_puntaje_juego_perdido'],$row_juego['interconf_puntaje_juego_wo']);
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

		  
    }//fin ger_interclubes
	
	function get_all_interclubes_abiertos($liga_id){
				
			$sql = "SELECT * FROM interclubes_categorias WHERE liga_id = ".$liga_id." AND inter_publicar = 'S' AND inter_cerrado = 'N' ORDER BY inter_categoria ASC";
                                
			echo $sql;	
							
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
		  
    }//fin get_all_interclubes_abiertos
	
	function get_all_interclubes($liga_id){
				
			$sql = "SELECT * FROM interclubes_categorias WHERE liga_id = ".$liga_id." AND inter_publicar = 'S' ORDER BY inter_categoria ASC";
                                
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
		  
    }//fin get_all_interclubes
	
	
	function get_all_interclubes_categorias($liga_id){
				
			$sql = "SELECT * FROM interclubes_categorias WHERE liga_id = ".$liga_id." ORDER BY inter_categoria ASC";
                                
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

    }//fin get_all_interclubes
	
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


	
	function add_inter_juego($interconf_id,$inter_id,$interconf_sexo,$interconf_tipo,$interconf_puntaje_juego_ganado,$interconf_categoria,
						$interconf_puntaje_juego_perdido,$interconf_puntaje_juego_wo){
	
		$inter_juego = new interclubes_juegos_config($interconf_id,$inter_id,$interconf_sexo,$interconf_tipo,$interconf_puntaje_juego_ganado,$interconf_categoria,
									$interconf_puntaje_juego_perdido,$interconf_puntaje_juego_wo);
		array_push($this->inter_juegos, $inter_juego);
	
	}
	
	
	function eliminar($inter_id){
	
			$sql = "DELETE FROM interclubes_categorias WHERE inter_id = ".$inter_id;
                                
			include($this->archivo_conexion);
						
				$aux = new interclubes_juegos_config('','','','','','');
					$aux->eliminar_all_inter_juegos($inter_id);		
				
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
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

}//fin clase interclubes
?>
