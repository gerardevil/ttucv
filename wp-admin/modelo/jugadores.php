<?php

require_once("modelo.php");

class jugadores extends modelo{

           public  $juga_id;
		   public  $juga_nombre;
		   public  $juga_apellido;
		   public  $juga_fecha_nac;
		   public  $juga_sexo;
		   public  $juga_ciudad;
		   public  $juga_zona;
		   public  $club_id;
		   public  $juga_email;
		   public  $juga_telf_hab;
		   public  $juga_telf_ofic;
		   public  $juga_telf_cel;
		   public  $juga_pin;
		   public  $juga_twitter;
		   public  $juga_facebook;
		   public  $juga_foto;
		   public  $edo_id;
		   public  $juga_otro_club;
		   public  $juga_categoria;
		   public  $juga_alias;
		   public  $juga_ficha_perfil;
		   
    
	 function __construct($id,$juga_nombre,$juga_apellido,$juga_fecha_nac,$juga_sexo,$juga_ciudad,$juga_zona
						,$club_id,$juga_email,$juga_telf_hab,$juga_telf_ofic,$juga_telf_cel,$juga_pin
						,$juga_twitter,$juga_facebook,$juga_foto, $edo_id, $juga_otro_club){
	 
			parent::__construct();
	 
			$this->juga_id = $id;
			$this->juga_nombre = $juga_nombre;
			$this->juga_apellido = $juga_apellido;
			$this->juga_fecha_nac = $juga_fecha_nac;
			$this->juga_sexo = $juga_sexo;
			$this->juga_ciudad = $juga_ciudad;
			$this->juga_zona = $juga_zona;
			if(isset($club_id)){
				$this->club_id = $club_id;
			}else{
				$this->club_id = 'NULL';
			}
			$this->juga_email = $juga_email;
			$this->juga_telf_hab = $juga_telf_hab;
			$this->juga_telf_ofic = $juga_telf_ofic;
			$this->juga_telf_cel = $juga_telf_cel;
			$this->juga_pin = $juga_pin;
			$this->juga_twitter = $juga_twitter;
			$this->juga_facebook = $juga_facebook;
			if(isset($juga_foto)){
				$this->juga_foto = "'".$juga_foto."'";
			}else{
				$this->juga_foto = 'NULL';
			}
			if(isset($edo_id)){
				$this->edo_id = $edo_id;
			}else{
				$this->edo_id = 'NULL';
			}
			if(isset($juga_otro_club)){
				$this->juga_otro_club = "'".$juga_otro_club."'";
			}else{
				$this->juga_otro_club = 'NULL';
			}
			$this->juga_categoria = '';
			$this->juga_alias = '';
			$this->juga_ficha_perfil = '+';
			
	 }//fin constructor
	 
	 
	 function guardar(){
				

			$sql = "INSERT INTO jugadores (juga_id,juga_nombre,juga_apellido,juga_fecha_nac,juga_sexo,juga_ciudad,
											   juga_zona,club_id,juga_email,juga_telf_hab,juga_telf_ofic,
											   juga_telf_cel,juga_pin,juga_twitter,juga_facebook,juga_foto,edo_id,juga_otro_club,juga_categoria,juga_alias,juga_ficha_perfil)"
				." VALUES($this->juga_id,'$this->juga_nombre','$this->juga_apellido',str_to_date('$this->juga_fecha_nac','%d/%m/%Y'),
						  '$this->juga_sexo','$this->juga_ciudad','$this->juga_zona',$this->club_id,'$this->juga_email',
						  '$this->juga_telf_hab','$this->juga_telf_ofic','$this->juga_telf_cel','$this->juga_pin',
						  '$this->juga_twitter','$this->juga_facebook',$this->juga_foto,$this->edo_id,$this->juga_otro_club,'$this->juga_categoria','$this->juga_alias',
						  '$this->juga_ficha_perfil') 
				   ON DUPLICATE KEY UPDATE 
						   juga_nombre='$this->juga_nombre',juga_apellido='$this->juga_apellido',juga_fecha_nac=str_to_date('$this->juga_fecha_nac','%d/%m/%Y'),"
						."juga_sexo='$this->juga_sexo',juga_ciudad='$this->juga_ciudad',juga_zona='$this->juga_zona',"
						."club_id=$this->club_id,juga_email='$this->juga_email',juga_telf_hab='$this->juga_telf_hab',"
						."juga_telf_ofic='$this->juga_telf_ofic',juga_telf_cel='$this->juga_telf_cel',juga_pin='$this->juga_pin',"
						."juga_twitter='$this->juga_twitter',juga_facebook='$this->juga_facebook',juga_foto=$this->juga_foto,"
						."edo_id=$this->edo_id,juga_otro_club=$this->juga_otro_club,juga_categoria='$this->juga_categoria',juga_alias='$this->juga_alias',"
						."juga_ficha_perfil='$this->juga_ficha_perfil'";

			
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

		  
    }//fin guardar
	
	
	 
	 function get_jugador($id){
				
			$sql = "SELECT * FROM jugadores WHERE juga_id = ".$id;
								
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
			
						$this->juga_id = $row['juga_id'];
						$this->juga_nombre = utf8_encode($row['juga_nombre']);
						$this->juga_apellido = utf8_encode($row['juga_apellido']);
						
						if($row['juga_fecha_nac'] != null){
							$this->juga_fecha_nac = date("m/d/Y",strtotime($row['juga_fecha_nac']));
						}else{
							$this->juga_fecha_nac = null;
						}
						
						$this->juga_sexo = $row['juga_sexo'];
						$this->juga_ciudad = utf8_encode($row['juga_ciudad']);
						$this->juga_zona = utf8_encode($row['juga_zona']);
						$this->club_id = $row['club_id'];
						$this->juga_email = utf8_encode($row['juga_email']);
						$this->juga_telf_hab = $row['juga_telf_hab'];
						$this->juga_telf_ofic = $row['juga_telf_ofic'];
						$this->juga_telf_cel = $row['juga_telf_cel'];
						$this->juga_pin = $row['juga_pin'];
						$this->juga_twitter = utf8_encode($row['juga_twitter']);
						$this->juga_facebook = utf8_encode($row['juga_facebook']);
						$this->juga_foto = $row['juga_foto'];
						$this->edo_id = $row['edo_id'];
						$this->juga_otro_club = $row['juga_otro_club'];
						$this->juga_categoria = $row['juga_categoria'];
						$this->juga_alias = utf8_encode($row['juga_alias']);
						$this->juga_ficha_perfil = $row['juga_ficha_perfil'];
								
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

		  
    }//fin get_patrocinante
	
	
	
	function get_jugador_by_email($email){
				
			$sql = "SELECT juga_id FROM jugadores WHERE upper(juga_email) = upper('".$email."')";
 
								
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){

						mysql_close($conexion);
						return $this->get_jugador($row['juga_id']);
					
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

		  
    }//fin get_patrocinante
	
	
	function get_all_jugadores(){
				
			$sql = "SELECT * FROM jugadores WHERE juga_id NOT IN (111111,999999)";

                                
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

    }//fin get_all_patrocinantes
	
	
	function get_lista_jugadores($buscar,$campo){
				
			$sql = "SELECT juga_id, juga_nombre, juga_apellido FROM jugadores WHERE juga_id NOT IN (111111,999999)";
			
			if($campo = "nombre"){
			
				$sql = $sql." AND (juga_apellido LIKE '%$buscar%' OR juga_nombre LIKE '%$buscar%') ";
				
			}else if($campo = "cedula"){
			
				$sql = $sql." AND juga_id = $buscar";
				
			}
	
			$sql = $sql." ORDER BY juga_apellido ASC, juga_nombre ASC";

                                
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

    }//fin get_all_patrocinantes
	
	
	
	function eliminar($juga_id){
	
			$sql = "DELETE FROM jugadores WHERE juga_id = ".$juga_id;
                                
			include($this->archivo_conexion);
						
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

	
	
	 function get_cant_juegos_jugados($id){
				
			$sql = "SELECT
					  count(distinct(em.even_id)) as cant_eventos,
					  count(distinct(em.evmo_id)) as cant_modalidades,
					  count(*) as cant_juegos
					FROM draws d
					  JOIN eventos_modalidades em ON (em.evmo_id = d.evmo_id)
					WHERE d.draw_ganador IS NOT NULL 
					  AND d.juga_id1 <> 111111 AND d.juga_id3 <> 111111
					  AND (d.juga_id1 = $id
					  OR d.juga_id2 = $id
					  OR d.juga_id3 = $id
					  OR d.juga_id4 = $id) 
					  AND year(em.evmo_fecha) > 2012 AND em.evmo_publicar_draw = 'S'";
								
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
							
						mysql_close($conexion);
						return $row;
					
					}else{
					
						mysql_close($conexion);
						//echo "<br>No se encontro el registro<br>";
						return false;
					
					}
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

		  
    }//fin get_patrocinante
	
	function get_cant_juegos_ganados($id){
				
			$sql = "SELECT
					  count(*) as cant_juegos_ganados
					FROM draws d
					  JOIN eventos_modalidades em ON (em.evmo_id = d.evmo_id)
					WHERE (d.juga_id1 <> 111111 AND d.juga_id3 <> 111111) 
					  AND ( 
						   ((d.juga_id1 = $id OR d.juga_id2 = $id) AND draw_ganador = 1)
					    OR ((d.juga_id3 = $id OR d.juga_id4 = $id) AND draw_ganador = 2)
						  ) AND year(em.evmo_fecha) > 2012 AND em.evmo_publicar_draw = 'S'";
								
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
							
						mysql_close($conexion);
						return $row['cant_juegos_ganados'];
					
					}else{
					
						mysql_close($conexion);
						//echo "<br>No se encontro el registro<br>";
						return false;
					
					}
			   
			   }else{

				    echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				    echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

		  
    }//fin get_patrocinante
	
	function get_cant_juegos_perdidos($id){
				
			$sql = "SELECT
					  count(*) as cant_juegos_perdidos
					FROM draws d
					  JOIN eventos_modalidades em ON (em.evmo_id = d.evmo_id)
					WHERE (d.juga_id1 <> 111111 AND d.juga_id3 <> 111111) 
					  AND (
						   ((d.juga_id1 = $id OR d.juga_id2 = $id) AND draw_ganador = 2)
					    OR ((d.juga_id3 = $id OR d.juga_id4 = $id) AND draw_ganador = 1)
						  ) AND year(em.evmo_fecha) > 2012 AND em.evmo_publicar_draw = 'S'";
								
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
							
						mysql_close($conexion);
						return $row['cant_juegos_perdidos'];
					
					}else{
					
						mysql_close($conexion);
						//echo "<br>No se encontro el registro<br>";
						return false;
					
					}
			   
			   }else{

				    echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				    echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

		  
    }//fin get_patrocinante
	
	function get_mejor_resultado($id){
				
			$sql = "SELECT d.juga_id1, d.juga_id2, d.juga_id3, d.juga_id4, d.draw_ganador, d.draw_fecha, e.even_nombre, m.moda_nombre, r.ronda_nombre, r.ronda_id
					FROM draws d
					  JOIN eventos_modalidades em ON (em.evmo_id = d.evmo_id)
					  JOIN eventos e ON (e.even_id = em.even_id)
					  JOIN modalidades m ON (m.moda_id = em.moda_id)
					  JOIN rondas r ON (r.ronda_id = d.ronda_id)
					WHERE
					  d.ronda_id = (SELECT max(ronda_id)
					              FROM draws
					              WHERE juga_id1 = $id OR juga_id2 = $id
					                OR juga_id3 = $id OR juga_id4 = $id)
					  AND (d.juga_id1 = $id OR d.juga_id2 = $id
					  OR d.juga_id3 = $id OR d.juga_id4 = $id)
					  AND (d.juga_id1 <> 111111 AND d.juga_id3 <> 111111) 
					  AND year(e.even_fecha) > 2012 AND em.evmo_publicar_draw = 'S'
					ORDER BY d.draw_fecha DESC
					LIMIT 1";
								
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
						
						mysql_close($conexion);
						return $row;
					
					}else{
					
						mysql_close($conexion);
						//echo "<br>No se encontro el registro<br>";
						return false;
					
					}
			   
			   }else{

					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

		  
    }//fin get_mejor_resultado
	
	
	function get_proximos_juegos($id){
				
			$sql = "SELECT d.*, j1.juga_nombre as juga1_nombre, j1.juga_apellido as juga1_apellido
							, j2.juga_nombre as juga2_nombre, j2.juga_apellido as juga2_apellido
							, j3.juga_nombre as juga3_nombre, j3.juga_apellido as juga3_apellido
							, j4.juga_nombre as juga4_nombre, j4.juga_apellido as juga4_apellido
							, m.moda_nombre
					FROM draws d
						LEFT OUTER JOIN jugadores j1 ON (j1.juga_id = d.juga_id1)
						LEFT OUTER JOIN jugadores j2 ON (j2.juga_id = d.juga_id2)
						LEFT OUTER JOIN jugadores j3 ON (j3.juga_id = d.juga_id3)
						LEFT OUTER JOIN jugadores j4 ON (j4.juga_id = d.juga_id4)
						JOIN eventos_modalidades em ON (em.evmo_id = d.evmo_id)
						JOIN modalidades m ON (m.moda_id = em.moda_id) 
					WHERE draw_fecha IS NOT NULL AND draw_fecha >= '".date("Y/m/d H:i:s")."'
						AND (d.juga_id1 = $id OR d.juga_id2 = $id OR d.juga_id3 = $id OR d.juga_id4 = $id)
						AND (d.juga_id1 <> 111111 AND d.juga_id3 <> 111111) 
						AND year(draw_fecha) > 2012 AND em.evmo_publicar_draw = 'S'
					ORDER BY draw_fecha ASC";
								
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

		  
    }//fin get_proximos_juegos
	
	function get_resultados($id, $evmo_id = null){
				
			$sql = "SELECT d.*, j1.juga_nombre as juga1_nombre, j1.juga_apellido as juga1_apellido
						, j2.juga_nombre as juga2_nombre, j2.juga_apellido as juga2_apellido
						, j3.juga_nombre as juga3_nombre, j3.juga_apellido as juga3_apellido
						, j4.juga_nombre as juga4_nombre, j4.juga_apellido as juga4_apellido
						, m.moda_nombre, e.even_nombre, e.even_id,
						(d.draw_ganador = 1 AND (d.juga_id1 = $id OR d.juga_id2 = $id)) OR
						(d.draw_ganador = 2 AND (d.juga_id3 = $id OR d.juga_id4 = $id)) as es_ganador
					FROM draws d
						LEFT OUTER JOIN jugadores j1 ON (j1.juga_id = d.juga_id1)
						LEFT OUTER JOIN jugadores j2 ON (j2.juga_id = d.juga_id2)
						LEFT OUTER JOIN jugadores j3 ON (j3.juga_id = d.juga_id3)
						LEFT OUTER JOIN jugadores j4 ON (j4.juga_id = d.juga_id4)
						JOIN eventos_modalidades em ON (em.evmo_id = d.evmo_id)
						JOIN modalidades m ON (m.moda_id = em.moda_id)
						JOIN eventos e ON (e.even_id = em.even_id)
					 WHERE draw_ganador IS NOT NULL
						AND (d.juga_id1 = $id OR d.juga_id2 = $id OR d.juga_id3 = $id OR d.juga_id4 = $id)
						AND (d.juga_id1 <> 111111 AND d.juga_id3 <> 111111) 
						AND year(e.even_fecha) > 2012 AND em.evmo_publicar_draw = 'S'";
					
			if($evmo_id != null) $sql = $sql." AND d.evmo_id = $evmo_id";
					
			$sql = $sql." ORDER BY e.even_id, d.evmo_id";	
			
			if($evmo_id != null) $sql = $sql.", es_ganador DESC";
			
			$sql = $sql.", d.draw_fecha DESC";
			
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

    }//fin get_resultados
	
	
	
	function get_email_jugador($id){
		
			$sql = "SELECT
					  juga_email
					FROM jugadores
					WHERE juga_id = $id";
								
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
								
						mysql_close($conexion);
						return $row['juga_email'];
					
					}else{
					
						mysql_close($conexion);
						//echo "<br>No se encontro el registro<br>";
						return false;
					
					}
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					mysql_close($conexion);
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))
	
	}
	
	
	
}//fin clase jugador
?>