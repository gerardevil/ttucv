<?php

	require_once("../modelo/rating_config.php");
	require_once("../modelo/rating_juegos_hist.php");
	require_once("../modelo/rating_jugadores_hist.php");
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
	
	
	$datosPesos = json_decode((stripslashes($_POST['datosPesos'])));
	$datosCategorias = json_decode((stripslashes($_POST['datosCategorias'])));
	
	
	if($_POST['opcion']=='guardar'){
			
		$publicar = $_POST['publicar'] == true ? 'S' : 'N';
		
		$obj = new rating_config($_POST['rating'],$_POST['factor_movilidad'],$_POST['factor_puntos'],
						$_POST['fecha_ult_corte'],$publicar,$_POST['nombre'],$_POST['sexo'],$_POST['tipo']);
	
		$i = 1;
	
		foreach($datosPesos as $datosPesos_key => $datosPesos_info){
		
			$obj->add_rating_pesos_config(
						'',
						$_POST['rating'],//raconf_id
						$datosPesos_info[0],//raconf_nombre
						$datosPesos_info[1]);//raconf_peso
			
			$i++;

		}
		
		$i = 1;
		
		foreach($datosCategorias as $datosCategorias_key => $datosCategorias_info){

			$obj->add_rating_categoria_config(
						'',
						$_POST['rating'],
						$datosCategorias_info[1],//raconf_puntos_min
						$datosCategorias_info[2],//raconf_puntos_max
						$datosCategorias_info[0]);//raconf_catagoria
			
			$i++;

		}
		

		if($obj->guardar()){
			
			//include("../vista/mod_eventos.php");
			
		}

	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new rating_config('','','','','','','','');
		
		if($obj->eliminar($_POST['rating'])){
			//include("../vista/mod_eventos.php");
		}
		
	}else if($_GET['opcion']=='consulta'){
		
		$obj = new rating_config('','','','','','','','');
		$obj->get_rating_config($_GET['rating']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
		
	}else if($_POST['opcion']=='calcular'){
		
		set_time_limit(0);
		
		$obj = new rating_config('','','','','','','','');
		$res = $obj->get_all_rating_jugadores($_POST['rating']);
		
		$ratingJugadores = array();
		
		while ($row = mysql_fetch_assoc($res)){
			$ratingJugadores[$row['juga_id']] = $row;
		}
		
		$juegos = $obj->get_all_juegos($_POST['rating']);
		
		$aux = new rating_juegos_hist('','','','','','','','','','','','','','','','','','');
		$aux->eliminar_all_rating_juegos_hist($_POST['rating'],$obj->raconf_fecha_ult_corte);
		
		while ($row = mysql_fetch_assoc($juegos)){
			
			$juga1Puntos = $ratingJugadores[$row['juga_id1']]['raju_puntos'];
			if($juga1Puntos == '') $juga1Puntos = $obj->get_rating_jugador_default($row['juga_id1'],$_POST['rating']);
			
			$comp1Puntos = $juga1Puntos;
			
			if($obj->raconf_tipo = 'D'){
				$juga2Puntos = $ratingJugadores[$row['juga_id2']]['raju_puntos'];
				if($juga2Puntos == '') $juga2Puntos = $obj->get_rating_jugador_default($row['juga_id2'],$_POST['rating']);
				
				$comp1Puntos += $juga2Puntos;
			}else{
				$juga2Puntos = 0;
			}
			
			$juga3Puntos = $ratingJugadores[$row['juga_id3']]['raju_puntos'];
			if($juga3Puntos == '') $juga3Puntos = $obj->get_rating_jugador_default($row['juga_id3'],$_POST['rating']);
			
			$comp2Puntos = $juga3Puntos;
			
			if($obj->raconf_tipo = 'D'){
				$juga4Puntos = $ratingJugadores[$row['juga_id4']]['raju_puntos'];
				if($juga4Puntos == '') $juga4Puntos = $obj->get_rating_jugador_default($row['juga_id4'],$_POST['rating']);
				
				$comp2Puntos += $juga4Puntos;
			}else{
				$juga4Puntos = 0;
			}
			
			//obtiene el peso
			for($i=0;$i<count($obj->raconf_pesos);$i++){
			
				if($obj->raconf_pesos[$i]->raconf_nombre == $row['tipo_torneo']){
				
					$peso = $obj->raconf_pesos[$i]->raconf_peso;
					break;
				
				}
			
			}
			
			$diferencia = $comp1Puntos - $comp2Puntos;
			
			$porcEsperado = max(0,min(1,$diferencia/$obj->raconf_factor_puntos/2+0.5));
			
			$ganador = $row['ganador'] == 2 ? 0 : 1;
			
			if($row['score'] != 'WO'){
				$ajuste = round(($ganador-$porcEsperado)*$peso*$obj->raconf_factor_movilidad,0);
			}else{
				$ajuste = 0;
			}
			
			$juga1PuntosAjuste = 0;
			$juga2PuntosAjuste = 0;
			$juga3PuntosAjuste = 0;
			$juga4PuntosAjuste = 0;
			
			$juga1PuntosAjuste = $juga1Puntos + $ajuste;
			$juga2PuntosAjuste = $juga2Puntos + $ajuste;

			$juga3PuntosAjuste = $juga3Puntos - $ajuste;
			$juga4PuntosAjuste = $juga4Puntos - $ajuste;	
			
			if($juga1PuntosAjuste < 0) $juga1PuntosAjuste = 0;
			if($juga2PuntosAjuste < 0) $juga2PuntosAjuste = 0;
			if($juga3PuntosAjuste < 0) $juga3PuntosAjuste = 0;
			if($juga4PuntosAjuste < 0) $juga4PuntosAjuste = 0;
			
			$juga1PuntosAjuste = floor($juga1PuntosAjuste);
			$juga2PuntosAjuste = floor($juga2PuntosAjuste);
			$juga3PuntosAjuste = floor($juga3PuntosAjuste);
			$juga4PuntosAjuste = floor($juga4PuntosAjuste);
			
			$ratingJugadores[$row['juga_id1']]['raju_puntos'] = $juga1PuntosAjuste;
			$ratingJugadores[$row['juga_id2']]['raju_puntos'] = $juga2PuntosAjuste;
			$ratingJugadores[$row['juga_id3']]['raju_puntos'] = $juga3PuntosAjuste;
			$ratingJugadores[$row['juga_id4']]['raju_puntos'] = $juga4PuntosAjuste;
			
			$porcEsperado = round($porcEsperado,2);
	
			// echo $juga1Puntos;
			// echo " | ".$juga2Puntos;
			// echo " | ".$juga3Puntos;
			// echo " | ".$juga4Puntos;
			// echo " | ".$ganador;
			// echo " | ".$peso;
			// echo " | ".$diferencia;
			// echo " | ".$porcEsperado;
			// echo " | ".$ajuste;
			// echo " | ".$juga1PuntosAjuste;
			// echo " | ".$juga2PuntosAjuste;
			// echo " | ".$juga3PuntosAjuste;
			// echo " | ".$juga4PuntosAjuste."<br>";
			
			$aux = new rating_juegos_hist('',$row['fecha'],$row['juga_id1'],$row['juga_id2'],$row['juga_id3'],$row['juga_id4'],$juga1Puntos,$juga2Puntos
					,$juga3Puntos,$juga4Puntos,$ganador,$peso,$porcEsperado,$ajuste,$_POST['rating']
					,$row['score'],$row['torneo'],$row['modalidad']);
					
			$aux->guardar();
			
		}
		
		$aux = new rating_jugadores_hist('','','','');
		$aux->eliminar_all_rating_jugadores_hist($_POST['rating'],$obj->raconf_fecha_ult_corte);
		
		$fechaCorte = date('Y-m-d h:i:s');
		
		foreach($ratingJugadores as $ratingJugadores_key => $ratingJugadores_info){
		
			$aux = new rating_jugadores_hist($ratingJugadores_key,$fechaCorte,$ratingJugadores_info['raju_puntos'],$_POST['rating']);
			$aux->guardar();
		
		}
		
		
		echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
		
	}else if($_GET['opcion']=='consultaFecha'){
	
		$obj = new rating_config('','','','','','','','');
		$fechas = $obj->get_all_fecha_corte_rating($_GET['rating']);
		
		$arrayDeObjetos = array(); 
		
		$i = 0;
		while ($row = mysql_fetch_assoc($fechas)){
		
			$arrayDeObjetos[$i] = $row; 
			$i++;
			
		}
		
		echo json_encode($arrayDeObjetos);
	
	}else if($_POST['opcion']=='corteRating'){
	
		$obj = new rating_config('','','','','','','','');
		$obj->cerrar_corte_rating($_POST['rating']);
	
	}else if($_GET['opcion']=='consultarRatingJugadoresActual'){
		
		$obj = new rating_config('','','','','','','','');
		$fecha = $obj->get_fecha_rating_abierto($_GET['rating']);
		//$fecha = $obj->raconf_fecha_ult_corte;
		
		$jug = new rating_jugadores_hist('','','','');
		$jugadores = $jug->get_all_rating_jugadores_hist($_GET['rating'],$fecha);
		
		$arrayDeObjetos = array(); 
		
		$i = 0;
		while ($row = mysql_fetch_assoc($jugadores)){
			
			$row['juga_nombre'] = utf8_encode($row['juga_nombre']);
			$row['juga_apellido'] = utf8_encode($row['juga_apellido']);
			$arrayDeObjetos[$i] = $row; 
			$i++;
			
		}
		
		echo json_encode($arrayDeObjetos);
		
	}
	
	
	
			
?>