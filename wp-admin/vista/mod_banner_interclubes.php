<?php

require_once("../modelo/miscelaneos.php");


?>

<!DOCTYPE HTML>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<!--
<style>
	table.testgrid { border-collapse: collapse; border: 1px solid #CCB; width: 680px; }
	table.testgrid td, table.testgrid th { padding: 5px; border: 1px solid #E0E0E0; }
	table.testgrid th { background: url(../art/fondo_titulointernos.jpg); text-align: left; }
	input.invalid { background: #FBECF1; color: #FDFDFD; }
</style>
-->

<script>


	//window.onload = function() {
		
		editableGridBanner = new EditableGrid("DemoGridAttach2"); 


		// we build and load the metadata in Javascript
		editableGridBanner.load({ metadata: [	
			{ name: "titulo", datatype: "string", editable: true },
			{ name: "nombre", datatype: "string", editable: false },
			{ name: "imagen", datatype: "html", editable: false },
			{ name: "action", datatype: "html", editable: false }
		]});

		
		// render for the action column
		editableGridBanner.setCellRenderer("action", new CellRenderer({render: function(cell, value) {
			// this action will remove the row, so first find the ID of the row containing this cell 
			var rowId = editableGridBanner.getRowId(cell.rowIndex);
			
			cell.innerHTML = "<a onclick=\"if (confirm('\u00BFDeseas eliminar esta imagen del banner? ')) { editableGridBanner.remove(" + cell.rowIndex + "); pintar_filaBanner(); editableGridBanner.renderCharts(); } \" style=\"cursor:pointer\">" +
							 "<img src=\"../art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar imagen\"/></a>";
			
		}}));
		
		
		// render for the imagen column
		editableGridBanner.setCellRenderer("imagen", new CellRenderer({render: function(cell, value) {
	
			cell.innerHTML = "<img src=\"" + (value) + "\" width=\"48\" height=\"48\"/>";
			
		}}));
	
		// then we attach to the HTML table and render it
		editableGridBanner.attachToHTMLTable('htmlgridBanner');
		editableGridBanner.renderGrid();
		
		cargar_banner();
		
	//} 

	
	function pintar_filaBanner(){
		
		cont = 1;
		$("#htmlgridBanner tbody tr").each(function (index) {
			if(cont % 2 == 0){
				$(this).css("background-color", "#e6e6e6");
			}else{
				$(this).css("background-color", "#ffffff");
			}
			cont++;
		});
		
	
	}
	
	
	function agregar_tablaBanner() {
			
		if(validar_banner()){
		
			agregar_filaBanner($("#titulo_imagen").val(),
			"scripts/fileupload/server/php/files/", 
			$("#fileupload3").val().replace("C:\\fakepath\\",""));

			pintar_filaBanner();
			
		}
		
		return false;
	}
	
	
	function agregar_filaBanner(titulo,ruta,archivo){

		var values = [];
		values={
			"titulo":titulo,
			"nombre":archivo,
			"imagen":ruta+archivo,
			"action":"www.google.com"};

		var newRowId = 0;
		var filaSel = editableGridBanner.getRowCount()-1;
		if(filaSel < 0) filaSel = 0;

		/*for (var r = 0; r < editableGridBanner.getRowCount(); r++) newRowId = Math.max(newRowId, parseInt(editableGridBanner.getRowId(r)) + 1);*/
		editableGridBanner.insertAfter(filaSel, 'B'+editableGridBanner.getRowCount(), values);
		
	}
	
	
	function limpiar_tablaBanner(){
	
		
		newRowId = 0;
		for (var r = editableGridBanner.getRowCount()-1; r >= 0; r--) editableGridBanner.remove(r);
		
	
	}
	
	function limpiar_info_banner() {
	
		$('#formularioBanner').each (function(){
		  this.reset();
		});
		//limpiar_tablaBanner();
		document.getElementById('mensajes').innerHTML = "";
		//document.getElementById('visor_imagen_banner').src = '../art/eventos/no_disponible.jpg';
		cargar_banner();

	}
	
	function guardar_info_banner(){

		//if(validar_banner()){
		
			if (confirm('\u00BFDeseas guardar el banner? ')) {
		
			
				var datosBanner = new Array(); 
				
				for(i=0;i<editableGridBanner.getRowCount();i++){
					var fila = new Array();
					for(j=0;j<editableGridBanner.getColumnCount()-2;j++){
						fila.push(editableGridBanner.getValueAt(i,j));
					}
					datosBanner.push(fila);
				}
				
				
				var form = document.forms.formularioBanner;

				form.datosBanner.value = JSON.stringify(datosBanner);
				form.opcion.value = 'guardar';
				
				//var archivo = '&afiche=' + document.getElementById('fileupload').value;
				
				/*
				if(document.getElementById('fileupload2').value != ''){
					form.imagen.value = document.getElementById('fileupload2').value;
				}
				*/
				

				
				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
			
			}
			
		//}//fin validar
	
	}//fin guardar_info
	
	
	function cargar_banner(){

			var param = 'opcion=consulta';
			
			var form = document.forms.formularioBanner;
			
			var json = geturl(form.action, param, 'GET');
			
			//alert(json);
			
			var imagenes = jQuery.parseJSON(json);
 
			
			limpiar_tablaBanner();
			
			
			for(var i=0;i<imagenes.length;i++){

				agregar_filaBanner(imagenes[i].misc_titulo,"../art/banner/",imagenes[i].misc_imagen1);
			}
			
			pintar_filaBanner();
		
	}
	
	function validar_banner(){
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
		
		
		if($("#formularioBanner").validator({
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

<form name="formularioBanner" id="formularioBanner" enctype="multipart/form-data" action="control/ctrl_banner_interclubes.php">
<fieldset>
<table width="680" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
	<tr>
		<td width="100" height="40" align='left'>T&iacute;tulo</td>
		<td width="100" height="40" align='left'>              
		  <input id="titulo_imagen" type="text" name="titulo_imagen" required="required">
		</td>
	</tr>
	<tr>
		<td width="100" height="40" align='left'>Imagen</td>
		<td width="100" height="40" align='left'>              
		  <input id="fileupload3" type="file" name="files[]" required="required" onClick="inicializar_fileupload(this)">
		</td>
	</tr>
	
	<tr>
		<td width="100" height="40">&nbsp;</td>
		<td width="100" colspan="2" align="right">
			<input type="image" name="agregarBanner" id="agregarBanner" value="agregar" src="../art/edit_add.png" onClick="return agregar_tablaBanner()">
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table id="htmlgridBanner" name="htmlgridBanner" class="testgrid tablaForm">
					<tr class="textoblanco12b">
						<th>T&iacute;tulo</th>
						<th>Nombre</th>
						<th>Imagen</th>
						<th></th>
					</tr>
			</table>
			<input type="hidden" name="datosBanner" id="datosBanner" value="">
		</td>
	</tr>
</table>

<input type="hidden" name="opcion" id="opcion" value="">

<table width="680" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
	<tr>
		<td width="50" height="50" align="left">
			<button name="nuevo" type="reset" value="nuevo" width="50" height="50" onClick="limpiar_info_banner()">
				<img src="../art/filenew.png"> Nuevo
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="guardar" type="button" value="guardar" width="50" height="50" onClick="guardar_info_banner()">
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