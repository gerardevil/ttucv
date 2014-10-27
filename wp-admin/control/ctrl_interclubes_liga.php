<?php

	require_once("../modelo/interclubes_liga.php");
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
	
	
	$datosPatr = json_decode((stripslashes($_POST['datosPatr'])));
	
	
	if($_POST['opcion']=='guardar'){
	
		
	
		$publicar = $_POST['publicar'] == true ? 'S' : 'N';
		$cerrado = $_POST['cerrado'] == true ? 'S' : 'N';

		
		if($_POST['afiche']!=''){
		
			$afiche = $_POST['afiche'];
			$afiche = mover_archivo($afiche,"../../art/interclubes/");
		
		}else{
			$afiche = NULL;
		}
		
	
		$obj = new interclubes_liga($_POST['liga'],$_POST['nombre'],
							$_POST['fecha'],$publicar,$cerrado,$afiche);
		
		

		
		foreach($datosPatr as $datosPatr_key => $datosPatr_info){

			$obj->add_liga_patrocinante(
						$_POST['liga'],//liga_id
						$datosPatr_info[0]);//patr_id


		}
		
		
		if($obj->guardar()){
			
			
			
		}

	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new interclubes_liga('','','','','','');
		
		if($obj->eliminar($_POST['liga'])){
			//include("../vista/mod_eventos.php");
		}
		
	}else if($_GET['opcion']=='consulta'){
		
		$obj = new interclubes_liga('','','','','','');
		$obj->get_interclubes_liga($_GET['liga']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
		
	}
	
	
			
?>