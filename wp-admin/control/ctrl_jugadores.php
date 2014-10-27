<?php

	require_once("../modelo/jugadores.php");
	require_once("ctrl_archivos.php");
	
/*	
	$numero = count($_GET);
	$tags = array_keys($_GET);// obtiene los nombres de las varibles
	$valores = array_values($_GET);// obtiene los valores de las varibles

	
	// crea las variables y les asigna el valor
	for($i=0;$i<$numero;$i++){
		echo $tags[$i]." : ".$valores[$i]."<br>";
	}
*/	

	
	
	if($_POST['opcion']=='guardar'){
	
		/*
	
		$publicarhome = $_POST['publicarhome'] == true ? 'S' : 'N';
		$publicar = $_POST['publicar'] == true ? 'S' : 'N';
		
		*/
		

		if($_POST['foto']!=''){
		
			$foto = $_POST['foto'];
			$foto = mover_archivo($foto,"../../art/jugadores/");
		
		}else{
			$foto = NULL;
		}
		
		
		if(is_numeric($_POST['club']))
			$club = $_POST['club'];
		else
			$club = null;
			
		if(is_numeric($_POST['estado']))
			$estado = $_POST['estado'];
		else
			$estado = null;
	
		$obj = new jugadores($_POST['cedula'],utf8_decode($_POST['nombre']),utf8_decode($_POST['apellido']),
							$_POST['fecha_nac'],$_POST['sexo'],utf8_decode($_POST['ciudad']),
							utf8_decode($_POST['zona']),$club,utf8_decode($_POST['email']),
							$_POST['telf_hab'],$_POST['telf_ofic'],$_POST['telf_cel'],
							$_POST['pin'],utf8_decode($_POST['twitter']),utf8_decode($_POST['facebook']),$foto,$estado,$_POST['otro_club']);
		
		$obj->juga_alias = $_POST['alias'];
		$obj->juga_categoria = $_POST['categoria'];
		
		if($_POST['privacidadFicha'])
			$obj->juga_ficha_perfil = $_POST['privacidadFicha'];
			
			
		if($obj->guardar()){
			
			if($_POST['modulo'] == "actualizar_jugador"){
			
				echo "<p>Actualizaci&oacute;n realizada satisfactoriamente. <br><br>";
						
			}
			
		}
		
		
		
	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new jugadores('','','','','','','','','','','','','','','','','','');
		
		if($obj->eliminar($_POST['cedula'])){
			//include("../vista/mod_eventos.php");
		}
		
	}else if($_GET['opcion']=='consulta'){
		
		$obj = new jugadores('','','','','','','','','','','','','','','','','','');
		
		if($_GET['cedula'] != ''){
			$obj->get_jugador($_GET['cedula']);
		}else if($_GET['email'] != ''){
			$obj->get_jugador_by_email($_GET['email']);
		}
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
		
	}else if($_GET['opcion']=='consultaAll'){
		
		$obj = new jugadores('','','','','','','','','','','','','','','','','','');
		

		$jugadores = $obj->get_lista_jugadores($_GET['buscar'],'nombre');
		
		$arrayDeObjetos = array(); 
		$i=0;
		
		while ($row = mysql_fetch_assoc($jugadores)){
			$row['juga_nombre'] = utf8_encode($row['juga_nombre']);
			$row['juga_apellido'] = utf8_encode($row['juga_apellido']);
			$row['juga_nombre_full'] = ucwords(strtolower($row['juga_apellido'].", ".$row['juga_nombre']));
			
			$arrayDeObjetos[$i] = $row;
			$i++;
		}
		
		echo json_encode($arrayDeObjetos);
		
	}
	
	
			
?>