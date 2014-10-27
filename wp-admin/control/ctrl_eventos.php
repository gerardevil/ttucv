<?php

	require_once("../modelo/eventos.php");
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
	
	
	$datosTabla = json_decode((stripslashes($_POST['datosTabla'])));
	$datosPatr = json_decode((stripslashes($_POST['datosPatr'])));
	
	
	if($_POST['opcion']=='guardar'){
	
		
	
		$publicarhome = $_POST['publicarhome'] == true ? 'S' : 'N';
		$publicar = $_POST['publicar'] == true ? 'S' : 'N';
		$cerrado = $_POST['cerrado'] == true ? 'S' : 'N';
		
		if($_POST['afiche']!=''){
		
			$afiche = $_POST['afiche'];
			$afiche = mover_archivo($afiche,"../../art/eventos/");
		
		}else{
			$afiche = NULL;
		}

		
	
		$obj = new eventos($_POST['eventos'],$_POST['deportes'],$_POST['nombre'],
							$_POST['even_fecha'],$_POST['sede'],$_POST['ciudad'],
							$afiche,$publicarhome,NULL,$publicar);
		
		$obj->even_cerrado = $cerrado;
	
		$i = 1;
	
		foreach($datosTabla as $datosTabla_key => $datosTabla_info){

			$cerrado = $datosTabla_info[6] == true ? 'S' : 'N';
			$publicar = $datosTabla_info[7] == true ? 'S' : 'N';
		
		
			$obj->add_evento_modalidad(
						$datosTabla_info[5],
						$_POST['eventos'],//even_id
						$datosTabla_info[0],//moda_id
						$datosTabla_info[2],//premiacion a campeon
						$datosTabla_info[3],//premiacion a subcampeon
						$datosTabla_info[1],'','','',$cerrado,$publicar,$datosTabla_info[4]);//evmo_fecha, si esta cerrado y si esta publicado el draw
			
			
			$i++;

		}
		
		$i = 1;
		
		foreach($datosPatr as $datosPatr_key => $datosPatr_info){

			$obj->add_evento_patrocinante(
						$i,
						$_POST['eventos'],//even_id
						$datosPatr_info[0],//moda_id
						$i);//evmo_fecha
			
			
			$i++;

		}
		

		if($obj->guardar()){
			
			//include("../vista/mod_eventos.php");
			
		}

	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new eventos('','','','','','','','','','');
		
		if($obj->eliminar($_POST['eventos'])){
			//include("../vista/mod_eventos.php");
		}
		
	}else if($_GET['opcion']=='consulta'){
		
		$obj = new eventos('','','','','','','','','','');
		$obj->get_evento($_GET['eventos']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
		
	}
	
	
			
?>