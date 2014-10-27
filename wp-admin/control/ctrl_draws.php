<?php

	require_once("../modelo/draws.php");
	//require_once("ctrl_archivos.php");
	
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
	
		$arrayDraws = json_decode((stripslashes($_POST['arrayDraws'])));
		
	
		$i = 1;
	
		$obj = new draws('','','','','','','','','','');
		$obj->eliminar_all_draws($_POST['evmo_id']);
	
		foreach($arrayDraws as $datosTabla_key => $datosTabla_info){

			$obj = new draws('',$datosTabla_info[0],$datosTabla_info[1],$datosTabla_info[2],
							$datosTabla_info[3],$datosTabla_info[4],$datosTabla_info[5],
							$datosTabla_info[6],$datosTabla_info[7],$datosTabla_info[8]);
		
			$obj->guardar();
			
			
			$i++;

		}
		
	}else if($_POST['opcion']=='eliminar'){
		/*
		$obj = new eventos('','','','','','','','','','');
		
		if($obj->eliminar($_POST['eventos'])){
			//include("../vista/mod_eventos.php");
		}
		*/
		
	}else if($_GET['opcion']=='consulta'){
		/*
		$obj = new eventos('','','','','','','','','','');
		$obj->get_evento($_GET['eventos']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
		*/
	}else if($_GET['opcion']=='calcular'){
		
		$obj = new draws('','','','','','','','','','');
		$obj->calcular_puntos_draw($_GET['evmo_id']);
		
	}else if($_GET['opcion']=='asignar'){
		
		$obj = new draws('','','','','','','','','','');
		$obj->asignar_puntos_ranking($_GET['evmo_id']);
		
	}
	
	
			
?>