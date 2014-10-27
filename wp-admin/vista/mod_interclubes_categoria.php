<?php

require_once("../modelo/interclubes_categorias.php");
require_once("../modelo/interclubes_liga.php");
require_once("../modelo/modalidades.php");

$vdeporte = 1;

/*
echo $_GET['depo_id']."<br>";
echo $_GET['even_id']."<br>";
*/


?>


<script>
	$(function() {
		// setup ul.tabs to work as tabs for each div directly under div.panes
		//$("ul.tabs").tabs("div.panes > div");
		
		$("#tabs").tabs();
		
		$("#fecha").datepicker({
	      changeMonth: true,
	      changeYear: true,
		  minDate: -1000, 
		  maxDate: 1000
	    });
	});
	/*
	$("#fecha").dateinput({
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
	
	editableGrid = new EditableGrid("DemoGridAttach"); 


		// we build and load the metadata in Javascript
		editableGrid.load({ metadata: [
			{ name: "sexo", datatype: "string", editable: true, values: 
				{ "M" : "Masculino",
				  "F" : "Femenino",
				  "MF" : "Mixto"
				}
			},
			{ name: "tipo", datatype: "string", editable: true, values: 
				{ "D" : "Doble",
				  "I" : "Individual"
				}
			},
			{ name: "puntaje_ganador", datatype: "string", editable: true },
			{ name: "puntaje_perdedor", datatype: "string", editable: true },
			{ name: "puntaje_wo", datatype: "string", editable: true },
			{ name: "categoria", datatype: "string", editable: true, values: 
				{ "1ra" : "1ra",
				  "2da" : "2da",
				  "3ra" : "3ra",
				  "4ta" : "4ta",
				  "5ta" : "5ta",
				  "6ta" : "6ta"
				}
			},
			{ name: "interconf_id", datatype: "string", editable: false },
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
		editableGrid.attachToHTMLTable('htmlgridJuegos');
		editableGrid.renderGrid();
		
	function pintar_filas(){
	
		var cont = 1;
		$("#htmlgridJuegos tbody tr").each(function (index) {
			if(cont % 2 == 0){
				$(this).css("background-color", "#e6e6e6");
			}else{
				$(this).css("background-color", "#ffffff");
			}
			cont++;
		});
	
	}
	
	function agregar_tabla() {

		agregar_fila($("#sexo").val(),$("#tipo").val(),
						$("#puntaje_juego_ganado").val(),$("#puntaje_juego_perdido").val(),
						$("#puntaje_juego_wo").val(),$("#juego_categoria").val(),'');
		
		pintar_filas();
		
		return false;
	}
	
	function agregar_fila(sexo, tipo, puntaje_ganador, puntaje_perdedor, puntaje_wo, categoria, id){
	
		var values = [];
		values={
			"sexo":sexo,
			"tipo":tipo,
			"puntaje_ganador":puntaje_ganador,
			"puntaje_perdedor":puntaje_perdedor,
			"puntaje_wo":puntaje_wo,
			"categoria":categoria,
			"interconf_id":id,
			"action":"www.google.com"};

		var newRowId = 0;
		var filaSel = editableGrid.getRowCount()-1;
		if(filaSel < 0) filaSel = 0;
		/*
		for (var r = 0; r < editableGrid.getRowCount(); r++){
			newRowId = Math.max(newRowId, parseInt(editableGrid.getRowId(r)) + 1);
		}
		*/
		
		newRowId = 'J'+editableGrid.getRowCount();
		
		editableGrid.insertAfter(filaSel, 'J'+editableGrid.getRowCount(), values);
	
		$('table#htmlgridJuegos tr#'+newRowId+' td:eq(6)').attr('class','oculto');
		
	
	}
	
	
	
	function limpiar_tablas(){
	
		
		var newRowId = 0;
		for (var r = editableGrid.getRowCount()-1; r >= 0; r--) editableGrid.remove(r);

		/*
		editableGrid.attachToHTMLTable('htmlgrid');
		editableGrid.renderGrid();
		*/
		
	
		//$('#htmlgridInsc tbody').html('');
	
	}
	
	function limpiar_info() {
	
		$('#formInterclubes').each (function(){
		  this.reset();
		});
		limpiar_tablas();
		document.getElementById('mensajes').innerHTML = "";
		document.getElementById('visor_imagen').src = '../art/eventos/no_disponible.jpg';
		$('#juego_categoria').removeAttr('disabled');
		limpiarTablaInsc();
		limpiarGrupos();
	}
	
	function guardar_interclubes(){

		if(validar()){
		
			if (confirm('\u00BFDeseas guardar esta categoria de interclubes? ')) {
		
			
				var datosTabla = new Array(); 
				
				for(i=0;i<editableGrid.getRowCount();i++){
					var fila = new Array();
					for(j=0;j<editableGrid.getColumnCount()-1;j++){
						fila.push(editableGrid.getValueAt(i,j));
					}
					datosTabla.push(fila);
				}
				
				
				
				document.forms.formInterclubes.datosTabla.value = JSON.stringify(datosTabla);
				document.forms.formInterclubes.opcion.value = 'guardar';
				
				if(document.getElementById('fileupload_afiche').value != ''){
					document.forms.formInterclubes.afiche.value = document.getElementById('fileupload_afiche').value;
				}
				
				
				var form =  document.forms.formInterclubes;

				
				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
			
			}
			
		}//fin validar
	
	}//fin guardar_info
	
	
	function guardar_info(){
		
		if($('#info').css('display') == 'block' || $('#juegos').css('display') == 'block'){
			guardar_interclubes();
		}else if($('#inscripciones').css('display') == 'block'){
			actualizarInscripcionesEquipos();
		}else if($('#grupos').css('display') == 'block'){
			guardarGrupos();
		}
		
		
	}
	
	function eliminar_info(){

		var inter_id = $('#interclubes').val();
		
		if(inter_id != ''){
		
			if (confirm('\u00BFDeseas eliminar esta liga de interclubes? ')) {
			
				document.forms.formInterclubes.opcion.value = 'eliminar';
				
				
				var form =  document.forms.formInterclubes;

				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
				
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique una liga de interclubes<br>');
		}
	
	}
	
	
	function cargar_interclubes(){
		
		var inter_id = $('#interclubes').val();
		
		var form =  document.forms.formInterclubes;
		
		if(inter_id != ''){
			
			var param = 'opcion=consulta&interclubes=' + inter_id;
			
			var json = geturl(form.action, param, 'GET');
			
			//alert(json);
			
			var obj = jQuery.parseJSON(json);
			
			document.getElementById('nombre').value = obj[0].inter_nombre;
			
			document.getElementById('puntaje').value = obj[0].inter_puntaje_jornada;
			document.getElementById('publicar').checked = obj[0].inter_publicar=='S';
			document.getElementById('cerrado').checked = obj[0].inter_cerrado=='S';
			/*var fecha = new Date(obj[0].inter_fecha);
			var api = $("#fecha").data("dateinput");
			api.setValue(fecha);*/
			$('#fecha').datepicker('setDate', new Date(obj[0].inter_fecha));
			document.getElementById('visor_imagen').src = '../art/interclubes/' + obj[0].inter_afiche;
			document.getElementById('afiche').value = obj[0].inter_afiche;
			document.getElementById('tipo_torneo').value = obj[0].inter_tipo;
			document.getElementById('categoria').value = obj[0].inter_categoria;
			
			
			var juegos = obj[0].inter_juegos;
			
			limpiar_tablas();
						
			for(var i=0;i<juegos.length;i++){

				agregar_fila(juegos[i].interconf_sexo,juegos[i].interconf_tipo,
								juegos[i].interconf_puntaje_juego_ganado,juegos[i].interconf_puntaje_juego_perdido,
								juegos[i].interconf_puntaje_juego_wo,juegos[i].interconf_categoria,juegos[i].interconf_id);
	
			}
			
			try{
				document.getElementById('nro_equipos_x_grupos').value = obj[0].inter_cant_equipos_x_grupo;
				cargarInscripcionesEquipos();
				cargarGrupos();				
			}catch(ex){
			}
			
			pintar_filas();
			
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
		
		
		if($("#formInterclubes").validator({
			lang:'es',
			//position: 'top left', 
			offset: [0, 0],
			effect: 'wall',
			container: '#mensajes',		 
			errorInputEvent: null // do not validate inputs when they are edited 
				
			}).data("validator").checkValidity()){
			
			return true

		}
	*/
		return true;
	
	}
	
	
	function seleccionoCategoria(){
	
		if($('#categoria').val() != ""){
		
			
			if (confirm('\u00BFSe cambiaran la categoria de los juegos ya cargados? ')) {
				
				for(i=0;i<editableGrid.getRowCount();i++){
						editableGrid.setValueAt(i,3,$('#categoria').val(),true);
				}
				
			}
		
			$('#juego_categoria').val($('#categoria').val());
			$('#juego_categoria').attr('disabled','disabled');

		}else{
		
			$('#juego_categoria').val('');
			$('#juego_categoria').removeAttr('disabled');
		
		}
		
	}
	
	function cargarCategorias(){
	
			//$('#panelPrincipal').hideLoading();	
			//$('#panelPrincipal').showLoading();	
			
			$('#interclubes').html('<option value=""><Ingresar Nuevo></option>');
			
			var ligaId = $('#liga').val();
			var param = 'opcion=consultaAll&liga=' + ligaId;  
	
			$.ajax({  
			 type: 'GET',  
			 url: getHost()+'admin/control/ctrl_interclubes.php',
			 dataType: 'json',
			 data: param,
			 //async: false
			 success: function(arrayDeObjetos){

					//alert(arrayDeObjetos);
					
					for(i=0;i<arrayDeObjetos.length;i++){
						$('#interclubes').append('<option value="'+arrayDeObjetos[i].inter_id+'">'+arrayDeObjetos[i].inter_nombre+'</option>');
					}
					
			  },
			 complete: function(){
				//$('#panelPrincipal').hideLoading();
			  }
			});
	}
	
	
</script>

<div id="mensajes" name="mensajes" class="textoverdeesmeralda11b"></div>

<form name="formInterclubes" id="formInterclubes" class="formEstilo2"  enctype="multipart/form-data" action="control/ctrl_interclubes.php">

<label for="liga" class="textogris11b">Liga Interclubes</label>
<select name="liga" class="textogris11r" id="liga" onChange="cargarCategorias()">
	<option value="" ><Ingresar Nuevo></option>
	<?php 
		$obj = new interclubes_liga('','','','','','');
		$interclubes = $obj->get_all_interclubes_ligas();

		while ($row_interclubes = mysql_fetch_assoc($interclubes)){ 
	?>
	<option value="<?php echo $row_interclubes['liga_id']; ?>" <?php if ($vevento==$row_interclubes['liga_id']) { ?> selected <?php } ?>><?php echo $row_interclubes['liga_nombre']; ?></option>
	<?php  } ?>
</select>     
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


<label for="interclubes" class="textogris11b">Categor&iacute;a</label>

<select name="interclubes" class="textogris11r" id="interclubes" onChange="cargar_interclubes()">
	<option value="" ><Ingresar Nuevo></option>
	<?php 
		/*$obj = new interclubes_categorias('','','','','','');
		$interclubes = $obj->get_all_interclubes();

		while ($row_interclubes = mysql_fetch_assoc($interclubes)){ 
	?>
	<option value="<?php echo $row_interclubes['inter_id']; ?>" <?php if ($vevento==$row_interclubes['inter_id']) { ?> selected <?php } ?>><?php echo $row_interclubes['inter_nombre']; ?></option>
	<?php  }*/ ?>
</select>     
<br><br><br>





<div id="tabs">
	<ul>
		<li><a href="#info">Interclubes</a></li>
		<li><a href="#juegos">Juegos por jornadas</a></li>
		<li><a href="#inscripciones">Inscripciones Equipos</a></li>
		<li><a href="#grupos">Grupos</a></li>
	</ul>
	<div id="info">
	
			<div id="panel_foto" style="display:block;">
				<label class="textoverdeesmeralda11b">Afiche del Torneo</label><br>
				<a onClick="cargarFoto();"><img width="140" height="140" src="../art/eventos/no_disponible.jpg" id="visor_imagen"></a>
				<input type="file" id="fileupload_afiche" name="files[]" accept="image/*" onClick="inicializar_fileupload(this)" width="30"/><br>
				<input type="hidden" name="afiche" id="afiche" value="">
				<label class="textoverdeesmeralda11b">Haga click en el recuadro para cargar una nueva foto</label>
			</div>

			<label for="nombre" class="textogris11b">Nombre</label><br>
			<input type="text" id="nombre" name="nombre" size="20" required="required"/>
			<span id="msg_nombre" class="error"></span>
			<br>
			
			<label for="fecha" class="textogris11b">Fecha de inicio</label><br>
			<input type="text" class="date" name="fecha" id="fecha" required="required">
			<span id="msg_fecha" class="error"></span>
			<br>
			
			<label for="puntaje" class="textogris11b">Puntaje jornada ganada</label><br>
			<input type="text" id="puntaje" name="puntaje" size="20" required="required"/>
			<span id="msg_puntaje" class="error"></span>
			<br>	
			
			<label for="categoria" class="textogris11b">Tipo de torneo</label><br>
			<select name="tipo_torneo" class="textogris11r" id="tipo_torneo">
				<option></option>
				<option value="L">Liga</option>
				<option value="G">Ronda clasificatoria de grupos</option>
			</select>  
			<span id="msg_categoria" class="error"></span>
			<br>	
			
			<label for="categoria" class="textogris11b">Categor&iacute;a</label><br>
			<select name="categoria" class="textogris11r" id="categoria" onChange="seleccionoCategoria()">
				<option></option>
				<option value="1ra">1ra</option>
				<option value="2da">2da</option>
				<option value="3ra">3ra</option>
				<option value="4ta">4ta</option>
				<option value="5ta">5ta</option>
				<option value="6ta">6ta</option>
			</select>  
			<span id="msg_categoria" class="error"></span>
			<br>
			
			<label for="publicar" class="textogris11b">Publicar</label><br>
			<input type="checkbox" name="publicar" id="publicar" value="true" checked>
			<span id="msg_publicar" class="error"></span>
			<br>
			
			<label for="cerrado" class="textogris11b">Cerrado</label><br>
			<input type="checkbox" name="cerrado" id="cerrado" value="true">  
			<span id="msg_cerrado" class="error"></span>
			<br>	
	</div>
	<div id="juegos">
	
		<label for="sexo" class="textogris11b">Sexo</label><br>
		<select name="sexo" class="textogris11r" id="sexo">
			<option></option>
			<option value="M">Masculino</option>
			<option value="F">Femenino</option>
			<option value="MF">Mixto</option>
		</select>  
		<span id="msg_sexo" class="error"></span>
		<br>
		
		<label for="tipo" class="textogris11b">Tipo</label><br>
		<select name="tipo" class="textogris11r" id="tipo">
			<option></option>
			<option value="D">Doble</option>
			<option value="I">Individual</option>
		</select>  
		<span id="msg_tipo" class="error"></span>
		<br>
	
		<label for="puntaje_juego_ganado" class="textogris11b">Puntaje juego ganado</label><br>
		<input type="text" id="puntaje_juego_ganado" name="puntaje_juego_ganado" size="20" />
		<span id="msg_puntaje_juego_ganado" class="error"></span>
		<br>
		
		<label for="puntaje_juego_perdido" class="textogris11b">Puntaje juego perdido</label><br>
		<input type="text" id="puntaje_juego_perdido" name="puntaje_juego_perdido" size="20" />
		<span id="msg_puntaje_juego_perdido" class="error"></span>
		<br>
		
		<label for="puntaje_juego_wo" class="textogris11b">Puntaje WO</label><br>
		<input type="text" id="puntaje_juego_wo" name="puntaje_juego_wo" size="20" />
		<span id="msg_puntaje_juego_wo" class="error"></span>
		<br>
		
		<label for="juego_categoria" class="textogris11b">Categor&iacute;a</label><br>
			<select name="juego_categoria" class="textogris11r" id="juego_categoria">
				<option></option>
				<option value="1ra">1ra</option>
				<option value="2da">2da</option>
				<option value="3ra">3ra</option>
				<option value="4ta">4ta</option>
				<option value="5ta">5ta</option>
				<option value="6ta">6ta</option>
			</select>  
			<span id="msg_juego_categoria" class="error"></span>
			<br>
	
		<input type="image" name="agregarJuego" id="agregarJuego" class="botonAgregar" value="agregar" src="../art/edit_add.png" onClick="return agregar_tabla()">
	
		<table id="htmlgridJuegos" name="htmlgridJuegos" class="tablaForm">
			<thead>
				<tr class="textoblanco12b">
					<th>Sexo</th>
					<th>Individual o Doble</th>
					<th>Puntaje juego ganado</th>
					<th>Puntaje juego perdido</th>
					<th>Puntaje juego WO</th>
					<th>Categor&iacute;a</th>
					<th class="oculto">interconf_id</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		
	</div>
	<div id="inscripciones">
		<?php
			include('mod_inscripciones_interclubes.php');
		?>
	</div>
	<div id="grupos">
		<?php
			include('mod_equipos_grupos.php');
		?>
	</div>
</div>

<input type="hidden" name="datosTabla" id="datosTabla" value="">
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


</form>