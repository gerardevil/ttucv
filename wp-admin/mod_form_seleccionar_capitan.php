
<meta HTTP-EQUIV=”Pragma” CONTENT=”no-cache”>
<meta HTTP-EQUIV=”Expires” CONTENT=”-1?>

<style>
div.error{
	text-align: left;
}
</style>


<script type="text/javascript">

jugadorSel = null;
initCapitan();

function cargarCapitan(){
	
		var cedula = $('#busca_cedula').val();

		if(cedula != ""){

			if(typeof jugador != "undefined"){
				if(cedula == jugador.juga_id || cedula == 111111 || cedula == 999999){
					jugadorSel = null;
				
					$('#busca_nombre').html("&nbsp;");
					//$('#busca_fecha_nac').html("&nbsp;");
					//$('#busca_sexo').html("&nbsp;");
					//$('#busca_categoria').html("&nbsp;");
					$('#busca_email').html("&nbsp;");
					//$('#busca_telefono').html("&nbsp;");
					
					$('#busca_error_carga_info').html("<p>Debes especificar otro jugador</p>");
				
					return;
				}
			}
			
			var form =  document.forms.formCargaJugador;
			
			var param = 'opcion=consulta&cedula=' + cedula;
			
			try{
			
				var json = $.ajax({  
				 type: 'GET',  
				 url: 'control/ctrl_jugadores.php',
				 //dataType: 'json',
				 data: param,
				 async: false  
				}).responseText;
				
				//var json = geturl(form.action, param, 'GET');
				
				//alert(json);
				
				var obj = jQuery.parseJSON(json);

				$('#busca_cedula').html(obj[0].juga_id);
				$('#busca_nombre').html(obj[0].juga_apellido + ', ' + obj[0].juga_nombre );
				//$('#busca_fecha_nac').html(obj[0].juga_fecha_nac == null || obj[0].juga_fecha_nac == '' ? '&nbsp;' : obj[0].juga_fecha_nac);
				//$('#busca_sexo').html(obj[0].juga_sexo == null || obj[0].juga_sexo == '' ? '&nbsp;' : (obj[0].juga_sexo == 'M' ? 'Masculino' : 'Femenino'));
				//$('#busca_categoria').html(obj[0].juga_categoria == null || obj[0].juga_categoria == '' ? '&nbsp;' : obj[0].juga_categoria);
				$('#busca_email').html(obj[0].juga_email == null || obj[0].juga_email == '' ? '&nbsp;' : obj[0].juga_email);
				
				/*
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
				*/
				
				
				
				jugadorSel = obj[0];
				
				$('#busca_error_carga_info').html('');
			
			}catch(ex){
				
				jugadorSel = null;
			
				$('#busca_nombre').html("&nbsp;");
				//$('#busca_fecha_nac').html("&nbsp;");
				//$('#busca_sexo').html("&nbsp;");
				$('#busca_email').html("&nbsp;");
				//$('#busca_telefono').html("&nbsp;");
				
				$('#busca_error_carga_info').html("<p>No se pudo cargar la informaci&oacute;n del jugador, "+
					"comuniquese con el jugador para que actualice sus datos en la p&aacute;gina web.</p>");
					
				$('#busca_error_carga_info').append("Tambi&eacute;n puede enviarle una invitaci&oacute;n a su correo electr&oacute;nico:");
					

				$('#busca_error_carga_info').append('<form id="formInvitacion" name="formInvitacion" class="formEstilo1">');
				$('#busca_error_carga_info').append('<fieldset>');
				
				$('#busca_error_carga_info').append('<label for="email" class="textoverdeesmeralda11b">Correo electr&oacute;nico</label>'+
													'<input type="text" id="invitacion_email" name="invitacion_email" size="20" onBlur="validarCorreo(this)" class="txtBox" />');
				
				$('#busca_error_carga_info').append('<br><br><div align="right"><a href="#" onClick="return invitar_jugador()"><img src="../art/boton_invitar.png"></a></div>');
				
				$('#busca_error_carga_info').append('</fieldset>');
				$('#busca_error_carga_info').append('</form>');

				$('#busca_error_carga_info').append('<div id="invitar_error_info"></div>');
				
													
				$('#busca_error_carga_info').append('<br><br><hr><br>');
			}

		}
	}
	
	/*
	function aceptar_jugador(){
	
		cargar_jugador();
	
		if(jugadorSel != null){
	
			//alert(elementoSel.parent().next().html());
			elementoSel.parent().next().html($('#busca_email').html());
			
			elementoSel.parent().html('<a class="fancybox.ajax textogris11b" href="mod_seleccionar_jugador.php">'
					+ $('#busca_cedula').val() + ' - ' + $('#busca_nombre').html() +'</a>');
					
			
			
			$("#htmlgridInsc tbody tr td a.textogris11b").fancybox();
			$("#htmlgridInsc tbody tr td a.textogris11b").click(function() {
				elementoSel = $(this);
			});
			
		}
		
		$.fancybox.close();
	
		return false;
	}
	*/
	
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
			 url: 'control/ctrl_enviar_email.php',
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

	function initCapitan(){
	
		var temp = elementoSel.parent().next().next().next().next().next().html();
		
		if(parseInt(temp,10)>0){
			$('#busca_cedula').val(temp.trim());
			cargarCapitan();
		}
	
	}
	
	
</script>


	<fieldset>
	
		<div id="busca_error_carga_info" class="error"></div>
	
		<label for="busca_cedula" class="textoverdeesmeralda11b">Cedula</label>
		<input type="text" id="busca_cedula" name="busca_cedula" size="20" class="txtBox" onBlur="cargarCapitan()" />
		<span id="msg_busca_cedula" class="error"></span>

		<label for="busca_nombre" class="textoverdeesmeralda11b">Nombre</label>
		<span id="busca_nombre">&nbsp;</span>

		<!--
		<label for="busca_fecha_nac" class="textoverdeesmeralda11b">Fecha nacimiento</label>
		<span id="busca_fecha_nac">&nbsp;</span>
					
		<label for="busca_sexo" class="textoverdeesmeralda11b">Sexo</label>
		<span id="busca_sexo">&nbsp;</span>
		
		<label for="busca_categoria" class="textoverdeesmeralda11b">Categor&iacute;a</label>
		<span id="busca_categoria">&nbsp;</span>
		-->
		<label for="busca_email" class="textoverdeesmeralda11b">Correo electr&oacute;nico</label>
		<span id="busca_email">&nbsp;</span>
		
		<!--
		<label for="busca_telefono" class="textoverdeesmeralda11b">Tel&eacute;fonos</label>
		<span id="busca_telefono">&nbsp;</span>
		
		<br><br><div align="right"><a href="#" onClick="return aceptar_jugador()"><img src="../art/boton_aceptar.png"></a></div>
		-->
	</fieldset>
