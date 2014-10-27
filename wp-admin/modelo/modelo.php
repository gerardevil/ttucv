<?php


class modelo{

	protected  $archivo_conexion;

			   
	public function __construct(){


		if(file_exists('../../Connections/conexion.php')){
			$this->archivo_conexion = '../../Connections/conexion.php';
		}else if(file_exists('../Connections/conexion.php')){
			$this->archivo_conexion = '../Connections/conexion.php';
		}else if(file_exists('Connections/conexion.php')){
			$this->archivo_conexion = 'Connections/conexion.php';	
		}else{
			die('No se encontro el archivo de conexi&oacute;n');
		}


	}//fin constructor

}



?>