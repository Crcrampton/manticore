<?php

$hostname="localhost";
$username="manticore";
$password="8UnderP@r";
$dbname="manticore";

mysql_connect($hostname,$username, $password) or die ("<html><script language='JavaScript'>alert('Unable to connect to database! Please try again later.'),history.go(-1)</script></html>");
mysql_select_db($dbname);

?>