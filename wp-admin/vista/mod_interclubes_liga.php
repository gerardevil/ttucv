<?php

$vdeporte = 1;

require_once("../modelo/patrocinantes.php");
require_once("../modelo/interclubes_liga.php");

?>
<script>
	
	$(function() {
	
		$("#tabs").tabs({ heightStyle: "content" });
		
		$("#fecha").datepicker({
	      changeMonth: true,
	      changeYear: true,
		  minDate: -1000, 
		  maxDate: 1000
	    });
		
	});
	
	
	
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
		
		
	
	function agregarTablaPatr() {
			
		agregarFilaPatr($("#patrocinantes").val());
		
		return false;
	}
	
	
	function agregarFilaPatr(patr){
		
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
	
	
	
	function limpiarTablas(){
	
		
		var newRowId = 0;
		for (var r = editableGridPatr.getRowCount()-1; r >= 0; r--) editableGridPatr.remove(r);

		/*
		editableGrid.attachToHTMLTable('htmlgrid');
		editableGrid.renderGrid();
		*/
		
	
		//$('#htmlgridInsc tbody').html('');
	
	}
	
	function limpiarInfo() {
	
		$('#formLigas').each (function(){
		  this.reset();
		});
		limpiarTablas();
		document.getElementById('mensajes').innerHTML = "";
		document.getElementById('visor_imagen').src = '../art/eventos/no_disponible.jpg';
	}
	
	function guardarInfo(){

		if(validar()){
		
			if (confirm('\u00BFDeseas guardar esta liga de interclubes? ')) {
		
			
				var datosTabla = new Array(); 
				
				for(i=0;i<editableGridPatr.getRowCount();i++){
					var fila = new Array();
					for(j=0;j<editableGridPatr.getColumnCount()-1;j++){
						fila.push(editableGridPatr.getValueAt(i,j));
					}
					datosTabla.push(fila);
				}
				
				var form =  document.forms.formLigas;
				
				form.datosPatr.value = JSON.stringify(datosTabla);
				form.opcion.value = 'guardar';
				
				if(document.getElementById('fileupload_afiche').value != ''){
					form.afiche.value = document.getElementById('fileupload_afiche').value;
				}
				
				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
			
			}
			
		}//fin validar
	
	}//fin guardar_info
	
	
	function eliminarInfo(){

		var ligaId = $('#liga').val();
		
		if(ligaId != ''){
		
			if (confirm('\u00BFDeseas eliminar esta liga de interclubes? ')) {

				var form =  document.forms.formLigas;
				
				form.opcion.value = 'eliminar';

				$('#mensajes').html(geturl(form.action, $(form).serialize(), 'POST'));
				
			}
			
		}else{
			$('#mensajes').html('<br>Por favor especifique una liga de interclubes<br>');
		}
	
	}
	
	
	function cargarLiga(){
		
		var ligaId = $('#liga').val();
		
		var form =  document.forms.formLigas;
		
		if(ligaId != ''){
			
			var param = 'opcion=consulta&liga=' + ligaId;
			
			var json = geturl(form.action, param, 'GET');
			
			//alert(json);
			
			var obj = jQuery.parseJSON(json);
			
			document.getElementById('nombre').value = obj[0].liga_nombre;
			
			document.getElementById('publicar').checked = obj[0].liga_publicar=='S';
			document.getElementById('cerrado').checked = obj[0].liga_cerrado=='S';
			
			$('#fecha').datepicker('setDate', new Date(obj[0].liga_fecha));
			document.getElementById('visor_imagen').src = '../art/interclubes/' + obj[0].liga_afiche;
			document.getElementById('afiche').value = obj[0].liga_afiche;
			
			
			var patros = obj[0].liga_patrocinantes;
			
			limpiarTablas();
						
			for(var i=0;i<patros.length;i++){

				agregarFilaPatr(patros[i].patr_id);
	
			}
			
			
		}else{
			limpiarInfo();
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
</script>


<div id="mensajes" name="mensajes" class="textoverdeesmeralda11b"></div>

<form name="formLigas" id="formLigas" class="formEstilo2"  enctype="multipart/form-data" action="control/ctrl_interclubes_liga.php">

<label for="liga" class="textogris11b">Liga Interclubes</label>
<select name="liga" class="textogris11r" id="liga" onChange="cargarLiga()">
	<option value="" ><Ingresar Nuevo></option>
	<?php 
		$obj = new interclubes_liga('','','','','','');
		$interclubes = $obj->get_all_interclubes_ligas();

		while ($row_interclubes = mysql_fetch_assoc($interclubes)){ 
	?>
	<option value="<?php echo $row_interclubes['liga_id']; ?>" <?php if ($vevento==$row_interclubes['liga_id']) { ?> selected <?php } ?>><?php echo $row_interclubes['liga_nombre']; ?></option>
	<?php  } ?>
</select>     
<br><br>

<div id="tabs">
	<ul>
		<li><a href="#info">Liga Interclubes</a></li>
		<li><a href="#patro">Patrocinantes</a></li>
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
		
		<label for="publicar" class="textogris11b">Publicar</label><br>
		<input type="checkbox" name="publicar" id="publicar" value="true" checked>
		<span id="msg_publicar" class="error"></span>
		<br>
		
		<label for="cerrado" class="textogris11b">Cerrado</label><br>
		<input type="checkbox" name="cerrado" id="cerrado" value="true">  
		<span id="msg_cerrado" class="error"></span>
		<br>

	
	</div>
	<div id="patro">
	
		<label for="patrocinantes" class="textogris11b">Patrocinante</label>
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
		<br>
		
		<input type="image" name="agregarPatro" id="agregarPatro" class="botonAgregar" value="agregar" src="../art/edit_add.png" onClick="return agregarTablaPatr()">
		
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
		
	</div>
</div>

<input type="hidden" name="opcion" id="opcion" value="">

<br><br>
<table width="640" border="0" cellpadding="0" cellspacing="0" class="textogris11b">
	<tr>
		<td width="50" height="50" align="left">
			<button name="nuevo" type="reset" value="nuevo" width="50" height="50" onClick="limpiarInfo()">
				<img src="../art/filenew.png"> Nuevo
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="guardar" type="button" value="guardar" width="50" height="50" onClick="guardarInfo()">
				<img src="../art/filesave.png"> Guardar
			</button>
		</td>
		<td width="50" height="50" align="left">
			<button name="eliminar" type="button" value="eliminar" width="50" height="50" onClick="eliminarInfo()">
				<img src="../art/editdelete.png"> Eliminar
			</button>
		</td>
		<td width="600">
		</td>
	</tr>
</table>


</form>