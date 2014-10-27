<?php

	require_once("../modelo/galerias.php");
	require_once("ctrl_archivos.php");
	require_once("../../funciones.php");
	
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
	$datosPatr = json_decode((stripslashes($_POST['datosPatr'])));
	
	
	if($_POST['opcion']=='guardar'){

		$publicar = $_POST['publicar'] == true ? 'S' : 'N';
		
		if($_POST['imagen']!=''){
		
			$imagen = $_POST['imagen'];
			$imagen = mover_archivo($imagen,"../../art/galerias/");
		
		}else{
			$imagen = NULL;
		}

		
	
		$obj = new galerias($_POST['galeria'],$_POST['deportes'],$_POST['nombre'],
							$imagen,$_POST['fecha'],$publicar);
	/*
		$i = 1;
	
		foreach($datosTabla as $datosTabla_key => $datosTabla_info){

			$obj->add_evento_modalidad(
						$i,
						$_POST['eventos'],//even_id
						$datosTabla_info[0],//moda_id
						$datosTabla_info[2],//premiacion a campeon
						$datosTabla_info[3],//premiacion a subcampeon
						$datosTabla_info[1]);//evmo_fecha
			
			
			$i++;

		}
		
		$i = 1;
		
		foreach($datosPatr as $datosPatr_key => $datosPatr_info){

			$obj->add_evento_patrocinante(
						$i,
						$_POST['eventos'],//even_id
						$datosPatr_info[0],//moda_id
						$i);//evmo_fecha
			
			
			$i++;

		}
		*/

		if($obj->guardar()){
			
			//include("../vista/mod_eventos.php");
			
		}

	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new galerias('','','','','','');
		
		if($obj->eliminar($_POST['galeria'])){
			//include("../vista/mod_eventos.php");
		}
		
	}else if($_GET['opcion']=='consulta'){
		
		$obj = new galerias('','','','','','');
		$obj->get_galeria($_GET['galeria']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
		
	}else if($_GET['opcion']=='consultaArchivos'){

		$archivos = listar_archivos('../scripts/fileupload/server/php/files/');
		
		echo json_encode($archivos);
		
	}else if($_GET['opcion']=='consultaAll'){
		
		$cantidad = 10;
		$inicio = ($cantidad*($_GET['pagina']-1));
		
		//echo 'Inicio: '.$inicio.'<br>';
		
		$archivos = array(); 
		$archivos = listar_archivos('../scripts/fileupload/server/php/files/');
		$cantArchivos = count($archivos);
		
		//echo 'CantArchivos: '.$cantArchivos.'<br>';
		
		$arrayDeObjetos = array();
		
		$i = 0;
		
		if($inicio < $cantArchivos){
		
			for($j=$inicio;$j<$cantArchivos;$j++){
				
				$arrayDeObjetos[$i] = $archivos[$j];
				$i++;
				if($i==$cantidad) break;
			}
		
			$cantidad -= $i;
			
			$inicio = 0;
		
		}else{
		
			$inicio -= $cantArchivos;
		
		}
		
		//if($cantArchivos <= $cantidad){
			
		
			//echo 'Inicio: '.$inicio.'<br>';
			
		if($cantidad != 0){
			
			$obj = new galerias('','','','','','');
			$imagenes = $obj->get_all_galerias($inicio,$cantidad);
			
			while ($row = mysql_fetch_assoc($imagenes)){
			
				$arrayDeObjetos[$i] = $row;
				$i++;
				
			}
		}
		//}else{
		
		//}
		
		echo json_encode($arrayDeObjetos);
		
	}else if($_GET['opcion']=='consultaCantPaginas'){
		
		$cantidad = 10;
		
		$obj = new galerias('','','','','','');
		$cantGalerias = $obj->get_cant_galerias();
		
		$archivos = array(); 
		$archivos = listar_archivos('../scripts/fileupload/server/php/files/');
		$cantArchivos = count($archivos);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = ceil(($cantGalerias + $cantArchivos) / $cantidad); 
		
		echo json_encode($arrayDeObjetos);
		
	}else if($_POST['opcion']=='publicarGalerias'){

		$datos = json_decode((stripslashes($_POST['datos'])));
	
		for($i=0;$i<count($datos);$i++){	
	
			if($datos[$i]!=''){
			
				$imagen = $datos[$i];
				$imagen = mover_archivo($imagen,"../../art/galerias/");
			
			}else{
				$imagen = NULL;
			}

			
			$obj = new galerias('',1,$imagen,
								$imagen,date('d/m/Y'),'S');
								
								
			if($obj->guardar()){
			
			
			}
								
								
		}
	
	
	}else if($_POST['opcion']=='eliminarGalerias'){

		$datos = json_decode((stripslashes($_POST['datos'])));
	
		foreach($datos as $datos_key => $datos_info){	

			if($datos_info[1]=='A'){

				if(file_exists("../scripts/fileupload/server/php/files/".$datos_info[0])){
					unlink("../scripts/fileupload/server/php/files/".$datos_info[0]);
					if(file_exists("../scripts/fileupload/server/php/thumbnails/".$datos_info[0])){
						unlink("../scripts/fileupload/server/php/thumbnails/".$datos_info[0]);
					}
				}
			
			}else{
			
				$obj = new galerias('','','','','','');	
				echo '<br>id: '.$datos_info[0].'<br>';
				if($obj->eliminar($datos_info[0])){
				
					
				
				}
				
			}
														
		}
	
	
	}
			
?>