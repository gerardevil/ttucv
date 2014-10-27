<?php require_once('./admin.php');
 
function add_js() {?>
 
 <link href="../estilos.css" rel="stylesheet" type="text/css" />
 
<?php }
 
add_action('admin_head', 'add_js');
 

include('./admin-header.php');?>

<link rel="stylesheet" href="css/jquery-ui-1.10.3.min.css">

<link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css" media="screen" />

<link rel="stylesheet" href="css/editablegrid-2.0.1.css" type="text/css" media="screen">

<link rel="stylesheet" href="css/showLoading.css" type="text/css" media="screen">




<script src="scripts/jquery-1.9.1.min.js"></script>
	

<!--<script src="scripts/modernizr.custom.js"></script>-->

<!-- Add jQuery library -->
<!--<script src="../scripts/jquery.min-1.7.2.js"></script>-->

<!--<script src="../scripts/jquery.tools.min-1.2.7.js"></script>

<script src="scripts/config-location.js"></script>-->


<script src="scripts/fileupload/js/vendor/jquery.ui.widget.js"></script>
<script src="scripts/fileupload/js/jquery.iframe-transport.js"></script>
<script src="scripts/fileupload/js/jquery.fileupload.js"></script>
<script src="scripts/fileupload/js/jquery.fileupload-ui.js"></script>

<script src="scripts/jquery-ui-1.10.3.min.js"></script>
<script src="scripts/jquery.ui.datepicker-es.js"></script>


<!-- Add mousewheel plugin (this is optional) -->
<!--<script type="text/javascript" src="../scripts/jquery.mousewheel-3.0.6.pack.js"></script>-->
<!-- Add fancyBox -->

<script type="text/javascript" src="scripts/jquery.fancybox.pack.js"></script>

<script src="scripts/editablegrid-2.0.1.js"></script>


<script src="scripts/jquery.showLoading.min.js"></script>

<script src="../scripts/funciones.js"></script>


<script language="javascript">

	function geturl(addr, param, metodo) {
		
		if(metodo == '') metodo = 'GET';
	
		var r = $.ajax({  
		 type: metodo,  
		 url: addr,
		 //dataType: 'json',
		 data: param,
		 async: false  
		}).responseText;  
	return r;
	}

	function cargar_form(url, titulo, param, metodo){
	
		//alert(url);
	
		if ($('#panelprincipal').length){
		
			if(titulo != ''){
				document.getElementById('titulo').innerHTML = titulo;
			}
			
			//$('#panelprincipal').html(geturl(url, param, metodo)); 
			
			$('#panelprincipal').hideLoading();
			$('#panelprincipal').showLoading();
			
			$.ajax({  
				 type: metodo,  
				 url: url,
				 //dataType: 'json',
				 data: param,
				 success: function(respuesta){
					console.info(respuesta);
					try{
						$('#panelprincipal').append(respuesta); 
					}catch(e){
						console.error(e);
					}
				 },
				 complete: function(){
					$('#panelprincipal').hideLoading();
				 }
				 //async: false  
				});
		
		
		}else{
		
			// Creamos el formulario auxiliar
			var form = document.createElement( "form" );

			// Le añadimos atributos como el name, action y el method
			form.setAttribute( "name", "formulario" );
			form.setAttribute( "action", "index.php" );
			form.setAttribute( "method", 'post' );

			// Creamos un input para enviar el valor
			var input = document.createElement( "input" );

			// Le añadimos atributos como el name, type y el value
			input.setAttribute( "name", "modulo" );
			input.setAttribute( "type", "hidden" );
			input.setAttribute( "value", url );
			
			// Añadimos el input al formulario
			form.appendChild( input );
			
			// Creamos un input para enviar el valor
			input = document.createElement( "input" );

			// Le añadimos atributos como el name, type y el value
			input.setAttribute( "name", "titulo" );
			input.setAttribute( "type", "hidden" );
			input.setAttribute( "value", titulo );

			// Añadimos el input al formulario
			form.appendChild( input );

			// Añadimos el formulario al documento
			document.getElementsByTagName( "body" )[0].appendChild( form );

			// Hacemos submit
			document.formulario.submit();
		}
		
		
		
		return false;
		
	}
	
	
	function inicializar_fileupload(inputfile, noCargarImagen, visorImagenId){
		
		/* $('#panelprincipal').hideLoading();
		 $('#panelprincipal').showLoading();*/
		
		noCargarImagen = noCargarImagen || false;
		visorImagenId = (typeof visorImagenId == 'undefined') ? 'visor_imagen' : visorImagenId;
		
		$(inputfile).fileupload({
			dataType: 'json',
			url: 'scripts/fileupload/server/php/',
			replaceFileInput: false,
			add: function (e, data) {
				data.submit();
			},
			fail: function (e, data) {
				$('#panelprincipal').hideLoading();
				//$.each(data.result, function (index, file) { $('#panelprincipal').hideLoading();/* $.unblockUI(); */ });
			},
			error: function (e, data) {
				$('#panelprincipal').hideLoading();
				//$.each(data.result, function (index, file) { $('#panelprincipal').hideLoading();/* $.unblockUI(); */ });
			},
			done: function (e, data) {
			
				$.each(data.result, function (index, file) {
					if(!noCargarImagen){
						if ($('#'+visorImagenId).length) {

							document.getElementById(visorImagenId).src = 'scripts/fileupload/server/php/files/'+file.name;
				
						}
					}
				});
				
			}
		});
		
		
		$(inputfile).bind('fileuploadstart', function (e, data) { 
			$('#panelprincipal').hideLoading();
			$('#panelprincipal').showLoading();
			
		}); 
		

		
		$(inputfile).bind('fileuploadstop', function (e, data) {
			$('#panelprincipal').hideLoading();
		}); 
		
	}

</script>
<div class="wrap">
	<div id="icon-tools" class="icon32"><br></div>
	<h2 id="titulo"></h2><br>
	<div id="panelprincipal" style="min-height:400px">
		
	 
		<?php 
		
			$modulo = "";
			$titulo = "";
			
			if($_GET['modulo'] != ""){
				$modulo = $_GET['modulo'];
				$titulo = $_GET['titulo'];
			}

			if($_POST['modulo'] != ""){
				$modulo = $_POST['modulo'];
				$titulo = $_POST['titulo'];
			}
		
			if($modulo != ""){
				echo "<script>
						$(function() {
						cargar_form('".$modulo."','".$titulo."');
						});
					  </script>";
			}else{
				
				echo "<script>
						$(function() {
						cargar_form('vista/mod_eventos.php','Gestionar Eventos');
						});
					  </script>";
			} 
		
		?>
	 
	</div>
</div>
 
<?php include('./admin-footer.php') ?>