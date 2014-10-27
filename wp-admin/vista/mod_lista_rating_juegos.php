<?php

	require_once("../modelo/rating_config.php");
	require_once("../modelo/rating_juegos_hist.php");
	require_once("../modelo/rating_jugadores_hist.php");
	require_once("../modelo/jugadores.php");
	require_once("../../funciones.php");
	
	
	$obj = new rating_config('','','','','','','','');
	$obj->get_rating_config($_GET['rating']);
	
	$aux = new rating_juegos_hist('','','','','','','','','','','','','','','','','','');
	$jugadores = $aux->get_all_rating_juegos_hist($_GET['rating'],$_GET['cedula']);
	
	$jugador = new jugadores('','','','','','','','','','','','','','','','','','');
	$jugador->get_jugador($_GET['cedula']);
	
	echo '<p class="textogris11b"><a href="'.getHost().'admin/vista/mod_lista_rating.php?rating='.$_GET['rating'].'" class="link fancybox.ajax textoverdeesmeralda11b">'.$obj->raconf_nombre.'</a> > Hist&oacute;rico Rating '.utf8_decode($jugador->juga_apellido).' '.utf8_decode($jugador->juga_nombre).'</p>';
	
	
	echo '<table class="tablaForm">';
	echo '<thead><tr><th style="text-align:center">Torneo</th>';
	echo '<th style="text-align:center">Modalidad</th>';
	echo '<th style="text-align:center">Fecha</th>';
	
	if($obj->raconf_tipo == 'I'){
		echo '<th style="text-align:center">Jugador 1 (Puntos)</th>';
		echo '<th style="text-align:center">Jugador 2 (Puntos)</th>';
	}else{
		echo '<th style="text-align:center">Pareja 1 (Puntos)</th>';
		echo '<th style="text-align:center">Pareja 2 (Puntos)</th>';
	}
	
	echo '<th style="text-align:center">Resultado</th>';
	echo '<th style="text-align:center">Peso</th>';
	echo '<th style="text-align:center">Diferencia</th>';
	echo '<th style="text-align:center">Esperado</th>';
	echo '<th style="text-align:center">Ajuste</th>';
	echo '<th style="text-align:center">Rating Anterior</th>';
	echo '<th style="text-align:center">Rating Nuevo</th>';
	echo '<th style="text-align:center">Bono</th></tr></thead><tbody>';
	
	$i = 1;
	
	while ($row = mysql_fetch_assoc($jugadores)){
	
		$juga1PuntosAjuste = 0;
		$juga2PuntosAjuste = 0;
		$juga3PuntosAjuste = 0;
		$juga4PuntosAjuste = 0;

		$juga1PuntosAjuste = $row['juga1_puntos_ant'] + $row['rajue_ajuste'];
		$juga2PuntosAjuste = $row['juga2_puntos_ant'] + $row['rajue_ajuste'];

		$juga3PuntosAjuste = $row['juga3_puntos_ant'] - $row['rajue_ajuste'];
		$juga4PuntosAjuste = $row['juga4_puntos_ant'] - $row['rajue_ajuste'];
		
		if($juga1PuntosAjuste < 0) $juga1PuntosAjuste = 0;
		if($juga2PuntosAjuste < 0) $juga2PuntosAjuste = 0;
		if($juga3PuntosAjuste < 0) $juga3PuntosAjuste = 0;
		if($juga4PuntosAjuste < 0) $juga4PuntosAjuste = 0;
		
		$juga1PuntosAjuste = floor($juga1PuntosAjuste);
		$juga2PuntosAjuste = floor($juga2PuntosAjuste);
		$juga3PuntosAjuste = floor($juga3PuntosAjuste);
		$juga4PuntosAjuste = floor($juga4PuntosAjuste);
	
		$puntosAnt = 0;
		$puntosNuevo = 0;
	
		if($_GET['cedula'] == $row['juga_id1']){
			$puntosAnt = $row['juga1_puntos_ant'];
			$puntosNuevo = $juga1PuntosAjuste;
		}else if($_GET['cedula'] == $row['juga_id2']){
			$puntosAnt = $row['juga2_puntos_ant'];
			$puntosNuevo = $juga2PuntosAjuste;
		}else if($_GET['cedula'] == $row['juga_id3']){
			$puntosAnt = $row['juga3_puntos_ant'];
			$puntosNuevo = $juga3PuntosAjuste;
		}else if($_GET['cedula'] == $row['juga_id4']){
			$puntosAnt = $row['juga4_puntos_ant'];
			$puntosNuevo = $juga4PuntosAjuste;
		}
	
		for($j=0;$j<count($obj->raconf_categorias);$j++){
		
			if($obj->raconf_categorias[$j]->raconf_puntos_min <= $puntosAnt && $obj->raconf_categorias[$j]->raconf_puntos_max >= $puntosAnt){
				if($obj->raconf_categorias[$j]->raconf_puntos_max < $puntosNuevo){
					echo '<tr><td colspan="13" class="cambioCategoria">Cambio de categor&iacute;a (Sube de '
					.$obj->raconf_categorias[$j]->raconf_categoria.' a '
					.$obj->raconf_categorias[$j-1]->raconf_categoria.')</td></tr>';
				}
				
				if($obj->raconf_categorias[$j]->raconf_puntos_min > $puntosNuevo){
					echo '<tr><td colspan="13" class="cambioCategoria">Cambio de categor&iacute;a (Baja de '
					.$obj->raconf_categorias[$j]->raconf_categoria.' a '
					.$obj->raconf_categorias[$j+1]->raconf_categoria.')</td></tr>';
				}
				
				break;
			}
		
		}
	
		echo '<tr><td>'.$row['rajue_nombre_torneo'].'</td>';
		echo '<td>'.$row['rajue_modalidad_torneo'].'</td>';
		echo '<td style="text-align:center">'.$row['rajue_fecha'].'</td>';
		
		if($obj->raconf_tipo == 'I'){
		
			echo '<td style="text-align:center">'.$row['juga1_apellido'].' '.$row['juga1_nombre'].' ('.round($row['juga1_puntos_ant']).')</td>';
			echo '<td style="text-align:center">'.$row['juga3_apellido'].' '.$row['juga3_nombre'].' ('.round($row['juga3_puntos_ant']).')</td>';
			
			$diferencia = $row['juga1_puntos_ant'] - $row['juga3_puntos_ant'];
			
		}else{
		
			echo '<td style="text-align:center">'.$row['juga1_apellido'].' '.$row['juga1_nombre'].' ('.round($row['juga1_puntos_ant']).')';
			echo ' y '.$row['juga2_apellido'].' '.$row['juga2_nombre'].' ('.round($row['juga2_puntos_ant']).')</td>';
			echo '<td style="text-align:center">'.$row['juga3_apellido'].' '.$row['juga3_nombre'].' ('.round($row['juga3_puntos_ant']).')';
			echo ' y '.$row['juga4_apellido'].' '.$row['juga4_nombre'].' ('.round($row['juga4_puntos_ant']).')</td>';
			
			$diferencia = ($row['juga1_puntos_ant'] + $row['juga2_puntos_ant']) - ($row['juga3_puntos_ant'] + $row['juga4_puntos_ant']);
			
		}
		
		$ajuste = $row['rajue_ajuste'];
		
		if($_GET['cedula'] == $row['juga_id3'] || $_GET['cedula'] == $row['juga_id4']){
			$ajuste = $ajuste * -1;
		}
		
		if(($_GET['cedula'] == $row['juga_id1'] || $_GET['cedula'] == $row['juga_id2']) && $row['rajue_ganador'] == 1){
			$ganador = 'Gano';
		}else if(($_GET['cedula'] == $row['juga_id3'] || $_GET['cedula'] == $row['juga_id4']) && $row['rajue_ganador'] == 0){
			$ganador = 'Gano';
		}else{
			$ganador = 'Perdio';
		}
		
		echo '<td style="text-align:center">'.$ganador.'</td>';
		echo '<td style="text-align:center">'.$row['rajue_peso'].'</td>';
		
		if($_GET['cedula'] == $row['juga_id3'] || $_GET['cedula'] == $row['juga_id4']){
			$diferencia = $diferencia * -1;
		}
		
		echo '<td style="text-align:center">'.$diferencia.'</td>';
		
		if($_GET['cedula'] == $row['juga_id3'] || $_GET['cedula'] == $row['juga_id4']){
			echo '<td style="text-align:center">'.(100-($row['rajue_esperado']*100)).'%</td>';
		}else{
			echo '<td style="text-align:center">'.($row['rajue_esperado']*100).'%</td>';
		}
		
		
		
		echo '<td style="text-align:center">'.round($ajuste).'</td>';
	
		echo '<td style="text-align:center">'.round($puntosAnt).'</td>';
		echo '<td style="text-align:center">'.$puntosNuevo.'</td>';
		
		echo '<td></td></tr>';
		
		$i++;
	
	}
	
	echo '</tbody></table>';
	
	echo "<script> $('.link').fancybox(); </script>";
	
?>