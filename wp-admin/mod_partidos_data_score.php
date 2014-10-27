

<script type="text/javascript">

	init();

	var jugadoresArray;

	function aceptar_data(){

		var ganador = $('#busca_ganador option:selected').val();
		elementoSel.attr('ganador',ganador);
		elementoSel.attr('score',$('#busca_score').val());
		
		marcarGanador(ganador,elementoSel.parent().parent().attr('id'));
		
		if($('#busca_score').val()=="")
			elementoSel.html('<label class="textogris11b">vs</label><span class="textogris11r">(Resultados)</span>');
		else
			elementoSel.html('<label class="textogris11b">vs</label><span class="textogris11r">'+$('#busca_score').val()+'</span>');
		
		
		actualizarResultadoEquipo();
		
		$.fancybox.close();
		
		//inicializar_drag_and_drop();
	
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
		
		var jugador1 = elementoSel.parent().parent().find('div.equipo1 :nth-child(1)').html();
		var jugador2 = elementoSel.parent().parent().find('div.equipo1 :nth-child(3)').html();
		var jugador3 = elementoSel.parent().parent().find('div.equipo2 :nth-child(1)').html();
		var jugador4 = elementoSel.parent().parent().find('div.equipo2 :nth-child(3)').html();
		
		
		$('#busca_ganador').append('<option value="1">'+jugador1+' y '+jugador2+'</option>');
		$('#busca_ganador').append('<option value="2">'+jugador3+' y '+jugador4+'</option>');
		
		
		var ganador = elementoSel.attr('ganador');
		
		if(ganador != null && ganador != '' && ganador != undefined){
			$('#busca_ganador').val(ganador);
			//$('#busca_home option[value='+home+']').attr("selected","selected");
		}
		
		
		var score = elementoSel.attr('score');
		
		if(score == "WO"){
			$('#busca_wo').attr("checked","checked");
			habilitar_score();
		}
		
		$('#busca_score').val(score);

		
	}

</script>


<form id="formSelResultado" name="formSelResultado" class="formEstilo">
	
	<fieldset>

		<label for="busca_ganador" class="textoverdeesmeralda11b">Ganador</label>
		<select id="busca_ganador" name="busca_ganador">
			<option></option>
		</select>
		<span id="msg_busca_ganador"></span>
		
		<br><br>
		<input type="checkbox" id="busca_wo" name="busca_wo" size="20" onChange="habilitar_score();"/><span class="textoverdeesmeralda11b">Walkover</span>

		<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&oacute;<br>
		
		<label for="busca_score" class="textoverdeesmeralda11b">Score</label>
		<input type="text" id="busca_score" name="busca_score" />
		<span id="busca_score">&nbsp;</span>
		
		<br><br><div align="right"><a href="#" onClick="return aceptar_data()"><img src="../art/boton_aceptar.png"></a></div>
		
	</fieldset>

</form>
