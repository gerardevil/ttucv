<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexion = "209.200.229.220";
$database_conexion = "dxtev0_website";
$username_conexion = "dxtev0_eventos";
$password_conexion = "Ev2012Os";

$hostname_conexion = getenv('IP');
$database_conexion = "c9";
$username_conexion = getenv('C9_USER');
$password_conexion = "";

$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_conexion, $conexion);
?>