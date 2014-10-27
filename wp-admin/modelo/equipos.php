<?php

require_once("modelo.php");
	

class equipos extends modelo{

           public  $equipo_id;
		   public  $equipo_nombre;
		   public  $club_id;
		   public  $inter_id;
		   public  $equipo_email;
		   public  $equipo_puntos;
		   public  $equipo_tipo_cancha;
		   public  $equipo_fecha_insc;
		   public  $equipo_estatus;
		   public  $intergrup_id;
    
	 function __construct($id,$nombre,$club,$inter_id,$email,$puntos,$tipo_cancha,$equipo_fecha_insc,$equipo_estatus,$intergrup_id){
	 
			parent::__construct();
	 
			$this->equipo_id = $id;
			$this->equipo_nombre = $nombre;
			if($club == ''){
				$this->club_id = 'NULL';
			}else{
				$this->club_id = $club;
			}
			$this->inter_id = $inter_id;
			$this->equipo_email = $email;
			$this->equipo_puntos = $puntos;
			$this->equipo_tipo_cancha = $tipo_cancha;
			$this->equipo_fecha_insc = $equipo_fecha_insc;
			$this->equipo_estatus = $equipo_estatus;
			if($intergrup_id == '' || $intergrup_id == null){
				$this->intergrup_id = 'NULL';
			}else{
				$this->intergrup_id = $intergrup_id;
			}

	 }//fin constructor
	 
	 
	 function guardar(){
				
			if($this->equipo_id==''){
				
				$sql = "INSERT INTO equipos (equipo_nombre,club_id,inter_id,equipo_email,equipo_puntos,equipo_tipo_cancha,equipo_fecha_insc,equipo_estatus,intergrup_id)"
					." VALUES ('$this->equipo_nombre',$this->club_id,$this->inter_id,'$this->equipo_email',$this->equipo_puntos,"
					."'$this->equipo_tipo_cancha',str_to_date('$this->equipo_fecha_insc','%d/%m/%Y %H:%i:%s'),'$this->equipo_estatus',$this->intergrup_id)";
                
			}else{
				$sql = "UPDATE equipos "
					." SET equipo_nombre='$this->equipo_nombre',club_id=$this->club_id,inter_id=$this->inter_id,"
					." equipo_email='$this->equipo_email',equipo_puntos=$this->equipo_puntos,equipo_tipo_cancha='$this->equipo_tipo_cancha',"
					." equipo_fecha_insc=str_to_date('$this->equipo_fecha_insc','%d/%m/%Y %H:%i:%s'),equipo_estatus='$this->equipo_estatus',intergrup_id=$this->intergrup_id"
					." WHERE equipo_id = $this->equipo_id";
			}
			
			//echo $sql."<br><br>";
			
			include($this->archivo_conexion);
			
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
					
					if($this->equipo_id=='')
						$this->equipo_id = mysql_insert_id();
					
					mysql_close($conexion);
					//echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					return true;
					
			   }else{

				    echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				    echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

		  
    }//fin guardar_data
	
	
	 
	 function get_equipo($id){
			
			
			$sql = "SELECT * FROM equipos WHERE equipo_id = $id";
			
			include($this->archivo_conexion);
			
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
			
						$this->equipo_id = $row['equipo_id'];
						$this->equipo_nombre = $row['equipo_nombre'];
						$this->club_id = $row['club_id'];
						$this->inter_id = $row['inter_id'];
						$this->equipo_email = $row['equipo_email'];
						$this->equipo_puntos = $row['equipo_puntos'];
						$this->equipo_tipo_cancha = $row['equipo_tipo_cancha'];
						$this->equipo_fecha_insc = $row['equipo_fecha_insc'];
						$this->equipo_estatus = $row['equipo_estatus'];
						$this->intergrup_id = $row['intergrup_id'];
								
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

		  
    }//fin ger_equipo
	
	
	function existe_usuario($usuario){
			
			$exite = false;
			$sql = "SELECT * FROM equipos WHERE equipo_usuario = '".$usuario."'";
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
						$exite = true;
					}else{				
						$exite = false;
					}

			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
				   $exite = false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				mysql_close($conexion);
		  
