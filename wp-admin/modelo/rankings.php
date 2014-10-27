<?php

require_once("modelo.php");
require_once("rankings_posiciones.php");
require_once("rankings_fotos.php");
require_once("rankings_modalidades.php");

class rankings extends modelo{

           public  $rank_id;
		   public  $depo_id;
		   public  $rank_nombre;
		   public  $rank_ano;
		   public  $rank_archivo;
		   public  $rank_imagen;
		   public  $rank_publicar;
		   public $rank_modalidades;
		   public $rank_posiciones;
		   public $rank_fotos;

		   
    
	 function __construct($rank_id,$depo_id,$rank_nombre,$rank_ano,$rank_archivo,$rank_imagen,$rank_publicar){
	 
			parent::__construct();
	 
			$this->rank_id = $rank_id;
			$this->depo_id = $depo_id;
			$this->rank_nombre = $rank_nombre;
			$this->rank_ano = $rank_ano;
			if(isset($rank_archivo)){
				$this->rank_archivo = "'".$rank_archivo."'";
			}else{
				$this->rank_archivo = 'NULL';
			}
			if(isset($rank_imagen)){
				$this->rank_imagen = "'".$rank_imagen."'";
			}else{
				$this->rank_imagen = 'NULL';
			}
			$this->rank_publicar = $rank_publicar;
			$this->rank_modalidades = array();
			$this->rank_posiciones = array();
			$this->rank_fotos = array();


	 }//fin constructor
	 
	 
	 function guardar(){
				
				
				
			if($this->rank_id==''){
				
			$sql = "INSERT INTO rankings (depo_id,rank_nombre,rank_ano,rank_archivo,rank_imagen,rank_publicar)"
				." VALUES($this->depo_id,'$this->rank_nombre',$this->rank_ano,$this->rank_archivo,$this->rank_imagen,'$this->rank_publicar')";
                
			}else{
				$sql = "UPDATE rankings "
					." SET depo_id=$this->depo_id, rank_nombre='$this->rank_nombre',rank_ano=rank_ano,"
					." rank_archivo=$this->rank_archivo,rank_imagen=$this->rank_imagen,rank_publicar='$this->rank_publicar' "
					." WHERE rank_id = $this->rank_id";
			}
			
			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($this->rank_id != ''){
						/*
						$aux = new rankings_posiciones('','','','','','');
						$aux->eliminar_all_ranking_posiciones($this->rank_id);
						*/
						
						
						$aux = new rankings_fotos('','','','','');
						$aux->eliminar_all_ranking_fotos($this->rank_id);
						
						
						$aux = new rankings_modalidades('','','','','');
						$aux->eliminar_all_ranking_modalidades($this->rank_id);
					}else{
						$this->rank_id = mysql_insert_id();
					}
			   
					
					foreach($this->rank_modalidades as $key => $obj){
						$obj->rank_id = $this->rank_id;
						$obj->guardar();
					}
			   
					/*
					foreach($this->rank_posiciones as $key => $obj){
						$obj->rank_id = $this->rank_id;
						$obj->guardar();
					}
					*/
					
					foreach($this->rank_fotos as $key => $obj){
						//echo $obj->rafo_descripcion;
						$obj->rank_id = $this->rank_id;
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
		  
    }//fin guardar_data
	
	
	 
	 function get_ranking($id){
			
			
			$sql = "SELECT * FROM rankings WHERE rank_id = $id";

			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
							
						$this->rank_id = $row['rank_id'];
						$this->depo_id = $row['depo_id'];
						$this->rank_nombre = htmlentities($row['rank_nombre']);
						$this->rank_ano = $row['rank_ano'];
						$this->rank_archivo = $row['rank_archivo'];
						$this->rank_imagen = $row['rank_imagen'];
						$this->rank_publicar = $row['rank_publicar'];
						
						
						
						$aux = new rankings_modalidades('','');
						
						$res_modalidades =  $aux->get_all_ranking_modalidades($this->rank_id);
									
						while($row_modalidades = mysql_fetch_assoc($res_modalidades)){
							$this->add_ranking_modalidad($row_modalidades['rank_id'],$row_modalidades['moda_id']);
						}

						
						/*
						$aux = new rankings_posiciones('','','','','','');
						
						$res_pos =  $aux->get_all_ranking_posiciones($this->rank_id);
									
						while($row_pos = mysql_fetch_assoc($res_pos)){
							$this->add_ranking_posicion($row_pos['rapo_id'],$row_pos['rank_id'],
											$row_pos['rapo_jugador'],$row_pos['rapo_puntos'],
											$row_pos['rapo_tj'],$row_pos['rapo_orden']);
						}
						*/

						$aux = new rankings_fotos('','','','','');
						
						$res_fotos =  $aux->get_all_ranking_fotos($this->rank_id);
									
						while($row_fotos = mysql_fetch_assoc($res_fotos)){
							$this->add_ranking_foto($row_fotos['rafo_id'],$row_fotos['rank_id'],
													utf8_encode($row_fotos['rafo_descripcion']),$row_fotos['rafo_foto'],
													$row_fotos['rafo_publicar']);
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
		  
    }//fin get_evento
	
	function get_all_rankings($depo_id){
				
			$sql = "SELECT * FROM rankings WHERE depo_id = ".$depo_id." AND rank_publicar = 'S'";
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento
	
	
	function add_ranking_modalidad($rank_id,$moda_id){
	
		array_push($this->rank_modalidades, new rankings_modalidades($rank_id,$moda_id));
	
	}
	
	
	function add_ranking_posicion($rapo_id,$rank_id,$rapo_jugador,$rapo_puntos,$rapo_tj,$rapo_orden){
	
		array_push($this->rank_posiciones, new rankings_posiciones($rapo_id,$rank_id,$rapo_jugador,$rapo_puntos,$rapo_tj,$rapo_orden));
	
	}
	
	
	function add_ranking_foto($rafo_id,$rank_id,$rafo_descripcion,$rafo_foto,$rafo_publicar){
	
		array_push($this->rank_fotos, new rankings_fotos($rafo_id,$rank_id,$rafo_descripcion,$rafo_foto,$rafo_publicar));
	
	}
	
	function eliminar($rank_id){
	
			$sql = "DELETE FROM rankings WHERE rank_id = ".$rank_id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					$aux = new rankings_posiciones('','','','','','');
					$aux->eliminar_all_ranking_posiciones($rank_id);
					
					$aux = new rankings_fotos('','','','','');
					$aux->eliminar_all_ranking_fotos($rank_id);
			
					echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					return true;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
	}

	
	

	function get_ranking_detallado($depo_id, $año){
				
			$sql = "(SELECT /*e.even_id, e.even_nombre, em.evmo_id, */m.moda_nombre, j.juga_id, concat(j.juga_apellido,', ',j.juga_nombre) as juga_nombre, ifnull(dp.draws_puntos,0) as draws_puntos, e.even_fecha, 'TP' as tipo_col
					FROM (jugadores j, eventos e
					  JOIN eventos_modalidades em ON em.even_id = e.even_id
					  JOIN modalidades m ON m.moda_id = em.moda_id)
					  LEFT OUTER JOIN draws_puntajes dp ON dp.evmo_id = em.evmo_id AND dp.juga_id = j.juga_id
					WHERE j.juga_id <> 111111
					 AND j.juga_id <> 999999
					 AND e.depo_id = $depo_id
					 AND e.even_publicar = 'S'
					 AND extract(year from e.even_fecha) = $año
					)
					UNION ALL
					(
					SELECT /*1, 'RANKING PUNTOS', r.rank_id, */r.rank_nombre, j.juga_id, concat(j.juga_apellido,', ',j.juga_nombre) as juga_nombre, ifnull(rp.rapo_puntos,0) as draws_puntos, null, 'RP'
										FROM (jugadores j, rankings r)
										  LEFT OUTER JOIN rankings_posiciones rp ON rp.rank_id = r.rank_id AND rp.juga_id = j.juga_id
										WHERE j.juga_id <> 111111
										 AND j.juga_id <> 999999
										 AND r.depo_id = $depo_id
										 AND r.rank_publicar = 'S'
										 AND r.rank_ano = $año
					)
					UNION ALL
					(
					SELECT /*2, 'RANKING TORNEOS JUGADOS', r.rank_id, */r.rank_nombre, j.juga_id, concat(j.juga_apellido,', ',j.juga_nombre) as juga_nombre, ifnull(rp.rapo_tj,0) as draws_puntos, null, 'RJ'
										FROM (jugadores j, rankings r)
										  LEFT OUTER JOIN rankings_posiciones rp ON rp.rank_id = r.rank_id AND rp.juga_id = j.juga_id
										WHERE j.juga_id <> 111111
										 AND j.juga_id <> 999999
										 AND r.depo_id = $depo_id
										 AND r.rank_publicar = 'S'
										 AND r.rank_ano = $año
					)
					ORDER BY juga_id ASC, tipo_col DESC, even_fecha ASC, moda_nombre ASC";

                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_ranking_detallado
	
	
	function get_ranking_detallado_paginado($depo_id, $año, $pagina, $cantidad){
			
			
			include($this->archivo_conexion);
			
			
			$row = ($pagina-1) * $cantidad;
			
			
			$sql = "(SELECT /*e.even_id, e.even_nombre, em.evmo_id, */m.moda_nombre, j.juga_id, concat(j.juga_apellido,', ',j.juga_nombre) as juga_nombre, ifnull(dp.draws_puntos,0) as draws_puntos, e.even_fecha, 'TP' as tipo_col
					FROM (jugadores j, eventos e
					  JOIN eventos_modalidades em ON em.even_id = e.even_id
					  JOIN modalidades m ON m.moda_id = em.moda_id)
					  LEFT OUTER JOIN draws_puntajes dp ON dp.evmo_id = em.evmo_id AND dp.juga_id = j.juga_id
					WHERE j.juga_id <> 111111
					 AND j.juga_id <> 999999
					 AND e.depo_id = $depo_id
					 AND e.even_publicar = 'S'
					 AND extract(year from e.even_fecha) = $año
					)
					UNION ALL
					(
					SELECT /*1, 'RANKING PUNTOS', r.rank_id, */r.rank_nombre, j.juga_id, concat(j.juga_apellido,', ',j.juga_nombre) as juga_nombre, ifnull(rp.rapo_puntos,0) as draws_puntos, null, 'RP'
										FROM (jugadores j, rankings r)
										  LEFT OUTER JOIN rankings_posiciones rp ON rp.rank_id = r.rank_id AND rp.juga_id = j.juga_id
										WHERE j.juga_id <> 111111
										 AND j.juga_id <> 999999
										 AND r.depo_id = $depo_id
										 AND r.rank_publicar = 'S'
										 AND r.rank_ano = $año
					)
					UNION ALL
					(
					SELECT /*2, 'RANKING TORNEOS JUGADOS', r.rank_id, */r.rank_nombre, j.juga_id, concat(j.juga_apellido,', ',j.juga_nombre) as juga_nombre, ifnull(rp.rapo_tj,0) as draws_puntos, null, 'RJ'
										FROM (jugadores j, rankings r)
										  LEFT OUTER JOIN rankings_posiciones rp ON rp.rank_id = r.rank_id AND rp.juga_id = j.juga_id
										WHERE j.juga_id <> 111111
										 AND j.juga_id <> 999999
										 AND r.depo_id = $depo_id
										 AND r.rank_publicar = 'S'
										 AND r.rank_ano = $año
					)
					ORDER BY juga_id ASC, tipo_col DESC, even_fecha ASC, moda_nombre ASC";
					
					
				if($cantidad != 0){
					$sql = $sql." LIMIT $row,$cantidad";
				}
					
					
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
					
					return $res;
					
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
				   
    }//fin get_ranking_detallado_paginado

	
	function get_ranking_detallado_cantidad($depo_id, $año){
			
			
			include($this->archivo_conexion);
			
			$sql = "SELECT COUNT(*) as cant FROM ((SELECT /*e.even_id, e.even_nombre, em.evmo_id, */m.moda_nombre, j.juga_id, concat(j.juga_apellido,', ',j.juga_nombre) as juga_nombre, ifnull(dp.draws_puntos,0) as draws_puntos, e.even_fecha, 'TP' as tipo_col
					FROM (jugadores j, eventos e
					  JOIN eventos_modalidades em ON em.even_id = e.even_id
					  JOIN modalidades m ON m.moda_id = em.moda_id)
					  LEFT OUTER JOIN draws_puntajes dp ON dp.evmo_id = em.evmo_id AND dp.juga_id = j.juga_id
					WHERE j.juga_id <> 111111
					 AND j.juga_id <> 999999
					 AND e.depo_id = $depo_id
					 AND e.even_publicar = 'S'
					 AND extract(year from e.even_fecha) = $año
					)
					UNION ALL
					(
					SELECT /*1, 'RANKING PUNTOS', r.rank_id, */r.rank_nombre, j.juga_id, concat(j.juga_apellido,', ',j.juga_nombre) as juga_nombre, ifnull(rp.rapo_puntos,0) as draws_puntos, null, 'RP'
										FROM (jugadores j, rankings r)
										  LEFT OUTER JOIN rankings_posiciones rp ON rp.rank_id = r.rank_id AND rp.juga_id = j.juga_id
										WHERE j.juga_id <> 111111
										 AND j.juga_id <> 999999
										 AND r.depo_id = $depo_id
										 AND r.rank_publicar = 'S'
										 AND r.rank_ano = $año
					)
					UNION ALL
					(
					SELECT /*2, 'RANKING TORNEOS JUGADOS', r.rank_id, */r.rank_nombre, j.juga_id, concat(j.juga_apellido,', ',j.juga_nombre) as juga_nombre, ifnull(rp.rapo_tj,0) as draws_puntos, null, 'RJ'
										FROM (jugadores j, rankings r)
										  LEFT OUTER JOIN rankings_posiciones rp ON rp.rank_id = r.rank_id AND rp.juga_id = j.juga_id
										WHERE j.juga_id <> 111111
										 AND j.juga_id <> 999999
										 AND r.depo_id = $depo_id
										 AND r.rank_publicar = 'S'
										 AND r.rank_ano = $año
					)) y";
					
					
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
					
					$row = mysql_fetch_assoc($res);
					
					return $row['cant'];
					
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
				   
    }//fin get_ranking_detallado_cantidad

	function actualizar_puntos_ranking($rank_id){
	
			$sql = "call actualizar_ranking($rank_id)";
                                
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
	
}//fin clase rankings
?>