<?php

$vdeporte = 1;

require_once("../modelo/deportes.php");
require_once("../modelo/prensas.php");


?>

<!DOCTYPE html5>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>

	
	
	function limpiar_info_prensa() {
		
		$('#formularioPrensa').each (function(){
		  this.reset();
		});
		document.getElementById('mensajes').innerHTML = "";
		document.getElementById('visor_imagen_prensa').src = '../art/eventos/no_disponible.jpg';

	}
	
	function guardar_info_prensa(){

		if(validar_prensa()){
		
			if (confirm('\u00BFDeseas guardar este articulo? ')) {
		
				document.forms.formularioPrensa.opcion.value = 'guardar';
				
				
				if(document.getElementById('fileupload_prensa').value != ''){
					document.forms.formularioPrensa.imagen_prensa.value = document.getElementById('fileupload_prensa').value;
				}
				
				
				var form =  document.forms.formularioPrensa;

				
				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
			
			}
			
		}
	
	}
	
	function eliminar_info_prensa(){

		var pren_id = $('#prensa').val();
		
		if(pren_id != ''){
		
			if (confirm('\u00BFDeseas eliminar este articulo? ')) {
			
				document.forms.formularioPrensa.opcion.value = 'eliminar';
				
				
				var form =  document.forms.formularioPrensa;

				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));	
				
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique un articulo<br>');
		}
	
	}
	
	
	function cargar_prensa(){
		
		
		//document.forms.formulario.nombre.value = document.forms.formulario.eventos.value;
		
		var pren_id = $('#prensa').val();
		
		var form =  document.forms.formularioPrensa;
		
		if(pren_id != ''){
			
			var param = 'opcion=consulta&prensa=' + pren_id;
			
			var json = geturl(form.action, param, 'GET');
			
			//alert(json);
			
			var obj = jQuery.parseJSON(json);
			
			
			document.getElementById('titulo_prensa').value = obj[0].pren_titulo;
			document.getElementById('resumen_prensa').value = obj[0].pren_resumen;
			document.getElementById('texto_prensa').value = obj[0].pren_texto;
			
			/*
			var fecha = new Date(obj[0].pren_fecha);
			var api = $("#fecha_prensa").data("dateinput");
			api.setValue(fecha);*/
			
			$('#fecha_prensa').datepicker('setDate', new Date(obj[0].pren_fecha));
			
			document.getElementById('visor_imagen_prensa').src = '../art/prensas/' + obj[0].pren_imagen;
			document.getElementById('imagen_prensa').value = obj[0].pren_imagen;
			document.getElementById('publicar_prensa').checked = obj[0].pren_publicar=='S';

		
		}else{
			limpiar_info_prensa();
		}
		
	}
	
	
	function validar_prensa(){
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
		
		
		if($("#formularioPrensa").validator({
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

<form name="formularioPrensa" id="formularioPrensa" enctype="multipart/form-data" action="control/ctrl_prensas.php">
<fieldset>
<!--<input type="hidden" name="directorio" id="directorio" value="art/eventos/">-->
<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr><td width="78" height="30">&nbsp;</td></tr>
			<tr>
				<td width="75" height="30" align='left'>Art&iacute;culos Registrados</td>
				<td width="99" height="30" align='left'>              
				  <select name="prensa" class="textonegro11r" id="prensa" onChange="cargar_prensa()">
				  <option value="" ><Ingresar Nuevo></option>
				  <?php 
				  
				    
					$obj = new prensas('','','','','','','');
					$prensas = $obj->get_all_prensas();
				  
					$cont = 1; 
					while ($row_prensas = mysql_fetch_assoc($prensas)){ 
				  ?>
				  <option value="<?php echo $row_prensas['pren_id']; ?>"  <?php if (cont==1) { ?> selected <?php } ?> ><?php echo utf8_encode($row_prensas['pren_titulo']); ?></option>
				  <?php  } ?>
				  </select>        
				</td>
			</tr>
			<tr height="50">
				<td colspan="4"><hr></hr></td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>T&iacute;tulo Prensa</td>
				<td width="100" height="40" align='left'>              
				  <input type="text" name="titulo_prensa" id="titulo_prensa" required="required">           
				</td>
				<td width="100" height="40" align='center' valign="top" rowspan="8" colspan="8"> 
					<img src="../art/eventos/no_disponible.jpg" id="visor_imagen_prensa" width="150" height="150">
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Fecha</td>
				<td width="100" height="40" align='left'>              
					<input type="text" class="date" id="fecha_prensa" name="fecha_prensa" required="required"/>
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Imagen</td>
				<td width="100" height="40" align='left'>              
				  <input id="fileupload_prensa" type="file" name="files[]" onClick="inicializar_fileupload(this,false,'visor_imagen_prensa')">
				  <input type="hidden" name="imagen_prensa" id="imagen_prensa" value="">
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Resumen Prensa</td>
				<td width="100" height="40" align='left'>        
					<textarea name="resumen_prensa" id="resumen_prensa" cols="50" rows="5" required="required"></textarea>      
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Texto Prensa</td>
				<td width="100" height="40" align='left'>        
					<textarea name="texto_prensa" id="texto_prensa" cols="50" rows="5" required="required"></textarea>      
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Publicar</td>
				<td width="100" height="40" align='left'>              
				  <input type="checkbox" name="publicar_prensa" id="publicar_prensa" value="true" checked>
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
			<button name="nuevo" type="reset" value="nuevo" width="50" height="50" onClick="limpiar_info_prensa()">
				<img src="../art/filenew.png"> Nuevo
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="guardar" type="button" value="guardar" width="50" height="50" onClick="guardar_info_prensa()">
				<img src="../art/filesave.png"> Guardar
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="eliminar" type="button" value="eliminar" width="50" height="50" onClick="eliminar_info_prensa()">
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
	
	$("#fecha_prensa").datepicker({
	  changeMonth: true,
	  changeYear: true,
	  minDate: -1000, 
	  maxDate: 1000
	});
	
	/*$("#fecha_prensa").dateinput({
		lang:'es',
		format: 'dd/mm/yyyy',	// the format displayed for the user
		selectors: true,             	// whether month/year dropdowns are shown
		//min: -1000,                    // min selectable day (100 days backwards)
		//max: 1000,                    	// max selectable day (100 days onwards)
		offset: [10, 20],            	// tweak the position of the calendar
		speed: 'fast',               	// calendar reveal speed
		firstDay: 1                  	// which day starts a week. 0 = sunday, 1 = monday etc..
	});*/
</script>
</body>
</html>