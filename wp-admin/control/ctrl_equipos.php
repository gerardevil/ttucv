<?php

	session_start();

	require_once("../modelo/equipos.php");
	require_once("../modelo/interclubes_categorias.php");
	require_once("../modelo/jornadas.php");
	
	date_default_timezone_set('America/Caracas');
	
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

	
			$obj = new equipos('',$_POST['equipo_nombre'],$_POST['club'],$_POST['interclubes'],$_POST['emails_destinos'],0,
							$_POST['tipo_cancha'],date("d/m/Y H:i:s"),'I',null);
								
			if($obj->guardar()){
				
				$equiposJugadores = json_decode((stripslashes($_POST['equiposJugadores'])));
	
				
				if($obj->guardar_lista_jugadores($_POST['interclubes'],$equiposJugadores)){
				
				
				
				}
				
				$mensaje = file_get_contents('correos/Mensaje_Web_Inscripcion_Interclubes.html');
				$mensaje = str_replace('<torneo>',$_POST['evento_nombre'],$mensaje);
				$mensaje = str_replace('<categoria>',$_POST['evento_categoria'],$mensaje);
				$mensaje = str_replace('<equipo>',$_POST['equipo_nombre'],$mensaje);
		
				echo $mensaje;
				
				/* Se manda el correo */
				//$_POST['emails_destinos'] = $_POST['email'];
				$_POST['asunto'] = "Inscripción a interclubes en dxteventos.com";
				$_POST['cuerpo'] = "inscripcionInterclubes";
				include('ctrl_enviar_email.php');
				
				/*
				echo "<p>Registro realizado satisfactoriamente. <br><br>Ahora puede iniciar sesi&oacute;n 
						con lo que podr&aacute; realizar inscripciones en linea a los torneos y actualizar sus datos personales.</p>";       
						*/
				
			}
		
		
	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new equipos('','','','','','','','','','');
		
		if($obj->eliminar($_POST['equipo_id'])){
		}
		
	}else if($_GET['opcion']=='consulta'){
	
		$obj = new equipos('','','','','','','','','','');
		$obj->get_equipo($_GET['equipo_id']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
	
	}else if($_GET['opcion']=='existe'){
	
		$obj = new equipos('','','','','','','','','','');
		$existe = $obj->existe_usuario($_GET['usuario']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $existe; 
		
		echo json_encode($arrayDeObjetos);
	
	}else if($_GET['opcion']=='existeEquipo'){
	
		$obj = new equipos('','','','','','','','','','');
		$existe = $obj->existe_equipo($_GET['inter_id'],$_GET['equipo']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $existe; 
		
		echo json_encode($arrayDeObjetos);
		
	}else if($_GET['opcion']=='consultaAll'){

		$obj = new equipos('','','','','','','','','','');
		
		$grupo = '';
		if($_GET['grupo'] != '') $grupo = $_GET['grupo'];
		
		$inscripciones = $obj->get_all_equipos($_GET['inter_id'],$_GET['estatus'],$_GET['orden'],$_GET['filtro'],$grupo);
		
		$arrayDeObjetos = array();
		
		//setlocale(LC_ALL, 'pt_BR');
		
		$i=0;
		while ($row = mysql_fetch_assoc($inscripciones)){
			$row['juga_nombre'] = utf8_encode($row['juga_nombre']);
			$row['juga_apellido'] = utf8_encode($row['juga_apellido']);
			$row['juga_nombre_full'] = ucwords(strtolower($row['juga_apellido'].", ".$row['juga_nombre']));
			
			$arrayDeObjetos[$i] = $row;
			$i++;
		}
		
		echo json_encode($arrayDeObjetos);
		
	}else if($_POST['opcion']=='actualizar'){

		$datosModa = json_decode((stripslashes($_POST['datosInsc'])));
		
		foreach($datosModa as $datosModa_key => $datosModa_info){
			
			
			$obj = new equipos($datosModa_info[3],$datosModa_info[1],$datosModa_info[4],$_POST['interclubes'],$datosModa_info[7],0,
							$datosModa_info[5],$datosModa_info[0],$datosModa_info[8],null);
			
			//echo json_encode($obj);
			
			if($obj->equipo_estatus == 'E'){
				$obj->eliminar($obj->equipo_id);
			}else{			
				if($obj->guardar()){
					/*
					if($_POST['enviarCorreo'] && ($datosModa_info[8] == 'A' || $datosModa_info[8] == 'R')){
					
						
						//Se manda el correo
						$_POST['emails_destinos'] = $datosModa_info[2].($datosModa_info[4] != "" ? ", ".$datosModa_info[4] : "");
						$_POST['modalidades'] = $_POST['moda_nombre'];
						$_POST['asunto'] = "Inscripción en el torneo ".$_POST['evento_nombre'];
						
						if($datosModa_info[8] == 'A'){
							$_POST['cuerpo'] = "aprobada";
						}else{
							$_POST['cuerpo'] = "rechazada";
						}
						include('ctrl_enviar_email.php');
						
					}
					*/
				}else{
				
					die("<p>Error guardando.</p>");
				}
			}

		}
		
		echo "<p>Operaci&oacute;n realizada satisfactoriamente.</p>";
		

	}else if($_GET['opcion']=='cantidad'){

		$inter = new interclubes_categorias('','','','','','','','','');
		$obj = new equipos('','','','','','','','','','');
		$jorn = new jornadas('','','','','','','','','','','');

		$inter->get_interclubes($_GET['inter_id']);		
		$cant = $obj->get_cantidad_equipos($_GET['inter_id'],'A');
		$jornadas = $jorn->get_cant_jornada($_GET['inter_id']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $cant;
		$arrayDeObjetos[1] = $inter;
		$arrayDeObjetos[2] = $jornadas;
 
		
		echo json_encode($arrayDeObjetos);
		
	}else if($_GET['opcion']=='consultaEquiposCapitan'){
		
		$obj = new equipos('','','','','','','','','','');
		$inscripciones = $obj->get_equipos_inscritos($_GET['inter_id'],$_GET['email']);
		
		$arrayDeObjetos = array();
		
		//setlocale(LC_ALL, 'pt_BR');
		
		$i=0;
		while ($row = mysql_fetch_assoc($inscripciones)){			
			$arrayDeObjetos[$i] = $row;
			$i++;
		}
		
		$inscripciones = $obj->get_equipos_asociados($_GET['inter_id'],$_GET['email']);
		
		while ($row = mysql_fetch_assoc($inscripciones)){			
			$arrayDeObjetos[$i] = $row;
			$i++;
		}
		
		echo json_encode($arrayDeObjetos);
		
	}else if($_POST['opcion']=='guardarListaJugadores'){
	
		$equiposJugadores = json_decode((stripslashes($_POST['equiposJugadores'])));
	
		$obj = new equipos('','','','','','','','','','');
		
		if($obj->guardar_lista_jugadores($_POST['interclubes'],$equiposJugadores)){
		
			echo "<p>Listas de jugadores actualizadas satisfactoriamente</p>";
		
		}
		
		/*
		foreach($equiposJugadores as $equiposJugadores_key => $equiposJugadores_info){
			echo $equiposJugadores_info[0].' - '.$equiposJugadores_info[1].'<br>';
		}
		*/
	}else if($_GET['opcion']=='consultaListaJugadores'){
		
		$obj = new equipos('','','','','','','','','','');
		$inscritos = $obj->get_lista_jugadores($_GET['equipo_id'],$_GET['estatus'],$_GET['orden'],$_GET['filtro']);
		
		$arrayDeObjetos = array();
		$i = 0;
		
		setlocale(LC_ALL, 'pt_BR');
		
		while ($row = mysql_fetch_assoc($inscritos)){

			$row['juga_nombre_full'] = ucwords(strtolower($row['juga_apellido'].", ".$row['juga_nombre']));
			$arrayDeObjetos[$i] = $row;
			$i++;
		
		}
		
		echo json_encode($arrayDeObjetos);
		
	
	}else if($_POST['opcion']=='guardarListaUsuarios'){
	
		$equiposJugadores = json_decode((stripslashes($_POST['equiposJugadores'])));
	
		$obj = new equipos('','','','','','','','','','');
		
		if($obj->guardar_lista_usuarios($_POST['interclubes'],$equiposJugadores)){
		
			echo "<p>Listas de usuarios autorizados actualizadas satisfactoriamente</p>";
		
		}
		
		/*
		foreach($equiposJugadores as $equiposJugadores_key => $equiposJugadores_info){
			echo $equiposJugadores_info[0].' - '.$equiposJugadores_info[1].'<br>';
		}
		*/
	}else if($_GET['opcion']=='consultaListaUsuarios'){
		
		$obj = new equipos('','','','','','','','','','');
		$inscritos = $obj->get_lista_usuarios($_GET['equipo_id'],$_GET['estatus'],$_GET['orden'],$_GET['filtro']);
		
		$arrayDeObjetos = array();
		$i = 0;
		
		setlocale(LC_ALL, 'pt_BR');
		
		while ($row = mysql_fetch_assoc($inscritos)){

			$row['juga_nombre_full'] = ucwords(strtolower($row['juga_apellido'].", ".$row['juga_nombre']));
			$arrayDeObjetos[$i] = $row;
			$i++;
		
		}
		
		echo json_encode($arrayDeObjetos);
		
	}
			
?>
