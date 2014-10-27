<?php

	require_once("../modelo/modalidades.php");
	
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
		
		$obj = new modalidades($_POST['modalidad'],$_POST['deportes'],$_POST['nombre'],
							$_POST['abreviatura'],$_POST['sexo'],$publicar,$_POST['tipo']);
			

		if($obj->guardar()){
			
			//include("../vista/mod_modalidades.php");
			
		}

	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new modalidades('','','','','','','');
		
		if($obj->eliminar($_POST['modalidad'])){
			//include("../vista/mod_modalidades.php");
		}
		
	}else if($_GET['opcion']=='consulta'){
	
		$obj = new modalidades('','','','','','','');
		$obj->get_modalidad($_GET['modalidad']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
	
	}
	
	
			
?>
