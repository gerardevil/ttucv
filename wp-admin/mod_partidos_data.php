

<script type="text/javascript">

	init();

	var jugadoresArray;

	function aceptar_data(){

		var fecha = $.datepicker.formatDate( "yy/mm/dd", $('#busca_fecha').datepicker('getDate')) + " " + $('#busca_hora option:selected').val();
		var fecha2 = $.datepicker.formatDate( "dd M", $('#busca_fecha').datepicker('getDate')) + ", " + $('#busca_hora option:selected').html();
		
		
		elementoSel.attr('fecha',fecha);
		elementoSel.attr('home',$('#busca_home option:selected').val());
		
		elementoSel.html(fecha2);
		
		var home = $('#busca_home').val();
		
		elementoSel.parent().children('.home1, .home2').each(function(){
				$(this).removeClass('visible');
			})
		
		if(home != ''){
			elementoSel.parent().children('.home'+home).addClass('visible');
		}
		
		try{ //porque solo aplica para el calendario
			var nroJornada = parseInt($('.jornada.selected').html());	
			partidosJornadas[nroJornada] = $('#juegosJornada').html();
		}catch(ex){alert(ex);}
		
		$.fancybox.close();
		
		inicializar_drag_and_drop();
	
		return false;
	}
	
	
	function init(){

		$( "#busca_fecha" ).datepicker({
	      changeMonth: true,
	      changeYear: true,
		  minDate: -1000, 
		  maxDate: 1000
	    } );
		
		
		elemEquipo1 = elementoSel.parent().prev().children().first();
		
		equipoId1 = elemEquipo1.attr('equipoId');
		equipoNombre1 = elemEquipo1.html();
		
		if(equipoId1 != null && equipoId1 != '' && equipoId1 != undefined){
			$('#busca_home').append('<option value="1">'+equipoNombre1+'</option>');
		}
		
		elemEquipo2 = elementoSel.parent().next().children().first();
		
		equipoId2 = elemEquipo2.attr('equipoId');
		equipoNombre2 = elemEquipo2.html();
		
		if(equipoId2 != null && equipoId2 != '' && equipoId2 != undefined){
			$('#busca_home').append('<option value="2">'+equipoNombre2+'</option>');
		}
		
		var strFecha = elementoSel.attr('fecha');
		
		if(strFecha != undefined && strFecha != ""){
			var arrFecha = strFecha.split(" ");
			
			$('#busca_fecha').datepicker('setDate', new Date(arrFecha[0]));
			$('#busca_hora').val(arrFecha[1]);
		}
		
		var home = elementoSel.attr('home');
		
		if(home != null && home != '' && home != undefined){
			$('#busca_home').val(home);
			//$('#busca_home option[value='+home+']').attr("selected","selected");
		}
		
	}

</script>


<form id="formSelLugarFecha" name="formSelLugarFecha" class="formEstilo">
	
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
		<span id="msg_busca_hora" class="error"></span>

		<label for="busca_home" class="textoverdeesmeralda11b">Home Club</label>
		<select id="busca_home" for="busca_home">
			<option></option>
		</select>
		<span id="msg_busca_home"></span>
		
		<br><br><div align="right"><a href="#" onClick="return aceptar_data()"><img src="../art/boton_aceptar.png"></a></div>
		
	</fieldset>

</form>
