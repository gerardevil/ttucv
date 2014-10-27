<?php

require_once("modelo.php");

class inscripciones_eventos extends modelo{

		   public  $evmo_id;
           public  $juga_id1;
		   public  $juga_id2;
		   public  $inev_fecha_insc;
		   public  $inev_estatus;
    
	 function __construct($evmo_id,$juga_id1,$juga_id2,$inev_fecha_insc,$inev_estatus){
	 
			parent::__construct();
	 
			$this->evmo_id = $evmo_id;
			$this->juga_id1 = $juga_id1;
			$this->juga_id2 = $juga_id2;
			$this->inev_fecha_insc = $inev_fecha_insc;
			$this->inev_estatus = $inev_estatus;


	 }//fin constructor
	 
	 
	 
	 function guardar(){
				
			$sql = "INSERT INTO inscripciones_eventos (evmo_id,juga_id1,juga_id2,inev_fecha_insc,inev_estatus) "
					." VALUES($this->evmo_id,$this->juga_id1,$this->juga_id2,str_to_date('$this->inev_fecha_insc','%d/%m/%Y %H:%i:%s'),'$this->inev_estatus')"
					." ON DUPLICATE KEY UPDATE "
					." 			evmo_id=$this->evmo_id,juga_id1=$this->juga_id1,juga_id2=$this->juga_id2,"
					."			inev_fecha_insc=str_to_date('$this->inev_fecha_insc','%d/%m/%Y %H:%i:%s'),inev_estatus='$this->inev_estatus'";
					

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
	
	
	
	function guardarPago($evmo_id,$juga_id1,$inpa_fecha,$inpa_monto1,$inpa_estatus1,$inpa_monto2,$inpa_estatus2){
				
			$sql = "INSERT INTO inscripciones_pagos (evmo_id,juga_id1,inpa_fecha,inpa_monto1,inpa_estatus1,inpa_monto2,inpa_estatus2) "
					." VALUES($evmo_id,$juga_id1,str_to_date('$inpa_fecha','%d/%m/%Y %H:%i:%s'),$inpa_monto1,'$inpa_estatus1',$inpa_monto2,'$inpa_estatus2')"
					." ON DUPLICATE KEY UPDATE "
					." 			evmo_id=$evmo_id,juga_id1=$juga_id1,inpa_fecha=str_to_date('$inpa_fecha','%d/%m/%Y %H:%i:%s'),"
					."			inpa_monto1=$inpa_monto1,inpa_estatus1='$inpa_estatus1', "
					." 			inpa_monto2=$inpa_monto2,inpa_estatus2='$inpa_estatus2'";
					

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
	}
	
	
	function eliminarPagos($evmo_id,$juga_id){
	
		$sql = "DELETE FROM inscripciones_pagos WHERE evmo_id  = ".$evmo_id." AND juga_id = ".$juga_id;
                                
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
	
	 
	 function get_inscripcion($id,$juga_id){
				
			$sql = "SELECT * FROM inscripciones_eventos WHERE evmo_id = ".$id." AND juga_id1 = ".$juga_id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento
	
	function get_all_moda_inscripciones($evmo_id, $inev_estatus, $orden, $filtro){
				
			$sql = "SELECT ie.evmo_id, ie.juga_id1, ie.juga_id2, date_format(ie.inev_fecha_insc,'%d/%m/%Y %H:%i:%s') as inev_fecha_insc
							, ie.inev_estatus, j1.juga_nombre as juga1_nombre, ifnull(j1.juga_apellido,'') as juga1_apellido, ifnull(j1.juga_email,'') as juga1_email,  
							j2.juga_nombre as juga2_nombre, ifnull(j2.juga_apellido,'') as juga2_apellido, ifnull(j2.juga_email,'') as juga2_email,
							m.moda_tipo, inpa_monto1, inpa_estatus1, inpa_monto2, inpa_estatus2
					FROM inscripciones_eventos ie 
						JOIN eventos_modalidades em ON em.evmo_id = ie.evmo_id
						JOIN modalidades m ON m.moda_id = em.moda_id
						JOIN jugadores j1 ON j1.juga_id = ie.juga_id1
						LEFT OUTER JOIN jugadores j2 ON j2.juga_id = ifnull(ie.juga_id2,0)
						LEFT OUTER JOIN inscripciones_pagos ip ON ip.evmo_id = ie.evmo_id AND ip.juga_id1 = ie.juga_id1
					WHERE ie.evmo_id = ".$evmo_id;
					
			if($inev_estatus != ''){
				$sql = $sql." AND ie.inev_estatus = '".$inev_estatus."'"; 
			}
			
			if($filtro != ''){
				if(is_numeric($filtro)){
					$sql = $sql." AND (ie.juga_id1 LIKE '%".$filtro."%' OR ie.juga_id2 LIKE '%".$filtro."%')";
				}else{
					$sql = $sql." AND (j1.juga_nombre LIKE '%".$filtro."%' OR ifnull(j1.juga_apellido,'') LIKE '%".$filtro."%'";
					$sql = $sql." OR j2.juga_nombre LIKE '%".$filtro."%' OR ifnull(j2.juga_apellido,'') LIKE '%".$filtro."%')";
				}
			}
			
			switch($orden){
				case 'cedula': 
					$sql = $sql." ORDER BY juga_id1, juga_id2 DESC";
					break;
				case 'nombre': 
					$sql = $sql." ORDER BY juga1_apellido, juga1_nombre, juga2_apellido, juga2_nombre DESC";
					break;
				default: 
					$sql = $sql." ORDER BY DATE_FORMAT(inev_fecha_insc,'%Y %m %d %H:%i:%s') DESC";
					break;
			
			}
					
								
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento
	
	function get_insc_pagos_pendientes($juga_id, $inev_estatus, $orden, $inpa_estatus){
				
			$sql = "SELECT ie.evmo_id, ie.juga_id1, ie.juga_id2, date_format(ie.inev_fecha_insc,'%d/%m/%Y %H:%i:%s') as inev_fecha_insc
							, ie.inev_estatus, j1.juga_nombre as juga1_nombre, ifnull(j1.juga_apellido,'') as juga1_apellido, ifnull(j1.juga_email,'') as juga1_email,  
							j2.juga_nombre as juga2_nombre, ifnull(j2.juga_apellido,'') as juga2_apellido, ifnull(j2.juga_email,'') as juga2_email,
							m.moda_tipo, m.moda_nombre, inpa_monto1, inpa_estatus1, inpa_monto2, inpa_estatus2, e.even_nombre
					FROM inscripciones_eventos ie 
						JOIN eventos_modalidades em ON em.evmo_id = ie.evmo_id
						JOIN modalidades m ON m.moda_id = em.moda_id
						JOIN eventos e ON e.even_id = em.even_id
						JOIN jugadores j1 ON j1.juga_id = ie.juga_id1
						JOIN inscripciones_pagos ip ON ip.evmo_id = ie.evmo_id AND ip.juga_id1 = ie.juga_id1
						LEFT OUTER JOIN jugadores j2 ON j2.juga_id = ifnull(ie.juga_id2,0)";
			


			$sql = $sql." WHERE ((ie.juga_id1 = ".$juga_id." AND inpa_estatus1 in (".$inpa_estatus.")) OR (ie.juga_id2 = ".$juga_id." AND inpa_estatus2 IN (".$inpa_estatus.")))";
			
			if($inev_estatus != ''){
				$sql = $sql." AND ie.inev_estatus = '".$inev_estatus."'"; 
			}

			
			switch($orden){
				case 'cedula': 
					$sql = $sql." ORDER BY juga_id1, juga_id2 DESC";
					break;
				case 'nombre': 
					$sql = $sql." ORDER BY juga1_apellido, juga1_nombre, juga2_apellido, juga2_nombre DESC";
					break;
				default: 
					$sql = $sql." ORDER BY DATE_FORMAT(inev_fecha_insc,'%Y %m %d %H:%i:%s') DESC";
					break;
			
			}
			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento
	
	function get_inscripcion_pago($evmo_id, $juga_id1){
				
			$sql = "SELECT ie.evmo_id, ie.juga_id1, ie.juga_id2, date_format(ie.inev_fecha_insc,'%d/%m/%Y %H:%i:%s') as inev_fecha_insc
							, ie.inev_estatus, j1.juga_nombre as juga1_nombre, ifnull(j1.juga_apellido,'') as juga1_apellido, ifnull(j1.juga_email,'') as juga1_email,  
							j2.juga_nombre as juga2_nombre, ifnull(j2.juga_apellido,'') as juga2_apellido, ifnull(j2.juga_email,'') as juga2_email,
							m.moda_tipo, m.moda_nombre, inpa_monto1, inpa_estatus1, inpa_monto2, inpa_estatus2
					FROM inscripciones_eventos ie 
						JOIN eventos_modalidades em ON em.evmo_id = ie.evmo_id
						JOIN modalidades m ON m.moda_id = em.moda_id
						JOIN jugadores j1 ON j1.juga_id = ie.juga_id1
						LEFT OUTER JOIN jugadores j2 ON j2.juga_id = ifnull(ie.juga_id2,0)
						LEFT OUTER JOIN inscripciones_pagos ip ON ip.evmo_id = ie.evmo_id AND ip.juga_id1 = ie.juga_id1
					WHERE ie.evmo_id = ".$evmo_id." AND ie.juga_id1 = ".$juga_id1;
					
			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
					
					if($row = mysql_fetch_assoc($res)){
						return $row;
				    }else{
						echo "<br>No se encontro el registro<br>";
						return false;
					}
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento
	
	
	function tiene_pagos_pendientes($juga_id){
				
			$sql = "SELECT count(ie.evmo_id) as cant
					FROM inscripciones_eventos ie 
						JOIN eventos_modalidades em ON em.evmo_id = ie.evmo_id
						JOIN modalidades m ON m.moda_id = em.moda_id
						JOIN eventos e ON e.even_id = em.even_id
						JOIN jugadores j1 ON j1.juga_id = ie.juga_id1
						JOIN inscripciones_pagos ip ON ip.evmo_id = ie.evmo_id AND ip.juga_id1 = ie.juga_id1
						LEFT OUTER JOIN jugadores j2 ON j2.juga_id = ifnull(ie.juga_id2,0)";

						
			$sql = $sql." WHERE ((ie.juga_id1 = ".$juga_id." AND inpa_estatus1 in ('I','E')) OR (ie.juga_id2 = ".$juga_id." AND inpa_estatus2 IN ('I','E')))";
			
			if($inev_estatus != ''){
				$sql = $sql." AND ie.inev_estatus = 'I'"; 
			}
			
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
					
					if($row = mysql_fetch_assoc($res)){
				   
						if($row['cant'] > 0){
						
							return true;
						
						}
				   
					}
			   
			   }else{
			   
					echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
					echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				mysql_close($conexion);
				return false;
		  
    }//fin get_evento
	
	
	function get_all_even_inscripciones($even_id){
				
			$sql = "SELECT ie.*, m.moda_nombre, moda_sexo, moda_tipo 
					FROM eventos_modalidades em JOIN modalidades m ON m.moda_id = em.moda_id JOIN inscripciones_eventos ie ON ie.evmo_id = em.evmo_id
					WHERE em.even_id = ".$even_id;
                                
			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			
				   return $res;
			   
			   }else{
			   
				   echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin get_evento
	
	function eliminar_all_even_inscripciones($even_id){
	
			$sql = "DELETE FROM inscripciones_eventos WHERE evmo_id in (SELECT evmo_id FROM eventos_modalidades WHERE even_id = ".$even_id.")";
                                
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
	
	
	function eliminar_all_inscripciones($evmo_id){
	
			$sql = "DELETE FROM inscripciones_eventos WHERE evmo_id  = ".$evmo_id;
                                
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
	
	function eliminar_inscripcion($evmo_id, $juga_id){
	
			$sql = "DELETE FROM inscripciones_eventos WHERE evmo_id  = ".$evmo_id." AND juga_id1 = ".$juga_id;
                                
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

}//fin clase eventos
?>