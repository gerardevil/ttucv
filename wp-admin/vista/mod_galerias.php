<?php

$vdeporte = 1;

require_once("../modelo/deportes.php");
require_once("../modelo/galerias.php");


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
		
		document.getElementById('imagen').value = "";
		document.getElementById('mensajes').innerHTML = "";
		document.getElementById('visor_imagen').src = '../art/eventos/no_disponible.jpg';

	}
	
	function guardar_info(){

		if(validar()){
		
			if (confirm('\u00BFDeseas guardar esta galeria? ')) {
		
				document.forms.formulario.opcion.value = 'guardar';
				
				
				if(document.getElementById('fileupload').value != ''){
					document.forms.formulario.imagen.value = document.getElementById('fileupload').value;
				}
				
				
				var form =  document.forms.formulario;

				
				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
			
			}
			
		}
	
	}
	
	function eliminar_info(){

		var gale_id = $('#galeria').val();
		
		if(gale_id != ''){
		
			if (confirm('\u00BFDeseas eliminar esta galeria? ')) {
			
				document.forms.formulario.opcion.value = 'eliminar';
				
				
				var form =  document.forms.formulario;

				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));	
				
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique una galeria<br>');
		}
	
	}
	
	
	function cargar_galeria(){
		
		
		//document.forms.formulario.nombre.value = document.forms.formulario.eventos.value;
		
		var gale_id = $('#galeria').val();
		
		var form =  document.forms.formulario;
		
		if(gale_id != ''){
			
			var param = 'opcion=consulta&galeria=' + gale_id;
			
			var json = geturl(form.action, param, 'GET');
			
			//alert(json);
			
			var obj = jQuery.parseJSON(json);
			
			document.getElementById('nombre').value = obj[0].gale_nombre;
			
			/*
			var fecha = new Date(obj[0].gale_fecha);
			var api = $("#fecha").data("dateinput");
			api.setValue(fecha);*/
			
			$('#fecha').datepicker('setDate', new Date(obj[0].gale_fecha));
			
			document.getElementById('visor_imagen').src = '../art/galerias/' + obj[0].gale_imagenpp;
			document.getElementById('imagen').value = obj[0].gale_imagenpp;
			document.getElementById('publicar').checked = obj[0].gale_publicar=='S';

		
		}else{
			//limpiar_info();
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
<div id="mensajes" class="mensajes textoverdeesmeralda11b"></div>
<form name="formulario" id="formulario" enctype="multipart/form-data" action="control/ctrl_galerias.php">
<fieldset>
<!--<input type="hidden" name="directorio" id="directorio" value="art/eventos/">-->
<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
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
				<td width="75" height="30" align='left'>Galer&iacute;as Registradas</td>
				<td width="99" height="30" align='left'>              
				  <select name="galeria" class="textonegro11r" id="galeria" onChange="cargar_galeria()">
				  <option value="" ><Ingresar Nuevo></option>
				  <?php 
				  
				    
					$obj = new galerias('','','','','','');
					$galerias = $obj->get_all_galerias(0,0);
				  
					$cont = 1; 
					while ($row_galerias = mysql_fetch_assoc($galerias)){ 
				  ?>
				  <option value="<?php echo $row_galerias['gale_id']; ?>"  <?php if ($row_galerias['gale_id'] == $_GET['id']) { ?> selected <?php } ?> ><?php echo $row_galerias['gale_nombre']; ?></option>
				  <?php  } ?>
				  </select>        
				</td>
			</tr>
			<tr height="50">
				<td colspan="4"><hr></hr></td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Nombre Galer&iacute;a</td>
				<td width="100" height="40" align='left'>
					<?php
					
						if($_GET['imagen'] == ''){
							
							echo '<input type="text" name="nombre" id="nombre" required="required">  ';
						
						}else{
							echo '<input type="text" name="nombre" id="nombre" value="'.$_GET['imagen'].'" required="required">';
						}
					
					?>
				          
				</td>
				<td width="100" height="40" align='center' valign="top" rowspan="8" colspan="8"> 
					<?php
					
						if($_GET['imagen'] == ''){
							
							echo '<img src="../art/eventos/no_disponible.jpg" id="visor_imagen" width="150" height="150">';
						
						}else{
							echo '<img src="scripts/fileupload/server/php/files/'.$_GET['imagen'].'" id="visor_imagen" width="150" height="150">';
						}
					
					?>
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Fecha</td>
				<td width="100" height="40" align='left'>
					<?php
					
						if($_GET['imagen'] == ''){
							
							echo '<input type="text" class="date" id="fecha" name="fecha" required="required"/>';
						
						}else{
							echo '<input type="text" class="date" id="fecha" name="fecha" value="'.date('d/m/Y').'" required="required"/>';
						}
					
					?>
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Imagen</td>
				<td width="100" height="40" align='left'>
					<?php
						
						if($_GET['imagen'] == ''){
								
							echo '<input id="fileupload" type="file" name="files[]" accept="image/jpg, image/jpeg, image/gif, image/png" onClick="inicializar_fileupload(this)">';
							echo '<input type="hidden" name="imagen" id="imagen" value="">';
					  
						}else{
					  
							echo '<input id="fileupload" type="file" name="files[]" accept="image/jpg, image/jpeg, image/gif, image/png" onClick="inicializar_fileupload(this)" value="'.$_GET['imagen'].'">';
							echo '<input type="hidden" name="imagen" id="imagen" value="'.$_GET['imagen'].'">';
					  
						}
					  
					?>
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

</fieldset>
</form>
<script>
	
	$("#fecha").datepicker({
	  changeMonth: true,
	  changeYear: true,
	  minDate: -1000, 
	  maxDate: 1000
	});

	/*$("#fecha").dateinput({
		lang:'es',
		format: 'dd/mm/yyyy',	// the format displayed for the user
		selectors: true,             	// whether month/year dropdowns are shown
		//min: -1000,                    // min selectable day (100 days backwards)
		//max: 1000,                    	// max selectable day (100 days onwards)
		offset: [10, 20],            	// tweak the position of the calendar
		speed: 'fast',               	// calendar reveal speed
		firstDay: 1                  	// which day starts a week. 0 = sunday, 1 = monday etc..
	});*/
	
	$(function(){
	
		cargar_galeria();
	
	});
	
</script>
</body>
</html>