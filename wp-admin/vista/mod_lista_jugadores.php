<?php

	require_once("../modelo/equipos.php");

    $obj = new equipos('','','','','','','','','','');
	
	if($_GET['equipo_id'] != ''){
	
		$equipo = $obj->get_equipo($_GET['equipo_id']);
			
		echo '<div class="lista" equipoId="'.$_GET['equipo_id'].'">';
		
		echo '<br>';

		echo '<table class="tablaForm">';
		echo '<thead><tr>';
		echo '<th width="310">Jugador</th>';
		echo '<th width="110">Categor&iacute;a</th>';
		echo '<th width="210">Correo</th>';
		echo '<th>Ranking Individual</th>';
		echo '<th>Ranking Doble</th>';
		echo '</tr></thead>';

		$jugadores = $obj->get_lista_jugadores($_GET['equipo_id'],'');
		
		while($jugador = mysql_fetch_assoc($jugadores)){
		
			echo '<tr>';
			echo '<td>'.$jugador['juga_id'].' - '.$jugador['juga_nombre'].' '.$jugador['juga_apellido'];
			if($equipo->equipo_email == $jugador['juga_email']){
				echo ' (<span class="textoverdeesmeralda11b">C</span>)';
			}
			echo '</td>';
			echo '<td>'.$jugador['juga_categoria'].'</td>';
			echo '<td>'.$jugador['juga_email'].'</td>';
			echo '<td>'.$jugador['eqju_rank_individual'].'</td>';
			echo '<td>'.$jugador['eqju_rank_doble'].'</td>';
			echo '</tr>';
		
		}
		
		echo '</table><br>';

		echo '</div>';
	
	}
?>
