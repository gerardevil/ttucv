


function clickSiguiente(){

		var posicion = $('div#interCalendario div#calendarioJornadas div#wrapper').position().left;
		
		var ancho = parseInt($('div#interCalendario div#calendarioJornadas div#wrapper').css('width'));
		
		var anchoView = parseInt($('div#interCalendario div#calendarioJornadas').css('width'));
		
		posicion = posicion - 400;
		
		if(posicion < anchoView-ancho){
			posicion = anchoView-ancho;
		}
		
		
		$("div#interCalendario div#calendarioJornadas div#wrapper").animate({left:  posicion + "px"}, {duration: 1000}); 
		
		//$('div#interCalendario div#calendarioJornadas div#wrapper').css("left", posicion + "px");
		
		
		return true;
}


function clickAnterior(){

		var posicion = $('div#interCalendario div#calendarioJornadas div#wrapper').position().left;
		
		var ancho = parseInt($('div#interCalendario div#calendarioJornadas div#wrapper').css('width'));
		
		posicion = posicion + 400;
		
		if(posicion > 0){
			posicion = 0;
		}
		
		$("div#interCalendario div#calendarioJornadas div#wrapper").animate({left:  posicion + "px"}, {duration: 1000});
		
		//$('div#interCalendario div#calendarioJornadas div#wrapper').css("left", posicion + "px");
		
		return true;
		
}


function agregarJornada(numeroJornada){

	$('#wrapper').append('<div class="jornada" title="Jornada '+numeroJornada+'">'+numeroJornada+'</div>');
	
	var width = numeroJornada * 125;
	
	if($('#wrapper').width() < width){
		
		$('#wrapper').css('width', (width+100) + 'px');
	
	}
	

}

function limpiarJornadas(){

	$('#wrapper').html('');
	$('#wrapper').css('width', 'auto');
	
}


function agregarPartido(partido,interId,intergrupId){

	var html = '';
	var url = 'mod_seleccionar_equipo.php?inter_id='+interId;
	
	if(intergrupId != null && intergrupId != undefined && intergrupId != '') url += '&intergrup_id='+intergrupId;
	
	if(partido != null && partido != undefined){

		html = '<div class="partido" jornId="'+partido.jorn_id+'" '
				+(partido.jorn_ganador != null ? 'ganador="'+partido.jorn_ganador+'" ' : '')
				+(partido.jorn_score != null ? 'score="'+partido.jorn_score+'" ' : '')+'>';
				
		html += '<div class="equipo1"><a class="fancybox.ajax equipo" href="'+url+'" intergrupId="'+intergrupId+'"'
				+ (partido.equipo_id1 != null ? ' equipoId="'+partido.equipo_id1+'">' : '>')
				+ (partido.equipo_id1 != null ? partido.equipo_nombre1+'('+partido.club_nombre1+')' : 'Equipo 1')
				+'</a></div>';
		html += '<div class="infoJuego"><div class="home1'+(partido.jorn_home == 1 ? ' visible' : '')+'"></div>';
		html += 'vs';
		html += '<div class="home2'+(partido.jorn_home == 2 ? ' visible' : '')+'"></div>';
		html += '<br><a class="fancybox.ajax data" href="mod_partidos_data.php" intergrupId="'+intergrupId+'"' 
				+ (partido.jorn_fecha != null ? ' fecha="'+partido.jorn_fecha+'"' : '')
				+ (partido.jorn_home != null ? ' home="'+partido.jorn_home + '">' : '>')
				+ (partido.jorn_fecha != null ? $.datepicker.formatDate("dd M", new Date(partido.jorn_fecha))+', '+formatHoraMeridiana(partido.jorn_fecha.split(' ')[1].substr(0,5)) : 'Fecha<br>Hora') + '</a>';
		html += '</div>';
		html += '<div class="equipo2"><a class="fancybox.ajax equipo" href="'+url+'" intergrupId="'+intergrupId+'"'
				+ (partido.equipo_id2 != null ? ' equipoId="'+partido.equipo_id2+'">' : '>')
				+ (partido.equipo_id2 != null ? partido.equipo_nombre2+'('+partido.club_nombre2+')' : 'Equipo 2')
				+'</a></div>';
		html += '</div>';
	
	}else{
	
		html = '<div class="partido">';
		html += '<div class="equipo1"><a class="fancybox.ajax equipo" href="'+url+'" intergrupId="'+intergrupId+'">Equipo 1</a></div>';
		html += '<div class="infoJuego"><div class="home1"></div>';
		html += 'vs';
		html += '<div class="home2"></div>';
		html += '<br><a class="fancybox.ajax data" href="mod_partidos_data.php" intergrupId="'+intergrupId+'">Fecha<br>Hora</a>';
		html += '</div>';
		html += '<div class="equipo2"><a class="fancybox.ajax equipo" href="'+url+'" intergrupId="'+intergrupId+'">Equipo 2</a></div>';
		html += '</div>';
	
	}

	
	$('#juegosJornada').append(html);

}

