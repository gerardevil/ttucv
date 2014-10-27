<?php

	require_once("../modelo/rankings.php");
	require_once("../modelo/draws.php");
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
	
	
	//$datosPos = json_decode((stripslashes($_POST['datosPos'])));
	$datosModa = json_decode((stripslashes($_POST['datosModa'])));
	$datosPatr = json_decode((stripslashes($_POST['datosPatr'])));
	
	
	if($_POST['opcion']=='guardar'){
	
		
	
		$publicar = $_POST['publicar'] == true ? 'S' : 'N';
		
		if($_POST['archivo']!=''){
		
			$archivo = $_POST['archivo'];
			$archivo = mover_archivo($archivo,"../../art/rankings/");
		
		}else{
			$archivo = NULL;
		}
		
		if($_POST['imagen']!=''){
		
			$imagen = $_POST['imagen'];
			$imagen = mover_archivo($imagen,"../../art/rankings/");
		
		}else{
			$imagen = NULL;
		}

		
	
		$obj = new rankings($_POST['ranking'],$_POST['deportes'],$_POST['nombre'],
							$_POST['ano'],$archivo,$imagen,$publicar);
	
	
		$i = 1;
		
		foreach($datosModa as $datosModa_key => $datosModa_info){

			$obj->add_ranking_modalidad(
						$_POST['ranking'],//rank_id
						$datosModa_info[0]);//moda_id
			
			$i++;

		}
	
		/*
		$i = 1;
		
		foreach($datosPos as $datosPos_key => $datosPos_info){

			$obj->add_ranking_posicion(
						$i,
						$_POST['ranking'],//rank_id
						$datosPos_info[1],//rapo_jugador
						$datosPos_info[2],//rapo_puntos
						$datosPos_info[3],//rapo_tj
						$datosPos_info[0]);//rapo_orden
			
			
			$i++;

		}
		*/
		
		$i = 1;

		foreach($datosPatr as $datosPatr_key => $datosPatr_info){

			if($datosPatr_info[1]!=''){
		
				$foto = $datosPatr_info[1];
				$foto = mover_archivo($foto,"../../art/rankings/");
			
			}else{
				$foto = NULL;
			}
		
			$publicar_foto = $datosPatr_info[2] == true ? 'S' : 'N';
		
			$obj->add_ranking_foto(
						$i,
						$_POST['ranking'],//rank_id
						$datosPatr_info[0],//rank_descripcion
						$foto,//rank_foto
						$publicar_foto);//rank_publicar

			
			
			$i++;

		}


		if($obj->guardar()){
			
			//include("../vista/mod_eventos.php");
			
		}

	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new rankings('','','','','','','');
		
		if($obj->eliminar($_POST['ranking'])){
			//include("../vista/mod_eventos.php");
		}
		
	}else if($_GET['opcion']=='actualizar'){
		
		// $obj = new draws('','','','','','','','','','');
		// $obj->calcular_puntos(2013);
		
		$obj = new rankings('','','','','','','');
		$obj->actualizar_puntos_ranking($_GET['ranking']);
		
	}else if($_GET['opcion']=='consulta'){
		
		$obj = new rankings('','','','','','','');
		$obj->get_ranking($_GET['ranking']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
		
	}
	
	
			
?>