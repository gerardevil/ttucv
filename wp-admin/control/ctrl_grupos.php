<?php

	require_once("../modelo/interclubes_grupos.php");
	require_once("../modelo/interclubes_categorias.php");
	require_once("../modelo/equipos.php");
	
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
		
		$datosGrupos = json_decode((stripslashes($_POST['datosGrupos'])));
		
		$seGuardaron = true;
		
		$obj = new interclubes_grupos('','','');
		$obj->asignar_cant_equipos_x_grupo($_POST['interclubes'],$_POST['nro_equipos_x_grupos']);
		
		foreach($datosGrupos as $datosGrupos_key => $datosGrupos_info){
			
			$obj = new interclubes_grupos($datosGrupos_info[0],$datosGrupos_info[1],$_POST['interclubes']);
			
			if($obj->guardar()){
			
				$datosEquipos = $datosGrupos_info[2];
				

				foreach($datosEquipos as $datosEquipos_key => $datosEquipos_info){
					if($datosEquipos_info!=''){
						$obj->asignar_grupo_equipo($datosEquipos_info);
					}
				}
				
			}else{
				$seGuardaron = false;
				die("Error al realizar la inscripcion correctamente");
			}

		}
		
		if($seGuardaron){
			echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
		}
	
	
		
		
	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new interclubes_grupos('','','');
		
		if($obj->eliminar($_POST['intergrup_id'])){
		}
		
	}else if($_GET['opcion']=='consulta'){
	
		$obj = new interclubes_grupos('','','');
		$obj->get_grupo($_GET['intergrup_id']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
	
		
	}else if($_GET['opcion']=='consultaAll'){

		$obj = new interclubes_grupos('','','');
		$inscripciones = $obj->get_all_grupos($_GET['inter_id']);
		
		$arrayDeObjetos = array();
		

		$i=0;
		while ($row = mysql_fetch_assoc($inscripciones)){
			
			$obj = new equipos('','','','','','','','','','');
			$equipos = $obj->get_all_equipos($_GET['inter_id'], '', '', '', $row['intergrup_id']);
			
			$arrayEquipos = array();
			$j=0;
			while ($row2 = mysql_fetch_assoc($equipos)){	
				$arrayEquipos[$j] = $row2;
				$j++;
			}
			
			$row['equipos'] = $arrayEquipos;
			$arrayDeObjetos[$i] = $row;
			$i++;
		}
		
		echo json_encode($arrayDeObjetos);
		
	}
	
	
			
?>
