
<?php require_once('./admin.php');
 
function add_js() {?>
 
 <link href="../estilos.css" rel="stylesheet" type="text/css" />
 
<?php }
 
add_action('admin_head', 'add_js');
 

include('./admin-header.php');?>



<?php 

require_once ("../funciones.php");
require_once("modelo/eventos.php");
require_once("modelo/modalidades.php");
require_once("modelo/draws.php");
require_once("modelo/rondas.php");
require_once("modelo/jugadores.php");
require_once("modelo/inscripciones_eventos.php");


//VARIABLE FIJA DEPORTE
$vdeporte="1";



?>


<link href="../estilos.css" rel="stylesheet" type="text/css" />

<link href="../css/draw.css" rel="stylesheet" type="text/css" />

<!--<link rel="stylesheet" type="text/css" href="css/dateinput.css"/>-->

<link rel="stylesheet" href="css/jquery-ui-1.10.3.min.css">

<link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css" media="screen" />

<link rel="stylesheet" href="css/showLoading.css" type="text/css" media="screen">

<style type="text/css">
	a img{border:0}
</style>


<!-- Add jQuery library -->
<script src="scripts/jquery-1.9.1.min.js"></script>
	

<script src="scripts/modernizr.custom.js"></script>

<!-- Add mousewheel plugin (this is optional) -->
<!--<script type="text/javascript" src="../scripts/jquery.mousewheel-3.0.6.pack.js"></script>-->

<!-- Para el drag and drop-->
<script src="scripts/jquery-ui-1.10.3.min.js"></script>
<script src="scripts/jquery.ui.datepicker-es.js"></script>

<!-- Add fancyBox -->
<script type="text/javascript" src="scripts/jquery.fancybox.pack.js"></script>
<!-- Optionally add helpers - button, thumbnail and/or media -->
<!--<link rel="stylesheet" href="../css/jquery.fancybox-buttons.css?v=1.0.2" type="text/css" media="screen" />
<script type="text/javascript" src="../scripts/jquery.fancybox-buttons.js?v=1.0.2"></script>
<script type="text/javascript" src="../scripts/jquery.fancybox-media.js?v=1.0.0"></script>
<link rel="stylesheet" href="../css/jquery.fancybox-thumbs.css?v=2.0.6" type="text/css" media="screen" />
<script type="text/javascript" src="../scripts/jquery.fancybox-thumbs.js?v=2.0.6"></script>-->

<script src="scripts/jquery.showLoading.min.js"></script>


<!-- Scripts para iniciar el efecto de fancybox-->
<script type="text/javascript">
	$(document).ready(function() {
		inicializar_drag_and_drop();
	});
</script>

