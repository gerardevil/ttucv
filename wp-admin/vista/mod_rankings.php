<?php

$vdeporte = 1;

require_once("../modelo/deportes.php");
require_once("../modelo/rankings.php");
require_once("../modelo/modalidades.php");


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

	$(function() {
		// setup ul.tabs to work as tabs for each div directly under div.panes
		$("#tabs").tabs();
	});
	
	//window.onload = function() {
	
		editableGridModa = new EditableGrid("DemoGridAttachModa"); 


		// we build and load the metadata in Javascript
		editableGridModa.load({ metadata: [
			{ name: "modalidad", datatype: "string", editable: true, values: 
				{ 
				  <?php 
				  
					$obj = new modalidades('','','','','','','');
					$modalidades = $obj->get_all_modalidades($vdeporte);
				  
					$cont = 1; 
					while ($row_modalidades = mysql_fetch_assoc($modalidades)){
					
						echo $row_modalidades['moda_id']." : \"".$row_modalidades['moda_nombre']."\",\n";
					
					}
				  
				  ?>
				}
			},
			{ name: "action", label:"", datatype: "html", editable: false }
		]});

		
		// render for the action column
		editableGridModa.setCellRenderer("action", new CellRenderer({render: function(cell, value) {
			// this action will remove the row, so first find the ID of the row containing this cell 
			var rowId = editableGridModa.getRowId(cell.rowIndex);
			
			cell.innerHTML = "<a onclick=\"if (confirm('\u00BFDeseas eliminar esta modalidad del ranking? ')) { editableGridModa.remove(" + cell.rowIndex + "); pintar_filas(); editableGridModa.renderCharts(); } \" style=\"cursor:pointer\">" +
							 "<img src=\"../art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar modalidad\"/></a>";
			
		}}));
	
		// then we attach to the HTML table and render it
		editableGridModa.attachToHTMLTable('htmlgridModa');
		editableGridModa.renderGrid();
		
	/*
	
		editableGrid = new EditableGrid("DemoGridAttach"); 


		// we build and load the metadata in Javascript
		editableGrid.load({ metadata: [
			{ name: "nro", datatype: "integer", editable: false },
			{ name: "jugador", datatype: "string", editable: true },
			{ name: "puntos", datatype: "double(,2)", editable: true },
			{ name: "tj", datatype: "integer", editable: true },
			{ name: "action", label:"", datatype: "html", editable: false }
		]});

		
		// render for the action column
		editableGrid.setCellRenderer("action", new CellRenderer({render: function(cell, value) {
			// this action will remove the row, so first find the ID of the row containing this cell 
			var rowId = editableGrid.getRowId(cell.rowIndex);
			
			cell.innerHTML = "<a onclick=\"if (confirm('\u00BFDeseas eliminar este jugador del ranking? ')) { editableGrid.remove(" + cell.rowIndex + "); pintar_filas(); editableGrid.renderCharts(); } \" style=\"cursor:pointer\">" +
							 "<img src=\"../art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar jugador\"/></a>";
			
		}}));
	
		// then we attach to the HTML table and render it
		editableGrid.attachToHTMLTable('htmlgrid');
		editableGrid.renderGrid();
		
		*/
		
		editableGridPatr = new EditableGrid("DemoGridAttach2"); 


		// we build and load the metadata in Javascript
		editableGridPatr.load({ metadata: [	
			{ name: "descripcion", datatype: "string", editable: true },
			{ name: "nombre", datatype: "string", editable: false },
			{ name: "publicar", datatype: "boolean", editable: true },
			{ name: "imagen", datatype: "html", editable: false },
			{ name: "action", datatype: "html", editable: false }
		]});

		
		// render for the action column
		editableGridPatr.setCellRenderer("action", new CellRenderer({render: function(cell, value) {
			// this action will remove the row, so first find the ID of the row containing this cell 
			var rowId = editableGridPatr.getRowId(cell.rowIndex);
			
			cell.innerHTML = "<a onclick=\"if (confirm('\u00BFDeseas eliminar esta foto del ranking? ')) { editableGridPatr.remove(" + cell.rowIndex + "); pintar_filas(); editableGridPatr.renderCharts(); } \" style=\"cursor:pointer\">" +
							 "<img src=\"../art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar foto\"/></a>";
			
		}}));
		
		
		// render for the imagen column
		editableGridPatr.setCellRenderer("imagen", new CellRenderer({render: function(cell, value) {
	
			cell.innerHTML = "<img src=\"" + (value) + "\" width=\"48\" height=\"48\"/>";
			
		}}));
	
		// then we attach to the HTML table and render it
		editableGridPatr.attachToHTMLTable('htmlgridPatr');
		editableGridPatr.renderGrid();
		
	//} 

	
	
	
	
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
		
		
		cont = 1;
		$("#htmlgridPatr tbody tr").each(function (index) {
			if(cont % 2 == 0){
				$(this).css("background-color", "#e6e6e6");
			}else{
				$(this).css("background-color", "#ffffff");
			}
			cont++;
		});
		
		
		cont = 1;
		$("#htmlgridModa tbody tr").each(function (index) {
			if(cont % 2 == 0){
				$(this).css("background-color", "#e6e6e6");
			}else{
				$(this).css("background-color", "#ffffff");
			}
			cont++;
		});
		
	
	}
	
	
	function agregar_tabla() {

		agregar_fila($("#jugador").attr("value"),$("#puntos").attr("value"),
						$("#tj").attr("value"));
		
		pintar_filas();
		
		return false;
	}
	
	function agregar_fila(jugador, puntos, tj){
	
		var values = [];
		
		var nro = editableGrid.getRowCount()+1;
		
		values={
			"nro":nro,
			"jugador":jugador,
			"puntos":puntos,
			"tj":tj,
			"action":"www.google.com"};

		var newRowId = 0;
		var filaSel = editableGrid.getRowCount()-1;
		if(filaSel < 0) filaSel = 0;

		/*for (var r = 0; r < editableGrid.getRowCount(); r++) newRowId = Math.max(newRowId, parseInt(editableGrid.getRowId(r)) + 1);*/
		editableGrid.insertAfter(filaSel, 'J'+editableGrid.getRowCount(), values);
	
	}
	
	
	function agregar_tablaModa() {

		agregar_filaModa($("#modalidad").attr("value"));
		
		pintar_filas();
		
		return false;
	}
	
	function agregar_filaModa(modalidad){
	
		var values = [];
		
		var nro = editableGridModa.getRowCount()+1;
		
		values={
			"modalidad":modalidad,
			"action":"www.google.com"};

		var newRowId = 0;
		var filaSel = editableGridModa.getRowCount()-1;
		if(filaSel < 0) filaSel = 0;

		/*for (var r = 0; r < editableGridModa.getRowCount(); r++) newRowId = Math.max(newRowId, parseInt(editableGridModa.getRowId(r)) + 1);*/
		editableGridModa.insertAfter(filaSel, 'M'+editableGridModa.getRowCount(), values);
	
	}
	
	function agregar_tablaPatr() {
			
		agregar_filaPatr($("#descripcion").val(),
		"scripts/fileupload/server/php/files/", 
		$("#fileupload3").val().replace("C:\\fakepath\\",""),
		$("#publicar_foto").attr("checked"));

		pintar_filas();
		
		return false;
	}
	
	
	function agregar_filaPatr(descripcion,ruta,archivo,publicar){
		
		var values = [];
		values={
			"descripcion":descripcion,
			"nombre":archivo,
			"publicar":publicar,
			"imagen":ruta+archivo,
			"action":"www.google.com"};
			
		var newRowId = 0;
		var filaSel = editableGridPatr.getRowCount()-1;
		if(filaSel < 0) filaSel = 0;

		/*for (var r = 0; r < editableGridPatr.getRowCount(); r++) newRowId = Math.max(newRowId, parseInt(editableGridPatr.getRowId(r)) + 1);*/
		editableGridPatr.insertAfter(filaSel, 'F'+editableGridPatr.getRowCount(), values);
		
	}
	
	
	function limpiar_tablas(){
	
		
		var newRowId = 0;
		for (var r = editableGridModa.getRowCount()-1; r >= 0; r--) editableGridModa.remove(r);
		
		newRowId = 0;
		for (var r = editableGrid.getRowCount()-1; r >= 0; r--) editableGrid.remove(r);

		/*
		editableGrid.attachToHTMLTable('htmlgrid');
		editableGrid.renderGrid();
		*/

		newRowId = 0;
		for (var r = editableGridPatr.getRowCount()-1; r >= 0; r--) editableGridPatr.remove(r);
		
		/*
		editableGridPatr.attachToHTMLTable('htmlgrid');
		editableGridPatr.renderGrid();
		*/
	
	}
	
	function limpiar_info() {
	
		$('#formulario').each (function(){
		  this.reset();
		});
		limpiar_tablas();
		document.getElementById('mensajes').innerHTML = "";
		document.getElementById('visor_imagen').src = '../art/eventos/no_disponible.jpg';
		document.getElementById('botonActualizar').style.display = 'none'; 

	}
	
	function guardar_info(){

		if(validar()){
		
			if (confirm('\u00BFDeseas guardar este ranking? ')) {
				
				var datosModa = new Array(); 
				
				for(i=0;i<editableGridModa.getRowCount();i++){
					var fila = new Array();
					for(j=0;j<editableGridModa.getColumnCount()-1;j++){
						fila.push(editableGridModa.getValueAt(i,j));
					}
					datosModa.push(fila);
				}
				
				/*
				var datosPos = new Array(); 
				
				for(i=0;i<editableGrid.getRowCount();i++){
					var fila = new Array();
					for(j=0;j<editableGrid.getColumnCount()-1;j++){
						fila.push(editableGrid.getValueAt(i,j));
					}
					datosPos.push(fila);
				}
				*/
				
				var datosPatr = new Array(); 
				
				for(i=0;i<editableGridPatr.getRowCount();i++){
					var fila = new Array();
					for(j=0;j<editableGridPatr.getColumnCount()-2;j++){
						fila.push(editableGridPatr.getValueAt(i,j));
					}
					datosPatr.push(fila);
				}
				
				
				document.forms.formulario.datosModa.value = JSON.stringify(datosModa);
				//document.forms.formulario.datosPos.value = JSON.stringify(datosPos);
				document.forms.formulario.datosPatr.value = JSON.stringify(datosPatr);
				document.forms.formulario.opcion.value = 'guardar';
				
				//var archivo = '&afiche=' + document.getElementById('fileupload').value;
				
				if(document.getElementById('fileupload').value != ''){
					document.forms.formulario.archivo.value = document.getElementById('fileupload').value;
				}
				
				if(document.getElementById('fileupload2').value != ''){
					document.forms.formulario.imagen.value = document.getElementById('fileupload2').value;
				}
				
				var form =  document.forms.formulario;

				
				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
			
			}
			
		}//fin validar
	
	}//fin guardar_info
	
	function eliminar_info(){

		var rank_id = $('#ranking').val();
		
		if(rank_id != ''){
		
			if (confirm('\u00BFDeseas eliminar este ranking? ')) {
			
				document.forms.formulario.opcion.value = 'eliminar';
				
				
				var form =  document.forms.formulario;

				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
				
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique un ranking<br>');
		}
	
	}
	
	
	function cargar_ranking(){
		
		var rank_id = $('#ranking').val();
		
		var form =  document.forms.formulario;
		
		if(rank_id != ''){
			
			var param = 'opcion=consulta&ranking=' + rank_id;
			
			var json = geturl(form.action, param, 'GET');
			
			//alert(json);
			
			var obj = jQuery.parseJSON(json);
			
			document.getElementById('nombre').value = obj[0].rank_nombre;
			document.getElementById('ano').value = obj[0].rank_ano;
			document.getElementById('archivo').value = obj[0].rank_archivo;
			document.getElementById('visor_imagen').src = '../art/rankings/' + obj[0].rank_imagen;
			document.getElementById('imagen').value = obj[0].rank_imagen;
			document.getElementById('publicar').checked = obj[0].rank_publicar=='S';
			
			var modalidades = obj[0].rank_modalidades;
			//var jugadores = obj[0].rank_posiciones;
			var fotos = obj[0].rank_fotos;
			
			
			limpiar_tablas();
			
			
			for(var i=0;i<modalidades.length;i++){

				agregar_filaModa(modalidades[i].moda_id);
			}
			
			/*
			for(var i=0;i<jugadores.length;i++){

				agregar_fila(jugadores[i].rapo_jugador,jugadores[i].rapo_puntos,
								jugadores[i].rapo_tj);
			}
			*/
			

			for(var i=0;i<fotos.length;i++){

				agregar_filaPatr(fotos[i].rafo_descripcion,"../art/rankings/",fotos[i].rafo_foto,
									fotos[i].rafo_publicar == 'S');
			}

			pintar_filas();
			
			document.getElementById('botonActualizar').style.display = 'block'; 
			
		
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
	
	function actualizar_puntos_ranking(){
	
		var rank_id = $('#ranking').val();;
		
		if(rank_id != ''){
		
			if (confirm('\u00BFDeseas actualizar los puntos de este rankings? ')) {
		
				$('#panelprincipal').hideLoading();
				$('#panelprincipal').showLoading();
				
				$.ajax({  
					 type: 'GET',  
					 url: 'control/ctrl_rankings.php',
					 data: 'opcion=actualizar&ranking=' + rank_id,
					 //async: false
					 success: function(res){
						$('#mensajes').html(res);
					 },
					 complete: function(){
						$('#panelprincipal').hideLoading();
					 }
				});
				
			
			}
		
		}else{
			alert('Debe seleccionar un ranking');
		}
		
		return false;
	}
	
	
	limpiar_info();
	
</script>


</head>

<body>

<div id="mensajes" name="mensajes" class="textoverdeesmeralda11b"></div>

<form name="formulario" id="formulario" enctype="multipart/form-data" action="control/ctrl_rankings.php">
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
				<td width="75" height="30" align='left'>Rankings Registrados</td>
				<td width="99" height="30" align='left'>              
				  <select name="ranking" class="textonegro11r" id="ranking" onChange="cargar_ranking()">
				  <option value="" ><Ingresar Nuevo></option>
				  <?php 
				  
				    
					$obj = new rankings('','','','','','','');
					$ranking = $obj->get_all_rankings($vdeporte);
				  
					while ($row_ranking = mysql_fetch_assoc($ranking)){ 
				  ?>
				  <option value="<?php echo $row_ranking['rank_id']; ?>"><?php echo $row_ranking['rank_nombre']; ?></option>
				  <?php  } ?>
				  </select>        
				</td>
			</tr>
			<tr height="20">
			</tr>
		</table>





<div id="tabs">
	<ul>
		<li><a href="#info">Ranking</a></li>
		<li><a href="#moda">Modalidades</a></li>
		<!--<li><a href="#">Posiciones</a></li>-->
		<li><a href="#patro">Fotos</a></li>
	</ul>
	<div id="info">
		<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr>
				<td width="100" height="40" align='left'>Nombre del Ranking</td>
				<td width="100" height="40" align='left'>              
				  <input type="text" name="nombre" id="nombre" required="required">           
				</td>
				<td width="100" height="40" align='center' valign="top" rowspan="8" colspan="8"> 
					<img src="../art/eventos/no_disponible.jpg" id="visor_imagen" width="150" height="150">
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>A&ntilde;o</td>
				<td width="100" height="40" align='left'>              
					<input type="number" id="ano" name="ano" required="required" minlength="4" minlength="4"/>
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Ranking Detallado</td>
				<td width="100" height="40" align='left'>              
				  <input id="fileupload" type="file" name="files[]" onClick="inicializar_fileupload(this,true)">
				  <input type="hidden" name="archivo" id="archivo" value="">
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Imagen</td>
				<td width="100" height="40" align='left'>              
				  <input id="fileupload2" type="file" name="files[]" onClick="inicializar_fileupload(this)">
				  <input type="hidden" name="imagen" id="imagen" value="">
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Publicar</td>
				<td width="100" height="40" align='left'>              
				  <input type="checkbox" name="publicar" id="publicar" value="true" checked>           
				</td>
			</tr>
		</table>
	</div>
	<div id="moda">
		<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr>
				<td width="100" height="30" align='left'>Modalidad</td>
				<td width="100" height="30" align='left'>              
				  <select name="modalidad" class="textonegro11r" id="modalidad">
				  <?php 
				  
				    
					$obj = new modalidades('','','','','','','');
					$modalidades = $obj->get_all_modalidades_activas($vdeporte);
				  
					$cont = 1; 
					while ($row_modalidades = mysql_fetch_assoc($modalidades)){ 
				  ?>
				  <option value="<?php echo $row_modalidades['moda_id']; ?>"  <?php if (cont==1) { ?> selected <?php } ?> ><?php echo $row_modalidades['moda_nombre']; ?></option>
				  <?php  } ?>
				  </select>              
				</td>
			</tr>
			<tr>
				<td width="60" height="40" align="center">
					<a id="botonActualizar" href="#" title="Actualizar puntos del ranking" onClick="return actualizar_puntos_ranking()">
						<img src="../art/boton_actualizar.png">
					</a>
				</td>
				<td width="140" colspan="2" align="right">
					<input type="image" name="agregarModa" id="agregarModa" value="agregar" src="../art/edit_add.png" onClick="return agregar_tablaModa()">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table id="htmlgridModa" name="htmlgridModa" class="testgrid tablaForm">
							<tr class="textoblanco12b">
								<th>Modalidades</th>
								<th></th>
							</tr>
							<!--
							<tr id="R1" bgcolor="#ffffff" align="left" valign="middle" class="textogris11b">
								<td height="12"></td>
								<td height="12"></td>
								<td height="12">&nbsp;</td>
								<td height="12">&nbsp;</td>
							</tr>
							<tr id="R2" bgcolor="#e6e6e6" align="left" valign="middle" class="textogris11b">
								<td height="12"></td>
								<td height="12"></td>
								<td height="12">&nbsp;</td>
								<td height="12">&nbsp;</td>
							</tr>
							-->
					</table>
					<input type="hidden" name="datosModa" id="datosModa" value="">
				</td>
			</tr>
		</table>
	</div>
	<!--
	<div id="posiciones">
		<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr>
				<td width="100" height="40" align='left'>Nombre del Jugador</td>
				<td width="100" height="40" align='left'>              
					<input type="text" id="jugador" name="jugador"/>
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Puntos</td>
				<td width="100" height="40" align='left'>              
				  <input type="number" name="puntos" id="puntos">           
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>TJ</td>
				<td width="100" height="40" align='left'>              
				  <input type="number" name="tj" id="tj">           
				</td>
			</tr>
			<tr>
				<td width="100" height="40">&nbsp;</td>
				<td width="100" colspan="2" align="right">
					<input type="image" name="agregar" id="agregar" value="agregar" src="../art/edit_add.png" onClick="return agregar_tabla()">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table id="htmlgrid" name="htmlgrid" class="testgrid">
							<tr class="textoblanco12b">
								<th>Nro.</th>
								<th>Jugador</th>
								<th>Puntos</th>
								<th>TJ</th>
								<th></th>
							</tr>
							
					</table>
					<input type="hidden" name="datosPos" id="datosPos" value="">
					
				</td>
			</tr>
		</table>
	</div>
	-->
	<div id="patro">
		<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr>
				<td width="100" height="40" align='left'>Descripcion</td>
				<td width="100" height="40" align='left'>              
				  <input id="descripcion" type="text" name="descripcion">
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Foto</td>
				<td width="100" height="40" align='left'>              
				  <input id="fileupload3" type="file" name="files[]" onClick="inicializar_fileupload(this)">
				</td>
			</tr>
			<tr>
				<td width="100" height="40" align='left'>Publicar</td>
				<td width="100" height="40" align='left'>              
				  <input type="checkbox" name="publicar_foto" id="publicar_foto" value="true" checked>           
				</td>
			</tr>
			<tr>
				<td width="100" height="40">&nbsp;</td>
				<td width="100" colspan="2" align="right">
					<input type="image" name="agregarPatr" id="agregarPatr" value="agregar" src="../art/edit_add.png" onClick="return agregar_tablaPatr()">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table id="htmlgridPatr" name="htmlgridPatr" class="testgrid tablaForm">
							<tr class="textoblanco12b">
								<th>Descripcion</th>
								<th>Nombre</th>
								<th>Publicar</th>
								<th>Imagen</th>
								<th></th>
							</tr>
					</table>
					<input type="hidden" name="datosPatr" id="datosPatr" value="">
				</td>
			</tr>
		</table>
	</div>
</div>

<input type="hidden" name="opcion" id="opcion" value="">

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

</body>
</html>