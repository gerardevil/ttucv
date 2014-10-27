<?php

	require_once('../modelo/clubes.php');
	require_once('../modelo/jugadores.php');
	require_once('../modelo/equipos.php');
	require_once('../modelo/interclubes_liga.php');
	require_once('../modelo/interclubes_categorias.php');


?>


<script>
	
	function cargarEquipos(){
	
		var interId = $('#interclubes').val();			
		
		if(interId != ''){
		
			var param = 'opcion=consultaAll&inter_id=' + interId;
			
			try{
				$('#accordion').html('');
				$('#accordion').accordion('destroy');
			}catch(ex){
			}
		
			$('#accordion').hideLoading();
			$('#accordion').showLoading();
		
			var json = $.ajax({  
			 type: 'GET',  
			 url: getHost()+'admin/control/ctrl_equipos.php',
			 dataType: 'json',
			 data: param,
			 //async: false
			 success: function(arrayDeObjetos){

					var html = '';
					
					for(var i=0;i<arrayDeObjetos.length;i++){
					
						html += '<h3 class="textogris12b" equipoId="'+arrayDeObjetos[i].equipo_id+'">'+arrayDeObjetos[i].equipo_nombre;
						html += '</h3><div class="lista" equipoId="'+arrayDeObjetos[i].equipo_id+'"></div>';
					
					}
					
					$('#accordion').html(html);
					
					$('.lista').each(function(){
					
						var contenedor = $(this);
						var equipoId = contenedor.attr('equipoId');
					
						//contenedor.hideLoading();
						//contenedor.showLoading();

					
						$.get(getHost()+'admin/vista/mod_equipos_jugadores.php', {equipo_id : equipoId}, function(data) {
						  //contenedor.hideLoading();
						  contenedor.html(data);
						});
					});
							
				
					$('#accordion').accordion({
					  heightStyle: "content",
					  collapsible: true,
					  active: false
					});
				
					$('#accordion').css({
						'height':'340px',
						'overflow-y':'scroll'
					});		
				
				
					//$('#listaEquipos li').removeClass('selected');
					/*
					$('.equipo').click(function(e){
					
						e.preventDefault();
						
						if($(this).parent().hasClass('selected')){
							$(this).parent().removeClass('selected');
						}else{
							$(this).parent().addClass('selected');
						}
					});
					*/
			  },
			   complete: function(){
				$('#accordion').hideLoading();
			 }
			});
			
		
		}
	
	}
	
	function cargarCategorias(){
	
			//$('#panelPrincipal').hideLoading();	
			//$('#panelPrincipal').showLoading();	
			
			$('#interclubes').html('<option value=""><Ingresar Nuevo></option>');
			
			var ligaId = $('#liga').val();
			
			if(ligaId != ''){
			
				var param = 'opcion=consultaAllAbiertas&liga=' + ligaId;  
		
				$.ajax({  
				 type: 'GET',  
				 url: getHost()+'admin/control/ctrl_interclubes.php',
				 dataType: 'json',
				 data: param,
				 //async: false
				 success: function(arrayDeObjetos){

						//alert(arrayDeObjetos);
						
						for(i=0;i<arrayDeObjetos.length;i++){
							$('#interclubes').append('<option value="'+arrayDeObjetos[i].inter_id+'">'+arrayDeObjetos[i].inter_nombre+'</option>');
						}
				  },
				 complete: function(){
					//$('#panelPrincipal').hideLoading();
				  }
				});
				
			}else{
				$('#panelEquipos').html('');
			}
	}
	
	
	
	
	function limpiarInfo(){
		$('#formCapitan').each (function(){
		  this.reset();
		});
		
		$('#accordion').html('');
	}
	
	
	
	function guardarInfo(){
	
		var equiposJugadores = new Array(); 
			
		$("#accordion h3").each(function(row) { // this represents the row 
			var equipoId = $(this).attr('equipoId');
			 $(this).next().find('a.linkJugador').each(function (col) {
				var jugadores = new Array();
				var temp = $(this).html().split(" - ");
				if(temp[0] != 'Jugador' && $(this).parent().parent().css('display') != 'none'){
					jugadores.push(equipoId); 
					jugadores.push(temp[0]);
					jugadores.push($(this).parent().next().next().children().first().val());//rankIndividual
					jugadores.push($(this).parent().next().next().next().children().first().val());//rankDoble						
					equiposJugadores.push(jugadores);
				}
			}); 
		}); 
		
		
		$('#opcion').val('guardarListaJugadores');
		$('#equiposJugadores').val(JSON.stringify(equiposJugadores));
		
		var form =  $('#formCapitan');
		
		try{
			$('div.correcto').remove();
		}catch(ex){ }
		
		
		$('#panelprincipal').hideLoading();
		$('#panelprincipal').showLoading();
		
		$.ajax({  
		 type: 'POST',  
		 url: getHost()+'admin/control/ctrl_equipos.php',
		 //dataType: 'json',
		 data: form.serialize(),
		 success: function(respuesta){
			
			$('#panelprincipal').prepend('<div class="correcto">'+respuesta+'</div>');
			$('div.correcto').delay(10000).fadeOut();
		 
		 },
		 complete: function(){
			$('#panelprincipal').hideLoading();
		 }
		});
		
	}
	
