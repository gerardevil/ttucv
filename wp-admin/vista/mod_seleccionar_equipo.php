<?php
	require_once("modelo/equipos.php");
?>

<script type="text/javascript">

$(document).ready(function(){
	init();
});

function aceptar_equipo(){
	
		var etiqueta;
		
		if($('#equipos option:selected').attr('equipoId') != null && $('#equipos option:selected').attr('equipoId') != undefined){
			
			elementoSel.attr('equipoId',$('#equipos option:selected').attr('equipoId'));
			elementoSel.attr('equipoNombre',$('#equipos option:selected').html());
			elementoSel.html($('#equipos option:selected').html());
			
		}else{
		
			elementoSel.attr('equipoId','');
			elementoSel.attr('equipoNombre','');
			elementoSel.html('Equipo');
			
		}
		
		try{ //porque solo aplica para el calendario
			var nroJornada = parseInt($('.jornada.selected').html());	
			partidosJornadas[nroJornada] = $('#juegosJornada').html();
		}catch(ex){}
		
		
		$.fancybox.close();
		
		inicializar_drag_and_drop();
		
	
		return false;
	}
	
	
	function filtrar_equipos(){
	
		$('#equipos').html('');
		
		$('#equipos').append('<option ></option>');
		
		var param = 'opcion=consultaAll&inter_id=' + $('#interclubes').val() + '&estatus=A&orden=equipo_nombre&filtro=' + $('#filtro').val();
			
			$.ajax({  
			 type: 'GET',  
			 url: 'control/ctrl_equipos.php',
			 dataType: 'json',
			 data: param,
			 success: function(arrayDeObjetos){
			 
				if(arrayDeObjetos != null){
					for(var i=0;i<arrayDeObjetos.length;i++){
					
						//alert(arrayDeObjetos[i].equipo_nombre);
					
						var opcion = '<option equipoId="'+arrayDeObjetos[i].equipo_id+'"';
							opcion += ' equipoNombre="'+arrayDeObjetos[i].equipo_nombre+'('+arrayDeObjetos[i].club_nombre+')">';
							opcion += arrayDeObjetos[i].equipo_nombre+'('+arrayDeObjetos[i].club_nombre+')';
							
							opcion += '</option>'
					
							$("#equipos").append(opcion);
					}
				}
				
				init();
				
		      }  
			});

			
		return false;
	
	}
	
	function init(){

		if(elementoSel.attr('equipoId') != null && elementoSel.attr('equipoId') != undefined && elementoSel.attr('equipoId') != '')
		$('#equipos option[equipoId='+elementoSel.attr('equipoId')+']').attr("selected","selected");
		
		$('.equipo').each(function( index ) {
			equipoId = $(this).attr('equipoId');
			if(equipoId != elementoSel.attr('equipoId') && equipoId != null && equipoId != 'undefined'){
				$('#equipos option[equipoId='+equipoId+']').remove();
			}
		});
		
	}

</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


<form id="formCargaEquipo" name="formCargaEquipo" class="formEstilo">
	<fieldset>
	
		<div id="busca_error_carga_info" class="error"></div>
	
		<div id="panelFiltrado">
	
			<input type="text" id="filtro" name="filtro" placeholder="Filtrar por Nombre de Equipo" size="30"><button id="filtrar" name="filtrar" onClick="return filtrar_equipos();">Filtrar</button>
			
		</div>
	
		<label for="equipos" class="textoverdeesmeralda11b">Equipos Inscritos</label>
		<select id="equipos">
			<option></option>
			<!--<option equipoId="0">Descanso</option>-->
			<?php
				if($_GET['inter_id'] != ''){
					$obj = new equipos('','','','','','','','','');
					$equipos = $obj->get_all_equipos($_GET['inter_id'],'A','equipo_nombre','',$_GET['intergrup_id']);
					
					while ($row = mysql_fetch_assoc($equipos)){
	
						setlocale(LC_ALL, 'pt_BR');
						echo "<option equipoId=\"".$row['equipo_id']."\" equipoNombre=\"".$row['equipo_nombre']."\">"
								.$row['equipo_nombre'].' ('.$row['club_nombre'].')';
						echo "</option>";
					
					}
					
				}
			?>
		</select>
		
		<br><br><div align="right"><a href="#" onClick="return aceptar_equipo()"><img src="../art/boton_aceptar.png"></a></div>
		
	</fieldset>
	
</form>