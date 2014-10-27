<?php


	require_once("../modelo/inscripciones_eventos.php");
	
	
	$obj = new inscripciones_eventos('','','','','');
	
	$row = $obj->get_inscripcion_pago($_GET['evmo_id'],$_GET['juga_id']);
	
	$row['juga1_nombre'] = utf8_encode($row['juga1_nombre']);
	$row['juga1_apellido'] = utf8_encode($row['juga1_apellido']);
	$row['juga1_nombre_full'] = ucwords(strtolower($row['juga1_apellido'].", ".$row['juga1_nombre']));
	$row['juga2_nombre'] = utf8_encode($row['juga2_nombre']);
	$row['juga2_apellido'] = utf8_encode($row['juga2_apellido']);
	$row['juga2_nombre_full'] = ucwords(strtolower($row['juga2_apellido'].", ".$row['juga2_nombre']));

	echo '<span class="textoverdeesmeralda12b">Modalidad: </span>';
	echo '<span class="textogris12r">'.$row['moda_nombre'].'</span><br><br><br>';
	echo '<table class="tablaForm"><tr><th>Jugador</th><th>Monto</th><th>Estatus</th></tr>';
	echo '<tr class="textogris12r"><td>'.$row['juga1_nombre_full'].'</td><td>'.$row['inpa_monto1'].' Bs</td><td>';
	if($row['inpa_estatus1']=='P'){
		echo 'Pagado';
	}else if($row['inpa_estatus1']=='E'){
		echo 'En proceso de pago';
	}else if($row['inpa_estatus1']=='I'){
		echo 'Impaga';
	}
	echo '</td></tr>';
	
	if($row['juga2_nombre'] != null){
	
		echo '<tr class="textogris12r"><td>'.$row['juga2_nombre_full'].'</td><td>'.$row['inpa_monto2'].' Bs</td><td>';
		if($row['inpa_estatus2']=='P'){
			echo 'Pagado';
		}else if($row['inpa_estatus2']=='E'){
			echo 'En proceso de pago';
		}else if($row['inpa_estatus2']=='I'){
			echo 'Impaga';
		}
		echo '</td></tr>';
		
	}
	
	echo '</table>';


?>