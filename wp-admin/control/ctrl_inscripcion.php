<?php

	require_once("../modelo/inscripciones_eventos.php");
	require_once("../modelo/jugadores.php");
	require_once("../modelo/transacciones_pagos.php");

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

		$datosModa = json_decode((stripslashes($_POST['datosModa'])));
		$datosPagos = json_decode((stripslashes($_POST['datosPagos'])));
		
		$modalidades = "";
		
		$seGuardaron = true;
		
		$i = 0;
		
		foreach($datosModa as $datosModa_key => $datosModa_info){

			if($modalidades != "") $modalidades .= ", ";
			$modalidades .= $datosModa_info[1];
		
			if($datosModa_info[2] != ""){
				$juga_id2 = $datosModa_info[2];
			}else{
				$juga_id2 = "NULL";
			}
			
			$obj = new inscripciones_eventos($datosModa_info[0],$_POST['juga_id'],$juga_id2,date("d/m/Y H:i:s"),'I');
			
			if($obj->guardar()){
				
				
			}else{
				$seGuardaron = false;
				die("Error al realizar la inscripcion");
			}

			$i++;
			
		}
		
		if($seGuardaron){
		
			$mensaje = file_get_contents('correos/Mensaje_Web_Inscripcion.html');
			
			$mensaje = str_replace('<torneo>',$_POST['evento_nombre'],$mensaje);
			$mensaje = str_replace('<modalidad>',$modalidades,$mensaje);
			
			echo $mensaje;
			
			/* Se manda el correo */
			$_POST['emails_destinos'] = $_POST['emails_destinos'];
			$_POST['modalidades'] = $modalidades;
			$_POST['asunto'] = "Inscripción en el torneo ".$_POST['evento_nombre'];
			$_POST['cuerpo'] = "inscripcion";
			include('ctrl_enviar_email.php');
			
		}
	
	}else if($_POST['opcion']=='guardarPagos'){

		$datosModa = json_decode((stripslashes($_POST['datosModa'])));
		$datosPagos = json_decode((stripslashes($_POST['datosPagos'])));
		
		$modalidades = "";
		
		$seGuardaron = true;
		
		$tran = new transacciones_pagos('',date("d/m/Y H:i:s"),$_POST['conceptoPago'],$_POST['totalPagado'],'I',$_POST['juga_id']);
		
		$tran->guardar();
		
		$i = 0;
		$iaux = 0;
		
		foreach($datosModa as $datosModa_key => $datosModa_info){

			if($modalidades != "") $modalidades .= ", ";
			$modalidades .= $datosModa_info[1];
		
			if($datosModa_info[2] != ""){
				$juga_id2 = $datosModa_info[2];
			}else{
				$juga_id2 = "NULL";
			}
			
			$obj = new inscripciones_eventos($datosModa_info[0],$_POST['juga_id'],$juga_id2,date("d/m/Y H:i:s"),'I');
			$jugador = new jugadores('','','','','','','','','','','','','','','','','','');
			$jugador->get_jugador($_POST['juga_id']);
			
				$monto2 = 0;
				$estatus2 = 'N';
				
				if($datosModa_info[2] != ""){
					$iaux = $i+1;
					$monto2 = $datosPagos[$iaux][0];
					$estatus2 = $datosPagos[$iaux][1];
				}
			
			if($obj->guardarPago($datosModa_info[0],$_POST['juga_id'],'NULL',$datosPagos[$i][0],$datosPagos[$i][1],$monto2,$estatus2)){
				
				
			}else{
				$seGuardaron = false;
				die("Error al registrar el pago");
			}
			
			$iaux++;
			$i = $iaux;
			
			
		}
		
		if($seGuardaron){
		
			$post_url = "http://190.153.48.115/msBotonDePago/index.jsp"; // (TEST)
			//$post_url = "https://123pago.net/msBotonDePago/index.jsp"; // (PRODUCCION)
			
			$find = array(".","-","(",")"," ");
			$telf = str_replace($find,"",$jugador->juga_telf_cel);
			if(!is_int($telf)){
				$telf = "";
			}
			
			$post_values = array(
			"nbproveedor" => "DxT Eventos",
			"nb" => $jugador->juga_nombre,
			"ap" => $jugador->juga_apellido,
			"ci" => $jugador->juga_id,
			"em" => $jugador->juga_email,
			"cs" => "91bbe5b14ab02e9bfa4f447edcbb6f5c",
			"nai" => $tran->tran_id,
			"co" => $tran->tran_concepto,
			"tl" => $telf,
			"mt" => $tran->tran_monto,
			"ancho" => "400px");
			
			$post_string = "";
			foreach( $post_values as $key => $value )
			{ $post_string .= "$key=" . urlencode( $value ) . "&"; }
			$post_string = rtrim( $post_string, "& " );
			
			$request = curl_init($post_url); // instancia el objeto curl
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // retorna data de respuesta TRUE(1)
			curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // usa HTTP POST para enviar data de la forma.
			curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // descomente esta línea si no quiere obtener
			//respuesta de gateway
			$post_response = curl_exec($request); // ejecuta el curl post y almacena el resultado en $post_response
			// es posible que se requiera el uso de opciones adicionales a las indicadas dependiendo de la
			//configuración de su servidor
			// Puede encontrar documentación de las opciones de curl en http://www.php.net/curl_setopt
			curl_close ($request); // cierra el objeto curl
			echo $post_response;
			
		}
		
	
	}else if($_POST['opcion']=='actualizar'){

		$datosModa = json_decode((stripslashes($_POST['datosInsc'])));
		
		foreach($datosModa as $datosModa_key => $datosModa_info){
			
			if($datosModa_info[3] != ""){
				$juga_id2 = $datosModa_info[3];
			}else{
				$juga_id2 = "NULL";
			}
			
			$obj = new inscripciones_eventos($_POST['modaInscripcion'],$datosModa_info[1],$juga_id2,$datosModa_info[0],$datosModa_info[5]);
			
			//echo json_encode($obj);
			
			if($datosModa_info[5] == 'E'){
				$obj->eliminar_inscripcion($_POST['modaInscripcion'], $datosModa_info[1]);
			}else{			
				if($obj->guardar()){
					
					if($_POST['enviarCorreo'] && ($datosModa_info[5] == 'A' || $datosModa_info[5] == 'R')){
					
						
						/* Se manda el correo */
						$_POST['emails_destinos'] = $datosModa_info[2].($datosModa_info[4] != "" ? ", ".$datosModa_info[4] : "");
						$_POST['evento_nombre'] = $_POST['nombre'];
						$_POST['modalidades'] = $_POST['moda_nombre'];
						$_POST['asunto'] = "Inscripción en el torneo ".$_POST['evento_nombre']." - ".$_POST['moda_nombre'];
						
						if($datosModa_info[5] == 'A'){
							$_POST['cuerpo'] = "aprobada";
						}else{
							$_POST['cuerpo'] = "rechazada";
						}
						include('ctrl_enviar_email.php');
						
					}
					
				}else{
				
					die("<p>Error guardando.</p>");
				}
			}

		}
		
		echo "<p>Operaci&oacute;n realizada satisfactoriamente.</p>";
		

	}else if($_POST['opcion']=='eliminar'){
		/*
		$obj = new eventos('','','','','','','','','','');
		
		if($obj->eliminar($_POST['eventos'])){
			//include("../vista/mod_eventos.php");
		}
		*/
	}else if($_GET['opcion']=='consultaAll'){

		$obj = new inscripciones_eventos('','','','','');
		$inscripciones = $obj->get_all_moda_inscripciones($_GET['evmo_id'],$_GET['estatus'],$_GET['orden'],$_GET['filtro']);
		
		$arrayDeObjetos = array();
		
		//setlocale(LC_ALL, 'pt_BR');
		
		$i=0;
		while ($row = mysql_fetch_assoc($inscripciones)){
			$row['juga1_nombre'] = utf8_encode($row['juga1_nombre']);
			$row['juga1_apellido'] = utf8_encode($row['juga1_apellido']);
			$row['juga1_nombre_full'] = ucwords(strtolower($row['juga1_apellido'].", ".$row['juga1_nombre']));
			$row['juga2_nombre'] = utf8_encode($row['juga2_nombre']);
			$row['juga2_apellido'] = utf8_encode($row['juga2_apellido']);
			$row['juga2_nombre_full'] = ucwords(strtolower($row['juga2_apellido'].", ".$row['juga2_nombre']));
			$arrayDeObjetos[$i] = $row;
			$i++;
		}
		
		echo json_encode($arrayDeObjetos);
		
	}

	
			
?>