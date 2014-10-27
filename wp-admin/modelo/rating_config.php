<?php

require_once("modelo.php");
require_once("rating_pesos_config.php");
require_once("rating_categoria_config.php");

class rating_config extends modelo{

           public  $raconf_id;
		   public  $raconf_factor_movilidad;
		   public  $raconf_factor_puntos;
		   public  $raconf_fecha_ult_corte;
		   public  $raconf_publicar;
		   public  $raconf_nombre;
		   public  $raconf_sexo;
		   public  $raconf_tipo;
		   public  $raconf_pesos;
		   public  $raconf_categorias;
		   
		   
	function __construct($raconf_id,$raconf_factor_movilidad,$raconf_factor_puntos,$raconf_fecha_ult_corte,
						$raconf_publicar,$raconf_nombre,$raconf_sexo,$raconf_tipo){
	 
			parent::__construct();
	 
			$this->raconf_id = $raconf_id;
			$this->raconf_factor_movilidad = $raconf_factor_movilidad;
			$this->raconf_factor_puntos = $raconf_factor_puntos;
			$this->raconf_fecha_ult_corte = $raconf_fecha_ult_corte;
			$this->raconf_publicar = $raconf_publicar;
			$this->raconf_nombre = $raconf_nombre;
			$this->raconf_sexo = $raconf_sexo;
			$this->raconf_tipo = $raconf_tipo;
			$this->raconf_pesos = array();
			$this->raconf_categorias = array();
			
	 }//fin constructor
	 
	 
	 function guardar(){

			if($this->raconf_id==''){
			
				$sql = "INSERT INTO rating_config (raconf_factor_movilidad,raconf_factor_puntos,raconf_fecha_ult_corte,raconf_publicar,raconf_nombre,raconf_sexo,raconf_tipo)"
					." VALUES($this->raconf_factor_movilidad,$this->raconf_factor_puntos,str_to_date('$this->raconf_fecha_ult_corte','%d/%m/%Y'),'$this->raconf_publicar','$this->raconf_nombre','$this->raconf_sexo','$this->raconf_tipo')";
                
			}else{
				$sql = "UPDATE rating_config "
					." SET raconf_factor_movilidad=$this->raconf_factor_movilidad,raconf_factor_puntos=$this->raconf_factor_puntos, raconf_fecha_ult_corte=str_to_date('$this->raconf_fecha_ult_corte','%d/%m/%Y')"
					." ,raconf_publicar='$this->raconf_publicar',raconf_nombre='$this->raconf_nombre',raconf_sexo='$this->raconf_sexo',raconf_tipo='$this->raconf_tipo'"
					." WHERE raconf_id = $this->raconf_id";
			}
			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			   
					if($this->raconf_id != ''){
						$aux = new rating_pesos_config('','','','');
						$aux->eliminar_all_rating_pesos_configs($this->raconf_id);
						
						$aux = new rating_categoria_config('','','','','');
						$aux->eliminar_all_rating_categoria_configs($this->raconf_id);
					}else{
						$this->raconf_id = mysql_insert_id();
					}
			   
					
			   
					foreach($this->raconf_pesos as $key => $obj){
						$obj->raconf_id = $this->raconf_id;
						$obj->guardar();
					}
					
					foreach($this->raconf_categorias as $key => $obj){
						$obj->raconf_id = $this->raconf_id;
						$obj->guardar();
					}
			   
				   echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				   return true;
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin guardar
	
	
	 
	 function get_rating_config($id){
				
			$sql = "SELECT * FROM rating_config WHERE raconf_id = ".$id;
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){
						
						$this->raconf_id = $row['raconf_id'];
						$this->raconf_factor_movilidad = $row['raconf_factor_movilidad'];
						$this->raconf_factor_puntos = $row['raconf_factor_puntos'];
						$this->raconf_fecha_ult_corte = $row['raconf_fecha_ult_corte'];
						$this->raconf_publicar = $row['raconf_publicar'];
						$this->raconf_nombre = $row['raconf_nombre'];
						$this->raconf_sexo = $row['raconf_sexo'];
						$this->raconf_tipo= $row['raconf_tipo'];
						
						$aux = new rating_pesos_config('','','','');
						$pesos = $aux->get_all_rating_pesos_configs($this->raconf_id);

						while($row = mysql_fetch_assoc($pesos)){
						
							$this->add_rating_pesos_config(
										$row['rapes_id'],
										$row['raconf_id'],//raconf_id
										$row['raconf_nombre'],//raconf_nombre
										$row['raconf_peso']);//raconf_peso

						}

						$aux = new rating_categoria_config('','','','','');
						$categorias = $aux->get_all_rating_categoria_configs($this->raconf_id);
						
						while($row = mysql_fetch_assoc($categorias)){

							$this->add_rating_categoria_config(
										$row['racat_id'],
										$row['raconf_id'],
										$row['raconf_puntos_min'],//raconf_puntos_min
										$row['raconf_puntos_max'],//raconf_puntos_max
										$row['raconf_categoria']);//raconf_catagoria

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
		  
    }//fin get_patrocinante
	
	function get_all_rating_configs(){
				
			$sql = "SELECT * FROM rating_config";
                                
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
	
	
	
	
	
	function add_rating_pesos_config($rapes_id,$raconf_id,$raconf_nombre,$raconf_peso){
	
		array_push($this->raconf_pesos, new rating_pesos_config($rapes_id,$raconf_id,$raconf_nombre,$raconf_peso));
	
	}
	
	function add_rating_categoria_config($racat_id,$raconf_id,$raconf_puntos_min,$raconf_puntos_max,$raconf_categoria){
	
		array_push($this->raconf_categorias, new rating_categoria_config($racat_id,$raconf_id,$raconf_puntos_min,$raconf_puntos_max,$raconf_categoria));
	
	}
	
	
	function eliminar($id){
	
			$aux = new rating_pesos_config('','','','');
			$pesos = $aux->eliminar_all_rating_pesos_configs($id);

			$aux = new rating_categoria_config('','','','','');
			$categorias = $aux->eliminar_all_rating_categoria_configs($id);
	
			$sql = "DELETE FROM rating_config WHERE raconf_id = ".$id;
                                
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

	
	function get_all_juegos($id){
			
			$this->get_rating_config($id);
			
			$sql = "SELECT
					 ifnull(ifnull(d.draw_fecha,em.evmo_fecha),e.even_fecha) as fecha,
					 d.juga_id1,
					 d.juga_id2,
					 d.juga_id3,
					 d.juga_id4,
					 d.draw_ganador as ganador,
					 d.draw_score as score,
					 e.even_nombre as torneo,
					 m.moda_nombre as modalidad,
					 'C' as tipo_torneo
					FROM draws d
					 JOIN eventos_modalidades em ON em.evmo_id = d.evmo_id
					 JOIN eventos e ON e.even_id = em.even_id
					 JOIN modalidades m ON m.moda_id = em.moda_id
					WHERE d.draw_ganador IS NOT NULL
					 AND d.juga_id1 <> 111111
					 AND d.juga_id2 <> 111111
					 AND d.juga_id3 <> 111111
					 AND d.juga_id4 <> 111111
					 AND ifnull(ifnull(d.draw_fecha,em.evmo_fecha),e.even_fecha) > '$this->raconf_fecha_ult_corte'
					 AND ifnull(ifnull(d.draw_fecha,em.evmo_fecha),e.even_fecha) > '2013-01-01'
					 AND m.moda_tipo = '$this->raconf_tipo'
					 AND m.moda_sexo = '$this->raconf_sexo'

					UNION ALL

					SELECT
					 ifnull(ifnull(ifnull(dj.juego_fecha,d.interdraw_fecha),ic.inter_fecha),il.liga_fecha) as fecha,
					 dj.juga_id1,
					 dj.juga_id2,
					 dj.juga_id3,
					 dj.juga_id4,
					 dj.juego_ganador as ganador,
					 dj.juego_score as score,
					 il.liga_nombre as torneo,
					 ic.inter_nombre as modalidad,
					 'I' as tipo_torneo
					FROM interclubes_draw_juegos dj
					 JOIN interclubes_draw d ON d.interdraw_id = dj.interdraw_id
					 JOIN interclubes_juegos_config ijc ON ijc.interconf_id = dj.interconf_id
					 JOIN interclubes_categorias ic ON ic.inter_id = d.inter_id
					 JOIN interclubes_liga il ON il.liga_id = ic.liga_id
					WHERE dj.juego_ganador IS NOT NULL
					 AND dj.juga_id1 <> 111111
					 AND dj.juga_id2 <> 111111
					 AND dj.juga_id3 <> 111111
					 AND dj.juga_id4 <> 111111
					 AND ifnull(ifnull(ifnull(dj.juego_fecha,d.interdraw_fecha),ic.inter_fecha),il.liga_fecha) > '$this->raconf_fecha_ult_corte'
					 AND ifnull(ifnull(ifnull(dj.juego_fecha,d.interdraw_fecha),ic.inter_fecha),il.liga_fecha) > '2013-01-01'
					 AND ijc.interconf_tipo = '$this->raconf_tipo'
					 AND ijc.interconf_sexo = '$this->raconf_sexo'
					 
					UNION ALL

					SELECT
					 ifnull(ifnull(ifnull(jj.juego_fecha,j.jorn_fecha),ic.inter_fecha),il.liga_fecha) as fecha,
					 jj.juga_id1,
					 jj.juga_id2,
					 jj.juga_id3,
					 jj.juga_id4,
					 jj.juego_ganador as ganador,
					 jj.juego_score as score,
					 il.liga_nombre as torneo,
					 ic.inter_nombre as modalidad,
					 'I' as tipo_torneo
					FROM jornadas_juegos jj
					 JOIN jornadas j ON j.jorn_id = jj.jorn_id
					 JOIN interclubes_juegos_config ijc ON ijc.interconf_id = jj.interconf_id
					 JOIN interclubes_categorias ic ON ic.inter_id = j.inter_id
					 JOIN interclubes_liga il ON il.liga_id = ic.liga_id
					WHERE jj.juego_ganador IS NOT NULL
					 AND jj.juga_id1 <> 111111
					 AND jj.juga_id2 <> 111111
					 AND jj.juga_id3 <> 111111
					 AND jj.juga_id4 <> 111111
					 AND ifnull(ifnull(ifnull(jj.juego_fecha,j.jorn_fecha),ic.inter_fecha),il.liga_fecha) > '$this->raconf_fecha_ult_corte'
					 AND ifnull(ifnull(ifnull(jj.juego_fecha,j.jorn_fecha),ic.inter_fecha),il.liga_fecha) > '2013-01-01'
					 AND ijc.interconf_tipo = '$this->raconf_tipo'
					 AND ijc.interconf_sexo = '$this->raconf_sexo'

					ORDER BY fecha ASC";
					
			//echo $sql;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin
	
	
	function get_all_rating_jugadores($id){
			
			$this->get_rating_config($id);
			
			$sql = "SELECT
					 *
					FROM rating_jugadores_hist
					WHERE raju_fecha_corte = '$this->raconf_fecha_ult_corte'
					 AND raconf_id = $this->raconf_id
					ORDER BY juga_id ASC";
 
			//echo $sql;
			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin
	
	
	function get_rating_jugador_default($juga_id, $raconf_id){
			
			
			$sql = "SELECT
					 rc.raconf_puntos_min,
					 rc.raconf_puntos_max,
					 rc.raconf_categoria
					FROM jugadores j
					 JOIN rating_categoria_config rc ON rc.raconf_categoria = j.juga_categoria  
					WHERE j.juga_id = $juga_id
					 AND rc.raconf_id = $raconf_id";
                                
			//echo $sql;
			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if ($row = mysql_fetch_assoc($res)){
					
						if($row['raconf_categoria'] == '1ra'){
							$puntos = round($row['raconf_puntos_min']+($row['raconf_puntos_min']/2),0);
						}else{
							$puntos = $row['raconf_puntos_max'] + $row['raconf_puntos_min'];
							$puntos = round($puntos/2,0);
						}
						
						return $puntos;
						
					}else{
					
						return 0;
					
					}
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin
	
	
	function get_all_fecha_corte_rating($id){
			
			$this->get_rating_config($id);
			
			$sql = "SELECT
					 distinct(raju_fecha_corte)
					FROM rating_jugadores_hist
					WHERE raconf_id = $id
					 AND raju_fecha_corte <= '$this->raconf_fecha_ult_corte'
					ORDER BY raju_fecha_corte DESC";
 
			//echo $sql;
			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin
	
	function get_fecha_rating_abierto($id){
		
		$this->get_rating_config($id);	
		
		$sql = "SELECT
				 max(raju_fecha_corte) as raju_fecha_corte
				FROM rating_jugadores_hist
				WHERE raconf_id = $id
				 AND raju_fecha_corte > '$this->raconf_fecha_ult_corte'";
							
		//echo $sql;
		
		include($this->archivo_conexion);
					
			if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
		
				if ($row = mysql_fetch_assoc($res)){

					return $row['raju_fecha_corte'];
					
				}else{
				
					return null;
				
				}
			   return $res;
		   
		   }else{
		   
			   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
			   echo "<br>".mysql_error().".<br>";
				return false;
		   
		   }// fin if del query if($res = mysql_query($sql))

		mysql_close($conexion);
			   
	}
	
	function cerrar_corte_rating($id){

		$fecha = $this->get_fecha_rating_abierto($id);

		if($fecha != null){
			
			$sql = "UPDATE
					  rating_config
					SET raconf_fecha_ult_corte = '$fecha'
					WHERE raconf_id = $id";
 
			//echo $sql;
			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   echo '<br>Operaci&oacute;n realizada satisfactoriamente.<br>';
				   return true;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);	
		
		}else{
		
			echo "<br>No hay un rating calculado que cerrar.<br>";
			return false;
			
		}
		
	}
	
}//fin clase eventos
?>