<!-- Para Google Analytics-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-37628651-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script type="text/javascript">

	var rondasArray = new Array();
	var evmo_id;
	var elementoSel;

	function contruir_draw(){
		
		if($('#rondaIni').val() != ''){
			if($('#drawDetalleSeccion').children('table').size() > 0){
				
				var rondasAnt = $('#drawDetalleSeccion table thead tr th').size();
				
				if(rondasAnt > (rondasArray.length-parseInt($('#rondaIni').val()))){
				
					for(var i=0;i<rondasAnt-(rondasArray.length-parseInt($('#rondaIni').val()))-1;i++){
						eliminar_ronda(i);
					}
					
					actualizar_clases_rondas();
				
				}else{
				
					remover_clases_rondas();
				
					for(var i=rondasArray.length-rondasAnt;i>=parseInt($('#rondaIni').val());i--){
						agregar_ronda(i,true);
					}
					
					actualizar_clases_rondas();
					
				}
				
			}else{
				//Se crea un draw vacio
			
				$('#drawDetalleSeccion').html("\n<table cellspacing=\"0\" class=\"rondas\">");
				$('#drawDetalleSeccion table').append("<thead>");
				$('#drawDetalleSeccion table thead').append("<tr>");
			
				var i;
				var col_i;
						
				$('#drawDetalleSeccion table').append("<tr>");
				
				for(i=parseInt($('#rondaIni').val()); i<rondasArray.length;i++){
					agregar_ronda(i);
				}
				
				//Jugador Campeon
				agregar_ronda(i);

			}
			
			inicializar_drag_and_drop();
			
		}else{
			$('#drawDetalleSeccion').html("<p class=\"textogris11b\"><br>Seleccione una modalidad<br></p>");
		}
		
	}
	
	// i: la columna de la ronda 
	function eliminar_ronda(i){
	
		var col_i = '.col_'+(i+1);
		$(col_i).remove();
		
	}
	
	
	// i: la columna de la ronda 
	function agregar_ronda(i,alPrincipio){
	
		alPrincipio = alPrincipio || false;
	
		col_i = 'col_'+(i-parseInt($('#rondaIni').val())+1);
		
		if(i < rondasArray.length){
			nombreRonda = rondasArray[i].ronda_nombre;
			cantDraws = rondasArray[i].ronda_draws;
		}else{
			nombreRonda = 'CAMPEON';
			cantDraws = 1;
		}
		
		if(alPrincipio){
			$('#drawDetalleSeccion table thead tr').prepend("\n<th class=\""+col_i+"\">"+nombreRonda+"</th>\n");
			$('#drawDetalleSeccion table tbody tr').prepend("\n<td class=\""+col_i+"\">\n");
		}else{
			$('#drawDetalleSeccion table thead tr').append("\n<th class=\""+col_i+"\">"+nombreRonda+"</th>\n");
			$('#drawDetalleSeccion table tbody tr').append("\n<td class=\""+col_i+"\">\n");
		}
		
		for(var j=1; j<=cantDraws;j++){
			
			$('#drawDetalleSeccion table tbody tr td.'+col_i).append("\n<div class=\"draw\">\n");
			
			//Jugador 1
			
			if(j==1){
				$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child').append("\n<div class=\"drawItem first\">\n");
			}else{
				$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child').append("\n<div class=\"drawItem\">\n");
			}
			
			$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child').append("\n<div class=\"jugadoresContenedor\">\n");
			
			$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child div.jugadoresContenedor').append("\n<div class=\"jugador\">\n");
			
			if(i==parseInt($('#rondaIni').val())){
				$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child div.jugadoresContenedor div.jugador:last-child').append("<a class=\"fancybox.ajax data\" href=\"mod_draws_jugador.php?evmo_id="+evmo_id+"\">Jugador 1</a>\n");
			}
			
			//if(es_doble){
				$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child div.jugadoresContenedor').append("\n<div class=\"jugador\">\n");
			//}
			
			
			
			if((i-parseInt($('#rondaIni').val())+1) == 2){//solo se coloca la fecha de lo juegos de la primera ronda (es 2 porque la fecha de los juegos de la primera ronda se especifican en la secci�n de ganador de la segunda)
				$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child').append("\n<div class=\"scores\">\n");
				$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child div.scores').append("<a class=\"fancybox.ajax data\" href=\"mod_draws_data.php\" fecha=\""+$('#fechaIniModa').attr('larga')+"\">"+$('#fechaIniModa').attr('corta')+"</a>");
			}else if((i-parseInt($('#rondaIni').val())+1) > 2){
				$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child').append("\n<div class=\"scores\">\n");
				$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child div.scores').append("<a class=\"fancybox.ajax data\" href=\"mod_draws_data.php\" fecha=\"\">Fecha/Score</a>");
			}
			
			if(i < rondasArray.length){
				
				//Jugador 2
				
				$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child').append("\n<div class=\"drawItem even\">\n");
				
				$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child').append("\n<p class=\"numero\">"+j+"</p>\n");
				
				$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child').append("\n<div class=\"jugadoresContenedor\">\n");
				
				$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child div.jugadoresContenedor').append("\n<div class=\"jugador\">\n");
				
				if(i==parseInt($('#rondaIni').val())){
					$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child div.jugadoresContenedor div.jugador:last-child').append("<a class=\"fancybox.ajax data\" href=\"mod_draws_jugador.php?evmo_id="+evmo_id+"\">Jugador 2</a>\n");
				}
				
				//if(es_doble){
					$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child div.jugadoresContenedor').append("\n<div class=\"jugador\">\n");
				//}
				
				if((i-parseInt($('#rondaIni').val())+1) == 2){//solo se coloca la fecha de lo juegos de la primera ronda(es 2 porque la fecha de los juegos de la primera ronda se especifican en la secci�n de ganador de la segunda)
					$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child').append("\n<div class=\"scores\">\n");
					$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child div.scores').append("<a class=\"fancybox.ajax data\" href=\"mod_draws_data.php\" fecha=\""+$('#fechaIniModa').attr('larga')+"\">"+$('#fechaIniModa').attr('corta')+"</a>");
				}else if((i-parseInt($('#rondaIni').val())+1) > 2){
					$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child').append("\n<div class=\"scores\">\n");
					$('#drawDetalleSeccion table tbody tr td.'+col_i+' div.draw:last-child div.drawItem:last-child div.scores').append("<a class=\"fancybox.ajax data\" href=\"mod_draws_data.php\" fecha=\"\">Fecha/Score</a>");
				}
				
			}
			
		}
							
	}
	
	function actualizar_clases_rondas(){
		
		$("#drawDetalleSeccion table thead tr th").each(function (index) {
			$(this).removeClass();
			col_i = 'col_'+(index+1);
			$(this).addClass(col_i);
		});
	
		$("#drawDetalleSeccion table tbody tr td").each(function (index) {
			$(this).removeClass();
			col_i = 'col_'+(index+1);
			$(this).addClass(col_i);
		});
	}
	
	function remover_clases_rondas(){
		
		$("#drawDetalleSeccion table thead tr th").each(function (index) {
			$(this).removeClass();
		});
	
		$("#drawDetalleSeccion table tbody tr td").each(function (index) {
			$(this).removeClass();
		});
	
	}
	
	function inicializar_drag_and_drop(){
	
		$(".fancybox").fancybox();
		
		$("#puntajes").fancybox({
			'scrolling'			: 'yes',
        	'autoDimensions'	: true
		});
		
		$(".data").fancybox();
		
		$(".data").click(function() {
			elementoSel = $(this);
		});
	
		$( ".jugadoresContenedor" ).draggable({ revert: true , helper: "clone" });
		
		$( ".drawItem" ).droppable({
			drop: function( event, ui ) {
			
				if(ui.draggable.find(':nth-child(1) a').attr('cedula')!=111111){//que no sea BYE
				
					var drawSrcId = parseInt(ui.draggable.parent().parent().find('div.drawItem:eq(1) p.numero').html());
					var drawDestId = parseInt($(this).parent().find('div.drawItem:eq(1) p.numero').html());	
						
					if($(this).parent().parent().attr('class') == ui.draggable.parent().parent().parent().attr('class')){
						//misma ronda
						
						if(drawSrcId!=drawDestId || ui.draggable.parent().attr('class')!=$(this).attr('class')){//origen != destino
						
							if($(this).parent().parent().attr('class')=='col_1'){
							
								if($(this).find('div.jugadoresContenedor:eq(0)').hasClass('ganador')){
									actualizar_referencias_jugador(ui.draggable,$(this));
								}
								
								//if(ui.draggable.parent().parent().find('div.drawItem:eq(1) p.numero').html() != $(this).parent().find('div.drawItem:eq(1) p.numero').html()){
								if(ui.draggable.hasClass('ganador')){
									actualizar_referencias_jugador($(this).find('div.jugadoresContenedor:eq(0)'),ui.draggable.parent());
								}
								//}
								
								var jugadoresTemp = $(this).find('div.jugadoresContenedor').find('div.jugador').clone();
								$(this).find('div.jugadoresContenedor').html(ui.draggable.find('div.jugador').clone());
								ui.draggable.html(jugadoresTemp);
								
								inicializar_drag_and_drop();
							
							}else{
								alert('Operaci\u00f3n inv\u00e1lida');
							}
						
						}
						
					}else{
						//diferente ronda
					
						var i = parseInt(ui.draggable.parent().parent().parent().attr('class').substr(4))+1;
					
						if($(this).parent().parent().attr('class') == ('col_'+i)){//verifica que solo se pueda pasar a una ronda siguiente
						
							var drawSrcId = parseInt(ui.draggable.parent().parent().find('div.drawItem:eq(1) p.numero').html());
							var drawDestId = parseInt($(this).parent().find('div.drawItem:eq(1) p.numero').html());	
							
							if(i==$('#drawDetalleSeccion table thead tr').children().size()){
								drawDestId = 1;
							}
							
							
							if(drawDestId == Math.round(drawSrcId/2)){//verifica que sea la llave valida
						
								if((drawSrcId % 2 != 0 && !$(this).hasClass('even')) || (drawSrcId % 2 == 0 && $(this).hasClass('even'))){
									//verifica que sea el item de la llave que corresponde
								
									ui.draggable.parent().parent().find('div.jugadoresContenedor').each(function (index) {
										$(this).removeClass('ganador');
									});
								
									actualizar_referencias_jugador(ui.draggable,$(this));
									$(this).find('div.jugadoresContenedor').html(ui.draggable.find('div.jugador').clone());
									
									ui.draggable.addClass('ganador');
									
									
									
									inicializar_drag_and_drop();
								
								}else{
									alert('Operaci\u00f3n inv\u00e1lida');
								}
								
							}else{
								alert('Operaci\u00f3n inv\u00e1lida');
							}
							
						}else{
							alert('Operaci\u00f3n inv\u00e1lida');
						}
						
					}	
					
				}
			}
		});
		
	}
	
	function actualizar_referencias_jugador(dragItem,dropItem){
	
		var colIni = parseInt(dropItem.parent().parent().attr('class').substr(4))+1;
		//var drawSrcId = parseInt(dragItem.parent().parent().find('div.drawItem:eq(1) p.numero').html());
		var drawDestId = parseInt(dropItem.parent().find('div.drawItem:eq(1) p.numero').html());
		var cedula = dropItem.find('div.jugadoresContenedor div.jugador:eq(0) a').attr('cedula');
		
		var iDraw = drawDestId;

		var drawItemId = iDraw % 2 == 0 ? 1 : 0;
		
		for(var i=colIni;i<=$('#drawDetalleSeccion table thead tr').children().size();i++){
			
			iDraw = Math.round(iDraw/2);
		
			var refJugSig = $('#drawDetalleSeccion table tbody tr td.col_'+i+' div.draw:eq('+(iDraw-1)+') div.drawItem:eq('+drawItemId+') div.jugadoresContenedor:eq(0) div.jugador:eq(0) :nth-child(1)');
			
			drawItemId = iDraw % 2 == 0 ? 1 : 0;
			
			if(refJugSig.attr('cedula') == cedula){
				refJugSig.parent().parent().html(dragItem.find('div.jugador').clone());
			}else{
				break;
			}
			
		}
	
	}
	
	
	function guardar_draw(){
	
		var arrayDraws = new Array();
	
		rondaIniId = parseInt($('#rondaIni').val());
	
		$('#drawDetalleSeccion table tbody tr td').each(function (index) { //ciclo que recorre las rondas
		
			if(index < $('#drawDetalleSeccion table tbody tr td').size()-1){
		
				$(this).find('.draw').each(function (index2) { //ciclo que recorre los draw de la ronda
				
					var datosDraws = new Array();
					
					datosDraws[0] = evmo_id;
					datosDraws[1] = rondaIniId+index;
					datosDraws[2] = $(this).find('.drawItem:eq(0) div.jugador:eq(0) :nth-child(1)').attr('cedula');
					datosDraws[3] = $(this).find('.drawItem:eq(0) div.jugador:eq(1) :nth-child(1)').attr('cedula');
					datosDraws[4] = $(this).find('.drawItem:eq(1) div.jugador:eq(0) :nth-child(1)').attr('cedula');
					datosDraws[5] = $(this).find('.drawItem:eq(1) div.jugador:eq(1) :nth-child(1)').attr('cedula');
					
					
					
					//alert('RondaIni: '+(rondaIniId+index)+'\n'+$(this).html());
					
					//alert($(this).find('.drawItem:eq(0) div.jugador a').size());
					
					
					datos = $(this).parent().next().children('.draw:nth-child('+(parseInt(index2/2)+1)+')');
					
					if(datos.html() != null){
						if(index2 % 2 == 0){
							if(datos.find('.drawItem:eq(0) div.jugador:eq(0) :nth-child(1)').attr('cedula')!=null){
								if(datos.find('.drawItem:eq(0) div.jugador:eq(0) :nth-child(1)').attr('cedula')==$(this).find('.drawItem:eq(0) div.jugador:eq(0) :nth-child(1)').attr('cedula')){
									datosDraws[6] = 1;
								}else{
									datosDraws[6] = 2;
								}
							}
							datosDraws[7] = datos.find('.drawItem:eq(0) div.scores :nth-child(1)').attr('score');
							datosDraws[8] = datos.find('.drawItem:eq(0) div.scores :nth-child(1)').attr('fecha');
						}else{
							if(datos.find('.drawItem:eq(1) div.jugador:eq(0) :nth-child(1)').attr('cedula')!=null){
								if(datos.find('.drawItem:eq(1) div.jugador:eq(0) :nth-child(1)').attr('cedula')==$(this).find('.drawItem:eq(0) div.jugador:eq(0) :nth-child(1)').attr('cedula')){
									datosDraws[6] = 1;
								}else{
									datosDraws[6] = 2;
								}
							}
							datosDraws[7] = datos.find('.drawItem:eq(1) div.scores :nth-child(1)').attr('score');
							datosDraws[8] = datos.find('.drawItem:eq(1) div.scores :nth-child(1)').attr('fecha');
						}
					}
					
					arrayDraws.push(datosDraws);
					
				});
				
			}
			
		});
		
		var form =  document.forms.formDraw;
		
		//alert(JSON.stringify(arrayDraws));
		
		form.arrayDraws.value = JSON.stringify(arrayDraws);
		form.evmo_id.value = evmo_id;
	
		$('#drawDetalleSeccion').hideLoading();
		$('#drawDetalleSeccion').showLoading();
	
		$.ajax({  
		 type: 'POST',  
		 url: 'control/ctrl_draws.php',
		 //dataType: 'json',
		 data: $(form).serialize(),
		 success: function(r){
		 
			if(r == ''){ 
				r = '<p class="textoverdeesmeralda11b">Operaci&oacute;n realizada satisfactoriamente.</p>';
			}else{
				r = '<div class="error">'+r+'</div>';
			}
			
			$('#mensajeOperacion').html(r);
		 
		 },
		 complete: function(){
			$('#drawDetalleSeccion').hideLoading();
		 }
		});
	
	
		return false;
		
	}
	
	
	function ir_lista_inscritos(){
	
		var url = "vista/mod_eventos.php?opcion=inscripciones&even_id="+$('#evento').val()+"&evmo_id="+evmo_id;
		
		cargar_form(url,'Gestionar Eventos');
	
		return false;
	
	}
	
	
