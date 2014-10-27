<?php

	session_start();

	require_once("../modelo/usuarios.php");
	
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
		
		if($_POST['modulo']=='registro'){
		
			if($_POST['telf_cel']!=''){
				$telefono = $_POST['telf_cel'];
			}else if($_POST['telf_hab']!=''){
				$telefono = $_POST['telf_hab'];
			}

		
			$obj = new usuarios('',utf8_decode($_POST['nombre']." ".$_POST['apellido']),$_POST['email'],
								$telefono,$_POST['password'],'Normal');
								
			if($obj->guardar()){
			
				include("ctrl_jugadores.php");
				
				$mensaje = file_get_contents('correos/Mensaje_Web_Registro.html');
		
				echo $mensaje;
				
				/* Se manda el correo */
				$_POST['emails_destinos'] = $_POST['email'];
				$_POST['asunto'] = "Bienvenido a dxteventos.com";
				$_POST['cuerpo'] = "registro";
				include('ctrl_enviar_email.php');
				
				/*
				echo "<p>Registro realizado satisfactoriamente. <br><br>Ahora puede iniciar sesi&oacute;n 
						con lo que podr&aacute; realizar inscripciones en linea a los torneos y actualizar sus datos personales.</p>";       
						*/
				
			}
		
		}else{
		
			$obj = new usuarios($_POST['usuario'],$_POST['nombre'],$_POST['email'],
								$_POST['telefono'],$_POST['password'],$_POST['tipo']);
		
		
			if($obj->guardar()){
			
				//include("../vista/mod_modalidades.php");
				echo "<br>Operaci&oacute;n realizada satisfactoriamente.<br>";
				
			}
		
		}

		
		
	}else if($_POST['opcion']=='recuperar'){
		
		$obj = new usuarios('','','','','','');
		
		if($obj->get_usuario_by_email($_POST['email'])){
			
			$mensaje = file_get_contents('correos/Mensaje_Web_Recuperar.html');
			
			echo $mensaje;
			
			/* Se manda el correo */
			
			$code = sha1(mt_rand().time().mt_rand().$_SERVER['REMOTE_ADDR']);

			$obj->guardar_code($code);
			
			$_POST['codigo'] = $code;
			$_POST['emails_destinos'] = $_POST['email'];
			$_POST['asunto'] = "Recuperacion de contraseña";
			$_POST['cuerpo'] = "recuperar";
			include('ctrl_enviar_email.php');
			
		}
		
		
	}else if($_POST['opcion']=='eliminar'){
		
		$obj = new usuarios('','','','','','');
		
		if($obj->eliminar($_POST['usuario'])){
		}
		
	}else if($_GET['opcion']=='consulta'){
	
		$obj = new usuarios('','','','','','');
		$obj->get_usuario($_GET['usuario']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $obj; 
		
		echo json_encode($arrayDeObjetos);
	
	}else if($_GET['opcion']=='existe'){
	
		$obj = new usuarios('','','','','','');
		$existe = $obj->existe_usuario($_GET['email']);
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $existe; 
		
		echo json_encode($arrayDeObjetos);
		
	}else if($_GET['opcion']=='validaClave'){
	
		$obj = new usuarios('','','','','','');
		
		$obj->get_usuario_by_email($_SESSION['email']);
		
		$res = $obj->usua_clave == $_GET['clave'];
		
		$arrayDeObjetos = array(); 
		$arrayDeObjetos[0] = $res; 
		
		echo json_encode($arrayDeObjetos);
		
		
	}else if($_POST['opcion']=='cambiar2'){
	
		$obj = new usuarios('','','','','','');
		$obj->get_usuario($_POST['usua_id']);		
		$obj->usua_clave = $_POST['password'];
		
		if($obj->guardar()){
			
			$mensaje = file_get_contents('correos/Mensaje_Web_Cambio.html');
			
			echo $mensaje;
			
		}
	
	}else if($_POST['opcion']=='cambiar'){
	
		$obj = new usuarios('','','','','','');
		
		echo $_SESSION['email'];
		
		$obj->get_usuario_by_email($_SESSION["email"]);		
		$obj->usua_clave = $_POST['password'];
		
		if($obj->guardar()){
			
			$mensaje = file_get_contents('correos/Mensaje_Web_Cambio.html');
			
			echo $mensaje;
			
		}
		
	}
	
	
			
?>
