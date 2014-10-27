<?php

require_once("modelo.php");

class eventos_modalidades extends modelo{

		   public  $evmo_id;
           public  $even_id;
		   public  $moda_id;
		   public  $evmo_premiacion;
		   public  $evmo_subcampeon;
		   public  $evmo_fecha;
		   public  $moda_nombre;
		   public  $moda_sexo;
		   public  $moda_tipo;
		   public  $evmo_cerrado;
		   public  $evmo_publicar_draw;
		   public  $evmo_costo_inscripcion;
    
	 function __construct($evmo_id,$even_id,$moda_id,$evmo_premiacion,$evmo_subcampeon,$evmo_fecha){
	 
			parent::__construct();
			
			$this->evmo_id = $evmo_id;
			$this->even_id = $even_id;
			$this->moda_id = $moda_id;
			$this->evmo_premiacion = $evmo_premiacion;
			$this->evmo_subcampeon = $evmo_subcampeon;
			$this->evmo_fecha = $evmo_fecha;
			$this->evmo_cerrado = 'N';
			$this->evmo_publicar_draw = 'N';
			$this->evmo_costo_inscripcion = 0;


	 }//fin constructor
	 
	 
	 
	 function guardar(){
			
			if($this->evmo_id==''){
				$sql = "INSERT INTO eventos_modalidades (even_id,moda_id,evmo_premiacion,evmo_subcampeon,evmo_fecha,evmo_cerrado,evmo_publicar_draw,evmo_costo_inscripcion) "
					." VALUES($this->even_id,'$this->moda_id','$this->evmo_premiacion','$this->evmo_subcampeon',str_to_date('$this->evmo_fecha','%d/%m/%Y'),'$this->evmo_cerrado','$this->evmo_publicar_draw',$this->evmo_costo_inscripcion)";
            }else{
				$sql = "INSERT INTO eventos_modalidades (evmo_id,even_id,moda_id,evmo_premiacion,evmo_subcampeon,evmo_fecha,evmo_cerrado,evmo_publicar_draw,evmo_costo_inscripcion) "
					." VALUES($this->evmo_id,$this->even_id,'$this->moda_id','$this->evmo_premiacion','$this->evmo_subcampeon',str_to_date('$this->evmo_fecha','%d/%m/%Y'),'$this->evmo_cerrado','$this->evmo_publicar_draw',$this->evmo_costo_inscripcion)";
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
	
	
	 
	 function get_evento($id){
				
			$sql = "SELECT * FROM eventos_modalidades WHERE evmo_id = ".$id;
                                
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
	
	function get_all_even_modalidades($even_id){
				
			$sql = "SELECT em.*, m.moda_nombre, moda_sexo, moda_tipo 
					FROM eventos_modalidades em JOIN modalidades m ON m.moda_id = em.moda_id 
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
	
	function eliminar_all_even_modalidades($even_id){
	
			$sql = "DELETE FROM eventos_modalidades WHERE even_id = ".$even_id;
                                
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