<?php 

	
	$retornar = false;
	
	if($_POST['cuerpo'] == "invitacion"){
	
		$body = file_get_contents('correos/Email_Invitacion_Jugador.html');
		//$body = preg_replace('/[\]/','',$body);
		$body = str_replace('<Jugador>',$_POST['juga_nombre'],$body);
		$retornar = true;
		
	}else if($_POST['cuerpo'] == "registro"){
	
		$body = file_get_contents('correos/Email_Registro.html');
		//$body = preg_replace('/[\]/','',$body);
		$body = str_replace('<usuario>',$_POST['email'],$body);
		$body = str_replace('<clave>',$_POST['password'],$body);
		
	}else if($_POST['cuerpo'] == "inscripcion"){
	
		$body = file_get_contents('correos/Email_Recepcion_Inscripcion.html');
		//$body = preg_replace('/[\]/','',$body);
		$body = str_replace('<torneo>',$_POST['evento_nombre'],$body);
		$body = str_replace('<modalidad>',$_POST['modalidades'],$body);
	
	}else if($_POST['cuerpo'] == "aprobada"){
	
		$body = file_get_contents('correos/Email_Inscripcion_Aceptada.html');
		//$body = preg_replace('/[\]/','',$body);
		$body = str_replace('<torneo>',$_POST['evento_nombre'],$body);
		$body = str_replace('<modalidad>',$_POST['modalidades'],$body);
		
	}else if($_POST['cuerpo'] == "rechazada"){
	
		$body = file_get_contents('correos/Email_Inscripcion_Rechazada.html');
		//$body = preg_replace('/[\]/','',$body);
		$body = str_replace('<torneo>',$_POST['evento_nombre'],$body);
		$body = str_replace('<modalidad>',$_POST['modalidades'],$body);
		
	}else if($_POST['cuerpo'] == "recuperar"){
	
		$body = file_get_contents('correos/Email_Recuperar_Clave.html');
		//$body = preg_replace('/[\]/','',$body);
		$body = str_replace('<codigo>',$_POST['codigo'],$body);
	}else if($_POST['cuerpo'] == "inscripcionInterclubes"){
	
		$body = file_get_contents('correos/Email_Recepcion_Inscripcion_Interclubes.html');
		//$body = preg_replace('/[\]/','',$body);
		$body = str_replace('<torneo>',$_POST['evento_nombre'],$body);
		$body = str_replace('<categoria>',$_POST['evento_categoria'],$body);
		$body = str_replace('<equipo>',$_POST['equipo_nombre'],$body);
		
	}else{
		$body = $_POST['cuerpo'];
		$retornar = false;
	}
	
	
	
	

	/*$cabeceras = 'From: info@dxteventos.com' . "\r\n" .
    'Reply-To: webmaster@dxteventos.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();*/
/*
	// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Cabeceras adicionales
	//$cabeceras .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
	$cabeceras .= 'From: DxT Eventos <info@dxteventos.com>' . "\r\n";
	//$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
	//$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
	
	$enviado = mail($_POST['emails_destinos'],$_POST['asunto'],$_POST['cuerpo'],$cabeceras);
	echo $enviado;
*/
	
	//error_reporting(E_ALL);
	//error_reporting(E_STRICT);
	
	date_default_timezone_set('America/Caracas');

	
	if(file_exists('../modelo/class.phpmailer.php')){
		require_once('../modelo/class.phpmailer.php');
	}else if(file_exists('../wp-admin/modelo/class.phpmailer.php')){
		require_once('../wp-admin/modelo/class.phpmailer.php');
	}else{
		require_once('wp-admin/modelo/class.phpmailer.php');
	}
	
	
	$mail = new PHPMailer();
	//$mail->IsSMTP(); // telling the class to use SMTP
	//$mail->IsMail();
	
	//v=spf1 ip4:216.97.237.203 -all
	
	
try {
	/*
	$mail->Host          = "mail.dxteventos.com";
	$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	//$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 26;                   // set the SMTP port for the GMAIL server
	*/
	
	$mail->IsSMTP(); // telling the class to use SMTP
	//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 587;                
	$mail->Username      = "webmaster@dxteventos.com"; // SMTP account username
	$mail->Password      = "WebmasterDxT13";        // SMTP account password
	
	if($_POST['correo_emisor'] != ""){
		$mail->SetFrom($_POST['correo_emisor'], '');
	}else{
		$mail->SetFrom('webmaster@dxteventos.com', 'Dxt Eventos');
	}
	
	if($_POST['correo_responder'] != ""){
		$mail->AddReplyTo($_POST['correo_responder'], '');
	}
	
	$correos = explode(",", $_POST['emails_destinos']);
	if(count($correos) > 1){
		for($i = 0; $i < count($correos); $i++){
			$mail->AddAddress($correos[$i], "");
		}
	}else{
		$mail->AddAddress($_POST['emails_destinos'], "");
	}
	
	$mail->AddBCC("gerardevil@gmail.com");
	
	$mail->Subject       = $_POST['asunto'];	
		
	$mail->MsgHTML($body);

	$enviado = $mail->Send();
/*
  if(!$enviado) {
    echo "Mailer Error (" . str_replace("@", "&#64;", $_POST['emails_destinos']) . ') ' . $mail->ErrorInfo . '<br />';
  } else {
    echo "Message sent to : Gerardo Linares (" . str_replace("@", "&#64;", $_POST['emails_destinos']) . ')<br />';
  }
*/	
	if($retornar) echo $enviado;	
	

} catch (phpmailerException $e) {
  echo "<br>".$e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo "<br>".$e->getMessage(); //Boring error messages from anything else!
}
	
?>