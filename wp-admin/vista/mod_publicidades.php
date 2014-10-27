<?php

require_once("../modelo/publicidades.php");

?>

<!DOCTYPE HTML>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<!--
<style>
	table.testgrid { border-collapse: collapse; border: 1px solid #CCB; width: 640px; }
	table.testgrid td, table.testgrid th { padding: 5px; border: 1px solid #E0E0E0; }
	table.testgrid th { background: url(../art/fondo_titulointernos.jpg); text-align: left; }
	input.invalid { background: #FBECF1; color: #FDFDFD; }
</style>
-->

<script>


	//window.onload = function() {
	
		editableGrid = new EditableGrid("DemoGridAttach"); 


		// we build and load the metadata in Javascript
		editableGrid.load({ metadata: [
			{ name: "seccion", datatype: "string", editable: true, 
				values: {"HOME" : "HOME", "QUIENES SOMOS" : "QUIENES SOMOS", "CALENDARIO" : "CALENDARIO",
						"MEDIOS" : "MEDIOS", "RANKING" : "RANKING", "REGLAMENTO" : "REGLAMENTO",
						"CONTACTO" : "CONTACTO", "HOME LIGA" : "HOME LIGA", "REGLAMENTO LIGA" : "REGLAMENTO LIGA",
						"EQUIPOS LIGA" : "EQUIPOS LIGA", "RESULTADOS LIGA" : "RESULTADOS LIGA"}
				
			},
			{ name: "action", label:"", datatype: "html", editable: false }
		]});

		
		// render for the action column
		editableGrid.setCellRenderer("action", new CellRenderer({render: function(cell, value) {
			// this action will remove the row, so first find the ID of the row containing this cell 
			var rowId = editableGrid.getRowId(cell.rowIndex);
			
			cell.innerHTML = "<a onclick=\"if (confirm('\u00BFDeseas eliminar esta publicidad de la seccion? ')) { editableGrid.remove(" + cell.rowIndex + "); pintar_filas(); editableGrid.renderCharts(); } \" style=\"cursor:pointer\">" +
							 "<img src=\"../art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar publicidad de la seccion\"/></a>";
			
		}}));
	
		// then we attach to the HTML table and render it
		editableGrid.attachToHTMLTable('htmlgrid');
		editableGrid.renderGrid();
		

	
	function pintar_filas(){
	
		var cont = 1;
		$("#htmlgrid tbody tr").each(function (index) {
			if(cont % 2 == 0){
				$(this).css("background-color", "#e6e6e6");
			}else{
				$(this).css("background-color", "#ffffff");
			}
			cont++;
		});
		
	
	}
	
	
	function agregar_tabla() {

		agregar_fila($("#seccion").val());
		
		pintar_filas();
		
		return false;
	}
	
	function agregar_fila(sec){
	
		var values = [];
		values={
			"seccion":sec,
			"action":"www.google.com"};

		var newRowId = 0;
		var filaSel = editableGrid.getRowCount()-1;
		if(filaSel < 0) filaSel = 0;

		/*for (var r = 0; r < editableGrid.getRowCount(); r++) newRowId = Math.max(newRowId, parseInt(editableGrid.getRowId(r)) + 1);*/
		editableGrid.insertAfter(filaSel, 'P'+editableGrid.getRowCount(), values);
	
	}
	
	
	
	function limpiar_tablas(){
	
		
		var newRowId = 0;
		for (var r = editableGrid.getRowCount()-1; r >= 0; r--) editableGrid.remove(r);
		
	
	}
	
	function limpiar_info_publicidad() {
	
		$('#formularioPublicidad').each (function(){
		  this.reset();
		});
		limpiar_tablas();
		document.getElementById('mensajes').innerHTML = "";
		document.getElementById('visor_imagen_publ').src = '../art/eventos/no_disponible.jpg';

	}
	
	function guardar_info_publicidad(){

		if(validar_publicidad()){
		
			if (confirm('\u00BFDeseas guardar esta publicidad? ')) {
		
			
				var datosTabla = new Array(); 
				
				for(i=0;i<editableGrid.getRowCount();i++){
					var fila = new Array();
					for(j=0;j<editableGrid.getColumnCount()-1;j++){
						fila.push(editableGrid.getValueAt(i,j));
					}
					datosTabla.push(fila);
				}
				
				var form =  document.forms.formularioPublicidad;
				
				
				form.datosTabla.value = JSON.stringify(datosTabla);
				form.opcion.value = 'guardar';
				
				//var archivo = '&afiche=' + document.getElementById('fileupload').value;
				
				if(document.getElementById('fileupload').value != ''){
					form.imagen_publicidad.value = document.getElementById('fileupload').value;
				}
				
				

				
				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
			
			}
			
		}//fin validar
	
	}//fin guardar_info
	
	function eliminar_info_publicidad(){

		var publ_id = $('#publicidad').val();
		
		if(publ_id != ''){
		
			if (confirm('\u00BFDeseas eliminar esta publicidad? ')) {
			
				document.forms.formularioPublicidad.opcion.value = 'eliminar';
				
				
				var form =  document.forms.formularioPublicidad;

				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
				
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique una publicidad<br>');
		}
	
	}
	
	
	function cargar_publicidad(){
		
		var publ_id = $('#publicidad').val();
		
		var form =  document.forms.formularioPublicidad;
		
		if(publ_id != ''){
			
			var param = 'opcion=consulta&publicidad=' + publ_id;
			
			var json = geturl(form.action, param, 'GET');
			
			//alert(json);
			
			var obj = jQuery.parseJSON(json);
			
			document.getElementById('nombre_publicidad').value = obj[0].publ_nombre;
			

			document.getElementById('ubicacion_publicidad').value = obj[0].publ_ubicacion;

			
			document.getElementById('visor_imagen_publ').src = '../art/publicidades/' + obj[0].publ_archivo;
			document.getElementById('imagen_publicidad').value = obj[0].publ_archivo;
			document.getElementById('publicar_publicidad').checked = obj[0].publ_publicar=='S';
			
			
			var secciones = obj[0].publ_secciones;
			
			limpiar_tablas();
			
			for(var i=0;i<secciones.length;i++){
				
				agregar_fila(secciones[i].puse_seccion);
			}
			

			pintar_filas();
		
		}else{
			limpiar_info_publicidad();
		}
		
	
	}
	
	function validar_publicidad(){
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
		
		
		if($("#formularioPublicidad").validator({
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

<form name="formularioPublicidad" id="formularioPublicidad" enctype="multipart/form-data" action="control/ctrl_publicidades.php">
<fieldset>
<!--<input type="hidden" name="directorio" id="directorio" value="art/eventos/">-->
<table width="680" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr><td width="78" height="30">&nbsp;</td></tr>
			<tr>
				<td width="75" height="30" align='left'>Publicidad Registrada</td>
				<td width="99" height="30" align='left'>              
				  <select name="publicidad" class="textonegro11r" id="publicidad" onChange="cargar_publicidad()">
				  <option value="" ><Ingresar Nuevo></option>
				  <?php 
				  
				    
					$obj = new publicidades('','','','','');
					$publicidades = $obj->get_all_publicidades();
				  
					while ($row_publicidades = mysql_fetch_assoc($publicidades)){ 
				  ?>
				  <option value="<?php echo $row_publicidades['publ_id']; ?>"><?php echo $row_publicidades['publ_nombre']; ?></option>
				  <?php  } ?>
				  </select>        
				</td>
			</tr>
			<tr height="20">
			</tr>
		</table>





<div id="tabs_publ" class="panes">
	<ul>
		<li><a href="#publ_info">Publicidad</a></li>
		<li><a href="#publ_sec">Asignar Publicidad</a></li>
	</ul>
	<div id="publ_info">
		<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr>
				<td width="200" height="30" align='left'>Nombre</td>
				<td width="100" height="30" align='left'>              
				  <input type="text" name="nombre_publicidad" title="Nombre Publicidad" id="nombre_publicidad" required="required">           
				</td>
				<td width="100" height="30" align='center' valign="top" rowspan="8" colspan="8"> 
					<img src="../art/eventos/no_disponible.jpg" id="visor_imagen_publ" width="150" height="150">
				</td>
			</tr>
			<tr>
				<td width="100" height="30" align='left'>Ubicaci&oacute;n</td>
				<td width="100" height="30" align='left'>       
					<select name="ubicacion_publicidad" id="ubicacion_publicidad" required="required">
						<option value="HORIZONTAL" >HORIZONTAL</option>
						<option value="VERTICAL" >VERTICAL</option>
						<option value="VERTICAL 2" >VERTICAL 2</option>
						<option value="VERTICAL 3" >VERTICAL 3</option>
					</select>          
				</td>
			</tr>
			<tr>
				<td width="100" height="30" align='left'>Imagen</td>
				<td width="100" height="30" align='left'>              
				  <input id="fileupload" type="file" name="files[]" onClick="inicializar_fileupload(this,false,'visor_imagen_publ')">
				  <input type="hidden" name="imagen_publicidad" id="imagen_publicidad" value="">
				</td>
			</tr>
			<tr>
				<td width="100" height="30" align='left'>Publicar</td>
				<td width="100" height="30" align='left'>              
				  <input type="checkbox" name="publicar_publicidad" id="publicar_publicidad" value="true" checked>           
				</td>
			</tr>
		</table>
	</div>
	<div id="publ_sec">
		<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr>
				<td width="100" height="30" align='left'>Secci&oacute;n</td>
				<td width="100" height="30" align='left'>       
					<select name="seccion" id="seccion" required="required">
						<option value="HOME" >HOME</option>
						<option value="QUIENES SOMOS" >QUIENES SOMOS</option>
						<option value="CALENDARIO" >CALENDARIO</option>
						<option value="MEDIOS" >MEDIOS</option>
						<option value="RANKING" >RANKING</option>
						<option value="REGLAMENTO" >REGLAMENTO</option>
						<option value="CONTACTO" >CONTACTO</option>
						<option value="HOME LIGA" >HOME LIGA</option> 
						<option value="REGLAMENTO LIGA" >REGLAMENTO LIGA</option>
						<option value="EQUIPOS LIGA" >EQUIPOS LIGA</option> 
						<option value="RESULTADOS LIGA" >RESULTADOS LIGA</option>
					</select>          
				</td>
			</tr>
			<tr>
				<td width="100" height="30">&nbsp;</td>
				<td width="100" colspan="2" align="right">
					<input type="image" name="agregar" id="agregar" value="agregar" src="../art/edit_add.png" onClick="return agregar_tabla()">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table id="htmlgrid" name="htmlgrid" class="testgrid tablaForm">
							<tr class="textoblanco12b">
								<th>Secci&oacute;n</th>
								<th></th>
							</tr>
					</table>
					<input type="hidden" name="datosTabla" id="datosTabla" value="">
					<input type="hidden" name="opcion" id="opcion" value="">
				</td>
			</tr>
		</table>
	</div>
</div>

<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
	<tr>
		<td width="50" height="50" align="left">
			<button name="nuevo" type="reset" value="nuevo" width="50" height="50" onClick="limpiar_info_publicidad()">
				<img src="../art/filenew.png"> Nuevo
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="guardar" type="button" value="guardar" width="50" height="50" onClick="guardar_info_publicidad()">
				<img src="../art/filesave.png"> Guardar
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="eliminar" type="button" value="eliminar" width="50" height="50" onClick="eliminar_info_publicidad()">
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

	$(function() {
		// setup ul.tabs to work as tabs for each div directly under div.panes
		//$("#tabs_publ").tabs("#publ_info,#publ_sec");
		$("#tabs_publ").tabs();
		 
	});
	
</script>
</body>
</html>