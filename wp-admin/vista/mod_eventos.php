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

<!--
<style>
	table.testgrid { border-collapse: collapse; border: 1px solid #CCB; width: 640px; }
	table.testgrid td, table.testgrid th { padding: 5px; border: 1px solid #E0E0E0; }
	table.testgrid th { background: url(../art/fondo_titulointernos.jpg); text-align: left; }
	input.invalid { background: #FBECF1; color: #FDFDFD; }
	a img{border:0}
</style>
-->
<script>
	$(function() {
		// setup ul.tabs to work as tabs for each div directly under div.panes
		//$("ul.tabs").tabs("div.panes > div");
		
		$("#tabs").tabs({ heightStyle: "content" });
		
		$("#even_fecha").datepicker({
	      changeMonth: true,
	      changeYear: true,
		  minDate: -1000, 
		  maxDate: 1000
	    });
		
		$("#evmo_fecha").datepicker({
	      changeMonth: true,
	      changeYear: true,
		  minDate: -1000, 
		  maxDate: 1000
	    });
		
	});
	
	/*
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
	*/
	
</script>


<script>

	var moda = null;

	function seleccionar_by_php(){
		
		var evento = "<?php echo $_GET['even_id']; ?>";
		moda = "<?php echo $_GET['evmo_id']; ?>";
		var opcion = "<?php echo $_GET['opcion']; ?>";
		
		//alert("evento: "+evento+ "\nmoda: "+moda+ "\nopcion: "+opcion);
		
		
		if(evento != ""){
			//$('#eventos').val(evento);
			$('#eventos option:[value='+evento+']').attr("selected","selected");
			cargar_evento();
		}
		
		
		if(moda != ""){
			//$('#modaInscripcion').val(moda);
			$('#modaInscripcion option:[value='+moda+']').attr("selected","selected");
			cargar_inscripciones();
		}
		
		
		if(opcion == "inscripciones"){
			var api = $("ul#tabsEven").data("tabs");
			api.click(4);
		}
		
	}



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
			{ name: "inscripcion", datatype: "double(2)", editable: true },
			{ name: "evmo_id", datatype: "string", editable: false },
			{ name: "cerrado", datatype: "boolean", editable: true },
			{ name: "publicar_draw", datatype: "boolean", editable: true },
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
		
		cont = 1;
		$("#htmlgridInsc tbody tr").each(function (index) {
			if(cont % 2 == 0){
				$(this).css("background-color", "#e6e6e6");
			}else{
				$(this).css("background-color", "#ffffff");
			}
			cont++;
		});
	
	}
	
	
	function agregar_tabla() {
	
		agregar_fila($("#modalidad").val(),$("#evmo_fecha").val(),
						$("#campeon").val(),$("#subcampeon").val(),$("#costo_inscripcion").val(),'',
						document.getElementById('evmo_cerrado').checked,document.getElementById('evmo_publicar_draw').checked);
		
		pintar_filas();
		
		return false;
	}
	
	function agregar_fila(moda, fecha, campeon, subcampeon, inscripcion, id, cerrado, publicar){
	
		var values = [];
		values={
			"modalidad":moda,
			"evmo_fecha":fecha,
			"campeon":campeon,
			"subcampeon":subcampeon,
			"inscripcion":inscripcion,
			"evmo_id":id,
			"cerrado":cerrado,
			"publicar_draw":publicar,
			"action":"www.google.com"};

		var newRowId = 0;
		var filaSel = editableGrid.getRowCount()-1;
		if(filaSel < 0) filaSel = 0;
		/*
		for (var r = 0; r < editableGrid.getRowCount(); r++){
			newRowId = Math.max(newRowId, parseInt(editableGrid.getRowId(r)) + 1);
		}
		*/
		
		newRowId = 'M'+editableGrid.getRowCount();
		
		editableGrid.insertAfter(filaSel, 'M'+editableGrid.getRowCount(), values);
	
		$('table#htmlgrid tr#'+newRowId+' td:eq(5)').attr('class','oculto');
		
	
	}
	
	
	function agregar_tablaPatr() {
			
		agregar_filaPatr($("#patrocinantes").val());

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
	
	
		$('#htmlgridInsc tbody').html('');
	
	}
	
	function limpiar_info() {
	
		$('#formulario').each (function(){
		  this.reset();
		});
		limpiar_tablas();
		document.getElementById('mensajes').innerHTML = "";
		document.getElementById('visor_imagen').src = '../art/eventos/no_disponible.jpg';
		
		document.getElementById('draws').innerHTML = "";
		
		$('#modaInscripcion').html('<option></option>');
		$('#modaGrupos').html('<option></option>');
		limpiarGrupos();

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
			
			//console.log(json);
			
			var obj = jQuery.parseJSON(json);
			
			document.getElementById('nombre').value = obj[0].even_nombre;
			
			/*
			var fecha = new Date(obj[0].even_fecha);
			var api = $("#even_fecha").data("dateinput");
			api.setValue(fecha);
			*/
			
			$('#even_fecha').datepicker('setDate', new Date(obj[0].even_fecha));
			
			document.getElementById('sede').value = obj[0].even_sede;
			document.getElementById('ciudad').value = obj[0].even_ciudad;
			document.getElementById('publicarhome').checked = obj[0].even_publicarhome=='S';
			
			document.getElementById('visor_imagen').src = '../art/eventos/' + obj[0].even_afiche;
			document.getElementById('afiche').value = obj[0].even_afiche;
			document.getElementById('publicar').checked = obj[0].even_publicar=='S';
			document.getElementById('cerrado').checked = obj[0].even_cerrado=='S';
			
			
			var modalidades = obj[0].even_modalidades;
			var patrocinantes = obj[0].even_patrocinantes;
			var draws = obj[0].even_draws;
			
			limpiar_tablas();
			
			$('#modaInscripcion').html('<option></option>');
			
			for(var i=0;i<modalidades.length;i++){
				/*api = $("#evmo_fecha").data("dateinput");
				api.setValue(new Date(modalidades[i].evmo_fecha));*/
				
				$('#evmo_fecha').datepicker('setDate', new Date(modalidades[i].evmo_fecha));
				
				agregar_fila(modalidades[i].moda_id,$("#evmo_fecha").val(),
								modalidades[i].evmo_premiacion,modalidades[i].evmo_subcampeon,modalidades[i].evmo_costo_inscripcion,modalidades[i].evmo_id,
								(modalidades[i].evmo_cerrado=='S'),(modalidades[i].evmo_publicar_draw=='S'));
								
								
				$('#modaInscripcion').append('<option value="'+modalidades[i].evmo_id+'">'+modalidades[i].moda_nombre+'</option>');
				$('#modaGrupos').append('<option value="'+modalidades[i].evmo_id+'">'+modalidades[i].moda_nombre+'</option>');				
			}
			
			for(var i=0;i<patrocinantes.length;i++){
				agregar_filaPatr(patrocinantes[i].patr_id);
			}
			
			
			
			document.getElementById('draws').innerHTML = "";
			var etiqueta;
			
			etiqueta = '<table>';
			
				etiqueta += '<tr>';
					etiqueta += '<td>';
						etiqueta += '<a class="textogris11b" title="Crear nuevo draw" href="edicion_draw.php?even_id='+even_id+'" target="_blank"><img src="../art/boton_nuevo.png"></a>';
					etiqueta += '</td>';
				etiqueta += '</tr>';
			
				etiqueta += '<tr><td colspan="4"><hr></td></tr>';
			
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
						/*
						etiqueta += '<td>';
							etiqueta += '<a href="#" title="Asignar puntos a los ranking" class="fancybox.ajax" onClick="return asignar_puntos_ranking('+draws[i]['evmo_id']+')"><img src="../art/boton_asignar.png"></a>';
						etiqueta += '</td>';
						*/
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
	
		return false;*/
		
		return true;
	
	}
	
	var elementoSel = null;

	function cargar_inscripciones(){
	
		var evmo_id = $('#modaInscripcion').val();
		
		$('#htmlgridInsc tbody').html('');
		
		if(evmo_id  != ''){
			
			var json = geturl('control/ctrl_inscripcion.php', 'opcion=consultaAll&evmo_id=' + evmo_id, 'GET');

			var inscripciones = jQuery.parseJSON(json);
			
			for(var i=0;i<inscripciones.length;i++){
				
				var fila = '<tr id="fila_'+i+'">';
				fila += '<td>'+inscripciones[i].inev_fecha_insc+'</td>';
				
				fila += '<td>'+'<a class="fancybox.ajax textogris11b" href="mod_seleccionar_jugador.php">'+inscripciones[i].juga_id1+ ' - ' +inscripciones[i].juga1_nombre+ ' ' +inscripciones[i].juga1_apellido+'</a>'+'</td>';
				
				fila += '<td class="oculto">'+inscripciones[i].juga1_email+'</td>';
				
				if(inscripciones[i].juga_id2!=null){
					fila += '<td>'+'<a class="fancybox.ajax textogris11b" href="mod_seleccionar_jugador.php">'+inscripciones[i].juga_id2+ ' - ' +inscripciones[i].juga2_nombre+ ' ' +inscripciones[i].juga2_apellido+'</a>'+'</td>';
					fila += '<td class="oculto">'+inscripciones[i].juga2_email+'</td>';
				}else{
					if(inscripciones[i].moda_tipo == 'D'){
						fila += '<td><a class="fancybox.ajax textogris11b" href="mod_seleccionar_jugador.php">Jugador 2</a></td>';
					}else{
						fila += '<td></td>';
					}
					fila += '<td class="oculto"></td>';
				}
				
				fila += '<td>';
				
				if(inscripciones[i].inev_estatus == 'I'){
					//fila += 'Inscrito';
					fila += '<input type="radio" name="estatus'+i+'[]" value="A">Aprobar</input>';
					fila += '<input type="radio" name="estatus'+i+'[]" value="R">Rechazar</input>';
				}else if(inscripciones[i].inev_estatus == 'A'){
					fila += '<input type="radio" name="estatus'+i+'[]" value="A" checked>Aprobado</input>';
					fila += '<input type="radio" name="estatus'+i+'[]" value="R">Rechazado</input>';
				}else if(inscripciones[i].inev_estatus == 'R'){
					fila += '<input type="radio" name="estatus'+i+'[]" value="A">Aprobado</input>';
					fila += '<input type="radio" name="estatus'+i+'[]" value="R" checked>Rechazado</input>';
				}
				
				fila += '</td>';
				
				
				var estatusPago = '';
				var rutaPago = getHost()+'/admin/vista/mod_inscripcion_pago.php?evmo_id='+evmo_id+'&juga_id='+inscripciones[i].juga_id1;
				
				
				if(inscripciones[i].inpa_estatus1 == 'P'){
				
					estatusPago += '<a href="'+rutaPago+'" title="Pagado" class="fancybox.ajax pago"><img src="'+getHost()+'/art/money16x16.png"></a>';
				
				}else if(inscripciones[i].inpa_estatus1 == 'E'){
				
					estatusPago += '<a href="'+rutaPago+'" title="En proceso de pago" class="fancybox.ajax pago"><img src="'+getHost()+'/art/monedas16x16.png"></a>';
				
				}
				
				if(inscripciones[i].inpa_estatus2 == 'P'){
				
					estatusPago += '<a href="'+rutaPago+'" title="Pagado" class="fancybox.ajax pago"><img src="'+getHost()+'/art/money16x16.png"></a>';
				
				}else if(inscripciones[i].inpa_estatus2 == 'E'){
				
					estatusPago += '<a href="'+rutaPago+'"  title="En proceso de pago" class="fancybox.ajax pago"><img src="'+getHost()+'/art/monedas16x16.png"></a>';
				}
				
				
				fila += '<td>'+estatusPago+'</td>';
				
				
				
				fila += "<td><a onclick=\"if (confirm('\u00BFDeseas eliminar esta inscripcion del torneo? ')) { "+
						"$(this).parent().parent().slideUp('fast');" +
						" } \" style=\"cursor:pointer\">" +
						"<img src=\"../art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar inscripcion\"/></a></td>";
				
				fila += '</tr>';
				
				$('#htmlgridInsc tbody').append(fila);
				
			}
			
			pintar_filas();
			$("#htmlgridInsc tbody tr td a.textogris11b").fancybox({
													    'width' : 400,
													    'height' : 540,
														'autoScale' : false,       
													    'autoSize' :   false,         
													    'autoDimensions' : false
			});
			$("#htmlgridInsc tbody tr td a.textogris11b").click(function() {
				elementoSel = $(this);
			});
			$('.pago').fancybox();
		}
		
	}
	
	
	function actualizar_inscripcion(){


		if (confirm('\u00BFDesea actualizar las inscripciones al torneo? ')) {
	

			var datosInsc = new Array(); 
				
				$("#htmlgridInsc tbody tr").each(function(row) { // this represents the row
					var elementoTr = $(this);
					var fila = new Array();
					 $(this).children("td").each(function (col) {

						switch(col){
							case 0: fila.push($(this).html()); break; //fecha de la inscripci�n
							case 1: fila.push($(this).children().html().substr(0,$(this).children().html().indexOf("-")-1)); break; // cedula jugador 1
							case 2: fila.push($(this).html()); break; // email jugador 1
							case 3: 
								if($(this).children().html() != null){
									fila.push($(this).children().html().substr(0,$(this).children().html().indexOf("-")-1));  // cedula jugador 1
								}else{
									fila.push(null);
								}
								break;
							case 4: fila.push($(this).html()); break; // email jugador 2
							case 5: 
								if(elementoTr.is(":hidden")){
									fila.push('E');
								}else{
									if($(this).children("input:checked").val()){
										fila.push($(this).children("input:checked").val());
									}else{
										fila.push('I');
									}
								}
								break;
						}	
						
					}); 
					datosInsc.push(fila);
				}); 
			
			
			//alert(JSON.stringify(datosInsc));
			
			$("#formulario #datosInsc").attr('value',JSON.stringify(datosInsc));
			$("#formulario #moda_nombre").attr('value',$('#formulario #modaInscripcion option:selected').html());
			$("#formulario #opcion").attr('value','actualizar');

			$('#mensajes').html(geturl('control/ctrl_inscripcion.php', $("#formulario").serialize(), 'POST'));
		
			cargar_inscripciones()
		}
		

	}//fin
	
	function agregar_tablaInsc(){
		
		var fila = '<tr>';
		
		var ahora = new Date();
		
		fila += '<td>'+ahora.getDate()+'/'+(ahora.getMonth()+1)+'/'+ahora.getFullYear()+' '+ahora.getHours()+':'+ahora.getMinutes()+':'+ahora.getSeconds()+'</td>';
		fila += '<td>'+'<a class="fancybox.ajax textogris11b" href="mod_seleccionar_jugador.php">Jugador 1</a>'+'</td>';
		fila += '<td class="oculto"></td>'
		if(true){
			fila += '<td>'+'<a class="fancybox.ajax textogris11b" href="mod_seleccionar_jugador.php">Jugador 2</a>'+'</td>';
		}else{
			fila += '<td></td>';
		}
		
		fila += '<td class="oculto"></td>'
		
		var i = $('#htmlgridInsc tbody').find ('tr').length + 1;
		
		fila += '<td>';
		fila += '<input type="radio" name="estatus'+i+'[]" value="A">Aprobar</input>';
		fila += '<input type="radio" name="estatus'+i+'[]" value="R">Rechazar</input>';
		fila += '</td>';
		fila += '<td></td>';
		fila += "<td><a onclick=\"if (confirm('\u00BFDeseas eliminar esta inscripcion del torneo? ')) { "+
						"$(this).parent().parent().slideUp('fast');" +
						" } \" style=\"cursor:pointer\">" +
						"<img src=\"../art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar inscripcion\"/></a></td>";
		fila += '</tr>';
		
		$('#htmlgridInsc tbody').prepend(fila);
		
		$("#htmlgridInsc tbody tr td a.textogris11b").fancybox({
													    'width' : 400,
													    'height' : 540,
														'autoScale' : false,       
													    'autoSize' :   false,         
													    'autoDimensions' : false
			
		});
		$("#htmlgridInsc tbody tr td a.textogris11b").click(function() {
			elementoSel = $(this);
		});
		
		return false;
		
	}
	
	
	
	seleccionar_by_php();
	
	
	function limpiarGrupos(){
		$('#panelGrupos').html('<p class="mensajeGrupo">No se han registrado grupos para el torneo</p>');
		$('#nro_equipos_x_grupos').removeAttr('disabled');
	}
	
	function inicializar_drag_and_drop(){

		$(".jugador").click(function() {
			elementoSel = $(this);
		});
		
		try{
		
			$(".jugador").fancybox();
			
			$(".jugador").each(function( index ) {
				$(this).draggable({ revert: true , helper: "clone" });
			});
			
			$(".jugador").each(function( index ) {
				$(this).droppable({
					drop: function( event, ui ) {
					
						var equipoTemp = $(this).clone();
						$(this).parent().html(ui.draggable.clone());
						ui.draggable.parent().html(equipoTemp);
						
						inicializar_drag_and_drop();
					
					}
				});
			});
			
		}catch(ex){
			console.error('No se pudo inicializar el drag and drop');
		}
		
		
	}
	
	function agregarGrupo(interId, cantEquiposByGrupo, grupoId, grupoNombre, jugadores){
		
		var grupo = '<table class="grupo" grupoId="'+grupoId+'"><thead><tr><th colspan="'+(cantEquiposByGrupo+3)+'">'+grupoNombre+'</th></tr></thead>';
		grupo += '<tr><td></td><td>Nombre</td>';
		
		for(j=1;j<=cantEquiposByGrupo;j++){
			grupo += '<td>'+j+'</td>';
		}
	
		grupo += '<td>Ptos</td></tr>';

		for(j=1;j<=cantEquiposByGrupo;j++){
			
			if(jugadores != null && jugadores[j-1] != null){
			
				grupo += '<tr><td>'+j+'</td><td> <a href="mod_grupo_jugador.php?evmo_id='+interId+'" class="fancybox.ajax jugador" jugaId="'+jugadores[j-1].juga_id+'"> '+jugadores[j-1].juga_nombre+'</a></td>';
			
			}else{
			
				grupo += '<tr><td>'+j+'</td><td> <a href="mod_grupo_jugador.php?evmo_id='+interId+'" class="fancybox.ajax jugador"> Jugador '+j+'</a></td>';
			
			}
			
			for(k=1;k<=cantEquiposByGrupo;k++){
				grupo += '<td' + (j==k ? ' class="relleno"' : '') + '></td>';
			}
			
			grupo += '<td>0</td></tr>';
		}
		
		grupo += '</table>';
		
		$('#panelGrupos').append(grupo);
		
		
	}
	
	function generarGrupos(){
		
		var interId = $('#modaGrupos').val();
		var cantEquiposByGrupo = parseInt($('#nro_equipos_x_grupos').val());
		var cantGrupos = parseInt($('#nro_grupos').val());
		
		if(interId != ''){
			if(confirm('Esto eliminar� los grupos ya cargados. \u00BFDeseas hacerlo de todas formas? ')){
				$('#panelGrupos').html('');
				
				for(i=1;i<=cantGrupos;i++){
					
					agregarGrupo(interId, cantEquiposByGrupo, '', 'Grupo '+i, null);
					
				}
				
				inicializar_drag_and_drop();
			}
		}
	}
	
	function cambioEquiposByGrupos(){
	
		$('#msg_nro_equipos_x_grupos').html('');
		
		if($('#modaGrupos').val() != ''){
		
			var cantEquipos = parseInt($('#nro_equipos').val());
			var cantEquiposByGrupo = parseInt($('#nro_equipos_x_grupos').val());
			
			if(cantEquipos != '' && cantEquiposByGrupo != ''){
				
				if(cantEquiposByGrupo > 2 && cantEquiposByGrupo <= cantEquipos){
					cantGrupos = cantEquipos/cantEquiposByGrupo;
					
					if(cantGrupos > parseInt(cantGrupos)) cantGrupos = cantGrupos + 1;
					
					$('#nro_grupos').val(parseInt(cantGrupos));
					
				}else{
					$('#msg_nro_equipos_x_grupos').html('Debe ser minimo 3 y maximo '+cantEquipos);
					$('#nro_grupos').val(1);
				}
			
			}
			
		}else{
			$('#msg_nro_equipos_x_grupos').html('Debe seleccionar un torneo previamente cargado');
		}
	
	}
	
	function cargarCantEquipos(){
	
		inter_id = $('#modaGrupos').val();
	
		if(inter_id != ''){
			
			var param = 'opcion=consultaAll&evmo_id=' + inter_id + '&estatus=A';
			
			$.ajax({  
			 type: 'GET',  
			 url: 'control/ctrl_inscripcion.php',
			 dataType: 'json',
			 data: param,
			 success: function(arrayDeObjetos){
			 
					try{
						cantidad = arrayDeObjetos.length;
						$('#nro_equipos').val(cantidad);
						cambioEquiposByGrupos();
						moda = inter_id;
						
					}catch(ex){
						//$('#error_carga_info').html('No se pudo cargar su informaci&oacute;n, actualicela antes de realizar la inscripci&oacute;n');
					}
		      }  
			});
		
		}
		
	}
	
		function guardarGrupos(){
	
		if (confirm('\u00BFDeseas guardar los grupos del torneo? ')) {
		
			var form =  document.forms.formulario;
			
			var arrayGrupos = new Array();
			
			$('.grupo').each(function (index) {
			
				var grupo = new Array();
				grupo[0] = $(this).attr('grupoId');
				grupo[1] = $(this).find('th').html();
			
				var arrayJugadores = new Array();
			
				$(this).find('.jugador').each(function (index2) {
					var jugador = new Array();
					jugador.push($(this).attr('jugaId'))
					jugador.push($(this).attr('jugaId2'))
					jugador.push($(this).attr('grju_id'))

					arrayJugadores.push(jugador);
					
				});
				
				grupo[2] = arrayJugadores;
				arrayGrupos.push(grupo);
				
			});
			
			form.datosGrupos.value = JSON.stringify(arrayGrupos);
			form.opcion.value = 'guardar';
			
			$('#panelprincipal').hideLoading();	
			$('#panelprincipal').showLoading();	
			
			$.ajax({  
			 type: 'POST',  
			 url: 'control/ctrl_grupos_jugadores.php',
			 //dataType: 'json',
			 data: $(form).serialize(),
			 //async: false
			 success: function(data){

				$('#mensajes').html(data);
				 //cargarGrupos();
			 },
			 complete: function(){
			 
				$('#panelprincipal').hideLoading();	
			 
			 } 
			});
			
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





<div id="tabs">
	<ul>
		<li><a href="#info">Informaci&oacute;n del Evento</a></li>
		<li><a href="#moda">Modalidades y Premios</a></li>
		<li><a href="#patro">Patrocinantes</a></li>
		<li><a href="#inscripcion">Inscripciones</a></li>
		<li><a href="#grupos">Grupos</a></li>
		<li><a href="#draws">Draws</a></li>
		
	</ul>
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
					<input type="text" class="date" id="even_fecha" name="even_fecha" required="required"/>
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
			<tr>
				<td width="100" height="30" align='left'>Cerrado</td>
				<td width="100" height="30" align='left'>              
				  <input type="checkbox" name="cerrado" id="cerrado" value="true">           
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
					<input type="text" class="date" id="evmo_fecha" name="evmo_fecha"/>
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
				<td width="100" height="30" align='left'>Costo Inscripci&oacute;n</td>
				<td width="100" height="30" align='left'>              
				  <input type="text" name="costo_inscripcion" id="costo_inscripcion">           
				</td>
			</tr>
			<tr>
				<td width="100" height="30" align='left'>Cerrado</td>
				<td width="100" height="30" align='left'>              
				  <input type="checkbox" name="evmo_cerrado" id="evmo_cerrado">           
				</td>
			</tr>
			<tr>
				<td width="100" height="30" align='left'>Publicar Draw</td>
				<td width="100" height="30" align='left'>              
				  <input type="checkbox" name="evmo_publicar_draw" id="evmo_publicar_draw">           
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
						<thead>
							<tr class="textoblanco12b">
								<th class="textoblanco12b">Modalidad</th>
								<th>Fecha</th>
								<th>Campe&oacute;n</th>
								<th>Sub-Campe&oacute;n</th>
								<th>Costo Inscripci&oacute;n</th>
								<th class="oculto"></th><!-- evmo_id: Id del registro -->
								<th>Cerrado</th>
								<th>Publicar Draw</th>
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
					<table id="htmlgridPatr" name="htmlgridPatr" class="testgrid tablaForm">
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
					  <select name="modaInscripcion" class="textonegro11r" id="modaInscripcion" onChange="cargar_inscripciones()">
							<option></option>
					  </select>              
					</td>
				</tr>
				<td width="100" colspan="2" align="right">
					<input type="image" name="agregarInsc" id="agregarInsc" value="agregar" src="../art/edit_add.png" onClick="return agregar_tablaInsc()">
				</td>
				<tr>
					<td colspan="2">
						<table id="htmlgridInsc" name="htmlgridInsc" class="testgrid tablaForm">
							<thead>
								<tr class="textoblanco12b">
									<th>Fecha Insc.</th>
									<th>Jugador</th>
									<th class="oculto">Email</th>
									<th>Jugador Doble</th>
									<th class="oculto">Email</th>
									<th>Estatus</th>
									<th>Pagos</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						<input type="hidden" name="datosInsc" id="datosInsc" value="">
						<input type="hidden" name="moda_nombre" id="moda_nombre" value="">
					</td>
				</tr>
				<tr>
					<td width="100" height="10">&nbsp;</td>
				</tr>
				<tr><td colspan="2" align="right">
					<input type="checkbox" name="enviarCorreo">Enviar correo de notificaci&oacute;n
					<a href="javascript:actualizar_inscripcion()"><img src="../art/boton_enviar.png"></a>
				</td></tr>
			</table>
	</div>
	
	<div id="grupos">
		
		<link href="css/calendario-interclubes.css" rel="stylesheet" type="text/css" />
		<link href="css/grupos-interclubes.css" rel="stylesheet" type="text/css" />
	
		<label for="modaGrupos" class="textogris11b">Modalidad</label><br>
		<select name="modaGrupos" class="textonegro11r" id="modaGrupos" onChange="cargarCantEquipos();cargarGrupos();">
			<option></option>
		</select>
		<br>
	
		<label for="nro_equipos" class="textogris11b">Nro de Jugadores</label><br>
		<input type="number" id="nro_equipos" name="nro_equipos" size="20" disabled/>
		<span id="msg_nro_equipos" class="error"></span>
		<br>
		
		<label for="nro_equipos_x_grupos" class="textogris11b">Jugadores por grupos</label><br>
		<input type="number" id="nro_equipos_x_grupos" name="nro_equipos_x_grupos" size="20" onChange="cambioEquiposByGrupos();generarGrupos();"/>
		<span id="msg_nro_equipos_x_grupos" class="error"></span>
		<br>
		
		<label for="nro_grupos" class="textogris11b">Nro de Grupos</label><br>
		<input type="number" id="nro_grupos" name="nro_grupos" size="20" disabled/>
		<span id="msg_nro_grupos" class="error"></span>
		<br>
		<a href="#" onClick="guardarGrupos()"><img src="../art/boton_guardar.png"></a>
		<br>
	
		<input type="hidden" id="datosGrupos" name="datosGrupos" value="">
		<div id="panelGrupos">
		</div>

		
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

</body>
</html>