<?php

require_once("../modelo/patrocinantes.php");


?>

<!DOCTYPE HTML>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<script src="scripts/funciones.js"></script>

<script>

	
	
	function limpiar_info() {
		
		$('#formulario').each (function(){
		  this.reset();
		});
		document.getElementById('mensajes').innerHTML = "";
		document.getElementById('visor_imagen').src = '../art/eventos/no_disponible.jpg';

	}
	
	function guardar_info(){

		
		if(validar()){
		
			if (confirm('\u00BFDeseas guardar este patrocinante? ')) {
		
				document.forms.formulario.opcion.value = 'guardar';
				
				
				var form =  document.forms.formulario;

				//var archivo = '&logo=' + document.getElementById('fileupload').value;
				
				if(document.getElementById('fileupload').value != ''){
					document.forms.formulario.logo.value = document.getElementById('fileupload').value;
				}
				
				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));

			}
			
		}//fin validar
	
	}
	
	function eliminar_info(){

		var patr_id = $('#patrocinante').val();
		
		if(patr_id != ''){
		
			if (confirm('\u00BFDeseas eliminar este patrocinante? ')) {
			
				document.forms.formulario.opcion.value = 'eliminar';
				
				
				var form =  document.forms.formulario;

				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
					
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique un patrocinante<br>');
		}
	
	}
	
	
	function cargar_patrocinante(){
		
		
		var patr_id = $('#patrocinante').val();
		
		var form =  document.forms.formulario;
		
		if(patr_id != ''){
			
			var param = 'opcion=consulta&patrocinante=' + patr_id;
			
			var json = geturl(form.action, param, 'GET');
			
			//alert(json);
			
			var obj = jQuery.parseJSON(json);
			
			document.getElementById('nombre').value = obj[0].patr_nombre;
			document.getElementById('visor_imagen').src = '../art/patrocinantes/' + obj[0].patr_logo;
			document.getElementById('logo').value = obj[0].patr_logo;
			document.getElementById('publicar').checked = obj[0].patr_activo=='S';
					
		}else{
			limpiar_info();
		}
		
	}
	
	
	function validar(){
		/*
		// adds an effect called "wall" to the validator
		$.tools.validator.addEffect("wall", function(errors, event) {
		 
			// get the message wall
			var wall = $(this.getConf().container).fadeIn();
		 
			// remove all existing messages
			wall.find("p").remove();
		 
			// add new ones
			$.each(errors, function(index, error) {
				wall.append(
					"<p>" + error.messages[0]+ " " +error.input.attr("name")+ "</p>"
				);
			});
		 
		// the effect does nothing when all inputs are valid
		}, function(inputs)  {
		 
		});
		
		
		if($("#formulario").validator({
			lang:'es',
			//position: 'top left', 
			offset: [0, 0],
			effect: 'wall',
			container: '#mensajes',		 
			errorInputEvent: null // do not validate inputs when they are edited 
				
			}).data("validator").checkValidity()){
			
			return true

		}
		*/
	
		return true;
	
	} 
	
	
</script>




</head>

<body>

<div id="mensajes" name="mensajes" class="textoverdeesmeralda11b"></div>

<form name="formulario" id="formulario" enctype="multipart/form-data" action="control/ctrl_patrocinantes.php">
<fieldset>
<table width="680" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr><td width="78" height="30">&nbsp;</td></tr>
			<tr>
				<td width="75" height="30" align='left'>Patrocinantes Registrados</td>
				<td width="99" height="30" align='left'>              
				  <select name="patrocinante" class="textonegro11r" id="patrocinante" onChange="cargar_patrocinante()">
				  <option value="" ><Ingresar Nuevo></option>
				  <?php 
				  
				    
					$obj = new patrocinantes('','','','','','');
					$patrocinantes = $obj->get_all_patrocinantes();
				  
					$cont = 1; 
					while ($row_patrocinantes = mysql_fetch_assoc($patrocinantes)){ 
				  ?>
				  <option value="<?php echo $row_patrocinantes['patr_id']; ?>"  <?php if (cont==1) { ?> selected <?php } ?> ><?php echo $row_patrocinantes['patr_nombre']; ?></option>
				  <?php  } ?>
				  </select>        
				</td>
			</tr>
			<tr height="50">
				<td colspan="10"><hr></hr></td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Nombre Patrocinante</td>
				<td width="100" height="40" align='left'>              
				  <input type="text" name="nombre" id="nombre" required="required">           
				</td>
				<td width="100" height="40" align='center' valign="top" rowspan="8" colspan="8"> 
					<img src="../art/eventos/no_disponible.jpg" id="visor_imagen" width="150" height="120">
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Logo</td>
				<td width="100" height="40" align='left'>              
				  <input id="fileupload" type="file" name="files[]" onClick="inicializar_fileupload(this)">
				  <input type="hidden" name="logo" id="logo" value=""> 				  
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Activo</td>
				<td width="100" height="40" align='left'>              
				  <input type="checkbox" name="publicar" id="publicar" value="true" checked>
				  <input type="hidden" name="opcion" id="opcion" value="">				  
				</td>
			</tr>
			<tr height="50">
				<td colspan="10"><hr></hr></td>
			</tr>
		</table>

<!--
<ul class="tabs">
<li><a href="#">Informaci&oacute;n del Evento</a></li>
<li><a href="#">Modalidades y Premios</a></li>
<li><a href="#">Patrocinantes</a></li>
</ul>
-->

<table width="680" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
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

</fieldset>
</form>
</body>
</html>