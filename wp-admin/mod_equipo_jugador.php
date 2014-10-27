
<?php
	require_once("modelo/equipos.php");
	require_once("../funciones.php");
?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


<script type="text/javascript">

	init();

	var jugadoresArray;

	function aceptar_jugador(){
	
		var etiqueta;
	
		if($('#jugadores option:selected').attr('cedula') != null){
		
			elementoSel.html($('#jugadores option:selected').html());
			elementoSel.attr('cedula',$('#jugadores option:selected').attr('cedula'));
			
		}else{
			
			elementoSel.html('Jugador');
			elementoSel.removeAttr('cedula');
			
		}
		
		$.fancybox.close();
		
		return false;
	}
	
	function init(){
	
		var cedula = elementoSel.attr('cedula');
		
		elementoSel.parent().find('.jugador').each(function(){
		
			if($(this).attr('cedula') != cedula)
				$('#jugadores option[cedula='+$(this).attr('cedula')+']').remove();
		
		});
		
		
		// if(drawAnt.html() != null){
		
			// $('#panelFiltrado').hide();
		
			// var cedula1 = drawAnt.find('div.drawItem:eq(0) div.jugadoresContenedor div.jugador:eq(0) :nth-child(1)').attr('cedula');
			// var cedula2 = drawAnt.find('div.drawItem:eq(1) div.jugadoresContenedor div.jugador:eq(0) :nth-child(1)').attr('cedula');
			
			// $('#jugadores option').each(function (index) {
				// if($(this).attr('cedula1') != cedula1 && $(this).attr('cedula1') != cedula2 && $(this).attr('cedula1') != null/*&& $(this).attr('cedula1') != 111111*/){
					// $(this).remove();
				// }
			// });
			
		// }else{
		
			
			// $('div#drawDetalleSeccion table tbody tr:first td.col_1').find('div.draw').each(function (index) {
				// $(this).find('div.drawItem').each(function (index2) {
					// celAux = $(this).find('div.jugadoresContenedor div.jugador:eq(0) :nth-child(1)').attr('cedula');
					// if(celAux != 111111 && cedula != celAux && celAux != null){
						// $('#jugadores option[cedula1='+celAux+']').remove();
					// }
				// });
			// });
		
		// }

	
		$('#jugadores option[cedula='+cedula+']').attr("selected","selected");
	
	}
	
	
	function quitar_jugadores_seleccionados(){
		
		//$('div#drawDetalleSeccion table tbody tr:first td:first');
		
		alert(elementoSel.parent().parent().parent().parent().attr('class'));
	
	}
	
	
	
	
	function filtrar_jugadores(){
	
		$('#jugadores').html('');
		
		$('#jugadores').append('<option ></option>');
		//$('#jugadores').append('<option cedula1="111111" nombre1="BYE">BYE</option>');
		
		var param = 'opcion=consultaListaJugadores&equipo_id=<?php echo $_GET['equipo_id']; ?>&estatus=A&orden=nombre&filtro=' + $('#filtro').val();
			
		$.ajax({  
		 type: 'GET',  
		 url: getHost()+'admin/control/ctrl_equipos.php',
		 dataType: 'json',
		 data: param,
		 success: function(arrayDeObjetos){

			if(arrayDeObjetos != null){
				for(var i=0;i<arrayDeObjetos.length;i++){
				
					var opcion = '<option cedula="'+arrayDeObjetos[i].juga_id+'"';
						opcion += ' nombre="'+arrayDeObjetos[i].juga_nombre_full+'">';
						opcion += arrayDeObjetos[i].juga_nombre_full;
						opcion += '</option>';
				
						$("#jugadores").append(opcion);
				}
			}
			
		  },
		error: function(res,res2){
			alert(res2);
		}
		});

			
		return false;
	}
	
</script>


<form id="formCargaJugador" name="formCargaJugador" class="formEstilo">
	<fieldset>
	
		<div id="busca_error_carga_info" class="error"></div>
	
		<div id="panelFiltrado">
	
			<input type="text" id="filtro" name="filtro" placeholder="Filtrar por Cedula o Nombre" size="30"><button id="filtrar" name="filtrar" onClick="return filtrar_jugadores();">Filtrar</button>
			
		</div>
	
		<label for="jugdores" class="textoverdeesmeralda11b">Jugadores Inscritos</label>
		<select id="jugadores">
			<option></option>
			<!--<option cedula1="111111" nombre1="BYE">BYE</option>-->
			<?php
				if($_GET['equipo_id'] != ''){
				
					$obj = new equipos('','','','','','','','','','');
					$inscritos = $obj->get_lista_jugadores($_GET['equipo_id']);
					
					
					
					while ($row = mysql_fetch_assoc($inscritos)){
	
						setlocale(LC_ALL, 'pt_BR');
						echo "<option cedula=\"".$row['juga_id']
								."\" nombre=\"".ucwords(strtolower($row['juga_apellido'].", ".$row['juga_nombre']))
								."\">"
								.ucwords(strtolower($row['juga_apellido'].', '.$row['juga_nombre']));
	
						echo "</option>";
					
					}
					
				}
			?>
		</select>
		<br><br><div align="right"><a href="#" onClick="return aceptar_jugador()"><img src="<?php echo getHost(); ?>art/boton_aceptar.png"></a></div>
		
	</fieldset>
	
	<!--
	<fieldset>
	
		<label for="busca_cedula" class="textoverdeesmeralda11b">Cedula</label>
		<input type="text" id="busca_cedula" name="busca_cedula" size="20" class="txtBox" onBlur="cargar_jugador()" />
		<span id="msg_busca_cedula" class="error"></span>

		<label for="busca_nombre" class="textoverdeesmeralda11b">Nombre</label>
		<span id="busca_nombre">&nbsp;</span>

		<label for="busca_fecha_nac" class="textoverdeesmeralda11b">Fecha nacimiento</label>
		<span id="busca_fecha_nac">&nbsp;</span>
					
		<label for="busca_sexo" class="textoverdeesmeralda11b">Sexo</label>
		<span id="busca_sexo">&nbsp;</span>

		<label for="busca_email" class="textoverdeesmeralda11b">Correo electr&oacute;nico</label>
		<span id="busca_email">&nbsp;</span>
		
		<br><br><div align="right"><a href="#" onClick="return aceptar_jugador()"><img src="../art/boton_aceptar.png"></a></div>
		
	</fieldset>
	-->
</form>