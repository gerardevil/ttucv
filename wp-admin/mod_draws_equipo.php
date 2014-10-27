
<?php
	require_once("modelo/equipos.php");
?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


<script type="text/javascript">

	init();

	var jugadoresArray;

	function aceptar_jugador(){
	
		var etiqueta;
	
		if($('#equipos option:selected').val() != null){
			
			etiqueta = "\n<div class=\"jugador\">\n";
				etiqueta += "<a class=\"fancybox.ajax data\" equipo_id=\""+$('#equipos option:selected').val()
					+"\" href=\"mod_draws_equipo.php?inter_id="+inter_id+"\">"+$('#equipos option:selected').html()+"</a>\n";
			etiqueta += "\n</div>\n";
			
			
		}else{
			
			if(elementoSel.parent().parent().parent().parent().parent().attr('class') == 'col_1'){
			
				etiqueta = "\n<div class=\"jugador\">\n";
					etiqueta += "<a class=\"fancybox.ajax data\" href=\"mod_draws_equipo.php?inter_id="+inter_id+"\">Equipo </a>\n";
				etiqueta += "\n</div>\n";
				
			}else{
			
				etiqueta = "\n<div class=\"jugador\">\n";
					etiqueta += "<a class=\"fancybox.ajax data\" href=\"mod_draws_equipo.php?inter_id="+inter_id+"\"> </a>\n";
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
		
		var equipoId = elementoSel.parent().parent().find('div.jugador:eq(0) :nth-child(1)').attr('equipo_id');
		
		if(i==$('#drawDetalleSeccion table thead tr').children().size()){
			drawIdSel = 1;
		}
		
		var drawItemIdSel = elementoSel.parent().parent().parent().hasClass('even') ? 2 : 1;//los even son el segundo drawItem
		
		var drawAnt = elementoSel.parent().parent().parent().parent().parent().prev().find('div.draw:eq('+((2*drawIdSel+(drawItemIdSel-2))-1)+')');
		
		if(drawAnt.html() != null){
		
			$('#panelFiltrado').hide();
		
			var equipoId1 = drawAnt.find('div.drawItem:eq(0) div.jugadoresContenedor div.jugador:eq(0) :nth-child(1)').attr('equipo_id');
			var equipoId2 = drawAnt.find('div.drawItem:eq(1) div.jugadoresContenedor div.jugador:eq(0) :nth-child(1)').attr('equipo_id');
			
			$('#equipos option').each(function (index) {
				if($(this).val() != equipoId1 && $(this).val() != equipoId2 && $(this).val() != null/*&& $(this).attr('cedula1') != 111111*/){
					$(this).remove();
				}
			});
			
		}else{
		
			
			$('div#drawDetalleSeccion table tbody tr:first td.col_1').find('div.draw').each(function (index) {
				$(this).find('div.drawItem').each(function (index2) {
					equipoIdAux = $(this).find('div.jugadoresContenedor div.jugador:eq(0) :nth-child(1)').attr('equipo_id');
					if(equipoIdAux != 111111 && equipoId != equipoIdAux && equipoIdAux != null){
						$('#equipos option[value='+equipoIdAux+']').remove();
					}
				});
			});
		
		}

	
		$('#equipos option[value='+equipoId+']').attr("selected","selected");
	
	}
	
	
	function quitar_jugadores_seleccionados(){
		
		//$('div#drawDetalleSeccion table tbody tr:first td:first');
		
		alert(elementoSel.parent().parent().parent().parent().attr('class'));
	
	}
	
	
	
	
	function filtrar_jugadores(){
	
		$('#jugadores').html('');
		
		$('#jugadores').append('<option ></option>');
		$('#jugadores').append('<option value="111111">BYE</option>');
		
		var param = 'opcion=consultaAll&einter_id=' + inter_id + '&estatus=A&orden=equipo_nombre&filtro=' + $('#filtro').val();
			
			$.ajax({  
			 type: 'GET',  
			 url: 'control/ctrl_equipos.php',
			 dataType: 'json',
			 data: param,
			 success: function(arrayDeObjetos){
				if(arrayDeObjetos != null){
					for(var i=0;i<arrayDeObjetos.length;i++){
					
						var opcion = '<option value="'+arrayDeObjetos[i].equipo_id+'">';
							opcion += arrayDeObjetos[i].equipo_nombre;
							opcion += '</option>'
					
							$("#equipos").append(opcion);
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
	
			<input type="text" id="filtro" name="filtro" placeholder="Filtrar por Nombre" size="30"><button id="filtrar" name="filtrar" onClick="return filtrar_jugadores();">Filtrar</button>
			
		</div>
	
		<label for="equipos" class="textoverdeesmeralda11b">Equipos Inscritos</label>
		<select id="equipos">
			<option></option>
			<option value="111111">BYE</option>
			<?php
				if($_GET['inter_id'] != ''){
					$obj = new equipos('','','','','','','','','','');
					$inscritos = $obj->get_all_equipos($_GET['inter_id'],'A','equipo_nombre','','');
					
					
					while ($row = mysql_fetch_assoc($inscritos)){
	
			setlocale(LC_ALL, 'pt_BR');
						echo "<option value=\"".$row['equipo_id']."\">"
								.$row['equipo_nombre'];	
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