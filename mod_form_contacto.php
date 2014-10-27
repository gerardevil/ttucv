		
		
		<fieldset>
			
			<?php if($_GET['modulo'] == 'jugador'){?>
			
			<label for="email" class="textoverdeesmeralda11b">Correo electr&oacute;nico</label>
			<input type="text" id="email" name="email" size="20" onBlur="validarCorreo(this)" class="txtBox" />
			<br>
			<span class="textogris10r"> Formatos v&aacute;lido: ejemplo@correo.com</span>
			<span id="msg_email" class="error"></span>
			
			<?php } ?>
			
			<label for="telf_hab" class="textoverdeesmeralda11b">Tel&eacute;fono habitaci&oacute;n</label>
			<input type="text" id="telf_hab" name="telf_hab" size="20" class="txtBox" />
			<br>
			<span class="textogris10r"> Formatos v&aacute;lidos: 0212-1234567, 0212.1234567, 02121234567</span>
			<span id="msg_telf_hab" class="error"></span>
			
			<label for="telf_ofic" class="textoverdeesmeralda11b">Tel&eacute;fono oficina</label>
			<input type="text" id="telf_ofic" name="telf_ofic" size="20" class="txtBox" />
			<br>
			<span class="textogris10r"> Formatos v&aacute;lidos: 0212-1234567, 0212.1234567, 02121234567</span>
			<span id="msg_telf_ofic" class="error"></span>
			
			<label for="telf_cel" class="textoverdeesmeralda11b">Tel&eacute;fono celular</label>
			<input type="text" id="telf_cel" name="telf_cel" size="20" class="txtBox" />
			<br>
			<span class="textogris10r"> Formatos v&aacute;lidos: 0412-1234567, 0412.1234567, 04121234567</span>
			<span id="msg_telf_cel" class="error"></span>
			
			<label for="pin" class="textoverdeesmeralda11b">Pin</label>
			<input type="text" id="pin" name="pin" size="20" class="txtBox" />
			<span id="msg_pin" class="error"></span>
			
			<label for="twitter" class="textoverdeesmeralda11b">Twitter</label>
			<input type="text" id="twitter" name="twitter" size="20" class="txtBox" />
			<span id="msg_twitter" class="error"></span>
			
			<label for="facebook" class="textoverdeesmeralda11b">Facebook</label>
			<input type="text" id="facebook" name="facebook" size="20" class="txtBox" />
			<span id="msg_facebook" class="error"></span>
		
		</fieldset>