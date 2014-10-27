<?php

require_once("modelo.php");

class interclubes_juegos_config extends modelo{

		   public  $interconf_id;
           public  $inter_id;
		   public  $interconf_sexo;
		   public  $interconf_tipo;
		   public  $interconf_puntaje_juego_ganado;
		   public  $interconf_categoria;
		   public  $interconf_puntaje_juego_perdido;
		   public  $interconf_puntaje_juego_wo;
    
	 function __construct($interconf_id,$inter_id,$interconf_sexo,$interconf_tipo,$interconf_puntaje_juego_ganado,$interconf_categoria,
					$interconf_puntaje_juego_perdido,$interconf_puntaje_juego_wo){
	 
			parent::__construct();
			
			$this->interconf_id = $interconf_id;
			$this->inter_id = $inter_id;
			$this->interconf_sexo = $interconf_sexo;
			$this->interconf_tipo = $interconf_tipo;
			$this->interconf_puntaje_juego_ganado = $interconf_puntaje_juego_ganado;
			
			$this->interconf_categoria = $interconf_categoria;
			$this->interconf_puntaje_juego_perdido = $interconf_puntaje_juego_perdido;
			$this->interconf_puntaje_juego_wo = $interconf_puntaje_juego_wo;
			


	 }//fin constructor
	 
	 
	 
	 function guardar(){
			
			if($this->interconf_categoria == ''){
				$this->interconf_categoria = 'NULL';
			}else{
				$this->interconf_categoria = "'".$this->interconf_categoria."'";
			}
			
			if($this->interconf_id==''){
				$sql = "INSERT INTO interclubes_juegos_config (inter_id,interconf_sexo,interconf_tipo,interconf_puntaje_juego_ganado,interconf_categoria,interconf_puntaje_juego_perdido,interconf_puntaje_juego_wo) "
					." VALUES ($this->inter_id,'$this->interconf_sexo','$this->interconf_tipo',$this->interconf_puntaje_juego_ganado,$this->interconf_categoria,$this->interconf_puntaje_juego_perdido,$this->interconf_puntaje_juego_wo)";
            }else{
				$sql = "UPDATE interclubes_juegos_config "
					." SET inter_id = $this->inter_id, interconf_sexo = '$this->interconf_sexo',interconf_tipo = '$this->interconf_tipo',"
					." interconf_puntaje_juego_ganado = $this->interconf_puntaje_juego_ganado, interconf_categoria = $this->interconf_categoria,"
					." interconf_puntaje_juego_perdido = $this->interconf_puntaje_juego_perdido, interconf_puntaje_juego_wo = $this->interconf_puntaje_juego_wo"
					." WHERE interconf_id = $this->interconf_id";
			}

			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			   
				   //echo "<br>Operación realizada satisfactoriamente.<br>";
				   return true;
			   }else{
			   
				   echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin guardar_data
	
	
	 
	 function get_juego_config($id){
				
			$sql = "SELECT * FROM interclubes_juegos_config WHERE interconf_id = ".$id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_juego_config
	
	function get_all_inter_juegos($inter_id){
				
			$sql = "SELECT *
					FROM interclubes_juegos_config
					WHERE inter_id = ".$inter_id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_all_inter_juegos
	
	function eliminar_all_inter_juegos($inter_id){
	
			$sql = "DELETE FROM interclubes_juegos_config WHERE inter_id = ".$inter_id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					return true;
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				mysql_close($conexion);
	}

}//fin clase interclubes_juegos_config
?>