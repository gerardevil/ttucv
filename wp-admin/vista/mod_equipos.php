
<!DOCTYPE HTML>
<html>
<head>

<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<script type="text/javascript" src="../scripts/funciones.js"></script>
<script type="text/javascript" src="../scripts/validar-pasos.js"></script>

<script>

	$(document).ready(function() {	
		init();
		<?php
			echo 'modulo = "'.$_GET['modulo'].'"';
		?>
	});
/*
	vUrl = '';
	modulo = 'jugador';
	
	function limpiar_equipo) {
	
		$('#formJugador').each (function(){
		  this.reset();
		});
		document.getElementById('mensajes').innerHTML = "";
		document.getElementById('visor_imagen').src = '../art/eventos/no_disponible.jpg';
		document.getElementById('foto').value = '';
		
		$('#formJugador span.error').each (function(){
		  $(this).hide();
		});
	

	}
	
	
	function guardar_jugador(){
	
		if(validar_jugador()){
			
			$('#formJugador span.error').each (function(){
			  $(this).hide();
			});
			
			if (confirm('\u00BFDeseas guardar los datos del jugador? ')) {
			
				var form =  document.forms.formJugador;
				
				document.getElementById('otro_club').value = document.getElementById('club').value != 0 ? '' : document.getElementById('otro_club').value;
				
				form.opcion.value = 'guardar';
				
				
				
				if(document.getElementById('fileupload_foto_jugador').value != ''){
					form.foto.value = document.getElementById('fileupload_foto_jugador').value;
				}
				
				
				$('#mensajes').html(geturl('control/ctrl_jugadores.php', $(form).serialize(), 'POST'));
			
				//$('#formUsuario').submit();
				
			}
			
		}
	
	} 
	
	function eliminar_jugador(){
	
		var cedula = $('#cedula').val();
		
		if(cedula != ''){
			
			if (confirm('\u00BFDesea eliminar este jugador? ')) {
			
				var form =  document.forms.formJugador;
				
				form.opcion.value = 'eliminar';
				
				$('#mensajes').html(geturl('control/ctrl_jugadores.php', $(form).serialize(), 'POST'));
				
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique un jugador<br>');
		}
	
	} 
	
	
	function validar_jugador(){
		
			var isStepValid = true;
		   
		   if(validarPasoJugador() == false){
			 isStepValid = false;
			 //$('#wizard').smartWizard('setError',{stepnum:2,iserror:true});         
		   }else{
			 //$('#wizard').smartWizard('setError',{stepnum:2,iserror:false});
		   }
		   
		   if(validarPasoContacto() == false || validarPasoUsuario() == false){
			 isStepValid = false;
			 //$('#wizard').smartWizard('setError',{stepnum:3,iserror:true});         
		   }else{
			 //$('#wizard').smartWizard('setError',{stepnum:3,iserror:false});
		   }
		   
		   if(!isStepValid){
			  //$('#wizard').smartWizard('showMessage','Por favor corrige los errores y presione Siguiente');
		   }
				  
		   return isStepValid;

		}
	
	
	$(document).ready(function() {
		$("#cedula").blur(function(event) {
			 cargar_jugador();
		});
	});
	
	function seleccionar_jugador(cedula){
	
		
		$('#cedula').val(cedula);
		cargar_jugador();
		$.fancybox.close();
		
		return false;
	
	}
	*/
	
	function validarEquipo(){
		
			var isStepValid = true;
		   
		   /*
		   if(validarPasoUsuarioEquipo() == false){
			 isStepValid = false;
			 //$('#wizard').smartWizard('setError',{stepnum:2,iserror:true});         
		   }else{
			 //$('#wizard').smartWizard('setError',{stepnum:2,iserror:false});
		   }
		   */
		   if(validarPasoEquipo() == false){
			 isStepValid = false;
			 //$('#wizard').smartWizard('setError',{stepnum:3,iserror:true});         
		   }else{
			 //$('#wizard').smartWizard('setError',{stepnum:3,iserror:false});
		   }
		   
		   if(!isStepValid){
			  //$('#wizard').smartWizard('showMessage','Por favor corrige los errores y presione Siguiente');
		   }
				  
		   return isStepValid;

		}
	
	
	function aceptarEquipo(){
		if(validarEquipo()){
			
			elementoSel.html($('#equipo_nombre').val());
			elementoSel.parent().parent().find(':nth-child(3)').html($('#busca_nombre').html());
			elementoSel.parent().parent().find(':nth-child(5)').html($('#club').val());
			elementoSel.parent().parent().find(':nth-child(6)').html($('#tipo_cancha').val());
			elementoSel.parent().parent().find(':nth-child(7)').html($('#busca_cedula').val());
			elementoSel.parent().parent().find(':nth-child(8)').html($('#busca_email').html());
			
			$.fancybox.close();
			
		}
		
		return false;
		
	}
	
	function cargarEquipo(equipoId){


		if(equipoId != ""){
			
			var param = 'opcion=consulta&equipo_id=' + equipoId;
			
			try{
			
				var json = $.ajax({  
				 type: 'GET',  
				 url: 'control/ctrl_equipos.php',
				 //dataType: 'json',
				 data: param,
				 async: false  
				}).responseText;
				
				//var json = geturl(form.action, param, 'GET');
				
				//alert(json);
				
				var obj = jQuery.parseJSON(json);


				$('#equipo_nombre').val(obj[0].equipo_nombre);
				$('#club').val(obj[0].club_id);
				$('#tipo_cancha').val(obj[0].equipo_tipo_cancha);
				
				equipoSel = obj[0];
				
				$('#busca_error_carga_info').html('');
			
			}catch(ex){
				
				equipoSel = null;
			
				$('#equipo_nombre').val('');
				$('#club').val('');
				$('#tipo_cancha').val('');
				
				$('#busca_error_carga_info').html("<p>No se pudo cargar la informaci&oacute;n del equipo, "+
					"comuniquese con el jugador para que actualice sus datos en la p&aacute;gina web.</p>");

			}


		}
		
	
	}
	
	function init(){
	
		var temp = elementoSel.parent().next().next().next().next().next().html();
		
		if(parseInt(temp,10)>0){
			$('#busca_cedula').val(temp.trim());
			cargarEquipo(elementoSel.parent().next().next().html());
		}
	
	}
	
	
	
