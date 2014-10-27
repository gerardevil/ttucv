<?php

$vdeporte = 1;


require_once("../modelo/clubes.php");


?>

<!DOCTYPE html5>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>

	
	
	function limpiar_info_club() {
		
		$('#formClub').each (function(){
		  this.reset();
		});
		document.getElementById('mensajes').innerHTML = "";

	}
	
	function guardar_info_club(){

		if(validar_club()){
		
			if (confirm('\u00BFDeseas guardar este club? ')) {
		
				var form =  document.forms.formClub;
		
				form.opcion.value = 'guardar';
				
				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
			
			}
			
		}
	
	}
	
	function eliminar_info_club(){

		var club_id = $('#club_id').val();
		
		if(club_id != ''){
		
			if (confirm('\u00BFDeseas eliminar este club? ')) {
			
				var form =  document.forms.formClub;
			
				form.opcion.value = 'eliminar';

				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));	
				
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique un club<br>');
		}
	
	}
	
	
	function cargar_club(){
		
		
		//document.forms.formulario.nombre.value = document.forms.formulario.eventos.value;
		
		var club_id = $('#club_id').val();
		
		var form =  document.forms.formClub;
		
		if(club_id != ''){
			
			var param = 'opcion=consulta&club=' + club_id;
			
			var json = geturl(form.action, param, 'GET');
			
			//alert(json);
			
			var obj = jQuery.parseJSON(json);
			
			document.getElementById('nombre_club').value = obj[0].club_nombre;
			

		
		}else{
			limpiar_info_club();
		}
		
	}
	
	
	function validar_club(){
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
		
		
		if($("#formClub").validator({
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

<form name="formClub" id="formClub" enctype="multipart/form-data" action="control/ctrl_clubes.php">
<fieldset>
<!--<input type="hidden" name="directorio" id="directorio" value="art/eventos/">-->
<table width="680" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr><td width="78" height="30">&nbsp;</td></tr>
			<tr>
				<td width="75" height="30" align='left'>Clubes Registrados</td>
				<td width="99" height="30" align='left'>              
				  <select name="club_id" class="textonegro11r" id="club_id" onChange="cargar_club()">
				  <option value="" ><Ingresar Nuevo></option>
				  <?php 
				  
				    
					$obj = new clubes('','');
					$clubes = $obj->get_all_clubes();
				  
					$cont = 1; 
					while ($row_clubes = mysql_fetch_assoc($clubes)){ 
				  ?>
				  <option value="<?php echo $row_clubes['club_id']; ?>"  <?php if (cont==1) { ?> selected <?php } ?> ><?php echo $row_clubes['club_nombre']; ?></option>
				  <?php  } ?>
				  </select>        
				</td>
			</tr>
			<tr height="50">
				<td colspan="4"><hr></hr></td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Nombre Club</td>
				<td width="100" height="40" align='left'>              
				  <input type="text" name="nombre_club" id="nombre_club" required="required" size="50">           
				</td>
			</tr>
			<!--
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
			-->
		</table>

<!--
<ul class="tabs">
<li><a href="#">Informaci&oacute;n del Evento</a></li>
<li><a href="#">Modalidades y Premios</a></li>
<li><a href="#">Patrocinantes</a></li>
</ul>
-->

<input type="hidden" name="opcion" id="opcion" value="">

<table width="680" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
	<tr>
		<td width="50" height="50" align="left">
			<button name="nuevo" type="reset" value="nuevo" width="50" height="50" onClick="limpiar_info_club()">
				<img src="../art/filenew.png"> Nuevo
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="guardar" type="button" value="guardar" width="50" height="50" onClick="guardar_info_club()">
				<img src="../art/filesave.png"> Guardar
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="eliminar" type="button" value="eliminar" width="50" height="50" onClick="eliminar_info_club()">
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