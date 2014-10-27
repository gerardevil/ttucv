<?php

require_once("modelo.php");
	

class jornadas_juegos extends modelo{

           public  $juego_id;
		   public  $jorn_id;
		   public  $interconf_id;
		   public  $juga_id1;
		   public  $juga_id2;
		   public  $juga_id3;
		   public  $juga_id4;
		   public  $juego_ganador;
		   public  $juego_score;
		   public  $juego_fecha;
    
	 function __construct($juego_id,$jorn_id,$interconf_id,$juga_id1,$juga_id2,$juga_id3,$juga_id4,$juego_ganador,$juego_score,$juego_fecha){
	 
			parent::__construct();
	 
			$this->juego_id = $juego_id;
			$this->jorn_id = $jorn_id;
			$this->interconf_id = $interconf_id;
		
			if($juga_id1 == ''){
				$this->juga_id1 = 'null';
			}else{
				$this->juga_id1 = $juga_id1;
			}
			
			if($juga_id2 == ''){
				$this->juga_id2 = 'null';
			}else{
				$this->juga_id2 = $juga_id2;
			}
			
			if($juga_id3 == ''){
				$this->juga_id3 = 'null';
			}else{
				$this->juga_id3 = $juga_id3;
			}
			
			if($juga_id4 == ''){
				$this->juga_id4 = 'null';
			}else{
				$this->juga_id4 = $juga_id4;
			}
			
			if($juego_ganador == ''){
				$this->juego_ganador = 'null';
			}else{
				$this->juego_ganador = $juego_ganador;
			}
			
			if($juego_score == ''){
				$this->juego_score = 'null';
			}else{
				$this->juego_score = "'".$juego_score."'";
			}
			
			if($juego_fecha == ''){
				$this->juego_fecha = 'null';
			}else{
				$this->juego_fecha = "'".$juego_fecha."'";
			}

	 }//fin constructor
	 
	 
	 function guardar(){
				
			if($this->juego_id==''){
				
				$sql = "INSERT INTO jornadas_juegos (jorn_id,interconf_id,juga_id1,juga_id2,juga_id3,juga_id4,juego_ganador,juego_score,juego_fecha)"
					." VALUES ($this->jorn_id,$this->interconf_id,$this->juga_id1,$this->juga_id2,"
					."$this->juga_id3,$this->juga_id4,$this->juego_ganador,$this->juego_score,$this->juego_fecha)";
                
			}else{
				$sql = "UPDATE jornadas_juegos "
					." SET jorn_id=$this->jorn_id,"
					." interconf_id=$this->interconf_id,juga_id1=$this->juga_id1,juga_id2=$this->juga_id2,juga_id3=$this->juga_id3,"
					." juga_id4=$this->juga_id4,juego_ganador=$this->juego_ganador,juego_score=$this->juego_score,juego_fecha=$this->juego_fecha"
					." WHERE juego_id = $this->juego_id";
			}
			
			//echo $sql.'<br>';
			
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
	
	
	 
	 function get_jornada_juego($juego_id){
			
			
			$sql = "SELECT * FROM jornadas_juegos WHERE juego_id = $id";
			
			include($this->archivo_conexion);
			
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
			
						$this->juego_id = $row['juego_id'];
						$this->jorn_id = $row['jorn_id'];
						$this->interconf_id = $row['interconf_id'];
						$this->juga_id1 = $row['juga_id1'];
						$this->juga_id2 = $row['juga_id2'];
						$this->juga_id3 = $row['juga_id3'];
						$this->juga_id4 = $row['juga_id4'];
						$this->juego_ganador = $row['juego_ganador'];
						$this->juego_score = $row['juego_score'];
						$this->juego_fecha = $row['juego_fecha'];
									
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
	
	
	
	function get_all_jornadas_juegos($jorn_id){
				
			$sql = "SELECT * 
					FROM jornadas_juegos
					WHERE jorn_id = $jorn_id
					ORDER BY juego_fecha ASC";
                                
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
	
			$sql = "DELETE FROM jornadas_juegos WHERE juego_id = $id";
                                
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

}//fin clase jornadas_juegos
?>