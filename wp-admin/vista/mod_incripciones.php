<?php

$vdeporte = 1;

require_once("../modelo/deportes.php");
require_once("../modelo/modalidades.php");
require_once("../modelo/eventos.php");
require_once("../modelo/patrocinantes.php");
require_once("../modelo/draws.php");

/*
echo $_GET['depo_id']."<br>";
echo $_GET['even_id']."<br>";
*/


if ($_GET['depo_id']<>"" && $_GET['even_id']<>""){

	$vdeporte = $_GET['depo_id'];
	$vevento = $_GET['even_id'];
	
	$even = new eventos('','','','','','','','','','');
	$even = $even->get_evento($vevento);
	

}


?>

<!DOCTYPE HTML>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<style>
	table.testgrid { border-collapse: collapse; border: 1px solid #CCB; width: 640px; }
	table.testgrid td, table.testgrid th { padding: 5px; border: 1px solid #E0E0E0; }
	table.testgrid th { background: url(../art/fondo_titulointernos.jpg); text-align: left; }
	input.invalid { background: #FBECF1; color: #FDFDFD; }
	a img{border:0}
</style>

<script>


	//window.onload = function() {
	
		editableGrid = new EditableGrid("DemoGridAttach"); 


		// we build and load the metadata in Javascript
		editableGrid.load({ metadata: [
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
			{ name: "evmo_fecha", datatype: "date", editable: true },
			{ name: "campeon", datatype: "string", editable: true },
			{ name: "subcampeon", datatype: "string", editable: true },
			{ name: "action", label:"", datatype: "html", editable: false }
		]});

		
		// render for the action column
		editableGrid.setCellRenderer("action", new CellRenderer({render: function(cell, value) {
			// this action will remove the row, so first find the ID of the row containing this cell 
			var rowId = editableGrid.getRowId(cell.rowIndex);
			
			cell.innerHTML = "<a onclick=\"if (confirm('\u00BFDeseas eliminar esta modalidad del evento? ')) { editableGrid.remove(" + cell.rowIndex + "); pintar_filas(); } \" style=\"cursor:pointer\">" +
							 "<img src=\"../art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar modalidad\"/></a>";
			
		}}));
	
		// then we attach to the HTML table and render it
		editableGrid.attachToHTMLTable('htmlgrid');
		editableGrid.renderGrid();
		
		
		editableGridPatr = new EditableGrid("DemoGridAttachPatr"); 


		// we build and load the metadata in Javascript
		editableGridPatr.load({ metadata: [
			{ name: "patrocinante", datatype: "string", editable: true, values: 
				{ 
				  <?php 
				  
					$obj = new patrocinantes('','','','');
					$patrocinantes = $obj->get_all_patrocinantes();
				   
					while ($row_patrocinantes = mysql_fetch_assoc($patrocinantes)){
					
						echo $row_patrocinantes['patr_id']." : \"".$row_patrocinantes['patr_nombre']."\",\n";
					
					}
				  
				  ?>
				}
			},
			{ name: "action2", label:"", datatype: "html", editable: false }
		]});

		
		// render for the action column
		editableGridPatr.setCellRenderer("action2", new CellRenderer({render: function(cell2, value) {
			// this action will remove the row, so first find the ID of the row containing this cell 
			//var rowId = editableGridPatr.getRowId(cell2.rowIndex);
	
			//alert(cell2.rowIndex);
	
			cell2.innerHTML = "<a onclick=\"if(confirm('\u00BFDeseas eliminar este patrocinador del evento? ')) { editableGridPatr.remove(" + cell2.rowIndex + ");\n pintar_filas(); \n } \" style=\"cursor:pointer\">" +
							 "<img src=\"../art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar patrocinador\"/></a>";
			
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
	
	}
	
	
	function agregar_tabla() {

		agregar_fila($("#modalidad").attr("value"),$("#evmo_fecha").attr("value"),
						$("#campeon").attr("value"),$("#subcampeon").attr("value"));
		
		pintar_filas();
		
		return false;
	}
	
	function agregar_fila(moda, fecha, campeon, subcampeon){
	
		var values = [];
		values={
			"modalidad":moda,
			"evmo_fecha":fecha,
			"campeon":campeon,
			"subcampeon":subcampeon,
			"action":"www.google.com"};

		var newRowId = 0;
		var filaSel = editableGrid.getRowCount()-1;
		if(filaSel < 0) filaSel = 0;
		/*
		for (var r = 0; r < editableGrid.getRowCount(); r++){
			newRowId = Math.max(newRowId, parseInt(editableGrid.getRowId(r)) + 1);
		}
		*/
		
		editableGrid.insertAfter(filaSel, 'M'+editableGrid.getRowCount(), values);
	
	}
	
	
	function agregar_tablaPatr() {
			
		agregar_filaPatr($("#patrocinantes").attr("value"));

		pintar_filas();
		
		return false;
	}
	
	
	function agregar_filaPatr(patr){
		
		var values = [];
		values={
			"patrocinante":patr,
			"action2":"www.facebook.com"};

		var newRowId = 0;
		var filaSel = editableGridPatr.getRowCount()-1;
		if(filaSel < 0) filaSel = 0;

		/*for (var r = 0; r < editableGridPatr.getRowCount(); r++) newRowId = Math.max(newRowId, parseInt(editableGridPatr.getRowId(r)) + 1);*/
		editableGridPatr.insertAfter(filaSel, 'P'+editableGridPatr.getRowCount(), values);
		
	}
	
	
	function limpiar_tablas(){
	
		
		var newRowId = 0;
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
		
		document.getElementById('draws').innerHTML = "";

	}
	
	function guardar_info(){

		if(validar()){
		
			if (confirm('\u00BFDeseas guardar este evento? ')) {
		
			
				var datosTabla = new Array(); 
				
				for(i=0;i<editableGrid.getRowCount();i++){
					var fila = new Array();
					for(j=0;j<editableGrid.getColumnCount()-1;j++){
						fila.push(editableGrid.getValueAt(i,j));
					}
					datosTabla.push(fila);
				}
				
				var datosPatr = new Array(); 
				
				for(i=0;i<editableGridPatr.getRowCount();i++){
					var fila = new Array();
					for(j=0;j<editableGridPatr.getColumnCount()-1;j++){
						fila.push(editableGridPatr.getValueAt(i,j));
					}
					datosPatr.push(fila);
				}
				
				
				
				document.forms.formulario.datosTabla.value = JSON.stringify(datosTabla);
				document.forms.formulario.datosPatr.value = JSON.stringify(datosPatr);
				document.forms.formulario.opcion.value = 'guardar';
				
				//var archivo = '&afiche=' + document.getElementById('fileupload').value;
				
				if(document.getElementById('fileupload').value != ''){
					document.forms.formulario.afiche.value = document.getElementById('fileupload').value;
				}
				
				var form =  document.forms.formulario;

				
				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
			
			}
			
		}//fin validar
	
	}//fin guardar_info
	
	function eliminar_info(){

		var even_id = $('#eventos').val();
		
		if(even_id != ''){
		
			if (confirm('\u00BFDeseas eliminar este evento? ')) {
			
				document.forms.formulario.opcion.value = 'eliminar';
				
				
				var form =  document.forms.formulario;

				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
				
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique un evento<br>');
		}
	
	}
	
	
	function cargar_evento(){
		
		var even_id = $('#eventos').val();
		
		var form =  document.forms.formulario;
		
		if(even_id != ''){
			
			var param = 'opcion=consulta&eventos=' + even_id;
			
			var json = geturl(form.action, param, 'GET');
			
			//alert(json);
			
			var obj = jQuery.parseJSON(json);
			
			document.getElementById('nombre').value = obj[0].even_nombre;
			
			var fecha = new Date(obj[0].even_fecha);
			var api = $("#even_fecha").data("dateinput");
			api.setValue(fecha);
			
			document.getElementById('sede').value = obj[0].even_sede;
			document.getElementById('ciudad').value = obj[0].even_ciudad;
			document.getElementById('publicarhome').checked = obj[0].even_publicarhome=='S';
			
			document.getElementById('visor_imagen').src = '../art/eventos/' + obj[0].even_afiche;
			document.getElementById('afiche').value = obj[0].even_afiche;
			document.getElementById('publicar').checked = obj[0].even_publicar=='S';
			
			
			var modalidades = obj[0].even_modalidades;
			var patrocinantes = obj[0].even_patrocinantes;
			var draws = obj[0].even_draws;
			
			limpiar_tablas();
			
			for(var i=0;i<modalidades.length;i++){
				api = $("#evmo_fecha").data("dateinput");
				api.setValue(new Date(modalidades[i].evmo_fecha));
				agregar_fila(modalidades[i].moda_id,$("#evmo_fecha").attr("value"),
								modalidades[i].evmo_premiacion,modalidades[i].evmo_subcampeon);
			}
			
			for(var i=0;i<patrocinantes.length;i++){
				agregar_filaPatr(patrocinantes[i].patr_id);
			}
			
			
			
			document.getElementById('draws').innerHTML = "";
			var etiqueta;
			
			etiqueta = '<table>';
			
			for(var i=0;i<draws.length;i++){
						
					etiqueta += '<tr>';
					
						etiqueta += '<td>';
							etiqueta += '<a class="textogris11b" title="Ver Draw" href="edicion_draw.php?even_id='+even_id+'&evmo_id='+draws[i]['evmo_id']+'" target="_blank">';
							
							//etiqueta += '<a class="textogris11b" title="Ver Draw" href="" onClick="return cargar_form(\'vista/mod_edicion_draw.php?even_id='+even_id+'&evmo_id='+draws[i]['evmo_id']+'\',\'Gestionar Draws\')">';
							
								etiqueta += draws[i]['moda_nombre'];
							etiqueta += '</a>';
						etiqueta += '</td>';
						
						/*
						etiqueta += '<td>';
							etiqueta += '<a class="puntajes" class="fancybox.ajax" href="../mod_draws_puntos.php?evmo_id='
											+draws[i]['evmo_id']+'"><img src="../art/boton_puntajes.png"></a>';
						etiqueta += '</td>';
						*/

						etiqueta += '<td>';
							etiqueta += '<a href="#" title="Calcular puntos del draw" class="fancybox.ajax" onClick="return calcular_puntos_draw('+draws[i]['evmo_id']+')"><img src="../art/boton_calcular.png"></a>';
						etiqueta += '</td>';
						
						etiqueta += '<td>';
							etiqueta += '<a href="#" title="Asignar puntos a los ranking" class="fancybox.ajax" onClick="return asignar_puntos_ranking('+draws[i]['evmo_id']+')"><img src="../art/boton_asignar.png"></a>';
						etiqueta += '</td>';
						
					etiqueta += '</tr>';			

			}
			
			etiqueta += '</table>';
			
			$("#draws").append(etiqueta);
			
			pintar_filas();
		
		}else{
			limpiar_info();
		}
		
	
	}
	
	
	function calcular_puntos_draw(evmo_id){
	
		if (confirm('\u00BFDeseas recalcular los puntos de este draw? ')) {
	
			$.blockUI({ message: '<img src="../art/cargando.gif" width="48" height="48">',
						css: { 
							top:  ($(window).height() - 48) /2 + 'px', 
							left: ($(window).width() - 48) /2 + 'px', 
							width: '48px',
							border: 'none', 
							//padding: '15px', 
							backgroundColor: '#000', 
							'-webkit-border-radius': '10px', 
							'-moz-border-radius': '10px', 
							opacity: .5, 
							color: '#fff'
						} 
			});
		
		
			$('#mensajes').html(geturl('control/ctrl_draws.php', 'opcion=calcular&evmo_id=' + evmo_id, 'GET'));
		
		
			$.unblockUI();
		
		}
		
		
		return false;
	}
	
	function asignar_puntos_ranking(evmo_id){
	
		if (confirm('\u00BFDeseas asignar los puntos de este draw a los rankings? ')) {
	
			$.blockUI({ message: '<img src="../art/cargando.gif" width="48" height="48">',
						css: { 
							top:  ($(window).height() - 48) /2 + 'px', 
							left: ($(window).width() - 48) /2 + 'px', 
							width: '48px',
							border: 'none', 
							//padding: '15px', 
							backgroundColor: '#000', 
							'-webkit-border-radius': '10px', 
							'-moz-border-radius': '10px', 
							opacity: .5, 
							color: '#fff'
						} 
			});

			
			$('#mensajes').html(geturl('control/ctrl_draws.php', 'opcion=asignar&evmo_id=' + evmo_id, 'GET'));
		
			$.unblockUI();
		
		}
		
		
		
		return false;
	}
	
	function validar(){
		
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
	
	} 
	
</script>


</head>

<body>


<div id="mensajes" name="mensajes" class="textoverdeesmeralda11b"></div>

<form name="formulario" id="formulario" enctype="multipart/form-data" action="control/ctrl_eventos.php">
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
				<td width="75" height="30" align='left'>Eventos Registrados</td>
				<td width="99" height="30" align='left'>              
				  <select name="eventos" class="textonegro11r" id="eventos" onChange="cargar_evento()">
				  <option value="" ><Ingresar Nuevo></option>
				  <?php 
				  
				    
					$obj = new eventos('','','','','','','','','','','');
					$eventos = $obj->get_all_eventos($vdeporte);
				  
					while ($row_eventos = mysql_fetch_assoc($eventos)){ 
				  ?>
				  <option value="<?php echo $row_eventos['even_id']; ?>" <?php if ($vevento==$row_eventos['even_id']) { ?> selected <?php } ?>><?php echo $row_eventos['even_nombre']; ?></option>
				  <?php  } ?>
				  </select>        
				</td>
			</tr>
			<tr height="20">
			</tr>
		</table>

<ul class="tabs">
<li><a href="#">Informaci&oacute;n del Evento</a></li>
<li><a href="#">Modalidades y Premios</a></li>
<li><a href="#">Patrocinantes</a></li>
<li><a href="#">Draws</a></li>
</ul>



<div class="panes">
	<div id="info">
		<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr>
				<td width="200" height="30" align='left'>Nombre del Evento</td>
				<td width="100" height="30" align='left'>              
				  <input type="text" name="nombre" title="Nombre del Evento" id="nombre" required="required">           
				</td>
				<td width="100" height="30" align='center' valign="top" rowspan="8" colspan="8"> 
					<img src="../art/eventos/no_disponible.jpg" id="visor_imagen" width="150" height="150">
				</td>
			</tr>
			<tr>
				<td width="100" height="30" align='left'>Fecha del Evento</td>
				<td width="100" height="30" align='left'>              
					<input type="date" class="date" id="even_fecha" name="even_fecha" required="required"/>
				</td>
			</tr>
			<tr>
				<td width="100" height="30" align='left'>Sede</td>
				<td width="100" height="30" align='left'>              
				  <input type="text" name="sede" id="sede" required="required">           
				</td>
			</tr>
			<tr>
				<td width="100" height="30" align='left'>Ciudad</td>
				<td width="100" height="30" align='left'>              
				  <input type="text" name="ciudad" id="ciudad" required="required">           
				</td>
			</tr>
			<tr>
				<td width="100" height="30" align='left'>Afiche</td>
				<td width="100" height="30" align='left'>              
				  <input id="fileupload" type="file" name="files[]" onClick="inicializar_fileupload(this)">
				  <input type="hidden" name="afiche" id="afiche" value="">
				</td>
			</tr>
			<tr>
				<td width="100" height="30" align='left'>Publicar al Inicio</td>
				<td width="100" height="30" align='left'>              
				  <input type="checkbox" name="publicarhome" id="publicarhome" value="true" checked>           
				</td>
			</tr>
			<tr>
				<td width="100" height="30" align='left'>Publicar</td>
				<td width="100" height="30" align='left'>              
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
				<td width="100" height="30" align='left'>Fecha del Evento</td>
				<td width="100" height="30" align='left'>              
					<input type="date" class="date" id="evmo_fecha" name="evmo_fecha"/>
				</td>
			</tr>
			<tr>
				<td width="100" height="30" align='left' class="textoverde11b">PREMIACI&Oacute;N</td>
			</tr>
			<tr>
				<td width="100" height="30" align='left'>Campe&oacute;n</td>
				<td width="100" height="30" align='left'>              
				  <input type="text" name="campeon" id="campeon">           
				</td>
			</tr>
			<tr>
				<td width="100" height="30" align='left'>Sub-Campe&oacute;n</td>
				<td width="100" height="30" align='left'>              
				  <input type="text" name="subcampeon" id="subcampeon">           
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
					<table id="htmlgrid" name="htmlgrid" class="testgrid">
						<thead>
							<tr class="textoblanco12b">
								<th>Modalidad</th>
								<th>Fecha</th>
								<th>Campe&oacute;n</th>
								<th>Sub-Campe&oacute;n</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
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
					<input type="hidden" name="datosTabla" id="datosTabla" value="">
					<input type="hidden" name="opcion" id="opcion" value="">
				</td>
			</tr>
		</table>
	</div>
	<div id="patro">
		<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr>
				<td width="100" height="30" align='left'>Patrocinante</td>
				<td width="100" height="30" align='left'>              
				  <select name="patrocinantes" class="textonegro11r" id="patrocinantes">
				  <?php 
				  
				    
					$obj = new patrocinantes('','','','');
					$patrocinantes = $obj->get_all_patrocinantes_activos();
				  
					$cont = 1; 
					while ($row_patrocinantes = mysql_fetch_assoc($patrocinantes)){ 
				  ?>
				  <option value="<?php echo $row_patrocinantes['patr_id']; ?>"  <?php if (cont==1) { ?> selected <?php } ?> ><?php echo $row_patrocinantes['patr_nombre']; ?></option>
				  <?php  } ?>
				  </select>              
				</td>
			</tr>
			<tr>
				<td width="100" height="30">&nbsp;</td>
				<td width="100" colspan="2" align="right">
					<input type="image" name="agregarPatr" id="agregarPatr" value="agregar" src="../art/edit_add.png" onClick="return agregar_tablaPatr()">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table id="htmlgridPatr" name="htmlgridPatr" class="testgrid">
						<thead>
							<tr class="textoblanco12b">
								<th>Patrocinante</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					<input type="hidden" name="datosPatr" id="datosPatr" value="">
				</td>
			</tr>
		</table>
	</div>
	<div id="draws" align="left">
	</div>
	
	<div id="inscripcion" align="left">
	
		<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
			<tr>
				<td width="100" height="30" align='left'>Modalidad</td>
				<td width="100" height="30" align='left'>              
				  <select name="modaInscripcion" class="textonegro11r" id="modaInscripcion">
				  <?php 
				    
					$obj = new modalidades('','','','','','','');
					$modalidades = $obj->get_all_modalidades_activas($vdeporte);
				  
					$cont = 1; 
					while ($row_modalidades = mysql_fetch_assoc($modalidades)){ 
				  ?>
				  <option value="<?php echo $row_modalidades['moda_id']; ?>"><?php echo $row_modalidades['moda_nombre']; ?></option>
				  <?php  } ?>
				  </select>              
				</td>
			</tr>
			<tr>
				<td>
					<table id="htmlgridInsc" name="htmlgridInsc" class="testgrid">
						<thead>
							<tr class="textoblanco12b">
								<th>Fecha</th>
								<th>Jugador</th>
								<th>Jugador Doble</th>
								<th>Estatus</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
	
	
	</div>
	
</div>

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
	$(function() {
		// setup ul.tabs to work as tabs for each div directly under div.panes
		$("ul.tabs").tabs("div.panes > div");
	});
</script>
<script>
	$("#even_fecha").dateinput({
		lang:'es',
		format: 'dd/mm/yyyy',	// the format displayed for the user
		selectors: true,             	// whether month/year dropdowns are shown
		//min: -1000,                    // min selectable day (100 days backwards)
		//max: 1000,                    	// max selectable day (100 days onwards)
		offset: [10, 20],            	// tweak the position of the calendar
		speed: 'fast',               	// calendar reveal speed
		firstDay: 1                  	// which day starts a week. 0 = sunday, 1 = monday etc..
	});
	$("#evmo_fecha").dateinput({
		lang:'es',	
		format: 'dd/mm/yyyy',	// the format displayed for the user
		selectors: true,             	// whether month/year dropdowns are shown
		//min: -1000,                    // min selectable day (100 days backwards)
		//max: 1000,                    	// max selectable day (100 days onwards)
		offset: [10, 20],            	// tweak the position of the calendar
		speed: 'fast',               	// calendar reveal speed
		firstDay: 1                  	// which day starts a week. 0 = sunday, 1 = monday etc..
	});
</script>
</body>
</html>