</script>


<form id="formCapitan" name="formCapitan" class="formEstilo2 textogris12r" method="post">
				
	<label for="liga" class="textogris11b">Liga Interclubes</label>
	<select name="liga"  id="liga" class="textogris11r" onChange="cargarCategorias()">
		<option value=""><Ingresar Nuevo></option>
		<?php 
			$obj = new interclubes_liga('','','','','','');
			$interclubes = $obj->get_all_ligas_abiertas();
			
			$res = $obj->get_liga_defaut();
			$default = mysql_fetch_assoc($res);

			if($default) $vevento = $default['liga_id'];
			else $vevento = -1;

			
			while ($row_interclubes = mysql_fetch_assoc($interclubes)){ 
		?>
		<option value="<?php echo $row_interclubes['liga_id']; ?>" <?php if ($vevento==$row_interclubes['liga_id']) { ?> selected <?php } ?>><?php echo $row_interclubes['liga_nombre']; ?></option>
		<?php  } ?>
	</select>
	
	     
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				
	<label for="interclubes" class="textogris11b">Categor&iacute;a</label>
	<select id="interclubes" name="interclubes" class="textogris11r" onChange="cargarEquipos()">
		<option></option>
		<?php
		
			$obj = new interclubes_categorias('','','','','','','','','');
			$interclubes = $obj->get_all_categorias_abiertas($default['liga_id']);
		
			while ($row_interclubes = mysql_fetch_assoc($interclubes)){

				echo "<option value=\"".$row_interclubes['inter_id']."\">"
						.$row_interclubes['inter_nombre']."</option>";
			
			}
		
		?>
	</select>
	<span id="msg_interclubes" class="error"></span><br><br>
	
	<input type="hidden" id="equiposJugadores" name="equiposJugadores" value="" >
	<input type="hidden" id="opcion" name="opcion" value="" >
	
	<div style="text-align:center; width:100%;">
	<label class="textoverdeesmeralda12b">Lista de Jugadores</label>
	</div>
	<br><br>
	<div id="accordion">
	</div>
	
	<br>

	<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
		<tr>
			<td width="50" height="50" align="left">
				<button name="nuevo" type="reset" value="nuevo" width="50" height="50" onClick="limpiarInfo()">
					<img src="../art/filenew.png"> Nuevo
				</button>
			</td>
			<td width="50" height="50" align="left">
				<button name="guardar" type="button" value="guardar" width="50" height="50" onClick="guardarInfo()">
					<img src="../art/filesave.png"> Guardar
				</button>
			</td>
			<td width="600">
			</td>
		</tr>
	</table>

</form>