<?php

	require_once("../modelo/prensas.php");
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
	
		
	
		$publicar = $_POST['publicar_prensa'] == true ? 'S' : 'N';
		
		if($_POST['imagen_prensa']!=''){
		
			$imagen = $_POST['imagen_prensa'];
			$imagen = mover_archivo($imagen,"../../art/prensas/");
		
		}else{
			$imagen = NULL;
		}

		
	
		$obj = new prensas($_POST['prensa'],$_POST['fecha_prensa'],utf8_decode($_POST['titulo_prensa']),
							utf8_decode($_POST['resumen_prensa']),utf8_decode($_POST['texto_prensa']),
							$imagen,$publicar);
	

		if($obj->guardar()){
			
			//include("../vista/mod_eventos.php");
			
		}

	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new prensas('','','','','','','');
		
		if($obj->eliminar($_POST['prensa'])){
			//include("../vista/mod_eventos.php");
		}
		
	}else if($_GET['opcion']=='consulta'){
		
		$obj = new prensas('','','','','','','');
		$obj->get_prensa($_GET['prensa']);
		
		$obj->pren_titulo = utf8_encode($obj->pren_titulo);
		$obj->pren_resumen = utf8_encode($obj->pren_resumen);
		$obj->pren_texto = utf8_encode($obj->pren_texto);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
		
	}
	
	
			
?>