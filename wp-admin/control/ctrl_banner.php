<?php

	require_once("../modelo/miscelaneos.php");
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
	
	
	if($_POST['opcion']=='guardar'){
	
	/*
		
		if($_POST['imagen_prensa']!=''){
		
			$imagen = $_POST['imagen_prensa'];
			$imagen = mover_archivo($imagen,"../../art/prensas/");
		
		}else{
			$imagen = NULL;
		}
*/
		
		$datosBanner = json_decode((stripslashes($_POST['datosBanner'])));
	
	
		$i = 1;

		$obj = new miscelaneos('','','','','');
		$obj->eliminar_all_miscelaneos('banner');
		
		foreach($datosBanner as $datosBanner_key => $datosBanner_info){

			if($datosBanner_info[1]!=''){
		
				$imagen = $datosBanner_info[1];
				$imagen = mover_archivo($imagen,"../../art/banner/");
			
			}else{
				$imagen = NULL;
			}

						
			$obj = new miscelaneos($_POST['miscelaneo'],'banner',utf8_decode($datosBanner_info[0]),
									'',$imagen);

			$obj->guardar();
			
			$i++;

		}
	
		echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
	
		
	}else if($_GET['opcion']=='consulta'){
		
		$obj = new miscelaneos('','','','','');
		$banners = $obj->get_all_banner();

		$miscelaneos = array();
		
		while ($row_banner = mysql_fetch_assoc($banners)){
		
			$aux = new miscelaneos($row_banner['misc_id'],$row_banner['misc_variable'],
								$row_banner['misc_titulo'],$row_banner['misc_texto'],$row_banner['misc_imagen1']);
			$aux->misc_imagen1 = $row_banner['misc_imagen1'];
		
			array_push($miscelaneos, $aux);
		
		}
		
		//$arrayDeObjetos = array(); 
		//$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($miscelaneos);
		
	}
	
	
			
?>