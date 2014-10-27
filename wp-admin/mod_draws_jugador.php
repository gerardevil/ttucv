
<?php
	require_once("modelo/inscripciones_eventos.php");
?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


<script type="text/javascript">

	init();

	var jugadoresArray;

	function aceptar_jugador(){
	
		var etiqueta;
	
		if($('#jugadores option:selected').attr('cedula1') != null){
			
			etiqueta = "\n<div class=\"jugador\">\n";
				etiqueta += "<a class=\"fancybox.ajax data\" cedula=\""+$('#jugadores option:selected').attr('cedula1')
					+"\" href=\"mod_draws_jugador.php?evmo_id="+evmo_id+"\">"+$('#jugadores option:selected').attr('nombre1')+"</a>\n";
			etiqueta += "\n</div>\n";
			
			var cedula2 = $('#jugadores option:selected').attr('cedula2');
			
			if(cedula2 != null && cedula2 != ''){
				etiqueta += "\n<div class=\"jugador\">\n";
					etiqueta += "<a class=\"fancybox.ajax data\" cedula=\""+$('#jugadores option:selected').attr('cedula2')
						+"\" href=\"mod_draws_jugador.php?evmo_id="+evmo_id+"\">"+$('#jugadores option:selected').attr('nombre2')+"</a>\n";
				etiqueta += "\n</div>\n";
			}
			
		}else{
			
			if(elementoSel.parent().parent().parent().parent().parent().attr('class') == 'col_1'){
			
				etiqueta = "\n<div class=\"jugador\">\n";
					etiqueta += "<a class=\"fancybox.ajax data\" href=\"mod_draws_jugador.php?evmo_id="+evmo_id+"\">Jugador </a>\n";
				etiqueta += "\n</div>\n";
				
				etiqueta += "\n<div class=\"jugador\">\n";
				etiqueta += "\n</div>\n";
				
			}else{
			
				etiqueta = "\n<div class=\"jugador\">\n";
					etiqueta += "<a class=\"fancybox.ajax data\" href=\"mod_draws_jugador.php?evmo_id="+evmo_id+"\"> </a>\n";
				etiqueta += "\n</div>\n";
				
				etiqueta += "\n<div class=\"jugador\">\n";
				etiqueta += "\n</div>\n";
			
			}
			
		}
		
		
		var temp = elementoSel.parent().parent().clone();
		temp.html(etiqueta);
		
		actualizar_referencias_jugador(temp,elementoSel.parent().parent().parent());
		
		elementoSel.parent().parent().html(etiqueta);
		
		$.fancybox.close();
		
		inicializar_drag_and_drop();
	
		return false;
	}
	
	function init(){
	
		var drawIdSel = parseInt(elementoSel.parent().parent().parent().parent().find('div.drawItem:eq(1) p.numero').html());
		var i = parseInt(elementoSel.parent().parent().parent().parent().parent().attr('class').substr(4));
		
		var cedula = elementoSel.parent().parent().find('div.jugador:eq(0) :nth-child(1)').attr('cedula');
		
		if(i==$('#drawDetalleSeccion table thead tr').children().size()){
			drawIdSel = 1;
		}
		
		var drawItemIdSel = elementoSel.parent().parent().parent().hasClass('even') ? 2 : 1;//los even son el segundo drawItem
		
		var drawAnt = elementoSel.parent().parent().parent().parent().parent().prev().find('div.draw:eq('+((2*drawIdSel+(drawItemIdSel-2))-1)+')');
		
		if(drawAnt.html() != null){
		
			$('#panelFiltrado').hide();
		
			var cedula1 = drawAnt.find('div.drawItem:eq(0) div.jugadoresContenedor div.jugador:eq(0) :nth-child(1)').attr('cedula');
			var cedula2 = drawAnt.find('div.drawItem:eq(1) div.jugadoresContenedor div.jugador:eq(0) :nth-child(1)').attr('cedula');
			
			$('#jugadores option').each(function (index) {
				if($(this).attr('cedula1') != cedula1 && $(this).attr('cedula1') != cedula2 && $(this).attr('cedula1') != null/*&& $(this).attr('cedula1') != 111111*/){
					$(this).remove();
				}
			});
			
		}else{
		
			
			$('div#drawDetalleSeccion table tbody tr:first td.col_1').find('div.draw').each(function (index) {
				$(this).find('div.drawItem').each(function (index2) {
					celAux = $(this).find('div.jugadoresContenedor div.jugador:eq(0) :nth-child(1)').attr('cedula');
					if(celAux != 111111 && cedula != celAux && celAux != null){
						$('#jugadores option[cedula1='+celAux+']').remove();
					}
				});
			});
		
		}

	
		$('#jugadores option[cedula1='+cedula+']').attr("selected","selected");
	
	}
	
	
	function quitar_jugadores_seleccionados(){
		
		//$('div#drawDetalleSeccion table tbody tr:first td:first');
		
		alert(elementoSel.parent().parent().parent().parent().attr('class'));
	
	}
	
	
	
	
	function filtrar_jugadores(){
	
		$('#jugadores').html('');
		
		$('#jugadores').append('<option ></option>');
		$('#jugadores').append('<option cedula1="111111" nombre1="BYE">BYE</option>');
		
		var param = 'opcion=consultaAll&evmo_id=' + evmo_id + '&estatus=A&orden=nombre&filtro=' + $('#filtro').val();
			
			$.ajax({  
			 type: 'GET',  
			 url: 'control/ctrl_inscripcion.php',
			 dataType: 'json',
			 data: param,
			 success: function(arrayDeObjetos){
				if(arrayDeObjetos != null){
					for(var i=0;i<arrayDeObjetos.length;i++){
					
						var opcion = '<option cedula1="'+arrayDeObjetos[i].juga_id1+'"';
							opcion += ' cedula2="'+arrayDeObjetos[i].juga_id2+'"';
							opcion += ' nombre1="'+arrayDeObjetos[i].juga1_nombre_full+'"';
							opcion += ' nombre2="'+arrayDeObjetos[i].juga2_nombre_full+'">';
							opcion += arrayDeObjetos[i].juga1_nombre_full;
							
							if(arrayDeObjetos[i].juga_id2 != null){
								opcion += ' y ' + arrayDeObjetos[i].juga2_nombre_full;
							}
							
							opcion += '</option>'
					
							$("#jugadores").append(opcion);
					}
				}
				
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
			<option cedula1="111111" nombre1="BYE">BYE</option>
			<?php
				if($_GET['evmo_id'] != ''){
					$obj = new inscripciones_eventos('','','','','');
					$inscritos = $obj->get_all_moda_inscripciones($_GET['evmo_id'],'A','nombre','');
					
					
					
					while ($row = mysql_fetch_assoc($inscritos)){
	
			setlocale(LC_ALL, 'pt_BR');
						echo "<option cedula1=\"".$row['juga_id1']
								."\" cedula2=\"".$row['juga_id2']
								."\" nombre1=\"".ucwords(strtolower($row['juga1_apellido'].", ".$row['juga1_nombre']))
								."\" nombre2=\"".ucwords(strtolower($row['juga2_apellido'].", ".$row['juga2_nombre']))."\">"
								.ucwords(strtolower($row['juga1_apellido'].', '.$row['juga1_nombre']));
								
						if($row['juga_id2'] != null){
							echo ' y '.ucwords(strtolower($row['juga2_apellido'].', '.$row['juga2_nombre']));
						}
								
						echo "</option>";
					
					}
					
				}
			?>
		</select>
		
		<br><br><div align="right"><a href="#" onClick="return aceptar_jugador()"><img src="../art/boton_aceptar.png"></a></div>
		
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