				return $exite;
		  
    }//fin get_evento
	
	
	function existe_equipo($inter_id, $equipo){
			
			$exite = false;
			$sql = "SELECT * FROM equipos WHERE inter_id = $inter_id AND equipo_nombre = '$equipo'";
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
						$exite = true;
					}else{				
						$exite = false;
					}

			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
				   $exite = false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				mysql_close($conexion);
		  
				return $exite;
		  
    }//fin get_evento
	
	
	
	function get_cantidad_equipos($inter_id, $estatus){
			
			$exite = false;
			$sql = "SELECT count(equipo_id) as cant FROM equipos WHERE inter_id = $inter_id";
                                
			if($estatus != ''){
				$sql = $sql." AND equipo_estatus = '".$estatus."'"; 
			}
				
				
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
						mysql_close($conexion);
						return $row['cant'];
					}

			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
			   
			   }// fin if del query if($res = mysql_query($sql))

				mysql_close($conexion);
		  
				return 0;
		  
    }//fin get_evento
	
	
	
	function eliminar($equipo_id){
	
			$sql = "DELETE FROM equipos WHERE equipo_id = ".$equipo_id;
                                
			//echo $sql."<br><br>";
			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
					
					mysql_close($conexion);
					//echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					return true;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

	}

	
	function get_all_equipos($inter_id, $estatus, $orden, $filtro, $grupo){
				
			$sql = "SELECT e.inter_id, j.juga_id, date_format(e.equipo_fecha_insc,'%d/%m/%Y %H:%i:%s') as equipo_fecha_insc, e.equipo_nombre, e.equipo_id, e.equipo_tipo_cancha
							, e.equipo_email, e.club_id, c.club_nombre, e.equipo_estatus, j.juga_nombre as juga_nombre, ifnull(j.juga_apellido,'') as juga_apellido, e.equipo_puntos
					FROM equipos e 
						JOIN jugadores j ON j.juga_email = e.equipo_email
						JOIN clubes c ON c.club_id = e.club_id
					WHERE e.inter_id = ".$inter_id;
					
			if($estatus != ''){
				$sql = $sql." AND e.equipo_estatus = '".$estatus."'"; 
			}
			
			if($filtro != ''){
				
				$sql = $sql." AND equipo_nombre LIKE '%".$filtro."%'";
				
			}
			
			if($grupo != ''){
				
				$sql = $sql." AND intergrup_id = $grupo";
				
			}
			
			if($orden != ""){
				$sql = $sql." ORDER BY ".$orden;
			}

			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					mysql_close($conexion);
					return $res;
			   
			   }else{

					echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))
		  
    }//fin get_all_equipos
	
	
	function get_equipos_inscritos($inter_id, $email){
				
			$sql = "SELECT e.inter_id, j.juga_id, date_format(e.equipo_fecha_insc,'%d/%m/%Y %H:%i:%s') as equipo_fecha_insc, e.equipo_nombre, e.equipo_id, e.equipo_tipo_cancha
							, e.equipo_email, e.club_id, c.club_nombre, e.equipo_estatus, j.juga_nombre as juga_nombre, ifnull(j.juga_apellido,'') as juga_apellido
					FROM equipos e 
						JOIN jugadores j ON j.juga_email = e.equipo_email
						JOIN clubes c ON c.club_id = e.club_id
					WHERE e.inter_id = $inter_id
					 AND e.equipo_email = '$email'";
					
			//echo $sql."<br>";

			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					mysql_close($conexion);
					return $res;
			   
			   }else{

					echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))
		  
    }//fin get_all_equipos
	
	function get_equipos_asociados($inter_id, $email){
				
			$sql = "SELECT e.inter_id, j.juga_id, date_format(e.equipo_fecha_insc,'%d/%m/%Y %H:%i:%s') as equipo_fecha_insc, e.equipo_nombre, e.equipo_id, e.equipo_tipo_cancha
							, e.equipo_email, e.club_id, c.club_nombre, e.equipo_estatus, j.juga_nombre as juga_nombre, ifnull(j.juga_apellido,'') as juga_apellido
					FROM equipos e 
						JOIN equipos_usuarios eu ON eu.equipo_id = e.equipo_id
						JOIN jugadores j ON j.juga_id = eu.juga_id AND j.juga_email = '$email'
						JOIN clubes c ON c.club_id = e.club_id
					WHERE e.inter_id = $inter_id";
					
			//echo $sql."<br>";

			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					mysql_close($conexion);
					return $res;
			   
			   }else{

					echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))
		  
    }//fin get_all_equipos
	
	
	function guardar_lista_jugadores($inter_id, $arrayJugadores){
					
		$sql = "";
		$aux = -1;
		
		include($this->archivo_conexion);
		
		mysql_query("BEGIN",$conexion);
		
		foreach($arrayJugadores as $jugador_key => $jugador_info){
		
			if($jugador_info[0] != '')
					$this->equipo_id = $jugador_info[0];
		
			if($aux != $this->equipo_id){

				$sql = "DELETE FROM equipos_jugadores WHERE equipo_id = $this->equipo_id;";
				$aux = $this->equipo_id;
				//echo $sql.'<br>';
				
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					//echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					//return true;

				}else{
		   
					mysql_query("ROLBACK",$conexion); 
			
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
				   
				}// fin if del query if($res = mysql_query($sql))	
	
			}
			
			
			$sql = "INSERT INTO equipos_jugadores (equipo_id,juga_id,eqju_rank_individual,eqju_rank_doble) VALUES ($this->equipo_id,$jugador_info[1],$jugador_info[2],$jugador_info[3]);";
			
			//echo $sql.'<br>';
			
			if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				//echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				//return true;

			}else{
	   
				mysql_query("ROLBACK",$conexion);		
	   
				echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				echo "<br>".mysql_error().".<br>";
				mysql_close($conexion);
				return false;
			   
			}// fin if del query if($res = mysql_query($sql))
		}

		mysql_query("COMMIT",$conexion);  

		mysql_close($conexion);   

		return true;
		
		
	}
	
	
	function get_lista_jugadores($equipo_id, $estatus="A", $orden="", $filtro=""){
	
		$sql = "SELECT e.inter_id, j.juga_id, date_format(e.equipo_fecha_insc,'%d/%m/%Y %H:%i:%s') as equipo_fecha_insc, e.equipo_nombre, e.equipo_id, e.equipo_tipo_cancha
							, e.equipo_email, e.club_id, c.club_nombre, e.equipo_estatus, j.juga_nombre, ifnull(j.juga_apellido,'') as juga_apellido, j.juga_email
							, ej.eqju_rank_individual, ej.eqju_rank_doble, j.juga_categoria
					FROM equipos_jugadores ej
						JOIN equipos e ON e.equipo_id = ej.equipo_id	
						JOIN jugadores j ON j.juga_id = ej.juga_id
						JOIN clubes c ON c.club_id = e.club_id
					WHERE ej.equipo_id = $equipo_id
					 AND e.equipo_estatus LIKE '%$estatus%'";
					 
			if($filtro != ''){
				if(is_numeric($filtro)){
					$sql = $sql." AND j.juga_id LIKE '%".$filtro."%'";
				}else{
					$sql = $sql." AND (j.juga_nombre LIKE '%".$filtro."%' OR ifnull(j.juga_apellido,'') LIKE '%".$filtro."%')";

				}
			}
			
			switch($orden){
				case 'cedula': 
					$sql = $sql." ORDER BY juga_id DESC";
					break;
				case 'nombre': 
					$sql = $sql." ORDER BY juga_apellido ASC, juga_nombre ASC";
					break;
				default: 
					$sql = $sql." ORDER BY DATE_FORMAT(equipo_fecha_insc,'%Y %m %d %H:%i:%s') DESC";
					break;
			
			}
					
			//echo $sql."<br>";

			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					mysql_close($conexion);
					return $res;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

	}
	
	
	function guardar_lista_usuarios($inter_id, $arrayJugadores){
					
		$sql = "";
		$aux = -1;
		
		include($this->archivo_conexion);
		
		mysql_query("BEGIN",$conexion);
		
		foreach($arrayJugadores as $jugador_key => $jugador_info){
		
			if($aux != $jugador_info[0]){
				
				$sql = "DELETE FROM equipos_usuarios WHERE equipo_id = $jugador_info[0];";
				$aux = $jugador_info[0];
				
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					//echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					//return true;

				}else{
		   
					mysql_query("ROLBACK",$conexion); 
			
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
				   
				}// fin if del query if($res = mysql_query($sql))	
	
			}
			
			$sql = "INSERT INTO equipos_usuarios (equipo_id,juga_id) VALUES ($jugador_info[0],$jugador_info[1]);";
			
			if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				//echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				//return true;

			}else{
	   
				mysql_query("ROLBACK",$conexion);		
	   
				echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				echo "<br>".mysql_error().".<br>";
				mysql_close($conexion);
				return false;
			   
			}// fin if del query if($res = mysql_query($sql))
		}

		mysql_query("COMMIT",$conexion);  

		mysql_close($conexion);   

		return true;
		
		
	}
	
	
	function get_lista_usuarios($equipo_id, $estatus="A", $orden="", $filtro=""){
	
		$sql = "SELECT e.inter_id, j.juga_id, date_format(e.equipo_fecha_insc,'%d/%m/%Y %H:%i:%s') as equipo_fecha_insc, e.equipo_nombre, e.equipo_id, e.equipo_tipo_cancha
							, e.equipo_email, e.club_id, c.club_nombre, e.equipo_estatus, j.juga_nombre, ifnull(j.juga_apellido,'') as juga_apellido, j.juga_email
					FROM equipos_usuarios ej
						JOIN equipos e ON e.equipo_id = ej.equipo_id	
						JOIN jugadores j ON j.juga_id = ej.juga_id
						JOIN clubes c ON c.club_id = e.club_id
					WHERE ej.equipo_id = $equipo_id
					 AND e.equipo_estatus = '$estatus'";
					 
			if($filtro != ''){
				if(is_numeric($filtro)){
					$sql = $sql." AND j.juga_id LIKE '%".$filtro."%'";
				}else{
					$sql = $sql." AND (j.juga_nombre LIKE '%".$filtro."%' OR ifnull(j.juga_apellido,'') LIKE '%".$filtro."%')";

				}
			}
			
			switch($orden){
				case 'cedula': 
					$sql = $sql." ORDER BY juga_id DESC";
					break;
				case 'nombre': 
					$sql = $sql." ORDER BY juga_apellido ASC, juga_nombre ASC";
					break;
				default: 
					$sql = $sql." ORDER BY DATE_FORMAT(equipo_fecha_insc,'%Y %m %d %H:%i:%s') DESC";
					break;
			
			}
					
			//echo $sql."<br>";

			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					mysql_close($conexion);
					return $res;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);	
	}
	
	
	
	
	
}//fin clase equipos
?>
