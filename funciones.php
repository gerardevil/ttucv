<?php
function getRealIP2(){
 $client_ip = $_SERVER['REMOTE_ADDR']; 
 return $client_ip;
}

//OBTENER DIA SEMANA
function get_dia_semana ($diasemana) {

    switch ($diasemana) {
    case "1":
        $diasemana="Lunes";
        break;
    case "2":
        $diasemana="Martes";
        break;
	 case "3":
        $diasemana="Miércoles";
        break;
	 case "4":
        $diasemana="Jueves";
        break;
	 case "5":
        $diasemana="Viernes";
        break;
	 case "6":
        $diasemana="Sábado";
        break;
	 case "7":
        $diasemana="Domingo";
        break;
	 default:
       $diasemana="ND";
	}
return $diasemana;
}
//OBTENER NOMBRE MES
function get_nombre_mes ($nombremes) {

    switch ($nombremes) {
    case "01":
        $nombremes="Enero";
        break;
    case "02":
        $nombremes="Febrero";
        break;
	 case "03":
        $nombremes="Marzo";
        break;
	 case "04":
        $nombremes="Abril";
        break;
	 case "05":
        $nombremes="Mayo";
        break;
	 case "06":
        $nombremes="Junio";
        break;
	 case "07":
        $nombremes="Julio";
        break;
	case "08":
        $nombremes="Agosto";
        break;
	case "09":
        $nombremes="Septiembre";
        break;
	case "10":
        $nombremes="Octubre";
        break;
	case "11":
        $nombremes="Noviembre";
        break;
	case "12":
        $nombremes="Diciembre";
        break;
	 default:
       $nombremes="ND";
	}
return $nombremes;
}


//OBTENER DIA SEMANA
function dia_semana () {
	$diasemana=date(N);
    
return get_dia_semana($diasemana);
}
//OBTENER NOMBRE MES
function nombre_mes () {
	$nombremes=date('m');
 
return get_nombre_mes($nombremes);
}
function cambiarFormatoFecha($fecha){
    list($anio,$mes,$dia)=explode("-",$fecha);
    return $dia."-".$mes."-".$anio;
}

function suma_fechas($fecha,$ndias) {
	if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
		list($dia,$mes,$año)=split("/", $fecha);
	if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
		list($dia,$mes,$año)=split("-",$fecha);
	$nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
	$nuevafecha=date("d-m-Y",$nueva);
	return ($nuevafecha);
}   

function existe_elemento($tabla, $campo, $elemento){
	$query="SELECT * FROM $tabla WHERE $campo='$elemento'";
    $verif=mysql_query($query) or die(mysql_error());
    if($row=mysql_fetch_assoc($verif)){
      return true;
    }else{
      return false;
    }
}
  /*
    function getRealIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
    }  
  */

  function getRealIP(){
	
	if( $_SERVER['HTTP_X_FORWARDED_FOR'] != "" ){
	
		$client_ip =
			( !empty($_SERVER['REMOTE_ADDR']) ) ?
				$_SERVER['REMOTE_ADDR']
				:
				( ( !empty($_ENV['REMOTE_ADDR']) ) ?
					$_ENV['REMOTE_ADDR']
					:
					"unknown" );

		// los proxys van añadiendo al final de esta cabecera
		// las direcciones ip que van “ocultando”. Para localizar la ip real
		// del usuario se comienza a mirar por el principio hasta encontrar
		// una dirección ip que no sea del rango privado. En caso de no
		// encontrarse ninguna se toma como valor el REMOTE_ADDR

		$entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

		reset($entries);
		while (list(, $entry) = each($entries)){
			$entry = trim($entry);
			if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) ){
				$private_ip = array(
				'/^0\./',
				'/^127\.0\.0\.1/',
				'/^192\.168\..*/',
				'/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
				'/^10\..*/');

				$found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

				if ($client_ip != $found_ip){
					$client_ip = $found_ip;
					break;
				}
			}
		}
		
	}else{
	
		$client_ip =
			( !empty($_SERVER['REMOTE_ADDR']) ) ?
				$_SERVER['REMOTE_ADDR']
				:
				( ( !empty($_ENV['REMOTE_ADDR']) ) ?
					$_ENV['REMOTE_ADDR']
					:
					"unknown" );
	}

	return $client_ip;

 }
  
  
