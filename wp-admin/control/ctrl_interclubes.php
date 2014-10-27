<?php

	require_once("../modelo/interclubes_categorias.php");
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
	
	
	if($_POST['opcion']=='guardar'){
	
		
	
		$publicar = $_POST['publicar'] == true ? 'S' : 'N';
		$cerrado = $_POST['cerrado'] == true ? 'S' : 'N';

		
		if($_POST['afiche']!=''){
		
			$afiche = $_POST['afiche'];
			$afiche = mover_archivo($afiche,"../../art/interclubes/");
		
		}else{
			$afiche = NULL;
		}
		
	
		$obj = new interclubes_categorias($_POST['interclubes'],$_POST['nombre'],$_POST['puntaje'],
							$publicar,$cerrado,$_POST['fecha'],$afiche,$_POST['categoria'],$_POST['tipo_torneo']);
		
		$obj->liga_id = $_POST['liga'];
		
		$i = 1;
	
		foreach($datosTabla as $datosTabla_key => $datosTabla_info){

			$obj->add_inter_juego(
						$datosTabla_info[6],//interconf_id
						$_POST['interclubes'],//inter_id
						$datosTabla_info[0],//sexo
						$datosTabla_info[1],//tipo
						$datosTabla_info[2],//puntaje ganador
						$datosTabla_info[5],//categoria
						$datosTabla_info[3],//puntaje perdedor
						$datosTabla_info[4]);//puntaje wo
			
			$i++;

		}
		
		
		if($obj->guardar()){
			
			//include("../vista/mod_eventos.php");
			
		}

	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new interclubes_categorias('','','','','','','','','','');
		
		if($obj->eliminar($_POST['interclubes'])){
			//include("../vista/mod_eventos.php");
		}
		
	}else if($_GET['opcion']=='consulta'){
		
		$obj = new interclubes_categorias('','','','','','','','','','');
		$obj->get_interclubes($_GET['interclubes']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
	
	}else if($_GET['opcion']=='consultaAll'){
		
		$obj = new interclubes_categorias('','','','','','','','','','');
		$categorias = $obj->get_all_interclubes_categorias($_GET['liga']);
		
		$arrayDeObjetos = array(); 
		
		$i=0;
		while ($row = mysql_fetch_assoc($categorias)){
			$arrayDeObjetos[$i] = $row;
			$i++;
		}
		
		echo json_encode($arrayDeObjetos);
		
	}else if($_GET['opcion']=='consultaAllAbiertas'){
		
		$obj = new interclubes_categorias('','','','','','','','','','');
		$categorias = $obj->get_all_categorias_abiertas($_GET['liga']);
		
		$arrayDeObjetos = array(); 
		
		$i=0;
		while ($row = mysql_fetch_assoc($categorias)){
			$arrayDeObjetos[$i] = $row;
			$i++;
		}
		
		echo json_encode($arrayDeObjetos);
		
	}
	
	
			
?>