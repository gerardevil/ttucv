<?php

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
	
	
	if($_POST['tipo_medio']=='galeria'){
	
		include("ctrl_galerias.php");

	}else if($_POST['tipo_medio']=='videos'){
		
		include("ctrl_videos.php");
		
	}else if($_POST['tipo_medio']=='prensas'){
		
		include("ctrl_prensas.php");
		
	}
	
	
			
?>