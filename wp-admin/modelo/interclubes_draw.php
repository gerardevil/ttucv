<?php

require_once("modelo.php");


class interclubes_draw extends modelo{

           public  $interdraw_id;
		   public  $inter_id;
		   public  $ronda_id;
		   public  $equipo_id1;
		   public  $equipo_id2;
		   public  $interdraw_ganador;
		   public  $interdraw_score;
		   public  $interdraw_fecha;
		   
    
	 function __construct($id,$inter_id,$ronda_id,$equipo_id1,$equipo_id2
						,$draw_ganador,$draw_score,$draw_fecha){
	 
			parent::__construct();
	 
			$this->interdraw_id = $id;
			$this->inter_id = $inter_id;
			$this->ronda_id = $ronda_id;
			if($equipo_id1 != null){
				$this->equipo_id1 = $equipo_id1;
			}else{
				$this->equipo_id1 = "null";
			}
			if($equipo_id2 != null){
				$this->equipo_id2 = $equipo_id2;
			}else{
				$this->equipo_id2 = "null";
			}
			
			if($draw_ganador != null){
				$this->interdraw_ganador = $draw_ganador;
			}else{
				$this->interdraw_ganador = "null";
			}
			if($draw_score != null){
				$this->interdraw_score = "'".$draw_score."'";
			}else{
				$this->interdraw_score = "null";
			}
			if($draw_fecha != null){
				$this->interdraw_fecha = "'".$draw_fecha."'";
			}else{
				$this->interdraw_fecha = "null";
			}

			
	 }//fin constructor
	 
	 
	 function guardar(){
				
				
				
			if($this->interdraw_id==''){
				
				$sql = "INSERT INTO interclubes_draw (inter_id,ronda_id,equipo_id1,equipo_id2,interdraw_ganador,interdraw_score,interdraw_fecha)"
				." VALUES($this->inter_id,$this->ronda_id,$this->equipo_id1,$this->equipo_id2,$this->interdraw_ganador,$this->interdraw_score,$this->interdraw_fecha)";
                
			}else{
				$sql = "UPDATE interclubes_draw "
					." SET inter_id=$this->inter_id,ronda_id=$this->ronda_id,equipo_id1=$this->equipo_id1,equipo_id2=$this->equipo_id2,"
						."interdraw_ganador=$this->interdraw_ganador,interdraw_score='$this->interdraw_score',interdraw_fecha=str_to_date('$this->interdraw_fecha','%d/%m/%Y')"
					." WHERE interdraw_id = $this->interdraw_id";
			}
			
			//echo $sql.'\n';
			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			   
				   //echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				    mysql_close($conexion);
				   return true;
			   }else{
			   
					 mysql_close($conexion);
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin guardar
	
	
	 
	 function get_draw($id){
				
			$sql = "SELECT * FROM interclubes_draw WHERE interdraw_id = ".$id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
			
						
						$this->interdraw_id = $row['interdraw_id'];
						$this->inter_id = $row['inter_id'];
						$this->ronda_id = $row['ronda_id'];
						$this->equipo_id1 = $row['equipo_id1'];
						$this->equipo_id2 = $row['equipo_id2'];
						$this->interdraw_ganador = $row['interdraw_ganador'];
						$this->interdraw_score = $row['interdraw_score'];
						$this->interdraw_fecha = date("m/d/Y",strtotime($row['interdraw_fecha']));
						
								
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
		  
    }//fin get_draw
	
	
	
	function get_all_draws($inter_id){
				
			$sql = "SELECT d.* FROM interclubes_draw d JOIN rondas r ON r.ronda_id = d.ronda_id WHERE d.inter_id = ".$inter_id." ORDER BY r.ronda_draws DESC, d.interdraw_id ASC";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_all_draws
	
	
	
	
	function get_draws_ronda($inter_id,$ronda_id){
				
			$sql = "SELECT d.*, e1.equipo_nombre as equipo1_nombre
					, e2.equipo_nombre as equipo2_nombre
					FROM interclubes_draw d
					  LEFT OUTER JOIN equipos e1 ON (e1.equipo_id = d.equipo_id1)
					  LEFT OUTER JOIN equipos e2 ON (e2.equipo_id = d.equipo_id2) 
					WHERE d.inter_id = ".$inter_id." AND d.ronda_id = ".$ronda_id." ORDER BY interdraw_id ASC";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_draws_ronda
	
	
	
	
	function get_first_ronda($inter_id){
				
			$sql = "SELECT r.ronda_id
					FROM interclubes_draw d
					  JOIN rondas r ON r.ronda_id = d.ronda_id
					WHERE d.inter_id = $inter_id
					ORDER BY r.ronda_draws DESC
					LIMIT 1";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){

						return $row['ronda_id'];
				   
				   }else{
						//echo "<br>No se han cargado los draw<br>";
						return false;
				   }
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_first_ronda
	
	
	function get_draws_by_fecha(){
				
			date_default_timezone_set('America/Caracas');	
				
			$sql = "SELECT d.*, e1.equipo_nombre as equipo1_nombre
					, e2.equipo_nombre as equipo2_nombre
					, m.moda_nombre
					FROM interclubes_draw d
					  LEFT OUTER JOIN equipos e1 ON (e1.equipo_id = d.equipo_id1)
					  LEFT OUTER JOIN equipos e2 ON (e2.equipo_id = d.equipo_id2)
					  JOIN interclubles_categorias ic ON (ic.inter_id = d.inter_id)
					WHERE interdraw_fecha IS NOT NULL 
					  AND d.equipo_id1 IS NOT NULL
					  AND d.equipo_id1 <> 111111
					  AND interdraw_fecha >= '".date("Y/m/d H:i:s")."' AND ic.inter_publicar = 'S' 
					ORDER BY interdraw_fecha ASC";
	
							
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_draws_by_fecha
	
	
	function eliminar($interdraw_id){
	
			$sql = "DELETE FROM interclubes_draw WHERE interdraw_id = ".$interdraw_id;
                                
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
	
	
	
	function eliminar_all_draws($inter_id){
	
			$sql = "DELETE FROM interclubes_draw WHERE inter_id = ".$inter_id;
                                
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

	
	function get_evento_draws($even_id){
				
			$sql = "SELECT em.evmo_id, m.moda_nombre
					FROM eventos e
					  JOIN eventos_modalidades em ON e.even_id = em.even_id
					  JOIN modalidades m ON m.moda_id = em.moda_id
					WHERE e.even_id = $even_id
					 AND em.evmo_id IN (SELECT evmo_id FROM draws)";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento_draws
	
	
	
	function existe_draw($inter_id){
		
			$sql = "SELECT count(*) as cant
					FROM interclubes_draw
					WHERE inter_id = $inter_id";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){

						return $row['cant'] == 0 ? false : true;
				   
				   }else{
						//echo "<br>No se han cargado los draw<br>";
						return false;
				   }
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
	}
	
	
	function is_draw_publicado($inter_id){
		
			$sql = "SELECT inter_publicar
					FROM interclubes_categorias
					WHERE inter_id = $inter_id";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){

						return $row['inter_publicar'] == 'N' ? false : true;
				   
				   }else{
						//echo "<br>No se han cargado los draw<br>";
						return false;
				   }
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
	}
	
	
	function get_resultados_draw($inter_id, $interdraw_id){
				
			$sql = "SELECT ij.*, jj.*
					 , j1.juga_nombre as juga1_nombre, ifnull(j1.juga_apellido,'') as juga1_apellido
					 , j2.juga_nombre as juga2_nombre, ifnull(j2.juga_apellido,'') as juga2_apellido
					 , j3.juga_nombre as juga3_nombre, ifnull(j3.juga_apellido,'') as juga3_apellido
					 , j4.juga_nombre as juga4_nombre, ifnull(j4.juga_apellido,'') as juga4_apellido
					 , c1.club_nombre as club_nombre1, c2.club_nombre as club_nombre2,
					 ij.interconf_id,
					 j.interdraw_id
					FROM interclubes_juegos_config ij
					 LEFT OUTER JOIN interclubes_draw j ON j.inter_id = ij.inter_id
					 LEFT OUTER JOIN interclubes_draw_juegos jj ON jj.interdraw_id = j.interdraw_id AND jj.interconf_id = ij.interconf_id
					 LEFT OUTER JOIN jugadores j1 ON j1.juga_id = jj.juga_id1 
					 LEFT OUTER JOIN jugadores j2 ON j2.juga_id = jj.juga_id2 
					 LEFT OUTER JOIN jugadores j3 ON j3.juga_id = jj.juga_id3
					 LEFT OUTER JOIN jugadores j4 ON j4.juga_id = jj.juga_id4 					 
					 LEFT OUTER JOIN clubes c1 ON c1.club_id = j1.club_id
					 LEFT OUTER JOIN clubes c2 ON c2.club_id = j3.club_id
					WHERE ij.inter_id = $inter_id
						AND j.interdraw_id = $interdraw_id
					ORDER BY ij.interconf_id ASC, jj.interdraw_id ASC";
					
					
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
	
}//fin clase draws
?>