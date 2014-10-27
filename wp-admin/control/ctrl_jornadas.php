<?php

	require_once("../modelo/jornadas.php");
	require_once("../modelo/jornadas_juegos.php");
	require_once("../modelo/equipos.php");
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
	
		$datosCalendario = json_decode((stripslashes($_POST['datosCalendario'])));
		
	
		$i = 1;
	
		
		$obj = new jornadas('','','','','','','','','','','');
		
		$seGuardo = true;
		
		foreach($datosCalendario as $datosCalendario_key => $datosCalendario_info){

			$obj = new jornadas($datosCalendario_info[0],$_POST['interclubes'],$datosCalendario_info[1],$datosCalendario_info[4],
							'',$datosCalendario_info[2],$datosCalendario_info[3],$datosCalendario_info[7],
							$datosCalendario_info[8],$datosCalendario_info[5],$datosCalendario_info[6]);
		
			if(!$obj->guardar()){
				$seGuardo = false;
				die('Error guardando el calendario');
			}
			
			
			$i++;

		}
		
		if(seGuardo) echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
		
		
	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new jornadas('','','','','','','','','','','');
		
		if($obj->eliminar_all_jornadas($_POST['inter_id'])){
			echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
		}
		
	
	}else if($_GET['opcion']=='consultaAll'){
	
		$obj = new jornadas('','','','','','','','','','','');
		$partidos = $obj->get_all_jornadas($_GET['inter_id'],$_GET['grupo']);
		
		$arrayDeObjetos = array();
		
		//setlocale(LC_ALL, 'pt_BR');
		
		$i=0;
		while ($row = mysql_fetch_assoc($partidos)){
			if($row['jorn_fecha']!=null) $row['jorn_fecha'] = str_replace('-', '/', $row['jorn_fecha']);
			$arrayDeObjetos[$i] = $row;
			$i++;
		}
		
		echo json_encode($arrayDeObjetos);
	
	}else if($_GET['opcion']=='consultaCantJornadas'){
	
		$obj = new jornadas('','','','','','','','','','','');
		$cantidad = $obj->get_cant_jornada($_GET['inter_id']);
		$actual = $obj->get_jornada_actual($_GET['inter_id']);
		
		$arrayDeObjetos = array();
		$arrayDeObjetos[0] = $cantidad;
		$arrayDeObjetos[1] = $actual;
		
		echo json_encode($arrayDeObjetos);
	
	
	}else if($_GET['opcion']=='consultaJornadaEquipo'){
	
		$obj = new jornadas('','','','','','','','','','','');
		$equipo1 = new equipos('','','','','','','','','','');
		$equipo2 = new equipos('','','','','','','','','','');
		$arrayDeObjetos = array();
		
		if($obj->get_jornada_equipo($_GET['inter_id'], $_GET['numero'], $_GET['equipo']) != false){
		
			$arrayDeObjetos[0] = $obj;
			
			$partidos = $obj->get_resultados_jornada($_GET['inter_id'], $obj->jorn_id);

			$arrayPartidos = array();
			
			$i=0;
			while ($row = mysql_fetch_assoc($partidos)){
				if($row['jorn_fecha']!=null) $row['jorn_fecha'] = str_replace('-', '/', $row['jorn_fecha']);
				$arrayPartidos[$i] = $row;
				$i++;
			}
			
			$arrayDeObjetos[1] = $arrayPartidos;
			$arrayDeObjetos[2] = $equipo1->get_equipo($obj->equipo_id1);
			$arrayDeObjetos[3] = $equipo2->get_equipo($obj->equipo_id2);
			
		}
		
		echo json_encode($arrayDeObjetos);
	
	}else if($_GET['opcion']=='consulta'){
		/*
		$obj = new eventos('','','','','','','','','','');
		$obj->get_evento($_GET['eventos']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
		*/
	}else if($_POST['opcion']=='guardarResultados'){

		$partidos = json_decode((stripslashes($_POST['partidos'])));
	
		$obj = new jornadas('','','','','','','','','','','');
		$obj->get_jornada($_POST['jorn_id']);
		
		if($_POST['equipo_ganador'] != ''){
			$obj->jorn_ganador = $_POST['equipo_ganador'];
		}else{
			$obj->jorn_ganador = 'NULL';
		}
		
		if($_POST['juego_score'] != ''){
			$obj->jorn_score = "'".$_POST['juego_score']."'";
		}else{
			$obj->jorn_score = 'NULL';
		}
		
		$seGuardo = true;
		
		if($obj->guardar()){
		
			foreach($partidos as $partidos_key => $partidos_info){
			
				$juego = new jornadas_juegos($partidos_info[0],//juego_id
											$partidos_info[1],//jorn_id
											$partidos_info[2],//interconf_id
											$partidos_info[3],//juga_id1
											$partidos_info[4],//juga_id2
											$partidos_info[5],//juga_id3
											$partidos_info[6],//juga_id4
											$partidos_info[7],//juego_ganador
											$partidos_info[8],//juego_score
											'');//juego_fecha
											
				if(!$juego->guardar()){
					$seGuardo = false;
					die('<p>Error guardando.</p>');
				}
			
			}
		
		}else{
		
			$seGuardo = false;
			die('<p>Error guardando.</p>');
			
		}
		
		if($seGuardo){
		
			/* $mensaje = file_get_contents('correos/Mensaje_Web_Inscripcion.html');
			
			$mensaje = str_replace('<torneo>',$_POST['evento_nombre'],$mensaje);
			$mensaje = str_replace('<modalidad>',$modalidades,$mensaje);
			
			echo $mensaje; */
			
			echo "<p>Operaci&oacute;n realizada satisfactoriamente.</p>";
		}
		
	
	}else if($_GET['opcion']=='consultarCuadroClasificacion'){
	
		$obj = new jornadas('','','','','','','','','','','');
		$res = $obj->get_cuadro_clasificacion($_GET['inter_id'],$_GET['intergrup_id']);
		
		$arrayDeObjetos = array();
		
		$equipoId = -1;
		
		while($row = mysql_fetch_assoc($res)){
	   
			if($row['equipo_id'] != $equipoId){
				$equipoId = $row['equipo_id']; 
				$arrayDeObjetos[$equipoId] = array();
			}
			
			$equipo2Id =  $row['equipo_id1'] == $equipoId ? $row['equipo_id2'] : $row['equipo_id1'];
			$arrayDeObjetos[$equipoId][$equipo2Id] = $row;
	   
	    }
		
		echo json_encode($arrayDeObjetos);

	}
			
?>