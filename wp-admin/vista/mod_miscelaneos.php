<?php

require_once("../modelo/miscelaneos.php");

?>

<!DOCTYPE HTML>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<script>
	
	
	function limpiar_info() {
	
		$('#formulario').each (function(){
		  this.reset();
		});

		document.getElementById('mensajes').innerHTML = "";

	}
	
	function guardar_info(){

		if(validar()){
		
			if (confirm('\u00BFDeseas guardar esta configuracion? ')) {
		
				document.forms.formulario.opcion.value = 'guardar';
				
		
				var form =  document.forms.formulario;

				
				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
			
			}
			
		}//fin validar
	
	}//fin guardar_info
	
	function eliminar_info(){

		var misc_id = $('#miscelaneo').val();
		
		if(misc_id != ''){
		
			if (confirm('\u00BFDeseas eliminar esta configuracion? ')) {
			
				document.forms.formulario.opcion.value = 'eliminar';
				
				
				var form =  document.forms.formulario;

				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
				
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique una configuracion<br>');
		}
	
	}
	
	
	function cargar_miscelaneo(){
		
		var misc_id = $('#miscelaneo').val();
		
		var form =  document.forms.formulario;
		
		if(misc_id != ''){
			
			var param = 'opcion=consulta&miscelaneo=' + misc_id;
			
			var json = geturl(form.action, param, 'GET');
			
			//alert(json);
			
			var obj = jQuery.parseJSON(json);
			
			document.getElementById('titulo_conf').value = obj[0].misc_titulo;
			document.getElementById('texto_conf').value = obj[0].misc_texto;
			document.getElementById('variable').value = obj[0].misc_variable;
			
			
			//document.getElementById('visor_imagen').src = '../art/eventos/' + obj[0].even_afiche;
			//document.getElementById('afiche').value = obj[0].even_afiche;
			
		
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
	
		return false;
		*/
		return true;
	} 
	
</script>



</head>

<body>

<div id="mensajes" name="mensajes" class="textoverdeesmeralda11b"></div>

<form name="formulario" id="formulario" enctype="multipart/form-data" action="control/ctrl_miscelaneos.php">
<fieldset>


<table width="680" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr><td width="78" height="30">&nbsp;</td></tr>
			<tr>
				
				<td width="75" height="30" align='left'>Variables</td>
				<td width="99" height="30" align='left'>              
				  <select name="miscelaneo" class="textonegro11r" id="miscelaneo" onChange="cargar_miscelaneo()">
				  <option value="" ><Ingresar Nuevo></option>
				  <?php 
				  
				    
					$obj = new miscelaneos('','','','','');
					$misc = $obj->get_all_miscelaneos();
				  
					while ($row_miscelaneos = mysql_fetch_assoc($misc)){ 
				  ?>
				  <option value="<?php echo $row_miscelaneos['misc_id']; ?>"><?php echo $row_miscelaneos['misc_variable']; ?></option>
				  <?php  } ?>
				  </select>        
				</td>
			</tr>
			<tr height="50">
				<td colspan="4"><hr></hr></td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Variable</td>
				<td width="100" height="40" align='left'>              
				  <input type="text" name="variable" id="variable" readonly required="required">           
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>T&iacute;tulo</td>
				<td width="100" height="40" align='left'>              
				  <input type="text" name="titulo_conf" id="titulo_conf">           
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Texto</td>
				<td width="100" height="40" align='left'>              
					<textarea name="texto_conf" id="texto_conf" cols="50" rows="10" required="required"></textarea>
				</td>
			</tr>
			<tr height="50">
				<td colspan="4"><hr></hr></td>
			</tr>
		</table>


<input type="hidden" name="opcion" id="opcion" value="">

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
		<!--
		<td width="50" height="50" align="left">
			<button name="eliminar" type="button" value="eliminar" width="50" height="50" onClick="eliminar_info()">
				<img src="../art/editdelete.png"> Eliminar
			</button>
		</td>
		-->
		<td width="600">
		</td>
	</tr>
</table>

</fieldset>
</form>

</body>
</html>