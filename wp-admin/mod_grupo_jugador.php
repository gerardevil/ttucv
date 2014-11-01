<?php
	require_once("modelo/inscripciones_eventos.php");
?>


<script type="text/javascript">

    init();

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
	
	
	function aceptar_jugador(){
	
		var etiqueta;
	
		if($('#jugadores option:selected').attr('cedula1') != null){
		    elementoSel.attr('jugaId',$('#jugadores option:selected').attr('cedula1'))
		    elementoSel.html($('#jugadores option:selected').attr('nombre1'));
	        
	        if($('#jugadores option:selected').attr('cedula2') != null && $('#jugadores option:selected').attr('cedula2') != ''){
	            elementoSel.attr('jugaId2',$('#jugadores option:selected').attr('cedula2'))
		        elementoSel.append(' y '+$('#jugadores option:selected').attr('nombre2'));
	        }
	        
		}
		
		$.fancybox.close();
		
	}
	
    function init(){
    
        cedula1 = elementoSel.attr('jugaid');
        cedula2 = elementoSel.attr('jugaid2');
        
        if(cedula1 != undefined){
        
           $('#jugadores option[cedula1='+cedula1+']').attr("selected","selected");
    			
        }
        
        elementoSel.parent().parent().parent().parent().find('.jugador').each(function(){
            
            var cedula1 = $(this).attr('jugaid');
			var cedula2 = $(this).attr('jugaid2');
            
            if(cedula1 != undefined && cedula1 != null && cedula1 != ''){
                $('#jugadores option').each(function (index) {
    				if($(this).attr('cedula1') == cedula1 || $(this).attr('cedula1') == cedula2/*&& $(this).attr('cedula1') != 111111*/){
    					$(this).remove();
    				}
    			});
            }
            
        });
        
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
	
	
</form>