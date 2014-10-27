
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script src="../scripts/bootstrap.min.js"></script>

<script>

	function cargarImagenes(pagina){
	
		$('#imagenes').hideLoading();	
		$('#imagenes').showLoading();	
	
		var paginaActual = 1;

		
		if($('.pagination li.active a').size() > 0){
			paginaActual = $('.pagination li.active a').first().html();
		}
		
		
		if(pagina == '\u00AB'){
			
			pagina = parseInt(paginaActual)-1;
		
		}else if(pagina == '\u00BB'){
		
			pagina = parseInt(paginaActual)+1;
		
		}else{
		
			pagina = parseInt(pagina);
		
		}
		
	
		$('.pagination li.active').removeClass('active');
		$('.pagination li.disabled').removeClass('disabled');
		if(pagina==1)
			$('.pagination a:contains('+pagina+')').parent().addClass('active').prev().addClass('disabled');
		else if(pagina==($('.pagination li').size()-2))
			$('.pagination a:contains('+pagina+')').parent().addClass('active').next().addClass('disabled');
		else
			$('.pagination a:contains('+pagina+')').parent().addClass('active');
	
		
		
		$('#tablaImagenes tbody').html('');
		
		$.ajax({  
			 type: 'GET',  
			 url: getHost()+'admin/control/ctrl_galerias.php',
			 dataType: 'json',
			 data: 'opcion=consultaAll&pagina='+pagina,
			 success: function(arrayDeObjetos){
			 
				for(i=0;i<arrayDeObjetos.length;i++){
					
					if(typeof arrayDeObjetos[i] == 'object'){
					
						var param = '?id='+arrayDeObjetos[i].gale_id;
						
						html = '<tr><td><a href="vista/mod_galerias.php'+param+'" gale_id="'+arrayDeObjetos[i].gale_id+'" class="imagen fancybox.ajax">';
						html += '<img src="'+getHost()+'art/galerias/'+arrayDeObjetos[i].gale_imagenpp+'" width="80" height="60"></a></td>';
						html += '<td><a href="vista/mod_galerias.php'+param+'" gale_id="'+arrayDeObjetos[i].gale_id+'" class="imagen fancybox.ajax">'+arrayDeObjetos[i].gale_nombre+'</a></td>';
						//html += '<td>'+Math.round(result[0].size/10)/100+' KB</td>';
						if(arrayDeObjetos[i].gale_publicar == 'S'){
							html += '<td><span class="label label-success">Publicado</span></td>';
						}else{
							html += '<td><span class="label label-warning">No publicado</span></td>';
						}
						html += '<td><input type="checkbox"></td>';
						html += '</tr>';
						$('#tablaImagenes tbody').append(html);
					
					}else{
					
						var param = '?imagen='+arrayDeObjetos[i];
			
						html = '<tr><td><a href="vista/mod_galerias.php'+param+'" class="imagen fancybox.ajax">';
						html += '<img src="'+getHost()+'admin/scripts/fileupload/server/php/thumbnails/'+arrayDeObjetos[i]+'"></a></td>';
						html += '<td><a href="vista/mod_galerias.php'+param+'" class="imagen fancybox.ajax">'+arrayDeObjetos[i]+'</a></td>';
						//html += '<td>'+Math.round(result[0].size/10)/100+' KB</td>';
						html += '<td><span class="label label-warning">En espera</span></td>';
						html += '<td><input type="checkbox"></td>';
						html += '</tr>';
						
						$('#tablaImagenes tbody').append(html);
					
					}
						
				}
				
			 },
			  error: function(err,err2){
				alert(err+' - '+err2);
			  },
			 complete: function(){
				$('.imagen').fancybox();
				$('#imagenes').hideLoading();
			  }
			});

	
	}
	
	function cargarCantPaginas(){
	
		$.ajax({  
		 type: 'GET',  
		 url: getHost()+'admin/control/ctrl_galerias.php',
		 dataType: 'json',
		 data: 'opcion=consultaCantPaginas',
		 async: false,
		 success: function(arrayDeObjetos){
			
			var paginas = arrayDeObjetos[0];
			var html = '<li><a href="#">&laquo;</a></li>';
			
			for(i=1;i<=paginas;i++){
				html += '<li><a href="#">'+i+'</a></li>';
			}
			
			html += '<li><a href="#">&raquo;</a></li>';
			
			$('.pagination').html(html);
			
			$('.pagination a').click(function(e){
				e.preventDefault();
				
				if(!$(this).parent().hasClass('active') && !$(this).parent().hasClass('disabled'))
					cargarImagenes($(this).html());
			});
				
		  },
		  error: function(err,err2){
			alert(err+' - '+err2);
		  },
		 complete: function(){
			//$('#imagenes').hideLoading();
		  }
		});
	
	}


	function publicar(){
		
		$('#imagenes').hideLoading();	
		$('#imagenes').showLoading();	
		var datos = new Array(); 
		
		$('#tablaImagenes input:checked').each(function(){
		
			if($(this).parent().prev().children().html() == 'En espera'){
				//var tmp = new Array();
				//tmp.push($(this).parent().prev().prev().children().html());
				//datos.push(tmp);
				datos.push($(this).parent().prev().prev().children().html());
			}
		
		});

		
		$.ajax({  
		 type: 'POST',  
		 url: getHost()+'admin/control/ctrl_galerias.php',
		 //dataType: 'json',
		 data: 'opcion=publicarGalerias&datos='+ JSON.stringify(datos),
		 success: function(arrayDeObjetos){
			
			html = '<div class="alert alert-success alert-dismissable">' +
						' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
						' Operaci&oacute;n realizada satisfactoriamente.' +
						'</div>';
						
			$('#mensajesMulti').append(html);
				
		  },
		  error: function(err,err2){
			//alert(err+' - '+err2);
			console.error(err+' - '+err2);
		  },
		 complete: function(){
			$('#imagenes').hideLoading();
		  }
		});
		
		
		
	}
	
	
	function eliminar(){
		
		$('#imagenes').hideLoading();	
		$('#imagenes').showLoading();	
		var datos = new Array(); 
		
		$('#tablaImagenes input:checked').each(function(){
		
			if($(this).parent().prev().children().html() == 'En espera'){
				var tmp = new Array();
				tmp.push($(this).parent().prev().prev().children().html());
				tmp.push('A');
				datos.push(tmp);
			}else{
				var tmp = new Array();
				tmp.push($(this).parent().prev().prev().children().attr('gale_id'));
				tmp.push('G');
				datos.push(tmp);
			}
			
		});

		
		$.ajax({  
		 type: 'POST',  
		 url: getHost()+'admin/control/ctrl_galerias.php',
		 //dataType: 'json',
		 data: 'opcion=eliminarGalerias&datos='+ JSON.stringify(datos),
		 success: function(res){
			
			html = '<div class="alert alert-success alert-dismissable">' +
					' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
					' Operaci&oacute;n realizada satisfactoriamente.' +
					'</div>';
						
			$('#mensajesMulti').append(html);
				
		  },
		  error: function(err,err2){
			//alert(err+' - '+err2);
			console.error(err+' - '+err2);
		  },
		 complete: function(){
			$('#imagenes').hideLoading();
		  }
		});

	}
	
	$(function(){
	
		$('#fileuploadMulti').fileupload({
			dataType: 'json',
			url: 'scripts/fileupload/server/php/',
			replaceFileInput: false,
			limitMultiFileUploadSize: 100000000,
			maxFileSize: 1000000,
			acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
			sequentialUploads: true,
			imageMaxWidth: 720,
			imageMaxHeight: 480,
			imageForceResize: true,
			//autoUpload: true,
			add: function (e, data) {
			
				console.log('Added file: ' + data.files[0].name);
				
				if(data.files[0].size > 1000000){
					html = '<div class="alert alert-danger alert-dismissable">' +
						' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
						' <strong>Error!</strong>El archivo ' + data.files[0].name + ' es demasiado grande.' +
						'</div>';
					$('#mensajesMulti').append(html);
					return;
				}
				
				if(!/(\.|\/)(gif|jpe?g|png)$/i.test(data.files[0].type)){
					html = '<div class="alert alert-danger alert-dismissable">' +
						' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
						' <strong>Error!</strong>El archivo ' + data.files[0].name + ' no es una imagen.' +
						'</div>';
					$('#mensajesMulti').append(html);
					return;
				}
				 					
				var jqXHR = data.submit()
					.success(function (result, textStatus, jqXHR){
						console.log(result);
						
						var param = '?imagen='+result[0].name;
						
						html = '<tr><td><a href="vista/mod_galerias.php'+param+'" class="imagen fancybox.ajax">';
						html += '<img src="'+result[0].thumbnail_url+'"></a></td>';
						html += '<td><a href="vista/mod_galerias.php'+param+'" class="imagen fancybox.ajax">'+result[0].name+'</a></td>';
						//html += '<td>'+Math.round(result[0].size/10)/100+' KB</td>';
						html += '<td><span class="label label-warning">En espera</span></td>'
						html += '<td><input type="checkbox"></td>';
						html += '</tr>';
						$('#tablaImagenes tbody').prepend(html);
						
						$('.imagen').fancybox();
						
					})
					.error(function (jqXHR, textStatus, errorThrown){
						html = '<div class="alert alert-danger alert-dismissable">' +
						' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
						' <strong>Error!</strong>' + errorThrown + '.' +
						'</div>';
						
						$('#mensajesMulti').append(html);
					})
					.complete(function (result, textStatus, jqXHR) {/* ... */});
					
			},
			fail: function (e, data) {
				//console.error(data);
			},
			error: function (e, data) {
				//console.error(data);
			},
			done: function (e, data) {
			/*
				$.each(data.result, function (index, file) {
					
					console.log(file.name);
					
				});
				*/
			},
			progressall: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 100, 10);
				$('#progressBar').css(
					'width',
					progress + '%'
				);
				
				$('#progressExt').html((Math.round(data.loaded/10)/100) + ' KB / '+(Math.round(data.total/10)/100)+' KB');

			}
		});
		
		$('#btnActualizar').click(function(e){
			e.preventDefault();
			
			var pagina = $('.pagination li.active a').first().html();
			
			cargarCantPaginas();
			cargarImagenes(pagina);
		});
		
		$('#btnPublicar').click(function(e){
			e.preventDefault();
			publicar();
		});
		
		$('#btnEliminar').click(function(e){
			e.preventDefault();
			eliminar();
		});
		
		$('#selTodo').click(function(e){
			$('input:checkbox').prop('checked',$('#selTodo').prop('checked'));
			//e.preventDefault();
		});
		
		cargarCantPaginas();
		cargarImagenes(1);
	
	});

