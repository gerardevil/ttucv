			
	<?php
		require_once('wp-admin/modelo/clubes.php');
		require_once('wp-admin/modelo/jugadores.php');
		require_once('wp-admin/modelo/estados.php');
		
	?>
	
	<script type="text/javascript"> 
	
		$(function(){
		
			//if(vUrl == ''){
				$('#visor_imagen').attr('src', (vUrl == '' ? '../' : '') + 'art/eventos/no_disponible.jpg');
			//}
			
			
			document.getElementById('otro_club').style.display = 'none'; 
			
			if(navigator.appName.indexOf("Explorer") != -1){
				
			}else{
				document.getElementById('fileupload_foto_jugador').style.display = 'none'; 
			}
			
			$("#fecha_nac").datepicker({
		      changeMonth: true,
		      changeYear: true,
			  minDate: -40000, 
			  maxDate: 1000,
			  yearRange: "c-100:c"
		    });
			
		});
		
		function cargarFoto(){
		
			
			$('#fileupload_foto_jugador').trigger('click');
			
		}
		
	</script>
	
		<fieldset>
			
			<div id="panel_foto">
				<label class="textoverdeesmeralda11b">Foto de <span>140x140</span></label>
				<a onClick="cargarFoto();"><img width="140" height="140" id="visor_imagen"></a>
				<input type="file" id="fileupload_foto_jugador" name="files[]" onClick="inicializar_fileupload(this)" width="30"/>
				<input type="hidden" name="foto" id="foto" value="">
				<label class="textoverdeesmeralda11b">Haga click en el recuadro para cargar una nueva foto</label>
			</div>
			
			<label for="cedula" class="textoverdeesmeralda11b">Cedula</label>
			<input type="text" id="cedula" name="cedula" size="20" class="txtBox"/> 	
			<span id="msg_cedula" class="error"></span>
			
			<label for="nombre" class="textoverdeesmeralda11b">Nombre</label>
			<input type="text" id="nombre" name="nombre" size="20" class="txtBox" />
			<span id="msg_nombre" class="error"></span>
			
			<label for="apellido" class="textoverdeesmeralda11b">Apellido</label>
			<input type="text" id="apellido" name="apellido" size="20" class="txtBox" />
			<span id="msg_apellido" class="error"></span>
			
			<label for="alias" class="textoverdeesmeralda11b">Alias</label>
			<input type="text" id="alias" name="alias" size="20" class="txtBox" />
			<span id="msg_apodo" class="error"></span>
			
			<label for="fecha_nac" class="textoverdeesmeralda11b">Fecha nacimiento</label>
			<input type="text" class="date" id="fecha_nac" name="fecha_nac" />
			<span id="msg_fecha_nac" class="error"></span>
			
			<label for="sexo" class="textoverdeesmeralda11b">Sexo</label>
			<select id="sexo" name="sexo">
				<option value=""></option>
				<option value="M">Masculino</option>
				<option value="F">Femenino</option>
			</select>
			<span id="msg_sexo" class="error"></span>
			
			<label for="estado" class="textoverdeesmeralda11b">Estado</label>
			<select id="estado" name="estado">
				<option value=""></option>
				<?php
				
					$obj = new estados('','');
					$estados = $obj->get_all_estados();
				
					while ($row_estado = mysql_fetch_assoc($estados)){
	
						echo "<option value=\"".$row_estado['edo_id']."\">"
								.$row_estado['edo_nombre']."</option>";
					
					}
				
				?>
			</select>
			<span id="msg_estado" class="error"></span>
			
			<label for="ciudad" class="textoverdeesmeralda11b">Ciudad</label>
			<input type="text" id="ciudad" name="ciudad" class="txtBox" size="20" />
			<span id="msg_ciudad" class="error"></span>
			
			<label for="zona" class="textoverdeesmeralda11b">Zona</label>
			<input type="text" id="zona" name="zona" size="20" class="txtBox" />
			<span id="msg_zona" class="error"></span>
			
			<label for="club" class="textoverdeesmeralda11b">Club</label>
			<select id="club" name="club" onChange="document.getElementById('otro_club').style.display = (this.value == 0 ? 'block' : 'none');">
				<option></option>
				<?php
				
					$obj = new clubes('','');
					$clubes = $obj->get_all_clubes();
				
					while ($row_clubes = mysql_fetch_assoc($clubes)){
	
						echo "<option value=\"".$row_clubes['club_id']."\">"
								.$row_clubes['club_nombre']."</option>";
					
					}
				
				?>
			</select>
			<input type="text" id="otro_club" name="otro_club" size="20" class="txtBox" />
			<span id="msg_club" class="error"></span>
			
			<label for="categoria" class="textoverdeesmeralda11b">Categor&iacute;a</label>
			<select id="categoria" name="categoria" <?php if($_GET['modulo']=='jugador') echo 'disabled="disabled"'; ?>>
				<option></option>
				<option value="1ra">1ra</option>
				<option value="2da">2da</option>
				<option value="3ra">3ra</option>
				<option value="4ta">4ta</option>
				<option value="5ta">5ta</option>
				<option value="6ta">6ta</option>
			</select>
			<span id="msg_categoria" class="error"></span>
			
		</fieldset>
		
				
<!--
<script>
	$("#fecha_nac").dateinput({
		lang:'es',
		format: 'dd/mm/yyyy',	// the format displayed for the user
		selectors: true,             	// whether month/year dropdowns are shown
		//min: -1000,                    // min selectable day (100 days backwards)
		//max: 1000,                    	// max selectable day (100 days onwards)
		offset: [10, 20],            	// tweak the position of the calendar
		speed: 'fast',               	// calendar reveal speed
		firstDay: 1,                  	// which day starts a week. 0 = sunday, 1 = monday etc..
		yearRange: [-80,1]
	});
</script>
-->