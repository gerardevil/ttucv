<?php

require_once("../modelo/interclubes_categorias.php");
require_once("../modelo/interclubes_liga.php");

$vdeporte = 1;

/*
echo $_GET['depo_id']."<br>";
echo $_GET['even_id']."<br>";
*/


?>

<!--<link rel="stylesheet" href="css/jquery-ui-1.10.3.min.css">-->
<!--
<script src="../scripts/jquery.min-1.7.2.js"></script>
<script src="scripts/jquery-ui-1.10.3.min.js"></script>
<script src="scripts/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" src="../scripts/jquery.fancybox.pack.js"></script>
-->
<!--
<link rel="stylesheet" href="css/jquery-ui-1.10.3.min.css">

<script src="scripts/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="scripts/jquery.fancybox.pack.js"></script>
<script src="scripts/jquery-ui-1.10.3.min.js"></script>
-->

<link href="css/calendario-interclubes.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="scripts/calendario-interclubes.js"></script>

<script>

	var partidosJornadas = new Array();
	var elementoSel;
	var elemJornadaAnt;
	
	function limpiar_info(){

		limpiarJornadas();

		$('#juegosJornada').html('');
		$('#datosGrupos').css('display','none');
		$('#formJornadas').each (function(){
		  this.reset();
		});
		
		$('#mensajes').html('');
		partidosJornadas = new Array();
		elementoSel = null;
		elemJornadaAnt = null

	}
	
	
	function actualizarJornadas(){
	
		var cantJornadas = $('#nro_jornadas').val();
		if(cantJornadas > 0){

			limpiarJornadas();
			for(i=1;i<=cantJornadas;i++){
				agregarJornada(i);
			}
			
			$('.jornada').each(function (index) {
				$(this).attr('onClick','cargarPartidos(this)');
			});
			
		}else{
			alert('El numero de jornadas no puede ser menor a 1');
			$('#nro_jornadas').val(1);
		}
		
	}
	
	
	function cargarPartidos(elem){
	
		var cantPartidos = $('#nro_equipos').val();
		var interId = $('#interclubes').val();
		var equipoDescansa = false;
		
		if(cantPartidos > 0){
		
			var nroJornada = parseInt($(elem).html());
			
			if(elemJornadaAnt != null){
				var nroJornadaAnt = parseInt($(elemJornadaAnt).html());
				partidosJornadas[nroJornadaAnt] = $('#juegosJornada').html();
			}	
			
			elemJornadaAnt = elem;
			
			$('.jornada').each(function (index) {
				$(this).removeClass('selected');
			});
				
			$(elem).addClass('selected');
			
			if(partidosJornadas[nroJornada] == undefined || partidosJornadas[nroJornada] == null || partidosJornadas[nroJornada] == ''){
				
				$('#juegosJornada').html('<div class="textoverdeesmeralda12b" style="text-align:center; height:50px;">Jornada '+nroJornada+'</div>');
				
				if($('#datosGrupos').css('display')=='none'){
				
					if(cantPartidos % 2 > 0) equipoDescansa = true;
			
					cantPartidos = parseInt(cantPartidos / 2);
				
					for(i=1;i<=cantPartidos;i++){
						agregarPartido(null,interId);
					}

					if(equipoDescansa) agregarEquipoDescanso(null,interId);
					
					inicializar_drag_and_drop();
					
				}else{
					
					var cantGrupos = $('#nro_grupos').val();
					var cantEquiposXGrupos = $('#nro_equipos_x_grupos').val();
					
					
					if(cantEquiposXGrupos % 2 > 0) equipoDescansa = true;
				
					cantPartidos = parseInt(cantEquiposXGrupos / 2);
					
					if(cantGrupos > 0){
					
						var param = 'opcion=consultaAll&inter_id=' + interId;

						$('#panelprincipal').hideLoading();	
						$('#panelprincipal').showLoading();	
						
						$.ajax({  
						 type: 'GET',  
						 url: 'control/ctrl_grupos.php',
						 dataType: 'json',
						 data: param,
						 success: function(arrayDeObjetos){
							
							for(i=0;i<arrayDeObjetos.length;i++){
							
								$('#juegosJornada').append('<div class="textogris12b" style="text-align:left; height:50px;">'+arrayDeObjetos[i].intergrup_nombre+'</div>');
								
								for(j=1;j<=cantPartidos;j++){
									agregarPartido(null,interId,arrayDeObjetos[i].intergrup_id);
								}
								
								if(equipoDescansa) agregarEquipoDescanso(null,interId,arrayDeObjetos[i].intergrup_id);
							}
							
							inicializar_drag_and_drop();

						  },
						 complete: function(){
							
							$('#panelprincipal').hideLoading();
							
						  }
						});
						
					}else{
					
					}
					
					
				}

				
			}else{

				$('#juegosJornada').html(partidosJornadas[nroJornada]);
				
				inicializar_drag_and_drop();
				
			}
		
		}else{
			alert('El numero de equipos no puede ser menor a 1');
			$('#nro_equipos').val(1);
		}
		
	}
	
	
	function cambioEquipos(){
	
		var cantEquipos = $('#nro_equipos').val();
		var cantGrupos = $('#nro_grupos').val();
		var cantEquiposXGrupos = $('#nro_equipos_x_grupos').val();
		var cantJornadasRegistradas = $('#nro_jornadas').val();
		var equipoDescansa = false;
		var cantJornadas;
		
		if(cantEquipos > 1){

			if($('#datosGrupos').css('display')=='none'){
			
				cantJornadas = cantEquipos - 1;
				if(cantEquipos % 2 > 0) cantJornadas = cantJornadas+1;
				if(document.getElementById('ida_vuelta').checked) cantJornadas = cantJornadas * 2;
				if(cantJornadasRegistradas > cantJornadas){ 
					cantJornadas = cantJornadasRegistradas;
					document.getElementById('ida_vuelta').checked = true;
				}
				$('#nro_jornadas').val(cantJornadas);
				actualizarJornadas();
				
			}else{
			
				cantJornadas = cantEquiposXGrupos - 1;
				if(cantEquiposXGrupos % 2 > 0) cantJornadas = cantJornadas+1;
				if(document.getElementById('ida_vuelta').checked) cantJornadas = cantJornadas * 2;
				if(cantJornadasRegistradas > cantJornadas){ 
					cantJornadas = cantJornadasRegistradas;
					document.getElementById('ida_vuelta').checked = true;
				}
				$('#nro_jornadas').val(cantJornadas);
				actualizarJornadas();
			
			}
			
		}else{
			alert('El numero de equipos no puede ser menor a 2');
			$('#nro_equipos').val(1);
		}
			
	}
	
	
	
	function inicializar_drag_and_drop(){

		$(".equipo, .data").click(function() {
			elementoSel = $(this);
		});
		
		
		try{
		
			$(".equipo").fancybox();
			$(".data").fancybox();
		
		}catch(ex){
			
			console.error('No se pudo inicializar el fancybox');
		
		}		
		
		try{
			
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
	
	function cargar_interclubes(){
		
		var inter_id = $('#interclubes').val();
		$('#nro_jornadas').val('');

		$('#juegosJornada').html('');
		limpiarJornadas();
		
		
		$('#mensajes').html('');
		partidosJornadas = new Array();
		elementoSel = null;
		elemJornadaAnt = null

		if(inter_id != ""){
			var form =  document.forms.formInscripcion;
			
			var param = 'opcion=cantidad&inter_id=' + inter_id;
			
			try{
			
				var json = $.ajax({  
				 type: 'GET',  
				 url: 'control/ctrl_equipos.php',
				 dataType: 'json',
				 data: param,
				 //async: false
				 success: function(arrayDeObjetos){
				 
					try{

						$('#nro_equipos').val(arrayDeObjetos[0]);
						$('#nro_jornadas').val(arrayDeObjetos[2]);
						if(arrayDeObjetos[1].inter_tipo == 'G'){
							$('#nro_equipos_x_grupos').val(arrayDeObjetos[1].inter_cant_equipos_x_grupo);
							cambioEquiposByGrupos();
							$('#datosGrupos').css('display','block');
						}
						
						cambioEquipos();
						
						cargarCalendario();
						
					}catch(ex){
						console.error(ex);
						//$('#error_carga_info').html('No se pudo cargar su informaci&oacute;n, actualicela antes de realizar la inscripci&oacute;n');
					}
					
				  }
				});
				
			}catch(ex){
				console.error(ex);
				//$('#error_carga_info').html('No se pudo cargar su informaci&oacute;n, actualicela antes de realizar la inscripci&oacute;n');
			}

		}else{
			limpiar_info();
		}
		
	}


	function guardar_info(){
	
		if(confirm('\u00BFDeseas guardar el calendario? ')) {
			
			$('#juegosJornada').append('<div id="temp" class="oculto"></div>');
			var temp = $('#temp');
			
			var arrayJornadas = new Array();
			
			$('#panelprincipal').hideLoading();	
			$('#panelprincipal').showLoading();
			
			for(var i=1;i<partidosJornadas.length;i++){
				if(partidosJornadas[i] != undefined && partidosJornadas[i] != null && partidosJornadas[i] != ''){

					temp.html(partidosJornadas[i]);

					temp.find('.partido , .descansa').each(function(){
					
						var arrayPartido = new Array();
						
						var jornId = $(this).attr('jornId');
						
						if(jornId != 'undefined'){
							arrayPartido[0] = jornId; 
						}else{
							arrayPartido[0] = '';
						}
						
						arrayPartido[1] = i; //jorn_numero
						arrayPartido[2] = $(this).children().first().find('a').attr('equipoId'); //equipo1
						arrayPartido[3] = $(this).children().eq(2).find('a').attr('equipoId'); //equipo2
						arrayPartido[4] = $(this).children().eq(1).find('a').attr('fecha'); //jorn_fecha
						arrayPartido[5] = $(this).children().eq(1).find('a').attr('home'); //jorn_home
						
						var grupo = $(this).children().first().find('a').attr('intergrupId');
						if(grupo != 'undefined'){
							arrayPartido[6] = grupo; //intergrup_id
						}else{
							arrayPartido[6] = '';
						}
						
						var ganador = $(this).attr('ganador');
						if(ganador != 'undefined'){
							arrayPartido[7] = ganador;
						}else{
							arrayPartido[7] = '';
						}
						
						var score = $(this).attr('score');
						if(score != 'undefined'){
							arrayPartido[8] = score; 
						}else{
							arrayPartido[8] = '';
						}
						
						arrayJornadas.push(arrayPartido);
						
					});
				}
			}
			
			temp.remove();
			
			$('#datosCalendario').val(JSON.stringify(arrayJornadas));
			$('#opcion').val('guardar');
			
			
			
			$.ajax({  
				 type: 'POST',  
				 url: 'control/ctrl_jornadas.php',
				 //dataType: 'json',
				 data: $('#formJornadas').serialize(),
				 success: function(obj){
				 
					$('#mensajes').html(obj);

					
					partidosJornadas = new Array();
					elementoSel = null;
					elemJornadaAnt = null

					
					cargarCalendario();
				 
				 },
				 error: function(obj){
				 
					$('#mensajes').html('<span class="error">'+obj+'<span>');
				 
				 },
				 complete: function(){
				 
					$('#panelprincipal').hideLoading();	
					
				 }
				});
			
			
			
		}
	
	}
	
	
	function eliminar_info(){
	
		var interId = $('#interclubes').val();
		
		if(interId != ''){
	
			if(confirm('\u00BFDeseas eliminar TODO el calendario? ')) {
				
				var param = 'opcion=eliminar&inter_id='+interId
				
				$.ajax({  
					 type: 'POST',  
					 url: 'control/ctrl_jornadas.php',
					 //dataType: 'json',
					 data: param,
					 success: function(obj){
					 
						$('#mensajes').html(obj);
					 
					 },
					 error: function(obj){
					 
						$('#mensajes').html(obj);
					 
					 }
					});
				
			}
			
		}else{
			$('#msg_interclubes').html('Debes especificar un torneo');
		}
	
	}
	
	
	function cargarCalendario(){
	
		var interId = $('#interclubes').val();
	
		if(interId != ''){
		
			var param = 'opcion=consultaAll&inter_id='+interId;
				
			$.ajax({  
				 type: 'GET',
				 url: getHost()+'admin/control/ctrl_jornadas.php',
				 dataType: 'json',
				 data: param,
				 async: false,
				 success: function(arrayDeObjetos){
				 
					if(arrayDeObjetos.length > 0){
					
						var nroJornada = 0;
						var grupoId = 0;
						var tieneGrupos = arrayDeObjetos[0].intergrup_id != null;
						var equipoDescansa = false;
						var nroPartidoGrupo;
							
						partidosJornadas = new Array();
						
						var cantEquipos = $('#nro_equipos').val();
						var cantGrupos = $('#nro_grupos').val();
						var cantEquiposXGrupos = $('#nro_equipos_x_grupos').val();
						
						if(tieneGrupos){
							if(cantEquiposXGrupos % 2 > 0) equipoDescansa = true;
							cantPartidos = parseInt(cantEquiposXGrupos / 2);
						}else{
							if(cantEquipos % 2 > 0) equipoDescansa = true;
							cantPartidos = parseInt(cantEquipos / 2);
						}
						nroPartidoGrupo = 1;
						
						for(j=0;j<arrayDeObjetos.length;j++){
						
							if(nroJornada != arrayDeObjetos[j].jorn_numero){
								nroJornada = arrayDeObjetos[j].jorn_numero;
								$('#juegosJornada').html('<div class="textoverdeesmeralda12b" style="text-align:center; height:50px;">Jornada '+nroJornada+'</div>');
								nroPartidoGrupo = 1;
							}
							
							if(tieneGrupos && grupoId != arrayDeObjetos[j].intergrup_id){
								$('#juegosJornada').append('<div class="textogris12b" style="text-align:left; height:50px;">'+arrayDeObjetos[j].intergrup_nombre+'</div>');
								grupoId = arrayDeObjetos[j].intergrup_id;
								nroPartidoGrupo = 1;
							}
							
							if(nroPartidoGrupo<=cantPartidos){
								agregarPartido(arrayDeObjetos[j],interId,arrayDeObjetos[j].intergrup_id);
							}else{
								agregarEquipoDescanso(arrayDeObjetos[j],interId,arrayDeObjetos[j].intergrup_id);
							}
							
							partidosJornadas[nroJornada] = $('#juegosJornada').html();
							
							nroPartidoGrupo++;
							
						}
						
						$('#juegosJornada').html(partidosJornadas[1]);
						$('.jornada').first().addClass('selected');
						inicializar_drag_and_drop();
					
					}else{
						$('#juegosJornada').html('');
					}
				 },
				 error: function(obj){
				 
					$('#mensajes').html('error');
				 
				 },
				 complete: function(){
				 
					//$('#panelprincipal').hideLoading();	
				 
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
			
				var param = 'opcion=consultaAll&liga=' + ligaId;  
		
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
				
			}
	}

	
	$(function() {
		$( document ).tooltip({
		  position: {
			my: "center bottom-20",
			at: "center top",
			using: function( position, feedback ) {
			  $( this ).css( position );
			  $( "<div>" )
				.addClass( "arrow" )
				.addClass( feedback.vertical )
				.addClass( feedback.horizontal )
				.appendTo( this );
			}
		  }
		});
	  });
</script>

<div id="mensajes" name="mensajes" class="textoverdeesmeralda11b"></div>

<form name="formJornadas" id="formJornadas" class="formEstilo2"  enctype="multipart/form-data" action="control/ctrl_jornadas.php">


<label for="liga" class="textogris11b">Liga Interclubes</label>
<select name="liga" class="textogris11r" id="liga" onChange="cargarCategorias()">
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

<select name="interclubes" class="textogris11r" id="interclubes" onChange="cargar_interclubes()">
	<option value="" ><Ingresar Nuevo></option>
	<?php 
		if($default){
	
			$obj = new interclubes_categorias('','','','','','');
			$interclubes = $obj->get_all_categorias_abiertas($default['liga_id']);

			while ($row_interclubes = mysql_fetch_assoc($interclubes)){ 
	?>
				<option value="<?php echo $row_interclubes['inter_id']; ?>" <?php if ($vevento==$row_interclubes['inter_id']) { ?> selected <?php } ?>><?php echo $row_interclubes['inter_nombre']; ?></option>
	<?php   } 
	
		}
	?>
</select>
<span id="msg_interclubes" class="error"></span>     
<br><br>

<label for="ida_vuelta" class="textogris11b">Jornadas ida y vuelta</label><br>
<input type="checkbox" id="ida_vuelta" name="ida_vuelta" onChange="cambioEquipos()"/>
<span id="msg_ida_vuelta" class="error"></span>
<br>

<label for="nro_equipos" class="textogris11b">Nro de Equipos</label><br>
<input type="number" id="nro_equipos" name="nro_equipos" size="20" onChange="cambioEquipos()" disabled/>
<span id="msg_nro_equipos" class="error"></span>
<br>

<div id="datosGrupos">

	<label for="nro_equipos_x_grupos" class="textogris11b">Equipos por grupos</label><br>
	<input type="number" id="nro_equipos_x_grupos" name="nro_equipos_x_grupos" size="20" disabled/>
	<span id="msg_nro_equipos_x_grupos" class="error"></span>
	<br>

	<label for="nro_grupos" class="textogris11b">Nro de Grupos</label><br>
	<input type="number" id="nro_grupos" name="nro_grupos" size="20" disabled/>
	<span id="msg_nro_grupos" class="error"></span>
	<br>

</div>

<label for="nro_jornadas" class="textogris11b">Nro de Jornadas</label><br>
<input type="number" id="nro_jornadas" name="nro_jornadas" size="20" onChange="actualizarJornadas()" disabled/>
<span id="msg_nro_jornadas" class="error"></span>
<br><br>

<div class="textoverdeesmeralda12b" style="text-align:center;width:100%;">Calendario de Jornadas</div><br><br>

<?php
	include("mod_calendario2.php");
?>

<br><br>

<input type="hidden" name="datosCalendario" id="datosCalendario" value="">
<input type="hidden" name="opcion" id="opcion" value="">

<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
	<tr>
		<td width="50" height="50" align="left">
			<button name="nuevo" type="reset" value="nuevo" width="50" height="50" onClick="limpiar_info()">
				<img src="../art/filenew.png"> Nuevo
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="guardar" type="button" value="guardar" width="50" height="50" onClick="guardar_info()">
				<img src="../art/filesave.png"> Guardar
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="eliminar" type="button" value="eliminar" width="50" height="50" onClick="eliminar_info()">
				<img src="../art/editdelete.png"> Eliminar
			</button>
		</td>
		<td width="600">
		</td>
	</tr>
</table>


</form>


<script>
	limpiar_info();
</script>
