<?php

require_once("../modelo/usuarios.php");

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
		
			if (confirm('\u00BFDeseas guardar este usuario? ')) {
		
				document.forms.formulario.opcion.value = 'guardar';
				
				
				var form =  document.forms.formulario;

				
				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
			
			}
			
		}
	
	}
	
	function eliminar_info(){

		var usua_id = $('#usuario').val();
		
		if(usua_id != ''){
		
			if (confirm('\u00BFDeseas eliminar este usuario? ')) {
			
				document.forms.formulario.opcion.value = 'eliminar';
				
				
				var form =  document.forms.formulario;

				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));	
				
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique un usuario<br>');
		}
	
	}
	
	
	function cargar_usuario(){
		
		
		//document.forms.formulario.nombre.value = document.forms.formulario.eventos.value;
		
		var usua_id = $('#usuario').val();
		
		var form =  document.forms.formulario;
		
		if(usua_id != ''){
			
			var param = 'opcion=consulta&usuario=' + usua_id;
			
			var json = geturl(form.action, param, 'GET');
			
			//alert(json);
			
			var obj = jQuery.parseJSON(json);
			
			document.getElementById('nombre').value = obj[0].usua_nombre;
			document.getElementById('email').value = obj[0].usua_email;
			document.getElementById('email2').value = obj[0].usua_email;
			document.getElementById('password').value = obj[0].usua_clave;
			document.getElementById('password2').value = obj[0].usua_clave;
			document.getElementById('telefono').value = obj[0].usua_telefono;
			document.getElementById('tipo').value = obj[0].usua_tipo;
			

		
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
		
		$.tools.validator.fn("[data-equals]", function(input) {
		    var name = input.attr("data-equals"),
		    field = this.getInputs().filter("[name=" + name + "]");
		    return input.val() == field.val() ? true : [name];
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

<form name="formulario" id="formulario" enctype="multipart/form-data" action="control/ctrl_usuarios.php">
<fieldset>
<!--<input type="hidden" name="directorio" id="directorio" value="art/eventos/">-->
<table width="680" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr><td width="78" height="30">&nbsp;</td></tr>
			<tr>
				<td width="78" height="30">Usuarios Registrados</td>
				<td width="99" height="30">              
				  <select name="usuario" class="textonegro11r" id="usuario" onChange="cargar_usuario()">
				  <option value="" ><Ingresar Nuevo></option>
				  <?php
					
					
					$obj = new usuarios('','','','','','');
					$usuarios = $obj->get_all_usuarios();
					
					while ($row_usuarios = mysql_fetch_assoc($usuarios)){ 
				  ?>
				  <option value="<?php echo $row_usuarios['usua_id']; ?>"><?php echo $row_usuarios['usua_nombre']; ?></option>
				  <?php } ?>
				  </select>              
				</td>
			</tr>
			<tr height="50">
				<td colspan="4"><hr></hr></td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Nombre Usuario</td>
				<td width="100" height="40" align='left'>              
				  <input type="text" name="nombre" id="nombre" pattern="[a-zA-Z ]{5,}" required="required">           
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Correo Electr&oacute;nico</td>
				<td width="100" height="40" align='left'>              
				  <input type="email" name="email" id="email" required="required"> ej. usuario@correo.com        
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Confirmar Correo</td>
				<td width="100" height="40" align='left'>              
				  <input type="email" name="email2" id="email2" required="required" data-equals="email"> ej. usuario@correo.com           
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Contrase&ntilde;a</td>
				<td width="100" height="40" align='left'>              
				  <input type="password" name="password" id="password" required="required">           
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Confirmar Contrase&ntilde;a</td>
				<td width="100" height="40" align='left'>              
				  <input type="password" name="password2" id="password2" required="required" data-equals="password">           
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Tel&eacute;fono</td>
				<td width="100" height="40" align='left'>              
				  <input type="number" name="telefono" id="telefono"> ej. 02126853422			  
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Tipo Usuario</td>
				<td width="100" height="40" align='left'>              
				  <select name="tipo" class="textonegro11r" id="tipo">
					<option value="Administrador">Administrador</option>
					<option value="Normal">Normal</option>
					<input type="hidden" name="opcion" id="opcion" value="">
				  </select>                         
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