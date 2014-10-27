
<!DOCTYPE HTML>
<html>
<head>

<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<script type="text/javascript" src="../scripts/funciones.js"></script>
<script type="text/javascript" src="../scripts/validar-pasos.js"></script>

<script>

	//$(document).ready(function() {
		
		$("#buscar").fancybox({
			'href' : 'mod_buscar_jugador.php'
		});
		
	//});

	vUrl = '';
	modulo = 'jugador';
	
	function limpiar_jugador() {
	
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
	
	
</script>

</head>

<body>

<div id="mensajes" name="mensajes" class="textoverdeesmeralda11b"></div>

<form id="formJugador" name="formJugador" class="formEstilo formEstilo2" method="post" action="ctrl_jugadores.php">

	<?php
		include("../../mod_form_jugador.php");
	?>
	
	<?php
		$_GET['modulo'] = 'jugador';
		include("../../mod_form_contacto.php");
	?>

	<input type="hidden" name="opcion" id="opcion" value="guardar">
	<input type="hidden" name="modulo" id="mudulo" value="actualizar_jugador">
	
</form>

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

</body>
<html>

