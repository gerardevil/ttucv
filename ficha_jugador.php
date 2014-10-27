<?php

session_start();

if($_SESSION["usuario"]==""){

		echo('<div class="mensaje error">Debe iniciar sesi&oacute;n para poder acceder a esta secci&oacute;n.</div>');
		
}else{

	require_once("wp-admin/modelo/jugadores.php");
	require_once("wp-admin/modelo/clubes.php");
	require_once("wp-admin/modelo/estados.php");
	require_once("funciones.php");
	require_once("GoogChart.class.php");

	$jugador = new jugadores('','','','','','','','','','','','','','','','','','');
	$jugador->get_jugador($_GET['cedula']);

	if($jugador->juga_id == ''){
		die("No se encontro el jugador.");
	}

	$jugador->juga_apellido = utf8_decode($jugador->juga_apellido);
	$jugador->juga_nombre = utf8_decode($jugador->juga_nombre);

?>

<link href="estilos.css" rel="stylesheet" type="text/css" />

<style>
body {
	background: #e5e5e5;
}
</style>


<script type="text/javascript">
	$(document).ready(function() {
	
		$(".ficha").fancybox();
		
	});
</script>


<?php

	//if($jugador->juga_ficha_perfil == '+'){
	
?>
<div id="seccionFicha">


<?php

	//}
	
?>

	<div id="seccionDatos">
		<div id="nombreJugador">
			<?php echo ucwords(strtolower($jugador->juga_apellido." ".$jugador->juga_nombre))
						.($jugador->juga_alias != null && $jugador->juga_alias != '' ? " - alias ".$jugador->juga_alias : ""); ?>
		</div>
		<div id="datosJugador">
			<div id="datosContenedorJugador">
				<img id="fotoJugador" src="<?php 
												if($jugador->juga_foto==null) 
													echo getHost()."art/eventos/no_disponible.jpg";
												else
													echo getHost()."art/jugadores/".$jugador->juga_foto;
											?>" width="140" height="140">
				<div id="datosBasicosJugador">
					<label>Club: </label>
					<span>
						<?php 
							if($jugador->club_id==null){ 
								echo "No Especificado"; 
							}else{
								$club = new clubes('','');
								$club->get_club($jugador->club_id);
								echo $club->club_nombre;
							} 
						?>
					</span><br><br>
					<label>Categor&iacute;a: </label>
					<span>
						<?php 
							if($jugador->juga_categoria==null || $jugador->juga_categoria==''){ 
								echo "No Especificado"; 
							}else{
								echo $jugador->juga_categoria;
							} 
						?>
					</span><br><br>
					<label>Sexo: </label><span>
						<?php 
							if($jugador->juga_sexo==null || $jugador->juga_sexo==''){ 
								echo "No Especificado"; 
							}else{
								echo $jugador->juga_sexo == 'M' ? 'Masculino' : 'Femenino';
							}
						?></span><br><br>
									
<?php

	if($jugador->juga_ficha_perfil == '+'){
	
?>
					<label>Fecha Nac.: </label>
					<span>
						<?php 
							if($jugador->juga_fecha_nac==null){
								echo "No Especificado"; 
							}else{
								echo date("d/m/Y",strtotime($jugador->juga_fecha_nac));
							}
						?></span><br><br>
					<label>Ubicaci&oacute;n: </label>
					<span>
						<?php 
							if($jugador->edo_id==null && ($jugador->juga_ciudad==null || $jugador->juga_ciudad=='')){ 
								echo "No Especificado"; 
							}else{
								$estado = new estados('','');
								$estado->get_estado($jugador->edo_id);
								echo $estado->edo_nombre.($jugador->juga_ciudad==null || $jugador->juga_ciudad=='' ? "" : ", ".$jugador->juga_ciudad);
							} 
						?>
					</span>
					
<?php

	}
	
?>
				</div>
			</div>
			
<?php

	if($jugador->juga_ficha_perfil == '+'){
	
?>

			<div id="datosContactoJugador">
				<label>Correo: </label>
				<span>
					<?php 
						if($jugador->juga_email==null || $jugador->juga_email==''){ 
							echo "No Especificado"; 
						}else{
							echo $jugador->juga_email;
						} 
					?>
				</span><br><br>
				<label>Tel&eacute;fonos: </label>
				<span>
					<?php 
						if(($jugador->juga_telf_hab==null || $jugador->juga_telf_hab=='') 
							&& ($jugador->juga_telf_ofic==null || $jugador->juga_telf_ofic=='') 
							&& ($jugador->juga_telf_cel==null || $jugador->juga_telf_cel=='')){ 
							
								echo "No Especificado"; 
								
						}else{
							if($jugador->juga_telf_hab!=null && $jugador->juga_telf_hab!='') 
								echo $jugador->juga_telf_hab;
							if($jugador->juga_telf_ofic!=null && $jugador->juga_telf_ofic!='') 
								echo ($jugador->juga_telf_hab!=null && $jugador->juga_telf_hab!='' ? ", " : "").$jugador->juga_telf_ofic;
							if($jugador->juga_telf_cel!=null && $jugador->juga_telf_cel!='') 
								echo (($jugador->juga_telf_hab!=null && $jugador->juga_telf_hab!='') || ($jugador->juga_telf_ofic!=null && $jugador->juga_telf_ofic!='') ? ", " : "").$jugador->juga_telf_cel;
						} 
					?>
				</span><br><br>
				<label>Twitter: </label>
				<span>
					<?php 
						if($jugador->juga_twitter==null || $jugador->juga_twitter==''){ 
							echo "No Especificado"; 
						}else{
							echo $jugador->juga_twitter;
						} 
					?>
				</span>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label>Facebook: </label>
				<span>
					<?php 
						if($jugador->juga_facebook==null || $jugador->juga_facebook==''){ 
							echo "No Especificado"; 
						}else{
							echo $jugador->juga_facebook;
						} 
					?>
				</span><br><br>
			</div>

<?php

	}else{
		echo "<p align=\"center\" class=\"textogris11r\">".ucwords(strtolower($jugador->juga_nombre))." no permite la visualizaci&oacute;n de sus otros datos personales</p>";
	}
	
?>			

		</div>
		<div id="estadisticasJugador">
			<table>
				<tr>
					<th>Torneos jugados</th>
					<th>Modalidades jugadas</th>
					<th>Juegos jugados</th>
					<th>Juegos ganados</th>
					<th>Juegos perdidos</th>
				</tr>
				<tr>
					<?php  
						$row = $jugador->get_cant_juegos_jugados($_GET['cedula']);
						if($row){
							echo "<td>".$row['cant_eventos']."</td>\n";
							echo "<td>".$row['cant_modalidades']."</td>\n";
							echo "<td>".$row['cant_juegos']."</td>\n";
							$ganados = $jugador->get_cant_juegos_ganados($_GET['cedula']);
							echo "<td>".($ganados ? $ganados : "0")."</td>\n";
							$perdidos = $jugador->get_cant_juegos_perdidos($_GET['cedula']);
							echo "<td>".($perdidos ? $perdidos : "0")."</td>\n";
						}else{
							echo "<td>N/A</td>\n";
							echo "<td>N/A</td>\n";
							echo "<td>N/A</td>\n";
							echo "<td>N/A</td>\n";
							echo "<td>N/A</td>\n";
						}
					?>
				</tr>
			</table>
			
			<div id="estadisticasContenedor">
				<div id="mejorResultado">
					<label>Mejor resultado:</label>
					<br><br>
					<?php
						$row = $jugador->get_mejor_resultado($_GET['cedula']);
						if($row){
							if($row['ronda_id'] == 8 && (($_GET['cedula'] == $row['juga_id1'] || $_GET['cedula'] == $row['juga_id2']) && $row['draw_ganador'] == 1)){
								echo "<span>PRIMER LUGAR</span><br><br>";
							}else if($row['ronda_id'] == 8 && (($_GET['cedula'] == $row['juga_id3'] || $_GET['cedula'] == $row['juga_id4']) && $row['draw_ganador'] == 2)){
								echo "<span>PRIMER LUGAR</span><br><br>";
							}else if($row['ronda_id'] == 8 && (($_GET['cedula'] == $row['juga_id1'] || $_GET['cedula'] == $row['juga_id2']) && $row['draw_ganador'] == 2)){
								echo "<span>SEGUNDO LUGAR</span><br><br>";
							}else if($row['ronda_id'] == 8 && (($_GET['cedula'] == $row['juga_id3'] || $_GET['cedula'] == $row['juga_id4']) && $row['draw_ganador'] == 1)){
								echo "<span>SEGUNDO LUGAR</span><br><br>";
							}else{
								echo "<span>".$row['ronda_nombre']."</span><br><br>";
							}
							echo "<span>".$row['moda_nombre']."</span><br><br>";
							echo "<span>".$row['even_nombre']."</span><br><br>";
						}else{
							echo "<span>No se encontro ninguna participaci&oacute;n</span>";
						}
					?>
				</div>
				<div id="grafica">
					<label>Relaci&oacute;n ganados y perdidos:</label>
					<!--<br><br>
					<img src="art/eventos/no_disponible.jpg" width="100" height="70">-->
					<?php
						
						$chart = new GoogChart();
						$data = array(
									'Ganados' => ($ganados ? $ganados : 0),
									'Perdidos' => ($perdidos ? $perdidos : 0)
								);

						$color = array(
									'#72b84c',
									'#3C3C3C'
								);
								
						$legenda = array(
									'Ganados '.($ganados ? round($ganados*100/($ganados+$perdidos)) : 0).'%',
									'Perdidos '.($perdidos ? round($perdidos*100/($ganados+$perdidos)) : 0).'%'
								);
						
						$chart->setChartAttrs( array(
							'type' => 'pie-3d',
							'data' => $data,
							'size' => array( 200, 100 ),
							'color' => $color,
							));
							
						$chart->setLegendArray( $legenda );
						$chart->setLabelsArray( null );
						
						echo $chart;
						
					?>
				</div>
			</div>
		</div>
		

<?php

	//}
	
?>

	</div>

<?php

	//if($jugador->juga_ficha_perfil == '+'){
	
?>
	
	<div id="seccionJuegos">
		<div class="tituloFicha"><img src="<?php echo getHost(); ?>art/vineta_blanca.png">Pr&oacute;ximos Juegos</div>
		<div id="proximosJuegosJugador">
			<?php
				$juegos = $jugador->get_proximos_juegos($_GET['cedula']);
				if($juegos){
				
					$row_juego = mysql_fetch_assoc($juegos);
					$fechaAnt = null;
					
					do{
						if($row_juego){
							
							$fecha = new DateTime($row_juego['draw_fecha']);
							if($fechaAnt != $fecha->format('Y/m/d')){
								echo "<div class=\"subTituloFicha\">".get_dia_semana($fecha->format("N")).", ".$fecha->format("d")." de ".get_nombre_mes($fecha->format("m"))."</div>";
								$fechaAnt = $fecha->format('Y/m/d');
							}
							
							echo "<p align=\"left\">";
									echo $fecha->format('g:ia')."<br>";
									echo $row_juego['moda_nombre']."<br>";
							echo "</p>";
							echo "<p align=\"center\">";
									echo ($row_juego['juga_id1']==111111 ? $row_juego['juga1_nombre'] : ucwords(strtolower($row_juego['juga1_apellido']." ".$row_juego['juga1_nombre'])));
									
									if($row_juego['juga_id2'] != null){
										echo " / ".($row_juego['juga_id2']==111111 ? $row_juego['juga2_nombre'] : ucwords(strtolower($row_juego['juga2_apellido']." ".$row_juego['juga2_nombre'])));
									}		
							//echo "</p>";
							
									echo "<br>vs<br>";
									
							//echo "<p align=\"center\">";
									echo ($row_juego['juga_id3']==111111 ? $row_juego['juga3_nombre'] : ucwords(strtolower($row_juego['juga3_apellido']." ".$row_juego['juga3_nombre'])));
									
									if($row_juego['juga_id4'] != null){
										echo " / ".($row_juego['juga_id4']==111111 ? $row_juego['juga4_nombre'] : ucwords(strtolower($row_juego['juga4_apellido']." ".$row_juego['juga4_nombre'])));
									}
									
							echo "</p>";
							
						}else{
							echo "<p align=\"center\">No tiene juegos programados proximamente</p>";
							break;
						}
					}while($row_juego = mysql_fetch_assoc($juegos));
					
				}else{
					echo "<p align=\"center\">No tiene juegos programados proximamente</p>";
				}
			?>
		</div>
		<div class="tituloFicha"><img src="<?php echo getHost(); ?>art/vineta_blanca.png">Resultados</div>
		<div id="resultadosJugador">
			<?php
				$juegos = $jugador->get_resultados($_GET['cedula']);
				if($juegos){
				
					$row_juego = mysql_fetch_assoc($juegos);
					$evenAnt = -1;
					$modaAnt = -1;
					
					do{
						if($row_juego){
							
							if($evenAnt != $row_juego['even_id']){
								if($evenAnt != -1) echo "</ul>";
								echo "<div class=\"subTituloFicha\">".$row_juego['even_nombre']."</div>";
								$evenAnt = $row_juego['even_id'];
								echo "<ul>";
							}
							
							if($modaAnt != $row_juego['evmo_id']){
								echo "<li><a href=\"".getHost()."resultados_jugador.php?cedula=".$_GET['cedula']."&evmo_id=".$row_juego['evmo_id']."\" class=\"ficha fancybox.ajax\">".$row_juego['moda_nombre']."</a></li>";
								$modaAnt = $row_juego['evmo_id'];
							}
				
						}else{
							echo "<p align=\"center\">No ha participado en ningun torneo</p>";
							break;
						}
					}while($row_juego = mysql_fetch_assoc($juegos));
					
				}else{
					echo "<p align=\"center\">No ha participado en ningun torneo</p>";
				}
			?>
		</div>
	</div>
</div>

	
<?php

}
	
?>