function cargar_archivo_con_nombre($campo_archivo, $ruta_archivo, $nombre_archivo, $nombre_archivo_alternativo, $extension){ //GUARDA CON NOMBRE DADO Y MANTIENE EXTENSION
	if (is_uploaded_file($_FILES[$campo_archivo]['tmp_name'])){
		if ((substr($_FILES[$campo_archivo]['name'],-3)==$extension)){
			$nombre_archivo_temp=$nombre_archivo.substr($_FILES[$campo_archivo]['name'],-4);
			copy($_FILES[$campo_archivo]['tmp_name'],$ruta_archivo.$nombre_archivo_temp);
		}else{
			$nombre_archivo_temp=$nombre_archivo_alternativo;
			echo "<script>alert('La imagen no se pudo subir por no correspondo a la extensión')</script>";
		}
	}else
		$nombre_archivo_temp=$nombre_archivo_alternativo;
	return $nombre_archivo_temp;
}
?>
<?php
function validar_archivo_nombre($directorio,$nombre,$debug=TRUE,$nombreausar) {
	// $directorio: nombre del directorio destino CON slash al final.
	// $nombre: nombre del array que tiene la data del archivo dentro de $_FILES
	// $_FILES ['form_data']( <- $nombre) ['size']
	// $debug: ¿quieres ver output de lo que paso?
	$ERROR=FALSE; // si hay un error, EXIT;
	$_FILES[$nombre]['name'] = str_replace(' ', '_', $_FILES[$nombre]['name']);
	$file_temp = $_FILES[$nombre]['tmp_name'];
	// esto susbtituye los espacios en blanco del filename por un underscore.
	if (file_exists($directorio . $_FILES[$nombre]['name'])) echo 'Existe un archivo con ese nombre.<br />Agregar&eacute; un n&uacute;mero al final del nombre del nuevo para no borrar el anterior.<br />';
	$i = 1;
	while (file_exists($directorio .  $_FILES[$nombre]['name'])) {
		$separated_filename = explode(".",$_FILES[$nombre]['name']);
		if (substr($separated_filename[0],-1) == $i) {
			$separated_filename[0] = substr($separated_filename[0], 0, (strlen($separated_filename[0])-1));
			$i++;
		}
		$separated_filename[0] = $separated_filename[0] . "$i";
		$_FILES[$nombre]['name'] = implode(".",$separated_filename);
	}
	$ruta =  $directorio . $nombreausar;
	$resultado_move_uploaded= move_uploaded_file ($file_temp,$ruta);
	if ($resultado_move_uploaded) {
		if ($debug) echo "<span class='texto'>Archivo A&ntilde;adido.</span>";
	} else {
		if ($debug) echo "<span class='texto'>Error al copiar el archivo.</span>";
		$ERROR=TRUE;
	}
	if ($debug) echo"<br>Ruta: $ruta<br />Nombre de la foto:" . $_FILES[$nombre]['name'] . "<br>";
	if ($ERROR) exit;
	$foto=$nombreausar;
	$valores_devolver=array(flag_archivo =>TRUE, url =>$foto);
	// si llegamos hasta aqui es que la foto subió, asi que flag_archivo es TRUE.
	return $valores_devolver;
}

function validar_archivo_nombre2($directorio,$nombre,$debug=TRUE,$nombreausar) {
	// $directorio: nombre del directorio destino CON slash al final.
	// $nombre: nombre del array que tiene la data del archivo dentro de $_FILES
	// $_FILES ['form_data']( <- $nombre) ['size']
	// $debug: ¿quieres ver output de lo que paso?
	$ERROR=FALSE; // si hay un error, EXIT;
	$_FILES[$nombre]['name'] = str_replace(' ', '_', $_FILES[$nombreausar]['name']);
	// esto susbtituye los espacios en blanco del filename por un underscore.
	if (file_exists($directorio . $_FILES[$nombre]['name'])) echo 'Existe un archivo con ese nombre.<br />Agregar&eacute; un n&uacute;mero al final del nombre del nuevo para no borrar el anterior.<br />';
	$i = 1;
	while (file_exists($directorio .  $_FILES[$nombreausar]['name'])) {
		$separated_filename = explode(".",$_FILES[$nombreausar]['name']);
		if (substr($separated_filename[0],-1) == $i) {
			$separated_filename[0] = substr($separated_filename[0], 0, (strlen($separated_filename[0])-1));
			$i++;
		}
		$separated_filename[0] = $separated_filename[0] . "$i";
		$_FILES[$nombreausar]['name'] = implode(".",$separated_filename);
	}
	$ruta =  $directorio . $_FILES[$nombreausar]['name'];
	$resultado_move_uploaded= move_uploaded_file ($_FILES[$nombre]['tmp_name'],$ruta);
	if ($resultado_move_uploaded) {
		if ($debug) echo "<span class='texto'>Archivo A&ntilde;adido.</span>";
	} else {
		if ($debug) echo "<span class='texto'>Error al copiar el archivo.</span>";
		$ERROR=TRUE;
	}
	if ($debug) echo"<br>Ruta: $ruta<br />Nombre de la foto:" . $_FILES[$nombre]['name'] . "<br>";
	if ($ERROR) exit;
	//$foto=$ruta;
	$foto=$_FILES[$nombre]['name'];
	$valores_devolver=array(flag_archivo =>TRUE, url =>$foto);
	// si llegamos hasta aqui es que la foto subió, asi que flag_archivo es TRUE.
	return $valores_devolver;
}

/////////////////////////////////////////////////////////


