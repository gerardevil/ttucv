<?php

require_once("modelo.php");

class rating_juegos_hist extends modelo{

           public  $rajue_id;
		   public  $rajue_fecha;
		   public  $juga_id1;
		   public  $juga_id2;
		   public  $juga_id3;
		   public  $juga_id4;
		   public  $juga1_puntos_ant;
		   public  $juga2_puntos_ant;
		   public  $juga3_puntos_ant;
		   public  $juga4_puntos_ant;
		   public  $rajue_ganador;
		   public  $rajue_peso;
		   public  $rajue_esperado;
		   public  $rajue_ajuste;
		   public  $raconf_id;
		   public  $rajue_score;
		   public  $rajue_nombre_torneo;
		   public  $rajue_modalidad_torneo;
		   
		   
	 function __construct($rajue_id,$rajue_fecha,$juga_id1,$juga_id2,$juga_id3,$juga_id4,$juga1_puntos_ant,$juga2_puntos_ant
					,$juga3_puntos_ant,$juga4_puntos_ant,$rajue_ganador,$rajue_peso,$rajue_esperado,$rajue_ajuste,$raconf_id
					,$rajue_score,$rajue_nombre_torneo,$rajue_modalidad_torneo){
	 
			parent::__construct();
	 
			$this->rajue_id = $rajue_id;
			$this->rajue_fecha = $rajue_fecha;
			$this->juga_id1 = $juga_id1;
			$this->juga_id2 = $juga_id2;
			$this->juga_id3 = $juga_id3;
			$this->juga_id4 = $juga_id4;
			$this->juga1_puntos_ant = $juga1_puntos_ant;
			$this->juga2_puntos_ant = $juga2_puntos_ant;
			$this->juga3_puntos_ant = $juga3_puntos_ant;
			$this->juga4_puntos_ant = $juga4_puntos_ant;
			$this->rajue_ganador = $rajue_ganador;
			$this->rajue_peso = $rajue_peso;
			$this->rajue_esperado = $rajue_esperado;
			$this->rajue_ajuste = $rajue_ajuste;
			$this->raconf_id = $raconf_id;
			$this->rajue_score = $rajue_score;
			$this->rajue_nombre_torneo = $rajue_nombre_torneo;
			$this->rajue_modalidad_torneo = $rajue_modalidad_torneo;
			
			
	 }//fin constructor
	 
	 
	 function guardar(){

			if($this->rajue_id==''){
				
				$sql = "INSERT INTO rating_juegos_hist (rajue_fecha,juga_id1,juga_id2,juga_id3,juga_id4,juga1_puntos_ant,juga2_puntos_ant
							,juga3_puntos_ant,juga4_puntos_ant,rajue_ganador,rajue_peso,rajue_esperado,rajue_ajuste,raconf_id,rajue_score,rajue_nombre_torneo,rajue_modalidad_torneo)"
						." VALUES('$this->rajue_fecha',$this->juga_id1,$this->juga_id2,$this->juga_id3,$this->juga_id4,$this->juga1_puntos_ant,$this->juga2_puntos_ant,
							$this->juga3_puntos_ant,$this->juga4_puntos_ant,$this->rajue_ganador,$this->rajue_peso,$this->rajue_esperado,$this->rajue_ajuste,$this->raconf_id,
							'$this->rajue_score','$this->rajue_nombre_torneo','$this->rajue_modalidad_torneo')";
                
			}else{
			
				$sql = "UPDATE rating_juegos_hist "
						." SET rajue_fecha='$this->rajue_fecha',juga_id1=$this->juga_id1, juga_id2=$this->juga_id2, juga_id3=$this->juga_id3, juga_id4=$this->juga_id4, juga1_puntos_ant=$this->juga1_puntos_ant,"
						."juga2_puntos_ant=$this->juga2_puntos_ant,juga3_puntos_ant=$this->juga3_puntos_ant,juga4_puntos_ant=$this->juga4_puntos_ant,rajue_ganador=$this->rajue_ganador, rajue_peso=$this->rajue_peso, rajue_esperado=$this->rajue_esperado,
						  raconf_id=$this->raconf_id,rajue_score='$this->rajue_score',rajue_nombre_torneo='$this->rajue_nombre_torneo',rajue_modalidad_torneo='$this->rajue_modalidad_torneo'"
						." WHERE rajue_id = $this->rajue_id";
			}
			
			//echo $sql."<br>";
			
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			   
				   //echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				   return true;
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
				   die();
			
				   return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin guardar
	
	
	 
	 function get_rating_juegos_hist($id){
				
			$sql = "SELECT * FROM rating_juegos_hist WHERE rajue_id = ".$id;
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   if($row = mysql_fetch_assoc($res)){

						$this->rajue_id = $row['rajue_id'];
						$this->rajue_fecha = $row['rajue_fecha'];
						$this->juga_id1 = $row['juga_id1'];
						$this->juga_id2 = $row['juga_id2'];
						$this->juga_id3 = $row['juga_id3'];
						$this->juga_id4 = $row['juga_id4'];
						$this->juga1_puntos_ant = $row['juga1_puntos_ant'];
						$this->juga2_puntos_ant = $row['juga2_puntos_ant'];
						$this->juga3_puntos_ant = $row['juga3_puntos_ant'];
						$this->juga4_puntos_ant = $row['juga4_puntos_ant'];
						$this->rajue_ganador = $row['rajue_ganador'];
						$this->rajue_peso = $row['rajue_peso'];
						$this->rajue_esperado = $row['rajue_esperado'];
						$this->rajue_ajuste = $row['rajue_ajuste'];
						$this->raconf_id = $row['raconf_id'];
						$this->rajue_score = $row['rajue_score'];
						$this->rajue_nombre_torneo = $row['rajue_nombre_torneo'];
						$this->rajue_modalidad_torneo = $row['rajue_modalidad_torneo'];
								
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
	
	function get_all_rating_juegos_hist($raconf_id, $juga_id){
				
			$sql = "SELECT * FROM rating_juegos_hist";
			
			$sql = "SELECT rjh.*, j1.juga_nombre as juga1_nombre, j1.juga_apellido as juga1_apellido,
					 j2.juga_nombre as juga2_nombre, j2.juga_apellido as juga2_apellido,
					 j3.juga_nombre as juga3_nombre, j3.juga_apellido as juga3_apellido,
					 j4.juga_nombre as juga4_nombre, j4.juga_apellido as juga4_apellido
					FROM rating_juegos_hist rjh
					 JOIN jugadores j1 ON j1.juga_id = rjh.juga_id1
					 LEFT JOIN jugadores j2 ON j2.juga_id = rjh.juga_id2
					 JOIN jugadores j3 ON j3.juga_id = rjh.juga_id3
					 LEFT JOIN jugadores j4 ON j4.juga_id = rjh.juga_id4
					WHERE rjh.raconf_id = $raconf_id
					 AND (rjh.juga_id1 = $juga_id OR rjh.juga_id2 = $juga_id OR rjh.juga_id3 = $juga_id OR rjh.juga_id4 = $juga_id)
					ORDER BY rjh.rajue_fecha DESC";
                                
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_all_miscelaneos
	
	function eliminar($rajue_id){
	
			$sql = "DELETE FROM rating_juegos_hist WHERE rajue_id = ".$rajue_id;
                                
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
	
	function eliminar_all_rating_juegos_hist($raconf_id, $raju_fecha_corte){
	
			$sql = "DELETE FROM rating_juegos_hist WHERE raconf_id = $raconf_id AND rajue_fecha > '".$raju_fecha_corte."'";
                                
			//echo $sql.'<br>';
								
			 include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					//echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
					return true;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					die();
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
	}

}//fin clase eventos
?>