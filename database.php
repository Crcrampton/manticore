<?php

$hostname="localhost";
$username="root";
$password="Ploobert11";
$dbname="manticore";

mysql_connect($hostname,$username, $password) or die ("<html><script language='JavaScript'>alert('Unable to connect to database! Please try again later.'),history.go(-1)</script></html>");
mysql_select_db($dbname);

?>