function agregarEquipoDescanso(partido,interId,intergrupId){
	
	var html = '';
	var url = 'mod_seleccionar_equipo.php?inter_id='+interId;
	
	if(intergrupId != null && intergrupId != undefined && intergrupId != '') url += '&intergrup_id='+intergrupId;
	
	if(partido != null && partido != undefined){
	
		html = '<div class="descansa" jornId="'+partido.jorn_id+'" ganador="'+partido.jorn_ganador+'" score="'+partido.jorn_score+'">';
		html += '<div class="equipo1"><span class="textogris11b">Equipo Descansa</span><br><br><a class="fancybox.ajax equipo" href="'+url+'" intergrupId="'+intergrupId+'"'
				+ (partido.equipo_id1 != null ? ' equipoId="'+partido.equipo_id1+'">' : '>')
				+ (partido.equipo_id1 != null ? partido.equipo_nombre1+'('+partido.club_nombre1+')' : 'Equipo 1')
				+'</a></div>';
		html += '</div>';
		
	}else{
		
		html = '<div class="descansa">';
		html += '<div class="equipo1"><span class="textogris11b">Equipo Descansa</span><br><br><a class="fancybox.ajax equipo" href="'+url+'" intergrupId="'+intergrupId+'">Equipo</a></div>';
		html += '</div>';
		
	}
	
	

	$('#juegosJornada').append(html);

}



