

<script>
	
	var elementoSel = null;
	var registrar = true;
	
	function agregarJugador(tabla){
		
		var ranks = '<select>';
		for(i=1;i<=30;i++)
			ranks += '<option>'+i+'</option>';
		ranks += '</select>';
		
		
		var fila = '<tr><td><a class="fancybox.ajax linkJugador textogris11b" href="'+getHost()+'wp-admin/mod_seleccionar_jugador.php">Jugador</a></td>';
		
		fila += '<td></td>';
		fila += '<td>'+ranks+'</td>';
		fila += '<td>'+ranks+'</td>';
		
		fila += "<td><a onclick=\"if (confirm('\u00BFDeseas eliminar esta inscripcion del torneo? ')) { "+
				"$(this).parent().parent().fadeOut('normal');" +
				" } \" style=\"cursor:pointer\">" +
				"<img src=\""+getHost()+"art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar jugador\"/></a></td>";
		
		fila += '</tr>';
		
		tabla.append(fila);
		
		$('.linkJugador').fancybox().click(function(e){
			elementoSel = $(this);
		});
		
		return false;
		
	}
	
	
	$(document).ready(function(){
		
		var botonAgregar = $('.botonAgregar');
		
		botonAgregar.unbind();
		
		botonAgregar.click(function(e){
			e.preventDefault();
			agregarJugador($(this).parent().next().children().first());
		});
		
		botonAgregar.attr('src',getHost()+'art/edit_add'+ (getSiteActual() != '' ? '_' + getSiteActual() : '') +'.png');
		
		$('.linkJugador').fancybox().click(function(e){
			elementoSel = $(this);
		});
		
	});

</script>



<div style="display: block; width: 600px; height: 40px;">
<input type="image" class="botonAgregar">
</div>
<div class="contenedorScroll">
	<table id="tablaJugadores" name="tablaJugadores" class="tablaForm" style="width:600px">
		<thead>
			<tr class="textoblanco12b">
				<th>Jugador</th>
				<th>Correo</th>
				<th>Ranking Individual</th>
				<th>Ranking Double</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			
				
				
				if(file_exists('../funciones.php')){
					require_once('../funciones.php');
				}else if(file_exists('../../funciones.php')){
					require_once('../../funciones.php');
				}
				
			
				if($_GET['equipo_id'] != ''){
				
				
					if(file_exists('../modelo/equipos.php')){
						require_once('../modelo/equipos.php');
					}else if(file_exists('../wp-admin/modelo/equipos.php')){
						require_once('../wp-admin/modelo/equipos.php');
					}

					$obj = new equipos('','','','','','','','','','');
					$jugadores = $obj->get_lista_jugadores($_GET['equipo_id'],'');
					
					while ($row = mysql_fetch_assoc($jugadores)){
						
						$fila = '<tr><td><a class="fancybox.ajax linkJugador textogris11b" href="'.getHost().'wp-admin/mod_seleccionar_jugador.php">';
						
						$fila .= $row['juga_id'].' - '.$row['juga_nombre'].' '.$row['juga_apellido'].'</a></td>';
						
						$rankSingle = '<select>';
						$rankDoble = '<select>';
						
						for($i=1;$i<=30;$i++){
							$rankSingle .= '<option'.($i==$row['eqju_rank_individual'] ? ' selected ' : '').'>'.$i.'</option>'; 
							$rankDoble .= '<option'.($i==$row['eqju_rank_doble'] ? ' selected ' : '').'>'.$i.'</option>'; 
						}
						
						$rankSingle .= '</select>';
						$rankDoble .= '</select>';
						
						$fila .= '<td>'.$row['juga_email'].'</td>';
						$fila .= '<td>'.$rankSingle.'</td>';
						$fila .= '<td>'.$rankDoble.'</td>';
						
						$fila .= "<td><a onclick=\"if (confirm('\u00BFDeseas eliminar esta inscripcion del torneo? ')) { ".
								"$(this).parent().parent().fadeOut('normal');" .
								" } \" style=\"cursor:pointer\">" .
								"<img src=\"".getHost()."art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar jugador\"/></a></td>";
						
						$fila .= '</tr>';
						
						echo $fila;
					}
				}
				
			?>
		</tbody>
	</table>
</div>