function valida_archivo_extension($nombre,$extensiones_validas) {
	// $nombre es el nombre del array dentro de FILES donde esta toda la data del archivo a subir.
	// es decir, $_FILES[$nombre]
	$pagina = explode (".",$_FILES[$nombre]['name']);
	$last = strtolower (end ($pagina));
	if (!in_array($last, $extensiones_validas)) {// si  la extension no es una de estas da error:
		echo "<p>Ese tipo de archivos no est&aacute; permitido. S&oacute;lo";
		foreach($extensiones_validas as $nombre=>$valor) {
			echo " $valor ";
		}
		echo '.';
		exit;
	}
}


////////////////////////////////////////////


function valida_archivo($nombre,$maximo,$minimo) { // tamaños en bytes
	if (is_uploaded_file($_FILES[$nombre]['tmp_name']))	{
		switch($_FILES[$nombre]['error']) {
			case 0: //no error
				break;
			case 1: //uploaded file exceeds the upload_max_filesize directive in php.ini
				echo "El tama&ntilde;o es mayor al l&iacute;mite del php.ini.<br />";
				exit;
				break;
			case 2: //uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form
				echo 'El tama&ntilde;o es mayor al l&iacute;mite establecido (' . $maximo .')';
				exit;
				break;
			case 3: //uploaded file was only partially uploaded
				echo 'S&oacute;lo recib&iacute; parte del archivo.<br />';
				exit;
				break;
			case 4: //no file was uploaded
				echo 'No hay archivo enviado.';
				exit;
				break;
			default: //a default error, just in case!  :)
				echo 'Error generico';
				exit;
				break;
		}
		if ($_FILES[$nombre]['size'] < $minimo)	{
			echo 'Error en el tama&ntilde;o, es menor al m&iacute;nimo permitido.<br />';
			echo 'Tama&ntilde;o del archivo: ' . $_FILES[$nombre]['size'];
			echo '<br />';
			exit;
		}
		if ($_FILES[$nombre]['size'] > $maximo)	{
			echo "Tama&ntilde;o m&aacute;ximo " .  ($maximo/1024) . " K.<br>";
			echo 'Tama&ntilde;o del archivo: ' . ($_FILES[$nombre]['size'] / 1024) . ' K.<br>';
			exit;
		}
	} else {
		echo 'Error. Reintenta.';
		exit;
	}
}
function ajustar_imagen($imagen, $ancho_i, $alto_i, $imagen_alterna){
	
	if(file_exists('thumb.php')){
		$archivo = 'thumb.php';
		$root = '';
	}else if(file_exists('../thumb.php')){
		$archivo = '../thumb.php';
		$root = '../';
	}else{
		die('No se encontro el archivo de conexi&oacute;n');
	}
  
  
  if(@$size=getimagesize($root.$imagen)){
    $imagen=$imagen;
  }else{
    $imagen=$imagen_alterna;
  }
  
  @$size=getimagesize($root.$imagen); // "Ancho=".$size[0]." y Alto=".$size[1];
  @$alto=$size[1]*$ancho_i/$size[0];
  if($alto){
    @$ancho=$size[0]*$alto_i/$size[1];
    if(($ancho-$ancho_i)>($alto-$alto_i)){
      return '<img src="'.$archivo.'?ruta='.$imagen.'&ancho='.$ancho_i.'&alto='.$alto.'" border="0" width="'.$ancho_i.'" height="'.$alto.'" />';
    }else{ 
      return '<img src="'.$archivo.'?ruta='.$imagen.'&ancho='.$ancho.'&alto='.$alto_i.'" border="0" width="'.$ancho.'" height="'.$alto_i.'" />';
    }
  }else{
    return 'ERROR';
  }
}


function ObtenerNavegador($user_agent) {
     $navegadores = array(
          'Opera' => 'Opera',
          'Mozilla Firefox'=> '(Firebird)|(Firefox)',
          'Galeon' => 'Galeon',
          'Mozilla'=>'Gecko',
          'MyIE'=>'MyIE',
          'Lynx' => 'Lynx',
          'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',
          'Konqueror'=>'Konqueror',
		  'Internet Explorer 10' => '(MSIE 10\.[0-9]+)',
		  'Internet Explorer 9' => '(MSIE 9\.[0-9]+)',
		  'Internet Explorer 8' => '(MSIE 8\.[0-9]+)',
          'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',
          'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',
          'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',
          'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',
		);
		
		foreach($navegadores as $navegador=>$pattern){
		   if (eregi($pattern, $user_agent))
		   return $navegador;
		}
		
		return 'Desconocido';
}



function getHost(){

	if($_SERVER['HTTP_HOST'] == 'localhost'){
		return "http://".$_SERVER['HTTP_HOST']."/wdxteventos/";
	}else{
		return "http://".$_SERVER['HTTP_HOST']."/";
	}
	
}


function getSiteActual(){
		
	if(strpos($_SERVER['REQUEST_URI'],'liga') != FALSE){
		return 'liga';
	}else if(strpos($_SERVER['REQUEST_URI'],'circuito') != FALSE){
		return 'circuito';
	}else{
		return '';
	}
		
}




?>