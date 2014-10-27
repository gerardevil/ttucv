

<script type="text/javascript">

	$(document).ready(function() {
		
		//if(path.indexOf('admin')!=-1){
			$(".jugadores").fancybox();
		//}
		
	});


	function filtrar_jugadores(){
	
		
	}
	
	
	$(function(){
	
		$('#filtrar').click(function(e){
	
			$('#tablaJugador tbody').html('');
			
			var param = 'opcion=consultaAll&buscar=' + $('#filtro').val();
			
			//$('#tablaJugador').hideLoading();
			//$('#tablaJugador').showLoading();
				
			$.ajax({  
				 type: 'GET',  
				 url: getHost()+'wp-admin/control/ctrl_jugadores.php',
				 dataType: 'json',
				 data: param,
				 success: function(arrayDeObjetos){
				 
					
					if(arrayDeObjetos != null){
						for(var i=0;i<arrayDeObjetos.length;i++){
						
							var fila = '<tr'+((i+1) % 2 == 0 ? ' class="even"' : '')+'>';
							
							if(window.location.pathname.indexOf('admin')==-1){
							
								fila += '<td><a href="'+getHost()+'ficha_jugador.php?cedula='+arrayDeObjetos[i].juga_id+'" class="jugadores fancybox.ajax textogris11r">'
										+arrayDeObjetos[i].juga_nombre_full+'</a></td><td></td>';
							
							}else{
							
								fila += '<td><a href="#" class="textogris11r" onClick="return seleccionar_jugador('+arrayDeObjetos[i].juga_id+')">'
										+arrayDeObjetos[i].juga_nombre_full+'</a></td><td></td>';
							
							}
							
							fila += '</tr>'
					
							$("#tablaJugador tbody").append(fila);
						}
					}
					
					
				  },
				complete: function(){
					//$('#tablaJugador').hideLoading();
				}  
			});

			e.preventDefault();
			
		
		});
	
	});
	
</script>



<form id="formBuscarJugador" name="formBuscarJugador" class="formEstilo">
	<fieldset>
	
		<div id="busca_error_carga_info" class="error"></div>
	
		<div id="panelFiltrado">
	
			<input type="text" id="filtro" name="filtro" placeholder="Especificar el nombre" size="30"><button href="#" id="filtrar" name="filtrar">Buscar</button>
			
		</div>

		<br><br>
		
		<div class="contenedorScroll">
			<table id="tablaJugador" name="tablaJugador" class="tablaForm">
				<thead>
					<tr class="textoblanco12b">
						<th>Jugador</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		
	</fieldset>
	
</form>