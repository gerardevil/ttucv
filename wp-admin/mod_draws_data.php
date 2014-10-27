
<script type="text/javascript">

	init();

	var jugadoresArray;

	function aceptar_data(){
	
		var etiqueta;
	
		var fecha = $.datepicker.formatDate( "yy/mm/dd", $('#busca_fecha').datepicker('getDate')) + " " + $('#busca_hora option:selected').val();
		var fecha2 = $.datepicker.formatDate( "dd M", $('#busca_fecha').datepicker('getDate')) + ", " + $('#busca_hora option:selected').html();

		etiqueta = "<a class=\"fancybox.ajax data\" fecha=\"" + fecha + "\" score=\""+$('#busca_score').val()
			+"\" href=\"mod_draws_data.php\">"+($('#busca_score').val() == "" ? fecha2 : $('#busca_score').val())+"</a>\n";
			
		elementoSel.parent().html(etiqueta);
		
		$.fancybox.close();
		
		inicializar_drag_and_drop();
	
		return false;
	}
	
	function habilitar_score(){
	
		if($('#busca_wo').is(':checked')) {
			$('#busca_score').val('WO');
			$('#busca_score').attr('disabled','disabled'); 
		}else{ 
			$('#busca_score').val('');
			$('#busca_score').removeAttr('disabled');
		}
	
	}
	
	function init(){
	
		/* $("#busca_fecha").dateinput({
			lang:'es',
			format: 'dd/mm/yyyy',	// the format displayed for the user
			selectors: true,             	// whether month/year dropdowns are shown
			//min: -1000,                    // min selectable day (100 days backwards)
			//max: 1000,                    	// max selectable day (100 days onwards)
			offset: [10, 20],            	// tweak the position of the calendar
			speed: 'fast',               	// calendar reveal speed
			firstDay: 1                  	// which day starts a week. 0 = sunday, 1 = monday etc..
		}); */
		
		$( "#busca_fecha" ).datepicker({
	      changeMonth: true,
	      changeYear: true,
		  minDate: -1000, 
		  maxDate: 1000
	    } );
		
		var strFecha = elementoSel.attr('fecha');
		
		if(strFecha != undefined && strFecha != ""){
			var arrFecha = strFecha.split(" ");
	
			$('#busca_fecha').datepicker('setDate', new Date(arrFecha[0]));
			$('#busca_hora').val(arrFecha[1]);
		}
	
		
		
		var score = elementoSel.attr('score');
		
		if(score == "WO"){
			$('#busca_wo').attr("checked","checked");
		}
		
		$('#busca_score').attr("value",score);
	}

</script>


<form id="formSelFechaScore" name="formSelFechaScore" class="formEstilo">
	
	<fieldset>
	
		<label for="busca_fecha" class="textoverdeesmeralda11b">Fecha</label>
		<input type="text" id="busca_fecha" name="busca_fecha" size="20" class="txtBox" />
		<span id="msg_busca_fecha" class="error"></span>
		
		
		<label for="busca_hora" class="textoverdeesmeralda11b">Hora</label>
		<select id="busca_hora" name="busca_hora">
			<option></option>
			<?php
			
					echo "\n<option value=\"00:00:00\">12:00am</option>";
					echo "\n<option value=\"00:15:00\">12:15am</option>";
					echo "\n<option value=\"00:30:00\">12:30am</option>";
					echo "\n<option value=\"00:45:00\">12:45am</option>";
						
					for($i=1;$i<=11;$i++){
						echo "\n<option value=\"".($i<10 ? "0" : "").$i.":00:00\">".$i.":00am</option>";
						echo "\n<option value=\"".($i<10 ? "0" : "").$i.":15:00\">".$i.":15am</option>";
						echo "\n<option value=\"".($i<10 ? "0" : "").$i.":30:00\">".$i.":30am</option>";
						echo "\n<option value=\"".($i<10 ? "0" : "").$i.":45:00\">".$i.":45am</option>";
					}
					
					echo "\n<option value=\"12:00:00\">12:00pm</option>";
					echo "\n<option value=\"12:15:00\">12:15pm</option>";
					echo "\n<option value=\"12:30:00\">12:30pm</option>";
					echo "\n<option value=\"12:45:00\">12:45pm</option>";
					
					for($i=1;$i<=11;$i++){
						echo "\n<option value=\"".($i+12).":00:00\">".$i.":00pm</option>";
						echo "\n<option value=\"".($i+12).":15:00\">".$i.":15pm</option>";
						echo "\n<option value=\"".($i+12).":30:00\">".$i.":30pm</option>";
						echo "\n<option value=\"".($i+12).":45:00\">".$i.":45pm</option>";
					}
			?>
		</select>
		<!--
		<select id="busca_minuto" name="busca_minuto">
			<option></option>
			<?php
					for($i=0;$i<60;$i++){
						echo "\n<option value=\"".$i."\">".$i."min</option>";
					}
			?>
		</select>
		-->
		<span id="msg_busca_hora" class="error"></span>
		

		<br>
		<input type="checkbox" id="busca_wo" name="busca_wo" size="20" class="txtBox" onChange="habilitar_score();"/><span class="textoverdeesmeralda11b">Walkover</span>

		<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&oacute;<br>
		
		<label for="busca_score" class="textoverdeesmeralda11b">Score</label>
		<input type="text" id="busca_score" name="busca_score" />
		<span id="busca_score">&nbsp;</span>
		
		<br><br><div align="right"><a href="#" onClick="return aceptar_data()"><img src="../art/boton_aceptar.png"></a></div>
		
	</fieldset>

</form>
