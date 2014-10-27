
<!DOCTYPE HTML>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>

<div id="mensajes" name="mensajes" class="textoverdeesmeralda11b"></div>

<div id="tabs">
	<ul>
		<li><a href="#galerias">Galer&iacute;as</a></li>
		<li><a href="#videos">Videos</a></li>
		<li><a href="#patro">Prensa</a></li>
	</ul>
	<div id="galerias">
		<?php include('mod_galerias.php'); ?>
	</div>
	<div id="videos">
		<?php include('mod_videos.php'); ?>
	</div>
	<div id="patro">
		<?php include('mod_prensas.php'); ?>
	</div>
</div>

<script>
	$(function() {
		// setup ul.tabs to work as tabs for each div directly under div.panes
		//$("ul.tabs").tabs("div.panes > div");
		$('#tabs').tabs();
	});
</script>
</body>
</html>