

<script>
	
	var elementoSel = null;
	var registrar = true;
	
	function agregarJugador(tabla){
		
		
		var fila = '<tr><td><a class="fancybox.ajax linkJugador textogris11b" href="'+getHost()+'admin/mod_seleccionar_jugador.php">Usuario</a></td>';
		
		fila += '<td></td>';
		
		fila += "<td><a onclick=\"if (confirm('\u00BFDeseas eliminar este usuario del equipo? ')) { "+
				"$(this).parent().parent().fadeOut('normal');" +
				" } \" style=\"cursor:pointer\">" +
				"<img src=\""+getHost()+"art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar usuario\"/></a></td>";
		
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
				<th>Usuario</th>
				<th>Correo</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			
				require_once('../../funciones.php');
			
				if($_GET['equipo_id'] != ''){
				
					require_once('../modelo/equipos.php');
					$obj = new equipos('','','','','','','','','','');
					$jugadores = $obj->get_lista_usuarios($_GET['equipo_id']);
					
					while ($row = mysql_fetch_assoc($jugadores)){
						
						$fila = '<tr><td><a class="fancybox.ajax linkJugador textogris11b" href="'.getHost().'admin/mod_seleccionar_jugador.php">';
						
						$fila .= $row['juga_id'].' - '.$row['juga_nombre'].' '.$row['juga_apellido'].'</a></td>';
		
						$fila .= '<td>'.$row['juga_email'].'</td>';
						
						$fila .= "<td><a onclick=\"if (confirm('\u00BFDeseas eliminar este usuario del equipo? ')) { ".
								"$(this).parent().parent().fadeOut('normal');" .
								" } \" style=\"cursor:pointer\">" .
								"<img src=\"".getHost()."art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar usuario\"/></a></td>";
						
						$fila .= '</tr>';
						
						echo $fila;
					}
				}
				
			?>
		</tbody>
	</table>
</div>