</script>

</head>

<body>

<div id="mensajes" name="mensajes" class="textoverdeesmeralda11b"></div>

<form id="formEquipo" name="formEquipo" class="formEstilo formEstilo2" method="post" action="ctrl_equipos.php">

	<?php
	
		//include("../../mod_form_equipo_usuario.php");
	
		include("../mod_form_seleccionar_capitan.php");
		
		include("../../liga/mod_form_equipo.php");
		
		include("mod_lista_jugadores.php");
	
		
	?>

	<input type="hidden" name="opcion" id="opcion" value="guardar">
	<input type="hidden" name="modulo" id="mudulo" value="actualizar_jugador">
	
</form>

<?php

	if($_GET['modulo'] == 'inscripcion'){
	
		echo '<br><br><div align="right"><a href="#" onClick="return aceptarEquipo()"><img src="../art/boton_aceptar.png"></a></div>';
	
	}else{

?>

<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
	<tr>
		<td width="50" height="50" align="left">
			<button name="nuevo" type="reset" value="nuevo" width="50" height="50" onClick="limpiar_jugador()">
				<img src="../art/filenew.png"> Nuevo
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="guardar" type="button" value="guardar" width="50" height="50" onClick="guardar_jugador()">
				<img src="../art/filesave.png"> Guardar
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="eliminar" type="button" value="eliminar" width="50" height="50" onClick="eliminar_jugador()">
				<img src="../art/editdelete.png"> Eliminar
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button id="buscar" name="buscar"  value="buscar" width="50" height="50" href="mod_buscar_jugador.php" class="fancybox.ajax">
				<img src="../art/find.png"> Buscar
			</button>
		</td>
		<td width="550">
		</td>
	</tr>
</table>

<?php } ?>

</body>
<html>