function agregarResultado(numero,partido,interId,equipoId1,equipoId2){
	
	var html = '';
	var url = '';
	var modalidad = '';
	id = 'partido'+$('.partido2').size();
	
	//if(intergrupId != null && intergrupId != undefined && intergrupId != '') url += '&intergrup_id='+intergrupId;
	
	if(partido != null && partido != undefined){
		
		html = '<div class="partido2" id="'+id+'" juego_id="'+(partido.juego_id==null ? '' : partido.juego_id)+'" jorn_id="'+partido.jorn_id+'" interconf_id="'+partido.interconf_id+'">';
		
		switch(partido.interconf_tipo){
			case 'I':
				modalidad = 'Individual'; break;
			case 'D':
				modalidad = 'Dobles'; break;
		}
		
		switch(partido.interconf_sexo){
			case 'M':
				modalidad += ' masculino'; break;
			case 'F':
				modalidad += ' femenino'; break;
			case 'MF':
				modalidad += ' mixto'; break;
		}
		
		html += '<div class="numero">'+numero+'</div>';
		html += '<div class="modalidad" tipo="'+partido.interconf_tipo+'" sexo="'+partido.interconf_sexo+'">'+modalidad+'</div>';
		
		url = getHost()+'wp-admin/mod_equipo_jugador.php?equipo_id='+equipoId1;
		
		if(partido.interconf_tipo == 'D'){
			html += '<div class="equipo1"><a href="'+url
					+'" class="fancybox.ajax jugador" '+(partido.juga_id1==null ? '>Jugador 1' : 'cedula="'+partido.juga_id1+'">'+partido.juga1_apellido+', '+partido.juga1_nombre)
					+'</a> <span class="textogris11b">y</span> <a href="'+url
					+'" class="fancybox.ajax jugador" '+(partido.juga_id2==null ? '>Jugador 2' : 'cedula="'+partido.juga_id2+'">'+partido.juga2_apellido+', '+partido.juga2_nombre)
					+'</a></div>';
		}else{
			html += '<div class="equipo1"><a href="'+url
					+'" class="fancybox.ajax jugador" '+(partido.juga_id1==null ? '>Jugador 1' : 'cedula="'+partido.juga_id1+'">'+partido.juga1_apellido+', '+partido.juga1_nombre)
					+'</a></div>';
		}
		
		html += '<div class="infoJuego"> <a href="'+getHost()+'admin/mod_partidos_data_score.php" class="fancybox.ajax data"'
				+(partido.juego_ganador==null ? '' : ' ganador="'+partido.juego_ganador+'"')
				+(partido.juego_score==null ? '' : ' score="'+partido.juego_score+'"')
				+'><label class="textogris11b">vs</label><span class="textogris11r">'
				+(partido.juego_score==null ? '(Resultados)' : partido.juego_score)
				+'</span></a> </div>';

		url = getHost()+'wp-admin/mod_equipo_jugador.php?equipo_id='+equipoId2;
			
		if(partido.interconf_tipo == 'D'){
			html += '<div class="equipo2"><a href="'+url
					+'" class="fancybox.ajax jugador" '+(partido.juga_id3==null ? '>Jugador 3' : 'cedula="'+partido.juga_id3+'">'+partido.juga3_apellido+', '+partido.juga3_nombre)
					+'</a> <span class="textogris11b">y</span> <a href="'+url
					+'" class="fancybox.ajax jugador" '+(partido.juga_id4==null ? '>Jugador 4' : 'cedula="'+partido.juga_id4+'">'+partido.juga4_apellido+', '+partido.juga4_nombre)
					+'</a></div>';
		}else{
			html += '<div class="equipo2"><a href="'+url
					+'" class="fancybox.ajax jugador" '+(partido.juga_id3==null ? '>Jugador 2' : 'cedula="'+partido.juga_id3+'">'+partido.juga3_apellido+', '+partido.juga3_nombre)
					+'</a></div>';
		}
		
		html += '</div>';
		
		$('#juegosJornada').append(html);
		marcarGanador(partido.juego_ganador, id);
		
	}else{
		/*
		html += '<div class="equipo1"><a class="fancybox.ajax equipo" href="'+url+'" intergrupId="'+intergrupId+'">Equipo 1</a></div>';
		html += '<div class="infoJuego"><div class="home1"></div>';
		html += 'vs';
		html += '<div class="home2"></div>';
		html += '<br><a class="fancybox.ajax data" href="mod_partidos_data.php" intergrupId="'+intergrupId+'">Fecha<br>Hora</a>';
		html += '</div>';
		html += '<div class="equipo2"><a class="fancybox.ajax equipo" href="'+url+'" intergrupId="'+intergrupId+'">Equipo 2</a></div>';
		*/	
	}
	
}


function marcarGanador(ganador, partidoId){
	$('#'+partidoId).find('.jugador').css('color','#545454');
	$('#'+partidoId).find('.equipo'+ganador).find('.jugador').css('color','#72b84c');
}


