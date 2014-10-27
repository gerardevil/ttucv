

	var vUrl = getHost()+'wp-admin/';

	var modulo = '';
	function validarPasoUsuario(){
       var isValid = true; 
       
	   // Validate Email
	   var email = $('#email').val();

       if(email && email.length > 0){
         if(!validarCorreo(email)){
           isValid = false;
           $('#msg_email').html('El correo debe tener formato ejemplo@correo.com').show();           
         }else{

			if(modulo != 'jugador'){
			
				var r = $.ajax({  
				 type: 'GET',  
				 url: getHost()+'wp-admin/control/ctrl_usuarios.php',
				 //dataType: 'json',
				 data: 'opcion=existe&email='+email,
				 async: false  
				}).responseText;
				
				var existe = jQuery.parseJSON(r)=='true';
				
				if(modulo == 'recuperar'){
				
					if(!existe){
						isValid = false;
						$('#msg_email').html('No se encontro ningun usuario asociado a esta cuenta de correo electr&oacutenico').show();           
					}else{
						$('#msg_email').html('').hide();
					}
					
				}else{
				    if(existe){
						isValid = false;
						$('#msg_email').html('Ya existe un usuario con este correo').show();           
					}else{
						$('#msg_email').html('').hide();
					}
				}
				
			}
			
         }
       }else{
         isValid = false;
         $('#msg_email').html('Especifique el correo electr&oacute;nico').show();
       }       
       
	   try{
	   
	       // validate password
	       var pw = $('#password').val();
	       if(!pw && pw.length <= 0){
	         isValid = false;
	         $('#msg_password').html('Especifique la contrase&ntilde;a').show();         
	       }else{
	         $('#msg_password').html('').hide();
	       }
	       
	       // validate confirm password
	       var cpw = $('#password2').val();
	       if(!cpw && cpw.length <= 0){
	         isValid = false;
	         $('#msg_password2').html('Especifique la confirmaci&oacute;n de contrase&ntilde;a').show();         
	       }else{
	         $('#msg_password2').html('').hide();
	       }  
	       
	       // validate password match
	       if(pw && pw.length > 0 && cpw && cpw.length > 0){
	         if(pw != cpw){
	           isValid = false;
	           $('#msg_password2').html('Las contrase&ntilde;as no concuerdan').show();            
	         }else{
	           $('#msg_password2').html('').hide();
	         }
	       }
	   
	   }catch(ex){
			
	   }
	   
	   
       return isValid;
    }
    
	
	
	
    function validarPasoJugador(){
       var isValid = true; 
       
	   // validate cedula
	   var ci = $('#cedula').val();
       if(ci && ci.length > 0){
         if(!validarNumero(ci)){
           isValid = false;
           $('#msg_cedula').html('La cedula solo debe contener n&uacute;meros ej. 12345678').show();           
         }else{
          $('#msg_cedula').html('').hide();
         }
       }else{
         isValid = false;
         $('#msg_cedula').html('Especifique su cedula').show();
       }       
	   
       // validate nombre
       var nombre = $('#nombre').val();
       if(!nombre && nombre.length <= 0){
         isValid = false;
         $('#msg_nombre').html('Especifique su nombre').show();         
       }else{
         $('#msg_nombre').html('').hide();
       }
       
       // validate sexo
       var sexo = $('#sexo').val();
       if(!sexo && sexo.length <= 0){
         isValid = false;
         $('#msg_sexo').html('Especifique su sexo').show();         
       }else{
         $('#msg_sexo').html('').hide();
       }  
       
       return isValid;
    }
	
	
	
	
	
	function validarPasoContacto(){
       var isValid = true; 
       
	   // validate telefono habitacion
	   var telf = $('#telf_hab').val();
       if(telf && telf.length > 0){
         if(!validarTelefono(telf)){
           isValid = false;
           $('#msg_telf_hab').html('El tel&eacute;fono de habitaci&oacute;n debe tener formato ej. 0212-1234567, 0212.1234567, 02121234567').show();           
         }else{
          $('#msg_telf_hab').html('').hide();
         }
       }else{
         isValid = false;
         $('#msg_telf_hab').html('Especifique su tel&eacute;fono de habitaci&oacute;n').show();
       }   

		// validate telefono oficina
	   var telf = $('#telf_ofic').val();
       if(telf && telf.length > 0){
         if(!validarTelefono(telf)){
           isValid = false;
           $('#msg_telf_ofic').html('El tel&eacute;fono de oficina debe tener formato ej. 0212-1234567, 0212.1234567, 02121234567').show();           
         }else{
          $('#msg_telf_ofic').html('').hide();
         }
       }
	   
	   
	   // validate telefono celular
	   var telf = $('#telf_cel').val();
       if(telf && telf.length > 0){
         if(!validarTelefono(telf)){
           isValid = false;
           $('#msg_telf_cel').html('El tel&eacute;fono celular debe tener formato ej. 0416-1234567, 0412.1234567, 04121234567').show();           
         }else{
          $('#msg_telf_cel').html('').hide();
         }
       }
	   
       
       return isValid;
    }
	
	
	function cargar_jugador(){
	
		var cedula = $('#cedula').val();
		
		if(cedula != ''){
			var form =  document.forms[0];
			
			var param = 'opcion=consulta&cedula=' + cedula;
			
			var json = $.ajax({  
			 type: 'GET',  
			 url: vUrl + 'control/ctrl_jugadores.php',
			 dataType: 'json',
			 data: param,
			 //async: false 
			 success: function(arrayDeObjetos){
					
					try{
						
						var obj = arrayDeObjetos;
						
						if(obj[0].juga_foto != null){
							document.getElementById('visor_imagen').src = getHost() + 'art/jugadores/' + obj[0].juga_foto;
							document.getElementById('foto').value = obj[0].juga_foto;
						}else{
							document.getElementById('visor_imagen').src = getHost() + 'art/eventos/no_disponible.jpg';
							document.getElementById('foto').value = '';
						}
						
						document.getElementById('nombre').value = obj[0].juga_nombre;
						document.getElementById('apellido').value = obj[0].juga_apellido;
						
						if(obj[0].juga_fecha_nac != null){
							/*var fecha = new Date(obj[0].juga_fecha_nac);
							var api = $("#fecha_nac").data("dateinput");
							api.setValue(fecha);*/
							$('#fecha_nac').datepicker('setDate', new Date(obj[0].juga_fecha_nac));
						}else{
							$("#fecha_nac").reset();
						}
						
						if(obj[0].juga_sexo != null){
							document.getElementById('sexo').value = obj[0].juga_sexo;
						}else{
							document.getElementById('sexo').value = "";
						}
						
						if(obj[0].edo_id != null){
							document.getElementById('estado').value = obj[0].edo_id;
						}else{
							document.getElementById('estado').value = "";
						}
						
						document.getElementById('ciudad').value = obj[0].juga_ciudad;
						document.getElementById('zona').value = obj[0].juga_zona;
						document.getElementById('club').value = obj[0].club_id;
						document.getElementById('otro_club').value = obj[0].juga_otro_club;
						document.getElementById('otro_club').style.display = (obj[0].club_id == 0 ? 'block' : 'none');
						
						document.getElementById('telf_hab').value = obj[0].juga_telf_hab;
						document.getElementById('telf_ofic').value = obj[0].juga_telf_ofic;
						document.getElementById('telf_cel').value = obj[0].juga_telf_cel;
						document.getElementById('pin').value = obj[0].juga_pin;
						document.getElementById('twitter').value = obj[0].juga_twitter;
						document.getElementById('facebook').value = obj[0].juga_facebook;
						document.getElementById('email').value = obj[0].juga_email;
						
						document.getElementById('categoria').value = obj[0].juga_categoria;
						document.getElementById('alias').value = obj[0].juga_alias;
						
						if($('#privacidadFicha').size() > 0){
							if(obj[0].juga_ficha_perfil == "+")	$('input:radio[name=privacidadFicha]')[0].checked = true;
							else $('input:radio[name=privacidadFicha]')[1].checked = true;
						}
						
					}catch(ex){
					
						console.error(ex.message);
					
					}
					
				  }  
			});
			
		}
	}
	
	function cargar_jugador_by_email(email){

		if(email != ''){
		
			try{
			
				var form =  document.forms[0];
				
				var param = 'opcion=consulta&email=' + email;
				
				var json = $.ajax({  
				 type: 'GET',  
				 url: vUrl + 'control/ctrl_jugadores.php',
				 dataType: 'json',
				 data: param,
				 //async: false  
				 success: function(arrayDeObjetos){
					
					try{
						
						var obj = arrayDeObjetos;
						
						if(obj[0].juga_foto != null){
							document.getElementById('visor_imagen').src = getHost() + 'art/jugadores/' + obj[0].juga_foto;
							document.getElementById('foto').value = obj[0].juga_foto;
						}else{
							document.getElementById('visor_imagen').src = getHost() + 'art/eventos/no_disponible.jpg';;
							document.getElementById('foto').value = '';
						}
						
						document.getElementById('cedula').value = obj[0].juga_id;
						document.getElementById('nombre').value = obj[0].juga_nombre;
						document.getElementById('apellido').value = obj[0].juga_apellido;
						
						if(obj[0].juga_fecha_nac != null){
							/*var fecha = new Date(obj[0].juga_fecha_nac);
							var api = $("#fecha_nac").data("dateinput");
							api.setValue(fecha);*/
							$('#fecha_nac').datepicker('setDate', new Date(obj[0].juga_fecha_nac));
						}else{
							$("#fecha_nac").reset();
						}
						
						if(obj[0].juga_sexo != null){
							document.getElementById('sexo').value = obj[0].juga_sexo;
						}else{
							document.getElementById('sexo').value = "";
						}
						
						if(obj[0].edo_id != null){
							document.getElementById('estado').value = obj[0].edo_id;
						}else{
							document.getElementById('estado').value = "";
						}
						
						document.getElementById('ciudad').value = obj[0].juga_ciudad;
						document.getElementById('zona').value = obj[0].juga_zona;
						document.getElementById('club').value = obj[0].club_id;
						document.getElementById('otro_club').value = obj[0].juga_otro_club;
						document.getElementById('otro_club').style.display = (obj[0].club_id == 0 ? 'block' : 'none');
						
						document.getElementById('telf_hab').value = obj[0].juga_telf_hab;
						document.getElementById('telf_ofic').value = obj[0].juga_telf_ofic;
						document.getElementById('telf_cel').value = obj[0].juga_telf_cel;
						document.getElementById('pin').value = obj[0].juga_pin;
						document.getElementById('twitter').value = obj[0].juga_twitter;
						document.getElementById('facebook').value = obj[0].juga_facebook;
						document.getElementById('email').value = obj[0].juga_email;
						
						document.getElementById('categoria').value = obj[0].juga_categoria;
						document.getElementById('alias').value = obj[0].juga_alias;
						
						if($('#privacidadFicha').size() > 0){
							if(obj[0].juga_ficha_perfil == "+")	$('input:radio[name=privacidadFicha]')[0].checked = true;
							else $('input:radio[name=privacidadFicha]')[1].checked = true;
						}
						
					}catch(ex){
					
						console.error(ex.message);
					
					}
					
				  }  
				});
				
			}catch(ex){
			
				console.error(ex.message);
			
			}
			
		}
	}
	
		function validarPasoUsuarioEquipo(){
		
			var isValid = true;
			
			var usuario = $('#usuario').val();

			if(usuario && usuario.length > 0){
			
				var path = document.location.pathname;
			
				var r = $.ajax({  
				 type: 'GET',  
				 url: getHost()+'wp-admin/control/ctrl_equipos.php',
				 //dataType: 'json',
				 data: 'opcion=existe&usuario='+usuario,
				 async: false  
				}).responseText;
				
				var existe = jQuery.parseJSON(r)=='true';
				
				if(modulo == 'recuperar'){
				
					if(!existe){
						isValid = false;
						$('#msg_usuario').html('No se encontro ningun usuario asociado a esta cuenta de correo electr&oacutenico').show();           
					}else{
						$('#msg_usuario').html('').hide();
					}
					
				}else{
					if(existe){
						isValid = false;
						$('#msg_usuario').html('Ya existe un equipo con este usuario').show();           
					}else{
						$('#msg_usuario').html('').hide();
					}
				}
				
			}else{
	         isValid = false;
	         $('#msg_usuario').html('Especifique su usuario para registrarse en el interclubes').show();
	       }        
	       
		  // try{
		   
		       // validate password
		       var pw = $('#password').val();
		       if(!pw && pw.length <= 0){
		         isValid = false;
		         $('#msg_password').html('Especifique la contrase&ntilde;a').show();         
		       }else{
		         $('#msg_password').html('').hide();
		       }
		       
		       // validate confirm password
		       var cpw = $('#password2').val();
		       if(!cpw && cpw.length <= 0){
		         isValid = false;
		         $('#msg_password2').html('Especifique la confirmaci&oacute;n de contrase&ntilde;a').show();         
		       }else{
		         $('#msg_password2').html('').hide();
		       }  
		       
		       // validate password match
		       if(pw && pw.length > 0 && cpw && cpw.length > 0){
		         if(pw != cpw){
		           isValid = false;
		           $('#msg_password2').html('Las contrase&ntilde;as no concuerdan').show();            
		         }else{
		           $('#msg_password2').html('').hide();
		         }
		       }
		   
		  // }catch(ex){
				
		   //}
		   
		   // Validate Email
		   var email = $('#email').val();

	       if(email && email.length > 0){
	         if(!validarCorreo(email)){
	           isValid = false;
	           $('#msg_email').html('El correo debe tener formato ejemplo@correo.com').show();           
	         }else{
				$('#msg_email').hide();
			 }
	       }else{
	         isValid = false;
	         $('#msg_email').html('Especifique el correo electr&oacute;nico').show();
	       }      
		   
		   
		   
						
			
			return isValid;
		}		
	

		function validarPasoEquipo(){
		
			var isValid = true;
			
			var interclubes = $('#interclubes').val();

			if(interclubes && interclubes.length > 0){
				
				$('#msg_interclubes').html('').hide();
				
				var equipo_nombre = $('#equipo_nombre').val();
				
				if(equipo_nombre && equipo_nombre.length > 0){
				
					var path = document.location.pathname;
			
					var r = $.ajax({  
					 type: 'GET',  
					 url: getHost()+'wp-admin/control/ctrl_equipos.php',
					 //dataType: 'json',
					 data: 'opcion=existeEquipo&equipo='+equipo_nombre+'&inter_id='+interclubes,
					 async: false  
					}).responseText;
					
					var existe = jQuery.parseJSON(r)=='true';
					
					if(modulo != 'inscripcion'){
					
						if(modulo == 'recuperar'){
						
							if(!existe){
								isValid = false;
								$('#msg_equipo_nombre').html('No se encontro ningun usuario asociado a esta cuenta de correo electr&oacutenico').show();           
							}else{
								$('#msg_equipo_nombre').html('').hide();
							}
							
						}else{
							if(existe){
								isValid = false;
								$('#msg_equipo_nombre').html('Ya existe un equipo con este nombre en el torneo').show();           
							}else{
								$('#msg_equipo_nombre').html('').hide();
							}
						}
						
					}
					
				}else{
					isValid = false;
					$('#msg_equipo_nombre').html('Especifique el nombre de su equipo para estos interclubes').show();
				}
				
			}else{
				isValid = false;
				$('#msg_interclubes').html('Especifique un torneo de interclubes a inscribirse').show();
			} 
	       
		  // try{
		   
		       // validate club
		       var club = $('#club').val();
		       if(!club && club.length <= 0){
		         isValid = false;
		         $('#msg_club').html('Especifique el club al que representa su equipo').show();         
		       }else{
		         $('#msg_club').html('').hide();
		       }
		       
		       // validate tipo_cancha
		       var tcancha = $('#tipo_cancha').val();
		       if(!tcancha && tcancha.length <= 0){
		         isValid = false;
		         $('#msg_tipo_cancha').html('Especifique el tipo de cancha preferida para su equipo').show();         
		       }else{
		         $('#msg_tipo_cancha').html('').hide();
		       }  
		       
		   
		   
						
			
			return isValid;
		}		