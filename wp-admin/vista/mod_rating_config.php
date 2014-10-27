<?php

require_once("../modelo/rating_config.php");

?>

<script>

		editableGridPesos = new EditableGrid("DemoGridAttach"); 


		// we build and load the metadata in Javascript
		editableGridPesos.load({ metadata: [
			{ name: "nombre", datatype: "string", editable: true, values: 
				{ "C" : "Torneo del Circuito",
				  "I" : "Interclubes"
				}
			},
			{ name: "peso", datatype: "string", editable: true },
			{ name: "raconf_id", datatype: "string", editable: false },
			{ name: "action", label:"", datatype: "html", editable: false }
		]});

		
		// render for the action column
		editableGridPesos.setCellRenderer("action", new CellRenderer({render: function(cell, value) {
			// this action will remove the row, so first find the ID of the row containing this cell 
			var rowId = editableGridPesos.getRowId(cell.rowIndex);
			
			cell.innerHTML = "<a onclick=\"if (confirm('\u00BFDeseas eliminar este peso? ')) { editableGridPesos.remove(" + cell.rowIndex + ");  } \" style=\"cursor:pointer\">" +
							 "<img src=\"../art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar peso\"/></a>";
			
		}}));
	
		// then we attach to the HTML table and render it
		editableGridPesos.attachToHTMLTable('htmlgridPesos');
		editableGridPesos.renderGrid();

		
		
		
		editableGridCategoria = new EditableGrid("DemoGridAttach2"); 


		// we build and load the metadata in Javascript
		editableGridCategoria.load({ metadata: [
			{ name: "categoria", datatype: "string", editable: true, values: 
				{ "1ra" : "1ra",
				  "2da" : "2da",
				  "3ra" : "3ra",
				  "4ta" : "4ta",
				  "5ta" : "5ta",
				  "6ta" : "6ta"
				}
			},
			{ name: "puntos_min", datatype: "string", editable: true },
			{ name: "puntos_max", datatype: "string", editable: true },
			{ name: "raconf_id", datatype: "string", editable: false },
			{ name: "action", label:"", datatype: "html", editable: false }
		]});

		
		// render for the action column
		editableGridCategoria.setCellRenderer("action", new CellRenderer({render: function(cell, value) {
			// this action will remove the row, so first find the ID of the row containing this cell 
			var rowId = editableGridCategoria.getRowId(cell.rowIndex);
			
			cell.innerHTML = "<a onclick=\"if (confirm('\u00BFDeseas eliminar esta categoria? ')) { editableGridCategoria.remove(" + cell.rowIndex + "); pintar_filas(); } \" style=\"cursor:pointer\">" +
							 "<img src=\"../art/delete.png\" border=\"0\" alt=\"delete\" title=\"Eliminar categoria\"/></a>";
			
		}}));
	
		// then we attach to the HTML table and render it
		editableGridCategoria.attachToHTMLTable('htmlgridCategoria');
		editableGridCategoria.renderGrid();

		
	function agregarPeso() {

		agregarFilaPeso($("#nombre_peso").val(),$("#peso").val(),'');
		
		return false;
	}
	
	
	function agregarFilaPeso(nombre, peso, id){
	
		var values = [];
		values={
			"nombre":nombre,
			"peso":peso,
			"raconf_id":id,
			"action":"www.google.com"};

		var newRowId = 0;
		var filaSel = editableGridPesos.getRowCount()-1;
		if(filaSel < 0) filaSel = 0;
		/*
		for (var r = 0; r < editableGrid.getRowCount(); r++){
			newRowId = Math.max(newRowId, parseInt(editableGrid.getRowId(r)) + 1);
		}
		*/
		
		newRowId = 'P'+editableGridPesos.getRowCount();
		editableGridPesos.insertAfter(filaSel, 'P'+editableGridPesos.getRowCount(), values);
	
		$('table#htmlgridPesos tr#'+newRowId+' td:eq(2)').attr('class','oculto');
		
	
	}
	
		
	function agregarCategoria() {

		agregarFilaCategoria($("#categoria").val(),$("#puntos_min").val(),
						$("#puntos_max").val(),'');
		
		return false;
	}
	
	
	function agregarFilaCategoria(categoria, puntos_min, puntos_max, id){
	
		var values = [];
		values={
			"categoria":categoria,
			"puntos_min":puntos_min,
			"puntos_max":puntos_max,
			"raconf_id":id,
			"action":"www.google.com"};

		var newRowId = 0;
		var filaSel = editableGridCategoria.getRowCount()-1;
		if(filaSel < 0) filaSel = 0;
		/*
		for (var r = 0; r < editableGrid.getRowCount(); r++){
			newRowId = Math.max(newRowId, parseInt(editableGrid.getRowId(r)) + 1);
		}
		*/
		
		newRowId = 'C'+editableGridCategoria.getRowCount();
		
		editableGridCategoria.insertAfter(filaSel, 'C'+editableGridCategoria.getRowCount(), values);
	
		$('table#htmlgridCategoria tr#'+newRowId+' td:eq(3)').attr('class','oculto');
		
	
	}
	
	function limpiarTablas(){
		
		var newRowId = 0;
		for (var r = editableGridPesos.getRowCount()-1; r >= 0; r--) editableGridPesos.remove(r);

		newRowId = 0;
		for (var r = editableGridCategoria.getRowCount()-1; r >= 0; r--) editableGridCategoria.remove(r);
		
		/*
		editableGrid.attachToHTMLTable('htmlgrid');
		editableGrid.renderGrid();
		*/
		
	
		//$('#htmlgridInsc tbody').html('');
		
		$('#tablaHistorico tbody').html('');
	
	}
	
	function limpiarConfig() {
	
		$('#formRatingConfig').each (function(){
		  this.reset();
		});
		limpiarTablas();
		document.getElementById('mensajes').innerHTML = "";
	}


	function guardarConfig(){

		if(validar()){
		
			if (confirm('\u00BFDeseas guardar esta configuracion de rating? ')) {
		
				var datosPesos = new Array(); 
				
				for(i=0;i<editableGridPesos.getRowCount();i++){
					var fila = new Array();
					for(j=0;j<editableGridPesos.getColumnCount()-1;j++){
						fila.push(editableGridPesos.getValueAt(i,j));
					}
					datosPesos.push(fila);
				}
				
				var datosCategorias = new Array(); 
				
				for(i=0;i<editableGridCategoria.getRowCount();i++){
					var fila = new Array();
					for(j=0;j<editableGridCategoria.getColumnCount()-1;j++){
						fila.push(editableGridCategoria.getValueAt(i,j));
					}
					datosCategorias.push(fila);
				}

				var form =  document.forms.formRatingConfig;
				
				form.datosPesos.value = JSON.stringify(datosPesos);
				form.datosCategorias.value = JSON.stringify(datosCategorias);
				form.opcion.value = 'guardar';

				$('#panelprincipal').hideLoading();
				$('#panelprincipal').showLoading();
				
				$.ajax({  
				 type: 'POST',
				 url: form.action,
				 data: $(form).serialize(),
				 success: function(res){
				 
					$('#mensajes').html(res);
				 
				 },
				 complete: function(){
					$('#panelprincipal').hideLoading();
				 },
				 error: function(jqXHR, textStatus){
					console.error(textStatus);
				 } 
				});
			
			}
			
		}//fin validar
	
	}//fin guardar_info
	
	
	function eliminarConfig(){

		var raconf_id = $('#rating').val();
		
		if(raconf_id != ''){
		
			if (confirm('\u00BFDeseas eliminar esta configuracion de rating? ')) {

				var form =  document.forms.formRatingConfig;
				
				form.opcion.value = 'eliminar';
				
				$('#panelprincipal').hideLoading();
				$('#panelprincipal').showLoading();
				
				$.ajax({  
				 type: 'POST',
				 url: form.action,
				 data: $(form).serialize(),
				 success: function(res){
				 
					$('#mensajes').html(res);
				 
				 },
				 complete: function(){
					$('#panelprincipal').hideLoading();
				 },
				 error: function(jqXHR, textStatus){
					console.error(textStatus);
				 } 
				});
				
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique una configuracion<br>');
		}
	
	}
	
	
	function cargarRating(){
		
		var raconf_id = $('#rating').val();
		
		var form =  document.forms.formRatingConfig;
		
		if(raconf_id != ''){
			
			var param = 'opcion=consulta&rating=' + raconf_id;
			
			$('#panelprincipal').hideLoading();
			$('#panelprincipal').showLoading();
			
			$.ajax({  
				 type: 'GET',
				 url: form.action,
				 dataType: 'json',
				 data: param,
				 success: function(obj){
	
					document.getElementById('nombre').value = obj[0].raconf_nombre;
					document.getElementById('sexo').value = obj[0].raconf_sexo;
					document.getElementById('tipo').value = obj[0].raconf_tipo;
					document.getElementById('publicar').checked = obj[0].raconf_publicar=='S';
					document.getElementById('factor_movilidad').value = obj[0].raconf_factor_movilidad;
					document.getElementById('factor_puntos').value = obj[0].raconf_factor_puntos;
					
					limpiarTablas();
					
					var pesos = obj[0].raconf_pesos;
					
					for(var i=0;i<pesos.length;i++){

						agregarFilaPeso(pesos[i].raconf_nombre, pesos[i].raconf_peso, pesos[i].rapes_id);
					
					}
					
					var categorias = obj[0].raconf_categorias;

					for(var i=0;i<categorias.length;i++){
					
						agregarFilaCategoria(categorias[i].raconf_categoria, categorias[i].raconf_puntos_min,categorias[i].raconf_puntos_max, categorias[i].racat_id);
					
					}
					
					cargarFechasCorteRating();
					
				 },
				 complete: function(){
					$('#panelprincipal').hideLoading();
				 },
				 error: function(jqXHR, textStatus){
					console.error(textStatus);
				 } 
				});
			
			
			
		}else{
			limpiarConfig();
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
	
	function calcularRating(){
	
		var raconf_id = $('#rating').val();
		
		var form =  document.forms.formRatingConfig;
		
		if(raconf_id != ''){
			
			if (confirm('\u00BFDeseas calcular el rating? ')) {
			
				var param = 'opcion=calcular&rating=' + raconf_id;
				
				$('#panelprincipal').hideLoading();
				$('#panelprincipal').showLoading();
				
				$.ajax({  
					 type: 'POST',
					 url: form.action,
					 data: param,
					 success: function(obj){

						$('#mensajes').html(obj);
						
					 },
					 complete: function(){
						$('#panelprincipal').hideLoading();
					 },
					 error: function(jqXHR, textStatus){
						console.error(textStatus);
					 } 
					});
				
			}
			
		}else{
			alert('Seleccione un rating');
		}
			
		return false;
			
	}
	
	
	
	function cargarFechasCorteRating(){
	
		var raconf_id = $('#rating').val();
		
		var form =  document.forms.formRatingConfig;
		
		if(raconf_id != ''){
			
			var param = 'opcion=consultaFecha&rating=' + raconf_id;
			
			$.ajax({  
				 type: 'GET',
				 url: form.action,
				 dataType: 'json',
				 data: param,
				 success: function(fechas){

					var html = '<tr><td><a class="fancybox.ajax fechasCorte textogris11b" href="vista/mod_lista_rating.php?rating='+raconf_id
					+'">Actual</a></td>';
					html += '<td><input type="image" name="botonCalcular" id="botonCalcular" value="calcular" src="../art/boton_calcular.png" onClick="return calcularRating()"></td>';
					html += '<td><input type="image" name="botonCorte" id="botonCorte" value="corte" src="../art/boton_cerrar.png" onClick="return corteRating()"></td><tr>'
					
				 
					for(i=0;i<fechas.length;i++){
					
						html += '<tr><td><a class="fancybox.ajax fechasCorte textogris11b" href="vista/mod_lista_rating.php?rating='+raconf_id
						+'&fecha='+fechas[i].raju_fecha_corte.replace(' ','%20')+'">' + fechas[i].raju_fecha_corte;
						html += '</a></td><td></td><td><tr>';
					
					}
					
					$('#tablaHistorico tbody').html(html);
					
					$('.fechasCorte').fancybox();
					
				 },
				 complete: function(){

				 },
				 error: function(jqXHR, textStatus){
					console.error(textStatus);
				 } 
				});
			
		}else{
			alert('Seleccione un rating');
		}
			
		return false;
			
	}
	
	function corteRating(){
	
		var raconf_id = $('#rating').val();
		
		var form =  document.forms.formRatingConfig;
		
		if(raconf_id != ''){
			
			if (confirm('\u00BFDeseas hacer un punto de corte del rating? ')) {
			
				var param = 'opcion=corteRating&rating=' + raconf_id;
				
				$('#panelprincipal').hideLoading();
				$('#panelprincipal').showLoading();
				
				$.ajax({  
					 type: 'POST',
					 url: form.action,
					 data: param,
					 success: function(obj){

						$('#mensajes').html(obj);
						cargarFechasCorteRating();
						
					 },
					 complete: function(){
						$('#panelprincipal').hideLoading();
					 },
					 error: function(jqXHR, textStatus){
						console.error(textStatus);
					 } 
					});
				
			}
			
		}else{
			alert('Seleccione un rating');
		}
			
		return false;
			
	}
	
</script>


<div id="mensajes" name="mensajes" class="textoverdeesmeralda11b"></div>

<form name="formRatingConfig" id="formRatingConfig" class="formEstilo2"  enctype="multipart/form-data" action="control/ctrl_rating.php">

<label for="rating" class="textogris11b">Ratings</label>
<select name="rating" class="textogris11r" id="rating" onChange="cargarRating()">
	<option value="" ><Ingresar Nuevo></option>
	<?php 
		$obj = new rating_config('','','','','','','','');
		$ratings = $obj->get_all_rating_configs();

		while ($row_rating = mysql_fetch_assoc($ratings)){ 
	?>
	<option value="<?php echo $row_rating['raconf_id']; ?>" <?php if ($vevento==$row_rating['raconf_id']) { ?> selected <?php } ?>><?php echo $row_rating['raconf_nombre']; ?></option>
	<?php  } ?>
</select>     
<br><br>
<div id="tabs">
	<ul>
		<li><a href="#info">Configuraci&oacute;n</a></li>
		<li><a href="#pesos">Pesos</a></li>
		<li><a href="#cat">Categor&iacute;as</a></li>
		<li><a href="#list">Hist&oacute;rico</a></li>
	</ul>
	<div id="info">
	
		<label for="nombre" class="textogris11b">Nombre</label><br>
		<input type="text" id="nombre" name="nombre" size="20" required="required"/>
		<span id="msg_nombre" class="error"></span>
		<br>
		
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
		
		<label for="factor_movilidad" class="textogris11b">Factor de movilidad</label><br>
		<input type="text" id="factor_movilidad" name="factor_movilidad" size="20" required="required"/>
		<span id="msg_factor_movilidad" class="error"></span>
		<br>	
		
		<label for="factor_puntos" class="textogris11b">Factor puntos</label><br>
		<input type="text" id="factor_puntos" name="factor_puntos" size="20" required="required"/>
		<span id="msg_factor_puntos" class="error"></span>
		<br>
		
		<label for="publicar" class="textogris11b">Publicar</label><br>
		<input type="checkbox" name="publicar" id="publicar" value="true" checked/>
		<span id="msg_publicar" class="error"></span>
		<br>

	</div>
	<div id="pesos">
	
		<label for="nombre_peso" class="textogris11b">Nombre</label><br>
		<select id="nombre_peso" name="nombre_peso" required="required">
			<option></option>
			<option value="C">Torneo del Circuito</option>
			<option value="I">Interclubes</option>
		</select>
		<span id="msg_nombre_peso" class="error"></span>
		<br>
		
		<label for="peso" class="textogris11b">Peso</label><br>
		<input type="text" id="peso" name="peso" size="20" required="required"/>
		<span id="msg_peso" class="error"></span>
		<br>
		
		<input type="image" name="agregarPeso" id="agregarPeso" class="botonAgregar" value="agregar" src="../art/edit_add.png" onClick="return agregarPeso()">
	
		<table id="htmlgridPesos" name="htmlgridPesos" class="tablaForm">
			<thead>
				<tr class="textoblanco12b">
					<th>Nombre</th>
					<th>Peso</th>
					<th class="oculto">interconf_id</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	
	</div>
	<div id="cat">
	
		<label for="categoria" class="textogris11b">Categor&iacute;a</label><br>
		<select name="categoria" class="textogris11r" id="categoria">
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
	
		<label for="puntos_min" class="textogris11b">Puntos m&iacute;nimos</label><br>
		<input type="text" id="puntos_min" name="puntos_min" size="20" required="required"/>
		<span id="msg_puntos_min" class="error"></span>
		<br>
		
		<label for="puntos_max" class="textogris11b">Puntos m&aacute;ximos</label><br>
		<input type="text" id="puntos_max" name="puntos_max" size="20" required="required"/>
		<span id="msg_puntos_max" class="error"></span>
		<br>
		
		<input type="image" name="agregarCategoria" id="agregarCategoria" class="botonAgregar" value="agregar" src="../art/edit_add.png" onClick="return agregarCategoria()">
	
		<table id="htmlgridCategoria" name="htmlgridCategoria" class="tablaForm">
			<thead>
				<tr class="textoblanco12b">
					<th>Categor&iacute;a</th>
					<th>Puntos m&iacute;nimos</th>
					<th>Puntos m&aacute;ximos</th>
					<th class="oculto">raconf_id</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	
	</div>
	
	<div id="list">
	
		<table id="tablaHistorico" name="tablaHistorico" class="tablaForm">
			<thead>
				<tr class="textoblanco12b">
					<th width="400">Fecha Corte</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	
	</div>
	
</div>

<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
	<tr>
		<td width="50" height="50" align="left">
			<button name="nuevo" type="reset" value="nuevo" width="50" height="50" onClick="limpiarConfig()">
				<img src="../art/filenew.png"> Nuevo
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="guardar" type="button" value="guardar" width="50" height="50" onClick="guardarConfig()">
				<img src="../art/filesave.png"> Guardar
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="eliminar" type="button" value="eliminar" width="50" height="50" onClick="eliminarConfig()">
				<img src="../art/editdelete.png"> Eliminar
			</button>
		</td>
		<td width="600">
		</td>
	</tr>
</table>

<input type="hidden" name="opcion" id="opcion" value="">
<input type="hidden" name="datosPesos" id="datosPesos" value="">
<input type="hidden" name="datosCategorias" id="datosCategorias" value="">

</form>

<script>
	$(function() {
		$("#tabs").tabs({ heightStyle: "content" });
	});
</script>