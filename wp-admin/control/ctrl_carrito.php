<?php
	session_start();
	
	
	require_once("../modelo/inscripciones_eventos.php");
	require_once("../modelo/jugadores.php");
	require_once("../modelo/transacciones_pagos.php");

	date_default_timezone_set('America/Caracas');
	
	if($_POST['opcion']=='botonPago'){
	
		$jugador = new jugadores('','','','','','','','','','','','','','','','','','');
		$jugador->get_jugador_by_email($_SESSION['email']);
		$tran = new transacciones_pagos('',date("d/m/Y H:i:s"),$_POST['conceptoPago'],$_POST['totalPagado'],'I',$jugador->juga_id);
		
		if($tran->guardar()){
		
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
	
	}
	
?>