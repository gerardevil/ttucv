<?php

require_once("modelo.php");
	

class jornadas extends modelo{

           public  $jorn_id;
		   public  $inter_id;
		   public  $jorn_numero;
		   public  $jorn_fecha;
		   public  $jorn_lugar;
		   public  $equipo_id1;
		   public  $equipo_id2;
		   public  $jorn_ganador;
		   public  $jorn_score;
		   public  $jorn_home;
		   public  $intergrup_id;
    
	 function __construct($id,$inter_id,$jorn_numero,$jorn_fecha,$jorn_lugar,$equipo_id1,$equipo_id2,$jorn_ganador,$jorn_score,$jorn_home,$intergrup_id){
	 
			parent::__construct();
	 
			$this->jorn_id = $id;
			$this->inter_id = $inter_id;
			$this->jorn_numero = $jorn_numero;
			
			if($jorn_fecha != ''){
				$this->jorn_fecha = "'".$jorn_fecha."'";
			}else{
				$this->jorn_fecha = 'NULL';
			}
			
			$this->jorn_lugar = $jorn_lugar;
			
			if($equipo_id1 != ''){
				$this->equipo_id1 = $equipo_id1;
			}else{
				$this->equipo_id1 = 'NULL';
			}
			
			if($equipo_id2 != ''){
				$this->equipo_id2 = $equipo_id2;
			}else{
				$this->equipo_id2 = 'NULL';
			}
			
			if($jorn_ganador != ''){
				$this->jorn_ganador = $jorn_ganador;
			}else{
				$this->jorn_ganador = 'NULL';
			}
			
			if($jorn_score != ''){
				$this->jorn_score = "'".$jorn_score."'";
			}else{
				$this->jorn_score = 'NULL';
			}
			
			if($jorn_home != ''){
				$this->jorn_home = $jorn_home;
			}else{
				$this->jorn_home = 'NULL';
			}
			
			if($intergrup_id != ''){
				$this->intergrup_id = $intergrup_id;
			}else{
				$this->intergrup_id = 'NULL';
			}


	 }//fin constructor
	 
	 
	 function guardar(){
				
			if($this->jorn_id==''){
				
			$sql = "INSERT INTO jornadas (inter_id,jorn_numero,jorn_fecha,jorn_lugar,equipo_id1,equipo_id2,jorn_ganador,jorn_score,jorn_home,intergrup_id)"
				." VALUES ($this->inter_id,$this->jorn_numero,$this->jorn_fecha,'$this->jorn_lugar',"
				."$this->equipo_id1,$this->equipo_id2,$this->jorn_ganador,$this->jorn_score,$this->jorn_home,$this->intergrup_id)";
                
			}else{
				$sql = "UPDATE jornadas "
					." SET inter_id=$this->inter_id,"
					." jorn_numero=$this->jorn_numero,jorn_fecha=$this->jorn_fecha,jorn_lugar='$this->jorn_lugar',equipo_id1=$this->equipo_id1,"
					." equipo_id2=$this->equipo_id2,jorn_ganador=$this->jorn_ganador,jorn_score=$this->jorn_score,jorn_home=$this->jorn_home,intergrup_id=$this->intergrup_id"
					." WHERE jorn_id = $this->jorn_id";
			}
			
			//echo $sql."<br>";
			
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
	
	
	 
	 function get_jornada($id){
			
			$sql = "SELECT * FROM jornadas WHERE jorn_id = $id";
			
			include($this->archivo_conexion);
			
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
							
						$this->jorn_id = $row['jorn_id'];
						$this->inter_id = $row['inter_id'];
						$this->jorn_numero = $row['jorn_numero'];
						//$this->jorn_fecha = date("m/d/Y",strtotime($row['jorn_fecha']));
						
						
						if($row['jorn_fecha'] != ''){
							$this->jorn_fecha = "'".$row['jorn_fecha']."'";
						}else{
							$this->jorn_fecha = 'NULL';
						}
						
						$this->jorn_lugar = $row['jorn_lugar'];
						
						if($row['equipo_id1'] != ''){
							$this->equipo_id1 = $row['equipo_id1'];
						}else{
							$this->equipo_id1 = 'NULL';
						}
						
						if($row['equipo_id2'] != ''){
							$this->equipo_id2 = $row['equipo_id2'];
						}else{
							$this->equipo_id2 = 'NULL';
						}
						
						if($row['jorn_ganador'] != ''){
							$this->jorn_ganador = $row['jorn_ganador'];
						}else{
							$this->jorn_ganador = 'NULL';
						}
						
						if($row['jorn_score'] != ''){
							$this->jorn_score = "'".$row['jorn_score']."'";
						}else{
							$this->jorn_score = 'NULL';
						}
						
						if($row['jorn_home'] != ''){
							$this->jorn_home = $row['jorn_home'];
						}else{
							$this->jorn_home = 'NULL';
						}
						
						if($row['intergrup_id'] != ''){
							$this->intergrup_id = $row['intergrup_id'];
						}else{
							$this->intergrup_id = 'NULL';
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
		  
    }//fin ger_equipo
	
	
	function get_jornada_equipo($inter_id, $jorn_numero, $equipo_id){
			
			
			$sql = "SELECT * 
					FROM jornadas 
					WHERE inter_id = $inter_id 
					 AND jorn_numero = $jorn_numero 
					 AND (equipo_id1 = $equipo_id OR equipo_id2 = $equipo_id)";
			
			include($this->archivo_conexion);
			
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
			
						$this->jorn_id = $row['jorn_id'];
						$this->inter_id = $row['inter_id'];
						$this->jorn_numero = $row['jorn_numero'];
						$this->jorn_fecha = date("m/d/Y",strtotime($row['jorn_fecha']));
						$this->jorn_lugar = $row['jorn_lugar'];
						$this->equipo_id1 = $row['equipo_id1'];
						$this->equipo_id2 = $row['equipo_id2'];
						$this->jorn_ganador = $row['jorn_ganador'];
						$this->jorn_score = $row['jorn_score'];
						$this->jorn_home = $row['jorn_home'];
						$this->intergrup_id = $row['intergrup_id'];
									
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
		  
    }//fin ger_equipo
	
	
	
	function get_all_jornadas($inter_id, $intergrup_id=''){
				
			$sql = "SELECT j.*, e1.equipo_nombre as equipo_nombre1, e2.equipo_nombre as equipo_nombre2, 
							c1.club_nombre as club_nombre1, c2.club_nombre as club_nombre2, g.intergrup_nombre
					FROM jornadas j
					 LEFT OUTER JOIN equipos e1 ON e1.equipo_id = j.equipo_id1 
					 LEFT OUTER JOIN equipos e2 ON e2.equipo_id = j.equipo_id2 
					 LEFT OUTER JOIN clubes c1 ON c1.club_id = e1.club_id
					 LEFT OUTER JOIN clubes c2 ON c2.club_id = e2.club_id
					 LEFT OUTER JOIN interclubes_grupos g ON g.intergrup_id = j.intergrup_id
					WHERE j.inter_id = $inter_id";
					
			if($intergrup_id != '') $sql = $sql." AND j.intergrup_id = ". $intergrup_id;
			
			$sql = $sql." ORDER BY jorn_id ASC";
					
					
			//echo $sql."<br>";

			include($this->archivo_conexion);
					
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_all_equipos
	
	
	function eliminar($id){
	
			$sql = "DELETE FROM jornadas WHERE jorn_id = $id";
                                
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

	
	function eliminar_all_jornadas($inter_id){
	
			$sql = "DELETE FROM jornadas WHERE inter_id = $inter_id";
                                
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
	
	function get_cant_jornada($inter_id){
			
			
			$sql = "SELECT max(jorn_numero) as cant FROM jornadas WHERE inter_id = $inter_id";
			
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
		  
    }//fin ger_equipo
	
	
	function get_jornada_actual($inter_id){
			
			
			$sql = "SELECT ifnull(max(j.jorn_numero),1) as cant 
					FROM jornadas j
					 JOIN jornadas_juegos jj ON jj.jorn_id = j.jorn_id
					WHERE j.inter_id = $inter_id";
			
			include($this->archivo_conexion);
			
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
									
						return $row['cant'];
					
					}else{
					
						return 1;
					
					}
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin ger_equipo
	
	
	function get_resultados_jornada($inter_id, $jorn_id){
				
			$sql = "SELECT ij.*, jj.*
					 , j1.juga_nombre as juga1_nombre, ifnull(j1.juga_apellido,'') as juga1_apellido
					 , j2.juga_nombre as juga2_nombre, ifnull(j2.juga_apellido,'') as juga2_apellido
					 , j3.juga_nombre as juga3_nombre, ifnull(j3.juga_apellido,'') as juga3_apellido
					 , j4.juga_nombre as juga4_nombre, ifnull(j4.juga_apellido,'') as juga4_apellido
					 , c1.club_nombre as club_nombre1, c2.club_nombre as club_nombre2,
					 ij.interconf_id,
					 j.jorn_id
					FROM interclubes_juegos_config ij
					 LEFT OUTER JOIN jornadas j ON j.inter_id = ij.inter_id
					 LEFT OUTER JOIN jornadas_juegos jj ON jj.jorn_id = j.jorn_id AND jj.interconf_id = ij.interconf_id
					 LEFT OUTER JOIN jugadores j1 ON j1.juga_id = jj.juga_id1 
					 LEFT OUTER JOIN jugadores j2 ON j2.juga_id = jj.juga_id2 
					 LEFT OUTER JOIN jugadores j3 ON j3.juga_id = jj.juga_id3
					 LEFT OUTER JOIN jugadores j4 ON j4.juga_id = jj.juga_id4 					 
					 LEFT OUTER JOIN clubes c1 ON c1.club_id = j1.club_id
					 LEFT OUTER JOIN clubes c2 ON c2.club_id = j3.club_id
					WHERE ij.inter_id = $inter_id
						AND j.jorn_id = $jorn_id
					ORDER BY ij.interconf_id ASC, jj.jorn_id ASC";
					
					
			//echo $sql."<br>";

			include($this->archivo_conexion);
					
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_all_equipos
	
	
	
	function get_cuadro_clasificacion($inter_id,$intergrup_id){
	
		$sql = "SELECT e.*, j.equipo_id1, j.equipo_id2, j.jorn_ganador, j.jorn_score, j.jorn_id
				FROM equipos e
				 LEFT OUTER JOIN jornadas j ON (j.equipo_id1 = e.equipo_id OR j.equipo_id2 = e.equipo_id) AND j.inter_id = e.inter_id
				WHERE e.inter_id = $inter_id
				 AND j.jorn_ganador is not null";
				 
		if($intergrup_id != ''){
		
			$sql = $sql." AND e.intergrup_id = $intergrup_id";
		
		}
				
				
		//echo $sql."<br>";

		include($this->archivo_conexion);
				
			if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
		
			   return $res;
		   
		   }else{
		   
			   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
			   echo "<br>".mysql_error().".<br>";
				return false;
		   
		   }// fin if del query if($res = mysql_query($sql))

			mysql_close($conexion);
	
	}
	
	
}//fin clase equipos
?>