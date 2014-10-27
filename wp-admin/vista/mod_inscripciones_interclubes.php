

<script>

	var elementoSel;

	function agregarTablaInscEquipo(){
		
		var fila = '<tr>';
		
		var ahora = new Date();
		
		fila += '<td>'+("0" + ahora.getDate()).slice(-2)+'/'+("0" + (ahora.getMonth()+1)).slice(-2)+'/'+ahora.getFullYear()+' '+("0" + ahora.getHours()).slice(-2)+':'+("0" + ahora.getMinutes()).slice(-2)+':'+("0" + ahora.getSeconds()).slice(-2)+'</td>';
		fila += '<td>'+'<a class="fancybox.ajax textogris11b" href="vista/mod_equipos.php?modulo=inscripcion">Equipo</a>'+'</td>';
		
		fila += '<td></td>'
		
		fila += '<td class="oculto"></td>';
		fila += '<td class="oculto"></td>';
		fila += '<td class="oculto"></td>';
		fila += '<td class="oculto"></td>';
		fila += '<td class="oculto"></td>';
		
		var i = $('#htmlgridInsc tbody').find ('tr').length + 1;
		
		fila += '<td>';
		fila += '<input type="radio" name="estatus'+i+'[]" value="A">Aprobar</input>';
		fila += '<input type="radio" name="estatus'+i+'[]" value="R">Rechazar</input>';
		fila += '</td>';
		fila += "<td><a onclick=\"if (confirm('\u00BFDeseas eliminar esta inscripcion del torneo? ')) { "+
						"$(this).parent().parent().slideUp('fast');" +
						" } \" style=\"cursor:pointer\">" +
						"<img src=\"../art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar inscripcion\"/></a></td>";
		fila += '</tr>';
		
		$('#htmlgridInsc tbody').prepend(fila);
		
		$("#htmlgridInsc tbody tr td a.textogris11b").fancybox();
		$("#htmlgridInsc tbody tr td a.textogris11b").click(function() {
			elementoSel = $(this);
		});
		
		pintarFilasInsc();
		
		return false;
		
	}
	
	
	function cargarInscripcionesEquipos(){
	
		var inter_id = $('#interclubes').val();
		
		$('#htmlgridInsc tbody').html('');
		
		if(inter_id  != ''){
			
			var json = geturl('control/ctrl_equipos.php', 'opcion=consultaAll&inter_id=' + inter_id + '&orden=equipo_fecha_insc DESC', 'GET');
			
			var inscripciones = jQuery.parseJSON(json);
			
			for(var i=0;i<inscripciones.length;i++){
				
				var fila = '<tr id="fila_'+i+'">';
				fila += '<td>'+inscripciones[i].equipo_fecha_insc+'</td>';
				
				fila += '<td>'+'<a class="fancybox.ajax textogris11b" href="vista/mod_equipos.php?modulo=inscripcion&equipo_id='+inscripciones[i].equipo_id+'">'+inscripciones[i].equipo_nombre+'</a>'+'</td>';
				fila += '<td>'+inscripciones[i].juga_nombre_full+'</td>';
				
				fila += '<td class="oculto">'+inscripciones[i].equipo_id+'</td>';
				fila += '<td class="oculto">'+inscripciones[i].club_id+'</td>';
				fila += '<td class="oculto">'+inscripciones[i].equipo_tipo_cancha+'</td>';
				fila += '<td class="oculto">'+inscripciones[i].juga_id+'</td>';
				fila += '<td class="oculto">'+inscripciones[i].equipo_email+'</td>';
				
				
				
				fila += '<td>';
				
				if(inscripciones[i].equipo_estatus == 'I'){
					//fila += 'Inscrito';
					fila += '<input type="radio" name="estatus'+i+'[]" value="A">Aprobar</input>';
					fila += '<input type="radio" name="estatus'+i+'[]" value="R">Rechazar</input>';
				}else if(inscripciones[i].equipo_estatus == 'A'){
					fila += '<input type="radio" name="estatus'+i+'[]" value="A" checked>Aprobado</input>';
					fila += '<input type="radio" name="estatus'+i+'[]" value="R">Rechazado</input>';
				}else if(inscripciones[i].equipo_estatus == 'R'){
					fila += '<input type="radio" name="estatus'+i+'[]" value="A">Aprobado</input>';
					fila += '<input type="radio" name="estatus'+i+'[]" value="R" checked>Rechazado</input>';
				}
				
				fila += '</td>';
				fila += "<td><a onclick=\"if (confirm('\u00BFDeseas eliminar esta inscripcion del torneo? ')) { "+
						"$(this).parent().parent().slideUp('fast');" +
						" } \" style=\"cursor:pointer\">" +
						"<img src=\"../art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar inscripcion\"/></a></td>";
				fila += '</tr>';
				
				$('#htmlgridInsc tbody').append(fila);
				pintarFilasInsc();
				
			}
			

			$("#htmlgridInsc tbody tr td a.textogris11b").fancybox();
			$("#htmlgridInsc tbody tr td a.textogris11b").click(function() {
				elementoSel = $(this);
			});
		}
		
	}
	
	
	function actualizarInscripcionesEquipos(){


		if (confirm('\u00BFDesea actualizar las inscripciones al torneo? ')) {
	

			var datosInsc = new Array(); 
				
				$("#htmlgridInsc tbody tr").each(function(row) { // this represents the row
					var elementoTr = $(this);
					var fila = new Array();
					 $(this).children("td").each(function (col) {

						switch(col){
							case 0: fila.push($(this).html()); break; //fecha de la inscripción
							case 1: fila.push($(this).children().html()); break; // nombre equipo
							case 2: fila.push($(this).html()); break; //nombre capitan
							case 3: fila.push($(this).html()); break; //equipoId
							case 4: fila.push($(this).html()); break; //clubId
							case 5: fila.push($(this).html()); break; //tipoCancha
							case 6: fila.push($(this).html()); break; //jugaId
							case 7: fila.push($(this).html()); break; //correo
							case 8: 
								if(elementoTr.is(":hidden")){ //estatus
									fila.push('E');
								}else{
									if($(this).children("input:checked").val()){
										fila.push($(this).children("input:checked").val());
									}else{
										fila.push('I');
									}
								}
								break;
						}	
						
					}); 
					datosInsc.push(fila);
				}); 
			
			
			//alert(JSON.stringify(datosInsc));
			
			$("#formInterclubes #datosInsc").attr('value',JSON.stringify(datosInsc));
			$("#formInterclubes #opcion").attr('value','actualizar');

			//$('#mensajes').html(geturl('control/ctrl_equipos.php', $("#formInterclubes").serialize(), 'POST'));
			//cargarInscripcionesEquipos();
			
			$('#panelprincipal').hideLoading();	
			$('#panelprincipal').showLoading();	
			
			$.ajax({  
			 type: 'POST',  
			 url: 'control/ctrl_equipos.php',
			 //dataType: 'json',
			 data: $("#formInterclubes").serialize(),
			 //async: false
			 success: function(data){

				$('#mensajes').html(data);
				 cargarInscripcionesEquipos();
			 },
			 complete: function(){
			 
				$('#panelprincipal').hideLoading();	
			 
			 } 
			});
			
		}
	}
	
	function limpiarTablaInsc(){
		$('#htmlgridInsc tbody').html('');
	}

	
	
	function pintarFilasInsc(){
	
		var cont = 1;
		$("#htmlgridInsc tbody tr").each(function (index) {
			if(cont % 2 == 0){
				$(this).css("background-color", "#e6e6e6");
			}else{
				$(this).css("background-color", "#ffffff");
			}
			cont++;
		});
	
	}
	
	
</script>



<input type="image" name="agregarInsc" id="agregarInsc" class="botonAgregar" value="agregar" src="../art/edit_add.png" onClick="return agregarTablaInscEquipo()">

<table id="htmlgridInsc" name="htmlgridInsc" class="tablaForm">
	<thead>
		<tr class="textoblanco12b">
			<th>Fecha Insc.</th>
			<th>Equipo</th>
			<th>Capit&aacute;n</th>
			<th class="oculto">EquipoId</th>
			<th class="oculto">ClubId</th>
			<th class="oculto">TipoCancha</th>
			<th class="oculto">JugaId</th>
			<th class="oculto">Correo</th>
			<th>Estatus</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<input type="hidden" name="datosInsc" id="datosInsc" value="">

<br>
<div style="float:right;width:auto;height:auto;display:block;padding:0;border:0;font-size:11px;" class="textogris11b">
<input type="checkbox" name="enviarCorreo">Enviar correo de notificaci&oacute;n
<a href="javascript:actualizarInscripcionesEquipos()"><img src="../art/boton_enviar.png"></a>
</div>
<br><br>