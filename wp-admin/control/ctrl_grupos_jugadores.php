<?php

	/*require_once("../modelo/interclubes_grupos.php");
	require_once("../modelo/interclubes_categorias.php");
	require_once("../modelo/grupos.php");
	
	date_default_timezone_set('America/Caracas');
	*/
	
	if($_POST['opcion']=='guardar'){
		
		echo 'entro';
		/*
		$datosGrupos = json_decode((stripslashes($_POST['datosGrupos'])));
		
		print_r($datosGrupos);

		
		$seGuardaron = true;*/
	/*
		foreach($datosGrupos as $datosGrupos_key => $datosGrupos_info){
			
			//$obj = new grupos($datosGrupos_info[0],$datosGrupos_info[1],$_POST['modaGrupos']),$datosGrupos_info[2];
			/*
			if($obj->guardar()){

				
			}else{
				$seGuardaron = false;
				die("Error al realizar la inscripcion correctamente");
			}
*/
	//	}
		
		/*if($seGuardaron){
			echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
		}*/

	*/
		
		
	}else if($_POST['opcion']=='eliminar'){
		/*
		$obj = new grupos('','','');
		
		if($obj->eliminar($_POST['grupo_id'])){
		}
		*/
	}else if($_GET['opcion']=='consulta'){
		/*
		$obj = new grupos('','','');
		$obj->get_grupo($_GET['intergrup_id']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
	*/
		
	}else if($_GET['opcion']=='consultaAll'){
		/*
		$obj = new grupos('','','');
		$inscripciones = $obj->get_all_grupos($_GET['evmo_id']);
		
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
		*/
	}
	
	
			
?>
