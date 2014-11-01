
<meta HTTP-EQUIV=�Pragma� CONTENT=�no-cache�>
<meta HTTP-EQUIV=�Expires� CONTENT=�-1?>

<style>
div.error{
	text-align: left;
}
</style>


<script type="text/javascript">

jugadorSel = null;

init();

function cargar_jugador(){
	
		var cedula = $('#busca_cedula').val();

		if(cedula != ""){
		
			$('#formCargaJugador span').css('display','block');
			$('#formCargaJugador input, #formCargaJugador select').css('display','none');
			$('#busca_cedula').css('display','block');
		
			if(typeof jugador != "undefined"){
				if(cedula == jugador.juga_id || cedula == 111111 || cedula == 999999){
					jugadorSel = null;
				
					$('#busca_nombre').html("&nbsp;");
					$('#busca_fecha_nac').html("&nbsp;");
					$('#busca_sexo').html("&nbsp;");
					$('#busca_categoria').html("&nbsp;");
					$('#busca_email').html("&nbsp;");
					$('#busca_telefono').html("&nbsp;");
					
					$('#busca_error_carga_info').html("<p>Debes especificar otro jugador</p>");
				
					return;
				}
			}
			
			var form =  document.forms.formCargaJugador;
			
			var param = 'opcion=consulta&cedula=' + cedula;
			
			try{
			
				var json = $.ajax({  
				 type: 'GET',  
				 url: getHost()+'wp-admin/control/ctrl_jugadores.php',
				 //dataType: 'json',
				 data: param,
				 async: false  
				}).responseText;
				
				var obj = jQuery.parseJSON(json);

				$('#busca_cedula').html(obj[0].juga_id);
				$('#busca_nombre').html(obj[0].juga_nombre + ' ' + obj[0].juga_apellido);
				$('#busca_fecha_nac').html(obj[0].juga_fecha_nac == null || obj[0].juga_fecha_nac == '' ? '&nbsp;' : obj[0].juga_fecha_nac);
				$('#busca_sexo').html(obj[0].juga_sexo == null || obj[0].juga_sexo == '' ? '&nbsp;' : (obj[0].juga_sexo == 'M' ? 'Masculino' : 'Femenino'));
				$('#busca_categoria').html(obj[0].juga_categoria == null || obj[0].juga_categoria == '' ? '&nbsp;' : obj[0].juga_categoria);
				$('#busca_email').html(obj[0].juga_email == null || obj[0].juga_email == '' ? '&nbsp;' : obj[0].juga_email);
				
				var telefonos = "";
				
				if((obj[0].juga_telf_hab==null || obj[0].juga_telf_hab=='') 
					&& (obj[0].juga_telf_ofic==null || obj[0].juga_telf_ofic=='') 
					&& (obj[0].juga_telf_cel==null || obj[0].juga_telf_cel=='')){ 
					
						$('#busca_telefono').html("&nbsp;");
						
				}else{
					if(obj[0].juga_telf_hab!=null && obj[0].juga_telf_hab!='') 
						telefonos += obj[0].juga_telf_hab;
					if(obj[0].juga_telf_ofic!=null && obj[0].juga_telf_ofic!='') 
						telefonos += (obj[0].juga_telf_hab!=null && obj[0].juga_telf_hab!='' ? ", " : "") + obj[0].juga_telf_ofic;
					if(obj[0].juga_telf_cel!=null && obj[0].juga_telf_cel!='') 
						telefonos += ((obj[0].juga_telf_hab!=null && obj[0].juga_telf_hab!='') || (obj[0].juga_telf_ofic!=null && obj[0].juga_telf_ofic!='') ? ", " : "") + obj[0].juga_telf_cel;
				
					$('#busca_telefono').html(telefonos);
				} 
				
				
				
				
				jugadorSel = obj[0];
				
				$('#busca_error_carga_info').html('');
			
			}catch(ex){

				
				if (typeof (registrar) == "undefined") registrar=false;
				
				if(!registrar){
				
					jugadorSel = null;
				
					$('#busca_nombre').html("&nbsp;");
					$('#busca_fecha_nac').html("&nbsp;");
					$('#busca_sexo').html("&nbsp;");
					$('#busca_email').html("&nbsp;");
					$('#busca_telefono').html("&nbsp;");
					
					$('#busca_error_carga_info').html("<p>No se pudo cargar la informaci&oacute;n del jugador, "+
						"comuniquese con el jugador para que actualice sus datos en la p&aacute;gina web.</p>");
						
					$('#busca_error_carga_info').append("Tambi&eacute;n puede enviarle una invitaci&oacute;n a su correo electr&oacute;nico:");
						

					$('#busca_error_carga_info').append('<form id="formInvitacion" name="formInvitacion" class="formEstilo1">');
					$('#busca_error_carga_info').append('<fieldset>');
					
					$('#busca_error_carga_info').append('<label for="email" class="textoverdeesmeralda11b">Correo electr&oacute;nico</label>'+
														'<input type="text" id="invitacion_email" name="invitacion_email" size="20" onBlur="validarCorreo(this)" class="txtBox" />');
					
					$('#busca_error_carga_info').append('<br><br><div align="right"><a href="#" onClick="return invitar_jugador()"><img src="'+getHost()+'art/boton_invitar.png"></a></div>');
					
					$('#busca_error_carga_info').append('</fieldset>');
					$('#busca_error_carga_info').append('</form>');

					$('#busca_error_carga_info').append('<div id="invitar_error_info"></div>');
					
														
					$('#busca_error_carga_info').append('<br><br><hr><br>');
				
				}else{

					$('#busca_error_carga_info').html("<p>No se pudo cargar la informaci&oacute;n del jugador, "+
						"comuniquese con el jugador para que actualice sus datos en la p&aacute;gina web.</p>");	
				
					$('#busca_error_carga_info').append("Tambi&eacute;n puede cargar sus datos b&aacute;sicos aqu&iacute;:");
					$('#busca_error_carga_info').append('<br><br><hr><br>');
				
					
					$('#formCargaJugador span').css('display','none');
					$('#formCargaJugador input, #formCargaJugador select').css('display','block');
					//$('#busca_cedula').css('display','none');
					$('#formCargaJugador #cedula').val(cedula);
					
					$("#fecha_nac").datepicker({
					  changeMonth: true,
					  changeYear: true,
					  minDate: -1000, 
					  maxDate: 1000
					});
					
				}
			}

		}
	}
	
	
	function aceptar_jugador(){
	
		if(jugadorSel != null){
	
			//alert(elementoSel.parent().next().html());
			elementoSel.parent().next().html($('#busca_email').html());
			
			elementoSel.html($('#busca_cedula').val() + ' - ' + $('#busca_nombre').html());
					
			$("#htmlgridInsc tbody tr td a.textogris11b").fancybox();
			$("#htmlgridInsc tbody tr td a.textogris11b").click(function() {
				elementoSel = $(this);
			});
			
		}
		
		$.fancybox.close();
	
		return false;
	}
	
	
	function invitar_jugador(){
	
		var email = $('#invitacion_email').val();
		
		if(email && email.length > 0){
			if(!validarCorreo(email)){
				
				$('#invitar_error_info').html('<p>El correo debe tener formato ejemplo@correo.com</p>');
				
				return false;
			}
		}
	
	
		var asunto = 'Invitacion a dxteventos.com';
		
		var cuerpo = 'invitacion';
		
		var juga_nombre = $('#nombre').html(); 
	
		var param = 'emails_destinos=' + email + '&asunto='+asunto+'&cuerpo='+cuerpo+'&juga_nombre='+juga_nombre;
			
			$.ajax({  
			 type: 'POST',  
			 url: getHost()+'wp-admin/control/ctrl_enviar_email.php',
			 //dataType: 'json',
			 data: param,
			 success: function(enviado){
				if(enviado==true){
					$('#invitar_error_info').html('<p class="textoverde11b">Invitaci&oacute;n enviada a '+email+'</p>');
				}else{
					if(enviado!=false){
						$('#invitar_error_info').html('<span class="error">'+enviado+'</p>');
					}else{
						$('#invitar_error_info').html('<span class="error">No se pudo enviar la invitaci&oacute;n</p>');
					}
				}
				
		      }  
			});
		
		
		//$.fancybox.close();
	
		return false;
	}
	
	
	function guardarJugador(){
	
		var seGuardo = false; 
		
		$('#busca_nombre').val($('#nombre').val());
	
		$.ajax({  
		 type: 'POST',  
		 url: getHost()+'wp-admin/control/ctrl_jugadores.php',
		 //dataType: 'json',
		 data: $('#formCargaJugador').serialize(),
		 success: function(resultado){
			console.log(resultado);
			seGuardo = true;
		  },
		  error: function(resultado){
			console.error(resultado);
			seGuardo = true;
		  }
		});
		
		return seGuardo;
	}
	
	
	function init(){
	
		var temp = elementoSel.html().split("-");
				
		if(parseInt(temp,10)>0){
			$('#busca_cedula').val(temp[0].trim());
			cargar_jugador();
		}
	
		$('#botonAceptar').attr('src',getHost()+'art/boton_aceptar.png');
	
		$(function(){
		
			$('#aceptar').click(function(e){
				e.preventDefault();
				cargar_jugador();
				if($('#formCargaJugador #nombre').css('display')!='none'){
					if(!guardarJugador()){
						
						return false;
					}
				}
				aceptar_jugador();
			});
		
		})
	
	}
	
		$(document).ready(function() {
		
		//if(path.indexOf('admin')!=-1){
			$(".jugadores").fancybox();
		//}
		
	});


	function filtrar_jugadores(){
	
		
	}
	
	
	$(function(){
	
		$('#filtrar').click(function(e){
	
			$('#tablaJugador tbody').html('');
			
			var param = 'opcion=consultaAll&buscar=' + $('#filtro').val();
			
			//$('#tablaJugador').hideLoading();
			//$('#tablaJugador').showLoading();
				
			$.ajax({  
				 type: 'GET',  
				 url: getHost()+'wp-admin/control/ctrl_jugadores.php',
				 dataType: 'json',
				 data: param,
				 success: function(arrayDeObjetos){
				 
					
					if(arrayDeObjetos != null){
						for(var i=0;i<arrayDeObjetos.length;i++){
						
							var fila = '<tr'+((i+1) % 2 == 0 ? ' class="even"' : '')+'>';
							
							if(window.location.pathname.indexOf('admin')==-1){
							
								fila += '<td><a href="'+getHost()+'ficha_jugador.php?cedula='+arrayDeObjetos[i].juga_id+'" class="jugadores fancybox.ajax textogris11r">'
										+arrayDeObjetos[i].juga_nombre_full+'</a></td><td></td>';
							
							}else{
							
								fila += '<td><a href="#" class="textogris11r" onClick="return seleccionar_jugador('+arrayDeObjetos[i].juga_id+')">'
										+arrayDeObjetos[i].juga_nombre_full+'</a></td><td></td>';
							
							}
							
							fila += '</tr>'
					
							$("#tablaJugador tbody").append(fila);
						}
					}
					
					
				  },
				complete: function(){
					//$('#tablaJugador').hideLoading();
				}  
			});

			e.preventDefault();
			
		
		});
	
	});
	
	function seleccionar_jugador(cedula){
		
		$('#busca_cedula').val(cedula);
		cargar_jugador();
		
	}
	
