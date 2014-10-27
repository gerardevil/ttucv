<?php

require_once("modelo.php");

class transacciones_pagos extends modelo{

		   public  $tran_id;
           public  $tran_fecha;
		   public  $tran_concepto;
		   public  $tran_monto;
		   public  $tran_estatus;
		   public  $juga_id;
    
	 function __construct($tran_id,$tran_fecha,$tran_concepto,$tran_monto,$tran_estatus,$juga_id){
	 
			parent::__construct();
	 
			$this->tran_id = $tran_id;
			$this->tran_fecha = $tran_fecha;
			$this->tran_concepto = $tran_concepto;
			$this->tran_monto = $tran_monto;
			$this->tran_estatus = $tran_estatus;
			if($juga_id != ""){
				$this->juga_id = $juga_id;
			}else{
				$this->juga_id = "NULL";
			}

	 }//fin constructor
	 
	 
	 
	 function guardar(){
	 
			if($this->tran_id==''){
				
				$sql = "INSERT INTO transacciones_pagos (tran_fecha,tran_concepto,tran_monto,tran_estatus,juga_id)"
					." VALUES(str_to_date('$this->tran_fecha','%d/%m/%Y %H:%i:%s'),'$this->tran_concepto',$this->tran_monto,'$this->tran_estatus',$this->juga_id)";
                
			}else{
				$sql = "UPDATE transacciones_pagos "
					." SET tran_fecha=str_to_date('$this->tran_fecha','%d/%m/%Y %H:%i:%s'), tran_concepto='$this->tran_concepto',"
					." tran_monto=$this->tran_monto,tran_estatus='$this->tran_estatus',juga_id=$this->juga_id"
					." WHERE tran_id = $this->tran_id";
			}

			include($this->archivo_conexion);
						
				if($res = mysql_query($sql,$conexion)){// valido si se realizo el query
			   
				   //echo "<br>Operación realizada satisfactoriamente.<br>";
				    if($this->tran_id == ''){
						$this->tran_id = mysql_insert_id();
				    }
					
					return $this->tran_id;
					
			   }else{
			   
				   echo "<br>No se pudo realizar la operación por el siguiente error:<br>";
				   echo "<br>".mysql_error().".<br>";
					return false;
			   
			   }// fin if del query if($res = mysql_query($sql))

				   mysql_close($conexion);
		  
    }//fin guardar_data
	 
	 
}