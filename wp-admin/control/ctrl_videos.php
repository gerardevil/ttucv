<?php

	require_once("../modelo/videos.php");
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
	
	
	if($_POST['opcion_video']=='guardar'){
	
		
	
		$publicar = $_POST['publicar_video'] == true ? 'S' : 'N';
		
		//$codigo = '<iframe width="215" height="139" src="'.$_POST['url'].'" frameborder="0" allowfullscreen></iframe>';
		$codigo = $_POST['url'];
	
		$obj = new videos($_POST['video'],$_POST['deportes_video'],$_POST['nombre_video'],
						$_POST['fecha_video'],$codigo,$publicar);
	/*
		$i = 1;
	
		foreach($datosTabla as $datosTabla_key => $datosTabla_info){

			$obj->add_evento_modalidad(
						$i,
						$_POST['eventos'],//even_id
						$datosTabla_info[0],//moda_id
						$datosTabla_info[2],//premiacion a campeon
						$datosTabla_info[3],//premiacion a subcampeon
						$datosTabla_info[1]);//evmo_fecha
			
			
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
		*/

		if($obj->guardar()){
			
			//include("../vista/mod_eventos.php");
			
		}

	}else if($_POST['opcion_video']=='eliminar'){
		
		$obj = new videos('','','','','','');
		
		if($obj->eliminar($_POST['video'])){
			//include("../vista/mod_eventos.php");
		}
		
	}else if($_GET['opcion_video']=='consulta'){
		
		$obj = new videos('','','','','','');
		$obj->get_video($_GET['video']);
		
		//$obj->vide_codigo = str_replace('<iframe width="215" height="139" src="','',$obj->vide_codigo);
		//$obj->vide_codigo = str_replace('" frameborder="0" allowfullscreen></iframe>','',$obj->vide_codigo);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
		
	}
	
	
			
?>