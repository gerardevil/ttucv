<?php

$vdeporte = 1;

require_once("../modelo/deportes.php");
require_once("../modelo/videos.php");


?>

<!DOCTYPE html5>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>

	
	
	function limpiar_info_video() {
		
		$('#formularioVideos').each (function(){
		  this.reset();
		});
		document.getElementById('mensajes').innerHTML = "";
		document.getElementById('visor_videos').src = "";

	}
	
	function guardar_info_video(){

		if(validar_video()){
		
			if (confirm('\u00BFDeseas guardar este video? ')) {
		
				document.forms.formularioVideos.opcion_video.value = 'guardar';
				
				var form =  document.forms.formularioVideos;

				
				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
			
			}
			
		}
	
	}
	
	function eliminar_info_video(){

		var vide_id = $('#video').val();
		
		if(vide_id != ''){
		
			if (confirm('\u00BFDeseas eliminar este video? ')) {
			
				document.forms.formularioVideos.opcion_video.value = 'eliminar';
				
				
				var form =  document.forms.formularioVideos;

				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));	
				
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique una galeria<br>');
		}
	
	}
	
	
	function cargar_video(){
		
		
		//document.forms.formulario.nombre.value = document.forms.formulario.eventos.value;
		
		var vide_id = $('#video').val();
		
		var form =  document.forms.formularioVideos;
		
		if(vide_id != ''){
			
			var param = 'opcion_video=consulta&video=' + vide_id;
			
			var json = geturl(form.action, param, 'GET');
			
			//alert(json);
			
			var obj = jQuery.parseJSON(json);
			
			document.getElementById('nombre_video').value = obj[0].vide_nombre;
			
			/*
			var fecha = new Date(obj[0].vide_fecha);
			var api = $("#fecha_video").data("dateinput");
			api.setValue(fecha);*/
			
			$('#fecha_video').datepicker('setDate', new Date(obj[0].vide_fecha));
			
			document.getElementById('url').value = obj[0].vide_codigo;
			document.getElementById('publicar_video').checked = obj[0].vide_publicar=='S';

			visualizar_video();
		
		}else{
			limpiar_info_video();
		}
		
	}
	
	
	function validar_video(){
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
		
		
		if($("#formularioVideos").validator({
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
	
	
	function visualizar_video(){
	
		var str = document.getElementById('url').value;
		
		var res = "";
		
		
		var pos =  str.indexOf('src');
		pos = str.indexOf('"',pos);
		posAux = pos+1;
		pos = str.indexOf('"',pos+1);
		var url = str.substring(posAux, pos);

		document.getElementById('visor_videos').src	 = url;

		
		
		var pos = str.indexOf('width');
		var posAux;
		
		
		pos = str.indexOf('"',pos);
		res = res + str.substring(0,pos+1);
		res = res + "215";
		
		pos = str.indexOf('"',pos+1);
		posAux = pos;
		pos = str.indexOf('height');
		pos = str.indexOf('"',pos);
		res = res + str.substring(posAux,pos+1);
		res = res + "139";
		pos = str.indexOf('"',pos+1);
		res = res + str.substring(pos);
		
		//alert(res);
	
		document.getElementById('url').value = res;
		//$('#visor_videos').load(res);
		//document.getElementById('visor_videos').innerHTML = res;
		
	
	}
	
	
</script>




</head>

<body>

<form name="formularioVideos" id="formularioVideos" enctype="multipart/form-data" action="control/ctrl_videos.php">
<fieldset>
<!--<input type="hidden" name="directorio" id="directorio" value="art/eventos/">-->
<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr><td width="78" height="30">&nbsp;</td></tr>
			<tr>
				<td width="78" height="30">Deporte</td>
				<td width="99" height="30">              
				  <select name="deportes_video" class="textonegro11r" id="deportes_video">
				  <?php
					
					
					$obj = new deportes('','','');
					$deportes = $obj->get_all_deportes();
					
					while ($row_deportes = mysql_fetch_assoc($deportes)){ 
				  ?>
				  <option value="<?php echo $row_deportes['depo_id']; ?>" <?php if ($vdeporte==$row_deportes['depo_id']) { ?> selected <?php } ?>><?php echo $row_deportes['depo_nombre']; ?></option>
				  <?php } ?>
				  </select>              
				</td>
				<td width="75" height="30" align='left'>Videos Registrados</td>
				<td width="99" height="30" align='left'>              
				  <select name="video" class="textonegro11r" id="video" onChange="cargar_video()">
				  <option value="" ><Ingresar Nuevo></option>
				  <?php 
				  
				    
					$obj = new videos('','','','','','');
					$videos = $obj->get_all_videos($vdeporte);
				  
					$cont = 1; 
					while ($row_videos = mysql_fetch_assoc($videos)){ 
				  ?>
				  <option value="<?php echo $row_videos['vide_id']; ?>"  <?php if (cont==1) { ?> selected <?php } ?> ><?php echo $row_videos['vide_nombre']; ?></option>
				  <?php  } ?>
				  </select>        
				</td>
			</tr>
			<tr height="50">
				<td colspan="4"><hr></hr></td>
			</tr>
			<tr>
				<td width="150" height="40" align='left'>Nombre Video</td>
				<td width="150" height="40" align='left'>              
				  <input type="text" name="nombre_video" id="nombre_video" required="required">           
				</td>
				<td width="150" height="40" align='center' valign="top" rowspan="8" colspan="8"> 
					<iframe id="visor_videos" width="215" height="139" src="" frameborder="0" allowfullscreen></iframe>
					<!--<div id="visor_videos" width="215" height="139"></div>-->
				</td>
			</tr>
			<tr>
				<td width="150" height="40" align='left'>Fecha</td>
				<td width="150" height="40" align='left'>              
					<input type="text" class="date" id="fecha_video" name="fecha_video" required="required"/>
				</td>
			</tr>
			<tr>
				<td width="150" height="40" align='left'>Direcci&oacute;n Video</td>
				<td width="150" height="40" align='left'>              
				  <input type="text" name="url" id="url" required="required" onChange="visualizar_video()"/>
				</td>
			</tr>
			<tr>
				<td width="150" height="40" align='left'>Publicar</td>
				<td width="150" height="40" align='left'>              
				  <input type="checkbox" name="publicar_video" id="publicar_video" value="true" checked>
				  <input type="hidden" name="opcion_video" id="opcion_video" value="">				  
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
			<button name="nuevo" type="reset" value="nuevo" width="50" height="50" onClick="limpiar_info_video()">
				<img src="../art/filenew.png"> Nuevo
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="guardar" type="button" value="guardar" width="50" height="50" onClick="guardar_info_video()">
				<img src="../art/filesave.png"> Guardar
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="eliminar" type="button" value="eliminar" width="50" height="50" onClick="eliminar_info_video()">
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

	$("#fecha_video").datepicker({
	  changeMonth: true,
	  changeYear: true,
	  minDate: -1000, 
	  maxDate: 1000
	});
	/*
	$("#fecha_video").dateinput({
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