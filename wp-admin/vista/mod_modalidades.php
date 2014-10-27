<?php

$vdeporte = 1;

require_once("../modelo/deportes.php");
require_once("../modelo/modalidades.php");


?>

<!DOCTYPE html5>
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
		
			if (confirm('\u00BFDeseas guardar esta modalidad? ')) {
		
				document.forms.formulario.opcion.value = 'guardar';
				
				
				var form =  document.forms.formulario;

				
				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
			
			}
			
		}
	
	}
	
	function eliminar_info(){

		var moda_id = $('#modalidad').val();
		
		if(moda_id != ''){
		
			if (confirm('\u00BFDeseas eliminar esta modalidad? ')) {
			
				document.forms.formulario.opcion.value = 'eliminar';
				
				
				var form =  document.forms.formulario;

				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));	
				
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique una modalidad<br>');
		}
	
	}
	
	
	function cargar_modalidad(){
		
		
		//document.forms.formulario.nombre.value = document.forms.formulario.eventos.value;
		
		var moda_id = $('#modalidad').val();
		
		var form =  document.forms.formulario;
		
		if(moda_id != ''){
			
			var param = 'opcion=consulta&modalidad=' + moda_id;
			
			var json = geturl(form.action, param, 'GET');
			
			//alert(json);
			
			var obj = jQuery.parseJSON(json);
			
			document.getElementById('nombre').value = obj[0].moda_nombre;
			document.getElementById('abreviatura').value = obj[0].moda_abreviatura;
			document.getElementById('sexo').value = obj[0].moda_sexo;
			document.getElementById('publicar').checked = obj[0].moda_publicar=='S';
			document.getElementById('tipo').value = obj[0].moda_tipo;

		
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

<form name="formulario" id="formulario" enctype="multipart/form-data" action="control/ctrl_modalidades.php">
<fieldset>
<!--<input type="hidden" name="directorio" id="directorio" value="art/eventos/">-->
<table width="680" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr><td width="78" height="30">&nbsp;</td></tr>
			<tr>
				<td width="78" height="30">Deporte</td>
				<td width="99" height="30">              
				  <select name="deportes" class="textonegro11r" id="deportes">
				  <?php
					
					
					$obj = new deportes('','','');
					$deportes = $obj->get_all_deportes();
					
					while ($row_deportes = mysql_fetch_assoc($deportes)){ 
				  ?>
				  <option value="<?php echo $row_deportes['depo_id']; ?>" <?php if ($vdeporte==$row_deportes['depo_id']) { ?> selected <?php } ?>><?php echo $row_deportes['depo_nombre']; ?></option>
				  <?php } ?>
				  </select>              
				</td>
				<td width="75" height="30" align='left'>Modalidades Registradas</td>
				<td width="99" height="30" align='left'>              
				  <select name="modalidad" class="textonegro11r" id="modalidad" onChange="cargar_modalidad()">
				  <option value="" ><Ingresar Nuevo></option>
				  <?php 
				  
				    
					$obj = new modalidades('','','','','','');
					$modalidades = $obj->get_all_modalidades($vdeporte);
				  
					$cont = 1; 
					while ($row_modalidades = mysql_fetch_assoc($modalidades)){ 
				  ?>
				  <option value="<?php echo $row_modalidades['moda_id']; ?>"  <?php if (cont==1) { ?> selected <?php } ?> ><?php echo $row_modalidades['moda_nombre']; ?></option>
				  <?php  } ?>
				  </select>        
				</td>
			</tr>
			<tr height="50">
				<td colspan="4"><hr></hr></td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Nombre Modalidad</td>
				<td width="100" height="40" align='left'>              
				  <input type="text" name="nombre" id="nombre" required="required">           
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Abreviatura</td>
				<td width="100" height="40" align='left'>              
				  <input type="text" name="abreviatura" id="abreviatura" required="required">           
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Sexo</td>
				<td width="100" height="40" align='left'>              
				  <select name="sexo" class="textonegro11r" id="sexo">
					<option value="M">Masculino</option>
					<option value="F">Femenino</option>
					<option value="MF">Mixto</option>
				  </select>                         
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Tipo</td>
				<td width="100" height="40" align='left'>              
				  <select name="tipo" class="textonegro11r" id="tipo">
					<option value="D">Doble</option>
					<option value="I">Individual</option>
				  </select>                         
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Publicar</td>
				<td width="100" height="40" align='left'>              
				  <input type="checkbox" name="publicar" id="publicar" value="true" checked>
				  <input type="hidden" name="opcion" id="opcion" value="">				  
				</td>
			</tr>
			<tr height="50">
				<td colspan="4"><hr></hr></td>
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