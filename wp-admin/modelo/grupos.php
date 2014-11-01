<?php

require_once("modelo.php");

class grupos extends modelo{

           public  $grupo_id;
		   public  $grupo_nombre;
		   public  $evmo_id;
		   public  $datosJugadores;
		   
	function __construct($id,$grupo_nombre,$evmo_id,$datosJugadores){
	 
			parent::__construct();
	 
			$this->grupo_id = $id;
			$this->grupo_nombre = $grupo_nombre;
			$this->evmo_id = $evmo_id;
			$this->datosJugadores = $datosJugadores;
			
	 }//fin constructor
	 
	 
	 function guardar(){
				
			if($this->grupo_id==''){
				
				$sql = "INSERT INTO grupos (grupo_nombre,evmo_id)"
					." VALUES('$this->grupo_nombre',$this->evmo_id)";
                
			}else{
				$sql = "UPDATE grupos "
					." SET grupo_id=$this->grupo_id, grupo_nombre='$this->grupo_nombre',evmo_id=$this->evmo_id'"
					." WHERE grupo_id = $this->grupo_id";
			}
			
			
			include($this->archivo_conexion);
			
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
			        foreach($this->datosJugadores as $datosJugadores_key => $datosJugadores_info){
    					if($datosJugadores_info!=''){
    					    $sql ="INSERT INTO grupos_jugadores ()";
    						mysql_query($sql,$conexion);
    					}
    				}
    			
			    /*
					if($this->even_id != ''){
						$aux = new eventos_modalidades('','','','','','');
						$aux->eliminar_all_even_modalidades($this->even_id);
						
						$aux = new patrocinantes_eventos('','','','');
						$aux->eliminar_all_patrocinadores($this->even_id);
					}else{
						$this->even_id = mysql_insert_id();
					}
			   
					
			   
					foreach($this->even_modalidades as $key => $obj){
						$obj->even_id = $this->even_id;
						$obj->guardar();
					}
					
					foreach($this->even_patrocinantes as $key => $obj){
						$obj->even_id = $this->even_id;
						$obj->guardar();
					}
			   */
				   echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				   return true;
			   }else{
			   
				   echo "<br>No se pudo realizar la operaci&oacute;n por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin guardar_data
    
    
    
	 function get_grupo($id){
			
			
			$sql = "SELECT * FROM eventos WHERE even_id = $id";
			
			include($this->archivo_conexion);
			
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
					if($row = mysql_fetch_assoc($res)){
			
						$this->grupo_id = $row['grupo_id'];
						$this->grupo_nombre = $row['grupo_nombre'];
						$this->evmo_id = $row['evmo_id'];
						/*
						
						$aux = new eventos_modalidades('','','','','','');
						
						$res_moda =  $aux->get_all_even_modalidades($this->even_id);
									
						while($row_moda = mysql_fetch_assoc($res_moda)){
							$this->add_evento_modalidad($row_moda['evmo_id'],$row_moda['even_id'],
											$row_moda['moda_id'],$row_moda['evmo_premiacion'],
											$row_moda['evmo_subcampeon'],date("m/d/Y",strtotime($row_moda['evmo_fecha'])),
											$row_moda['moda_nombre'],$row_moda['moda_sexo'],$row_moda['moda_tipo'],$row_moda['evmo_cerrado'],
											$row_moda['evmo_publicar_draw'],$row_moda['evmo_costo_inscripcion']);
						}

						$aux = new patrocinantes_eventos('','','','');
						
						$res_patr =  $aux->get_all_even_patrocinantes($this->even_id);
									
						while($row_patr = mysql_fetch_assoc($res_patr)){
							$this->add_evento_patrocinante($row_patr['prev_id'],$row_patr['even_id'],
													$row_patr['patr_id'],$row_patr['prev_orden']);
						}
						
						
						$aux = new draws('','','','','','','','','','');
						
						$res_draw =  $aux->get_evento_draws($this->even_id);
									
						while($row_draw = mysql_fetch_assoc($res_draw)){
							$this->add_evento_draw($row_draw['evmo_id'],$row_draw['moda_nombre']);
						}
						*/
									
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
    
    
    	
    function get_all_grupos($evmo_id){
				
			$sql = "SELECT * FROM grupos WHERE evmo_id = ".$evmo_id;
                                
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
    
    function eliminar($grupo_id){
	
			$sql = "DELETE FROM grupos WHERE grupo_id = ".$grupo_id;
                                
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
	
	function eliminar_all_grupos($evmo_id){
	
			$sql = "DELETE FROM grupos WHERE evmo_id = ".$evmo_id;
                                
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
	
}