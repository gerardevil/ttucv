
<!DOCTYPE HTML>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

</head>

<body>

<div id="mensajes" name="mensajes" class="textoverdeesmeralda11b"></div>


<div id="tabs_gen">
	<ul>
		<li><a href="#misc_pane">Miscelaneos</a></li>
		<li><a href="#publ_pane">Publicidad</a></li>
		<li><a href="#banner_pane">Banner</a></li>
		<li><a href="#juga_pane">Jugadores</a></li>
		<li><a href="#club_pane">Clubes</a></li>
	</ul>
	<div id="misc_pane" style="padding:0">
		<?php include('mod_miscelaneos.php'); ?>
	</div>
	<div id="publ_pane" style="padding:0">
		<?php include('mod_publicidades.php'); ?>
	</div>
	<div id="banner_pane" style="padding:0">
		<?php include('mod_banner.php'); ?>
	</div>
	
	<div id="juga_pane" style="padding:0">
		<?php include('mod_jugadores.php'); ?>
	</div>
	
	<div id="club_pane" style="padding:0">
		<?php include('mod_clubes.php'); ?>
	</div>
</div>

<script>
	$(function() {
		// setup ul.tabs to work as tabs for each div directly under div.panes
		//$("#tabs_conf").tabs("#panes_conf > div");
		//$("ul.tabs").tabs("> .pane");
		$("#tabs_gen").tabs();
	});
</script>
</body>
</html>