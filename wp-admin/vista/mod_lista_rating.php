
<script>

	// NEW selector
	jQuery.expr[':'].Contains = function(a, i, m) {
	  return jQuery(a).text().toUpperCase()
		  .indexOf(m[3].toUpperCase()) >= 0;
	};

	// OVERWRITES old selecor
	jQuery.expr[':'].contains = function(a, i, m) {
	  return jQuery(a).text().toUpperCase()
		  .indexOf(m[3].toUpperCase()) >= 0;
	};

	$.expr[":"].contains = $.expr.createPseudo(function(arg) {
		return function( elem ) {
			return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
		};
	});

	function filtrarJugador(){
	
		var filtro = $('#filtro').val();
		
		if(filtro != ''){
		
			$('#tablaJugadores tbody tr').css('display','none');
			
			var i = 1;
			$("#tablaJugadores a:contains('"+filtro+"')").each(function(){
				
				if(i % 2 == 0){
					$(this).parent().parent().css({'display':'table-row','background':'#e6e6e6'});
				}else{
					$(this).parent().parent().css({'display':'table-row','background':'none'});
				}
				i++;
			
			});
		
		}else{
		
			$('#tablaJugadores tbody tr').css('display','table-row');
			
			var i = 1;
			$("#tablaJugadores a").each(function(){
				
				if(i % 2 == 0){
					$(this).parent().parent().css({'display':'table-row','background':'#e6e6e6'});
				}else{
					$(this).parent().parent().css({'display':'table-row','background':'none'});
				}
				i++;
			
			});
		
		}
		
		
	}


	$(function(){
	
		$('#btnFiltrar').click(function(e){
		
			e.preventDefault();
			filtrarJugador();

		});
		
		$('#filtro').keypress(function(e){
			
			if ( event.which == 13 ) {
				e.preventDefault();
				filtrarJugador();
			}
		
		});
	
	});

</script>

<?php

	require_once("../modelo/rating_config.php");
	require_once("../modelo/rating_juegos_hist.php");
	require_once("../modelo/rating_jugadores_hist.php");
	require_once("../../funciones.php");
	
	echo '<form class="formEstilo">';
	echo '<br><input type="text" id="filtro" name="filtro" placeholder="Especificar el nombre">';
	echo '<button id="btnFiltrar" name="btnFiltrar">Filtrar</button><br><br>';
	echo '</form>';
	
	$aux = new rating_jugadores_hist('','','','');
	$jugadores = $aux->get_all_rating_jugadores_hist($_GET['rating'],$_GET['fecha']);
	
	echo '<table class="tablaForm" id="tablaJugadores">';
	echo '<thead><tr><th style="text-align:center">Nro</th><th>Nombre</th>';
	echo '<th style="text-align:center">Puntos</th>';
	echo '<th style="text-align:center">Categor&iacute;a</th></tr></thead><tbody>';
	
	$i = 1;
	
	while ($row = mysql_fetch_assoc($jugadores)){
	
		echo '<tr><td style="text-align:center">'.$i.'</td>';
		echo '<td><a class="fancybox.ajax jugadorRating textogris11b" href="'.getHost().'admin/vista/mod_lista_rating_juegos.php?rating='
			.$_GET['rating'].'&cedula='.$row['juga_id'].'">'.$row['juga_apellido'].' '.$row['juga_nombre'].'</a></td>';
		echo '<td style="text-align:center">'.round($row['raju_puntos']).'</td>';
		echo '<td style="text-align:center">'.$row['raconf_categoria'].'</td></tr>';
		
		$i++;
	
	}
	
	echo '</tbody></table>';
	
	echo "<script> $('.jugadorRating').fancybox(); </script>";
	
?>