</script>

<form id="formGaleria" class="formEstilo2" action="scripts/fileupload/server/php/UploadHandler.php" method="POST" enctype="multipart/form-data" class="">
    
	<label class="textogris11b">Seleccionar las im&aacute;genes a subir</label>
	<input type="file" id="fileuploadMulti" name="files[]" multiple="" accept="image/jpg, image/jpeg, image/gif, image/png"><br><br>
	
	<button type="button" id="btnActualizar" class="btn btn-info refresh">
		<i class="glyphicon glyphicon-refresh"></i>
		<span>Actualizar</span>
	</button>
	<button type="button" id="btnPublicar" class="btn btn-success start">
		<i class="glyphicon glyphicon-check"></i>
		<span>Publicar</span>
	</button>
	<button type="button" id="btnEliminar" class="btn btn-danger delete">
		<i class="glyphicon glyphicon-trash"></i>
		<span>Eliminar</span>
	</button>
	<input type="checkbox" id="selTodo" class="toggle"><br><br>

	<!-- The global progress bar -->
	<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
		<div id="progressBar" class="progress-bar btn-success" style="width:0%;"></div>
	</div>
	<!-- The extended global progress state -->
	<div id="progressExt" class="progress-extended">&nbsp;</div><br>
		
	<div id="mensajesMulti"></div>
	<!-- The table listing the files available for upload/download -->
	
	<ul class="pagination" style="float:right;">
	  <li><a href="#">&laquo;</a></li>
	  <li><a href="#">1</a></li>
	  <li><a href="#">&raquo;</a></li>
	</ul>
	
	<div id="imagenes" style="min-height:770px;">
	<table id="tablaImagenes" role="presentation" class="table table-striped">
		<tbody class="files">
		</tbody>
	</table>
	</div>
    <!--<div class="alert alert-danger">Upload server currently unavailable - Wed Dec 04 2013 01:23:31 GMT-0430 (Hora estándar de Venezuela)</div>-->

	
</form>
	