
<link href="css/calendario-interclubes.css" rel="stylesheet" type="text/css" />
<link href="css/grupos-interclubes.css" rel="stylesheet" type="text/css" />


<script>

	limpiarGrupos();


	function cargarCantEquipos(){
	
		inter_id = $('#interclubes').val();
	
		if(inter_id != ''){
			
			var param = 'opcion=cantidad&inter_id=' + inter_id;
			
			$.ajax({  
			 type: 'GET',  
			 url: 'control/ctrl_equipos.php',
			 dataType: 'json',
			 data: param,
			 success: function(arrayDeObjetos){
			 
					try{
						cantidad = arrayDeObjetos[0];
						$('#nro_equipos').val(cantidad);
						cambioEquiposByGrupos();
						
					}catch(ex){
						//$('#error_carga_info').html('No se pudo cargar su informaci&oacute;n, actualicela antes de realizar la inscripci&oacute;n');
					}
		      }  
			});
		
		}
		
	}
	
	
	function cambioEquiposByGrupos(){
	
		$('#msg_nro_equipos_x_grupos').html('');
		
		if($('#interclubes').val() != ''){
		
			var cantEquipos = parseInt($('#nro_equipos').val());
			var cantEquiposByGrupo = parseInt($('#nro_equipos_x_grupos').val());
			
			if(cantEquipos != '' && cantEquiposByGrupo != ''){
				
				if(cantEquiposByGrupo > 2 && cantEquiposByGrupo <= cantEquipos){
					cantGrupos = cantEquipos/cantEquiposByGrupo;
					
					if(cantGrupos > parseInt(cantGrupos)) cantGrupos = cantGrupos + 1;
					
					$('#nro_grupos').val(parseInt(cantGrupos));
					
				}else{
					$('#msg_nro_equipos_x_grupos').html('Debe ser minimo 3 y maximo '+cantEquipos);
					$('#nro_grupos').val(1);
				}
			
			}
			
		}else{
			$('#msg_nro_equipos_x_grupos').html('Debe seleccionar un torneo previamente cargado');
		}
	
	}
	
	function generarGrupos(){
		
		var interId = $('#interclubes').val();
		var cantEquiposByGrupo = parseInt($('#nro_equipos_x_grupos').val());
		var cantGrupos = parseInt($('#nro_grupos').val());
		
		if(interId != ''){
			if(confirm('Esto eliminará los grupos ya cargados. \u00BFDeseas hacerlo de todas formas? ')){
				$('#panelGrupos').html('');
				
				for(i=1;i<=cantGrupos;i++){
					
					agregarGrupo(interId, cantEquiposByGrupo, '', 'Grupo '+i, null);
					
				}
				
				inicializar_drag_and_drop();
			}
		}
	}
	
	function agregarGrupo(interId, cantEquiposByGrupo, grupoId, grupoNombre, equipos){
		
		var grupo = '<table class="grupo" grupoId="'+grupoId+'"><thead><tr><th colspan="'+(cantEquiposByGrupo+3)+'">'+grupoNombre+'</th></tr></thead>';
		grupo += '<tr><td></td><td>Nombre</td>';
		
		for(j=1;j<=cantEquiposByGrupo;j++){
			grupo += '<td>'+j+'</td>';
		}
	
		grupo += '<td>Ptos</td></tr>';

		for(j=1;j<=cantEquiposByGrupo;j++){
			
			if(equipos != null && equipos[j-1] != null){
			
				grupo += '<tr><td>'+j+'</td><td> <a href="mod_seleccionar_equipo.php?inter_id='+interId+'" class="fancybox.ajax equipo" equipoId="'+equipos[j-1].equipo_id+'"> '+equipos[j-1].equipo_nombre+' ('+equipos[j-1].club_nombre+')</a></td>';
			
			}else{
			
				grupo += '<tr><td>'+j+'</td><td> <a href="mod_seleccionar_equipo.php?inter_id='+interId+'" class="fancybox.ajax equipo"> Equipo '+j+'</a></td>';
			
			}
			
			for(k=1;k<=cantEquiposByGrupo;k++){
				grupo += '<td' + (j==k ? ' class="relleno"' : '') + '></td>';
			}
			
			grupo += '<td>0</td></tr>';
		}
		
		grupo += '</table>';
		
		$('#panelGrupos').append(grupo);
		
		
	}
	
	function inicializar_drag_and_drop(){

		$(".equipo").click(function() {
			elementoSel = $(this);
		});
		
		try{
		
			$(".equipo").fancybox();
			
			$(".equipo").each(function( index ) {
				$(this).draggable({ revert: true , helper: "clone" });
			});
			
			$(".equipo").each(function( index ) {
				$(this).droppable({
					drop: function( event, ui ) {
					
						var equipoTemp = $(this).clone();
						$(this).parent().html(ui.draggable.clone());
						ui.draggable.parent().html(equipoTemp);
						
						inicializar_drag_and_drop();
					
					}
				});
			});
			
		}catch(ex){
			console.error('No se pudo inicializar el drag and drop');
		}
		
		
	}
	
	function limpiarGrupos(){
		$('#panelGrupos').html('<p class="mensajeGrupo">No se han registrado grupos para el torneo</p>');
		$('#nro_equipos_x_grupos').removeAttr('disabled');
		$('#verDraw').css('display','none');
	}

	
	function guardarGrupos(){
	
		if (confirm('\u00BFDeseas guardar los grupos de los interclubes? ')) {
		
			var form =  document.forms.formInterclubes;
			
			var arrayGrupos = new Array();
			
			$('.grupo').each(function (index) {
			
				var grupo = new Array();
				grupo[0] = $(this).attr('grupoId');
				grupo[1] = $(this).find('th').html();
			
				var arrayEquipos = new Array();
			
				$(this).find('.equipo').each(function (index2) {
					
					arrayEquipos.push($(this).attr('equipoId'));
					
				});
				
				grupo[2] = arrayEquipos;
				arrayGrupos.push(grupo);
				
			});
			
			form.datosGrupos.value = JSON.stringify(arrayGrupos);
			form.opcion.value = 'guardar';
			
			$('#panelprincipal').hideLoading();	
			$('#panelprincipal').showLoading();	
			
			$.ajax({  
			 type: 'POST',  
			 url: 'control/ctrl_grupos.php',
			 //dataType: 'json',
			 data: $(form).serialize(),
			 //async: false
			 success: function(data){

				$('#mensajes').html(data);
				 cargarGrupos();
			 },
			 complete: function(){
			 
				$('#panelprincipal').hideLoading();	
			 
			 } 
			});
			
		}
		
		return false;
	
	}
	
	function cargarGrupos(){
	
		var ligaId = $('#liga').val();
		var interId = $('#interclubes').val();

		if(interId != ""){
			
			cargarCantEquipos();

			var cantEquiposByGrupo = parseInt($('#nro_equipos_x_grupos').val());
			
			var tieneGrupos = $('#tipo_torneo').val() == 'G';
			
			if(tieneGrupos){
			
				var param = 'opcion=consultaAll&inter_id=' + interId;

				$.ajax({  
				 type: 'GET',  
				 url: 'control/ctrl_grupos.php',
				 dataType: 'json',
				 data: param,
				 //async: false
				 success: function(arrayDeObjetos){
				 
					$('#panelGrupos').html('');
					
					for(i=0;i<arrayDeObjetos.length;i++){
						agregarGrupo(interId, cantEquiposByGrupo, arrayDeObjetos[i].intergrup_id, arrayDeObjetos[i].intergrup_nombre, arrayDeObjetos[i].equipos);
					}
					
					inicializar_drag_and_drop();

				  },
				  error: function(res, res2){
				  alert(res2);
				  }
				});
				
			}else{
				$('#nro_equipos_x_grupos').attr('disabled','disabled');
				$('#panelGrupos').html('<p class="mensajeGrupo">No aplica para este tipo de torneo</p>');
			}
			
			$('#botonVerDraw').attr('href','edicion_draw_interclubes.php?liga_id='+ligaId+'&inter_id='+interId);
			$('#verDraw').css('display','block');
				
		}
		
		return false;
	
	}
	
		
</script>


<label for="nro_equipos" class="textogris11b">Nro de Equipos</label><br>
<input type="number" id="nro_equipos" name="nro_equipos" size="20" disabled/>
<span id="msg_nro_equipos" class="error"></span>
<br>

<label for="nro_equipos_x_grupos" class="textogris11b">Equipos por grupos</label><br>
<input type="number" id="nro_equipos_x_grupos" name="nro_equipos_x_grupos" size="20" onChange="cambioEquiposByGrupos();generarGrupos();"/>
<span id="msg_nro_equipos_x_grupos" class="error"></span>
<br>

<label for="nro_grupos" class="textogris11b">Nro de Grupos</label><br>
<input type="number" id="nro_grupos" name="nro_grupos" size="20" disabled/>
<span id="msg_nro_grupos" class="error"></span>
<br>

<div id="verDraw">
	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<label for="botonVerDraw" class="textogris11b">Etapa Final</label><br><br>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<a id="botonVerDraw" title="Ver draw de la etapa final" href="edicion_draw_interclubes.php">
		<img src="../art/boton_ver_draw.png">
	</a>
	
	<br><br><br>
</div>

<input type="hidden" id="datosGrupos" name="datosGrupos" value="">

<div id="panelGrupos">
</div>
