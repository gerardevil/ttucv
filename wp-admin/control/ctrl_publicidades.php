<?php

	require_once("../modelo/publicidades.php");
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
	
		
	
		$publicar = $_POST['publicar_publicidad'] == true ? 'S' : 'N';
		
		if($_POST['imagen_publicidad']!=''){
		
			$imagen = $_POST['imagen_publicidad'];
			$imagen = mover_archivo($imagen,"../../art/publicidades/");
		
		}else{
			$imagen = NULL;
		}

		
	
		$obj = new publicidades($_POST['publicidad'],$_POST['nombre_publicidad'],$imagen,
							$_POST['ubicacion_publicidad'],$publicar);
	
		$i = 1;
	
		foreach($datosTabla as $datosTabla_key => $datosTabla_info){

			$obj->add_publicidad_seccion(
						$_POST['publicidad'],//publ_id
						$datosTabla_info[0]);//puse_seccion
			
			
			$i++;

		}
		
		
		if($obj->guardar()){
			
			//include("../vista/mod_eventos.php");
			
		}

	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new publicidades('','','','','');
		
		if($obj->eliminar($_POST['publicidad'])){
			//include("../vista/mod_eventos.php");
		}
		
	}else if($_GET['opcion']=='consulta'){
		
		$obj = new publicidades('','','','','');
		$obj->get_publicidad($_GET['publicidad']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
		
	}
	
	
			
?>