<?php

	
	function mover_archivo_raiz($archivo, $dir_destino, $raiz){
		
		//$archivo = str_replace("C:\\\\fakepath\\\\","",$archivo);
		$pos = strripos($archivo,'\\');
		
		if($pos)	
			$archivo = substr($archivo,$pos+1);
			
		$pos = strripos($archivo,'/');
		
		if($pos)	
			$archivo = substr($archivo,$pos+1);
		
		$prefijo = substr(md5(uniqid(rand())),0,6);
		$destino = $dir_destino.$prefijo."_".$archivo;

		if(file_exists($raiz."scripts/fileupload/server/php/files/".$archivo)){
			
			if (!copy($raiz."scripts/fileupload/server/php/files/".$archivo,$destino)){
				die("No se pudo mover el archivo <b>".$archivo."</b>");
			}else{
				unlink($raiz."scripts/fileupload/server/php/files/".$archivo);
				if(file_exists($raiz."scripts/fileupload/server/php/thumbnails/".$archivo)){
					unlink($raiz."scripts/fileupload/server/php/thumbnails/".$archivo);
				}
				$archivo = $prefijo."_".$archivo;
			}
			
		}else{
		
			if(!file_exists($dir_destino.$archivo)){
				die("No se encontro el archivo <b>".$archivo."</b> en el servidor");
			}
			
		}
	
		return $archivo;
	}

	
	
	function mover_archivo($archivo, $dir_destino){
		
		return mover_archivo_raiz($archivo, $dir_destino, "../");
		
	}
	
	
	function listar_archivos($ruta){ 

	   $archivos = array();
	   
	   if (is_dir($ruta)) { 
	   
		  if ($dh = opendir($ruta)) { 
			 while (($file = readdir($dh)) !== false) { 
			 
				if (!is_dir($ruta . $file) && $file!="." && $file!=".." && $file!=".htaccess"){ 
				  
				   array_push( $archivos, $file);
				   //echo "<br>Directorio: $ruta$file";
				  
				} 
			 } 
			closedir($dh); 
		  } 
		  
	   }else{
		  echo "<br>No es ruta valida"; 
	   }
	   
	   return $archivos;
	   
	}


?>