</script>

<form id="formBuscarJugador" name="formBuscarJugador" class="formEstilo">
	<fieldset>
	
		<div id="busca_error_carga_info" class="error"></div>
	
		<div id="panelFiltrado">
	
			<input type="text" id="filtro" name="filtro" placeholder="Especificar el nombre" size="30"><button href="#" id="filtrar" name="filtrar">Buscar</button>
			
		</div>

		<br><br>
		
		<div class="contenedorScroll">
			<table id="tablaJugador" name="tablaJugador" class="tablaForm">
				<thead>
					<tr class="textoblanco12b">
						<th>Jugador</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		
	</fieldset>
	
</form>


<form id="formCargaJugador" name="formCargaJugador" class="formEstilo" action="javascript:aceptar_jugador()">
	<fieldset>
	
		<div id="busca_error_carga_info" class="error"></div>
	
		<label for="busca_cedula" class="textoverdeesmeralda11b">Cedula</label>
		<input type="text" id="busca_cedula" name="busca_cedula" size="20" class="txtBox" onBlur="cargar_jugador()" />
		<input type="hidden" id="cedula" name="cedula" style="display:none;">
		<span id="msg_busca_cedula" class="error"></span>
		

		<label for="busca_nombre" class="textoverdeesmeralda11b">Nombre</label>
		<span id="busca_nombre">&nbsp;</span>
		<input type="text" id="nombre" name="nombre" style="display:none;">

		<label for="busca_fecha_nac" class="textoverdeesmeralda11b">Fecha nacimiento</label>
		<span id="busca_fecha_nac">&nbsp;</span>
		<input type="text" id="fecha_nac" name="fecha_nac" style="display:none;">
					
		<label for="busca_sexo" class="textoverdeesmeralda11b">Sexo</label>
		<span id="busca_sexo">&nbsp;</span>
		<select id="sexo" name="sexo" style="display:none;">
			<option value=""></option>
			<option value="M">Masculino</option>
			<option value="F">Femenino</option>
		</select>
		
		<label for="busca_categoria" class="textoverdeesmeralda11b">Categor&iacute;a</label>
		<span id="busca_categoria">&nbsp;</span>
		<select id="categoria" name="categoria" style="display:none;">
			<option></option>
			<option value="1ra">1ra</option>
			<option value="2da">2da</option>
			<option value="3ra">3ra</option>
			<option value="4ta">4ta</option>
			<option value="5ta">5ta</option>
			<option value="6ta">6ta</option>
		</select>

		<label for="busca_email" class="textoverdeesmeralda11b">Correo electr&oacute;nico</label>
		<span id="busca_email">&nbsp;</span>
		<input type="text" id="email" name="email" style="display:none;">
		
		<label for="busca_telefono" class="textoverdeesmeralda11b">Tel&eacute;fonos</label>
		<span id="busca_telefono">&nbsp;</span>
		<input type="text" id="telf_cel" name="telf_cel" style="display:none;" class=""/>
		
		<input type="hidden" id="opcion" name="opcion" value="guardar">
		
		<br><br><div align="right"><a href="#" id="aceptar"><img id="botonAceptar"></a></div>
		
	</fieldset>
</form>