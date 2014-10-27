<?php

	require_once("../modelo/patrocinantes.php");
	require_once("ctrl_archivos.php");
	
	/*
	$numero = count($_POST);
	$tags = array_keys($_POST);// obtiene los nombres de las varibles
	$valores = array_values($_POST);// obtiene los valores de las varibles

	
	// crea las variables y les asigna el valor
	for($i=0;$i<$numero;$i++){
		echo $tags[$i]." : ".$valores[$i]."<br>";
	}
	*/
	
	if($_POST['opcion']=='guardar'){
	
		$publicar = $_POST['publicar'] == true ? 'S' : 'N';
		
		if($_POST['logo']!=''){
			
			$logo = $_POST['logo'];
			$logo = mover_archivo($logo,"../../art/patrocinantes/");
			
		}else{
			$logo = NULL;
		}
		
		$obj = new patrocinantes($_POST['patrocinante'],$_POST['nombre'],
							$logo,$publicar);
			

		if($obj->guardar()){
			
			//include("../vista/mod_modalidades.php");
			
		}

	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new patrocinantes('','','','');
		
		if($obj->eliminar($_POST['patrocinante'])){
			//include("../vista/mod_modalidades.php");
		}
		
	}else if($_GET['opcion']=='consulta'){
		
		$obj = new patrocinantes('','','','');
		$obj->get_patrocinante($_GET['patrocinante']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
		
	}
	
	
			
?>
