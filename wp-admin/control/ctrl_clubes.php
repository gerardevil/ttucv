<?php

	require_once("../modelo/clubes.php");
	
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
		
		$obj = new clubes($_POST['club_id'],$_POST['nombre_club']);
			

		if($obj->guardar()){
			
			//include("../vista/mod_modalidades.php");
			
		}

	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new clubes('','');
		
		if($obj->eliminar($_POST['club_id'])){
			//include("../vista/mod_modalidades.php");
		}
		
	}else if($_GET['opcion']=='consulta'){
	
		$obj = new clubes('','');
		$obj->get_club($_GET['club']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
	
	}
	
	
			
?>
