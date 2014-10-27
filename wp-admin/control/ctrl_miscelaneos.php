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
		
	
		$obj = new miscelaneos($_POST['miscelaneo'],$_POST['variable'],utf8_decode($_POST['titulo_conf']),
									utf8_decode($_POST['texto_conf']),NULL);
	

		if($obj->guardar()){
			
			echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
			
		}

	}else if($_POST['opcion']=='eliminar'){
		
		/*
		$obj = new miscelaneos('','','','','');
		
		if($obj->eliminar($_POST['miscelaneo'])){
			//include("../vista/mod_eventos.php");
		}
		*/
		
	}else if($_GET['opcion']=='consulta'){
		
		$obj = new miscelaneos('','','','','');
		$obj->get_miscelaneo($_GET['miscelaneo']);
		
		$obj->misc_titulo = utf8_encode($obj->misc_titulo);
		$obj->misc_texto = utf8_encode($obj->misc_texto);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
		
	}
	
	
			
?>