function actualizarResultadoEquipo(){

	var ganadosEquipo1 = 0, ganadosEquipo2 = 0;
	
	$('.partido2').each(function(){
	
		var ganador = $(this).find('.data').attr('ganador');
		if(ganador==1) ganadosEquipo1++;
		else if(ganador==2) ganadosEquipo2++;
	
	});
	
	$('#juego_score').val(ganadosEquipo1+' - '+ganadosEquipo2);
	
	if(ganadosEquipo1+ganadosEquipo2 == $('.partido2').size()-1){
	
		if(ganadosEquipo1 > ganadosEquipo2)	$('#equipo_ganador').val(1);
		else if(ganadosEquipo2 > ganadosEquipo1) $('#equipo_ganador').val(2);
		else $('#equipo_ganador').val('');
		
	}else{
	
		$('#equipo_ganador').val('');
	
	}
	
}


function agregarPartidoCalendario(partido,interId,intergrupId){
	
	var html = '<div class="partido">';
	var url = getHost()+'interclubes/ficha_equipo.php?equipo_id=';
	
	if(intergrupId != null && intergrupId != undefined && intergrupId != '') url += '&intergrup_id='+intergrupId;
	
	if(partido != null && partido != undefined && partido.equipo_id1 != null && partido.equipo_id2 != null){

		url =  getHost()+'interclubes/ficha_equipo.php?equipo_id='+partido.equipo_id1;
	
		html += '<div class="equipo1"><a class="fancybox.ajax equipo" href="'+url+'" '+(partido.jorn_ganador == 1 ? ' style="font-weight:bold"' : '')+'>'
				+ (partido.equipo_id1 != null ? partido.equipo_nombre1+'('+partido.club_nombre1+')' : 'Equipo 1')
				+'</a></div>';
		html += '<div class="infoJuego"><div class="home1'+(partido.jorn_home == 1 ? ' visible' : '')+'"></div>';
		html += 'vs';
		html += '<div class="home2'+(partido.jorn_home == 2 ? ' visible' : '')+'"></div>';
		html += '<br><span>' + (partido.jorn_fecha != null ? $.datepicker.formatDate("dd M", new Date(partido.jorn_fecha))+', '+formatHoraMeridiana(partido.jorn_fecha.split(' ')[1].substr(0,5)) : '') + '</span>';

		if(partido.jorn_score != null){
			html += '<br><a class="fancybox.ajax data" title="Ver detalle del encuentro" href="'+getHost()+'interclubes/mod_resultados_juegos.php?inter_id='+interId+'&jorn_id='+partido.jorn_id+'">'+partido.jorn_score+'</a>';
		}
		
		html += '</div>';
		
		url = getHost()+'interclubes/ficha_equipo.php?equipo_id='+partido.equipo_id2;
		
		html += '<div class="equipo2"><a class="fancybox.ajax equipo" href="'+url+'" '+(partido.jorn_ganador == 2 ? ' style="font-weight:bold"' : '')+'>'
				+ (partido.equipo_id2 != null ? partido.equipo_nombre2+'('+partido.club_nombre2+')' : 'Equipo 2')
				+'</a></div>';
				
		html += '</div>';
	
	}else{
	
		html = '';
	
	}
	
	$('#juegosJornada').append(html);
	
}

function agregarEquipoDescansoCalendario(partido,interId,intergrupId){
	
	var html = '<div class="descansa">';
	var url = 'mod_seleccionar_equipo.php?inter_id='+interId;
	
	if(intergrupId != null && intergrupId != undefined && intergrupId != '') url += '&intergrup_id='+intergrupId;
	
	if(partido != null && partido != undefined && partido.equipo_id1 != null){
	
		html += '<div class="equipo1"><span class="textogris11b">Equipo Descansa</span><br><br><a class="fancybox.ajax equipo" href="'+url+'" intergrupId="'+intergrupId+'"'
				+ (partido.equipo_id1 != null ? ' equipoId="'+partido.equipo_id1+'">' : '>')
				+ (partido.equipo_id1 != null ? partido.equipo_nombre1+'('+partido.club_nombre1+')' : 'Equipo 1')
				+'</a></div>';
		
		html += '</div>';
		
	}else{
		
		html = '';
		
	}

	$('#juegosJornada').append(html);

}