</script>



<style>
	table.rondas th { background: url(../art/fondo_titulomodulos.jpg); height: 20px; text-align: center; }
</style>

	<section id="cuerpo">
		<div id="sombraIzq"></div>
		<section id="cuerpoPrincipalDraw">
			
			<form id="formDraw" class="formEstilo">
			
				<input type="hidden" name="arrayDraws" id="arrayDraws" value="">
				<input type="hidden" name="opcion" id="opcion" value="guardar">
				<input type="hidden" name="evmo_id" id="evmo_id" value="">
			
			<div id="drawPrincipal">
				
				<div id="drawEvento">
					<?php
						if ($_GET['even_id']<>"") { 
							
							$event = new eventos('','','','','','','','','','');
							$event->get_evento($_GET['even_id']);
							
							echo "<div class=\"drawEventoContenedor\">\n\n";
							
								echo "<a class=\"fancybox\" rel=\"group\" href=\"../art/eventos/".$event->even_afiche."\" title=\"".$event->even_nombre."\">";
									echo ajustar_imagen('art/eventos/'.$event->even_afiche, 260, 220, 'art/eventos/no_disponible.jpg');
								echo "</a>";
							
							echo "</div>\n\n";

							echo "<div class=\"drawEventoContenedor\">\n\n";
								
								echo "<input type=\"hidden\" id=\"evento\" value=\"".$_GET['even_id']."\">";
								echo "<p><span class=\"textoverde12b\">".$event->even_nombre."</span><br></p>";
								echo "<p><span class=\"textoverdeesmeralda11b\">Inicio: </span><span class=\"textogris11b\">".date("d/m/Y",strtotime($event->even_fecha))."</span></p>";
								echo "<p><span class=\"textoverdeesmeralda11b\">Lugar: </span><span class=\"textogris11b\">".$event->even_sede.", ".$event->even_ciudad."</span></p>";

							
								//if ($_GET['evmo_id']<>"") {
								
								
									echo "<p><span class=\"textoverdeesmeralda11b\">Modalidad: </span>";
									echo "<select name=\"modalidad\" class=\"textonegro11r\" id=\"modalidad\" onChange=\"document.location.href=this.value\">\n";

									$fechaModa = $event->even_fecha;
									
									echo "<option value=\"edicion_draw.php?even_id=".$_GET['even_id']."\"></option>";
									
									for($k=0;$k < count($event->even_modalidades);$k++){
										
										$mod = new modalidades('','','','','','');
										$mod = $mod->get_modalidad($event->even_modalidades[$k]->moda_id);
										echo "<option ".
												"value=\"edicion_draw.php?even_id=".$_GET['even_id']."&evmo_id=".$event->even_modalidades[$k]->evmo_id.
												"\"".($event->even_modalidades[$k]->evmo_id == $_GET['evmo_id'] ? " selected " : "").">"
											.$mod->moda_nombre."</option>\n";
										if($event->even_modalidades[$k]->evmo_id == $_GET['evmo_id']){
											$fechaModa = $event->even_modalidades[$k]->evmo_fecha;
										}
									}

									echo "</select>\n</p>\n";
									
									echo "<p><span class=\"textoverdeesmeralda11b\">Inicio: </span><span id=\"fechaIniModa\" class=\"textogris11b\" corta=\"".date("d M, g:ia",strtotime($fechaModa))."\" larga=\"".date("Y/m/d H:i:s",strtotime($fechaModa))."\">".date("d/m/Y",strtotime($fechaModa))."</span></p>";
									
																
									echo "\n<hr>\n";
									
									$obj = new draws('','','','','','','','','','');
									
									if ($_GET['evmo_id']<>"") {
										$ronda_ini_id = $obj->get_first_ronda($_GET['evmo_id']);
									}
									
									$rond = new rondas('','','');
									
									echo "<span class=\"textoverdeesmeralda11b\">Ronda inicial: </span>";
										
									echo '<select id="rondaIni" name="rondaIni" onChange="contruir_draw()"><option></option>';
									
										$rondas = $rond->get_all_rondas();
										
										$rondasArray = array();
										
										while ($row_ronda = mysql_fetch_assoc($rondas)){
											array_push($rondasArray, $row_ronda);
											echo '<option value="'.$row_ronda['ronda_id'].'"';
											if($ronda_ini_id && $ronda_ini_id == $row_ronda['ronda_id']){
												echo ' selected ';
											} 
											echo '>'.$row_ronda['ronda_nombre'].'</option>';
										}
										
									echo '</select>';
								
									echo  '<script>';
										if($_GET['evmo_id'] != null){
											echo  'evmo_id = '.$_GET['evmo_id'].'; ';
										}
										echo  'rondasArray = '.json_encode($rondasArray).';';
									echo  '</script>';
											
									echo "<br><br>";
									
									echo "\n<a id=\"guardar\" href=\"#\" onClick=\"return guardar_draw()\">"
											."<img src=\"../art/boton_guardar.png\" width=\"111\" height=\"35\">"
										."</a>\n";
										
									if ($_GET['evmo_id']<>"") {
										/*echo "\n<a id=\"inscripciones\" href=\"#\" onClick=\"return ir_lista_inscritos()\">"
												."<img src=\"../art/boton_lista_inscritos.png\" width=\"150\" height=\"35\">"
											."</a>\n";
											
										echo "\n<a id=\"puntajes\" class=\"fancybox.ajax\" href=\"../mod_draws_puntos.php?evmo_id=".$_GET['evmo_id']."\">"
											."<img src=\"../art/boton_puntajes.png\" width=\"111\" height=\"35\">"
										."</a>\n";
										*/
									}
									
								//}
							
							echo "</div>\n\n";							
							
							
						}
					?>
				</div>
				
				
				
				<div id="drawDetalleSeccion" class="drawDetalle doubles">
				
					<div id="mensajeOperacion"></div>
				
					<?php
					
						if ($_GET['evmo_id']<>"") {
									
								$obj = new draws('','','','','','','','','','');
								$ronda = new rondas('','','');
							
								$ronda_ini_id = $obj->get_first_ronda($_GET['evmo_id']);
								
								if($ronda_ini_id){
								
									echo "\n<table cellspacing=\"0\" class=\"rondas\">
						                    <thead>
						                        <tr>\n";
												
													$ronda->get_ronda($ronda_ini_id);
													$i=1;
													do{
														echo "\n<th class=\"col_".$i."\">".$ronda->ronda_nombre."</th>\n";
														$i++;
													}while($ronda = $ronda->get_next_ronda($ronda->ronda_draws));

													echo "\n<th>CAMPEON</th>\n";
												
						            echo       "\n</tr>
						                    </thead>\n";
										
									echo "\n<tr>\n";
									
													$ronda = new rondas('','','');
													$ronda->get_ronda($ronda_ini_id);
													$info = array();
													$draw_aux_final;
												
													$i = 1;
													
												
													do{
														echo "\n<td class=\"col_".$i."\">\n";
														
															$draw = new draws('','','','','','','','','','');
															
															$res_draw = $draw->get_draws_ronda($_GET['evmo_id'],$ronda->ronda_id);
														
															$j = 1;
						
														
															while($row_draw = mysql_fetch_assoc($res_draw)){
															
																$draw_aux_final = $row_draw;
															
																echo "\n<div class=\"draw\">\n";
															
																//Jugador 1
																
																if($j==1){
																	echo "\n<div class=\"drawItem first\">\n";
																}else{
																	echo "\n<div class=\"drawItem\">\n";
																}
																
																	if($i==1){
																		//echo "\n<p class=\"numero\">".$j."</p>\n";
																	}
																	
																	setlocale(LC_ALL, 'pt_BR');
																	
																	echo "\n<div class=\"jugadoresContenedor".($row_draw['draw_ganador']==1 ? " ganador" : "")."\">\n";
				        
																			echo "\n<div class=\"jugador\">\n";
																	            
																				if($row_draw['juga_id1'] != null){
																				
																					//$jugador = new jugadores('','','','','','','','','','','','','','','','','','');
																					//$jugador->get_jugador($row_draw['juga_id1']);
																		            echo "\n<a class=\"fancybox.ajax data\" cedula=\"".$row_draw['juga_id1']."\" href=\"mod_draws_jugador.php?evmo_id=".$_GET['evmo_id']."\">"
																						.($row_draw['juga_id1']==111111 ? $row_draw['juga1_nombre'] : ucwords(strtolower($row_draw['juga1_apellido'].", ".$row_draw['juga1_nombre'])))
																						."</a>\n";
																						
																				}else{
																					if($i==1){
																						echo "\n<a class=\"fancybox.ajax data\" href=\"mod_draws_jugador.php?evmo_id=".$_GET['evmo_id']."\">Jugador 1</a>\n";
																					}
																				}
																	            
																	        echo "\n</div>\n";
																		
																		
																		if($row_draw['juga_id2'] != null){
																		
																			echo "\n<div class=\"jugador\">\n";
																	            
																				//$jugador = new jugadores('','','','','','','','','','','','','','','','','','');
																				//$jugador->get_jugador($row_draw['juga_id2']);
																	            echo "\n<a class=\"fancybox.ajax data\" cedula=\"".$row_draw['juga_id2']."\" href=\"mod_draws_jugador.php?evmo_id=".$_GET['evmo_id']."\">"
																					.($row_draw['juga_id2']==111111 ? $row_draw['juga2_nombre'] : ucwords(strtolower($row_draw['juga2_apellido'].", ".$row_draw['juga2_nombre'])))
																					."</a>\n";
																	            
																	        echo "\n</div>\n";
																			
																		}
																	
																	echo "\n</div>\n";
																
																	//score jugador 1
																	if($i != 1){
																		echo "\n<div class=\"scores\">\n";
																			//echo "<a class=\"fancybox.ajax data\" href=\"mod_draws_data.php\">";
																				if($info[$j*2-1] != null){
																					echo $info[$j*2-1];
																				}else{
																					echo "Fecha/Score";
																				}			
																			//echo "</a>";
																		echo "\n</div>\n";
																	}
																	
																echo "\n</div>\n";
															
																
																
															
																//Jugador 2
															
																echo "\n<div class=\"drawItem even\">\n";
																	
																
																	//if($i==1){
																		echo "\n<p class=\"numero\">".$j."</p>\n";
																	//}
																	
																	echo "\n<div class=\"jugadoresContenedor".($row_draw['draw_ganador']==2 ? " ganador" : "")."\">\n";
																	
																		
																		
																	        echo "\n<div class=\"jugador\">\n";
																	            
																				if($row_draw['juga_id3'] != null){
																				
																					//$jugador = new jugadores('','','','','','','','','','','','','','','','');
																					//$jugador->get_jugador($row_draw['juga_id3']);
																		            echo "\n<a class=\"fancybox.ajax data\" cedula=\"".$row_draw['juga_id3']."\" href=\"mod_draws_jugador.php?evmo_id=".$_GET['evmo_id']."\">"
																						.($row_draw['juga_id3']==111111 ? $row_draw['juga3_nombre'] : ucwords(strtolower($row_draw['juga3_apellido'].", ".$row_draw['juga3_nombre'])))
																						."</a>\n";
																						
																	            }else{
																					if($i==1){
																						echo "\n<a class=\"fancybox.ajax data\" href=\"mod_draws_jugador.php?evmo_id=".$_GET['evmo_id']."\">Jugador 2</a>\n";
																					}
																				}
																				
																	        echo "\n</div>\n";
																			
																		
																		
																		if($row_draw['juga_id4'] != null){
																			
																			echo "\n<div class=\"jugador\">\n";
																	            
																				//$jugador = new jugadores('','','','','','','','','','','','','','','','');
																				//$jugador->get_jugador($row_draw['juga_id4']);
																	            echo "\n<a class=\"fancybox.ajax data\" cedula=\"".$row_draw['juga_id4']."\" href=\"mod_draws_jugador.php?evmo_id=".$_GET['evmo_id']."\">"
																					.($row_draw['juga_id4']==111111 ? $row_draw['juga4_nombre'] : ucwords(strtolower($row_draw['juga4_apellido'].", ".$row_draw['juga4_nombre'])))
																					."</a>\n";
																	            
																	        echo "\n</div>\n";
																			
																		}
																	
																	echo "\n</div>\n";
																
																	//score jugador 2
																	if($i != 1){
																		echo "\n<div class=\"scores\">\n";
																			//echo "<a class=\"fancybox.ajax data\" href=\"mod_draws_data.php\">";
																				if($info[$j*2] != null){
																					echo $info[$j*2];
																				}else{
																					echo "Fecha/Score";
																				}			
																			//echo "</a>";
																		echo "\n</div>\n";
																	}
																
																echo "\n</div>\n";
																
																
																
																$fecha = "";
																$mostrar = "";
																$score = "";
																
																if($row_draw['draw_fecha'] != null){
																	$date = date_create($row_draw['draw_fecha']);
																	$mostrar = date_format($date, 'd M, g:ia');
																	$fecha = date_format($date, 'Y/m/d H:i:s');
																}else{
																	$mostrar = "Fecha/Score";
																}
																	
																if($row_draw['draw_score'] != null){
																	$score = $row_draw['draw_score'];
																	$mostrar = $row_draw['draw_score'];
																}
																
																$info[$j] = "<a fecha=\"".$fecha."\" score=\"".$score."\" class=\"fancybox.ajax data\" href=\"mod_draws_data.php\">";
																$info[$j] .= $mostrar;
																$info[$j] .= "</a>";
																
																
																
																echo "\n</div>\n";
																$j++;
															}
														
														
														echo "\n</td>\n";
														
														$i++;
														
													}while($ronda = $ronda->get_next_ronda($ronda->ronda_draws));
											
											
											
													/*
													Columna del campeon
													*/
													
													echo "\n<td class=\"col_".$i."\">\n";
													
														echo "\n<div class=\"draw\">\n";
							
															$j = 1;

															echo "\n<div class=\"drawItem first\">\n";

																	
																	echo "\n<div class=\"jugadoresContenedor ganador\">\n";
				        
																		
																		if($draw_aux_final['draw_ganador']==1){
																			$juga_id1 = $draw_aux_final['juga_id1'];
																			$juga_id2 = $draw_aux_final['juga_id2'];
																			$juga1_nombre = $draw_aux_final['juga1_apellido'].", ".$draw_aux_final['juga1_nombre'];
																			$juga2_nombre = $draw_aux_final['juga2_apellido'].", ".$draw_aux_final['juga2_nombre'];
																		}else if($draw_aux_final['draw_ganador']==2){
																			$juga_id1 = $draw_aux_final['juga_id3'];
																			$juga_id2 = $draw_aux_final['juga_id4'];
																			$juga1_nombre = $draw_aux_final['juga3_apellido'].", ".$draw_aux_final['juga3_nombre'];
																			$juga2_nombre = $draw_aux_final['juga4_apellido'].", ".$draw_aux_final['juga4_nombre'];
																		}else{
																			$juga_id1 = null;
																			$juga_id2 = null;
																			$juga1_nombre = null;
																			$juga2_nombre = null;
																		}
																		
																		
																		if($juga_id1 != null){
																		
																			echo "\n<div class=\"jugador\">\n";

																					$jugador = new jugadores('','','','','','','','','','','','','','','','','','');
																					$jugador->get_jugador($juga_id1);
																		            echo "\n<a class=\"fancybox.ajax data\" cedula=\"".$juga_id1."\" href=\"mod_draws_jugador.php?evmo_id=".$_GET['evmo_id']."\">"
																						.ucwords(strtolower($juga1_nombre))
																						."</a>\n";
													
																	        echo "\n</div>\n";
																		
																		}
																		
																		if($juga_id2 != null){
																		
																			echo "\n<div class=\"jugador\">\n";
																	            
																				$jugador = new jugadores('','','','','','','','','','','','','','','','','','');
																				$jugador->get_jugador($juga_id2);
																	            echo "\n<a class=\"fancybox.ajax data\" cedula=\"".$juga_id2."\" href=\"mod_draws_jugador.php?evmo_id=".$_GET['evmo_id']."\">"
																					.ucwords(strtolower($juga2_nombre))
																					."</a>\n";
																	            
																	        echo "\n</div>\n";
																			
																		}
																	
																	
																	echo "\n</div>\n";
																
																	//score jugador campeon
																	if($i != 1){
																		echo "\n<div class=\"scores\">\n";
																			//echo "<a class=\"fancybox.ajax data\" href=\"mod_draws_data.php\">";
																				if($info[$j*2-1] != null){
																					echo $info[$j*2-1];
																				}else{
																					echo "Fecha/Score";
																				}																				
																			//echo "</a>";
																		echo "\n</div>\n";
																	}
																	
															echo "\n</div>\n";
															
														echo "\n</div>\n";
															
													echo "\n</td>\n";
													
											
									echo "\n</tr>\n";		
											
									echo "\n</table>\n";	
									
								
								}else{
									
									echo "\n<p class=\"textogris11b\"><br>No se han cargado los draw<br></p>\n";
								
								}
						}else{
							
							echo "\n<p class=\"textogris11b\"><br>Seleccione una modalidad<br></p>\n";
							
						}
					
					?>
					
				
				</div>
			
			</div>
			
			</form>
			
		</section>
		<div id="sombraDer"></div>
	</section>
	
<?php include('./admin-footer.php') ?>
