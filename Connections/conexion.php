<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexion = "localhost";
$database_conexion = "ttucv";
$username_conexion = "root";
$password_conexion = "root";

$hostname_conexion = getenv('IP');
$database_conexion = "c9";
$username_conexion = getenv('C9_USER');
$password_conexion = "";

$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_conexion, $conexion);
?>